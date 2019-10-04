/*--------------------------------- Para Avión ---------------------------------*/
function insertAvion(url){
    //avion/insertAvion/";
    $("#preloader").css("display","block");
    
    if(validate_formAvion()) {
        var parametros = {
            "TIPAVI_id" : $("#TIPAVI_id").val(),
            "AVI_num_cola" : $("#AVI_num_cola").val(),
            "AVI_cant_pasajeros" : $("#AVI_cant_pasajeros").val(),
            "AVI_cap_carga_max" : $("#AVI_cap_carga_max").val(),
            "AVI_estado" : $("#AVI_estado").val()
        };
        $.post(url,parametros,
        function(data){
            var AVI_num_cola = data[0]["AVI_num_cola"];            
            
            if(AVI_num_cola != undefined){
                alert('El Número de Cola: ' + AVI_num_cola + ' ya se encuentra registrado.');
                $("#preloader").css("display","none");
            } else {
                limpiarFormAvion();
                $("#preloader").css("display", "none");
                alert("Se ha registrado correctamente el Avión.");
                $('#avionRegistro').modal('hide');
                location.reload(true);
            }
        });
    } else{
        $("#preloader").css("display","none");
    }
}

function updateAvion(url){
    //avion/updateAvion/";
    $("#preloader").css("display","block");

    if(validate_formAvion()) {
        var parametros = {
            "AVI_id" : $("#AVI_id").val(),
            "TIPAVI_id" : $("#TIPAVI_id").val(),
            "AVI_num_cola" : $("#AVI_num_cola").val(),
            "AVI_cant_pasajeros" : $("#AVI_cant_pasajeros").val(),
            "AVI_cap_carga_max" : $("#AVI_cap_carga_max").val(),
            "AVI_estado" : $("#AVI_estado").val()
        };
        $.post(url,parametros,
        function(data){
            if(data == ""){
                alert("Hubo un error en la modificación de la Información.");
            } else {
                limpiarFormAvion();
                $("#preloader").css("display", "none");
                alert("Se ha modificado correctamente el Avión.");
            }
            $('#avionRegistro').modal('hide');
            location.reload(true);
        });
    } else{
        $("#preloader").css("display","none");
    }
}

function listarDetAvion(url,AVI_id,accion){
    $("#preloader").css("display","block");

    var parametros = {
        "AVI_id" : AVI_id
    };
    $.post(url,parametros,
    function(data){
        if(data == ""){
            alert("Hubo un error al cargar la información.");
        } else {
            $("#titleForm").text("Detalle de avión");
            $("#AVI_id").val(data[0]["AVI_id"]);
            $("#TIPAVI_id").val(data[0]["TIPAVI_id"]).trigger('change.select2');
            $("#AVI_num_cola").val(data[0]["AVI_num_cola"]);
            $("#AVI_cant_pasajeros").val(data[0]["AVI_cant_pasajeros"]);
            $("#AVI_cap_carga_max").val(data[0]["AVI_cap_carga_max"]);
            $("#AVI_estado").val(data[0]["AVI_estado"]).trigger('change.select2');
            $("#AUD_usu_cre").val(data[0]["AUD_usu_cre"]);
            $("#AUD_fch_cre").val(data[0]["AUD_fch_cre"]);
            $("#AUD_usu_mod").val(data[0]["AUD_usu_mod"]);
            $("#AUD_fch_mod").val(data[0]["AUD_fch_mod"]);
            if(accion == "listar"){
                verFormAvion();
            } else {
                $("#insertAvion").hide();
                $("#updateAvion").show();
            }
            $("#preloader").css("display", "none");
        }
    });
}

$('#avionRegistro').on('show.bs.modal', function (e) {
    $("#updateAvion").hide();
})
$('#avionRegistro').on('hidden.bs.modal', function (e) {
    limpiarFormAvion();
})

function resetFormAvion(url){
    window.location.href = url;
}

/*--------------------------------- Para Manto de Avión ---------------------------------*/
function insertMantoAvion(url){
    //avion/insertMantoAvion/";
    $("#preloader").css("display","block");

    if(validate_formMantoAvion()) {
        var parametros = {
            "AVI_id" : $("#AVI_id").val(),
            "MANTAVI_fchini" : $("#MANTAVI_fchini").val(),
            "MANTAVI_fchfin" : $("#MANTAVI_fchfin").val(),
            "MANTAVI_tipoChequeo" : $("#MANTAVI_tipoChequeo").val(),
            "MANTAVI_ordenTrabajo" : $("#MANTAVI_ordenTrabajo").val(),
            "MANTAVI_observacion" : $("#MANTAVI_observacion").val()
        };
        $.post(url,parametros,
        function(data){
            var MANTAVI_fchini = data[0]["MANTAVI_fchini"];
            var MANTAVI_fchfin = data[0]["MANTAVI_fchfin"];
            var AVI_num_cola = data[0]["AVI_num_cola"];
            
            
            if(AVI_num_cola != undefined){
                alert('Conflicto de Fechas. El Avión ' + AVI_num_cola + ' ya se encuentra en mantenimiento del ' + MANTAVI_fchini + ' al ' + MANTAVI_fchfin);
                $("#preloader").css("display","none");
            } else {
                limpiarFormMantoAvion();
                $("#preloader").css("display", "none");
                alert("Se ha registrado correctamente el Manto del Avión.");
                $('#avionMantoRegistro').modal('hide');
                location.reload(true);                
            }
        });
    } else{
        $("#preloader").css("display","none");
    }
}

function updateMantoAvion(url){
    //avion/updateMantoAvion/";
    $("#preloader").css("display","block");

    if(validate_formMantoAvion()) {
        var parametros = {
            "MANTAVI_id" : $("#MANTAVI_id").val(),
            "AVI_id" : $("#AVI_id").val(),
            "MANTAVI_fchini" : $("#MANTAVI_fchini").val(),
            "MANTAVI_fchfin" : $("#MANTAVI_fchfin").val(),
            "MANTAVI_tipoChequeo" : $("#MANTAVI_tipoChequeo").val(),
            "MANTAVI_ordenTrabajo" : $("#MANTAVI_ordenTrabajo").val(),
            "MANTAVI_observacion" : $("#MANTAVI_observacion").val()
        };
        $.post(url,parametros,
        function(data){
            if(data == ""){
                alert("Hubo un error en la modificación de la Información.");
            } else {
                var table = $('#listaDetMantoAvion').DataTable();
                table.destroy();
                listarMantoAvion($("#MANTAVI_fchiniMes").val(),$("#MANTAVI_fchiniAnio").val(),$("#MANTAVI_fchfinMes").val(),$("#MANTAVI_fchfinAnio").val());
                limpiarFormMantoAvion();
                $("#preloader").css("display", "none");
                alert("Se ha modificado correctamente el Manto Avión.");
            }
            $('#avionMantoRegistro').modal('hide');
        });
    } else{
        $("#preloader").css("display","none");
    }
}

function listarDetMantoAvion(url,MANTAVI_id,accion){
    //avion/listarMantoAvion/";
    $("#preloader").css("display","block");

    var parametros = {
        "MANTAVI_id" : MANTAVI_id
    };
    $.post(url,parametros,
    function(data){
        if(data == ""){
            alert("Hubo un error al cargar la información.");
        } else {
            $("#titleForm").text("Detalle de Manto de Avión");

            $("#MANTAVI_id").val(data[0]["MANTAVI_id"]);
            $("#TIPAVI_id").val(data[0]["TIPAVI_id"]).trigger('change.select2');

            listarComboAvionView();
            setTimeout(function(){
                $("#AVI_id").chained("#TIPAVI_id");
                $("#AVI_id").val(data[0]["AVI_id"]).trigger('change.select2');
                if(accion == "listar"){
                    $("#AVI_id").prop("disabled","disabled");
                }
            },1000);
            $("#MANTAVI_fchini").val(data[0]["MANTAVI_fchini"]);
            $("#MANTAVI_fchfin").val(data[0]["MANTAVI_fchfin"]);
            $("#MANTAVI_tipoChequeo").val(data[0]["MANTAVI_tipoChequeo"]);
            $("#MANTAVI_ordenTrabajo").val(data[0]["MANTAVI_ordenTrabajo"]);
            $("#MANTAVI_observacion").val(data[0]["MANTAVI_observacion"]);

            $("#AUD_usu_cre").val(data[0]["AUD_usu_cre"]);
            $("#AUD_fch_cre").val(data[0]["AUD_fch_cre"]);
            $("#AUD_usu_mod").val(data[0]["AUD_usu_mod"]);
            $("#AUD_fch_mod").val(data[0]["AUD_fch_mod"]);
            if(accion == "listar"){
                verFormMantoAvion();
            } else {
                $("#insertMantoAvion").hide();
                $("#updateMantoAvion").show();
            }
            $("#preloader").css("display", "none");
            $(document).ready(function() { $(".js-example-basic-single").select2(); });
        }
    });
}

$("#MANTAVI_fchiniDate").on("dp.change", function (e) {
    var select = $("#MANTAVI_fchfinDate");
    var fchIni = $("#MANTAVI_fchini").val();
    validarFechaContinua(select,fchIni);
    $("#MANTAVI_fchfin").removeAttr("disabled");
    $("#MANTAVI_fchfin").css("background", "#FFFFFF");
});
$('#avionMantoRegistro').on('show.bs.modal', function (e) {
    $("#updateMantoAvion").hide();
})
$('#avionMantoRegistro').on('hidden.bs.modal', function (e) {
    limpiarFormMantoAvion();
})
$('#avionMantoDetalle').on('show.bs.modal', function (e) {
    $("#avionMantoDetalle").css('z-index','1045');
    $("#avionMantoRegistro").css('z-index','1055');
})
$('#avionMantoDetalle').on('hidden.bs.modal', function (e) {
    var table = $('#listaDetMantoAvion').DataTable();
    table.destroy();
    location.reload(true);
})

function resetFormMantoAvion(url){
    window.location.href = url;
}

