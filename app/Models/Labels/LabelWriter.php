<?php

namespace App\Models\Labels;

use App\Helpers\Helper;
use App\Models\LabelTemplate;
use App\Models\Setting;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use TCPDF;

class LabelWriter
{

//    /**
//     * Make changes to the PDF properties here. OPTIONAL.
//     *
//     * @param  TCPDF  $pdf  The TCPDF instance
//     */
//    public function preparePDF(TCPDF $pdf);

    /**
     * Handle the data here. Override for multiple-per-page handling
     *
     * @param  TCPDF       $pdf   The TCPDF instance
     * @param  Collection  $data  The data
     */
    public function writeAll( TCPDF $pdf, Collection $data, $label) {
        if(strpos($label->label_type, 'Sheet') !== false) {
            $prevPageNumber = -1;

            foreach ($data->toArray() as $recordIndex => $record) {

                $pageNumber = (int)($recordIndex / $label->labelsPerPage());
                if ($pageNumber != $prevPageNumber) {
                    $pdf->AddPage();
                    $prevPageNumber = $pageNumber;
                }

                $pageIndex = $recordIndex - ($label->labelsPerPage() * $pageNumber);
                $position = $label->getlabelPosition($pageIndex);

                $pdf->StartTemplate();
                $this->write5267($pdf, $data->get($recordIndex), $label);
                $template = $pdf->EndTemplate();

                $pdf->printTemplate($template, $position[0], $position[1]);

                if ($label->label_border) {
                    $prevLineWidth = $pdf->GetLineWidth();

                    $borderThickness = $label->label_border;
                    $borderOffset = $borderThickness / 2;
                    $borderX = $position[0]- $borderOffset;
                    $borderY = $position[1] - $borderOffset;
                    $borderW = $label->label_Width() + $borderThickness;
                    $borderH = $label->label_Height() + $borderThickness;

                    $pdf->setLineWidth($borderThickness);
                    $pdf->Rect($borderX, $borderY, $borderW, $borderH);
                    $pdf->setLineWidth($prevLineWidth);
                }
            }
        }else {
            $data->each(function ($record, $index) use ($label, $pdf) {
                $pdf->AddPage();
                $this->write5267($pdf, $record, $label);
            });
        }
    }
    /**
     * Write the label information to the PDF.
     *
     * @param TCPDF $pdf The PDF object to write to.
     * @param object $record The record containing the data to write on the label.
     *
     * @return void
     */
    public function write(TCPDF $pdf, object $record, $template)
    {
        $pa = $this->getLabelPrintableArea($template);
        $currentX = $pa->x1;
        $currentY = $pa->y1;
        $usableWidth = $pa->w;
        $usableHeight = $pa->h;

        if ($record->has('barcode1d')) {
            $this->write1DBarcode(
                $pdf, $record->get('barcode1d')->content, $record->get('barcode1d')->type,
                $pa->x1, $pa->y2 - $template->barcode_size,
                $pa->w, $template->barcode_size
            );
            $usableHeight -= $template->barcode_size + $template->barcode_margin;
        }
        if ($record->has('title')) {
            $this->writeText(
                $pdf, $record->get('title'),
                $currentX, $currentY,
                'freesans', '', $template->title_size, $template->title_align ?? 'L',
                $usableWidth, $template->title_size, true, 0
            );
            $currentY += $template->title_size + $template->title_margin;
            $usableHeight -= $template->title_size + $template->title_margin;
        }

        if ($record->has('barcode2d')) {
            $barcodeSize = $this->options['barcode_size'] ?? $usableHeight;
            $this->write2DBarcode(
                $pdf, $record->get('barcode2d')->content, $record->get('barcode2d')->type,
                $currentX, $currentY,
                $barcodeSize, $barcodeSize
            );
            $currentX += $barcodeSize + $template->barcode_margin;
            $usableWidth -= $barcodeSize + $template->barcode_margin;

            if ($record->has('tag')) {
                $this->writeText(
                    $pdf, $record->get('tag'),
                    $pa->x1, $pa->y2 - $template->tag_size,
                    'freemono', 'b', $template->tag_size, 'C',
                    $barcodeSize, $template->tag_size, true, 0
                );
            }
        } else if ($record->has('tag')) {
            $tagPosition = $template->tag_position;
            $tagY = $tagPosition === 'bottom' ? $pa->y2 - $template->tag_size : $currentY;
            $this->writeText(
                $pdf, $record->get('tag'),
                $pa->x1, $tagY,
                'freemono',
                'b', $template->tag_size,
                (string) $template->tag_align,
                $usableWidth,
                $template->tag_size,
                true,
                0
            );
            if ($tagPosition === 'bottom') {
                $currentY += $template->tag_size + $template->barcode_margin;
            }
        }


        if ($record->has('logo')) {
            $logoSize = $this->writeImage(
                $pdf, $record->get('logo'),
                $pa->x1, $pa->y1,
                $template->logo_max_width, $usableHeight,
                'L', 'T', 300, true, false, 0.1
            );
            $currentX += $logoSize[0] + $template->logo_margin;
            $usableWidth -= $logoSize[0] + $template->logo_margin;
        }

        if ($record->has('tag')) {
            $tagPosition = isset($template->tag_position) ? $template->tag_position : 'L';
            $tagY = $tagPosition === 'bottom' ? $pa->y2 - $template->tag_size : $currentY;
            $this->writeText(
                $pdf, $record->get('tag'),
                $pa->x1, $tagY,
                'freemono', 'b', $template->tag_size, isset($template->tag_align) ? $template->tag_align : 'L',
                $usableWidth, $template->tag_size, true, 0
            );
            if ($tagPosition === 'bottom') {
                $currentY += $template->tag_size + $template->barcode_margin;
            }
        }

        foreach ($record->get('fields') as $field) {
            $this->writeText(
                $pdf, $field['label'],
                $currentX, $currentY,
                'freesans', '', $template->label_size, 'L',
                $usableWidth, $template->label_size, true, 0
            );
            $currentY += $template->label_size + $template->label_margin;

            $this->writeText(
                $pdf, $field['value'],
                $currentX, $currentY,
                'freemono', 'B', $template->field_size, 'L',
                $usableWidth, $template->field_size, true, 0, 0.3
            );
            $currentY += $template->field_size + $template->field_margin;
        }

        if ($record->has('tag') && isset($template->tag_position) && $template->tag_position === 'bottom') {
            $this->writeText(
                $pdf, $record->get('tag'),
                $currentX, $pa->y2 - $template->barcode_size - $template->barcode_margin - $template->tag_size,
                'freemono', 'b', $template->tag_size, 'R',
                $usableWidth, $template->tag_size, true, 0, 0.3
            );
        }

    }
    public function write5267($pdf, $record, $template) {
        $pa = $this->getLabelPrintableArea($template);
//dd($this->getLabelPrintableArea($template));
        if ($record->has('barcode1d')) {
            $this->write1DBarcode(
                $pdf, $record->get('barcode1d')->content, $record->get('barcode1d')->type,
                $pa->x1, $pa->y2 - $template->barcode_size,
                $pa->w, $template->barcode_size
            );
        }

        if ($record->has('title')) {
            $this->writeText(
                $pdf, $record->get('title'),
                $pa->x1, $pa->y1,
                'freesans', '', $template->title_size, 'L',
                $pa->w, $template->title_size, true, 0
            );
        }

        $fieldY = $pa->y2 - $template->barcode_size - $template->barcode_margin - $template->field_size;
        if ($record->has('fields')) {
            if ($record->get('fields')->count() >= 1) {
                $field = $record->get('fields')->first();
                $this->writeText(
                    $pdf, $field['value'],
                    $pa->x1, $fieldY,
                    'freemono', 'B', $template->field_size, 'C',
                    $pa->w, $template->field_size, true, 0, 0.01
                );
            }
        }

    }
    public function barcodeSize(){

    }
    /**
     * Write a text cell.
     *
     * @param  TCPDF   $pdf     The TCPDF instance
     * @param  string  $text    The text to write. Supports 'some **bold** text'.
     * @param  float   $x       X position of top-left
     * @param  float   $y       Y position of top-left
     * @param  string  $font    The font family
     * @param  string  $style   The font style
     * @param  int     $size    The font size in getUnit() units
     * @param  string  $align   Align text in the box. 'L' left, 'R' right, 'C' center.
     * @param  float   $width   Force text box width. NULL to auto-fit.
     * @param  float   $height  Force text box height. NULL to auto-fit.
     * @param  bool    $squash  Squash text if it's too big
     * @param  int     $border  Thickness of border. Default = 0.
     * @param  int     $spacing Letter spacing. Default = 0.
     */
    public function writeText(TCPDF $pdf, string $text, float $x,float $y, string $font=null, string $style=null, int $size=null, string $align='L', float $width=null, float $height=null, bool $squash=false, int $border=0, int $spacing=0) {
        $prevFamily = $pdf->getFontFamily();
        $prevStyle = $pdf->getFontStyle();
        $prevSizePt = $pdf->getFontSizePt();
        $settings = Setting::getSettings();
        $template = LabelTemplate::where('name', '=', $settings->label2_template)->first();
        $text = !empty($text) ? $text : '';
        $fontFamily = !empty($font) ? $font : $prevFamily;
        $fontStyle = !empty($style) ? $style : $prevStyle;
        if ($size) $fontSizePt = Helper::convertUnit($size, $template->measurement_unit, 'pt', true);
        else $fontSizePt = $prevSizePt;

//        $pdf->SetFontSpacing($spacing);

        $parts = collect(explode('**', $text))
            ->map(function ($part, $index) use ($pdf, $fontFamily, $fontStyle, $fontSizePt) {
                $modStyle = ($index % 2 == 1) ? 'B' : $fontStyle;
                $pdf->setFont($fontFamily, $modStyle, $fontSizePt);
                return [
                    'text' => $part,
                    'text_width' => $pdf->GetStringWidth($part),
                    'font_family' => $fontFamily,
                    'font_style' => $modStyle,
                    'font_size' => $fontSizePt,
                ];
            });

        $textWidth = $parts->reduce(function ($carry, $part) { return $carry += $part['text_width']; });
        $cellWidth = !empty($width) ? $width : $textWidth;

        if ($squash && ($textWidth > 0)) {
            $scaleFactor = min(1.0, $cellWidth / $textWidth);
            $parts = $parts->map(function ($part, $index) use ($scaleFactor) {
                $part['text_width'] = $part['text_width'] * $scaleFactor;
                return $part;
            });
        }
        $cellHeight = !empty($height) ? $height : Helper::convertUnit($fontSizePt, 'pt', $template->measurement_unit);

        if ($border) {
            $prevLineWidth = $pdf->getLineWidth();
            $pdf->setLineWidth($border);
            $pdf->Rect($x, $y, $cellWidth, $cellHeight);
            $pdf->setLineWidth($prevLineWidth);
        }

        switch($align) {
            case 'R': $startX = ($x + $cellWidth) - min($cellWidth, $textWidth); break;
            case 'C': $startX = ($x + ($cellWidth / 2)) - (min($cellWidth, $textWidth) / 2); break;
            case 'L':
            default: $startX = $x; break;
        }

        $parts->reduce(function ($currentX, $part) use ($pdf, $y, $cellHeight) {
            $pdf->SetXY($currentX, $y);
            $pdf->setFont($part['font_family'], $part['font_style'], $part['font_size']);
            $pdf->Cell($part['text_width'], $cellHeight, $part['text'], 0, 0, '', false, '', 1, true);
            return $currentX += $part['text_width'];
        }, $startX);

        $pdf->SetFont($prevFamily, $prevStyle, $prevSizePt);
        $pdf->SetFontSpacing(0);
    }
    /**
     * Write an image.
     *
     * @param  TCPDF   $pdf     The TCPDF instance
     * @param  string  $image   The image to write
     * @param  float   $x       X position of top-left
     * @param  float   $y       Y position of top-left
     * @param  float   $width   The container width
     * @param  float   $height  The container height
     * @param  string  $halign  Align text in the box. 'L' left, 'R' right, 'C' center. Default 'L'.
     * @param  string  $valign  Align text in the box. 'T' top, 'B' bottom, 'C' center. Default 'T'.
     * @param  int     $dpi     Pixels per inch
     * @param  bool    $resize  Resize to fit container
     * @param  bool    $stretch Stretch (vs Scale) to fit container
     * @param  int     $border  Thickness of border. Default = 0.
     *
     * @return array   Returns the final calculated size [w,h]
     */
    public final function writeImage(TCPDF $pdf, $image, $x, $y, $template, $width=null, $height=null, $halign='L', $valign='L', $dpi=300, $resize=false, $stretch=false, $border=0) {

        if (empty($image)) return [0,0];

        $imageInfo = getimagesize($image);
        if (!$imageInfo) return [0,0]; // TODO: SVG or other

        $imageWidthPx = $imageInfo[0];
        $imageHeightPx = $imageInfo[1];
        $imageType = image_type_to_extension($imageInfo[2], false);

        $imageRatio = $imageWidthPx / $imageHeightPx;
        $dpu = Helper::convertUnit($dpi, $template->measurement_unit, 'in');
        $imageWidth = $imageWidthPx / $dpu;
        $imageHeight = $imageHeightPx / $dpu;

        $outputWidth = $imageWidth;
        $outputHeight = $imageHeight;

        if ($resize) {
            // Assign specified parameters
            $limitWidth = $width;
            $limitHeight = $height;

            // If not, try calculating from the other dimension
            $limitWidth = ($limitWidth > 0) ? $limitWidth : ($limitHeight / $imageRatio);
            $limitHeight = ($limitHeight > 0) ? $limitHeight : ($limitWidth * $imageRatio);

            // If not, just use the image size
            $limitWidth = ($limitWidth > 0) ? $limitWidth : $imageWidth;
            $limitHeight = ($limitHeight > 0) ? $limitHeight : $imageHeight;

            $scaleWidth = $limitWidth / $imageWidth;
            $scaleHeight = $limitHeight / $imageHeight;

            // If non-stretch, make both scales factors equal
            if (!$stretch) {
                // Do we need to scale down at all? That's most important.
                if (($scaleWidth < 1.0) || ($scaleHeight < 1.0)) {
                    // Choose largest scale-down
                    $scaleWidth = min($scaleWidth, $scaleHeight);
                } else {
                    // Choose smallest scale-up
                    $scaleWidth = min(max($scaleWidth, 1.0), max($scaleHeight, 1.0));
                }
                $scaleHeight = $scaleWidth;
            }

            $outputWidth = $imageWidth * $scaleWidth;
            $outputHeight = $imageHeight * $scaleHeight;
        }

        // Container
        $containerWidth = !empty($width) ? $width : $outputWidth;
        $containerHeight = !empty($height) ? $height : $outputHeight;

        // Horizontal Position
        switch ($halign) {
            case 'R': $originX = ($x + $containerWidth) - $outputWidth; break;
            case 'C': $originX = ($x + ($containerWidth / 2)) - ($outputWidth / 2); break;
            case 'L':
            default: $originX = $x; break;
        }

        // Vertical Position
        switch ($valign) {
            case 'B': $originY = ($y + $containerHeight) - $outputHeight; break;
            case 'C': $originY = ($y + ($containerHeight / 2)) - ($outputHeight / 2); break;
            case 'T':
            default: $originY = $y; break;
        }

        // Actual Image
        $pdf->Image($image, $originX, $originY, $outputWidth, $outputHeight, $imageType, '', '', true);

        // Border
        if ($border) {
            $prevLineWidth = $pdf->getLineWidth();
            $pdf->setLineWidth($border);
            $pdf->Rect($x, $y, $containerWidth, $containerHeight);
            $pdf->setLineWidth($prevLineWidth);
        }

        return [ $outputWidth, $outputHeight ];
    }
    /**
     * Write a 1D barcode.
     *
     * @param  TCPDF   $pdf     The TCPDF instance
     * @param  string  $value   The barcode content
     * @param  string  $type    The barcode type
     * @param  float   $x       X position of top-left
     * @param  float   $y       Y position of top-left
     * @param  float   $width   The container width
     * @param  float   $height  The container height
     */
    public final function write1DBarcode(TCPDF $pdf, $value, $type, $x, $y, $width, $height) {
        if (empty($value)) return;
        try {
            $pdf->write1DBarcode($value, $type, $x, $y, $width, $height, null, ['stretch'=>true]);
        } catch (\Exception|TypeError $e) {
            Log::debug('The 1D barcode ' . $value . ' is not compliant with the barcode type '. $type);
        }
    }

