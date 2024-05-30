<?php

namespace App\Importer;

use App\Models\Asset;
use App\Models\AssetModel;
use App\Models\Statuslabel;
use App\Models\User;
use App\Events\CheckoutableCheckedIn;
use Carbon\CarbonImmutable;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class AssetImporter extends ItemImporter
{
    protected $defaultStatusLabelId;

    public function __construct($filename)
    {
        parent::__construct($filename);

        if (!is_null(Statuslabel::first())) {
            $this->defaultStatusLabelId = Statuslabel::deployable()->first()->id;
        }
    }

    protected function handle($row)
    {
        // ItemImporter handles the general fetching.
        parent::handle($row);

        if ($this->customFields) {
            foreach ($this->customFields as $customField) {
                $customFieldValue = $this->array_smart_custom_field_fetch($row, $customField);

                if ($customFieldValue) {
                    if ($customField->field_encrypted == 1) {
                        $this->item['custom_fields'][$customField->db_column_name()] = Crypt::encrypt($customFieldValue);
                        $this->log('Custom Field '.$customField->name.': '.Crypt::encrypt($customFieldValue));
                    } else {
                        $this->item['custom_fields'][$customField->db_column_name()] = $customFieldValue;
                        $this->log('Custom Field '.$customField->name.': '.$customFieldValue);
                    }
                } else {
                    // Clear out previous data.
                    $this->item['custom_fields'][$customField->db_column_name()] = null;
                }
            }
        }


        $this->createAssetIfNotExists($row);
    }

    /**
     * Create the asset if it does not exist.
     *
     * @author Daniel Melzter
     * @since 3.0
     * @param array $row
     * @return Asset|mixed|null
     */
    public function createAssetIfNotExists(array $row)
    {
        $editingAsset = false;
        $asset_tag = $this->findCsvMatch($row, 'asset_tag');

        if (empty($asset_tag)){
            $asset_tag = Asset::autoincrement_asset();
        }

        $asset = Asset::where(['asset_tag'=> (string) $asset_tag])->first();
        if ($asset) {
            if (! $this->updating) {
                $this->log('A matching Asset '.$asset_tag.' already exists');
                return;
            }

            $this->log('Updating Asset');
            $editingAsset = true;
        } else {
            $this->log('No Matching Asset, Creating a new one');
            $asset = new Asset;
        }

        // If no status ID is found
        if (! array_key_exists('status_id', $this->item) && ! $editingAsset) {
            $this->log('No status ID field found, defaulting to first deployable status label.');
            $this->item['status_id'] = $this->defaultStatusLabelId;
        }

        $this->item['notes'] = trim($this->findCsvMatch($row, 'asset_notes'));
        $this->item['image'] = trim($this->findCsvMatch($row, 'image'));
        $this->item['requestable'] = trim(($this->fetchHumanBoolean($this->findCsvMatch($row, 'requestable'))) == 1) ? '1' : 0;
        $asset->requestable = $this->item['requestable'];
        $this->item['warranty_months'] = intval(trim($this->findCsvMatch($row, 'warranty_months')));
        $this->item['model_id'] = $this->createOrFetchAssetModel($row);
        $this->item['byod'] = ($this->fetchHumanBoolean(trim($this->findCsvMatch($row, 'byod'))) == 1) ? '1' : 0;
        $this->item['last_checkout'] = trim($this->findCsvMatch($row, 'last_checkout'));
        $this->item['last_checkin'] = trim($this->findCsvMatch($row, 'last_checkin'));
        $this->item['expected_checkin'] = trim($this->findCsvMatch($row, 'expected_checkin'));
        $this->item['last_audit_date'] = trim($this->findCsvMatch($row, 'last_audit_date'));
        $this->item['next_audit_date'] = trim($this->findCsvMatch($row, 'next_audit_date'));
        $this->item['asset_eol_date'] = trim($this->findCsvMatch($row, 'asset_eol_date'));

        $this->item['asset_tag'] = $asset_tag;

        // We need to save the user if it exists so that we can checkout to user later.
        // Sanitizing the item will remove it.
        if (array_key_exists('checkout_target', $this->item)) {
            $target = $this->item['checkout_target'];
        } 

        $item = $this->sanitizeItemForStoring($asset, $editingAsset);

        // The location id fetched by the csv reader is actually the rtd_location_id.
        // This will also set location_id, but then that will be overridden by the
        // checkout method if necessary below.
        if (isset($this->item['location_id'])) {
            $item['rtd_location_id'] = $this->item['location_id'];
        }

        $checkin_date = date('Y-m-d H:i:s');
        if ($this->item['last_checkin']!='') {
            try {
                $checkin_date = CarbonImmutable::parse($this->item['last_checkin'])->format('Y-m-d H:i:s');
                $this->item['last_checkout'] = $checkin_date;
            } catch (\Exception $e) {
                Log::info($e->getMessage());
                $this->log('Unable to parse date: '.$this->item['last_checkout']);
            }
        }

        /**
         * We use this to backdate the checkout action further down
         */
        $checkout_date = date('Y-m-d H:i:s');
        if ($this->item['last_checkout']!='') {

            try {
                $checkout_date = CarbonImmutable::parse($this->item['last_checkout'])->format('Y-m-d H:i:s');
                $this->item['last_checkout'] = $checkout_date;
            } catch (\Exception $e) {
                Log::info($e->getMessage());
                $this->log('Unable to parse date: '.$this->item['last_checkout']);
            }
        }

        if ($this->item['expected_checkin']!='') {
            try {
                $this->item['expected_checkin'] = CarbonImmutable::parse($this->item['expected_checkin'])->format('Y-m-d');
            } catch (\Exception $e) {
                Log::info($e->getMessage());
                $this->log('Unable to parse date: '.$this->item['expected_checkin']);
            }
        }

        if ($this->item['last_audit_date']!='') {
            try {
                $this->item['last_audit_date'] = CarbonImmutable::parse($this->item['last_audit_date'])->format('Y-m-d');
            } catch (\Exception $e) {
                Log::info($e->getMessage());
                $this->log('Unable to parse date: '.$this->item['last_audit_date']);
            }
        }

        if ($this->item['next_audit_date']!='') {
            try {
                $this->item['next_audit_date'] = CarbonImmutable::parse($this->item['next_audit_date'])->format('Y-m-d');
            } catch (\Exception $e) {
                Log::info($e->getMessage());
                $this->log('Unable to parse date: '.$this->item['next_audit_date']);
            }
        }


        if ($editingAsset) {
            $asset->update($item);
        } else {
            $asset->fill($item);
        }

        // If we're updating, we don't want to overwrite old fields.
        if (array_key_exists('custom_fields', $this->item)) {
            foreach ($this->item['custom_fields'] as $custom_field => $val) {
                $asset->{$custom_field} = $val;
            }
        }

        // This sets an attribute on the Loggable trait for the action log
        $asset->setImported(true);

        if ($asset->save()) {

            $this->log('Asset '.$this->item['name'].' with serial number '.$this->item['serial'].' was created');

            // If we have a target to checkout to, lets do so.
            //-- user_id is a property of the abstract class Importer, which this class inherits from and it's set by
            //-- the class that needs to use it (command importer or GUI importer inside the project).
            if (isset($target) && ($target !== false)) {
                if (!is_null($asset->assigned_to)){
                    if ($asset->assigned_to != $target->id) {
                        event(new CheckoutableCheckedIn($asset, User::find($asset->assigned_to), Auth::user(), 'Checkin from CSV Importer', $checkin_date));
                        $this->log('Checking this asset in');
                    }
                }

                $asset->fresh()->checkOut($target, $this->user_id, $checkout_date, null, 'Checkout from CSV Importer',  $asset->name);
                $this->log('Checking this asset out');
            }

            return;
        }
        $this->logError($asset, 'Asset "'.$this->item['name'].'"');
    }
}
