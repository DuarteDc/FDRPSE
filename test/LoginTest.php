<?php

namespace Test;

use Test\DatabaseServiceTest;
use App\application\authentication\AuthenticationUseCase;
use App\domain\user\User;
use App\infrastructure\controllers\AuthenticationController;
use App\infrastructure\repositories\user\UserRepository;

use Test\Persistence\DatabaseTestCase;

final class LoginTest extends DatabaseTestCase
{

    public function testLoginUSer() 
    {

        $userRepository = new UserRepository(new User);
        $authenticationUseCase = new AuthenticationUseCase($userRepository);

        $user = $authenticationUseCase->signin('Eduardo Duarte', '7291073097');

        $this->assertSame('Eduardo', $user->nombre);
    }
}
