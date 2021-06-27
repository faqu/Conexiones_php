<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once ("../domain/temas.php");
require_once ("../dao/temasDao.php");

class TemasBo {

    private $temasDao;

    public function __construct() {
        $this->temasDao = new TemasDao();
    }

    public function getClientes_CorreoDao() {
        return $this->temasDao;
    }

    public function setTemasDao(TemasDao $temasDao) {
        $this->temasDao = $temasDao;
    }

    //Agreagra clientes en la base de datos 
    public function add(Temas $temas) {
        try {
            if (!$this->temasDao->exist($temas)) {
                $this->temasDao->add($temas);
            } else {
                throw new Exception("El Cliente ya existe en la base de datos");
            }
        } catch (Exception $e) {
            throw $e;
        }
    }

    //Modifocar a un cliente ala base de datos 

    public function update(Temas $temas) {
        try {
            $this->temasDao->update($temas);
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function delete(Temas $temas) {
        try {
            $this->temasDao->delete($temas);
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function searchById(Temas $temas) {
        try {
            return $this->temasDao->searchById($temas);
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function getAll() {
        try {
            return $this->temasDao->getAll();
        } catch (Exception $e) {
            throw $e;
        }
    }

}
