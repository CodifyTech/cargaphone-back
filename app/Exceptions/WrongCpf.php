<?php

namespace App\Exceptions;

use Exception;

class WrongCpf extends Exception
{
    protected $message = 'O CPF informado está incorreto.';
    public function render()
    {
        return response()->json([
            'error' => class_basename($this),
            'message' => $this->getMessage(),
        ], 400);
    }
}