/*--------------------------------- Para Tripulante de Vuelo ---------------------------------*/
function insertTripVuelo(url){
    //tripulante/insertTripulante/";
    $("#preloader").css("display","block");

    if(validate_formTripulante('Vuelo')) {
        var parametros = {
            "TRIP_nombre" : $("#TRIP_nombre").val(),
            "TRIP_apellido" : $("#TRIP_apellido").val(),
            "TRIP_correo" : $("#TRIP_correo").val(),
            "TRIP_fechnac" : $("#TRIP_fechnac").val(),
            "idDepa" : $("#idDepa").val(),
            "idProv" : $("#idProv").val(),
            "idDist" : $("#idDist").val(),
            "TRIP_domilicio" : $("#TRIP_domilicio").val(),
            "TIPTRIPDET_id" : $("#TIPTRIPDET_id").val(),
            "TIPLIC_id" : $("#TIPLIC_id").val(),
            "TRIP_numlicencia" : $("#TRIP_numlicencia").val(),
            "TRIP_DGAC" : $("#TRIP_DGAC").val(),
            "NIVING_id" : $("#NIVING_id").val(),
            "CAT_id" : $("#CAT_id").val(),
            "TRIP_estado": $("#TRIP_estado").val()
        };
        
        if($("#TRIP_instructor_Si").is(':checked')){
            parametros["TRIP_instructor"] = $("#TRIP_instructor_Si").val();
        } else {
            parametros["TRIP_instructor"] = $("#TRIP_instructor_No").val();
        }
        
        $.post(url,parametros,
        function(data){
            var TRIP_nombre = data[0]["TRIP_nombre"];
            var TRIP_apellido = data[0]["TRIP_apellido"];
            var TRIP_numlicencia = data[0]["TRIP_numlicencia"];            
            
            if(TRIP_numlicencia != undefined){
                alert('La Licencia N° ' + TRIP_numlicencia + ' ya se encuentra registrada a nombre de ' + TRIP_nombre + ' ' + TRIP_apellido);
                $("#preloader").css("display","none");
            } else {
                limpiarFormTripulante('Vuelo');
                $("#preloader").css("display", "none");
                alert("Se ha registrado correctamente el Tripulante de Vuelo.");
                $('#TripVueloRegistro').modal('hide');
                location.reload(true);               
            }
        });
    } else{
        $("#preloader").css("display","none");
    }
}

function updateTripVuelo(url){
    //tripulante/updateTripulante/";
    $("#preloader").css("display","block");

    if(validate_formTripulante('Vuelo')) {
        var parametros = {
            "TRIP_id" : $("#TRIP_id").val(),
            "TRIP_nombre" : $("#TRIP_nombre").val(),
            "TRIP_apellido" : $("#TRIP_apellido").val(),
            "TRIP_correo" : $("#TRIP_correo").val(),
            "TRIP_fechnac" : $("#TRIP_fechnac").val(),
            "idDepa" : $("#idDepa").val(),
            "idProv" : $("#idProv").val(),
            "idDist" : $("#idDist").val(),
            "TRIP_domilicio" : $("#TRIP_domilicio").val(),
            "TIPTRIPDET_id" : $("#TIPTRIPDET_id").val(),
            "TIPLIC_id" : $("#TIPLIC_id").val(),
            "TRIP_numlicencia" : $("#TRIP_numlicencia").val(),
            "TRIP_DGAC" : $("#TRIP_DGAC").val(),
            "NIVING_id" : $("#NIVING_id").val(),
            "CAT_id" : $("#CAT_id").val(),
            "TRIP_estado": $("#TRIP_estado").val()
        };
        
        if($("#TRIP_instructor_Si").is(':checked')){
            parametros["TRIP_instructor"] = $("#TRIP_instructor_Si").val();
        } else {
            parametros["TRIP_instructor"] = $("#TRIP_instructor_No").val();
        }
        
        $.post(url,parametros,
        function(data){
            if(data == ""){
                alert("La Licencia del Trip. registrado ya existe.");
            } else {
                limpiarFormTripulante('Vuelo');
                $("#preloader").css("display", "none");
                alert("Se ha modificado correctamente el Tripulante.");
            }
            $('#TripVueloRegistro').modal('hide');
            location.reload(true);
        });
    } else{
        $("#preloader").css("display","none");
    }
}

function listarDetTripVuelo(url,TRIP_id,accion){
    //tripulante/listarDetTrip/";
    $("#preloader").css("display","block");
    var parametros = {
            "TRIP_id" : TRIP_id
        };
    $.post(url,parametros,
    function(data){
        if(data == ""){
            alert("Hubo un error al cargar la información.");
        } else {
            $("#titleForm").text("Detalle de Trip. de Vuelo");+

            $("#TRIP_id").val(data[0]["TRIP_id"]);
            $("#TRIP_nombre").val(data[0]["TRIP_nombre"]);
            $("#TRIP_apellido").val(data[0]["TRIP_apellido"]);
            $("#TRIP_correo").val(data[0]["TRIP_correo"]);
            $("#TRIP_fechnac").val(data[0]["TRIP_fechnac"]);

            $("#idDepa").val(data[0]["idDepa"]).trigger('change.select2');
            listarComboProvinciaView();
            setTimeout(function(){
                $("#idProv").chained("#idDepa");
                $("#idProv").val(data[0]["idProv"]).trigger('change.select2');
                if(accion == "listar"){
                    $("#idProv").prop("disabled","disabled");
                }
                
                listarComboDistritoView();
                setTimeout(function(){
                    $("#idDist").val(data[0]["idDist"]).trigger('change.select2');
                    $("#idDist").chained("#idProv");
                    if(accion == "listar"){
                        $("#idDist").prop("disabled","disabled");
                    }
                },1000);
            },1000);

            $("#TRIP_domilicio").val(data[0]["TRIP_domilicio"]);
            $("#TIPTRIPDET_id").val(data[0]["TIPTRIPDET_id"]).trigger('change.select2');
            
            if(data[0]["TRIP_instructor"] == "Si"){
                $("#TRIP_instructor_Si").prop("checked", true);
                $("#TRIP_instructor_No").prop("checked", false);
            } else {
                $("#TRIP_instructor_Si").prop("checked", false);
                $("#TRIP_instructor_No").prop("checked", true);
            }
            
            $("#TIPLIC_id").val(data[0]["TIPLIC_id"]).trigger('change.select2');
            $("#TRIP_numlicencia").val(data[0]["TRIP_numlicencia"]);
            $("#TRIP_DGAC").val(data[0]["TRIP_DGAC"]);
            $("#NIVING_id").val(data[0]["NIVING_id"]).trigger('change.select2');
            $("#CAT_id").val(data[0]["CAT_id"]).trigger('change.select2');
            $("#TRIP_estado").val(data[0]["TRIP_estado"]).trigger('change.select2');

            $("#AUD_usu_cre").val(data[0]["AUD_usu_cre"]);
            $("#AUD_fch_cre").val(data[0]["AUD_fch_cre"]);
            $("#AUD_usu_mod").val(data[0]["AUD_usu_mod"]);
            $("#AUD_fch_mod").val(data[0]["AUD_fch_mod"]);
            if(accion == "listar"){
                verFormTripulante('Vuelo');
            } else {
                $("#insertTripulante").hide();
                $("#updateTripulante").show();
            }
            $("#preloader").css("display", "none");
        }
    });
}

$('#TripVueloRegistro').on('show.bs.modal', function (e) {
    $("#updateTripulante").hide();
})
$('#TripVueloRegistro').on('hidden.bs.modal', function (e) {
    limpiarFormTripulante('Vuelo');
})

function resetFormTripVuelo(url){
    window.location.href = url;
}

/*--------------------------------- Para Tripulante de Cabina ---------------------------------*/
function insertTripCabina(url){
    //tripulante/insertTripulante/";
    $("#preloader").css("display","block");

    if(validate_formTripulante('Cabina')) {
        var parametros = {
            "TRIP_nombre" : $("#TRIP_nombre").val(),
            "TRIP_apellido" : $("#TRIP_apellido").val(),
            "TRIP_correo" : $("#TRIP_correo").val(),
            "TRIP_fechnac" : $("#TRIP_fechnac").val(),
            "idDepa" : $("#idDepa").val(),
            "idProv" : $("#idProv").val(),
            "idDist" : $("#idDist").val(),
            "TRIP_domilicio" : $("#TRIP_domilicio").val(),
            "TIPTRIPDET_id" : $("#TIPTRIPDET_id").val(),
            "TIPLIC_id" : $("#TIPLIC_id").val(),
            "TRIP_numlicencia" : $("#TRIP_numlicencia").val(),
            "TRIP_DGAC" : $("#TRIP_DGAC").val(),
            "NIVING_id" : $("#NIVING_id").val(),
            "CAT_id" : $("#CAT_id").val(),
            "TRIP_estado": $("#TRIP_estado").val()
        };
        if($("#TRIP_instructor_Si").is(':checked')){
            parametros["TRIP_instructor"] = $("#TRIP_instructor_Si").val();
        } else {
            parametros["TRIP_instructor"] = $("#TRIP_instructor_No").val();
        }
        $.post(url,parametros,
        function(data){
            var TRIP_nombre = data[0]["TRIP_nombre"];
            var TRIP_apellido = data[0]["TRIP_apellido"];
            var TRIP_numlicencia = data[0]["TRIP_numlicencia"];            
            
            if(TRIP_numlicencia != undefined){
                alert('La Licencia N° ' + TRIP_numlicencia + ' ya se encuentra registrada a nombre de ' + TRIP_nombre + ' ' + TRIP_apellido);
                $("#preloader").css("display","none");
            } else {
                limpiarFormTripulante('Cabina');
                $("#preloader").css("display", "none");
                alert("Se ha registrado correctamente el Tripulante de Cabina.");
                $('#TripVueloRegistro').modal('hide');
                location.reload(true);               
            }
        });
    } else{
        $("#preloader").css("display","none");
    }
}

