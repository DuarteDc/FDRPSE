<?php

namespace App\infrastructure\adapters;

use Shuchkin\SimpleXLSXGen;

final class ExcelAdapter
{

    private array $cells = [];
    private array $merge = [];
    private readonly SimpleXLSXGen $xlsx;

    public function __construct()
    {
        $this->xlsx = new SimpleXLSXGen;
    }

    public function addNewSheet(string $name)
    {
        $this->xlsx->addSheet($this->cells, $name);
        foreach ($this->merge as $key => $merge) {
            $this->xlsx->mergeCells($merge);
        }
        $this->cells = [];
        $this->merge = [];
    }

    public function mergeCellDocument(string $cellsMerge)
    {
        $this->merge = [$cellsMerge, ...$this->merge];
        return $this;
    }

    public function setHeader(array $headers)
    {
        $this->cells = [...$this->cells, $headers];
        return $this;
    }

    public function setData(array $data)
    {
        $this->cells = [...$this->cells, ...$data];
    }

    public function generateReport(string $title = 'Reporte')
    {
        $xlsx = $this->xlsx;
        $xlsx->setDefaultFont('Arial')
            ->setDefaultFontSize(12)
            ->setCompany('IGECEM')
            ->setTitle($title)
            ->setLanguage('es-MX')
            ->downloadAs($title . '.xlsx');
    }
}
