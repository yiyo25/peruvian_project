$(function () {
    var d = new Date();
    var dia = d.getDate();
    var mes = (d.getMonth()+1);
    var anio = d.getFullYear();
    var anio_min = (d.getFullYear()-18);
    var strDate = d.getFullYear() + "/" + (d.getMonth()+1) + "/" + d.getDate();
    var strDate_2 = (d.getMonth()+1) + "/" + d.getDate() + "/" + d.getFullYear();
    
    $(".numberEntero").keydown(function (e) {
        // Permite: backspace, delete, tab, escape, enter and .
        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 190]) !== -1 ||
            // Permite: Ctrl+A
            (e.keyCode == 65 && e.ctrlKey === true) ||
            // Permite: home, end, left, right
            (e.keyCode >= 35 && e.keyCode <= 39)) {
            // solo permitir lo que no este dentro de estas condiciones es un return false
            return;
        }
        // Aseguramos que son numeros
        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
            e.preventDefault();
        }
    });
    
    $.each($(".numberDecimal"),function (index,value){
        //console.log(index + ':' + $(value).val());
        $(value).on('keypress', function (e) {
        var field = $(this);
        key = e.keyCode ? e.keyCode : e.which;
		if (key == 8  || (key >= 35 && key <= 39) || ($.inArray(key, [46, 8, 9, 27, 13, 110, 190]) !== -1)){
            return true;
        }
		if (key > 47 && key < 58) {
		  if (field.val() === "") return true;
		      var existePto = (/[.]/).test(field.val());
		          if (existePto === false){
		              regexp = /.[1-9]{9}$/;
		          }
		          else {
		              regexp = /.[0-9]{2}$/;
                      ///^\d+(?:\.\d{0,2})$/
		          }
		          return !(regexp.test(field.val()));
		        }
		        if (key == 46) {
		          if (field.val() === "") return false;
		          regexp = /^[0-9]+$/;
		          return regexp.test(field.val());
		        }
		        return false;
	    	});
    });
    
    $('.myDataTables').DataTable({
        "oLanguage": {"sUrl": "//cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json"},
        "searching": false,
        "pagingType": "full_numbers",
        "bInfo" : false,
        "dom": 'Bfrtip',
        "buttons": [
            'copyHtml5',
            'excelHtml5',
            'csvHtml5',
            'pdfHtml5',
            'print'
        ],
        "columnDefs": [
            {"className": "dt-center", "targets": "_all"}
        ],
    });
    
    $('.myDataTables_sinPaginacion').DataTable({
        "oLanguage": {"sUrl": "//cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json"},
        "searching": false,
        "pagingType": "full_numbers",
        "paging": false,
        "bInfo" : false,
        //"dom": 'Bfrtip',
        "scrollCollapse": true,
        "columnDefs": [
            { "width": "20%", "targets": 0 }
          ],
        "buttons": [
            'copyHtml5',
            'excelHtml5',
            'csvHtml5',
            'pdfHtml5',
            'print'
        ]
    });
    
    $('.myDataTables_sinPaginacionBusqueda').DataTable({
        "oLanguage": {"sUrl": "//cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json"},
        /*"fixedHeader" : {
            header : true
        },*/
        "scrollY": '80vh',
        "searching": false,
        "pagingType": "full_numbers",
        "paging": false,
        "bInfo" : false,
        "searching": true,
        /*"dom": 'Bfrtip',
        "buttons": [
            'copyHtml5',
            'excelHtml5',
            'csvHtml5',
            'pdfHtml5',
            'print'
        ],*/
        scrollX: true,
        scrollCollapse: true,
        fixedColumns:   {
            leftColumns: 3//Le indico que deje fijas solo las 2 primeras columnas
        },
        //order: [[ 1, "asc" ]]
    });
    
    $('.datetimepicker').datetimepicker({
        format: 'DD/MM/YYYY',
        minDate: new Date(1900,1-1,1)
    });
    
    $('.datetimepicker1').datetimepicker({
        format: 'DD/MM/YYYY',
        minDate: new Date()
    });
    
    $('.datetimepicker2').datetimepicker({
        //format: 'LT',
        format: 'HH:mm'
    });
});

function conversor_segundos(seg_ini) {
    var horas = Math.floor(seg_ini/3600);
    var minutos = Math.floor((seg_ini-(horas*3600))/60);
    var segundos = Math.round(seg_ini-(horas*3600)-(minutos*60));
    return (horas + ":" + pad(minutos, 2));
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
    if (hh1<hh2 || (hh1==hh2 && mm1<mm2))
        //return "sHora1 MENOR sHora2";
        return false;
    else if (hh1>hh2 || (hh1==hh2 && mm1>mm2))
        //return "sHora1 MAYOR sHora2";
        return true;
    else 
        //return "sHora1 IGUAL sHora2";
        return false;
}

function pad(n, width, z) {
  z = z || '0';
  n = n + '';
  return n.length >= width ? n : new Array(width - n.length + 1).join(z) + n;
}

function myDataTables(myTabla){
    $('#' + myTabla).DataTable({
        "oLanguage": {"sUrl": "//cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json"},
        "searching": false,
        "pagingType": "full_numbers",
        "bInfo" : false,
        "dom": 'Bfrtip',
        "buttons": [
            'copyHtml5',
            'excelHtml5',
            'csvHtml5',
            'pdfHtml5',
            'print'
        ]
    });
}

function myDataTables_sinPaginacion(myTabla){
    $('#' + myTabla).DataTable({
        "oLanguage": {"sUrl": "//cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json"},
        "searching": false,
        "pagingType": "full_numbers",
        "paging": false,
        "bInfo" : false,
        //"dom": 'Bfrtip',
        "scrollCollapse": true,
        "buttons": [
            'copyHtml5',
            'excelHtml5',
            'csvHtml5',
            'pdfHtml5',
            'print'
        ]
    });
}

function myDataTables_sinPaginacionBusqueda(myTabla){
    $('#' + myTabla).DataTable({
        "oLanguage": {"sUrl": "//cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json"},
        /*"fixedHeader" : {
            header : true
        },*/
        "scrollY": '80vh',
        "searching": false,
        "pagingType": "full_numbers",
        "paging": false,
        "bInfo" : false,
        "searching": true,
        /*"dom": 'Bfrtip',
        "buttons": [
            'copyHtml5',
            'excelHtml5',
            'csvHtml5',
            'pdfHtml5',
            'print'
        ],*/
        scrollX: true,
        scrollCollapse: true,
        fixedColumns:   {
            leftColumns: 3//Le indico que deje fijas solo las 2 primeras columnas
        },
    });
}

/*--------------------------------- Para Avion ---------------------------------*/
function validate_formAvion(){
    var error = 0;
    error += validate_input6();
    //error += validate_input5();
    error += validate_input4();
    error += validate_input3();
    error += validate_input2();
    
    if(error > 0) return false;
	else return true;
}

function limpiarFormAvion(){
    $("#titleForm").text("Ingresar Nuevo Avión");
    $("#TIPAVI_id").val("").trigger('change.select2');
    $("#AVI_num_cola").val("");
    $("#AVI_cant_pasajeros").val("");
    $("#AVI_cap_carga_max").val("");
    $("#AVI_estado").val("1").trigger('change.select2');
    $("#AUD_usu_cre").val("");
    $("#AUD_fch_cre").val("");
    $("#AUD_usu_mod").val("");
    $("#AUD_fch_mod").val("");
    
    $("#TIPAVI_id").css("background", "#FFF");
    $("#AVI_num_cola").css("background", "#FFF");
    $("#AVI_cant_pasajeros").css("background", "#FFF");
    $("#AVI_cap_carga_max").css("background", "#FFF");
    $("#AVI_estado").css("background", "#FFF");
    
    $("#divAUD_usu_cre").css("display","none");
    $("#divAUD_fch_cre").css("display","none");
    $("#divAUD_usu_mod").css("display","none");
    $("#divAUD_fch_mod").css("display","none");
    
    $("#TIPAVI_id").removeAttr("disabled");
    $("#AVI_num_cola").removeAttr("disabled");
    $("#AVI_cant_pasajeros").removeAttr("disabled");
    $("#AVI_cap_carga_max").removeAttr("disabled");
    $("#AVI_estado").removeAttr("disabled");
    
    $("#insertAvion").show();
}

function verFormAvion(){
    $("#titleForm").text("Detalle de Avión");
    
    $("#divAUD_usu_cre").css("display","block");
    $("#divAUD_fch_cre").css("display","block");
    $("#divAUD_usu_mod").css("display","block");
    $("#divAUD_fch_mod").css("display","block");

    $("#TIPAVI_id").prop("disabled","disabled");
    $("#AVI_num_cola").prop("disabled","disabled");
    $("#AVI_cant_pasajeros").prop("disabled","disabled");
    $("#AVI_cap_carga_max").prop("disabled","disabled");
    $("#AVI_estado").prop("disabled","disabled");
    $("#AUD_usu_cre").prop("disabled","disabled");
    $("#AUD_fch_cre").prop("disabled","disabled");
    $("#AUD_usu_mod").prop("disabled","disabled");
    $("#AUD_fch_mod").prop("disabled","disabled");
    
    $("#TIPAVI_id").css("background", "#EEEEEE");
    $("#AVI_num_cola").css("background", "#EEEEEE");
    $("#AVI_cant_pasajeros").css("background", "#EEEEEE");
    $("#AVI_cap_carga_max").css("background", "#EEEEEE");
    $("#AVI_estado").css("background", "#EEEEEE");
    
    $("#insertAvion").hide();
}

/*--------------------------------- Para Manto de Avion ---------------------------------*/
function validate_formMantoAvion(){
    var error = 0;
    error += validate_input53();
    error += validate_input54();
    error += validate_input55();
    error += validate_input61();
    error += validate_input62();
    
    if(error > 0) return false;
	else return true;
}

function limpiarFormMantoAvion(){
    $("#titleForm").text("Ingresar Nuevo Manto Avión");
    
    $("#AVI_id").val("").trigger('change.select2');
    $("#TIPAVI_id").val("").trigger('change.select2');
    $("#MANTAVI_fchini").val("");
    $("#MANTAVI_fchfin").val("");
    $("#MANTAVI_tipoChequeo").val("");
    $("#MANTAVI_ordenTrabajo").val("");
    $("#MANTAVI_observacion").val("");
    
    $("#AUD_usu_cre").val("");
    $("#AUD_fch_cre").val("");
    $("#AUD_usu_mod").val("");
    $("#AUD_fch_mod").val("");
    
    $("#TIPAVI_id").css("background", "#FFF");
    $("#AVI_id").css("background", "#FFF");
    $("#MANTAVI_fchini").css("background", "#FFF");
    $("#MANTAVI_fchfin").css("background", "#FFF");
    $("#MANTAVI_tipoChequeo").css("background", "#FFF");
    $("#MANTAVI_ordenTrabajo").css("background", "#FFF");
    $("#MANTAVI_observacion").css("background", "#FFF");
    
    $("#divAUD_usu_cre").css("display","none");
    $("#divAUD_fch_cre").css("display","none");
    $("#divAUD_usu_mod").css("display","none");
    $("#divAUD_fch_mod").css("display","none");
    
    $("#TIPAVI_id").removeAttr("disabled");
    $("#AVI_id").removeAttr("disabled");
    $("#MANTAVI_fchini").removeAttr("disabled");
    $("#MANTAVI_tipoChequeo").removeAttr("disabled");
    $("#MANTAVI_ordenTrabajo").removeAttr("disabled");
    $("#MANTAVI_observacion").removeAttr("disabled");
    
    $("#MANTAVI_fchfin").prop("disabled","disabled");
    $("#MANTAVI_fchfin").css("background", "#EEEEEE");
    
    $("#insertMantoAvion").show();
}

function verFormMantoAvion(){
    $("#titleForm").text("Detalle Manto de Avión");
    
    $("#divAUD_usu_cre").css("display","block");
    $("#divAUD_fch_cre").css("display","block");
    $("#divAUD_usu_mod").css("display","block");
    $("#divAUD_fch_mod").css("display","block");

    $("#TIPAVI_id").prop("disabled","disabled");
    $("#AVI_id").prop("disabled","disabled");
    $("#MANTAVI_fchini").prop("disabled","disabled");
    $("#MANTAVI_fchfin").prop("disabled","disabled");
    $("#MANTAVI_tipoChequeo").prop("disabled","disabled");
    $("#MANTAVI_ordenTrabajo").prop("disabled","disabled");
    $("#MANTAVI_observacion").prop("disabled","disabled");
    
    $("#AUD_usu_cre").prop("disabled","disabled");
    $("#AUD_fch_cre").prop("disabled","disabled");
    $("#AUD_usu_mod").prop("disabled","disabled");
    $("#AUD_fch_mod").prop("disabled","disabled");
    
    $("#TIPAVI_id").css("background", "#EEEEEE");
    $("#AVI_id").css("background", "#EEEEEE");
    $("#MANTAVI_fchini").css("background", "#EEEEEE");
    $("#MANTAVI_fchfin").css("background", "#EEEEEE");
    $("#MANTAVI_tipoChequeo").css("background", "#EEEEEE");
    $("#MANTAVI_ordenTrabajo").css("background", "#EEEEEE");
    $("#MANTAVI_observacion").css("background", "#EEEEEE");
    
    $("#insertMantoAvion").hide();
}

/*--------------------------------- Para Tripulante ---------------------------------*/
function validate_formTripulante(variable){
    var error = 0;
    error += validate_input7();
    error += validate_input8();
    error += validate_input9();
    error += validate_input10();
    error += validate_input11();
    error += validate_input12();
    error += validate_input13();
    error += validate_input14();
    error += validate_input15();
    error += validate_input16();
    error += validate_input17();
    error += validate_input56();
    error += validate_input57();
    error += validate_input60();
    error += validate_correo($("#TRIP_correo"));
    error += calcularEdad($("#TRIP_fechnac"));
    
    if(variable == 'Vuelo'){
        error += validate_input18();
    }
    error += validate_input19();
    
    if(error > 0) return false;
	else return true;
}

