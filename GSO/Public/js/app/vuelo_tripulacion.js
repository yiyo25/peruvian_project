/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$(document).ready(function () {
   
    openModalTripulacion();
});

function openModalTripulacion(){
    $('.tripulacion_modal').click(function (e) {
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
            fecha_vuelo : fecha_vuelo,
            matricula :matricula,
            nro_vuelo : nro_vuelo,
            ruta : ruta
        };
        $.ajax({
            url: SERVER_NAME+'vuelotripulacion',
            type: 'post',
            data: urlJson,
            success: function (response) {
                $("#title_modal").text("Agregar Tripulación");
                $('#body_dinamicac_modal').html(response);
                agregarTripulacion();
                $('#dinamicModal .select2').each(function () {
                    var container = $(this).parent();
                    $(this).select2({
                        dropdownParent: container
                    });
                });

                functionByTripulation();
                deleteTripulacion(id_vuelo_cabecera);
                checkedInstructor();
                if($("#dialogM").hasClass("modal-xl")){
                    $("#dialogM").removeClass("modal-xl");
                    $("#dialogM").addClass("modal-lg");
                }
                $('#dinamicModal').modal('show');
                
            }
        });
    });
}

function functionByTripulation(){
    $("#tripulacionCabina").select2().on('change',function(event){
        event.preventDefault();
        event.stopImmediatePropagation();
        var id_trip = $('#tripulacionCabina option:selected').val();
        var id_funcion = $('#tripulacionCabina option:selected').attr('data-funcion');
        var id_tipo_tripulacion = $('#tripulacionCabina option:selected').attr('data-idTipoTripulacion');
        var tipoTripulacion="C";
        var urlData = {
            id_funcion:id_funcion, 
            id_tripulacion:id_trip, 
            tipoTripulacion:tipoTripulacion, 
            idTipoTripulacion:id_tipo_tripulacion
        };
        
        $.ajax({
            data: urlData,
            url: SERVER_NAME + 'vuelotripulacion/getFunciones',
            type: 'post',
            dataType: "json",
            success: function (response) {
                if(response.rpt == 1){
                    
                    $("#cbo_functionCabina").html(response.html_cbo_funciones);
                    $('#dinamicModal .select2').each(function () {
                        var container = $(this).parent();
                        $(this).select2({
                            dropdownParent: container
                        });
                    });
                    
                }
            }
        });
         
    });
}

function agregarTripulacion(){
    $(".btn-agregar-tripulacion").click(function(e){
        e.preventDefault();
        e.stopImmediatePropagation();
        var tipo_tripulacion = $(this).attr('tipo_tripulacion');

        
        var id_vuelo_cabecera = $("#id_vuelo_cabecera").val();
        var id_tripulacion = '';
        var id_funcion = '';
        var tipo_tripulacion = '';
        if($(this).attr('tipo_tripulacion') === "cabina"){
            
             id_vuelo_cabecera = $("#id_vuelo_cabecera").val();
             id_tripulacion = $("#tripulacionCabina").val();
             id_funcion = $('#funcion_tt').val();
             tipo_tripulacion = "C";
            
        }else if($(this).attr('tipo_tripulacion') === "servicio"){
            
             id_vuelo_cabecera = $("#id_vuelo_cabecera").val();
             id_tripulacion = $("#tp_servicio").val();
             id_funcion = $('#function_serv').val();
             tipo_tripulacion = "S";
            
        }else if($(this).attr('tipo_tripulacion') === "practicante"){
            id_vuelo_cabecera = $("#id_vuelo_cabecera").val();
             id_tripulacion = $("#tripulacion_pp").val();
             id_funcion = $('#funccion_tt_pp').val();
             tipo_tripulacion = "P";
        }
        
        if( id_funcion == "0" || id_tripulacion=="0"){
            swal({
                icon: 'error',
                title: 'Ocurrio un problema!!',
                text: 'selecione una funcion y un tripulante',
                dangerMode: true
            });

        }else{
            //console.log("error");
            ajaxAddTripulacion(id_vuelo_cabecera,id_tripulacion,id_funcion,tipo_tripulacion);

        }
       
        console.log(id_vuelo_cabecera+" "+id_tripulacion+" "+id_funcion);
        
        
    });
}

