<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once ("../domain/usuarios.php");
require_once ("../dao/usuariosDao.php");

class UsuariosBo {

    private $usuariosDao;

    public function __construct() {
        $this->usuariosDao = new UsuariosDao();
    }

    public function getUsuariosDao() {
        return $this->usuariosDao;
    }

    public function setUsuariosDao(UsuariosDao $usuariosDao) {
        $this->usuariosDao = $usuariosDao;
    }

    //Agreagra clientes en la base de datos 
    public function add(Usuarios $usuarios) {
        try {
            if (!$this->usuariosDao->exist($usuarios)) {
                $this->usuariosDao->add($usuarios);
            } else {
                throw new Exception("El Cliente ya existe en la base de datos");
            }
        } catch (Exception $e) {
            throw $e;
        }
    }

    //Modifocar a un cliente ala base de datos 

    public function update(Usuarios $usuarios) {
        try {
            $this->usuariosDao->update($usuarios);
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function delete(Usuarios $usuarios) {
        try {
            $this->usuariosDao->delete($usuarios);
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function searchById(Usuarios $usuarios) {
        try {
            return $this->usuariosDao->searchById($usuarios);
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function getAll() {
        try {
            return $this->usuariosDao->getAll();
        } catch (Exception $e) {
            throw $e;
        }
    }

}
