<?php include "header_view.php";?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
				Cursos <small></small>
            </h1>
            <ol class="breadcrumb">
                <li><i class="fa fa-thumb-tack"></i> Cursos</li>
                <li class="active">
                    Listado de Cursos
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
                        <form method="post" action="<?php echo URLLOGICA?>curso/buscarCurso/" onsubmit="document.forms['buscar']['buscar'].disabled=true;" name="buscar">
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
                                    <label for="bPART_indicador" class="col-md-2 control-label">Cumplimiento</label>
                                    <div class="col-md-2">
                                        <select name="bPART_indicador" id="bPART_indicador" class="form-control input-sm js-example-basic-single" >
                                            <option value="" selected>Seleccionar Cumplimiento</option>
                                            <?php $selected_APROBADO = '' ?>
                                            <?php $selected_DESAPROBADO = '' ?>
                                            <?php $selected_OBSERVADO = '' ?>
                                            <?php $selected_PENDIENTE = '' ?>
                                            <?php if(isset($_SESSION["PART_indicador"])) { ?>
                                                    <?php if($_SESSION["PART_indicador"] == 'APROBADO') { ?>
                                                        <?php $selected_APROBADO = 'selected' ?>
                                                        <?php $selected_DESAPROBADO = '' ?>
                                                        <?php $selected_OBSERVADO = '' ?>
                                                        <?php $selected_PENDIENTE = '' ?>
                                                    <?php } else if($_SESSION["PART_indicador"] == 'DESAPROBADO') { ?>
                                                        <?php $selected_APROBADO = '' ?>
                                                        <?php $selected_DESAPROBADO = 'selected' ?>
                                                        <?php $selected_OBSERVADO = '' ?>
                                                        <?php $selected_PENDIENTE = '' ?>
                                                    <?php } else if($_SESSION["PART_indicador"] == 'OBSERVADO') { ?>
                                                        <?php $selected_APROBADO = '' ?>
                                                        <?php $selected_DESAPROBADO = '' ?>
                                                        <?php $selected_OBSERVADO = 'selected' ?>
                                                        <?php $selected_PENDIENTE = '' ?>
                                                    <?php } else if($_SESSION["PART_indicador"] == 'PENDIENTE') { ?>
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
                                    <label for="bTIPCUR_id" class="col-md-2 control-label">Tipo de Curso</label>
                                    <div class="col-md-2">
                                        <select name="bTIPCUR_id" id="bTIPCUR_id" class="form-control input-sm js-example-basic-single" >
                                            <option value="" selected>Tipo de Curso</option>
                                        <?php foreach($this->objTipoCurso as $lista){ ?>
                                            <?php $selected = "";?>
                                            <?php if(isset($_SESSION["TIPCUR_id"])) { ?>
                                                <?php if($_SESSION["TIPCUR_id"] == $lista["TIPCUR_id"]) { ?>
                                                    <?php $selected = "selected";?>
                                                <?php } ?>
                                            <?php } ?>
                                            <option value="<?php echo $lista["TIPCUR_id"];?>" <?php echo $selected;?>><?php echo utf8_encode(($lista["TIPCUR_descripcion"]));?></option>
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
                                <button type="button" name="limpiar" class="btn btn-danger btn-block" onclick="resetFormCurso('<?php echo URLLOGICA?>curso/listarResumenCurso/');"> Limpiar </button>
                            </div>
                        <div class="clearfix" style="padding: 4px;"></div>
                    </div>
                    <div id="MainContent_listaPro" class="panel panel-default">
                        <div class="panel-heading clearfix" style="padding: 5px !important">
                            <span id="MainContent_tituloPro"><strong>Lista de Cursos</strong></span>
                            <?php  $Bdisabled = 0; ?>
                            <?php foreach ($this->objBotton as $botton) { ?>
                                <?php if($botton["Funcion"] == "insertCurso"){ ?>
                                    <?php  $Bdisabled += 1; ?>
                                <?php } ?>
                            <?php } ?>
                            <?php if($Bdisabled > 0){ $disabled = ""; } else { $disabled = "disabled"; } ?>
                                <button type="button" class="pull-right fa fa-book" data-toggle="modal" data-target="#cursoRegistro" <?php echo $disabled;?>></button>
                        </div>
                        <div class="area_resultado table-responsive">
                            <table id="listaCurso" class="display myDataTables" cellspacing="0" cellpadding="2">
                                <thead>
                                    <tr>
                                        <th scope="col">Item</th>
                                        <th scope="col">Tipo Curso</th>
                                        <th scope="col">Tipo Trip.</th>
                                        <th scope="col">Cant. de Trip.</th>
                                        <th scope="col">Cumplimiento</th>
                                        <th scope="col">Ver</th>
                                        <th scope="col">Editar</th>
                                        <th scope="col">Correo Info.</th>
                                        <th scope="col">Correo Curso</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (count($this->objResumenCurso) > 0) { ?>
                                        <?php $item = 1; ?>
                                        <?php foreach ($this->objResumenCursoMatriz as $lista) { ?>
                                        <?php $PART_indicador = 'APROBADO'; ?>
                                            <?php foreach ($this->objResumenCurso as $listaII) { ?>
                                                <?php if ($lista["TIPCUR_id"] == $listaII["TIPCUR_id"] and $lista["CUR_id"] == $listaII["CUR_id"]) { ?>
                                                    <?php if($listaII["PART_indicador"] == 'DESAPROBADO'){ ?>
                                                        <?php $PART_indicador = 'DESAPROBADO';?>
                                                    <?php } else if($listaII["PART_indicador"] == 'OBSERVADO') { ?>
                                                        <?php $PART_indicador = 'OBSERVADO';?>
                                                    <?php } else if($listaII["PART_indicador"] == 'PENDIENTE') { ?>
                                                        <?php $PART_indicador = 'PENDIENTE';?>
                                                    <?php } ?>
                                                <?php } ?>
                                            <?php } ?>
                                    <tr>
                                        <td style="width:auto;"><?php echo $item;?></td>
                                        <td style="width:auto;"><?php echo $lista["TIPCUR_descripcion"];?></td>
                                        <td style="width:auto;"><?php echo utf8_encode($lista["TIPTRIP_descripcion"]);?></td>
                                        <td style="width:auto;"><?php echo $lista["CUR_Afectados"];?></td>
                                        <td style="width:auto;"><?php echo $PART_indicador;?></td>
                                        <td style="width:auto;">
                                            <?php  $Bdisabled = 0; ?>
                                            <?php foreach ($this->objBotton as $botton) { ?>
                                                <?php if($botton["Funcion"] == "listarCurso"){ ?>
                                                    <?php  $Bdisabled += 1; ?>
                                                <?php } ?>
                                            <?php } ?>
                                            <?php if($Bdisabled > 0){ $disabled = ""; } else { $disabled = "disabled"; } ?>
                                                <button type="button" class="fa fa-eye" data-toggle="modal" data-target="#cursoDetalle" onclick="listarCurso('<?php echo URLLOGICA?>curso/listarCurso/',<?php echo utf8_encode($lista["CUR_id"]);?>,'listar')" <?php echo $disabled;?>></button>
                                        </td>
                                        <td style="width:auto;">
                                            <?php  $Bdisabled = 0; ?>
                                            <?php foreach ($this->objBotton as $botton) { ?>
                                                <?php if($botton["Funcion"] == "updateCurso"){ ?>
                                                    <?php  $Bdisabled += 1; ?>
                                                <?php } ?>
                                            <?php } ?>
                                            <?php if($Bdisabled > 0){ $disabled = ""; } else { $disabled = "disabled"; } ?>
                                                <button type="button" class="fa fa-pencil" data-toggle="modal" data-target="#cursoDetalle" onclick="listarCurso('<?php echo URLLOGICA?>curso/listarCurso/',<?php echo utf8_encode($lista["CUR_id"]);?>,'modificar')" <?php echo $disabled;?>></button>
                                        </td>
                                        <td style="width:auto;">
                                            <?php  $Bdisabled = 0; ?>
                                            <?php foreach ($this->objBotton as $botton) { ?>
                                                <?php if($botton["Funcion"] == "insertCurso"){ ?>
                                                    <?php  $Bdisabled += 1; ?>
                                                <?php } ?>
                                            <?php } ?>
                                            <?php if($Bdisabled > 0){ $disabled = ""; } else { $disabled = "disabled"; } ?>
                                                <button type="button" class="fa fa-envelope" onclick="enviarCorreoCurso(<?php echo utf8_encode($lista["CUR_id"]);?>)" <?php echo $disabled;?>></button>
                                        </td>
                                        <td style="width:auto;">
                                            <?php  $Bdisabled = 0; ?>
                                            <?php foreach ($this->objBotton as $botton) { ?>
                                                <?php if($botton["Funcion"] == "insertCurso"){ ?>
                                                    <?php  $Bdisabled += 1; ?>
                                                <?php } ?>
                                            <?php } ?>
                                            <?php if($Bdisabled > 0){ $disabled = ""; } else { $disabled = "disabled"; } ?>
                                                <button type="button" class="fa fa-users" onclick="enviarCorreoCursoParticipante(<?php echo utf8_encode($lista["CUR_id"]);?>)" <?php echo $disabled;?>></button>
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
    <div id="cursoRegistro" class="modal fade" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header" style="padding: 10px !important">
                    <table class="col-xs-12">
                        <tr>
                            <td style="text-align:left;">
                                <h4><strong id="titleForm">Ingresar Nuevo Curso</strong></h4>
                            </td>
                            <td>
                                <button type="button" class="close btn-lg" data-dismiss="modal" onclick="limpiarFormCurso();" style="background-color: red; color:white; margin:10px; padding: 0px 6px 2px 6px;text-align:right;">
                                    <span aria-hidden="true">&times;</span><span class="sr-only">Cerrar</span>
                                </button>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="modal-body" style="padding-bottom: 10px;">
                    <div class="row">
                        <div class="col-md-12" style="padding-bottom: 10px;">
                            <label for="TIPCUR_id" class="col-md-5 control-label">Tipo de Curso
                            <span style="color: #FF0000"><strong>*</strong></span></label>
                            <div class="col-md-7">
                                <input type="hidden" name="CUR_id" id="CUR_id" value="" class="form-control input-sm"/>
                                <select name="TIPCUR_id" id="TIPCUR_id" class="form-control input-sm js-example-basic-single" >
                                    <option value="" selected>Tipo de Curso</option>
                                <?php foreach($this->objTipoCurso as $lista){ ?>
                                    <option value="<?php echo $lista["TIPCUR_id"];?>"><?php echo utf8_encode(($lista["TIPCUR_descripcion"]));?></option>
                                <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12" style="padding-bottom: 10px;">
                            <label for="CUR_fchini" class="col-md-5 control-label">Fecha Inicio
                            <span style="color: #FF0000"><strong>*</strong></span></label>
                            <div class="col-md-7">
                                <div class='input-group date datetimepicker1' id="CUR_fchiniDate">
                                    <input type="text" name="CUR_fchini" id="CUR_fchini" class="form-control input-sm" style="text-transform: uppercase; width: 100% !important;"/>
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12" style="padding-bottom: 10px;">
                            <label for="CUR_fchfin" class="col-md-5 control-label">Fecha Fin
                            <span style="color: #FF0000"><strong>*</strong></span></label>
                            <div class="col-md-7">
                                <div class='input-group date datetimepicker1' id="CUR_fchfinDate">
                                    <input type="text" name="CUR_fchfin" id="CUR_fchfin" class="form-control input-sm" style="text-transform: uppercase; width: 100% !important;" disabled="disabled" />
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12" style="padding-bottom: 10px;">
                            <label for="CUR_estado" class="col-md-5 control-label">Estado:
                            <span style="color: #FF0000"><strong>*</strong></span></label>
                            <div class="col-md-7">
                               <select name="CUR_estado" id="CUR_estado" class="form-control input-sm js-example-basic-single">
                                   <option value="1" selected>Activo</option>
                                   <option value="0">Inactivo</option>
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
                            <label for="TRIP_id_i" class="col-md-5 control-label">Tripulante Instructor
                            <span style="color: #FF0000"><strong>*</strong></span></label>
                            <div class="col-md-7">
                                <select name="TRIP_id_i" id="TRIP_id_i" class="form-control input-sm js-example-basic-single" >
                                    <option value="" selected>Tripulante Instructor</option>
                                <?php foreach($this->objTripulanteInstructor as $lista){ ?>
                                    <option class="<?php echo $lista["TIPTRIP_id"];?>" value="<?php echo $lista["TRIP_id"];?>"><?php echo utf8_encode($lista["TRIP_nombre"]." ".$lista["TRIP_apellido"]);?></option>
                                <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12" style="padding-bottom: 10px;">
                            <label for="TRIP_id_a" class="col-md-5 control-label">Tripulante Alumno
                            <span style="color: #FF0000"><strong>*</strong></span></label>
                            <div class="col-md-7" id="divAlum">
                                <div class="col-xs-8 col-md-8" style="padding: 0px">
                                    <select name="TRIP_id_a1" id="TRIP_id_a1" class="form-control input-sm js-example-basic-single" >
                                        <option value="" selected>Seleccionar Tripulante</option>
                                    <?php foreach($this->objTripulante as $lista){ ?>
                                        <option class="<?php echo $lista["TIPTRIP_id"];?>" value="<?php echo $lista["TRIP_id"];?>"><?php echo utf8_encode($lista["TRIP_nombre"]." ".$lista["TRIP_apellido"]);?></option>
                                    <?php } ?>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <span class="input-group-btn">
                                        <input name="num-alum" id="num-alum" value="1" type="hidden">
                                        <button class="btn btn-default input-group-abdon" type="button" onclick="agregar_alumno()" style="color:green">
                                            <span class="glyphicon glyphicon-plus"></span>
                                        </button>
                                        <button class="btn btn-default input-group-abdon" type="button" onclick="quitar_alumno()" style="color:red">
                                            <span class="glyphicon glyphicon-minus"></span>
                                        </button>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer" style="padding: 10px !important">
                    <button name='insertCurso' id='insertCurso' type="button" class="btn btn-sm" onclick="flagEstadoModulo('<?php echo URLLOGICA?>curso/insertCurso/','listar','curso');">Grabar</button><!-- insertCurso('<?php //echo URLLOGICA?>curso/insertCurso/'); -->
                    <button name="closeCurso" id="closeCurso" type="button" class="btn btn-danger btn-sm" data-dismiss="modal" onclick="limpiarFormCurso();">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
    
    <div id="cursoDetalle" class="modal fade" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header" style="padding: 10px !important">
                    <table class="col-xs-12">
                        <tr>
                            <td style="text-align:left;">
                                <h4><strong id="titleForm">Detalle del Curso</strong></h4>
                            </td>
                            <td>
                                <button type="button" class="close btn-lg" data-dismiss="modal" onclick="limpiarFormCurso();" style="background-color: red; color:white; margin:10px; padding: 0px 6px 2px 6px;text-align:right;">
                                    <span aria-hidden="true">&times;</span><span class="sr-only">Cerrar</span>
                                </button>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="modal-body" style="padding-bottom: 10px;">
                    <div class="row">
                        <div class="col-md-12" style="padding-bottom: 10px;">
                            <label for="dTIPCUR_id" class="col-md-5 control-label">Tipo de Curso
                            <span style="color: #FF0000"><strong>*</strong></span></label>
                            <div class="col-md-7">
                                <input type="hidden" name="dCUR_id" id="dCUR_id" value="" class="form-control input-sm"/>
                                <select name="dTIPCUR_id" id="dTIPCUR_id" class="form-control input-sm js-example-basic-single" >
                                    <option value="" selected>Tipo de Curso</option>
                                <?php foreach($this->objTipoCurso as $lista){ ?>
                                    <option value="<?php echo $lista["TIPCUR_id"];?>"><?php echo ($lista["TIPCUR_descripcion"]);?></option>
                                <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12" style="padding-bottom: 10px;">
                            <label for="dTIPTRIP_id" class="col-md-5 control-label">Tipo de Tripulante
                            <span style="color: #FF0000"><strong>*</strong></span></label>
                            <div class="col-md-7">
                                <select name="dTIPTRIP_id" id="dTIPTRIP_id" class="form-control input-sm js-example-basic-single" >
                                    <option value="" selected>Tipo de Tripulante</option>
                                <?php foreach($this->objTipoTripulante as $lista){ ?>
                                    <option value="<?php echo $lista["TIPTRIP_id"];?>"><?php echo ($lista["TIPTRIP_descripcion"]);?></option>
                                <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12" style="padding-bottom: 10px;">
                            <label for="dTRIP_id_i" class="col-md-5 control-label">Tripulante Instructor
                            <span style="color: #FF0000"><strong>*</strong></span></label>
                            <div class="col-md-7">
                                <input type="hidden" name="PART_id_i" id="PART_id_i" value="" class="form-control input-sm"/>
                                <select name="dTRIP_id_i" id="dTRIP_id_i" class="form-control input-sm js-example-basic-single" >
                                    <option value="" selected>Tripulante Instructor</option>
                                <?php foreach($this->objTripulante as $lista){ ?>
                                    <option class="<?php echo $lista["TIPTRIP_id"];?>" value="<?php echo $lista["TRIP_id"];?>"><?php echo utf8_encode($lista["TRIP_nombre"]." ".$lista["TRIP_apellido"]);?></option>
                                <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12" style="padding-bottom: 10px;">
                            <label for="dCUR_fchini" class="col-md-5 control-label">Fecha Inicio
                            <span style="color: #FF0000"><strong>*</strong></span></label>
                            <div class="col-md-7">
                                <div class='input-group date datetimepicker1' id="dCUR_fchiniDate">
                                    <input type="text" name="dCUR_fchini" id="dCUR_fchini" class="form-control input-sm" style="text-transform: uppercase; width: 100% !important;"/>
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12" style="padding-bottom: 10px;">
                            <label for="dCUR_fchfin" class="col-md-5 control-label">Fecha Fin
                            <span style="color: #FF0000"><strong>*</strong></span></label>
                            <div class="col-md-7">
                                <div class='input-group date datetimepicker1' id="dCUR_fchfinDate">
                                    <input type="text" name="dCUR_fchfin" id="dCUR_fchfin" class="form-control input-sm" style="text-transform: uppercase; width: 100% !important;" disabled="disabled" />
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12" style="padding-bottom: 10px;">
                            <label for="dCUR_estado" class="col-md-5 control-label">Estado:
                            <span style="color: #FF0000"><strong>*</strong></span></label>
                            <div class="col-md-7">
                               <select name="dCUR_estado" id="dCUR_estado" class="form-control input-sm js-example-basic-single" onchange="validarEstadoCurso();">
                                   <option value="1" selected>Activo</option>
                                   <option value="0">Inactivo</option>
                               </select>
                            </div>
                        </div>
                        <div class="col-md-12" style="padding-bottom: 10px !important;" id="divAPT_fchentrega">
                            <label for="dCUR_fchinforme" class="col-md-5 control-label">Fch. de Informe
                            <span style="color: #FF0000"><strong>*</strong></span></label>
                            <div class="col-md-7">
                                <div class='input-group date datetimepicker1' id="dCUR_fchinformeDate">
                                    <input type="text" name="dCUR_fchinforme" id="dCUR_fchinforme" class="form-control input-sm" style="text-transform: uppercase; width: 100% !important;" />
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-11 col-md-11">
                            <table id="listaDetCurso" class="display table" cellspacing="0" cellpadding="2" style="margin: 10px;">
                                <thead>
                                    <tr>
                                        <th scope="col">Item</th>
                                        <th scope="col">Alumno</th>
                                        <th scope="col">Indicador</th>
                                        <th scope="col">Observación</th>
                                    </tr>
                                </thead>
                                <tbody id="listaAlumnos">
                                    <input name="num-alum" id="num-alum" value="" type="hidden">
                                </tbody>
                            </table>
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
                    <button name='dupdateCurso' id='dupdateCurso' type="button" class="btn btn-sm" onclick="flagEstadoModulo('<?php echo URLLOGICA?>curso/updateCurso/','modificar','curso')">Modificar</button><!-- updateCurso('<?php //echo URLLOGICA?>curso/updateCurso/'); -->
                    <button name="dcloseCurso" id="dcloseCurso" type="button" class="btn btn-danger btn-sm" data-dismiss="modal" onclick="limpiarFormCurso();">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Fin Modal-->
    
    <script type="text/javascript">
        $(function () {
            $("#TRIP_id_i").chained("#TIPTRIP_id");
            $("#TRIP_id_a1").chained("#TIPTRIP_id");
        });
        
        function listarComboTripulanteView(select){
            listarComboTripulanteDependTipo('<?php echo URLLOGICA?>tripulante/listarTripulantes/',select);
        }
        
        function enviarCorreoCurso(CUR_id){
            var envio = confirm('Advertencia: Se enviará el Correo informativo de Cursos. ¿Estas seguro de enviarlo (SI [ok] / NO [cancelar])?.');
            if (envio){
                var url = "<?php echo URLLOGICA?>curso/enviarCorreoCurso/";
                $("#preloader").css("display","block");
                var parametros = {
                    "CUR_id" : CUR_id,
                };
                $.post(url,parametros,
                function(data){
                    $("#preloader").css("display","none");
                });
            } else {
                return false;
            }
        }
        
        function enviarCorreoCursoParticipante(CUR_id){
            var envio = confirm('Advertencia: Se enviará el Correo informativo a los Particioantes acerca de su Curso. ¿Estas seguro de enviarlo (SI [ok] / NO [cancelar])?.');
            if (envio){
                var url = "<?php echo URLLOGICA?>curso/enviarCorreoCursoParticipante/";
                $("#preloader").css("display","block");
                var parametros = {
                    "CUR_id" : CUR_id,
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