function limpiarFormTripulante(variable){
    $("#titleForm").text("Ingresar Nuevo Tripulante");
    
    $("#TRIP_nombre").val("");
    $("#TRIP_apellido").val("");
    $("#TRIP_correo").val("");
    $("#TRIP_fechnac").val("");
    $("#idDepa").val("").trigger('change.select2');
    $("#idProv").val("").trigger('change.select2');
    $("#idDist").val("").trigger('change.select2');
    $("#TRIP_domilicio").val("");
    $("#TIPTRIPDET_id").val("").trigger('change.select2');
    $("#TRIP_Instructor_Si").val("").trigger('change.select2');
    $("#TRIP_Instructor_No").val("").trigger('change.select2');
    $("#TIPLIC_id").val("").trigger('change.select2');
    $("#TRIP_numlicencia").val("");
    $("#TRIP_DGAC").val("");
    $("#NIVING_id").val("").trigger('change.select2');
    if(variable == 'Vuelo'){
        $("#CAT_id").val("").trigger('change.select2');
    }
    $("#TRIP_estado").val("1").trigger('change.select2');
    
    $("#AUD_usu_cre").val("");
    $("#AUD_fch_cre").val("");
    $("#AUD_usu_mod").val("");
    $("#AUD_fch_mod").val("");
    
    $("#TRIP_nombre").css("background", "#FFF");
    $("#TRIP_apellido").css("background", "#FFF");
    $("#TRIP_correo").css("background", "#FFF");
    $("#TRIP_fechnac").css("background", "#FFF");
    $("#idDepa").css("background", "#FFF");
    $("#idProv").css("background", "#FFF");
    $("#idDist").css("background", "#FFF");
    $("#TRIP_domilicio").css("background", "#FFF");
    $("#TIPTRIPDET_id").css("background", "#FFF");
    $("#TRIP_Instructor_Si").css("background", "#FFF");
    $("#TRIP_Instructor_No").css("background", "#FFF");
    $("#TIPLIC_id").css("background", "#FFF");
    $("#TRIP_numlicencia").css("background", "#FFF");
    $("#TRIP_DGAC").css("background", "#FFF");
    $("#NIVING_id").css("background", "#FFF");
    if(variable == 'Vuelo'){
        $("#CAT_id").css("background", "#FFF");
    }
    $("#TRIP_estado").css("background", "#FFF");
    
    $("#divAUD_usu_cre").css("display","none");
    $("#divAUD_fch_cre").css("display","none");
    $("#divAUD_usu_mod").css("display","none");
    $("#divAUD_fch_mod").css("display","none");
    
    $("#TRIP_nombre").removeAttr("disabled");
    $("#TRIP_apellido").removeAttr("disabled");
    $("#TRIP_correo").removeAttr("disabled");
    $("#TRIP_fechnac").removeAttr("disabled");
    $("#idDepa").removeAttr("disabled");
    $("#idProv").removeAttr("disabled");
    $("#idDist").removeAttr("disabled");
    $("#TRIP_domilicio").removeAttr("disabled");
    $("#TIPTRIPDET_id").removeAttr("disabled");
    $("#TRIP_Instructor_Si").removeAttr("disabled");
    $("#TRIP_Instructor_No").removeAttr("disabled");
    $("#TIPLIC_id").removeAttr("disabled");
    $("#TRIP_numlicencia").removeAttr("disabled");
    $("#TRIP_DGAC").removeAttr("disabled");
    $("#NIVING_id").removeAttr("disabled");
    if(variable == 'Vuelo'){
        $("#CAT_id").removeAttr("disabled");
    }
    $("#TRIP_estado").removeAttr("disabled");
    
    $("#insertTripulante").show();
}

function verFormTripulante(variable){
    $("#titleForm").text("Detalle de Tripulante");
    
    $("#divAUD_usu_cre").css("display","block");
    $("#divAUD_fch_cre").css("display","block");
    $("#divAUD_usu_mod").css("display","block");
    $("#divAUD_fch_mod").css("display","block");
    
    $("#TRIP_nombre").prop("disabled","disabled");
    $("#TRIP_apellido").prop("disabled","disabled");
    $("#TRIP_correo").prop("disabled","disabled");
    $("#TRIP_fechnac").prop("disabled","disabled");
    $("#idDepa").prop("disabled","disabled");
    $("#idProv").prop("disabled","disabled");
    $("#idDist").prop("disabled","disabled");
    $("#TRIP_domilicio").prop("disabled","disabled");
    $("#TIPTRIPDET_id").prop("disabled","disabled");
    $("#TRIP_Instructor_Si").prop("disabled","disabled");
    $("#TRIP_Instructor_No").prop("disabled","disabled");
    $("#TIPLIC_id").prop("disabled","disabled");
    $("#TRIP_numlicencia").prop("disabled","disabled");
    $("#TRIP_DGAC").prop("disabled","disabled");
    $("#NIVING_id").prop("disabled","disabled");
    if(variable == 'Vuelo'){
        $("#CAT_id").prop("disabled","disabled");
    }
    $("#TRIP_estado").prop("disabled","disabled");
    
    $("#AUD_usu_cre").prop("disabled","disabled");
    $("#AUD_fch_cre").prop("disabled","disabled");
    $("#AUD_usu_mod").prop("disabled","disabled");
    $("#AUD_fch_mod").prop("disabled","disabled");
    
    $("#TRIP_nombre").css("background", "#EEEEEE");
    $("#TRIP_apellido").css("background", "#EEEEEE");
    $("#TRIP_correo").css("background", "#EEEEEE");
    $("#TRIP_fechnac").css("background", "#EEEEEE");
    $("#idDepa").css("background", "#EEEEEE");
    $("#idProv").css("background", "#EEEEEE");
    $("#idDist").css("background", "#EEEEEE");
    $("#TRIP_domilicio").css("background", "#EEEEEE");
    $("#TIPTRIPDET_id").css("background", "#EEEEEE");
    $("#TRIP_Instructor_Si").css("background", "#EEEEEE");
    $("#TRIP_Instructor_No").css("background", "#EEEEEE");
    $("#TIPLIC_id").css("background", "#EEEEEE");
    $("#TRIP_numlicencia").css("background", "#EEEEEE");
    $("#TRIP_DGAC").css("background", "#EEEEEE");
    $("#NIVING_id").css("background", "#EEEEEE");
    if(variable == 'Vuelo'){
        $("#CAT_id").css("background", "#EEEEEE");
    }
    $("#TRIP_estado").css("background", "#EEEEEE");
    
    $("#insertTripulante").hide();
}

/*--------------------------------- Para Apto ---------------------------------*/
function validate_formApto(){
    var error = 0;
    error += validate_input20();
    error += validate_input21();
    error += validate_input22();
    error += validate_input23();
    //error += validate_input24();
    
    if($("#APT_indicador").val() == "Si"){
       error += validate_input58();
    }
    
    if(error > 0) return false;
	else return true;
}

function limpiarFormApto(){
    $("#titleForm").text("Ingresar Nuevo Apto");
    
    $("#TIPTRIP_id").val("").trigger('change.select2');
    $("#TIPTRIPDET_id").val("").trigger('change.select2');
    $("#TRIP_id").val("").trigger('change.select2');
    $("#APT_fchvenci").val("");
    $("#APT_fchgestion").val("");
    $("#APT_drestantes").val("");
    $("#APT_estado").val("");
    $("#APT_fchentrega").val("");
    $("#APT_observacion").val("");
    
    $("#AUD_usu_cre").val("");
    $("#AUD_fch_cre").val("");
    $("#AUD_usu_mod").val("");
    $("#AUD_fch_mod").val("");
    
    $("#TIPTRIP_id").css("background", "#FFF");
    $("#TIPTRIPDET_id").css("background", "#FFF");
    $("#TRIP_id").css("background", "#FFF");
    $("#APT_fchvenci").css("background", "#FFF");
    $("#APT_fchgestion").css("background", "#FFF");
    $("#APT_estado").css("background", "#FFF");
    $("#APT_fchentrega").css("background", "#FFF");
    $("#APT_observacion").css("background", "#FFF");
    
    $("#divAPT_indicador").css("display","none");
    $("#divAPT_fchentrega").css("display","none");
    $("#divAPT_observacion").css("display","none");
    $("#divAUD_usu_cre").css("display","none");
    $("#divAUD_fch_cre").css("display","none");
    $("#divAUD_usu_mod").css("display","none");
    $("#divAUD_fch_mod").css("display","none");
    
    $("#TIPTRIP_id").removeAttr("disabled");
    $("#TIPTRIPDET_id").removeAttr("disabled");
    $("#TRIP_id").removeAttr("disabled");
    $("#APT_fchvenci").removeAttr("disabled");
    //$("#APT_fchgestion").removeAttr("disabled");
    //$("#APT_fchgestion").prop("disabled","disabled");
    $("#APT_fchgestion").css("background", "#EEEEEE");
    $("#APT_estado").removeAttr("disabled");
    $("#APT_fchentrega").removeAttr("disabled");
    $("#APT_observacion").removeAttr("disabled");
    
    $("#insertApto").show();
}

function verFormApto(){
    $("#titleForm").text("Detalle de Apto");
    
    $("#divAUD_usu_cre").css("display","block");
    $("#divAUD_fch_cre").css("display","block");
    $("#divAUD_usu_mod").css("display","block");
    $("#divAUD_fch_mod").css("display","block");
    $("#divAPT_indicador").css("display","block");
    //$("#divAPT_fchentrega").css("display","block");
    //$("#divAPT_observacion").css("display","block");

    $("#TIPTRIP_id").prop("disabled","disabled");
    $("#TIPTRIPDET_id").prop("disabled","disabled");
    $("#TRIP_id").prop("disabled","disabled");
    $("#APT_fchvenci").prop("disabled","disabled");
    $("#APT_fchgestion").prop("disabled","disabled");
    $("#APT_indicador").prop("disabled","disabled");
    $("#APT_estado").prop("disabled","disabled");
    $("#APT_fchentrega").prop("disabled","disabled");
    $("#APT_observacion").prop("disabled","disabled");
    
    $("#AUD_usu_cre").prop("disabled","disabled");
    $("#AUD_fch_cre").prop("disabled","disabled");
    $("#AUD_usu_mod").prop("disabled","disabled");
    $("#AUD_fch_mod").prop("disabled","disabled");
    
    $("#TIPTRIP_id").css("background", "#EEEEEE");
    $("#TIPTRIPDET_id").css("background", "#EEEEEE");
    $("#TRIP_id").css("background", "#EEEEEE");
    $("#APT_fchvenci").css("background", "#EEEEEE");
    //$("#APT_fchgestion").css("background", "#EEEEEE");
    $("#APT_indicador").css("background", "#EEEEEE");
    $("#APT_estado").css("background", "#EEEEEE");
    $("#APT_fchentrega").css("background", "#EEEEEE");
    $("#APT_observacion").css("background", "#EEEEEE");
    
    $("#insertApto").hide();
}

/*--------------------------------- Para Curso ---------------------------------*/
function validate_formCurso(){
    var error = 0;
    error += validate_input20();
    error += validate_input25();
    error += validate_input26();
    error += validate_input27();
    error += validate_input28();
    error += validate_input29();
    error += validate_input30();
    
    if(error > 0) return false;
	else return true;
}

function validate_formModCurso(){
    var error = 0;
    error += validate_input31();
    error += validate_input32();
    error += validate_input33();
    error += validate_input34();
    error += validate_input35();
    error += validate_input36();
    error += validate_input37();
    
    if(error > 0) return false;
	else return true;
}

function limpiarFormCurso(){
    $("#titleForm").text("Ingresar Nuevo Curso");
    
    $("#TIPCUR_id").val("").trigger('change.select2');
    $("#TIPTRIP_id").val("").trigger('change.select2');
    $("#TRIP_id_i").val("").trigger('change.select2');
    var cantidad = $("#num-alum").val();
    for (var i = 1; i <= cantidad; i++) {
        $("#divAlumno" + i).remove();
    };
    
    $("#num-alum").val("1");
    
    $("#TRIP_id_a1").val("").trigger('change.select2');
    $("#CUR_fchini").val("");
    $("#CUR_fchfin").val("");
    $("#CUR_estado").val("1").trigger('change.select2');
    
    $("#AUD_usu_cre").val("");
    $("#AUD_fch_cre").val("");
    $("#AUD_usu_mod").val("");
    $("#AUD_fch_mod").val("");
    
    $("#TIPCUR_id").css("background", "#FFF");
    $("#TIPTRIP_id").css("background", "#FFF");
    $("#TRIP_id_i").css("background", "#FFF");
    $("#TRIP_id_a1").css("background", "#FFF");
    $("#CUR_fchini").css("background", "#FFF");
    $("#CUR_fchfin").css("background", "#FFF");
    $("#CUR_estado").css("background", "#FFF");
    
    $("#dTIPCUR_id").css("background", "#FFF");
    $("#dTIPTRIP_id").css("background", "#FFF");
    $("#dTRIP_id_i").css("background", "#FFF");
    $("#dTRIP_id_a1").css("background", "#FFF");
    $("#dCUR_fchini").css("background", "#FFF");
    $("#dCUR_fchfin").css("background", "#FFF");
    $("#dCUR_estado").css("background", "#FFF");
    $("#dCUR_fchinforme").css("background", "#FFF");
    
    $("#divCUR_indicador").css("display","none");
    $("#divAUD_usu_cre").css("display","none");
    $("#divAUD_fch_cre").css("display","none");
    $("#divAUD_usu_mod").css("display","none");
    $("#divAUD_fch_mod").css("display","none");
    
    $("#TIPCUR_id").removeAttr("disabled");
    $("#TIPTRIP_id").removeAttr("disabled");
    $("#TRIP_id_i").removeAttr("disabled");
    $("#TRIP_id_a1").removeAttr("disabled");
    $("#CUR_fchini").removeAttr("disabled");
    $("#CUR_estado").removeAttr("disabled");
    //$("#CUR_fchfin").removeAttr("disabled");
    $("#CUR_fchfin").prop("disabled","disabled");
    $("#CUR_fchfin").css("background", "#EEEEEE");
    
    $("#dTIPCUR_id").removeAttr("disabled");
    $("#dTIPTRIP_id").removeAttr("disabled");
    $("#dTRIP_id_i").removeAttr("disabled");
    $("#dTRIP_id_a1").removeAttr("disabled");
    $("#dCUR_fchini").removeAttr("disabled");
    $("#dCUR_estado").removeAttr("disabled");
    $("#dCUR_fchinforme").removeAttr("disabled");
    $("#dCUR_fchfin").removeAttr("disabled");
    /*$("#dCUR_fchfin").prop("disabled","disabled");
    $("#dCUR_fchfin").css("background", "#EEEEEE");*/
    
    $("#insertCurso").show();
}

function verFormCurso(){
    $("#titleForm").text("Detalle de Curso");
    
    $("#divAUD_usu_cre").css("display","block");
    $("#divAUD_fch_cre").css("display","block");
    $("#divAUD_usu_mod").css("display","block");
    $("#divAUD_fch_mod").css("display","block");

    $("#dTIPCUR_id").prop("disabled","disabled");
    $("#dTIPTRIP_id").prop("disabled","disabled");
    $("#dTRIP_id_i").prop("disabled","disabled");
    $("#dTRIP_id_a1").prop("disabled","disabled");
    $("#dCUR_fchini").prop("disabled","disabled");
    $("#dCUR_fchfin").prop("disabled","disabled");
    $("#dCUR_estado").prop("disabled","disabled");
    $("#dCUR_fchinforme").prop("disabled","disabled");
    
    $("#AUD_usu_cre").prop("disabled","disabled");
    $("#AUD_fch_cre").prop("disabled","disabled");
    $("#AUD_usu_mod").prop("disabled","disabled");
    $("#AUD_fch_mod").prop("disabled","disabled");
    
    $("#dTIPCUR_id").css("background", "#EEEEEE");
    $("#dTIPTRIP_id").css("background", "#EEEEEE");
    $("#dTRIP_id_i").css("background", "#EEEEEE");
    $("#dTRIP_id_a1").css("background", "#EEEEEE");
    $("#dCUR_fchini").css("background", "#EEEEEE");
    $("#dCUR_fchfin").css("background", "#EEEEEE");
    $("#dCUR_estado").css("background", "#EEEEEE");
    $("#dCUR_fchinforme").css("background", "#EEEEEE");
    
    $("#insertCurso").hide();
}

/*--------------------------------- Para Chequeo ---------------------------------*/
function validate_formChequeo(){
    var error = 0;
    error += validate_input20();
    error += validate_input21();
    error += validate_input22();
    error += validate_input38();
    error += validate_input39();
    
    if(error > 0) return false;
	else return true;
}

