<?php

require_once ("../bo/usuarios_correoBo.php");
require_once ("../domain/usuarios_correo.php");
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
if (filter_input(INPUT_POST, 'action') != null) {
    $action = filter_input(INPUT_POST, 'action');

    //choose the action
    try {
        $myUsuarios_CorreoBo = new UsuariosBo();
        $myUsuarios_Correo = Usuarios_Correo::createNullUsuarios_Correo();

        if ($action === "add_usuarios_correo" or $action === "clientes_usuarios_correo") {
            //se valida que los parametros hayan sido enviados por post
            if ((filter_input(INPUT_POST, 'idClientes_Correo') != null) && (filter_input(INPUT_POST, 'Estado') != null) && (filter_input(INPUT_POST, 'Usuarios_PK_idUsuarios') != null) && (filter_input(INPUT_POST, 'Tipo_CorreoU_idTipo_CorreoU') != null)) {
                $myUsuarios_Correo->setidClientes_Correo(filter_input(INPUT_POST, 'idClientes_Correo'));
                $myUsuarios_Correo->setEstado(filter_input(INPUT_POST, 'Estado'));
                $myUsuarios_Correo->setUsuarios_PK_idUsuarios(filter_input(INPUT_POST, 'Usuarios_PK_idUsuarios'));
                $myUsuarios_Correo->setTipo_CorreoU_idTipo_CorreoU(filter_input(INPUT_POST, 'Tipo_CorreoU_idTipo_CorreoU'));
                if ($action == "add_clientes_correo") {
                    $myUsuarios_CorreoBo->add($myUsuarios_Correo);
                    echo('M~Registro Incluido Correctamente');
                }
                if ($action == "update_clientes_correo") {
                    $myUsuarios_CorreoBo->update($myUsuarios_Correo);
                    echo ('M~Registro Modificado Correctamente');
                }
            }
        }

        if ($action === "showAll_usuarios_correo") {//accion de consultar todos los registros
            $resultDB = $myUsuarios_CorreoBo->getAll();
            $json = json_encode($resultDB->GetArray());
            $resultado = '{"data": ' . $json . '}';
            if ($resultDB->RecordCount() === 0) {
                $resultado = '{"data": []}';
            }
            echo $resultado;
        }

        if ($action === "show_usuarios_correo") {
            if (filter_input(INPUT_POST, 'idClientes_Correo') != null) {
                $myUsuarios_Correo->setidClientes_Correo(filter_input(INPUT_POST, 'idClientes_Correo'));
                $myUsuarios_Correo = $myUsuarios_CorreoBo->searchById($myUsuarios_Correo);
                if ($myUsuarios_Correo != null) {
                    echo json_encode(($myUsuarios_Correo));
                } else {
                    echo('E~NO Existe un Cliente con el ID especificado');
                }
            }
        }

        if ($action === "delete_usuarios_correo") {
            if (filter_input(INPUT_POST, 'idClientes_Correo') != null) {
                $myUsuarios_Correo->setidClientes_Correo(filter_input(INPUT_POST, 'idClientes_Correo'));
                $myUsuarios_CorreoBo->delete($myUsuarios_Correo);
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