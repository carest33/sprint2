<?php

class FileSizeException extends Exception
{
    public function __construct($message = 'Tamaño de archivo excede el límite permitido', $code = 0, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}