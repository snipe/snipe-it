<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\AssetModel;
use App\Models\Category;
use App\Models\Company;
use App\Models\Labels\Label;
use App\Models\Manufacturer;
use App\Models\Setting;
use App\Models\User;
use App\View\Label as LabelView;
use Illuminate\Support\Facades\Storage;

class LabelsController extends Controller
{
    /**
     * Returns the Label view with test data
     *
     * @author Grant Le Roux <grant.leroux+snipe-it@gmail.com>
     * @param  string  $labelName
     * @return \Illuminate\Contracts\View\View
     */
    public function show(string $labelName)
    {
        $labelName = str_replace('/', '\\', $labelName);
        $template = Label::find($labelName);

        $exampleAsset = new Asset();

        $exampleAsset->id = 999999;
        $exampleAsset->name = 'JEN-867-5309';
        $exampleAsset->asset_tag = '100001';
        $exampleAsset->serial = 'SN9876543210';

        $exampleAsset->company = new Company();
        $exampleAsset->company->id = 999999;
        $exampleAsset->company->name = 'Test Company Limited';
        $exampleAsset->company->image = 'company-image-test.png';

        $exampleAsset->assignedto = new User();
        $exampleAsset->assignedto->id = 999999;
        $exampleAsset->assignedto->first_name = 'Test';
        $exampleAsset->assignedto->last_name = 'Person';
        $exampleAsset->assignedto->username = 'Test.Person';
        $exampleAsset->assignedto->employee_num = '0123456789';

        $exampleAsset->model = new AssetModel();
        $exampleAsset->model->id = 999999;
        $exampleAsset->model->name = 'Test Model';
        $exampleAsset->model->model_number = 'MDL5678';
        $exampleAsset->model->manufacturer = new Manufacturer();
        $exampleAsset->model->manufacturer->id = 999999;
        $exampleAsset->model->manufacturer->name = 'Test Manufacturing Inc.';
        $exampleAsset->model->category = new Category();
        $exampleAsset->model->category->id = 999999;
        $exampleAsset->model->category->name = 'Test Category';

        $settings = Setting::getSettings();
        if (request()->has('settings')) {
            $overrides = request()->get('settings');
            foreach ($overrides as $key => $value) {
                $settings->$key = $value;
            }
        }

        return (new LabelView())
            ->with('assets', collect([$exampleAsset]))
            ->with('settings', $settings)
            ->with('template', $template)
            ->with('bulkedit', false)
            ->with('count', 0);

        return redirect()->route('home')->with('error', trans('admin/labels/message.does_not_exist'));
    }
}
