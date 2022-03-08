 <?php

use App\Models\Accessory;
 use App\Models\Asset;
 use App\Models\AssetModel;
 use App\Models\Category;
use App\Models\Company;
 use App\Models\Component;
 use App\Models\Consumable;
 use App\Models\Depreciation;
 use App\Models\Location;
use App\Models\Manufacturer;
 use App\Models\Statuslabel;
 use App\Models\Supplier;
 use App\Models\User;

/**
 * Inherited Methods
 * @method void wantToTest($text)
 * @method void wantTo($text)
 * @method void execute($callable)
 * @method void expectTo($prediction)
 * @method void expect($prediction)
 * @method void amGoingTo($argumentation)
 * @method void am($role)
 * @method void lookForwardTo($achieveValue)
 * @method void comment($description)
 * @method \Codeception\Lib\Friend haveFriend($name, $actorClass = NULL)
 *
 * @SuppressWarnings(PHPMD)
 */
class FunctionalTester extends \Codeception\Actor
{
    use _generated\FunctionalTesterActions;

    /**
     * Define custom actions here
     */
    public function getCompanyId()
    {
        return Company::inRandomOrder()->first()->id;
    }

    public function getCategoryId()
    {
        return Category::inRandomOrder()->first()->id;
    }

    public function getManufacturerId()
    {
        return Manufacturer::inRandomOrder()->first()->id;
    }

    public function getLocationId()
    {
        return Location::inRandomOrder()->first()->id;
    }

    /**
     * @return mixed Random Accessory Id
     */
    public function getAccessoryId()
    {
        return Accessory::inRandomOrder()->first()->id;
    }

    /**
     * @return mixed Random Asset Model Id;
     */
    public function getModelId()
    {
        return AssetModel::inRandomOrder()->first()->id;
    }

    /**
     * @return mixed Id of Empty Asset Model
     */
    public function getEmptyModelId()
    {
        return AssetModel::doesntHave('assets')->first()->id;
    }

    /**
     * @return mixed Id of random status
     */
    public function getStatusId()
    {
        return StatusLabel::inRandomOrder()->first()->id;
    }

    /**
     * Id of random user
     * @return mixed
     */
    public function getUserId()
    {
        return User::inRandomOrder()->first()->id;
    }

    /**
     * @return mixed Id of random supplier
     */
    public function getSupplierId()
    {
        return Supplier::inRandomOrder()->first()->id;
    }

    /**
     * @return mixed Id of Random Asset
     */
    public function getAssetId()
    {
        return Asset::inRandomOrder()->first()->id;
    }

    /**
     * An Empty category
     * @return mixed Id of Empty Category
     */
    public function getEmptyCategoryId()
    {
        return Category::where('category_type', 'asset')->doesntHave('models')->first()->id;
    }

    /**
     * A random component id for testing
     * @return mixed Id of random component
     */
    public function getComponentId()
    {
        return Component::inRandomOrder()->first()->id;
    }

    /**
     * A random consumable Id for testing
     * @return mixed
     */
    public function getConsumableId()
    {
        return Consumable::inRandomOrder()->first()->id;
    }

    /**
     * Return a random depreciation id for tests.
     * @return mixed
     */
    public function getDepreciationId()
    {
        return Depreciation::inRandomOrder()->first()->id;
    }
}
