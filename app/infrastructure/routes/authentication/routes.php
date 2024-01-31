<?php

namespace App\infrastructure\routes\authentication;

use Bramus\Router\Router;

use App\domain\user\User;
use App\application\authentication\AuthenticationUseCase;
use App\infrastructure\controllers\AuthenticationController;
use App\infrastructure\repositories\user\UserRepository;

function router(Router $router)
{

    $authenticationRepository = new UserRepository(new User);
    $authenticationUseCase    = new AuthenticationUseCase($authenticationRepository);
    $authenticationController = new AuthenticationController($authenticationUseCase);

    $router->post('/signin', function ()  use ($authenticationController) {
        $authenticationController->login();
    });

    $router->get('/me', function () use ($authenticationController) {
        $authenticationController->revalidateToke();
    });
}
