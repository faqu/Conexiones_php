<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once ("../domain/facturas.php");
require_once ("../dao/facturasDao.php");

class FacturasBo {

    private $facturasDao;

    public function __construct() {
        $this->facturasDao = new FacturasDao();
    }

    public function getFacturasDao() {
        return $this->facturasDao;
    }

    public function setFacturasDao(FacturasDao $facturasDao) {
        $this->facturasDao = $facturasDao;
    }

    //Agreagra clientes en la base de datos 
    public function add(Facturas $facturas) {
        try {
            if (!$this->facturasDao->exist($facturas)) {
                $this->facturasDao->add($facturas);
            } else {
                throw new Exception("El Cliente ya existe en la base de datos");
            }
        } catch (Exception $e) {
            throw $e;
        }
    }

    //Modifocar a un cliente ala base de datos 

    public function update(Facturas $facturas) {
        try {
            $this->facturasDao->update($facturas);
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function delete(Facturas $facturas) {
        try {
            $this->facturasDao->delete($facturas);
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function searchById(Facturas $facturas) {
        try {
            return $this->facturasDao->searchById($facturas);
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function getAll() {
        try {
            return $this->facturasDao->getAll();
        } catch (Exception $e) {
            throw $e;
        }
    }

}
