<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;

class ExcelExport implements FromArray
{
    protected $arreglo;

    public function __construct(array $arreglo)
    {
        $this->arreglo = $arreglo;
    }

    public function array(): array
    {
        return $this->arreglo;
    }
}