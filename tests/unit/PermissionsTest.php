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

class PermissionsTest extends TestCase
{
    // use DatabaseMigrations;
    use DatabaseTransactions;

    protected function _before()
    {
        Artisan::call('migrate');
        $this->hardwareId = factory(App\Models\Asset::class)->create()->id;
        $this->noHardware = [
            route('hardware.index') => 403,
            route('hardware.create') => 403,
            route('hardware.edit', $this->hardwareId) => 403,
            route('hardware.show', $this->hardwareId) => 403,
        ];

        $this->licenseId = factory(App\Models\License::class)->create()>id;
        $this->noLicenses = [
            route('licenses.index') => 403,
            route('licenses.create') => 403,
            route('licenses.edit', $this->licenseId) => 403,
            route('licenses.show', $this->licenseId) => 403,
        ];

        $this->accessoryId = factory(App\Models\Accessory::class)->create()->id;
        $this->noAccessories = [
            route('accessories.index') => 403,
            route('accessories.create') => 403,
            route('accessories.edit', $this->accessoryId) => 403,
            route('accessories.show', $this->accessoryId) => 403,
        ];

        $this->consumableId = factory(App\Models\Consumable::class)->create()->id;
        $this->noConsumables = [
            route('consumables.index') => 403,
            route('consumables.create') => 403,
            route('consumables.edit', $this->consumableId) => 403,
            route('consumables.show', $this->consumableId) => 403,
        ];

        $this->componentId = factory(App\Models\Component::class)->create()->id;
        $this->noComponents = [
            route('components.index') => 403,
            route('components.create') => 403,
            route('components.edit', $this->componentId) => 403,
            route('components.show', $this->componentId) => 403,
        ];

        $this->userId = factory(App\Models\User::class)->create()->id;
        $this->noUsers = [
            route('users.index') => 403,
            route('users.create') => 403,
            route('users.edit', $this->userId) => 403,
            route('users.show', $this->userId) => 403,
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

    // An existing id for each type;
    private $hardwareId;
    private $licenseId;
    private $accessoryId;
    private $consumableId;
    private $componentId;
    private $userId;
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
            route('hardware.index') => 200,
            route('hardware.create') => 403,
            route('hardware.edit', $this->hardwareId) => 403,
            route('hardware.show', $this->hardwareId) => 200,
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
            route('hardware.index') => 403,
            route('hardware.create') => 200,
            route('hardware.edit', $this->hardwareId) => 403,
            route('hardware.show', $this->hardwareId) => 403,
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
            route('hardware.index') => 403,
            route('hardware.create') => 403,
            route('hardware.edit', $this->hardwareId) => 200,
            route('hardware.show', $this->hardwareId) => 403,
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
            route('licenses.index') => 200,
            route('licenses.create') => 403,
            route('licenses.edit', $this->licenseId) => 403,
            route('licenses.show', $this->licenseId) => 200,
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
            route('licenses.index') => 403,
            route('licenses.create') => 200,
            route('licenses.edit', $this->licenseId) => 403,
            route('licenses.show', $this->licenseId) => 403,
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
            route('licenses.index') => 403,
            route('licenses.create') => 403,
            route('licenses.edit', $this->licenseId) => 200,
            route('licenses.show', $this->licenseId) => 403,
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
            route('accessories.index') => 200,
            route('accessories.create') => 403,
            route('accessories.edit', $this->accessoryId) => 403,
            route('accessories.show', $this->accessoryId) => 200,
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
            route('accessories.index') => 403,
            route('accessories.create') => 200,
            route('accessories.edit', $this->accessoryId) => 403,
            route('accessories.show', $this->accessoryId) => 403,
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
            route('accessories.index') => 403,
            route('accessories.create') => 403,
            route('accessories.edit', $this->accessoryId) => 200,
            route('accessories.show', $this->accessoryId) => 403,
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
            route('consumables.index') => 200,
            route('consumables.create') => 403,
            route('consumables.edit', $this->consumableId) => 403,
            route('consumables.show', $this->consumableId) => 200,
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
            route('consumables.index') => 403,
            route('consumables.create') => 200,
            route('consumables.edit', $this->consumableId) => 403,
            route('consumables.show', $this->consumableId) => 403,
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
            route('consumables.index') => 403,
            route('consumables.create') => 403,
            route('consumables.edit', $this->consumableId) => 200,
            route('consumables.show', $this->consumableId) => 403,
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
            route('users.index') => 200,
            route('users.create') => 403,
            route('users.edit', $this->userId) => 403,
            route('users.show', $this->userId) => 200,
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
            route('users.index') => 403,
            route('users.create') => 200,
            route('users.edit', $this->userId) => 403,
            route('users.show', $this->userId) => 403,
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
            route('users.index') => 403,
            route('users.create') => 403,
            route('users.edit', $this->userId) => 200,
            route('users.show', $this->userId) => 403,
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
            route('components.index') => 200,
            route('components.create') => 403,
            route('components.edit', $this->componentId) => 403,
            route('components.show', $this->componentId) => 200,
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
            route('components.index') => 403,
            route('components.create') => 200,
            route('components.edit', $this->componentId) => 403,
            route('components.show', $this->componentId) => 403,
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
            route('components.index') => 403,
            route('components.create') => 403,
            route('components.edit', $this->componentId) => 200,
            route('components.show', $this->componentId) => 403,
        ]);
        $this->hitRoutes($permissions, $u);
    }

    private function hitRoutes(array $routes, User $user)
    {
        $this->actingAs($user);

        foreach ($routes as $route => $response) {
            $this->get($route)
                ->assertStatus($response);
        }
    }
}
