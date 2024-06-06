<?php


class LabelWriter extends Eloquent
{
    /**
     * Write the label information to the PDF.
     *
     * @param object $pdf The PDF object to write to.
     * @param object $record The record containing the data to write on the label.
     *
     * @return void
     */
    public function write($pdf, $record, $template, $options = [])
    {
        $pa = $this->getLabelPrintableArea();
        
        $currentX = $pa->x1;
        $currentY = $pa->y1;
        $usableWidth = $pa->w;
        $usableHeight = $pa->h;

        if ($record->has('title')) {
            static::writeText(
                $pdf, $record->get('title'),
                $currentX, $currentY,
                'freesans', '', $template->title_size, isset($template->title_align) ? $template->title_align : 'L',
                $usableWidth, $template->title_size, true, 0
            );
            $currentY += $template->title_size + $template->title_margin;
            $usableHeight -= $template->title_size + $template->title_margin;
        }

        if ($record->has('barcode2d')) {
            $barcodeSize = $this->options['barcode_size'] ?? $usableHeight;
            static::write2DBarcode(
                $pdf, $record->get('barcode2d')->content, $record->get('barcode2d')->type,
                $currentX, $currentY,
                $barcodeSize, $barcodeSize
            );
            $currentX += $barcodeSize + $template->barcode_margin;
            $usableWidth -= $barcodeSize + $template->barcode_margin;

            if ($record->has('tag')) {
                static::writeText(
                    $pdf, $record->get('tag'),
                    $pa->x1, $pa->y2 - $template->tag_size,
                    'freemono', 'b', $template->tag_size, 'C',
                    $barcodeSize, $template->tag_size, true, 0
                );
            }
        } else if ($record->has('tag')) {
            $tagPosition = $template->tag_position;
            $tagY = $tagPosition === 'bottom' ? $pa->y2 - $template->tag_size : $currentY;
            static::writeText(
                $pdf, $record->get('tag'),
                $pa->x1, $tagY,
                'freemono', 'b', $template->tag_size, $template->tag_align,
                $usableWidth, $template->tag_size, true, 0
            );
            if ($tagPosition === 'bottom') {
                $currentY += $template->tag_size + $template->barcode_margin;
            }
        }

        if ($record->has('barcode1d')) {
            static::write1DBarcode(
                $pdf, $record->get('barcode1d')->content, $record->get('barcode1d')->type,
                $pa->x1, $pa->y2 - $template->barcode_size,
                $pa->w, $template->barcode_size
            );
            $usableHeight -= $template->barcode_size + $template->barcode_margin;
        }

        if ($record->has('logo')) {
            $logoSize = static::writeImage(
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
            static::writeText(
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
            static::writeText(
                $pdf, $field['label'],
                $currentX, $currentY,
                'freesans', '', $template->label_size, 'L',
                $usableWidth, $template->label_size, true, 0
            );
            $currentY += $template->label_size + $template->label_margin;

            static::writeText(
                $pdf, $field['value'],
                $currentX, $currentY,
                'freemono', 'B', $template->field_size, 'L',
                $usableWidth, $template->field_size, true, 0, 0.3
            );
            $currentY += $template->field_size + $template->field_margin;
        }

        if ($record->has('tag') && isset($template->tag_position) && $template->tag_position === 'bottom') {
            static::writeText(
                $pdf, $record->get('tag'),
                $currentX, $pa->y2 - $template->barcode_size - $template->barcode_margin - $template->tag_size,
                'freemono', 'b', $template->tag_size, 'R',
                $usableWidth, $template->tag_size, true, 0, 0.3
            );
        }

    }
    public function barcodeSize(){

    }

    public final function getLabelPrintableArea()
    {
        return (object)[
            'x1' => $this->getLabelMarginLeft(),
            'y1' => $this->getLabelMarginTop(),
            'x2' => $this->getLabelWidth() - $this->getLabelMarginRight(),
            'y2' => $this->getLabelHeight() - $this->getLabelMarginBottom(),
            'w' => $this->getLabelWidth() - $this->getLabelMarginLeft() - $this->getLabelMarginRight(),
            'h' => $this->getLabelHeight() - $this->getLabelMarginTop() - $this->getLabelMarginBottom(),
        ];
    }
}