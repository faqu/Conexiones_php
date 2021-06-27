<?php

require_once ("../bo/temas_expertoBo.php");
require_once ("../domain/temas_experto.php");
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
if (filter_input(INPUT_POST, 'action') != null) {
    $action = filter_input(INPUT_POST, 'action');

    //choose the action
    try {
        $myTemas_ExpertosBo = new Temas_ExpertoBo();
        $myTemas_Expertos = Temas_Experto::createNullTemas_Experto();

        if ($action === "add_temas_expertos" or $action === "update_temas_expertos") {
            //se valida que los parametros hayan sido enviados por post
            if ((filter_input(INPUT_POST, 'idTemas_Expertos') != null) && (filter_input(INPUT_POST, 'Observaciones') != null) && (filter_input(INPUT_POST, 'Estado') != null) && (filter_input(INPUT_POST, 'Temas_idTemas') != null)&& (filter_input(INPUT_POST, 'Usuarios_PK_idUsuarios') != null)) {
                $myTemas_Expertos->setidTemas_Expertos(filter_input(INPUT_POST, 'idTemas_Expertos'));
                $myTemas_Expertos->setObservaciones(filter_input(INPUT_POST, 'Observaciones'));
                $myTemas_Expertos->setEstado(filter_input(INPUT_POST, 'Estado'));
                $myTemas_Expertos->setTemas_idTemas(filter_input(INPUT_POST, 'Temas_idTemas'));
                $myTemas_Expertos->setUsuarios_PK_idUsuarios(filter_input(INPUT_POST, 'Usuarios_PK_idUsuarios'));
                if ($action == "add_temas_expertos") {
                    $myTemas_ExpertosBo->add($myTemas_Expertos);
                    echo('M~Registro Incluido Correctamente');
                }
                if ($action == "update_temas_expertos") {
                    $myTemas_ExpertosBo->update($myTemas_Expertos);
                    echo ('M~Registro Modificado Correctamente');
                }
            }
        }

        if ($action === "showAll_temas_expertos") {//accion de consultar todos los registros
            $resultDB = $myTemas_ExpertosBo->getAll();
            $json = json_encode($resultDB->GetArray());
            $resultado = '{"data": ' . $json . '}';
            if ($resultDB->RecordCount() === 0) {
                $resultado = '{"data": []}';
            }
            echo $resultado;
        }

        if ($action === "show_temas_expertos") {
            if (filter_input(INPUT_POST, 'idTemas_Expertos') != null) {
                $myTemas_Expertos->setidTemas_Expertos(filter_input(INPUT_POST, 'idTemas_Expertos'));
                $myTemas_Expertos = $myTemas_ExpertosBo->searchById($myTemas_Expertos);
                if ($myTemas_Expertos != null) {
                    echo json_encode(($myClientes_Correo));
                } else {
                    echo('E~NO Existe un Cliente con el ID especificado');
                }
            }
        }

        if ($action === "delete_temas_expertos") {
            if (filter_input(INPUT_POST, 'idTemas_Expertos') != null) {
                $myTemas_Expertos->setidTemas_Expertos(filter_input(INPUT_POST, 'idTemas_Expertos'));
                $myTemas_ExpertosBo->delete($myTemas);
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