
//const axios = require('axios');
var app = new Vue({
    el: '#principal',
    data: {
        search:'',
        tripulacion:[]   
    },
    methods:{
        listar:function(){
            var url = SERVER_NAME+'tripulacion/list';
            axios.get(url)
            .then(function (response) {
                app.tripulacion = response.data;
            })
            .catch(function (error) {
                console.log(error);
            });
        }
    },
    mounted: function () {
        this.listar();
    } 
});
$(document).ready(function () {

    /*$('#tblvuelos').DataTable({
        ordering: false,
        searching: false,
        lengthChange: false,
        info: false
    });*/
    opendEdit();
    opendCreate();
    activarTripulante();
    desactivarTripulante();
    eliminarTripulante();
});

function opendEdit() {

    $(".btn-edit").click(function (e) {
        e.preventDefault();
        var id_tripulante = $(this).attr('data-id');
        $.ajax({
            url: SERVER_NAME + 'tripulacion/edit',
            type: 'post',
            data: {id_tripulante: id_tripulante},
            success: function (response) {
                $("#title_modal").text("Editar Tripulante");
                $('#body_dinamicac_modal').html(response);
                $('#dinamicModal .select2').each(function () {
                    var container = $(this).parent();
                    $(this).select2({
                        dropdownParent: container
                    });
                });
                ValidTripulacion("update");
                $('#dinamicModal').modal('show');
            }
        });
    });
}

function opendCreate() {

    $("#btn-create").click(function (e) {
        e.preventDefault();
        var tipo_funcion = $("#tipo_funcion").val();
        var JsonData = {tipo_funcion: tipo_funcion};
        $.ajax({
            url: SERVER_NAME + 'tripulacion/create',
            type: 'post',
            data: JsonData,
            success: function (response) {
                $("#title_modal").text("Nuevo Tripulante");
                $('#body_dinamicac_modal').html(response);

                $('#dinamicModal .select2').each(function () {
                    var container = $(this).parent();
                    $(this).select2({
                        dropdownParent: container
                    });
                });
                ValidTripulacion("create");
                $('#dinamicModal').modal('show');

            }
        });
    });
}

function ValidTripulacion(from) {

    $("#tripulacion-form").validate({
        rules: {
            licencia: "required",
            email: {
                required: true,
                email: true
            },
            num_documento: {
                required: true,
                number: true,
                minlength: 8,
                maxlength: 8
            },
            nombre: {required: true},
            apellidos: {required: true}
        },
        messages: {
            licencia: "Por favor indica una Licencia",
            email: {
                required: "Por favor, indica una  de e-mail valida",
                email: "Ingrese un email valido"
            },
            num_documento: {
                required: "Por favor ingrese un dni",
                number: "Campo debe ser numérico",
                minlength: "Debe contener 8 caracteres",
                maxlength: "Debe contener 8 caracteres"
            },
            nombre: {required: "Por favor ingrese un nombre"},
            apellidos: {required: "Por favor ingrese los apellidos"}

        },
        submitHandler: function (form) {
            $("#btnSaveTripulacion").attr("disabled", true);
            /*console.log("llama al ajax");
             $("#alert").html("<img src='"+SERVER_PUBLIC+"img/ajax-loader.gif' style='vertical-align:middle;margin:0 10px 0 0' /><strong>Enviando mensaje...</strong>");
             setTimeout(function() {
             $('#alert').fadeOut('slow');
             }, 5000);*/
            var tipo_funcion = $("#tipo_funcion").val();
            var id_funcion = $("#funcion").val();
            var licencia = $("#licencia").val();
            var num_documento = $("#num_documento").val();
            var nombre = $("#nombre").val();
            var apellidos = $("#apellidos").val();
            var telefono = $("#telefono").val();
            var celular = $("#phone").val();
            var email = $("#email").val();

            if (from == "create") {
                var dataJson = {
                    id_funcion: id_funcion,
                    licencia: licencia,
                    num_documento: num_documento,
                    nombre: nombre,
                    apellidos: apellidos,
                    telefono: telefono,
                    numcelular: celular,
                    email: email,
                    tipo_funcion: tipo_funcion
                };
                ajaxStore(dataJson);
            } else if (from == "update") {
                var id_tripulante = $("#id_tripulante").val();
                var dataJson = {
                    id_tripulante: id_tripulante,
                    id_funcion: id_funcion,
                    licencia: licencia,
                    num_documento: num_documento,
                    nombre: nombre,
                    apellidos: apellidos,
                    telefono: telefono,
                    numcelular: celular,
                    email: email,
                    tipo_funcion: tipo_funcion
                };
                ajaxUpdate(dataJson);
            }

        }
    });

}

