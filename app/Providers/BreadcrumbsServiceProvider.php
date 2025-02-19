<?php namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Tabuna\Breadcrumbs\Breadcrumbs;
use App\Models\Asset;
use Tabuna\Breadcrumbs\Trail;

class BreadcrumbsServiceProvider extends ServiceProvider
{
/**
* Bootstrap any application services.
*
* @return void
*/
    public function boot()
    {

        Breadcrumbs::for('home', fn (Trail $trail) =>
        $trail->push('Home', route('home'))
        );

        Breadcrumbs::for('hardware.index', fn (Trail $trail) =>
            $trail->parent('home', route('home'))
                ->push(trans('general.assets'), route('hardware.index'))
        );

        Breadcrumbs::for('hardware.create', fn (Trail $trail) =>
        $trail->parent('hardware.index', route('hardware.index'))
        ->push(trans('general.create'), route('home'))
        );

        Breadcrumbs::for('hardware.show', fn (Trail $trail, Asset $asset) =>
        $trail->parent('hardware.index', route('hardware.index'))
            ->push($asset->asset_tag, route('home'))
        );
    }
}