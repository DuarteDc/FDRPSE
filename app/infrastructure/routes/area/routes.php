<?php

namespace App\infrastructure\routes\area;

use Bramus\Router\Router;

use App\domain\area\Area;
use App\application\area\AreaUseCase;
use App\infrastructure\controllers\AreaController;
use App\infrastructure\repositories\area\AreaRepository;

function router(Router $router)
{

    $areaRepository = new AreaRepository(new Area);
    $areaUseCase    = new AreaUseCase($areaRepository);
    $areaController = new AreaController($areaUseCase);

    $router->get('/', function ()  use ($areaController) {
        $areaController->getAreas();
    });
}