function updateTripCabina(url){
    //tripulante/updateTripulante/";
    $("#preloader").css("display","block");

    if(validate_formTripulante('Cabina')) {
        var parametros = {
            "TRIP_id" : $("#TRIP_id").val(),
            "TRIP_nombre" : $("#TRIP_nombre").val(),
            "TRIP_apellido" : $("#TRIP_apellido").val(),
            "TRIP_correo" : $("#TRIP_correo").val(),
            "TRIP_fechnac" : $("#TRIP_fechnac").val(),
            "idDepa" : $("#idDepa").val(),
            "idProv" : $("#idProv").val(),
            "idDist" : $("#idDist").val(),
            "TRIP_domilicio" : $("#TRIP_domilicio").val(),
            "TIPTRIPDET_id" : $("#TIPTRIPDET_id").val(),
            "TIPLIC_id" : $("#TIPLIC_id").val(),
            "TRIP_numlicencia" : $("#TRIP_numlicencia").val(),
            "TRIP_DGAC" : $("#TRIP_DGAC").val(),
            "NIVING_id" : $("#NIVING_id").val(),
            "CAT_id" : $("#CAT_id").val(),
            "TRIP_estado": $("#TRIP_estado").val()
        };
        if($("#TRIP_instructor_Si").is(':checked')){
            parametros["TRIP_instructor"] = $("#TRIP_instructor_Si").val();
        } else {
            parametros["TRIP_instructor"] = $("#TRIP_instructor_No").val();
        }
        $.post(url,parametros,
        function(data){
            if(data == ""){
                alert("La Licencia del Trip. registrado ya existe.");
            } else {
                limpiarFormTripulante('Cabina');
                $("#preloader").css("display", "none");
                alert("Se ha modificado correctamente el Tripulante.");
            }
            $('#TripCabinaRegistro').modal('hide');
            location.reload(true);
        });
    } else{
        $("#preloader").css("display","none");
    }
}

function listarDetTripCabina(url,TRIP_id,accion){
    //tripulante/listarDetTrip/";
    $("#preloader").css("display","block");
    var parametros = {
        "TRIP_id" : TRIP_id
    };
    $.post(url,parametros,
    function(data){
        if(data == ""){
            alert("Hubo un error al cargar la información.");
        } else {
            $("#titleForm").text("Detalle de Trip. de Cabina");+
                
            $("#TRIP_id").val(data[0]["TRIP_id"]);
            $("#TRIP_nombre").val(data[0]["TRIP_nombre"]);
            $("#TRIP_apellido").val(data[0]["TRIP_apellido"]);
            $("#TRIP_correo").val(data[0]["TRIP_correo"]);
            $("#TRIP_fechnac").val(data[0]["TRIP_fechnac"]);
            
            $("#idDepa").val(data[0]["idDepa"]).trigger('change.select2');
            listarComboProvinciaView();
            setTimeout(function(){
                $("#idProv").chained("#idDepa");
                $("#idProv").val(data[0]["idProv"]).trigger('change.select2');
                if(accion == "listar"){
                    $("#idProv").prop("disabled","disabled");
                }
                
                listarComboDistritoView();
                setTimeout(function(){
                    $("#idDist").val(data[0]["idDist"]).trigger('change.select2');
                    $("#idDist").chained("#idProv");
                    if(accion == "listar"){
                        $("#idDist").prop("disabled","disabled");
                    }
                },1000);
            },1000);

            $("#TRIP_domilicio").val(data[0]["TRIP_domilicio"]);
            $("#TIPTRIPDET_id").val(data[0]["TIPTRIPDET_id"]).trigger('change.select2');
            if(data[0]["TRIP_instructor"] == "Si"){
                $("#TRIP_instructor_Si").prop("checked", true);
                $("#TRIP_instructor_No").prop("checked", false);
            } else {
                $("#TRIP_instructor_Si").prop("checked", false);
                $("#TRIP_instructor_No").prop("checked", true);
            }
            $("#TIPLIC_id").val(data[0]["TIPLIC_id"]).trigger('change.select2');
            $("#TRIP_numlicencia").val(data[0]["TRIP_numlicencia"]);
            $("#TRIP_DGAC").val(data[0]["TRIP_DGAC"]);
            $("#NIVING_id").val(data[0]["NIVING_id"]).trigger('change.select2');
            $("#CAT_id").val(data[0]["CAT_id"]).trigger('change.select2');
            $("#TRIP_estado").val(data[0]["TRIP_estado"]).trigger('change.select2');

            $("#AUD_usu_cre").val(data[0]["AUD_usu_cre"]);
            $("#AUD_fch_cre").val(data[0]["AUD_fch_cre"]);
            $("#AUD_usu_mod").val(data[0]["AUD_usu_mod"]);
            $("#AUD_fch_mod").val(data[0]["AUD_fch_mod"]);
            if(accion == "listar"){
                verFormTripulante('Cabina');
            } else {
                $("#insertTripulante").hide();
                $("#updateTripulante").show();
            }
            $("#preloader").css("display", "none");
        }
    });
}

$('#TripCabinaRegistro').on('show.bs.modal', function (e) {
    $("#updateTripulante").hide();
})
$('#TripCabinaRegistro').on('hidden.bs.modal', function (e) {
    limpiarFormTripulante('Cabina');
})

function resetFormTripCabina(url){
    window.location.href = url;
}

/*--------------------------------- Para Apto Médico ---------------------------------*/
function dRestantes(){
    if($("#APT_fchvenci").val() != ''){
        var dRestantes = 0;
        var f = new Date();
        var fecha1 = (f.getDate() + "/" + (f.getMonth() +1) + "/" + f.getFullYear());
        var fecha2 = $("#APT_fchvenci").val();
        dRestantes = restaFechas(fecha1,fecha2);
        $("#APT_drestantes").val(dRestantes);
        if(dRestantes <= 0){
           $("#APT_drestantes").css("color","#f60909");
        }
    }
}

function insertApto(url,variable){
    $("#preloader").css("display","block");
    
    var flagEstadoModulo = variable;
    
    var FLAG_estado = flagEstadoModulo[0]["FLAG_estado"];
    var AUD_usu_cre = flagEstadoModulo[0]["AUD_usu_cre"];
        
    if(FLAG_estado != '1'){
        if(validate_formApto()) {
            var parametros = {
                "TRIP_id" : $("#TRIP_id").val(),
                "APT_fchvenci" : $("#APT_fchvenci").val(),
                "APT_fchgestion" : $("#APT_fchgestion").val(),
                "APT_indicador" : 'No',
                "APT_estado" : $("#APT_estado").val(),
            };
            $.post(url,parametros,
            function(data){
                var TRIP_nombre = data[0]["TRIP_nombre"];
                var TRIP_apellido = data[0]["TRIP_apellido"];           
                var APT_fchvenci = data[0]["APT_fchvenci"];           
                var APT_fchgestion = data[0]["APT_fchgestion"];           

                if(TRIP_nombre != undefined){
                    alert('El Tripulante ' + TRIP_nombre + ' ' + TRIP_apellido + ' ya cuenta con la Fecha de Vencimiento: ' + APT_fchvenci + ' y la Fecha de Gestión: ' + APT_fchgestion);
                    $("#preloader").css("display","none");
                } else {
                    limpiarFormApto();
                    $("#preloader").css("display", "none");
                    alert("Se ha registrado correctamente el Apto.");
                    $('#aptoRegistro').modal('hide');
                    location.reload(true);              
                }
            });
        } else{
            $("#preloader").css("display","none");
        }
    } else {
        $("#preloader").css("display","none");
        $("#usuEdicion").text(AUD_usu_cre);
        $("#TipoTrabajoMensaje").modal('show');
    }
}

function updateApto(url,variable){
    $("#preloader").css("display","block");
    var flagEstadoModulo = variable;
    
    var FLAG_estado = flagEstadoModulo[0]["FLAG_estado"];
    var AUD_usu_cre = flagEstadoModulo[0]["AUD_usu_cre"];
        
    if(FLAG_estado != '1'){
        if(validate_formApto()) {
            var parametros = {
                "APT_id" : $("#APT_id").val(),
                "TRIP_id" : $("#TRIP_id").val(),
                "APT_fchvenci" : $("#APT_fchvenci").val(),
                "APT_fchgestion" : $("#APT_fchgestion").val(),
                "APT_indicador" : $("#APT_indicador").val(),
                "APT_fchentrega" : $("#APT_fchentrega").val(),
                "APT_observacion" : $("#APT_observacion").val(),
                "APT_estado" : $("#APT_estado").val(),
            };
            $.post(url,parametros,
            function(data){
                if(data == ""){
                    alert("Hubo un error en la modificación de la Información.");
                } else {
                    var table = $('#listaDetApto').DataTable();
                    table.destroy();
                    listarApto($("#APT_fchvenci_Mes").val(),$("#APT_fchvenci_Anio").val(),$("#TIPTRIP_id").val());
                    limpiarFormApto();
                    $("#preloader").css("display", "none");
                    alert("Se ha modificado correctamente el Apto.");
                }
                $('#aptoRegistro').modal('hide');
            });
        } else{
            $("#preloader").css("display","none");
        }
    } else {
        $("#preloader").css("display","none");
        $("#usuEdicion").text(AUD_usu_cre);
        $("#TipoTrabajoMensaje").modal('show');
    }
}

