
$(document).ready(function () {
    $('#datetimepicker3').datetimepicker({
        format: 'YYYY-MM-DD'
    });
    incidenciaVueloModal();
    /*$('#tblvuelos').DataTable({
        ordering: false,
        searching: false,
        lengthChange: false,
        info: false,
        pageLength: 50
    });
    */
    
    //var fecha_Actual = moment().format('YYYY-MM-DD');
    //$("#fecha").val(fecha_Actual);

    $(".select2").select2({
        placeholder: 'Seleccione una opcion'
    });

    $(".select-multiple").select2({
        multiple: true,
        maximumSelectionLength: 3
    });


    $(".select-multiple").on("select2:select", function (evt) {
        var element = evt.params.data.element;
        var $element = $(element);
        $element.detach();
        $(this).append($element);
        $(this).trigger("change");

    });


    $("#btngenerar").click(function () {
        if (validaForm()) {
            var ruta = $("#ruta").val();
            var fecha = $("#fecha").val();
            var hora = $("#hora_vuelo").val();
            var tipo = $("#tipovuelo").val();
            var nro_vuelo = $("#nro_vuelo").val();
            ajaxGenerarVuelo(ruta, fecha, hora, tipo, nro_vuelo);
        }
    });

    $("#btn_save").click(function () {
        
        if (validaForm()) {
            swal({
                icon: 'warning',
                title: 'Registrar Vuelo',
                text: "Esta seguro de registrar el vuelo",
                buttons: true,
                dangerMode: true
            }).then((willDelete) => {
                if (willDelete) {
                    var ruta = $("#ruta").val();
                    var fecha = $("#fecha").val();
                    var hora = $("#hora_vuelo").val();
                    var tipo = $("#tipovuelo").val();
                    var nro_vuelo = $("#nro_vuelo").val();
                    var tipo_op = $("#tipo_op").val();
                    var matricula = $("#matricula").val();
                    ajaxGuardarVuelo(ruta, fecha, hora, tipo, nro_vuelo, tipo_op, matricula);
               }
            });
        }
    });

    $("#nro_vuelo").keypress(function (e) {
        soloNumeros(e);
    });

    $('#ModalCreateFlight').on('hidden.bs.modal', function (e) {

        $("#nro_vuelo").val('');
        $("#hora_vuelo").val('');
        $("#table_resul").html('');
        $('.select-multiple').val(null).trigger('change');
        $('.select2').val(null).trigger('change');
    });
    cierre_vuelo();
});



function incidenciaVueloModal(){
    $('.incidenciaVuelo_modal').click(function (e) {
        e.preventDefault();
        var id_vuelo_detalle = $(this).attr('data-id-detalle');
        var id_vuelo_cabecera = $(this).attr('data-vuelo-cabecera');
        var fecha_vuelo = $(this).attr('data-fecha-vuelo');
        var matricula = $(this).attr('data-matricula');
        var nro_vuelo = $(this).attr("data-nro-vuelo");
        var ruta = $(this).attr('data-ruta');
        var urlJson = {
            id_vuelo_detalle: id_vuelo_detalle,
            id_vuelo_cabecera: id_vuelo_cabecera,
            fecha_vuelo: fecha_vuelo,
            matricula: matricula,
            nro_vuelo: nro_vuelo,
            ruta: ruta
        };
        $.ajax({
            url: SERVER_NAME + 'index/incidencias',
            type: 'post',
            data: urlJson,
            dataType: "json",
            success: function (response) {
                if (response.rpt == 1) {
                    $("#title_modal").text("Cierre Vuelo");
                    $('#body_dinamicac_modal').html(response.html_incidencia);
                    $("#table_incidencias").html(response.html_vuelo_incidencia);
                    $('#dinamicModal .select2').each(function () {
                        var container = $(this).parent();
                        $(this).select2({
                            dropdownParent: container
                        });
                    });
                    $('#dinamicModal').modal('show');
                    saveIncidencia();
                    deleteVueloIncidencia();
                }
            }
        });
    });
}

