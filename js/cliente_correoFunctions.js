/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$(function () { //para la creación de los controles
    //agrega los eventos las capas necesarias
    $("#enviar").click(function () {
        addOrUpdateClientes_Correo();
    });
    //agrega los eventos las capas necesarias
    $("#cancelar").click(function () {
        cancelAction();
    });    //agrega los eventos las capas necesarias

    $("#btMostarForm").click(function () {
        //muestra el fomurlaior
        clearFormClientes_Correo();
        $("#typeAction").val("add_clientes");
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

function addOrUpdateClientes_Correo() {
    //Se envia la información por ajax
    if (validar()) {
        $.ajax({
            url: '../backend/controller/clientes_correoController_1.php',
            data: {
                action:                                 $("#typeAction").val(),
                idCorreo_Clientes:                      $("#txtidCorreo_Clientes").val(),
                Estado:                                 $("#txtEstado").val(),
                Clientes_PK_idCliente:                  $("#txtClientes_PK_idCliente").val(),
                Tipo_CorreoC_idTipo_CorreoC:            $("#txtTipo_CorreoC_idTipo_CorreoC").val(),
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
                    clearFormClientes_Correo();
                    $("#dt_clientes_correo").DataTable().ajax.reload();
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
    if ($("#txtidCorreo_Clientes").val() === "") {
        validacion = false;
    }

    if ($("#txtEstado").val() === "") {
        validacion = false;
    }

    if ($("#txtClientes_PK_idCliente").val() === "") {
        validacion = false;
    }

    if ($("#txtTipo_CorreoC_idTipo_CorreoC").val() === "") {
        validacion = false;
    }

    return validacion;
}

//*****************************************************************
//*****************************************************************

function clearFormClientes_Correo() {
    $('#formClientes_Correo').trigger("reset");
}

//*****************************************************************
//*****************************************************************

function cancelAction() {
    //clean all fields of the form
    clearFormClientes();
    $("#typeAction").val("add_clientes_correo");
    $("#myModalFormulario").modal("hide");
}



//*****************************************************************
//*****************************************************************

function showClientesByID(idCorreo_Clientes) {
    //Se envia la información por ajax
    $.ajax({
        url: '../backend/controller/clientes_correoController_1.php',
        data: {
            action: "show_clientes_correo",
            idCorreo_Clientes: idCorreo_Clientes
        },
        error: function () { //si existe un error en la respuesta del ajax
            swal("Error", "Se presento un error al consultar la informacion", "error");
        },
        success: function (data) { //si todo esta correcto en la respuesta del ajax, la respuesta queda en el data
            var objClientes_CorreoJSon = JSON.parse(data);
            $("#txtidCorreo_Clientes").val(objClientes_CorreoJSon.idCorreo_Clientes);
            $("#txtEstado").val(objClientes_CorreoJSon.Estado);
            $("#txtClientes_PK_idCliente").val(objClientes_CorreoJSon.Clientes_PK_idCliente);
            $("#txtTipo_CorreoC_idTipo_CorreoC").val(objClientes_CorreoJSon.Tipo_CorreoC_idTipo_CorreoC);
            $("#typeAction").val("update_clientes_correo");
            
            swal("Confirmacion", "Los datos de la persona fueron cargados correctamente", "success");
        },
        type: 'POST'
    });
}

//*****************************************************************
//*****************************************************************

function deleteClientesByID(idCorreo_Clientes) {
    //Se envia la información por ajax
    $.ajax({
        url: '../backend/controller/clientes_correoController_1.php',
        data: {
            action: "delete_clientes",
            idCorreo_Clientes: idCorreo_Clientes
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
                $("#dt_clientes_correo").DataTable().ajax.reload();
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



    var dataTableClientes_Correo_const = function () {
        if ($("#dt_clientes_correo").length) {
            $("#dt_clientes_correo").DataTable({
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
                        targets: 4,
                        className: "dt-center",
                        render: function (data, type, row, meta) {
                            var botones = '<button type="button" class="btn btn-default btn-xs" aria-label="Left Align" onclick="showClientes_CorreoByID(\''+row[0]+'\');">Cargar</button> ';
                            botones += '<button type="button" class="btn btn-default btn-xs" aria-label="Left Align" onclick="deleteClientes_CorreoByID(\''+row[0]+'\');">Eliminar</button>';
                            return botones;
                        }
                    }

                ],
                pageLength: 2,
                language: dt_lenguaje_espanol,
                ajax: {
                    url: '../backend/controller/clientesController.php',
                    type: "POST",
                    data: function (d) {
                        return $.extend({}, d, {
                            action: "showAll_clientes"
                        });
                    }
                },
                drawCallback: function (nRow, aData, iDisplayIndex, iDisplayIndexFull) {
                    $('#dt_clientes_correo').DataTable().columns.adjust().responsive.recalc();
                }
            });
        }
    };



    TableManageButtons = function () {
        "use strict";
        return {
            init: function () {
                dataTableClientes_Correo_const();
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
    $('#dt_clientes_correo').DataTable().columns.adjust().responsive.recalc();
};