function listarDetApto(url,APT_id,accion){
    //apto/listarDetApto/";
    $("#preloader").css("display","block");
    
    var parametros = {
        "APT_id" : APT_id
    };
    $.post(url,parametros,
    function(data){
        if(data == ""){
            alert("Hubo un error al cargar la información.");
        } else {
            $("#titleForm").text("Detalle de apto");
            var f = new Date();
            var fecha1 = (f.getDate() + "/" + (f.getMonth() +1) + "/" + f.getFullYear());
            var fecha2 = data[0]["APT_fchvenci"];
            var dRestantes = restaFechas(fecha1,fecha2);

            $("#APT_id").val(data[0]["APT_id"]);

            $("#TIPTRIP_id").val(data[0]["TIPTRIP_id"]).trigger('change.select2');
            listarComboDetalleTripView();
            setTimeout(function(){
                $("#TIPTRIPDET_id").chained("#TIPTRIP_id");
                $("#TIPTRIPDET_id").val(data[0]["TIPTRIPDET_id"]).trigger('change.select2');
                if(accion == "listar"){
                    $("#TIPTRIPDET_id").prop("disabled","disabled");
                }

                listarComboTripulanteView($("#TRIP_id"));
                setTimeout(function(){
                    $("#TRIP_id").val(data[0]["TRIP_id"]).trigger('change.select2');
                    $("#TRIP_id").chained("#TIPTRIPDET_id");
                    if(accion == "listar"){
                        $("#TRIP_id").prop("disabled","disabled");
                    }
                },250);
            },750);

            $("#APT_fchvenci").val(data[0]["APT_fchvenci"]);
            $("#APT_fchgestion").val(data[0]["APT_fchgestion"]);
            $("#APT_fchentrega").val(data[0]["APT_fchentrega"]);
            $("#APT_indicador").val(data[0]["APT_indicador"]).trigger('change.select2');
            $("#APT_observacion").val(data[0]["APT_observacion"]);
            $("#APT_estado").val(data[0]["APT_estado"]).trigger('change.select2');
            $("#APT_drestantes").val(dRestantes);

            $("#AUD_usu_cre").val(data[0]["AUD_usu_cre"]);
            $("#AUD_fch_cre").val(data[0]["AUD_fch_cre"]);
            $("#AUD_usu_mod").val(data[0]["AUD_usu_mod"]);
            $("#AUD_fch_mod").val(data[0]["AUD_fch_mod"]);
            if(accion == "listar"){
                verFormApto();
            } else {
                $("#divAPT_indicador").css("display","block");
                //$("#APT_indicador").removeAttr("disabled");
                //$("#APT_fchgestion").removeAttr("disabled");
                //$("#APT_indicador").css("background", "#FFF");
                //$("#APT_fchgestion").css("background", "#FFF");
                
                setTimeout(function(){
                    if( $("#Apto_fechaGestion").val() == "fechaGestion" && $("#Apto_registro").val() != "" ){
                        
                        $("#Apto_fechaGestion").css("background", "#FFF");
                        $("#APT_fchvenci").css("background", "#EEEEEE");
                        
                        $("#TIPTRIP_id").prop("disabled","disabled");
                        $("#TIPTRIPDET_id").prop("disabled","disabled");
                        $("#TRIP_id").prop("disabled","disabled");
                        $("#APT_fchvenci").prop("disabled","disabled");
                        $("#APT_estado").prop("disabled","disabled");
                        $("#APT_indicador").prop("disabled","disabled");
                        $("#APT_fchentrega").prop("disabled","disabled");
                        $("#APT_observacion").prop("disabled","disabled");
                        
                    }
                },1250);
                
                var result = ($("#APT_fchvenci").val()).split('/');
                var d = new Date();
                var strDate_2 = (d.getMonth()+1) + "/" + d.getDate() + "/" + d.getFullYear();
                $("#APT_fchgestion").datetimepicker({
                    format: 'DD/MM/YYYY',
                    maxDate: result[1] + '/' + result[0] + '/' + result[2],
                    minDate: strDate_2,
                });
                
                $("#insertApto").hide();
                $("#updateApto").show();
            }
            $("#preloader").css("display", "none");
        }
    });
}

function validarEstadoApto(){
    if($("#APT_estado").val() == "0"){
        $("#APT_indicador").val("No").trigger('change.select2');
        $("#APT_indicador").prop("disabled","disabled");
    } else {
        $("#APT_indicador").removeAttr("disabled");
    }
}

function validarIndicadorApto(){
    if($("#APT_indicador").val() == "Si"){
        $("#divAPT_fchentrega").css("display","block");
        $("#divAPT_observacion").css("display","block");

        var select = $("#APT_fchentregaDate");
        var f = new Date();
        if($("#APT_fchgestion").val() == ""){
            var fchIni = f.getDate() + "/" + (f.getMonth() +1) + "/" + f.getFullYear();
        } else {
            var fchIni = $("#APT_fchgestion").val();
        }
        
        validarFechaContinua(select,fchIni);

    } else if($("#APT_indicador").val() == "No"){
        $("#divAPT_fchentrega").css("display","none");
        $("#divAPT_observacion").css("display","none");
        $("#APT_fchentrega").val("");
        $("#APT_observacion").val("");
    }
}

$("#APT_fchvenciDate").on("dp.change", function (e) {
    var select = $("#APT_fchgestionDate");
    var fchIni = $("#APT_fchvenci").val();
    validarFechaContinuaInversa(select,fchIni);
    $("#APT_fchgestion").val("");
    /*$("#APT_fchgestion").removeAttr("disabled");
    $("#APT_fchgestion").css("background", "#FFFFFF");*/
});
$('#aptoRegistro').on('show.bs.modal', function (e) {
    $("#updateApto").hide();
})
$('#aptoRegistro').on('hidden.bs.modal', function (e) {
    limpiarFormApto();
})
$('#aptoDetalle').on('show.bs.modal', function (e) {
    $("#aptoDetalle").css('z-index','1045');
})
$('#aptoDetalle').on('hidden.bs.modal', function (e) {
    var table = $('#listaDetApto').DataTable();
    table.destroy();
    location.reload(true);
})

function resetFormApto(url){
    window.location.href = url;
}

/*--------------------------------- Para Curso ---------------------------------*/
function quitar_alumno() {
    var num = $("#num-alum").val();
    var newnum = Number(num) - 1;

    $("#num-alum").val(newnum);
    $("#divAlumno" + num).remove();
}

function agregar_alumno() {
    var num = $("#num-alum").val() <= 0 ? 1 : $("#num-alum").val();
    var newnum = Number(num) + 1;

    html = '<div class="col-xs-8 col-md-8" style="padding: 0px;margin: 1px;" id="divAlumno' + newnum + '">'
                + '<select name="TRIP_id_a' + newnum + '" id="TRIP_id_a' + newnum + '" class="form-control input-sm js-example-basic-single_extra" >'
                    + '<option value="" selected>Seleccionar Tripulante</option>'
                + '</select>'
            + '</div>';
    $("#divAlum").append(html);
    listarComboTripulanteView($("#TRIP_id_a" + newnum));
    setTimeout(function(){
        $("#TRIP_id_a" + newnum).chained("#TIPTRIP_id");
    },500);
    $(document).ready(function() { $(".js-example-basic-single_extra").select2(); });
    $("#num-alum").val(newnum);
}

function insertCurso(url,variable){
    $("#preloader").css("display","block");
    
    var flagEstadoModulo = variable;
    
    var FLAG_estado = flagEstadoModulo[0]["FLAG_estado"];
    var AUD_usu_cre = flagEstadoModulo[0]["AUD_usu_cre"];
        
    if(FLAG_estado != '1'){
    
    var cantidad = $("#num-alum").val();
        if(validate_formCurso()) {

            var parametros = {
                "TIPCUR_id" : $("#TIPCUR_id").val(),
                "TRIP_id_i" : $("#TRIP_id_i").val(),
                "CUR_fchini" : $("#CUR_fchini").val(),
                "CUR_fchfin" : $("#CUR_fchfin").val(),
                "PART_indicador" : 'PENDIENTE',
                "CUR_estado" : $("#CUR_estado").val(),
                "cantidad" : $("#num-alum").val(),
            };
            for (var i = 1; i <= cantidad; i++) {
                parametros["TRIP_id_a" + i] = $("#TRIP_id_a" + i).val();
            }

            $.post(url,parametros,

            function(data){
                var CUR_fchini = data[0]["CUR_fchini"];
                var CUR_fchfin = data[0]["CUR_fchfin"];

                if(CUR_fchini != undefined){
                    alert('Conflicto de Fechas. Ya existe programado un curso de fecha ' + CUR_fchini + ' al ' + CUR_fchfin);
                    $("#preloader").css("display","none");
                } else {
                    limpiarFormCurso();
                    $("#preloader").css("display", "none");
                    alert("Se ha registrado correctamente el Curso.");
                    $('#cursoRegistro').modal('hide');
                    location.reload(true);               
                }
            });
        } else{
            $("#preloader").css("display","none");
        }
    } else {
        $("#preloader").css("display","none");
        $("#usuEdicion").text(AUD_usu_cre);
        $("#TipoTrabajoMensaje").modal('show');
    }
}

function updateCurso(url,variable){
    $("#preloader").css("display","block");
    
    var flagEstadoModulo = variable;
    
    var FLAG_estado = flagEstadoModulo[0]["FLAG_estado"];
    var AUD_usu_cre = flagEstadoModulo[0]["AUD_usu_cre"];
        
    if(FLAG_estado != '1'){

        var cantidad = $("#num-alum").val();
        var variable = true;

        if($("#dCUR_fchinforme").val() != ""){
            var cantidad = $("#num-alum").val();

            for (var i = 2; i <= cantidad; i++) {
                if($("#dPART_indicador" + i).val() == "PENDIENTE"){
                    var variable = false;
                    break;
                }
            }
            if(!(variable)){
               alert("Debe Modificar el estado de los Alumnos.");
                $("#preloader").css("display","none");
            }
        }
        if(validate_formModCurso() && variable) {
            var parametros = {
                "CUR_id" : $("#dCUR_id").val(),
                "TIPCUR_id" : $("#dTIPCUR_id").val(),
                "TRIP_id_i" : $("#dTRIP_id_i").val(),
                "CUR_fchini" : $("#dCUR_fchini").val(),
                "CUR_fchfin" : $("#dCUR_fchfin").val(),
                "CUR_estado" : $("#dCUR_estado").val(),
                "CUR_fchinforme" : $("#dCUR_fchinforme").val(),
                "cantidad" : $("#num-alum").val(),
            };
            for (var i = 1; i <= cantidad; i++) {
                parametros["TRIP_id_a" + i] = $("#dTRIP_id_a" + i).val();
                parametros["PART_indicador" + i] = $("#dPART_indicador" + i).val();
                parametros["PART_observacion" + i] = $("#dPART_observacion" + i).val();
                parametros["PART_id_a" + i] = $("#PART_id_a" + i).val();
            }

            $.post(url,parametros,

            function(data){
                if(data == ""){
                    alert("Hubo un error en la modificación de la Información.");
                } else {
                    limpiarFormCurso();
                    $("#preloader").css("display", "none");
                    alert("Se ha modificado correctamente el Curso.");
                }
                $('#cursoDetalle').modal('hide');
                location.reload(true);
            });
        }
        else{
            $("#preloader").css("display","none");
        }
    } else {
        $("#preloader").css("display","none");
        $("#usuEdicion").text(AUD_usu_cre);
        $("#TipoTrabajoMensaje").modal('show');
    }
}

