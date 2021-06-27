<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once ("../domain/facturas_detalles.php");
require_once ("../dao/facturas_detallesDao.php");

class Facturas_DetallesBo {

    private $facturas_detallesDao;

    public function __construct() {
        $this->facturas_detallesDao = new Facturas_DetallesDao();
    }

    public function getFacturas_DetallesDao() {
        return $this->facturas_detallesDao;
    }

    public function setFacturas_DetallesDao(Facturas_DetallesDao $facturas_detallesDao) {
        $this->facturas_detallesDao = $facturas_detallesDao;
    }

    //Agreagra clientes en la base de datos 
    public function add(Facturas_Detalles $facturas_detalles) {
        try {
            if (!$this->facturas_detallesDao->exist($facturas_detalles)) {
                $this->facturas_detallesDao->add($facturas_detalles);
            } else {
                throw new Exception("El Cliente ya existe en la base de datos");
            }
        } catch (Exception $e) {
            throw $e;
        }
    }

    //Modifocar a un cliente ala base de datos 

    public function update(Facturas_Detalles $facturas_detalles) {
        try {
            $this->facturas_detallesDao->update($facturas_detalles);
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function delete(Facturas_Detalles $facturas_detalles) {
        try {
            $this->facturas_detallesDao->delete($facturas_detalles);
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function searchById(Facturas_Detalles $facturas_detalles) {
        try {
            return $this->facturas_detallesDao->searchById($facturas_detalles);
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function getAll() {
        try {
            return $this->facturas_detallesDao->getAll();
        } catch (Exception $e) {
            throw $e;
        }
    }

}