function limpiarFormChequeo(){
    $("#titleForm").text("Ingresar Nuevo Chequeo");
    
    $("#TIPCHEQ_id").val("").trigger('change.select2');
    $("#TIPTRIP_id").val("").trigger('change.select2');
    $("#TIPTRIPDET_id").val("").trigger('change.select2');
    $("#TRIP_id").val("").trigger('change.select2');
    $("#CHEQ_fch").val("");
    $("#CHEQ_estado").val("1").trigger('change.select2');
    $("#CHEQ_fchentrega").val("");
    $("#CHEQ_observacion").val("");
    
    $("#AUD_usu_cre").val("");
    $("#AUD_fch_cre").val("");
    $("#AUD_usu_mod").val("");
    $("#AUD_fch_mod").val("");
    
    $("#TIPCHEQ_id").css("background", "#FFF");
    $("#TIPTRIP_id").css("background", "#FFF");
    $("#TIPTRIPDET_id").css("background", "#FFF");
    $("#TRIP_id").css("background", "#FFF");
    $("#CHEQ_fch").css("background", "#FFF");
    $("#CHEQ_estado").css("background", "#FFF");
    $("#CHEQ_fchentrega").css("background", "#FFF");
    $("#CHEQ_observacion").css("background", "#FFF");
    
    $("#divCHEQ_indicador").css("display","none");
    $("#divCHEQ_fchentrega").css("display","none");
    $("#divCHEQ_observacion").css("display","none");
    $("#divAUD_usu_cre").css("display","none");
    $("#divAUD_fch_cre").css("display","none");
    $("#divAUD_usu_mod").css("display","none");
    $("#divAUD_fch_mod").css("display","none");
    
    $("#TIPCHEQ_id").removeAttr("disabled");
    $("#TIPTRIP_id").removeAttr("disabled");
    $("#TIPTRIPDET_id").removeAttr("disabled");
    $("#TRIP_id").removeAttr("disabled");
    $("#CHEQ_fch").removeAttr("disabled");
    $("#CHEQ_indicador").removeAttr("disabled");
    $("#CHEQ_estado").removeAttr("disabled");
    $("#CHEQ_fchentrega").removeAttr("disabled");
    $("#CHEQ_observacion").removeAttr("disabled");
    
    $("#insertChequeo").show();
}

function verFormChequeo(){
    $("#titleForm").text("Detalle de Chequeo");
    
    $("#divAUD_usu_cre").css("display","block");
    $("#divAUD_fch_cre").css("display","block");
    $("#divAUD_usu_mod").css("display","block");
    $("#divAUD_fch_mod").css("display","block");
    $("#divCHEQ_indicador").css("display","block");

    $("#TIPCHEQ_id").prop("disabled","disabled");
    $("#TIPTRIP_id").prop("disabled","disabled");
    $("#TIPTRIPDET_id").prop("disabled","disabled");
    $("#TRIP_id").prop("disabled","disabled");
    $("#CHEQ_fch").prop("disabled","disabled");
    $("#CHEQ_indicador").prop("disabled","disabled");
    $("#CHEQ_estado").prop("disabled","disabled");
    $("#CHEQ_fchentrega").prop("disabled","disabled");
    $("#CHEQ_observacion").prop("disabled","disabled");
    
    $("#AUD_usu_cre").prop("disabled","disabled");
    $("#AUD_fch_cre").prop("disabled","disabled");
    $("#AUD_usu_mod").prop("disabled","disabled");
    $("#AUD_fch_mod").prop("disabled","disabled");
    
    $("#TIPCHEQ_id").css("background", "#EEEEEE");
    $("#TIPTRIP_id").css("background", "#EEEEEE");
    $("#TIPTRIPDET_id").css("background", "#EEEEEE");
    $("#TRIP_id").css("background", "#EEEEEE");
    $("#CHEQ_fch").css("background", "#EEEEEE");
    $("#CHEQ_indicador").css("background", "#EEEEEE");
    $("#CHEQ_estado").css("background", "#EEEEEE");
    $("#CHEQ_fchentrega").css("background", "#EEEEEE");
    $("#CHEQ_observacion").css("background", "#EEEEEE");
    
    $("#insertChequeo").hide();
}

/*--------------------------------- Para Simulador ---------------------------------*/
function validate_formSimulador(){
    var error = 0;
    error += validate_input20();
    error += validate_input21();
    error += validate_input22();
    error += validate_input40();
    error += validate_input41();
    
    if(error > 0) return false;
	else return true;
}

function limpiarFormSimulador(){
    $("#titleForm").text("Ingresar Nuevo Simulador");
    
    $("#TIPTRIP_id").val("").trigger('change.select2');
    $("#TIPTRIPDET_id").val("").trigger('change.select2');
    $("#TRIP_id").val("").trigger('change.select2');
    $("#TIPTRIP_id2").val("").trigger('change.select2');
    $("#TIPTRIPDET_id2").val("").trigger('change.select2');
    $("#TRIP_id2").val("").trigger('change.select2');
    $("#SIMU_estado").val("1").trigger('change.select2');
    $("#SIMU_fchini").val("");
    $("#SIMU_fchfin").val("");
    $("#SIMU_fchentrega").val("");
    $("#SIMU_observacion").val("");
    
    $("#AUD_usu_cre").val("");
    $("#AUD_fch_cre").val("");
    $("#AUD_usu_mod").val("");
    $("#AUD_fch_mod").val("");
    
    $("#TIPTRIP_id").css("background", "#FFF");
    $("#TIPTRIPDET_id").css("background", "#FFF");
    $("#TRIP_id").css("background", "#FFF");
    $("#TIPTRIP_id2").css("background", "#FFF");
    $("#TIPTRIPDET_id2").css("background", "#FFF");
    $("#TRIP_id2").css("background", "#FFF");
    $("#SIMU_fchini").css("background", "#FFF");
    $("#SIMU_fchfin").css("background", "#FFF");
    $("#SIMU_estado").css("background", "#FFF");
    $("#SIMU_fchentrega").css("background", "#FFF");
    $("#SIMU_observacion").css("background", "#FFF");
    
    $("#divSIMU_indicador").css("display","none");
    $("#divSIMU_fchentrega").css("display","none");
    $("#divSIMU_observacion").css("display","none");
    $("#divAUD_usu_cre").css("display","none");
    $("#divAUD_fch_cre").css("display","none");
    $("#divAUD_usu_mod").css("display","none");
    $("#divAUD_fch_mod").css("display","none");
    
    $("#TIPTRIP_id").removeAttr("disabled");
    $("#TIPTRIPDET_id").removeAttr("disabled");
    $("#TRIP_id").removeAttr("disabled");
    $("#TIPTRIP_id2").removeAttr("disabled");
    $("#TIPTRIPDET_id2").removeAttr("disabled");
    $("#TRIP_id2").removeAttr("disabled");
    $("#SIMU_fchini").removeAttr("disabled");
    $("#SIMU_fchfin").removeAttr("disabled");
    $("#SIMU_estado").removeAttr("disabled");
    $("#SIMU_fchentrega").removeAttr("disabled");
    $("#SIMU_observacion").removeAttr("disabled");
    
    $("#divTIPTRIP_id2").css("display","block");
    $("#divTIPTRIPDET_id2").css("display","block");
    $("#divTRIP_id2").css("display","block");
    
    $("#insertSimulador").show();
}

function verFormSimulador(){
    $("#titleForm").text("Detalle de Simulador");
    
    $("#divAUD_usu_cre").css("display","block");
    $("#divAUD_fch_cre").css("display","block");
    $("#divAUD_usu_mod").css("display","block");
    $("#divAUD_fch_mod").css("display","block");
    $("#divSIMU_indicador").css("display","block");

    $("#TIPTRIP_id").prop("disabled","disabled");
    $("#TIPTRIPDET_id").prop("disabled","disabled");
    $("#TRIP_id").prop("disabled","disabled");
    $("#TIPTRIP_id2").prop("disabled","disabled");
    $("#TIPTRIPDET_id2").prop("disabled","disabled");
    //$("#TRIP_id2").prop("disabled","disabled");
    $("#SIMU_fchini").prop("disabled","disabled");
    $("#SIMU_fchfin").prop("disabled","disabled");
    $("#SIMU_estado").prop("disabled","disabled");
    $("#SIMU_indicador").prop("disabled","disabled");
    $("#SIMU_fchentrega").prop("disabled","disabled");
    $("#SIMU_observacion").prop("disabled","disabled");
    
    $("#AUD_usu_cre").prop("disabled","disabled");
    $("#AUD_fch_cre").prop("disabled","disabled");
    $("#AUD_usu_mod").prop("disabled","disabled");
    $("#AUD_fch_mod").prop("disabled","disabled");
    
    $("#TIPTRIP_id").css("background", "#EEEEEE");
    $("#TIPTRIPDET_id").css("background", "#EEEEEE");
    $("#TRIP_id").css("background", "#EEEEEE");
    $("#TIPTRIP_id2").css("background", "#EEEEEE");
    $("#TIPTRIPDET_id2").css("background", "#EEEEEE");
    //$("#TRIP_id2").css("background", "#EEEEEE");
    $("#SIMU_fchini").css("background", "#EEEEEE");
    $("#SIMU_fchfin").css("background", "#EEEEEE");
    $("#SIMU_estado").css("background", "#EEEEEE");
    $("#SIMU_indicador").css("background", "#EEEEEE");
    $("#SIMU_fchentrega").css("background", "#EEEEEE");
    $("#SIMU_observacion").css("background", "#EEEEEE");
    
    $("#insertSimulador").hide();
}

/*--------------------------------- Para Ruta ---------------------------------*/
function validate_formRuta(){
    var error = 0;
    error += validate_input63();
    error += validate_input64();
    error += validate_input65();
    error += validate_input66();
    error += validate_input67();
    error += validate_input68();
    error += validate_input69();
    error += validate_input70();
    error += validate_input71();
    error += validate_input72();
    error += validate_input73();
    
    if(error > 0) return false;
	else return true;
}

function limpiarFormRuta(){
    $("#titleForm").text("Ingresar Ruta");
    
    for (var i = 2; i <= $("#num-diaIDA").val(); i++) {
        $("#horaIDA" + i).remove();
        $("#diaIDA" + i).remove();
        /*$("#RUT_hora_llegadaIDA" + i).remove();
        $("#RUT_diaIDA" + i).select2('destroy');
        $("#RUT_diaIDA" + i).remove();*/
    }
    for (var i = 2; i <= $("#num-diaVUELTA").val(); i++) {
        $("#horaVUELTA" + i).remove();
        $("#diaVUELTA" + i).remove();
        /*$("#RUT_hora_salidaVUELTA" + i).remove();
        $("#RUT_hora_llegadaVUELTA" + i).remove();
        $("#RUT_diaVUELTA" + i).select2('destroy');
        $("#RUT_diaVUELTA" + i).remove();*/      
    }
    $("#num-diaIDA").val("1");
    $("#num-diaVUELTA").val("1");
    
    $("#RUT_num_vueloIDA").val("");
    $("#RUT_num_vueloVUELTA").val("");
    $("#RUT_diaIDA1").val("Monday").trigger('change.select2');
    $("#RUT_diaVUELTA1").val("Monday").trigger('change.select2');
    $("#CIU_id_origen").val("").trigger('change.select2');
    $("#CIU_id_destino").val("").trigger('change.select2');
    $("#RUT_estado").val("1").trigger('change.select2');
    $("#RUT_hora_salidaIDA1").val("");
    $("#RUT_hora_llegadaIDA1").val("");
    $("#RUT_hora_salidaVUELTA1").val("");
    $("#RUT_hora_llegadaVUELTA1").val("");
    
    $("#AUD_usu_cre").val("");
    $("#AUD_fch_cre").val("");
    $("#AUD_usu_mod").val("");
    $("#AUD_fch_mod").val("");
    
    $("#RUT_num_vueloIDA").css("background", "#FFF");
    $("#RUT_num_vueloVUELTA").css("background", "#FFF");
    $("#RUT_diaIDA1").css("background", "#FFF");
    $("#RUT_diaVUELTA1").css("background", "#FFF");
    $("#CIU_id_origen").css("background", "#FFF");
    $("#CIU_id_destino").css("background", "#FFF");
    $("#RUT_estado").css("background", "#FFF");
    $("#RUT_hora_salidaIDA1").css("background", "#FFF");
    $("#RUT_hora_llegadaIDA1").css("background", "#FFF");
    $("#RUT_hora_salidaVUELTA1").css("background", "#FFF");
    $("#RUT_hora_llegadaVUELTA1").css("background", "#FFF");
    
    $("#divAUD_usu_cre").css("display","none");
    $("#divAUD_fch_cre").css("display","none");
    $("#divAUD_usu_mod").css("display","none");
    $("#divAUD_fch_mod").css("display","none");
    
    $("#RUT_num_vueloIDA").removeAttr("disabled");
    $("#RUT_num_vueloVUELTA").removeAttr("disabled");
    $("#RUT_diaIDA1").removeAttr("disabled");
    $("#RUT_diaVUELTA1").removeAttr("disabled");
    $("#CIU_id_origen").removeAttr("disabled");
    $("#CIU_id_destino").removeAttr("disabled");
    $("#RUT_estado").removeAttr("disabled");
    $("#RUT_hora_salidaIDA1").removeAttr("disabled");
    $("#RUT_hora_llegadaIDA1").removeAttr("disabled");
    $("#RUT_hora_salidaVUELTA1").removeAttr("disabled");
    $("#RUT_hora_llegadaVUELTA1").removeAttr("disabled");
    
    $("#insertRuta").show();
}

function verFormRuta(){
    $("#titleForm").text("Detalle de Ruta");
    
    $("#divAUD_usu_cre").css("display","block");
    $("#divAUD_fch_cre").css("display","block");
    $("#divAUD_usu_mod").css("display","block");
    $("#divAUD_fch_mod").css("display","block");

    $("#RUT_num_vueloIDA").prop("disabled","disabled");
    $("#RUT_num_vueloVUELTA").prop("disabled","disabled");
    $("#CIU_id_origen").prop("disabled","disabled");
    $("#CIU_id_destino").prop("disabled","disabled");
    $("#RUT_estado").prop("disabled","disabled");
    $("#RUT_hora_salidaIDA1").val("").prop("disabled","disabled");
    $("#RUT_hora_llegadaIDA1").prop("disabled","disabled");
    $("#RUT_hora_salidaVUELTA1").prop("disabled","disabled");
    $("#RUT_hora_llegadaVUELTA1").prop("disabled","disabled");
    
    $("#AUD_usu_cre").prop("disabled","disabled");
    $("#AUD_fch_cre").prop("disabled","disabled");
    $("#AUD_usu_mod").prop("disabled","disabled");
    $("#AUD_fch_mod").prop("disabled","disabled");
    
    $("#RUT_num_vueloIDA").css("background", "#EEEEEE");
    $("#RUT_num_vueloVUELTA").css("background", "#EEEEEE");
    $("#CIU_id_origen").css("background", "#EEEEEE");
    $("#CIU_id_destino").css("background", "#EEEEEE");
    $("#RUT_estado").css("background", "#EEEEEE");
    $("#RUT_hora_salidaIDA1").val("").css("background", "#EEEEEE");
    $("#RUT_hora_llegadaIDA1").css("background", "#EEEEEE");
    $("#RUT_hora_salidaVUELTA1").css("background", "#EEEEEE");
    $("#RUT_hora_llegadaVUELTA1").css("background", "#EEEEEE");
    
    $("#insertRuta").hide();
}


/*--------------------------------- Para Ausencia ---------------------------------*/
function validate_formAusencia(){
    var error = 0;
    error += validate_input42();
    error += validate_input20();
    error += validate_input21();
    error += validate_input22();
    error += validate_input43();
    error += validate_input44();
    
    if(error > 0) return false;
	else return true;
}

