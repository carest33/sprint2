<?php

class ValidateProvider
{
    public static function validate($fields)
    {
        $errors = [];
        foreach ($fields as $field => $value) {
            switch ($field) {
                case 'name':
                    $errors[$field] = self::validateName($value);
                    break;
                case 'completeAddress':
                    $errors[$field] = self::validateCompleteAddress($value);
                    break;
                case 'phone':
                    $errors[$field] = self::validatePhone($value);
                    break;
                case 'email':
                    $errors[$field] = self::validateEmail($value);
                    break;
                case 'CIF':
                    $errors[$field] = self::validateCIF($value);
                    break;
                case 'managerNIF':
                    $errors[$field] = self::validateManagerNIF($value);
                    break;
                default:
                    break;
            }
        }
        return $errors;
    }

    private static function validateName($name)
    {
        $error = "";
        if (empty($name)) {
            $error = "El campo de nombre es necesario";
        } else if (!preg_match("/^[A-Za-z\s]+$/", $name)) {
            $error = "El nombre no puede contener números ni caracteres especiales";
        }
        return $error;
    }

    private static function validateCompleteAddress($completeAddress)
    {
        $error = "";
        if (empty($completeAddress)) {
            $error = "El campo de domicilio es necesario";
        }
        return $error;
    }

    private static function validatePhone($phone)
    {
        $error = "";
        if (empty($phone)) {
            $error = "El campo de teléfono es necesario";
        } else if (!preg_match("/^\d{9}$/", $phone)) {
            $error = "El teléfono debe tener 9 dígitos. El formato es: 555555555";
        }
        return $error;
    }

    private static function validateEmail($email)
    {
        $error = "";
        $emailPattern = '/^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/';
        if (empty($email)) {
            $error = "Este campo es necesario";
        } else if (!preg_match($emailPattern, $email)) {
            $error = "Email no válido. El formato es: example@gmail.com";
        }
        return $error;
    }

    private static function validateCIF($cif)
    {
        $error = "";
        $CIFPattern = '/^[A-Z]{1}[0-9]{7}[A-Z]{1}$/';
        if (empty($cif)) {
            $error = "Este campo es necesario";
        } else if (!preg_match($CIFPattern, $cif)) {
            $error = "CIF no válido";
        }
        return $error;
    }

    private static function validateManagerNIF($managerNIF)
    {
        $error = "";
        $NIFPattern = '/^[0-9]{8}[A-Z]{1}$/';
        if (empty($managerNIF)) {
            $error = "Este campo es necesario";
        } else if (!preg_match($NIFPattern, $managerNIF)) {
            $error = "NIF del gerente no válido";
        }
        return $error;
    }
}