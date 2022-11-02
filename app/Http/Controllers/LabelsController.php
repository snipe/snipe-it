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
        $this->authorize('view', Label::class);

        $labelName = str_replace('/', '\\', $labelName);
        $template = Label::find($labelName);

        $this->authorize('view', $template);

        $testAsset = new Asset();

        $testAsset->id = 999999;
        $testAsset->name = 'AST-AB-CD-1234';
        $testAsset->asset_tag = 'TCA-00001';
        $testAsset->serial = 'SN9876543210';

        $testAsset->company = new Company();
        $testAsset->company->id = 999999;
        $testAsset->company->name = 'Test Company Limited';
        $testAsset->company->image = 'company-image-test.png';

        $testAsset->assignedto = new User();
        $testAsset->assignedto->id = 999999;
        $testAsset->assignedto->first_name = 'Test';
        $testAsset->assignedto->last_name = 'Person';
        $testAsset->assignedto->username = 'Test.Person';
        $testAsset->assignedto->employee_num = '0123456789';

        $testAsset->model = new AssetModel();
        $testAsset->model->id = 999999;
        $testAsset->model->name = 'Test Model';
        $testAsset->model->model_number = 'MDL5678';
        $testAsset->model->manufacturer = new Manufacturer();
        $testAsset->model->manufacturer->id = 999999;
        $testAsset->model->manufacturer->name = 'Test Manufacturing Inc.';
        $testAsset->model->category = new Category();
        $testAsset->model->category->id = 999999;
        $testAsset->model->category->name = 'Test Category';

        return (new LabelView())
            ->with('assets', collect([$testAsset]))
            ->with('settings', Setting::getSettings())
            ->with('template', $template)
            ->with('bulkedit', false)
            ->with('count', 0);

        return redirect()->route('home')->with('error', trans('admin/labels/message.does_not_exist'));
    }
}
