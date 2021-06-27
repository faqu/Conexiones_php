<?php

require_once ("../bo/tipo_correoU.php");
require_once ("../domain/tipo_correoU.php");
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
if (filter_input(INPUT_POST, 'action') != null) {
    $action = filter_input(INPUT_POST, 'action');

    //choose the action
    try {
        $myTipo_CorreoUBo = new Tipo_CorreoUBo();
        $myTipo_CorreoU = Tipo_CorreoU::createNullTipo_CorreoU();

        if ($action === "add_tipo_correoU" or $action === "update_tipo_correoU") {
            //se valida que los parametros hayan sido enviados por post
            if ((filter_input(INPUT_POST, 'idTipo_CorreoU') != null) && (filter_input(INPUT_POST, 'Descripcion_TipoCorreoU') != null)) {
                $myTipo_CorreoU->setidTipo_CorreoU(filter_input(INPUT_POST, 'idTipo_CorreoU'));
                $myTipo_CorreoU->setDescripcion_TipoCorreoU(filter_input(INPUT_POST, 'Descripcion_TipoCorreoU'));
                if ($action == "add_tipo_correoU") {
                    $myTipo_CorreoUBo->add($myTipo_CorreoU);
                    echo('M~Registro Incluido Correctamente');
                }
                if ($action == "update_tipo_correoU") {
                    $myTipo_CorreoUBo->update($myTipo_CorreoU);
                    echo ('M~Registro Modificado Correctamente');
                }
            }
        }

        if ($action === "showAll_tipo_correoU") {//accion de consultar todos los registros
            $resultDB = $myTipo_CorreoUBo->getAll();
            $json = json_encode($resultDB->GetArray());
            $resultado = '{"data": ' . $json . '}';
            if ($resultDB->RecordCount() === 0) {
                $resultado = '{"data": []}';
            }
            echo $resultado;
        }

        if ($action === "show_tipo_correoU") {
            if (filter_input(INPUT_POST, 'idTipo_CorreoU') != null) {
                $myTipo_CorreoU->setidTipo_CorreoU(filter_input(INPUT_POST, 'idTipo_CorreoU'));
                $myTipo_CorreoU = $myTipo_CorreoCBo->searchById($myTipo_CorreoC);
                if ($myTipo_CorreoU != null) {
                    echo json_encode(($myTipo_CorreoU));
                } else {
                    echo('E~NO Existe un Cliente con el ID especificado');
                }
            }
        }

        if ($action === "delete_tipo_correoU") {
            if (filter_input(INPUT_POST, 'show_tipo_correoU') != null) {
                $myTipo_CorreoU->setshow_tipo_correoU(filter_input(INPUT_POST, 'show_tipo_correoU'));
                $myTipo_CorreoUBo->delete($myTipo_CorreoU);
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