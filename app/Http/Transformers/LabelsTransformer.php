<?php

namespace App\Http\Transformers;

use App\Helpers\Helper;
use App\Models\Labels\Label;
use App\Models\Labels\Sheet;
use App\Models\Labels\RectangleSheet;
use App\Models\LabelTemplate;
use Illuminate\Support\Collection;

class LabelsTransformer
{
    public function transformLabels($total)
    {
        $label_templates = LabelTemplate::all();
        $array = [];
        foreach ($label_templates as $label_template) {
            $array[] = self::transformLabel($label_template);
        }

        return (new DatatablesTransformer)->transformDatatables($array, $total);
    }

    public function transformLabel(LabelTemplate $label)
    {
        $array = [
            'name' => $label->name,
            'unit' => $label->measurement_unit,

            'width'  => number_format($label->label_width, 3),
            'height' => number_format($label->label_height, 3),

            'margin_top'    => $label->margin_top,
            'margin_bottom' => $label->margin_bottom,
            'margin_left'   => $label->margin_left,
            'margin_right'  => $label->margin_right,

            'tag_option'         => $label->tag_option,
            'one_d_barcode_option'  => $label->one_d_barcode_option,
            'two_d_barcode_option' => $label->two_d_barcode_option,
            'fields_supported'     => $label->fields_supported,
            'logo_option'       => $label->logo_option,
            'title_option'      => $label->title_option,
        ];

        if ($label instanceof Sheet) {
            $array['sheet_info'] = [
                'label_width'  => $label->label_width,
                'label_height' => $label->label_height,

                'label_margin_top'    => $label->margin_top,
                'label_margin_bottom' => $label->margin_bottom,
                'label_margin_left'   => $label->margin_left,
                'label_margin_right'  => $label->margin_right,

                'labels_per_page' => $label->getLabelsPerPage(),
                'label_border' => $label->getLabelBorder(),
            ];
        }

        if ($label instanceof RectangleSheet) {
            $array['rectanglesheet_info'] = [
                'columns' => $label->columns(),
                'rows'    => $label->rows(),
                'column_spacing' => $label->getLabelColumnSpacing(),
                'row_spacing'    => $label->getLabelRowSpacing(),
            ];
        }

        return $array;
    }
}
