<?php

require_once ("../bo/temasBo.php");
require_once ("../domain/temas.php");
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
if (filter_input(INPUT_POST, 'action') != null) {
    $action = filter_input(INPUT_POST, 'action');

    //choose the action
    try {
        $myTemasBo = new TemasBo();
        $myTemas = Temas::createNullTemas();

        if ($action === "add_temas" or $action === "update_temas") {
            //se valida que los parametros hayan sido enviados por post
            if ((filter_input(INPUT_POST, 'idTemas') != null) && (filter_input(INPUT_POST, 'Nombre') != null) && (filter_input(INPUT_POST, 'Costo') != null) && (filter_input(INPUT_POST, 'Observaciones') != null)&& (filter_input(INPUT_POST, 'Estado') != null)) {
                $myTemas->setidTemas(filter_input(INPUT_POST, 'idTemas'));
                $myTemas->setNombre(filter_input(INPUT_POST, 'Nombre'));
                $myTemas->setCosto(filter_input(INPUT_POST, 'Costo'));
                $myTemas->setObservaciones(filter_input(INPUT_POST, 'Observaciones'));
                $myTemas->setEstado(filter_input(INPUT_POST, 'Estado'));
                if ($action == "add_temas") {
                    $myTemasBo->add($myTemas);
                    echo('M~Registro Incluido Correctamente');
                }
                if ($action == "update_temas") {
                    $myTemasBo->update($myTemas);
                    echo ('M~Registro Modificado Correctamente');
                }
            }
        }

        if ($action === "showAll_temas") {//accion de consultar todos los registros
            $resultDB = $myTemasBo->getAll();
            $json = json_encode($resultDB->GetArray());
            $resultado = '{"data": ' . $json . '}';
            if ($resultDB->RecordCount() === 0) {
                $resultado = '{"data": []}';
            }
            echo $resultado;
        }

        if ($action === "show_temas") {
            if (filter_input(INPUT_POST, 'idTemas') != null) {
                $myTemas->setidTemas(filter_input(INPUT_POST, 'idTemas'));
                $myTemas = $myTemasBo->searchById($myTemas);
                if ($myTemas != null) {
                    echo json_encode(($myClientes_Correo));
                } else {
                    echo('E~NO Existe un Cliente con el ID especificado');
                }
            }
        }

        if ($action === "delete_temas") {
            if (filter_input(INPUT_POST, 'idTemas') != null) {
                $myTemas->setidCorreo_Clientes(filter_input(INPUT_POST, 'idTemas'));
                $myTemasBo->delete($myTemas);
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