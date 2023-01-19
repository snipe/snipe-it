<?php
namespace Tests\Unit;

use App\Models\Accessory;
use App\Models\Asset;
use App\Models\Component;
use App\Models\Consumable;
use App\Models\License;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\Unit\BaseTest;

class PermissionsTest extends BaseTest
{
    // public function _before()
    // {
    //     parent::_before();
    //     $this->noHardware = [
    //         'assets.view' => false,
    //         'assets.create' => false,
    //         'assets.edit' => false,
    //         'assets.delete' => false,
    //     ];

    //     $this->noLicenses = [
    //         'licenses.view' => false,
    //         'licenses.create' => false,
    //         'licenses.edit' => false,
    //         'licenses.delete' => false,
    //     ];

    //     $this->noAccessories = [
    //         'accessories.view' => false,
    //         'accessories.create' => false,
    //         'accessories.edit' => false,
    //         'accessories.delete' => false,
    //     ];

    //     $this->noConsumables = [
    //         'consumables.view' => false,
    //         'consumables.create' => false,
    //         'consumables.edit' => false,
    //         'consumables.delete' => false,
    //     ];

    //     $this->noComponents = [
    //         'components.view' => false,
    //         'components.create' => false,
    //         'components.edit' => false,
    //         'components.delete' => false,
    //     ];

    //     $this->noUsers = [
    //         'users.view' => false,
    //         'users.create' => false,
    //         'users.edit' => false,
    //         'users.delete' => false,
    //     ];
    // }

    // private $noHardware;
    // private $noLicenses;
    // private $noAccessories;
    // private $noConsumables;
    // private $noComponents;
    // private $noUsers;

    // // tests

    // /**
    //  * @test
    //  */
    // public function a_user_with_no_permissions_sees_nothing()
    // {
    //     $u = \App\Models\User::factory()->create();
    //     $permissions = $this->noHardware + $this->noLicenses + $this->noAccessories + $this->noConsumables + $this->noComponents + $this->noUsers;
    //     // $permissions = $this->noHardware;
    //     $this->hitRoutes($permissions, $u);
    // }

    // /**
    //  * @test
    //  */
    // public function a_user_with_view_asset_permissions_can_view_assets()
    // {
    //     $u = \App\Models\User::factory()->viewAssets()->create();
    //     $permissions = $this->noLicenses + $this->noAccessories + $this->noConsumables + $this->noComponents + $this->noUsers;

    //     $permissions = array_merge($permissions, [
    //         'assets.view' => true,
    //         'assets.create' => false,
    //         'assets.edit' => false,
    //         'assets.delete' => false,
    //     ]);
    //     $this->hitRoutes($permissions, $u);
    // }

    // /**
    //  * @test
    //  */
    // public function a_user_with_create_asset_permissions_can_create_assets()
    // {
    //     $u = \App\Models\User::factory()->createAssets()->create();
    //     $permissions = $this->noLicenses + $this->noAccessories + $this->noConsumables + $this->noComponents + $this->noUsers;

    //     $permissions = array_merge($permissions, [
    //         'assets.view' => false,
    //         'assets.create' => true,
    //         'assets.edit' => false,
    //         'assets.delete' => false,
    //     ]);
    //     $this->hitRoutes($permissions, $u);
    // }

    // /**
    //  * @test
    //  */
    // public function a_user_with_edit_assets_permissions_can_edit_assets()
    // {
    //     $u = \App\Models\User::factory()->editAssets()->create();

    //     $permissions = $this->noLicenses + $this->noAccessories + $this->noConsumables + $this->noComponents + $this->noUsers;

    //     $permissions = array_merge($permissions, [
    //         'assets.view' => false,
    //         'assets.create' => false,
    //         'assets.edit' => true,
    //         'assets.delete' => false,
    //     ]);
    //     $this->hitRoutes($permissions, $u);
    // }

