<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once ("../domain/tipo_correoU.php");
require_once ("../dao/tipo_correoUDao.php");

class Tipo_CorreoUBo {

    private $tipo_correoUDao;

    public function __construct() {
        $this->tipo_correoUDao = new Tipo_correoUDao();
    }

    public function getTipo_correoUDao() {
        return $this->tipo_correoUDao;
    }

    public function setTipo_correoUDao(Tipo_correoUDao $tipo_correoUDao) {
        $this->tipo_correoUDao = $tipo_correoUDao;
    }

    //Agreagra clientes en la base de datos 
    public function add(Tipo_correoU $tipo_correoU) {
        try {
            if (!$this->tipo_correoUDao->exist($tipo_correoU)) {
                $this->tipo_correoUDao->add($tipo_correoU);
            } else {
                throw new Exception("El Cliente ya existe en la base de datos");
            }
        } catch (Exception $e) {
            throw $e;
        }
    }

    //Modifocar a un cliente ala base de datos 

    public function update(Tipo_correoU $tipo_correoU) {
        try {
            $this->tipo_correoUDao->update($tipo_correoU);
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function delete(Tipo_correoU $tipo_correoU) {
        try {
            $this->tipo_correoUDao->delete($tipo_correoU);
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function searchById(Tipo_correoU $tipo_correoU) {
        try {
            return $this->tipo_correoUDao->searchById($tipo_correoU);
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function getAll() {
        try {
            return $this->tipo_correoUDao->getAll();
        } catch (Exception $e) {
            throw $e;
        }
    }

}
