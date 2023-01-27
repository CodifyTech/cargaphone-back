<?php

namespace App\Exceptions;

use Exception;

class InternalServerErrorException extends Exception
{
    protected $message = 'Algo deu errado, tente novamente ou entre em contato.';
    public function render()
    {
        return response()->json([
            'error' => class_basename($this),
            'message' => $this->getMessage(),
        ], 500);
    }
}
