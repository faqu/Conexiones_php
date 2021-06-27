<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once ("../domain/temas_experto.php");
require_once ("../dao/temas_expertoDao.php");

class Temas_ExpertoBo {

    private $temas_expertoDao;

    public function __construct() {
        $this->temas_expertoDao = new Temas_ExpertosDao();
    }

    public function getTemas_ExpertoDao() {
        return $this->temas_expertoDao;
    }

    public function seTemas_ExpertoDao(Temas_ExpertoDao $temas_expertoDao) {
        $this->temas_experto = $temas_expertoDao;
    }

    //Agreagra clientes en la base de datos 
    public function add(Temas_Experto $temas_experto) {
        try {
            if (!$this->temas_expertoDao->exist($temas_experto)) {
                $this->temas_expertoDao->add($temas_experto);
            } else {
                throw new Exception("El Cliente ya existe en la base de datos");
            }
        } catch (Exception $e) {
            throw $e;
        }
    }

    //Modifocar a un cliente ala base de datos 

    public function update(Temas_Experto $temas_experto) {
        try {
            $this->temas_expertoDao->update($temas_experto);
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function delete(Temas_Experto $temas_experto) {
        try {
            $this->temas_expertoDao->delete($temas_experto);
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function searchById(Temas_Experto $temas_experto) {
        try {
            return $this->temas_expertoDao->searchById($temas_experto);
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function getAll() {
        try {
            return $this->temas_expertoDao->getAll();
        } catch (Exception $e) {
            throw $e;
        }
    }

}
