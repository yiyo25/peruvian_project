<?php include "header_view.php";?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
				Chequeos de desempeño<small></small>
            </h1>
            <ol class="breadcrumb">
                <li><i class="fa fa-thumb-tack"></i> Chequeos</li>
                <li class="active">
                    Listado de Chequeos
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
                        <form method="post" action="<?php echo URLLOGICA?>chequeo/buscarChequeo/" onsubmit="document.forms['buscar']['buscar'].disabled=true;" name="buscar">
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
                                    <label for="bCHEQ_indicador" class="col-md-2 control-label">Cumplimiento</label>
                                    <div class="col-md-2">
                                        <select name="bCHEQ_indicador" id="bCHEQ_indicador" class="form-control input-sm js-example-basic-single" >
                                            <option value="" selected>Seleccionar Cumplimiento</option>
                                            <?php $selected_APROBADO = '' ?>
                                            <?php $selected_DESAPROBADO = '' ?>
                                            <?php $selected_OBSERVADO = '' ?>
                                            <?php $selected_PENDIENTE = '' ?>
                                            <?php if(isset($_SESSION["CHEQ_indicador"])) { ?>
                                                    <?php if($_SESSION["CHEQ_indicador"] == 'APROBADO') { ?>
                                                        <?php $selected_APROBADO = 'selected' ?>
                                                        <?php $selected_DESAPROBADO = '' ?>
                                                        <?php $selected_OBSERVADO = '' ?>
                                                        <?php $selected_PENDIENTE = '' ?>
                                                    <?php } else if($_SESSION["CHEQ_indicador"] == 'DESAPROBADO') { ?>
                                                        <?php $selected_APROBADO = '' ?>
                                                        <?php $selected_DESAPROBADO = 'selected' ?>
                                                        <?php $selected_OBSERVADO = '' ?>
                                                        <?php $selected_PENDIENTE = '' ?>
                                                    <?php } else if($_SESSION["CHEQ_indicador"] == 'OBSERVADO') { ?>
                                                        <?php $selected_APROBADO = '' ?>
                                                        <?php $selected_DESAPROBADO = '' ?>
                                                        <?php $selected_OBSERVADO = 'selected' ?>
                                                        <?php $selected_PENDIENTE = '' ?>
                                                    <?php } else if($_SESSION["CHEQ_indicador"] == 'PENDIENTE') { ?>
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
                            <div class="row-fluid">
                                <div class="form-group">
                                    <label for="bCHEQ_fch_Mes" class="col-md-2 control-label">Mes de Chequeo</label>
                                    <div class="col-md-2">
                                        <select name="bCHEQ_fch_Mes" id="bCHEQ_fch_Mes" class="form-control input-sm js-example-basic-single" >
                                            <option value="" selected>Seleccionar Mes</option>
                                        <?php foreach($this->objMes as $lista){ ?>
                                            <?php $selected = "";?>
                                            <?php if(isset($_SESSION["CHEQ_fch_Mes"])) { ?>
                                                <?php if($_SESSION["CHEQ_fch_Mes"] == $lista["MES_id"]) { ?>
                                                    <?php $selected = "selected";?>
                                                <?php } ?>
                                            <?php } ?>
                                            <option value="<?php echo $lista["MES_id"];?>" <?php echo $selected;?>><?php echo utf8_encode(($lista["MES_descripcion"]));?></option>
                                        <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="bCHEQ_fch_Anio" class="col-md-2 control-label">Año de Chequeo</label>
                                    <div class="col-md-2">
                                        <select name="bCHEQ_fch_Anio" id="bCHEQ_fch_Anio" class="form-control input-sm js-example-basic-single" >
                                            <option value="" selected>Seleccionar Mes</option>
                                        <?php foreach($this->objAnio as $lista){ ?>
                                            <?php $selected = "";?>
                                            <?php if(isset($_SESSION["CHEQ_fch_Anio"])) { ?>
                                                <?php if($_SESSION["CHEQ_fch_Anio"] == $lista["ANIO_descripcion"]) { ?>
                                                    <?php $selected = "selected";?>
                                                <?php } ?>
                                            <?php } ?>
                                            <option value="<?php echo $lista["ANIO_descripcion"];?>" <?php echo $selected;?>><?php echo utf8_encode(($lista["ANIO_descripcion"]));?></option>
                                        <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="bTIPCHEQ_id" class="col-md-2 control-label">Tipo de Chequeo</label>
                                    <div class="col-md-2">
                                        <select name="bTIPCHEQ_id" id="bTIPCHEQ_id" class="form-control input-sm js-example-basic-single" >
                                            <option value="" selected>Tipo de Chequeo</option>
                                        <?php foreach($this->objTipoChequeo as $lista){ ?>
                                            <option value="<?php echo $lista["TIPCHEQ_id"];?>"><?php echo utf8_encode(($lista["TIPCHEQ_descripcion"]));?></option>
                                        <?php } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="row-fluid">
                                <div class="form-group">
                                    <div class="col-md-2 col-md-offset-8">
                                        <input type="submit" name="buscar" value="Buscar" class="btn btn-danger btn-block" />
                                    </div>
                                </div>
                            </div>
                        </form>
                            <div class="col-md-2">
                                <button type="button" name="limpiar" class="btn btn-danger btn-block" onclick="resetFormChequeo('<?php echo URLLOGICA?>chequeo/listarResumenChequeo/');"> Limpiar </button>
                            </div>
                            <div class="clearfix" style="padding: 4px;"></div>
                    </div>
                    <div id="MainContent_listaPro" class="panel panel-default">
                        <div class="panel-heading clearfix" style="padding: 5px !important">
                            <span id="MainContent_tituloPro"><strong>Lista de Chequeos</strong></span>
                            <?php  $Bdisabled = 0; ?>
                            <?php foreach ($this->objBotton as $botton) { ?>
                                <?php if($botton["Funcion"] == "insertChequeo"){ ?>
                                    <?php  $Bdisabled += 1; ?>
                                <?php } ?>
                            <?php } ?>
                            <?php if($Bdisabled > 0){ $disabled = ""; } else { $disabled = "disabled"; } ?>
                                <button type="button" class="pull-right fa fa-pencil-square-o" data-toggle="modal" data-target="#chequeoRegistro" <?php echo $disabled;?>></button>
                        </div>
                        <div class="area_resultado table-responsive">
                            <table id="listaChequeo" class="display myDataTables" cellspacing="0" cellpadding="2">
                                <thead>
                                    <tr>
                                        <th scope="col">Item</th>
                                        <th scope="col">Mes de Chequeo</th>
                                        <th scope="col">Tipo Chequeo</th>
                                        <th scope="col">Tipo Trip.</th>
                                        <th scope="col">Cant. de Trip.</th>
                                        <th scope="col">Cumplimiento</th>
                                        <th scope="col">Ver</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (count($this->objResumenChequeo) > 0) { ?>
                                        <?php $item = 1; ?>
                                        <?php foreach ($this->objResumenChequeoMatriz as $lista) { ?>
                                        <?php $CHEQ_indicador = 'APROBADO'; ?>
                                            <?php foreach ($this->objResumenChequeo as $listaII) { ?>
                                                <?php if ($lista["TIPTRIP_descripcion"] == $listaII["TIPTRIP_descripcion"] and $lista["CHEQ_fch_MesChequeo"] == $listaII["CHEQ_fch_MesChequeo"]) { ?>
                                                    <?php if($listaII["CHEQ_indicador"] == 'DESAPROBADO'){ ?>
                                                        <?php $CHEQ_indicador = 'DESAPROBADO'; ?>
                                                    <?php } else if($listaII["CHEQ_indicador"] == 'OBSERVADO') { ?>
                                                        <?php $CHEQ_indicador = 'OBSERVADO'; ?>
                                                    <?php } else if($listaII["CHEQ_indicador"] == 'PENDIENTE') { ?>
                                                        <?php $CHEQ_indicador = 'PENDIENTE'; ?>
                                                    <?php } ?>
                                                <?php } ?>
                                            <?php } ?>
                                    <tr>
                                        <td style="width:auto;"><?php echo $item;?></td>
                                        <td style="width:auto;"><?php echo $lista["CHEQ_fch_MesChequeo"];?></td>
                                        <td style="width:auto;"><?php echo utf8_encode($lista["TIPCHEQ_descripcion"]);?></td>
                                        <td style="width:auto;"><?php echo utf8_encode($lista["TIPTRIP_descripcion"]);?></td>
                                        <td style="width:auto;"><?php echo $lista["CHEQ_Afectados"];?></td>
                                        <td style="width:auto;"><?php echo $CHEQ_indicador;?></td>
                                        <td style="width:auto;">
                                            <?php  $Bdisabled = 0; ?>
                                            <?php foreach ($this->objBotton as $botton) { ?>
                                                <?php if($botton["Funcion"] == "listarChequeo"){ ?>
                                                    <?php  $Bdisabled += 1; ?>
                                                <?php } ?>
                                            <?php } ?>
                                            <?php if($Bdisabled > 0){ $disabled = ""; } else { $disabled = "disabled"; } ?>
                                                <button type="button" class="fa fa-eye" data-toggle="modal" data-target="#chequeoDetalle" onclick="listarChequeo(<?php echo utf8_encode($lista["CHEQ_fch_Mes"]);?>,<?php echo utf8_encode($lista["CHEQ_fch_Anio"]);?>,<?php echo $lista["TIPTRIP_id"];?>)" <?php echo $disabled;?>></button>
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
    <div id="chequeoRegistro" class="modal fade" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header" style="padding: 10px !important">
                    <table class="col-xs-12">
                        <tr>
                            <td style="text-align:left;">
                                <h4><strong id="titleForm">Ingresar Nuevo Chequeo</strong></h4>
                            </td>
                            <td>
                                <button type="button" class="close btn-lg" data-dismiss="modal" onclick="limpiarFormChequeo();" style="background-color: red; color:white; margin:10px; padding: 0px 6px 2px 6px;text-align:right;">
                                    <span aria-hidden="true">&times;</span><span class="sr-only">Cerrar</span>
                                </button>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="modal-body" style="padding-bottom: 10px;">
                    <div class="row">
                        <div class="col-md-12" style="padding-bottom: 10px;">
                            <label for="TIPCHEQ_id" class="col-md-5 control-label">Tipo de Chequeo
                            <span style="color: #FF0000"><strong>*</strong></span></label>
                            <div class="col-md-7">
                                <input type="hidden" name="CHEQ_id" id="CHEQ_id" value="" class="form-control input-sm"/>
                                <select name="TIPCHEQ_id" id="TIPCHEQ_id" class="form-control input-sm js-example-basic-single" >
                                    <option value="" selected>Tipo de Chequeo</option>
                                <?php foreach($this->objTipoChequeo as $lista){ ?>
                                    <option value="<?php echo $lista["TIPCHEQ_id"];?>"><?php echo utf8_encode(($lista["TIPCHEQ_descripcion"]));?></option>
                                <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12" style="padding-bottom: 10px;">
                            <label for="TIPTRIP_id" class="col-md-5 control-label">Tipo de Tripulante
                            <span style="color: #FF0000"><strong>*</strong></span></label>
                            <div class="col-md-7">
                                <select name="TIPTRIP_id" id="TIPTRIP_id" class="form-control input-sm js-example-basic-single" >
                                    <option value="" selected>Tipo de Tripulante</option>
                                <?php foreach($this->objTipoTripulante as $lista){ ?>
                                    <option value="<?php echo $lista["TIPTRIP_id"];?>"><?php echo ($lista["TIPTRIP_descripcion"]);?></option>
                                <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12" style="padding-bottom: 10px;">
                            <label for="TIPTRIPDET_id" class="col-md-5 control-label">Tipo de Detalle de Trip.
                            <span style="color: #FF0000"><strong>*</strong></span></label>
                            <div class="col-md-7">
                                <select name="TIPTRIPDET_id" id="TIPTRIPDET_id" class="form-control input-sm js-example-basic-single" >
                                    <option value="" selected>Tipo Detalle de Trip.</option>
                                <?php foreach($this->objTipoDetTripulante as $lista){ ?>
                                    <option class="<?php echo $lista["TIPTRIP_id"];?>" value="<?php echo $lista["TIPTRIPDET_id"];?>"><?php echo ($lista["TIPTRIPDET_descripcion"]);?></option>
                                <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12" style="padding-bottom: 10px;">
                            <label for="TRIP_id" class="col-md-5 control-label">Tripulante Afectado
                            <span style="color: #FF0000"><strong>*</strong></span></label>
                            <div class="col-md-7">
                                <select name="TRIP_id" id="TRIP_id" class="form-control input-sm js-example-basic-single" >
                                    <option value="" selected>Tripulante Afectado</option>
                                <?php foreach($this->objTripulante as $lista){ ?>
                                    <option class="<?php echo $lista["TIPTRIPDET_id"];?>" value="<?php echo $lista["TRIP_id"];?>"><?php echo utf8_encode($lista["TRIP_nombre"]." ".$lista["TRIP_apellido"]);?></option>
                                <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12" style="padding-bottom: 10px;">
                            <label for="CHEQ_fch" class="col-md-5 control-label">Fch. de Chequeo
                            <span style="color: #FF0000"><strong>*</strong></span></label>
                            <div class="col-md-7">
                                <div class='input-group date datetimepicker1'>
                                    <input type="text" name="CHEQ_fch" id="CHEQ_fch" class="form-control input-sm" style="text-transform: uppercase; width: 100% !important;" />
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12" style="padding-bottom: 10px;">
                            <label for="CHEQ_estado" class="col-md-5 control-label">Estado:
                            <span style="color: #FF0000"><strong>*</strong></span></label>
                            <div class="col-md-7">
                               <select name="CHEQ_estado" id="CHEQ_estado" class="form-control input-sm js-example-basic-single" onchange="validarEstadoChequeo();">
                                   <option value="1" selected>Activo</option>
                                   <option value="0">Inactivo</option>
                               </select>
                            </div>
                        </div>
                        <div class="col-md-12" style="padding-bottom: 10px !important; display:none;" id="divCHEQ_indicador">
                            <label for="CHEQ_indicador" class="col-md-5 control-label">Indicador de Cumplimiento
                            <span style="color: #FF0000"><strong>*</strong></span></label>
                            <div class="col-md-7">
                               <select name="CHEQ_indicador" id="CHEQ_indicador" class="form-control input-sm js-example-basic-single" onchange="validarIndicadorChequeo();">
                                    <option value="" selected>Seleccione Cumplimiento</option>
                                    <option value="APROBADO">APROBADO</option>
                                    <option value="DESAPROBADO">DESAPROBADO</option>
                                    <option value="OBSERVADO">OBSERVADO</option>
                                    <option value="PENDIENTE">PENDIENTE</option>
                               </select>
                            </div>
                        </div>
                        <div class="col-md-12" style="padding-bottom: 10px !important; display:none;" id="divCHEQ_fchentrega">
                            <label for="CHEQ_fchentrega" class="col-md-5 control-label">Fch. de Entrega
                            <span style="color: #FF0000"><strong>*</strong></span></label>
                            <div class="col-md-7">
                                <div class='input-group date datetimepicker1' id="CHEQ_fchentregaDate">
                                    <input type="text" name="CHEQ_fchentrega" id="CHEQ_fchentrega" class="form-control input-sm" style="text-transform: uppercase; width: 100% !important;" />
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12" style="padding-bottom: 10px !important; display:none;" id="divCHEQ_observacion">
                            <label for="CHEQ_observacion" class="col-md-5 control-label">Observación: </label>
                            <div class="col-md-7">
                               <input type="text" name="CHEQ_observacion" id="CHEQ_observacion" class="form-control input-sm" style="text-transform: uppercase; width: 100% !important;" />
                            </div>
                        </div>
                        <div class="col-md-12" style="padding-bottom: 10px !important; display:none;" id="divAUD_usu_cre">
                            <label for="AUD_usu_cre" class="col-md-5 control-label">Usuario de Creación:
                            <span style="color: #FF0000"><strong>*</strong></span></label>
                            <div class="col-md-7">
                               <input type="text" name="AUD_usu_cre" id="AUD_usu_cre" class="form-control input-sm numberDecimal" style="text-transform: uppercase; width: 100% !important;" />
                            </div>
                        </div>
                        <div class="col-md-12" style="padding-bottom: 10px !important; display:none;" id="divAUD_fch_cre">
                            <label for="AUD_fch_cre" class="col-md-5 control-label">Fecha de Creación:
                            <span style="color: #FF0000"><strong>*</strong></span></label>
                            <div class="col-md-7">
                               <input type="text" name="AUD_fch_cre" id="AUD_fch_cre" class="form-control input-sm numberDecimal" style="text-transform: uppercase; width: 100% !important;" />
                            </div>
                        </div>
                        <div class="col-md-12" style="padding-bottom: 10px !important; display:none;" id="divAUD_usu_mod">
                            <label for="AUD_usu_mod" class="col-md-5 control-label">Usuario de Mod.:
                            <span style="color: #FF0000"><strong>*</strong></span></label>
                            <div class="col-md-7">
                               <input type="text" name="AUD_usu_mod" id="AUD_usu_mod" class="form-control input-sm numberDecimal" style="text-transform: uppercase; width: 100% !important;" />
                            </div>
                        </div>
                        <div class="col-md-12" style="padding-bottom: 10px !important; display:none;" id="divAUD_fch_mod">
                            <label for="AUD_fch_mod" class="col-md-5 control-label">Fecha de Mod.:
                            <span style="color: #FF0000"><strong>*</strong></span></label>
                            <div class="col-md-7">
                               <input type="text" name="AUD_fch_mod" id="AUD_fch_mod" class="form-control input-sm numberDecimal" style="text-transform: uppercase; width: 100% !important;" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer" style="padding: 10px !important">
                    <button name='insertChequeo' id='insertChequeo' type="button" class="btn btn-sm" onclick="flagEstadoModulo('<?php echo URLLOGICA?>chequeo/insertChequeo/','listar','chequeo');">Grabar</button><!-- insertChequeo('<?php //echo URLLOGICA?>chequeo/insertChequeo/'); -->
                    <button name='updateChequeo' id='updateChequeo' type="button" class="btn btn-sm" onclick="flagEstadoModulo('<?php echo URLLOGICA?>chequeo/updateChequeo/','modificar','chequeo')">Modificar</button><!-- updateChequeo('<?php //echo URLLOGICA?>chequeo/updateChequeo/'); -->
                    <button name="closeChequeo" id="closeChequeo" type="button" class="btn btn-danger btn-sm" data-dismiss="modal" onclick="limpiarFormChequeo();">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
    
    <div id="chequeoDetalle" class="modal fade" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content modal-lg">
                <div class="modal-header" style="padding: 10px !important">
                    <table class="col-xs-12">
                        <tr>
                            <td style="text-align:left;">
                                <h4><strong id="titleForm">Detalle de Tripulantes</strong></h4>
                            </td>
                            <td>
                                <button type="button" class="close btn-lg" data-dismiss="modal" onclick="limpiarFormChequeo();" style="background-color: red; color:white; margin:10px; padding: 0px 6px 2px 6px;text-align:right;">
                                    <span aria-hidden="true">&times;</span><span class="sr-only">Cerrar</span>
                                </button>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="modal-body" style="padding-bottom: 10px;">
                    <div class="area_resultado table-responsive">
                        <table id="listaDetChequeo" class="display" cellspacing="0" cellpadding="2">
                            <thead>
                                <tr>
                                    <th scope="col">Item</th>
                                    <th scope="col">Tipo Chequeo</th>
                                    <th scope="col">Tripulante</th>
                                    <th scope="col">Fch. de Chequeo</th>
                                    <th scope="col">Indicador</th>
                                    <th scope="col">Ver</th>
                                    <th scope="col">Editar</th>
                                </tr>
                            </thead>
                            <tbody id="listaChequeoMes">
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
        });
        
        function listarComboDetalleTripView(){
            listarComboDetalleTrip('<?php echo URLLOGICA?>detalle/listarTipoTripDetalle/');
        }
        
        function listarComboTripulanteView(select){
            listarComboTripulante('<?php echo URLLOGICA?>tripulante/listarTripulantes/',select);
        }
        
        function listarChequeo(CHEQ_fch_Mes,CHEQ_fch_Anio,TIPTRIP_id){
            var url = "<?php echo URLLOGICA?>chequeo/listarChequeo/";
            $("#preloader").css("display","block");
            var parametros = {
                "CHEQ_fch_Mes" : CHEQ_fch_Mes,
                "CHEQ_fch_Anio" : CHEQ_fch_Anio,
                "TIPTRIP_id" : TIPTRIP_id
            };
            $.post(url,parametros,
            function(data){
                if(data == ""){
                    alert("Hubo un error al cargar la información.");
                } else {
                    $("#listaChequeoMes").empty();
                    
                    for (var i = 1; i <= data.length; i++) {
                    html = '<tr>'
                            + '<input type="hidden" name="CHEQ_fch_Mes" id="CHEQ_fch_Mes" value="' + CHEQ_fch_Mes + '" class="form-control input-sm"/>'
                            + '<input type="hidden" name="CHEQ_fch_Anio" id="CHEQ_fch_Anio" value="' + CHEQ_fch_Anio + '" class="form-control input-sm"/>'
                            + '<input type="hidden" name="TIPTRIP_id" id="TIPTRIP_id" value="' + TIPTRIP_id + '" class="form-control input-sm"/>'
                            + '<td style="width:auto;">' + i + '</td>'
                            + '<td style="width:auto;">' + data[i-1]["TIPCHEQ_descripcion"] + '</td>'
                            + '<td style="width:auto;">' + data[i-1]["TRIP_nombre"] + ' ' + data[i-1]["TRIP_apellido"] + '</td>'
                            + '<td style="width:auto;">' + data[i-1]["CHEQ_fch"] + '</td>'
                            + '<td style="width:auto;">' + data[i-1]["CHEQ_indicador"] + '</td>'
                            + '<td style="width:auto;">'
                                <?php  $Bdisabled = 0; ?>
                                <?php foreach ($this->objBotton as $botton) { ?>
                                    <?php if($botton["Funcion"] == "listarDetChequeo"){ ?>
                                        <?php  $Bdisabled += 1; ?>
                                    <?php } ?>
                                <?php } ?>
                                <?php if($Bdisabled > 0){ $disabled = ""; } else { $disabled = "disabled"; } ?>
                                    + '<button type="button" class="fa fa-eye" data-toggle="modal" data-target="#chequeoRegistro" onclick="listarDetChequeo(\'<?php echo URLLOGICA?>chequeo/listarDetChequeo/\',' + data[i-1]["CHEQ_id"] + ',\'listar\')" <?php echo $disabled;?>></button>'
                            + '</td>'
                            + '<td style="width:auto;">'
                                <?php  $Bdisabled = 0; ?>
                                <?php foreach ($this->objBotton as $botton) { ?>
                                    <?php if($botton["Funcion"] == "updateDetChequeo"){ ?>
                                        <?php  $Bdisabled += 1; ?>
                                    <?php } ?>
                                <?php } ?>
                                <?php if($Bdisabled > 0){ $disabled = ""; } else { $disabled = "disabled"; } ?>
                                    + '<button type="button" class="fa fa-pencil" data-toggle="modal" data-target="#chequeoRegistro" onclick="listarDetChequeo(\'<?php echo URLLOGICA?>chequeo/listarDetChequeo/\',' + data[i-1]["CHEQ_id"] + ',\'modificar\')" <?php echo $disabled;?>></button>'
                            + '</td>'
                        + '</tr>';
                        $("#listaChequeoMes").append(html);
                    };
                    myDataTables('listaDetChequeo');
                    $("#preloader").css("display", "none");
                }
            });
        }
    </script>
    <!-- /.content-wrapper -->
    <?php include "footer_view.php";?>
