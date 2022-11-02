<?php

namespace App\Models\Labels\Tapes\Brother;

class TZe_12mm_A extends TZe_12mm
{
    private const BARCODE_SIZE   = 2.50;
    private const BARCODE_MARGIN = 0.30;
    private const FIELD_SIZE_MOD = 1.00;

    public function getUnit()  { return 'mm'; }
    public function getWidth() { return 50.0; }
    public function getSupport1DBarcode() { return true; }
    public function getSupport2DBarcode() { return false; }
    public function getSupportFields()    { return 2; }
    public function getSupportLogo()      { return false; }
    public function getSupportTitle()     { return false; }

    public function preparePDF($pdf) {}

    public function write($pdf, $record) {
        $pa = $this->getPrintableArea();

        if ($record->has('barcode1d')) {
            static::write1DBarcode(
                $pdf, $record->get('barcode1d')->content, $record->get('barcode1d')->type,
                $pa->x1, $pa->y1, $pa->w, self::BARCODE_SIZE
            );
        }

        $fields = $record->get('fields');
        $y = $pa->y1 + self::BARCODE_SIZE + self::BARCODE_MARGIN;
        $realSize = $pa->h - self::BARCODE_SIZE - self::BARCODE_MARGIN;
        $fontSize = $realSize + self::FIELD_SIZE_MOD;

        if ($fields->count() >= 1) {
            static::writeText(
                $pdf, $fields->values()->get(0),
                $pa->x1, $y,
                'freemono', 'B', $fontSize, 'L',
                $pa->w, $realSize, true, 0, 0.1
            );
        }
        if ($fields->count() >= 2) {
            static::writeText(
                $pdf, $fields->values()->get(1),
                $pa->x1, $y,
                'freemono', 'B', $fontSize, 'R',
                $pa->w, $realSize, true, 0, 0.1
            );
        }
        
    }
}