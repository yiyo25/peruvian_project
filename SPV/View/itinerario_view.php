<?php include "header_view.php";?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
				Gestionar de Itinerarios <small>Administrar Itinerarios</small>
            </h1>
            <ol class="breadcrumb">
                <li><i class="fa fa-thumb-tack"></i> Itinerarios</li>
                <li class="active">
                    Listado de Itinerarios
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
                        <form method="post" action="<?php echo URLLOGICA?>itinerario/buscarItinerario/" onsubmit="document.forms['buscar']['buscar'].disabled=true;" name="buscar">
                            <div class="row-fluid">
                                <div class="form-group">
                                    <label for="bITI_fchini" class="col-md-2 control-label">Fch. de Inicio </label>
                                    <div class="col-md-2">
                                        <div class='input-group date datetimepicker1'>
                                            <input type="text" name="bITI_fchini" id="bITI_fchini" value="<?php if(isset($_SESSION["ITI_fchini"])) { echo $_SESSION["ITI_fchini"]; } else { echo ""; }?>" class="form-control input-sm" style="text-transform: uppercase; width: 100% !important;" required />
                                            <span class="input-group-addon">
                                                <span class="glyphicon glyphicon-calendar"></span>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="bITI_fchfin" class="col-md-2 control-label">Fch. de Fin </label>
                                    <div class="col-md-2">
                                        <div class='input-group date datetimepicker1'>
                                            <input type="text" name="bITI_fchfin" id="bITI_fchfin" value="<?php if(isset($_SESSION["ITI_fchfin"])) { echo $_SESSION["ITI_fchfin"]; } else { echo ""; }?>" class="form-control input-sm" style="text-transform: uppercase; width: 100% !important;" required />
                                            <span class="input-group-addon">
                                                <span class="glyphicon glyphicon-calendar"></span>
                                            </span>
                                        </div>
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
                                <button type="button" name="limpiar" class="btn btn-danger btn-block" onclick="resetFormItinerario('<?php echo URLLOGICA?>itinerario/listarResumenItinerario/');"> Limpiar </button>
                            </div>
                            <div class="clearfix" style="padding: 4px;"></div>
                    </div>
                    <div id="MainContent_listaPro" class="panel panel-default">
                        <div class="panel-heading clearfix" style="padding: 5px !important">
                            <span id="MainContent_tituloPro"><strong>Lista de Itinerario</strong></span>
                            
                            <?php if($this->permisos_agregar[0]["Ejecutar"] == 1){ ?>
                                <button type="button" class="pull-right fa fa-handshake-o" data-toggle="modal" data-target="#itinerarioRegistro" ></button>
                            <?php } ?>
                        </div>
                        <div class="area_resultado table-responsive">
                            <table id="listaItinerario" class="display myDataTables" cellspacing="0" cellpadding="2">
                                <thead>
                                    <tr>
                                        <th scope="col">Item</th>
                                        <th scope="col">Fecha de Inicio</th>
                                        <th scope="col">Fecha Fin</th>
                                        <th scope="col">Proceso</th>
                                        <th scope="col">Fch. Registro</th>
                                        <th scope="col">Ver</th>
                                        <th scope="col">Editar</th>
                                        <th scope="col">Excel</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (count($this->objResumenItinerario) > 0) { ?>
                                        <?php $item = 1; ?>
                                        <?php foreach ($this->objResumenItinerario as $lista) { ?>
                                            <?php $data_toggle = "modal"; ?>
                                            <?php $title = ""; ?>
                                            <?php if($lista["ITI_proceso"] == 'ENVIADO'){ ?>
                                                <?php $data_toggle = "tooltip"; ?>
                                                <?php $title = "El Itinerario se encuentra Enviado"; ?>
                                            <?php } ?>
                                    <tr>
                                        <td style="width:auto;"><?php echo $item;?></td>
                                        <td style="width:auto;"><?php echo $lista["ITI_fchini"];?></td>
                                        <td style="width:auto;"><?php echo $lista["ITI_fchfin"];?></td>
                                        <td style="width:auto;"><?php echo $lista["ITI_proceso"];?></td>
                                        <td style="width:auto;"><?php echo $lista["AUD_fch_cre"];?></td>
                                        <td style="width:auto;">
                                            <?php  /*$Bdisabled = 1;*/ ?>
                                            <?php /* foreach ($this->objBotton as $botton) {*/ ?>
                                                <?php /*if($botton["Funcion"] == "listarItinerario"){*/ ?>
                                                    <?php /* $Bdisabled += 1; */ ?>
                                                <?php /* } */?>
                                            <?php /* } */ ?>
                                            <?php /*if($Bdisabled > 0){ $disabled = ""; } else { $disabled = "disabled"; }*/ ?>
                                            <?php if($this->permisos_ver[0]["Ejecutar"] == 1 ){ ?>
                                                <button type="button" class="fa fa-eye" data-toggle="modal"  data-target="#itinerarioRegistro" onclick="listarDetItinerario('<?php echo URLLOGICA?>itinerario/listarDetItinerario/','<?php echo utf8_encode($lista["ITI_fchini"]);?>','<?php echo utf8_encode($lista["ITI_fchfin"]);?>','','listar','')" ></button>
                                            <?php } ?>
                                        </td>
                                        <td style="width:auto;">
                                            <?php  /*$Bdisabled = 0;*/ ?>
                                            <?php /*foreach ($this->objBotton as $botton) {*/ ?>
                                                <?php /*if($botton["Funcion"] == "updateItinerario"){*/ ?>
                                                    <?php /*if($lista["ITI_proceso"] != 'ENVIADO'){*/ ?>
                                                        <?php /*$Bdisabled += 1;*/  ?>
                                                    <?php /*}*/ ?>
                                                <?php /*}*/ ?>
                                            <?php /*}*/ ?>

                                             <?php if($this->permisos_modificar[0]["Ejecutar"] == 1){ ?>
                                                 <?php  $Bdisabled = 0; ?>
                                                 <?php if($lista["ITI_proceso"] != 'ENVIADO'){ ?>
                                                     <?php $Bdisabled = 1;  ?>
                                                 <?php } ?>
                                                 <?php if($Bdisabled > 0){ $disabled = ""; } else { $disabled = "disabled"; } ?>
                                                <button type="button" class="fa fa-pencil" data-toggle="<?php echo $data_toggle; ?>" data-target="#itinerarioRegistro" onclick="listarDetItinerario('<?php echo URLLOGICA?>itinerario/listarDetItinerario/','<?php echo utf8_encode($lista["ITI_fchini"]);?>','<?php echo utf8_encode($lista["ITI_fchfin"]);?>','','modificar','')" <?php echo  $disabled; ?> data-placement="top" title="<?php echo $title; ?>" ></button>
                                                <!--<input type="hidden" name="ITI_proceso" id="ITI_proceso" value="<?php //echo $lista["ITI_proceso"];?>" />-->
                                            <?php } ?>
                                        </td>
                                        <td style="width:auto;">
                                             <?php if($this->objBotton[0]["Exportar"] == 1){ ?>
                                            <a href="<?php echo URLLOGICA;?>excel/itinerario_excel/<?php echo $lista["ITI_fchini"];?>/<?php echo $lista["ITI_fchfin"];?>" class="logo">
                                                <img src="<?php echo URLPUBLIC;?>/img/excel.png" />
                                            </a>
                                             <?php } ?>
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
    <div id="itinerarioRegistro" class="modal fade" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header" style="padding: 10px !important">
                    <table class="col-xs-12">
                        <tr>
                            <td style="text-align:left;">
                                <h4><strong id="titleForm">Ingresar Nuevo Itinerario</strong></h4>
                            </td>
                            <td>
                                <button type="button" class="close btn-lg" data-dismiss="modal" onclick="limpiarFormItinerario();" style="background-color: red; color:white; margin:10px; padding: 0px 6px 2px 6px;text-align:right;">
                                    <span aria-hidden="true">&times;</span><span class="sr-only">Cerrar</span>
                                </button>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="modal-body" style="padding-top: 0px;">
                    <div class="row-fluid" style="padding-bottom: 10px;">
                        <div class="form-group">
                            <label for="ITI_fchini" class="col-md-2 control-label">Fch. Ini
                            <span style="color: #FF0000"><strong>*</strong></span></label>
                            <div class="col-md-3">
                                <div class='input-group date datetimepicker1' id="ITI_fchiniDate">
                                    <input type="text" name="ITI_fchini" id="ITI_fchini" class="form-control input-sm" style="text-transform: uppercase; width: 100% !important;" />
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                            </div>
                            <label for="ITI_fchfin" class="col-md-2 control-label">Fch. Fin
                            <span style="color: #FF0000"><strong>*</strong></span></label>
                            <div class="col-md-3">
                                <div class='input-group date datetimepicker1' id="ITI_fchfinDate">
                                    <input type="text" name="ITI_fchfin" id="ITI_fchfin" class="form-control input-sm" style="text-transform: uppercase; width: 100% !important;" disabled="disabled" />
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group" style="padding-bottom: 10px !important; display:none;" id="divITI_fchListar">
                            <div class="col-md-2">
                                <button type="button" name="listar" class="btn btn-danger btn-block" onclick="listarDetItinerarioxFch('<?php echo URLLOGICA?>itinerario/listarDetItinerario/')"> Listar </button>
                                <input type="hidden" name="accion" id="accion" value="" />
                            </div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="row-fluid" style="padding-bottom: 10px !important; display:none;" id="divITI_fchVisualizada">
                        <div class="form-group">
                            <label for="bRUT_num_vuelo" class="col-md-2 control-label">N° de Vuelo</label>
                            <div class="col-md-3">
                                <select name="bRUT_num_vuelo" id="bRUT_num_vuelo" class="form-control input-sm js-example-basic-single" >
                                    <option value="" selected>N° de Vuelo</option>
                                <?php foreach($this->objRuta as $lista){ ?>
                                    <option value="<?php echo $lista["RUT_num_vuelo"];?>"><?php echo $lista["RUT_num_vuelo"]."-".$lista["CIU_id_origen"]."-".$lista["CIU_id_destino"];?></option>
                                <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="ITI_fchVisualizada" class="col-md-2 control-label">Fch. Ver</label>
                            <div class="col-md-3">
                                <div class='input-group date datetimepicker1' id="ITI_fchVisualizadaDate">
                                    <input type="text" name="ITI_fchVisualizada" id="ITI_fchVisualizada" class="form-control input-sm" style="text-transform: uppercase; width: 100% !important;" />
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-2">
                                <button type="button" name="limpiar" class="btn btn-danger btn-block" onclick="limpiarListado();"> Limpiar </button>
                                <input type="hidden" name="accion" id="accion" value="" />
                            </div>
                        </div>
                    </div>
                    <div class="clearfix" style="padding: 10px;"></div>
                    <div class="row-fluid">
                        <div class="form-group area_resultado table-responsive" style="height:430px; overflow:auto;">
                            <table id="listaItinerario" class="table table-striped" cellspacing="0" cellpadding="2">
                                <thead>
                                    <tr>
                                        <th scope="col">Avión</th>
                                        <th scope="col">Estado</th>
                                        <th scope="col">N° Vuelo</th>
                                        <th scope="col">Origen</th>
                                        <th scope="col">Destino</th>
                                        <th scope="col">Hora Salida</th>
                                        <th scope="col">Hora Llegada</th>
                                    </tr>
                                </thead>
                                <tbody id="tbody_objRutaxFecha">
                                    <?php if (count($this->objRuta) > 0) { ?>
                                        <?php $item = 1;?>
                                        <?php foreach ($this->objRuta as $lista) { ?>
                                    <tr>
                                        <td style="width:18%;">
                                            <select name="AVI_id<?php echo $item;?>" id="AVI_id<?php echo $item;?>" class="form-control input-sm js-example-basic-single" onchange="asignarAvionAuto('<?php echo $lista["RUT_relacion"];?>','<?php echo $lista["RUT_orden"];?>',this.value);"> 
                                                <option value="">Selecccione Avión</option>
                                            <?php foreach($this->objAvion as $listaAv){ ?>
                                                <option value="<?php echo $listaAv["AVI_id"];?>"><?php echo $listaAv["AVI_num_cola"];?></option>
                                            <?php } ?>
                                            </select>
                                        </td>
                                        <td style="width:auto;">
                                            <input type="checkbox" id="RUT_num_vuelo<?php echo $item;?>" name="RUT_num_vuelo<?php echo $item;?>" value="<?php echo $lista["RUT_num_vuelo"];?>" class="form-check-input" checked /><!--checked-->
                                            <input type="hidden" name="RUT_primer_vuelo<?php echo $item;?>" id="RUT_primer_vuelo<?php echo $item;?>" value="<?php echo $lista["RUT_primer_vuelo"];?>" />
                                            <!--<button type="button" class="fa fa-info fa-xs" data-toggle="modal" data-target="#cargaRegistro"></button>-->
                                        </td>
                                        <td style="width:auto;"><?php echo $lista["RUT_num_vuelo"];?></td>
                                        <td style="width:auto;"><?php echo $lista["CIU_id_origen"];?>
                                            <input type="hidden" name="CIU_id_origen<?php echo $item;?>" id="CIU_id_origen<?php echo $item;?>" value="<?php echo $lista["CIU_id_origen"];?>" />
                                        </td>
                                        <td style="width:auto;"><?php echo $lista["CIU_id_destino"];?>
                                            <input type="hidden" name="CIU_id_destino<?php echo $item;?>" id="CIU_id_destino<?php echo $item;?>" value="<?php echo $lista["CIU_id_destino"];?>" />
                                        </td>
                                        <td style="width:auto;"><?php echo $lista["RUT_hora_salida"];?>
                                            <input type="hidden" name="RUT_hora_salida<?php echo $item;?>" id="RUT_hora_salida<?php echo $item;?>" value="<?php echo $lista["RUT_hora_salida"];?>" />
                                        </td>
                                        <td style="width:auto;"><?php echo $lista["RUT_hora_llegada"];?>
                                            <input type="hidden" name="RUT_hora_llegada<?php echo $item;?>" id="RUT_hora_llegada<?php echo $item;?>" value="<?php echo $lista["RUT_hora_llegada"];?>" />
                                        </td>
                                    </tr>
                                        <?php $item++; ?>
                                        <?php } ?>
                                    <?php } ?>
                                </tbody>
                                <tbody id="tbody_objRuta"></tbody>
                            </table>
                        </div>
                    </div>
                    <div class="row-fluid" style="padding-bottom: 10px !important; display:none;" id="divAUD_usu_cre">
                        <div class="form-group">
                                <label for="AUD_usu_cre" class="col-md-5 control-label">Usuario de Creación:
                                <span style="color: #FF0000"><strong>*</strong></span></label>
                                <div class="col-md-6">
                                   <input type="text" name="AUD_usu_cre" id="AUD_usu_cre" class="form-control input-sm numberDecimal" style="text-transform: uppercase; width: 100% !important;" />
                                </div>
                        </div>
                    </div>
                    <div class="row-fluid" style="padding-bottom: 10px !important; display:none;" id="divAUD_fch_cre">
                        <div class="form-group">
                                <label for="AUD_fch_cre" class="col-md-5 control-label">Fecha de Creación:
                                <span style="color: #FF0000"><strong>*</strong></span></label>
                                <div class="col-md-6">
                                   <input type="text" name="AUD_fch_cre" id="AUD_fch_cre" class="form-control input-sm" style="text-transform: uppercase; width: 100% !important;" />
                                </div>
                        </div>
                    </div>
                    <div class="row-fluid" style="padding-bottom: 10px !important; display:none;" id="divAUD_usu_mod">
                        <div class="form-group">
                                <label for="AUD_usu_mod" class="col-md-5 control-label">Usuario de Mod.:
                                <span style="color: #FF0000"><strong>*</strong></span></label>
                                <div class="col-md-6">
                                   <input type="text" name="AUD_usu_mod" id="AUD_usu_mod" class="form-control input-sm" style="text-transform: uppercase; width: 100% !important;" />
                                </div>
                        </div>
                    </div>
                    <div class="row-fluid" style="padding-bottom: 10px !important; display:none;" id="divAUD_fch_mod">
                        <div class="form-group">
                                <label for="AUD_fch_mod" class="col-md-5 control-label">Fecha de Mod.:
                                <span style="color: #FF0000"><strong>*</strong></span></label>
                                <div class="col-md-6">
                                   <input type="text" name="AUD_fch_mod" id="AUD_fch_mod" class="form-control input-sm numberDecimal" style="text-transform: uppercase; width: 100% !important;" />
                                </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer" style="padding: 10px !important">
                    <input type="hidden" name="objRuta" id="objRuta" value="<?php echo count($this->objRuta);?>" />
                    <?php if($this->permisos_ver[0]["Agregar"] == 1){  ?>
                    <button name='sendItinerario' id='sendItinerario' type="button" class="btn btn-sm" onclick="sendItinerario('<?php echo URLLOGICA?>itinerario/enviarAprobItinerario/');" >Enviar</button><!--disabled="disabled"-->
                    <?php } ?>
                     <?php if($this->permisos_agregar[0]["Agregar"] == 1){  ?>
                    <button name='insertItinerario' id='insertItinerario' type="button" class="btn btn-sm" onclick="insertItinerario('<?php echo URLLOGICA?>avion/listarMantoAvion/','<?php echo URLLOGICA?>itinerario/insertItinerario/');">Grabar</button>
                    <?php } ?>
                    <?php if($this->permisos_modificar[0]["Modificar"] == 1){ ?>
                    <button name='updateItinerario' id='updateItinerario' type="button" class="btn btn-sm" onclick="updateItinerario('<?php echo URLLOGICA?>avion/listarMantoAvion/','<?php echo URLLOGICA?>itinerario/updateItinerario/');">Modificar</button>
                    <?php } ?>
                    <button name="closeItinerario" id="closeItinerario" type="button" class="btn btn-danger btn-sm" data-dismiss="modal" onclick="limpiarFormItinerario();">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
    
    <div id="itinerarioRegistroxFecha" class="modal fade" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header" style="padding: 10px !important">
                    <table class="col-xs-12">
                        <tr>
                            <td style="text-align:left;">
                                <h4><strong id="titleForm">Ingresar Nuevo Itinerario</strong></h4>
                                <h6 style="color: #FF0000"><strong id="contentForm">Los Aviones del listado se encuentran en Mantenimiento en las fechas indicadas, favor de modificar los aviones caso contrario retirará las rutas para esas fechas</strong></h6>
                            </td>
                            <td>
                                <button type="button" class="close btn-lg" data-dismiss="modal" onclick="closeItinerarioRegistroxFecha();" style="background-color: red; color:white; margin:10px; padding: 0px 6px 2px 6px;text-align:right;">
                                    <span aria-hidden="true">&times;</span><span class="sr-only">Cerrar</span>
                                </button>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="modal-body" style="padding-bottom: 10px !important">
                    <div class="row">
                        <div class="col-md-12 area_resultado table-responsive" style="padding-bottom: 10px;">
                            <table id="listaItinerario" class="table table-striped" cellspacing="0" cellpadding="2">
                                <thead>
                                    <tr>
                                        <th scope="col">Avión Manto</th>
                                        <th scope="col">Fch. Ini</th>
                                        <th scope="col">Fch. Fin</th>
                                        <th scope="col">Avión</th>
                                        <th scope="col">Estado</th>
                                        <th scope="col">N° Vuelo</th>
                                        <th scope="col">Origen</th>
                                        <th scope="col">Destino</th>
                                        <th scope="col">Hora Salida</th>
                                        <th scope="col">Hora Llegada</th>
                                    </tr>
                                </thead>
                                <tbody id="listaitinerarioxMantoAvion">
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer" style="padding: 10px !important">
                    <input type="hidden" name="objRutaManto" id="objRutaManto" value="" />
                    <button name='insertItinerario_m' id='insertItinerario_m' type="button" class="btn btn-sm" onclick="insertItinerario_m('<?php echo URLLOGICA?>itinerario/insertItinerarioManto/','<?php echo URLLOGICA?>itinerario/insertItinerario/');">Grabar</button>
                    <button name='updateItinerario_m' id='updateItinerario_m' type="button" class="btn btn-sm" onclick="updateItinerario_m('<?php echo URLLOGICA?>itinerario/updateItinerarioManto/');">Modificar</button>
                    <button name="closeItinerario_m" id="closeItinerario_m" type="button" class="btn btn-danger btn-sm" data-dismiss="modal" onclick="closeItinerarioRegistroxFecha();">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Fin Modal-->
    
    <script>
        function listarComboAvionView(select,ITI_fchini,ITI_fchfin){
            listarComboAvionxManto('<?php echo URLLOGICA?>detalle/listarAvion/',select,ITI_fchini,ITI_fchfin);
        }
        
        function listarComboAvionVariosView(valor){
            listarComboAvionVarios('<?php echo URLLOGICA?>avion/listarDetAvion/',valor);
        }
        
        function limpiarListado(){
            var ITI_fchini = $("#ITI_fchini").val();
            var ITI_fchfin = $("#ITI_fchfin").val();
            $("#ITI_fchVisualizada").val(ITI_fchini);
            $("#bRUT_num_vuelo").val("").trigger('change.select2');
            listarDetItinerario('<?php echo URLLOGICA?>itinerario/listarDetItinerario/',ITI_fchini,ITI_fchfin,'','listar','')
        }
        
        function asignarAvionAuto(RUT_relacion,RUT_orden,value){
            var url = '<?php echo URLLOGICA?>itinerario/completarRuta/';
            var parametros = {
                "RUT_orden" : RUT_orden,
                "RUT_relacion" : RUT_relacion,
                "ITI_fchini" : $("#ITI_fchini").val(),
            };
            $.post(url,parametros,
            function(data){
                if(data != ""){
                    for (var j = 1; j <= $("#objRuta").val(); j++) {
                        if($("#RUT_num_vuelo" + j).val() == data){
                            if( $("#AVI_id" + j).val() == '' ){
                                $("#AVI_id" + j).val(value).trigger('change.select2');
                                break;
                            }
                        }
                    }
                }
            });
        }
        
        function guardarExcelItiServidorView(ITI_fchini,ITI_fchfin){
            var result = ITI_fchini.split('/');
            var result2 = ITI_fchfin.split('/');
            guardarExcelServidor('<?php echo URLLOGICA?>excel/itinerario_excel/' + result[0] + '/' + result[1] + '/' + result[2] + '/' + result2[0] + '/' + result2[1] + '/' + result2[2]);
        }
        
        function listarRutaxDia(ITI_fchini,accion){
            $("#preloader").css("display","block");
            var url = '<?php echo URLLOGICA?>itinerario/listarRutaxDia/';
            var parametros = {
                "ITI_fchini" : ITI_fchini,
            };
            $.post(url,parametros,
            function(data){
                $("#tbody_objRutaxFecha").empty();
                
                var disabled = '';
                var checked = '';
                
                if(accion == 'insert'){
                    disabled = '';
                    checked = 'checked'; //produccion
                    //checked = ''; //desarrollo
                } else {
                    disabled = 'disabled="disabled"';
                    checked = '';
                }
                
                for (var j = 0; j < data.length; j++){
                    html = '<tr>'
                            + '<td style="width:18%;">'
                                + '<select name="AVI_id' + (j+1) + '" id="AVI_id' + (j+1) + '" class="form-control input-sm js-example-basic-single_extra" onchange="asignarAvionAuto(' + data[j]["RUT_relacion"] + ',' + data[j]["RUT_orden"] + ',this.value);" '+disabled+'>'
                                    + '<option value="">Selecccione Avión</option>'
                                <?php foreach($this->objAvion as $listaAv){ ?>
                                    + '<option value="<?php echo $listaAv["AVI_id"];?>"><?php echo $listaAv["AVI_num_cola"];?></option>'
                                <?php } ?>
                                + '</select>'
                            + '</td>'
                            + '<td style="width:auto;">'
                                + '<input type="checkbox" id="RUT_num_vuelo' + (j+1) + '" name="RUT_num_vuelo' + (j+1) + '" value="' + data[j]["RUT_num_vuelo"] +'" class="form-check-input" '+disabled+' '+checked+'/><!--checked-->'
                                + '<input type="hidden" name="RUT_primer_vuelo' + (j+1) + '" id="RUT_primer_vuelo' + (j+1) + '" value="' + data[j]["RUT_primer_vuelo"] +'" />'
                            + '</td>'
                            + '<td style="width:auto;">' + data[j]["RUT_num_vuelo"] + '</td>'
                            + '<td style="width:auto;">' + data[j]["CIU_id_origen"]
                                + '<input type="hidden" name="CIU_id_origen' + (j+1) + '" id="CIU_id_origen' + (j+1) + '" value="' + data[j]["CIU_id_origen"] +'" />'
                            + '</td>'
                            + '<td style="width:auto;">' + data[j]["CIU_id_destino"]
                                + '<input type="hidden" name="CIU_id_destino' + (j+1) + '" id="CIU_id_destino' + (j+1) + '" value="' + data[j]["CIU_id_destino"] +'" />'
                            + '</td>'
                            + '<td style="width:auto;">' + data[j]["RUT_hora_salida"]
                                + '<input type="hidden" name="RUT_hora_salida' + (j+1) + '" id="RUT_hora_salida' + (j+1) + '" value="' + data[j]["RUT_hora_salida"] +'" />'
                            + '</td>'
                            + '<td style="width:auto;">' + data[j]["RUT_hora_llegada"]
                                + '<input type="hidden" name="RUT_hora_llegada' + (j+1) + '" id="RUT_hora_llegada' + (j+1) + '" value="' + data[j]["RUT_hora_llegada"] +'" />'
                            + '</td>'
                        + '</tr>';
                    $("#tbody_objRutaxFecha").append(html);
                }
                $(document).ready(function() { $(".js-example-basic-single_extra").select2(); });
                $("#preloader").css("display","none");
            });
        }
        
        function insertItinerario(url_AVI,url){
            $("#preloader").css("display","block");

            if(validate_formItinerario()) {
                var variable = true;
                for (var i = 1; i <= $("#objRuta").val(); i++) {
                    if($("#RUT_num_vuelo" + i).is(':checked')){
                        $("#AVI_id" + i).attr("required","required");
                        if($("#AVI_id" + i).val() == ""){
                            var RUT_num_vuelo = $("#RUT_num_vuelo" + i).val();
                            var variable = false;
                            break;
                        }
                    }
                }

                if(variable){
                    var contador = 0;
                    var parametros = {
                        "ITI_fchini" : $("#ITI_fchini").val(),
                        "ITI_fchfin" : $("#ITI_fchfin").val()
                    };
                    for (var i = 1; i <= $("#objRuta").val(); i++) {
                        if($("#RUT_num_vuelo" + i).is(':checked')){
                            parametros["RUT_num_vuelo" + i] = $("#RUT_num_vuelo" + i).val();
                            parametros["AVI_id" + i] = $("#AVI_id" + i).val();
                        }
                    }
                    parametros["cantidad"] = $("#objRuta").val();

                    $.post(url_AVI,parametros,
                    function(data){
                        if(data == ""){
                            //alert("Hubo un error en el registro.");
                        }
                        else {
                            $("#listaitinerarioxMantoAvion").empty();
                            for (var j = 0; j < data.length; j++){
                                for (var i = 1; i <= $("#objRuta").val(); i++) {
                                    if($("#RUT_num_vuelo" + i).is(':checked')){
                                        if( data[j]["AVI_id"] == $("#AVI_id" + i).val() && $("#RUT_primer_vuelo" + i).val() != 'Si' ){
                                            html = '<tr>'
                                                + '<td style="width:auto;">' + data[j]["AVI_num_cola"] + '</td>'
                                                + '<td style="width:auto;">' + data[j]["MANTAVI_fchini"] + '</td>'
                                                + '<td style="width:auto;">' + data[j]["MANTAVI_fchfin"] + '</td>'
                                                + '<td style="width:auto;">'
                                                    + '<select name="AVI_id_m' + i + '" id="AVI_id_m' + i + '" class="form-control input-sm js-example-basic-single_extra">'
                                                        + '<option value="">Selecccione Avión</option>'
                                                    + '</select>'
                                                + '</td>'
                                                + '<td style="width:auto;">'
                                                    + '<input type="checkbox" id="RUT_num_vuelo_m' + i + '" name="RUT_num_vuelo_m' + i + '" value="' + $("#RUT_num_vuelo" + i).val() + '" class="form-check-input" />'
                                                    + '<input type="hidden" name="MANTAVI_fchini' + i + '" id="MANTAVI_fchini' + i + '" value="' + data[j]["MANTAVI_fchini"] + '" />'
                                                    + '<input type="hidden" name="MANTAVI_fchfin' + i + '" id="MANTAVI_fchfin' + i + '" value="' + data[j]["MANTAVI_fchfin"] + '" />'
                                                + '</td>'
                                                + '<td style="width:auto;">' + $("#RUT_num_vuelo" + i).val() + '</td>'
                                                + '<td style="width:auto;">' + $("#CIU_id_origen" + i).val() + '</td>'
                                                + '<td style="width:auto;">' + $("#CIU_id_destino" + i).val() + '</td>'
                                                + '<td style="width:auto;">' + $("#RUT_hora_salida" + i).val() + '</td>'
                                                + '<td style="width:auto;">' + $("#RUT_hora_llegada" + i).val() + '</td>'
                                            + '</tr>';
                                            $("#listaitinerarioxMantoAvion").append(html);

                                            listarComboAvionView($("#AVI_id_m" + i),$("#ITI_fchini").val(),$("#ITI_fchfin").val());
                                            contador++;
                                        }
                                    }
                                }
                            }
                            $("#preloader").css("display", "none");
                            if(contador > 0){
                                guardarExcelItiServidorView($("#ITI_fchini").val(),$("#ITI_fchfin").val());
                                $('#objRutaManto').val(contador);
                                $(document).ready(function() { $(".js-example-basic-single_extra").select2(); });
                                $('#itinerarioRegistroxFecha').modal('show');
                                $("#itinerarioRegistroxFecha").css('z-index','1050');
                                $('#itinerarioRegistroxFecha').modal({backdrop: 'static', keyboard: false})
                            }
                        }
                    });
                    setTimeout(function(){
                        if(contador == 0){
                            $.post(url,parametros,
                            function(data){
                                if(data.length > 0){
                                    var ITI_fchini = data[0]["ITI_fchini"];
                                    var ITI_fchfin = data[0]["ITI_fchfin"];
                                    alert('Conflicto de Fechas. Existe el itinerario del ' + ITI_fchini + ' al ' + ITI_fchfin);
                                    $("#preloader").css("display","none");
                                } else {
                                    guardarExcelItiServidorView($("#ITI_fchini").val(),$("#ITI_fchfin").val());
                                    limpiarFormItinerario();
                                    $("#preloader").css("display", "none");
                                    alert("Se ha registrado correctamente el Itinerario.");
                                    $('#itinerarioRegistro').modal('hide');
                                    location.reload(true);
                                }
                            });
                        }
                    },1000);
                } else {
                    alert("Debe ingresar el avión para la Ruta " + RUT_num_vuelo);
                    $("#preloader").css("display", "none");
                }
            } else{
                $("#preloader").css("display","none");
            }
        }

        function insertItinerario_m(url_m,url){
            $("#preloader").css("display","block");
            var variable = true;
            for (var i = 1; i <= $("#objRuta").val(); i++) {
                if($("#RUT_num_vuelo_m" + i).is(':checked')){
                    $("#AVI_id_m" + i).attr("required","required");
                    if($("#AVI_id_m" + i).val() == ""){
                        var RUT_num_vuelo = $("#RUT_num_vuelo_m" + i).val();
                        var variable = false;
                        break;
                    }
                }
            }

            var parametros = {
            };
            for (var i = 1; i <= $("#objRuta").val(); i++) {
                if($("#RUT_num_vuelo_m" + i).is(':checked')){
                    parametros["RUT_num_vuelo_m" + i] = $("#RUT_num_vuelo_m" + i).val();
                    parametros["AVI_id_m" + i] = $("#AVI_id_m" + i).val();
                    parametros["MANTAVI_fchini" + i] = $("#MANTAVI_fchini" + i).val();
                    parametros["MANTAVI_fchfin" + i] = $("#MANTAVI_fchfin" + i).val();
                }
            }
            parametros["cantidadManto"] = $("#objRuta").val();

            if(variable){
                $.post(url_m,parametros,
                function(data){
                    if(data.length > 0){
                        $('#itinerarioRegistroxFecha').modal('hide');
                    } else {
                    }
                });

                setTimeout(function(){
                    var parametros2 = {
                        "ITI_fchini" : $("#ITI_fchini").val(),
                        "ITI_fchfin" : $("#ITI_fchfin").val()
                    };
                    for (var i = 1; i <= $("#objRuta").val(); i++) {
                        if($("#RUT_num_vuelo" + i).is(':checked')){
                            parametros2["RUT_num_vuelo" + i] = $("#RUT_num_vuelo" + i).val();
                            parametros2["AVI_id" + i] = $("#AVI_id" + i).val();
                        }
                    }
                    parametros2["cantidad"] = $("#objRuta").val();
                    $.post(url,parametros2,
                    function(data){
                        if(data.length > 0){
                            var ITI_fchini = data[0]["ITI_fchini"];
                            var ITI_fchfin = data[0]["ITI_fchfin"];
                            alert('Conflicto de Fechas. Existe el itinerario del ' + ITI_fchini + ' al ' + ITI_fchfin);
                            $("#preloader").css("display","none");
                        } else {
                            limpiarFormItinerario();
                            $("#preloader").css("display", "none");
                            alert("Se ha registrado correctamente el Itinerario.");
                            $('#itinerarioRegistro').modal('hide');
                            location.reload(true);
                        }
                    });
                },1000);
            } else {
                alert("Debe ingresar el avión para la Ruta " + RUT_num_vuelo);
            }
        }
        
        //updateItinerario('<?php //echo URLLOGICA?>avion/listarMantoAvion/','<?php //echo URLLOGICA?>itinerario/updateItinerario/')
        function updateItinerario(url_AVI,url){
            $("#preloader").css("display","block");

            if(validate_formItinerario()) {
                var variable = true;
                for (var i = 1; i <= $("#objRuta").val(); i++) {
                    if($("#RUT_num_vuelo" + i).is(':checked')){
                        $("#AVI_id" + i).attr("required","required");
                        if($("#AVI_id" + i).val() == ""){
                            var RUT_num_vuelo = $("#RUT_num_vuelo" + i).val();
                            var variable = false;
                            break;
                        }
                    }
                }

                if(variable){
                    var contador = 0;
                    var parametros = {
                        "ITI_fchini" : $("#ITI_fchVisualizada").val(),
                        "ITI_fchfin" : $("#ITI_fchVisualizada").val()
                    };
                    for (var i = 1; i <= $("#objRuta").val(); i++) {
                        if($("#RUT_num_vuelo" + i).is(':checked')){
                            parametros["RUT_num_vuelo" + i] = $("#RUT_num_vuelo" + i).val();
                            parametros["AVI_id" + i] = $("#AVI_id" + i).val();
                        }
                    }
                    parametros["cantidad"] = $("#objRuta").val();

                    $.post(url_AVI,parametros,
                    function(data){
                        if(data == ""){
                            //alert("Hubo un error en el registro.");
                        } else {
                            $("#preloader").css("display", "none");
                            /*Cambio 13/06/2018*/
                            /*$("#preloader").css("display", "none");
                            $("#listaitinerarioxMantoAvion").empty();
                            for (var j = 0; j < data.length; j++){
                                for (var i = 1; i <= $("#objRuta").val(); i++) {
                                    if($("#RUT_num_vuelo" + i).is(':checked') && $("#RUT_primer_vuelo" + i).val() == "No" ){
                                        if( data[j]["AVI_id"] == $("#AVI_id" + i).val()){
                                            html = '<tr>'
                                                + '<td style="width:auto;">' + data[j]["AVI_num_cola"] + '</td>'
                                                + '<td style="width:auto;">' + data[j]["MANTAVI_fchini"] + '</td>'
                                                + '<td style="width:auto;">' + data[j]["MANTAVI_fchfin"] + '</td>'
                                                + '<td style="width:auto;">'
                                                    + '<select name="AVI_id_m' + i + '" id="AVI_id_m' + i + '" class="form-control input-sm js-example-basic-single_extra">'
                                                        + '<option value="">Selecccione Avión</option>'
                                                    + '</select>'
                                                + '</td>'
                                                + '<td style="width:auto;">'
                                                    + '<input type="checkbox" id="RUT_num_vuelo_m' + i + '" name="RUT_num_vuelo_m' + i + '" value="' + $("#RUT_num_vuelo" + i).val() + '" class="form-check-input" />'
                                                    + '<input type="hidden" name="MANTAVI_fchini' + i + '" id="MANTAVI_fchini' + i + '" value="' + data[j]["MANTAVI_fchini"] + '" />'
                                                    + '<input type="hidden" name="MANTAVI_fchfin' + i + '" id="MANTAVI_fchfin' + i + '" value="' + data[j]["MANTAVI_fchfin"] + '" />'
                                                + '</td>'
                                                + '<td style="width:auto;">' + $("#RUT_num_vuelo" + i).val() + '</td>'
                                                + '<td style="width:auto;">' + $("#CIU_id_origen" + i).val() + '</td>'
                                                + '<td style="width:auto;">' + $("#CIU_id_destino" + i).val() + '</td>'
                                                + '<td style="width:auto;">' + $("#RUT_hora_salida" + i).val() + '</td>'
                                                + '<td style="width:auto;">' + $("#RUT_hora_llegada" + i).val() + '</td>'
                                            + '</tr>';
                                            $("#listaitinerarioxMantoAvion").append(html);
                                            listarComboAvionView($("#AVI_id_m" + i),$("#AVI_id" + i).val());
                                        contador++;
                                        }
                                    }
                                }
                            }
                            if(contador > 0){
                                $('#objRutaManto').val(contador);
                                $(document).ready(function() { $(".js-example-basic-single_extra").select2(); });
                                $('#itinerarioRegistroxFecha').modal('show');
                                $("#itinerarioRegistroxFecha").css('z-index','1050');
                                $('#itinerarioRegistroxFecha').modal({backdrop: 'static', keyboard: false})
                            }*/
                        }
                    });
                    setTimeout(function(){
                        if(contador == 0){
                            $.post(url,parametros,
                            function(data){
                                if(data == ""){
                                    alert("Hubo un error en el registro.");
                                } else {
                                    guardarExcelItiServidorView($("#ITI_fchini").val(),$("#ITI_fchfin").val());
                                    limpiarFormItinerario();
                                    $("#preloader").css("display", "none");
                                    alert("Se ha registrado correctamente el Itinerario.");
                                }
                                $('#itinerarioRegistro').modal('hide');
                                location.reload(true);
                            });
                        }
                    },1000);
                } else {
                    alert("Debe ingresar el avión para la Ruta " + RUT_num_vuelo);
                }
            } else{
                $("#preloader").css("display","none");
            }
        }

        function updateItinerario_m(url_m,url){
            $("#preloader").css("display","block");
            var variable = true;
            for (var i = 1; i <= $("#objRutaManto").val(); i++) {
                if($("#RUT_num_vuelo_m" + i).is(':checked')){
                    $("#AVI_id_m" + i).attr("required","required");
                    if($("#AVI_id_m" + i).val() == ""){
                        var RUT_num_vuelo = $("#RUT_num_vuelo_m" + i).val();
                        var variable = false;
                        break;
                    }
                }
            }

            var parametros = {
            };
            for (var i = 1; i <= $("#objRutaManto").val(); i++) {
                if($("#RUT_num_vuelo_m" + i).is(':checked')){
                    parametros["RUT_num_vuelo_m" + i] = $("#RUT_num_vuelo_m" + i).val();
                    parametros["AVI_id_m" + i] = $("#AVI_id_m" + i).val();
                    parametros["MANTAVI_fchini" + i] = $("#MANTAVI_fchini" + i).val();
                    parametros["MANTAVI_fchfin" + i] = $("#MANTAVI_fchfin" + i).val();
                }
            }
            parametros["cantidadManto"] = $("#objRutaManto").val();

            if(variable){
                $.post(url_m,parametros,
                function(data){
                    if(data == ""){
                        alert("Hubo un error en el registro.");
                    } else {
                        $('#itinerarioRegistroxFecha').modal('hide');
                    }
                });

                setTimeout(function(){
                    var parametros2 = {
                        "ITI_fchini" : $("#ITI_fchVisualizada").val(),
                        "ITI_fchfin" : $("#ITI_fchVisualizada").val()
                    };
                    for (var i = 1; i <= $("#objRuta").val(); i++) {
                        if($("#RUT_num_vuelo" + i).is(':checked')){
                            parametros2["RUT_num_vuelo" + i] = $("#RUT_num_vuelo" + i).val();
                            parametros2["AVI_id" + i] = $("#AVI_id" + i).val();
                        }
                    }
                    parametros2["cantidad"] = $("#objRuta").val();
                    $.post(url,parametros2,
                    function(data){
                        if(data == ""){
                            alert("Hubo un error en el registro.");
                        } else {
                            limpiarFormItinerario();
                            $("#preloader").css("display", "none");
                            alert("Se ha registrado correctamente el Itinerario.");
                        }
                        $('#itinerarioRegistro').modal('hide');
                        location.reload(true);
                    });
                },1000);
            } else {
                alert("Debe ingresar el avión para la Ruta " + RUT_num_vuelo);
            }
        }

        function sendItinerario(url){
            var envio = confirm('Advertencia: Se procederá a ralizar la programación correspondiente a este itinerario. ¿Estas seguro de enviarlo (SI [ok] / NO [cancelar])?.');
            if (envio){
                //var url = "<?php echo URLLOGICA?>itinerario/enviarAprobItinerario/";
                $("#preloader").css("display","block");
                var parametros = {
                    "ITI_fchini" : $("#ITI_fchini").val(),
                    "ITI_fchfin" : $("#ITI_fchfin").val()
                };
                $.post(url,parametros,
                function(data){
                    if(data == ""){
                        alert("Hubo un error al cargar la información.");
                    } else {
                        //ejecucionMotorView();
                        //guardarExcelItiServidorView($("#ITI_fchini").val(),$("#ITI_fchfin").val());
                        $('#itinerarioRegistro').modal('hide');
                        $("#preloader").css("display","none");
                        /*setTimeout(function(){
                            location.reload(true);
                        },1500);*/
                    }
                });
            } else {
                return false;
            }
        }

        function listarDetItinerario(url,ITI_fchini,ITI_fchfin,RUT_num_vuelo,accion,valor){
            $("#preloader").css("display","block");
            var parametros = {
                "ITI_fchini" : ITI_fchini,
                "ITI_fchfin" : ITI_fchfin,
                "RUT_num_vuelo" : RUT_num_vuelo
            };

            $.post(url,parametros,
            function(data){
                if(data == ""){
                    alert("No hay información de esa Ruta.");
                    limpiarListado()
                    $("#preloader").css("display", "none");
                } else {
                    $("#titleForm").text("Detalle de Itinerario");

                    if(accion == 'listar'){
                        listarRutaxDia(ITI_fchini,'ver');
                    } else {
                        listarRutaxDia(ITI_fchini,'insert');
                    }

                    setTimeout(function(){
                        for (var j = 1; j <= $("#objRuta").val(); j++) {
                            $("#RUT_num_vuelo" + j).removeAttr("checked");
                            for (var i = 1; i <= data.length; i++){
                                if($("#RUT_num_vuelo" + j).val() == data[i-1]["RUT_num_vuelo"]){
                                    $("#AVI_id" + j).val(data[i-1]["AVI_id"]).trigger('change.select2');
                                    $("#RUT_num_vuelo" + j).prop("checked","true");
                                    break;
                                }
                            }
                        }
                        setTimeout(function(){
                            $("#preloader").css("display", "none");
                        },1000);
                    },1500);

                    $("#ITI_fchVisualizada").val(ITI_fchini);
                    if(RUT_num_vuelo != ""){
                        $("#tbody_objRutaxFecha").hide();
                        $("#tbody_objRuta").empty();
                        $("#ITI_fchVisualizada").val("");

                        for (var k = 0; k < data.length; k++) {

                            html = '<tr>'
                                    + '<td style="width:auto;">' + data[k]["AVI_num_cola"] + '</td>'
                                    + '<td style="width:auto;">' + data[k]["ITI_fch"] + '</td>'
                                    + '</td>'
                                    + '<td style="width:auto;">' + data[k]["RUT_num_vuelo"] + '</td>'
                                    + '<td style="width:auto;">' + data[k]["CIU_id_origen"]
                                        + '<input type="hidden" name="CIU_id_origen' + (k+1) + '" id="CIU_id_origen' + (k+1) + '" value="' + data[k]["CIU_id_origen"] + '" />'
                                    + '</td>'
                                    + '<td style="width:auto;">' + data[k]["CIU_id_destino"]
                                        + '<input type="hidden" name="CIU_id_destino' + (k+1) + '" id="CIU_id_destino' + (k+1) + '" value="' + data[k]["CIU_id_destino"] + '" />'
                                    + '</td>'
                                    + '<td style="width:auto;">' + data[k]["RUT_hora_salida"]
                                        + '<input type="hidden" name="RUT_hora_salida' + (k+1) + '" id="RUT_hora_salida' + (k+1) + '" value="' + data[k]["RUT_hora_salida"] + '" />'
                                    + '</td>'
                                    + '<td style="width:auto;">' + data[k]["RUT_hora_llegada"]
                                        + '<input type="hidden" name="RUT_hora_llegada' + (k+1) + '" id="RUT_hora_llegada' + (k+1) + '" value="' + data[k]["RUT_hora_llegada"] + '" />'
                                    + '</td>'
                                + '</tr>';
                            $("#tbody_objRuta").append(html);
                            $(document).ready(function() { $(".js-example-basic-single_extra").select2(); });
                        }
                    }
                    else {
                        $("#tbody_objRutaxFecha").show();
                        $("#tbody_objRuta").empty();
                    }

                    if(valor != "listadoxDia"){

                        $("#ITI_fchini").val(ITI_fchini);
                        $("#ITI_fchfin").val(ITI_fchfin);

                        $("#ITI_fchVisualizadaDate").datetimepicker('destroy');
                        var result = ITI_fchini.split('/');
                        var result2 = ITI_fchfin.split('/');
                        $("#ITI_fchVisualizadaDate").datetimepicker({
                            format: 'DD/MM/YYYY',
                            minDate: result[1] + '/' + result[0] + '/' + result[2],
                            maxDate: result2[1] + '/' + result2[0] + '/' + result2[2]
                        });
                    }

                    $("#AUD_usu_cre").val(data[0]["AUD_usu_cre"]);
                    $("#AUD_fch_cre").val(data[0]["AUD_fch_cre"]);
                    $("#AUD_usu_mod").val(data[0]["AUD_usu_mod"]);
                    $("#AUD_fch_mod").val(data[0]["AUD_fch_mod"]);
                    if(accion == "listar"){
                        $("#accion").val('listar');
                        //if($("#ITI_proceso").val() != "ENVIADO"){
                        if(data[0]["ITI_proceso"] != "ENVIADO"){
                            $("#sendItinerario").removeAttr("disabled");
                        } else {
                            //$("#sendItinerario").prop("disabled","disabled");
                        }
                        verFormItinerario();
                    }
                    else {
                        $("#ITI_fchini").prop("disabled","disabled");
                        $("#ITI_fchfin").prop("disabled","disabled");
                        $("#ITI_fchini").css("background", "#EEEEEE");
                        $("#ITI_fchfin").css("background", "#EEEEEE");

                        $("#divITI_fchVisualizada").css("display","block");
                        $("#divITI_fchListar").css("display","block");

                        $("#accion").val('modificar');

                        $("#insertItinerario").hide();
                        $("#sendItinerario").hide();
                        $("#updateItinerario").show();
                    }
                }
            });
        }

        function listarDetItinerarioxFch(url){
            var RUT_num_vuelo = $("#bRUT_num_vuelo").val();
            var ITI_fchVisualizada = $("#ITI_fchVisualizada").val();

            if (RUT_num_vuelo != ""){
                var ITI_fchini = $("#ITI_fchini").val();
                var ITI_fchfin = $("#ITI_fchfin").val();
                $("#ITI_fchVisualizada").val("");
            }
            if(ITI_fchVisualizada != "") {
                var ITI_fchini = $("#ITI_fchVisualizada").val();
                var ITI_fchfin = $("#ITI_fchVisualizada").val();
                $("#bRUT_num_vuelo").val("").trigger('change.select2');
            }

            var accion = $("#accion").val();
            var valor = 'listadoxDia';

            listarDetItinerario(url,ITI_fchini,ITI_fchfin,RUT_num_vuelo,accion,valor)
        }

        function closeItinerarioRegistroxFecha(){
            $('#itinerarioRegistroxFecha').modal('hide');
        }

        $("#ITI_fchiniDate").on("dp.change", function (e) {
            var select = $("#ITI_fchfinDate");
            var fchIni = $("#ITI_fchini").val();
            validarFechaContinua(select,fchIni);
            $("#ITI_fchfin").removeAttr("disabled");
            $("#ITI_fchfin").css("background", "#FFFFFF");
            listarRutaxDia(fchIni,'insert');
        });
        $('#itinerarioRegistro').on('show.bs.modal', function (e) {
            $("#updateItinerario").hide();
            $("#updateItinerario_m").hide();
            $("#sendItinerario").hide();
        })
        $('#itinerarioRegistro').on('hidden.bs.modal', function (e) {
            limpiarFormItinerario();
        })

        function resetFormItinerario(url){
            window.location.href = url;
        }
        
        function mostrarMsjEstadoIti(){
            $('[data-toggle="tooltip"]').tooltip();
        }
    </script>
    <!-- /.content-wrapper -->
    <?php include "footer_view.php";?>
