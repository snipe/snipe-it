<?php

namespace Tests\Unit\Presenters;

use App\Models\Accessory;
use App\Models\Asset;
use App\Models\AssetModel;
use App\Models\Category;
use App\Models\Company;
use App\Models\Component;
use App\Models\Consumable;
use App\Models\CustomFieldset;
use App\Models\Department;
use App\Models\Depreciation;
use App\Models\License;
use App\Models\Location;
use App\Models\Manufacturer;
use App\Models\PredefinedKit;
use App\Models\Supplier;
use App\Models\User;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

/**
 * Sweep test that locks in HTML-escaping of user-controlled model attributes
 * across every presenter that renders a name/display_name into an HTML sink.
 *
 * The motivating bug (FD-56438, fixed in 36d472489c) was a stored XSS where
 * DepartmentPresenter::formattedNameLink()'s fallback branch (rendered for
 * users without departments.view) returned the department name unescaped.
 * The shape "permission-gated branch selection where only one branch
 * escapes" is easy to miss in review, so this test exercises both branches
 * of every listed presenter method with a script-tag payload and asserts
 * the raw payload never appears in the output.
 *
 * Adding a new presenter method that emits a user-controlled string into
 * HTML? Add it to the cases below so a future refactor cannot silently
 * drop an e(...) call.
 */
class PresenterEscapingTest extends TestCase
{
    private const PAYLOAD = '<script>alert(1)</script>';

    private const EXPECTED_ESCAPED = '&lt;script&gt;alert(1)&lt;/script&gt;';

    /**
     * @return array<string, array{class-string, array<string, mixed>, list<string>}>
     */
    public static function presenterCases(): array
    {
        return [
            // Simple name-based presenters.
            'Accessory::nameUrl' => [Accessory::class, ['name' => self::PAYLOAD], ['nameUrl']],
            'AssetModel' => [AssetModel::class, ['name' => self::PAYLOAD], ['nameUrl', 'formattedNameLink']],
            'Asset' => [Asset::class, ['name' => self::PAYLOAD], ['nameUrl', 'formattedNameLink']],
            'Category' => [Category::class, ['name' => self::PAYLOAD], ['nameUrl', 'formattedNameLink']],
            'Company' => [Company::class, ['name' => self::PAYLOAD], ['nameUrl', 'formattedNameLink']],
            'Component::nameUrl' => [Component::class, ['name' => self::PAYLOAD], ['nameUrl']],
            'Consumable::nameUrl' => [Consumable::class, ['name' => self::PAYLOAD], ['nameUrl']],
            'CustomFieldset::nameUrl' => [CustomFieldset::class, ['name' => self::PAYLOAD], ['nameUrl']],
            'Department' => [Department::class, ['name' => self::PAYLOAD], ['nameUrl', 'formattedNameLink', 'viewUrl']],
            'Depreciation' => [Depreciation::class, ['name' => self::PAYLOAD], ['nameUrl', 'formattedNameLink']],
            'License::nameUrl' => [License::class, ['name' => self::PAYLOAD], ['nameUrl']],
            'Location' => [Location::class, ['name' => self::PAYLOAD], ['nameUrl', 'formattedNameLink']],
            'Manufacturer' => [Manufacturer::class, ['name' => self::PAYLOAD], ['nameUrl', 'formattedNameLink']],
            'PredefinedKit::nameUrl' => [PredefinedKit::class, ['name' => self::PAYLOAD], ['nameUrl']],
            'Supplier' => [Supplier::class, ['name' => self::PAYLOAD], ['nameUrl', 'formattedNameLink', 'viewUrl']],

            // User composes display_name from first_name + last_name, so plant
            // the payload in first_name (last_name kept plain).
            'User' => [User::class, ['first_name' => self::PAYLOAD, 'last_name' => 'X'], ['nameUrl', 'formattedNameLink']],
        ];
    }

    /**
     * Both branches must escape: the fallback (viewer lacks the resource's
     * view ability) AND the can-view branch (viewer has it, tested via
     * superuser which bypasses every ability check).
     */
    #[DataProvider('presenterCases')]
    public function test_presenter_methods_escape_user_input(string $modelClass, array $attributes, array $methods): void
    {
        $item = $modelClass::factory()->create($attributes);

        // Fallback branch: authenticate as a permissionless user.
        $this->actingAs(User::factory()->create());
        $this->assertMethodsEscape($item, $methods, 'fallback branch (viewer lacks resource view ability)');

        // Can-view branch: authenticate as a superuser to bypass every gate.
        $this->actingAs(User::factory()->superuser()->create());
        $this->assertMethodsEscape($item, $methods, 'can-view branch');
    }

    private function assertMethodsEscape(object $item, array $methods, string $branchLabel): void
    {
        foreach ($methods as $method) {
            $output = $item->present()->{$method}();

            $this->assertIsString($output, "{$branchLabel}: {$method} should return a string");
            $this->assertStringContainsString(
                self::EXPECTED_ESCAPED,
                $output,
                "{$branchLabel}: {$method} did not emit the HTML-escaped payload"
            );
            $this->assertStringNotContainsString(
                self::PAYLOAD,
                $output,
                "{$branchLabel}: {$method} emitted the raw payload unescaped"
            );
        }
    }
}
