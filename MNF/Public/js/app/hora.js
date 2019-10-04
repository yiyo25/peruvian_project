
$(document).ready(function () {
    openFlightTime();
});

function validInput() {
    $("#frm_hora_vuelo").find(':input').each(function () {
        var elemento = this;
        $("#" + elemento.id + "").keypress(function (element) {
            soloNumeros(element);
            if ($("#" + elemento.id + "").hasClass('error-input')) {
                $("#" + elemento.id + "").removeClass('error-input');
            }
        });

        $("#" + elemento.id + "").blur(function () {
            validarSiNumero(elemento);
        });
    });
}

function saveHora() {
    $("#btnSaveHora").click(function () {
        if (validarFrm()) {
            if(validarTiempoMayor()){
            var id_vuelo_detalle = $("#id_vuelo_detalle").val();
            var txtCPITIN = $("#txt_ci_pu_iti").val();
            var txtCP = $("#txt_ci_pu").val();
            var txtPB = $("#txt_pu_pb").val();
            var txtENG_ON = $("#txt_eng_on").val();
            var txtTAKE_OFF = $("#txt_take_off").val();
            var txtHoraAirr = $("#txt_arr_in").val();
            var txtTiempoVuelo = $("#txt_tiempoVuelo").val();
            var txtETA = $("#txt_eta").val();

            var txtStop = $("#txt_stop").val();
            var txtAP = $("#txt_AP").val();
            var txtAPItin = "0000";

            var flag_horas = $("#horas_block_flag").val();

            var horasBlock;
            if (flag_horas === '1') {
                horasBlock = $("#txt_TiempoHorasBlock").val();

            }else{
                horasBlock = "";
            }
            var urlJson = {
                idVueloDetalle:id_vuelo_detalle,
                txtCPITIN :txtCPITIN,
                txtCP:txtCP,
                txtPB:txtPB,
                txtENG_ON:txtENG_ON,
                txtTAKE_OFF:txtTAKE_OFF,
                txtHoraAirr: txtHoraAirr,
                txtTiempoVuelo: txtTiempoVuelo,
                txtETA: txtETA,
                txtStop: txtStop,
                txtAP: txtAP,
                txtAPItin: txtAPItin,
                txtTiempoHorasBlock: horasBlock
                        
            };
            
            
            swal({
                icon: 'warning',
                title: 'Registrar Horario',
                text: "Esta seguro de registrar los horarios",
                buttons: true,
                dangerMode: true
            }).then((willDelete) => {
                if (willDelete) {
                     $.ajax({
                        url: SERVER_NAME + 'Horavuelo/saveHora',
                        type: 'post',
                        data: urlJson,
                        dataType: "json",
                        success: function (response) {
                            if (response.rpt == 1) {
                                //console.log("guardado");
                                $('#dinamicModal').modal('hide');
                                swal("Horario Guardado Correctamente", {
                                    icon: "success"
                                }).then((willDelete) => {
                                    if (willDelete) {
                                        location.reload();
                                    }
                                });
                            }else{
                                modalError(response.msj);
                            }
                        }
                    });
                }
            });
        }
        }
    });

}

function openFlightTime() {
    $('.flighttime_modal').click(function (e) {
        e.preventDefault();
        //console.log("dsfdf");
        var id_vuelo_detalle = $(this).attr('data-id-detalle');
        var id_vuelo_cabecera = $(this).attr('data-vuelo-cabecera');
        var fecha_vuelo = $(this).attr('data-fecha-vuelo');
        var matricula = $(this).attr('data-matricula');
        var nro_vuelo = $(this).attr("data-nro-vuelo");
        var ruta = $(this).attr('data-ruta');
        var flag_horas_block = $(this).attr('data-flag_horablock');
        var urlJson = {
            id_vuelo_detalle: id_vuelo_detalle,
            id_vuelo_cabecera: id_vuelo_cabecera,
            fecha_vuelo: fecha_vuelo,
            matricula: matricula,
            nro_vuelo: nro_vuelo,
            ruta: ruta,
            flag_horas_block : flag_horas_block
        };
        $.ajax({
            url: SERVER_NAME + 'horavuelo',
            type: 'post',
            data: urlJson,
            dataType: "json",
            success: function (response) {
                //console.log(response);
                if (response.rpt == 1) {
                    $("#title_modal").text("Agregar Hora de Vuelos");
                    $('#body_dinamicac_modal').html(response.html_hora);
                    if($("#dialogM").hasClass("modal-lg")){
                        $("#dialogM").removeClass("modal-lg");
                        $("#dialogM").addClass("modal-xl");
                    }
                    $('#dinamicModal .select2').each(function () {
                        var container = $(this).parent();
                        $(this).select2({
                            dropdownParent: container
                        });
                    });
                    editRuta();
                    $('#dinamicModal').modal('show');
                    validInput();
                    saveHora();
                }


            }
        });
    });
}


