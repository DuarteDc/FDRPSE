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

    public function generateReport(string $title = 'Reporte', string $name = 'Reporte de cuestionario')
    {
        $xlsx = $this->xlsx::fromArray($this->cells);
        foreach ($this->merge as $key => $merge) {
            $xlsx->mergeCells($merge);
        }
        $xlsx->setDefaultFont('Arial')
            ->setDefaultFontSize(12)
            ->setCompany('IGECM')
            ->setTitle($title)
            ->setLanguage('es-MX')
            ->downloadAs($name);
    }
}
