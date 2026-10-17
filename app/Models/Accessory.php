<?php

namespace App\Models;

use App\Enums\FileStorage;
use App\Models\Builders\AccessoryQueryBuilder;
use App\Models\Traits\Acceptable;
use App\Models\Traits\AdjustsQuantity;
use App\Models\Traits\CompanyableTrait;
use App\Models\Traits\HasOrders;
use App\Models\Traits\HasUploads;
use App\Models\Traits\Loggable;
use App\Models\Traits\Requestable;
use App\Models\Traits\Searchable;
use App\Presenters\AccessoryPresenter;
use App\Presenters\Presentable;
use App\Rules\RequestableArchivedMutex;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Watson\Validating\ValidatingTrait;

/**
 * Model for Accessories.
 *
 * @version v1.0
 *
 * @mixin IdeHelperAccessory
 */
class Accessory extends SnipeModel
{
    use Acceptable;
    use AdjustsQuantity;
    use CompanyableTrait;
    use HasFactory;
    use HasOrders;
    use HasUploads;
    use Loggable;
    use Presentable;
    use Requestable;
    use Searchable;
    use SoftDeletes;
    use ValidatingTrait;

    protected $table = 'accessories';

    protected $casts = [
        'purchase_date' => 'datetime',
        'requestable' => 'boolean',
        'archived' => 'boolean',
    ];

    protected $presenter = AccessoryPresenter::class;

    /**
     * The attributes that should be included when searching the model.
     *
     * @var array
     */
    protected $searchableAttributes = [
        'created_at',
        'model_number',
        'name',
        'notes',
    ];

    /**
     * The relations and their attributes that should be included when searching the model.
     *
     * @var array
     */
    protected $searchableRelations = [
        'category' => ['name'],
        'company' => ['name'],
        'location' => ['name'],
        'manufacturer' => ['name'],
        // Search by the parent's "typical supplier" template. Historical
        // per-order supplier lookups belong on the Orders tab; this join
        // keeps parent-level list-page search predictable.
        'defaultSupplier' => ['name'],
        // Order numbers moved to a dedicated Orders / OrderItems data
        // model when the parent order_number column was removed.
        // Free-text search on an order-number string walks the HasOrders
        // trait's orders() HasManyThrough into orders.order_number so
        // any accessory ever acquired under that order still surfaces.
        'orders' => ['order_number'],
    ];

    protected $searchableCounts = [
        'checkouts_count',
    ];

    /**
     * Accessory validation rules
     */
    public $rules = [
        'name' => 'required|max:255',
        'qty' => 'nullable|integer|min:0',
        'category_id' => 'required|integer|exists:categories,id',
        'company_id' => 'integer|nullable|exists:companies,id|fmcs_company',
        'location_id' => 'exists:locations,id|nullable|fmcs_location',
        'min_amt' => 'integer|min:0|nullable',
        'purchase_cost' => 'numeric|nullable|gte:0|max:99999999999999999.99',
        'purchase_date' => 'date_format:Y-m-d|nullable',
        'default_supplier_id' => 'nullable|integer|exists:suppliers,id',
        'default_purchase_cost' => 'numeric|nullable|gte:0|max:99999999999999999.99',
        'requestable' => ['nullable', 'boolean'],
        'archived' => ['nullable', 'boolean'],
    ];

    /**
     * PHP 8.2 blocks `new X` in property defaults, so the rule object
     * gets spliced in here rather than in $rules above. Mirrors
     * Component::getRules() so the mutex and the no-archive-with-
     * checkouts guard behave identically across checkoutable items.
     */
    public function getRules(): array
    {
        $rules = $this->rules ?? [];
        $mutex = new RequestableArchivedMutex;

        $noArchivingWithCheckouts = function (string $attribute, mixed $value, \Closure $fail): void {
            if (filter_var($value, FILTER_VALIDATE_BOOLEAN) && $this->exists && $this->checkouts()->count() > 0) {
                // $attribute passed through to trans() so phpmd sees
                // the param as used. The translation string ignores
                // the extra key today, but future refinements can
                // reference it if we want field-specific phrasing.
                $fail(trans('general.archived_blocked_by_checkouts', [
                    'item_type' => trans('general.accessory'),
                    'attribute' => $attribute,
                ]));
            }
        };

        $rules['requestable'] = array_merge((array) ($rules['requestable'] ?? []), [$mutex]);
        $rules['archived'] = array_merge((array) ($rules['archived'] ?? []), [$mutex, $noArchivingWithCheckouts]);

        return $rules;
    }

