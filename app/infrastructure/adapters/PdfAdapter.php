<?php

namespace App\infrastructure\adapters;

use Dompdf\Dompdf;
use Dompdf\Options;

enum PaperTypes: string
{
    case A4 = 'A4';
    case Letter = 'letter';
}

enum OrientationTypes: string
{
    case Portrait = 'portrait';
    case Landscape = 'landscape';
}

class PdfAdapter
{
    public function generatePDF(string $html, PaperTypes $paper, OrientationTypes $orientation, string $fileName, bool $download = true): void
    {
        $options = new Options();
        $options->set('isRemoteEnabled', true);

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper($paper->value, $orientation->value);
        $dompdf->render();
        $dompdf->stream("$fileName.pdf", ['Attachment' => $download]);
    }
}
