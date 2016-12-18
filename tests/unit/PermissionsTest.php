<?php

use App\Models\Accessory;
use App\Models\Asset;
use App\Models\Consumable;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class PermissionsTest extends TestCase
{
    // use DatabaseMigrations;
    use DatabaseTransactions;
    public function setUp()
    {
        parent::setUp();
        $this->noHardware = [
            'hardware.index' => 403,
            'hardware.create' => 403,
            'hardware.edit' => 403,
            'hardware.show' => 403,
        ];

        $this->noLicenses = [
            'licenses.index' => 403,
            'licenses.create' => 403,
            'licenses.edit' => 403,
            'licenses.show' => 403,
        ];

        $this->noAccessories = [
            'accessories.index' => 403,
            'accessories.create' => 403,
            'accessories.edit' => 403,
            'accessories.show' => 403,
        ];

        $this->noConsumables = [
            'consumables.index' => 403,
            'consumables.create' => 403,
            'consumables.edit' => 403,
            'consumables.show' => 403,
        ];

        $this->noComponents = [
            'components.index' => 403,
            'components.create' => 403,
            'components.edit' => 403,
            'components.show' => 403,
        ];

        $this->noUsers = [
            'users.index' => 403,
            'users.create' => 403,
            'users.edit' => 403,
            'users.show' => 403,
        ];

    }

    public function tearDown()
    {
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
        $u = factory(App\Models\User::class, 'valid-user')->create();
        $permissions = $this->noHardware + $this->noLicenses + $this->noAccessories + $this->noConsumables + $this->noComponents + $this->noUsers;
        // $permissions = $this->noHardware;
        $this->hitRoutes($permissions, $u);

    }

    /**
     * @test
     */
    public function a_user_with_view_asset_permissions_can_view_assets()
    {
        $u = factory(App\Models\User::class, 'valid-user')->states('view-assets')->create();
        $permissions = $this->noLicenses + $this->noAccessories + $this->noConsumables + $this->noComponents + $this->noUsers;

        $permissions = array_merge($permissions, [
            'hardware.index' => 200,
            'hardware.create' => 403,
            'hardware.edit' => 403,
            'hardware.show' => 200,
        ]);
        $this->hitRoutes($permissions, $u);
    }

    /**
     * @test
     */
    public function a_user_with_create_asset_permissions_can_create_assets()
    {
        $u = factory(App\Models\User::class, 'valid-user')->states('create-assets')->create();
        $permissions = $this->noLicenses + $this->noAccessories + $this->noConsumables + $this->noComponents + $this->noUsers;

        $permissions = array_merge($permissions, [
            'hardware.index' => 403,
            'hardware.create' => 200,
            'hardware.edit' => 403,
            'hardware.show' => 403,
        ]);
        $this->hitRoutes($permissions, $u);
    }

    /**
     * @test
     */
    public function a_user_with_edit_assets_permissions_can_edit_assets()
    {
        $u = factory(App\Models\User::class, 'valid-user')->states('edit-assets')->create();

        $permissions = $this->noLicenses + $this->noAccessories + $this->noConsumables + $this->noComponents + $this->noUsers;

        $permissions = array_merge($permissions, [
            'hardware.index' => 403,
            'hardware.create' => 403,
            'hardware.edit' => 200,
            'hardware.show' => 403,
        ]);
        $this->hitRoutes($permissions, $u);
    }

    /**
     * @test
     */
    public function a_user_with_view_licenses_permissions_can_view_licenses()
    {
        $u = factory(App\Models\User::class, 'valid-user')->states('view-licenses')->create();
        $permissions = $this->noHardware + $this->noAccessories + $this->noConsumables + $this->noComponents + $this->noUsers;

        $permissions = array_merge($permissions, [
            'licenses.index' => 200,
            'licenses.create' => 403,
            'licenses.edit' => 403,
            'licenses.show' => 200,
        ]);
        $this->hitRoutes($permissions, $u);
    }

    /**
     * @test
     */
    public function a_user_with_create_licenses_permissions_can_create_licenses()
    {
        $u = factory(App\Models\User::class, 'valid-user')->states('create-licenses')->create();
        $permissions = $this->noHardware + $this->noAccessories + $this->noConsumables + $this->noComponents + $this->noUsers;

        $permissions = array_merge($permissions, [
            'licenses.index' => 403,
            'licenses.create' => 200,
            'licenses.edit' => 403,
            'licenses.show' => 403,
        ]);
        $this->hitRoutes($permissions, $u);
    }

    /**
     * @test
     */
    public function a_user_with_edit_licenses_permissions_can_edit_licenses()
    {
        $u = factory(App\Models\User::class, 'valid-user')->states('edit-licenses')->create();
        $permissions = $this->noHardware + $this->noAccessories + $this->noConsumables + $this->noComponents + $this->noUsers;

        $permissions = array_merge($permissions, [
            'licenses.index' => 403,
            'licenses.create' => 403,
            'licenses.edit' => 200,
            'licenses.show' => 403,
        ]);
        $this->hitRoutes($permissions, $u);
    }

    /**
     * @test
    */
    public function a_user_with_view_accessories_permissions_can_view_accessories()
    {
        $u = factory(App\Models\User::class, 'valid-user')->states('view-accessories')->create();

        $permissions = $this->noHardware + $this->noLicenses + $this->noConsumables + $this->noComponents + $this->noUsers;

        $permissions = array_merge($permissions, [
            'accessories.index' => 200,
            'accessories.create' => 403,
            'accessories.edit' => 403,
            'accessories.show' => 200,
        ]);
        $this->hitRoutes($permissions, $u);
    }

    /**
     * @test
     */
    public function a_user_with_create_accessories_permissions_can_create_accessories()
    {
        $u = factory(App\Models\User::class, 'valid-user')->states('create-accessories')->create();

        $permissions = $this->noHardware + $this->noLicenses + $this->noConsumables + $this->noComponents + $this->noUsers;

        $permissions = array_merge($permissions, [
            'accessories.index' => 403,
            'accessories.create' => 200,
            'accessories.edit' => 403,
            'accessories.show' => 403,
        ]);
        $this->hitRoutes($permissions, $u);
    }

    /**
     * @test
     */
    public function a_user_with_edit_accessories_permissions_can_edit_accessories()
    {
        $u = factory(App\Models\User::class, 'valid-user')->states('edit-accessories')->create();

        $permissions = $this->noHardware + $this->noLicenses + $this->noConsumables + $this->noComponents + $this->noUsers;

        $permissions = array_merge($permissions, [
            'accessories.index' => 403,
            'accessories.create' => 403,
            'accessories.edit' => 200,
            'accessories.show' => 403,
        ]);
        $this->hitRoutes($permissions, $u);
    }

    /**
     * @test
     */
    public function a_user_with_view_consumables_permissions_can_view_consumables()
    {
        $u = factory(App\Models\User::class, 'valid-user')->states('view-consumables')->create();

        $permissions = $this->noHardware + $this->noLicenses + $this->noAccessories + $this->noComponents + $this->noUsers;

        $permissions = array_merge($permissions, [
            'consumables.index' => 200,
            'consumables.create' => 403,
            'consumables.edit' => 403,
            'consumables.show' => 200,
        ]);
        $this->hitRoutes($permissions, $u);
    }

    /**
     * @test
     */
    public function a_user_with_create_consumables_permissions_can_create_consumables()
    {
        $u = factory(App\Models\User::class, 'valid-user')->states('create-consumables')->create();

        $permissions = $this->noHardware + $this->noLicenses + $this->noConsumables + $this->noComponents + $this->noUsers;

        $permissions = array_merge($permissions, [
            'consumables.index' => 403,
            'consumables.create' => 200,
            'consumables.edit' => 403,
            'consumables.show' => 403,
        ]);
        $this->hitRoutes($permissions, $u);
    }

    /**
     * @test
     */
    public function a_user_with_edit_consumables_permissions_can_edit_consumables()
    {
        $u = factory(App\Models\User::class, 'valid-user')->states('edit-consumables')->create();

        $permissions = $this->noHardware + $this->noLicenses + $this->noAccessories + $this->noComponents + $this->noUsers;

        $permissions = array_merge($permissions, [
            'consumables.index' => 403,
            'consumables.create' => 403,
            'consumables.edit' => 200,
            'consumables.show' => 403,
        ]);
        $this->hitRoutes($permissions, $u);
    }

    /**
     * @test
     */
    public function a_user_with_view_users_permissions_can_view_users()
    {
        $u = factory(App\Models\User::class, 'valid-user')->states('view-users')->create();

        $permissions = $this->noHardware + $this->noLicenses + $this->noAccessories +$this->noConsumables + $this->noComponents;

        $permissions = array_merge($permissions, [
            'users.index' => 200,
            'users.create' => 403,
            'users.edit' => 403,
            'users.show' => 200,
        ]);
        $this->hitRoutes($permissions, $u);
    }

    /**
     * @test
     */
    public function a_user_with_create_users_permissions_can_create_users()
    {
        $u = factory(App\Models\User::class, 'valid-user')->states('create-users')->create();

        $permissions = $this->noHardware + $this->noLicenses + $this->noAccessories +$this->noConsumables + $this->noComponents;

        $permissions = array_merge($permissions, [
            'users.index' => 403,
            'users.create' => 200,
            'users.edit' => 403,
            'users.show' => 403,
        ]);
        $this->hitRoutes($permissions, $u);
    }

    /**
     * @test
     */
    public function a_user_with_edit_users_permissions_can_edit_users()
    {
        $u = factory(App\Models\User::class, 'valid-user')->states('edit-users')->create();

                $permissions = $this->noHardware + $this->noLicenses + $this->noAccessories +$this->noConsumables + $this->noComponents;

        $permissions = array_merge($permissions, [
            'users.index' => 403,
            'users.create' => 403,
            'users.edit' => 200,
            'users.show' => 403,
        ]);
        $this->hitRoutes($permissions, $u);
    }

    /**
     * @test
     */
    public function a_user_with_view_components_permissions_can_view_components()
    {
        $u = factory(App\Models\User::class, 'valid-user')->states('view-components')->create();

        $permissions = $this->noHardware + $this->noLicenses + $this->noAccessories +$this->noConsumables + $this->noUsers;

        $permissions = array_merge($permissions, [
            'components.index' => 200,
            'components.create' => 403,
            'components.edit' => 403,
            'components.show' => 200,
        ]);
        $this->hitRoutes($permissions, $u);
    }

    /**
     * @test
     */
    public function a_user_with_create_components_permissions_can_create_components()
    {
        $u = factory(App\Models\User::class, 'valid-user')->states('create-components')->create();
        $permissions = $this->noHardware + $this->noLicenses + $this->noAccessories +$this->noConsumables + $this->noUsers;

        $permissions = array_merge($permissions, [
            'components.index' => 403,
            'components.create' => 200,
            'components.edit' => 403,
            'components.show' => 403,
        ]);
        $this->hitRoutes($permissions, $u);
    }

    /**
     * @test
     */
    public function a_user_with_edit_components_permissions_can_edit_components()
    {
        $u = factory(App\Models\User::class, 'valid-user')->states('edit-components')->create();

        $permissions = $this->noHardware + $this->noLicenses + $this->noAccessories +$this->noConsumables + $this->noUsers;

        $permissions = array_merge($permissions, [
            'components.index' => 403,
            'components.create' => 403,
            'components.edit' => 200,
            'components.show' => 403,
        ]);
        $this->hitRoutes($permissions, $u);
    }

    private function hitRoutes(array $routes, User $user)
    {
        $this->actingAs($user);
        // dd($user);
        foreach ($routes as $route => $response) {
            // $this->log($route);
            if (strpos($route, 'edit') || strpos($route, 'show') || strpos($route, 'destroy')) {
                // ($this->get(route($route,2))->dump());
                $this->get(route($route, 1))
                    ->assertResponseStatus($response);
            } else {
                // dd($this->get(route($route)));
                // echo($this->get(route($route))->dump());
                $this->get(route($route))
                    ->assertResponseStatus($response);
            }
        }
    }

}
