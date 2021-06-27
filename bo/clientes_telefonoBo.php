<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once ("../domain/clientes_telefono.php");
require_once ("../dao/clientes_telefonosDao.php");

class Clientes_TelefonosBo {

    private $clientes_telefonosDao;

    public function __construct() {
        $this->clientes_telefonosDao = new Clientes_TelefonosDao();
    }

    public function getClientes_TelefonosDao() {
        return $this->clientes_telefonosDao;
    }

    public function setClientes_TelefonosDao(Clientes_TelefonosDao $clientes_telefonosDao) {
        $this->clientes_telefonosDao = $clientes_telefonosDao;
    }

    //Agreagra clientes en la base de datos 
    public function add(Clientes_Telefonos $clientes_telefonosDao) {
        try {
            if (!$this->clientes_telefonosDao->exist($clientes_telefonosDao)) {
                $this->clientes_telefonosDao->add($clientes_telefonosDao);
            } else {
                throw new Exception("El Cliente ya existe en la base de datos");
            }
        } catch (Exception $e) {
            throw $e;
        }
    }

    //Modifocar a un cliente ala base de datos 

    public function update(Clientes_Telefonos $clientes_telefonosDao) {
        try {
            $this->clientes_telefonosDao->update($clientes_telefonosDao);
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function delete(Clientes_Telefonos $clientes_telefonosDao) {
        try {
            $this->clientes_telefonosDao->delete($clientes_telefonosDao);
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function searchById(Clientes_Telefonos $clientes_telefonos) {
        try {
            return $this->clientes_telefonosDao->searchById($clientes_telefonos);
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function getAll() {
        try {
            return $this->clientes_telefonosDao->getAll();
        } catch (Exception $e) {
            throw $e;
        }
    }

}
