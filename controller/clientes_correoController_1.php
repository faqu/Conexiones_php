<?php

require_once ("../bo/clientes_correoBo_1.php");
require_once ("../domain/clientes_correo.php");
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
if (filter_input(INPUT_POST, 'action') != null) {
    $action = filter_input(INPUT_POST, 'action');

    //choose the action
    try {
        $myClientes_CorreoBo = new Clientes_CorreoBo();
        $myClientes_Correo = Clientes_Correo::createNullClientes_Correo();

        if ($action === "add_clientes_correo" or $action === "clientes_clientes_correo") {
            //se valida que los parametros hayan sido enviados por post
            if ((filter_input(INPUT_POST, 'idCorreo_Clientes') != null) && (filter_input(INPUT_POST, 'Estado') != null) && (filter_input(INPUT_POST, 'Clientes_PK_idClientes') != null) && (filter_input(INPUT_POST, 'Tipo_CorreoC_idTipo_CorreoC') != null)) {
                $myClientes_Correo->setidCorreo_Clientes(filter_input(INPUT_POST, 'idCorreo_Clientes'));
                $myClientes_Correo->setEstado(filter_input(INPUT_POST, 'Estado'));
                $myClientes_Correo->setClientes_PK_idClientes(filter_input(INPUT_POST, 'Clientes_PK_idClientes'));
                $myClientes_Correo->setTipo_CorreoC_idTipo_CorreoC(filter_input(INPUT_POST, 'Tipo_CorreoC_idTipo_CorreoC'));
                if ($action == "add_clientes_correo") {
                    $myClientes_CorreoBo->add($myClientes_Correo);
                    echo('M~Registro Incluido Correctamente');
                }
                if ($action == "update_clientes_correo") {
                    $myClientes_CorreoBo->update($myClientes_Correo);
                    echo ('M~Registro Modificado Correctamente');
                }
            }
        }

        if ($action === "showAll_clientes_correo") {//accion de consultar todos los registros
            $resultDB = $myClientes_CorreoBo->getAll();
            $json = json_encode($resultDB->GetArray());
            $resultado = '{"data": ' . $json . '}';
            if ($resultDB->RecordCount() === 0) {
                $resultado = '{"data": []}';
            }
            echo $resultado;
        }

        if ($action === "show_clientes_correo") {
            if (filter_input(INPUT_POST, 'idCorreo_Clientes') != null) {
                $myClientes_Correo->setidCorreo_Clientes(filter_input(INPUT_POST, 'idCorreo_Clientes'));
                $myClientes_Correo = $myClientes_CorreoBo->searchById($myClientes_Correo);
                if ($myClientes_Correo != null) {
                    echo json_encode(($myClientes_Correo));
                } else {
                    echo('E~NO Existe un Cliente con el ID especificado');
                }
            }
        }

        if ($action === "delete_clientes_correo") {
            if (filter_input(INPUT_POST, 'idCorreo_Clientes') != null) {
                $myClientes_Correo->setidCorreo_Clientes(filter_input(INPUT_POST, 'idCorreo_Clientes'));
                $myClientes_CorreoBo->delete($myClientes_Correo);
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