function saveIncidencia(){
    $("#btnSaveIncidencia").click(function(e){
        e.preventDefault();
        e.stopImmediatePropagation();
        var id_incidencia=$("#cbo_incidencia").val(); 
        var observacion=$("#txt_observacion").val(); 

        var id_vuelo_detalle = $("#id_vuelo_detalle").val();
        var urlJson = {
            id_vuelo_detalle    : id_vuelo_detalle,
            id_incidencia       : id_incidencia,
            observacion         : observacion
        };
        
        if(id_incidencia>=0){
            swal({
                icon: 'warning',
                title: 'Registrar Incidencia',
                text: "Esta seguro de registrar la incidencia",
                buttons: true,
                dangerMode: true
            }).then((willDelete) => {
                if (willDelete) {
                    $.ajax({
                        url: SERVER_NAME + 'index/saveIncidencia',
                        type: 'post',
                        data: urlJson,
                        dataType: "json",
                        success: function (response) {
                            if (response.rpt == 1) {
                                $('.select2').val(-1).trigger('change');
                                $("#txt_observacion").val('');
                                $("#txt_observacion").text('');
                                $("#table_incidencias").html(response.html_vuelo_incidencia);
                                deleteVueloIncidencia();
                                swal("Incidencia Guardado Correctamente", {
                                    icon: "success"
                                });
                            }else{
                                modalError(response.msg_error);
                            }
                        }
                    });
                }
            });
        }else{
            modalError("Debe selecciona una opcion");
        }
    });
}

function deleteVueloIncidencia(){
    $(".deleteVueloIncidencias").click(function(e){
        e.preventDefault();
        e.stopImmediatePropagation();
        swal({
            icon: 'warning',
            title: 'Eliminar Incidencia',
            text: "Esta seguro de eliminar la incidencia",
            buttons: true,
            dangerMode: true
        }).then((willDelete) => {
            if (willDelete) {
                var id_vuelo_incidencia = $(this).attr('data-id');
                var id_vuelo_detalle = $(this).attr('data-id-vuelo-detalle');
                $.ajax({
                    data: {id_vuelo_incidencia:id_vuelo_incidencia,id_vuelo_detalle : id_vuelo_detalle},
                    url: SERVER_NAME + 'index/deleteVueloIncidencia',
                    type: 'post',
                    dataType: "json",
                    success: function (response) {
                        if(response.rpt == 1){
                            $("#table_incidencias").html(response.html_vuelo_incidencias);
                            deleteVueloIncidencia();
                        }else{
                            modalError(response.msg_error);
                        }
                    }
                });
            }
        });
    });
    
}


function ajaxGenerarVuelo(ruta, fecha, hora, tipo, nro_vuelo) {
    var urlData = "ruta=" + ruta + "&fecha=" + fecha + "&tipo=" + tipo + "&nro_vuelo=" + nro_vuelo + "&hora_ini=" + hora;
    $.ajax({
        data: urlData,
        url: SERVER_NAME + 'ajax/showDataFlight',
        type: 'post',
        dataType: "json",
        beforeSend: function () {
            $("#table_resul").html("<img src='" + SERVER_PUBLIC + "img/ajax-loader.gif' /><strong>Procesando...</strong>");
        },
        success: function (response) {
            if(response.rpt==1){
                $("#table_resul").html(response.html_vuelo);
            }else{
                $("#table_resul").html("");
                modalError(response.error_msg);
            }            
        }
    });
}

function ajaxGuardarVuelo(ruta_vuelo, fecha_vuelo, hora_ini, tipo_vuelo, nro_vuelo, tipo_op, matricula) {
    var jsonData = {
        ruta: ruta_vuelo,
        fecha: fecha_vuelo,
        hora: hora_ini,
        tipo: tipo_vuelo,
        nroVuelo: nro_vuelo,
        tipoOperacion: tipo_op,
        matricula: matricula
    };
    $.ajax({
        type: 'POST',
        data: jsonData,
        url: SERVER_NAME + 'ajax/guardarVuelo',
        dataType: "JSON",
        success: function (response) {
            if (response.rpt == 1) {
                $('#ModalCreateFlight').modal('hide');
                $("#table_resul").html('');
                swal("Vuelo Creado Correctamente", {
                    icon: "success"
                }).then((willDelete) => {
                    if (willDelete) {
                       location.reload(); 
                    }else{
                        $("#nro_vuelo").val("");
                        $("#ruta").val("");
                        $("#ruta").text("");
                        $("#hora_vuelo").val();
                        location.reload(); 
                    }
                });
            } else {
                modalError(response.error_msg);
            }
        }
    });
}

