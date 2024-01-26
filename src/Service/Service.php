<?php

namespace Orangecode\Service;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;

interface Service
{
    /**
     * @param int $id
     * @return mixed
     */
    public function find(int $id): mixed;

    /**
     * @param Request $request
     * @return mixed
     */
    public function manager(Request $request): mixed;

    /**
     * @param Request $request
     * @return mixed
     */
    public function delete(Request $request): void;

    /**
     * @param Request $request
     * @return array
     */
    public function validated(Request $request): array;

    /**
     * @return Model
     */
    public function getModel(): Model;
}
