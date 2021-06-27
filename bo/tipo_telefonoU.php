<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once ("../domain/tipo_telefomoU_1.php");
require_once ("../dao/tipo_telefonoUDao_1.php");

class Tipo_TelefonosUBo {

    private $tipo_telefonosUDao;

    public function __construct() {
        $this->tipo_telefonosUDao = new Tipo_TelefonosUDao();
    }

    public function getTipo_telefonoUDao() {
        return $this->tipo_telefonosUDao;
    }

    public function setTipo_telefonoCDao(Tipo_TelefonosUDao $tipo_telefonosUDao) {
        $this->tipo_telefonosUDao = $tipo_telefonosUDao;
    }

    //Agreagra clientes en la base de datos 
    public function add(Tipo_TelefonosU $tipo_telefonosU) {
        try {
            if (!$this->tipo_telefonosUDao->exist($tipo_telefonosU)) {
                $this->tipo_telefonosUDao->add($tipo_telefonosU);
            } else {
                throw new Exception("El Cliente ya existe en la base de datos");
            }
        } catch (Exception $e) {
            throw $e;
        }
    }

    //Modifocar a un cliente ala base de datos 

    public function update(Tipo_TelefonosU $tipo_telefonosU) {
        try {
            $this->tipo_telefonosUDao->update($tipo_telefonosU);
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function delete(Tipo_TelefonosU $tipo_telefonosU) {
        try {
            $this->tipo_telefonosUDao->delete($tipo_telefonosU);
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function searchById(Tipo_TelefonosU $tipo_telefonosU) {
        try {
            return $this->tipo_telefonosUDao->searchById($tipo_telefonosU);
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function getAll() {
        try {
            return $this->tipo_telefonosUDao->getAll();
        } catch (Exception $e) {
            throw $e;
        }
    }

}
