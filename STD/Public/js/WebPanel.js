$(document).ready(function () {
    $('ul.dropdown-menu [data-toggle=dropdown]').on('click', function (event) {
        
      /*  // Avoid following the href location when clicking
        event.preventDefault();
        // Avoid having the menu to close when clicking
        event.stopPropagation();
        // If a menu is already open we close it
        //$('ul.dropdown-menu [data-toggle=dropdown]').parent().removeClass('open');
        // opening the one you clicked on
        $(this).parent().addClass('open');
        var menu = $(this).parent().find("ul");
        var menupos = menu.offset();
        if ((menupos.left + menu.width()) + 30 > $(window).width()) {
            var newpos = -menu.width();
        } else {
            var newpos = $(this).parent().width();
        }
        menu.css({ left: newpos });*/
    });

    $('ul.dropdown-menu [data-toggle=dropdown]').on('click', function (event) {
        event.preventDefault();
        event.stopPropagation();
        $('ul.dropdown-menu [data-toggle=dropdown]').parent().removeClass('open');
        $(this).parent().addClass('open');
        var menu = $(this).parent().find("ul");
        var menupos = menu.offset();
        if ((menupos.left + menu.width()) + 30 > $(window).width()) {
            var newpos = -menu.width();
        } else {
            var newpos = $(this).parent().width();
        }
        menu.css({ left: newpos });
    })

})
function NotaBorrar(id_reserva, cod_reserva) {

    var nota = $("#nota").val("");

    $('#borrar_nota').dialog({
        autoOpen: true,
        title: 'Status de la Reserva y Observacion',
        resizable: false,
        width: "390",
        height: "310",
        modal: true,
        buttons: {
            "Guardar": function () {
                var nota = $("#nota").val();
                var resuelto = ($('#resuelto:checked').val() == "1") ? "1" : "0";
                
                $.ajax({
                    type: "GET",
                    url: "../../Views/webpanel/ObservacionProceso.aspx",
                    data: "flag=4&codigo="+id_reserva+"&nota="+nota+"&resuelto="+resuelto,
                    success: function (data) {
                       
                    }
                })

                $("#borrar_nota").dialog("close");
                $("#MainContent_cmdBuscar").click();
                alertify.success("Se Grabo todos los cambios");


            },
            "Cerrar": function () {
                $(this).dialog("close");
            }
        }
    });

}



    function VerReservaVerificacion(id_verificacion_email, estado, id_verificacion_visual) {

        $.ajax({
            type: "GET",
            url: "../../Views/webpanel/VerificacionReserva.aspx",
            data: "id_verificacion=" + id_verificacion_email + "&estado=" + estado + "&id_visual=" + id_verificacion_visual,
            success: function (data) {
                $("#cargar_mensaje").html(data);
                $("#cargar_mensaje").css("display", "block");
            }
        })

    }
   
    function ChangeStatusPax(id_pasajero, estado) {

        var msg = (estado == 1) ? "Desactivar" : "Activar";
        var status = (estado == 1) ? 0 : 1;


        alertify.confirm("Desea " + msg + " el registro : " + id_pasajero, function (e) {
            if (e) {

                $.ajax({
                    type: "GET",
                    url: "../../Views/peruvianpass/Proceso.aspx",
                    data: "flag=1&id_pasajero=" + id_pasajero+ "&estado=" + status,
                    success: function (data) {
                    }
                })
                setTimeout(function () { $("#MainContent_cmdBuscar").click(); }, 1000);
                alertify.success("Se ha cambiado el status del registro" + id_pasajero + " a " + msg);

            } else {

                alertify.error("Has cancelado la accion");

            }
        });

        
    }
    function ChangeStatusDscto(id_agencia_dscto, estado) {

        var msg = (estado == 1) ? "Desactivar" : "Activar";
        var status = (estado == 1) ? 0 : 1;

        alertify.confirm("Desea " + msg + " el registro : " + id_agencia_dscto, function (e) {
            if (e) {
                
                
                $.ajax({
                    type: "GET",
                    url: "../../Views/comercial/Proceso.aspx",
                    data: "flag=1&id_agencia_dscto=" + id_agencia_dscto + "&estado=" + status,
                    success: function (data) {

                    }
                })

                setTimeout(function () { $("#buscar").click(); }, 1000);
                alertify.success("Se ha cambiado el status del registro" + id_agencia_dscto + " a " + msg);

            } else {

                alertify.error("Has cancelado la accion");

            }
        });

    }
    function ChangeDscto(id_agencia_dscto,dscto) {

        setTimeout(function () { $("#alertify-text").val(dscto); }, 500);

        alertify.prompt("Desea cambiar el descuento para el registro : " + id_agencia_dscto, function (e, str) {           

            if (e) {

                $.ajax({
                    type: "GET",
                    url: "../../Views/comercial/Proceso.aspx",
                    data: "flag=2&id_agencia_dscto=" + id_agencia_dscto + "&descuento=" + str,
                    success: function (data) {

                    }
                })

                setTimeout(function () { $("#buscar").click(); }, 1000);
                alertify.success("Se ha actualizado el registro " + id_agencia_dscto + " con el descuento : " + str);
                
            } else {
                alertify.error("Has pulsado cancelado la accion");
            }
        });


    }
     

    function ChangeExtranjero(id_ruta_clase, estado) {

        var msg = (estado == 1) ? "Nacional" : "Internacional";
        var msg2 = (estado == 1) ? "Desactivar" : "Activar";
        var status = (estado == 1) ? 0 : 1;

        alertify.confirm("Desea cambiar a " + msg + " el registro : " + id_ruta_clase, function (e) {
            if (e) {
                
                $.ajax({
                    type: "GET",
                    url: "../../Views/revenue/Proceso.aspx",
                    data: "flag=2&id_ruta_clase=" + id_ruta_clase + "&estado=" + status,
                    success: function (data) {

                    }
                })
               
                setTimeout(function () { $("#buscar").click(); }, 1000);
                alertify.success("Se ha cambiado el registro" + id_ruta_clase+ " a " + msg);

            } else {

                alertify.error("Has cancelado la accion");

            }
        });
        return false;


    }
    function ChangeStatusPrice(id_ruta_clase, estado) {

        var msg = (estado == 1) ? "Desactivado" : "Activado";
        var msg2 = (estado == 1) ? "Desactivar" : "ACtivar";
        var status = (estado == 1) ? 0 : 1;

        alertify.confirm("Desea " + msg2 + " el registro : " + id_ruta_clase, function (e) {
            if (e) {

                $.ajax({
                    type: "GET",
                    url: "../../Views/revenue/Proceso.aspx",
                    data: "flag=1&id_ruta_clase=" + id_ruta_clase + "&estado=" + status,
                    success: function (data) {

                    }
                })
                setTimeout(function () { $("#buscar").click(); }, 1000);
                alertify.success("Se ha " + msg + " el registro  : " + id_ruta_clase);

            } else {

                alertify.error("Has cancelado la accion");

            }
        });
        return false;

    }
    function ChangeFamilia(id_ruta_clase, familia) {


        alertify.confirm("¿Desea cambiar la familia de esta clase?", function (e) {
            if (e) {

                $.ajax({
                    type: "GET",
                    url: "../../Views/revenue/Proceso.aspx",
                    data: "flag=3&id_ruta_clase=" + id_ruta_clase + "&familia=" + familia,
                    success: function (data) {

                    }
                })
                setTimeout(function () { $("#buscar").click(); }, 1000);
                alertify.success("Se ha modificado la familia del registro.");

            } else {

                alertify.error("Has cancelado la accion");

            }
        });
        return false;

    }

    function VerificacionDetalle(id_reserva) {
        
        $.ajax({
            type: "GET",
            url: "../../Views/webpanel/VerificacionDetalle.aspx",
            data: "codigo=" + id_reserva ,
            success: function (data) {
                $("#verificacion_detalle").html(data);
            }
        })

        $('#verificacion_detalle').dialog({
            autoOpen: true,
            title: 'Verificacion Visual - Detalle',
            resizable: false,
            width: "820",
            height: "500",
            modal: true
        });

    }

    function BorrarListaNegra(id_reserva) {
        $("#borrar_lista_negra").html("Seguro Quitar de Lista Negra el ID : " + id_reserva);

        $('#borrar_lista_negra').dialog({
            autoOpen: true,
            title: 'Aviso',
            resizable: false,
            width: "350",
            height: "150",
            modal: true,
            buttons: {
                "Aceptar": function () {
                   $.ajax({
                        type: "GET",
                        url: "../../Views/webpanel/ObservacionProceso.aspx",
                        data: "flag=3&codigo=" + id_reserva,
                        success: function (data) {
                            $("#borrar_lista_negra").dialog("close");
                            alertify.error('Se quito de lista Negra el ID : '+id_reserva);
                        }
                    })
                },
                "Cerrar": function () {
                    $(this).dialog("close");
                }
            }
        });
    }

    function BorrarListaDevolucion(id_reserva) {
        $("#borrar_lista_negra").html("Seguro Quitar de Lista devolucion el ID : " + id_reserva);

        $('#borrar_lista_negra').dialog({
            autoOpen: true,
            title: 'Aviso',
            resizable: false,
            width: "350",
            height: "150",
            modal: true,
            buttons: {
                "Aceptar": function () {
                    $.ajax({
                        type: "GET",
                        url: "../../Views/webpanel/ObservacionProceso.aspx",
                        data: "flag=5&codigo=" + id_reserva,
                        success: function (data) {
                            $("#borrar_lista_negra").dialog("close");
                            alertify.error('Se quito de lista de devolucion el ID : ' + id_reserva);
                        }
                    })
                },
                "Cerrar": function () {
                    $(this).dialog("close");
                }
            }
        });
    }
    function AgregarDscto() {

        $("#txt_clase").val("");
        $("#txt_porcentaje").val("");

        
        $('#agregar_dscto').dialog({
            autoOpen: true,
            title: 'Agregar Descuento',
            resizable: false,
            width: "450",
            height: "200",
            modal: true,
            buttons: {
                "Grabar": function () {

                    id_agencia = $("#id_agencia").val();
                    id_ruta = $("#id_ruta").val();
                    clase = $("#txt_clase").val();
                    dscto = $("#txt_porcentaje").val();

                    //alert(clase+" / "+dscto);

                    $.ajax({
                        type: "GET",
                        url: "../../Views/comercial/Proceso.aspx",
                        data: "flag=3&id_agencia=" + id_agencia + "&id_ruta=" + id_ruta + "&clase=" + clase + "&dscto=" + dscto,
                        success: function (data) {

                            alertify.success('Se agrego la clase : ' + clase + " con el porcentaje : " + dscto);
                        }
                    });
                    $("#agregar_dscto").dialog("close");
                    setTimeout(function () { $("#buscar").click(); }, 500);
                },
                "Cerrar": function () {
                    $(this).dialog("close");
                }
            }
        });



    }

    function Ip(tipo, dato, clave) {

        $.ajax({
            type: "GET",
            url: "../../Views/webpanel/IpDetalle.aspx",
            data: "tipo=" + tipo+"&dato="+dato+"&clave="+clave,
            success: function (data) {
                $("#ip_detalle").html(data);
            }
        })
        var titulo="";
        switch(tipo) {
            case "ip":
                titulo="Ventas desde la ip "+dato;
                break;
            case "tc":
                titulo = "Ventas con la tarjeta " + dato;
                break;
            case "pnr":
                titulo = "Transacciones con el PNR " + dato;
                break;    
        }

        $('#ip_detalle').dialog({
            autoOpen: true,
            title: titulo,
            resizable: false,
            width: "900",
            height: "500",
            modal: true
        });

    }
    function Reset_Status_Reserva() {
            
        $("#detalle_motivo").val("");
        $("#nota option:first").attr("selected", "selected");
        $("#revision option:first").attr("selected", "selected");
        $("input[name='anulado']").attr('checked', false);
        alertify.error('Se Borro todos los datos ingresados ...! ');

    }

    function EnviarVerificacionVisual(){
        
        idreserva = $("#lbl_idreserva").html();
        destinatarios = $("#txtdestinatarios").val();
        asunto = $("#txtasunto").val();
        txtCuerpo = $("#txtDatosReserva").val();
        txtNota = $("#txtNota").val();

        $.ajax({
            type: "GET",
            url: "../../Views/webpanel/ObservacionProceso.aspx",
            data: "flag=2&codigo=" + idreserva + "&destinatarios=" + destinatarios + "&asunto=" + asunto + "&cuerpo=" + txtCuerpo + "&nota=" + txtNota,
            success: function (data) {
                alertify.error('Se Envio la Verificacion Visual ... !');
            }
        })

    }

    function Guardar_Status_Reserva() {
       
        nota = $("#nota option:selected").val();
        detalle_motivo = $("#detalle_motivo").val();
        revision = $("#revision option:selected").val();
        idreserva = $("#lbl_idreserva").html();
        anulado = $("input[name='anulado']:checked").val();

        if (anulado == undefined) {
            anulado = 0;
        }
        else {
            anulado = 1;
        }
        $.ajax({
            type: "GET",
            url: "../../Views/webpanel/ObservacionProceso.aspx",
            data: "flag=1&nota=" + nota + "&detalle_motivo=" + detalle_motivo + "&revision=" + revision + "&id_reserva=" + idreserva + "&anulado=" + anulado,
            success: function (data) {
                alertify.error('Se Ingreso su Observacion ...! ');
            }
        })
    }

    function Obs(id_reserva) {

        $('#obs').html("");
        //$('#reserva_form').visible = true;
        $('#obs').load("../../Views/app/load.html");
        $.ajax({
            type: "GET",
            url: "../../Views/webpanel/Observacion.aspx",
            data: "codigo=" + id_reserva,
            success: function (data) {
                $("#obs").html(data);
            }
        });

        $('#obs').dialog({
            autoOpen: true,
            title: "Operaciones - Detalle Venta",
            resizable: false,
            width: "900",
            height: "500",
            modal: true
        });
    }

    function ReservaVer(id_reserva) {

        var tipo=$("#MainContent_web_tipo option:selected").val()

        if (typeof $("#MainContent_web_tipo option:selected").val() == "undefined") {
            tipo = 1;
        }
        
        //$.ajax({
        //    type : "GET",
        //    url: "../../Views/webpanel/VerReserva.aspx",
        //    data: "codigo=" + id_reserva+"&tipo="+tipo,
        //    success: function (data) {
        //        $("#reserva_form").html(data);
        //    }
        //})

        $('#reserva_form').html("");
        //$('#reserva_form').visible = true;
        $('#reserva_form').load("../../Views/app/load.html");
        
        //Changed by rpadilla 23/Aug
        $('#reserva_form').load("../../Views/webpanel/VerReserva.aspx?codigo=" + id_reserva + "&tipo=" + tipo);

        //alert("2:codigo=" + id_reserva + "&tipo=" + tipo);

        $('#reserva_form').dialog({
            autoOpen: true,
            title: 'Reserva - Detalles',
            resizable: false,
            width: "820",
            height: "500",
            modal: false
        });
    }

    function ListaNegra(id_reserva) {
    
        $("#lista_negra").html("Desea poner en Lista Negra el id_reserva : "+id_reserva + " ? ");

        $('#lista_negra').dialog({
            autoOpen: true,
            title: 'Aviso',
            resizable: false,
            width: "350",
            height: "150",
            modal: true,
            buttons: {
                "Aceptar": function (){

                    $.ajax({
                        type: "GET",
                        url: "../../Views/webpanel/ListaNegra.aspx",
                        data: "codigo=" + id_reserva,
                        success: function (data) {
                            $("#lista_negra").css("height","75px")
                            $("#lista_negra").html(data);
                        }

                    })

                },
                "Cerrar": function () {
                    $(this).dialog("close");
                }
            }
        });
    }
    
   

    function Reemitir(id_reserva, cod_reserva) {

        $("#emitir_reserva").html("Desea Emitir la reserva : " + cod_reserva + " ? ");

        var tipo = $("#MainContent_web_tipo option:selected").val()

        if (typeof $("#MainContent_web_tipo option:selected").val() == "undefined") {
            tipo = 1;
        }
       
        $('#emitir_reserva').dialog({
            autoOpen: true,
            title: 'Aviso',
            resizable: false,
            width: "350",
            height: "150",
            modal: true,
            buttons: {
                "Aceptar": function () {

                    $.ajax({
                        type: "GET",
                        url: "../../Views/webpanel/RealizarPago.aspx",
                        data: "codigo=" + id_reserva+"&tipo="+tipo,
                        success: function (data) {
                            $("#emitir_reserva").html(data);
                        }

                    })

                },
                "Cerrar": function () {
                    $(this).dialog("close");
                }
            }
        });


    }

  
