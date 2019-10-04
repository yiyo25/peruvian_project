
$(document).ready(function () {

    openModalEquipaje();
});

function openModalEquipaje() {
    $('.equipaje_modal').click(function (e) {
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
            url: SERVER_NAME + 'equipaje',
            type: 'post',
            data: urlJson,
            dataType: "json",
            success: function (response) {
                //console.log(response);
                if (response.rpt == 1) {
                    $("#title_modal").text("Agregar Equipaje");
                    $('#body_dinamicac_modal').html(response.html_hora);
                    if($("#dialogM").hasClass("modal-xl")){
                        $("#dialogM").removeClass("modal-xl");
                        $("#dialogM").addClass("modal-lg");
                    }
                    $('#dinamicModal .select2').each(function () {
                        var container = $(this).parent();
                        $(this).select2({
                            dropdownParent: container
                        });
                    });

                    editRuta("tri");
                    $('#dinamicModal').modal('show');
                    validInputEquipaje();
                    saveEquipaje();
                }else{
                    modalError(response.msg_error);
                }
            }
        });
    });
}




function saveEquipaje(){
    
    $("#btnSaveEquipaje").click(function(){
        //var txtTTL=$("#txtTTL").val(); 
        var txtBAGPZS=$("#txtBAGPZS").val(); 
        var txtBAGKGS=$("#txtBAGKGS").val(); 
        var txtBAGBIN=$("#txtBAGBIN").val(); 
        var txtCARPZS=$("#txtCARPZS").val(); 
        var txtCARKGS=$("#txtCARKGS").val(); 
        var txtCARBIN=$("#txtCARBIN").val(); 
        var id_vuelo_detalle = $("#id_vuelo_detalle").val();
        var urlJson = {
            id_vuelo_detalle    : id_vuelo_detalle,
            txt_BAGPZS          : txtBAGPZS,
            txt_BAGKGS          : txtBAGKGS,
            txt_BAGBIN          : txtBAGBIN,
            txt_CARPZS          : txtCARPZS,
            txt_CARKGS          : txtCARKGS,
            txt_CARBIN          : txtCARBIN
        };
        
        
        
        swal({
            icon: 'warning',
            title: 'Registrar Equipaje',
            text: "Esta seguro de registrar el equipaje",
            buttons: true,
            dangerMode: true
        }).then((willDelete) => {
            if (willDelete) {
                $.ajax({
                    url: SERVER_NAME + 'equipaje/save',
                    type: 'post',
                    data: urlJson,
                    dataType: "json",
                    success: function (response) {
                        console.log(response);
                        if (response.rpt == 1) {
                            $('#dinamicModal').modal('hide');
                            swal("Horario Guardado Correctamente", {
                                icon: "success"
                            }).then((willDelete) => {
                                if (willDelete) {
                                    location.reload();
                                }
                            });
                        }else{
                            var error=response.msj+"<br>";
                            
                            response.error.forEach( function(valor, indice) {
                                error+="El campo <b>"+valor['input']+"</b> "+valor["msg_error"]+"<br>";
                            });
                            modalError(error);
                            validInputEquipaje();
                        }
                    }
                });
            }
        });
    });
    
}

function validInputEquipaje() {
    $("#frm_equipaje").find(':input').each(function () {
        var elemento = this;
        if(elemento.id!="txtBAGBIN" && elemento.id != "txtCARBIN") {
            $("#" + elemento.id + "").keypress(function (element) {
                if(elemento.id=="txtBAGPZS" || elemento.id=="txtCARPZS"){
                    soloNumeros(element);
                }else{
                    soloNumerosandDecimal(element);
                }
                
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
        }else{
             $("#" + elemento.id + "").keypress(function (element) {
                soloNumerosBIN(element);
            });
        }
        
        $("#" + elemento.id + "").focus(function () {
            if( $(this).val()=="0" ){
                $(this).val("");
            } 
        });
    });
    
}

function soloNumerosBIN(evt)
{
        if(window.event){ keynum = evt.keyCode; }
        else{ keynum = evt.which; }

        //if( (keynum>43 && keynum<58) && (keynum!=47) && (keynum!=45)  ){return true;}
        if( (keynum>43 && keynum<58) && (keynum!=47) ){return true;}
        else{return false;}
}