function validaForm() {

    if ($("#nro_vuelo").val() == "") {
        $("#nro_vuelo").focus();
        alert("El campo Nro. vuelo no puede estar vacío.");

        return false;
    }
    if ($("#hora_vuelo").val() == "") {
        alert("El campo hora no puede estar vacío.");
        $("#hora_vuelo").focus();
        return false;
    }
    /*if ($("#ruta").val() == "") {
        alert("El campo ruta no puede estar vacío.");
        $("#ruta").focus();
        return false;
    }else{
        var ruta = $("#ruta").val();
        var cant_ruta = Object.keys(ruta).length;
        if(cant_ruta===1){
            alert("Ingrese un ruta correcta");
            $("#ruta").focus();
            return false;
        }
    }*/
   /* if ($("#ruta").text() == "") {
        alert("El campo ruta no puede estar vacío.");
        $("#ruta").focus();
        return false;
    }else{
        var ruta = $("#ruta").val();
        var cant_ruta = Object.keys(ruta).length;
        if(cant_ruta===1){
            alert("Ingrese un ruta correcta");
            $("#ruta").focus();
            return false;
        }
    }*/
    if ($("#ruta").val() === null) {
        alert("El campo ruta no puede estar vacío.");
        $("#ruta").focus();
        return false;
    }else{
        var ruta = $("#ruta").val();
        var cant_ruta = Object.keys(ruta).length;
        if(cant_ruta===1){
            alert("Ingrese un ruta correcta");
            $("#ruta").focus();
            return false;
        }
    }
    return true; // Si todo está correcto
}


function cierre_vuelo(){
    $("#cierre_vuelo").click(function(e){
        e.preventDefault();
        var urlJson = {fecha_cierre:$("#fecha_vuelo_dia").val()};
        $.ajax({
            url: SERVER_NAME + 'Cierrevuelo',
            type: 'post',
            data: urlJson,
            dataType: "json",
            success: function (response) {
                if(response.rpt===1){
                    $("#title_modal").text("Cierre Vuelo");
                    $('#body_dinamicac_modal').html(response.html_cierre_vuelo);
                    $('#dinamicModal').modal('show');
                    if($("#dialogM").hasClass("modal-xl")){
                        $("#dialogM").removeClass("modal-xl");
                        $("#dialogM").addClass("modal-lg");
                    }
                }
                if(response.rpt === 2){
                    cerrarVuelo(response.msg_error);
                }
                if(response.rpt === 3){
                    
                    messageVueloCerrado(response.msg_error);
                }
                if(response.rpt === 0){
                    modalError(response.msg_error);
                }
            }
        });
    });
}

function cerrarVuelo(texto){
    var urlJson = {fecha_cierre:$("#fecha_vuelo_dia").val()};
    swal({
        icon: 'warning',
        title:  "Está seguro de cerrer el vuelo",
        text: texto,
        buttons: true,
        dangerMode: true
    }).then((willDelete) => {
        if (willDelete) {
            $.ajax({
                url: SERVER_NAME + 'cierrevuelo/procesarCierreVueloDia',
                type: 'post',
                data: urlJson,
                dataType: "json",
                success: function (response) {
                    if (response.rpt == 1) {
                        $('#dinamicModal').modal('hide');
                        swal("Vuelo Cerrado Correctamente", {
                            icon: "success"
                        }).then((willDelete) => {
                            if (willDelete) {
                               location.reload(); 
                            }
                        });
                    }else {
                        modalError(response.msg);
                    }
                }
            });
        }
    });
}

function messageVueloCerrado(texto){
    swal(texto, {
        icon: "success"
    });
}