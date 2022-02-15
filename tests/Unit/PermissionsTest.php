<?php

use App\Models\Accessory;
use App\Models\Asset;
use App\Models\Component;
use App\Models\Consumable;
use App\Models\License;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class PermissionsTest extends BaseTest
{

    public function _before()
    {
        parent::_before();
        $this->noHardware = [
            'assets.view' => false,
            'assets.create' => false,
            'assets.edit' => false,
            'assets.delete' => false,
        ];

        $this->noLicenses = [
            'licenses.view' => false,
            'licenses.create' => false,
            'licenses.edit' => false,
            'licenses.delete' => false,
        ];

        $this->noAccessories = [
            'accessories.view' => false,
            'accessories.create' => false,
            'accessories.edit' => false,
            'accessories.delete' => false,
        ];

        $this->noConsumables = [
            'consumables.view' => false,
            'consumables.create' => false,
            'consumables.edit' => false,
            'consumables.delete' => false,
        ];

        $this->noComponents = [
            'components.view' => false,
            'components.create' => false,
            'components.edit' => false,
            'components.delete' => false,
        ];

        $this->noUsers = [
            'users.view' => false,
            'users.create' => false,
            'users.edit' => false,
            'users.delete' => false,
        ];

    }

    private $noHardware;
    private $noLicenses;
    private $noAccessories;
    private $noConsumables;
    private $noComponents;
    private $noUsers;

    // tests
    /**
     * @test
     */
    public function a_user_with_no_permissions_sees_nothing()
    {
        $u = factory(App\Models\User::class)->create();
        $permissions = $this->noHardware + $this->noLicenses + $this->noAccessories + $this->noConsumables + $this->noComponents + $this->noUsers;
        // $permissions = $this->noHardware;
        $this->hitRoutes($permissions, $u);
    }

    /**
     * @test
     */
    public function a_user_with_view_asset_permissions_can_view_assets()
    {
        $u = factory(App\Models\User::class)->states('view-assets')->create();
        $permissions = $this->noLicenses + $this->noAccessories + $this->noConsumables + $this->noComponents + $this->noUsers;

        $permissions = array_merge($permissions, [
            'assets.view' => true,
            'assets.create' => false,
            'assets.edit' => false,
            'assets.delete' => false,
        ]);
        $this->hitRoutes($permissions, $u);
    }

    /**
     * @test
     */
    public function a_user_with_create_asset_permissions_can_create_assets()
    {
        $u = factory(App\Models\User::class)->states('create-assets')->create();
        $permissions = $this->noLicenses + $this->noAccessories + $this->noConsumables + $this->noComponents + $this->noUsers;

        $permissions = array_merge($permissions, [
            'assets.view' => false,
            'assets.create' => true,
            'assets.edit' => false,
            'assets.delete' => false,
        ]);
        $this->hitRoutes($permissions, $u);
    }

    /**
     * @test
     */
    public function a_user_with_edit_assets_permissions_can_edit_assets()
    {
        $u = factory(App\Models\User::class)->states('edit-assets')->create();

        $permissions = $this->noLicenses + $this->noAccessories + $this->noConsumables + $this->noComponents + $this->noUsers;

        $permissions = array_merge($permissions, [
            'assets.view' => false,
            'assets.create' => false,
            'assets.edit' => true,
            'assets.delete' => false,
        ]);
        $this->hitRoutes($permissions, $u);
    }

    /**
     * @test
     */
    public function a_user_with_delete_assets_permissions_can_delete_assets()
    {
        $u = factory(App\Models\User::class)->states('delete-assets')->create();
        $permissions = $this->noLicenses + $this->noAccessories + $this->noConsumables + $this->noComponents + $this->noUsers;
        $permissions = array_merge($permissions, [
            'assets.view' => false,
            'assets.create' => false,
            'assets.edit' => false,
            'assets.delete' => true,
        ]);
        $this->hitRoutes($permissions, $u);
    }

    /**
     * @test
     */
    public function a_user_with_view_licenses_permissions_can_view_licenses()
    {
        $u = factory(App\Models\User::class)->states('view-licenses')->create();
        $permissions = $this->noHardware + $this->noAccessories + $this->noConsumables + $this->noComponents + $this->noUsers;

        $permissions = array_merge($permissions, [
            'licenses.view' => true,
            'licenses.create' => false,
            'licenses.edit' => false,
            'licenses.delete' => false,
        ]);
        $this->hitRoutes($permissions, $u);
    }

    /**
     * @test
     */
    public function a_user_with_create_licenses_permissions_can_create_licenses()
    {
        $u = factory(App\Models\User::class)->states('create-licenses')->create();
        $permissions = $this->noHardware + $this->noAccessories + $this->noConsumables + $this->noComponents + $this->noUsers;

        $permissions = array_merge($permissions, [
            'licenses.view' => false,
            'licenses.create' => true,
            'licenses.edit' => false,
            'licenses.delete' => false,
        ]);
        $this->hitRoutes($permissions, $u);
    }

    /**
     * @test
     */
    public function a_user_with_edit_licenses_permissions_can_edit_licenses()
    {
        $u = factory(App\Models\User::class)->states('edit-licenses')->create();
        $permissions = $this->noHardware + $this->noAccessories + $this->noConsumables + $this->noComponents + $this->noUsers;

        $permissions = array_merge($permissions, [
            'licenses.view' => false,
            'licenses.create' => false,
            'licenses.edit' => true,
            'licenses.delete' => false,
        ]);
        $this->hitRoutes($permissions, $u);
    }

    /**
     * @test
     */
    public function a_user_with_delete_licenses_permissions_can_delete_licenses()
    {
        $u = factory(App\Models\User::class)->states('delete-licenses')->create();
        $permissions = $this->noHardware + $this->noAccessories + $this->noConsumables + $this->noComponents + $this->noUsers;

        $permissions = array_merge($permissions, [
            'licenses.view' => false,
            'licenses.create' => false,
            'licenses.edit' => false,
            'licenses.delete' => true,
        ]);
        $this->hitRoutes($permissions, $u);
    }

    /**
     * @test
    */
    public function a_user_with_view_accessories_permissions_can_view_accessories()
    {
        $u = factory(App\Models\User::class)->states('view-accessories')->create();

        $permissions = $this->noHardware + $this->noLicenses + $this->noConsumables + $this->noComponents + $this->noUsers;

        $permissions = array_merge($permissions, [
            'accessories.view' => true,
            'accessories.create' => false,
            'accessories.edit' => false,
            'accessories.delete' => false,
        ]);
        $this->hitRoutes($permissions, $u);
    }

    /**
     * @test
     */
    public function a_user_with_create_accessories_permissions_can_create_accessories()
    {
        $u = factory(App\Models\User::class)->states('create-accessories')->create();

        $permissions = $this->noHardware + $this->noLicenses + $this->noConsumables + $this->noComponents + $this->noUsers;

        $permissions = array_merge($permissions, [
            'accessories.view' => false,
            'accessories.create' => true,
            'accessories.edit' => false,
            'accessories.delete' => false,
        ]);
        $this->hitRoutes($permissions, $u);
    }

    /**
     * @test
     */
    public function a_user_with_edit_accessories_permissions_can_edit_accessories()
    {
        $u = factory(App\Models\User::class)->states('edit-accessories')->create();

        $permissions = $this->noHardware + $this->noLicenses + $this->noConsumables + $this->noComponents + $this->noUsers;

        $permissions = array_merge($permissions, [
            'accessories.view' => false,
            'accessories.create' => false,
            'accessories.edit' => true,
            'accessories.delete' => false,
        ]);
        $this->hitRoutes($permissions, $u);
    }

    /**
     * @test
     */
    public function a_user_with_delete_accessories_permissions_can_delete_accessories()
    {
        $u = factory(App\Models\User::class)->states('delete-accessories')->create();

        $permissions = $this->noHardware + $this->noLicenses + $this->noConsumables + $this->noComponents + $this->noUsers;

        $permissions = array_merge($permissions, [
            'accessories.view' => false,
            'accessories.create' => false,
            'accessories.edit' => false,
            'accessories.delete' => true,
        ]);
        $this->hitRoutes($permissions, $u);
    }

    /**
     * @test
     */
    public function a_user_with_view_consumables_permissions_can_view_consumables()
    {
        $u = factory(App\Models\User::class)->states('view-consumables')->create();

        $permissions = $this->noHardware + $this->noLicenses + $this->noAccessories + $this->noComponents + $this->noUsers;

        $permissions = array_merge($permissions, [
            'consumables.view' => true,
            'consumables.create' => false,
            'consumables.edit' => false,
            'consumables.delete' => false,
        ]);
        $this->hitRoutes($permissions, $u);
    }

    /**
     * @test
     */
    public function a_user_with_create_consumables_permissions_can_create_consumables()
    {
        $u = factory(App\Models\User::class)->states('create-consumables')->create();

        $permissions = $this->noHardware + $this->noLicenses + $this->noConsumables + $this->noComponents + $this->noUsers;

        $permissions = array_merge($permissions, [
            'consumables.view' => false,
            'consumables.create' => true,
            'consumables.edit' => false,
            'consumables.delete' => false,
        ]);
        $this->hitRoutes($permissions, $u);
    }

    /**
     * @test
     */
    public function a_user_with_edit_consumables_permissions_can_edit_consumables()
    {
        $u = factory(App\Models\User::class)->states('edit-consumables')->create();

        $permissions = $this->noHardware + $this->noLicenses + $this->noAccessories + $this->noComponents + $this->noUsers;

        $permissions = array_merge($permissions, [
            'consumables.view' => false,
            'consumables.create' => false,
            'consumables.edit' => true,
            'consumables.delete' => false,
        ]);
        $this->hitRoutes($permissions, $u);
    }

    /**
     * @test
     */
    public function a_user_with_delete_consumables_permissions_can_delete_consumables()
    {
        $u = factory(App\Models\User::class)->states('delete-consumables')->create();

        $permissions = $this->noHardware + $this->noLicenses + $this->noAccessories + $this->noComponents + $this->noUsers;

        $permissions = array_merge($permissions, [
            'consumables.view' => false,
            'consumables.create' => false,
            'consumables.edit' => false,
            'consumables.delete' => true,
        ]);
        $this->hitRoutes($permissions, $u);
    }

    /**
     * @test
     */
    public function a_user_with_view_users_permissions_can_view_users()
    {
        $u = factory(App\Models\User::class)->states('view-users')->create();

        $permissions = $this->noHardware + $this->noLicenses + $this->noAccessories +$this->noConsumables + $this->noComponents;

        $permissions = array_merge($permissions, [
            'users.view' => true,
            'users.create' => false,
            'users.edit' => false,
            'users.delete' => false,
        ]);
        $this->hitRoutes($permissions, $u);
    }

    /**
     * @test
     */
    public function a_user_with_create_users_permissions_can_create_users()
    {
        $u = factory(App\Models\User::class)->states('create-users')->create();

        $permissions = $this->noHardware + $this->noLicenses + $this->noAccessories +$this->noConsumables + $this->noComponents;

        $permissions = array_merge($permissions, [
            'users.view' => false,
            'users.create' => true,
            'users.edit' => false,
            'users.delete' => false,
        ]);
        $this->hitRoutes($permissions, $u);
    }

    /**
     * @test
     */
    public function a_user_with_edit_users_permissions_can_edit_users()
    {
        $u = factory(App\Models\User::class)->states('edit-users')->create();

                $permissions = $this->noHardware + $this->noLicenses + $this->noAccessories +$this->noConsumables + $this->noComponents;

        $permissions = array_merge($permissions, [
            'users.view' => false,
            'users.create' => false,
            'users.edit' => true,
            'users.delete' => false,
        ]);
        $this->hitRoutes($permissions, $u);
    }

    /**
     * @test
     */
    public function a_user_with_delete_users_permissions_can_delete_users()
    {
        $u = factory(App\Models\User::class)->states('delete-users')->create();

                $permissions = $this->noHardware + $this->noLicenses + $this->noAccessories +$this->noConsumables + $this->noComponents;

        $permissions = array_merge($permissions, [
            'users.view' => false,
            'users.create' => false,
            'users.edit' => false,
            'users.delete' => true,
        ]);
        $this->hitRoutes($permissions, $u);
    }

    /**
     * @test
     */
    public function a_user_with_view_components_permissions_can_view_components()
    {
        $u = factory(App\Models\User::class)->states('view-components')->create();

        $permissions = $this->noHardware + $this->noLicenses + $this->noAccessories +$this->noConsumables + $this->noUsers;

        $permissions = array_merge($permissions, [
            'components.view' => true,
            'components.create' => false,
            'components.edit' => false,
            'components.delete' => false,
        ]);
        $this->hitRoutes($permissions, $u);
    }

    /**
     * @test
     */
    public function a_user_with_create_components_permissions_can_create_components()
    {
        $u = factory(App\Models\User::class)->states('create-components')->create();
        $permissions = $this->noHardware + $this->noLicenses + $this->noAccessories +$this->noConsumables + $this->noUsers;

        $permissions = array_merge($permissions, [
            'components.view' => false,
            'components.create' => true,
            'components.edit' => false,
            'components.delete' => false,
        ]);
        $this->hitRoutes($permissions, $u);
    }

    /**
     * @test
     */
    public function a_user_with_edit_components_permissions_can_edit_components()
    {
        $u = factory(App\Models\User::class)->states('edit-components')->create();

        $permissions = $this->noHardware + $this->noLicenses + $this->noAccessories +$this->noConsumables + $this->noUsers;

        $permissions = array_merge($permissions, [
            'components.view' => false,
            'components.create' => false,
            'components.edit' => true,
            'components.delete' => false,
        ]);
        $this->hitRoutes($permissions, $u);
    }

    /**
     * @test
     */
    public function a_user_with_delete_components_permissions_can_delete_components()
    {
        $u = factory(App\Models\User::class)->states('delete-components')->create();

        $permissions = $this->noHardware + $this->noLicenses + $this->noAccessories +$this->noConsumables + $this->noUsers;

        $permissions = array_merge($permissions, [
            'components.view' => false,
            'components.create' => false,
            'components.edit' => false,
            'components.delete' => true,
        ]);
        // dd($u);
        $this->hitRoutes($permissions, $u);
    }

    private function hitRoutes(array $routes, User $user)
    {
        foreach ($routes as $route => $expectation) {
            $this->assertEquals($user->hasAccess($route), $expectation);
        }
    }
}
