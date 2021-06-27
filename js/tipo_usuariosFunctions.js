/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$(function () { //para la creación de los controles
    //agrega los eventos las capas necesarias
    $("#enviar").click(function () {
        addOrUpdateTipo_usuarios();
    });
    //agrega los eventos las capas necesarias
    $("#cancelar").click(function () {
        cancelAction();
    });    //agrega los eventos las capas necesarias

    $("#btMostarForm").click(function () {
        //muestra el fomurlaior
        clearFormTipo_Usuarios();
        $("#typeAction").val("add_tipos_usuarios");
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

function addOrUpdateTipo_Usaurios() {
    //Se envia la información por ajax
    if (validar()) {
        $.ajax({
            url: '../backend/controller/tipos_usuariosController.php',
            data: {
                action:             $("#typeAction").val(),
                idTipos_Usuarios:      $("#txtidTipos_Usuarios").val(),
                Descripcion_Tipos_Usuario:             $("#txtDescripcion_Tipos_Usuario").val(),
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
                    clearFormTipo_Usuarios();
                    $("#dt_tipo_usuarios").DataTable().ajax.reload();
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
    if ($("#txtidTipos_Usuarios").val() === "") {
        validacion = false;
    }

    if ($("#txtDescripcion_Tipos_Usuario").val() === "") {
        validacion = false;
    }

    return validacion;
}

//*****************************************************************
//*****************************************************************

function clearFormTipo_Usuarios() {
    $('#formTipo_usuarios').trigger("reset");
}

//*****************************************************************
//*****************************************************************

function cancelAction() {
    //clean all fields of the form
    clearFormTipo_CorreoC();
    $("#typeAction").val("add_tipos_usuarios");
    $("#myModalFormulario").modal("hide");
}



//*****************************************************************
//*****************************************************************

function showTipo_UsuariosByID(idTipos_Usuarios) {
    //Se envia la información por ajax
    $.ajax({
        url: '../backend/controller/tipos_usuariosCContoller.php',
        data: {
            action: "show_tipos_usaurios",
            idTipos_Usuarios: idTipos_Usuarios
        },
        error: function () { //si existe un error en la respuesta del ajax
            swal("Error", "Se presento un error al consultar la informacion", "error");
        },
        success: function (data) { //si todo esta correcto en la respuesta del ajax, la respuesta queda en el data
            var objClientesJSon = JSON.parse(data);
            $("#txtidTipos_Usuarios").val(objClientesJSon.idTipos_Usuarios);
            $("#txtDescripcion_Tipos_Usuario").val(objClientesJSon.Descripcion_Tipos_Usuario);
            $("#typeAction").val("update_tipos_usuarios");
            
            swal("Confirmacion", "Los datos de la persona fueron cargados correctamente", "success");
        },
        type: 'POST'
    });
}

//*****************************************************************
//*****************************************************************

function deleteTipos_UsuariosCByID(idTipos_Usuarios) {
    //Se envia la información por ajax
    $.ajax({
        url: '../backend/controller/tipos_usuariosContoller.php',
        data: {
            action: "delete_tipos_usuarios",
            idTipos_Usuarios: idTipos_Usuarios
        },
        error: function () { //si existe un error en la respuesta del ajax
            swal("Error", "Se presento un error al eliminar la informacion", "error");
        },
        success: function (data) { //si todo esta correcto en la respuesta del ajax, la respuesta queda en el data
            var responseText = data.trim().substring(2);
            var typeOfMessage = data.trim().substring(0, 2);
            if (typeOfMessage === "M~") { //si todo esta corecto
                swal("Confirmacion", responseText, "success");
                clearFormTipos_Usuarios();
                $("#dt_tipos_usuarios").DataTable().ajax.reload();
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



    var dataTableTipos_Usuarios_const = function () {
        if ($("#dt_tipos_usuarios").length) {
            $("#dt_tipos_usuarios").DataTable({
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
                            var botones = '<button type="button" class="btn btn-default btn-xs" aria-label="Left Align" onclick="showTipos_UsuariosByID(\''+row[0]+'\');">Cargar</button> ';
                            botones += '<button type="button" class="btn btn-default btn-xs" aria-label="Left Align" onclick="deleteTipos_UsuariosByID(\''+row[0]+'\');">Eliminar</button>';
                            return botones;
                        }
                    }

                ],
                pageLength: 2,
                language: dt_lenguaje_espanol,
                ajax: {
                    url: '../backend/controller/tipos_usuariosController.php',
                    type: "POST",
                    data: function (d) {
                        return $.extend({}, d, {
                            action: "showAll_tipo_correoC"
                        });
                    }
                },
                drawCallback: function (nRow, aData, iDisplayIndex, iDisplayIndexFull) {
                    $('#dt_tipos_usuarios').DataTable().columns.adjust().responsive.recalc();
                }
            });
        }
    };



    TableManageButtons = function () {
        "use strict";
        return {
            init: function () {
                dataTableTipos_Usuarios_const();
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
    $('#dt_tipos_usuarios').DataTable().columns.adjust().responsive.recalc();
};


