<?php

namespace Tests\Feature\Assets\Ui;

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

    #[Group('focus')]
    #[DataProvider('userProvider')]
    public function testAdheresToFullMultipleCompaniesSupportScoping($data)
    {
        ['actor' => $actor, 'company_attempting_to_associate' => $company, 'assertions' => $assertions] = $data();

        $this->settings->enableMultipleFullCompanySupport();

        $this->actingAs($actor)
            ->post(route('hardware.store'), [
                'asset_tags' => ['1' => '1234'],
                'model_id' => AssetModel::factory()->create()->id,
                'status_id' => Statuslabel::factory()->create()->id,
                'company_id' => $company->id,
            ]);

        $asset = Asset::where('asset_tag', '1234')->sole();

        $assertions($asset);
    }
}
