/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$(function () { //para la creación de los controles
    //agrega los eventos las capas necesarias
    $("#enviar").click(function () {
        addOrUpdateTemas_Experto();
    });
    //agrega los eventos las capas necesarias
    $("#cancelar").click(function () {
        cancelAction();
    });    //agrega los eventos las capas necesarias

    $("#btMostarForm").click(function () {
        //muestra el fomurlaior
        clearFormTemas_Experto();
        $("#typeAction").val("add_temas_escpertos");
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
            url: '../backend/controller/temas_expertoController.php',
            data: {
                action:             $("#typeAction").val(),
                idTemas_Expertos:      $("#txtidTemas_Expertos").val(),
                Observaciones:             $("#txtObservaciones").val(),
                Estado:           $("#txtEstado").val(),
                Temas_idTemas:             $("#txtTemas_idTemas").val(),
                Usuarios_PK_idUsuarios:          $("#txtUsuarios_PK_idUsuarios").val(),
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
                    clearFormTemas_Experto();
                    $("#dt_temas_experto").DataTable().ajax.reload();
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
    if ($("#txtidTemas_Expertos").val() === "") {
        validacion = false;
    }

    if ($("#txtObservaciones").val() === "") {
        validacion = false;
    }

    if ($("#txtEstado").val() === "") {
        validacion = false;
    }

    if ($("#txtTemas_idTemas").val() === "") {
        validacion = false;
    }

    if ($("#txtUsuarios_PK_idUsuarios").val() === "") {
        validacion = false;
    }


    return validacion;
}

//*****************************************************************
//*****************************************************************

function clearFormTemas_Experto() {
    $('#formTemas_expertos').trigger("reset");
}

//*****************************************************************
//*****************************************************************

function cancelAction() {
    //clean all fields of the form
    clearFormTemas_Experto();
    $("#typeAction").val("add_temas_expertos");
    $("#myModalFormulario").modal("hide");
}



//*****************************************************************
//*****************************************************************

function showTemas_ExpertosByID(idTemas_Expertos) {
    //Se envia la información por ajax
    $.ajax({
        url: '../backend/controller/temas_expertosController.php',
        data: {
            action: "show_temas_expertos",
            idTemas_Expertos: idTemas_Expertos
        },
        error: function () { //si existe un error en la respuesta del ajax
            swal("Error", "Se presento un error al consultar la informacion", "error");
        },
        success: function (data) { //si todo esta correcto en la respuesta del ajax, la respuesta queda en el data
            var objClientesJSon = JSON.parse(data);
            $("#txtidTemas_Expertos").val(objClientesJSon.idTemas_Expertos);
            $("#txtObservaciones").val(objClientesJSon.Observaciones);
            $("#txtEstado").val(objClientesJSon.Estado);
            $("#txtTemas_idTemas").val(objClientesJSon.Temas_idTemas);
            $("#txtUsuarios_PK_idUsuarios").val(objClientesJSon.Usuarios_PK_idUsuarios);
            $("#typeAction").val("update_temas_expertos");
            
            swal("Confirmacion", "Los datos de la persona fueron cargados correctamente", "success");
        },
        type: 'POST'
    });
}

//*****************************************************************
//*****************************************************************

function deleteTemas_ExpertosByID(idTemas_Expertos) {
    //Se envia la información por ajax
    $.ajax({
        url: '../backend/controller/clientesController.php',
        data: {
            action: "delete_temas_expertos",
            idTemas_Expertos: idTemas_Expertos
        },
        error: function () { //si existe un error en la respuesta del ajax
            swal("Error", "Se presento un error al eliminar la informacion", "error");
        },
        success: function (data) { //si todo esta correcto en la respuesta del ajax, la respuesta queda en el data
            var responseText = data.trim().substring(2);
            var typeOfMessage = data.trim().substring(0, 2);
            if (typeOfMessage === "M~") { //si todo esta corecto
                swal("Confirmacion", responseText, "success");
                clearFormTemas_Experto();
                $("#dt_temas_expertos").DataTable().ajax.reload();
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



    var dataTableTems_Experto_const = function () {
        if ($("#dt_temas_expertos").length) {
            $("#dt_temas_expertos").DataTable({
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
                            var botones = '<button type="button" class="btn btn-default btn-xs" aria-label="Left Align" onclick="showTemas_ExpertosByID(\''+row[0]+'\');">Cargar</button> ';
                            botones += '<button type="button" class="btn btn-default btn-xs" aria-label="Left Align" onclick="deleteTemas_ExpertosByID(\''+row[0]+'\');">Eliminar</button>';
                            return botones;
                        }
                    }

                ],
                pageLength: 2,
                language: dt_lenguaje_espanol,
                ajax: {
                    url: '../backend/controller/temas_expertos.php',
                    type: "POST",
                    data: function (d) {
                        return $.extend({}, d, {
                            action: "showAll_temas_expertos"
                        });
                    }
                },
                drawCallback: function (nRow, aData, iDisplayIndex, iDisplayIndexFull) {
                    $('#dt_clientes').DataTable().columns.adjust().responsive.recalc();
                }
            });
        }
    };



    TableManageButtons = function () {
        "use strict";
        return {
            init: function () {
                dataTableTems_Experto_const();
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
    $('#dt_temas_expertos').DataTable().columns.adjust().responsive.recalc();
};


