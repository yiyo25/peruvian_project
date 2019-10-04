$(document).ready(function () {

    openCreatePasajeros();
    ModificarPasajero();
    eliminarPasajero();
    $('#tblpasajeros').DataTable({
        ordering: false,
        searching: true,
        lengthChange: true,
        info: false,
        pageLength: 20
    });
    $('#tblpasajeros').on( 'page.dt', function () {
        ModificarPasajero();
        eliminarPasajero();
    } );
});

function openCreatePasajeros() {

    $("#btn-add-pax").click(function (e) {
        e.preventDefault();
        $.ajax({
            url: SERVER_NAME + 'Tuua_application/createPasajero',
            type: 'post',
            success: function (response) {
                $("#title_modal").text("Crear Pasajero");
                $('#body_dinamicac_modal').html(response);

                $('#dinamicModal').modal('show');
                storePasajero();
            }
        });
    });
}

function storePasajero(){
    $("#btnSavePasajero").click(function (e) {
        e.preventDefault();
        validaDataPasajero();
    })
}

function validaDataPasajero(){
    var nroTicket = $("#nroTicket").val();
    var apellido = $("#Apellido").val();
    var nombre = $("#Nombre").val();
    var pax = $("#Pax").val();
    var foid = $("#Foid").val();
    var destino = $("#Destino").val();
    var clase = $("#Clase").val();
    var cupon = $("#Cupon").val();
    var ref = $("#Ref").val();
    var asiento = $("#Asiento").val();
    var nroDoc = $("#NroDoc").val();
    var nac = $("#Nac").val();
    var id_file = $("#id_fileTuua").val();
    if ( /^[0-9]{13}$/.test(nroTicket)) {
    }else{
        modalError("Nro Ticket => Solo 13 numeros");
        $( "#nroTicket" ).focus();return false;
    }

    if ( /[A-Za-z ]$/.test(apellido.toUpperCase())) {
        /*if(apellido==""){
            modalError("Apellidos => Campo no puede ser vacio"); $( "#Apellido" ).focus();return false;
        }*/
    }else{ modalError("Apellidos => Solo letras"); $( "#Apellido" ).focus();return false;}

    if ( /[A-Za-z ]$/.test(nombre.toUpperCase()) ) {
        /*if(nombre==""){
            modalError("Nombre => Campo no puede ser vacio"); $( "#Apellido" ).focus();return false;
        }*/
    }else{ modalError("Nombre => Solo letras"); $( "#Nombre" ).focus();return false;}

    if ( /^[A,C,I]{1}$/.test(pax.toUpperCase()) ) {
    }else{ modalError("Pax => Solo 1 letra A C I"); $( "#Pax" ).focus();return false;}

    if ( /^(PP|CN|NI|DL|ID)[0-9A-Z ]{4,20}$/.test(foid.toUpperCase()) ) {
    }else{ modalError("Foid => Solo 2 letras al inicio (PP CN NI DL ID) mas caracteres"); $( "#Foid" ).focus();return false;}

    if ( /^[AQP,CUZ,IQT,LIM,PIU,TCQ,PCL,TPP,LPB]{3}$/.test(destino.toUpperCase()) ) {
    }else{ modalError("El origen no es correcto (AQP CUZ IQT LIM PIU TCQ PCL TPP LPB)"); $( "#Destino" ).focus(); return false;}

    if ( /^[A-Z]{1}$/.test(clase.toUpperCase()) ) {
    }else{ modalError("El campo Clase solo permite 1 letras"); $( "#Clase" ).focus();return false;}

    if ( /^[1-2]{1}$/.test(cupon) ) {
    }else{ modalError("Cupon => Solo 1 o 2"); $( "#Cupon" ).focus();return false;}

    if ( /^[0-9]{3}$/.test(ref) ) {
    }else{ modalError("El campo Ref solo permite 3 digitos"); $( "#Ref" ).focus();return false;}

    if ( /^[0-9]{1,3}[A-Z]{1}$/.test(asiento.toUpperCase()) ) {
    }else{ modalError("El campo Asiento solo permite 4 caracteres"); $( "#Asiento" ).focus();return false;}
    var dataJson = {
            nroTicketPax:nroTicket,
            apellidoPax:apellido,
            nombrePax:nombre,
            tipoPax:pax,
            foidPax:foid,
            destinoPax:destino,
            clasePax:clase,
            nroCuponPax:cupon,
            nroReferencia:ref,
            nroAsientoPax:asiento,
            nroDoc:nroDoc,
            nacPax:nac,
            idFileTuua:id_file
        };

    $.ajax({
        type : "POST",
        url : SERVER_NAME + 'Tuua_application/storePasajero',
        data : dataJson,
        dataType: "json",
        success:function(response){

            if (response.rpt == 1) {
                swal("Pasajero creado Correctamente", {
                    icon: "success"
                }).then((willDelete) => {
                    if (willDelete) {
                        document.location.reload();
                    }
                });

            }else{
                modalError(response.msg_error);
            }
        }
    });
}



