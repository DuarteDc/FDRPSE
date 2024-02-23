<?php
const QUALIFICATION_NAME = [
    'always_op' => 'Siempre',
    'almost_alwyas_op' => 'Casi siempre',
    'sometimes_op' => 'Algunas veces',
    'almost_never_op' => 'Casi nunca',
    'never_op' => 'Nunca'
];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        body {
            font-size: 11px;
            font-family: Arial, Helvetica, sans-serif, sans-serif;
        }

        @page {
            margin: 4cqmax 50px;
        }

        h1 {
            text-align: center;
            color: #333;
            font-size: 16px;
        }

        table {
            width: 100%;
            margin: 40px auto;
            border-collapse: collapse;
            border: 1px solid #ddd;
            background-color: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        th,
        td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
        }

        footer {
            text-align: center;
            width: 100%;
            position: absolute;
            bottom: -2px;
        }
        .signature-section{
            margin-top: 10px;
        }
    </style>
</head>


<body>
    <main>
        <h1 style="text-align: center;">Cuestionario de Identificación y Análisis de los Factores de Riesgo Psicológicos y Evaluación del Entorno Organizacional en los Centros de Trabajo de IGECEM</h1>
        <table>
            <thead>
                <th>#</th>
                <th>Pregunta</th>
                <th>Respuesta</th>
            </thead>
            <tbody>
                <?php
                foreach ($data->survey_user->answers as $key => $question) {
                    echo "
                    <tr>
                        <td>" . $key + 1 . "</td>
                        <td>{$question->name}</td>
                        
                    </tr>
                    ";
                }
                ?>
            </tbody>
        </table>
        <footer>
            <div class="signature-line">
                Yo, <b><?php echo $data->survey_user->user->nombre . " " . $data->survey_user->user->apellidoP . " " . $data->survey_user->user->apellidoM ?? '' ?></b> certifico que he contestado el cuestionario de manera
                honesta y fidedigna, proporcionando respuestas precisas y veraces en cada pregunta.
            </div>
            <div class="signature-section">
                <p> __________________________________</p>
                <b><?php echo $data->survey_user->user->nombre . " " . $data->survey_user->user->apellidoP . " " . $data->survey_user->user->apellidoM ?? '' ?></b>
            </div>
        </footer>
    </main>
</body>

</html>