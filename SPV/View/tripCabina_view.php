<?php include "header_view.php";?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
				Tripulantes de cabina <small></small>
            </h1>
            <ol class="breadcrumb">
                <li><i class="fa fa-thumb-tack"></i> Trip. Cabina</li>
                <li class="active">
                    Listado de Trip. de Cabina
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
                        <form method="post" action="<?php echo URLLOGICA?>tripulante/buscarTripulante/Cabina/" onsubmit="document.forms['buscar']['buscar'].disabled=true;" name="buscar">
                            <div class="row-fluid">
                                <div class="form-group">
                                    <label for="bTIPLIC_id" class="col-md-2 control-label">Tipo de Licencia</label>
                                    <div class="col-md-2">
                                        <select name="bTIPLIC_id" id="bTIPLIC_id" class="form-control input-sm js-example-basic-single" >
                                            <option value="" selected>Tipo de Licencia</option>
                                        <?php foreach($this->objTipoLicencia as $lista){ ?>
                                            <?php $selected = "";?>
                                            <?php if(isset($_SESSION["TIPLIC_id"])) { ?>
                                                <?php if($_SESSION["TIPLIC_id"] == $lista["TIPLIC_id"]) { ?>
                                                    <?php $selected = "selected";?>
                                                <?php } ?>
                                            <?php } ?>
                                            <option value="<?php echo $lista["TIPLIC_id"];?>" <?php echo $selected;?>><?php echo ($lista["TIPLIC_abreviatura"]."-".utf8_encode($lista["TIPLIC_descripcion"]));?></option>
                                        <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="bTRIP_numlicencia" class="col-md-2 control-label">N° de Licencia</label>
                                    <div class="col-md-2">
                                        <input type="text" name="bTRIP_numlicencia" id="bTRIP_numlicencia" value="<?php if(isset($_SESSION["TRIP_numlicencia"])) { echo $_SESSION["TRIP_numlicencia"]; } else { echo ""; }?>" class="form-control input-sm" style="text-transform: uppercase;" />
                                    </div>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="row-fluid">
                                <div class="form-group">
                                    <label for="bTRIP_apellido" class="col-md-2 control-label">Apellido</label>
                                    <div class="col-md-2">
                                        <input type="text" name="bTRIP_apellido" id="bTRIP_apellido" value="<?php if(isset($_SESSION["TRIP_numlicencia"])) { echo $_SESSION["TRIP_apellido"]; } else { echo ""; }?>" class="form-control input-sm" style="text-transform: uppercase;" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="bTIPTRIPDET_id" class="col-md-2 control-label">Tipo de Trip. de Cabina</label>
                                    <div class="col-md-2">
                                        <select name="bTIPTRIPDET_id" id="bTIPTRIPDET_id" class="form-control input-sm js-example-basic-single" >
                                            <option value="" selected>Tipo de Trip. Cabina</option>
                                        <?php foreach($this->objTipoTripulante as $lista){ ?>
                                            <?php $selected = "";?>
                                            <?php if(isset($_SESSION["TIPTRIPDET_id"])) { ?>
                                                <?php if($_SESSION["TIPTRIPDET_id"] == $lista["TIPTRIPDET_id"]) { ?>
                                                    <?php $selected = "selected";?>
                                                <?php } ?>
                                            <?php } ?>
                                            <option value="<?php echo $lista["TIPTRIPDET_id"];?>" <?php echo $selected;?>><?php echo ($lista["TIPTRIPDET_descripcion"]);?></option>
                                        <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-2">
                                        <input type="submit" name="buscar" value="Buscar" class="btn btn-danger btn-block" />
                                    </div>
                                </div>
                            </div>
                        </form>
                            <div class="form-group">
                                <div class="col-md-2">
                                    <button type="button" name="limpiar" class="btn btn-danger btn-block" onclick="resetFormTripCabina('<?php echo URLLOGICA?>tripulante/listarTripulante/Cabina/');"> Limpiar </button>
                                </div>
                            </div>
                            <div class="clearfix" style="padding: 5px;"></div>
                    </div>
                    <div id="MainContent_listaPro" class="panel panel-default">
                        <div class="panel-heading clearfix" style="padding: 4px !important">
                            <span id="MainContent_tituloPro"><strong>Lista de Tripulantes de Cabina</strong></span>
                            <?php  $Bdisabled = 0; ?>
                            <?php foreach ($this->objBotton as $botton) { ?>
                                <?php if($botton["Funcion"] == "insertTripCabina"){ ?>
                                    <?php  $Bdisabled += 1; ?>
                                <?php } ?>
                            <?php } ?>
                            <?php if($Bdisabled > 0){ $disabled = ""; } else { $disabled = "disabled"; } ?>
                                <button type="button" class="pull-right fa fa-user-plus" data-toggle="modal" data-target="#TripCabinaRegistro" <?php echo $disabled;?>></button>
                        </div>
                        <div class="area_resultado table-responsive">
                            <table id="listaTripCabina" class="display myDataTables" cellspacing="0" cellpadding="2">
                                <thead>
                                    <tr>
                                        <th scope="col">Item</th>
                                        <th scope="col">Nombre y Apellidos</th>
                                        <th scope="col">Tipo de Trip. Cabina</th>
                                        <th scope="col">Tipo de Licencia</th>
                                        <th scope="col">N° de Licencia</th>
                                        <th scope="col">Estado</th>
                                        <th scope="col">Fch. Registro</th>
                                        <th scope="col">Ver</th>
                                        <th scope="col">Editar</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (count($this->objTripulante) > 0) { ?>
                                        <?php $item = 1; ?>
                                        <?php foreach ($this->objTripulante as $lista) { ?>
                                    <tr>
                                        <td style="width:auto;"><?php echo $item;?></td>
                                        <td style="width:auto;"><?php echo utf8_encode($lista["TRIP_nombre"]." ".$lista["TRIP_apellido"]);?></td>
                                        <td style="width:auto;"><?php echo utf8_encode($lista["TIPTRIPDET_descripcion"]);?></td>
                                        <td style="width:auto;"><?php echo utf8_encode($lista["TIPLIC_descripcion"]);?></td>
                                        <td style="width:auto;"><?php echo utf8_encode($lista["TRIP_numlicencia"]);?></td>
                                        <td style="width:auto;"><?php if ($lista["TRIP_estado"] == 1) { echo Activo; } elseif ($lista["TRIP_estado"] == 0) { echo Inactivo; } ?></td>
                                        <td style="width:auto;"><?php echo utf8_encode($lista["AUD_fch_cre"]);?></td>
                                        <td style="width:auto;">
                                            <?php  $Bdisabled = 0; ?>
                                            <?php foreach ($this->objBotton as $botton) { ?>
                                                <?php if($botton["Funcion"] == "listarTripCabina"){ ?>
                                                    <?php  $Bdisabled += 1; ?>
                                                <?php } ?>
                                            <?php } ?>
                                            <?php if($Bdisabled > 0){ $disabled = ""; } else { $disabled = "disabled"; } ?>
                                                <button type="button" class="fa fa-eye" data-toggle="modal"  data-target="#TripCabinaRegistro" onclick="listarDetTripCabina('<?php echo URLLOGICA?>tripulante/listarDetTrip/',<?php echo utf8_encode($lista["TRIP_id"]);?>,'listar')" <?php echo $disabled;?>></button>
                                        </td>
                                        <td style="width:auto;">
                                            <?php  $Bdisabled = 0; ?>
                                            <?php foreach ($this->objBotton as $botton) { ?>
                                                <?php if($botton["Funcion"] == "updateTripCabina"){ ?>
                                                    <?php  $Bdisabled += 1; ?>
                                                <?php } ?>
                                            <?php } ?>
                                            <?php if($Bdisabled > 0){ $disabled = ""; } else { $disabled = "disabled"; } ?>
                                                <button type="button" class="fa fa-pencil" data-toggle="modal" data-target="#TripCabinaRegistro" onclick="listarDetTripCabina('<?php echo URLLOGICA?>tripulante/listarDetTrip/',<?php echo utf8_encode($lista["TRIP_id"]);?>,'modificar')" <?php echo $disabled;?>></button>
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
    <div id="TripCabinaRegistro" class="modal fade" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header" style="padding: 10px !important">
                    <table class="col-xs-12">
                        <tr>
                            <td style="text-align:left;">
                                <h4><strong id="titleForm">Ingresar Nuevo Trip. de Cabina</strong></h4>
                            </td>
                            <td>
                                <button type="button" class="close btn-lg" data-dismiss="modal" onclick="limpiarFormTripulante('Cabina');" style="background-color: red; color:white; margin:10px; padding: 0px 6px 2px 6px;text-align:right;">
                                    <span aria-hidden="true">&times;</span><span class="sr-only">Cerrar</span>
                                </button>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="modal-body" style="padding-bottom: 10px !important">
                    <div class="row">
                        <div class="col-md-12" style="padding-bottom: 10px;">
                            <label for="TRIP_nombre" class="col-md-5 control-label">Nombres:
                            <span style="color: #FF0000"><strong>*</strong></span></label>
                            <div class="col-md-6">
                                <input type="hidden" name="TRIP_id" id="TRIP_id" value="" class="form-control input-sm"/>
                                <input type="text" name="TRIP_nombre" id="TRIP_nombre" class="form-control input-sm" style="text-transform: uppercase; width: 100% !important;" autofocus />
                            </div>
                        </div>
                        <div class="col-md-12" style="padding-bottom: 10px;">
                            <label for="TRIP_apellido" class="col-md-5 control-label">Apellidos:
                            <span style="color: #FF0000"><strong>*</strong></span></label>
                            <div class="col-md-6">
                                <input type="text" name="TRIP_apellido" id="TRIP_apellido" class="form-control input-sm" style="text-transform: uppercase; width: 100% !important;" />
                            </div>
                        </div>
                        <div class="col-md-12" style="padding-bottom: 10px;">
                            <label for="TRIP_correo" class="col-md-5 control-label">Correo:
                            <span style="color: #FF0000"><strong>*</strong></span></label>
                            <div class="col-md-6">
                                <input type="email" name="TRIP_correo" id="TRIP_correo" class="form-control input-sm" style="text-transform: uppercase; width: 100% !important;"/>
                            </div>
                        </div>
                        <div class="col-md-12" style="padding-bottom: 10px;">
                            <label for="TRIP_fechnac" class="col-md-5 control-label">Fecha Nac.:
                            <span style="color: #FF0000"><strong>*</strong></span></label>
                            <div class="col-md-6">
                                <div class='input-group date datetimepicker'>
                                    <input type="text" name="TRIP_fechnac" id="TRIP_fechnac" class="form-control input-sm" style="text-transform: uppercase; width: 100% !important;" />
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12" style="padding-bottom: 10px;">
                            <label for="idDepa" class="col-md-5 control-label">Departamento:
                            <span style="color: #FF0000"><strong>*</strong></span></label>
                            <div class="col-md-6">
                                <select name="idDepa" id="idDepa" class="form-control input-sm js-example-basic-single" >
                                    <option value="" selected>Seleccione Departamento</option>
                                <?php foreach($this->objTripDepa as $lista){ ?>
                                    <option value="<?php echo $lista["idDepa"];?>"><?php echo ($lista["departamento"]);?></option>
                                <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12" style="padding-bottom: 10px;">
                            <label for="idProv" class="col-md-5 control-label">Provincia:
                            <span style="color: #FF0000"><strong>*</strong></span></label>
                            <div class="col-md-6">
                                <select name="idProv" id="idProv" class="form-control input-sm js-example-basic-single" >
                                    <option value="" selected>Seleccione Provincia</option>
                                <?php foreach($this->objTripProv as $lista){ ?>
                                    <option class="<?php echo $lista["idDepa"];?>" value="<?php echo $lista["idProv"];?>"><?php echo ($lista["provincia"]);?></option>
                                <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12" style="padding-bottom: 10px;">
                            <label for="idDist" class="col-md-5 control-label">Distrito:
                            <span style="color: #FF0000"><strong>*</strong></span></label>
                            <div class="col-md-6">
                                <select name="idDist" id="idDist" class="form-control input-sm js-example-basic-single" >
                                    <option value="" selected>Seleccione Distrito</option>
                                <?php foreach($this->objTripDist as $lista){ ?>
                                    <option class="<?php echo $lista["idProv"];?>" value="<?php echo $lista["idDist"];?>"><?php echo ($lista["distrito"]);?></option>
                                <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12" style="padding-bottom: 10px;">
                            <label for="TRIP_domilicio" class="col-md-5 control-label">Domicilio:
                            <span style="color: #FF0000"><strong>*</strong></span></label>
                            <div class="col-md-6">
                                <input type="text" name="TRIP_domilicio" id="TRIP_domilicio" class="form-control input-sm" style="text-transform: uppercase; width: 100% !important;" />
                            </div>
                        </div>
                        <div class="col-md-12" style="padding-bottom: 10px;">
                            <label for="TIPTRIPDET_id" class="col-md-5 control-label">Tipo de Tripulante:
                            <span style="color: #FF0000"><strong>*</strong></span></label>
                            <div class="col-md-6">
                                <select name="TIPTRIPDET_id" id="TIPTRIPDET_id" class="form-control input-sm js-example-basic-single" >
                                    <option value="" selected>Seleccione Tipo de Trip. Cabina</option>
                                <?php foreach($this->objTipoTripulante as $lista){ ?>
                                    <option value="<?php echo $lista["TIPTRIPDET_id"];?>"><?php echo ($lista["TIPTRIPDET_descripcion"]);?></option>
                                <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12" style="padding-bottom: 10px;">
                            <label for="TRIP_instructor" class="col-md-5 control-label">¿Habilitado Para Jefe Cabina?:
                            <span style="color: #FF0000"><strong>*</strong></span></label>
                            <div class="col-xs-6 col-md-3">
                                <input type="radio" id="TRIP_instructor_Si" name="TRIP_instructor" value="Si"> Si
                            </div>
                            <div class="col-xs-6 col-md-3">
                                <input type="radio" id="TRIP_instructor_No" name="TRIP_instructor" value="No" checked> No
                            </div>
                        </div>
                        <div class="col-md-12" style="padding-bottom: 10px;">
                            <label for="TIPLIC_id" class="col-md-5 control-label">Tipo de Licencia:
                            <span style="color: #FF0000"><strong>*</strong></span></label>
                            <div class="col-md-6">
                                <select name="TIPLIC_id" id="TIPLIC_id" class="form-control input-sm js-example-basic-single" >
                                    <option value="" selected>Seleccione Tipo de Licencia</option>
                                <?php foreach($this->objTipoLicencia as $lista){ ?>
                                    <option value="<?php echo $lista["TIPLIC_id"];?>"><?php echo ($lista["TIPLIC_abreviatura"]."-".utf8_encode($lista["TIPLIC_descripcion"]));?></option>
                                <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12" style="padding-bottom: 10px;">
                            <label for="TRIP_numlicencia" class="col-md-5 control-label">N° de Licencia:
                            <span style="color: #FF0000"><strong>*</strong></span></label>
                            <div class="col-md-6">
                                <input type="text" name="TRIP_numlicencia" id="TRIP_numlicencia" class="form-control input-sm numberEntero" style="text-transform: uppercase; width: 100% !important;" />
                            </div>
                        </div>                        
                        <div class="col-md-12" style="padding-bottom: 10px;">
                            <label for="TRIP_DGAC" class="col-md-5 control-label">Código DGAC:
                            <span style="color: #FF0000"><strong>*</strong></span></label>
                            <div class="col-md-6">
                                <input type="text" name="TRIP_DGAC" id="TRIP_DGAC" maxlength="5" class="form-control input-sm numberEntero" style="text-transform: uppercase; width: 100% !important;" />
                            </div>
                        </div>
                        <div class="col-md-12" style="padding-bottom: 10px;">
                            <label for="NIVING_id" class="col-md-5 control-label">Niv. de Ingles:
                            <span style="color: #FF0000"><strong>*</strong></span></label>
                            <div class="col-md-6">
                                <select name="NIVING_id" id="NIVING_id" class="form-control input-sm js-example-basic-single" >
                                    <option value="" selected>Seleccione Nivel Ingles</option>
                                <?php foreach($this->objTripNivIngles as $lista){ ?>
                                    <option value="<?php echo $lista["NIVING_id"];?>"><?php echo ($lista["NIVING_descripcion"]);?></option>
                                <?php } ?>
                                </select>
                            </div>
                        </div>
                        <!--Para el caso de Trip. de Cabina no hay Categorización-->
                        <div class="col-md-12" style="padding-bottom: 10px;">
                            <label for="CAT_id" class="col-md-5 control-label">Categoría:
                            <span style="color: #FF0000"><strong>*</strong></span></label>
                            <div class="col-md-6">
                                <select name="CAT_id" id="CAT_id" class="form-control input-sm js-example-basic-single" >
                                    <option value="" selected>Seleccione Categoría</option>
                                <?php foreach($this->objTripCate as $lista){ ?>
                                    <option value="<?php echo $lista["CAT_id"];?>"><?php echo ($lista["CAT_descripcion"]);?></option>
                                <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12" style="padding-bottom: 10px;">
                            <label for="TRIP_estado" class="col-md-5 control-label">Estado:
                            <span style="color: #FF0000"><strong>*</strong></span></label>
                            <div class="col-md-6">
                               <select name="TRIP_estado" id="TRIP_estado" class="form-control input-sm js-example-basic-single">
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
                    <button name='insertTripulante' id='insertTripulante' type="button" class="btn btn-sm" onclick="insertTripCabina('<?php echo URLLOGICA?>tripulante/insertTripulante/');">Grabar</button>
                    <button name='updateTripulante' id='updateTripulante' type="button" class="btn btn-sm" onclick="updateTripCabina('<?php echo URLLOGICA?>tripulante/updateTripulante/');">Modificar</button>
                    <button name="closeTripulante" id="closeTripulante" type="button" class="btn btn-danger btn-sm" data-dismiss="modal" onclick="limpiarFormTrpiCabina();">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Fin Modal-->
    
    <script type="text/javascript">
        $(function () {
            $("#idProv").chained("#idDepa");
            $("#idDist").chained("#idProv");
        });
        
        function listarComboProvinciaView(){
            listarComboProvincia('<?php echo URLLOGICA?>detalle/listarProvincia/');
        }
        function listarComboDistritoView(){
            listarComboDistrito('<?php echo URLLOGICA?>detalle/listarDistrito/');
        }
    </script>
    <!-- /.content-wrapper -->
    <?php include "footer_view.php";?>
