<?php

namespace App\Models\Labels\Tapes\Zebra;

use App\Helpers\Helper;
use App\Models\Labels\Label;
use Illuminate\Support\Collection;
use TCPDF;

abstract class Z_Ultimate extends Label
{
    private const LABEL_GAP = 3.00;

    private const MARGIN_SIDES = 1.50;

    private const MARGIN_ENDS = 1.50;

    public function getLabelGap()
    {
        return Helper::convertUnit(
            self::LABEL_GAP,
            'mm',
            $this->getUnit()
        );
    }

    public function getMarginTop()
    {
        return Helper::convertUnit(
            self::MARGIN_SIDES,
            'mm',
            $this->getUnit()
        );
    }

    public function getMarginBottom()
    {
        return Helper::convertUnit(
            self::MARGIN_SIDES,
            'mm',
            $this->getUnit()
        );
    }

    public function getMarginLeft()
    {
        return Helper::convertUnit(
            self::MARGIN_ENDS,
            'mm',
            $this->getUnit()
        );
    }

    public function getMarginRight()
    {
        return Helper::convertUnit(
            self::MARGIN_ENDS,
            'mm',
            $this->getUnit()
        );
    }

    public function preparePDF(TCPDF $pdf): void
    {
        $pdf->SetMargins(0, 0, 0);
        $pdf->SetAutoPageBreak(false, 0);
    }

    public function writeAll(TCPDF $pdf, Collection $data)
    {
        $pageSize = [
            $this->getWidth(),
            $this->getHeight() + $this->getLabelGap(),
        ];

        $data->each(function ($record) use ($pdf, $pageSize) {
            $pdf->AddPage('L', $pageSize);
            $this->write($pdf, $record);
        });
    }
}
