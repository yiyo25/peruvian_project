$(document).ready(function () {
    BuscarPasajero();
    opendCreate();
    var flag = $("#flag").val();

    if(flag=="loadBack"){

        var idFileTuua = $("#idFileTuua").val();

        setTimeout(function(){listarVuelos();

        },300);

    }
})

function opendEdit(id_file) {
    //$(".modificar").click(function (e) {
        //e.preventDefault();
        //var id_file = $(this).attr("id_file");
        $.ajax({
            url: SERVER_NAME + 'Tuua_application/AdpController',
            type: 'post',
            data:{flag:'ConsultarManifiesto',idFileTuua:id_file},
            dataType: "json",
            success: function (response) {
                //console.log(response.data.aeroEmbarque);

                $("#title_modal").text("Editar Manifiesto");
                $('#body_dinamicac_modal').html(response.html_form);
                $("#fecha_vuelo").val(response.data.fecVueloTip);
                $("#nro_vuelo").val(response.data.nroVuelo);
                $("#origen_mani").val(response.data.aeroEmbarque);
                $("#hora_despegue").val(response.data.horaCierrePuerta);
                $("#hora_cierra_despegue").val(response.data.horaCierreDespegue);
                $("#hora_llegada_destino").val(response.data.horaLlegadaDestino);
                $("#matricula_avion").val(response.data.matriculaAvion);
                $('#dateFechavuelo').datetimepicker({
                    format: 'YYYY-MM-DD'
                })
                $('#dinamicModal').modal('show');
                UpdateManifiesto(id_file);
            }
        });
    //});
}

function opendCreate() {

    $("#btn-create").click(function (e) {
        e.preventDefault();
        $.ajax({
            url: SERVER_NAME + 'Tuua_application/createManifiesto',
            type: 'post',
            success: function (response) {
                $("#title_modal").text("Crear Manifiesto");
                $('#body_dinamicac_modal').html(response);
                $('#dateFechavuelo').datetimepicker({
                    format: 'YYYY-MM-DD'
                })
                $('#dinamicModal').modal('show');
                validManifiesto();
            }
        });
    });
}

function validManifiesto(){

    $("#btnSaveManifiesto").click(function () {
        fecha_vuelo=$("#fecha_vuelo").val();
        nro_vuelo=$("#nro_vuelo").val();
        origen=$("#origen_mani").val();
        hora_despegue=$("#hora_despegue").val();
        hora_cierra_despegue=$("#hora_cierra_despegue").val();
        hora_llegada_destino=$("#hora_llegada_destino").val();
        matricula_avion=$("#matricula_avion").val();


        validFormManifiesto(fecha_vuelo,nro_vuelo,origen,hora_despegue,hora_cierra_despegue,hora_llegada_destino,matricula_avion)

        $.ajax({
            type : "POST",
            url : SERVER_NAME + 'Tuua_application/AdpController',
            data : "flag=CrearManifiesto&fecha_vuelo="+fecha_vuelo+"&nro_vuelo="+nro_vuelo+"&origen="+origen+"&hora_despegue="+hora_despegue+"&hora_cierra_despegue="+hora_cierra_despegue+"&hora_llegada_destino="+hora_llegada_destino+"&matricula_avion="+matricula_avion,
            dataType: "json",
            success:function(response){

                $("#fecha_vuelo").val("");
                $("#nro_vuelo").val("");
                $("#origen_mani").val("");
                $("#hora_despegue").val("");
                $("#hora_cierra_despegue").val("");
                $("#hora_llegada_destino").val("");
                $("#matricula_avion").val("");
                if (response.rpt == 1) {
                    swal("Manifiesto creado Correctamente", {
                        icon: "success"
                    }).then((willDelete) => {
                        if (willDelete) {
                            $('#dinamicModal').modal('hide');
                            listarVuelos();
                        }
                    });

                }else{
                    modalError(response.msg_error);
                }

            }
        });

    })

}