function limpiarFormAusencia(){
    $("#titleForm").text("Ingresar Nueva Ausencia");
    
    $("#TIPAUS_id").val("").trigger('change.select2');
    $("#TIPTRIP_id").val("").trigger('change.select2');
    $("#TIPTRIPDET_id").val("").trigger('change.select2');
    $("#TRIP_id").val("").trigger('change.select2');
    $("#AUS_fchini").val("");
    $("#AUS_fchfin").val("");
    $("#AUS_estado").val("1").trigger('change.select2');
    
    $("#AUD_usu_cre").val("");
    $("#AUD_fch_cre").val("");
    $("#AUD_usu_mod").val("");
    $("#AUD_fch_mod").val("");
    
    $("#TIPAUS_id").css("background", "#FFF");
    $("#TIPTRIP_id").css("background", "#FFF");
    $("#TIPTRIPDET_id").css("background", "#FFF");
    $("#TRIP_id").css("background", "#FFF");
    $("#AUS_fchini").css("background", "#FFF");
    $("#AUS_fchfin").css("background", "#FFF");
    $("#AUS_estado").css("background", "#FFF");
    
    $("#divAUD_usu_cre").css("display","none");
    $("#divAUD_fch_cre").css("display","none");
    $("#divAUD_usu_mod").css("display","none");
    $("#divAUD_fch_mod").css("display","none");
    
    $("#TIPAUS_id").removeAttr("disabled");
    $("#TIPTRIP_id").removeAttr("disabled");
    $("#TIPTRIPDET_id").removeAttr("disabled");
    $("#TRIP_id").removeAttr("disabled");
    $("#AUS_fchini").removeAttr("disabled");
    $("#AUS_estado").removeAttr("disabled");
    //$("#AUS_fchfin").removeAttr("disabled");
    $("#AUS_fchfin").prop("disabled","disabled");
    $("#AUS_fchfin").css("background", "#EEEEEE");
    
    $("#insertAusencia").show();
}

function verFormAusencia(){
    $("#titleForm").text("Detalle de Ausencia");
    
    $("#divAUD_usu_cre").css("display","block");
    $("#divAUD_fch_cre").css("display","block");
    $("#divAUD_usu_mod").css("display","block");
    $("#divAUD_fch_mod").css("display","block");

    $("#TIPAUS_id").prop("disabled","disabled");
    $("#TIPTRIP_id").prop("disabled","disabled");
    $("#TIPTRIPDET_id").prop("disabled","disabled");
    $("#TRIP_id").prop("disabled","disabled");
    $("#AUS_fchini").prop("disabled","disabled");
    $("#AUS_fchfin").prop("disabled","disabled");
    $("#AUS_estado").prop("disabled","disabled");
    
    $("#AUD_usu_cre").prop("disabled","disabled");
    $("#AUD_fch_cre").prop("disabled","disabled");
    $("#AUD_usu_mod").prop("disabled","disabled");
    $("#AUD_fch_mod").prop("disabled","disabled");
    
    $("#TIPAUS_id").css("background", "#EEEEEE");
    $("#TIPTRIP_id").css("background", "#EEEEEE");
    $("#TIPTRIPDET_id").css("background", "#EEEEEE");
    $("#TRIP_id").css("background", "#EEEEEE");
    $("#AUS_fchini").css("background", "#EEEEEE");
    $("#AUS_fchfin").css("background", "#EEEEEE");
    $("#AUS_estado").css("background", "#EEEEEE");
    
    $("#insertAusencia").hide();
}

/*--------------------------------- Para Condicion ---------------------------------*/
function validate_formCondicion(){
    var error = 0;
    error += validate_input20();
    error += validate_input21();
    //error += validate_input22();
    error += validate_input51();
    error += validate_input52();
    
    if(error > 0) return false;
	else return true;
}

function limpiarFormCondicion(){
    $("#titleForm").text("Ingresar Nueva Condición");
    
    $("#TIPTRIP_id").val("").trigger('change.select2');
    $("#TIPTRIPDET_id").val("").trigger('change.select2');
    $("#TRIP_id").val("").trigger('change.select2');
    $("#CONDESP_edad").val("");
    $("#CONDESP_indiedad").val("").trigger('change.select2');
    $("#CIU_id").val("").trigger('change.select2');
    $("#RUT_num_vuelo").val("").trigger('change.select2');
    $("#NIVING_id").val("").trigger('change.select2');
    $("#CONDESP_condicional").val("").trigger('change.select2');
    $("#CONDESP_estado").val("1").trigger('change.select2');
    $("#AUD_usu_cre").val("");
    $("#AUD_fch_cre").val("");
    $("#AUD_usu_mod").val("");
    $("#AUD_fch_mod").val("");
    
    $("#TIPTRIP_id").css("background", "#FFF");
    $("#TIPTRIPDET_id").css("background", "#FFF");
    $("#TRIP_id").css("background", "#FFF");
    $("#CONDESP_edad").css("background", "#FFF");
    $("#CONDESP_indiedad").css("background", "#FFF");
    $("#CIU_id").css("background", "#FFF");
    $("#RUT_num_vuelo").css("background", "#FFF");
    $("#NIVING_id").css("background", "#FFF");
    $("#CONDESP_condicional").css("background", "#FFF");
    $("#CONDESP_estado").css("background", "#FFF");
    
    $("#divAUD_usu_cre").css("display","none");
    $("#divAUD_fch_cre").css("display","none");
    $("#divAUD_usu_mod").css("display","none");
    $("#divAUD_fch_mod").css("display","none");
    
    $("#TIPTRIP_id").removeAttr("disabled");
    $("#TIPTRIPDET_id").removeAttr("disabled");
    $("#TRIP_id").removeAttr("disabled");
    $("#CONDESP_edad").removeAttr("disabled");
    $("#CONDESP_indiedad").removeAttr("disabled");
    $("#CIU_id").removeAttr("disabled");
    $("#RUT_num_vuelo").removeAttr("disabled");
    $("#NIVING_id").removeAttr("disabled");
    $("#CONDESP_condicional").removeAttr("disabled");
    $("#CONDESP_estado").removeAttr("disabled");
    
    $("#aTRIP_id_apli").removeAttr("disabled");
    $("#aCONDESP_edad_apli").removeAttr("disabled");
    $("#aCIU_id_apli").removeAttr("disabled");
    $("#aRUT_num_vuelo_apli").removeAttr("disabled");
    $("#aNIVING_id_apli").removeAttr("disabled");
    
    $("#aTRIP_id_apli").prop("checked",false);
    $("#aCONDESP_edad_apli").prop("checked",false);
    $("#aCIU_id_apli").prop("checked",false);
    $("#aRUT_num_vuelo_apli").prop("checked",false);
    $("#aNIVING_id_apli").prop("checked",false);
    $("#divAplicacion").empty();
    
    $("#insertCondicion").show();
}

function verFormCondicion(){
    $("#titleForm").text("Detalle de Condición");
    
    $("#divAUD_usu_cre").css("display","block");
    $("#divAUD_fch_cre").css("display","block");
    $("#divAUD_usu_mod").css("display","block");
    $("#divAUD_fch_mod").css("display","block");

    $("#TIPTRIP_id").prop("disabled","disabled");
    $("#TIPTRIPDET_id").prop("disabled","disabled");
    $("#TRIP_id").prop("disabled","disabled");
    $("#CONDESP_edad").prop("disabled","disabled");
    $("#CONDESP_indiedad").prop("disabled","disabled");
    $("#CIU_id").val("").prop("disabled","disabled");
    $("#RUT_num_vuelo").prop("disabled","disabled");
    $("#NIVING_id").prop("disabled","disabled");
    $("#CONDESP_condicional").prop("disabled","disabled");
    $("#CONDESP_estado").prop("disabled","disabled");
    
    $("#aTRIP_id_apli").prop("disabled","disabled");
    $("#aCONDESP_edad_apli").prop("disabled","disabled");
    $("#aCIU_id_apli").prop("disabled","disabled");
    $("#aRUT_num_vuelo_apli").prop("disabled","disabled");
    $("#aNIVING_id_apli").prop("disabled","disabled");
    
    $("#AUD_usu_cre").prop("disabled","disabled");
    $("#AUD_fch_cre").prop("disabled","disabled");
    $("#AUD_usu_mod").prop("disabled","disabled");
    $("#AUD_fch_mod").prop("disabled","disabled");
    
    $("#TIPTRIP_id").css("background", "#EEEEEE");
    $("#TIPTRIPDET_id").css("background", "#EEEEEE");
    $("#TRIP_id").css("background", "#EEEEEE");
    $("#CONDESP_edad").css("background", "#EEEEEE");
    $("#CONDESP_indiedad").css("background", "#EEEEEE");
    $("#CIU_id").val("").css("background", "#EEEEEE");
    $("#RUT_num_vuelo").css("background", "#EEEEEE");
    $("#NIVING_id").css("background", "#EEEEEE");
    $("#CONDESP_condicional").css("background", "#EEEEEE");
    $("#CONDESP_estado").css("background", "#EEEEEE");
    
    $("#insertCondicion").hide();
}

/*--------------------------------- Para Itinerario ---------------------------------*/
function validate_formItinerario(){
    var error = 0;
    error += validate_input45();
    error += validate_input46();
    
    if(error > 0) return false;
	else return true;
}

function limpiarFormItinerario(){
    $("#titleForm").text("Ingresar Nuevo Itinerario");
    
    for (var i = 1; i <= $("#objRuta").val(); i++) {
        $("#AVI_id" + i).val("").trigger('change.select2');
        $("#RUT_num_vuelo" + i).prop("checked","true");
    }
    
    $("#ITI_fchini").val("");
    $("#ITI_fchfin").val("");
    
    $("#AUD_usu_cre").val("");
    $("#AUD_fch_cre").val("");
    $("#AUD_usu_mod").val("");
    $("#AUD_fch_mod").val("");
    
    for (var i = 1; i <= $("#objRuta").val(); i++) {
        $("#AVI_id" + i).css("background", "#FFF");
        $("#RUT_num_vuelo" + i).css("background", "#FFF");
    }
    $("#ITI_fchini").css("background", "#FFF");
    $("#ITI_fchfin").css("background", "#FFF");
    
    $("#divAUD_usu_cre").css("display","none");
    $("#divAUD_fch_cre").css("display","none");
    $("#divAUD_usu_mod").css("display","none");
    $("#divAUD_fch_mod").css("display","none");
    $("#divITI_fchVisualizada").css("display","none");
    $("#divITI_fchListar").css("display","none");
    
    for (var i = 1; i <= $("#objRuta").val(); i++) {
        $("#AVI_id" + i).removeAttr("disabled");
        $("#RUT_num_vuelo" + i).removeAttr("disabled");
    }
    $("#ITI_fchini").removeAttr("disabled");
    //$("#ITI_fchfin").removeAttr("disabled");
    $("#ITI_fchfin").prop("disabled","disabled");
    $("#ITI_fchfin").css("background", "#EEEEEE");
    
    $("#insertItinerario").show();
}

function verFormItinerario(){
    $("#titleForm").text("Detalle de Itinerario");
    
    $("#divAUD_usu_cre").css("display","block");
    $("#divAUD_fch_cre").css("display","block");
    $("#divAUD_usu_mod").css("display","block");
    $("#divAUD_fch_mod").css("display","block");
    $("#divITI_fchVisualizada").css("display","block");
    $("#divITI_fchListar").css("display","block");

    for (var i = 1; i <= $("#objRuta").val(); i++) {
        $("#AVI_id" + i).prop("disabled","disabled");
        $("#RUT_num_vuelo" + i).prop("disabled","disabled");
    }
    $("#ITI_fchini").prop("disabled","disabled");
    $("#ITI_fchfin").prop("disabled","disabled");
    
    $("#AUD_usu_cre").prop("disabled","disabled");
    $("#AUD_fch_cre").prop("disabled","disabled");
    $("#AUD_usu_mod").prop("disabled","disabled");
    $("#AUD_fch_mod").prop("disabled","disabled");
    
    for (var i = 1; i <= $("#objRuta").val(); i++) {
        $("#AVI_id" + i).css("background", "#EEEEEE");
        $("#RUT_num_vuelo" + i).css("background", "#EEEEEE");
    }
    $("#ITI_fchini").css("background", "#EEEEEE");
    $("#ITI_fchfin").css("background", "#EEEEEE");
    
    $("#insertItinerario").hide();
    $("#sendItinerario").show();
}

/*--------------------------------- Para Programación ---------------------------------*/
function validate_formProgramacion(){
    var error = 0;
    if($("#TRIP_id_Instructor").val() == ''){
        error += validate_input47(); //Piloto
        error += validate_input48(); //Copiloto
    } else {
        /*if($("#TRIP_id_Piloto").val() == '') {
            error += validate_input48(); //Copiloto
        } else if($("#TRIP_id_Copiloto").val("") == '') {
            error += validate_input47(); //Piloto
        }*/
    }
    error += validate_input49(); //Jefe Cabina
    error += validate_input50(); //Tripulante Cabina
    
    if(error > 0) return false;
	else return true;
}

function limpiarFormProgramacion(){
    $("#titleForm").text("Ingresar Tripulacion");
    for (var i = 2; i <= $("#num-TripCabina").val(); i++) {
        $("#TRIP_id_TripCabina" + i).select2('destroy');
        $("#TRIP_id_TripCabina" + i).remove();
    }
    
    $("#TRIP_id_TripCabina1").val("").trigger('change.select2');
    
    $("#divTripCabina").empty();
    $("#num-TripCabina").val("1");
    
    $("#TRIP_id_Instructor").val("").trigger('change.select2');
    $("#TRIP_id_Piloto").val("").trigger('change.select2');
    $("#TRIP_id_Copiloto").val("").trigger('change.select2');
    $("#TIPTRIPU_id").val("").trigger('change.select2');
    $("#TRIP_id_JejeCabina").val("").trigger('change.select2');
    $("#TRIP_id_ApoyoVuelo").val("").trigger('change.select2');
    
    $("#AUD_usu_cre").val("");
    $("#AUD_fch_cre").val("");
    $("#AUD_usu_mod").val("");
    $("#AUD_fch_mod").val("");
    
    //for (var i = 1; i <= $("#num-TripCabina").val(); i++) {
        $("#TRIP_id_TripCabina1").css("background", "#FFF");
    //}
    $("#TRIP_id_Instructor").css("background", "#FFF");
    $("#TRIP_id_Piloto").css("background", "#FFF");
    $("#TRIP_id_Copiloto").css("background", "#FFF");
    //$("#TIPTRIPU_id").css("background", "#FFF");
    $("#TRIP_id_JejeCabina").css("background", "#FFF");
    $("#TRIP_id_ApoyoVuelo").css("background", "#FFF");
    
    $("#TRIP_id_Piloto_label").css("color","black");
    $("#TRIP_id_Copiloto_label").css("color","black");
    $("#TRIP_id_JejeCabina_label").css("color","black");
    $("#TRIP_id_TripCabina1_label").css("color","black");
    
    $("#divAUD_usu_cre").css("display","none");
    $("#divAUD_fch_cre").css("display","none");
    $("#divAUD_usu_mod").css("display","none");
    $("#divAUD_fch_mod").css("display","none");
    
    //for (var i = 1; i <= $("#num-TripCabina").val(); i++) {
        $("#TRIP_id_TripCabina1").removeAttr("disabled");
    //}
    $("#TRIP_id_Instructor").removeAttr("disabled");
    $("#TRIP_id_Piloto").removeAttr("disabled");
    $("#TRIP_id_Copiloto").removeAttr("disabled");
    //$("#TIPTRIPU_id").removeAttr("disabled");
    $("#TRIP_id_JejeCabina").removeAttr("disabled");
    $("#TRIP_id_ApoyoVuelo").removeAttr("disabled");
    $("#agregar_TripCabina").removeAttr("disabled");
    $("#quitar_TripCabina").removeAttr("disabled");
    
    $("#asteriscoPiloto").css("color","#FF0000");
    $("#asteriscoCopiloto").css("color","#FF0000");
    
    $("#insertprogramacion").show();
}

