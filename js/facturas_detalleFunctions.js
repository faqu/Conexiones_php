/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$(function () { //para la creación de los controles
    //agrega los eventos las capas necesarias
    $("#enviar").click(function () {
        addOrUpdateFacturas_Detalles();
    });
    //agrega los eventos las capas necesarias
    $("#cancelar").click(function () {
        cancelAction();
    });    //agrega los eventos las capas necesarias

    $("#btMostarForm").click(function () {
        //muestra el fomurlaior
        clearFormFacturas_Detalles();
        $("#typeAction").val("add_facturas_detalles");
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

function addOrUpdateFacturas_Detalles() {
    //Se envia la información por ajax
    if (validar()) {
        $.ajax({
            url: '../backend/controller/clientesController.php',
            data: {
                action:             $("#typeAction").val(),
                idFactura_Detalle:      $("#txtidFactura_Detalle").val(),
                Costo:             $("#txtCosto").val(),
                Impuestos:           $("#txtImpuestos").val(),
                Total:             $("#txtTotal").val(),
                Facturas_idFacturas:          $("#txtFacturas_idFacturas").val(),
                Temas_idTemas:          $("#txtTemas_idTemas").val(),
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
                    clearFormFacturas_Detalles();
                    $("#dt_facturas_detalles").DataTable().ajax.reload();
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
    if ($("#txtidFactura_Detalle").val() === "") {
        validacion = false;
    }

    if ($("#txtCosto").val() === "") {
        validacion = false;
    }

    if ($("#txtImpuestos").val() === "") {
        validacion = false;
    }

    if ($("#txtTotal").val() === "") {
        validacion = false;
    }

    if ($("#txtFacturas_idFacturas").val() === "") {
        validacion = false;
    }

    if ($("#txtTemas_idTemas").val() === "") {
        validacion = false;
    }



    return validacion;
}

//*****************************************************************
//*****************************************************************

function clearFormFacturas_Detalles() {
    $('#formFacturas_Detalles').trigger("reset");
}

//*****************************************************************
//*****************************************************************

function cancelAction() {
    //clean all fields of the form
    clearFormFacturas_Detalles();
    $("#typeAction").val("add_facturas_detalles");
    $("#myModalFormulario").modal("hide");
}



//*****************************************************************
//*****************************************************************

function showClientesByID(idFactura_Detalle) {
    //Se envia la información por ajax
    $.ajax({
        url: '../backend/controller/facturas_detallesController.php',
        data: {
            action: "show_facturas_detalles",
            idFactura_Detalle: idFactura_Detalle
        },
        error: function () { //si existe un error en la respuesta del ajax
            swal("Error", "Se presento un error al consultar la informacion", "error");
        },
        success: function (data) { //si todo esta correcto en la respuesta del ajax, la respuesta queda en el data
            var objFacturas_DetallesJSon = JSON.parse(data);
            $("#txtidFactura_Detalle").val(objFacturas_DetallesJSon.idFactura_Detalle);
            $("#txtCosto").val(objFacturas_DetallesJSon.Costo);
            $("#txtImpuestos").val(objFacturas_DetallesJSon.Impuestos);
            $("#txtTotal").val(objFacturas_DetallesJSon.Total);
            $("#txtFacturas_idFacturas").val(objFacturas_DetallesJSon.Facturas_idFacturas);
            $("#txtTemas_idTemas").val(objFacturas_DetallesJSon.Temas_idTemas);
            $("#typeAction").val("update_facturas_detalles");
            
            swal("Confirmacion", "Los datos de la persona fueron cargados correctamente", "success");
        },
        type: 'POST'
    });
}

//*****************************************************************
//*****************************************************************

function deleteClientesByID(idFactura_Detalle) {
    //Se envia la información por ajax
    $.ajax({
        url: '../backend/controller/facturas_detallesController.php',
        data: {
            action: "delete_facturas_detalles",
            idFactura_Detalle: idFactura_Detalle
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
                $("#dt_facturas_detalles").DataTable().ajax.reload();
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
        if ($("#dt_facturas_detalles").length) {
            $("#dt_facturas_detalles").DataTasble({
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
                            var botones = '<button type="button" class="btn btn-default btn-xs" aria-label="Left Align" onclick="showFacturas_DetallesByID(\''+row[0]+'\');">Cargar</button> ';
                            botones += '<button type="button" class="btn btn-default btn-xs" aria-label="Left Align" onclick="deleteFacturas_DetallesByID(\''+row[0]+'\');">Eliminar</button>';
                            return botones;
                        }
                    }

                ],
                pageLength: 2,
                language: dt_lenguaje_espanol,
                ajax: {
                    url: '../backend/controller/cfacturas_detallesController.php',
                    type: "POST",
                    data: function (d) {
                        return $.extend({}, d, {
                            action: "showAll_facturas_detalles"
                        });
                    }
                },
                drawCallback: function (nRow, aData, iDisplayIndex, iDisplayIndexFull) {
                    $('#dt_facturas_detalles').DataTable().columns.adjust().responsive.recalc();
                }
            });
        }
    };



    TableManageButtons = function () {
        "use strict";
        return {
            init: function () {
                dataTableFacturas_Detalles_const();
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
    $('#dt_facturas_detalles').DataTable().columns.adjust().responsive.recalc();
};


