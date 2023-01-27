<?php

namespace App\Exceptions;

use Exception;

class ErrorDeletingException extends Exception
{
    protected $message = 'Houve um erro ao excluir este usuário.';
    public function render()
    {
        return response()->json([
            'error' => class_basename($this),
            'message' => $this->getMessage(),
        ], 500);
    }
}
