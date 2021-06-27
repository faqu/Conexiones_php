/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$(function () { //para la creación de los controles
    //agrega los eventos las capas necesarias
    $("#enviar").click(function () {
        addOrUpdateFacturas();
    });
    //agrega los eventos las capas necesarias
    $("#cancelar").click(function () {
        cancelAction();
    });    //agrega los eventos las capas necesarias

    $("#btMostarForm").click(function () {
        //muestra el fomurlaior
        clearFormFacturas();
        $("#typeAction").val("add_facturas");
        $("#myModalFormulario").modal();
    });
    
    
    
});

//*********************************************************************
//cuando el documento esta cargado se procede a cargar la información
//*********************************************************************

$(document).ready(function () {
    cargarTablas();
    
});

//*********************************************************************
//Agregar o modificar la información
//*********************************************************************

function addOrUpdateFacturas() {
    //Se envia la información por ajax
    if (validar()) {
        $.ajax({
            url: '../backend/controller/facturasController.php',
            data: {
                action:             $("#typeAction").val(),
                idFacturas:      $("#txtidFacturas").val(),
                Fecha_Factura:             $("#txtFecha_Factura").val(),
                Total_Factura:           $("#txtTotal_Factura").val(),
                Total_Impuestos:             $("#txtTotal_Impuestos").val(),
                Clientes_PK_idClientes:          $("#txtClientes_PK_idClientes").val(),
            },
            error: function () { //si existe un error en la respuesta del ajax
                swal("Error", "Se presento un error al enviar la informacion", "error");
            },
            success: function (data) { //si todo esta correcto en la respuesta del ajax, la respuesta queda en el data
                var messageComplete = data.trim();
                var responseText = messageComplete.substring(2);
                var typeOfMessage = messageComplete.substring(0, 2);
                if (typeOfMessage === "M~") { //si todo esta corecto
                    swal("Confirmacion", responseText, "success");
                    clearFormFacturas();
                    $("#dt_facturas").DataTable().ajax.reload();
                } else {//existe un error
                    swal("Error", responseText, "error");
                }
            },
            type: 'POST'
        });
    }else{
        swal("Error de validación", "Los datos del formulario no fueron digitados, por favor verificar", "error");
    }
}

//*****************************************************************
//*****************************************************************
function validar() {
    var validacion = true;

    
    //valida cada uno de los campos del formulario
    //Nota: Solo si fueron digitados
    if ($("#txtidFacturas").val() === "") {
        validacion = false;
    }

    if ($("#txtFecha_Factura").val() === "") {
        validacion = false;
    }

    if ($("#txtTotal_Factura").val() === "") {
        validacion = false;
    }

    if ($("#txtTotal_Impuestos").val() === "") {
        validacion = false;
    }

    if ($("#txtClientes_PK_idClientes").val() === "") {
        validacion = false;
    }


    return validacion;
}

//*****************************************************************
//*****************************************************************

function clearFormFacturas() {
    $('#formFacturas').trigger("reset");
}

//*****************************************************************
//*****************************************************************

function cancelAction() {
    //clean all fields of the form
    clearFormClientes();
    $("#typeAction").val("add_facturas");
    $("#myModalFormulario").modal("hide");
}



//*****************************************************************
//*****************************************************************

function showFacturasByID(idFacturas) {
    //Se envia la información por ajax
    $.ajax({
        url: '../backend/controller/facturasController.php',
        data: {
            action: "show_facturas",
            idFacturas: idFacturas
        },
        error: function () { //si existe un error en la respuesta del ajax
            swal("Error", "Se presento un error al consultar la informacion", "error");
        },
        success: function (data) { //si todo esta correcto en la respuesta del ajax, la respuesta queda en el data
            var objFacturasJSon = JSON.parse(data);
            $("#txtidFacturas").val(objFacturasJSon.PK_idClientes);
            $("#txtFecha_Factura").val(objFacturasJSon.Codigo);
            $("#txtTotal_Factura").val(objFacturasJSon.Password);
            $("#txtTotal_Impuestos").val(objFacturasJSon.Nombre);
            $("#txtClientes_PK_idClientes").val(objFacturasJSon.Apellido1);
            $("#typeAction").val("update_facturas");
            
            swal("Confirmacion", "Los datos de la persona fueron cargados correctamente", "success");
        },
        type: 'POST'
    });
}

//*****************************************************************
//*****************************************************************

function deleteFacturasByID(idFacturas) {
    //Se envia la información por ajax
    $.ajax({
        url: '../backend/controller/favturasController.php',
        data: {
            action: "delete_facturas",
            idFacturas: idFacturas
        },
        error: function () { //si existe un error en la respuesta del ajax
            swal("Error", "Se presento un error al eliminar la informacion", "error");
        },
        success: function (data) { //si todo esta correcto en la respuesta del ajax, la respuesta queda en el data
            var responseText = data.trim().substring(2);
            var typeOfMessage = data.trim().substring(0, 2);
            if (typeOfMessage === "M~") { //si todo esta corecto
                swal("Confirmacion", responseText, "success");
                clearFormClientes();
                $("#dt_facturas").DataTable().ajax.reload();
            } else {//existe un error
                swal("Error", responseText, "error");
            }
        },
        type: 'POST'
    });
}




//*******************************************************************************
//Metodo para cargar las tablas
//*******************************************************************************


function cargarTablas() {



    var dataTableClientes_const = function () {
        if ($("#dt_facturas").length) {
            $("#dt_facturas").DataTable({
                dom: "Bfrtip",
                bFilter: false,
                ordering: false,
                buttons: [
                    {
                        extend: "copy",
                        className: "btn-sm",
                        text: "Copiar"
                    },
                    {
                        extend: "csv",
                        className: "btn-sm",
                        text: "Exportar a CSV"
                    },
                    {
                        extend: "print",
                        className: "btn-sm",
                        text: "Imprimir"
                    }

                ],
                "columnDefs": [
                    {
                        targets: 5,
                        className: "dt-center",
                        render: function (data, type, row, meta) {
                            var botones = '<button type="button" class="btn btn-default btn-xs" aria-label="Left Align" onclick="showClientesByID(\''+row[0]+'\');">Cargar</button> ';
                            botones += '<button type="button" class="btn btn-default btn-xs" aria-label="Left Align" onclick="deleteClientesByID(\''+row[0]+'\');">Eliminar</button>';
                            return botones;
                        }
                    }

                ],
                pageLength: 2,
                language: dt_lenguaje_espanol,
                ajax: {
                    url: '../backend/controller/facturasController.php',
                    type: "POST",
                    data: function (d) {
                        return $.extend({}, d, {
                            action: "showAll_facturas"
                        });
                    }
                },
                drawCallback: function (nRow, aData, iDisplayIndex, iDisplayIndexFull) {
                    $('#dt_facturas').DataTable().columns.adjust().responsive.recalc();
                }
            });
        }
    };



    TableManageButtons = function () {
        "use strict";
        return {
            init: function () {
                dataTableFacturas_const();
                $(".dataTables_filter input").addClass("form-control input-rounded ml-sm");
            }
        };
    }();

    TableManageButtons.init();
}

//*******************************************************************************
//evento que reajusta la tabla en el tamaño de la pantall
//*******************************************************************************

window.onresize = function () {
    $('#dt_facturas').DataTable().columns.adjust().responsive.recalc();
};


