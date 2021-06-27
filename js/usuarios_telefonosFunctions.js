/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$(function () { //para la creación de los controles
    //agrega los eventos las capas necesarias
    $("#enviar").click(function () {
        addOrUpdateUsuarios_Telefonos();
    });
    //agrega los eventos las capas necesarias
    $("#cancelar").click(function () {
        cancelAction();
    });    //agrega los eventos las capas necesarias

    $("#btMostarForm").click(function () {
        //muestra el fomurlaior
        clearFormUsuarios_Telefonos();
        $("#typeAction").val("add_usuarios_telefonos");
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

function addOrUpdateUsuarios_Telefonos() {
    //Se envia la información por ajax
    if (validar()) {
        $.ajax({
            url: '../backend/controller/usuarios_telefonosController.php',
            data: {
                action:             $("#typeAction").val(),
                idUsuarios_Telefonos:      $("#txtidUsuarios_Telefonos").val(),
                Estado:             $("#txtEstado").val(),
                Usuarios_PK_idUsuarios:           $("#txtUsuarios_PK_idUsuarios").val(),
                Tipo_TelefonosU_idTipo_TelefonosU:             $("#txtTipo_TelefonosU_idTipo_TelefonosU").val(),
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
                    clearFormUsuarios_Telefonos();
                    $("#dt_usaurios_telefonos").DataTable().ajax.reload();
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
    if ($("#txtidUsuarios_Telefonos").val() === "") {
        validacion = false;
    }

    if ($("#txtEstado").val() === "") {
        validacion = false;
    }

    if ($("#txtUsuarios_PK_idUsuarios").val() === "") {
        validacion = false;
    }

    if ($("#txtTipo_TelefonosU_idTipo_TelefonosU").val() === "") {
        validacion = false;
    }

    return validacion;
}

//*****************************************************************
//*****************************************************************

function clearFormUsuarios_Telefonos() {
    $('#formUsuarios_Telefonos').trigger("reset");
}

//*****************************************************************
//*****************************************************************

function cancelAction() {
    //clean all fields of the form
    clearFormUsuarios_Telefonos();
    $("#typeAction").val("add_usuarios_telefonos");
    $("#myModalFormulario").modal("hide");
}



//*****************************************************************
//*****************************************************************

function showUsuarios_TelefonosByID(idUsuarios_Telefonos) {
    //Se envia la información por ajax
    $.ajax({
        url: '../backend/controller/usuarios_telefonosController.php',
        data: {
            action: "show_usuarios_telefonos",
            idUsuarios_Telefonos: idUsuarios_Telefonos
        },
        error: function () { //si existe un error en la respuesta del ajax
            swal("Error", "Se presento un error al consultar la informacion", "error");
        },
        success: function (data) { //si todo esta correcto en la respuesta del ajax, la respuesta queda en el data
            var objClientesJSon = JSON.parse(data);
            $("#txtidUsuarios_Telefonos").val(objClientesJSon.idUsuarios_Telefonos);
            $("#txtEstado").val(objClientesJSon.Estado);
            $("#txtUsuarios_PK_idUsuarios").val(objClientesJSon.Usuarios_PK_idUsuarios);
            $("#txtTipo_TelefonosU_idTipo_TelefonosU").val(objClientesJSon.Tipo_TelefonosU_idTipo_TelefonosU);
            $("#typeAction").val("update_clientes");
            
            swal("Confirmacion", "Los datos de la persona fueron cargados correctamente", "success");
        },
        type: 'POST'
    });
}

//*****************************************************************
//*****************************************************************

function deleteUsuarios_TelefonosByID(idUsuarios_Telefonos) {
    //Se envia la información por ajax
    $.ajax({
        url: '../backend/controller/usuarios_telefonosController.php',
        data: {
            action: "delete_usuarios_telefonos",
            idUsuarios_Telefonos: idUsuarios_Telefonos
        },
        error: function () { //si existe un error en la respuesta del ajax
            swal("Error", "Se presento un error al eliminar la informacion", "error");
        },
        success: function (data) { //si todo esta correcto en la respuesta del ajax, la respuesta queda en el data
            var responseText = data.trim().substring(2);
            var typeOfMessage = data.trim().substring(0, 2);
            if (typeOfMessage === "M~") { //si todo esta corecto
                swal("Confirmacion", responseText, "success");
                clearFormUsuarios_Telefonos();
                $("#dt_usuarios_telefonos").DataTable().ajax.reload();
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



    var dataTableUsuarios_Telefonos_const = function () {
        if ($("#dt_usuarios_telefonos").length) {
            $("#dt_usuarios_telefonos").DataTable({
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
                            var botones = '<button type="button" class="btn btn-default btn-xs" aria-label="Left Align" onclick="showUsuarios_TelefonosByID(\''+row[0]+'\');">Cargar</button> ';
                            botones += '<button type="button" class="btn btn-default btn-xs" aria-label="Left Align" onclick="deleteUsuarios_TelfonosByID(\''+row[0]+'\');">Eliminar</button>';
                            return botones;
                        }
                    }

                ],
                pageLength: 2,
                language: dt_lenguaje_espanol,
                ajax: {
                    url: '../backend/controller/usuarios_telefonosController.php',
                    type: "POST",
                    data: function (d) {
                        return $.extend({}, d, {
                            action: "showAll_usuarios_telefonos"
                        });
                    }
                },
                drawCallback: function (nRow, aData, iDisplayIndex, iDisplayIndexFull) {
                    $('#dt_usuarios_telefonos').DataTable().columns.adjust().responsive.recalc();
                }
            });
        }
    };



    TableManageButtons = function () {
        "use strict";
        return {
            init: function () {
                dataTableUsuarios_Telefonos_const();
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
    $('#dt_usaurios_telefonos').DataTable().columns.adjust().responsive.recalc();
};