function listarCurso(url,CUR_id,accion){
    //var url = "<?php echo URLLOGICA?>curso/listarCurso/";
    $("#preloader").css("display","block");

    $.post(url,
    {
        "CUR_id" : CUR_id
    },
    function(data){
        if(data == ""){
            alert("Hubo un error al cargar la información.");
        } else {
            $("#dCUR_id").val(data[0]["CUR_id"]).trigger('change.select2');
            $("#dTIPCUR_id").val(data[0]["TIPCUR_id"]).trigger('change.select2');
            $("#dTIPTRIP_id").val(data[0]["TIPTRIP_id"]).trigger('change.select2');
            $("#PART_id_i").val(data[0]["PART_id"]);

            listarComboTripulanteView($("#dTRIP_id_i"));
            var dTRIP_id_i = data[0]["TRIP_id"]
            setTimeout(function(){
                $("#dTRIP_id_i").chained("#dTIPTRIP_id");
                $("#dTRIP_id_i").val(dTRIP_id_i).trigger('change.select2');
                if(accion == "listar"){
                    $("#dTRIP_id_i").prop("disabled","disabled");
                }
            },1000);

            $("#dCUR_fchini").val(data[0]["CUR_fchini"]);
            $("#dCUR_fchfin").val(data[0]["CUR_fchfin"]);
            $("#dCUR_fchinforme").val(data[0]["CUR_fchinforme"]);
            $("#AUD_usu_cre").val(data[0]["AUD_usu_cre"]);
            $("#AUD_fch_cre").val(data[0]["AUD_fch_cre"]);
            $("#AUD_usu_mod").val(data[0]["AUD_usu_mod"]);
            $("#AUD_fch_mod").val(data[0]["AUD_fch_mod"]);

            if(accion == "listar"){
                verFormCurso();
                var disabled = 'disabled="disabled"';
            } else {
                $("#dCUR_fchfin").removeAttr("disabled");
                $("#insertCurso").hide();
                $("#dupdateCurso").show();
                var disabled = '';
            }

            $("#listaAlumnos").empty();
            for (var i = 2; i <= data.length; i++) {

            html = '<tr>'
                    + '<td style="width:auto;">' + (i-1) + '</td>'
                    + '<td style="width:10% !important;">'
                        + '<input type="hidden" name="PART_id_a' + i + '" id="PART_id_a' + i + '" value="' + data[i-1]["TRIP_id"] + '" class="form-control input-sm" />'
                        + '<select name="dTRIP_id_a' + i + '" id="dTRIP_id_a' + i + '" class="form-control input-sm js-example-basic-single_extra" ' + disabled + ' style="width:10% !important;">'
                            + '<option value="" selected>Tripulante Alumno</option>'
                        + '</select>'
                    + '</td>'
                    + '<td style="width:auto;">'
                        + '<select name="dPART_indicador' + i + '" id="dPART_indicador' + i + '" class="form-control input-sm js-example-basic-single_extra"' + disabled + '>'
                            + '<option value="APROBADO">APROBADO</option>'
                            + '<option value="DESAPROBADO">DESAPROBADO</option>'
                            + '<option value="OBSERVADO">OBSERVADO</option>'
                            + '<option value="PENDIENTE">PENDIENTE</option>'
                       + '</select>'
                    + '</td>'
                    + '<td style="width:auto;">'
                        + '<input type="text" name="dPART_observacion' + i + '" id="dPART_observacion' + i + '" class="form-control input-sm" style="text-transform: uppercase; width: 100% !important;" ' + disabled + '/>'
                    + '</td>'
                + '</tr>';
                $("#listaAlumnos").append(html);
                listarComboTripulanteView($("#dTRIP_id_a" + i));
                $(document).ready(function() { $(".js-example-basic-single_extra").select2(); });
                $("#dPART_indicador" + i).val(data[i-1]["PART_indicador"]).trigger('change.select2');
                $("#dPART_observacion" + i).val(data[i-1]["PART_observacion"]);
            }
            
            setTimeout(function(){
                for (var i = 2; i <= data.length; i++) {
                    $("#dTRIP_id_a" + i).chained("#dTIPTRIP_id");
                    $("#dTRIP_id_a" + i).val(data[i-1]["TRIP_id"]).trigger('change.select2');
                    if(accion == "listar"){
                        $("#dTRIP_id_a" + i).prop("disabled","disabled");
                    } else {
                        $("#dPART_observacion"+ i).removeAttr("disabled");
                    }
                }
                $("#dCUR_estado").val(data[0]["CUR_estado"]).trigger('change.select2');
                
                if(accion == "listar"){
                    for (var i = 2; i <= data.length; i++) {
                        $("#dTRIP_id_a" + i).prop("disabled","disabled");
                        $("#dPART_indicador" + i).prop("disabled","disabled");
                        $("#dPART_observacion" + i).prop("disabled","disabled");
                    }
                }
            },1000);
            $("#num-alum").val(data.length);
            $("#preloader").css("display", "none");
        }
    });
}

function validarEstadoCurso(){
    var cantidad = $("#num-alum").val();
    if($("#dCUR_estado").val() == "0"){
        $("#dCUR_fchinforme").val("");
        for (var i = 2; i <= cantidad; i++) {
            $("#dPART_indicador" + i).val("PENDIENTE").trigger('change.select2');
            $("#dPART_observacion" + i).val("");
            $("#dTRIP_id_a" + i).prop("disabled","disabled");
            $("#dPART_indicador" + i).prop("disabled","disabled");
            $("#dPART_observacion" + i).prop("disabled","disabled");
        }
        $("#dCUR_fchinforme").prop("disabled","disabled");
    } else {
        $("#dCUR_fchinforme").removeAttr("disabled");
        for (var i = 2; i <= cantidad; i++) {
            $("#dTRIP_id_a"+ i).removeAttr("disabled");
            $("#dPART_indicador"+ i).removeAttr("disabled");
            $("#dPART_observacion"+ i).removeAttr("disabled");
        }
    }
}

$("#CUR_fchiniDate").on("dp.change", function (e) {
    var select = $("#CUR_fchfinDate");
    var fchIni = $("#CUR_fchini").val();
    validarFechaContinua(select,fchIni);
    $("#CUR_fchfin").removeAttr("disabled");
    $("#CUR_fchfin").css("background", "#FFFFFF");
});
$("#dCUR_fchiniDate").on("dp.change", function (e) {
    var select = $("#dCUR_fchfinDate");
    var fchIni = $("#dCUR_fchini").val();
    validarFechaContinua(select,fchIni);
    $("#dCUR_fchfin").removeAttr("disabled");
    $("#dCUR_fchfin").css("background", "#FFFFFF");
});
$('#cursoRegistro').on('show.bs.modal', function (e) {
    $("#updateCurso").hide();
})
$('#cursoRegistro').on('hidden.bs.modal', function (e) {
    limpiarFormCurso();
})
$('#cursoDetalle').on('hidden.bs.modal', function (e) {
    limpiarFormCurso();
})

function resetFormCurso(url){
    window.location.href = url;
}

/*--------------------------------- Para Chequeo ---------------------------------*/
function insertChequeo(url,variable){
    $("#preloader").css("display","block");
    
    var flagEstadoModulo = variable;
    
    var FLAG_estado = flagEstadoModulo[0]["FLAG_estado"];
    var AUD_usu_cre = flagEstadoModulo[0]["AUD_usu_cre"];
        
    if(FLAG_estado != '1'){
        if(validate_formChequeo()) {
            var parametros = {
                "TIPCHEQ_id" : $("#TIPCHEQ_id").val(),
                "TRIP_id" : $("#TRIP_id").val(),
                "CHEQ_fch" : $("#CHEQ_fch").val(),
                "CHEQ_estado" : $("#CHEQ_estado").val(),
                "CHEQ_indicador" : 'PENDIENTE'
            };
            $.post(url,parametros,
            function(data){
                var TRIP_nombre = data[0]["TRIP_nombre"];
                var TRIP_apellido = data[0]["TRIP_apellido"];           
                var CHEQ_fch = data[0]["CHEQ_fch"];         

                if(TRIP_nombre != undefined){
                    alert('El Tripulante ' + TRIP_nombre + ' ' + TRIP_apellido + ' ya cuenta con la Fecha de Chequeo: ' + CHEQ_fch);
                    $("#preloader").css("display","none");
                } else {
                    limpiarFormChequeo();
                    $("#preloader").css("display", "none");
                    alert("Se ha registrado correctamente el Chequeo.");
                    $('#chequeoRegistro').modal('hide');
                    location.reload(true);           
                }
            });
        } else{
            $("#preloader").css("display","none");
        }
    } else {
        $("#preloader").css("display","none");
        $("#usuEdicion").text(AUD_usu_cre);
        $("#TipoTrabajoMensaje").modal('show');
    }
}

function updateChequeo(url,variable){
    $("#preloader").css("display","block");
    
    var flagEstadoModulo = variable;
    
    var FLAG_estado = flagEstadoModulo[0]["FLAG_estado"];
    var AUD_usu_cre = flagEstadoModulo[0]["AUD_usu_cre"];
        
    if(FLAG_estado != '1'){
        if(validate_formChequeo()) {
            var parametros = {
                "CHEQ_id" : $("#CHEQ_id").val(),
                "TIPCHEQ_id" : $("#TIPCHEQ_id").val(),
                "TRIP_id" : $("#TRIP_id").val(),
                "CHEQ_fch" : $("#CHEQ_fch").val(),
                "CHEQ_indicador" : $("#CHEQ_indicador").val(),
                "CHEQ_fchentrega" : $("#CHEQ_fchentrega").val(),
                "CHEQ_observacion" : $("#CHEQ_observacion").val(),
                "CHEQ_estado" : $("#CHEQ_estado").val(),
            };
            $.post(url,parametros,
            function(data){
                if(data == ""){
                    alert("Hubo un error en la modificación de la Información.");
                } else {
                    var table = $('#listaDetChequeo').DataTable();
                    table.destroy();
                    listarChequeo($("#CHEQ_fch_Mes").val(),$("#CHEQ_fch_Anio").val(),$("#TIPTRIP_id").val());
                    limpiarFormChequeo();

                    $("#preloader").css("display", "none");
                    alert("Se ha modificado correctamente el Chequeo.");
                    $('#chequeoRegistro').modal('hide');
                }
            });
        } else{
            $("#preloader").css("display","none");
        }
    } else {
        $("#preloader").css("display","none");
        $("#usuEdicion").text(AUD_usu_cre);
        $("#TipoTrabajoMensaje").modal('show');
    }
}

