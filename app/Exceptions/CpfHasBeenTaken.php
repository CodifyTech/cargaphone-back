<?php

namespace App\Exceptions;

use Exception;

class CpfHasBeenTaken extends Exception
{
    protected $message = 'Já existe uma pessoa com este CPF.';
    public function render()
    {
        return response()->json([
            'error' => class_basename($this),
            'message' => $this->getMessage(),
        ], 500);
    }
}
