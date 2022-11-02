<?php

namespace App\Models\Labels\Tapes\Brother;

class TZe_24mm_A extends TZe_24mm
{
    private const BARCODE_MARGIN =   1.40;
    private const TITLE_SIZE     =   2.80;
    private const TITLE_MARGIN   =   0.60;
    private const LABEL_SIZE     =   1.90;
    private const LABEL_MARGIN   = - 0.30;
    private const FIELD_SIZE     =   3.20;
    private const FIELD_MARGIN   =   0.30;

    public function getUnit()  { return 'mm'; }
    public function getWidth() { return 65.0; }
    public function getSupport1DBarcode() { return false; }
    public function getSupport2DBarcode() { return true; }
    public function getSupportFields()    { return 3; }
    public function getSupportLogo()      { return false; }
    public function getSupportTitle()     { return true; }

    public function preparePDF($pdf) {}

    public function write($pdf, $record) {
        $pa = $this->getPrintableArea();

        $x = $pa->x1;
        $y = $pa->y1;
        $w = $pa->w;

        if ($record->has('barcode2d')) {
            static::write2DBarcode(
                $pdf, $record->get('barcode2d')->content, $record->get('barcode2d')->type,
                $x, $y, $pa->h, $pa->h
            );
            $x += $pa->h + self::BARCODE_MARGIN;
            $w -= $pa->h + self::BARCODE_MARGIN;
        }

        if ($record->has('title')) {
            static::writeText(
                $pdf, $record->get('title'),
                $x, $y,
                'freesans', '', self::TITLE_SIZE, 'L',
                $w, self::TITLE_SIZE, true, 0
            );
            $y += self::TITLE_SIZE + self::TITLE_MARGIN;
        }

        foreach ($record->get('fields') as $label => $value) {
            static::writeText(
                $pdf, $label,
                $x, $y,
                'freesans', '', self::LABEL_SIZE, 'L',
                $w, self::LABEL_SIZE, true, 0
            );
            $y += self::LABEL_SIZE + self::LABEL_MARGIN;

            static::writeText(
                $pdf, $value,
                $x, $y,
                'freemono', 'B', self::FIELD_SIZE, 'L',
                $w, self::FIELD_SIZE, true, 0, 0.3
            );
            $y += self::FIELD_SIZE + self::FIELD_MARGIN;
        }
    }
}