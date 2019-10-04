
$(document).ready(function () {

    openModalPasajeros();
});

function openModalPasajeros() {
    $('.pasajero_modal').click(function (e) {
        e.preventDefault();
        //console.log("dsfdf");
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
            url: SERVER_NAME + 'pasajero',
            type: 'post',
            data: urlJson,
            dataType: "json",
            success: function (response) {
                //console.log(response);
                if (response.rpt == 1) {
                    $("#title_modal").text("Agregar Pasajeros");
                    $('#body_dinamicac_modal').html(response.html_hora);
                    $("#dialogM").removeClass("modal-lg");
                    $("#dialogM").addClass("modal-xl");
                    $('#dinamicModal .select2').each(function () {
                        var container = $(this).parent();
                        $(this).select2({
                            dropdownParent: container
                        });
                    });
                    editRuta();
                    $('#dinamicModal').modal('show');
                    validInputPasajero();
                    savePasajero();
                    
                }else{
                    modalError(response.msg_error);
                }
            }
        });
    });
}

function savePasajero(){
    
    $("#btnSavePasajero").click(function(e){
        e.preventDefault();
        var id_vuelo_detalle = $("#id_vuelo_detalle").val();
        var txt_nro_adultos = $("#txt_nro_adulto").val();
        var txt_nro_menores = $("#txt_nro_menores").val();
        var txt_nro_infantes = $("#txt_nro_infantes").val();
        var txt_nro_nr= $("#txt_nro_nr").val();
        var txt_total = $("#txt_total").val();
        var urlJson = {
            id_vuelo_detalle : id_vuelo_detalle,
            txt_nro_adultos : txt_nro_adultos,
            txt_nro_menores : txt_nro_menores,
            txt_nro_infantes : txt_nro_infantes,
            txt_nro_nr : txt_nro_nr,
            txt_total : txt_total
        };
        swal({
            icon: 'warning',
            title: 'Registrar Pasajero',
            text: "Esta seguro de registrar los pasajeros",
            buttons: true,
            dangerMode: true
        }).then((willDelete) => {
            if (willDelete) {
                $.ajax({
                    url: SERVER_NAME + 'pasajero/savePasajero',
                    type: 'post',
                    data: urlJson,
                    dataType: "json",
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
                        }else{
                            var error=response.msj+"<br>";
                            
                            response.error.forEach( function(valor, indice) {
                                error+="El campo <b>"+valor['input']+"</b> debe ser Numérico"+"<br>";
                            });
                            modalError(error);
                        }
                    }
                });
            }
        });
    });
    
   
}

function validInputPasajero() {
    $("#frm_vuelo_pasajero").find(':input').each(function () {
        var elemento = this;
        $("#" + elemento.id + "").keypress(function (element) {
            soloNumeros(element);
            if ($("#" + elemento.id + "").hasClass('error-input')) {
                $("#" + elemento.id + "").removeClass('error-input');
            }
        });

       $("#" + elemento.id + "").blur(function () {
            validarSiNumero(elemento);
            if($(this).val()==="" ){
                $(this).val(0);
            }
        });
        
        $("#" + elemento.id + "").focus(function () {
            if( $(this).val()=="0" ){
                $(this).val("");
            } 
        });
    });
}



function sumarPasajeros()
{
    var adultos, menores, infantes, nr;
    if($("#txt_nro_adulto").val()===""){
        $("#txt_nro_adulto").val(0);
    }
    if($("#txt_nro_menores").val()===""){
        $("#txt_nro_menores").val(0);
    }
    if($("#txt_nro_infantes").val()===""){
        $("#txt_nro_infantes").val(0);
    }
    adultos = parseInt($("#txt_nro_adulto").val());
    menores = parseInt($("#txt_nro_menores").val());
    infantes = parseInt($("#txt_nro_infantes").val());
    nr = parseInt($("#txt_nro_nr").val());
    
    $("#txt_total").val(adultos + menores + infantes);

}


