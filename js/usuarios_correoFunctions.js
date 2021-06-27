/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$(function () { //para la creación de los controles
    //agrega los eventos las capas necesarias
    $("#enviar").click(function () {
        addOrUpdateUsuarios_Correo();
    });
    //agrega los eventos las capas necesarias
    $("#cancelar").click(function () {
        cancelAction();
    });    //agrega los eventos las capas necesarias

    $("#btMostarForm").click(function () {
        //muestra el fomurlaior
        clearFormUsuarios_Correo();
        $("#typeAction").val("add_usuarios_correo");
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

function addOrUpdateUsuarios_Correo() {
    //Se envia la información por ajax
    if (validar()) {
        $.ajax({
            url: '../backend/controller/usuario_correoController.php',
            data: {
                action:             $("#typeAction").val(),
                idClientes_Correo:      $("#txtidClientes_Correo").val(),
                Estado:             $("#txtEstado").val(),
                Usuarios_PK_idUsuarios:           $("#txtUsuarios_PK_idUsuarios").val(),
                Tipo_CorreoU_idTipo_CorreoU:             $("#txtTipo_CorreoU_idTipo_CorreoU").val(),
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
                    clearFormUsuarios_Correo();
                    $("#dt_usaurios_correo").DataTable().ajax.reload();
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
    if ($("#txtidClientes_Correo").val() === "") {
        validacion = false;
    }

    if ($("#txtEstado").val() === "") {
        validacion = false;
    }

    if ($("#txtUsuarios_PK_idUsuarios").val() === "") {
        validacion = false;
    }

    if ($("#txtTipo_CorreoU_idTipo_CorreoU").val() === "") {
        validacion = false;
    }

    return validacion;
}

//*****************************************************************
//*****************************************************************

function clearFormUsuarios_Correo() {
    $('#formUsuarios_Correo').trigger("reset");
}

//*****************************************************************
//*****************************************************************

function cancelAction() {
    //clean all fields of the form
    clearFormUsuarios_Correo();
    $("#typeAction").val("add_usuarios_correo");
    $("#myModalFormulario").modal("hide");
}



//*****************************************************************
//*****************************************************************

function showUsuarios_CorreoByID(idClientes_Correo) {
    //Se envia la información por ajax
    $.ajax({
        url: '../backend/controller/usuario_correoController.php',
        data: {
            action: "show_usuarios_correo",
            idClientes_Correo: idClientes_Correo
        },
        error: function () { //si existe un error en la respuesta del ajax
            swal("Error", "Se presento un error al consultar la informacion", "error");
        },
        success: function (data) { //si todo esta correcto en la respuesta del ajax, la respuesta queda en el data
            var objClientesJSon = JSON.parse(data);
            $("#txtidClientes_Correo").val(objClientesJSon.idClientes_Correo);
            $("#txtEstado").val(objClientesJSon.Estado);
            $("#txtUsuarios_PK_idUsuarios").val(objClientesJSon.Usuarios_PK_idUsuarios);
            $("#txtTipo_CorreoU_idTipo_CorreoU").val(objClientesJSon.Tipo_CorreoU_idTipo_CorreoU);
            $("#typeAction").val("update_clientes");
            
            swal("Confirmacion", "Los datos de la persona fueron cargados correctamente", "success");
        },
        type: 'POST'
    });
}

//*****************************************************************
//*****************************************************************

function deleteUsuarios_CorreoByID(idClientes_Correo) {
    //Se envia la información por ajax
    $.ajax({
        url: '../backend/controller/usuario_correoController.php',
        data: {
            action: "delete_usuarios_correo",
            idClientes_Correo: idClientes_Correo
        },
        error: function () { //si existe un error en la respuesta del ajax
            swal("Error", "Se presento un error al eliminar la informacion", "error");
        },
        success: function (data) { //si todo esta correcto en la respuesta del ajax, la respuesta queda en el data
            var responseText = data.trim().substring(2);
            var typeOfMessage = data.trim().substring(0, 2);
            if (typeOfMessage === "M~") { //si todo esta corecto
                swal("Confirmacion", responseText, "success");
                clearFormUsuarios_Correo();
                $("#dt_usuarios_correo").DataTable().ajax.reload();
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



    var dataTableUsuarios_Correo_const = function () {
        if ($("#dt_usuarios_correo").length) {
            $("#dt_usuarios_correo").DataTable({
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
                            var botones = '<button type="button" class="btn btn-default btn-xs" aria-label="Left Align" onclick="showUsuarios_CorreoByID(\''+row[0]+'\');">Cargar</button> ';
                            botones += '<button type="button" class="btn btn-default btn-xs" aria-label="Left Align" onclick="deleteUsuarios_CorreoByID(\''+row[0]+'\');">Eliminar</button>';
                            return botones;
                        }
                    }

                ],
                pageLength: 2,
                language: dt_lenguaje_espanol,
                ajax: {
                    url: '../backend/controller/usuario_correoController.php',
                    type: "POST",
                    data: function (d) {
                        return $.extend({}, d, {
                            action: "showAll_usuarios_correo"
                        });
                    }
                },
                drawCallback: function (nRow, aData, iDisplayIndex, iDisplayIndexFull) {
                    $('#dt_usuarios_correo').DataTable().columns.adjust().responsive.recalc();
                }
            });
        }
    };



    TableManageButtons = function () {
        "use strict";
        return {
            init: function () {
                dataTableUsuarios_Correo_const();
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
    $('#dt_usaurios_correo').DataTable().columns.adjust().responsive.recalc();
};


