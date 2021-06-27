<?php

require_once ("../bo/tipo_telefonoC.php");
require_once ("../domain/tipo_telefomoC_1.php");
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
if (filter_input(INPUT_POST, 'action') != null) {
    $action = filter_input(INPUT_POST, 'action');

    //choose the action
    try {
        $myTipo_TelefonoCBo = new Tipo_TelefonoCBo();
        $myTipo_TelefonoC = Tipo_TelefonoC::createNullTipo_TelefonoC();

        if ($action === "add_tipo_telefonoC" or $action === "update_tipo_telefonoC") {
            //se valida que los parametros hayan sido enviados por post
            if ((filter_input(INPUT_POST, 'idTipo_telefonoC') != null) && (filter_input(INPUT_POST, 'Descripcion_TipoTelefono') != null)) {
                $myTipo_TelefonoC->setidTipo_telefonoC(filter_input(INPUT_POST, 'idTipo_telefonoC'));
                $myTipo_TelefonoC->setDescripcion_TipoTelefono(filter_input(INPUT_POST, 'Descripcion_TipoTelefono'));
                if ($action == "add_tipo_telefonoC") {
                    $myTipo_TelefonoCBo->add($myTipo_TelefonoC);
                    echo('M~Registro Incluido Correctamente');
                }
                if ($action == "update_tipo_telefonoC") {
                    $myTipo_TelefonoCBo->update($myTipo_TelefonoC);
                    echo ('M~Registro Modificado Correctamente');
                }
            }
        }

        if ($action === "showAll_tipo_telefonoC") {//accion de consultar todos los registros
            $resultDB = $myTipo_TelefonoCBo->getAll();
            $json = json_encode($resultDB->GetArray());
            $resultado = '{"data": ' . $json . '}';
            if ($resultDB->RecordCount() === 0) {
                $resultado = '{"data": []}';
            }
            echo $resultado;
        }

        if ($action === "show_tipo_telefono") {
            if (filter_input(INPUT_POST, 'idTipo_TelefonoC') != null) {
                $myTipo_TelefonoC->setidTipo_TelefonoC(filter_input(INPUT_POST, 'idTipo_TelefonoC'));
                $myTipo_TelefonoC = $myTipo_TelefonoCBo->searchById($myTipo_TelefonoC);
                if ($myTipo_TelefonoC != null) {
                    echo json_encode(($myTipo_TelefonoC));
                } else {
                    echo('E~NO Existe un Cliente con el ID especificado');
                }
            }
        }

        if ($action === "delete_tipo_telefonoC") {
            if (filter_input(INPUT_POST, 'show_tipo_telefono') != null) {
                $myTipo_TelefonoC->setshow_tipo_telefono(filter_input(INPUT_POST, 'show_tipo_telefono'));
                $myTipo_TelefonoCBo->delete($myTipo_TelefonoC);
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