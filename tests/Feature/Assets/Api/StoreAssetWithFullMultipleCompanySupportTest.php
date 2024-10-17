<?php

namespace Tests\Feature\Assets\Api;

use App\Models\Asset;
use App\Models\AssetModel;
use App\Models\Company;
use App\Models\Statuslabel;
use App\Models\User;
use Generator;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Group;
use Tests\TestCase;

class StoreAssetWithFullMultipleCompanySupportTest extends TestCase
{
    public static function userProvider(): Generator
    {
        yield "User in a company should result in user's company_id being used" => [
            function () {
                $jedi = Company::factory()->create();
                $sith = Company::factory()->create();
                $luke = User::factory()->for($jedi)->createAssets()->create();

                return [
                    'actor' => $luke,
                    'company_attempting_to_associate' => $sith,
                    'assertions' => function ($asset) use ($jedi) {
                        self::assertEquals($jedi->id, $asset->company_id);
                    },
                ];
            }
        ];

        yield "User without a company should result in asset's company_id being null" => [
            function () {
                $userInNoCompany = User::factory()->createAssets()->create(['company_id' => null]);

                return [
                    'actor' => $userInNoCompany,
                    'company_attempting_to_associate' => Company::factory()->create(),
                    'assertions' => function ($asset) {
                        self::assertNull($asset->company_id);
                    },
                ];
            }
        ];

        yield "Super-User assigning across companies should result in asset's company_id being set to what was provided" => [
            function () {
                $superUser = User::factory()->superuser()->create(['company_id' => null]);
                $company = Company::factory()->create();

                return [
                    'actor' => $superUser,
                    'company_attempting_to_associate' => $company,
                    'assertions' => function ($asset) use ($company) {
                        self::assertEquals($asset->company_id, $company->id);
                    },
                ];
            }
        ];
    }

    /**
     * @link https://github.com/snipe/snipe-it/issues/15654
     */
    #[Group('focus')]
    #[DataProvider('userProvider')]
    public function testAdheresToFullMultipleCompaniesSupportScoping($data)
    {
        ['actor' => $actor, 'company_attempting_to_associate' => $company, 'assertions' => $assertions] = $data();

        $this->settings->enableMultipleFullCompanySupport();

        $response = $this->actingAsForApi($actor)
            ->postJson(route('api.assets.store'), [
                'asset_tag' => 'random_string',
                'company_id' => $company->id,
                'model_id' => AssetModel::factory()->create()->id,
                'status_id' => Statuslabel::factory()->readyToDeploy()->create()->id,
            ]);

        $asset = Asset::withoutGlobalScopes()->findOrFail($response['payload']['id']);

        $assertions($asset);
    }
}
