<?php include "header_view.php";?>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
				Aviones (datos) <small></small>
            </h1>
            <ol class="breadcrumb">
                <li><i class="fa fa-thumb-tack"></i> Avión</li>
                <li class="active">
                    Listado de Aviones
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
                        <div class="row-fluid">
                            <form method="post" action="<?php echo URLLOGICA?>avion/buscarAvion/" onsubmit="document.forms['buscar']['buscar'].disabled=true;" name="buscar">
                                <div class="form-group">
                                    <label for="bTIPAVI_id" class="col-md-2 control-label">Tipo de Avión</label>
                                    <div class="col-md-2">
                                        <select name="bTIPAVI_id" id="bTIPAVI_id" class="form-control input-sm js-example-basic-single" >
                                            <option value="" selected>Seleccionar Tipo de Avión</option>
                                        <?php foreach($this->objTipoAvion as $lista){ ?>
                                            <?php $selected = "";?>
                                            <?php if(isset($_SESSION["TIPAVI_id"])) { ?>
                                                <?php if($_SESSION["TIPAVI_id"] == $lista["TIPAVI_id"]) { ?>
                                                    <?php $selected = "selected";?>
                                                <?php } ?>
                                            <?php } ?>
                                            <option value="<?php echo $lista["TIPAVI_id"];?>" <?php echo $selected;?>><?php echo ($lista["TIPAVI_modelo"]."-".$lista["TIPAVI_serie"]);?></option>
                                        <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="bAVI_num_cola" class="col-md-2 control-label">N° de Cola</label>
                                    <div class="col-md-2">
                                        <input type="text" name="bAVI_num_cola" id="bAVI_num_cola" value="<?php if(isset($_SESSION["AVI_num_cola"])) { echo $_SESSION["AVI_num_cola"]; } else { echo ""; }?>" class="form-control input-sm" style="text-transform: uppercase;" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-2">
                                        <input type="submit" name="buscar" value="Buscar" class="btn btn-danger btn-block" />
                                    </div>
                                </div>
                            </form>
                                <div class="form-group">
                                    <div class="col-md-2">
                                        <button type="button" name="limpiar" class="btn btn-danger btn-block" onclick="resetFormAvion('<?php echo URLLOGICA?>avion/listarAvion/');"> Limpiar </button>
                                    </div>
                                </div>
                        </div>
                        <div class="clearfix" style="padding: 4px;"></div>
                    </div>
                    <div id="MainContent_listaPro" class="panel panel-default">
                        <div class="panel-heading clearfix" style="padding: 5px !important">
                            <span id="MainContent_tituloPro"><strong>Lista de Aviones</strong></span>
                            <?php  $Bdisabled = 0; ?>
                            <?php foreach ($this->objBotton as $botton) { ?>
                                <?php if($botton["Funcion"] == "insertAvion"){ ?>
                                    <?php  $Bdisabled += 1; ?>
                                <?php } ?>
                            <?php } ?>
                            <?php if($Bdisabled > 0){ $disabled = ""; } else { $disabled = "disabled"; } ?>
                                <button type="button" class="pull-right fa fa-plane" data-toggle="modal" data-target="#avionRegistro" <?php echo $disabled;?>></button>
                        </div>
                        <div class="area_resultado table-responsive">
                            <table id="listaAvion" class="display myDataTables" cellspacing="0" cellpadding="2">
                                <thead>
                                    <tr>
                                        <th scope="col">Item</th>
                                        <th scope="col">Tipo de Avión</th>
                                        <th scope="col">N° de Cola</th>
                                        <th scope="col">N° de Pasajeros</th>
                                        <th scope="col">Cap. Max. Carga</th>
                                        <th scope="col">Estado</th>
                                        <th scope="col">Fch. Registro</th>
                                        <th scope="col">Ver</th>
                                        <th scope="col">Editar</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (count($this->objAvion) > 0) { ?>
                                        <?php $item = 1; ?>
                                        <?php foreach ($this->objAvion as $lista) { ?>
                                    <tr>
                                        <td style="width:auto;"><?php echo $item;?></td>
                                        <td style="width:auto;"><?php echo $lista["TIPAVI_modelo"]."-".$lista["TIPAVI_serie"];?></td>
                                        <td style="width:auto;"><?php echo utf8_encode($lista["AVI_num_cola"]);?></td>
                                        <td style="width:auto;"><?php echo utf8_encode($lista["AVI_cant_pasajeros"]);?></td>
                                        <td style="width:auto;"><?php echo utf8_encode($lista["AVI_cap_carga_max"]);?></td>
                                        <td style="width:auto;"><?php if ($lista["AVI_estado"] == 1) { echo Activo; } elseif ($lista["AVI_estado"] == 0) { echo Inactivo; } ?></td>
                                        <td style="width:auto;"><?php echo $lista["AUD_fch_cre"];?></td>
                                        <td style="width:auto;">
                                            <?php  $Bdisabled = 0; ?>
                                            <?php foreach ($this->objBotton as $botton) { ?>
                                                <?php if($botton["Funcion"] == "listarAvion"){ ?>
                                                    <?php  $Bdisabled += 1; ?>
                                                <?php } ?>
                                            <?php } ?>
                                            <?php if($Bdisabled > 0){ $disabled = ""; } else { $disabled = "disabled"; } ?>
                                                <button type="button" class="fa fa-eye" data-toggle="modal" data-target="#avionRegistro" onclick="listarDetAvion('<?php echo URLLOGICA?>avion/listarDetAvion/',<?php echo $lista["AVI_id"];?>,'listar')" <?php echo $disabled;?>></button>
                                        </td>
                                        <td style="width:auto;">
                                            <?php  $Bdisabled = 0; ?>
                                            <?php foreach ($this->objBotton as $botton) { ?>
                                                <?php if($botton["Funcion"] == "updateAvion"){ ?>
                                                    <?php  $Bdisabled += 1; ?>
                                                <?php } ?>
                                            <?php } ?>
                                            <?php if($Bdisabled > 0){ $disabled = ""; } else { $disabled = "disabled"; } ?>
                                                <button type="button" class="fa fa-pencil" data-toggle="modal" data-target="#avionRegistro" onclick="listarDetAvion('<?php echo URLLOGICA?>avion/listarDetAvion/',<?php echo $lista["AVI_id"];?>,'modificar')" <?php echo $disabled;?>></button>
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
    <div id="avionRegistro" class="modal fade" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content ">
                <div class="modal-header" style="padding: 10px !important">
                    <table class="col-xs-12">
                        <tr>
                            <td style="text-align:left;">
                                <h4><strong id="titleForm">Ingresar Nuevo Avión</strong></h4>
                            </td>
                            <td>
                                <button type="button" class="close btn-lg" data-dismiss="modal" onclick="limpiarFormAvion();" style="background-color: red; color:white; margin:10px; padding: 0px 6px 2px 6px;text-align:right;">
                                    <span aria-hidden="true">&times;</span><span class="sr-only">Cerrar</span>
                                </button>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="modal-body" style="padding-bottom: 10px;">
                    <div class="row">
                        <div class="col-md-12" style="padding-bottom: 10px;">
                            <label for="AVI_num_cola" class="col-md-5 control-label">N° de Cola:
                            <span style="color: #FF0000"><strong>*</strong></span></label>
                            <div class="col-md-7">
                                <input type="hidden" name="AVI_id" id="AVI_id" value="" class="form-control input-sm"/>
                                <input type="text" name="AVI_num_cola" id="AVI_num_cola" class="form-control input-sm" style="text-transform: uppercase; width: 100% !important;" autofocus/>
                            </div>
                        </div>
                        <div class="col-md-12" style="padding-bottom: 10px;">
                            <label for="TIPAVI_id" class="col-md-5 control-label">Tipo de Avión:
                            <span style="color: #FF0000"><strong>*</strong></span></label>
                            <div class="col-md-7">
                                <select name="TIPAVI_id" id="TIPAVI_id" class="form-control input-sm js-example-basic-single" >
                                    <option value="" selected>Tipo Avión</option>
                                <?php foreach($this->objTipoAvion as $lista){ ?>
                                    <option value="<?php echo $lista["TIPAVI_id"];?>"><?php echo ($lista["TIPAVI_modelo"]."-".$lista["TIPAVI_serie"]);?></option>
                                <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12" style="padding-bottom: 10px;">
                            <label for="AVI_cant_pasajeros" class="col-md-5 control-label">N° de Pasajeros:
                            <span style="color: #FF0000"><strong>*</strong></span></label>
                            <div class="col-md-7">
                                <input type="text" name="AVI_cant_pasajeros" id="AVI_cant_pasajeros" class="form-control input-sm numberEntero" style="text-transform: uppercase; width: 100% !important;" />
                            </div>
                        </div>
                        <div class="col-md-12" style="padding-bottom: 10px;">
                            <label for="label_modelD_nombre" class="col-md-5 control-label">Cap. Max. de Carga (Kg): </label>
                            <div class="col-md-7">
                                <input type="text" name="AVI_cap_carga_max" id="AVI_cap_carga_max" value="0" class="form-control input-sm numberDecimal" style="text-transform: uppercase; width: 100% !important;" />
                            </div>
                        </div>
                        <div class="col-md-12" style="padding-bottom: 10px;">
                            <label for="AVI_estado" class="col-md-5 control-label">Estado:
                            <span style="color: #FF0000"><strong>*</strong></span></label>
                            <div class="col-md-7">
                               <select name="AVI_estado" id="AVI_estado" class="form-control input-sm js-example-basic-single">
                                   <option value="1" selected>Activo</option>
                                   <option value="0">Inactivo</option>
                               </select>
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
                    <button name='insertAvion' id='insertAvion' type="button" class="btn btn-sm" onclick="insertAvion('<?php echo URLLOGICA?>avion/insertAvion/');">Grabar</button>
                    <button name='updateAvion' id='updateAvion' type="button" class="btn btn-sm" onclick="updateAvion('<?php echo URLLOGICA?>avion/updateAvion/');">Modificar</button>
                    <button name="closeAvion" id="closeAvion" type="button" class="btn btn-danger btn-sm" data-dismiss="modal" onclick="limpiarFormAvion();">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Fin Modal-->
    <!-- /.content-wrapper -->
<?php include "footer_view.php";?>