function ModificarPasajero(){
    $(".modificar-pasajero").click(function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();

        var idItensPax = $(this).attr("idItensPax");
        $.ajax({
            url: SERVER_NAME + 'Tuua_application/editPasajero',
            type: 'post',
            data:{idItensPax:idItensPax},
            dataType: "json",
            success: function (response) {
                $("#title_modal").text("Actualizar Pasajero");
                $('#body_dinamicac_modal').html(response.html_form);
                $("#nroTicket").val(response.data[0]["nroTicketPax"]);
                $("#Apellido").val(response.data[0]["apellidoPax"]);
                $("#Nombre").val(response.data[0]["nombrePax"]);
                $("#Pax").val(response.data[0]["tipoPax"]);
                $("#Foid").val(response.data[0]["foidPax"]);
                $("#Destino").val(response.data[0]["destinoPax"]);
                $("#Clase").val(response.data[0]["clasePax"]);
                $("#Cupon").val(response.data[0]["nroCuponPax"]);
                $("#Ref").val(response.data[0]["nroReferencia"]);
                $("#Asiento").val(response.data[0]["nroAsientoPax"]);
                $("#NroDoc").val(response.data[0]["nroDoc"]);
                $("#Nac").val(response.data[0]["nacPax"]);
                $('#dinamicModal').modal('show');
                UpdatePasajero(idItensPax);
            }
        });
    })
}

function UpdatePasajero(idItensPax){
    $("#btnEditPasajero").click(function (e) {
        e.preventDefault();
        validEditPasajero(idItensPax);
    })
}

function validEditPasajero(idItensPax){
    var nroTicket = $("#nroTicket").val();
    var apellido = $("#Apellido").val();
    var nombre = $("#Nombre").val();
    var pax = $("#Pax").val();
    var foid = $("#Foid").val();
    var destino = $("#Destino").val();
    var clase = $("#Clase").val();
    var cupon = $("#Cupon").val();
    var ref = $("#Ref").val();
    var asiento = $("#Asiento").val();
    var nroDoc = $("#NroDoc").val();
    var nac = $("#Nac").val();
    var id_file = $("#id_fileTuua").val();

    if ( /^[0-9]{13}$/.test(nroTicket)) {
    }else{
        modalError("Nro Ticket => Solo 13 numeros");
        $( "#nroTicket" ).focus();return false;
    }

    if ( /[A-Za-z ]$/ .test(apellido.toUpperCase())) {
    }else{ modalError("Apellidos => Solo letras"); $( "#Apellido" ).focus();return false;}

    if ( /[A-Za-z ]$/.test(nombre.toUpperCase()) ) {

    }else{ modalError("Nombre => Solo letras"); $( "#Nombre" ).focus();return false;}

    if ( /^[A,C,I]{1}$/.test(pax.toUpperCase()) ) {
    }else{ modalError("Pax => Solo 1 letra A C I"); $( "#Pax" ).focus();return false;}

    if ( /^(PP|CN|NI|DL|ID)[0-9A-Z ]{4,20}$/.test(foid.toUpperCase()) ) {
    }else{ modalError("Foid => Solo 2 letras al inicio (PP CN NI DL ID) mas caracteres"); $( "#Foid" ).focus();return false;}

    if ( /^[AQP,CUZ,IQT,LIM,PIU,TCQ,PCL,TPP,LPB]{3}$/.test(destino.toUpperCase()) ) {
    }else{ modalError("El origen no es correcto (AQP CUZ IQT LIM PIU TCQ PCL TPP LPB)"); $( "#Destino" ).focus(); return false;}

    if ( /^[A-Z]{1}$/.test(clase) ) {
    }else{ modalError("El campo Clase solo permite 1 letras"); $( "#Clase" ).focus();return false;}

    if ( /^[1-2]{1}$/.test(cupon) ) {
    }else{ modalError("Cupon => Solo 1 o 2"); $( "#Cupon" ).focus();return false;}

    if ( /^[0-9]{3}$/.test(ref) ) {
    }else{ modalError("El campo Ref solo permite 3 digitos"); $( "#Ref" ).focus();return false;}

    if ( /^[0-9]{1,3}[A-Z]{1}$/.test(asiento) ) {
    }else{ modalError("El campo Asiento solo permite 4 caracteres"); $( "#Asiento" ).focus();return false;}
    var dataJson = {
        nroTicketPax:nroTicket,
        apellidoPax:apellido,
        nombrePax:nombre,
        tipoPax:pax,
        foidPax:foid,
        destinoPax:destino,
        clasePax:clase,
        nroCuponPax:cupon,
        nroReferencia:ref,
        nroAsientoPax:asiento,
        nroDoc:nroDoc,
        nacPax:nac,
        idFileTuua:id_file,
        idItensPax:idItensPax
    };

    $.ajax({
        type : "POST",
        url : SERVER_NAME + 'Tuua_application/ModificarPasajero',
        data : dataJson,
        dataType: "json",
        success:function(response){

            if (response.rpt == 1) {
                swal("Pasajero Actualizado Correctamente", {
                    icon: "success"
                }).then((willDelete) => {
                    if (willDelete) {
                        document.location.reload();
                    }
                });

            }else{
                modalError(response.msg_error);
            }
        }
    });
}

function eliminarPasajero(){
    $(".eliminar-pasajero").click(function (e) {
        e.preventDefault();
        var idItensPax = $(this).attr("idItensPax");
        var name_pax = $(this).attr("name_pax");
        swal({
            icon: 'warning',
            title: 'Eliminar Pasajero',
            text: "Esta seguro que desea eliminar al pasajero : "+name_pax,
            buttons: true,
            dangerMode: true
        }).then((willDelete) => {
            if (willDelete) {

                $.ajax({
                    url: SERVER_NAME + 'Tuua_application/EliminarPasajero',
                    type: 'post',
                    data:{idItensPax:idItensPax},
                    dataType: "json",
                    success: function (response) {
                        if (response.rpt == 1) {
                            swal("Pasajero Eliminado Correctamente", {
                                icon: "success"
                            }).then((willDelete) => {
                                if (willDelete) {
                                    document.location.reload();
                                }
                            });

                        }else{
                            modalError(response.msg_error);
                        }
                    }
                });
            }
        });
    })
}

