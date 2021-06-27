<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once ("../domain/clientes_correo.php");
require_once ("../dao/clientes_correoDao_1.php");

class Clientes_CorreoBo {

    private $clientes_correoDao;

    public function __construct() {
        $this->clientes_correoDao = new Clientes_CorreoDao();
    }

    public function getClientes_CorreoDao() {
        return $this->clientes_correoDao;
    }

    public function setClientes_CorreoDao(Clientes_CorreoDao $clientes_correoDao) {
        $this->clientes_correoDao = $clientes_correoDao;
    }

    //Agreagra clientes en la base de datos 
    public function add(Clientes_Correo $clientes_correoDao) {
        try {
            if (!$this->clientes_correoDao->exist($clientes_correoDao)) {
                $this->clientes_correoDao->add($clientes_correoDao);
            } else {
                throw new Exception("El Cliente ya existe en la base de datos");
            }
        } catch (Exception $e) {
            throw $e;
        }
    }

    //Modifocar a un cliente ala base de datos 

    public function update(Clientes_Correo $clientes_correoDao) {
        try {
            $this->clientes_correoDao->update($clientes_correoDao);
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function delete(Clientes_Correo $clientes_correoDao) {
        try {
            $this->clientes_correoDao->delete($clientes_correoDao);
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function searchById(Clientes_Correo $clientes_correoDao) {
        try {
            return $this->clientes_correoDao->searchById($clientes_correoDao);
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function getAll() {
        try {
            return $this->clientes_correoDao->getAll();
        } catch (Exception $e) {
            throw $e;
        }
    }

}
