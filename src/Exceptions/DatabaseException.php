<?php

class DatabaseException extends PDOException {
    public function __construct($message = "Error en la base de datos", $code = 0) {
        parent::__construct($message, $code);
    }
}