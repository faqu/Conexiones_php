<?php

require_once ("../bo/usuariosBo.php");
require_once ("../domain/usuarios.php");
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
if (filter_input(INPUT_POST, 'action') != null) {
    $action = filter_input(INPUT_POST, 'action');

    //choose the action
    try {
        $myUsuariosBo = new UsuariosBo();
        $myUsuarios = Usuarios::createNullUsuarios();

        if ($action === "add_usuarios" or $action === "update_usuarios") {
            //se valida que los parametros hayan sido enviados por post
            if ((filter_input(INPUT_POST, 'PK_idUsuarios') != null) && (filter_input(INPUT_POST, 'Password') != null) && (filter_input(INPUT_POST, 'Nombre') != null) && (filter_input(INPUT_POST, 'Apellido1') != null) && (filter_input(INPUT_POST, 'Apellido2') != null) && (filter_input(INPUT_POST, 'Fecha_Nacimiento') != null) && (filter_input(INPUT_POST, 'Estado') != null) && (filter_input(INPUT_POST, 'Tipos_Usuarios_idTipos_Usuarios') != null)) {
                $myUsuarios->setPK_idUsuarios(filter_input(INPUT_POST, 'PK_idUsuarios'));
                $myUsuarios->setPassword(filter_input(INPUT_POST, 'Password'));
                $myUsuarios->setNombre(filter_input(INPUT_POST, 'Nombre'));
                $myUsuarios->setApellido1(filter_input(INPUT_POST, 'Apellido1'));
                $myUsuarios->setApellido2(filter_input(INPUT_POST, 'Apellido2'));
                $myUsuarios->setFecha_Nacimiento(filter_input(INPUT_POST, 'Fecha_Nacimiento'));
                $myUsuarios->setEstado(filter_input(INPUT_POST, 'Estado'));
                $myUsuarios->setTipos_Usuarios_idTipos_Usuarios(filter_input(INPUT_POST, 'Tipos_Usuarios_idTipos_Usuarios'));
                $myUsuarios->setLastUser('112540148');
                if ($action == "add_usuarios") {
                    $myUsuariosBo->add($myUsuarios);
                    echo('M~Registro Incluido Correctamente');
                }
                if ($action == "update_usuarios") {
                    $myUsuariosBo->update($myUsuarios);
                    echo ('M~Registro Modificado Correctamente');
                }
            }
        }

        if ($action === "showAll_usuarios") {//accion de consultar todos los registros
            $resultDB = $myUsuariosBo->getAll();
            $json = json_encode($resultDB->GetArray());
            $resultado = '{"data": ' . $json . '}';
            if ($resultDB->RecordCount() === 0) {
                $resultado = '{"data": []}';
            }
            echo $resultado;
        }

        if ($action === "show_usuarios") {
            if (filter_input(INPUT_POST, 'PK_idUsuarios') != null) {
                $myUsuarios->setPK_idUsuarios(filter_input(INPUT_POST, 'PK_idUsuarios'));
                $myUsuarios = $myUsuariosBo->searchById($myUsuarios);
                if ($myUsuarios != null) {
                    echo json_encode(($myUsuarios));
                } else {
                    echo('E~NO Existe un Cliente con el ID especificado');
                }
            }
        }

        if ($action === "delete_usuarios") {
            if (filter_input(INPUT_POST, 'PK_idUsuarios') != null) {
                $myUsuarios->setPK_idUsuarios(filter_input(INPUT_POST, 'PK_idUsuarios'));
                $myUsuariosBo->delete($myUsuarios);
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