function validFormManifiesto(fecha_vuelo,nro_vuelo,origen,hora_despegue,hora_cierra_despegue,hora_llegada_destino,matricula_avion){

    if ( /(?:19|20)[0-9]{2}-(?:0[1-9]|1[0-2])-(?:0[1-9]|[12][0-9]|3[01])/.test(fecha_vuelo)) {
    }else{ modalError("la fecha de vuelo no es correcta"); $( "#fecha_vuelo" ).focus();return false;}

    if ( /^[0-9]{3,4}$/.test(nro_vuelo) ) {
    }else{ modalError("El numero de vuelo no es correcto"); $( "#nro_vuelo" ).focus();return false;}

    if ( /^[AQP,CUZ,IQT,LIM,PIU,TCQ,PCL,TPP]{3}$/.test(origen) ) {
    }else{ modalError("El origen no es correcto"); $( "#origen" ).focus(); return false;}

    if ( /^[0-9]{4}$/.test(hora_despegue) ) {
    }else{ modalError("La hora Despegue no es correcta"); $( "#hora_despegue" ).focus(); return false;}

    if ( /^[0-9]{4}$/.test(hora_cierra_despegue) ) {
    }else{ modalError("La hora_cierra_despegue no es correcto"); $( "#hora_cierra_despegue" ).focus(); return false;}

    if ( /^[0-9]{4}$/.test(hora_llegada_destino) ) {
    }else{ modalError("La hora_llegada_destino no es correcto"); $( "#hora_llegada_destino" ).focus(); return false;}

    if ( /^[A-Z]{1,2}[0-9]{4}$/.test(matricula_avion) ) {
    }else{ modalError("La matricula_avion no es correcta");$( "#matricula_avion" ).focus(); return false;}
}


function BuscarPasajero(){
    $("#btn-buscar-pasajeros").click(function (e) {
        e.preventDefault();

        /*var fecha_ini = $("#fecha_ini").val();
        var fecha_fin = $("#fecha_fin").val();
        var origen = $("#origen").val();*/
        listarVuelos();

    })
}

function  listarVuelos() {
    var fecha_ini = $("#fecha_ini").val();
    var fecha_fin = $("#fecha_fin").val();
    var origen = $("#origen").val();
    var urlJon = {
        'fecha_ini':fecha_ini,
        'fecha_fin':fecha_fin,
        'origen':origen
    };
    //console.log(urlJon);
    $.ajax({
        url: SERVER_NAME + 'Tuua_application/ta_listado_vuelos_kiu',
        type: 'post',
        data: urlJon,
        dataType: "json",
        success: function (response) {
            if (response.rpt == 1) {

                $("#table-listado-vuelos").html(response.html_vuelos);

                $('#tblvuelos').DataTable({
                    ordering: false,
                    searching: true,
                    lengthChange: true,
                    info: false,
                    pageLength: 10
                });

                /*reprocesar();
                eliminar();
                importar_pax();
                opendEdit();*/
                //$('#tblvuelos').ajax.reload(null, false);
               /*$('#tblvuelos').on( 'page.dt', function () {
                    reprocesar();
                    eliminar();
                    importar_pax();
                    opendEdit();
                } );*/
            }else{
                modalError(response.msg_error);
            }
        }
    });
}

function reprocesar(id_file,embarque){
    /*$('.reprocesar').click(function (e) {
        var id_file = $(this).attr("id_file");
        var embarque = $(this).attr("embarque");
        e.preventDefault();*/
        swal({
            icon: 'warning',
            title: 'Reprocesar manifiesto',
            text: "Esta seguro que desea reprocesar el manifiesto : "+id_file,
            buttons: true,
            dangerMode: true
        }).then((willDelete) => {
            if (willDelete) {
                $.ajax({
                    url: SERVER_NAME + 'Tuua_application/AdpController',
                    type: 'post',
                    data : {flag:'Reprocesar',id_file:id_file,embarque:embarque},
                    dataType: "json",
                    success: function (response) {
                        if (response.rpt == 1) {

                            swal("manifiesto Procesado Correctamente", {
                                icon: "success"
                            });
                        }else{
                            modalError(response.msg_error);
                        }
                    }
                });
            }
        });
    //})
}


