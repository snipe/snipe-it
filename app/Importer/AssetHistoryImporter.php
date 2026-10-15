<?php

namespace App\Importer;

use App\Models\Actionlog;
use App\Models\Asset;
use App\Models\Location;
use App\Models\Setting;
use App\Models\User;
use Carbon\Carbon;

class AssetHistoryImporter extends Importer
{
    protected $matchUsername = false;

    protected $matchEmail = false;

    protected $matchFirstnameLastname = false;

    protected $matchFlastname = false;

    protected $matchFirstname = false;

    // Base defaultFieldMap doesn't know about the two date columns this
    // importer uses, and its `full_name => "full name"` mapping doesn't
    // match the historical CSV template's bare "Name" column. Merge these
    // in every time setFieldMappings runs (which ItemImportRequest does
    // even for callers that don't pass column-mappings, wiping constructor-
    // level overrides). target_type is optional. When the CSV omits it
    // the row defaults to a user checkout, matching the earlier
    // behavior of the importer for backwards compat with older exports.
    private array $historyFieldMapExtras = [
        'checkout_date' => 'checkout date',
        'checkin_date' => 'checkin date',
        'full_name' => 'name',
        'target_type' => 'target type',
        'notes' => 'notes',
    ];

    public function setFieldMappings($fields)
    {
        parent::setFieldMappings($fields);
        $this->fieldMap = array_merge($this->fieldMap, $this->historyFieldMapExtras);

        return $this;
    }

    public function setMatchUsername(bool $flag): self
    {
        $this->matchUsername = $flag;

        return $this;
    }

    public function setMatchEmail(bool $flag): self
    {
        $this->matchEmail = $flag;

        return $this;
    }

    public function setMatchFirstnameLastname(bool $flag): self
    {
        $this->matchFirstnameLastname = $flag;

        return $this;
    }

    public function setMatchFlastname(bool $flag): self
    {
        $this->matchFlastname = $flag;

        return $this;
    }

    public function setMatchFirstname(bool $flag): self
    {
        $this->matchFirstname = $flag;

        return $this;
    }

    protected function handle($row)
    {
        $asset_tag = $this->findCsvMatch($row, 'asset_tag');
        $name = $this->findCsvMatch($row, 'full_name');
        $checkout_date_raw = $this->findCsvMatch($row, 'checkout_date');
        $checkin_date_raw = $this->findCsvMatch($row, 'checkin_date');

        // Was a checkin column present in the CSV at all? If not, the
        // original importer assumes every row represents an already-
        // checked-in asset (no assignment mutation, checkin actionlog
        // stamped at import time).
        $checkinHeaderPresent = array_key_exists($this->lookupCustomKey('checkin_date'), $row);

        if (empty($asset_tag)) {
            $this->log('Row is missing an asset tag - skipping');
            $this->recordSkipped();
            $this->addRowError(
                trans('admin/hardware/message.import.history.missing_asset_tag_identity'),
                trans('general.import-history'),
                'asset_tag',
                trans('admin/hardware/message.import.history.missing_asset_tag_message'),
            );

            return;
        }

        $asset = Asset::where('asset_tag', '=', $asset_tag)->first();

        if (! $asset) {
            $this->log('Asset '.$asset_tag.' does not exist - skipping');
            $this->recordSkipped();
            $this->addRowError(
                trans('general.asset').' '.$asset_tag,
                trans('general.import-history'),
                'asset_tag',
                trans('admin/hardware/message.import.history.asset_not_found_message'),
            );

            return;
        }

        $checkout_date = Carbon::parse($checkout_date_raw)->format('Y-m-d H:i:s');

        $checkin_date = null;
        if ($checkinHeaderPresent) {
            if (! empty($checkin_date_raw)) {
                $checkin_date = Carbon::parse($checkin_date_raw)->format('Y-m-d H:i:s');
            }
        } else {
            // No checkin column in the header - assume already checked in
            // as of import time so we don't leave the asset in a state that
            // implies an open, indefinite checkout.
            $checkin_date = Carbon::parse(now())->format('Y-m-d H:i:s');
        }

        $target_type_raw = strtolower(trim((string) $this->findCsvMatch($row, 'target_type')));

        // Optional column. Blank or absent falls back to user so
        // earlier-style CSVs behave unchanged. An explicit value that
        // isn't one of the two accepted forms surfaces as a per-row
        // error. Reject early with the actual bad value in the message.
        $lookupLocation = false;
        if ($target_type_raw !== '' && $target_type_raw !== 'user') {
            if ($target_type_raw === 'location') {
                $lookupLocation = true;
            } else {
                $this->log('Unrecognized target_type "' . $target_type_raw . '" for asset ' . $asset_tag);
                $this->recordSkipped();
                $this->addRowError(
                    trans('general.asset') . ' ' . $asset_tag,
                    trans('general.import-history'),
                    'target_type',
                    trans('admin/hardware/message.import.history.invalid_target_type_message', [
                        'value' => $target_type_raw,
                    ]),
                );

                return;
            }
        }

        $target = $lookupLocation
            ? $this->resolveTargetLocation($name)
            : $this->resolveTargetUser($name);

        if (!$target) {
            $missingLabel = $lookupLocation ? 'Location' : 'User';
            $this->log($missingLabel . ' "' . $name . '" does not exist so no checkin log was created for asset ' . $asset_tag);
            $this->recordSkipped();
            $this->addRowError(
                trans('general.asset').' '.$asset_tag,
                trans('general.import-history'),
                'name',
                trans('admin/hardware/message.import.history.target_not_matched_message', [
                    'name' => $name,
                    'target_type' => strtolower($missingLabel),
                ]),
            );

            return;
        }

        // Optional per-row note from the CSV.
        $csvNote = trim((string) $this->findCsvMatch($row, 'notes'));
        $checkoutNote = $csvNote !== ''
            ? $csvNote
            : 'Checkout imported by ' . (auth()->user()?->display_name ?? 'CSV importer') . ' from history importer';

        Actionlog::firstOrCreate([
            'item_id' => $asset->id,
            'item_type' => Asset::class,
            'created_by' => $this->created_by,
            'note' => $checkoutNote,
            'target_id' => $target->id,
            'target_type' => get_class($target),
            'created_at' => $checkout_date,
            'action_type' => 'checkout',
        ]);

        // If the CSV explicitly told us about a checkin column and this row's
        // checkin is empty or in the future, the asset is still assigned to
        // the target. Otherwise leave the current assignment alone -
        // the asset is (by the source-of-truth CSV) already checked in.
        if ($checkinHeaderPresent) {
            if (empty($checkin_date) || strtotime($checkin_date) > strtotime(Carbon::now())) {
                $asset->assigned_to = $target->id;
                $asset->assigned_type = get_class($target);

                // Mirror Asset::checkOut()'s Location branch: when the
                // asset is currently checked out TO a location, its own
                // location_id must point at that location too so it
                // shows up in the right place on the hardware list and
                // location-specific reports. Without this a location
                // checkout would flip assigned_to but leave location_id
                // pinned to whatever it was before, producing an
                // inconsistent state Snipe-IT itself never emits.
                if ($target instanceof Location) {
                    $asset->location_id = $target->id;
                }
            }
        }

        if (! empty($checkin_date)) {
            Actionlog::firstOrCreate([
                'item_id' => $asset->id,
                'item_type' => Asset::class,
                'created_by' => $this->created_by,
                'note' => 'Checkin imported by '.(auth()->user()?->display_name ?? 'CSV importer').' from history importer',
                'target_id' => null,
                'created_at' => $checkin_date,
                'action_type' => 'checkin',
            ]);
        }

        if ($asset->save()) {
            $identity = $target instanceof User ? $target->username : $target->name;
            $this->log('Asset history imported for ' . $asset_tag . ' -> ' . $identity . ' at ' . $checkout_date);
            $this->recordCreated();
        } else {
            $this->recordErrored();
            $this->logError($asset, 'asset_tag');
        }
    }