function listarDetChequeo(url,CHEQ_id,accion){
    //var url = "<?php echo URLLOGICA?>chequeo/listarDetChequeo/";
    $("#preloader").css("display","block");
    var parametros = {
        "CHEQ_id" : CHEQ_id
    };
    $.post(url,parametros,
    function(data){
        if(data == ""){
            alert("Hubo un error al cargar la información.");
        } else {
            $("#titleForm").text("Detalle de Chequeo");
            $("#CHEQ_id").val(data[0]["CHEQ_id"]);
            $("#TIPCHEQ_id").val(data[0]["TIPCHEQ_id"]).trigger('change.select2');
            $("#TIPTRIP_id").val(data[0]["TIPTRIP_id"]).trigger('change.select2');
            listarComboDetalleTripView();
            //listarDetalleTrip('<?php echo URLLOGICA?>tripulante/listarTipoTripDetalle/');
            setTimeout(function(){
                $("#TIPTRIPDET_id").val(data[0]["TIPTRIPDET_id"]).trigger('change.select2');
            },1000);
            //listarTripulantes('<?php echo URLLOGICA?>tripulante/listarTripulantes/','TIPTRIPDET_id');
            listarComboTripulanteView($("#TRIP_id"))
            setTimeout(function(){
                $("#TRIP_id").val(data[0]["TRIP_id"]).trigger('change.select2');
            },1000);

            listarComboDetalleTripView();
            setTimeout(function(){
                $("#TIPTRIPDET_id").chained("#TIPTRIP_id");
                $("#TIPTRIPDET_id").val(data[0]["TIPTRIPDET_id"]).trigger('change.select2');
                if(accion == "listar"){
                    $("#TIPTRIPDET_id").prop("disabled","disabled");
                }

                listarComboTripulanteView($("#TRIP_id"));
                setTimeout(function(){
                    $("#TRIP_id").val(data[0]["TRIP_id"]).trigger('change.select2');
                    $("#TRIP_id").chained("#TIPTRIPDET_id");
                    if(accion == "listar"){
                        $("#TRIP_id").prop("disabled","disabled");
                    }
                },500);
            },1000);

            $("#AUD_usu_cre").val(data[0]["AUD_usu_cre"]);
            $("#AUD_fch_cre").val(data[0]["AUD_fch_cre"]);
            $("#AUD_usu_mod").val(data[0]["AUD_usu_mod"]);
            $("#AUD_fch_mod").val(data[0]["AUD_fch_mod"]);
            
            $("#CHEQ_estado").val(data[0]["CHEQ_estado"]).trigger('change.select2');
            $("#CHEQ_fch").val(data[0]["CHEQ_fch"]);
            $("#CHEQ_indicador").val(data[0]["CHEQ_indicador"]).trigger('change.select2');
            
            if(accion == "listar"){
                $("#CHEQ_indicador").prop("disabled","disabled");
                verFormChequeo();
            } else {
                $("#divCHEQ_indicador").css("display","block");
                $("#CHEQ_indicador").removeAttr("disabled");
                $("#CHEQ_indicador").css("background", "#FFF");
                $("#insertChequeo").hide();
                $("#updateChequeo").show();
            }
            
            
            $("#CHEQ_fchentrega").val(data[0]["CHEQ_fchentrega"]);
            $("#CHEQ_observacion").val(data[0]["CHEQ_observacion"]);
            
            $("#preloader").css("display", "none");
        }
    });
}

function validarEstadoChequeo(){
    if($("#CHEQ_estado").val() == "0"){
        $("#CHEQ_indicador").val("PENDIENTE").trigger('change.select2');
        $("#CHEQ_indicador").prop("disabled","disabled");
    } else {
        $("#CHEQ_indicador").removeAttr("disabled");
    }
}

function validarIndicadorChequeo(){
    if($("#CHEQ_indicador").val() != "PENDIENTE"){
        $("#divCHEQ_fchentrega").css("display","block");
        $("#divCHEQ_observacion").css("display","block");

        var select = $("#CHEQ_fchentregaDate");
        var fchIni = $("#CHEQ_fch").val();
        validarFechaContinua(select,fchIni);

    } else if($("#CHEQ_indicador").val() == "PENDIENTE"){
        $("#divCHEQ_fchentrega").css("display","none");
        $("#divCHEQ_observacion").css("display","none");
        $("#CHEQ_fchentrega").val("");
        $("#CHEQ_observacion").val("");
    }
}

$('#chequeoRegistro').on('show.bs.modal', function (e) {
    $("#updateChequeo").hide();
})
$('#chequeoRegistro').on('hidden.bs.modal', function (e) {
    limpiarFormChequeo();
})
$('#chequeoDetalle').on('show.bs.modal', function (e) {
    $("#chequeoDetalle").css('z-index','1045');
})
$('#chequeoDetalle').on('hidden.bs.modal', function (e) {
    var table = $('#listaDetChequeo').DataTable();
    table.destroy();
    location.reload(true);
})

function resetFormChequeo(url){
    window.location.href = url;
}

/*--------------------------------- Para Simulador ---------------------------------*/
function insertSimulador(url,variable){
    /*var SIMU_fchini = $("#SIMU_fchini").val();
    var SIMU_fchfin = $("#SIMU_fchfin").val();*/
    
    var SIMU_fchini = sumaFecha(-1,$("#SIMU_fchini").val());
    var SIMU_fchfin = sumaFecha(1,$("#SIMU_fchfin").val());
    
    var envio = confirm("Advertencia: El Tripulante no podrá volar del " + SIMU_fchini + " al: " + SIMU_fchfin + ". ¿Continuar (SI [ok] / NO [cancelar])?." );
    var flagEstadoModulo = variable;
    
    var FLAG_estado = flagEstadoModulo[0]["FLAG_estado"];
    var AUD_usu_cre = flagEstadoModulo[0]["AUD_usu_cre"];
        
    if(FLAG_estado != '1'){
        if (envio){
        $("#preloader").css("display","block");

            if(validate_formSimulador()) {
                var parametros = {
                    "TRIP_id" : $("#TRIP_id").val(),
                    "TRIP_id2" : $("#TRIP_id2").val(),
                    "SIMU_fchini" : $("#SIMU_fchini").val(),
                    "SIMU_fchfin" : $("#SIMU_fchfin").val(),
                    "SIMU_estado" : $("#SIMU_estado").val(),
                    "SIMU_indicador" : 'PENDIENTE'
                };
                $.post(url,parametros,
                function(data){
                    var TRIP_nombre = data[0]["TRIP_nombre"];
                    var TRIP_apellido = data[0]["TRIP_apellido"];           
                    var SIMU_fchini = data[0]["SIMU_fchini"];         
                    var SIMU_fchfin = data[0]["SIMU_fchfin"];         

                    if(TRIP_nombre != undefined){
                        alert('El Tripulante ' + TRIP_nombre + ' ' + TRIP_apellido + ' ya cuenta con la Fecha de Simulación del : ' + SIMU_fchini + ' al ' + SIMU_fchfin);
                        $("#preloader").css("display", "none");
                    } else {
                        limpiarFormSimulador('Cabina');
                        $("#preloader").css("display", "none");
                        alert("Se ha registrado correctamente el Simulador.");
                        guardarExcelSimuServidorView();
                        $('#simuladorRegistro').modal('hide');
                        location.reload(true);         
                    }
                });
            } else{
                $("#preloader").css("display","none");
            }
        } else {
            return false;
        }
    } else {
        $("#preloader").css("display","none");
        $("#usuEdicion").text(AUD_usu_cre);
        $("#TipoTrabajoMensaje").modal('show');
    }
}

function updateSimulador(url,variable){
    $("#preloader").css("display","block");
    var flagEstadoModulo = variable;
    
    var FLAG_estado = flagEstadoModulo[0]["FLAG_estado"];
    var AUD_usu_cre = flagEstadoModulo[0]["AUD_usu_cre"];
        
    if(FLAG_estado != '1'){
        if(validate_formSimulador()) {
            var parametros = {
                "SIMU_id" : $("#SIMU_id").val(),
                "TRIP_id" : $("#TRIP_id").val(),
                "TRIP_id2" : $("#TRIP_id2").val(),
                "SIMU_fchini" : $("#SIMU_fchini").val(),
                "SIMU_fchfin" : $("#SIMU_fchfin").val(),
                "SIMU_indicador" : $("#SIMU_indicador").val(),
                "SIMU_fchentrega" : $("#SIMU_fchentrega").val(),
                "SIMU_observacion" : $("#SIMU_observacion").val(),
                "SIMU_estado" : $("#SIMU_estado").val(),
            };
            $.post(url,parametros,
            function(data){
                if(data == ""){
                    alert("Hubo un error en la modificación de la Información.");
                    $("#preloader").css("display", "none");
                } else {
                    
                    var table = $('#listaDetSimulador').DataTable();
                    table.destroy();
                    listarSimulador($("#SIMU_fch_Mes").val(),$("#SIMU_fch_Anio").val(),$("#TIPTRIP_id").val());
                    limpiarFormSimulador();
                    guardarExcelSimuServidorView();
                    $("#preloader").css("display", "none");
                    alert("Se ha modificado correctamente el Simulador.");
                }
                $('#simuladorRegistro').modal('hide');
            });
        } else{
            $("#preloader").css("display","none");
        }
    } else {
        $("#preloader").css("display","none");
        $("#usuEdicion").text(AUD_usu_cre);
        $("#TipoTrabajoMensaje").modal('show');
    }
}