function ajaxStore(dataJson) {
    $.ajax({
        type: "POST",
        url: SERVER_NAME + 'tripulacion/store',
        data: dataJson,
        dataType: "JSON",
        beforeSend: function () {
            $("#alert").html("<img src='" + SERVER_PUBLIC + "img/ajax-loader.gif' style='vertical-align:middle;margin:0 10px 0 0' /><strong>Registrando...</strong>");
        },
        success: function (response) {
            if (response.rpt == 1) {
                $('#dinamicModal').modal('hide');
                swal("Pasajero Guardado Correctamente", {
                    icon: "success"
                }).then((willDelete) => {
                    if (willDelete) {
                        location.reload();
                    }
                });
            } else {
                modalError(response.msg);
            }
        }
    });
}

function ajaxUpdate(dataJson) {

    $.ajax({
        type: "POST",
        url: SERVER_NAME + 'tripulacion/update',
        data: dataJson,
        dataType: "JSON",
        beforeSend: function () {
            $("#alert").html("<img src='" + SERVER_PUBLIC + "img/ajax-loader.gif' style='vertical-align:middle;margin:0 10px 0 0' /><strong>Registrando...</strong>");
        },
        success: function (response) {
            if (response.rpt == 1) {
                $('#dinamicModal').modal('hide');
                swal("Pasajero Actualizado Correctamente", {
                    icon: "success"
                }).then((willDelete) => {
                    if (willDelete) {
                        location.reload();
                    }
                });
            } else {
                modalError(response.msg);
            }
        }
    });
}

function desactivarTripulante() {
    $(".btn_inactive").click(function () {
        var id_tripulante = $(this).attr("data-id");
        var urlJson = {id_tripulante: id_tripulante};
        swal({
            icon: 'warning',
            title: 'Desactivar Tripulante',
            text: "Esta seguro de desactivar al tripulante",
            buttons: true,
            dangerMode: true
        }).then((willDelete) => {
            if (willDelete) {
                $.ajax({
                    url: SERVER_NAME + 'tripulacion/desactivar',
                    type: 'post',
                    data: urlJson,
                    dataType: "json",
                    success: function (response) {
                        if (response.rpt == 1) {
                            swal(response.msg, {
                                icon: "success"
                            }).then((willDelete) => {
                                if (willDelete) {
                                    location.reload();
                                }
                            });
                        } else {
                            modalError(response.msg_error);
                        }
                    }
                });
            }
        });
    });
}

function activarTripulante() {
    $(".btn_active").click(function () {
        var id_tripulante = $(this).attr("data-id");
        var urlJson = {id_tripulante: id_tripulante};
        swal({
            icon: 'warning',
            title: 'Activar Tripulante',
            text: "Esta seguro de activar al tripulante",
            buttons: true,
            dangerMode: true
        }).then((willDelete) => {
            if (willDelete) {
                $.ajax({
                    url: SERVER_NAME + 'tripulacion/activar',
                    type: 'post',
                    data: urlJson,
                    dataType: "json",
                    success: function (response) {
                        if (response.rpt == 1) {
                            swal(response.msg, {
                                icon: "success"
                            }).then((willDelete) => {
                                if (willDelete) {
                                    location.reload();
                                }
                            });
                        } else {
                            modalError(response.msg_error);
                        }
                    }
                });
            }
        });
    });
}

function eliminarTripulante() {
    $(".eliminar_tri").click(function () {
        var id_tripulante = $(this).attr("data-id");
        var urlJson = {id_tripulante: id_tripulante};
        swal({
            icon: 'warning',
            title: 'Eliminar Tripulante',
            text: "Esta seguro de eliminar al tripulante " + id_tripulante,
            buttons: true,
            dangerMode: true
        }).then((willDelete) => {
            if (willDelete) {
                $.ajax({
                    url: SERVER_NAME + 'tripulacion/delete',
                    type: 'post',
                    data: urlJson,
                    dataType: "json",
                    success: function (response) {
                        if (response.rpt == 1) {
                            swal(response.msg, {
                                icon: "success"
                            }).then((willDelete) => {
                                if (willDelete) {
                                    location.reload();
                                }
                            });
                        } else {
                            modalError(response.msg_error);
                        }
                    }
                });
            }
        });

    });
}