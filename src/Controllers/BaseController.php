<?php

declare(strict_types=1);

namespace Controllers;

use Service\Auth\AuthInterface;
use Service\Auth\AuthSessionService;

abstract class BaseController
{
    protected AuthInterface $authService;

    public function __construct()
    {
        $this->authService = new AuthSessionService();
    }

}