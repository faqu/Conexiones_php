<?php

require_once ("../bo/tipo_telefonoU.php");
require_once ("../domain/tipo_telefomoU_1.php");
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
if (filter_input(INPUT_POST, 'action') != null) {
    $action = filter_input(INPUT_POST, 'action');

    //choose the action
    try {
        $myTipo_TelefonosUBo = new Tipo_TelefonosUBo();
        $myTipo_TelefonosU = Tipo_TelefonoSC::createNullTipo_TelefonoSU();

        if ($action === "add_tipo_telefonosU" or $action === "update_tipo_telefonosU") {
            //se valida que los parametros hayan sido enviados por post
            if ((filter_input(INPUT_POST, 'idTipo_telefonoSU') != null) && (filter_input(INPUT_POST, 'Descripcion_TipoTelefonoU') != null)) {
                $myTipo_TelefonosU->setidTipo_telefonoSU(filter_input(INPUT_POST, 'idTipo_telefonoSU'));
                $myTipo_TelefonosU->setDescripcion_TipoTelefonoU(filter_input(INPUT_POST, 'Descripcion_TipoTelefonoU'));
                if ($action == "add_tipo_telefonosU") {
                    $myTipo_TelefonosUBo->add($myTipo_TelefonosU);
                    echo('M~Registro Incluido Correctamente');
                }
                if ($action == "update_tipo_telefonoU") {
                    $myTipo_TelefonosUBo->update($myTipo_TelefonosU);
                    echo ('M~Registro Modificado Correctamente');
                }
            }
        }

        if ($action === "showAll_tipo_telefonoSU") {//accion de consultar todos los registros
            $resultDB = $myTipo_TelefonoSUBo->getAll();
            $json = json_encode($resultDB->GetArray());
            $resultado = '{"data": ' . $json . '}';
            if ($resultDB->RecordCount() === 0) {
                $resultado = '{"data": []}';
            }
            echo $resultado;
        }

        if ($action === "show_tipo_telefonosU") {
            if (filter_input(INPUT_POST, 'idTipo_TelefonosU') != null) {
                $myTipo_TelefonosU->setidTipo_TelefonosU(filter_input(INPUT_POST, 'idTipo_TelefonosU'));
                $myTipo_TelefonosU = $myTipo_TelefonosUBo->searchById($myTipo_TelefonoC);
                if ($myTipo_TelefonoU != null) {
                    echo json_encode(($myTipo_TelefonoU));
                } else {
                    echo('E~NO Existe un Cliente con el ID especificado');
                }
            }
        }

        if ($action === "delete_tipo_telefonosU") {
            if (filter_input(INPUT_POST, 'show_tipo_telefonosU') != null) {
                $myTipo_TelefonosU->setshow_tipo_telefonosU(filter_input(INPUT_POST, 'show_tipo_telefonosU'));
                $myTipo_TelefonosUBo->delete($myTipo_TelefonosU);
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