<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once ("../domain/usuarios_telefonos.php");
require_once ("../dao/usuarios_telefonosDao.php");

class Usuarios_TelefonosBo {

    private $usauarios_telefonosDao;

    public function __construct() {
        $this->usauarios_telefonosDao = new Usuarios_TelefonosDao();
    }

    public function getUsuarios_TelefonosDao() {
        return $this->usauarios_telefonosDao;
    }

    public function setUsuarios_TelefonosDao(Usuarios_TelefonosDao $usauarios_telefonosDao) {
        $this->usauarios_telefonosDao = $usauarios_telefonosDao;
    }

    //Agreagra clientes en la base de datos 
    public function add(Usuarios_Telefonos $usauarios_telefonos) {
        try {
            if (!$this->usauarios_telefonosDao->exist($usauarios_telefonos)) {
                $this->usauarios_telefonosDao->add($usauarios_telefonos);
            } else {
                throw new Exception("El Cliente ya existe en la base de datos");
            }
        } catch (Exception $e) {
            throw $e;
        }
    }

    //Modifocar a un cliente ala base de datos 

    public function update(Usuarios_Telefonos $usauarios_telefonos) {
        try {
            $this->usauarios_telefonosDao->update($usauarios_telefonos);
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function delete(Clientes_Correo $usauarios_telefonos) {
        try {
            $this->usauarios_telefonosDao->delete($usauarios_telefonos);
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function searchById(Usuarios_Telefonos $usauarios_telefonos) {
        try {
            return $this->usauarios_telefonosDao->searchById($usauarios_telefonos);
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function getAll() {
        try {
            return $this->usauarios_telefonosDao->getAll();
        } catch (Exception $e) {
            throw $e;
        }
    }

}
