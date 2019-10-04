<?php include "header_view.php";?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
				Gestionar de Ruta <small>Administrar Ruta</small>
            </h1>
            <ol class="breadcrumb">
                <li><i class="fa fa-thumb-tack"></i> Rutas</li>
                <li class="active">
                    Listado de Rutas
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
                        <form method="post" action="<?php echo URLLOGICA?>ruta/buscarRuta/" onsubmit="document.forms['buscar']['buscar'].disabled=true;" name="buscar">
                            <div class="row-fluid">
                                <div class="form-group">
                                    <label for="bRUT_num_vuelo" class="col-md-2 control-label">N° de Ruta</label>
                                    <div class="col-md-2">
                                        <select name="bRUT_num_vuelo" id="bRUT_num_vuelo" class="form-control input-sm js-example-basic-single" >
                                            <option value="" selected>N° de Ruta</option>
                                        <?php foreach($this->objRuta as $lista){ ?>
                                            <?php $selected = "";?>
                                            <?php if(isset($_SESSION["bRUT_num_vuelo"])) { ?>
                                                <?php if($_SESSION["bRUT_num_vuelo"] == $lista["RUT_num_vuelo"]) { ?>
                                                    <?php $selected = "selected";?>
                                                <?php } ?>
                                            <?php } ?>
                                            <option value="<?php echo $lista["RUT_num_vuelo"];?>" <?php echo $selected;?>><?php echo ($lista["RUT_num_vuelo"]);?></option>
                                        <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="bCIU_id_origen" class="col-md-2 control-label">Ciudad Origen</label>
                                    <div class="col-md-2">
                                        <input type="text" name="bCIU_id_origen" id="bCIU_id_origen" value="<?php if(isset($_SESSION["bCIU_id_origen"])) { echo $_SESSION["bCIU_id_origen"]; } else { echo ""; }?>" class="form-control input-sm" style="text-transform: uppercase;" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="bCIU_id_destino" class="col-md-2 control-label">Ciudad Destino</label>
                                    <div class="col-md-2">
                                        <input type="text" name="bCIU_id_destino" id="bCIU_id_destino" value="<?php if(isset($_SESSION["bCIU_id_destino"])) { echo $_SESSION["bCIU_id_destino"]; } else { echo ""; }?>" class="form-control input-sm" style="text-transform: uppercase;" />
                                    </div>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="form-group">
                                <div class="row-fluid">
                                    <div class="form-group">
                                        <div class="col-md-2 col-md-offset-8">
                                            <input type="submit" name="buscar" value="Buscar" class="btn btn-danger btn-block" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                            <div class="col-md-2">
                                <button type="button" name="limpiar" class="btn btn-danger btn-block" onclick="resetFormRuta('<?php echo URLLOGICA?>ruta/listarRuta/');"> Limpiar </button>
                            </div>
                            <div class="clearfix" style="padding: 4px;"></div>
                    </div>
                    <div id="MainContent_listaPro" class="panel panel-default">
                        <div class="panel-heading clearfix" style="padding: 5px !important">
                            <span id="MainContent_tituloPro"><strong>Lista de Rutas</strong></span>
                            <?php  $Bdisabled = 0; ?>
                            <?php foreach ($this->objBotton as $botton) { ?>
                                <?php if($botton["Funcion"] == "insertRuta"){ ?>
                                    <?php  $Bdisabled += 1; ?>
                                <?php } ?>
                            <?php } ?>
                            <?php if($Bdisabled > 0){ $disabled = ""; } else { $disabled = "disabled"; } ?>
                                <button type="button" class="pull-right fa fa-handshake-o" data-toggle="modal" data-target="#rutaRegistro" <?php echo $disabled;?>></button>
                        </div>
                        <div class="area_resultado table-responsive">
                            <table id="listaRuta" class="display myDataTables" cellspacing="0" cellpadding="2">
                                <thead>
                                    <tr>
                                        <th scope="col">Item</th>
                                        <th scope="col">N° Ruta</th>
                                        <th scope="col">Ruta</th>
                                        <th scope="col">Origen</th>
                                        <th scope="col">Destino</th>
                                        <th scope="col">Ver</th>
                                        <th scope="col">Editar</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (count($this->objResumenRuta) > 0) { ?>
                                        <?php $item = 1; ?>
                                        <?php foreach ($this->objResumenRuta as $lista) { ?>
                                    <tr>
                                        <td style="width:auto;"><?php echo $item;?></td>
                                        <td style="width:auto;"><?php echo $lista["RUT_num_vuelo"];?></td>
                                        <td style="width:auto;"><?php echo $lista["CIU_id_origen"]."-".$lista["CIU_id_destino"];?></td>
                                        <td style="width:auto;"><?php echo $lista["CIU_nombre_o"];?></td>
                                        <td style="width:auto;"><?php echo $lista["CIU_nombre_d"];?></td>
                                        <td style="width:auto;">
                                            <?php  $Bdisabled = 0; ?>
                                            <?php foreach ($this->objBotton as $botton) { ?>
                                                <?php if($botton["Funcion"] == "listarRuta"){ ?>
                                                    <?php  $Bdisabled += 1; ?>
                                                <?php } ?>
                                            <?php } ?>
                                            <?php if($Bdisabled > 0){ $disabled = ""; } else { $disabled = "disabled"; } ?>
                                                <button type="button" class="fa fa-eye" data-toggle="modal"  data-target="#rutaRegistro" onclick="listarDetRuta('<?php echo URLLOGICA?>ruta/listarDetRuta/','<?php echo $lista["RUT_relacion"];?>','listar')" <?php echo $disabled;?>></button>
                                        </td>
                                        <td style="width:auto;">
                                            <?php  $Bdisabled = 0; ?>
                                            <?php foreach ($this->objBotton as $botton) { ?>
                                                <?php if($botton["Funcion"] == "updateRuta"){ ?>
                                                        <?php  $Bdisabled += 1; ?>
                                                <?php }?>
                                            <?php } ?>
                                            <?php if($Bdisabled > 0){ $disabled = ""; } else { $disabled = "disabled"; } ?>
                                                <button type="button" class="fa fa-pencil" data-toggle="modal" data-target="#rutaRegistro" onclick="listarDetRuta('<?php echo URLLOGICA?>ruta/listarDetRuta/','<?php echo $lista["RUT_relacion"];?>','modificar')" <?php echo $disabled;?>></button>
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
    <div id="rutaRegistro" class="modal fade" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header" style="padding: 10px !important">
                    <table class="col-xs-12">
                        <tr>
                            <td style="text-align:left;">
                                <h4><strong id="titleForm">Ingresar Nueva Ruta</strong></h4>
                            </td>
                            <td>
                                <button type="button" class="close btn-lg" data-dismiss="modal" onclick="limpiarFormRuta();" style="background-color: red; color:white; margin:10px; padding: 0px 6px 2px 6px;text-align:right;">
                                    <span aria-hidden="true">&times;</span><span class="sr-only">Cerrar</span>
                                </button>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="modal-body" style="padding-bottom: 10px !important">
                    <div class="row">
                        <div class="col-md-12" style="padding-bottom: 10px;">
                            <input type="hidden" name="RUT_num_vueloIDAhidden" id="RUT_num_vueloIDAhidden" value="" />
                            <input type="hidden" name="RUT_num_vueloVUELTAhidden" id="RUT_num_vueloVUELTAhidden" value="" />
                            <input type="hidden" name="RUT_ordenIDA" id="RUT_ordenIDA" value="" />
                            <input type="hidden" name="RUT_ordenVUELTA" id="RUT_ordenVUELTA" value="" />
                            <label for="RUT_num_vuelo" class="col-md-5 control-label">N° de Ruta: (IDA / VUELTA)
                            <span style="color: #FF0000"><strong>*</strong></span></label>
                            <div class="col-md-3">
                                <input type="text" name="RUT_num_vueloIDA" id="RUT_num_vueloIDA" class="form-control input-sm numberEntero" style="text-transform: uppercase; width: 100% !important;" autofocus />
                            </div>
                            <label for="" class="col-md-1 control-label">/</label>
                            <div class="col-md-3">
                                <input type="text" name="RUT_num_vueloVUELTA" id="RUT_num_vueloVUELTA" class="form-control input-sm numberEntero" style="text-transform: uppercase; width: 100% !important;" />
                            </div>
                        </div>
                        <!--<div class="col-md-12" style="padding-bottom: 10px;">
                            <label for="RUT_escala" class="col-md-5 control-label">¿Ruta con escala?:
                            <span style="color: #FF0000"><strong>*</strong></span></label>
                            <div class="col-xs-6 col-md-3">
                                <input type="radio" id="RUT_escala_Si" name="RUT_escala" value="Si"> Si
                            </div>
                            <div class="col-xs-6 col-md-3">
                                <input type="radio" id="RUT_escala_No" name="RUT_escala" value="No" checked> No
                            </div>
                        </div>-->
                        <div class="col-md-12" style="padding-bottom: 10px;">
                            <label for="CIU_id_origen" class="col-md-5 control-label">Ciudad de Origen:
                            <span style="color: #FF0000"><strong>*</strong></span></label>
                            <div class="col-md-7">
                                <select name="CIU_id_origen" id="CIU_id_origen" class="form-control input-sm js-example-basic-single" >
                                    <option value="" selected>Seleccionar Ciudad</option>
                                <?php foreach($this->objCiudad as $lista){ ?>
                                    <option value="<?php echo $lista["CIU_id"];?>"><?php echo utf8_encode($lista["CIU_nombre"]);?></option>
                                <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12" style="padding-bottom: 10px;">
                            <label for="CIU_id_destino" class="col-md-5 control-label">Ciudad de Destino:
                            <span style="color: #FF0000"><strong>*</strong></span></label>
                            <div class="col-md-7">
                                <select name="CIU_id_destino" id="CIU_id_destino" class="form-control input-sm js-example-basic-single" >
                                    <option value="" selected>Seleccionar Ciudad</option>
                                <?php foreach($this->objCiudad as $lista){ ?>
                                    <option value="<?php echo $lista["CIU_id"];?>"><?php echo utf8_encode($lista["CIU_nombre"]);?></option>
                                <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12" style="padding-bottom: 5px;">
                            <label for="RUT_estado" class="col-md-5 control-label">Estado:
                            <span style="color: #FF0000"><strong>*</strong></span></label>
                            <div class="col-md-7">
                               <select name="RUT_estado" id="RUT_estado" class="form-control input-sm js-example-basic-single" >
                                   <option value="1" selected>Activo</option>
                                   <option value="0">Inactivo</option>
                               </select>
                            </div>
                        </div>
                        
                        <div class="col-md-12" style="padding-bottom: 5px;">
                            <hr>
                            <label for="RUT_adicionalIda" class="col-md-3 control-label"><big><u>Datos Ida:</u></big></label>
                            <div class="col-md-1">
                                <span class="input-group-btn">
                                    <input name="num-diaIDA" id="num-diaIDA" value="1" type="hidden">
                                    <button class="btn btn-default input-group-abdon" type="button" onclick="agregar_diaIDA()" style="color:green">
                                        <span class="glyphicon glyphicon-plus"></span>
                                    </button>
                                    <button class="btn btn-default input-group-abdon" type="button" onclick="quitar_diaIDA()" style="color:red">
                                        <span class="glyphicon glyphicon-minus"></span>
                                    </button>
                                </span>
                            </div>
                        </div>
                        <div class="col-md-12" style="padding-bottom: 10px;" id="horaIDA1">
                            <label for="RUT_hora_salida/llegada1" class="col-md-5 control-label">Hora de: Salida / Llegada
                            <span style="color: #FF0000"><strong>*</strong></span></label>
                            <div class="col-md-3">
                                <div class='input-group date datetimepicker2' id='datetimepicker2'>
                                    <input id="RUT_hora_salidaIDA1" name="RUT_hora_salidaIDA1" type='text' class="form-control" />
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-time"></span>
                                    </span>
                                </div>
                            </div>
                            <label for="" class="col-md-1 control-label">/</label>
                            <div class="col-md-3">
                                <div class='input-group date datetimepicker2' id='datetimepicker2'>
                                    <input id="RUT_hora_llegadaIDA1" name="RUT_hora_llegadaIDA1" type='text' class="form-control" />
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-time"></span>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12" style="padding-bottom: 10px;" id="diaIDA1">
                            <label for="RUT_diaIDA1" class="col-md-5 control-label">Día:
                            <span style="color: #FF0000"><strong>*</strong></span></label>
                            <div class="col-md-7">
                               <select name="RUT_diaIDA1" id="RUT_diaIDA1" multiple="multiple" class="form-control input-sm js-example-basic-multiple" > <!--onchange="mostrarFechaVueloDia(1)"-->
                                   <option value="Monday" >Lunes</option>
                                   <option value="Tuesday" >Martes</option>
                                   <option value="Wednesday" >Miércoles</option>
                                   <option value="Thursday" >Jueves</option>
                                   <option value="Friday" >Viernes</option>
                                   <option value="Saturday" >Sábado</option>
                                   <option value="Sunday" >Domingo</option>
                               </select>
                            </div>
                        </div>
                        <div id="divDiaIDA"></div>
                        
                        <div class="col-md-12" style="padding-bottom: 5px;">
                            <hr>
                            <label for="RUT_adicionalVuelta" class="col-md-3 control-label"><big><u>Datos Vuelta:</u></big></label>
                            <div class="col-md-1">
                                <span class="input-group-btn">
                                    <input name="num-diaVUELTA" id="num-diaVUELTA" value="1" type="hidden">
                                    <button class="btn btn-default input-group-abdon" type="button" onclick="agregar_diaVUELTA()" style="color:green">
                                        <span class="glyphicon glyphicon-plus"></span>
                                    </button>
                                    <button class="btn btn-default input-group-abdon" type="button" onclick="quitar_diaVUELTA()" style="color:red">
                                        <span class="glyphicon glyphicon-minus"></span>
                                    </button>
                                </span>
                            </div>
                        </div>
                        <div class="col-md-12" style="padding-bottom: 10px;" id="horaVUELTA1">
                            <label for="RUT_hora_salida/llegada1" class="col-md-5 control-label">Hora de: Salida / Llegada
                            <span style="color: #FF0000"><strong>*</strong></span></label>
                            <div class="col-md-3">
                                <div class='input-group date datetimepicker2' id='datetimepicker2'>
                                    <input id="RUT_hora_salidaVUELTA1" name="RUT_hora_salidaVUELTA1" type='text' class="form-control" />
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-time"></span>
                                    </span>
                                </div>
                            </div>
                            <label for="" class="col-md-1 control-label">/</label>
                            <div class="col-md-3">
                                <div class='input-group date datetimepicker2' id='datetimepicker2'>
                                    <input id="RUT_hora_llegadaVUELTA1" name="RUT_hora_llegadaVUELTA1" type='text' class="form-control" />
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-time"></span>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12" style="padding-bottom: 10px;" id="diaVUELTA1">
                            <label for="RUT_diaVUELTA1" class="col-md-5 control-label">Día:
                            <span style="color: #FF0000"><strong>*</strong></span></label>
                            <div class="col-md-7">
                               <select name="RUT_diaVUELTA1" id="RUT_diaVUELTA1" multiple="multiple" class="form-control input-sm js-example-basic-multiple" >
                                   <option value="Monday" >Lunes</option>
                                   <option value="Tuesday" >Martes</option>
                                   <option value="Wednesday" >Miércoles</option>
                                   <option value="Thursday" >Jueves</option>
                                   <option value="Friday" >Viernes</option>
                                   <option value="Saturday" >Sábado</option>
                                   <option value="Sunday" >Domingo</option>
                               </select>
                            </div>
                        </div>
                        <div id="divDiaVUELTA"></div>
                        
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
                    <button name='insertRuta' id='insertRuta' type="button" class="btn btn-sm" onclick="insertRuta('<?php echo URLLOGICA?>ruta/insertRuta/');">Grabar</button>
                    <button name='updateRuta' id='updateRuta' type="button" class="btn btn-sm" onclick="updateRuta('<?php echo URLLOGICA?>ruta/updateRuta/');">Modificar</button>
                    <button name="closeRuta" id="closeRuta" type="button" class="btn btn-danger btn-sm" data-dismiss="modal" onclick="limpiarFormRuta();">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Fin Modal-->
    
    <script>
        function agregar_diaIDA(){
            var num = $("#num-diaIDA").val() <= 0 ? 1 : $("#num-diaIDA").val();
            var newnum = Number(num) + 1;

            html = '<div class="col-md-12" style="padding-bottom: 10px;" id="horaIDA' + newnum + '">'
                            + '<label for="RUT_hora_salida/llegada' + newnum + '" class="col-md-5 control-label">Hora de: Salida / Llegada'
                            + '<span style="color: #FF0000"><strong>*</strong></span></label>'
                            + '<div class="col-md-3">'
                                + '<div class="input-group date datetimepicker2_extra" id="datetimepicker2">'
                                    + '<input id="RUT_hora_salidaIDA' + newnum + '" name="RUT_hora_salidaIDA' + newnum + '" type="text" class="form-control" />'
                                    + '<span class="input-group-addon">'
                                        + '<span class="glyphicon glyphicon-time"></span>'
                                    + '</span>'
                                + '</div>'
                            + '</div>'
                            + '<label for="" class="col-md-1 control-label">/</label>'
                            + '<div class="col-md-3">'
                                + '<div class="input-group date datetimepicker2_extra" id="datetimepicker2">'
                                    + '<input id="RUT_hora_llegadaIDA' + newnum + '" name="RUT_hora_llegadaIDA' + newnum + '" type="text" class="form-control" />'
                                    + '<span class="input-group-addon">'
                                        + '<span class="glyphicon glyphicon-time"></span>'
                                    + '</span>'
                                + '</div>'
                            + '</div>'
                        + '</div>'
                        + '<div class="col-md-12" style="padding-bottom: 10px;" id="diaIDA' + newnum + '">'
                            + '<label for="RUT_diaIDA' + newnum + '" class="col-md-5 control-label">Día:'
                            + '<span style="color: #FF0000"><strong>*</strong></span></label>'
                            + '<div class="col-md-7">'
                               + '<select name="RUT_diaIDA' + newnum + '" id="RUT_diaIDA' + newnum + '" multiple="multiple" class="form-control input-sm js-example-basic-multiple_extra" >'
                                   + '<option value="Monday">Lunes</option>'
                                   + '<option value="Tuesday" >Martes</option>'
                                   + '<option value="Wednesday" >Miércoles</option>'
                                   + '<option value="Thursday" >Jueves</option>'
                                   + '<option value="Friday" >Viernes</option>'
                                   + '<option value="Saturday" >Sábado</option>'
                                   + '<option value="Sunday" >Domingo</option>'
                               + '</select>'
                            + '</div>'
                        + '</div>';
            $("#divDiaIDA").append(html);
            $(document).ready(function() { $(".js-example-basic-multiple_extra").select2(); });
            $(document).ready(function() { $('.datetimepicker2_extra').datetimepicker({ format: 'HH:mm' }); });
            
            $("#num-diaIDA").val(newnum);
        }
        
        function quitar_diaIDA(){
            var num = $("#num-diaIDA").val();
            var newnum = Number(num) - 1;
            
            if(newnum != 0){
                $("#horaIDA" + num).remove();
                $("#diaIDA" + num).remove();
                $("#num-diaIDA").val(newnum);
            }
        }
        
        function agregar_diaVUELTA(){
            var num = $("#num-diaVUELTA").val() <= 0 ? 1 : $("#num-diaVUELTA").val();
            var newnum = Number(num) + 1;

            html = '<div class="col-md-12" style="padding-bottom: 10px;" id="horaVUELTA' + newnum + '">'
                            + '<label for="RUT_hora_salida/llegada' + newnum + '" class="col-md-5 control-label">Hora de: Salida / Llegada'
                            + '<span style="color: #FF0000"><strong>*</strong></span></label>'
                            + '<div class="col-md-3">'
                                + '<div class="input-group date datetimepicker2_extra" id="datetimepicker2">'
                                    + '<input id="RUT_hora_salidaVUELTA' + newnum + '" name="RUT_hora_salidaVUELTA' + newnum + '" type="text" class="form-control" />'
                                    + '<span class="input-group-addon">'
                                        + '<span class="glyphicon glyphicon-time"></span>'
                                    + '</span>'
                                + '</div>'
                            + '</div>'
                            + '<label for="" class="col-md-1 control-label">/</label>'
                            + '<div class="col-md-3">'
                                + '<div class="input-group date datetimepicker2_extra" id="datetimepicker2">'
                                    + '<input id="RUT_hora_llegadaVUELTA' + newnum + '" name="RUT_hora_llegadaVUELTA' + newnum + '" type="text" class="form-control" />'
                                    + '<span class="input-group-addon">'
                                        + '<span class="glyphicon glyphicon-time"></span>'
                                    + '</span>'
                                + '</div>'
                            + '</div>'
                        + '</div>'
                        + '<div class="col-md-12" style="padding-bottom: 10px;" id="diaVUELTA' + newnum + '">'
                            + '<label for="RUT_diaVUELTA' + newnum + '" class="col-md-5 control-label">Día:'
                            + '<span style="color: #FF0000"><strong>*</strong></span></label>'
                            + '<div class="col-md-7">'
                               + '<select name="RUT_diaVUELTA' + newnum + '" id="RUT_diaVUELTA' + newnum + '" multiple="multiple" class="form-control input-sm js-example-basic-multiple_extra" >'
                                   + '<option value="Monday" >Lunes</option>'
                                   + '<option value="Tuesday" >Martes</option>'
                                   + '<option value="Wednesday" >Miércoles</option>'
                                   + '<option value="Thursday" >Jueves</option>'
                                   + '<option value="Friday" >Viernes</option>'
                                   + '<option value="Saturday" >Sábado</option>'
                                   + '<option value="Sunday" >Domingo</option>'
                               + '</select>'
                            + '</div>'
                        + '</div>';
            $("#divDiaVUELTA").append(html);
            $(document).ready(function() { $(".js-example-basic-multiple_extra").select2(); });
            $(document).ready(function() { $('.datetimepicker2_extra').datetimepicker({ format: 'HH:mm' }); });
            $("#num-diaVUELTA").val(newnum);
        }
        
        function quitar_diaVUELTA(){
            var num = $("#num-diaVUELTA").val();
            var newnum = Number(num) - 1;
            
            if(newnum != 0){
                $("#horaVUELTA" + num).remove();
                $("#diaVUELTA" + num).remove();
                $("#num-diaVUELTA").val(newnum);
            }           
        }
        
        function insertRuta(url){
            $("#preloader").css("display","block");

            var cantidadIDA = $("#num-diaIDA").val();
            var cantidadVUELTA = $("#num-diaVUELTA").val();
            
            if(validate_formRuta()) {

                var parametros = {
                    "RUT_num_vueloIDA" : $("#RUT_num_vueloIDA").val(),
                    "RUT_num_vueloVUELTA" : $("#RUT_num_vueloVUELTA").val(),
                    "CIU_id_origen" : $("#CIU_id_origen").val(),
                    "CIU_id_destino" : $("#CIU_id_destino").val(),
                    "RUT_estado" : $("#RUT_estado").val(),
                    "cantidadIDA" : $("#num-diaIDA").val(),
                    "cantidadVUELTA" : $("#num-diaVUELTA").val(),
                };

                for (var i = 1; i <= cantidadIDA; i++) {
                    
                    var RUT_diaIDA = $("#RUT_diaIDA" + i).val();
                    for( var l = 0; l < (RUT_diaIDA).length; l++ ){
                        
                        for (var k = (i+1); k <= cantidadIDA; k++) {
                            var RUT_diaIDA2 = $("#RUT_diaIDA" + k).val();
                            
                            for( var f = 0; f < (RUT_diaIDA2).length; f++ ){
                                if( RUT_diaIDA[l] == RUT_diaIDA2[f] ){
                                    alert("Revisar días de Rutas, ya que existe duplicidad.");
                                    $("#preloader").css("display","none");
                                    return false;
                                }
                            }                            
                        }                        
                    }

                    parametros["RUT_hora_salidaIDA" + i] = $("#RUT_hora_salidaIDA" + i).val();
                    parametros["RUT_hora_llegadaIDA" + i] = $("#RUT_hora_llegadaIDA" + i).val();
                    parametros["RUT_diaIDA" + i] = $("#RUT_diaIDA" + i).val();                                               
                }
                for (var i = 1; i <= cantidadVUELTA; i++) {
                    
                    var RUT_diaVUELTA = $("#RUT_diaVUELTA" + i).val();
                    for( var l = 0; l < (RUT_diaVUELTA).length; l++ ){
                        
                        for (var k = (i+1); k <= cantidadVUELTA; k++) {
                            var RUT_diaVUELTA2 = $("#RUT_diaVUELTA" + k).val();
                            
                            for( var f = 0; f < (RUT_diaVUELTA2).length; f++ ){
                            
                                if( RUT_diaVUELTA[l] == RUT_diaVUELTA[f] ){
                                    alert("Revisar días de Rutas, ya que existe duplicidad.");
                                    $("#preloader").css("display","none");
                                    return false;                                    
                                }
                            }                            
                        }                        
                    }
                    parametros["RUT_hora_salidaVUELTA" + i] = $("#RUT_hora_salidaVUELTA" + i).val();
                    parametros["RUT_hora_llegadaVUELTA" + i] = $("#RUT_hora_llegadaVUELTA" + i).val();
                    parametros["RUT_diaVUELTA" + i] = $("#RUT_diaVUELTA" + i).val();
                }

                $.post(url,parametros,

                function(data){
                        var RUT_num_vuelo = data[0]["RUT_num_vuelo"];
                    
                        if(RUT_num_vuelo != undefined){
                            alert('La Ruta ' + RUT_num_vuelo + ' ya se encuentra registrada.');
                            $("#preloader").css("display","none");
                        } else {
                            limpiarFormRuta();
                            $("#preloader").css("display", "none");
                            alert("Se ha registrado correctamente la Ruta.");
                            $('#rutaRegistro').modal('hide');
                            location.reload(true);           
                        }
                });
           } else{
                $("#preloader").css("display","none");
            }
        }
        
        $('#rutaRegistro').on('show.bs.modal', function (e) {
            $("#updateRuta").hide();
        })
        $('#rutaRegistro').on('hidden.bs.modal', function (e) {
            limpiarFormRuta();
        })
        
        function listarDetRuta(url,RUT_relacion,accion){
            $("#preloader").css("display","block");

            $.post(url,
            {
                "RUT_relacion" : RUT_relacion
            },
            function(data){
                if(data == ""){
                    alert("Hubo un error al cargar la información.");
                } else {
                
                    $("#RUT_num_vueloIDA").val(data[0]["RUT_num_vuelo"]);
                    $("#CIU_id_origen").val(data[0]["CIU_id_origen"]).trigger('change.select2');
                    $("#CIU_id_destino").val(data[0]["CIU_id_destino"]).trigger('change.select2');
                    $("#RUT_estado").val(data[0]["RUT_estado"]).trigger('change.select2');
                    
                    $("#AUD_usu_cre").val(data[0]["AUD_usu_cre"]);
                    $("#AUD_fch_cre").val(data[0]["AUD_fch_cre"]);
                    $("#AUD_usu_mod").val(data[0]["AUD_usu_mod"]);
                    $("#AUD_fch_mod").val(data[0]["AUD_fch_mod"]);

                    if(accion == "listar"){
                        verFormRuta();
                    } else {
                        $("#RUT_num_vueloIDAhidden").val(data[0]["RUT_num_vuelo"]);
                        $("#RUT_ordenIDA").val(data[0]["RUT_orden"]);
                        $("#insertRuta").hide();
                        $("#updateRuta").show();
                        var disabled = '';
                    }
                    
                    var l = 0;
                    $("#num-diaIDA").val(j);
                    
                    var vueloIDA = data[0]["RUT_num_vuelo"];
                    var diaSemana = new Array();
                    
                    for (var i = 1; i <= data.length; i++) {
                        if( data[i-1]["RUT_num_vuelo"] == vueloIDA ){
                            $("#RUT_hora_salidaIDA" + (l+1)).val(data[i-1]["RUT_hora_salida"]);
                            $("#RUT_hora_llegadaIDA" + (l+1)).val(data[i-1]["RUT_hora_llegada"]);
                            
                            if(accion == "listar"){
                                $("#RUT_hora_salidaIDA" + (l+1)).prop("disabled","disabled");
                                $("#RUT_hora_llegadaIDA" + (l+1)).prop("disabled","disabled");
                            } else {
                                $("#RUT_hora_salidaIDA" + (l+1)).removeAttr("disabled");
                                $("#RUT_hora_llegadaIDA" + (l+1)).removeAttr("disabled");
                            }
                            
                            diaSemana = diaSemana.concat(data[i-1]["RUTDIA_diaSemana"]);
                                                        
                            if( data[i]["RUT_num_vuelo"] == vueloIDA ){
                                if( data[i-1]["RUT_hora_salida"] != data[i]["RUT_hora_salida"] ){
                                    $("#RUT_diaIDA" + (l+1)).val(diaSemana).prop('selected',true);
                                    $("#RUT_diaIDA" + (l+1)).trigger('change.select2');
                                    
                                    if(accion == "listar"){
                                        $("#RUT_diaIDA" + (l+1)).prop("disabled","disabled");
                                    } else {
                                        $("#RUT_diaIDA" + (l+1)).removeAttr("disabled");
                                    }
                                    var diaSemana = new Array();
                                    agregar_diaIDA();
                                    l++;
                                }   
                            }
                        }
                    }
                    $("#RUT_diaIDA" + (l+1)).val(diaSemana).prop('selected',true);
                    $("#RUT_diaIDA" + (l+1)).trigger('change.select2');
                    if(accion == "listar"){
                        $("#RUT_diaIDA" + (l+1)).prop("disabled","disabled");
                    } else {
                        $("#RUT_diaIDA" + (l+1)).removeAttr("disabled");
                    }
                    
                    var k = 0;
                    $("#num-diaVUELTA").val(k);
                    var vueloVUELTA = data[i-2]["RUT_num_vuelo"];
                    var diaSemana = new Array();
                    
                    for (var j = 1; j <= data.length; j++) {
                        if( data[j-1]["RUT_num_vuelo"] == vueloVUELTA ){
                            $("#RUT_hora_salidaVUELTA" + (k+1)).val(data[j-1]["RUT_hora_salida"]);
                            $("#RUT_hora_llegadaVUELTA" + (k+1)).val(data[j-1]["RUT_hora_llegada"]);
                            
                            if(accion == "listar"){
                                $("#RUT_hora_salidaVUELTA" + (k+1)).prop("disabled","disabled");
                                $("#RUT_hora_llegadaVUELTA" + (k+1)).prop("disabled","disabled");
                            } else {
                                $("#RUT_hora_salidaVUELTA" + (k+1)).removeAttr("disabled");
                                $("#RUT_hora_llegadaVUELTA" + (k+1)).removeAttr("disabled");
                            }
                            
                            diaSemana = diaSemana.concat(data[j-1]["RUTDIA_diaSemana"]);
                            
                            if( j < data.length ){
                                var variable = data[j]["RUT_hora_salida"];
                                if( variable != undefined){
                                    if( data[j]["RUT_num_vuelo"] == vueloVUELTA ){
                                        if( data[j-1]["RUT_hora_salida"] != data[j]["RUT_hora_salida"] ){
                                            $("#RUT_diaVUELTA" + (k+1)).val(diaSemana).prop('selected',true);
                                            $("#RUT_diaVUELTA" + (k+1)).trigger('change.select2');
                                            
                                            if(accion == "listar"){
                                                $("#RUT_diaVUELTA" + (k+1)).prop("disabled","disabled");
                                            } else {
                                                $("#RUT_diaVUELTA" + (k+1)).removeAttr("disabled");
                                            }
                                            var diaSemana = new Array();
                                            agregar_diaVUELTA();
                                            k++;
                                        }
                                    }
                                }  
                            }
                        }
                    }
                    
                    $("#RUT_diaVUELTA" + (k+1)).val(diaSemana).prop('selected',true);
                    $("#RUT_diaVUELTA" + (k+1)).trigger('change.select2');
                    if(accion == "listar"){
                        $("#RUT_diaVUELTA" + (k+1)).prop("disabled","disabled");
                    } else {
                        $("#RUT_num_vueloVUELTAhidden").val(data[i-2]["RUT_num_vuelo"]);
                        $("#RUT_ordenVUELTA").val(data[i-2]["RUT_orden"]);
                        $("#RUT_diaVUELTA" + (k+1)).removeAttr("disabled");
                    }
                    
                    $("#RUT_num_vueloVUELTA").val(data[i-2]["RUT_num_vuelo"]);
                    
                    $("#num-diaIDA").val((l+1));
                    $("#num-diaVUELTA").val((k+1));
                    
                    $("#preloader").css("display", "none");
                };
            })
        }
        
        function updateRuta(url){
            $("#preloader").css("display","block");

            var cantidadIDA = $("#num-diaIDA").val();
            var cantidadVUELTA = $("#num-diaVUELTA").val();
            
                if(validate_formRuta()) {

                    var parametros = {
                        "RUT_num_vueloIDAhidden" : $("#RUT_num_vueloIDAhidden").val(),
                        "RUT_num_vueloVUELTAhidden" : $("#RUT_num_vueloVUELTAhidden").val(),
                        "RUT_ordenIDA" : $("#RUT_ordenIDA").val(),
                        "RUT_ordenVUELTA" : $("#RUT_ordenVUELTA").val(),
                        "RUT_num_vueloIDA" : $("#RUT_num_vueloIDA").val(),
                        "RUT_num_vueloVUELTA" : $("#RUT_num_vueloVUELTA").val(),
                        "CIU_id_origen" : $("#CIU_id_origen").val(),
                        "CIU_id_destino" : $("#CIU_id_destino").val(),
                        "RUT_estado" : $("#RUT_estado").val(),
                        "cantidadIDA" : $("#num-diaIDA").val(),
                        "cantidadVUELTA" : $("#num-diaVUELTA").val(),
                    };
                    
                    for (var i = 1; i <= cantidadIDA; i++) {
                        parametros["RUT_hora_salidaIDA" + i] = $("#RUT_hora_salidaIDA" + i).val();
                        parametros["RUT_hora_llegadaIDA" + i] = $("#RUT_hora_llegadaIDA" + i).val();
                        parametros["RUT_diaIDA" + i] = $("#RUT_diaIDA" + i).val();
                    }
                    for (var i = 1; i <= cantidadVUELTA; i++) {
                        parametros["RUT_hora_salidaVUELTA" + i] = $("#RUT_hora_salidaVUELTA" + i).val();
                        parametros["RUT_hora_llegadaVUELTA" + i] = $("#RUT_hora_llegadaVUELTA" + i).val();
                        parametros["RUT_diaVUELTA" + i] = $("#RUT_diaVUELTA" + i).val();
                    }

                    $.post(url,parametros,

                    function(data){
                            limpiarFormRuta();
                            $("#preloader").css("display", "none");
                            alert("Se ha modificado correctamente la Ruta.");
                            $('#rutaRegistro').modal('hide');
                            location.reload(true);
                    });
                } else{
                    $("#preloader").css("display","none");
                }
        }
        
        /*function mostrarFechaVueloDia(num) {
            var valuesDia = $("#RUT_diaIDA" + num).val();
            var numDiaIDA = $("#num-diaIDA").val();
            
            if(numDiaIDA > 1){
                for (var i = 2; i <= numDiaIDA; i++) {                    
                    $('#RUT_diaIDA'+ i +' > option[value="' + valuesDia + '"]').prop('disabled', true);
                    $('#RUT_diaIDA'+ i).val("-1");
                    $('#RUT_diaIDA'+ i).trigger("change");
                    $('#RUT_diaIDA'+ i).select2();                    
                }
            } else {
                return false;
            }
        }
        
        function mostrarFechaVueloRuta() {
            var valuesRutas = $("#MainContent_lstRutas").val();
            var idUpdateSelect = $('#rutaToUpdateSelect').val();
            for (var i = 0; valuesRutas && i < valuesRutas.length; i++)
                $("#divVueloRuta_" + valuesRutas[i]).hide();
            var idDivShow = "#divVueloRuta_" + idUpdateSelect;
            $(idDivShow).show();
            $("#rutaToUpdateSelectCopy > option").each(function (index) {
                $(this).removeProp('disabled');
            });
            $("#rutaToUpdateSelectCopy > option[value='" + idUpdateSelect + "']").prop('disabled', true);
            $("#rutaToUpdateSelectCopy").val("-1");
            $("#rutaToUpdateSelectCopy").trigger("change");
            $("#rutaToUpdateSelectCopy").select2();
        }*/
    </script>
    <!-- /.content-wrapper -->
    <?php include "footer_view.php";?>