function verFormProgramacion(){
    $("#titleForm").text("Detalle de Tripulantes");
    
    $("#divAUD_usu_cre").css("display","block");
    $("#divAUD_fch_cre").css("display","block");
    $("#divAUD_usu_mod").css("display","block");
    $("#divAUD_fch_mod").css("display","block");
    
    for (var i = 1; i <= $("#num-TripCabina").val(); i++) {
        $("#TRIP_id_TripCabina" + i).prop("disabled","disabled");
    }
    $("#TRIP_id_Instructor").prop("disabled","disabled");
    $("#TRIP_id_Piloto").prop("disabled","disabled");
    $("#TRIP_id_Copiloto").prop("disabled","disabled");
    $("#TIPTRIPU_id").prop("disabled","disabled");
    $("#TRIP_id_JejeCabina").prop("disabled","disabled");
    $("#TRIP_id_ApoyoVuelo").prop("disabled","disabled");
    
    $("#AUD_usu_cre").prop("disabled","disabled");
    $("#AUD_fch_cre").prop("disabled","disabled");
    $("#AUD_usu_mod").prop("disabled","disabled");
    $("#AUD_fch_mod").prop("disabled","disabled");
    
    for (var i = 1; i <= $("#num-TripCabina").val(); i++) {
        $("#TRIP_id_TripCabina" + i).css("background", "#EEEEEE");
    }
    $("#TRIP_id_Instructor").css("background", "#EEEEEE");
    $("#TRIP_id_Piloto").css("background", "#EEEEEE");
    $("#TRIP_id_Copiloto").css("background", "#EEEEEE");
    $("#TIPTRIPU_id").css("background", "#EEEEEE");
    $("#TRIP_id_JejeCabina").css("background", "#EEEEEE");
    $("#TRIP_id_ApoyoVuelo").css("background", "#EEEEEE");
    
    //$("#insertProgramacion").hide();
}

/*--------------------------------- Para Reservas ---------------------------------*/
function validate_formReserva(){
    var error = 0;
    error += validate_input47(); //Piloto
    error += validate_input48(); //Copiloto
    error += validate_input49(); //Jefe Cabina
    error += validate_input49(); //Jefe Cabina
    error += validate_input59(); //Tripulante Cabina
    
    if(error > 0) return false;
	else return true;
}

function limpiarFormReserva(){
    $("#titleForm").text("Ingresar Reserva.");
    
    for (var i = 2; i <= $("#num-TripCabina").val(); i++) {
        $("#TRIP_id_TripCabina" + i).select2('destroy');
        $("#TRIP_id_TripCabina" + i).remove();
    }
    
    $("#num-TripCabina").val("1");
    $("#TRIP_id_TripCabina1").val("").trigger('change.select2');
    $("#TRIP_id_Instructor").val("").trigger('change.select2');
    $("#TRIP_id_Piloto").val("").trigger('change.select2');
    $("#TRIP_id_Copiloto").val("").trigger('change.select2');
    $("#TRIP_id_JejeCabina").val("").trigger('change.select2');
    $("#TRIP_id_ApoyoVuelo").val("").trigger('change.select2');
    $("#TIPTRIPU_id").val("").trigger('change.select2');
    $("#bITI_fch").val("");
    
    $("#AUD_usu_cre").val("");
    $("#AUD_fch_cre").val("");
    $("#AUD_usu_mod").val("");
    $("#AUD_fch_mod").val("");
    
    $("#TRIP_id_TripCabina1").css("background", "#EEEEEE")
    $("#TRIP_id_Instructor").css("background", "#EEEEEE");
    $("#TRIP_id_Piloto").css("background", "#EEEEEE");
    $("#TRIP_id_Copiloto").css("background", "#EEEEEE");
    $("#TRIP_id_JejeCabina").css("background", "#EEEEEE");
    $("#TRIP_id_ApoyoVuelo").css("background", "#EEEEEE");
    $("#bITI_fch").css("background", "#FFF");
    
    $("#divAUD_usu_cre").css("display","none");
    $("#divAUD_fch_cre").css("display","none");
    $("#divAUD_usu_mod").css("display","none");
    $("#divAUD_fch_mod").css("display","none");
    
    $("#TRIP_id_TripCabina1").prop("disabled","disabled");
    $("#TRIP_id_Instructor").prop("disabled","disabled");
    $("#TRIP_id_Piloto").prop("disabled","disabled");
    $("#TRIP_id_Copiloto").prop("disabled","disabled");
    $("#TRIP_id_JejeCabina").prop("disabled","disabled");
    $("#TRIP_id_ApoyoVuelo").prop("disabled","disabled");
    $("#bITI_fch").removeAttr("disabled");
    
    $("#agregar_TripCabina").removeAttr("disabled");
    $("#quitar_TripCabina").removeAttr("disabled");
    
    $("#insertReserva").show();
}

function verFormReserva(){
    $("#titleForm").text("Detalle de Reserva.");
    
    $("#divAUD_usu_cre").css("display","block");
    $("#divAUD_fch_cre").css("display","block");
    $("#divAUD_usu_mod").css("display","block");
    $("#divAUD_fch_mod").css("display","block");
    
    for (var i = 1; i <= $("#num-TripCabina").val(); i++) {
        $("#TRIP_id_TripCabina" + i).prop("disabled","disabled");
    }
    $("#TRIP_id_Instructor").prop("disabled","disabled");
    $("#TRIP_id_Piloto").prop("disabled","disabled");
    $("#TRIP_id_Copiloto").prop("disabled","disabled");
    $("#TIPTRIPU_id").prop("disabled","disabled");
    $("#TRIP_id_JejeCabina").prop("disabled","disabled");
    $("#TRIP_id_ApoyoVuelo").prop("disabled","disabled");
    $("#bITI_fch").prop("disabled","disabled");
    
    $("#AUD_usu_cre").prop("disabled","disabled");
    $("#AUD_fch_cre").prop("disabled","disabled");
    $("#AUD_usu_mod").prop("disabled","disabled");
    $("#AUD_fch_mod").prop("disabled","disabled");
    
    for (var i = 1; i <= $("#num-TripCabina").val(); i++) {
        $("#TRIP_id_TripCabina" + i).css("background", "#EEEEEE");
    }
    $("#TRIP_id_Instructor").css("background", "#EEEEEE");
    $("#TRIP_id_Piloto").css("background", "#EEEEEE");
    $("#TRIP_id_Copiloto").css("background", "#EEEEEE");
    $("#TIPTRIPU_id").css("background", "#EEEEEE");
    $("#TRIP_id_JejeCabina").css("background", "#EEEEEE");
    $("#TRIP_id_ApoyoVuelo").css("background", "#EEEEEE");
    $("#bITI_fch").css("background", "#EEEEEE");
    
    //$("#insertProgramacion").hide();
}

/*--------------------------------- Para ProgxTrip ---------------------------------*/
function limpiarTripxDia(){
    $("#titleForm").text("Ingresar Cambio.");
    
    $("#fch_prog").val("").trigger('change.select2');
    $("#TIPTRIP_id").val("").trigger('change.select2');
    $("#TIPTRIPDET_id").val("").trigger('change.select2');
    $("#TRIP_id1").val("").trigger('change.select2');
    $("#TRIP_id2").val("").trigger('change.select2');
    $("#textCondicional").val("");
    
    $("#fch_prog").css("background", "#EEEEEE")
    $("#TIPTRIP_id").css("background", "#EEEEEE")
    $("#TIPTRIPDET_id").css("background", "#EEEEEE");
    $("#TRIP_id1").css("background", "#EEEEEE");
    $("#TRIP_id2").css("background", "#EEEEEE");
    $("#textCondicional").css("background", "#EEEEEE");
    
    $("#fch_prog").prop("disabled","disabled");
    $("#TIPTRIP_id").prop("disabled","disabled");
    $("#TIPTRIPDET_id").prop("disabled","disabled");
    $("#TRIP_id1").prop("disabled","disabled");
    //$("#TRIP_id2").prop("disabled","disabled");
    $("#textCondicional").prop("disabled","disabled");
}

/*--------------------------------- Para Chained (Hay q detallar) ---------------------------------*/
function listarDetalleTrip_apli(url){
    $.post(url,{},
    function(data6){
        if(data6 == ""){
            alert("Hubo un error al cargar la información.");
        } else {
            TIPTRIPDET_id = $("#TIPTRIPDET_id_apli");
            TIPTRIPDET_id.find('option').remove();
            for(var i=0;i<data6.length;i++){
                TIPTRIPDET_id.append('<option class="' + data6[i]["TIPTRIP_id"] + '" value="' + data6[i]["TIPTRIPDET_id"] + '">' + data6[i]["TIPTRIPDET_descripcion"] + '</option>');
            }
        }
    });
}

function listarTripulantes_apli(url,variable){
    $.post(url,{},
    function(data7){
        if(data7 == ""){
            alert("Hubo un error al cargar la información.");
        } else {
            TRIP_id = $("#TRIP_id_apli");
            TRIP_id.find('option').remove();
            for(var i=0;i<data7.length;i++){
                TRIP_id.append('<option class="' + data7[i][variable] + '" value="' + data7[i]["TRIP_id"] + '">' + data7[i]["TRIP_nombre"] + ' ' + data7[i]["TRIP_apellido"] + '</option>');
            }
        }
    });
}

function validarObligatorioInstructor(){
    if($("#TRIP_id_Instructor").val() == ''){
        $("#TRIP_instructorI").removeAttr("checked");
        $("#TRIP_instructorP").prop("disabled","disabled");
        $("#TRIP_instructorC").prop("disabled","disabled");
        $("#TRIP_instructorI").prop("disabled","disabled");
        /*$("#asteriscoPiloto").css("color","#FF0000");
        $("#asteriscoCopiloto").css("color","#FF0000");*/
    } else {
        $("#TRIP_instructorP").removeAttr("disabled");
        $("#TRIP_instructorC").removeAttr("disabled");
        $("#TRIP_instructorI").removeAttr("disabled");
        $("#TRIP_instructorI").prop("checked","true");
        //$("#asteriscoCopiloto").css("color","#FFFFFF");
    }
}

function validarObligatorioPiloto(){
    if($("#TRIP_id_Piloto").val() != ''){
        if($("#TRIP_id_Instructor").val() != ''){
            $("#TRIP_id_Copiloto").val("").trigger('change.select2');
            $("#asteriscoPiloto").css("color","#FF0000");
            $("#asteriscoCopiloto").css("color","#FFFFFF");
        }
    }
}

/*function validarObligatorioCopiloto(){
    if($("#TRIP_id_Copiloto").val() != ''){
        if($("#TRIP_id_Instructor").val() != ''){
            $("#TRIP_id_Piloto").val("").trigger('change.select2');
            $("#asteriscoPiloto").css("color","#FFFFFF");
            $("#asteriscoCopiloto").css("color","#FF0000");
        }
    }
}*/

function listarInstructor(url,RUT_num_vuelo,TIPTRIPU_id_cabina,TIPTRIPU_id_piloto){
    //var url = "<?php echo URLLOGICA?>motor/listarTripulantesMotor/";
    $("#preloader").css("display","block");
    /* Para Trip. de Vuelo - Piloto */
        $.post(url,
        {
            "ITI_fch" : $("#bITI_fch").val(),
            "RUT_num_vuelo" : RUT_num_vuelo,
            "TIPTRIPU_id" : TIPTRIPU_id_piloto,
            //"TIPTRIPU_id" : '1',
            "TIPTRIP_id" : 'Vuelo',
            "TIPTRIPDET_id" : 'Instructor'
        },
        function(data)
        {
            if(data == ""){
                alert("Hubo un error en la carga de Información.");
            } else {
                /* Para Instructor */
                TRIP_id_Instructor = $("#TRIP_id_Instructor");
                TRIP_id_Instructor.find('option').remove();
                TRIP_id_Instructor.append('<option value="">Seleccionar Instructor</option>');
                for(var i=0;i<data.length;i++){
                    TRIP_id_Instructor.append('<option value="' + data[i]["TRIP_id"] + '">' + data[i]["TRIP_nombre"] + ' ' + data[i]["TRIP_apellido"] + '</option>');
                }
            }
        });
    $("#preloader").css("display", "none");
}

function listarPiloto(url,RUT_num_vuelo,TIPTRIPU_id_cabina,TIPTRIPU_id_piloto){
    //var url = "<?php echo URLLOGICA?>motor/listarTripulantesMotor/";
    $("#preloader").css("display","block");
    /* Para Trip. de Vuelo - Piloto */
        $.post(url,
        {
            "ITI_fch" : $("#bITI_fch").val(),
            "RUT_num_vuelo" : RUT_num_vuelo,
            "TIPTRIPU_id" : TIPTRIPU_id_piloto,
            //"TIPTRIPU_id" : '1',
            "TIPTRIP_id" : 'Vuelo',
            "TIPTRIPDET_id" : 'Piloto'
        },
        function(data)
        {
            if(data == ""){
                alert("Hubo un error en la carga de Información.");
            } else {
                /* Para Piloto */
                TRIP_id_Piloto = $("#TRIP_id_Piloto");
                TRIP_id_Piloto.find('option').remove();
                TRIP_id_Piloto.append('<option value="">Seleccionar Piloto</option>');
                for(var i=0;i<data.length;i++){
                    TRIP_id_Piloto.append('<option value="' + data[i]["TRIP_id"] + '">' + data[i]["TRIP_nombre"] + ' ' + data[i]["TRIP_apellido"] + '</option>');
                }
            }
        });
    $("#preloader").css("display", "none");
}

function listarCopiloto(url,TRIP_id,RUT_num_vuelo,TIPTRIPU_id_cabina,TIPTRIPU_id_piloto){
    //var url = "<?php echo URLLOGICA?>motor/listarTripulantesMotor/";
    $("#preloader").css("display","block");
    /* Para Trip. de Vuelo - Copiloto */
        $.post(url,
        {
            "TRIP_id" : TRIP_id,
            "ITI_fch" : $("#bITI_fch").val(),
            "RUT_num_vuelo" : RUT_num_vuelo,
            "TIPTRIPU_id" : TIPTRIPU_id_piloto,
            //"TIPTRIPU_id" : '1',
            "TIPTRIP_id" : 'Vuelo',
            "TIPTRIPDET_id" : 'Copiloto'
        },
        function(data)
        {
            if(data == ""){
                //alert("Hubo un error en la carga de Información.");
            } else {
                /* Para Copiloto */
                TRIP_id_Copiloto = $("#TRIP_id_Copiloto");
                TRIP_id_Copiloto.find('option').remove();
                TRIP_id_Copiloto.append('<option value="">Seleccionar Copiloto</option>');
                for(var i=0;i<data.length;i++){
                    TRIP_id_Copiloto.append('<option value="' + data[i]["TRIP_id"] + '">' + data[i]["TRIP_nombre"] + ' ' + data[i]["TRIP_apellido"] + '</option>');
                }
            }
        });
    $("#preloader").css("display", "none");
}

