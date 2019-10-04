<?php include "header_view.php";?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
				Listado de Programación <small>Administrar Programación de Vuelo</small>
            </h1>
            <ol class="breadcrumb">
                <li><i class="fa fa-thumb-tack"></i> Programación de Vuelo</li>
                <li class="active">
                    Listado de Programación de Vuelo
                </li>
            </ol>
        </section>
        <!-- Main content -->
        <section class="content">
            <div class='box box-danger'>
                <div class="box-body">
                    <div id="MainContent_Div1" class="panel panel-default">
                        <div class="panel-heading clearfix"  style="padding: 7px !important">
                            <span><strong>Buscar Fecha</strong></span>
                        </div>
                            <div class="row-fluid">
                                <div class="form-group">
                                    <label for="bITI_fch" class="col-md-2 control-label">Fch. de Programación </label>
                                    <div class="col-md-2">
                                        <div class='input-group date datetimepicker1'>
                                            <input type="text" name="bITI_fch" id="bITI_fch" value="<?php if($_SESSION["ITI_fch"] != '') { echo $_SESSION["ITI_fch"]; } else { echo date("d/m/Y"); }?>" class="form-control input-sm" style="text-transform: uppercase; width: 100% !important;" />
                                            <span class="input-group-addon">
                                                <span class="glyphicon glyphicon-calendar"></span>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-2">
                                        <button type="button" id="listarProgramacionFch" class="btn btn-danger btn-block" onclick="listarProgramacionFch('listar');">Listar</button>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="bAVI_num_cola" class="col-md-2 control-label">N° de Cola</label>
                                    <div class="col-md-2">
                                        <select name="bAVI_id" id="bAVI_id" class="form-control input-sm js-example-basic-single">
                                            <option value="">Selecccione Avión</option>
                                        <?php foreach($this->objAvion as $listaAv){ ?>
                                            <option value="<?php echo $listaAv["AVI_id"];?>"><?php echo $listaAv["AVI_num_cola"];?></option>
                                        <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-2">
                                        <button type="button" class="btn btn-danger btn-block" onclick="listarProgramacionFch('buscar');">Buscar</button>
                                    </div>
                                </div>
                            </div>
                            <div class="clearfix" style="padding: 5px;"></div>
                    </div>
                    <div id="MainContent_listaPro" class="panel panel-default">
                        <div class="panel-heading clearfix" style="padding: 7px !important">
                            <span id="MainContent_tituloPro"><strong>Lista de Itinerario</strong></span>
                        </div>
                        <div class="area_resultado table-responsive">
                            <table id="listaItinerario" class="display" cellspacing="0" cellpadding="2">
                                <thead>
                                    <tr>
                                        <th scope="col">Item</th>
                                        <th scope="col">Avión</th>
                                        <th scope="col">N° Vuelo</th>
                                        <th scope="col">Origen</th>
                                        <th scope="col">Destino</th>
                                        <th scope="col">Hora Salida</th>
                                        <th scope="col">Hora Llegada</th>
                                        <th scope="col">Registrar</th>
                                        <th scope="col">Ver</th>
                                        <th scope="col">Editar</th>
                                    </tr>
                                </thead>
                                <tbody id="listaProgramacion">
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- /.content -->
    </div>

    <!-- Inicio Modal-->
    <div id="programacionRegistro" class="modal fade" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header" style="padding: 10px !important">
                    <table class="col-xs-12">
                        <tr>
                            <td style="text-align:left;">
                                <h4><strong id="titleForm">Ingresar la Tripulación</strong></h4>
                            </td>
                            <td>
                                <button type="button" class="close btn-lg" data-dismiss="modal" onclick="limpiarFormProgramacion();" style="background-color: red; color:white; margin:10px; padding: 0px 6px 2px 6px;text-align:right;">
                                    <span aria-hidden="true">&times;</span><span class="sr-only">Cerrar</span>
                                </button>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="modal-body" style="padding-bottom: 10px !important">
                    <div class="row">
                        <div class="col-md-12" style="padding-bottom: 10px;">
                            <label for="TIPTRIPU_id" class="col-md-4 control-label">Tipo de Tripulación:
                            <span style="color: #FF0000"><strong>*</strong></span></label>
                            <div class="col-md-7">
                                <input type="hidden" name="TIPTRIPU_id_piloto" id="TIPTRIPU_id_piloto" value="1" />
                                <select name="TIPTRIPU_id_cabina" id="TIPTRIPU_id_cabina" class="form-control input-sm js-example-basic-single" disabled="disabled" >
                                <?php foreach($this->objTripulacion as $lista){ ?>
                                    <option value="<?php echo $lista["TIPTRIPU_id"];?>"><?php echo utf8_encode($lista["TIPTRIPU_descripcion"]);?></option>
                                <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12" style="padding-bottom: 10px;">
                            <label for="TRIP_id_Instructor" class="col-md-4 control-label">Instructor: </label>
                            <div class="col-md-7">
                                <select name="TRIP_id_Instructor" id="TRIP_id_Instructor" class="form-control input-sm js-example-basic-single" onchange="validarObligatorioInstructor(); validarCopilotoxInstructor('1');" >
                                    <option value="" selected>Seleccionar Instructor</option>
                                <?php foreach($this->objTripVuelo as $lista){ ?>
                                    <option value="<?php echo $lista["TRIP_id"];?>"><?php echo utf8_encode($lista["TRIP_nombre"]." ".$lista["TRIP_apellido"]);?></option>
                                <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12" style="padding-bottom: 10px;">
                            <label for="TRIP_id_Piloto" class="col-md-4 control-label">Piloto:
                            <span style="color: #FF0000" id="asteriscoPiloto"><strong>*</strong></span></label>
                            <div class="col-md-7">
                                <select name="TRIP_id_Piloto" id="TRIP_id_Piloto" class="form-control input-sm js-example-basic-single"  onchange="validarObligatorioPiloto(); validarCopilotoxPiloto('1');" >
                                    <option value="" selected>Seleccionar Piloto</option>
                                <?php foreach($this->objTripVuelo as $lista){ ?>
                                    <option value="<?php echo $lista["TRIP_id"];?>"><?php echo utf8_encode($lista["TRIP_nombre"]." ".$lista["TRIP_apellido"]);?></option>
                                <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12" style="padding-bottom: 10px;">
                            <label for="TRIP_id_Copiloto" class="col-md-4 control-label">Copiloto:
                            <span style="color: #FF0000" id="asteriscoCopiloto"><strong>*</strong></span></label>
                            <div class="col-md-7">
                                <select name="TRIP_id_Copiloto" id="TRIP_id_Copiloto" class="form-control input-sm js-example-basic-single" onchange="validarObligatorioCopiloto();">
                                    <option value="" selected>Seleccionar Copiloto</option>
                                <?php foreach($this->objTripVuelo as $lista){ ?>
                                    <option value="<?php echo $lista["TRIP_id"];?>"><?php echo utf8_encode($lista["TRIP_nombre"]." ".$lista["TRIP_apellido"]);?></option>
                                <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12" style="padding-bottom: 10px;">
                            <label for="TRIP_id_JejeCabina" class="col-md-4 control-label">Jefe de Cabina:
                            <span style="color: #FF0000"><strong>*</strong></span></label>
                            <div class="col-md-7">
                                <select name="TRIP_id_JejeCabina" id="TRIP_id_JejeCabina" class="form-control input-sm js-example-basic-single" >
                                    <option value="" selected>Seleccionar Jefe Cabina</option>
                                <?php foreach($this->objTripCabina as $lista){ ?>
                                    <option value="<?php echo $lista["TRIP_id"];?>"><?php echo utf8_encode($lista["TRIP_nombre"]." ".$lista["TRIP_apellido"]);?></option>
                                <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12" style="padding-bottom: 10px;">
                            <label for="TRIP_id_TripCabina" class="col-md-4 control-label">Tripulante de Cabina
                            <span style="color: #FF0000"><strong>*</strong></span></label>
                            <div class="col-md-7" id="divTripCabina">
                                <div class="col-xs-8 col-md-8" style="padding: 0px">
                                    <select name="TRIP_id_TripCabina1" id="TRIP_id_TripCabina1" class="form-control input-sm js-example-basic-single" >
                                        <option value="" selected>Seleccionar Trip. Cabina</option>
                                    <?php foreach($this->objTripCabina as $lista){ ?>
                                        <option value="<?php echo $lista["TRIP_id"];?>"><?php echo utf8_encode($lista["TRIP_nombre"]." ".$lista["TRIP_apellido"]);?></option>
                                    <?php } ?>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <span class="input-group-btn">
                                        <input name="num-TripCabina" id="num-TripCabina" value="1" type="hidden">
                                        <button id="agregar_TripCabina" class="btn btn-default input-group-abdon" type="button" onclick="agregar_TripCabina()" style="color:green">
                                            <span class="glyphicon glyphicon-plus"></span>
                                        </button>
                                        <button id="quitar_TripCabina" class="btn btn-default input-group-abdon" type="button" onclick="quitar_TripCabina()" style="color:red">
                                            <span class="glyphicon glyphicon-minus"></span>
                                        </button>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12" style="padding-bottom: 4px;">
                            <label for="TRIP_id_ApoyoVuelo" class="col-md-4 control-label">Apoyo en Vuelo:</label>
                            <div class="col-md-7">
                                <select name="TRIP_id_ApoyoVuelo" id="TRIP_id_ApoyoVuelo" class="form-control input-sm js-example-basic-single" >
                                    <option value="" selected>Seleccionar Apoyo Vuelo</option>
                                <?php foreach($this->objTripCabina as $lista){ ?>
                                    <option value="<?php echo $lista["TRIP_id"];?>"><?php echo utf8_encode($lista["TRIP_nombre"]." ".$lista["TRIP_apellido"]);?></option>
                                <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12" style="padding-bottom: 10px !important; display:none;" id="divAUD_usu_cre">
                            <label for="AUD_usu_cre" class="col-md-5 control-label">Usuario de Creación:
                            <span style="color: #FF0000"><strong>*</strong></span></label>
                            <div class="col-md-6">
                               <input type="text" name="AUD_usu_cre" id="AUD_usu_cre" class="form-control input-sm numberDecimal" style="text-transform: uppercase; width: 100% !important;" />
                            </div>
                        </div>
                        <div class="col-md-12" style="padding-bottom: 10px !important; display:none;" id="divAUD_fch_cre">
                            <label for="AUD_fch_cre" class="col-md-5 control-label">Fecha de Creación:
                            <span style="color: #FF0000"><strong>*</strong></span></label>
                            <div class="col-md-6">
                               <input type="text" name="AUD_fch_cre" id="AUD_fch_cre" class="form-control input-sm numberDecimal" style="text-transform: uppercase; width: 100% !important;" />
                            </div>
                        </div>
                        <div class="col-md-12" style="padding-bottom: 10px !important; display:none;" id="divAUD_usu_mod">
                            <label for="AUD_usu_mod" class="col-md-5 control-label">Usuario de Mod.:
                            <span style="color: #FF0000"><strong>*</strong></span></label>
                            <div class="col-md-6">
                               <input type="text" name="AUD_usu_mod" id="AUD_usu_mod" class="form-control input-sm numberDecimal" style="text-transform: uppercase; width: 100% !important;" />
                            </div>
                        </div>
                        <div class="col-md-12" style="padding-bottom: 10px !important; display:none;" id="divAUD_fch_mod">
                            <label for="AUD_fch_mod" class="col-md-5 control-label">Fecha de Mod.:
                            <span style="color: #FF0000"><strong>*</strong></span></label>
                            <div class="col-md-6">
                               <input type="text" name="AUD_fch_mod" id="AUD_fch_mod" class="form-control input-sm numberDecimal" style="text-transform: uppercase; width: 100% !important;" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer" style="padding: 10px !important">
                    <button name='insertProgramacion' id='insertProgramacion' type="button" class="btn btn-sm" onclick="insertProgramacion('insert');">Grabar</button>
                    <button name='updateProgramacion' id='updateProgramacion' type="button" class="btn btn-sm" onclick="insertProgramacion('update');">Modificar</button>
                    <button name="closeProgramacion" id="closeProgramacion" type="button" class="btn btn-danger btn-sm" data-dismiss="modal" onclick="limpiarFormProgramacion();">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Fin Modal-->
    
    <div id="programacionRegistroTipoTripulacion" class="modal fade" data-backdrop="static" data-keyboard="false" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header" style="padding: 10px !important">
                    <table class="col-xs-12">
                        <tr>
                            <td style="text-align:left;">
                                <h4><strong id="titleForm">Ingresar Tipo de Tripulación</strong></h4>
                            </td>
                            <td>
                                <button type="button" class="close btn-lg" data-dismiss="modal" onclick="programacionRegistroCerrar();" style="background-color: red; color:white; margin:10px; padding: 0px 6px 2px 6px;text-align:right;">
                                    <span aria-hidden="true">&times;</span><span class="sr-only">Cerrar</span>
                                </button>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="modal-body" style="padding-bottom: 10px !important">
                    <div class="row">
                        <div class="col-md-12" style="padding-bottom: 10px;">
                            <label for="TIPTRIPU_id" class="col-md-4 control-label">Tipo de Tripulación:
                            <span style="color: #FF0000"><strong>*</strong></span></label>
                            <div class="col-md-7">
                                <input type="hidden" name="ITI_id" id="ITI_id" value="" />
                                <input type="hidden" name="RUT_num_vuelo" id="RUT_num_vuelo" value="" />
                                <input type="hidden" name="TIPTRIPU_id_piloto_ini" id="TIPTRIPU_id_piloto_ini" value="1" />
                                <select name="TIPTRIPU_id_cabina_ini" id="TIPTRIPU_id_cabina_ini" class="form-control input-sm js-example-basic-single">
                                <?php foreach($this->objTripulacion as $lista){ ?>
                                    <option value="<?php echo $lista["TIPTRIPU_id"];?>"><?php echo utf8_encode($lista["TIPTRIPU_descripcion"]);?></option>
                                <?php } ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer" style="padding: 10px !important">
                    <button name='insertTipoTripulacion' id='insertTipoTripulacion' type="button" class="btn btn-sm" onclick="insertTipoTripulacion();">Siguiente</button>
                    <button name="closeProgramacion" id="closeProgramacion" type="button" class="btn btn-danger btn-sm" data-dismiss="modal" onclick="programacionRegistroCerrar();">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
    
    <script type="text/javascript">
        $(function () {
            $( "#listarProgramacionFch" ).click();
        });
        
        function listarCabinaView(newnum,TIPTRIPU_id_cabina,TIPTRIPU_id_piloto){
            listarCabina('<?php echo URLLOGICA?>motor/listarTripulantesMotor/',newnum,TIPTRIPU_id_cabina,TIPTRIPU_id_piloto);
        }
        
        function listarProgramacionFch(accion){
            $("#preloader").css("display","block");
            var url = "<?php echo URLLOGICA?>programacion/listarProgramacionFch/";
            
            var table = $('#listaItinerario').DataTable();
            table.destroy();
            
            if(accion == 'listar'){
                $("#bAVI_id").val("").trigger('change.select2');
                var parametros = {
                    "accion" : accion,
                    "ITI_fch" : $("#bITI_fch").val(),
                };
            }
            if(accion == 'buscar'){
                var parametros = {
                    "accion" : accion,
                    "ITI_fch" : $("#bITI_fch").val(),
                    "AVI_id" : $("#bAVI_id").val()
                };
            }
            
            $.post(url,parametros,
            function(data){
                if(data == ""){
                    //alert("No existe datos de la Fecha Seleccionada.");
                    $("#listaProgramacion").empty();
                    myDataTables_sinPaginacion('listaItinerario');
                    $("#preloader").css("display", "none");
                } else {
                    $("#listaProgramacion").empty();
                    //$("#listaItinerario >tbody").empty();
                    
                    for (var i = 1; i <= data.length; i++) {
                    if(data[i-1]["Registrado"] == 'Si'){
                        var disabled = '';
                        var disabled_reg = 'disabled = "disabled"';
                    }
                    else {
                        var disabled = 'disabled = "disabled"';
                        var disabled_reg = '';
                    }
                    html = '<tr>'
                            + '<td style="width:auto;">' + i + '</td>'
                            //+ '<td style="width:auto;">' + data[i-1]["AVI_num_cola"] + '</td>'
                            + '<td style="width:auto;">'
                                + '<select name="AVI_id' + (i) + '" id="AVI_id' + (i) + '" class="form-control input-sm js-example-basic-single_extra">'
                                    + '<option value="">Selecccione Avión</option>'
                                + '</select>'
                            + '</td>'
                            + '<td style="width:auto;">' + data[i-1]["RUT_num_vuelo"] + '</td>'
                            + '<td style="width:auto;">' + data[i-1]["CIU_id_origen"] + '</td>'
                            + '<td style="width:auto;">' + data[i-1]["CIU_id_destino"] + '</td>'
                            + '<td style="width:auto;">' + data[i-1]["RUT_hora_salida"] + '</td>'
                            + '<td style="width:auto;">' + data[i-1]["RUT_hora_llegada"] + '</td>'
                            + '<td style="width:auto; text-align: center;">'
                                <?php  $Bdisabled = 0; ?>
                                <?php foreach ($this->objBotton as $botton) { ?>
                                    <?php if($botton["Funcion"] == "registrarProgramacion"){ ?>
                                        <?php  $Bdisabled += 1; ?>
                                    <?php } ?>
                                <?php } ?>
                                <?php if($Bdisabled > 0){ $disabled = ""; } else { $disabled = "disabled"; } ?>
                                    + '<button type="button" class="fa fa-users" data-toggle="modal" data-target="#programacionRegistroTipoTripulacion" <?php echo $disabled;?> onclick="listarTipoTripulacion(' + data[i-1]["ITI_id"] + ',\'' + data[i-1]["RUT_num_vuelo"] + '\');" ' + disabled_reg + '></button>'
                            + '</td>'
                            + '<td style="width:auto;">'
                                <?php  $Bdisabled = 0; ?>
                                <?php foreach ($this->objBotton as $botton) { ?>
                                    <?php if($botton["Funcion"] == "listarProgramacion"){ ?>
                                        <?php  $Bdisabled += 1; ?>
                                    <?php } ?>
                                <?php } ?>
                                <?php if($Bdisabled > 0){ $disabled = ""; } else { $disabled = "disabled"; } ?>
                                    + '<button type="button" class="fa fa-eye" data-toggle="modal"  data-target="#programacionRegistro" onclick="listarDetProgramacion(' + data[i-1]["ITI_id"] + ',\'' + data[i-1]["RUT_num_vuelo"] + '\',\'listar\')" <?php echo $disabled;?> ' + disabled + '></button>'
                            + '</td>'
                            + '<td style="width:auto;">'
                                <?php  $Bdisabled = 0; ?>
                                <?php foreach ($this->objBotton as $botton) { ?>
                                    <?php if($botton["Funcion"] == "updateProgramacion"){ ?>
                                        <?php  $Bdisabled += 1; ?>
                                    <?php } ?>
                                <?php } ?>
                                <?php if($Bdisabled > 0){ $disabled = ""; } else { $disabled = "disabled"; } ?>
                                    + '<button type="button" class="fa fa-pencil" data-toggle="modal"  data-target="#programacionRegistro" onclick="listarDetProgramacion(' + data[i-1]["ITI_id"] + ',\'' + data[i-1]["RUT_num_vuelo"] + '\',\'modificar\')" <?php echo $disabled;?> ' + disabled + '></button>'
                            + '</td>'
                        + '</tr>';
                        $("#listaProgramacion").append(html);
                        listarComboAvionDisponiblesView($("#AVI_id" + i),$("#bITI_fch").val(),$("#bITI_fch").val());
                        q++;
                        p[q] = i;
                    };
                        setTimeout(function(){
                            for(var r = 1; r <= data_matriz.length; r++){
                                var s = p[r];
                                $("#AVI_id" + r).val(data_matriz[s-1]["AVI_id"]).trigger('change.select2');;
                            }
                        },1000);
                    $(document).ready(function() { $(".js-example-basic-single_extra").select2(); });
                    myDataTables_sinPaginacion('listaItinerario');
                    $("#preloader").css("display", "none");
                }
            });
        }
        
        function listarTripulantesMotor(url,ITI_id,TRIP_id,RUT_num_vuelo,TIPTRIPU_id_cabina,TIPTRIPU_id_piloto){
            //var url = "<?php echo URLLOGICA?>motor/listarTripulantesMotor/";
            $("#preloader").css("display","block");
            
            listarInstructor(url,RUT_num_vuelo,TIPTRIPU_id_cabina,TIPTRIPU_id_piloto);
            listarPiloto(url,RUT_num_vuelo,TIPTRIPU_id_cabina,TIPTRIPU_id_piloto);
            listarJefeCabina(url,RUT_num_vuelo,TIPTRIPU_id_cabina,TIPTRIPU_id_piloto);
            listarCabina(url,'1',RUT_num_vuelo,TIPTRIPU_id_cabina,TIPTRIPU_id_piloto);
            listarApoyo(url,RUT_num_vuelo,TIPTRIPU_id_cabina,TIPTRIPU_id_piloto);
            
            $("#preloader").css("display", "none");
        }
        
        function validarCopilotoxInstructor(valor){
            //$("#TRIP_id_Copiloto").val("").trigger('change.select2')
            $("#TRIP_id_Copiloto").val("").trigger('change.select2');
            var TRIP_id = $("#TRIP_id_Instructor").val();
            var ITI_id = $("#ITI_id").val();
            var RUT_num_vuelo = $("#RUT_num_vuelo").val();
            var TIPTRIPU_id_cabina = $("#TIPTRIPU_id_cabina_ini").val();
            var TIPTRIPU_id_piloto = $("#TIPTRIPU_id_piloto_ini").val();
            
            listarCopiloto('<?php echo URLLOGICA?>motor/listarTripulantesMotor/',TRIP_id,RUT_num_vuelo,TIPTRIPU_id_cabina,TIPTRIPU_id_piloto);
        }
        
        function validarCopilotoxPiloto(valor){
            //
            if($("#TRIP_id_Piloto").val() != ''){
                $("#TRIP_id_Copiloto").val("").trigger('change.select2');
                var TRIP_id = $("#TRIP_id_Piloto").val();
                var ITI_id = $("#ITI_id").val();
                var RUT_num_vuelo = $("#RUT_num_vuelo").val();
                var TIPTRIPU_id_cabina = $("#TIPTRIPU_id_cabina_ini").val();
                var TIPTRIPU_id_piloto = $("#TIPTRIPU_id_piloto_ini").val();
                listarCopiloto('<?php echo URLLOGICA?>motor/listarTripulantesMotor/',TRIP_id,RUT_num_vuelo,TIPTRIPU_id_cabina,TIPTRIPU_id_piloto);
            }
        }
        
        function programacionRegistroCerrar(){
            $("#programacionRegistro").modal("hide");
        }
        
        function listarTipoTripulacion(ITI_id,RUT_num_vuelo){
            $("#ITI_id").val(ITI_id);
            $("#RUT_num_vuelo").val(RUT_num_vuelo);
        }
        
        function insertTipoTripulacion(){
            var ITI_id = $("#ITI_id").val();
            var TRIP_id = '';
            var RUT_num_vuelo = $("#RUT_num_vuelo").val();
            var TIPTRIPU_id_cabina = $("#TIPTRIPU_id_cabina_ini").val();
            var TIPTRIPU_id_piloto = $("#TIPTRIPU_id_piloto_ini").val();
            $("#TIPTRIPU_id_cabina").val(TIPTRIPU_id_cabina).trigger('change.select2');
            $("#TIPTRIPU_id_piloto").val(TIPTRIPU_id_piloto);
            
            listarTripulantesMotor('<?php echo URLLOGICA?>motor/listarTripulantesMotor/',ITI_id,TRIP_id,RUT_num_vuelo,TIPTRIPU_id_cabina,TIPTRIPU_id_piloto);
            $("#programacionRegistroTipoTripulacion").modal("hide");
            $("#programacionRegistro").modal("show");
        }
        
        function insertProgramacion(accion){
            var url = "<?php echo URLLOGICA?>programacion/insertProgramacion/";
            $("#preloader").css("display","block");
           
            if(validate_formProgramacion()) {
                var parametros = {
                    "accion": accion,
                    "ITI_id" : $("#ITI_id").val(),
                    "RUT_num_vuelo" : $("#RUT_num_vuelo").val(),
                    "ITI_fch" : $("#bITI_fch").val(),
                    "TRIP_id_Instructor" : $("#TRIP_id_Instructor").val(),
                    "TRIP_id_Piloto" : $("#TRIP_id_Piloto").val(),
                    "TIPTRIPU_id" : $("#TIPTRIPU_id_cabina").val(),
                    "TRIP_id_Copiloto" : $("#TRIP_id_Copiloto").val(),
                    "TRIP_id_JejeCabina" : $("#TRIP_id_JejeCabina").val(),
                    "TRIP_id_ApoyoVuelo" : $("#TRIP_id_ApoyoVuelo").val(),
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
                        alert("Se ha registrado correctamente los Tripulantes.");
                    }
                    $('#programacionRegistro').modal('hide');
                    location.reload(true);
                    //listarProgramacionFch();
                });
            } else{
                alert("Ingresar Información");
                $("#preloader").css("display","none");
            }
        }
        
        function listarComboAvionDisponiblesView(select,ITI_fchini,ITI_fchfin){
            listarComboAvionDisponibles('<?php echo URLLOGICA?>avion/listarAvionDisponiblesxFecha/',select,ITI_fchini,ITI_fchfin);
        }
        
        $('#programacionRegistro').on('show.bs.modal', function (e) {
            $("#updateProgramacion").hide();
        })
        
        $('#programacionRegistro').on('hidden.bs.modal', function (e) {
            limpiarFormProgramacion();
        })
    </script>
    <!-- /.content-wrapper -->
    <?php include "footer_view.php";?>
