<?php

require_once ("../bo/clientesBo.php");
require_once ("../domain/clientes.php");
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
if (filter_input(INPUT_POST, 'action') != null) {
    $action = filter_input(INPUT_POST, 'action');
    
    //choose the action
    try{
        $myClientesBo = new ClientesBo();
        $myClientes = Clientes::createNullClientes();
        
        if ($action === "add_clientes" or $action === "update_clientes") {
            //se valida que los parametros hayan sido enviados por post
            if ((filter_input(INPUT_POST, 'PK_idClientes') != null) && (filter_input(INPUT_POST, 'Codigo') != null) && (filter_input(INPUT_POST, 'Password') != null) && (filter_input(INPUT_POST, 'Nombre') != null) && (filter_input(INPUT_POST, 'Apellido1') != null) && (filter_input(INPUT_POST, 'Apellido2') != null) && (filter_input(INPUT_POST, 'Fecha_Nacimiento') != null)) {
                $myClientes->setPK_idClientes(filter_input(INPUT_POST, 'PK_idClientes'));
                $myClientes->setCodigo(filter_input(INPUT_POST, 'Codigo'));
                $myClientes->setPassword(filter_input(INPUT_POST, 'Password'));
                $myClientes->setNombre(filter_input(INPUT_POST, 'Nombre'));
                $myClientes->setApellido1(filter_input(INPUT_POST, 'Apellido1'));
                $myClientes->setApellido2(filter_input(INPUT_POST, 'Apellido2'));
                $myClientes->setFecha_Nacimiento(filter_input(INPUT_POST, 'Fecha_Nacimiento'));
                $myClientes->setLastUser('112540148');
                if ($action == "add_clientes") {
                    $myClientesBo->add($myClientes);
                    echo('M~Registro Incluido Correctamente');
                }
                if ($action=="update_clientes"){
                    $myClientesBo->update($myClientes);
                    echo ('M~Registro Modificado Correctamente');
                }
            }
        }
        
        if ($action === "showAll_clientes") {//accion de consultar todos los registros
            $resultDB   = $myClientesBo->getAll();
            $json       = json_encode($resultDB->GetArray());
            $resultado = '{"data": ' . $json . '}';
            if($resultDB->RecordCount() === 0){
                $resultado = '{"data": []}';
            }
            echo $resultado;
        }
        
        if ($action==="show_clientes"){
            if(filter_input(INPUT_POST, 'PK_idClientes')!=null){
                $myClientes->setPK_idClientes(filter_input(INPUT_POST, 'PK_idClientes'));
                $myClientes= $myClientesBo->searchById($myClientes);
                if($myClientes!=null){
                    echo json_encode(($myClientes));
                } else {
                    echo('E~NO Existe un Cliente con el ID especificado');
                }
            }
        }
        
        if ($action==="delete_clientes"){
            if(filter_input(INPUT_POST, 'PK_idClientes')!=null){
                $myClientes->setPK_idClientes(filter_input(INPUT_POST, 'PK_idClientes'));
                $myClientesBo->delete($myClientes);
                echo ('M~El Registro Fue Eliminado Correctamente');
            }
        }
    } catch (Exception $e) { //exception generated in the business object..
        echo("E~" . $e->getMessage());
    }
} else{
    echo ("M~Parametros no enviados desde el formulario");
}
?>