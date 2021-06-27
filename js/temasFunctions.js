/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$(function () { //para la creación de los controles
    //agrega los eventos las capas necesarias
    $("#enviar").click(function () {
        addOrUpdateTemas();
    });
    //agrega los eventos las capas necesarias
    $("#cancelar").click(function () {
        cancelAction();
    });    //agrega los eventos las capas necesarias

    $("#btMostarForm").click(function () {
        //muestra el fomurlaior
        clearFormTemas();
        $("#typeAction").val("add_temas");
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

function addOrUpdateTemas() {
    //Se envia la información por ajax
    if (validar()) {
        $.ajax({
            url: '../backend/controller/temasController.php',
            data: {
                action:             $("#typeAction").val(),
                idTemas:      $("#txtidTemas").val(),
                Nombre:             $("#txtNombre").val(),
                Costo:           $("#txtCosto").val(),
                Observaciones:             $("#txtObservaciones").val(),
                Estado:          $("#txtEstado").val(),
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
                    clearFormTemas();
                    $("#dt_temas").DataTable().ajax.reload();
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
    if ($("#txtidTemas").val() === "") {
        validacion = false;
    }

    if ($("#txtNombre").val() === "") {
        validacion = false;
    }

    if ($("#txtCosto").val() === "") {
        validacion = false;
    }

    if ($("#txtObservaciones").val() === "") {
        validacion = false;
    }

    if ($("#txtEstado").val() === "") {
        validacion = false;
    }



    return validacion;
}

//*****************************************************************
//*****************************************************************

function clearFormTemas() {
    $('#formTemas').trigger("reset");
}

//*****************************************************************
//*****************************************************************

function cancelAction() {
    //clean all fields of the form
    clearFormTemas();
    $("#typeAction").val("add_temas");
    $("#myModalFormulario").modal("hide");
}



//*****************************************************************
//*****************************************************************

function showTemasByID(idTemas) {
    //Se envia la información por ajax
    $.ajax({
        url: '../backend/controller/temasController.php',
        data: {
            action: "show_temas",
            idTemas: idTemas
        },
        error: function () { //si existe un error en la respuesta del ajax
            swal("Error", "Se presento un error al consultar la informacion", "error");
        },
        success: function (data) { //si todo esta correcto en la respuesta del ajax, la respuesta queda en el data
            var objClientesJSon = JSON.parse(data);
            $("#txtidTemas").val(objClientesJSon.idTemas);
            $("#txtNombre").val(objClientesJSon.Nombre);
            $("#txtCosto").val(objClientesJSon.Costo);
            $("#txtObservaciones").val(objClientesJSon.Observaciones);
            $("#txtEstado").val(objClientesJSon.Estado);
            $("#typeAction").val("update_temas");
            
            swal("Confirmacion", "Los datos de la persona fueron cargados correctamente", "success");
        },
        type: 'POST'
    });
}

//*****************************************************************
//*****************************************************************

function deleteTemasByID(idTemas) {
    //Se envia la información por ajax
    $.ajax({
        url: '../backend/controller/temasController.php',
        data: {
            action: "delete_temas",
            idTemas: idTemas
        },
        error: function () { //si existe un error en la respuesta del ajax
            swal("Error", "Se presento un error al eliminar la informacion", "error");
        },
        success: function (data) { //si todo esta correcto en la respuesta del ajax, la respuesta queda en el data
            var responseText = data.trim().substring(2);
            var typeOfMessage = data.trim().substring(0, 2);
            if (typeOfMessage === "M~") { //si todo esta corecto
                swal("Confirmacion", responseText, "success");
                clearFormTemas();
                $("#dt_temas").DataTable().ajax.reload();
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



    var dataTableTemas_const = function () {
        if ($("#dt_temas").length) {
            $("#dt_temas").DataTable({
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
                            var botones = '<button type="button" class="btn btn-default btn-xs" aria-label="Left Align" onclick="showTemasByID(\''+row[0]+'\');">Cargar</button> ';
                            botones += '<button type="button" class="btn btn-default btn-xs" aria-label="Left Align" onclick="deletTemasByID(\''+row[0]+'\');">Eliminar</button>';
                            return botones;
                        }
                    }

                ],
                pageLength: 2,
                language: dt_lenguaje_espanol,
                ajax: {
                    url: '../backend/controller/temasController.php',
                    type: "POST",
                    data: function (d) {
                        return $.extend({}, d, {
                            action: "showAll_clientes"
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
                dataTableTemas_const();
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
    $('#dt_temas').DataTable().columns.adjust().responsive.recalc();
};