function listarDetSimulador(url,SIMU_id,accion){
    //var url = "<?php echo URLLOGICA?>simulador/listarDetSimulador/";
    $("#preloader").css("display","block");
    var parametros = {
        "SIMU_id" : SIMU_id
    };
    $.post(url,parametros,
    function(data){
        if(data == ""){
            alert("Hubo un error al cargar la información.");
        } else {
            $("#titleForm").text("Detalle de Simulador");

            $("#SIMU_id").val(data[0]["SIMU_id"]);
            $("#TIPTRIP_id").val(data[0]["TIPTRIP_id"]).trigger('change.select2');
            
            if( data[0]["TRIP_id2"] != "0"){
                $("#TIPTRIP_id2").val(data[0]["TIPTRIP_id2"]).trigger('change.select2');
                $("#divTIPTRIP_id2").css("display","block");
                $("#divTIPTRIPDET_id2").css("display","block");
                $("#divTRIP_id2").css("display","block");
            } else{
                $("#TIPTRIP_id2").val("").trigger('change.select2');
                $("#divTIPTRIP_id2").css("display","none");
                $("#divTIPTRIPDET_id2").css("display","none");
                $("#divTRIP_id2").css("display","none");
            }
            
            
            listarComboDetalleTripView();
            listarComboDetalleTripView2();
            
            setTimeout(function(){
                $("#TIPTRIPDET_id").chained("#TIPTRIP_id");
                $("#TIPTRIPDET_id").val(data[0]["TIPTRIPDET_id"]).trigger('change.select2');
                $("#TIPTRIPDET_id2").chained("#TIPTRIP_id2");
                
                if( data[0]["TRIP_id2"] != "0"){
                    $("#TIPTRIPDET_id2").val(data[0]["TIPTRIPDET_id2"]).trigger('change.select2');
                } else{
                    $("#TIPTRIPDET_id2").val("").trigger('change.select2');
                }
                
                if(accion == "listar"){
                    $("#TIPTRIPDET_id").prop("disabled","disabled");
                    $("#TIPTRIPDET_id2").prop("disabled","disabled");
                }else{
                    $("#divTIPTRIP_id2").css("display","block");
                    $("#divTIPTRIPDET_id2").css("display","block");
                    $("#divTRIP_id2").css("display","block");
                    
                    setTimeout(function(){
                        if( $("#Simulador_cumplimiento").val() == "indicador" && $("#Simulador_registro").val() != "" ){
                            $("#TIPTRIP_id").prop("disabled","disabled");
                            $("#TIPTRIPDET_id").prop("disabled","disabled");
                            $("#TRIP_id").prop("disabled","disabled");
                            $("#TIPTRIP_id2").prop("disabled","disabled");
                            $("#TIPTRIPDET_id2").prop("disabled","disabled");
                            $("#TRIP_id2").prop("disabled","disabled");
                            
                            $("#SIMU_fchini").prop("disabled","disabled");
                            $("#SIMU_fchini").css("background", "#EEEEEE");
                            $("#SIMU_fchfin").prop("disabled","disabled");
                            $("#SIMU_fchfin").css("background", "#EEEEEE");
                            $("#SIMU_estado").prop("disabled","disabled");
                            $("#SIM_indicador").prop("disabled","disabled");

                        }
                    },1250);
                }
                
                listarComboTripulanteView($("#TRIP_id"));
                listarComboTripulanteView($("#TRIP_id2"));
                
                setTimeout(function(){
                    $("#TRIP_id").val(data[0]["TRIP_id"]).trigger('change.select2');
                    $("#TRIP_id").chained("#TIPTRIPDET_id");
                    $("#TRIP_id2").val(data[0]["TRIP_id2"]).trigger('change.select2');
                    $("#TRIP_id2").chained("#TIPTRIPDET_id2");
                    if(accion == "listar"){
                        $("#TRIP_id").prop("disabled","disabled");
                        $("#TRIP_id2").prop("disabled","disabled");
                    }
                },500);
            },1000);

            $("#SIMU_estado").val(data[0]["SIMU_estado"]).trigger('change.select2');
            $("#SIMU_fchini").val(data[0]["SIMU_fchini"]);
            $("#SIMU_fchfin").val(data[0]["SIMU_fchfin"]);
            $("#SIMU_indicador").val(data[0]["SIMU_indicador"]).trigger('change.select2');

            $("#AUD_usu_cre").val(data[0]["AUD_usu_cre"]);
            $("#AUD_fch_cre").val(data[0]["AUD_fch_cre"]);
            $("#AUD_usu_mod").val(data[0]["AUD_usu_mod"]);
            $("#AUD_fch_mod").val(data[0]["AUD_fch_mod"]);
            
            if(accion == "listar"){
                $("#SIMU_indicador").prop("disabled","disabled");
                verFormSimulador();
            } else {
                $("#divSIMU_indicador").css("display","block");
                
                $("#SIMU_fchfin").removeAttr("disabled");
                $("#SIMU_fchfin").css("background", "#FFF");
                
                $("#insertSimulador").hide();
                $("#updateSimulador").show();
            }
            
            $("#SIMU_fchentrega").val(data[0]["SIMU_fchentrega"]);
            $("#SIMU_observacion").val(data[0]["SIMU_observacion"]);
            
            $("#preloader").css("display", "none");
        }
    });
}

function validarEstadoSimulador(){
    if($("#SIMU_estado").val() == "0"){
        $("#SIMU_indicador").val("PENDIENTE").trigger('change.select2');
        $("#SIMU_indicador").prop("disabled","disabled");
    } else {
        if( $("#Simulador_indicador").val() == "indicador" && $("#Simulador_registro").val() != "" ){
            $("#SIMU_indicador").removeAttr("disabled");
        }
    }
}

function validarIndicadorSimulador(){
    if($("#SIMU_indicador").val() != "PENDIENTE"){
        $("#divSIMU_fchentrega").css("display","block");
        $("#divSIMU_observacion").css("display","block");

        var select = $("#SIMU_fchentregaDate");
        var fchIni = $("#SIMU_fchfin").val();
        validarFechaContinua(select,fchIni);

    } else if($("#SIMU_indicador").val() == "PENDIENTE"){
        $("#divSIMU_fchentrega").css("display","none");
        $("#divSIMU_observacion").css("display","none");
        $("#SIMU_fchentrega").val("");
        $("#SIMU_observacion").val("");
    }
}

$("#SIMU_fchiniDate").on("dp.change", function (e) {
    var select = $("#SIMU_fchfinDate");
    var fchIni = $("#SIMU_fchini").val();
    validarFechaContinua(select,fchIni);
    $("#SIMU_fchfin").removeAttr("disabled");
    $("#SIMU_fchfin").css("background", "#FFFFFF");
});
$('#simuladorRegistro').on('show.bs.modal', function (e) {
    $("#updateSimulador").hide();
})
$('#simuladorRegistro').on('hidden.bs.modal', function (e) {
    limpiarFormSimulador();
})
$('#simuladorDetalle').on('show.bs.modal', function (e) {
    $("#simuladorDetalle").css('z-index','1049');
})
$('#simuladorDetalle').on('hidden.bs.modal', function (e) {
    var table = $('#listaDetSimulador').DataTable();
    table.destroy();
    location.reload(true);
})

function resetFormSimulador(url){
    window.location.href = url;
}

/*--------------------------------- Para Ausencia ---------------------------------*/
function insertAusencia(url,variable){
    $("#preloader").css("display","block");

    var flagEstadoModulo = variable;
    
    var FLAG_estado = flagEstadoModulo[0]["FLAG_estado"];
    var AUD_usu_cre = flagEstadoModulo[0]["AUD_usu_cre"];
        
    if(FLAG_estado != '1'){
        if(validate_formAusencia()) {
            var parametros = {
                "TIPAUS_id" : $("#TIPAUS_id").val(),
                "TRIP_id" : $("#TRIP_id").val(),
                "AUS_fchini" : $("#AUS_fchini").val(),
                "AUS_fchfin" : $("#AUS_fchfin").val(),
                "AUS_estado" : $("#AUS_estado").val()
            };
            $.post(url,parametros,
            function(data){
                var TRIP_nombre = data[0]["TRIP_nombre"];
                var TRIP_apellido = data[0]["TRIP_apellido"];           
                var AUS_fchini = data[0]["AUS_fchini"];         
                var AUS_fchfin = data[0]["AUS_fchfin"];         

                if(TRIP_nombre != undefined){
                    alert('Conflicto de Fechas. El Tripulante ' + TRIP_nombre + ' ' + TRIP_apellido + ' ya cuenta con un periodo de Ausencia del : ' + AUS_fchini + ' al ' + AUS_fchfin);
                    $("#preloader").css("display", "none");
                } else {
                    limpiarFormAusencia();
                    $("#preloader").css("display", "none");
                    alert("Se ha registrado correctamente la Ausencia.");
                    $('#ausenciaRegistro').modal('hide');
                    location.reload(true);       
                }
            });
        } else{
            $("#preloader").css("display","none");
        }
    } else {
        $("#preloader").css("display","none");
        $("#usuEdicion").text(AUD_usu_cre);
        $("#TipoTrabajoMensaje").modal('show');
    }
}

function updateAusencia(url,variable){
    $("#preloader").css("display","block");
    
    var flagEstadoModulo = variable;
    
    var FLAG_estado = flagEstadoModulo[0]["FLAG_estado"];
    var AUD_usu_cre = flagEstadoModulo[0]["AUD_usu_cre"];
        
    if(FLAG_estado != '1'){
        if(validate_formAusencia()) {
            var parametros = {
                "AUS_id" : $("#AUS_id").val(),
                "TIPAUS_id" : $("#TIPAUS_id").val(),
                "TRIP_id" : $("#TRIP_id").val(),
                "AUS_fchini" : $("#AUS_fchini").val(),
                "AUS_fchfin" : $("#AUS_fchfin").val(),
                "AUS_estado" : $("#AUS_estado").val()
            };
            $.post(url,parametros,
            function(data){
                if(data == ""){
                    alert("Hubo un error en la modificación de la Información.");
                } else {
                    limpiarFormAusencia();
                    $("#preloader").css("display", "none");
                    alert("Se ha modificado correctamente la Ausencia.");
                    $('#ausenciaRegistro').modal('hide');
                    location.reload(true);
                }
            });
        } else{
            $("#preloader").css("display","none");
        }
    } else {
        $("#preloader").css("display","none");
        $("#usuEdicion").text(AUD_usu_cre);
        $("#TipoTrabajoMensaje").modal('show');
    }
}

