<?php

require 'src/Exceptions/DatabaseException.php';

class DataBase
{
    private PDO $dbConnection;

    public function __construct(array $config)
    {
        try {
            $host = $config['host'];
            $dbName = $config['dbname'];
            $username = $config['username'];
            $password = $config['password'];

            $this->dbConnection = new PDO("mysql:host=$host;dbname=$dbName", $username, $password);
            $this->dbConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function getProviders()
    {
        try {
            $consulta = $this->dbConnection->query("SELECT * FROM proveedor");
            return $consulta->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function getVehicles()
    {
        try {
            $consulta = $this->dbConnection->query("SELECT * FROM vehiculo");
            return $consulta->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function getProviderById($providerId)
    {
        try {
            $consulta = $this->dbConnection->prepare("SELECT * FROM proveedor WHERE ID = :providerId");
            $consulta->execute([':providerId' => $providerId]);
            return $consulta->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function getVehicleById($vehicleId)
    {
        try {
            $consulta = $this->dbConnection->prepare("SELECT * FROM vehiculo WHERE id = :vehicleId");
            $consulta->execute([':vehicleId' => $vehicleId]);
            return $consulta->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }


    public function insertProvider(Provider $provider)
    {
        try {
            $consulta = $this->dbConnection->prepare("INSERT INTO proveedor ( documento_LOPD, NIF_Gerente, documento_constitucion, CIF, certificado_cuenta_bancaria, domicilio_completo, telefono, nombre, correo_electronico) 
VALUES (:documento_LOPD, :NIF_Gerente, :documento_constitucion, :CIF, :certificado_cuenta_bancaria, :domicilio_completo, :telefono, :nombre, :correo_electronico)");

            $values = [
                ':documento_LOPD' => '',
                ':NIF_Gerente' => $provider->getManagerNIF(),
                ':documento_constitucion' => '',
                ':CIF' => $provider->getCIF(),
                ':certificado_cuenta_bancaria' => '',
                ':domicilio_completo' => $provider->getCompleteAddress(),
                ':telefono' => $provider->getPhone(),
                ':nombre' => $provider->getName(),
                ':correo_electronico' => $provider->getEmail(),
            ];

            $success = $consulta->execute($values);

            if ($success) {
                return true;
            } else {
                throw new DatabaseException("Error al insertar datos en la base de datos");
            }
        } catch (DatabaseException|PDOException $e) {
            die($e->getMessage());
        }
    }

    public function insertVehicle(Vehicle $vehicle)
    {
        try {
            $consulta = $this->dbConnection->prepare("INSERT INTO vehiculo (matricula, marca, modelo, color, danos, id_modelo, tipo_carburante, fecha_matriculacion, 
            kilometros, id_marca, descripcion, iva, num_bastidor, tipo_cambio, precio_venta, precio_compra, proveedor, nuevo, transporte_incluido, imagen, id_comanda) 
            VALUES (:matricula, :marca, :modelo, :color, :danos, :id_modelo, :tipo_carburante, STR_TO_DATE(:fecha_matriculacion, '%Y-%m-%d'), 
            :kilometros, :id_marca, :descripcion, :iva, :num_bastidor, :tipo_cambio, :precio_venta, :precio_compra, :proveedor, :nuevo, :transporte_incluido, :imagen, :id_comanda)");

            $values = [
                ':matricula' => $vehicle->getPlate(),
                ':marca' => $vehicle->getBrand(),
                ':modelo' => $vehicle->getModel(),
                ':color' => $vehicle->getColor(),
                ':danos' => $vehicle->getObservedDamages(),
                ':id_modelo' => null,
                ':tipo_carburante' => $vehicle->getFuel(),
                ':fecha_matriculacion' => $vehicle->getRegistrationDate()->format('Y-m-d'),
                ':kilometros' => $vehicle->getKm(),
                ':id_marca' => null,
                ':descripcion' => $vehicle->getDescription(),
                ':iva' => $vehicle->getIva(),
                ':num_bastidor' => $vehicle->getNumChassis(),
                ':tipo_cambio' => $vehicle->getGearShift(),
                ':precio_venta' => $vehicle->getSellPrice(),
                ':precio_compra' => $vehicle->getBuyPrice(),
                ':proveedor' => $vehicle->getProvider(),
                ':nuevo' => $vehicle->isNew(),
                ':transporte_incluido' => $vehicle->isIncludedTransport(),
                ':imagen' => "uploads/". $vehicle->getImage()->getName(),
                ':id_comanda' => null,
            ];

            $success = $consulta->execute($values);

            if ($success) {
                return true;
            } else {
                throw new DatabaseException("Error al insertar datos del vehículo en la base de datos");
            }
        } catch (DatabaseException|PDOException $e) {
            die($e->getMessage());
        }
    }

    public function deleteProvider($providerId)
    {
        try {
            $consulta = $this->dbConnection->prepare("DELETE FROM proveedor WHERE ID = :id");
            $consulta->execute([':id' => $providerId]);
            return true;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function deleteVehicle($vehicleId)
    {
        try {
            $consulta = $this->dbConnection->prepare("DELETE FROM vehiculo WHERE id = :id");
            $consulta->execute([':id' => $vehicleId]);
            return true;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function updateProvider($providerId, Provider $provider)
    {
        try {
            $consulta = $this->dbConnection->prepare("UPDATE proveedor 
            SET CIF = :CIF, NIF_Gerente = :NIF_Gerente, 
                domicilio_completo = :domicilio_completo, telefono = :telefono, 
                nombre = :nombre, correo_electronico = :correo_electronico 
            WHERE ID = :providerId");

            $values = [
                ':CIF' => $provider->getCIF(),
                ':NIF_Gerente' => $provider->getManagerNIF(),
                ':domicilio_completo' => $provider->getCompleteAddress(),
                ':telefono' => $provider->getPhone(),
                ':nombre' => $provider->getName(),
                ':correo_electronico' => $provider->getEmail(),
                ':providerId' => $providerId,
            ];

            $success = $consulta->execute($values);

            if ($success) {
                return true;
            } else {
                throw new DatabaseException("Error al actualizar datos del proveedor en la base de datos");
            }
        } catch (DatabaseException|PDOException $e) {
            die($e->getMessage());
        }
    }

    public function updateVehicle($vehicleId, Vehicle $vehicle)
    {
        try {
            $consulta = $this->dbConnection->prepare("UPDATE vehiculo 
            SET matricula = :matricula, marca = :marca, modelo = :modelo, color = :color, danos = :danos, 
                tipo_carburante = :tipo_carburante, fecha_matriculacion = STR_TO_DATE(:fecha_matriculacion, '%Y-%m-%d'), 
                kilometros = :kilometros, descripcion = :descripcion, iva = :iva, 
                num_bastidor = :num_bastidor, tipo_cambio = :tipo_cambio, 
                precio_venta = :precio_venta, proveedor = :proveedor, nuevo = :nuevo, transporte_incluido = :transporte_incluido, imagen = :imagen, precio_compra = :precio_compra 
            WHERE id = :vehicleId");

            $values = [
                ':matricula' => $vehicle->getPlate(),
                ':marca' => $vehicle->getBrand(),
                ':modelo' => $vehicle->getModel(),
                ':color' => $vehicle->getColor(),
                ':danos' => $vehicle->getObservedDamages(),
                ':tipo_carburante' => $vehicle->getFuel(),
                ':fecha_matriculacion' => $vehicle->getRegistrationDate()->format('Y-m-d'),
                ':kilometros' => $vehicle->getKm(),
                ':descripcion' => $vehicle->getDescription(),
                ':iva' => $vehicle->getIva(),
                ':num_bastidor' => $vehicle->getNumChassis(),
                ':tipo_cambio' => $vehicle->getGearShift(),
                ':precio_venta' => $vehicle->getSellPrice(),
                'proveedor' => $vehicle->getProvider(),
                'nuevo' => $vehicle->isNew(),
                'transporte_incluido' => $vehicle->isIncludedTransport(),
                'imagen' => "uploads/". $vehicle->getImage()->getName(),
                ':precio_compra' => $vehicle->getBuyPrice(),
                ':vehicleId' => $vehicleId,
            ];

            $success = $consulta->execute($values);

            if ($success) {
                return true;
            } else {
                throw new DatabaseException("Error al actualizar datos del vehículo en la base de datos");
            }
        } catch (DatabaseException|PDOException $e) {
            die($e->getMessage());
        }
    }

}