<?php

namespace App\View;

use App\Models\Labels\Label as LabelModel;
use App\Models\Labels\Sheet;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Traits\Macroable;
use TCPDF;

class Label implements View
{
    use Macroable { __call as macroCall; }

    protected const NAME = 'label';

    /**
     * A Collection of passed data.
     *
     * @var Collection
     */
    protected $data;

    public function __construct() {
        $this->data = new Collection();
    }

    /**
     * Render the PDF label.
     *
     * @param  callable|null  $callback
     */
    public function render(callable $callback = null)
    {
        $settings = $this->data->get('settings');
        $assets = $this->data->get('assets');
        $offset = $this->data->get('offset');
        $template = $this->data->get('template');
        
        // If disabled, pass to legacy view
        if ((!$settings->label2_enable) && (!$template)) {
            return view('hardware/labels')
                ->with('assets', $assets)
                ->with('settings', $settings)
                ->with('bulkedit', $this->data->get('bulkedit'))
                ->with('count', $this->data->get('count'));
        }

        if (empty($template)) $template = LabelModel::find($settings->label2_template);
        elseif (is_string($template)) $template = LabelModel::find($template);

        $template->validate();

        $pdf = new TCPDF(
            $template->getOrientation(),
            $template->getUnit(),
            [ $template->getWidth(), $template->getHeight() ]
        );

        // Reset parameters
        $pdf->SetPrintHeader(false);
        $pdf->SetPrintFooter(false);
        $pdf->SetAutoPageBreak(false);
        $pdf->SetMargins(0, 0, null, true);
        $pdf->SetCellMargins(0, 0, 0, 0);
        $pdf->SetCellPaddings(0, 0, 0, 0);
        $pdf->setCreator('Snipe-IT');
        $pdf->SetSubject('Asset Labels');
        $template->preparePDF($pdf);

        // 'Label1=field1|Alt1=altfield1;Label2=field2;Alt1=altfield1|Label3=field3'
        $fieldDefinitions = (new Collection())
            ->merge(explode(';', $settings->label2_fields))
            ->filter(function ($defString) {
                return strpos($defString, '=') !== false;
            })
            ->map(function ($defString) {
                return (new Collection())
                    ->merge(explode('|', $defString)) // ['Label1=field1', 'Alt1=altfield1']
                    ->mapWithKeys(function ($altString) {
                        $parts = explode('=', $altString);
                        if (count($parts) != 2) throw new \Exception(var_export($parts, true));
                        return [ $parts[0] => $parts[1] ];
                    });
            });
            /*
            $fieldDefinitions should now look like:
                [
                    [
                        'Label1'=>'field1',
                        'Alt1'=>'altfield1'
                    ],
                    [
                        'Label2'=>'field2'
                    ],
                    [
                        'Alt1'=>'altfield1',
                        'Label3'=>'field3'
                    ]
                ]
            */

        // Prepare data
        $data = $assets
            ->map(function ($asset) use ($template, $settings, $fieldDefinitions) {

                $assetData = new Collection();

                $assetData->put('asset', $asset);
                $assetData->put('id', $asset->id);
                $assetData->put('tag', $asset->asset_tag);

                if ($template->getSupportTitle()) {
                    $title = !empty($settings->label2_title) ?
                        str_ireplace(':company', $asset->company->name, $settings->label2_title) :
                        $settings->qr_text;
                    if (!empty($title)) $assetData->put('title', $title);
                }

                if ($template->getSupportLogo()) {
                    $logo = $settings->label2_asset_logo ?
                        (
                            !empty($asset->company->image) ? 
                                Storage::disk('public')->path('companies/'.e($asset->company->image)) :
                                null
                        ) :
                        (
                            !empty($settings->label_logo) ?
                                Storage::disk('public')->path(''.e($settings->label_logo)) :
                                null
                        );
                    if (!empty($logo)) $assetData->put('logo', $logo);
                }

                if ($template->getSupport1DBarcode()) {
                    $barcode1DType = $settings->label2_1d_type;
                    $barcode1DType = ($barcode1DType == 'default') ? 
                        (($settings->alt_barcode_enabled) ? $settings->alt_barcode : null) :
                        $barcode1DType;
                    if ($barcode1DType != 'none') {
                        $assetData->put('barcode1d', (object)[
                            'type' => $barcode1DType,
                            'content' => $asset->asset_tag,
                        ]);
                    }
                }

                if ($template->getSupport2DBarcode()) {
                    $barcode2DType = $settings->label2_2d_type;
                    $barcode2DType = ($barcode2DType == 'default') ? 
                        (($settings->qr_code) ? $settings->barcode_type : null) :
                        $barcode2DType;
                    if ($barcode2DType != 'none') {
                        switch ($settings->label2_2d_target) {
                            case 'ht_tag': $barcode2DTarget = route('ht/assetTag', $asset->asset_tag); break;
                            case 'hardware_id':
                            default: $barcode2DTarget = route('hardware.show', $asset->id); break;
                        }
                        $assetData->put('barcode2d', (object)[
                            'type' => $barcode2DType,
                            'content' => $barcode2DTarget,
                        ]);
                    }
                }

                $fields = $fieldDefinitions
                    ->map(function ($group, $index) use ($asset) {
                        return $group->mapWithKeys(function ($definition, $label) use ($asset) {
                            $value = collect(explode('.', $definition))
                                ->reduce(function ($carry, $chunk) {
                                    return $carry ? $carry->{$chunk} : ${$carry};
                                }, $asset);
                            return [ $label => $value ];
                        });
                    })
                    ->reduce(function ($carry, $group, $index) {
                        $values = $group
                            ->filter(function ($value, $label) use ($carry) {
                                if (empty($value)) return false;
                                if ($carry->has($label)) return false;
                                return true;
                            })
                            ->take(1);
                        return $carry->merge($values);
                    }, new Collection());
                $assetData->put('fields', $fields->take($template->getSupportFields()));

                return $assetData;
            });
        
        if ($template instanceof Sheet) {
            $template->setLabelIndexOffset($offset ?? 0);
        }
        $template->writeAll($pdf, $data);

        $filename = $assets->count() > 1 ? 'assets.pdf' : $assets->first()->asset_tag.'.pdf';
        $pdf->Output($filename, 'I');
    }

    /**
     * Add a piece of data.
     *
     * @param  string|array  $key
     * @param  mixed  $value
     * @return $this
     */
    public function with($key, $value = null)
    {
        $this->data->put($key, $value);
        return $this;
    }
    
    /**
     * Get the array of view data.
     *
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Get the name of the view.
     *
     * @return string
     */
    public function name()
    {
        return $this->getName();
    }

    /**
     * Get the name of the view.
     *
     * @return string
     */
    public function getName()
    {
        return self::NAME;
    }

}