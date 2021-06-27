<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once ("../domain/tipo_correoC.php");
require_once ("../dao/tipo_correoCDao.php");

class Tipo_CorreoCBo {

    private $tipo_correoCDao;

    public function __construct() {
        $this->tipo_correoCDao = new Tipo_correoCDao();
    }

    public function getTipo_correoCDao() {
        return $this->tipo_correoCDao;
    }

    public function setTipo_correoCDao(Tipo_correoCDao $tipo_correoCDao) {
        $this->tipo_correoCDao = $tipo_correoCDao;
    }

    //Agreagra clientes en la base de datos 
    public function add(Tipo_correoC $tipo_correoC) {
        try {
            if (!$this->tipo_correoCDao->exist($tipo_correoC)) {
                $this->tipo_correoCDao->add($tipo_correoC);
            } else {
                throw new Exception("El Cliente ya existe en la base de datos");
            }
        } catch (Exception $e) {
            throw $e;
        }
    }

    //Modifocar a un cliente ala base de datos 

    public function update(Tipo_correoC $tipo_correoC) {
        try {
            $this->tipo_correoCDao->update($tipo_correoC);
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function delete(Tipo_correoC $tipo_correoC) {
        try {
            $this->tipo_correoCDao->delete($tipo_correoC);
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function searchById(Tipo_correoC $tipo_correoC) {
        try {
            return $this->tipo_correoCDao->searchById($tipo_correoC);
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function getAll() {
        try {
            return $this->tipo_correoCDao->getAll();
        } catch (Exception $e) {
            throw $e;
        }
    }

}