    /**
     * Whether the model should inject it's identifier to the unique
     * validation rules before attempting validation. If this property
     * is not set in the model it will default to true.
     *
     * @var bool
     */
    protected $injectUniqueIdentifier = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    // supplier_id / purchase_date / purchase_cost are intentionally
    // absent. Post-Orders acquisitions record their own values per event
    // on Order + OrderItem; writing to the old names hard-fails at the
    // DB (column renamed) which is the intended guard against divergent
    // parent-vs-Orders state.
    //
    // default_supplier_id / default_purchase_cost are parent-level
    // "template" values that pre-populate the adjust-quantity modal for
    // items with no order history yet. See lastOrderDefaults() on the
    // HasOrders trait for the merge behavior.
    protected $fillable = [
        'category_id',
        'company_id',
        'location_id',
        'name',
        'model_number',
        'manufacturer_id',
        'image',
        'qty',
        'min_amt',
        'requestable',
        'archived',
        'notes',
        'default_supplier_id',
        'default_purchase_cost',
    ];

    // No `supplier()` relation, no `supplier_id` / `purchase_date` /
    // `purchase_cost` accessors on the parent. Those concepts are
    // per-transaction now. Callers use `$accessory->orders` (all Orders
    // over the lifetime) or `$accessory->lastOrderDefaults()` (most
    // recent acquisition context, falling back to the parent's
    // default_* template fields on items with no order history yet).

    /**
     * On hard-delete, wipe the image file and Files-tab attachments.
     * Soft-delete leaves everything alone so a restore comes back with
     * the image + files intact. The attachment action_log rows get
     * soft-deleted (not hard-deleted) so the audit trail of what was
     * attached-and-when survives even after the parent is gone.
     */
    protected static function booted(): void
    {
        static::forceDeleted(function (self $accessory) {
            if ($accessory->image) {
                try {
                    Storage::disk('public')->delete(FileStorage::Accessories->publicPath().$accessory->image);
                } catch (\Exception $e) {
                    Log::info($e->getMessage());
                }
            }

            foreach ($accessory->uploads as $upload) {
                if (($path = $upload->uploads_file_path()) !== null) {
                    try {
                        Storage::delete($path);
                    } catch (\Exception $e) {
                        Log::info($e->getMessage());
                    }
                }
                $upload->delete();
            }
        });
    }

