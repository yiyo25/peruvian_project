<?php include "header_view.php";?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
				Aptos médicos <small></small>
            </h1>
            <ol class="breadcrumb">
                <li><i class="fa fa-thumb-tack"></i> Aptos Médicos</li>
                <li class="active">
                    Listado de Aptos Médicos
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
                        <form method="post" action="apto/buscarApto/" onsubmit="document.forms['buscar']['buscar'].disabled=true;" name="buscar">
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
                                    <label for="bAPT_indicador" class="col-md-2 control-label">Cumplimiento</label>
                                    <div class="col-md-2">
                                        <select name="bAPT_indicador" id="bAPT_indicador" class="form-control input-sm js-example-basic-single" >
                                            <option value="" selected>Seleccionar Cumplimiento</option>
                                            <?php $selected_Si = '' ?>
                                            <?php $selected_No = '' ?>
                                            <?php if(isset($_SESSION["APT_indicador"])) { ?>
                                                    <?php if($_SESSION["APT_indicador"] == 'Si') { ?>
                                                        <?php $selected_Si = 'selected' ?>
                                                        <?php $selected_No = '' ?>
                                                    <?php } else if($_SESSION["APT_indicador"] == 'No') { ?>
                                                        <?php $selected_Si = '' ?>
                                                        <?php $selected_No = 'selected' ?>
                                                    <?php } ?>
                                            <?php } ?>
                                            <option value="Si" <?php echo $selected_Si;?>>Sí</option>
                                            <option value="No" <?php echo $selected_No;?>>No</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="form-group">
                                <div class="form-group">
                                    <label for="bAPT_fch_Mes" class="col-md-2 control-label">Mes de Apto</label>
                                    <div class="col-md-2">
                                        <select name="bAPT_fch_Mes" id="bAPT_fch_Mes" class="form-control input-sm js-example-basic-single" >
                                            <option value="" selected>Seleccionar Mes</option>
                                        <?php foreach($this->objMes as $lista){ ?>
                                            <?php $selected = "";?>
                                            <?php if(isset($_SESSION["APT_fch_Mes"])) { ?>
                                                <?php if($_SESSION["APT_fch_Mes"] == $lista["MES_id"]) { ?>
                                                    <?php $selected = "selected";?>
                                                <?php } ?>
                                            <?php } ?>
                                            <option value="<?php echo $lista["MES_id"];?>" <?php echo $selected;?>><?php echo utf8_encode(($lista["MES_descripcion"]));?></option>
                                        <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="bAPT_fch_Anio" class="col-md-2 control-label">Año de Apto</label>
                                    <div class="col-md-2">
                                        <select name="bAPT_fch_Anio" id="bAPT_fch_Anio" class="form-control input-sm js-example-basic-single" >
                                            <option value="" selected>Seleccionar Mes</option>
                                        <?php foreach($this->objAnio as $lista){ ?>
                                            <?php $selected = "";?>
                                            <?php if(isset($_SESSION["APT_fch_Anio"])) { ?>
                                                <?php if($_SESSION["APT_fch_Anio"] == $lista["ANIO_descripcion"]) { ?>
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
                                <button type="button" name="limpiar" class="btn btn-danger btn-block" onclick="resetFormApto('<?php echo URLLOGICA?>apto/listarResumenApto/');"> Limpiar </button>
                            </div>
                            <div class="clearfix" style="padding: 4px;"></div>
                    </div>
                    <div id="MainContent_listaPro" class="panel panel-default">
                        <div class="panel-heading clearfix" style="padding: 5px !important">
                            <span id="MainContent_tituloPro"><strong>Lista de Aptos Médicos</strong></span>
                            <?php  $Bdisabled = 0; ?>
                            <?php  $registro = ""; ?>
                            <?php foreach ($this->objBotton as $botton) { ?>
                                <?php if($botton["Funcion"] == "insertApto"){ ?>
                                    <?php  $Bdisabled += 1; ?>
                                <?php } ?>
                            <?php } ?>
                            <?php if($Bdisabled > 0){ $disabled = ""; $registro = ""; } else { $disabled = "disabled"; $registro = "registro"; } ?>
                                <input type="hidden" name="Apto_registro" id="Apto_registro" value="<?php echo $registro;?>" class="form-control input-sm"/>
                                <button type="button" class="pull-right fa fa-medkit" data-toggle="modal" data-target="#aptoRegistro" <?php echo $disabled;?>></button>
                        </div>
                        <div class="area_resultado table-responsive">
                            <table id="listaApto" class="display myDataTables" cellspacing="0" cellpadding="2">
                                <thead>
                                    <tr>
                                        <th scope="col">Item</th>
                                        <th scope="col">Mes de Apto</th>
                                        <th scope="col">Tipo Trip.</th>
                                        <th scope="col">Cant. de Trip.</th>
                                        <th scope="col">Cumplimiento</th>
                                        <th scope="col">Ver</th>
                                        <th scope="col">Envío Correo</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (count($this->objResumenApto) > 0) { ?>
                                        <?php $item = 1; ?>
                                        <?php foreach ($this->objResumenAptoMatriz as $lista) { ?>
                                        <?php $APT_indicador = 'Si'; ?>
                                            <?php foreach ($this->objResumenApto as $listaII) { ?>
                                                <?php if ($lista["APT_fchvenci_MesApto"] == $listaII["APT_fchvenci_MesApto"] and $lista["TIPTRIP_descripcion"] == $listaII["TIPTRIP_descripcion"]) { ?>
                                                    <?php if($listaII["APT_indicador"] == 'No'){ ?>
                                                        <?php $APT_indicador = 'No'; ?>
                                                    <?php } ?>
                                                <?php } ?>
                                            <?php } ?>
                                    <tr>
                                        <td style="width:auto;"><?php echo $item;?></td>
                                        <td style="width:auto;"><?php echo $lista["APT_fchvenci_MesApto"]?></td>
                                        <td style="width:auto;"><?php echo utf8_encode($lista["TIPTRIP_descripcion"]);?></td>
                                        <td style="width:auto;"><?php echo $lista["APT_Afectados"];?></td>
                                        <td style="width:auto;"><?php echo $APT_indicador;?></td>
                                        <td style="width:auto;">
                                            <?php  $Bdisabled = 0; ?>
                                            <?php foreach ($this->objBotton as $botton) { ?>
                                                <?php if($botton["Funcion"] == "listarApto"){ ?>
                                                    <?php  $Bdisabled += 1; ?>
                                                <?php } ?>
                                            <?php } ?>
                                            <?php if($Bdisabled > 0){ $disabled = ""; } else { $disabled = "disabled"; } ?>
                                                <button type="button" class="fa fa-eye" data-toggle="modal" data-target="#aptoDetalle" onclick="listarApto(<?php echo $lista["APT_fchvenci_Mes"];?>,<?php echo $lista["APT_fchvenci_Anio"];?>,<?php echo $lista["TIPTRIP_id"];?>)" <?php echo $disabled;?>></button>
                                        </td>
                                        <td style="width:auto;">
                                            <?php  $Bdisabled = 0; ?>
                                            <?php foreach ($this->objBotton as $botton) { ?>
                                                <?php if($botton["Funcion"] == "insertApto"){ ?>
                                                    <?php  $Bdisabled += 1; ?>
                                                <?php } ?>
                                            <?php } ?>
                                            <?php if($Bdisabled > 0){ $disabled = ""; } else { $disabled = "disabled"; } ?>
                                                <button type="button" class="fa fa-envelope" onclick="enviarCorreoApto(<?php echo $lista["APT_fchvenci_Mes"];?>,<?php echo $lista["APT_fchvenci_Anio"];?>,<?php echo $lista["TIPTRIP_id"];?>)" <?php echo $disabled;?>></button>
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
    <div id="aptoRegistro" class="modal fade" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header" style="padding: 10px !important">
                    <table class="col-xs-12">
                        <tr>
                            <td style="text-align:left;">
                                <h4><strong id="titleForm">Ingresar Nuevo Apto</strong></h4>
                            </td>
                            <td>
                                <button type="button" class="close btn-lg" data-dismiss="modal" onclick="limpiarFormApto();" style="background-color: red; color:white; margin:10px; padding: 0px 6px 2px 6px;text-align:right;">
                                    <span aria-hidden="true">&times;</span><span class="sr-only">Cerrar</span>
                                </button>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="modal-body" style="padding-bottom: 10px;">
                    <div class="row">
                        <div class="col-md-12" style="padding-bottom: 10px;">
                            <label for="TIPTRIP_id" class="col-md-5 control-label">Tipo de Tripulante
                            <span style="color: #FF0000"><strong>*</strong></span></label>
                            <div class="col-md-7">
                                <input type="hidden" name="APT_id" id="APT_id" value="" class="form-control input-sm"/>
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
                            <label for="APT_fchvenci" class="col-md-5 control-label">Fch. de Vencimiento
                            <span style="color: #FF0000"><strong>*</strong></span></label>
                            <div class="col-md-7">
                                <div class='input-group date datetimepicker1' id="APT_fchvenciDate">
                                    <input type="text" name="APT_fchvenci" id="APT_fchvenci" class="form-control input-sm" style="text-transform: uppercase; width: 100% !important;" onblur="dRestantes();"  />
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12" style="padding-bottom: 10px;">
                            <label for="APT_fchgestion" class="col-md-5 control-label">Fch. de Gestión </label>
                            <div class="col-md-7">
                                <div class='input-group date datetimepicker1' id="APT_fchgestionDate">
                                    <?php  $Bdisabled = 0; ?>
                                    <?php  $valor = ""; ?>
                                    <?php foreach ($this->objBotton as $botton) { ?>
                                        <?php if($botton["Funcion"] == "Apto_fechaGestion"){ ?>
                                            <?php  $Bdisabled += 1; ?>
                                        <?php } ?>
                                    <?php } ?>
                                    <?php if($Bdisabled > 0){ $disabled = ""; $valor = "fechaGestion"; } else { $disabled = "disabled"; $valor = ""; } ?>
                                    <input type="text" name="APT_fchgestion" id="APT_fchgestion" class="form-control input-sm" style="text-transform: uppercase; width: 100% !important;" onblur="dRestantes();" <?php echo $disabled;?> />
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                                <input type="hidden" name="Apto_fechaGestion" id="Apto_fechaGestion" value="<?php echo $valor;?>" class="form-control input-sm"/>
                            </div>
                        </div>
                        <div class="col-md-12" style="padding-bottom: 10px;">
                            <label for="APT_drestantes" class="col-md-5 control-label">Días Restantes:
                            <span style="color: #FF0000"><strong>*</strong></span></label>
                            <div class="col-md-7">
                               <input type="text" name="APT_drestantes" id="APT_drestantes" class="form-control input-sm" style="text-transform: uppercase; width: 100% !important;" disabled="disabled" />
                            </div>
                        </div>
                        <div class="col-md-12" style="padding-bottom: 10px;">
                            <label for="APT_estado" class="col-md-5 control-label">Estado:
                            <span style="color: #FF0000"><strong>*</strong></span></label>
                            <div class="col-md-7">
                               <select name="APT_estado" id="APT_estado" class="form-control input-sm js-example-basic-single" onchange="validarEstadoApto();">
                                   <option value="1" selected>Activo</option>
                                   <option value="0">Inactivo</option>
                               </select>
                            </div>
                        </div>
                        <div class="col-md-12" style="padding-bottom: 10px !important; display:none;" id="divAPT_indicador">
                            <label for="APT_indicador" class="col-md-5 control-label">Indicador de Cumplimiento
                            <span style="color: #FF0000"><strong>*</strong></span></label>
                            <div class="col-md-7">
                               <select name="APT_indicador" id="APT_indicador" class="form-control input-sm js-example-basic-single" onchange="validarIndicadorApto();" >
                                   <option value="">Seleccione Indicador</option>
                                   <option value="Si">Sí</option>
                                   <option value="No">No</option>
                               </select>
                            </div>
                        </div>
                        <div class="col-md-12" style="padding-bottom: 10px !important; display:none;" id="divAPT_fchentrega">
                            <label for="APT_fchentrega" class="col-md-5 control-label">Fch. de Entrega
                            <span style="color: #FF0000"><strong>*</strong></span></label>
                            <div class="col-md-7">
                                <div class='input-group date datetimepicker1' id="APT_fchentregaDate">
                                    <input type="text" name="APT_fchentrega" id="APT_fchentrega" class="form-control input-sm" style="text-transform: uppercase; width: 100% !important;" />
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12" style="padding-bottom: 10px !important; display:none;" id="divAPT_observacion">
                            <label for="APT_observacion" class="col-md-5 control-label">Observación: </label>
                            <div class="col-md-7">
                               <input type="text" name="APT_observacion" id="APT_observacion" class="form-control input-sm" style="text-transform: uppercase; width: 100% !important;" />
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
                    <button name='insertApto' id='insertApto' type="button" class="btn btn-sm" onclick="flagEstadoModulo('<?php echo URLLOGICA?>apto/insertApto/','listar','apto');">Grabar</button> <!--onclick="insertApto('<?php //echo URLLOGICA?>apto/insertApto/');"-->
                    <button name='updateApto' id='updateApto' type="button" class="btn btn-sm" onclick="flagEstadoModulo('<?php echo URLLOGICA?>apto/updateApto/','modificar','apto')">Modificar</button> <!--'<?php //echo URLLOGICA?>apto/updateApto/');-->
                    <button name="closeApto" id="closeApto" type="button" class="btn btn-danger btn-sm" data-dismiss="modal" onclick="limpiarFormApto();">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
    
    <div id="aptoDetalle" class="modal fade" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content modal-lg">
                <div class="modal-header" style="padding: 10px !important">
                    <table class="col-xs-12">
                        <tr>
                            <td style="text-align:left;">
                                <h4><strong id="titleForm">Detalle de Mes</strong></h4>
                            </td>
                            <td>
                                <button type="button" class="close btn-lg" data-dismiss="modal" onclick="limpiarFormApto();" style="background-color: red; color:white; margin:10px; padding: 0px 6px 2px 6px;text-align:right;">
                                    <span aria-hidden="true">&times;</span><span class="sr-only">Cerrar</span>
                                </button>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="modal-body" style="padding-bottom: 10px;">
                    <div class="area_resultado table-responsive">
                        <table id="listaDetApto" class="display" cellspacing="0" cellpadding="2">
                            <thead>
                                <tr>
                                    <th scope="col">Item</th>
                                    <th scope="col">Tripulante</th>
                                    <th scope="col">Indicador</th>
                                    <th scope="col">Fch. de Vencimiento</th>
                                    <th scope="col">Fch. de Gestión</th>
                                    <th scope="col">Días Restantes</th>
                                    <th scope="col">Ver</th>
                                    <th scope="col">Editar</th>
                                </tr>
                            </thead>
                            <tbody id="listaAptoMes">
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
        
        function listarApto(APT_fchvenci_Mes,APT_fchvenci_Anio,TIPTRIP_id){
            var url = "<?php echo URLLOGICA?>apto/listarApto/";
            $("#preloader").css("display","block");
            
            var parametros = {
                "APT_fchvenci_Anio" : APT_fchvenci_Anio,
                "APT_fchvenci_Mes" : APT_fchvenci_Mes,
                "TIPTRIP_id" : TIPTRIP_id
            };
            $.post(url,parametros,
            function(data){
                if(data == ""){
                    alert("Hubo un error al cargar la información.");
                } else {
                    $("#listaAptoMes").empty();
                    var f = new Date();
                    var fecha1 = (f.getDate() + "/" + (f.getMonth() +1) + "/" + f.getFullYear());
                    
                    for (var i = 1; i <= data.length; i++) {
                        
                    var fecha2 = data[i-1]["APT_fchvenci"];
                    var dRestantes = restaFechas(fecha1,fecha2);
                    html = '<tr>'
                            + '<input type="hidden" name="APT_fchvenci_Mes" id="APT_fchvenci_Mes" value="' + APT_fchvenci_Mes + '" class="form-control input-sm"/>'
                            + '<input type="hidden" name="APT_fchvenci_Anio" id="APT_fchvenci_Anio" value="' + APT_fchvenci_Anio + '" class="form-control input-sm"/>'
                            + '<input type="hidden" name="TIPTRIP_id" id="TIPTRIP_id" value="' + TIPTRIP_id + '" class="form-control input-sm"/>'
                            + '<td style="width:auto;">' + i + '</td>'
                            + '<td style="width:auto;">' + data[i-1]["TRIP_nombre"] + ' ' + data[i-1]["TRIP_apellido"] + '</td>'
                            + '<td style="width:auto;">' + data[i-1]["APT_indicador"] + '</td>'
                            + '<td style="width:auto;">' + data[i-1]["APT_fchvenci"] + '</td>'
                            + '<td style="width:auto;">' + data[i-1]["APT_fchgestion"] + '</td>'
                            + '<td style="width:auto;">' + dRestantes + '</td>'
                            + '<td style="width:auto;">'
                                <?php  $Bdisabled = 0; ?>
                                <?php foreach ($this->objBotton as $botton) { ?>
                                    <?php if($botton["Funcion"] == "listarDetApto"){ ?>
                                        <?php  $Bdisabled += 1; ?>
                                    <?php } ?>
                                <?php } ?>
                                <?php if($Bdisabled > 0){ $disabled = ""; } else { $disabled = "disabled"; } ?>
                                    + '<button type="button" class="fa fa-eye" data-toggle="modal" data-target="#aptoRegistro" onclick="listarDetApto(\'<?php echo URLLOGICA?>apto/listarDetApto/\',' + data[i-1]["APT_id"] + ',\'listar\')" <?php echo $disabled;?>></button>'
                            + '</td>'
                            + '<td style="width:auto;">'
                                <?php  $Bdisabled = 0; ?>
                                <?php foreach ($this->objBotton as $botton) { ?>
                                    <?php if($botton["Funcion"] == "updateDetApto"){ ?>
                                        <?php  $Bdisabled += 1; ?>
                                    <?php } ?>
                                <?php } ?>
                                <?php if($Bdisabled > 0){ $disabled = ""; } else { $disabled = "disabled"; } ?>
                                    + '<button type="button" class="fa fa-pencil" data-toggle="modal" data-target="#aptoRegistro" onclick="listarDetApto(\'<?php echo URLLOGICA?>apto/listarDetApto/\',' + data[i-1]["APT_id"] + ',\'modificar\')" <?php echo $disabled;?>></button>'
                            + '</td>'
                        + '</tr>';
                        $("#listaAptoMes").append(html);
                    };
                    myDataTables('listaDetApto');
                    $("#preloader").css("display", "none");
                }
            });
        }
        
        function enviarCorreoApto(APT_fchvenci_Mes,APT_fchvenci_Anio,TIPTRIP_id){
            var envio = confirm('Advertencia: Se enviará el Correo informativo de Apto Médico. ¿Estas seguro de enviarlo (SI [ok] / NO [cancelar])?.');
            if (envio){
                var url = "<?php echo URLLOGICA?>apto/enviarCorreoApto/";
                $("#preloader").css("display","block");
                var parametros = {
                    "APT_fchvenci_Mes" : APT_fchvenci_Mes,
                    "APT_fchvenci_Anio" : APT_fchvenci_Anio,
                    "TIPTRIP_id" : TIPTRIP_id,
                };
                $.post(url,parametros,
                function(data){
                    $("#preloader").css("display","none");
                });
            } else {
                return false;
            }
        }
    </script>
    <!-- /.content-wrapper -->
    <?php include "footer_view.php";?>
