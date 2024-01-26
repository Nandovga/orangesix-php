<?php

namespace Orangecode\Controller;

use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Routing\Controller;
use Orangecode\Service\AutoInstance;
use Orangecode\Service\Response\ServiceResponse;

abstract class ControllerBase extends Controller
{
    use AutoInstance;

    protected ServiceResponse $response;

    /**
     * @throws BindingResolutionException
     */
    public function __construct()
    {
        $this->response = app()->make(ServiceResponse::class);
    }

    /**
     * @param string $name
     * @return mixed
     * @throws BindingResolutionException
     */
    public function __get(string $name)
    {
        return $this->instanceAutoService($name);
    }
}