<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once ("../domain/tipo_telefomoC_1.php");
require_once ("../dao/tipo_telefonoCDao_1.php");

class Tipo_TelefonoCBo {

    private $tipo_telefonoCDao;

    public function __construct() {
        $this->tipo_telefonoCDao = new Tipo_TelefonoCDao();
    }

    public function getTipo_telefonoCDao() {
        return $this->tipo_telefonoCDao;
    }

    public function setTipo_telefonoCDao(Tipo_TelefonoCDao $tipo_telefonoCDao) {
        $this->tipo_telefonoCDao = $tipo_telefonoCDao;
    }

    //Agreagra clientes en la base de datos 
    public function add(Tipo_TelefonoC $tipo_telefonoC) {
        try {
            if (!$this->tipo_telefonoCDao->exist($tipo_telefonoC)) {
                $this->tipo_telefonoCDao->add($tipo_telefonoC);
            } else {
                throw new Exception("El Cliente ya existe en la base de datos");
            }
        } catch (Exception $e) {
            throw $e;
        }
    }

    //Modifocar a un cliente ala base de datos 

    public function update(Tipo_TelefonoC $tipo_telefonoC) {
        try {
            $this->tipo_telefonoCDao->update($tipo_telefonoC);
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function delete(Tipo_TelefonoC $tipo_telefonoC) {
        try {
            $this->tipo_telefonoCDao->delete($tipo_telefonoC);
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function searchById(Tipo_TelefonoC $tipo_telefonoC) {
        try {
            return $this->tipo_telefonoCDao->searchById($tipo_telefonoC);
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function getAll() {
        try {
            return $this->tipo_telefonoCDao->getAll();
        } catch (Exception $e) {
            throw $e;
        }
    }

}