    /**
     * Parent-level "typical supplier" template. Distinct from
     * per-acquisition supplier (which lives on Order.supplier_id).
     * Used by the searchable-relation join for list-page search and by
     * lastOrderDefaults() as the fallback for items with no orders yet.
     */
    public function defaultSupplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class, 'default_supplier_id');
    }

    public function isDeletable()
    {
        return $this->checkouts_count === 0;
    }

    /**
     * Sets the requestable attribute on the accessory
     *
     * Kept as the legacy magic-method form rather than the modern
     * Attribute::make accessor. Requestable() is also a query scope on
     * AccessoryQueryBuilder, and `Accessory::Requestable()` resolves
     * through Model::__callStatic → __call → forwardCallTo(newQuery(),
     * ...) only when the method doesn't exist on the model. An
     * `Attribute`-returning method shadows that forwarder and crashes
     * with "Call to undefined method Attribute::count()". See
     * Component::setRequestableAttribute for the same comment.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     *
     * @since  [v4.0]
     */
    public function setRequestableAttribute($value): void
    {
        if ($value == '') {
            $value = null;
        }
        $this->attributes['requestable'] = filter_var($value, FILTER_VALIDATE_BOOLEAN);
    }

    /**
     * Mirror for the archived flag. Normalizes empty-string / null /
     * missing-column CSV cells to false so the NOT NULL `archived`
     * column never receives a literal null.
     */
    public function setArchivedAttribute($value): void
    {
        if ($value == '') {
            $value = null;
        }
        $this->attributes['archived'] = filter_var($value, FILTER_VALIDATE_BOOLEAN);
    }

    /**
     * Establishes the accessory -> company relationship
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     *
     * @since  [v3.0]
     *
     * @return Relation
     */
    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    /**
     * Establishes the accessory -> location relationship
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     *
     * @since  [v3.0]
     *
     * @return Relation
     */
    public function location()
    {
        return $this->belongsTo(Location::class, 'location_id');
    }

    /**
     * Establishes the accessory -> category relationship
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     *
     * @since  [v3.0]
     *
     * @return Relation
     */
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id')->where('category_type', '=', 'accessory');
    }

    /**
     * Returns the action logs associated with the accessory
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     *
     * @since  [v3.0]
     *
     * @return Relation
     */
    public function assetlog()
    {
        return $this->hasMany(Actionlog::class, 'item_id')->where('item_type', self::class)->orderBy('created_at', 'desc')->withTrashed();
    }

    /**
     * Get the LAST checkout for this accessory.
     *
     * This is kinda gross, but is necessary for how the accessory
     * pivot stuff works for now.
     *
     * It looks like we should be able to use ->first() here and
     * return an object instead of a collection, but we actually
     * cannot.
     *
     * In short, you cannot execute the query defined when you're eager loading.
     * and in order to avoid 1001 query problems when displaying the most
     * recent checkout note, we have to eager load this.
     *
     * This means we technically return a collection of one here, and then
     * in the controller, we convert that collection to an array, so we can
     * use it in the transformer to display only the notes of the LAST
     * checkout.
     *
     * It's super-mega-assy, but it's the best I could do for now.
     *
     * @author A. Gianotto <snipe@snipe.net>
     *
     * @since  v5.0.0
     * @see checkedout()
     */
    public function lastCheckout(): HasMany
    {
        return $this->assetlog()->where('action_type', '=', 'checkout')->take(1);
    }

    /**
     * Sets the full image url
     *
     * @todo this should probably be moved out of the model and into a
     * presenter or service provider
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     *
     * @since  [v3.0]
     *
     * @return string
     */
    public function getImageUrl($path = null)
    {
        if ($this->image) {
            return Storage::disk('public')->url(FileStorage::Accessories->publicPath().$this->image);
        }

        return false;

    }

    /**
     * Establishes the accessory -> users relationship
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     *
     * @since  [v3.0]
     *
     * @return Relation
     */
    public function checkouts()
    {
        return $this->hasMany(AccessoryCheckout::class, 'accessory_id')
            ->with('assignedTo');
    }

    public function percentRemaining()
    {
        if (($this->qty == '' || $this->qty == 0)) {
            return 0;
        }
        if ($this->checkouts_count == 0) {
            return 100;
        }

        return ($this->qty - $this->checkouts_count) / $this->qty * 100;
    }

    /**
     * Establishes the accessory -> users relationship
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     *
     * @since  [v3.0]
     *
     * @return Relation
     */
    public function users()
    {
        return $this->belongsToMany(AccessoryCheckout::class, 'accessories_checkout')
            ->with('assignedTo');
    }

    /**
     * Checks whether or not the accessory has users
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     *
     * @since  [v3.0]
     *
     * @return int
     */
    public function hasUsers()
    {
        return $this->hasMany(AccessoryCheckout::class, 'accessory_id')
            ->where('assigned_type', User::class)
            ->count();
    }

    /**
     * Establishes the accessory -> manufacturer relationship
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     *
     * @since  [v3.0]
     *
     * @return Relation
     */
    public function manufacturer()
    {
        return $this->belongsTo(Manufacturer::class, 'manufacturer_id');
    }

    /**
     * Determins whether or not an email should be sent for checkin/checkout of this
     * accessory based on the category it belongs to.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     *
     * @since  [v3.0]
     *
     * @return bool
     */
    public function checkin_email()
    {
        return $this->category?->checkin_email;
    }

    /**
     * Determines whether or not the accessory should require the user to
     * accept it via email.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     *
     * @since  [v3.0]
     *
     * @return bool
     */
    public function requireAcceptance()
    {
        return $this->category->require_acceptance ?? false;
    }

    /**
     * Check how many items within an accessory are checked out
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     *
     * @since  [v5.0]
     *
     * @return int
     */
    public function numCheckedOut()
    {
        return $this->checkouts_count ?? $this->checkouts()->count();
    }

    /**
     * AdjustsQuantity trait hook: units currently checked out to users.
     * The adjust-quantity modal uses this to reject decrements that
     * would leave the on-hand qty below what's already assigned out.
     */
    public function currentlyInUseCount(): int
    {
        return (int) $this->numCheckedOut();
    }

    /**
     * Check how many items of an accessory remain.
     *
     * In order to use this model method, you MUST call withCount('checkouts as checkouts_count')
     * on the eloquent query in the controller, otherwise $this->checkouts_count will be null and
     * bad things happen.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     *
     * @since  [v3.0]
     *
     * @return int
     */
    public function numRemaining()
    {
        $checkedout = $this->numCheckedOut();
        $total = $this->qty;
        $remaining = $total - $checkedout;

        return $remaining;
    }

    /**
     * Run after the checkout acceptance was declined by the user
     *
     * @param  string  $signature
     */
    public function declinedCheckout(User $declinedBy, $signature)
    {
        // ->latest() on a builder is never null, so the previous
        // `is_null($query_builder)` guard was dead code and the subsequent
        // `->limit(1)->delete()` ran unconditionally. Resolve the row first
        // and delete by model so the no-match path is explicit.
        $accessory_checkout = AccessoryCheckout::userAssigned()
            ->where('assigned_to', $declinedBy->id)
            ->where('accessory_id', $this->id)
            ->latest('created_at')
            ->first();

        if ($accessory_checkout === null) {
            Log::warning('No AccessoryCheckout row found to decline for accessory '.$this->id.' and user '.$declinedBy->id);

            return;
        }

        $accessory_checkout->delete();
    }

    /**
     * -----------------------------------------------
     * BEGIN MUTATORS
     * -----------------------------------------------
     **/

    /**
     * This sets a value for qty if no value is given. The database does not allow this
     * field to be null, and in the other areas of the code, we set a default, but the importer
     * does not.
     *
     * This simply checks that there is a value for quantity, and if there isn't, set it to 0.
     *
     * @author A. Gianotto <snipe@snipe.net>
     *
     * @since  v6.3.4
     *
     * @return void
     */
    public function setQtyAttribute($value)
    {
        $this->attributes['qty'] = (! $value) ? 0 : intval($value);
    }

    public function newEloquentBuilder($query): AccessoryQueryBuilder
    {
        return new AccessoryQueryBuilder($query);
    }
}
