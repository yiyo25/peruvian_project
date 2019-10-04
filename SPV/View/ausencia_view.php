<?php include "header_view.php";?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
				Ausencias <small></small>
            </h1>
            <ol class="breadcrumb">
                <li><i class="fa fa-thumb-tack"></i> Ausencias</li>
                <li class="active">
                    Listado de Ausencias
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
                        <form method="post" action="<?php echo URLLOGICA?>ausencia/buscarAusencia/" onsubmit="document.forms['buscar']['buscar'].disabled=true;" name="buscar">
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
                            </div>
                            <div class="clearfix"></div>
                            <div class="row-fluid">
                                <div class="form-group">
                                    <label for="bTIPAUS_id" class="col-md-2 control-label">Tipo de Ausencia</label>
                                    <div class="col-md-2">
                                        <select name="bTIPAUS_id" id="bTIPAUS_id" class="form-control input-sm js-example-basic-single" >
                                            <option value="" selected>Tipo de Ausencia</option>
                                        <?php foreach($this->objTipoAusencia as $lista){ ?>
                                            <?php $selected = "";?>
                                            <?php if(isset($_SESSION["TIPAUS_id"])) { ?>
                                                <?php if($_SESSION["TIPAUS_id"] == $lista["TIPAUS_id"]) { ?>
                                                    <?php $selected = "selected";?>
                                                <?php } ?>
                                            <?php } ?>
                                            <option value="<?php echo $lista["TIPAUS_id"];?>" <?php echo $selected;?>><?php echo utf8_encode(($lista["TIPAUS_descripcion"]));?></option>
                                        <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="bTRIP_numlicencia" class="col-md-2 control-label">N° de Licencia</label>
                                    <div class="col-md-2">
                                        <input type="text" name="bTRIP_numlicencia" id="bTRIP_numlicencia" value="<?php if(isset($_SESSION["TRIP_numlicencia"])) { echo $_SESSION["TRIP_numlicencia"]; } else { echo ""; }?>" class="form-control input-sm numberEntero" style="text-transform: uppercase;" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-2">
                                        <input type="submit" name="buscar" value="Buscar" class="btn btn-danger btn-block" />
                                    </div>
                                </div>
                            </div>
                        </form>
                            <div class="col-md-2">
                                <button type="button" name="limpiar" class="btn btn-danger btn-block" onclick="resetFormAusencia('<?php echo URLLOGICA?>ausencia/listarAusencia/');"> Limpiar </button>
                            </div>
                            <div class="clearfix" style="padding: 4px;"></div>
                    </div>
                    <div id="MainContent_listaPro" class="panel panel-default">
                        <div class="panel-heading clearfix" style="padding: 5px !important">
                            <span id="MainContent_tituloPro"><strong>Lista de Ausencias</strong></span>
                            <?php  $Bdisabled = 0; ?>
                            <?php foreach ($this->objBotton as $botton) { ?>
                                <?php if($botton["Funcion"] == "insertAusencia"){ ?>
                                    <?php  $Bdisabled += 1; ?>
                                <?php } ?>
                            <?php } ?>
                            <?php if($Bdisabled > 0){ $disabled = ""; } else { $disabled = "disabled"; } ?>
                                <button type="button" class="pull-right fa fa-handshake-o" data-toggle="modal" data-target="#ausenciaRegistro" <?php echo $disabled;?>></button>
                        </div>
                        <div class="area_resultado table-responsive">
                            <table id="listaAusencia" class="display myDataTables" cellspacing="0" cellpadding="2">
                                <thead>
                                    <tr>
                                        <th scope="col">Item</th>
                                        <th scope="col">Nombre y Apellidos</th>
                                        <th scope="col">Tipo Tripulante</th>
                                        <th scope="col">Tipo Ausencia</th>
                                        <th scope="col">Fecha Inicio</th>
                                        <th scope="col">Fecha Fin</th>
                                        <th scope="col">Fch. Registro</th>
                                        <th scope="col">Ver</th>
                                        <th scope="col">Editar</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (count($this->objAusencia) > 0) { ?>
                                        <?php $item = 1; ?>
                                        <?php foreach ($this->objAusencia as $lista) { ?>
                                    <tr>
                                        <td style="width:auto;"><?php echo $item;?></td>
                                        <td style="width:auto;"><?php echo utf8_encode($lista["TRIP_nombre"]." ".$lista["TRIP_apellido"]);?></td>
                                        <td style="width:auto;"><?php echo utf8_encode($lista["TIPTRIP_descripcion"]);?></td>
                                        <td style="width:auto;"><?php echo utf8_encode($lista["TIPAUS_descripcion"]);?></td>
                                        <td style="width:auto;"><?php echo $lista["AUS_fchini"];?></td>
                                        <td style="width:auto;"><?php echo $lista["AUS_fchfin"];?></td>
                                        <td style="width:auto;"><?php echo $lista["AUD_fch_cre"];?></td>
                                        <td style="width:auto;">
                                            <?php  $Bdisabled = 0; ?>
                                            <?php foreach ($this->objBotton as $botton) { ?>
                                                <?php if($botton["Funcion"] == "listarAusencia"){ ?>
                                                    <?php  $Bdisabled += 1; ?>
                                                <?php } ?>
                                            <?php } ?>
                                            <?php if($Bdisabled > 0){ $disabled = ""; } else { $disabled = "disabled"; } ?>
                                                <button type="button" class="fa fa-eye" data-toggle="modal"  data-target="#ausenciaRegistro" onclick="listarDetAusencia('<?php echo URLLOGICA?>ausencia/listarDetAusencia/',<?php echo utf8_encode($lista["AUS_id"]);?>,'listar')" <?php echo $disabled;?>></button>
                                        </td>
                                        <td style="width:auto;">
                                            <?php  $Bdisabled = 0; ?>
                                            <?php foreach ($this->objBotton as $botton) { ?>
                                                <?php if($botton["Funcion"] == "updateAusencia"){ ?>
                                                    <?php  $Bdisabled += 1; ?>
                                                <?php } ?>
                                            <?php } ?>
                                            <?php if($Bdisabled > 0){ $disabled = ""; } else { $disabled = "disabled"; } ?>
                                                <button type="button" class="fa fa-pencil" data-toggle="modal" data-target="#ausenciaRegistro" onclick="listarDetAusencia('<?php echo URLLOGICA?>ausencia/listarDetAusencia/',<?php echo utf8_encode($lista["AUS_id"]);?>,'modificar')" <?php echo $disabled;?>></button>
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
    <div id="ausenciaRegistro" class="modal fade" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header" style="padding: 10px !important">
                    <table class="col-xs-12">
                        <tr>
                            <td style="text-align:left;">
                                <h4><strong id="titleForm">Ingresar Nueva Ausencia</strong></h4>
                            </td>
                            <td>
                                <button type="button" class="close btn-lg" data-dismiss="modal" onclick="limpiarFormAusencia();" style="background-color: red; color:white; margin:10px; padding: 0px 6px 2px 6px;text-align:right;">
                                    <span aria-hidden="true">&times;</span><span class="sr-only">Cerrar</span>
                                </button>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="modal-body" style="padding-bottom: 10px !important">
                    <div class="row">
                        <div class="col-md-12" style="padding-bottom: 10px;">
                            <label for="TIPAUS_id" class="col-md-5 control-label">Tipo de Ausencia
                            <span style="color: #FF0000"><strong>*</strong></span></label>
                            <div class="col-md-7">
                                <input type="hidden" name="AUS_id" id="AUS_id" value="" class="form-control input-sm"/>
                                <select name="TIPAUS_id" id="TIPAUS_id" class="form-control input-sm js-example-basic-single" >
                                    <option value="" selected>Tipo de Ausencia</option>
                                <?php foreach($this->objTipoAusencia as $lista){ ?>
                                    <option value="<?php echo $lista["TIPAUS_id"];?>"><?php echo utf8_encode($lista["TIPAUS_descripcion"]);?></option>
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
                            <label for="AUS_fchini" class="col-md-5 control-label">Fch. de Inicio
                            <span style="color: #FF0000"><strong>*</strong></span></label>
                            <div class="col-md-7">
                                <div class='input-group date datetimepicker1' id="AUS_fchiniDate">
                                    <input type="text" name="AUS_fchini" id="AUS_fchini" class="form-control input-sm" style="text-transform: uppercase; width: 100% !important;" />
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12" style="padding-bottom: 10px;">
                            <label for="AUS_fchfin" class="col-md-5 control-label">Fch. de Fin
                            <span style="color: #FF0000"><strong>*</strong></span></label>
                            <div class="col-md-7">
                                <div class='input-group date datetimepicker1' id="AUS_fchfinDate">
                                    <input type="text" name="AUS_fchfin" id="AUS_fchfin" class="form-control input-sm" style="text-transform: uppercase; width: 100% !important;" disabled="disabled" />
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12" style="padding-bottom: 10px;">
                            <label for="AUS_estado" class="col-md-5 control-label">Estado:
                            <span style="color: #FF0000"><strong>*</strong></span></label>
                            <div class="col-md-7">
                               <select name="AUS_estado" id="AUS_estado" class="form-control input-sm js-example-basic-single" >
                                   <option value="1" selected>Activo</option>
                                   <option value="0">Inactivo</option>
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
                               <input type="text" name="AUD_fch_cre" id="AUD_fch_cre" class="form-control input-sm" style="text-transform: uppercase; width: 100% !important;" />
                            </div>
                        </div>
                        <div class="col-md-12" style="padding-bottom: 10px !important; display:none;" id="divAUD_usu_mod">
                            <label for="AUD_usu_mod" class="col-md-5 control-label">Usuario de Mod.:
                            <span style="color: #FF0000"><strong>*</strong></span></label>
                            <div class="col-md-6">
                               <input type="text" name="AUD_usu_mod" id="AUD_usu_mod" class="form-control input-sm" style="text-transform: uppercase; width: 100% !important;" />
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
                    <button name='insertAusencia' id='insertAusencia' type="button" class="btn btn-sm" onclick="flagEstadoModulo('<?php echo URLLOGICA?>ausencia/insertAusencia/','listar','ausencia');">Grabar</button> <!-- insertAusencia('<?php //echo URLLOGICA?>ausencia/insertAusencia/'); -->
                    <button name='updateAusencia' id='updateAusencia' type="button" class="btn btn-sm" onclick="flagEstadoModulo('<?php echo URLLOGICA?>ausencia/updateAusencia/','modificar','ausencia')">Modificar</button> <!-- updateAusencia('<?php //echo URLLOGICA?>ausencia/updateAusencia/'); -->
                    <button name="closeAusencia" id="closeAusencia" type="button" class="btn btn-danger btn-sm" data-dismiss="modal" onclick="limpiarFormAusencia();">Cerrar</button>
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
    </script>
    <!-- /.content-wrapper -->
    <?php include "footer_view.php";?>
