$(document).ready(function () {

    $("#pais").change(function () {
        var valor = $("#pais option:selected").val();

        if (valor == 158) {
            $('#departamento').html('');
            $('#departamento').removeAttr('disabled');
            $('#provincia').removeAttr('disabled');
            $('#distrito').removeAttr('disabled');

            $.ajax({
                type: "GET",
                url: "../../Views/peruvianpass/CargarDepartamento.aspx",
                data: "valor=" + valor,
                success: function (data) {

                    $("#cargar_departamento").html(data);

                    $("#departamento").change(function () {

                        var valord = $("#departamento option:selected").val();

                        $('#provincia').html('');

                        if (valord != "0") {
                            var datod = valord;

                            $.ajax({
                                type: "GET",
                                url: "../../Views/peruvianpass/CargarProvincia.aspx",
                                data: "iddep=" + datod,
                                success: function (data) {

                                    $("#cargar_provincia").html(data);

                                    $("#provincia").change(function () {

                                        var iddep = $("#departamento").val();
                                        var idprov = $(this).val();
                                        $('#distrito').html('');

                                        $.ajax({
                                            type: "GET",
                                            url: "../../Views/peruvianpass/CargarDistrito.aspx",
                                            data: { iddep: iddep, idprov: idprov },
                                            success: function (data) {
                                                $("#cargar_distrito").html(data);
                                            }, beforeSend: function () {
                                                $(".carga_d").css("display", "block");
                                            }, complete: function () {
                                                $(".carga_d").css("display", "none");
                                            }
                                        })

                                    })


                                }, beforeSend: function () {
                                    $(".carga_p").css("display", "block");
                                }, complete: function () {
                                    $(".carga_p").css("display", "none");
                                }

                            })

                        }

                    })

                }, beforeSend: function () {
                    $(".carga_d").css("display", "block");
                }, complete: function () {
                    $(".carga_d").css("display", "none");
                }
            })

        } else {
            $('#departamento > option')[0].selected = true;
            $('#provincia > option')[0].selected = true;
            $('#distrito > option')[0].selected = true;
            $('#departamento').attr('disabled', 'disabled');
            $('#provincia').attr('disabled', 'disabled');
            $('#distrito').attr('disabled', 'disabled');

        }



    });



})

    function PasajeroEdit(id_pasajero) {

        $.ajax({
            type: "GET",
            url: "../../Views/peruvianpass/ListarPasajero.aspx",
            data: "flag=1&id_pasajero=" + id_pasajero,
            success: function (data) {

                $("#listar_pasajero").html(data);
            }

        });


        $('#listar_pasajero').dialog({
            autoOpen: true,
            title: 'Editar Pasajero',
            resizable: false,
            width: "700",
            height: "600",
            modal: true,
            buttons: {
                "Actualizar": function () {
                    
                    nombre = $("#nombre").val();
                    materno = $("#app").val();
                    paterno = $("#apm").val();
                    tipo_documento = $("#tipDoc option:selected").val();
                    documento = $("#ndoc").val();
                    genero = $("#genero option:selected").val();
                    fec_nac = $("#fecha").val();
                    direccion = $("#dir").val();
                    tel =  $("#telefono").val();
                    cel = $("#celular").val();
                    correo = $("#correo").val();
                    raz = $("#razon").val();
                    nruc = $("#ruc").val();
                    estado = $("#estado option:selected").val();

                    pais = $("#pais option:selected").val();
                    departamento = $("#departamento option:selected").val();
                    provincia = $("#provincia option:selected").val();
                    distrito = $("#distrito option:selected").val();

                    var dato = "flag=2&nombre=" + nombre + "&materno=" + materno + "&paterno=" + paterno + "&tdoc=" + tipo_documento + "&doc=" + documento + "&genero=" + genero + "&fec_nac=" + fec_nac + "&dir=" + direccion + "&tel=" + tel + "&cel=" + cel + "&correo=" + correo + "&raz=" + raz + "&nruc=" + nruc + "&estado=" + estado + "&pais=" + pais + "&departamento=" + departamento + "&provincia=" + provincia + "&distrito=" + distrito + "&id_pasajero=" + id_pasajero;

                    $.ajax({
                        type: "GET",
                        url: "../../Views/peruvianpass/Proceso.aspx",
                        data: dato,
                        success: function (data) {
                            $(this).dialog("close");
                        }
                    });

                },
                "Cerrar": function () {

                    $(this).dialog("close");

                }
                
            }
        });

    }
    function PasajeroVer(IdPasajero) {

        $('#ver_pasajero').dialog({
            autoOpen: true,
            title: 'Ver Datos del Pasajero',
            resizable: false,
            width: "700",
            height: "600",
            modal: true,
            buttons: {
                "Cerrar": function () {
                    $(this).dialog("close");
                }
            }
        });

        $.ajax({
            type: "GET",
            url: "../../Views/peruvianpass/VerPasajero.aspx",
            data: "IdPasajero=" + IdPasajero,
            success: function (data) {

                $("#ver_pasajero").html(data);
            }

        })
    }

     
    function PasajeroListar() {

        var $dialog = $('#listar_pasajero')
            .load("../../Views/peruvianpass/ListarPasajero.aspx")
            .dialog({
                autoOpen: false,
                title: 'Nuevo Pasajero',
                width: "700",
                height: "600",
                modal: true,
                buttons: {
                    "Insertar": function () {

                        nombre = $("#nombre").val();
                        materno = $("#app").val();
                        paterno = $("#apm").val();
                        tipo_documento = $("#tipDoc option:selected").val();
                        documento = $("#ndoc").val();
                        genero = $("#genero option:selected").val();
                        fec_nac = $("#fecha").val();
                        direccion = $("#dir").val();
                        tel = $("#telefono").val();
                        cel = $("#celular").val();
                        correo = $("#correo").val();
                        raz = $("#razon").val();
                        nruc = $("#ruc").val();
                        estado = $("#estado option:selected").val();

                        pais = $("#pais option:selected").val();
                        departamento = $("#departamento option:selected").val();
                        provincia = $("#provincia option:selected").val();
                        distrito = $("#distrito option:selected").val();
                        contrasena = $("#contrasena").val();
                        
                        var dato = "flag=3&nombre=" + nombre + "&materno=" + materno + "&paterno=" + paterno + "&tdoc=" + tipo_documento + "&doc=" + documento + "&genero=" + genero + "&fec_nac=" + fec_nac + "&dir=" + direccion + "&tel=" + tel + "&cel=" + cel + "&correo=" + correo + "&raz=" + raz + "&nruc=" + nruc + "&estado=" + estado + "&pais=" + pais + "&departamento=" + departamento + "&provincia=" + provincia + "&distrito=" + distrito + "&id_pasajero=" + id_pasajero + "&contrasena=" + contrasena;

                        $.ajax({
                            type: "GET",
                            url: "../../Views/peruvianpass/Proceso.aspx",
                            data: dato,
                            success: function (data) {
                                $(this).dialog("close");
                            }
                        });

                    },
                    "Cerrar": function () {
                        $(this).dialog("close");
                    }
                }
            });

        $dialog.dialog('open');


      
    }