    /**
     * Push a row-level error onto the same bag the standard CRUD
     * importers use, so the wizard's post-run error table surfaces the
     * skip reason to the user instead of hiding it in laravel.log.
     *
     * ItemImportRequest::errorCallback signature is
     * ($item, $field, $errorString), reads $item->name for the row
     * identity, and stores as errors[$item->name][$field] = $errorString.
     * The wizard's error table then iterates $errorString as an inner
     * [innerField => [message strings]] map, so we hand it that exact
     * shape here. Wraps with a stdClass because we don't have a real
     * model at row-error time.
     *
     * Bypasses the base addErrorToBag() helper - that one wraps the
     * message in an extra [$field => [...]] layer which produces
     * quadruple-nested arrays and blows up the blade's implode(). Direct
     * callback invocation matches what logError() effectively produces
     * from validating models.
     */
    private function addRowError(string $identity, string $tableLabel, string $field, string $message): void
    {
        if (! $this->errorCallback) {
            return;
        }

        $fake = new \stdClass;
        $fake->name = $identity;
        call_user_func(
            $this->errorCallback,
            $fake,
            $tableLabel,
            [$field => [$message]],
        );
    }

    /**
     * Resolve a location by name for the location-target branch. Same
     * "first match wins" contract as resolveTargetUser: no tie-breaker
     * across parents, which matches how Location::name is uniqued in
     * the schema (unique on name+parent_id, not globally unique). MySQL
     * collates case-insensitively by default so no explicit lower-case
     * fallback here.
     */
    private function resolveTargetLocation(?string $name): ?Location
    {
        if (empty($name)) {
            return null;
        }

        return Location::where('name', '=', $name)->first();
    }

    private function resolveTargetUser(?string $name): ?User
    {
        if (empty($name)) {
            return null;
        }

        $base = User::generateFormattedNameFromFullName(Setting::getSettings()->username_format, $name);
        $query = User::where('username', '=', $base['username']);

        if ($this->matchFirstnameLastname) {
            $firstDotLast = User::generateFormattedNameFromFullName('firstname.lastname', $name);
            $query->orWhere('username', '=', $firstDotLast['username']);
        }

        if ($this->matchFlastname) {
            $flastname = User::generateFormattedNameFromFullName('filastname', $name);
            $query->orWhere('username', '=', $flastname['username']);
        }

        if ($this->matchFirstname) {
            $firstname = User::generateFormattedNameFromFullName('firstname', $name);
            $query->orWhere('username', '=', $firstname['username']);
        }

        if ($this->matchEmail) {
            $query->orWhere('email', '=', User::generateEmailFromFullName($name));
        }

        if ($this->matchUsername) {
            $query->orWhere('username', '=', $name);
        }

        return $query->first();
    }
}
