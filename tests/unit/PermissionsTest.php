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
    }

    public function tearDown()
    {
    }

    // tests
    /**
     * @test
     */
    public function a_user_with_no_permissions_sees_nothing()
    {
        $u = factory(App\Models\User::class, 'valid-user')->create();
        $permissions = [
            'hardware.index' => 403,
            'hardware.create' => 403,
            'hardware.edit' => 403,
            'hardware.show' => 403,
            'hardware.destroy' => 403,
            'accessories.index' => 403,
            'accessories.create' => 403,
            'accessories.edit' => 403,
            'accessories.show' => 403,
            'accessories.destroy' => 403,
            'consumables.index' => 403,
            'consumables.create' => 403,
            'consumables.edit' => 403,
            'consumables.show' => 403,
            'consumables.destroy' => 403,
        ];
        $this->hitRoutes($permissions, $u);

    }

    // /**
    //  * @test
    //  */
    public function a_user_with_view_asset_permissions_can_view_assets()
    {
        $u = factory(App\Models\User::class, 'valid-user')->states('view-assets')->create();
        var_dump("here");
        $permissions = [
            'hardware.index' => 200,
            'hardware.create' => 403,
            'hardware.edit' => 403,
            'hardware.show' => 200,
            'accessories.index' => 403,
            'accessories.create' => 403,
            'accessories.edit' => 403,
            'accessories.show' => 403,
            'consumables.index' => 403,
            'consumables.create' => 403,
            'consumables.edit' => 403,
            'consumables.show' => 403,
        ];
        $this->hitRoutes($permissions, $u);
    }

    /**
     * @test
     */
    public function a_user_with_create_asset_permissions_can_create_assets()
    {
        $u = factory(App\Models\User::class, 'valid-user')->states('create-assets')->create();
        $permissions = [
            'hardware.index' => 200,
            'hardware.create' => 200,
            'hardware.edit' => 403,
            'hardware.show' => 200,
            'accessories.index' => 403,
            'accessories.create' => 403,
            'accessories.edit' => 403,
            'accessories.show' => 403,
            'consumables.index' => 403,
            'consumables.create' => 403,
            'consumables.edit' => 403,
            'consumables.show' => 403,
        ];
        $this->hitRoutes($permissions, $u);
    }

    /**
     * @test
     */
    public function a_user_with_edit_assets_permissions_can_edit_assets()
    {
        $u = factory(App\Models\User::class, 'valid-user')->states('edit-assets')->create();

        $permissions = [
            'hardware.index' => 200,
            'hardware.create' => 403,
            'hardware.edit' => 200,
            'hardware.show' => 200,
            'accessories.index' => 403,
            'accessories.create' => 403,
            'accessories.edit' => 403,
            'accessories.show' => 403,
            'consumables.index' => 403,
            'consumables.create' => 403,
            'consumables.edit' => 403,
            'consumables.show' => 403,
        ];
        $this->hitRoutes($permissions, $u);
    }

    /**
     * @test
    */
    public function a_user_with_view_accessories_permissions_can_view_accessories()
    {
        $u = factory(App\Models\User::class, 'valid-user')->states('view-accessories')->create();

        $permissions = [
            'hardware.index' => 403,
            'hardware.create' => 403,
            'hardware.edit' => 403,
            'hardware.show' => 403,
            'accessories.index' => 200,
            'accessories.create' => 403,
            'accessories.edit' => 403,
            'accessories.show' => 200,
            'consumables.index' => 403,
            'consumables.create' => 403,
            'consumables.edit' => 403,
            'consumables.show' => 403,
        ];
        $this->hitRoutes($permissions, $u);
    }

    /**
     * @test
     */
    public function a_user_with_create_accessories_permissions_can_create_accessories()
    {
        $u = factory(App\Models\User::class, 'valid-user')->states('create-accessories')->create();

        $permissions = [
            'hardware.index' => 403,
            'hardware.create' => 403,
            'hardware.edit' => 403,
            'hardware.show' => 403,
            'accessories.index' => 200,
            'accessories.create' => 200,
            'accessories.edit' => 403,
            'accessories.show' => 200,
            'consumables.index' => 403,
            'consumables.create' => 403,
            'consumables.edit' => 403,
            'consumables.show' => 403,
        ];
        $this->hitRoutes($permissions, $u);
    }

    /**
     * @test
     */
    public function a_user_with_edit_accessories_permissions_can_edit_accessories()
    {
        $u = factory(App\Models\User::class, 'valid-user')->states('edit-accessories')->create();

        $permissions = [
            'hardware.index' => 403,
            'hardware.create' => 403,
            'hardware.edit' => 403,
            'hardware.show' => 403,
            'accessories.index' => 200,
            'accessories.create' => 403,
            'accessories.edit' => 200,
            'accessories.show' => 200,
            'consumables.index' => 403,
            'consumables.create' => 403,
            'consumables.edit' => 403,
            'consumables.show' => 403,
        ];
        $this->hitRoutes($permissions, $u);
    }

    /**
     * @test
     */
    public function a_user_with_view_consumables_permissions_can_view_consumables()
    {
        $u = factory(App\Models\User::class, 'valid-user')->states('view-consumables')->create();

        $permissions = [
            'hardware.index' => 403,
            'hardware.create' => 403,
            'hardware.edit' => 403,
            'hardware.show' => 403,
            'accessories.index' => 403,
            'accessories.create' => 403,
            'accessories.edit' => 403,
            'accessories.show' => 403,
            'consumables.index' => 200,
            'consumables.create' => 403,
            'consumables.edit' => 403,
            'consumables.show' => 200,
        ];
        $this->hitRoutes($permissions, $u);
    }

    /**
     * @test
     */
    public function a_user_with_create_consumables_permissions_can_create_consumables()
    {
        $u = factory(App\Models\User::class, 'valid-user')->states('create-consumables')->create();

        $permissions = [
            'hardware.index' => 403,
            'hardware.create' => 403,
            'hardware.edit' => 403,
            'hardware.show' => 403,
            'accessories.index' => 403,
            'accessories.create' => 403,
            'accessories.edit' => 403,
            'accessories.show' => 403,
            'consumables.index' => 200,
            'consumables.create' => 200,
            'consumables.edit' => 403,
            'consumables.show' => 200,
        ];
        $this->hitRoutes($permissions, $u);
    }

    /**
     * @test
     */
    public function a_user_with_edit_consumables_permissions_can_edit_consumables()
    {
        $u = factory(App\Models\User::class, 'valid-user')->states('edit-consumables')->create();

        $permissions = [
            'hardware.index' => 403,
            'hardware.create' => 403,
            'hardware.edit' => 403,
            'hardware.show' => 403,
            'accessories.index' => 403,
            'accessories.create' => 403,
            'accessories.edit' => 403,
            'accessories.show' => 403,
            'consumables.index' => 200,
            'consumables.create' => 403,
            'consumables.edit' => 200,
            'consumables.show' => 200,
        ];
        $this->hitRoutes($permissions, $u);
    }

    private function hitRoutes(array $routes, User $user)
    {
        $this->actingAs($user);
        foreach ($routes as $route => $response) {
            // $this->log($route);
            echo $route;
            if (strpos($route, 'edit') || strpos($route, 'show') || strpos($route, 'destroy')) {
                $this->get(route($route, 1))
                    ->assertResponseStatus($response);
            } else {
                $this->get(route($route))
                    ->assertResponseStatus($response);
            }
        }
    }

}
