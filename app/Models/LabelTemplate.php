<?php

namespace App\Models;

use App\Helpers\Helper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LabelTemplate extends Model
{
    use HasFactory;

    protected $rules = [
        'name' => 'required|string|max:255',
        'page_format' => 'required|string',
        'page_orientation' => 'required|string',
        'column1_x' => 'required|numeric|lt:column2_x',
        'column2_x' => 'required|numeric|gt:column1_x',
        'row1_y' => 'nullable|numeric',
        'row2_y' => 'nullable|numeric|gt:row1_y',
        'label_width' => 'required|numeric',
        'label_height' => 'required|numeric',
        'barcode_size' => 'nullable|numeric',
        'barcode_margin' => 'nullable|numeric',
        'title_size' => 'nullable|numeric',
        'title_margin' => 'nullable|numeric',
        'field_size' => 'nullable|numeric',
        'field_margin' => 'nullable|numeric',
        'label_size' => 'nullable|numeric',
        'label_margin' => 'nullable|numeric',
        'tag_size' => 'nullable|numeric',
        'logo_max_width' => 'nullable|numeric',
        'logo_margin' => 'nullable|numeric',
        'measurement_unit' => 'required|string',
        'margin_top' => 'nullable|numeric',
        'margin_bottom' => 'nullable|numeric',
        'margin_left' => 'nullable|numeric',
        'margin_right' => 'nullable|numeric',
        'fields_supported' => 'nullable|integer',
        'tag_option' => 'nullable|boolean',
        'one_d_barcode_option' => 'nullable|boolean',
        'two_d_barcode_option' => 'nullable|boolean',
        'logo_option' => 'nullable|boolean',
        'title_option' => 'nullable|boolean',
        'tape_height' => 'nullable|numeric',
        'tape_margin_sides' => 'nullable|numeric',
        'tape_margin_ends' => 'nullable|numeric',
        'tape_text_size_mod' => 'nullable|numeric',
        'columns' => 'required|integer',
        'rows' => 'required|integer',
        ];

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
        'one_d_barcode_option',
        'two_d_barcode_option',
        'logo_option',
        'title_option',
        'tape_height',
        'tape_margin_sides',
        'tape_margin_ends',
        'tape_text_size_mod',
        'columns',
        'rows'
    ];

    public function labelsPerPage()  {

        return $this->columns * $this->rows;
    }

    public function labelPosition($index)  {
        $printIndex = $index + $this->getLabelIndexOffset();
        $row = (int)($printIndex / $this->getColumns());
        $col = $printIndex - ($row * $this->getColumns());
        $x = $this->getPageMarginLeft() + (($this->getLabelWidth() + $this->getLabelColumnSpacing()) * $col);
        $y = $this->getPageMarginTop() + (($this->getLabelHeight() + $this->getLabelRowSpacing()) * $row);
        return [ $x, $y ];
    }
    public function columns() {
        return $this->columns;
    }
    public function rows() {
        return $this->rows;
    }
    public function labelRowSpacing(){

    }
    public function LabelColumnSpacing(){

    }
    /**
     * Get the paper size in the specified format and orientation.
     *
     * @return object [width, height] based on the page format, orientation, and measurement unit .
     */
    public function paperSize(){
        return static::fromFormat($this->page_format, $this->page_orientation, $this->measurement_unit, 2);
    }

    /**
     * Get the spacing between columns in points.
     *
     * @return float The column spacing in points.
     */
    public function columnSpacingPt() {
        $columnSpacingPT = ($this->column2_x - $this->column1_x - $this->label_width);
        return Helper::convertUnit($columnSpacingPT, 'pt', $this->measurement_unit);
    }

    /**
     * Get the spacing between rows in points.
     *
     * @return float The row spacing in points.
     */
    public function rowSpacingPt() {
        $rowSpacingPT = ($this->row2_y - $this->row1_y - $this->label_height);
        return Helper::convertUnit($rowSpacingPT, 'pt', $this->measurement_unit);
    }


    /**
     * Get the label width in points.
     *
     * @return float The label width in points.
     */
    public function labelWidth() {
        return Helper::convertUnit($this->label_width, 'pt', $this->measurement_unit);
    }

    /**
     * Get the label height in points.
     *
     * @return float The label height in points.
     */
    public function labelHeight() {
        return Helper::convertUnit($this->label_height, 'pt', $this->measurement_unit);
    }

    /**
     * Get the left margin in points.
     *
     * @return float The left margin in points.
     */
    public function marginLeft(){
        return Helper::convertUnit($this->column1_x, 'pt', $this->measurement_unit);
    }

    /**
     * Get the top margin in points.
     *
     * @return float The top margin in points.
     */
    public function margintTop(){
        return Helper::convertUnit($this->row1_y, 'pt', $this->measurement_unit);
    }
    /**
     * Public Static Functions
     */

    /**
     * Find size of a page by its format.
     *
     * @param  string  $format       Format name (eg: 'A4', 'LETTER', etc.)
     * @param  string  $orientation  'L' for Landscape, 'P' for Portrait ('L' default)
     * @param  string  $unit         Unit of measure to return in ('mm' default)
     *
     * @return object  (object)[ 'width' => (float)123.4, 'height' => (float)123.4 ]
     */
    public static function fromFormat($format, $orientation='L', $unit='mm', $round=false) {
        $size = collect(TCPDF_STATIC::getPageSizeFromFormat(strtoupper($format)))
            ->sort()
            ->map(function ($value) use ($unit) {
                return Helper::convertUnit($value, 'pt', $unit);
            })
            ->toArray();
        $width = ($orientation == 'L') ? $size[1] : $size[0];
        $height = ($orientation == 'L') ? $size[0] : $size[1];
        return (object)[
            'width'  => ($round !== false) ? round($width, $round)  : $width,
            'height' => ($round !== false) ? round($height, $round) : $height,
        ];
    }
}