    /**
     * Write a 2D barcode.
     *
     * @param  TCPDF   $pdf     The TCPDF instance
     * @param  string  $value   The barcode content
     * @param  string  $type    The barcode type
     * @param  float   $x       X position of top-left
     * @param  float   $y       Y position of top-left
     * @param  float   $width   The container width
     * @param  float   $height  The container height
     */
    public function write2DBarcode(TCPDF $pdf, string $value, string $type, float $x, float $y, float $width, float $height) {
        if (empty($value)) return;
        $pdf->write2DBarcode($value, $type, $x, $y, $width, $height, null, ['stretch'=>true]);
    }

    /**
     * Returns each label's printable area as an object.
     *
     * @return object [ 'x1'=>0.00, 'y1'=>0.00, 'x2'=>0.00, 'y2'=>0.00, 'w'=>0.00, 'h'=>0.00 ]
     */
    public final function getLabelPrintableArea($template) : object
    {
        dd([
            'x1' => $template->margin_left,
            'y1' => $template->margin_top,
            'x2' => $template->label_width - $template->margin_right,
            'y2' => $template->label_height - $template->margin_bottom,
            'w' => $template->label_width - $template->margin_left - $template->margin_right,
            'h' => $template->label_height - $template->margin_top - $template->margin_botom,
        ]);
//        dd('margin left: '.$template->margin_left,'margin top: '.$template->margin_top, 'width: '.$template->label_width, 'margin right: '.$template->margin_right, 'height: '.$template->label_width, 'margin bottom:'.$template->margin_bottom);
        return (object)[
            'x1' => $template->margin_left,
            'y1' => $template->margin_top,
            'x2' => $template->label_width - $template->margin_right,
            'y2' => $template->label_height - $template->margin_bottom,
            'w' => $template->label_width - $template->margin_left - $template->margin_right,
            'h' => $template->label_height - $template->margin_top - $template->margin_botom,
        ];
    }




}