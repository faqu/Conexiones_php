<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once ("../domain/clientes.php");
require_once ("../dao/clientesDao.php");
class ClientesBo{
    private $clientesDao;
    
    public function __construct() {
        $this->clientesDao = new ClientesDao();
    }
    
    public function getClientesDao() {
        return $this->clientesDao;
    }
    public function setClientesDao(ClientesDao $clientesDao) {
        $this->clientesDao= $clientesDao;
    }
    
    //Agreagra clientes en la base de datos 
    public function add(Clientes $clientes) {
        try{
            if (!$this->clientesDao->exist($clientes)) {
                $this->clientesDao->add($clientes);
            }  else {
                throw new Exception("El Cliente ya existe en la base de datos");
            }
        } catch (Exception $e){
            throw $e;
        }
    }
    
    //Modifocar a un cliente ala base de datos 
    
    public function update(Clientes $clientes) {
        try {
            $this->clientesDao->update($clientes);
        } catch (Exception $e) {
            throw $e;
        }
    }
    
    
    public function delete(Clientes $clientes) {
        try {
            $this->clientesDao->delete($clientes);
        } catch (Exception $e) {
            throw $e;
        }
    }
    
    
    public function searchById(Clientes $clientes) {
        try {
            return $this->clientesDao->searchById($clientes);
        } catch (Exception $e) {
            throw $e;
        }
    }
    
    
    public function getAll() {
        try {
           return $this->clientesDao->getAll();
        } catch (Exception $e) {
            throw $e;
        }
    }
}