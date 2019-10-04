<?php include "header_view.php";?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
				Simuladores <small></small>
            </h1>
            <ol class="breadcrumb">
                <li><i class="fa fa-thumb-tack"></i> Simuladores</li>
                <li class="active">
                    Listado de Simuladores
                </li>
            </ol>
        </section>
        <!-- Main content -->
        <section class="content">
            <div class='box box-danger'>
                <div class="box-body">
                    <div id="MainContent_Div1" class="panel panel-default">
                        <div class="panel-heading clearfix"  style="padding: 5px !important">
                            <span><strong>Buscar</strong></span>
                        </div>
                        <form method="post" action="<?php echo URLLOGICA?>simulador/buscarSimulador/" onsubmit="document.forms['buscar']['buscar'].disabled=true;" name="buscar">
                            <div class="row-fluid">
                                <div class="form-group">
                                    <label for="bTIPTRIP_id" class="col-md-2 control-label">Tipo de Tripulante</label>
                                    <div class="col-md-2">
                                        <select name="bTIPTRIP_id" id="bTIPTRIP_id" class="form-control input-sm js-example-basic-single" >
                                            <option value="" selected>Tipo de Tripulante</option>
                                        <?php foreach($this->objTipoTripulante as $lista){ ?>
                                            <?php $selected = "";?>
                                            <?php if(isset($_SESSION["TIPTRIP_id"])) { ?>
                                                <?php if($_SESSION["TIPTRIP_id"] == $lista["TIPTRIP_id"]) { ?>
                                                    <?php $selected = "selected";?>
                                                <?php } ?>
                                            <?php } ?>
                                            <option value="<?php echo $lista["TIPTRIP_id"];?>" <?php echo $selected;?>><?php echo ($lista["TIPTRIP_descripcion"]);?></option>
                                        <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="bTRIP_apellido" class="col-md-2 control-label">Apellido</label>
                                    <div class="col-md-2">
                                        <input type="text" name="bTRIP_apellido" id="bTRIP_apellido" value="<?php if(isset($_SESSION["TRIP_apellido"])) { echo $_SESSION["TRIP_apellido"]; } else { echo ""; }?>" class="form-control input-sm" style="text-transform: uppercase;" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="bSIMU_indicador" class="col-md-2 control-label">Cumplimiento</label>
                                    <div class="col-md-2">
                                        <select name="bSIMU_indicador" id="bSIMU_indicador" class="form-control input-sm js-example-basic-single" >
                                            <option value="" selected>Seleccionar Cumplimiento</option>
                                            <?php $selected_APROBADO = '' ?>
                                            <?php $selected_DESAPROBADO = '' ?>
                                            <?php $selected_OBSERVADO = '' ?>
                                            <?php $selected_PENDIENTE = '' ?>
                                            <?php if(isset($_SESSION["SIMU_indicador"])) { ?>
                                                    <?php if($_SESSION["SIMU_indicador"] == 'APROBADO') { ?>
                                                        <?php $selected_APROBADO = 'selected' ?>
                                                        <?php $selected_DESAPROBADO = '' ?>
                                                        <?php $selected_OBSERVADO = '' ?>
                                                        <?php $selected_PENDIENTE = '' ?>
                                                    <?php } else if($_SESSION["SIMU_indicador"] == 'DESAPROBADO') { ?>
                                                        <?php $selected_APROBADO = '' ?>
                                                        <?php $selected_DESAPROBADO = 'selected' ?>
                                                        <?php $selected_OBSERVADO = '' ?>
                                                        <?php $selected_PENDIENTE = '' ?>
                                                    <?php } else if($_SESSION["SIMU_indicador"] == 'OBSERVADO') { ?>
                                                        <?php $selected_APROBADO = '' ?>
                                                        <?php $selected_DESAPROBADO = '' ?>
                                                        <?php $selected_OBSERVADO = 'selected' ?>
                                                        <?php $selected_PENDIENTE = '' ?>
                                                    <?php } else if($_SESSION["SIMU_indicador"] == 'PENDIENTE') { ?>
                                                        <?php $selected_APROBADO = '' ?>
                                                        <?php $selected_DESAPROBADO = '' ?>
                                                        <?php $selected_OBSERVADO = '' ?>
                                                        <?php $selected_PENDIENTE = 'selected' ?>
                                                    <?php } ?>
                                            <?php } ?>
                                            <option value="APROBADO" <?php echo $selected_APROBADO;?>>APROBADO</option>
                                            <option value="DESAPROBADO" <?php echo $selected_DESAPROBADO;?>>DESAPROBADO</option>
                                            <option value="OBSERVADO" <?php echo $selected_OBSERVADO;?>>OBSERVADO</option>
                                            <option value="PENDIENTE" <?php echo $selected_PENDIENTE;?>>PENDIENTE</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="form-group">
                                <div class="form-group">
                                    <label for="bSIMU_fch_Mes" class="col-md-2 control-label">Mes de Simulador</label>
                                    <div class="col-md-2">
                                        <select name="bSIMU_fch_Mes" id="bSIMU_fch_Mes" class="form-control input-sm js-example-basic-single" >
                                            <option value="" selected>Seleccionar Mes</option>
                                        <?php foreach($this->objMes as $lista){ ?>
                                            <?php $selected = "";?>
                                            <?php if(isset($_SESSION["SIMU_fch_Mes"])) { ?>
                                                <?php if($_SESSION["SIMU_fch_Mes"] == $lista["MES_id"]) { ?>
                                                    <?php $selected = "selected";?>
                                                <?php } ?>
                                            <?php } ?>
                                            <option value="<?php echo $lista["MES_id"];?>" <?php echo $selected;?>><?php echo utf8_encode(($lista["MES_descripcion"]));?></option>
                                        <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="bSIMU_fch_Anio" class="col-md-2 control-label">Año de Simulador</label>
                                    <div class="col-md-2">
                                        <select name="bSIMU_fch_Anio" id="bSIMU_fch_Anio" class="form-control input-sm js-example-basic-single" >
                                            <option value="" selected>Seleccionar Mes</option>
                                        <?php foreach($this->objAnio as $lista){ ?>
                                            <?php $selected = "";?>
                                            <?php if(isset($_SESSION["SIMU_fch_Anio"])) { ?>
                                                <?php if($_SESSION["SIMU_fch_Anio"] == $lista["ANIO_descripcion"]) { ?>
                                                    <?php $selected = "selected";?>
                                                <?php } ?>
                                            <?php } ?>
                                            <option value="<?php echo $lista["ANIO_descripcion"];?>" <?php echo $selected;?>><?php echo utf8_encode(($lista["ANIO_descripcion"]));?></option>
                                        <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="row-fluid">
                                    <div class="form-group">
                                        <div class="col-md-2">
                                            <input type="submit" name="buscar" value="Buscar" class="btn btn-danger btn-block" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                            <div class="col-md-2">
                                <button type="button" name="limpiar" class="btn btn-danger btn-block" onclick="resetFormSimulador('<?php echo URLLOGICA?>simulador/listarResumenSimulador/');"> Limpiar </button>
                            </div>
                            <div class="clearfix" style="padding: 4px;"></div>
                    </div>
                    <div id="MainContent_listaPro" class="panel panel-default">
                        <div class="panel-heading clearfix" style="padding: 5px !important">
                            <div class="col-xs-6 col-md-2">
                                <span id="MainContent_tituloPro"><strong>Lista de Simuladores</strong></span>
                            </div>
                            <div class="col-xs-2 col-md-4  col-md-offset-4">
                                <?php  $Bdisabled = 0; ?>
                                <?php  $registro = ""; ?>
                                <?php foreach ($this->objBotton as $botton) { ?>
                                    <?php if($botton["Funcion"] == "insertSimulador"){ ?>
                                        <?php  $Bdisabled += 1; ?>
                                    <?php } ?>
                                <?php } ?>
                                <?php if($Bdisabled > 0){ $disabled = ""; $registro = ""; } else { $disabled = "disabled"; $registro = "registro"; } ?>
                                    <input type="hidden" name="Simulador_registro" id="Simulador_registro" value="<?php echo $registro;?>" class="form-control input-sm"/>
                                    <button type="button" class="pull-right fa fa-fighter-jet" data-toggle="modal" data-target="#simuladorRegistro" <?php echo $disabled;?>></button>

                            </div>
                            <div class="col-xs-2 col-md-1">
                                <button type="button" class="fa fa-envelope" onclick="enviarCorreoSimulador(<?php echo date("Y");?>)" ></button>
                            </div>
                            <div class="col-xs-2 col-md-1">
                                <a href="<?php echo URLLOGICA;?>excel/simulador_excel/" class="logo"  >
                                    <img src="<?php echo URLPUBLIC;?>/img/excel.png" />
                                </a>
                            </div>
                        </div>
                        
                        <div class="area_resultado table-responsive">
                            <table id="listaSimulador" class="display myDataTables" cellspacing="0" cellpadding="2">
                                <thead>
                                    <tr>
                                        <th scope="col">Item</th>
                                        <th scope="col">Mes de Simulador</th>
                                        <th scope="col">Tipo Trip.</th>
                                        <th scope="col">Cant. de Trip.</th>
                                        <th scope="col">Cumplimiento</th>
                                        <th scope="col">Ver</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (count($this->objResumenSimulador) > 0) { ?>
                                        <?php $item = 1; ?>
                                        <?php foreach ($this->objResumenSimuladorMatriz as $lista) { ?>
                                         <?php $SIMU_indicador = 'APROBADO'; ?>
                                            <?php foreach ($this->objResumenSimulador as $listaII) { ?>
                                                <?php if ($lista["SIMU_fch_MesSimulador"] == $listaII["SIMU_fch_MesSimulador"] and $lista["TIPTRIP_descripcion"] == $listaII["TIPTRIP_descripcion"]) { ?>
                                                    <?php if($listaII["SIMU_indicador"] == 'DESAPROBADO'){ ?>
                                                        <?php $SIMU_indicador = 'DESAPROBADO';?>
                                                    <?php } else if($listaII["SIMU_indicador"] == 'OBSERVADO') { ?>
                                                        <?php $SIMU_indicador = 'OBSERVADO';?>
                                                    <?php } else if($listaII["SIMU_indicador"] == 'PENDIENTE') { ?>
                                                        <?php $SIMU_indicador = 'PENDIENTE';?>
                                                    <?php } ?>
                                                <?php } ?>
                                            <?php } ?>
                                    <tr>
                                        <td style="width:auto;"><?php echo $item;?></td>
                                        <td style="width:auto;"><?php echo $lista["SIMU_fch_MesSimulador"]?></td>
                                        <td style="width:auto;"><?php echo utf8_encode($lista["TIPTRIP_descripcion"]);?></td>
                                        <td style="width:auto;"><?php echo $lista["SIMU_Afectados"];?></td>
                                        <td style="width:auto;"><?php echo $SIMU_indicador;?></td>
                                        <td style="width:auto;">
                                            <?php  $Bdisabled = 0; ?>
                                            <?php foreach ($this->objBotton as $botton) { ?>
                                                <?php if($botton["Funcion"] == "listarSimulador"){ ?>
                                                    <?php  $Bdisabled += 1; ?>
                                                <?php } ?>
                                            <?php } ?>
                                            <?php if($Bdisabled > 0){ $disabled = ""; } else { $disabled = "disabled"; } ?>
                                                <button type="button" class="fa fa-eye" data-toggle="modal"  data-target="#simuladorDetalle" onclick="listarSimulador(<?php echo $lista["SIMU_fch_Mes"];?>,<?php echo $lista["SIMU_fch_Anio"];?>,<?php echo $lista["TIPTRIP_id"];?>)" <?php echo $disabled;?>></button>
                                        </td>
                                    </tr>
                                        <?php $item++; ?>
                                        <?php } ?>
                                    <?php } ?>
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
    <div id="simuladorRegistro" class="modal fade" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header" style="padding: 10px !important">
                    <table class="col-xs-12">
                        <tr>
                            <td style="text-align:left;">
                                <h4><strong id="titleForm">Ingresar Nuevo Trip. al Simulador</strong></h4>
                            </td>
                            <td>
                                <button type="button" class="close btn-lg" data-dismiss="modal" onclick="limpiarFormSimulador();" style="background-color: red; color:white; margin:10px; padding: 0px 6px 2px 6px;text-align:right;">
                                    <span aria-hidden="true">&times;</span><span class="sr-only">Cerrar</span>
                                </button>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="modal-body" style="padding-bottom: 10px !important">
                    <div class="row">
                        <div class="col-md-12" style="padding-bottom: 10px;">
                            <label for="TIPTRIP_id" class="col-md-5 control-label">Tipo de Tripulante 1
                            <span style="color: #FF0000"><strong>*</strong></span></label>
                            <div class="col-md-7">
                                <input type="hidden" name="SIMU_id" id="SIMU_id" value="" class="form-control input-sm"/>
                                <select name="TIPTRIP_id" id="TIPTRIP_id" class="form-control input-sm js-example-basic-single" >
                                    <option value="" selected>Tipo de Tripulante 1</option>
                                <?php foreach($this->objTipoTripulante as $lista){ ?>
                                    <option value="<?php echo $lista["TIPTRIP_id"];?>"><?php echo ($lista["TIPTRIP_descripcion"]);?></option>
                                <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12" style="padding-bottom: 10px;">
                            <label for="TIPTRIPDET_id" class="col-md-5 control-label">Tipo de Detalle de Trip. 1
                            <span style="color: #FF0000"><strong>*</strong></span></label>
                            <div class="col-md-7">
                                <select name="TIPTRIPDET_id" id="TIPTRIPDET_id" class="form-control input-sm js-example-basic-single" >
                                    <option value="" selected>Tipo Detalle de Trip. 1</option>
                                <?php foreach($this->objTipoDetTripulante as $lista){ ?>
                                    <option class="<?php echo $lista["TIPTRIP_id"];?>" value="<?php echo $lista["TIPTRIPDET_id"];?>"><?php echo ($lista["TIPTRIPDET_descripcion"]);?></option>
                                <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12" style="padding-bottom: 10px;">
                            <label for="TRIP_id" class="col-md-5 control-label">Tripulante Afectado 1
                            <span style="color: #FF0000"><strong>*</strong></span></label>
                            <div class="col-md-7">
                                <select name="TRIP_id" id="TRIP_id" class="form-control input-sm js-example-basic-single" >
                                    <option value="" selected>Tripulante Afectado 1</option>
                                <?php foreach($this->objTripulante as $lista){ ?>
                                    <option class="<?php echo $lista["TIPTRIPDET_id"];?>" value="<?php echo $lista["TRIP_id"];?>"><?php echo utf8_encode($lista["TRIP_nombre"]." ".$lista["TRIP_apellido"]);?></option>
                                <?php } ?>
                                </select>
                            </div>
                        </div>
                        
                        <div class="col-md-12" style="padding-bottom: 10px; display:block;" id="divTIPTRIP_id2">
                            <label for="TIPTRIP_id2" class="col-md-5 control-label">Tipo de Tripulante 2 </label>
                            <div class="col-md-7">
                                <select name="TIPTRIP_id2" id="TIPTRIP_id2" class="form-control input-sm js-example-basic-single" >
                                    <option value="" selected>Tipo de Tripulante 2</option>
                                <?php foreach($this->objTipoTripulante as $lista){ ?>
                                    <option value="<?php echo $lista["TIPTRIP_id"];?>"><?php echo ($lista["TIPTRIP_descripcion"]);?></option>
                                <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12" style="padding-bottom: 10px; display:block;" id="divTIPTRIPDET_id2">
                            <label for="TIPTRIPDET_id2" class="col-md-5 control-label">Tipo de Detalle de Trip. 2 </label>
                            <div class="col-md-7">
                                <select name="TIPTRIPDET_id2" id="TIPTRIPDET_id2" class="form-control input-sm js-example-basic-single" >
                                    <option value="" selected>Tipo Detalle de Trip. 2</option>
                                <?php foreach($this->objTipoDetTripulante as $lista){ ?>
                                    <option class="<?php echo $lista["TIPTRIP_id"];?>" value="<?php echo $lista["TIPTRIPDET_id"];?>"><?php echo ($lista["TIPTRIPDET_descripcion"]);?></option>
                                <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12" style="padding-bottom: 10px; display:block;" id="divTRIP_id2">
                            <label for="TRIP_id2" class="col-md-5 control-label">Tripulante Afectado 2 </label>
                            <div class="col-md-7">
                                <select name="TRIP_id2" id="TRIP_id2" class="form-control input-sm js-example-basic-single" >
                                    <option value="" selected>Tripulante Afectado 2</option>
                                <?php foreach($this->objTripulante as $lista){ ?>
                                    <option class="<?php echo $lista["TIPTRIPDET_id"];?>" value="<?php echo $lista["TRIP_id"];?>"><?php echo utf8_encode($lista["TRIP_nombre"]." ".$lista["TRIP_apellido"]);?></option>
                                <?php } ?>
                                </select>
                            </div>
                        </div>
                        
                        <div class="col-md-12" style="padding-bottom: 10px;">
                            <label for="SIMU_fchini" class="col-md-5 control-label">Fch. de Inicio
                            <span style="color: #FF0000"><strong>*</strong></span></label>
                            <div class="col-md-7">
                                <div class='input-group date datetimepicker1' id="SIMU_fchiniDate">
                                    <input type="text" name="SIMU_fchini" id="SIMU_fchini" class="form-control input-sm" style="text-transform: uppercase; width: 100% !important;" />
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12" style="padding-bottom: 10px;">
                            <label for="SIMU_fchfin" class="col-md-5 control-label">Fch. de Fin
                            <span style="color: #FF0000"><strong>*</strong></span></label>
                            <div class="col-md-7">
                                <div class='input-group date datetimepicker1' id="SIMU_fchfinDate">
                                    <input type="text" name="SIMU_fchfin" id="SIMU_fchfin" class="form-control input-sm" style="text-transform: uppercase; width: 100% !important;" disabled="disabled" />
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12" style="padding-bottom: 10px;">
                            <label for="SIMU_estado" class="col-md-5 control-label">Estado:
                            <span style="color: #FF0000"><strong>*</strong></span></label>
                            <div class="col-md-7">
                               <select name="SIMU_estado" id="SIMU_estado" class="form-control input-sm js-example-basic-single" onchange="validarEstadoSimulador();">
                                   <option value="1" selected>Activo</option>
                                   <option value="0">Inactivo</option>
                               </select>
                            </div>
                        </div>
                        <?php  $Bdisabled = 0; ?>
                        <?php  $valor = ""; ?>
                        <?php foreach ($this->objBotton as $botton) { ?>
                            <?php if($botton["Funcion"] == "SimuladorCumplimiento"){ ?>
                                <?php  $Bdisabled += 1; ?>
                            <?php } ?>
                        <?php } ?>
                        <?php if($Bdisabled > 0){ $disabled = "ssddsd"; $valor = "indicador"; } else { $disabled = "disabled"; $valor = ""; } ?>
                        <div class="col-md-12" style="padding-bottom: 10px !important; display:none;" id="divSIMU_indicador">
                            <label for="SIMU_indicador" class="col-md-5 control-label">Indicador de Cumplimiento
                            <span style="color: #FF0000"><strong>*</strong></span></label>
                            <div class="col-md-7">
                               <select name="SIMU_indicador" id="SIMU_indicador" class="form-control input-sm js-example-basic-single" onchange="validarIndicadorSimulador();" <?php echo $disabled;?> >
                                   <option value="" selected>Seleccione Cumplimiento</option>
                                    <option value="APROBADO">APROBADO</option>
                                    <option value="DESAPROBADO">DESAPROBADO</option>
                                    <option value="OBSERVADO">OBSERVADO</option>
                                    <option value="PENDIENTE">PENDIENTE</option>
                               </select>
                               <input type="hidden" name="Simulador_cumplimiento" id="Simulador_cumplimiento" value="<?php echo $valor;?>" class="form-control input-sm"/>
                            </div>
                        </div>
                        <div class="col-md-12" style="padding-bottom: 10px !important; display:none;" id="divSIMU_fchentrega">
                            <label for="SIMU_fchentrega" class="col-md-5 control-label">Fch. de Entrega
                            <span style="color: #FF0000"><strong>*</strong></span></label>
                            <div class="col-md-7">
                                <div class='input-group date datetimepicker1' id="SIMU_fchentregaDate">
                                    <input type="text" name="SIMU_fchentrega" id="SIMU_fchentrega" class="form-control input-sm" style="text-transform: uppercase; width: 100% !important;" />
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12" style="padding-bottom: 10px !important; display:none;" id="divSIMU_observacion">
                            <label for="SIMU_observacion" class="col-md-5 control-label">Observación: </label>
                            <div class="col-md-7">
                               <input type="text" name="SIMU_observacion" id="SIMU_observacion" class="form-control input-sm" style="text-transform: uppercase; width: 100% !important;" />
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
                    <button name='insertSimulador' id='insertSimulador' type="button" class="btn btn-sm" onclick="flagEstadoModulo('<?php echo URLLOGICA?>simulador/insertSimulador/','listar','simulador');">Grabar</button> <!-- insertSimulador('<?php //echo URLLOGICA?>simulador/insertSimulador/'); -->
                    <button name='updateSimulador' id='updateSimulador' type="button" class="btn btn-sm" onclick="flagEstadoModulo('<?php echo URLLOGICA?>simulador/updateSimulador/','modificar','simulador')">Modificar</button> <!-- updateSimulador('<?php //echo URLLOGICA?>simulador/updateSimulador/'); -->
                    <button name="closeSimulador" id="closeSimulador" type="button" class="btn btn-danger btn-sm" data-dismiss="modal" onclick="limpiarFormSimulador();">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
    
    <div id="simuladorDetalle" class="modal fade" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content modal-lg">
                <div class="modal-header" style="padding: 10px !important">
                    <table class="col-xs-12">
                        <tr>
                            <td style="text-align:left;">
                                <h4><strong id="titleForm">Detalle del Mes</strong></h4>
                            </td>
                            <td>
                                <button type="button" class="close btn-lg" data-dismiss="modal" onclick="limpiarFormSimulador();" style="background-color: red; color:white; margin:10px; padding: 0px 6px 2px 6px;text-align:right;">
                                    <span aria-hidden="true">&times;</span><span class="sr-only">Cerrar</span>
                                </button>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="modal-body" style="padding-bottom: 10px;">
                    <div class="area_resultado table-responsive">
                        <table id="listaDetSimulador" class="display" cellspacing="0" cellpadding="2">
                            <thead>
                                <tr>
                                    <th scope="col">Item</th>
                                    <th scope="col">Tripulante</th>
                                    <th scope="col">Tripulante2</th>
                                    <th scope="col">Fch. de Inicio</th>
                                    <th scope="col">Fch. de Fin</th>
                                    <th scope="col">Indicador</th>
                                    <th scope="col">Ver</th>
                                    <th scope="col">Editar</th>
                                </tr>
                            </thead>
                            <tbody id="listaSimuladorMes">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Fin Modal-->
    
    <script type="text/javascript">
        $(function () {
            $("#TIPTRIPDET_id").chained("#TIPTRIP_id");
            $("#TRIP_id").chained("#TIPTRIPDET_id");
            $("#TIPTRIPDET_id2").chained("#TIPTRIP_id2");
            $("#TRIP_id2").chained("#TIPTRIPDET_id2");
        });
        
        function listarSimulador(SIMU_fch_Mes,SIMU_fch_Anio,TIPTRIP_id){
            var url = "<?php echo URLLOGICA?>simulador/listarSimulador/";
            $("#preloader").css("display","block");
            
            var parametros = {
                "SIMU_fch_Anio" : SIMU_fch_Anio,
                "SIMU_fch_Mes" : SIMU_fch_Mes,
                "TIPTRIP_id" : TIPTRIP_id
            };
            $.post(url,parametros,
            function(data){
                if(data == ""){
                    alert("Hubo un error al cargar la información.");
                } else {
                    $("#listaSimuladorMes").empty();
                    
                    for (var i = 1; i <= data.length; i++) {
                        
                    html = '<tr>'
                            + '<input type="hidden" name="SIMU_fch_Mes" id="SIMU_fch_Mes" value="' + SIMU_fch_Mes + '" class="form-control input-sm"/>'
                            + '<input type="hidden" name="SIMU_fch_Anio" id="SIMU_fch_Anio" value="' + SIMU_fch_Anio + '" class="form-control input-sm"/>'
                            + '<input type="hidden" name="TIPTRIP_id" id="TIPTRIP_id" value="' + TIPTRIP_id + '" class="form-control input-sm"/>'
                            + '<td style="width:auto;">' + i + '</td>'
                            + '<td style="width:auto;">' + data[i-1]["TRIP_nombre"] + ' ' + data[i-1]["TRIP_apellido"] + '</td>'
                            + '<td style="width:auto;">' + data[i-1]["TRIP_nombre2"] + ' ' + data[i-1]["TRIP_apellido2"] + '</td>'
                            + '<td style="width:auto;">' + data[i-1]["SIMU_fchini"] + '</td>'
                            + '<td style="width:auto;">' + data[i-1]["SIMU_fchfin"] + '</td>'
                            + '<td style="width:auto;">' + data[i-1]["SIMU_indicador"] + '</td>'
                            + '<td style="width:auto;">'
                                <?php  $Bdisabled = 0; ?>
                                <?php foreach ($this->objBotton as $botton) { ?>
                                    <?php if($botton["Funcion"] == "listarDetSimulador"){ ?>
                                        <?php  $Bdisabled += 1; ?>
                                    <?php } ?>
                                <?php } ?>
                                <?php if($Bdisabled > 0){ $disabled = ""; } else { $disabled = "disabled"; } ?>
                                    + '<button type="button" class="fa fa-eye" data-toggle="modal" data-target="#simuladorRegistro" onclick="listarDetSimulador(\'<?php echo URLLOGICA?>simulador/listarDetSimulador/\',' + data[i-1]["SIMU_id"] + ',\'listar\')" <?php echo $disabled;?>></button>'
                            + '</td>'
                            + '<td style="width:auto;">'
                                <?php  $Bdisabled = 0; ?>
                                <?php foreach ($this->objBotton as $botton) { ?>
                                    <?php if($botton["Funcion"] == "updateDetSimulador"){ ?>
                                        <?php  $Bdisabled += 1; ?>
                                    <?php } ?>
                                <?php } ?>
                                <?php if($Bdisabled > 0){ $disabled = ""; } else { $disabled = "disabled"; } ?>
                                    + '<button type="button" class="fa fa-pencil" data-toggle="modal" data-target="#simuladorRegistro" onclick="listarDetSimulador(\'<?php echo URLLOGICA?>simulador/listarDetSimulador/\',' + data[i-1]["SIMU_id"] + ',\'modificar\')" <?php echo $disabled;?>></button>'
                            + '</td>'
                        + '</tr>';
                        $("#listaSimuladorMes").append(html);
                    };
                    myDataTables('listaDetSimulador');
                    $("#preloader").css("display", "none");
                }
            });
        }
        
        function listarComboDetalleTripView(){
            listarComboDetalleTrip('<?php echo URLLOGICA?>detalle/listarTipoTripDetalle/');
        }
        
        function listarComboDetalleTripView2(){
            listarComboDetalleTrip2('<?php echo URLLOGICA?>detalle/listarTipoTripDetalle/');
        }
        
        function listarComboTripulanteView(select){
            listarComboTripulante('<?php echo URLLOGICA?>tripulante/listarTripulantes/',select);
        }
        
        function enviarCorreoSimulador(SIMU_fchvenci_Anio){
            var envio = confirm('Advertencia: Se enviará el Correo informativo de Simuladores. ¿Estas seguro de enviarlo (SI [ok] / NO [cancelar])?.');
            if (envio){
                var url = "<?php echo URLLOGICA?>simulador/enviarCorreoSimulador/";
                $("#preloader").css("display","block");
                var parametros = {
                    //"SIMU_fchvenci_Mes" : SIMU_fchvenci_Mes,
                    "SIMU_fchvenci_Anio" : SIMU_fchvenci_Anio,
                    //"TIPTRIP_id" : TIPTRIP_id,
                };
                $.post(url,parametros,
                function(data){
                    $("#preloader").css("display","none");
                });
            } else {
                return false;
            }
        }
        
        function guardarExcelSimuServidorView(){
            guardarExcelServidor('<?php echo URLLOGICA?>excel/simulador_excel/');
        }
    </script>
    <!-- /.content-wrapper -->
    <?php include "footer_view.php";?>
