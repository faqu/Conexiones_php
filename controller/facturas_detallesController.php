<?php

require_once ("../bo/facturas_detalles.php");
require_once ("../domain/facturas_detalles.php");
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
if (filter_input(INPUT_POST, 'action') != null) {
    $action = filter_input(INPUT_POST, 'action');

    //choose the action
    try {
        $myFacturas_DetallesBo = new Facturas_DetallesBo();
        $myFacturas_Detalles = Facturas_Detalles::createFacturas_Detalles();

        if ($action === "add_facturas_detalles" or $action === "update_facturas_detalles") {
            //se valida que los parametros hayan sido enviados por post
            if ((filter_input(INPUT_POST, 'idFactura_Detalle') != null) && (filter_input(INPUT_POST, 'Costo') != null) && (filter_input(INPUT_POST, 'Impuesto') != null) && (filter_input(INPUT_POST, 'Total') != null)&& (filter_input(INPUT_POST, 'Facturas_idFacturas') != null)&& (filter_input(INPUT_POST, 'Temas_idTemas') != null)) {
                $myFacturas_Detalles->setidFactura_Detalle(filter_input(INPUT_POST, 'idFactura_Detalle'));
                $myFacturas_Detalles->setCosto(filter_input(INPUT_POST, 'Costo'));
                $myFacturas_Detalles->setImpuestos(filter_input(INPUT_POST, 'Impuestos'));
                $myFacturas_Detalles->setTotal(filter_input(INPUT_POST, 'Total'));
                $myFacturas_Detalles->setFacturas_idFacturas(filter_input(INPUT_POST, 'Facturas_idFacturas'));
                $myFacturas_Detalles->setTemas_idTemas(filter_input(INPUT_POST, 'Temas_idTemas'));
                if ($action == "add_facturas_detalles") {
                    $myFacturas_DetallesBo->add($myFacturas_Detalles);
                    echo('M~Registro Incluido Correctamente');
                }
                if ($action == "update_facturas_detalles") {
                    $myFacturas_DetallesBo->update($myFacturas_Detalles);
                    echo ('M~Registro Modificado Correctamente');
                }
            }
        }

        if ($action === "showAll_facturas_detalles") {//accion de consultar todos los registros
            $resultDB = $myFacturas_DetallesBo->getAll();
            $json = json_encode($resultDB->GetArray());
            $resultado = '{"data": ' . $json . '}';
            if ($resultDB->RecordCount() === 0) {
                $resultado = '{"data": []}';
            }
            echo $resultado;
        }

        if ($action === "show_facturas_detalles") {
            if (filter_input(INPUT_POST, 'idFactura_Detalle') != null) {
                $myFacturas_Detalles->setidFactura_Detalle(filter_input(INPUT_POST, 'idFactura_Detalle'));
                $myFacturas_Detalles = $myFacturas_DetallesBo->searchById($myFacturas_Detalles);
                if ($myFacturas_Detalles != null) {
                    echo json_encode(($myFacturas_Detalles));
                } else {
                    echo('E~NO Existe un Cliente con el ID especificado');
                }
            }
        }

        if ($action === "delete_facturas_detalles") {
            if (filter_input(INPUT_POST, 'idFactura_Detalle') != null) {
                $myFacturas_Detalles->setidFactura_Detalle(filter_input(INPUT_POST, 'idFactura_Detalle'));
                $myFacturas_DetallesBo->delete($myFacturas_Detalles);
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