function detectarBorderColor(element) {
    var result = ($('#' + element.id + '').css('border-color') == '#d51f1f') ? true : false;
    return result;
}


function validarFrm()
{

    var error, countError;
    countError = 0;
    error = "El campo resaltado debe ser llenado, por favor revise e intente de nuevo.";

    $("#frm_hora_vuelo").find(':input').each(function () {
        var elemento = this;
        elemento.value = elemento.value.trim();
        //document.getElementById(elemento.id ).style.backgroundColor= "#FFFFFF";
        if (elemento.id != "txt_tiempoVuelo" && elemento.id != "txt_TiempoHorasBlock" && elemento.id !="horas_block") {
            if (elemento.value.length > 0 && elemento.value.length < 4)
            {
               // console.log("error length=>" +elemento.id);
                document.getElementById(elemento.id).style.backgroundColor = "#F9C8C9";
                countError = countError + 1;
            }
            if (validaTiempo(elemento.value))
            {
                //console.log("error validtiempi=>" +elemento.id);
                document.getElementById(elemento.id).style.backgroundColor = "#F9C8C9";
                countError = countError + 1;
            }
        }
        
        
    });

    if (countError > 0)
    {
        modalError(error);
        return false;
    }
    return true;
}

function validarTiempoMayor(){
    var txt_pb = "00:00";
    var error="";
    var countError = 0;
    
    var txt_cp = "00:00";
    if($("#txt_ci_pu").val()!=""){
        var hora = ($("#txt_ci_pu").val().substr(0, 2));
        var minuto = ($("#txt_ci_pu").val().substr(2, 2));
        txt_cp = hora+":"+minuto;
    }
    
    
    if($("#txt_pu_pb").val()!=""){
        var hora =$("#txt_pu_pb").val().substr(0, 2);
        var minuto = $("#txt_pu_pb").val().substr(2, 2);
        
        txt_pb = hora+":"+minuto;
        if(CompararHoras(txt_cp,txt_pb)===0){
            document.getElementById("txt_ci_pu").style.backgroundColor = "#F9C8C9";
            countError = countError + 1;
            error = "El campo P/B debe ser mayor a C/P <br>";
        }
    }
    
    
    
    
    var txt_eng_on = "00:00";
    if($("#txt_eng_on").val()!=""){
        var hora =$("#txt_eng_on").val().substr(0, 2);
        var minuto = $("#txt_eng_on").val().substr(2, 2);
        
        txt_eng_on = hora+":"+minuto;
        if(CompararHoras(txt_pb,txt_eng_on)===0){
            document.getElementById("txt_pu_pb").style.backgroundColor = "#F9C8C9";
            countError += countError + 1;
            error += "El campo ENG ON debe ser mayor a P/B <br>";
        }
    }
    
    
    var txt_take_off = "00:00";
    if($("#txt_take_off").val()!=""){
        var hora =$("#txt_take_off").val().substr(0, 2);
        var minuto = $("#txt_take_off").val().substr(2, 2);
        
        txt_take_off = hora+":"+minuto;
        if(CompararHoras(txt_eng_on,txt_take_off)===0){
            document.getElementById("txt_eng_on").style.backgroundColor = "#F9C8C9";
            countError += countError + 1;
            error += "El campo take Off debe ser mayor a ENG ON <br>";
        }
    }
    
    
    /*************************Hora llegada*******************************/
    
    var txt_arr_in = "00:00";
    if($("#txt_arr_in").val()!=""){
        var hora =$("#txt_arr_in").val().substr(0, 2);
        var minuto = $("#txt_arr_in").val().substr(2, 2);
        
        txt_arr_in = hora+":"+minuto;
    }
    var txt_stop = "00:00";
    if($("#txt_stop").val()!=""){
        var hora =$("#txt_stop").val().substr(0, 2);
        var minuto = $("#txt_stop").val().substr(2, 2);
        
        txt_stop = hora+":"+minuto;
        if(CompararHoras(txt_arr_in,txt_stop)===0){
            document.getElementById("txt_arr_in").style.backgroundColor = "#F9C8C9";
            countError = countError + 1;
            error += "El campo Stop debe ser mayor a Arr-in <br>";
        }
    }
    
    
    
    var txt_AP = "00:00";
    if($("#txt_AP").val()!=""){
        var hora =$("#txt_AP").val().substr(0, 2);
        var minuto = $("#txt_AP").val().substr(2, 2);
        
        txt_AP = hora+":"+minuto;
        if(CompararHoras(txt_stop,txt_AP)===0){
            document.getElementById("txt_stop").style.backgroundColor = "#F9C8C9";
            countError = countError + 1;
            error += "El campo A/P debe ser mayor a Stock <br>";
        }
    }
    
    
    
    if (countError > 0)
    {
        modalError(error);
        return false;
    }
    return true;
}

