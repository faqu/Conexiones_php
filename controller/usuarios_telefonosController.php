<?php

require_once ("../bo/usuarios_telefonosBo.php");
require_once ("../domain/usuarios_telefonos.php");
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
if (filter_input(INPUT_POST, 'action') != null) {
    $action = filter_input(INPUT_POST, 'action');

    //choose the action
    try {
        $myUsuarios_TelefonosBo = new Usuarios_TelefonosBo();
        $myUsuarios_Telefonos = Usuarios_Telefonos::createNullUsuarios_telefonos();

        if ($action === "add_usaurios_telefonos" or $action === "update_usuarios_telefonos") {
            //se valida que los parametros hayan sido enviados por post
            if ((filter_input(INPUT_POST, 'idUsuarios_Telefonos') != null) && (filter_input(INPUT_POST, 'Estado') != null) && (filter_input(INPUT_POST, 'Usuarios_PK_idUsuarios') != null) && (filter_input(INPUT_POST, 'Tipo_TelefonosU_idTipo_TelefonosU') != null)) {
                $myUsuarios_Telefonos->setidUsuarios_Telefonos(filter_input(INPUT_POST, 'idUsuarios_Telefonos'));
                $myUsuarios_Telefonos->setEstado(filter_input(INPUT_POST, 'Estado'));
                $myUsuarios_Telefonos->setUsuarios_PK_idUsuarios(filter_input(INPUT_POST, 'Usuarios_PK_idUsuarios'));
                $myUsuarios_Telefonos->setTipo_TelefonosU_idTipo_TelefonosU(filter_input(INPUT_POST, 'Tipo_TelefonosU_idTipo_TelefonosU'));
                if ($action == "add_usaurios_telefonos") {
                    $myUsuarios_TelefonosBo->add($myClientes_Correo);
                    echo('M~Registro Incluido Correctamente');
                }
                if ($action == "update_clientes_correo") {
                    $myUsuarios_TelefonosBo->update($myClientes_Correo);
                    echo ('M~Registro Modificado Correctamente');
                }
            }
        }

        if ($action === "showAll_usuarios_telefonos") {//accion de consultar todos los registros
            $resultDB = $myUsuarios_TelefonosBo->getAll();
            $json = json_encode($resultDB->GetArray());
            $resultado = '{"data": ' . $json . '}';
            if ($resultDB->RecordCount() === 0) {
                $resultado = '{"data": []}';
            }
            echo $resultado;
        }

        if ($action === "show_usuarios_telefonos") {
            if (filter_input(INPUT_POST, 'idUsuarios_Telefonos') != null) {
                $myUsuarios_Telefonos->setidUsuarios_Telefonos(filter_input(INPUT_POST, 'idUsuarios_Telefonos'));
                $myUsuarios_Telefonos = $myUsuarios_TelefonosBo->searchById($myUsuarios_Telefonos);
                if ($myUsuarios_Telefonos != null) {
                    echo json_encode(($myUsuarios_Telefonos));
                } else {
                    echo('E~NO Existe un Cliente con el ID especificado');
                }
            }
        }

        if ($action === "delete_usuarios_telefonos") {
            if (filter_input(INPUT_POST, 'idUsuarios_Telefonos') != null) {
                $myUsuarios_Telefonos->setidUsuarios_Telefonos(filter_input(INPUT_POST, 'idUsuarios_Telefonos'));
                $myUsuarios_TelefonosBo->delete($myUsuarios_Telefonos);
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