<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use App\Exceptions\Handler;
use Illuminate\Contracts\Debug\ExceptionHandler;
use Illuminate\Support\Facades\DB;
use Tymon\JWTAuth\Facades\JWTAuth;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

	protected function signIn($user = null)
	{

		$user = $user ?: create('App\Model\User');

		$this->actingAs($user);

		return $this;
	}

	protected function signInViaJWT($user = null)
	{

		$user = $user ?: create('App\Model\User');

		JWTAuth::fromUser($user);

		return $this;
	}


}