    // /**
    //  * @test
    //  */
    // public function a_user_with_delete_assets_permissions_can_delete_assets()
    // {
    //     $u = \App\Models\User::factory()->deleteAssets()->create();
    //     $permissions = $this->noLicenses + $this->noAccessories + $this->noConsumables + $this->noComponents + $this->noUsers;
    //     $permissions = array_merge($permissions, [
    //         'assets.view' => false,
    //         'assets.create' => false,
    //         'assets.edit' => false,
    //         'assets.delete' => true,
    //     ]);
    //     $this->hitRoutes($permissions, $u);
    // }

    // /**
    //  * @test
    //  */
    // public function a_user_with_view_licenses_permissions_can_view_licenses()
    // {
    //     $u = \App\Models\User::factory()->viewLicenses()->create();
    //     $permissions = $this->noHardware + $this->noAccessories + $this->noConsumables + $this->noComponents + $this->noUsers;

    //     $permissions = array_merge($permissions, [
    //         'licenses.view' => true,
    //         'licenses.create' => false,
    //         'licenses.edit' => false,
    //         'licenses.delete' => false,
    //     ]);
    //     $this->hitRoutes($permissions, $u);
    // }

    // /**
    //  * @test
    //  */
    // public function a_user_with_create_licenses_permissions_can_create_licenses()
    // {
    //     $u = \App\Models\User::factory()->createLicenses()->create();
    //     $permissions = $this->noHardware + $this->noAccessories + $this->noConsumables + $this->noComponents + $this->noUsers;

    //     $permissions = array_merge($permissions, [
    //         'licenses.view' => false,
    //         'licenses.create' => true,
    //         'licenses.edit' => false,
    //         'licenses.delete' => false,
    //     ]);
    //     $this->hitRoutes($permissions, $u);
    // }

    // /**
    //  * @test
    //  */
    // public function a_user_with_edit_licenses_permissions_can_edit_licenses()
    // {
    //     $u = \App\Models\User::factory()->editLicenses()->create();
    //     $permissions = $this->noHardware + $this->noAccessories + $this->noConsumables + $this->noComponents + $this->noUsers;

    //     $permissions = array_merge($permissions, [
    //         'licenses.view' => false,
    //         'licenses.create' => false,
    //         'licenses.edit' => true,
    //         'licenses.delete' => false,
    //     ]);
    //     $this->hitRoutes($permissions, $u);
    // }

    // /**
    //  * @test
    //  */
    // public function a_user_with_delete_licenses_permissions_can_delete_licenses()
    // {
    //     $u = \App\Models\User::factory()->deleteLicenses()->create();
    //     $permissions = $this->noHardware + $this->noAccessories + $this->noConsumables + $this->noComponents + $this->noUsers;

    //     $permissions = array_merge($permissions, [
    //         'licenses.view' => false,
    //         'licenses.create' => false,
    //         'licenses.edit' => false,
    //         'licenses.delete' => true,
    //     ]);
    //     $this->hitRoutes($permissions, $u);
    // }

    // /**
    //  * @test
    //  */
    // public function a_user_with_view_accessories_permissions_can_view_accessories()
    // {
    //     $u = \App\Models\User::factory()->viewAccessories()->create();

    //     $permissions = $this->noHardware + $this->noLicenses + $this->noConsumables + $this->noComponents + $this->noUsers;

    //     $permissions = array_merge($permissions, [
    //         'accessories.view' => true,
    //         'accessories.create' => false,
    //         'accessories.edit' => false,
    //         'accessories.delete' => false,
    //     ]);
    //     $this->hitRoutes($permissions, $u);
    // }

    // /**
    //  * @test
    //  */
    // public function a_user_with_create_accessories_permissions_can_create_accessories()
    // {
    //     $u = \App\Models\User::factory()->createAccessories()->create();

    //     $permissions = $this->noHardware + $this->noLicenses + $this->noConsumables + $this->noComponents + $this->noUsers;

    //     $permissions = array_merge($permissions, [
    //         'accessories.view' => false,
    //         'accessories.create' => true,
    //         'accessories.edit' => false,
    //         'accessories.delete' => false,
    //     ]);
    //     $this->hitRoutes($permissions, $u);
    // }

    // /**
    //  * @test
    //  */
    // public function a_user_with_edit_accessories_permissions_can_edit_accessories()
    // {
    //     $u = \App\Models\User::factory()->editAccessories()->create();

