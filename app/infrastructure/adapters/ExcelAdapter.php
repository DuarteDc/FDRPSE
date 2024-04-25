<?php

namespace App\infrastructure\adapters;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

final class ExcelAdapter
{

    const QUALIFICATION_NAME = [
        'always_op'        => 'Siempre',
        'almost_alwyas_op' => 'Casi siempre',
        'sometimes_op'     => 'Algunas veces',
        'almost_never_op'  => 'Casi nunca',
        'never_op'         => 'Nunca',
    ];

    private readonly Spreadsheet $spreadsheet;

    public function __construct()
    {
        $this->spreadsheet = new Spreadsheet();
    }


    public function generateReport(mixed $surveyUser)
    {
        $surveyUser = (object) $surveyUser;
        $this->spreadsheet->getActiveSheet()->setCellValue("A1", "Pregunta");
        $this->spreadsheet->getActiveSheet()->setCellValue("B1", "Respuesta");
        $this->spreadsheet->getActiveSheet()->setCellValue("C1", "Categoría");
        $this->spreadsheet->getActiveSheet()->setCellValue("D1", "Dominio");
        $this->spreadsheet->getActiveSheet()->setCellValue("E1", "Dimensions");
        foreach ($surveyUser->answers as $key => $answer) {
            $key += 1;
            $this->spreadsheet->getActiveSheet()->setCellValue("A" . $key + 1, $answer['name'])->getColumnDimension('A')->setAutoSize(true);
            $this->spreadsheet->getActiveSheet()->setCellValue("B" . $key + 1, $this->getNameOfQualifications($answer['qualification'], $answer['qualification_data']))->getColumnDimension('B')->setAutoSize(true);
            $this->spreadsheet->getActiveSheet()->setCellValue("C" . $key + 1, $answer['category']['name'] ??  "")->getColumnDimension('C')->setAutoSize(true);
            $this->spreadsheet->getActiveSheet()->setCellValue("D" . $key + 1, $answer['domain']['name'] ?? "")->getColumnDimension('D')->setAutoSize(true);
            $this->spreadsheet->getActiveSheet()->setCellValue("E" . $key + 1, $answer['dimension']['name'] ?? "")->getColumnDimension('E')->setAutoSize(true);
        }

        $writer = new Xlsx($this->spreadsheet);
        // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        // header('Content-Disposition: attachment; filename="' . urlencode("xd.xlsx") . '"');
        //$writer->save('php://output');
        $writer->save('xd.xlsx');
    }


    private function getNameOfQualifications(mixed $qualification, mixed $qualificationData)
    {
        if (gettype($qualification) === 'boolean') {
            return $qualification ? 'Si' : 'No';
        }

        return self::QUALIFICATION_NAME[array_search($qualification, (array) $qualificationData)];
    }
}
