<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once ("../domain/tipos_usuarios.php");
require_once ("../dao/tipos_usuariosDao.php");

class Tipos_UsuariosBo {

    private $tipos_usuariosDao;

    public function __construct() {
        $this->tipos_usuariosDao = new Tipos_UsuariosDao();
    }

    public function getTipos_UsuariosDao() {
        return $this->tipos_usuariosDao;
    }

    public function setTipos_UsuariosDao(Tipos_UsuariosDao $tipos_usuariosDao) {
        $this->tipos_usuariosDao = $tipos_usuariosDao;
    }

    //Agreagra clientes en la base de datos 
    public function add(Tipos_Usuarios $tipos_usuarios) {
        try {
            if (!$this->tipos_usuariosDao->exist($tipos_usuarios)) {
                $this->tipos_usuariosDao->add($tipos_usuarios);
            } else {
                throw new Exception("El Cliente ya existe en la base de datos");
            }
        } catch (Exception $e) {
            throw $e;
        }
    }

    //Modifocar a un cliente ala base de datos 

    public function update(Tipos_Usuarios $tipos_usuarios) {
        try {
            $this->tipos_usuariosDao->update($tipos_usuarios);
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function delete(Tipos_Usuarios $tipos_usuarios) {
        try {
            $this->tipos_usuariosDao->delete($tipos_usuarios);
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function searchById(Tipos_Usuarios $tipos_usuarios) {
        try {
            return $this->tipos_usuariosDao->searchById($tipos_usuarios);
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function getAll() {
        try {
            return $this->tipos_usuariosDao->getAll();
        } catch (Exception $e) {
            throw $e;
        }
    }

}