function listarJefeCabina(url,RUT_num_vuelo,TIPTRIPU_id_cabina,TIPTRIPU_id_piloto){
    //var url = "<?php echo URLLOGICA?>motor/listarTripulantesMotor/";
    $("#preloader").css("display","block");
    /* Para Trp. de Cabina */
        $.post(url,
        {
            "ITI_fch" : $("#bITI_fch").val(),
            "RUT_num_vuelo" : RUT_num_vuelo,
            "TIPTRIPU_id" : TIPTRIPU_id_cabina,
            "TIPTRIP_id" : 'Cabina',
            "TIPTRIPDET_id" : 'JefeCabina'
        },
        function(data)
        {
            if(data == ""){
                alert("Hubo un error en la carga de Información.");
            } else {
                /* Para Jefe de Cabina */
                TRIP_id_JejeCabina = $("#TRIP_id_JejeCabina");
                TRIP_id_JejeCabina.find('option').remove();
                TRIP_id_JejeCabina.append('<option value="">Seleccionar Jefe de Cabina</option>');
                for(var i=0;i<data.length;i++){
                    TRIP_id_JejeCabina.append('<option value="' + data[i]["TRIP_id"] + '">' + data[i]["TRIP_nombre"] + ' ' + data[i]["TRIP_apellido"] + '</option>');
                }
            }
        });
    $("#preloader").css("display", "none");
}

function listarCabina(url,num,RUT_num_vuelo,TIPTRIPU_id_cabina,TIPTRIPU_id_piloto){
    //var url = "<?php echo URLLOGICA?>motor/listarTripulantesMotor/";
    $("#preloader").css("display","block");
    /* Para Trp. de Cabina */
        $.post(url,
        {
            "ITI_fch" : $("#bITI_fch").val(),
            "RUT_num_vuelo" : RUT_num_vuelo,
            "TIPTRIPU_id" : TIPTRIPU_id_cabina,
            "TIPTRIP_id" : 'Cabina',
            "TIPTRIPDET_id" : 'Cabina'
        },
        function(data)
        {
            if(data == ""){
                alert("Hubo un error en la carga de Información.");
            } else {
                /* Para Trip de Cabina */
                TRIP_id_TripCabina = $("#TRIP_id_TripCabina" + num);
                TRIP_id_TripCabina.find('option').remove();
                TRIP_id_TripCabina.append('<option value="">Seleccionar Trip. Cabina</option>');
                for(var i=0;i<data.length;i++){
                    TRIP_id_TripCabina.append('<option value="' + data[i]["TRIP_id"] + '">' + data[i]["TRIP_nombre"] + ' ' + data[i]["TRIP_apellido"] + '</option>');
                }
            }
        });
    $("#preloader").css("display", "none");
}

function listarApoyo(url,RUT_num_vuelo,TIPTRIPU_id_cabina,TIPTRIPU_id_piloto){
    //var url = "<?php echo URLLOGICA?>motor/listarTripulantesMotor/";
    $("#preloader").css("display","block");
    /* Para Apoyo en Vuelo */
        $.post(url,
        {
            "ITI_fch" : $("#bITI_fch").val(),
            "RUT_num_vuelo" : RUT_num_vuelo,
            "TIPTRIPU_id" : TIPTRIPU_id_cabina,
            "TIPTRIP_id" : '',
            "TIPTRIPDET_id" : ''
        },
        function(data)
        {
            if(data == ""){
                alert("Hubo un error en la carga de Información.");
            } else {
                /* Para Apoyo en Vuelo */
                TRIP_id_ApoyoVuelo = $("#TRIP_id_ApoyoVuelo");
                TRIP_id_ApoyoVuelo.find('option').remove();
                TRIP_id_ApoyoVuelo.append('<option value="">Seleccionar Apoyo Vuelo</option>');
                for(var i=0;i<data.length;i++){
                    TRIP_id_ApoyoVuelo.append('<option value="' + data[i]["TRIP_id"] + '">' + data[i]["TRIP_nombre"] + ' ' + data[i]["TRIP_apellido"] + '</option>');
                }
            }
        });
    $("#preloader").css("display", "none");
}

/*--------- Listar Combo de Avión ---------*/
function listarComboAvion(url){
    $.post(url,{},
    function(data){
        if(data == ""){
            alert("Hubo un error al cargar la información.");
        } else {
            AVI_id = $("#AVI_id");
            AVI_id.find('option').remove();
            AVI_id.append('<option value="">Seleccionar Avión</option>');
            for(var i=0;i<data.length;i++){
                AVI_id.append('<option class="' + data[i]["TIPAVI_id"] + '" value="' + data[i]["AVI_id"] + '">' + data[i]["AVI_num_cola"] + '</option>');
            }
        }
    });
}

/*--------- Listar Combo de AviónVarios ---------*/
function listarComboAvionVarios(url,valor){
    $.post(url,{},
    function(data){
        if(data == ""){
            alert("Hubo un error al cargar la información.");
        } else {
            AVI_id = valor;
            AVI_id.find('option').remove();
            AVI_id.append('<option value="">Seleccionar Aviónsss</option>');
            for(var i=0;i<data.length;i++){
                AVI_id.append('<option value="' + data[i]["AVI_id"] + '">' + data[i]["AVI_num_cola"] + '</option>');
            }
        }
    });
}

/*--------- Listar Combo de Provincia ---------*/
function listarComboProvincia(url){
    $.post(url,{},
    function(data2){
        if(data2 == ""){
            alert("Hubo un error al cargar la información.");
        } else {
            idProv = $("#idProv");
            idProv.find('option').remove();
            idProv.append('<option value="">Seleccionar Provincia</option>');
            for(var i=0;i<data2.length;i++){
                idProv.append('<option class="' + data2[i]["idDepa"] + '" value="' + data2[i]["idProv"] + '">' + data2[i]["provincia"] + '</option>');
            }
        }
    });
}

/*--------- Listar Combo de Distrito ---------*/
function listarComboDistrito(url){
    $.post(url,{},
    function(data3){
        if(data3 == ""){
            alert("Hubo un error al cargar la información.");
        } else {
            idDist = $("#idDist");
            idDist.find('option').remove();
            idDist.append('<option value="">Seleccionar Distrito</option>');
            for(var i=0;i<data3.length;i++){
                idDist.append('<option class="' + data3[i]["idProv"] + '" value="' + data3[i]["idDist"] + '">' + data3[i]["distrito"] + '</option>');
            }
        }
    });
}

/*--------- Listar Combo Det. Tripulantes (Piloto-Copiloto_Auxiliar)  ---------*/
function listarComboDetalleTrip(url){
    $.post(url,{},
    function(data4){
        if(data4 == ""){
            alert("Hubo un error al cargar la información.");
        } else {
            TIPTRIPDET_id = $("#TIPTRIPDET_id");
            TIPTRIPDET_id.find('option').remove();
            TIPTRIPDET_id.append('<option value="">Seleccionar Det. Tripulante</option>');
            for(var i=0;i<data4.length;i++){
                TIPTRIPDET_id.append('<option class="' + data4[i]["TIPTRIP_id"] + '" value="' + data4[i]["TIPTRIPDET_id"] + '">' + data4[i]["TIPTRIPDET_descripcion"] + '</option>');
            }
        }
    });
}

/*--------- Listar Combo Det. Tripulantes (Piloto-Copiloto_Auxiliar)  ---------*/
function listarComboDetalleTrip2(url){
    $.post(url,{},
    function(data4){
        if(data4 == ""){
            alert("Hubo un error al cargar la información.");
        } else {
            TIPTRIPDET_id = $("#TIPTRIPDET_id2");
            TIPTRIPDET_id.find('option').remove();
            TIPTRIPDET_id.append('<option value="">Seleccionar Det. Tripulante</option>');
            for(var i=0;i<data4.length;i++){
                TIPTRIPDET_id.append('<option class="' + data4[i]["TIPTRIP_id"] + '" value="' + data4[i]["TIPTRIPDET_id"] + '">' + data4[i]["TIPTRIPDET_descripcion"] + '</option>');
            }
        }
    });
}

/*--------- Listar Combo Tripulante Dependiente de Det. Tipo ---------*/
function listarComboTripulante(url,select){
    $.post(url,{},
    function(data5){
        if(data5 == ""){
            alert("Hubo un error al cargar la información.");
        } else {
            TRIP_id = select;
            TRIP_id.find('option').remove();
            TRIP_id.append('<option value="">Seleccionar Tripulante</option>');
            for(var i=0;i<data5.length;i++){
                TRIP_id.append('<option class="' + data5[i]["TIPTRIPDET_id"] + '" value="' + data5[i]["TRIP_id"] + '">' + data5[i]["TRIP_nombre"] + ' ' + data5[i]["TRIP_apellido"] + '</option>');
            }
        }
    });
}

/*--------- Listar Combo Tripulante Dependiente de Tipo   ---------*/
function listarComboTripulanteDependTipo(url,select){
    $.post(url,{},
    function(data5){
        if(data5 == ""){
            alert("Hubo un error al cargar la información.");
        } else {
            TRIP_id = select;
            TRIP_id.find('option').remove();
            TRIP_id.append('<option value="">Seleccionar Tripulante</option>');
            for(var i=0;i<data5.length;i++){
                TRIP_id.append('<option class="' + data5[i]["TIPTRIP_id"] + '" value="' + data5[i]["TRIP_id"] + '">' + data5[i]["TRIP_nombre"] + ' ' + data5[i]["TRIP_apellido"] + '</option>');
            }
        }
    });
}

/*--------- Listar Combo AviónsinManto  ---------*/
function listarComboAvionxManto(url,select,ITI_fchini,ITI_fchfin){
    $.post(url,{
        "ITI_fchini" : ITI_fchini,
        "ITI_fchfin" : ITI_fchfin,
    },
    function(data){
        if(data == ""){
            alert("Hubo un error al cargar la información.");
        } else {
            AVI_id = select;
            AVI_id.find('option').remove();
            AVI_id.append('<option value="">Seleccionar Avión</option>');
            for(var i=0;i<data.length;i++){
                AVI_id.append('<option value="' + data[i]["AVI_id"] + '">' + data[i]["AVI_num_cola"] + '</option>');
            }
        }
    });
}
 
/*--------- Listar Combo AviónDisponiblesxFecha  ---------*/
function listarComboAvionDisponibles(url,select,ITI_fchini,ITI_fchfin,variable){
    var parametros = {
        "variable" : variable,
        "ITI_fchini" : ITI_fchini,
        "ITI_fchfin" : ITI_fchfin
    };
    $.post(url,parametros,
    function(data){
        if(data == ""){
            alert("Hubo un error al cargar la información.");
        } else {
            AVI_id = select;
            AVI_id.find('option').remove();
            AVI_id.append('<option value="">Seleccionar Avión</option>');
            for(var i=0;i<data.length;i++){
                AVI_id.append('<option value="' + data[i]["AVI_id"] + '">' + data[i]["AVI_num_cola"] + '</option>');
            }
        }
    });
}

/*--------------------------------- Validaciones Exepcionales ---------------------------------*/
/*--------- Formato Correo ---------*/
function validate_correo(origen){
    var regex = /[\w-\.]{2,}@([\w-]{2,}\.)*([\w-]{2,}\.)[\w-]{2,4}/;
    if (regex.test(origen.val().trim())) {
        origen.css("background","#FFF");
        return 0;
    } else {
        origen.css("background","#f9c8c9");
		origen.tooltip({title:"Ingresa Correo Correcto"});
		origen.tooltip("show");
		origen.focus();
        return 1;
    }
}

/*--------- Diferencia Fechas ---------*/
function restaFechas(f1,f2){
    var aFecha1 = f1.split('/'); 
    var aFecha2 = f2.split('/'); 
    var fFecha1 = Date.UTC(aFecha1[2],aFecha1[1]-1,aFecha1[0]); 
    var fFecha2 = Date.UTC(aFecha2[2],aFecha2[1]-1,aFecha2[0]); 
    var dif = fFecha2 - fFecha1;
    var dias = Math.floor(dif / (1000 * 60 * 60 * 24)); 
    return dias;
}

/*--------- Fechas Continua ---------*/
function validarFechaContinua(select,fchIni){
    select.datetimepicker('destroy');
    var result = fchIni.split('/');
    select.datetimepicker({
        format: 'DD/MM/YYYY',
        minDate: result[1] + '/' + result[0] + '/' + result[2],
    });
}

/*--------- Fechas ContinuaInversa ---------*/
function validarFechaContinuaInversa(select,fchIni){
    select.datetimepicker('destroy');
    var result = fchIni.split('/');
    var d = new Date();
    var strDate_2 = (d.getMonth()+1) + "/" + d.getDate() + "/" + d.getFullYear();
    select.datetimepicker({
        format: 'DD/MM/YYYY',
        maxDate: result[1] + '/' + result[0] + '/' + result[2],
        minDate: strDate_2,
    });
}

/*--------- Validar Edad ---------*/
function calcularEdad(fechnac) {
    var fecha = fechnac.val();
    // Si la fecha es correcta, calculamos la edad
    var values=fecha.split("/");
    var dia = values[0];
    var mes = values[1];
    var ano = values[2];

    // cogemos los valores actuales
    var fecha_hoy = new Date();
    var ahora_ano = fecha_hoy.getYear();
    var ahora_mes = fecha_hoy.getMonth()+1;
    var ahora_dia = fecha_hoy.getDate();

    // realizamos el calculo
    var edad = (ahora_ano + 1900) - ano;
    if ( ahora_mes < mes )
    {
        edad--;
    }
    if ((mes == ahora_mes) && (ahora_dia < dia))
    {
        edad--;
    }
    if (edad > 1900)
    {
        edad -= 1900;
    }

    // calculamos los meses
    var meses=0;
    if(ahora_mes>mes)
        meses=ahora_mes-mes;
    if(ahora_mes<mes)
        meses=12-(mes-ahora_mes);
    if(ahora_mes==mes && dia>ahora_dia)
        meses=11;

    // calculamos los dias
    var dias=0;
    if(ahora_dia>dia)
        dias=ahora_dia-dia;
    if(ahora_dia<dia)
    {
        ultimoDiaMes=new Date(ahora_ano, ahora_mes, 0);
        dias=ultimoDiaMes.getDate()-(dia-ahora_dia);
    }
    
    if(edad >= 18){
        return 0;
    } else {
        fechnac.css("background","#f9c8c9");
        fechnac.tooltip({title:"Ingresa persona mayor de Edad"});
        fechnac.tooltip("show");
        fechnac.focus();
        return 1;
    }
    //document.getElementById("result").innerHTML="Tienes "+edad+" años, "+meses+" meses y "+dias+" días";
}

/* ----- Función que suma o resta días a la fecha indicada ----- */
sumaFecha = function(d, fecha)
{
    var Fecha = new Date();
    var sFecha = fecha || (Fecha.getDate() + "/" + (Fecha.getMonth() +1) + "/" + Fecha.getFullYear());
    var sep = sFecha.indexOf('/') != -1 ? '/' : '-';
    var aFecha = sFecha.split(sep);
    var fecha = aFecha[2]+'/'+aFecha[1]+'/'+aFecha[0];
    fecha= new Date(fecha);
    fecha.setDate(fecha.getDate()+parseInt(d));
    var anno=fecha.getFullYear();
    var mes= fecha.getMonth()+1;
    var dia= fecha.getDate();
    mes = (mes < 10) ? ("0" + mes) : mes;
    dia = (dia < 10) ? ("0" + dia) : dia;
    var fechaFinal = dia+sep+mes+sep+anno;
    return (fechaFinal);
 }

