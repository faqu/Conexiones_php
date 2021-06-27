<?php

require_once ("../bo/tipo_correoC.php");
require_once ("../domain/tipo_correoC.php");
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
if (filter_input(INPUT_POST, 'action') != null) {
    $action = filter_input(INPUT_POST, 'action');

    //choose the action
    try {
        $myTipo_CorreoCBo = new Tipo_CorreoCBo();
        $myTipo_CorreoC = Tipo_CorreoC::createNullTipo_CorreoC();

        if ($action === "add_tipo_correoC" or $action === "update_tipo_correoC") {
            //se valida que los parametros hayan sido enviados por post
            if ((filter_input(INPUT_POST, 'idTipo_CorreoC') != null) && (filter_input(INPUT_POST, 'Descripcion_TipoCorreo') != null)) {
                $myTipo_CorreoC->setidTipo_CorreoC(filter_input(INPUT_POST, 'idTipo_CorreoC'));
                $myTipo_CorreoC->setDescripcion_TipoCorreo(filter_input(INPUT_POST, 'Descripcion_TipoCorreo'));
                if ($action == "add_tipo_correoC") {
                    $my_CorreoCBo->add($myTipo_CorreoC);
                    echo('M~Registro Incluido Correctamente');
                }
                if ($action == "update_tipo_correoC") {
                    $myTipo_CorreoCBo->update($myTipo_CorreoC);
                    echo ('M~Registro Modificado Correctamente');
                }
            }
        }

        if ($action === "showAll_tipo_correoC") {//accion de consultar todos los registros
            $resultDB = $myTipo_CorreoCBo->getAll();
            $json = json_encode($resultDB->GetArray());
            $resultado = '{"data": ' . $json . '}';
            if ($resultDB->RecordCount() === 0) {
                $resultado = '{"data": []}';
            }
            echo $resultado;
        }

        if ($action === "show_tipo_correo") {
            if (filter_input(INPUT_POST, 'idTipo_CorreoC') != null) {
                $myTipo_CorreoC->setidTipo_CorreoC(filter_input(INPUT_POST, 'idTipo_CorreoC'));
                $myTipo_CorreoC = $myTipo_CorreoCBo->searchById($myTipo_CorreoC);
                if ($myTipo_CorreoC != null) {
                    echo json_encode(($myTipo_CorreoC));
                } else {
                    echo('E~NO Existe un Cliente con el ID especificado');
                }
            }
        }

        if ($action === "delete_tipo_correoC") {
            if (filter_input(INPUT_POST, 'show_tipo_correo') != null) {
                $myTipo_CorreoC->setshow_tipo_correo(filter_input(INPUT_POST, 'show_tipo_correo'));
                $myTipo_CorreoCBo->delete($myTipo_CorreoC);
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