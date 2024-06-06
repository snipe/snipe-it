<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LabelTemplate extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'page_format',
        'page_orientation',
        'column1_x',
        'column2_x',
        'row1_y',
        'row2_y',
        'label_width',
        'label_height',
        'barcode_size',
        'barcode_margin',
        'title_size',
        'title_margin',
        'field_size',
        'field_margin',
        'label_size',
        'label_margin',
        'tag_size',
        'logo_max_width',
        'logo_margin',
        'measurement_unit',
        'margin_top',
        'margin_bottom',
        'margin_left',
        'margin_right',
        'fields_supported',
        'tag_option',
        '1d_barcode_option',
        '2d_barcode_option',
        'logo_option',
        'title_option',
        'tape_height',
        'tape_margin_sides',
        'tape_margin_ends',
        'tape_text_size_mod',
    ];
}