function validaTiempo(tiempo)
{
    var hora, minuto, rpta;
    rptaError = 0;

    if (tiempo.length == 0)
    {
        tiempo = "0000";
    }

    hora = parseInt(tiempo.substr(0, 2), 10);
    minuto = parseInt(tiempo.substr(2, 2), 10);
    if (!(hora < 24 && minuto < 60))
    {
        rptaError = 1;
    }
    return rptaError;
}

function calculaTiempoVuelo()
{

    var txtTAKE_OFF, txtHoraAirr, horaSalidaIti, minutoSalidaIti, horaLlegadaIti, minutoLlegadaIti, horaRecorrido;
    var miHoraSalida, miHoraLlegada;
    txtTAKE_OFF = $("#txt_take_off").val();
    txtHoraAirr = $("#txt_arr_in").val();
    
    console.log(txtTAKE_OFF+"-"+txtHoraAirr);

    horaSalidaIti = txtTAKE_OFF.substring(0, 2);
    minutoSalidaIti = txtTAKE_OFF.substring(2, 4);

    horaLlegadaIti = txtHoraAirr.substring(0, 2);
    minutoLlegadaIti = txtHoraAirr.substring(2, 4);

    miHoraSalida = new Date("0", "0", "0", horaSalidaIti, minutoSalidaIti, "00");
    miHoraLlegada = new Date("0", "0", "0", horaLlegadaIti, minutoLlegadaIti, "00");

    var diferencia = miHoraLlegada.getTime() - miHoraSalida.getTime();
    var tiempoVuelo = Math.floor(diferencia / (60000));

    var horaminutosVuelo = new Date("0", "0", "0", "00", tiempoVuelo, "00");

    var horaPresenta = horaminutosVuelo.getHours();
    horaPresenta = (horaPresenta <= 9) ? "0" + horaPresenta : horaPresenta;

    var minutoPresenta = horaminutosVuelo.getMinutes();
    minutoPresenta = (minutoPresenta <= 9) ? "0" + minutoPresenta : minutoPresenta;

    $("#txt_tiempoVuelo").val(horaPresenta + "" + minutoPresenta);

}

function CompararHoras(sHora1, sHora2) {
    
    var arHora1 = sHora1.split(":");
    var arHora2 = sHora2.split(":");
    
    // Obtener horas y minutos (hora 1)
    var hh1 = parseInt(arHora1[0],10);
    var mm1 = parseInt(arHora1[1],10);

    // Obtener horas y minutos (hora 2)
    var hh2 = parseInt(arHora2[0],10);
    var mm2 = parseInt(arHora2[1],10);

    // Comparar
    var result =0;
    if (hh1<hh2 || (hh1==hh2 && mm1<mm2))
        result= 1;
    else if (hh1>hh2 || (hh1==hh2 && mm1>mm2))
        result = 0;
    else 
        result = 0;
    
    return result;
} 