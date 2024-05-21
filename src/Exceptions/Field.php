<?php

namespace Orangesix\Exceptions;

use Illuminate\Http\JsonResponse;

class Field extends \Exception
{
    /**
     * @return JsonResponse
     */
    public function render(): JsonResponse
    {
        return response()->json([
            'errors' => json_decode($this->message)
        ], $this->getCode());
    }
}