function eliminar(id_file,embarque){
    /*$('.eliminar').click(function (e) {
        var id_file = $(this).attr("id_file");
        var embarque = $(this).attr("embarque");
        e.preventDefault();*/
        swal({
            icon: 'warning',
            title: 'Eliminar manifiesto',
            text: "Esta seguro que desea eliminar el manifiesto : "+id_file,
            buttons: true,
            dangerMode: true
        }).then((willDelete) => {
            if (willDelete) {
                $.ajax({
                    url: SERVER_NAME + 'Tuua_application/AdpController',
                    type: 'post',
                    data : {flag:'EliminarManifiesto',idFileTuua:id_file,embarque:embarque},
                    dataType: "json",
                    success: function (response) {
                        if (response.rpt == 1) {
                            swal("Manifiesto eliminado Correctamente", {
                                icon: "success"
                            }).then((willDelete) => {
                                if (willDelete) {
                                    listarVuelos();
                                }
                            });

                        }else{
                            modalError(response.msg_error);
                        }
                    }
                });
            }
        });
    //})
}
function importar_pax(id_file,embarque,fecha_vuelo,nroVuelo){
   /* $('.importar_pax').click(function (e) {
        var id_file = $(this).attr("id_file");
        var embarque = $(this).attr("embarque");
        var fecha_vuelo = $(this).attr("fecha");
        var nroVuelo = $(this).attr("nroVuelo");
        e.preventDefault();*/
        swal({
            icon: 'warning',
            title: 'Importar Pasajeros',
            text: "Esta seguro que desea importar los pasajeros del vuelo: "+nroVuelo,
            buttons: true,
            dangerMode: true
        }).then((willDelete) => {
            if (willDelete) {
                $.ajax({
                    url: SERVER_NAME + 'Tuua_application/AdpController',
                    type: 'post',
                    data : {flag:'ImportarPax',idFileTuua:id_file,aeroEmbarque:embarque,Fecha:fecha_vuelo,nroVuelo},
                    dataType: "json",
                    success: function (response) {
                        if (response.rpt == 1) {

                            swal("Pasajeros Importado Correctamente", {
                                icon: "success"
                            }).then((willDelete) => {
                                if (willDelete) {
                                    listarVuelos();
                                }
                            });
                        }else{
                            modalError(response.msg_error);
                        }
                    }
                });
            }
        });
    //})
}
function UpdateManifiesto(id_file){
    $("#btnEditManifiesto").click(function () {
        fecha_vuelo=$("#fecha_vuelo").val();
        nro_vuelo=$("#nro_vuelo").val();
        origen=$("#origen_mani").val();
        hora_despegue=$("#hora_despegue").val();
        hora_cierra_despegue=$("#hora_cierra_despegue").val();
        hora_llegada_destino=$("#hora_llegada_destino").val();
        matricula_avion=$("#matricula_avion").val();


        validFormManifiesto(fecha_vuelo,nro_vuelo,origen,hora_despegue,hora_cierra_despegue,hora_llegada_destino,matricula_avion)

        $.ajax({
            type : "POST",
            url : SERVER_NAME + 'Tuua_application/AdpController',
            data : "flag=ActualizarManifiesto&fecha_vuelo="+fecha_vuelo+"&nro_vuelo="+nro_vuelo+"&origen="+origen+"&hora_despegue="+hora_despegue+"&hora_cierra_despegue="+hora_cierra_despegue+"&hora_llegada_destino="+hora_llegada_destino+"&matricula_avion="+matricula_avion+"&idFileTuua="+id_file,
            dataType: "json",
            success:function(response){


                if (response.rpt == 1) {
                    swal("Manifiesto actualizado Correctamente", {
                        icon: "success"
                    }).then((willDelete) => {
                        if (willDelete) {
                            $("#fecha_vuelo").val("");
                            $("#nro_vuelo").val("");
                            $("#origen_mani").val("");
                            $("#hora_despegue").val("");
                            $("#hora_cierra_despegue").val("");
                            $("#hora_llegada_destino").val("");
                            $("#matricula_avion").val("");
                            $('#dinamicModal').modal('hide');
                            listarVuelos();
                        }
                    });
                }else{
                    modalError(response.msg_error);
                }

            }
        });

    })



}



