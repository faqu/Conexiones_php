<?php

require_once ("../bo/facturasBo.php");
require_once ("../domain/facturas.php");
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
if (filter_input(INPUT_POST, 'action') != null) {
    $action = filter_input(INPUT_POST, 'action');

    //choose the action
    try {
        $myFacturasBo = new FacturasBo();
        $myFacturas = Facturas::createNullFacturas();

        if ($action === "add_facturas" or $action === "update_facturas") {
            //se valida que los parametros hayan sido enviados por post
            if ((filter_input(INPUT_POST, 'idFacturas') != null) && (filter_input(INPUT_POST, 'Fecha_Factura') != null) && (filter_input(INPUT_POST, 'Total_Factura') != null) && (filter_input(INPUT_POST, 'Total_Impuestos') != null)&& (filter_input(INPUT_POST, 'Clientes_PK_idClientes') != null)) {
                $myFacturas->setidFacturas(filter_input(INPUT_POST, 'idFacturas'));
                $myFacturas->setFecha_Factura(filter_input(INPUT_POST, 'Fecha_Factura'));
                $myFacturas->setTotal_Factura(filter_input(INPUT_POST, 'Total_Factura'));
                $myFacturas->setTotal_Impuestos(filter_input(INPUT_POST, 'Total_Impuestos'));
                $myFacturas->setClientes_PK_idClientes(filter_input(INPUT_POST, 'Clientes_PK_idClientes'));
                if ($action == "add_facturas") {
                    $myFacturasBo->add($myFacturas);
                    echo('M~Registro Incluido Correctamente');
                }
                if ($action == "update_facturas") {
                    $myFacturasBo->update($myFacturas);
                    echo ('M~Registro Modificado Correctamente');
                }
            }
        }

        if ($action === "showAll_facturas") {//accion de consultar todos los registros
            $resultDB = $myFacturasBo->getAll();
            $json = json_encode($resultDB->GetArray());
            $resultado = '{"data": ' . $json . '}';
            if ($resultDB->RecordCount() === 0) {
                $resultado = '{"data": []}';
            }
            echo $resultado;
        }

        if ($action === "show_facturas") {
            if (filter_input(INPUT_POST, 'idFacturas') != null) {
                $myFacturas->setidFacturas(filter_input(INPUT_POST, 'idFacturas'));
                $myFacturas = $myFacturasBo->searchById($myFacturas);
                if ($myFacturas != null) {
                    echo json_encode(($myFacturas));
                } else {
                    echo('E~NO Existe un Cliente con el ID especificado');
                }
            }
        }

        if ($action === "delete_temas") {
            if (filter_input(INPUT_POST, 'idFacturas') != null) {
                $myFacturas->setidFacturas(filter_input(INPUT_POST, 'idFacturas'));
                $myFacturasBo->delete($myFacturas);
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