/*--------------------------------- Validaciones detalle por Campo ---------------------------------*/
/*--------- Tipo de Avión ---------*/
function validate_input2(){
	origen = $("#TIPAVI_id");
	if(origen.val() == ''){
		origen.css("background","#f9c8c9");
		origen.tooltip({title:"Ingresa Tipo"});
		origen.tooltip("show");
		origen.focus();
		return 1;
	}else{
		origen.css("background","#FFF");
		return 0;
	}
}

/*--------- Número de Cola ---------*/
function validate_input3(){
	origen = $("#AVI_num_cola");
	if(origen.val() == ''){
		origen.css("background","#f9c8c9");
		origen.tooltip({title:"Ingresa N° de Cola"});
		origen.tooltip("show");
		origen.focus();
		return 1;
	}else{
		origen.css("background","#FFF");
		return 0;
	}
}

/*--------- Cantidad de Pasajeros ---------*/
function validate_input4(){
	origen = $("#AVI_cant_pasajeros");
	if(origen.val() == ''){
		origen.css("background","#f9c8c9");
		origen.tooltip({title:"Ingresa Cant. Pasajeros"});
		origen.tooltip("show");
		origen.focus();
		return 1;
	}else{
		origen.css("background","#FFF");
		return 0;
	}
}

/*--------- Carga Máxima ---------*/
function validate_input5(){
	origen = $("#AVI_cap_carga_max");
	if(origen.val() == ''){
		origen.css("background","#f9c8c9");
		origen.tooltip({title:"Ingresa Cant. Max. Carga"});
		origen.tooltip("show");
		origen.focus();
		return 1;
	}else{
		origen.css("background","#FFF");
		return 0;
	}
}

/*--------- Estado Avión ---------*/
function validate_input6(){
	origen = $("#AVI_estado");
	if(origen.val() == ''){
		origen.css("background","#f9c8c9");
		origen.tooltip({title:"Ingresa Estado"});
		origen.tooltip("show");
		origen.focus();
		return 1;
	}else{
		origen.css("background","#FFF");
		return 0;
	}
}

/*--------- Nombre Tripulante ---------*/
function validate_input7(){
	origen = $("#TRIP_nombre");
	if(origen.val() == ''){
		origen.css("background","#f9c8c9");
		origen.tooltip({title:"Ingresa Nombre"});
		origen.tooltip("show");
		origen.focus();
		return 1;
	}else{
		origen.css("background","#FFF");
		return 0;
	}
}

/*--------- Apellido Tripulante ---------*/
function validate_input8(){
	origen = $("#TRIP_apellido");
	if(origen.val() == ''){
		origen.css("background","#f9c8c9");
		origen.tooltip({title:"Ingresa Apellido"});
		origen.tooltip("show");
		origen.focus();
		return 1;
	}else{
		origen.css("background","#FFF");
		return 0;
	}
}

/*--------- Fch Naci Tripulante ---------*/
function validate_input9(){
	origen = $("#TRIP_fechnac");
	if(origen.val() == ''){
		origen.css("background","#f9c8c9");
		origen.tooltip({title:"Ingresa Fecha de Nacimiento"});
		origen.tooltip("show");
		origen.focus();
		return 1;
	}else{
		origen.css("background","#FFF");
		return 0;
	}
}

/*--------- Id Departamento ---------*/
function validate_input10(){
	origen = $("#idDepa");
	if(origen.val() == ''){
		origen.css("background","#f9c8c9");
		origen.tooltip({title:"Ingrese Departamento"});
		origen.tooltip("show");
		origen.focus();
		return 1;
	}else{
		origen.css("background","#FFF");
		return 0;
	}
}

/*--------- Id Provincia ---------*/
function validate_input11(){
	origen = $("#idProv");
	if(origen.val() == ''){
		origen.css("background","#f9c8c9");
		origen.tooltip({title:"Ingrese Provincia"});
		//origen.tooltip("show");
		origen.focus();
		return 1;
	}else{
		origen.css("background","#FFF");
		return 0;
	}
}

/*--------- Id Distrito ---------*/
function validate_input12(){
	origen = $("#idDist");
	if(origen.val() == ''){
		origen.css("background","#f9c8c9");
		origen.tooltip({title:"Ingrese Distrito"});
		//origen.tooltip("show");
		origen.focus();
		return 1;
	}else{
		origen.css("background","#FFF");
		return 0;
	}
}

/*--------- Domicilio Tripulante ---------*/
function validate_input13(){
	origen = $("#TRIP_domilicio");
	if(origen.val() == ''){
		origen.css("background","#f9c8c9");
		origen.tooltip({title:"Ingrese Domicilio"});
		origen.tooltip("show");
		origen.focus();
		return 1;
	}else{
		origen.css("background","#FFF");
		return 0;
	}
}

/*--------- Tipo Detalle Tripulante ---------*/
function validate_input14(){
	origen = $("#TIPTRIPDET_id");
	if(origen.val() == ''){
		origen.css("background","#f9c8c9");
		origen.tooltip({title:"Ingrese Tipo de Tripulante"});
		//origen.tooltip("show");
		origen.focus();
		return 1;
	}else{
		origen.css("background","#FFF");
		return 0;
	}
}

/*--------- Tipo Licencia ---------*/
function validate_input15(){
	origen = $("#TIPLIC_id");
	if(origen.val() == ''){
		origen.css("background","#f9c8c9");
		origen.tooltip({title:"Ingrese Tipo de Licencia"});
		origen.tooltip("show");
		origen.focus();
		return 1;
	}else{
		origen.css("background","#FFF");
		return 0;
	}
}

/*--------- Num Licencia Tripulante ---------*/
function validate_input16(){
	origen = $("#TRIP_numlicencia");
	if(origen.val() == ''){
		origen.css("background","#f9c8c9");
		origen.tooltip({title:"Ingrese Número de Licencia"});
		origen.tooltip("show");
		origen.focus();
		return 1;
	}else{
		origen.css("background","#FFF");
		return 0;
	}
}

/*--------- Id Nivel Ingles ---------*/
function validate_input17(){
	origen = $("#NIVING_id");
	if(origen.val() == ''){
		origen.css("background","#f9c8c9");
		origen.tooltip({title:"Ingrese Nivel de Inglés"});
		origen.tooltip("show");
		origen.focus();
		return 1;
	}else{
		origen.css("background","#FFF");
		return 0;
	}
}

/*--------- Id Categoria ---------*/
function validate_input18(){
	origen = $("#CAT_id");
	if(origen.val() == ''){
		origen.css("background","#f9c8c9");
		origen.tooltip({title:"Ingrese Categoría"});
		origen.tooltip("show");
		origen.focus();
		return 1;
	}else{
		origen.css("background","#FFF");
		return 0;
	}
}

/*--------- Estado Tripulante ---------*/
function validate_input19(){
	origen = $("#TRIP_estado");
	if(origen.val() == ''){
		origen.css("background","#f9c8c9");
		origen.tooltip({title:"Ingrese Estado"});
		origen.tooltip("show");
		origen.focus();
		return 1;
	}else{
		origen.css("background","#FFF");
		return 0;
	}
}

/*--------- Tipo Tripulante ---------*/
function validate_input20(){
	origen = $("#TIPTRIP_id");
	if(origen.val() == ''){
		origen.css("background","#f9c8c9");
		origen.tooltip({title:"Ingrese Tipo de Tripulante"});
		origen.tooltip("show");
		origen.focus();
		return 1;
	}else{
		origen.css("background","#FFF");
		return 0;
	}
}

/*--------- Tipo Detalle Tripulante ---------*/
function validate_input21(){
	origen = $("#TIPTRIPDET_id");
	if(origen.val() == ''){
		origen.css("background","#f9c8c9");
		origen.tooltip({title:"Ingrese Tipo Detalle de Tripulante"});
		//origen.tooltip("show");
		origen.focus();
		return 1;
	}else{
		origen.css("background","#FFF");
		return 0;
	}
}

/*--------- Tripulante ---------*/
function validate_input22(){
	origen = $("#TRIP_id");
	if(origen.val() == ''){
		origen.css("background","#f9c8c9");
		origen.tooltip({title:"Ingrese Tripulante"});
		//origen.tooltip("show");
		origen.focus();
		return 1;
	}else{
		origen.css("background","#FFF");
		return 0;
	}
}

/*--------- Fch de Vencimiento ---------*/
function validate_input23(){
	origen = $("#APT_fchvenci");
	if(origen.val() == ''){
		origen.css("background","#f9c8c9");
		origen.tooltip({title:"Ingrese Fch. de Vencimiento"});
		origen.tooltip("show");
		origen.focus();
		return 1;
	}else{
		origen.css("background","#FFF");
		return 0;
	}
}

/*--------- Fch de Gestión ---------*/
function validate_input24(){
	origen = $("#APT_fchgestion");
	if(origen.val() == ''){
		origen.css("background","#f9c8c9");
		origen.tooltip({title:"Ingrese Fch. de Gestión"});
		origen.tooltip("show");
		origen.focus();
		return 1;
	}else{
		origen.css("background","#FFF");
		return 0;
	}
}

/*--------- Tripulante Instructor ---------*/
function validate_input25(){
	origen = $("#TRIP_id_i");
	if(origen.val() == ''){
		origen.css("background","#f9c8c9");
		origen.tooltip({title:"Ingrese Instructor"});
		//origen.tooltip("show");
		origen.focus();
		return 1;
	}else{
		origen.css("background","#FFF");
		return 0;
	}
}

/*--------- Tripulante Alumno ---------*/
function validate_input26(){
    var cantidad = $("#num-alum").val();
    var variable = false;
    
    if(cantidad < 1){
        cantidad = 1;
    }
    
    for (var i = cantidad; i >= 1; i--) {
        origen = $("#TRIP_id_a" + i);
        if(origen.val() == ''){
            variable = true;
            break;
        }else{
            variable = false;
        }
    }; 
    if(variable){
        origen.css("background","#f9c8c9");
        origen.tooltip({title:"Ingrese Alumno" + i});
        origen.tooltip("show");
        origen.focus();
        return 1; 
    } else {
        origen.css("background","#FFF");
        return 0;
    }
}

/*--------- Curso Fecha inicio ---------*/
function validate_input27(){
	origen = $("#CUR_fchini");
	if(origen.val() == ''){
		origen.css("background","#f9c8c9");
		origen.tooltip({title:"Ingrese Fecha Inicio"});
		origen.tooltip("show");
		origen.focus();
		return 1;
	}else{
		origen.css("background","#FFF");
		return 0;
	}
}

/*--------- Curso Fecha fin ---------*/
function validate_input28(){
	origen = $("#CUR_fchfin");
	if(origen.val() == ''){
		origen.css("background","#f9c8c9");
		origen.tooltip({title:"Ingrese Fecha Fin"});
		origen.tooltip("show");
		origen.focus();
		return 1;
	}else{
		origen.css("background","#FFF");
		return 0;
	}
}

/*--------- Curso Fecha fin ---------*/
function validate_input29(){
	origen = $("#CUR_fchfin");
	if(origen.val() == ''){
		origen.css("background","#f9c8c9");
		origen.tooltip({title:"Ingrese Fecha Fin"});
		origen.tooltip("show");
		origen.focus();
		return 1;
	}else{
		origen.css("background","#FFF");
		return 0;
	}
}

/*--------- Curso Tipo Curso ---------*/
function validate_input30(){
	origen = $("#TIPCUR_id");
	if(origen.val() == ''){
		origen.css("background","#f9c8c9");
		origen.tooltip({title:"Ingrese Tipo de Curso"});
		//origen.tooltip("show");
		origen.focus();
		return 1;
	}else{
		origen.css("background","#FFF");
		return 0;
	}
}

/*--------- Curso Tipo Tripulante(d) ---------*/
function validate_input31(){
	origen = $("#dTIPTRIP_id");
	if(origen.val() == ''){
		origen.css("background","#f9c8c9");
		origen.tooltip({title:"Ingrese Tipo de Tripulante"});
		origen.tooltip("show");
		origen.focus();
		return 1;
	}else{
		origen.css("background","#FFF");
		return 0;
	}
}

/*--------- Tripulantes Instructor(d) ---------*/
function validate_input32(){
	origen = $("#dTRIP_id_i");
	if(origen.val() == ''){
		origen.css("background","#f9c8c9");
		origen.tooltip({title:"Ingrese Instructor"});
		//origen.tooltip("show");
		origen.focus();
		return 1;
	}else{
		origen.css("background","#FFF");
		return 0;
	}
}

/*--------- Tripulantes Alumnos(d) ---------*/
function validate_input33(){
    var cantidad = $("#num-alum").val();
    for (var i = 1; i <= cantidad; i++) {
        origen = $("#dTRIP_id_a" + i);
        if(origen.val() == ''){
            origen.css("background","#f9c8c9");
            origen.tooltip({title:"Ingrese Alumno" + i});
            //origen.tooltip("show");
            origen.focus();
            return 1;
        }else{
            origen.css("background","#FFF");
            return 0;
        }
    };
}

/*--------- Curso Fecha inicio(d) ---------*/
function validate_input34(){
	origen = $("#dCUR_fchini");
	if(origen.val() == ''){
		origen.css("background","#f9c8c9");
		origen.tooltip({title:"Ingrese Fecha Inicio"});
		origen.tooltip("show");
		origen.focus();
		return 1;
	}else{
		origen.css("background","#FFF");
		return 0;
	}
}

/*--------- Curso Fecha fin(d) ---------*/
function validate_input35(){
	origen = $("#dCUR_fchfin");
	if(origen.val() == ''){
		origen.css("background","#f9c8c9");
		origen.tooltip({title:"Ingrese Fecha Fin"});
		origen.tooltip("show");
		origen.focus();
		return 1;
	}else{
		origen.css("background","#FFF");
		return 0;
	}
}

/*--------- Curso Fecha fin(d) ---------*/
function validate_input36(){
	origen = $("#dCUR_fchfin");
	if(origen.val() == ''){
		origen.css("background","#f9c8c9");
		origen.tooltip({title:"Ingrese Fecha Fin"});
		origen.tooltip("show");
		origen.focus();
		return 1;
	}else{
		origen.css("background","#FFF");
		return 0;
	}
}

/*--------- Curso Tipo Curso(d) ---------*/
function validate_input37(){
	origen = $("#dTIPCUR_id");
	if(origen.val() == ''){
		origen.css("background","#f9c8c9");
		origen.tooltip({title:"Ingrese Tipo de Curso"});
		//origen.tooltip("show");
		origen.focus();
		return 1;
	}else{
		origen.css("background","#FFF");
		return 0;
	}
}

/*--------- Curso Tipo Chequeo ---------*/
function validate_input38(){
	origen = $("#TIPCHEQ_id");
	if(origen.val() == ''){
		origen.css("background","#f9c8c9");
		origen.tooltip({title:"Ingrese Tipo de Chuequeo"});
		//origen.tooltip("show");
		origen.focus();
		return 1;
	}else{
		origen.css("background","#FFF");
		return 0;
	}
}

/*--------- Fecha Chequeo ---------*/
function validate_input39(){
	origen = $("#CHEQ_fch");
	if(origen.val() == ''){
		origen.css("background","#f9c8c9");
		origen.tooltip({title:"Ingrese Fecha de Chequeo"});
		origen.tooltip("show");
		origen.focus();
		return 1;
	}else{
		origen.css("background","#FFF");
		return 0;
	}
}

