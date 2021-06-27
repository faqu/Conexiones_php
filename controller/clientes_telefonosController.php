<?php

require_once ("../bo/clientes_telefonoBo.php");
require_once ("../domain/clientes_telefono.php");
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
if (filter_input(INPUT_POST, 'action') != null) {
    $action = filter_input(INPUT_POST, 'action');

    //choose the action
    try {
        $myClientes_TelefonosBo = new Clientes_CorreoBo();
        $myClientes_Telefonos = Clientes_Telefonos::createNullClientes_Telefonos();

        if ($action === "add_clientes_telefonos" or $action === "clientes_clientes_telefonos") {
            //se valida que los parametros hayan sido enviados por post
            if ((filter_input(INPUT_POST, 'idClientes_Telefono') != null) && (filter_input(INPUT_POST, 'Estado') != null) && (filter_input(INPUT_POST, 'Clientes_PK_idClientes') != null) && (filter_input(INPUT_POST, 'Tipo_TelefonoC_idTipo_TelefonoC') != null)) {
                $myClientes_Telefonos->setidClientes_Telefono(filter_input(INPUT_POST, 'idClientes_Telefono'));
                $myClientes_Telefonos->setEstado(filter_input(INPUT_POST, 'Estado'));
                $myClientes_Telefonos->setClientes_PK_idClientes(filter_input(INPUT_POST, 'Clientes_PK_idClientes'));
                $myClientes_Telefonos->setTipo_TelefonoC_idTipo_TelefonoC(filter_input(INPUT_POST, 'Tipo_TelefonoC_idTipo_TelefonoC'));
                if ($action == "add_clientes_telefonos") {
                    $myClientes_TelefonosBo->add($myClientes_Telefonos);
                    echo('M~Registro Incluido Correctamente');
                }
                if ($action == "update_clientes_telefonos") {
                    $myClientes_TelefonosBo->update($myClientes_Telefonos);
                    echo ('M~Registro Modificado Correctamente');
                }
            }
        }

        if ($action === "showAll_clientes_telefonos") {//accion de consultar todos los registros
            $resultDB = $myClientes_TelefonosBo->getAll();
            $json = json_encode($resultDB->GetArray());
            $resultado = '{"data": ' . $json . '}';
            if ($resultDB->RecordCount() === 0) {
                $resultado = '{"data": []}';
            }
            echo $resultado;
        }

        if ($action === "show_clientes_telefonos") {
            if (filter_input(INPUT_POST, 'idClientes_Telefono') != null) {
                $myClientes_Telefonos->setidClientes_Telefono(filter_input(INPUT_POST, 'idClientes_Telefono'));
                $myClientes_Telefonos = $myClientes_TelefonosBo->searchById($myClientes_Telefonos);
                if ($myClientes_Telefonos != null) {
                    echo json_encode(($myClientes_Telefonos));
                } else {
                    echo('E~NO Existe un Cliente con el ID especificado');
                }
            }
        }

        if ($action === "delete_clientes_telefonos") {
            if (filter_input(INPUT_POST, 'idClientes_Telefono') != null) {
                $myClientes_Telefonos->setidClientes_Telefono(filter_input(INPUT_POST, 'idClientes_Telefono'));
                $myClientes_TelefonosBo->delete($myClientes_Telefonos);
                echo ('M~El Registro Fue Eliminado Correctamente');
            }
        }
    } catch (Exception $e) { //exception generated in the business object..
        echo("E~" . $e->getMessage());
    }
} else {
    echo ("M~Parametros no enviados desde el formulario");
}
?>