function ajaxAddTripulacion(id_vuelo_cabecera,id_tripulacion,id_funcion,tipo_tripulacion){
    var urlData= {
        id_vuelo_cabecera : id_vuelo_cabecera,
        id_tripulacion : id_tripulacion,
        id_funcion : id_funcion,
        tipo_tripulacion: tipo_tripulacion
    };
    $.ajax({
        data: urlData,
        url: SERVER_NAME + 'vuelotripulacion/addTripulacion',
        type: 'post',
        dataType: "json",
        success: function (response) {
            if(response.rpt == 1){
                
                if(tipo_tripulacion=="C"){
                    $("#table_tripulacion-cabina").html(response.html_vuelo_tripulacion);
                }else if(tipo_tripulacion=="S"){
                    $("#table_tripulacion_servicio").html(response.html_vuelo_tripulacion);
                }else if(tipo_tripulacion=="P"){
                    $("#table_tripulacion_practicante").html(response.html_vuelo_tripulacion);
                }
               deleteTripulacion(id_vuelo_cabecera);
               checkedInstructor();
                
            }else{
                modalError(response.msg_error);
            }
        }
    });
}

function checkedInstructor(){
    $(".chkInstructor").click(function(e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        var id_vuelo_tripulante = $(this).attr('data-id-vt');
        var id_vuelo_cabecera = $(this).attr('data-id-vuelo-cabecera');
        if(this.checked) {
            var nombre = $(this).attr('data-nombre');
            swal({
                icon: 'warning',
                title: 'Asignar Instructor',
                text: "Esta seguro de asiganar al plito "+nombre+" como instructor",
                buttons: true,
                dangerMode: true
            }).then((willDelete) => {
                if (willDelete) {
                    var urlData = {
                        id_vuelo_cabecera:id_vuelo_cabecera,
                        id_vuelo_tripulacion:id_vuelo_tripulante,
                        tipo_tripulacion :'C'
                    };
                    $.ajax({
                        url: SERVER_NAME+'vuelotripulacion/asignarInstructor',
                        data:urlData,
                        type: 'post',
                        dataType: "json",
                        success: function(dataJson){
                          if(dataJson.rpt === 1){
                            $("#table_tripulacion-cabina").html(dataJson.html_vuelo_tripulacion);
                            checkedInstructor();
                            deleteTripulacion(id_vuelo_cabecera);
                            swal("Instructor agregado correctamente", {
                              icon: "success"
                            });
                          }

                        }
                    });
                }else {
                 $('input:checkbox').each(function() { this.checked = false; });
                }
          });
           
        }
             
    });
}

function deleteTripulacion(id_vuelo_cabecera){
    $(".deleteTripulacion").click(function(e){
        e.preventDefault();
        e.stopImmediatePropagation();
        var id_vuelo_tripulacion = $(this).attr('data-id');
        var tipo_tripulacion = $(this).attr('data-tipoTripulacion');
        $.ajax({
            data: {id_vuelo_tripulacion:id_vuelo_tripulacion,id_vuelo_cabecera:id_vuelo_cabecera,tipo_tripulacion:tipo_tripulacion},
            url: SERVER_NAME + 'vuelotripulacion/deleteVueloTripulacion',
            type: 'post',
            dataType: "json",
            success: function (response) {
                if(response.rpt == 1){
                    if(tipo_tripulacion=="C"){
                        $("#table_tripulacion-cabina").html(response.html_vuelo_tripulacion);
                    }else if(tipo_tripulacion=="S"){
                        $("#table_tripulacion_servicio").html(response.html_vuelo_tripulacion);
                    }else if(tipo_tripulacion=="P"){
                        $("#table_tripulacion_practicante").html(response.html_vuelo_tripulacion);
                    }
                    deleteTripulacion(id_vuelo_cabecera);
                    checkedInstructor();
                }else{
                    modalError(response.msg_error);
                }
            }
        });
    });
    
}

