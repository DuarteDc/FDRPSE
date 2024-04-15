<?php

declare(strict_types=1);

namespace App\infrastructure\controllers;

use App\application\authentication\AuthenticationUseCase;
use App\infrastructure\requests\authentication\LoginRequest;

use App\kernel\controllers\Controller;
use Exception;

final class AuthenticationController extends Controller
{
	public function __construct(private readonly AuthenticationUseCase $authenticationUseCase) {}

	public function login()
	{
		$this->validate(LoginRequest::rules(), LoginRequest::messages());
		$user = $this->authenticationUseCase->signin(
			trim(mb_strtoupper($this->post('username'))),
			trim($this->post('password'))
		);
		if ($user instanceof Exception) {
			return $this->response($user);
		}
		$this->response($this->createSession($user));
	}

	public function revalidateToke()
	{
		$session = $_SERVER['HTTP_SESSION'] ?? '';
		$user = $this->check($session);
		if (!$user) {
			return $this->response(['message' => 'Unathorized'], 401);
		}
		$user = $this->authenticationUseCase->checkUserSession($user);
		if ($user instanceof Exception) {
			return $this->response($user);
		}
		$this->response($this->createSession($user));
	}
}
