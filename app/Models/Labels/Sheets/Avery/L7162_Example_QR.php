<?php

namespace App\Models\Labels\Sheets\Avery;


class L7162_Example_QR extends L7162
{
    private const BARCODE1D_SIZE   =   6.0;
    private const BARCODE2D_MARGIN =   1.4;
    private const TITLE_SIZE       =   4.0;
    private const TITLE_MARGIN     =   1.6;
    private const LABEL_SIZE       =   2.2;
    private const LABEL_MARGIN     = - 0.5;
    private const FIELD_SIZE       =   4.8;
    private const FIELD_MARGIN     =   0.3;

    public function getUnit() { return 'mm'; }

    public function getLabelMarginTop()    { return 1.0; }
    public function getLabelMarginBottom() { return 1.0; }
    public function getLabelMarginLeft()   { return 1.0; }
    public function getLabelMarginRight()  { return 1.0; }

    public function getSupport1DBarcode() { return false; }
    public function getSupport2DBarcode() { return true; }
    public function getSupportFields()    { return 4; }
    public function getSupportLogo()      { return false; }
    public function getSupportTitle()     { return true; }

    public function preparePDF($pdf) {}

    public function write($pdf, $record) {
        $pa = $this->getLabelPrintableArea();

        static::write2DBarcode(
            $pdf, $record->get('barcode2d')->content, $record->get('barcode2d')->type,
            $pa->x1, $pa->y1, 
            $pa->h, $pa->h
        );

        $x = $pa->x1 + $pa->h + self::BARCODE2D_MARGIN;
        $y = $pa->y1;
        $w = $pa->w - $pa->h - self::BARCODE2D_MARGIN;

        if ($record->get('title')) {
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


?>