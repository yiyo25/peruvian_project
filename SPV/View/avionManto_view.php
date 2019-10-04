<?php include "header_view.php";?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
				Aviones en mantenimiento<small></small>
            </h1>
            <ol class="breadcrumb">
                <li><i class="fa fa-thumb-tack"></i> Avión en Mantenimiento</li>
                <li class="active">
                    Listado de Aviones en Mantenimiento
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
                        <form method="post" action="<?php echo URLLOGICA?>avion/buscarMantoAvion/" onsubmit="document.forms['buscar']['buscar'].disabled=true;" name="buscar">
                            <div class="row-fluid">
                                <div class="form-group">
                                    <label for="bTIPAVI_id" class="col-md-2 control-label">Tipo de Avión</label>
                                    <div class="col-md-2">
                                        <select name="bTIPAVI_id" id="bTIPAVI_id" class="form-control input-sm js-example-basic-single" >
                                            <option value="" selected>Tipo Avión</option>
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
                                    <label for="bAVI_id" class="col-md-2 control-label">N° de Cola</label>
                                    <div class="col-md-2">
                                        <select name="bAVI_id" id="bAVI_id" class="form-control input-sm js-example-basic-single" >
                                            <option value="" selected>Seleccionar N° de Cola</option>
                                        <?php foreach($this->objAvion as $lista){ ?>
                                            <?php $selected = "";?>
                                            <?php if(isset($_SESSION["AVI_id"])) { ?>
                                                <?php if($_SESSION["AVI_id"] == $lista["AVI_id"]) { ?>
                                                    <?php $selected = "selected";?>
                                                <?php } ?>
                                            <?php } ?>
                                            <option value="<?php echo $lista["AVI_id"];?>" <?php echo $selected;?>><?php echo ($lista["AVI_num_cola"]);?></option>
                                        <?php } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="form-group">
                                <div class="form-group">
                                    <label for="bAVI_fch_Mes" class="col-md-2 control-label">Mes de Mantenimiento.</label>
                                    <div class="col-md-2">
                                        <select name="bAVI_fch_Mes" id="bAVI_fch_Mes" class="form-control input-sm js-example-basic-single" >
                                            <option value="" selected>Seleccionar Mes</option>
                                        <?php foreach($this->objMes as $lista){ ?>
                                            <?php $selected = "";?>
                                            <?php if(isset($_SESSION["AVI_fch_Mes"])) { ?>
                                                <?php if($_SESSION["AVI_fch_Mes"] == $lista["MES_id"]) { ?>
                                                    <?php $selected = "selected";?>
                                                <?php } ?>
                                            <?php } ?>
                                            <option value="<?php echo $lista["MES_id"];?>" <?php echo $selected;?>><?php echo utf8_encode(($lista["MES_descripcion"]));?></option>
                                        <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="bAVI_fch_Anio" class="col-md-2 control-label">Año de Mantenimiento.</label>
                                    <div class="col-md-2">
                                        <select name="bAVI_fch_Anio" id="bAVI_fch_Anio" class="form-control input-sm js-example-basic-single" >
                                            <option value="" selected>Seleccionar Año</option>
                                        <?php foreach($this->objAnio as $lista){ ?>
                                            <?php $selected = "";?>
                                            <?php if(isset($_SESSION["AVI_fch_Anio"])) { ?>
                                                <?php if($_SESSION["AVI_fch_Anio"] == $lista["ANIO_descripcion"]) { ?>
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
                                <button type="button" name="limpiar" class="btn btn-danger btn-block" onclick="resetFormMantoAvion('<?php echo URLLOGICA?>avion/listarResumenMantoAvion/');"> Limpiar </button>
                            </div>
                            <div class="clearfix" style="padding: 5px;"></div>
                    </div>
                    <div id="MainContent_listaPro" class="panel panel-default">
                        <div class="panel-heading clearfix" style="padding: 4px !important">
                            <span id="MainContent_tituloPro"><strong>Lista de Aviones en Mantenimiento</strong></span>
                            <?php  $Bdisabled = 0; ?>
                            <?php foreach ($this->objBotton as $botton) { ?>
                                <?php if($botton["Funcion"] == "insertMantoAvion"){ ?>
                                    <?php  $Bdisabled += 1; ?>
                                <?php } ?>
                            <?php } ?>
                            <?php if($Bdisabled > 0){ $disabled = ""; } else { $disabled = "disabled"; } ?>
                                <button type="button" class="pull-right fa fa-plane" data-toggle="modal" data-target="#avionMantoRegistro" <?php echo $disabled;?>></button>
                        </div>
                        <div class="area_resultado table-responsive">
                            <table id="listaMantoAvion" class="display myDataTables" cellspacing="0" cellpadding="2">
                                <thead>
                                    <tr>
                                        <th scope="col">Item</th>
                                        <th scope="col">Mes de Mantenimiento</th>
                                        <th scope="col">Cant. Avión</th>
                                        <th scope="col">Ver</th>
                                        <th scope="col">Envío Correo</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (count($this->objMantoAvion) > 0) { ?>
                                        <?php $item = 1; ?>
                                        <?php foreach ($this->objMantoAvion as $lista) { ?>
                                    <tr>
                                        <td style="width:auto;"><?php echo $item;?></td>
                                        <td style="width:auto;"><?php echo $lista["AVI_fch_Mes"];?></td>
                                        <td style="width:auto;"><?php echo $lista["AVI_afectados"];?></td>
                                        <td style="width:auto;">
                                            <?php  $Bdisabled = 0; ?>
                                            <?php foreach ($this->objBotton as $botton) { ?>
                                                <?php if($botton["Funcion"] == "listarMantoAvion"){ ?>
                                                    <?php  $Bdisabled += 1; ?>
                                                <?php } ?>
                                            <?php } ?>
                                            <?php if($Bdisabled > 0){ $disabled = ""; } else { $disabled = "disabled"; } ?>
                                                <button type="button" class="fa fa-eye" data-toggle="modal" data-target="#avionMantoDetalle" onclick="listarMantoAvion(<?php echo $lista["MANTAVI_fchiniMes"];?>,<?php echo $lista["MANTAVI_fchiniAnio"];?>,<?php echo $lista["MANTAVI_fchfinMes"];?>,<?php echo $lista["MANTAVI_fchfinAnio"];?>)" <?php echo $disabled;?>></button>
                                        </td>
                                        <td style="width:auto;">
                                            <?php  $Bdisabled = 0; ?>
                                            <?php foreach ($this->objBotton as $botton) { ?>
                                                <?php if($botton["Funcion"] == "listarMantoAvion"){ ?>
                                                    <?php  $Bdisabled += 1; ?>
                                                <?php } ?>
                                            <?php } ?>
                                            <?php if($Bdisabled > 0){ $disabled = ""; } else { $disabled = "disabled"; } ?>
                                                <button type="button" class="fa fa-envelope" onclick="enviarCorreoMantoAvion(<?php echo $lista["MANTAVI_fchiniMes"];?>,<?php echo $lista["MANTAVI_fchiniAnio"];?>,<?php echo $lista["MANTAVI_fchfinMes"];?>,<?php echo $lista["MANTAVI_fchfinAnio"];?>);" <?php echo $disabled;?>></button>
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
    <div id="avionMantoRegistro" class="modal fade" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content ">
                <div class="modal-header" style="padding: 10px !important">
                    <table class="col-xs-12">
                        <tr>
                            <td style="text-align:left;">
                                <h4><strong id="titleForm">Ingresar Nuevo Mantenimiento Avión</strong></h4>
                            </td>
                            <td>
                                <button type="button" class="close btn-lg" data-dismiss="modal" onclick="limpiarFormMantoAvion();" style="background-color: red; color:white; margin:10px; padding: 0px 6px 2px 6px;text-align:right;">
                                    <span aria-hidden="true">&times;</span><span class="sr-only">Cerrar</span>
                                </button>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="modal-body" style="padding-bottom: 10px;">
                    <div class="row">
                        <div class="col-md-12" style="padding-bottom: 10px;">
                            <label for="TIPAVI_id" class="col-md-5 control-label">Tipo de Avión:
                            <span style="color: #FF0000"><strong>*</strong></span></label>
                            <div class="col-md-7">
                               <input type="hidden" name="MANTAVI_id" id="MANTAVI_id" value="" class="form-control input-sm"/>
                                <select name="TIPAVI_id" id="TIPAVI_id" class="form-control input-sm js-example-basic-single" >
                                    <option value="" selected>Seleccionar Tipo Avión</option>
                                <?php foreach($this->objTipoAvion as $lista){ ?>
                                    <option value="<?php echo $lista["TIPAVI_id"];?>"><?php echo ($lista["TIPAVI_modelo"]."-".$lista["TIPAVI_serie"]);?></option>
                                <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12" style="padding-bottom: 10px;">
                            <label for="AVI_num_cola" class="col-md-5 control-label">N° de Cola:
                            <span style="color: #FF0000"><strong>*</strong></span></label>
                            <div class="col-md-7">
                                <select name="AVI_id" id="AVI_id" class="form-control input-sm js-example-basic-single" >
                                    <option value="" selected>Seleccionar N° de Cola</option>
                                <?php foreach($this->objAvion as $lista){ ?>
                                    <option class="<?php echo $lista["TIPAVI_id"];?>" value="<?php echo $lista["AVI_id"];?>"><?php echo ($lista["AVI_num_cola"]);?></option>
                                <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12" style="padding-bottom: 10px;">
                            <label for="MANTAVI_fchini" class="col-md-5 control-label">Fch. de Inicio
                            <span style="color: #FF0000"><strong>*</strong></span></label>
                            <div class="col-md-7">
                                <div class='input-group date datetimepicker1' id="MANTAVI_fchiniDate">
                                    <input type="text" name="MANTAVI_fchini" id="MANTAVI_fchini" class="form-control input-sm" style="text-transform: uppercase; width: 100% !important;" />
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12" style="padding-bottom: 10px;">
                            <label for="MANTAVI_fchfin" class="col-md-5 control-label">Fch. de Fin
                            <span style="color: #FF0000"><strong>*</strong></span></label>
                            <div class="col-md-7">
                                <div class='input-group date datetimepicker1' id="MANTAVI_fchfinDate">
                                    <input type="text" name="MANTAVI_fchfin" id="MANTAVI_fchfin" class="form-control input-sm" style="text-transform: uppercase; width: 100% !important;" disabled="disabled" />
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12" style="padding-bottom: 10px;">
                            <label for="MANTAVI_tipoChequeo" class="col-md-5 control-label">Tipo de Chequeo
                            <span style="color: #FF0000"><strong>*</strong></span></label>
                            <div class="col-md-7">
                                <input type="text" name="MANTAVI_tipoChequeo" id="MANTAVI_tipoChequeo" class="form-control input-sm" style="text-transform: uppercase; width: 100% !important;" />
                            </div>
                        </div>
                        <div class="col-md-12" style="padding-bottom: 10px;">
                            <label for="MANTAVI_ordenTrabajo" class="col-md-5 control-label">Orden de Trabajo
                            <span style="color: #FF0000"><strong>*</strong></span></label>
                            <div class="col-md-7">
                               <textarea name="MANTAVI_ordenTrabajo" id="MANTAVI_ordenTrabajo" rows="5" cols="40" class="form-control input-sm" style="text-transform: uppercase;" ></textarea>
                                <!--<input type="text" name="MANTAVI_ordenTrabajo" id="MANTAVI_ordenTrabajo" class="form-control input-sm" style="text-transform: uppercase; width: 100% !important;" autofocus/>-->
                            </div>
                        </div>
                        <div class="col-md-12" style="padding-bottom: 10px;">
                            <label for="MANTAVI_observacion" class="col-md-5 control-label">Observación</label>
                            <div class="col-md-7">
                                <input type="text" name="MANTAVI_observacion" id="MANTAVI_observacion" class="form-control input-sm" style="text-transform: uppercase; width: 100% !important;" />
                            </div>
                        </div>
                        <div class="col-md-12" style="padding-bottom: 10px; display:none;" id="divAUD_usu_cre">
                            <label for="AUD_usu_cre" class="col-md-5 control-label">Usuario de Creación:
                            <span style="color: #FF0000"><strong>*</strong></span></label>
                            <div class="col-md-7">
                               <input type="text" name="AUD_usu_cre" id="AUD_usu_cre" class="form-control input-sm numberDecimal" style="text-transform: uppercase; width: 100% !important;" />
                            </div>
                        </div>
                        <div class="col-md-12" style="padding-bottom: 10px; display:none;" id="divAUD_fch_cre">
                            <label for="AUD_fch_cre" class="col-md-5 control-label">Fecha de Creación:
                            <span style="color: #FF0000"><strong>*</strong></span></label>
                            <div class="col-md-7">
                               <input type="text" name="AUD_fch_cre" id="AUD_fch_cre" class="form-control input-sm numberDecimal" style="text-transform: uppercase; width: 100% !important;" />
                            </div>
                        </div>
                        <div class="col-md-12" style="padding-bottom: 10px; display:none;" id="divAUD_usu_mod">
                            <label for="AUD_usu_mod" class="col-md-5 control-label">Usuario de Mod.:
                            <span style="color: #FF0000"><strong>*</strong></span></label>
                            <div class="col-md-7">
                               <input type="text" name="AUD_usu_mod" id="AUD_usu_mod" class="form-control input-sm numberDecimal" style="text-transform: uppercase; width: 100% !important;" />
                            </div>
                        </div>
                        <div class="col-md-12" style="padding-bottom: 10px; display:none;" id="divAUD_fch_mod">
                            <label for="AUD_fch_mod" class="col-md-5 control-label">Fecha de Mod.:
                            <span style="color: #FF0000"><strong>*</strong></span></label>
                            <div class="col-md-7">
                               <input type="text" name="AUD_fch_mod" id="AUD_fch_mod" class="form-control input-sm numberDecimal" style="text-transform: uppercase; width: 100% !important;" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer" style="padding: 10px !important">
                    <button name='insertMantoAvion' id='insertMantoAvion' type="button" class="btn btn-sm" onclick="insertMantoAvion('<?php echo URLLOGICA?>avion/insertMantoAvion/');">Grabar</button>
                    <button name='updateMantoAvion' id='updateMantoAvion' type="button" class="btn btn-sm" onclick="updateMantoAvion('<?php echo URLLOGICA?>avion/updateMantoAvion/');">Modificar</button>
                    <button name="closeMantoAvion" id="closeMantoAvion" type="button" class="btn btn-danger btn-sm" data-dismiss="modal" onclick="limpiarFormMantoAvion();">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
    
    <div id="avionMantoDetalle" class="modal fade" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content modal-lg">
                <div class="modal-header" style="padding: 10px !important">
                    <table class="col-xs-12">
                        <tr>
                            <td style="text-align:left;">
                                <h4><strong id="titleForm">Detalle de Mantenimiento de Avión</strong></h4>
                            </td>
                            <td>
                                <button type="button" class="close btn-lg" data-dismiss="modal" onclick="limpiarFormMantoAvion();" style="background-color: red; color:white; margin:10px; padding: 0px 6px 2px 6px;text-align:right;">
                                    <span aria-hidden="true">&times;</span><span class="sr-only">Cerrar</span>
                                </button>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="modal-body" style="padding-bottom: 10px;">
                    <div class="area_resultado table-responsive">
                        <table id="listaDetMantoAvion" class="display" cellspacing="0" cellpadding="2">
                            <thead>
                                <tr>
                                    <th scope="col">Item</th>
                                    <th scope="col">Tipo de Avión</th>
                                    <th scope="col">N° de Cola</th>
                                    <th scope="col">Fch. Mantenimiento Ini  </th>
                                    <th scope="col">Fch. Mantenimiento Fin</th>
                                    <th scope="col">Fch. Registro</th>
                                    <th scope="col">Ver</th>
                                    <th scope="col">Editar</th>
                                </tr>
                            </thead>
                            <tbody id="listaMantoDetAvion">
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
            $("#AVI_id").chained("#TIPAVI_id");
        });
        
        function listarComboAvionView(){
            listarComboAvion('<?php echo URLLOGICA?>avion/listarDetAvion/');
        }
        
        $("#MANTAVI_fchiniDate").on("dp.change", function (e) {
            var select = $("#MANTAVI_fchfinDate");
            var fchIni = $("#MANTAVI_fchini").val();
            validarFechaContinua(select,fchIni);
            $("#MANTAVI_fchfin").removeAttr("disabled");
        });
        
        function listarMantoAvion(MANTAVI_fchiniMes,MANTAVI_fchiniAnio,MANTAVI_fchfinMes,MANTAVI_fchfinAnio){
            var url = "<?php echo URLLOGICA?>avion/listarMantoAvion/";
            $("#preloader").css("display","block");
            var parametros = {
                "MANTAVI_fchiniMes" : MANTAVI_fchiniMes,
                "MANTAVI_fchiniAnio" : MANTAVI_fchiniAnio,
                "MANTAVI_fchfinMes" : MANTAVI_fchfinMes,
                "MANTAVI_fchfinAnio" : MANTAVI_fchfinAnio,
            };
            $.post(url,parametros,
            function(data){
                if(data == ""){
                    alert("Hubo un error al cargar la información.");
                } else {
                    $("#listaMantoDetAvion").empty();
                    
                    for (var i = 1; i <= data.length; i++) {
                    html = '<tr>'
                            + '<input type="hidden" name="MANTAVI_fchiniMes" id="MANTAVI_fchiniMes" value="' + MANTAVI_fchiniMes + '" class="form-control input-sm"/>'
                            + '<input type="hidden" name="MANTAVI_fchiniAnio" id="MANTAVI_fchiniAnio" value="' + MANTAVI_fchiniAnio + '" class="form-control input-sm"/>'
                            + '<input type="hidden" name="MANTAVI_fchfinMes" id="MANTAVI_fchfinMes" value="' + MANTAVI_fchfinMes + '" class="form-control input-sm"/>'
                            + '<input type="hidden" name="MANTAVI_fchfinAnio" id="MANTAVI_fchfinAnio" value="' + MANTAVI_fchfinAnio + '" class="form-control input-sm"/>'
                            + '<td style="width:auto;">' + i + '</td>'
                            + '<td style="width:auto;">' + data[i-1]["TIPAVI_modelo"] + ' ' + data[i-1]["TIPAVI_serie"] + '</td>'
                            + '<td style="width:auto;">' + data[i-1]["AVI_num_cola"] + '</td>'
                            + '<td style="width:auto;">' + data[i-1]["MANTAVI_fchini"] + '</td>'
                            + '<td style="width:auto;">' + data[i-1]["MANTAVI_fchfin"] + '</td>'
                            + '<td style="width:auto;">' + data[i-1]["AUD_fch_cre"] + '</td>'
                            + '<td style="width:auto;">'
                                <?php  $Bdisabled = 0; ?>
                                <?php foreach ($this->objBotton as $botton) { ?>
                                    <?php if($botton["Funcion"] == "listarDetMantoAvion"){ ?>
                                        <?php  $Bdisabled += 1; ?>
                                    <?php } ?>
                                <?php } ?>
                                <?php if($Bdisabled > 0){ $disabled = ""; } else { $disabled = "disabled"; } ?>
                                    + '<button type="button" class="fa fa-eye" data-toggle="modal" data-target="#avionMantoRegistro" onclick="listarDetMantoAvion(\'<?php echo URLLOGICA?>avion/listarMantoAvion/\',' + data[i-1]["MANTAVI_id"] + ',\'listar\')" <?php echo $disabled;?>></button>'
                            + '</td>'
                            + '<td style="width:auto;">'
                                <?php  $Bdisabled = 0; ?>
                                <?php foreach ($this->objBotton as $botton) { ?>
                                    <?php if($botton["Funcion"] == "updateDetMantoAvion"){ ?>
                                        <?php  $Bdisabled += 1; ?>
                                    <?php } ?>
                                <?php } ?>
                                <?php if($Bdisabled > 0){ $disabled = ""; } else { $disabled = "disabled"; } ?>
                                    + '<button type="button" class="fa fa-pencil" data-toggle="modal" data-target="#avionMantoRegistro" onclick="listarDetMantoAvion(\'<?php echo URLLOGICA?>avion/listarMantoAvion/\',' + data[i-1]["MANTAVI_id"] + ',\'modificar\')" <?php echo $disabled;?>></button>'
                            + '</td>'
                        + '</tr>';
                        $("#listaMantoDetAvion").append(html);
                    };
                    myDataTables('listaDetMantoAvion');
                    $("#preloader").css("display", "none");
                }
            });
        }
        
        function enviarCorreoMantoAvion(MANTAVI_fchiniMes,MANTAVI_fchiniAnio,MANTAVI_fchfinMes,MANTAVI_fchfinAnio){
            var envio = confirm('Advertencia: Se enviará el Correo informativo de Mantenimeitno de Aviones. ¿Estas seguro de enviarlo (SI [ok] / NO [cancelar])?.');
            if (envio){
                var url = "<?php echo URLLOGICA?>avion/enviarCorreoMantoAvion/";
                $("#preloader").css("display","block");
                var parametros = {
                    "MANTAVI_fchiniMes" : MANTAVI_fchiniMes,
                    "MANTAVI_fchiniAnio" : MANTAVI_fchiniAnio,
                    "MANTAVI_fchfinMes" : MANTAVI_fchfinMes,
                    "MANTAVI_fchfinAnio" : MANTAVI_fchfinAnio,
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
