
$(document).ready(function () {

    openModalCombustible();
});

function openModalCombustible() {
    $('.combustible_modal').click(function (e) {
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
            url: SERVER_NAME + 'combustible',
            type: 'post',
            data: urlJson,
            dataType: "json",
            success: function (response) {
                //console.log(response);
                if (response.rpt == 1) {
                    $("#title_modal").text("Agregar Combustible");
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
                    /*if($("#edit_ruta").hasClass('col-sm-6')){
                        $("#edit_ruta").removeClass('col-sm-6');
                        $("#edit_ruta").addClass('col-sm-3');
                    }*/
                    editRuta("tri");
                    $('#dinamicModal').modal('show');
                    
                    //validInputEquipaje();

                    //savePasajero();
                }
            }
        });
    });
}


/*function saveEquipaje(){
    
    $("#btnSaveEquipaje").function(function(){
        //var txtTTL=$("#txtTTL").val(); 
        var txtBAGPZS=$("#txtBAGPZS").val(); 
        var txtBAGKGS=$("#txtBAGKGS").val(); 
        var txtBAGBIN=$("#txtBAGBIN").val(); 
        var txtCARPZS=$("#txtCARPZS").val(); 
        var txtCARKGS=$("#txtCARKGS").val(); 
        var txtCARBIN=$("#txtCARBIN").val(); 
        var urlJson = {
            txt_BAGPZS: txtBAGPZS,
            txt_BAGKGS: txtBAGKGS,
            txt_BAGBIN: txtBAGBIN,
            txt_CARPZS: txtCARPZS,
            txt_CARKGS: txtCARKGS,
            txt_CARBIN: txtCARBIN
        };
        $.ajax({
            url: SERVER_NAME + 'equipaje/save',
            type: 'post',
            data: urlJson,
            dataType: "json",
            success: function (response) {
                //console.log(response);
                if (response.rpt == 1) {
                    $("#title_modal").text("Agregar Equipaje");
                    $('#body_dinamicac_modal').html(response.html_hora);

                    $('#dinamicModal').modal('show');
                    validInputEquipaje();
                    validCarga();
                    //savePasajero();
                }
            }
        });
    });
    
}

function validInputEquipaje() {
    $("#content_combustible").find(':input').each(function () {
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
    
}*/
