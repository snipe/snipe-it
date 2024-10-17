<?php

namespace Tests\Feature\Accessories\Ui;

use App\Models\Accessory;
use App\Models\Category;
use App\Models\Company;
use App\Models\User;
use Generator;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Group;
use Tests\TestCase;

class CreateAccessoryWithFullMultipleCompanySupportTest extends TestCase
{
    public static function userProvider(): Generator
    {
        yield "User in a company should result in user's company_id being used" => [
            function () {
                $jedi = Company::factory()->create();
                $sith = Company::factory()->create();
                $luke = User::factory()->for($jedi)->createAccessories()->create();

                return [
                    'actor' => $luke,
                    'company_attempting_to_associate' => $sith,
                    'assertions' => function ($accessory) use ($jedi) {
                        self::assertEquals($jedi->id, $accessory->company_id);
                    },
                ];
            }
        ];

        yield "User without a company should result in accessory's company_id being null" => [
            function () {
                $userInNoCompany = User::factory()->createAccessories()->create(['company_id' => null]);

                return [
                    'actor' => $userInNoCompany,
                    'company_attempting_to_associate' => Company::factory()->create(),
                    'assertions' => function ($accessory) {
                        self::assertNull($accessory->company_id);
                    },
                ];
            }
        ];

        yield "Super-User assigning across companies should result in accessory's company_id being set to what was provided" => [
            function () {
                $superUser = User::factory()->superuser()->create(['company_id' => null]);
                $company = Company::factory()->create();

                return [
                    'actor' => $superUser,
                    'company_attempting_to_associate' => $company,
                    'assertions' => function ($accessory) use ($company) {
                        self::assertEquals($accessory->company_id, $company->id);
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
            ->post(route('accessories.store'), [
                'redirect_option' => 'index',
                'name' => 'My Cool Accessory',
                'qty' => '1',
                'category_id' => Category::factory()->create()->id,
                'company_id' => $company->id,
            ]);

        $accessory = Accessory::withoutGlobalScopes()->where([
            'name' => 'My Cool Accessory',
        ])->sole();

        $assertions($accessory);
    }
}