function listarDetAusencia(url,AUS_id,accion){
    //var url = "<?php echo URLLOGICA?>ausencia/listarDetAusencia/";
    $("#preloader").css("display","block");
    var parametros = {
        "AUS_id" : AUS_id
    };
    $.post(url,parametros,
    function(data){
        if(data == ""){
            alert("Hubo un error al cargar la información.");
        } else {
            $("#titleForm").text("Detalle de Ausencia");

            $("#AUS_id").val(data[0]["AUS_id"]);
            $("#TIPAUS_id").val(data[0]["TIPAUS_id"]).trigger('change.select2');
            $("#TIPTRIP_id").val(data[0]["TIPTRIP_id"]).trigger('change.select2');
            
            listarComboDetalleTripView();
            setTimeout(function(){
                $("#TIPTRIPDET_id").chained("#TIPTRIP_id");
                $("#TIPTRIPDET_id").val(data[0]["TIPTRIPDET_id"]).trigger('change.select2');
                if(accion == "listar"){
                    $("#TIPTRIPDET_id").prop("disabled","disabled");
                }

                listarComboTripulanteView($("#TRIP_id"));
                setTimeout(function(){
                    $("#TRIP_id").val(data[0]["TRIP_id"]).trigger('change.select2');
                    $("#TRIP_id").chained("#TIPTRIPDET_id");
                    if(accion == "listar"){
                        $("#TRIP_id").prop("disabled","disabled");
                    }
                },350);
            },750);

            $("#AUS_fchini").val(data[0]["AUS_fchini"]);
            $("#AUS_fchfin").val(data[0]["AUS_fchfin"]);
            $("#AUS_estado").val(data[0]["AUS_estado"]).trigger('change.select2');

            $("#AUD_usu_cre").val(data[0]["AUD_usu_cre"]);
            $("#AUD_fch_cre").val(data[0]["AUD_fch_cre"]);
            $("#AUD_usu_mod").val(data[0]["AUD_usu_mod"]);
            $("#AUD_fch_mod").val(data[0]["AUD_fch_mod"]);
            if(accion == "listar"){
                verFormAusencia();
            } else {
                $("#AUS_fchfin").removeAttr("disabled");
                $("#insertAusencia").hide();
                $("#updateAusencia").show();
            }
            $("#preloader").css("display", "none");
        }
    });
}

$("#AUS_fchiniDate").on("dp.change", function (e) {
    var select = $("#AUS_fchfinDate");
    var fchIni = $("#AUS_fchini").val();
    validarFechaContinua(select,fchIni);
    $("#AUS_fchfin").removeAttr("disabled");
    $("#AUS_fchfin").css("background", "#FFFFFF");
});
$('#ausenciaRegistro').on('show.bs.modal', function (e) {
    $("#updateAusencia").hide();
})
$('#ausenciaRegistro').on('hidden.bs.modal', function (e) {
    limpiarFormAusencia();
})

function resetFormAusencia(url){
    window.location.href = url;
}

/*--------------------------------- Para Programación ---------------------------------*/
function quitar_TripCabina() {
    var num = $("#num-TripCabina").val();
    var newnum = Number(num) - 1;

    $("#divTripCabina" + num).remove();
    $("#num-TripCabina").val(newnum);
}

function agregar_TripCabina() {
    var num = $("#num-TripCabina").val() <= 0 ? 1 : $("#num-TripCabina").val();
    var newnum = Number(num) + 1;

    html = '<div class="col-xs-8 col-md-8" style="padding: 0px;margin: 1px;" id="divTripCabina' + newnum + '">'
                + '<select name="TRIP_id_TripCabina' + newnum + '" id="TRIP_id_TripCabina' + newnum + '" class="form-control input-sm js-example-basic-single_extra" >'
                    + '<option value="" selected>Seleccionar Trip. Cabina</option>'
                + '</select>'
            + '</div>';
    
    var RUT_num_vuelo = $("#RUT_num_vuelo").val();
    var TIPTRIPU_id_cabina = $("#TIPTRIPU_id_cabina_ini").val();
    var TIPTRIPU_id_piloto = $("#TIPTRIPU_id_piloto_ini").val();
    listarCabinaView(newnum,TIPTRIPU_id_cabina,TIPTRIPU_id_piloto);
    $("#divTripCabina").append(html);
    $("#TRIP_id_a" + newnum).chained("#TIPTRIP_id");
    $("#num-TripCabina").val(newnum);
    $(document).ready(function() { $(".js-example-basic-single_extra").select2(); });
}

function agregar_TripCabinaProg() {
    var num = $("#num-TripCabina").val() <= 0 ? 1 : $("#num-TripCabina").val();
    var newnum = Number(num) + 1;
    
    html = '<div class="col-md-12" style="padding-bottom: 10px;" >'
                + '<label for="TRIP_id_TripCabina" class="col-md-4 control-label" id="TRIP_id_TripCabina' + newnum + '_label" >Tripulante de Cabina N° ' + newnum + '</label>'
                + '<div class="col-md-7">'
                    + '<select name="TRIP_id_TripCabina' + newnum + '" id="TRIP_id_TripCabina' + newnum + '" class="form-control input-sm js-example-basic-single_extra" >'
                        + '<option value="" selected>Seleccionar Trip. Cabina</option>'
                    + '</select>'
                + '</div>';
            + '</div>';
    
    var RUT_num_vuelo = $("#RUT_num_vuelo").val();
    var TIPTRIPU_id_cabina = $("#TIPTRIPU_id_cabina_ini").val();
    var TIPTRIPU_id_piloto = $("#TIPTRIPU_id_piloto_ini").val();
    listarCabinaView(newnum,TIPTRIPU_id_cabina,TIPTRIPU_id_piloto);
    $("#divTripCabina").append(html);
    $("#TRIP_id_a" + newnum).chained("#TIPTRIP_id");
    $("#num-TripCabina").val(newnum);
    $(document).ready(function() { $(".js-example-basic-single_extra").select2(); });
}

function listarTripulantesMotor(url,ITI_id,TRIP_id,RUT_num_vuelo,TIPTRIPU_id_cabina,TIPTRIPU_id_piloto){
    $("#preloader").css("display","block");

    listarInstructor(url,RUT_num_vuelo,TIPTRIPU_id_cabina,TIPTRIPU_id_piloto);
    listarPiloto(url,RUT_num_vuelo,TIPTRIPU_id_cabina,TIPTRIPU_id_piloto);
    listarJefeCabina(url,RUT_num_vuelo,TIPTRIPU_id_cabina,TIPTRIPU_id_piloto);
    listarCabina(url,'1',RUT_num_vuelo,TIPTRIPU_id_cabina,TIPTRIPU_id_piloto);
    listarApoyo(url,RUT_num_vuelo,TIPTRIPU_id_cabina,TIPTRIPU_id_piloto);

    $("#preloader").css("display", "none");
}

function validarCopilotoxPiloto(url,valor){
    if($("#TRIP_id_Piloto").val() != ''){
        $("#TRIP_id_Copiloto").val("").trigger('change.select2');
        var TRIP_id = $("#TRIP_id_Piloto").val();
        var ITI_id = $("#ITI_id").val();
        var RUT_num_vuelo = $("#RUT_num_vuelo").val();
        var TIPTRIPU_id_cabina = $("#TIPTRIPU_id_cabina_ini").val();
        var TIPTRIPU_id_piloto = $("#TIPTRIPU_id_piloto_ini").val();
        listarCopiloto(url,TRIP_id,RUT_num_vuelo,TIPTRIPU_id_cabina,TIPTRIPU_id_piloto);
    }
}

function ejecucionMotor(url){
    var parametros = {
    };
    $.post(url,parametros,
    function(data){
    });
}

function guardarExcelServidor(url){
    var parametros = {
    };
    $.post(url,parametros,
    function(data){
    });
}

$('#programacionRegistro').on('show.bs.modal', function (e) {
    $("#updateProgramacion").hide();
})
$('#programacionRegistro').on('hidden.bs.modal', function (e) {
    limpiarFormProgramacion();
})

/*--------------------------------- Para Reserva ---------------------------------*/
function insertReserva(accion,url){
    $("#preloader").css("display","block");

    if(validate_formReserva()) {
        var parametros = {
            "accion": accion,
            "RES_id" : $("#RES_id").val(),
            "RES_fch" : $("#bITI_fch").val(),
            "TRIP_id_Instructor" : $("#TRIP_id_Instructor").val(),
            "TRIP_id_Piloto" : $("#TRIP_id_Piloto").val(),
            "TIPTRIPU_id" : $("#TIPTRIPU_id_cabina").val(),
            "TRIP_id_Copiloto" : $("#TRIP_id_Copiloto").val(),
            "TRIP_id_JejeCabina" : $("#TRIP_id_JejeCabina").val(),
            "num_TripCabina" : $("#num-TripCabina").val()
        };
        for (var i = 1; i <= $("#num-TripCabina").val(); i++) {
            parametros["TRIP_id_TripCabina" + i] = $("#TRIP_id_TripCabina" + i).val();
        }

        $.post(url,parametros,
        function(data){
            if(data == ""){
                alert("Hubo un error en el registro.");
            } else {
                limpiarFormProgramacion();
                $("#preloader").css("display", "none");
                alert("Se ha registrado correctamente la Reserva.");
            }
            $('#programacionRegistro').modal('hide');
            location.reload(true);
        });
    } else{
        alert("Ingresar Información");
        $("#preloader").css("display","none");
    }
}
$("#divRES_fch").on("dp.change", function (e) {
    $("#TRIP_id_Piloto").removeAttr("disabled");
    $("#TRIP_id_Copiloto").removeAttr("disabled");
    $("#TRIP_id_JejeCabina").removeAttr("disabled");
    $("#TRIP_id_TripCabina1").removeAttr("disabled");
    $("#agregar_TripCabina").removeAttr("disabled");
    $("#quitar_TripCabina").removeAttr("disabled");
    
    listarTripulantesMotorView();
    
});
$('#reservaRegistro').on('show.bs.modal', function (e) {
    $("#updateReserva").hide();
})
$('#reservaRegistro').on('hidden.bs.modal', function (e) {
    limpiarFormReserva();
})