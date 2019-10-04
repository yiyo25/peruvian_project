<?php include "header_view.php";?>
<div class="preloaderMotor" id="preloaderMotor"></div>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
				Gestionar de Programación <small>Resúmen Programación de Vuelo</small>
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
                                <label for="bITI_fch" class="col-xs-4 col-md-2 control-label">Fch. de Programación </label>
                                <div class="col-xs-4 col-md-2">
                                    <div class='input-group date datetimepicker1'>
                                        <input type="text" name="bITI_fch" id="bITI_fch" value="<?php if($_SESSION["ITI_fch"] != '') { echo $_SESSION["ITI_fch"]; } else { echo date("d/m/Y"); }?>" class="form-control input-sm" style="text-transform: uppercase; width: 100% !important;" />
                                        <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-calendar"></span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-xs-2 col-offset-xs-2 col-md-2" style="padding-bottom: 5px;">
                                    <button type="button" id="listarProgramacionFchResumen" class="btn btn-danger btn-block" onclick="listarProgramacionFchResumen('<?php echo URLLOGICA?>programacion/listarProgramacionFchResumenMatriz/','<?php echo URLLOGICA?>programacion/listarProgramacionFchResumen/','listar');">Listar</button>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="bAVI_num_cola" class="col-xs-4 col-md-2 control-label">N° de Cola</label>
                                <div class="col-xs-4 col-md-2">
                                    <select name="bAVI_id" id="bAVI_id" class="form-control input-sm js-example-basic-single">
                                        <option value="">Selecccione Avión</option>
                                    <?php foreach($this->objAvion as $listaAv){ ?>
                                        <option value="<?php echo $listaAv["AVI_id"];?>"><?php echo $listaAv["AVI_num_cola"];?></option>
                                    <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-xs-2 col-offset-xs-2 col-md-2">
                                    <button type="button" class="btn btn-danger btn-block" onclick="listarProgramacionFchResumen('<?php echo URLLOGICA?>programacion/listarProgramacionFchResumenMatriz/','<?php echo URLLOGICA?>programacion/listarProgramacionFchResumen/','buscar');">Buscar</button>
                                </div>
                            </div>
                        </div>
                        <div class="clearfix" style="padding: 5px;"></div>
                    </div>
                    <div id="MainContent_listaPro" class="panel panel-default">
                        <div class="panel-heading clearfix" style="padding: 7px !important">
                            <div class="col-xs-4 col-md-2">
                                <span id="MainContent_tituloPro"><strong>Lista de Programación</strong></span>
                            </div>
                            <div class="col-xs-7 col-md-4  col-md-offset-5">
                                <label for="TIP_trabajo" class="col-xs-5 col-md-5 col-md-offset-1 control-label">Modo de Trabajo</label>
                                <div class="col-xs-6 col-offset-xs-1 col-md-6">
                                    <?php 
                                    $disabled = '';
                                    $activo = 'OBSERVAR';
                                    $colorActivo = 'success';
                                                
                                    $inactivo = 'REPROGRAMAR';
                                    $colorInactivo = 'info';
                                    $checked = "checked";
                                    
                                    if($this->objModoTrabajo[0]["FLAG_estado"] == '1' and $this->objModoTrabajo[0]["AUD_usu_cre"] == $this->objUsu["Usuario"]){  
                                        $checked = '';
                                    } else if($this->objModoTrabajo[0]["FLAG_estado"] == '1' and $this->objModoTrabajo[0]["AUD_usu_cre"] != $this->objUsu["Usuario"]){
                                        $disabled2 = 'disabled';
                                        $checked = 'checked="checked"';
                                    }
                                    ?>
                                    
                                    <?php  $Bdisabled = 0; ?>
                                    <?php foreach ($this->objBotton as $botton) { ?>
                                        <?php if($botton["Funcion"] == "swicthProgramacion"){ ?>
                                            <?php  $Bdisabled += 1; ?>
                                        <?php } ?>
                                    <?php } ?>
                                    <?php if($Bdisabled > 0){ $disabled = ""; } else { $disabled = "disabled"; } ?>
                                    
                                    <input type="checkbox" id="TIP_trabajo" data-toggle="toggle" data-on="<?php echo $activo;?>" data-off="<?php echo $inactivo;?>" data-onstyle="<?php echo $colorActivo;?>" data-offstyle="<?php echo $colorInactivo;?>" <?php echo $disabled;?> <?php echo $disabled2;?> onchange="insertEstadoFlag();" <?php echo $checked?>>
                                </div>
                            </div>
                            <div class="col-xs-1 col-md-1">
                                <a id="excelProgramacion" href="<?php echo URLLOGICA;?>excel/programacion_excel/<?php echo $_SESSION["ITI_fch"];?>" class="logo">
                                    <img src="<?php echo URLPUBLIC;?>/img/excel.png" />
                                </a>
                            </div>
                        </div>
                        <div class="area_resultado table-responsive">
                            <table id="listaItinerario" class="display" cellspacing="0" cellpadding="2">
                                <thead>
                                    <tr>
                                        <th scope="col" rowspan="2" style="text-align: center">N°</th>
                                        <th scope="col" rowspan="2" style="text-align: center">Vuelo</th>
                                        <th scope="col" colspan="2" style="text-align: center">Avión</th>
                                        <th scope="col" rowspan="2" style="text-align: center">Origen</th>
                                        <th scope="col" rowspan="2" style="text-align: center">Destino</th>
                                        <th scope="col" rowspan="2" style="text-align: center">Hora Salida</th>
                                        <th scope="col" rowspan="2" style="text-align: center">Hora Llegada</th>
                                        <th scope="col" colspan="5" style="text-align: center">Tripulantes</th>
                                        <th scope="col" rowspan="2" style="text-align: center">Ver</th>
                                        <th scope="col" rowspan="2" style="text-align: center">Edit</th>
                                        <th scope="col" rowspan="2" style="text-align: center">Cancel</th>
                                    </tr>
                                    <tr>
                                        <th scope="col">N° de Cola</th>
                                        <th scope="col">Edit</th>
                                        <th scope="col">Instructor/<br/>Piloto</th>
                                        <th scope="col">Copiloto</th>
                                        <th scope="col">Jefe Cabina</th>
                                        <th scope="col">Trip. Cabina</th>
                                        <th scope="col">Apoyo Vuelo</th>
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
        <input type="hidden" id="FLAG_estado" name="FLAG_estado" value="<?php echo $_SESSION["FLAG_estado"];?>" />
    </div>

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
                                <input type="hidden" name="ITI_id" id="ITI_id" value="" />
                                <input type="hidden" name="RUT_num_vuelo" id="RUT_num_vuelo" value="" />
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
                                <select name="TRIP_id_Instructor" id="TRIP_id_Instructor" class="form-control input-sm js-example-basic-single" onchange="validarObligatorioInstructor();" >
                                    <option value="" selected>Seleccionar Instructor</option>
                                <?php foreach($this->objTripVuelo as $lista){ ?>
                                    <option value="<?php echo $lista["TRIP_id"];?>"><?php echo utf8_encode($lista["TRIP_nombre"]." ".$lista["TRIP_apellido"]);?></option>
                                <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12" style="padding-bottom: 10px;">
                            <label for="TRIP_instructor" class="col-md-1 col-md-offset-3 control-label">Piloto:</label>
                            <div class="col-md-1">
                                <input type="radio" id="TRIP_instructorP" name="TRIP_instructor" value="InstructorPiloto" disabled="disabled" onclick="validarTRIP_instructorxPiloto();">
                            </div>
                            <label for="TRIP_instructor" class="col-md-2 control-label">Copiloto:</label>
                            <div class="col-md-1">
                                <input type="radio" id="TRIP_instructorC" name="TRIP_instructor" value="InstructorCopiloto" disabled="disabled" onclick="validarTRIP_instructorxCopiloto();">
                            </div>
                            <label for="TRIP_instructor" class="col-md-2 control-label">Instructor:</label>
                            <div class="col-md-1">
                                <input type="radio" id="TRIP_instructorI" name="TRIP_instructor" value="InstructorInstructor" disabled="disabled" onclick="validarTRIP_instructorxInstructor();">
                            </div>
                        </div>
                        <div class="col-md-12" style="padding-bottom: 10px;">
                            <label for="TRIP_id_Piloto" class="col-md-4 control-label">Piloto:
                            <span style="color: #FF0000" id="asteriscoPiloto"><strong>*</strong></span></label>
                            <div class="col-md-7">
                                <input name="TRIP_id_PilotoHidden" id="TRIP_id_PilotoHidden" value="" type="hidden">
                                <select name="TRIP_id_Piloto" id="TRIP_id_Piloto" class="form-control input-sm js-example-basic-single"  onchange="validarCopilotoxPiloto('<?php echo URLLOGICA?>motor/listarTripulantesMotorView/','1');"> <!-- validarObligatorioPiloto(); -->
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
                                <input name="TRIP_id_CopilotoHidden" id="TRIP_id_CopilotoHidden" value="" type="hidden">
                                <select name="TRIP_id_Copiloto" id="TRIP_id_Copiloto" class="form-control input-sm js-example-basic-single" > <!--onchange="validarObligatorioCopiloto();"-->
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
                        <div class="col-md-12" style="padding-bottom: 10px;">
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
    
    <input type="hidden" id="divCambio" name="divCambio" value="<?php echo $this->objCambio;?>" />
    <div class="modal fade" id="divCambioMotor" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4>
                        <i class="fa fa-exclamation-triangle" aria-hidden="true" style="color:#1175AA; font-size: 20px;"></i>
                        <strong id="titleForm">        MENSAJE IMPORTANTE</strong>
                        <button type="button" class="close btn-lg" data-dismiss="modal" style="background-color: red; color:white; margin:10px; padding: 0px 6px 2px 6px;text-align:right;">
                            <span aria-hidden="true">&times;</span><span class="sr-only">Cerrar</span>
                        </button>
                    </h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12" style="padding-bottom: 10px;">
                            <p>Se ha detectado cambios que afectan la programación vigente, se procederá a realizar la reprogramación correspondiente</p>
                            <p>Por el momento, sólo podrá acceder en modo consulta. Dar click en [Continuar].</p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type='button' id='' name='' class="btn btn-sm" data-dismiss="modal">Continuar</button>
                </div>
            </div>
        </div>
    </div>
    
    <script type="text/javascript">
        var myVar = setInterval(flagEstado, 2000);
        var cambioEstado = false;
        var usu_trabajo = 'MOTOR';
        
        $(function () {
            resetEstado_Motor();
            $("#bodyProgVuelo").prop("class","skin-blue sidebar-mini sidebar-collapse");
            $("#listarProgramacionFchResumen").click();
            if($("#divCambio").val() == 'divCambio' ){
                $("#divCambioMotor").modal('show');
                ejecucionMotorView();
            }
        });
        
        function flagEstado() {
            var url = "<?php echo URLLOGICA?>motor/verificarEstadoFlag/";

            var parametros = {};
            $.post(url,parametros,
            function(data){
                
                if(data[0]["FLAG_estado"] != $("#FLAG_estado").val()){
                    $("#FLAG_estado").val(data[0]["FLAG_estado"]);
                    cambioEstado = true;
                } else{
                    cambioEstado = false;
                }

                if($("#FLAG_estado").val() == '1' && cambioEstado){
                    $("#listarProgramacionFchResumen").click();
                    usu_trabajo = data[0]["AUD_usu_cre"];
                    if($("#Usuario").val() !=  data[0]["AUD_usu_cre"]){
                        $("#TIP_trabajo").val(data[0]["FLAG_estado"]);
                        $("#TIP_trabajo").prop("disabled","disabled");
                        $("#usuEdicion").text(usu_trabajo);
                        $("#TipoTrabajoMensaje").modal('show');
                    }
                }
                if($("#FLAG_estado").val() == '0' && cambioEstado){
                    $("#TIP_trabajo").val(data[0]["FLAG_estado"]);
                    $("#TIP_trabajo").removeAttr("disabled");
                    $("#listarProgramacionFchResumen").click();
                }
            });
        }
        
        function insertEstadoFlag(){            
            var url = "<?php echo URLLOGICA?>motor/insertEstadoFlag/";
            $("#preloader").css("display","block");
            
            if ($('#TIP_trabajo').bootstrapSwitch('state') == true){
                var TIP_trabajo = 0;
            } else if ($('#TIP_trabajo').bootstrapSwitch('state') == false){
                var TIP_trabajo = 1;
            }
                
            var parametros = {
                "TIP_trabajo" : TIP_trabajo,
            };

            $.post(url,parametros,
            function(data){
                $("#preloader").css("display", "none");
            });
        }
        
        function listarProgramacionFchResumen(url_matriz,url,accion){
            url_avion = "<?php echo URLLOGICA?>avion/listarAvionNoDisponiblexItinerario/";
            
            $("#preloader").css("display","block");

            var table = $('#listaItinerario').DataTable();
            table.destroy();

            if(accion == 'listar'){
                $("#bAVI_id").val("").trigger('change.select2');
                var parametros = {
                    "accion" : accion,
                    "ITI_fch" : $("#bITI_fch").val(),
                };
                $("#excelProgramacion").prop("href","<?php echo URLLOGICA;?>excel/programacion_excel/" + $("#bITI_fch").val());
            }
            if(accion == 'buscar'){
                var parametros = {
                    "accion" : accion,
                    "ITI_fch" : $("#bITI_fch").val(),
                    "AVI_id" : $("#bAVI_id").val()
                };
            }

            $.post(url_matriz,parametros,
            function(data_matriz){
                if(data_matriz == ""){
                    //alert("No existe datos de la Fecha Seleccionada.");
                    $("#listaProgramacion").empty();
                    myDataTables_sinPaginacion('listaItinerario');
                    $("#preloader").css("display", "none");
                } else {
                    $.post(url_avion,parametros,
                    function(dataAvionesNoDisponibles){
                        
                        $.post(url,parametros,
                        function(data){
                            if(data == ""){
                                //alert("No existe datos de la Fecha Seleccionada.");
                                $("#listaProgramacion").empty();
                                myDataTables_sinPaginacion('listaItinerario');
                                $("#preloader").css("display", "none");
                            } else {
                                $("#listaProgramacion").empty();
                                var q = 0;
                                var p = {};
                                
                                var disabled = '';
                                if ($('#TIP_trabajo').bootstrapSwitch('state') == true && $("#Usuario").val() != usu_trabajo){
                                    disabled = 'disabled = "disabled"';                                    
                                } else if ($('#TIP_trabajo').bootstrapSwitch('state') == true && $("#Usuario").val() == usu_trabajo){
                                    disabled = 'disabled = "disabled"';
                                } else if ($('#TIP_trabajo').bootstrapSwitch('state') == false && $("#Usuario").val() != usu_trabajo){
                                    disabled = '';
                                }

                                for (var i = 1; i <= data_matriz.length; i++) {
                                    var disabled_cancelacion = '';
                                    var variableCancelacion = '';
                                    var alertaAvion = '';
                                    var cancelacion = '';
                                    
                                    for (var k = 1; k <= dataAvionesNoDisponibles.length; k++) {
                                        if( data_matriz[i-1]["RUT_num_vuelo"] == dataAvionesNoDisponibles[k-1]["RUT_num_vuelo"] && $("#bITI_fch").val() >= dataAvionesNoDisponibles[k-1]["MANTAVI_fchini"] && $("#bITI_fch").val() <= dataAvionesNoDisponibles[k-1]["MANTAVI_fchfin"] ){
                                            alertaAvion = ' style="background: #f8b5a6;"';
                                            break;
                                        }
                                    }
                                    if( data_matriz[i-1]["ITI_proceso"] == "CANCELADO" ){
                                        cancelacion = ' style=" background: url(<?php echo URLPUBLIC;?>/img/cancelado.png); background-repeat: no-repeat;"';
                                        disabled_cancelacion = 'disabled = "disabled"';
                                        variableCancelacion = "CANCELADO";
                                    }
                                    
                                    var html = "";
                                    html = '<tr' + alertaAvion + '>'
                                        + '<td style="width:auto;">' + i + '</td>'
                                        + '<td ' + cancelacion + '>' + data_matriz[i-1]["RUT_num_vuelo"] + '</td>'
                                        //+ '<td style="width:auto;">' + data_matriz[i-1]["AVI_num_cola"] + '</td>'
                                        + '<td style="width:auto;">'
                                            + '<select name="AVI_id' + (i) + '" id="AVI_id' + (i) + '" class="form-control input-sm js-example-basic-single_extra" disabled = "disabled" style="display:block;" >'
                                                + '<option value="">Selecccione Avión</option>'
                                            + '</select>'
                                            + '<select name="AVI_id_m' + (i) + '" id="AVI_id_m' + (i) + '" class="form-control input-sm" style="display:none;" onchange="activarSaveAvion(' + (i) + ');" >'
                                                + '<option value="">Selecccione Avión</option>'
                                            + '</select>'
                                        + '</td>'
                                        + '<td style="width:auto; text-align: center;">'
                                            + '<input type="checkbox" id="checkAVI_id' + (i) + '" name="checkAVI_id' + (i) + '" value="" class="form-check-input" onclick="activar_avionDisponible(' + (i) + ')"; ' + disabled + ' />'
                                            + '<button id="guardarAvionDisponible' + (i) + '" type="button" class="fa fa-save"  onclick="guardarAvionDisponible(\'' + data_matriz[i-1]["ITI_id"] + '\',\'' + data_matriz[i-1]["RUT_num_vuelo"] + '\',\'' + data_matriz[i-1]["AVI_num_cola"] + '\',' + i + ');" style="display: none" disabled = "disabled" ></button>'
                                        + '</td>'
                                        + '<td style="width:auto;">' + data_matriz[i-1]["CIU_id_origen"] + '</td>'
                                        + '<td style="width:auto;">' + data_matriz[i-1]["CIU_id_destino"] + '</td>'
                                        + '<td style="width:auto;">' + data_matriz[i-1]["RUT_hora_salida"] + '</td>'
                                        + '<td style="width:auto;">' + data_matriz[i-1]["RUT_hora_llegada"] + '</td>'
                                        var Instructor = "";
                                        var Piloto = "";
                                        var Copiloto = "";
                                        var JefeCabina = "";
                                        var TripCabina = "";
                                        var ApoyoVuelo = "---";
                                        for (var j = 1; j <= data.length; j++) {
                                            if(data_matriz[i-1]["RUT_num_vuelo"] == data[j-1]["RUT_num_vuelo"]){
                                                if(data[j - 1]["ITI_TRIP_tipo"] == 'Instructor'){
                                                    Instructor = data[j - 1]["TRIP_nombre"];
                                                } else if(data[j - 1]["ITI_TRIP_tipo"] == 'Piloto'){
                                                    Piloto = data[j - 1]["TRIP_nombre"] + " " + data[j - 1]["TRIP_apellido"];
                                                } else if(data[j - 1]["ITI_TRIP_tipo"] == 'Copiloto'){
                                                    Copiloto = data[j - 1]["TRIP_nombre"] + " " + data[j - 1]["TRIP_apellido"];
                                                } else if(data[j - 1]["ITI_TRIP_tipo"] == 'JefeCabina'){
                                                    JefeCabina = data[j - 1]["TRIP_nombre"] + " " + data[j - 1]["TRIP_apellido"];
                                                } else if(data[j - 1]["ITI_TRIP_tipo"] == 'ApoyoVuelo'){
                                                    ApoyoVuelo = data[j - 1]["TRIP_nombre"] + " " + data[j - 1]["TRIP_apellido"];
                                                } else if((data[j - 1]["ITI_TRIP_tipo"]).substring(0,10) == 'TripCabina'){
                                                    TripCabina += data[j - 1]["TRIP_nombre"] + " " + data[j - 1]["TRIP_apellido"] + "<br/><br/>";
                                                }
                                            }
                                        }
                                        if(Piloto != "" && Instructor == ""){
                                            html += '<td style="width:auto;">' + Piloto + '</td>'
                                        } else if(Piloto == "" && Instructor != ""){
                                            html += '<td style="width:auto;">' + Instructor + '</td>'
                                        } else {
                                            html += '<td style="width:auto;">' + Piloto + " /<br/>" + Instructor + '</td>'
                                        }
                                    html += '<td style="width:auto;">' + Copiloto + '</td>'
                                    html += '<td style="width:auto;">' + JefeCabina + '</td>'
                                    html += '<td style="width:auto;">' + TripCabina + '</td>'
                                    html += '<td style="width:auto;">' + ApoyoVuelo + '</td>'
                                        html += '<td style="width:auto;">'
                                                <?php  $Bdisabled = 0; ?>
                                                <?php foreach ($this->objBotton as $botton) { ?>
                                                    <?php if($botton["Funcion"] == "listarProgramacion"){ ?>
                                                        <?php  $Bdisabled += 1; ?>
                                                    <?php } ?>
                                                <?php } ?>
                                                <?php if($Bdisabled > 0){ $disabled = ""; } else { $disabled = "disabled"; } ?>
                                                    html += '<button type="button" class="fa fa-eye" data-toggle="modal"  data-target="#programacionRegistro" onclick="listarDetProgramacion(\'' + data_matriz[i-1]["ITI_fch"] + '\',\'' + data[i-1]["RUT_num_vuelo"] + '\',\'listar\')" <?php echo $disabled;?>></button>'
                                        html += '</td>'
                                        html += '<td style="width:auto;">'
                                                <?php  $Bdisabled = 0; ?>
                                                <?php foreach ($this->objBotton as $botton) { ?>
                                                    <?php if($botton["Funcion"] == "updateProgramacion"){ ?>
                                                        <?php  $Bdisabled += 1; ?>
                                                    <?php } ?>
                                                <?php } ?>
                                                <?php if($Bdisabled > 0){ $disabled = ""; } else { $disabled = "disabled"; } ?>
                                                    html += '<button type="button" class="fa fa-pencil" data-toggle="modal"  data-target="#programacionRegistro" onclick="listarDetProgramacion(\'' + data_matriz[i-1]["ITI_fch"] + '\',\'' + data[i-1]["RUT_num_vuelo"] + '\',\'modificar\')" <?php echo $disabled;?>  ' + disabled + ' ' + disabled_cancelacion + '></button>'
                                        html += '</td>'
                                        if( variableCancelacion != "CANCELADO" ){
                                            html += '<td>'
                                                    <?php  $Bdisabled = 0; ?>
                                                    <?php foreach ($this->objBotton as $botton) { ?>
                                                        <?php if($botton["Funcion"] == "updateProgramacion"){ ?>
                                                            <?php  $Bdisabled += 1; ?>
                                                        <?php } ?>
                                                    <?php } ?>
                                                    <?php if($Bdisabled > 0){ $disabled = ""; } else { $disabled = "disabled"; } ?>
                                                        html += '<button type="button" class="fa fa-ban" onclick="cancelarDetProgramacion(' + data_matriz[i-1]["ITI_id"] + ',\'' + data_matriz[i-1]["RUT_num_vuelo"] + '\',\'cancelar\')" <?php echo $disabled;?> ' + disabled + ' ' + disabled_cancelacion + '></button>'
                                            html += '</td>'
                                        }
                                        else {
                                            html += '<td>'
                                                <?php  $Bdisabled = 0; ?>
                                                <?php foreach ($this->objBotton as $botton) { ?>
                                                    <?php if($botton["Funcion"] == "updateProgramacion"){ ?>
                                                        <?php  $Bdisabled += 1; ?>
                                                    <?php } ?>
                                                <?php } ?>
                                                <?php if($Bdisabled > 0){ $disabled = ""; } else { $disabled = "disabled"; } ?>
                                                    html += '<button type="button" class="fa fa-plane" onclick="retornarDetProgramacion(' + data_matriz[i-1]["ITI_id"] + ',\'' + data_matriz[i-1]["RUT_num_vuelo"] + '\',\'retornar\')" <?php echo $disabled;?> ' + disabled + ' ></button>'
                                            html += '</td>'
                                        }
                                        
                                    html += '</tr>';

                                    q++;
                                    p[q] = i;
                                    $("#listaProgramacion").append(html);
                                    listarComboAvionDisponiblesView($("#AVI_id" + i),$("#bITI_fch").val(),$("#bITI_fch").val(),"todo");
                                    listarComboAvionDisponiblesView($("#AVI_id_m" + i),$("#bITI_fch").val(),$("#bITI_fch").val(),"xfecha");
                                    
                                    $("#AVI_id_m" + i).css("display","none"); 
                                };
                            }
                            
                            setTimeout(function(){
                                for(var r = 1; r <= data_matriz.length; r++){
                                    var s = p[r];
                                    $("#AVI_id" + r).val(data_matriz[s-1]["AVI_id"]).trigger('change.select2');
                                }
                                $("#preloader").css("display", "none");
                            },5000);
                            
                            $(document).ready(function() { $(".js-example-basic-single_extra").select2(); });
                            myDataTables_sinPaginacion('listaItinerario');
                        });
                    });
                }
            });
        }
        
        function listarComboAvionDisponiblesView(select,ITI_fchini,ITI_fchfin,variable){
            listarComboAvionDisponibles('<?php echo URLLOGICA?>avion/listarAvionDisponiblesxFecha/',select,ITI_fchini,ITI_fchfin,variable);
        }
                
        function listarDetProgramacion(ITI_fch,RUT_num_vuelo,accion){
            var url = "<?php echo URLLOGICA?>programacion/listarDetProgramacion/";
            $("#preloader").css("display","block");
            
            $.post(url,
            {
                "ITI_fch" : ITI_fch,
                "RUT_num_vuelo" : RUT_num_vuelo
            },
            function(data){
                if(data == ""){
                    alert("Hubo un error al cargar la información.");
                } else {
                    $("#titleForm").text("Detalle de Programación");
                    $("#ITI_id").val(ITI_id);
                    $("#RUT_num_vuelo").val(RUT_num_vuelo);
                    var TRIP_id = '';
                    var TIPTRIPU_id_cabina = '';
                    var TIPTRIPU_id_piloto = '';
                    listarTripulantesMotor('<?php echo URLLOGICA?>motor/listarTripulantesMotorView/',ITI_id,TRIP_id,RUT_num_vuelo,TIPTRIPU_id_cabina,TIPTRIPU_id_piloto);
                    var q = 0;
                    var p = {};
                    for (var i = 0; i < data.length; i++) {
                        if(data[i]["ITI_TRIP_tipo"] == "Instructor"){
                            var j = i;
                            setTimeout(function(){
                                $("#TRIP_id_Instructor").val(data[j]["TRIP_id"]).trigger('change.select2');
                            },1000);
                        }
                        else if(data[i]["ITI_TRIP_tipo"] == "Piloto"){
                            var k = i;
                            setTimeout(function(){
                                $("#TRIP_id_Piloto").val(data[k]["TRIP_id"]).trigger('change.select2');
                                $("#TRIP_id_PilotoHidden").val(data[k]["TRIP_id"]);
                            },1000);
                        }
                        else if(data[i]["ITI_TRIP_tipo"] == "Copiloto"){
                            var l = i;
                            setTimeout(function(){
                                $("#TRIP_id_Copiloto").val(data[l]["TRIP_id"]).trigger('change.select2');
                                $("#TRIP_id_CopilotoHidden").val(data[l]["TRIP_id"]);
                            },1500);
                        }
                        else if(data[i]["ITI_TRIP_tipo"] == "JefeCabina"){
                            var m = i;
                            setTimeout(function(){
                                $("#TRIP_id_JejeCabina").val(data[m]["TRIP_id"]).trigger('change.select2');
                            },1000);
                        }
                        else if(data[i]["ITI_TRIP_tipo"] == "ApoyoVuelo"){
                            var n = i;
                            setTimeout(function(){
                                $("#TRIP_id_ApoyoVuelo").val(data[n]["TRIP_id"]).trigger('change.select2');
                            },1000);
                        }
                        else {
                            q++;
                            if(q < 2){
                                var o = i;
                                setTimeout(function(){
                                    $("#TRIP_id_TripCabina1").val(data[o]["TRIP_id"]).trigger('change.select2');
                                },1000);
                            }
                            if(q > 1){
                                p[q] = i;
                                agregar_TripCabina();
                                setTimeout(function(){
                                    for(var r = 2; r <= q; r++){
                                        var s = p[r];
                                        $("#TRIP_id_TripCabina" + r).val(data[s]["TRIP_id"]).trigger('change.select2');
                                    }
                                },1000);
                            }
                        }
                    }
                    
                    $("#TIPTRIPU_id_cabina").val(data[0]["TIPTRIPU_id"]).trigger('change.select2');
                    $("#AUD_usu_cre").val(data[0]["AUD_usu_cre"]);
                    $("#AUD_fch_cre").val(data[0]["AUD_fch_cre"]);
                    $("#AUD_usu_mod").val(data[0]["AUD_usu_mod"]);
                    $("#AUD_fch_mod").val(data[0]["AUD_fch_mod"]);
                    if(accion == "listar"){
                        $("#agregar_TripCabina").prop("disabled","disabled");
                        $("#quitar_TripCabina").prop("disabled","disabled");
                        $("#insertProgramacion").show();
                        verFormProgramacion();
                    } else {
                        $("#agregar_TripCabina").removeAttr("disabled");
                        $("#quitar_TripCabina").removeAttr("disabled");
                        $("#insertProgramacion").hide();
                        $("#updateProgramacion").show();
                    }
                };
            });
            
            $("#preloader").css("display","none");
        }
        
        function listarCabinaView(newnum,TIPTRIPU_id_cabina,TIPTRIPU_id_piloto){
            listarCabina('<?php echo URLLOGICA?>motor/listarTripulantesMotorView/',newnum,TIPTRIPU_id_cabina,TIPTRIPU_id_piloto);
        }
                
        function validarCopilotoxInstructor(valor){
            $("#TRIP_id_Copiloto").val("").trigger('change.select2');
            var TRIP_id = $("#TRIP_id_Instructor").val();
            var ITI_id = $("#ITI_id").val();
            var RUT_num_vuelo = $("#RUT_num_vuelo").val();
            var TIPTRIPU_id_cabina = $("#TIPTRIPU_id_cabina_ini").val();
            var TIPTRIPU_id_piloto = $("#TIPTRIPU_id_piloto_ini").val();
            
            listarCopiloto('<?php echo URLLOGICA?>motor/listarTripulantesMotorView/',TRIP_id,RUT_num_vuelo,TIPTRIPU_id_cabina,TIPTRIPU_id_piloto);
        }
        
        function validarTRIP_instructorxPiloto(){
            $("#TRIP_id_Piloto").val("").trigger('change.select2');
            $("#TRIP_id_Piloto").prop("disabled","disabled");
            
            $("#TRIP_id_Copiloto").val($("#TRIP_id_CopilotoHidden").val()).trigger('change.select2');
            $("#TRIP_id_Copiloto").removeAttr("disabled");
        }
        
        function validarTRIP_instructorxCopiloto(){
            $("#TRIP_id_Piloto").val($("#TRIP_id_PilotoHidden").val()).trigger('change.select2');
            $("#TRIP_id_Piloto").removeAttr("disabled");
            
            $("#TRIP_id_Copiloto").val("").trigger('change.select2');
            $("#TRIP_id_Copiloto").prop("disabled","disabled");
        }
        
        function validarTRIP_instructorxInstructor(){
            $("#TRIP_id_Piloto").val($("#TRIP_id_PilotoHidden").val()).trigger('change.select2');
            $("#TRIP_id_Piloto").removeAttr("disabled");
            
            $("#TRIP_id_Copiloto").val($("#TRIP_id_CopilotoHidden").val()).trigger('change.select2');
            $("#TRIP_id_Copiloto").removeAttr("disabled");
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
                
                if($("#TRIP_instructorP").is(':checked')){
                    parametros["TRIP_instructor"] = $("#TRIP_instructorP").val();
                }
                else if($("#TRIP_instructorC").is(':checked')){
                    parametros["TRIP_instructor"] = $("#TRIP_instructorC").val();
                }
                else if($("#TRIP_instructorI").is(':checked')){
                    parametros["TRIP_instructor"] = $("#TRIP_instructorI").val();
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
        
        function activar_avionDisponible(num) {
			if ($('#checkAVI_id' + num).is(':checked')){
                $("#guardarAvionDisponible" + num).css('display','block');
				$("#AVI_id" + num).select2('destroy');
				$("#AVI_id" + num).css('display','none');
                $("#AVI_id_m" + num).css('display','block');
				$("#AVI_id_m" + num).prop('class','js-example-basic-single_extra2');
                $(document).ready(function() { $(".js-example-basic-single_extra2").select2(); });
			} else{
                $("#guardarAvionDisponible" + num).css('display','none');
                $("#AVI_id_m" + num).val("").trigger('change.select2');
                $("#AVI_id_m" + num).select2('destroy');
				$("#AVI_id_m" + num).css('display','none');
                $("#AVI_id" + num).css('display','block');
				$("#AVI_id" + num).prop('class','js-example-basic-single_extra');
                $(document).ready(function() { $(".js-example-basic-single_extra").select2(); });
			}
		}
        
        function activarSaveAvion(num){
            if( $("#AVI_id_m" + num).val() != "" ){
                $("#guardarAvionDisponible" + num).removeAttr("disabled");
            } else{
                $("#guardarAvionDisponible" + num).attr("disabled","disabled");
            }
        }
        
        function guardarAvionDisponible(ITI_id,RUT_num_vuelo,AVI_num_cola,num){
            var url = "<?php echo URLLOGICA?>itinerario/updateAvionItinerario/";
            var parametros = {
                AVI_id : $("#AVI_id_m" + num).val(),
                AVI_num_cola : AVI_num_cola,
                ITI_id : ITI_id,
                "ITI_fch" : $("#bITI_fch").val(),
                RUT_num_vuelo : RUT_num_vuelo
            };
            $.post(url,parametros,
            function(data){
                $("#AVI_id" + num).val($("#AVI_id_m" + num).val()).trigger('change.select2');
                $('#checkAVI_id' + num).removeAttr("checked");;
                activar_avionDisponible(num);
            });
        }
        
        function cancelarDetProgramacion(ITI_id,RUT_num_vuelo){
            var envio = confirm('Advertencia: Se procederá a cancelar el Vuelo N° ' + RUT_num_vuelo + '. ¿Estas seguro de cancelarlo (SI [ok] / NO [cancelar])?.');
            if (envio){
                var url = "<?php echo URLLOGICA?>programacion/cancelarVueloRuta/";

                var parametros = {
                    "ITI_id" : ITI_id,
                    "RUT_num_vuelo" : RUT_num_vuelo,
                    "ITI_fch" : $("#bITI_fch").val(),
                };
                $.post(url,parametros,
                function(data){
                    listarProgramacionFchResumen('<?php echo URLLOGICA?>programacion/listarProgramacionFchResumenMatriz/','<?php echo URLLOGICA?>programacion/listarProgramacionFchResumen/','listar');
                });
            } else {
                return false;
            }
        }
        
        function retornarDetProgramacion(ITI_id,RUT_num_vuelo){
            var envio = confirm('Advertencia: Se procederá a retornar el Vuelo N° ' + RUT_num_vuelo + '. ¿Estas seguro de retornar (SI [ok] / NO [cancelar])?.');
            if (envio){
                var url = "<?php echo URLLOGICA?>programacion/retornarVueloRuta/";

                var parametros = {
                    "ITI_id" : ITI_id,
                    "RUT_num_vuelo" : RUT_num_vuelo,
                    "ITI_fch" : $("#bITI_fch").val(),
                };
                $.post(url,parametros,
                function(data){
                    listarProgramacionFchResumen('<?php echo URLLOGICA?>programacion/listarProgramacionFchResumenMatriz/','<?php echo URLLOGICA?>programacion/listarProgramacionFchResumen/','listar');
                });
            } else {
                return false;
            }
        }
        
    </script>
    <!-- /.content-wrapper -->
    <?php include "footer_view.php";?>