    //     $permissions = $this->noHardware + $this->noLicenses + $this->noConsumables + $this->noComponents + $this->noUsers;

    //     $permissions = array_merge($permissions, [
    //         'accessories.view' => false,
    //         'accessories.create' => false,
    //         'accessories.edit' => true,
    //         'accessories.delete' => false,
    //     ]);
    //     $this->hitRoutes($permissions, $u);
    // }

    // /**
    //  * @test
    //  */
    // public function a_user_with_delete_accessories_permissions_can_delete_accessories()
    // {
    //     $u = \App\Models\User::factory()->deleteAccessories()->create();

    //     $permissions = $this->noHardware + $this->noLicenses + $this->noConsumables + $this->noComponents + $this->noUsers;

    //     $permissions = array_merge($permissions, [
    //         'accessories.view' => false,
    //         'accessories.create' => false,
    //         'accessories.edit' => false,
    //         'accessories.delete' => true,
    //     ]);
    //     $this->hitRoutes($permissions, $u);
    // }

    // /**
    //  * @test
    //  */
    // public function a_user_with_view_consumables_permissions_can_view_consumables()
    // {
    //     $u = \App\Models\User::factory()->viewConsumables()->create();

    //     $permissions = $this->noHardware + $this->noLicenses + $this->noAccessories + $this->noComponents + $this->noUsers;

    //     $permissions = array_merge($permissions, [
    //         'consumables.view' => true,
    //         'consumables.create' => false,
    //         'consumables.edit' => false,
    //         'consumables.delete' => false,
    //     ]);
    //     $this->hitRoutes($permissions, $u);
    // }

    // /**
    //  * @test
    //  */
    // public function a_user_with_create_consumables_permissions_can_create_consumables()
    // {
    //     $u = \App\Models\User::factory()->createConsumables()->create();

    //     $permissions = $this->noHardware + $this->noLicenses + $this->noConsumables + $this->noComponents + $this->noUsers;

    //     $permissions = array_merge($permissions, [
    //         'consumables.view' => false,
    //         'consumables.create' => true,
    //         'consumables.edit' => false,
    //         'consumables.delete' => false,
    //     ]);
    //     $this->hitRoutes($permissions, $u);
    // }

    // /**
    //  * @test
    //  */
    // public function a_user_with_edit_consumables_permissions_can_edit_consumables()
    // {
    //     $u = \App\Models\User::factory()->editConsumables()->create();

    //     $permissions = $this->noHardware + $this->noLicenses + $this->noAccessories + $this->noComponents + $this->noUsers;

    //     $permissions = array_merge($permissions, [
    //         'consumables.view' => false,
    //         'consumables.create' => false,
    //         'consumables.edit' => true,
    //         'consumables.delete' => false,
    //     ]);
    //     $this->hitRoutes($permissions, $u);
    // }

    // /**
    //  * @test
    //  */
    // public function a_user_with_delete_consumables_permissions_can_delete_consumables()
    // {
    //     $u = \App\Models\User::factory()->deleteConsumables()->create();

    //     $permissions = $this->noHardware + $this->noLicenses + $this->noAccessories + $this->noComponents + $this->noUsers;

    //     $permissions = array_merge($permissions, [
    //         'consumables.view' => false,
    //         'consumables.create' => false,
    //         'consumables.edit' => false,
    //         'consumables.delete' => true,
    //     ]);
    //     $this->hitRoutes($permissions, $u);
    // }

    // /**
    //  * @test
    //  */
    // public function a_user_with_view_users_permissions_can_view_users()
    // {
    //     $u = \App\Models\User::factory()->viewUsers()->create();

    //     $permissions = $this->noHardware + $this->noLicenses + $this->noAccessories + $this->noConsumables + $this->noComponents;

    //     $permissions = array_merge($permissions, [
    //         'users.view' => true,
    //         'users.create' => false,
    //         'users.edit' => false,
    //         'users.delete' => false,
    //     ]);
    //     $this->hitRoutes($permissions, $u);
    // }

    // /**
    //  * @test
    //  */
    // public function a_user_with_create_users_permissions_can_create_users()
    // {
    //     $u = \App\Models\User::factory()->createUsers()->create();