/*--------- Simulacion Fch Ini ---------*/
function validate_input40(){
	origen = $("#SIMU_fchini");
	if(origen.val() == ''){
		origen.css("background","#f9c8c9");
		origen.tooltip({title:"Ingrese Fch. de Inicio"});
		origen.tooltip("show");
		origen.focus();
		return 1;
	}else{
		origen.css("background","#FFF");
		return 0;
	}
}

/*--------- Simulacion Fch Fin ---------*/
function validate_input41(){
	origen = $("#SIMU_fchfin");
	if(origen.val() == ''){
		origen.css("background","#f9c8c9");
		origen.tooltip({title:"Ingrese Fch. de Fin"});
		origen.tooltip("show");
		origen.focus();
		return 1;
	}else{
		origen.css("background","#FFF");
		return 0;
	}
}

/*--------- Tipo de Ausencia ---------*/
function validate_input42(){
	origen = $("#TIPAUS_id");
	if(origen.val() == ''){
		origen.css("background","#f9c8c9");
		origen.tooltip({title:"Ingrese Tipo de Ausencia"});
		//origen.tooltip("show");
		origen.focus();
		return 1;
	}else{
		origen.css("background","#FFF");
		return 0;
	}
}

/*--------- Ausencia Fch Ini ---------*/
function validate_input43(){
	origen = $("#AUS_fchini");
	if(origen.val() == ''){
		origen.css("background","#f9c8c9");
		origen.tooltip({title:"Ingrese Fch. de Inicio"});
		origen.tooltip("show");
		origen.focus();
		return 1;
	}else{
		origen.css("background","#FFF");
		return 0;
	}
}

/*--------- Ausencia Fch Fin ---------*/
function validate_input44(){
	origen = $("#AUS_fchfin");
	if(origen.val() == ''){
		origen.css("background","#f9c8c9");
		origen.tooltip({title:"Ingrese Fch. de Fin"});
		origen.tooltip("show");
		origen.focus();
		return 1;
	}else{
		origen.css("background","#FFF");
		return 0;
	}
}

/*--------- Itinerario Fch Ini ---------*/
function validate_input45(){
	origen = $("#ITI_fchini");
	if(origen.val() == ''){
		origen.css("background","#f9c8c9");
		origen.tooltip({title:"Ingrese Fch. de Fin"});
		//origen.tooltip("show");
		origen.focus();
		return 1;
	}else{
		origen.css("background","#FFF");
		return 0;
	}
}

/*--------- Itinerario Fch Fin ---------*/
function validate_input46(){
	origen = $("#ITI_fchfin");
	if(origen.val() == ''){
		origen.css("background","#f9c8c9");
		origen.tooltip({title:"Ingrese Fch. de Fin"});
		//origen.tooltip("show");
		origen.focus();
		return 1;
	}else{
		origen.css("background","#FFF");
		return 0;
	}
}

/*--------- Tripulante Piloto ---------*/
function validate_input47(){
	origen = $("#TRIP_id_Piloto");
	if(origen.val() == ''){
		origen.css("background","#f9c8c9");
		origen.tooltip({title:"Ingrese Piloto"});
		//origen.tooltip("show");
		origen.focus();
		return 1;
	}else{
		origen.css("background","#FFF");
		return 0;
	}
}

/*--------- Tripulante Copiloto ---------*/
function validate_input48(){
	origen = $("#TRIP_id_Copiloto");
	if(origen.val() == ''){
		origen.css("background","#f9c8c9");
		origen.tooltip({title:"Ingrese Copiloto"});
		//origen.tooltip("show");
		origen.focus();
		return 1;
	}else{
		origen.css("background","#FFF");
		return 0;
	}
}

/*--------- Tripulante Jefe Cabina ---------*/
function validate_input49(){
	origen = $("#TRIP_id_JejeCabina");
	if(origen.val() == ''){
		origen.css("background","#f9c8c9");
		origen.tooltip({title:"Ingrese Jefe de Cabina"});
		//origen.tooltip("show");
		origen.focus();
		return 1;
	}else{
		origen.css("background","#FFF");
		return 0;
	}
}

/*--------- Tripulante Trip. Cabina ---------*/
function validate_input50(){
    var error = 0;
    for (var i = 1; i <= $("#num-TripCabina").val(); i++) {
        origen = $("#TRIP_id_TripCabina" + i);
        if(origen.val() == ''){
            origen.css("background","#f9c8c9");
            origen.tooltip({title:"Ingrese Trip. de Cabina" + i});
            //origen.tooltip("show");
            origen.focus();
            error++;
        } else{
            origen.css("background","#FFF");
        }
    }
    
    if(error > 0){
       return 1;
    } else {
        return 0;
    }
}

function validate_input51(){
    origen = $("#CONDESP_condicional");
    if(origen.val() == ''){
        origen.css("background","#f9c8c9");
        origen.tooltip({title:"Ingrese Condicional de Vuelo"});
        //origen.tooltip("show");
        origen.focus();
        return 1;
    }else{
        origen.css("background","#FFF");
        return 0;
    }
}

function validate_input52(){
    origen = $("#CONDESP_estado");
    if(origen.val() == ''){
        origen.css("background","#f9c8c9");
        origen.tooltip({title:"Ingrese Estado"});
        //origen.tooltip("show");
        origen.focus();
        return 1;
    }else{
        origen.css("background","#FFF");
        return 0;
    }
}

/*--------- Id de Avión ---------*/
function validate_input53(){
    origen = $("#AVI_id");
    if(origen.val() == ''){
        origen.css("background","#f9c8c9");
        origen.tooltip({title:"Ingrese Avión"});
        //origen.tooltip("show");
        origen.focus();
        return 1;
    }else{
        origen.css("background","#FFF");
        return 0;
    }
}

/*--------- Fch. Ini Manto ---------*/
function validate_input54(){
    origen = $("#MANTAVI_fchini");
    if(origen.val() == ''){
        origen.css("background","#f9c8c9");
        origen.tooltip({title:"Ingrese Fecha Inicio"});
        origen.tooltip("show");
        origen.focus();
        return 1;
    }else{
        origen.css("background","#FFF");
        return 0;
    }
}

/*--------- Fch. Fin Manto ---------*/
function validate_input55(){
    origen = $("#MANTAVI_fchfin");
    if(origen.val() == ''){
        origen.css("background","#f9c8c9");
        origen.tooltip({title:"Ingrese Fecha Fin"});
        origen.tooltip("show");
        origen.focus();
        return 1;
    }else{
        origen.css("background","#FFF");
        return 0;
    }
}

/*--------- Trip. Correo ---------*/
function validate_input56(){
    origen = $("#TRIP_correo");
    if(origen.val() == ''){
        origen.css("background","#f9c8c9");
        origen.tooltip({title:"Ingrese Correo Trip."});
        origen.tooltip("show");
        origen.focus();
        return 1;
    }else{
        origen.css("background","#FFF");
        return 0;
    }
}

/*--------- Trip. Instructor ---------*/
function validate_input57(){
    origen = $("#TRIP_Instructor");
    if(origen.val() == ''){
        origen.css("background","#f9c8c9");
        origen.tooltip({title:"Ingrese si esta habilitado para Instructor"});
        //origen.tooltip("show");
        origen.focus();
        return 1;
    }else{
        origen.css("background","#FFF");
        return 0;
    }
}

/*--------- Trip. Fecha Entrega ---------*/
function validate_input58(){
    origen = $("#APT_fchentrega");
    if(origen.val() == ''){
        origen.css("background","#f9c8c9");
        origen.tooltip({title:"Ingrese fecha de Entrega de Apto."});
        //origen.tooltip("show");
        origen.focus();
        return 1;
    }else{
        origen.css("background","#FFF");
        return 0;
    }
}

/*--------- Trip. Fecha Reserva ---------*/
function validate_input59(){
    origen = $("#bITI_fch");
    if(origen.val() == ''){
        origen.css("background","#f9c8c9");
        origen.tooltip({title:"Ingrese fecha de Reserva."});
        //origen.tooltip("show");
        origen.focus();
        return 1;
    }else{
        origen.css("background","#FFF");
        return 0;
    }
}

/*--------- Trip. Código DGAC ---------*/
function validate_input60(){
    origen = $("#TRIP_DGAC");
    if(origen.val() == ''){
        origen.css("background","#f9c8c9");
        origen.tooltip({title:"Ingrese Código DGAC."});
        //origen.tooltip("show");
        origen.focus();
        return 1;
    }else{
        origen.css("background","#FFF");
        return 0;
    }
}

/*--------- Tipo de Chequeo de Manto Avión ---------*/
function validate_input61(){
    origen = $("#MANTAVI_tipoChequeo");
    if(origen.val() == ''){
        origen.css("background","#f9c8c9");
        origen.tooltip({title:"Ingrese Tipo de Chequeo"});
        //origen.tooltip("show");
        origen.focus();
        return 1;
    }else{
        origen.css("background","#FFF");
        return 0;
    }
}

/*--------- Tipo de Chequeo de Manto Avión ---------*/
function validate_input62(){
    origen = $("#MANTAVI_ordenTrabajo");
    if(origen.val() == ''){
        origen.css("background","#f9c8c9");
        origen.tooltip({title:"Ingrese el Orden de Trabajo"});
        //origen.tooltip("show");
        origen.focus();
        return 1;
    }else{
        origen.css("background","#FFF");
        return 0;
    }
}


/*--------- Ruta numVueloIDA ---------*/
function validate_input63(){
	origen = $("#RUT_num_vueloIDA");
	if(origen.val() == ''){
		origen.css("background","#f9c8c9");
		origen.tooltip({title:"Ingresa Número de Ruta de Ida"});
		origen.tooltip("show");
		origen.focus();
		return 1;
	}else{
		origen.css("background","#FFF");
		return 0;
	}
}

/*--------- Ruta numVueloVUELTA ---------*/
function validate_input64(){
	origen = $("#RUT_num_vueloVUELTA");
	if(origen.val() == ''){
		origen.css("background","#f9c8c9");
		origen.tooltip({title:"Ingresa Número de Ruta de Vuelta"});
		origen.tooltip("show");
		origen.focus();
		return 1;
	}else{
		origen.css("background","#FFF");
		return 0;
	}
}

/*--------- Ciudad de Origen ---------*/
function validate_input65(){
	origen = $("#CIU_id_origen");
	if(origen.val() == ''){
		origen.css("background","#f9c8c9");
		origen.tooltip({title:"Ingresa Ciudad de Origen"});
		origen.tooltip("show");
		origen.focus();
		return 1;
	}else{
		origen.css("background","#FFF");
		return 0;
	}
}

/*--------- Ciudad de Destino ---------*/
function validate_input66(){
	origen = $("#CIU_id_destino");
	if(origen.val() == ''){
		origen.css("background","#f9c8c9");
		origen.tooltip({title:"Ingresa Ciudad de Destino"});
		origen.tooltip("show");
		origen.focus();
		return 1;
	}else{
		origen.css("background","#FFF");
		return 0;
	}
}

/*--------- Estado de Ruta ---------*/
function validate_input67(){
	origen = $("#RUT_estado");
	if(origen.val() == ''){
		origen.css("background","#f9c8c9");
		origen.tooltip({title:"Ingresa Ciudad de Destino"});
		origen.tooltip("show");
		origen.focus();
		return 1;
	}else{
		origen.css("background","#FFF");
		return 0;
	}
}

/*--------- Hora salida Ida ---------*/
function validate_input68(){
    var cantidad = $("#num-diaIDA").val();
    var variable = false;
    
    if(cantidad < 1){
        cantidad = 1;
    }
    
    for (var i = cantidad; i >= 1; i--) {
        origen = $("#RUT_hora_salidaIDA" + i);
        if(origen.val() == ''){
            variable = true;
            break;
        }else{
            variable = false;
        }
    }; 
    if(variable){
        origen.css("background","#f9c8c9");
        origen.tooltip({title:"Ingrese Hora de Salida de Ida" + i});
        origen.tooltip("show");
        origen.focus();
        return 1; 
    } else {
        origen.css("background","#FFF");
        return 0;
    }
}

/*--------- Hora llegada Ida ---------*/
function validate_input69(){
    var cantidad = $("#num-diaIDA").val();
    var variable = false;
    
    if(cantidad < 1){
        cantidad = 1;
    }
    
    for (var i = cantidad; i >= 1; i--) {
        origen = $("#RUT_hora_llegadaIDA" + i);
        if(origen.val() == ''){
            variable = true;
            break;
        }else{
            variable = false;
        }
    }; 
    if(variable){
        origen.css("background","#f9c8c9");
        origen.tooltip({title:"Ingrese Hora de Llegada de Ida" + i});
        origen.tooltip("show");
        origen.focus();
        return 1; 
    } else {
        origen.css("background","#FFF");
        return 0;
    }
}

/*--------- Hora salida Vuelta ---------*/
function validate_input70(){
    var cantidad = $("#num-diaVUELTA").val();
    var variable = false;
    
    if(cantidad < 1){
        cantidad = 1;
    }
    
    for (var i = cantidad; i >= 1; i--) {
        origen = $("#RUT_hora_salidaVUELTA" + i);
        if(origen.val() == ''){
            variable = true;
            break;
        }else{
            variable = false;
        }
    }; 
    if(variable){
        origen.css("background","#f9c8c9");
        origen.tooltip({title:"Ingrese Hora de Salida de Vuelta" + i});
        origen.tooltip("show");
        origen.focus();
        return 1; 
    } else {
        origen.css("background","#FFF");
        return 0;
    }
}

/*--------- Hora llegada Vuelta ---------*/
function validate_input71(){
    var cantidad = $("#num-diaIDA").val();
    var variable = false;
    
    if(cantidad < 1){
        cantidad = 1;
    }
    
    for (var i = cantidad; i >= 1; i--) {
        origen = $("#RUT_hora_llegadaVUELTA" + i);
        if(origen.val() == ''){
            variable = true;
            break;
        }else{
            variable = false;
        }
    }; 
    if(variable){
        origen.css("background","#f9c8c9");
        origen.tooltip({title:"Ingrese Hora de Llegada de Vuelta" + i});
        origen.tooltip("show");
        origen.focus();
        return 1; 
    } else {
        origen.css("background","#FFF");
        return 0;
    }
}

/*--------- Dia Ida ---------*/
function validate_input72(){
    var cantidad = $("#num-diaIDA").val();
    var variable = false;
    
    if(cantidad < 1){
        cantidad = 1;
    }
    
    for (var i = cantidad; i >= 1; i--) {
        origen = $("#RUT_diaIDA" + i);
        if(origen.val() == null){
            variable = true;
            break;
        }else{
            variable = false;
        }
    }; 
    if(variable){
        origen.css("background","#f9c8c9");
        origen.tooltip({title:"Ingrese Dia(s) - Ida" + i});
        origen.tooltip("show");
        origen.focus();
        return 1; 
    } else {
        origen.css("background","#FFF");
        return 0;
    }
}

/*--------- Dia Vuelta ---------*/
function validate_input73(){
    var cantidad = $("#num-diaVUELTA").val();
    var variable = false;
    
    if(cantidad < 1){
        cantidad = 1;
    }
    
    for (var i = cantidad; i >= 1; i--) {
        origen = $("#RUT_diaVUELTA" + i);
        if(origen.val() == null){
            variable = true;
            break;
        }else{
            variable = false;
        }
    }; 
    if(variable){
        origen.css("background","#f9c8c9");
        origen.tooltip({title:"Ingrese Dia(s) - Vuelta" + i});
        origen.tooltip("show");
        origen.focus();
        return 1; 
    } else {
        origen.css("background","#FFF");
        return 0;
    }
}
