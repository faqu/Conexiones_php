<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once ("../domain/usuarios_correo_1.php");
require_once ("../dao/usuarios_correoDao.php");

class Usuarios_CorreoBo {

    private $usuarios_correoDao;

    public function __construct() {
        $this->usuarios_correoDao = new Usuarios_CorreoDao();
    }

    public function getUsuarios_CorreoDao() {
        return $this->usuarios_correoDao;
    }

    public function setUsuarios_CorreoDao(Usuarios_CorreoDao $usaurios_correoDao) {
        $this->usuarios_correoDao = $usaurios_correoDao;
    }

    //Agreagra clientes en la base de datos 
    public function add(Usuarios_Correo $usuarios_correo) {
        try {
            if (!$this->usuarios_correoDao->exist($usuarios_correo)) {
                $this->usuarios_correoDao->add($usuarios_correo);
            } else {
                throw new Exception("El Cliente ya existe en la base de datos");
            }
        } catch (Exception $e) {
            throw $e;
        }
    }

    //Modifocar a un cliente ala base de datos 

    public function update(Usuarios_Correo $usuarios_correo) {
        try {
            $this->usuarios_correoDao->update($usuarios_correo);
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function delete(Usuarios_Correo $usuarios_correo) {
        try {
            $this->usuarios_correoDao->delete($usuarios_correo);
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function searchById(Usuarios_Correo $usuarios_correo) {
        try {
            return $this->usuarios_correoDao->searchById($usuarios_correo);
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function getAll() {
        try {
            return $this->usuarios_correoDao->getAll();
        } catch (Exception $e) {
            throw $e;
        }
    }

}