    //     $permissions = $this->noHardware + $this->noLicenses + $this->noAccessories + $this->noConsumables + $this->noComponents;

    //     $permissions = array_merge($permissions, [
    //         'users.view' => false,
    //         'users.create' => true,
    //         'users.edit' => false,
    //         'users.delete' => false,
    //     ]);
    //     $this->hitRoutes($permissions, $u);
    // }

    // /**
    //  * @test
    //  */
    // public function a_user_with_edit_users_permissions_can_edit_users()
    // {
    //     $u = \App\Models\User::factory()->editUsers()->create();

    //     $permissions = $this->noHardware + $this->noLicenses + $this->noAccessories + $this->noConsumables + $this->noComponents;

    //     $permissions = array_merge($permissions, [
    //         'users.view' => false,
    //         'users.create' => false,
    //         'users.edit' => true,
    //         'users.delete' => false,
    //     ]);
    //     $this->hitRoutes($permissions, $u);
    // }

    // /**
    //  * @test
    //  */
    // public function a_user_with_delete_users_permissions_can_delete_users()
    // {
    //     $u = \App\Models\User::factory()->deleteUsers()->create();

    //     $permissions = $this->noHardware + $this->noLicenses + $this->noAccessories + $this->noConsumables + $this->noComponents;

    //     $permissions = array_merge($permissions, [
    //         'users.view' => false,
    //         'users.create' => false,
    //         'users.edit' => false,
    //         'users.delete' => true,
    //     ]);
    //     $this->hitRoutes($permissions, $u);
    // }

    // /**
    //  * @test
    //  */
    // public function a_user_with_view_components_permissions_can_view_components()
    // {
    //     $u = \App\Models\User::factory()->viewComponents()->create();

    //     $permissions = $this->noHardware + $this->noLicenses + $this->noAccessories + $this->noConsumables + $this->noUsers;

    //     $permissions = array_merge($permissions, [
    //         'components.view' => true,
    //         'components.create' => false,
    //         'components.edit' => false,
    //         'components.delete' => false,
    //     ]);
    //     $this->hitRoutes($permissions, $u);
    // }

    // /**
    //  * @test
    //  */
    // public function a_user_with_create_components_permissions_can_create_components()
    // {
    //     $u = \App\Models\User::factory()->createComponents()->create();
    //     $permissions = $this->noHardware + $this->noLicenses + $this->noAccessories + $this->noConsumables + $this->noUsers;

    //     $permissions = array_merge($permissions, [
    //         'components.view' => false,
    //         'components.create' => true,
    //         'components.edit' => false,
    //         'components.delete' => false,
    //     ]);
    //     $this->hitRoutes($permissions, $u);
    // }

    // /**
    //  * @test
    //  */
    // public function a_user_with_edit_components_permissions_can_edit_components()
    // {
    //     $u = \App\Models\User::factory()->editComponents()->create();

    //     $permissions = $this->noHardware + $this->noLicenses + $this->noAccessories + $this->noConsumables + $this->noUsers;

    //     $permissions = array_merge($permissions, [
    //         'components.view' => false,
    //         'components.create' => false,
    //         'components.edit' => true,
    //         'components.delete' => false,
    //     ]);
    //     $this->hitRoutes($permissions, $u);
    // }

    // /**
    //  * @test
    //  */
    // public function a_user_with_delete_components_permissions_can_delete_components()
    // {
    //     $u = \App\Models\User::factory()->deleteComponents()->create();

    //     $permissions = $this->noHardware + $this->noLicenses + $this->noAccessories + $this->noConsumables + $this->noUsers;

    //     $permissions = array_merge($permissions, [
    //         'components.view' => false,
    //         'components.create' => false,
    //         'components.edit' => false,
    //         'components.delete' => true,
    //     ]);
    //     // dd($u);
    //     $this->hitRoutes($permissions, $u);
    // }

    // private function hitRoutes(array $routes, User $user)
    // {
    //     foreach ($routes as $route => $expectation) {
    //         $this->assertEquals($user->hasAccess($route), $expectation);
    //     }
    // }
}
