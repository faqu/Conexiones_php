/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$(function () { //para la creación de los controles
    //agrega los eventos las capas necesarias
    $("#enviar").click(function () {
        addOrUpdateClientes_Telefonos();
    });
    //agrega los eventos las capas necesarias
    $("#cancelar").click(function () {
        cancelAction();
    });    //agrega los eventos las capas necesarias

    $("#btMostarForm").click(function () {
        //muestra el fomurlaior
        clearFormClientes_Telefonos();
        $("#typeAction").val("add_clientes_telefonos");
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

function addOrUpdateClientes() {
    //Se envia la información por ajax
    if (validar()) {
        $.ajax({
            url: '../backend/controller/clientes_telefonosController.php',
            data: {
                action:             $("#typeAction").val(),
                idClientes_Telefono:      $("#txtidClientes_Telefono").val(),
                Estado:             $("#txtEstado").val(),
                Clientes_PK_idClientes:           $("#txtClientes_PK_idClientes").val(),
                Tipo_TelefonoC_idTipo_TelefonoC:             $("#txtTipo_TelefonoC_idTipo_TelefonoC").val(),
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
                    clearFormClientes_Telefonos();
                    $("#dt_clientes_telefonos").DataTable().ajax.reload();
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
    if ($("#txtidClientes_Telefono").val() === "") {
        validacion = false;
    }

    if ($("#txtEstado").val() === "") {
        validacion = false;
    }

    if ($("#txtClientes_PK_idClientes").val() === "") {
        validacion = false;
    }

    if ($("#txtTipo_TelefonoC_idTipo_TelefonoC").val() === "") {
        validacion = false;
    }

    return validacion;
}

//*****************************************************************
//*****************************************************************

function clearFormClientes_Telfonos() {
    $('#formClientes_Telefonos').trigger("reset");
}

//*****************************************************************
//*****************************************************************

function cancelAction() {
    //clean all fields of the form
    clearFormClientes_Telefonos();
    $("#typeAction").val("add_clientes_telefonos");
    $("#myModalFormulario").modal("hide");
}



//*****************************************************************
//*****************************************************************

function showClientes_TelefonosByID(idClientes_Telefono) {
    //Se envia la información por ajax
    $.ajax({
        url: '../backend/controller/clientes_telefonosController.php',
        data: {
            action: "show_clientes_telefonos",
            idClientes_Telefono: idClientes_Telefono
        },
        error: function () { //si existe un error en la respuesta del ajax
            swal("Error", "Se presento un error al consultar la informacion", "error");
        },
        success: function (data) { //si todo esta correcto en la respuesta del ajax, la respuesta queda en el data
            var objClientes_TelefonosJSon = JSON.parse(data);
            $("#txtidClientes_Telefono").val(objClientes_TelefonosJSon.idClientes_Telefono);
            $("#txtEstado").val(objClientes_TelefonosJSon.Estado);
            $("#txtClientes_PK_idClientes").val(objClientes_TelefonosJSon.Clientes_PK_idClientes);
            $("#txtTipo_TelefonoC_idTipo_TelefonoC").val(objClientes_TelefonosJSon.Tipo_TelefonoC_idTipo_TelefonoC);
            $("#typeAction").val("update_clientes_telefonos");
            
            swal("Confirmacion", "Los datos de la persona fueron cargados correctamente", "success");
        },
        type: 'POST'
    });
}

//*****************************************************************
//*****************************************************************

function deleteClientes_TelfonosByID(idClientes_Telefono) {
    //Se envia la información por ajax
    $.ajax({
        url: '../backend/controller/clientes_telefonosController.php',
        data: {
            action: "delete_clientes_telefonos",
            idClientes_Telefono: idClientes_Telefono
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
                $("#dt_clientes").DataTable().ajax.reload();
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



    var dataTableClientes_Telefonos_const = function () {
        if ($("#dt_clientedataTableClientes_consts_telefonos").length) {
            $("#dt_clientes_telefonos").DataTable({
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
                            var botones = '<button type="button" class="btn btn-default btn-xs" aria-label="Left Align" onclick="showClientesByID(\''+row[0]+'\');">Cargar</button> ';
                            botones += '<button type="button" class="btn btn-default btn-xs" aria-label="Left Align" onclick="deleteClientesByID(\''+row[0]+'\');">Eliminar</button>';
                            return botones;
                        }
                    }

                ],
                pageLength: 2,
                language: dt_lenguaje_espanol,
                ajax: {
                    url: '../backend/controller/clientes_telefonosController.php',
                    type: "POST",
                    data: function (d) {
                        return $.extend({}, d, {
                            action: "showAll_clientes_telefonos"
                        });
                    }
                },
                drawCallback: function (nRow, aData, iDisplayIndex, iDisplayIndexFull) {
                    $('#dt_clientes_telefonos').DataTable().columns.adjust().responsive.recalc();
                }
            });
        }
    };



    TableManageButtons = function () {
        "use strict";
        return {
            init: function () {
                dataTableClientes_Telefonos_const();
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
    $('#dt_clientes_telefonos').DataTable().columns.adjust().responsive.recalc();
};


