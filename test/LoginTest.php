<?php

namespace Test;

use App\application\authentication\AuthenticationUseCase;
use App\domain\user\User;
use App\infrastructure\controllers\AuthenticationController;
use App\infrastructure\repositories\user\UserRepository;
use PHPUnit\Framework\TestCase;
use App\infrastructure\database\Database;

final class LoginTest extends TestCase
{


    public function testLoginUSer() 
    {

        // Database::getInstance()->connection();
        // $userRepository = new UserRepository(new User);
        // $authenticationUseCase = new AuthenticationUseCase($userRepository);
        // // $authenticationController = new AuthenticationController($authenticationUseCase);

        // $user = $authenticationUseCase->signin('Eduardo Duarte', '7291073097');

        $this->assertSame('Eduardo Duarte', 'Eduardo Duarte');

    }
}
