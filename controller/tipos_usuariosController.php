<?php

require_once ("../bo/tipos_usuarios.php");
require_once ("../domain/tipos_usuarios.php");
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
if (filter_input(INPUT_POST, 'action') != null) {
    $action = filter_input(INPUT_POST, 'action');

    //choose the action
    try {
        $myTipos_UsuariosBo = new Tipos_UsuariosBo();
        $myTipos_Usuarios = Tipos_Usuarios::createNullTipos_Usuarios();

        if ($action === "add_tipos_usuarios" or $action === "update_tipos_usuarios") {
            //se valida que los parametros hayan sido enviados por post
            if ((filter_input(INPUT_POST, 'idTipos_Usuarios') != null) && (filter_input(INPUT_POST, 'Descripcion_Tipos_Usuario') != null)) {
                $myTipos_Usuarios->setidTipos_Usuarios(filter_input(INPUT_POST, 'idTipos_Usuarios'));
                $myTipos_Usuarios->setDescripcion_Tipos_Usuario(filter_input(INPUT_POST, 'Descripcion_Tipos_Usuario'));
                if ($action == "add_tipos_usuarios") {
                    $myTipos_UsuariosBo->add($myTipos_Usuarios);
                    echo('M~Registro Incluido Correctamente');
                }
                if ($action == "update_tipos_usuarios") {
                    $myTipos_UsuariosBo->update($myTipos_Usuarios);
                    echo ('M~Registro Modificado Correctamente');
                }
            }
        }

        if ($action === "showAll_tipos_usuarios") {//accion de consultar todos los registros
            $resultDB = $myTipos_UsuariosBo->getAll();
            $json = json_encode($resultDB->GetArray());
            $resultado = '{"data": ' . $json . '}';
            if ($resultDB->RecordCount() === 0) {
                $resultado = '{"data": []}';
            }
            echo $resultado;
        }

        if ($action === "show_tipos_usuarios") {
            if (filter_input(INPUT_POST, 'idTipos_Usuarios') != null) {
                $myTipos_Usuarios->setidTipo_CorreoU(filter_input(INPUT_POST, 'idTipos_Usuarios'));
                $myTipos_Usuarios = $myTipos_UsuariosBo->searchById($myTipos_Usuarios);
                if ($myTipos_Usuarios != null) {
                    echo json_encode(($myTipos_Usuarios));
                } else {
                    echo('E~NO Existe un Cliente con el ID especificado');
                }
            }
        }

        if ($action === "delete_tipos_usuarios") {
            if (filter_input(INPUT_POST, 'show_tipos_usuarios') != null) {
                $myTipos_Usuarios->setshow_tipo_correoU(filter_input(INPUT_POST, 'show_tipos_usuarios'));
                $myTipos_UsuariosBo->delete($myTipos_Usuarios);
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