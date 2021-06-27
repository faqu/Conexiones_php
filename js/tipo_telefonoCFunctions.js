/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$(function () { //para la creación de los controles
    //agrega los eventos las capas necesarias
    $("#enviar").click(function () {
        addOrUpdateTipo_telefonoC();
    });
    //agrega los eventos las capas necesarias
    $("#cancelar").click(function () {
        cancelAction();
    });    //agrega los eventos las capas necesarias

    $("#btMostarForm").click(function () {
        //muestra el fomurlaior
        clearFormTipo_TelefonoC();
        $("#typeAction").val("add_tipo_telefonoC");
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

function addOrUpdateTipo_TelefonoC() {
    //Se envia la información por ajax
    if (validar()) {
        $.ajax({
            url: '../backend/controller/tipo_telefonoCContoller_1.php',
            data: {
                action:             $("#typeAction").val(),
                idTipo_telefonoC:      $("#txtidTipo_telefonoC").val(),
                Descripcion_TipoTelefono:             $("#txtDescripcion_TipoTelefono").val(),
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
                    clearFormTipo_TelefonoC();
                    $("#dt_tipo_telefonoC").DataTable().ajax.reload();
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
    if ($("#txtidTipo_telefonoC").val() === "") {
        validacion = false;
    }

    if ($("#txtDescripcion_TipoTelefono").val() === "") {
        validacion = false;
    }

    return validacion;
}

//*****************************************************************
//*****************************************************************

function clearFormTipo_TelefonoC() {
    $('#formTipo_TelefonoC').trigger("reset");
}

//*****************************************************************
//*****************************************************************

function cancelAction() {
    //clean all fields of the form
    clearFormTipo_TelefonoC();
    $("#typeAction").val("add_tipo_telefonoC");
    $("#myModalFormulario").modal("hide");
}



//*****************************************************************
//*****************************************************************

function showTipo_TelefonoCByID(idTipo_telefonoC) {
    //Se envia la información por ajax
    $.ajax({
        url: '../backend/controller/tipo_telefonoCContoller_1.php',
        data: {
            action: "show_tipo_telefonoC",
            idTipo_telefonoC: idTipo_telefonoC
        },
        error: function () { //si existe un error en la respuesta del ajax
            swal("Error", "Se presento un error al consultar la informacion", "error");
        },
        success: function (data) { //si todo esta correcto en la respuesta del ajax, la respuesta queda en el data
            var objClientesJSon = JSON.parse(data);
            $("#txtidTipo_telefonoC").val(objClientesJSon.idTipo_telefonoC);
            $("#txtDescripcion_TipoTelefono").val(objClientesJSon.Descripcion_TipoTelefono);
            $("#typeAction").val("update_tipo_correo");
            
            swal("Confirmacion", "Los datos de la persona fueron cargados correctamente", "success");
        },
        type: 'POST'
    });
}

//*****************************************************************
//*****************************************************************

function deleteTipo_TelefonoCByID(idTipo_telefonoC) {
    //Se envia la información por ajax
    $.ajax({
        url: '../backend/controller/tipo_telefonoCContoller_1.php',
        data: {
            action: "delete_tipo_correoC",
            idTipo_telefonoC: idTipo_telefonoC
        },
        error: function () { //si existe un error en la respuesta del ajax
            swal("Error", "Se presento un error al eliminar la informacion", "error");
        },
        success: function (data) { //si todo esta correcto en la respuesta del ajax, la respuesta queda en el data
            var responseText = data.trim().substring(2);
            var typeOfMessage = data.trim().substring(0, 2);
            if (typeOfMessage === "M~") { //si todo esta corecto
                swal("Confirmacion", responseText, "success");
                clearFormTipos_TelefonoC();
                $("#dt_tipos_telefonoC").DataTable().ajax.reload();
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



    var dataTableTipo_TelefonoC_const = function () {
        if ($("#dt_tipos_telefonoC").length) {
            $("#dt_tipos_telefonoC").DataTable({
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
                        targets: 7,
                        className: "dt-center",
                        render: function (data, type, row, meta) {
                            var botones = '<button type="button" class="btn btn-default btn-xs" aria-label="Left Align" onclick="showTipos_TelefonoCByID(\''+row[0]+'\');">Cargar</button> ';
                            botones += '<button type="button" class="btn btn-default btn-xs" aria-label="Left Align" onclick="deleteTipos_TelefonoCByID(\''+row[0]+'\');">Eliminar</button>';
                            return botones;
                        }
                    }

                ],
                pageLength: 2,
                language: dt_lenguaje_espanol,
                ajax: {
                    url: '../backend/controller/tipos_telefonoCController_1.php',
                    type: "POST",
                    data: function (d) {
                        return $.extend({}, d, {
                            action: "showAll_tipo_telefonoC"
                        });
                    }
                },
                drawCallback: function (nRow, aData, iDisplayIndex, iDisplayIndexFull) {
                    $('#dt_tipo_telefonoC').DataTable().columns.adjust().responsive.recalc();
                }
            });
        }
    };



    TableManageButtons = function () {
        "use strict";
        return {
            init: function () {
                dataTableTipo_TelefonoC_const();
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
    $('#dt_tipo_telefonoC').DataTable().columns.adjust().responsive.recalc();
};


