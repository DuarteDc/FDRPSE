<?php

declare(strict_types=1);

namespace App\infrastructure\routes\authentication;

use App\application\authentication\AuthenticationUseCase;

use App\domain\user\User;
use App\infrastructure\controllers\AuthenticationController;
use App\infrastructure\repositories\user\UserRepository;
use Bramus\Router\Router;

function router(Router $router)
{
    $authenticationRepository = new UserRepository(new User());
    $authenticationUseCase = new AuthenticationUseCase($authenticationRepository);
    $authenticationController = new AuthenticationController($authenticationUseCase);

    $router->post('/signin', function () use ($authenticationController) {
        $authenticationController->login();
    });

    $router->get('/me', function () use ($authenticationController) {
        $authenticationController->revalidateToke();
    });
}
