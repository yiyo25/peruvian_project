<?php include "header_view.php";?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
				Listado de Condiciones Especiales <small>Administrar Condiciones Especiales</small>
            </h1>
            <ol class="breadcrumb">
                <li><i class="fa fa-thumb-tack"></i> Condiciones Especiales</li>
                <li class="active">
                    Listado de Condiciones Especiales
                </li>
            </ol>
        </section>
        <!-- Main content -->
        <section class="content">
            <div class='box box-danger'>
                <div class="box-body">
                    <div id="MainContent_Div1" class="panel panel-default">
                        <div class="panel-heading clearfix"  style="padding: 7px !important">
                            <span><strong>Buscar</strong></span>
                        </div>
                        <form method="post" action="<?php echo URLLOGICA?>condicion/buscarCondicion/" onsubmit="document.forms['buscar']['buscar'].disabled=true;" name="buscar">
                            <div class="row-fluid">
                                <div class="form-group">
                                    <label for="bTRIP_apellido" class="col-md-2 control-label">Apellido</label>
                                    <div class="col-md-2">
                                        <input type="text" name="bTRIP_apellido" id="bTRIP_apellido" class="form-control input-sm" style="text-transform: uppercase;" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="bCONDESP_id" class="col-md-2 control-label">Tipo de Condición</label>
                                    <div class="col-md-2">
                                        <select name="bCONDESP_id" id="bCONDESP_id" class="form-control input-sm js-example-basic-single" >
                                            <option value="" selected>Tipo de Condición</option>
                                            <option value="" >Por Tipo Trip.</option>
                                            <option value="" >Por Edad (años)</option>
                                            <option value="" >Por Ciudad</option>
                                            <option value="" >Por Ruta</option>
                                            <option value="" >Por Idioma</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-2 col-md-offset-2">
                                        <input type="submit" name="buscar" value="Buscar" class="btn btn-danger btn-block" />
                                    </div>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="clearfix" style="padding: 5px;"></div>
                        </form>
                    </div>
                    <div id="MainContent_listaPro" class="panel panel-default">
                        <div class="panel-heading clearfix" style="padding: 7px !important">
                            <span id="MainContent_tituloPro"><strong>Lista de Condiciones</strong></span>
                            <?php  $Bdisabled = 0; ?>
                            <?php foreach ($this->objBotton as $botton) { ?>
                                <?php if($botton["Funcion"] == "insertCondicion"){ ?>
                                    <?php  $Bdisabled += 1; ?>
                                <?php } ?>
                            <?php } ?>
                            <?php if($Bdisabled > 0){ $disabled = ""; } else { $disabled = "disabled"; } ?>
                                <button type="button" class="pull-right fa fa-plus" data-toggle="modal" data-target="#condicionRegistro" <?php echo $disabled;?>></button>
                        </div>
                        <div class="area_resultado table-responsive">
                            <table id="listaCondicion" class="display myDataTables" cellspacing="0" cellpadding="2">
                                <thead>
                                    <tr>
                                        <th scope="col">Item</th>
                                        <th scope="col">Tipo Condicion</th>
                                        <th scope="col">Estado</th>
                                        <th scope="col">Fch. Registro</th>
                                        <th scope="col">Ver</th>
                                        <th scope="col">Editar</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (count($this->objResumenCondicion) > 0) { ?>
                                        <?php $item = 1; ?>
                                        <?php foreach ($this->objResumenCondicion as $lista) { ?>
                                    <tr>
                                        <td style="width:auto;"><?php echo $item;?></td>
                                        <td style="width:auto;"><?php echo utf8_encode($lista["CONDESP_estado"]);?></td>
                                        <td style="width:auto;"><?php echo utf8_encode($lista["TIP_condicion"]);?></td>
                                        <td style="width:auto;"><?php echo $lista["AUD_fch_cre"];?></td>
                                        <td style="width:auto;">
                                            <?php  $Bdisabled = 0; ?>
                                            <?php foreach ($this->objBotton as $botton) { ?>
                                                <?php if($botton["Funcion"] == "listarCondicion"){ ?>
                                                    <?php  $Bdisabled += 1; ?>
                                                <?php } ?>
                                            <?php } ?>
                                            <?php if($Bdisabled > 0){ $disabled = ""; } else { $disabled = "disabled"; } ?>
                                                <button type="button" class="fa fa-eye" data-toggle="modal"  data-target="#condicionRegistro" onclick="listarDetCondicion(<?php echo utf8_encode($lista["CONDESP_id"]);?>,'listar')" <?php echo $disabled;?>></button>
                                        </td>
                                        <td style="width:auto;">
                                            <?php  $Bdisabled = 0; ?>
                                            <?php foreach ($this->objBotton as $botton) { ?>
                                                <?php if($botton["Funcion"] == "updateCondicion"){ ?>
                                                    <?php  $Bdisabled += 1; ?>
                                                <?php } ?>
                                            <?php } ?>
                                            <?php if($Bdisabled > 0){ $disabled = ""; } else { $disabled = "disabled"; } ?>
                                                <button type="button" class="fa fa-pencil" data-toggle="modal" data-target="#condicionRegistro" onclick="listarDetCondicion(<?php echo utf8_encode($lista["CONDESP_id"]);?>,'modificar')" <?php echo $disabled;?>></button>
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
    <div id="condicionRegistro" class="modal fade" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header" style="padding: 10px !important">
                    <table class="col-xs-12">
                        <tr>
                            <td style="text-align:left;">
                                <h4><strong id="titleForm">Ingresar Nueva Condición</strong></h4>
                            </td>
                            <td>
                                <button type="button" class="close btn-lg" data-dismiss="modal" onclick="limpiarFormCondicion();" style="background-color: red; color:white; margin:10px; padding: 0px 6px 2px 6px;text-align:right;">
                                    <span aria-hidden="true">&times;</span><span class="sr-only">Cerrar</span>
                                </button>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="modal-body" style="padding-bottom: 10px !important">
                    <div class="row">
                        <div class="col-md-12" style="padding-bottom: 10px;">
                            <label for="TIPTRIP_id" class="col-md-5 control-label">Por Tipo de Tripulante
                            <span style="color: #FF0000"><strong>*</strong></span></label>
                            <div class="col-md-7">
                                <input type="hidden" name="CONDESP_id" id="CONDESP_id" value="" />
                                <select name="TIPTRIP_id" id="TIPTRIP_id" class="form-control input-sm js-example-basic-single" >
                                    <option value="" selected>Seleccionar Tipo Tripulante</option>
                                <?php foreach($this->objTipoTripulante as $lista){ ?>
                                    <option value="<?php echo $lista["TIPTRIP_id"];?>"><?php echo ($lista["TIPTRIP_descripcion"]);?></option>
                                <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12" style="padding-bottom: 10px;">
                            <label for="TIPTRIPDET_id" class="col-md-5 control-label">Por Tipo de Detalle de Trip.
                            <span style="color: #FF0000"><strong>*</strong></span></label>
                            <div class="col-md-7">
                                <select name="TIPTRIPDET_id" id="TIPTRIPDET_id" class="form-control input-sm js-example-basic-single" >
                                    <option value="" selected>Seleccionar Det. Tipo Tripulante</option>
                                <?php foreach($this->objTipoDetTripulante as $lista){ ?>
                                    <option class="<?php echo $lista["TIPTRIP_id"];?>" value="<?php echo $lista["TIPTRIPDET_id"];?>"><?php echo ($lista["TIPTRIPDET_descripcion"]);?></option>
                                <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12" style="padding-bottom: 10px;">
                            <label for="TRIP_id" class="col-md-5 control-label">Por Tripulante Afectado</label>
                            <div class="col-md-7">
                                <select name="TRIP_id" id="TRIP_id" class="form-control input-sm js-example-basic-single" >
                                    <option value="">Todos los Tripulantes</option>
                                <?php foreach($this->objTripulante as $lista){ ?>
                                    <option class="<?php echo $lista["TIPTRIPDET_id"];?>" value="<?php echo $lista["TRIP_id"];?>"><?php echo utf8_encode($lista["TRIP_nombre"]." ".$lista["TRIP_apellido"]);?></option>
                                <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12" style="padding-bottom: 10px;">
                            <label for="CONDESP_indiedad" class="col-md-5 control-label">Indicador Edad</label>
                            <div class="col-md-7">
                                <select name="CONDESP_indiedad" id="CONDESP_indiedad" class="form-control input-sm js-example-basic-single"  onchange="activarCONDESP_edad();">
                                    <option value="" selected>No Aplica</option>
                                    <option value=">" >Mayor</option>
                                    <option value="<" >Menor</option>
                                    <option value="==" >Igual</option>
                                    <option value=">=" >Mayor Igual</option>
                                    <option value="<=" >Menor Igual</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12" style="padding-bottom: 10px;">
                            <label for="CONDESP_edad" class="col-md-5 control-label">Por Edad (años)</label>
                            <div class="col-md-7">
                                <input type="text" name="CONDESP_edad" id="CONDESP_edad" placeholder="No Aplica" class="form-control input-sm numberEntero" style="text-transform: uppercase; width: 100% !important;" disabled />
                            </div>
                        </div>
                        <div class="col-md-12" style="padding-bottom: 10px;">
                            <label for="CIU_id" class="col-md-5 control-label">Por Ciudad - Origen</label>
                            <div class="col-md-7">
                                <select name="CIU_id" id="CIU_id" class="form-control input-sm js-example-basic-single" >
                                    <option value="" selected>No Aplica</option>
                                    <option value="*">Todas las Ciudades</option>
                                <?php foreach($this->objCiudad as $lista){ ?>
                                    <option value="<?php echo $lista["CIU_id"];?>"><?php echo utf8_encode($lista["CIU_nombre"]);?></option>
                                <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12" style="padding-bottom: 10px;">
                            <label for="RUT_num_vuelo" class="col-md-5 control-label">Por Ruta</label>
                            <div class="col-md-7">
                                <select name="RUT_num_vuelo" id="RUT_num_vuelo" class="form-control input-sm js-example-basic-single" >
                                    <option value="" selected>No Aplica</option>
                                    <option value="*">Todas las Rutas</option>
                                <?php foreach($this->objRuta as $lista){ ?>
                                    <option value="<?php echo $lista["RUT_num_vuelo"];?>"><?php echo utf8_encode($lista["CIU_id_origen"]." -".$lista["CIU_id_destino"]);?></option>
                                <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12" style="padding-bottom: 10px;">
                            <label for="NIVING_id" class="col-md-5 control-label">Niv. de Ingles:</label>
                            <div class="col-md-7">
                                <select name="NIVING_id" id="NIVING_id" class="form-control input-sm js-example-basic-single" >
                                    <option value="" selected>No Aplica</option>
                                <?php foreach($this->objTripNivIngles as $lista){ ?>
                                    <option value="<?php echo $lista["NIVING_id"];?>"><?php echo ($lista["NIVING_descripcion"]);?></option>
                                <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12" style="padding-bottom: 10px;">
                            <label for="CONDESP_condicional" class="col-md-5 control-label">Condicional
                            <span style="color: #FF0000"><strong>*</strong></span></label>
                            <div class="col-md-7">
                                <select name="CONDESP_condicional" id="CONDESP_condicional" class="form-control input-sm js-example-basic-single" >
                                    <option value="" selected> Seleccionar Condicional</option>
                                    <option value="Vuela" >Vuela</option>
                                    <option value="NoVuela" >No Vuela</option>
                                </select>
                            </div>
                        </div>
                        <div id="divAplicacion">
                        </div>
                        <div class="col-md-12" style="padding-bottom: 10px;">
                            <label for="CONDESP_estado" class="col-md-5 control-label">Estado:
                            <span style="color: #FF0000"><strong>*</strong></span></label>
                            <div class="col-md-7">
                               <select name="CONDESP_estado" id="CONDESP_estado" class="form-control input-sm js-example-basic-single">
                                   <option value="1" selected>Activo</option>
                                   <option value="0">Inactivo</option>
                               </select>
                            </div>
                        </div>
                        <div class="col-md-12" style="padding-bottom: 10px;">
                            <label for="CONDESP_condicional_apli" class="col-md-3 control-label">Aplicado con:</label>
                            <div class="col-md-3">
                                <label for="aTRIP_id_apli" class="col-md-8 control-label">Tripulante</label>
                                <div class="col-md-1">
                                    <input type="checkbox" id="aTRIP_id_apli" name="aTRIP_id_apli" value="" class="form-check-input" onclick="activarTripulanteApli();" />
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label for="aCONDESP_edad_apli" class="col-md-8 control-label">Edad</label>
                                <div class="col-md-1">
                                    <input type="checkbox" id="aCONDESP_edad_apli" name="aCONDESP_edad_apli" value="" class="form-check-input" onclick="activarEdadApli();" />
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label for="aCIU_id_apli" class="col-md-8 control-label">Ciudad</label>
                                <div class="col-md-1">
                                    <input type="checkbox" id="aCIU_id_apli" name="aCIU_id_apli" value="" class="form-check-input" onclick="activarCiudadApli();" />
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12" style="padding-bottom: 10px;">
                            <div class="col-md-3 col-md-offset-3">
                                <label for="aRUT_num_vuelo_apli" class="col-md-8 control-label">Ruta</label>
                                <div class="col-md-1">
                                    <input type="checkbox" id="aRUT_num_vuelo_apli" name="aRUT_num_vuelo_apli" value="" class="form-check-input" onclick="activarRutaApli();" />
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label for="aNIVING_id_apli" class="col-md-8 control-label">Ingles</label>
                                <div class="col-md-1">
                                    <input type="checkbox" id="aNIVING_id_apli" name="aNIVING_id_apli" value="" class="form-check-input" onclick="activarInglesApli();" />
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12" style="padding-bottom: 10px !important; display:none;" id="divAUD_usu_cre">
                            <label for="AUD_usu_cre" class="col-md-5 control-label">Usuario de Creación:</label>
                            <div class="col-md-6">
                               <input type="text" name="AUD_usu_cre" id="AUD_usu_cre" class="form-control input-sm numberDecimal" style="text-transform: uppercase; width: 100% !important;" />
                            </div>
                        </div>
                        <div class="col-md-12" style="padding-bottom: 10px !important; display:none;" id="divAUD_fch_cre">
                            <label for="AUD_fch_cre" class="col-md-5 control-label">Fecha de Creación:</label>
                            <div class="col-md-6">
                               <input type="text" name="AUD_fch_cre" id="AUD_fch_cre" class="form-control input-sm" style="text-transform: uppercase; width: 100% !important;" />
                            </div>
                        </div>
                        <div class="col-md-12" style="padding-bottom: 10px !important; display:none;" id="divAUD_usu_mod">
                            <label for="AUD_usu_mod" class="col-md-5 control-label">Usuario de Mod.:</label>
                            <div class="col-md-6">
                               <input type="text" name="AUD_usu_mod" id="AUD_usu_mod" class="form-control input-sm" style="text-transform: uppercase; width: 100% !important;" />
                            </div>
                        </div>
                        <div class="col-md-12" style="padding-bottom: 10px !important; display:none;" id="divAUD_fch_mod">
                            <label for="AUD_fch_mod" class="col-md-5 control-label">Fecha de Mod.:</label>
                            <div class="col-md-6">
                               <input type="text" name="AUD_fch_mod" id="AUD_fch_mod" class="form-control input-sm numberDecimal" style="text-transform: uppercase; width: 100% !important;" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer" style="padding: 10px !important">
                    <button name='insertCondicion' id='insertCondicion' type="button" class="btn btn-sm" onclick="insertCondicion();">Grabar</button>
                    <button name='updateCondicion' id='updateCondicion' type="button" class="btn btn-sm" onclick="updateCondicion();">Modificar</button>
                    <button name="closeCondicion" id="closeCondicion" type="button" class="btn btn-danger btn-sm" data-dismiss="modal" onclick="limpiarFormCondicion();">Cerrar</button>
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
        
        function activarCONDESP_edad(){
            $("#CONDESP_edad").removeAttr("disabled");
        }
        
        function activarCONDESP_edad_apli(){
            $("#CONDESP_edad_apli").removeAttr("disabled");
        }
        
        function activarTripulanteApli(){
            if ($("#aTRIP_id_apli").is(':checked')) {
                html = '<div class="col-md-12" style="padding-bottom: 10px;" id="divTIPTRIP_id_apli">'
                            + '<label for="TIPTRIP_id_apli" class="col-md-5 control-label">Por Tipo de Tripulante</label>'
                            + '<div class="col-md-7">'
                                + '<select name="TIPTRIP_id_apli" id="TIPTRIP_id_apli" class="form-control input-sm js-example-basic-single_extra" >'
                                    + '<option value="" selected>Seleccionar Tipo Tripulante</option>'
                                <?php foreach($this->objTipoTripulante as $lista){ ?>
                                    + '<option value="<?php echo $lista["TIPTRIP_id"];?>"><?php echo ($lista["TIPTRIP_descripcion"]);?></option>'
                                <?php } ?>
                                + '</select>'
                            + '</div>'
                        + '</div>'
                        + '<div class="col-md-12" style="padding-bottom: 10px;" id="divTIPTRIPDET_id_apli">'
                            + '<label for="TIPTRIPDET_id_apli" class="col-md-5 control-label">Por Tipo de Detalle de Trip.</label>'
                            + '<div class="col-md-7">'
                                + '<select name="TIPTRIPDET_id_apli" id="TIPTRIPDET_id_apli" class="form-control input-sm js-example-basic-single_extra" >'
                                    + '<option value="" selected>Seleccionar Det. Tipo Tripulante</option>'
                                <?php foreach($this->objTipoDetTripulante as $lista){ ?>
                                    + '<option class="<?php echo $lista["TIPTRIP_id"];?>" value="<?php echo $lista["TIPTRIPDET_id"];?>"><?php echo ($lista["TIPTRIPDET_descripcion"]);?></option>'
                                <?php } ?>
                                + '</select>'
                            + '</div>'
                        + '</div>'
                        + '<div class="col-md-12" style="padding-bottom: 10px;" id="divTRIP_id_apli">'
                            + '<label for="TRIP_id_apli" class="col-md-5 control-label">Por Tripulante Afectado</label>'
                            + '<div class="col-md-7">'
                                + '<select name="TRIP_id_apli" id="TRIP_id_apli" class="form-control input-sm js-example-basic-single_extra" >'
                                    + '<option value="">Todos los Tripulantes</option>'
                                <?php foreach($this->objTripulante as $lista){ ?>
                                    + '<option class="<?php echo $lista["TIPTRIPDET_id"];?>" value="<?php echo $lista["TRIP_id"];?>"><?php echo utf8_encode($lista["TRIP_nombre"]." ".$lista["TRIP_apellido"]);?></option>'
                                <?php } ?>
                                + '</select>'
                            + '</div>'
                        + '</div>';
                $("#divAplicacion").append(html);
                $(document).ready(function() { $(".js-example-basic-single_extra").select2(); });
                $("#TIPTRIPDET_id_apli").chained("#TIPTRIP_id_apli");
                $("#TRIP_id_apli").chained("#TIPTRIPDET_id_apli");
            } else{
                $("#divTIPTRIP_id_apli").remove();
                $("#divTIPTRIPDET_id_apli").remove();
                $("#divTRIP_id_apli").remove();
            }
        }
        
        function activarEdadApli() {
            if ($("#aCONDESP_edad_apli").is(':checked')) {
                html = '<div class="col-md-12" style="padding-bottom: 10px;" id="divCONDESP_indiedad_apli">'
                            + '<label for="CONDESP_indiedad_apli" class="col-md-5 control-label">Indicador Edad</label>'
                            + '<div class="col-md-7">'
                                + '<select name="CONDESP_indiedad_apli" id="CONDESP_indiedad_apli" class="form-control input-sm js-example-basic-single_extra" onchange="activarCONDESP_edad_apli();">'
                                    + '<option value="" selected>No Aplica</option>'
                                    + '<option value=">" >Mayor</option>'
                                    + '<option value="<" >Menor</option>'
                                    + '<option value="==" >Igual</option>'
                                    + '<option value=">=" >Mayor Igual</option>'
                                    + '<option value="<=" >Menor Igual</option>'
                                + '</select>'
                            + '</div>'
                        + '</div>'
                        + '<div class="col-md-12" style="padding-bottom: 10px;" id="divCONDESP_edad_apli">'
                            + '<label for="CONDESP_edad_apli" class="col-md-5 control-label">Por Edad (años)</label>'
                            + '<div class="col-md-7">'
                                + '<input type="text" name="CONDESP_edad_apli" id="CONDESP_edad_apli" placeholder="No Aplica" class="form-control input-sm numberEntero" style="text-transform: uppercase; width: 100% !important;" />'
                            + '</div>'
                        + '</div>';
                $("#divAplicacion").append(html);
                $(document).ready(function() { $(".js-example-basic-single_extra").select2(); });
            } else{
                $("#divCONDESP_edad_apli").remove();
                $("#divCONDESP_indiedad_apli").remove();
            }
        }
        
        function activarCiudadApli(){
            if ($("#aCIU_id_apli").is(':checked')) {
                html = '<div class="col-md-12" style="padding-bottom: 10px;" id="divCIU_id_apli">'
                            + '<label for="CIU_id_apli" class="col-md-5 control-label">Por Ciudad</label>'
                            + '<div class="col-md-7">'
                                + '<select name="CIU_id_apli" id="CIU_id_apli" class="form-control input-sm js-example-basic-single_extra" >'
                                    + '<option value="" selected>No Aplica</option>'
                                    + '<option value="*">Todas las Ciudades</option>'
                                <?php foreach($this->objCiudad as $lista){ ?>
                                    + '<option value="<?php echo $lista["CIU_id"];?>"><?php echo utf8_encode($lista["CIU_nombre"]);?></option>'
                                <?php } ?>
                                + '</select>'
                            + '</div>'
                        + '</div>';
                $("#divAplicacion").append(html);
                $(document).ready(function() { $(".js-example-basic-single_extra").select2(); });
            } else{
                $("#divCIU_id_apli").remove();
            }
        }
        
        function activarRutaApli(){
            if ($("#aRUT_num_vuelo_apli").is(':checked')) {
                html = '<div class="col-md-12" style="padding-bottom: 10px;" id="divRUT_num_vuelo_apli">'
                            + '<label for="RUT_num_vuelo_apli" class="col-md-5 control-label">Por Ruta</label>'
                            + '<div class="col-md-7">'
                                + '<select name="RUT_num_vuelo_apli" id="RUT_num_vuelo_apli" class="form-control input-sm js-example-basic-single_extra" >'
                                    + '<option value="" selected>No Aplica</option>'
                                    + '<option value="*">Todas las Rutas</option>'
                                <?php foreach($this->objRuta as $lista){ ?>
                                    + '<option value="<?php echo $lista["RUT_num_vuelo"];?>"><?php echo utf8_encode($lista["CIU_id_origen"]." -".$lista["CIU_id_destino"]);?></option>'
                                <?php } ?>
                                + '</select>'
                            + '</div>'
                        + '</div>';
                $("#divAplicacion").append(html);
                $(document).ready(function() { $(".js-example-basic-single_extra").select2(); });
            } else{
                $("#divRUT_num_vuelo_apli").remove();
            }
        }
        
        function activarInglesApli(){
            if ($("#aNIVING_id_apli").is(':checked')) {
                html = '<div class="col-md-12" style="padding-bottom: 10px;" id="divNIVING_id">'
                            + '<label for="NIVING_id" class="col-md-5 control-label">Niv. de Ingles:</label>'
                            + '<div class="col-md-6">'
                                + '<select name="NIVING_id" id="NIVING_id" class="form-control input-sm js-example-basic-single_extra" >'
                                    + '<option value="" selected>No Aplica</option>'
                                <?php foreach($this->objTripNivIngles as $lista){ ?>
                                    + '<option value="<?php echo $lista["NIVING_id"];?>"><?php echo ($lista["NIVING_descripcion"]);?></option>'
                                <?php } ?>
                                + '</select>'
                            + '</div>'
                        + '</div>';
                $("#divAplicacion").append(html);
                $(document).ready(function() { $(".js-example-basic-single_extra").select2(); });
            } else{
                $("#divNIVING_id").remove();
            }
        }
                
        function insertCondicion(){
            var url = "<?php echo URLLOGICA?>condicion/insertCondicion/";
            $("#preloader").css("display","block");
            
            if(validate_formCondicion()) {
                var parametros = {
                    "TIPTRIP_id" : $("#TIPTRIP_id").val(),
                    "TIPTRIPDET_id" : $("#TIPTRIPDET_id").val(),
                    "TRIP_id" : $("#TRIP_id").val(),
				    "CONDESP_edad" : $("#CONDESP_edad").val(),
				    "CONDESP_indiedad" : $("#CONDESP_indiedad").val(),
				    "CIU_id" : $("#CIU_id").val(),
				    "RUT_num_vuelo" : $("#RUT_num_vuelo").val(),
				    "NIVING_id" : $("#NIVING_id").val(),
				    "CONDESP_condicional" : $("#CONDESP_condicional").val(),
				    "CONDESP_estado" : $("#CONDESP_estado").val(),
                };
                if ($("#aTRIP_id_apli").is(':checked')) {
                    parametros["TRIP_id_apli"] = $("#TRIP_id_apli").val();
                }
                if ($("#aCONDESP_edad_apli").is(':checked')) {
                    parametros["CONDESP_edad_apli"] = $("#CONDESP_edad_apli").val();
                    parametros["CONDESP_indiedad_apli"] = $("#CONDESP_indiedad_apli").val();
                }
                if ($("#aCIU_id_apli").is(':checked')) {
                    parametros["CIU_id_apli"] = $("#CIU_id_apli").val();
                }
                if ($("#aRUT_num_vuelo_apli").is(':checked')) {
                    parametros["RUT_num_vuelo_apli"] = $("#RUT_num_vuelo_apli").val();
                }
                if ($("#aNIVING_id_apli").is(':checked')) {
                    parametros["NIVING_id_apli"] = $("#NIVING_id_apli").val();
                }
                
                $.post(url,parametros,
			    function(data){
                    if(data == ""){
                        alert("Hubo un error en el registro.");
                    } else {
                        limpiarFormCondicion();
                        $("#preloader").css("display", "none");
                        alert("Se ha registrado correctamente la Condición.");
                    }
                    $('#condicionRegistro').modal('hide');
                    location.reload(true);
                });
            } else{
                $("#preloader").css("display","none");
            }
        }
        
        function listarDetCondicion(CONDESP_id,accion){
            var url = "<?php echo URLLOGICA?>condicion/listarDetCondicion/";
            $("#preloader").css("display","block");
            
            $.post(url,
            {
                "CONDESP_id" : CONDESP_id
            },
            function(data){
                if(data == ""){
                    alert("Hubo un error al cargar la información.");
                } else {
                    $("#titleForm").text("Detalle de Condicion");
                    
                    $("#CONDESP_id").val(data[0]["CONDESP_id"]);
                    $("#TIPTRIP_id").val(data[0]["TIPTRIP_id"]).trigger('change.select2');
                    listarDetalleTrip('<?php echo URLLOGICA?>tripulante/listarTipoTripDetalle/');
                    setTimeout(function(){
                        $("#TIPTRIPDET_id").val(data[0]["TIPTRIPDET_id"]).trigger('change.select2');
                    },1000);
                    listarTripulantes('<?php echo URLLOGICA?>tripulante/listarTripulantes/','TIPTRIPDET_id');
                    setTimeout(function(){
                        $("#TRIP_id").val(data[0]["TRIP_id"]).trigger('change.select2');
                    },1000);
                    
                    $("#CONDESP_edad").val(data[0]["CONDESP_edad"]);
                    $("#CONDESP_indiedad").val(data[0]["CONDESP_indiedad"]).trigger('change.select2');
                    $("#CIU_id").val(data[0]["CIU_id"]).trigger('change.select2');
                    $("#RUT_num_vuelo").val(data[0]["RUT_num_vuelo"]).trigger('change.select2');
                    $("#NIVING_id").val(data[0]["NIVING_id"]).trigger('change.select2');
                    
                    $("#CONDESP_condicional").val(data[0]["CONDESP_condicional"]).trigger('change.select2');
                    $("#CONDESP_estado").val(data[0]["CONDESP_estado"]).trigger('change.select2');
                    
                    if(data[0]["TRIP_id_apli"]){
                        $("#aTRIP_id_apli").prop("checked",true);
                        activarTripulanteApli();
                        $("#TIPTRIP_id_apli").val(data[0]["TIPTRIP_id_apli"]).trigger('change.select2');
                        listarDetalleTrip_apli('<?php echo URLLOGICA?>tripulante/listarTipoTripDetalle/');
                        setTimeout(function(){
                            $("#TIPTRIPDET_id_apli").val(data[0]["TIPTRIPDET_id_apli"]).trigger('change.select2');
                        },1000);
                        listarTripulantes_apli('<?php echo URLLOGICA?>tripulante/listarTripulantes/','TIPTRIPDET_id');
                        setTimeout(function(){
                            $("#TRIP_id_apli").val(data[0]["TRIP_id_apli"]).trigger('change.select2');
                        },1000);
                    }
                    if(data[0]["CONDESP_edad_apli"]){
                        $("#aCONDESP_edad_apli").prop("checked",true);
                        activarEdadApli();
                        $("#CONDESP_edad_apli").val(data[0]["CONDESP_edad_apli"]);
                        $("#CONDESP_indiedad_apli").val(data[0]["CONDESP_indiedad_apli"]).trigger('change.select2');
                    }
                    if(data[0]["CIU_id_apli"]){
                        $("#aCIU_id_apli").prop("checked",true);
                        activarCiudadApli();
                        $("#CIU_id_apli").val(data[0]["CIU_id_apli"]).trigger('change.select2');
                    }
                    if(data[0]["RUT_num_vuelo_apli"]){
                        $("#aRUT_num_vuelo_apli").prop("checked",true);
                        activarRutaApli();
                        $("#RUT_num_vuelo_apli").val(data[0]["RUT_num_vuelo_apli"]).trigger('change.select2');
                    }
                    if(data[0]["NIVING_id_apli"]){
                        $("#aNIVING_id_apli").prop("checked",true);
                        activarInglesApli();
                        $("#NIVING_id_apli").val(data[0]["NIVING_id_apli"]).trigger('change.select2');
                    }
                    
                    $("#AUD_usu_cre").val(data[0]["AUD_usu_cre"]);
                    $("#AUD_fch_cre").val(data[0]["AUD_fch_cre"]);
                    $("#AUD_usu_mod").val(data[0]["AUD_usu_mod"]);
                    $("#AUD_fch_mod").val(data[0]["AUD_fch_mod"]);
                    if(accion == "listar"){
                        verFormCondicion();
                        if(data[0]["TRIP_id_apli"]){
                            $("#TIPTRIP_id_apli").prop("disabled","disabled");
                            $("#TIPTRIPDET_id_apli").prop("disabled","disabled");
                            $("#TRIP_id_apli").prop("disabled","disabled");
                        }
                        if(data[0]["CONDESP_edad_apli"]){
                            $("#CONDESP_edad_apli").prop("disabled","disabled");
                            $("#CONDESP_indiedad_apli").prop("disabled","disabled");
                        }
                        if(data[0]["CIU_id_apli"]){
                            $("#CIU_id_apli").prop("disabled","disabled");
                        }
                        if(data[0]["RUT_num_vuelo_apli"]){
                            $("#RUT_num_vuelo_apli").prop("disabled","disabled");
                        }
                        if(data[0]["NIVING_id_apli"]){
                            $("#NIVING_id_apli").prop("disabled","disabled");
                        }
                    } else {
                        $("#TIPTRIPDET_id").removeAttr("disabled");
                        $("#TRIP_id").removeAttr("disabled");
                        if(data[0]["TRIP_id_apli"]){
                            $("#TIPTRIP_id_apli").removeAttr("disabled");
                            $("#TIPTRIPDET_id_apli").removeAttr("disabled");
                            $("#TRIP_id_apli").removeAttr("disabled");
                        }
                        if(data[0]["CONDESP_edad_apli"]){
                            $("#CONDESP_edad_apli").removeAttr("disabled");
                            $("#CONDESP_indiedad_apli").removeAttr("disabled");
                        }
                        if(data[0]["CIU_id_apli"]){
                            $("#CIU_id_apli").removeAttr("disabled");
                        }
                        if(data[0]["RUT_num_vuelo_apli"]){
                            $("#RUT_num_vuelo_apli").removeAttr("disabled");
                        }
                        if(data[0]["NIVING_id_apli"]){
                            $("#NIVING_id_apli").removeAttr("disabled");
                        }
                        $("#insertCondicion").hide();
                        $("#updateCondicion").show();
                    }
                    $("#preloader").css("display", "none");
                }
            });
        }
        
        function updateCondicion(){
            var url = "<?php echo URLLOGICA?>condicion/updateCondicion/";
            $("#preloader").css("display","block");
            
            if(validate_formCondicion()) {
                var parametros = {
                    "CONDESP_id" : $("#CONDESP_id").val(),
                    "TIPTRIP_id" : $("#TIPTRIP_id").val(),
                    "TIPTRIPDET_id" : $("#TIPTRIPDET_id").val(),
                    "TRIP_id" : $("#TRIP_id").val(),
				    "CONDESP_edad" : $("#CONDESP_edad").val(),
				    "CONDESP_indiedad" : $("#CONDESP_indiedad").val(),
				    "CIU_id" : $("#CIU_id").val(),
				    "RUT_num_vuelo" : $("#RUT_num_vuelo").val(),
				    "NIVING_id" : $("#NIVING_id").val(),
				    "CONDESP_condicional" : $("#CONDESP_condicional").val(),
				    "CONDESP_estado" : $("#CONDESP_estado").val(),
                };
                if ($("#aTRIP_id_apli").is(':checked')) {
                    parametros["TRIP_id_apli"] = $("#TRIP_id_apli").val();
                }
                if ($("#aCONDESP_edad_apli").is(':checked')) {
                    parametros["CONDESP_edad_apli"] = $("#CONDESP_edad_apli").val();
                    parametros["CONDESP_indiedad_apli"] = $("#CONDESP_indiedad_apli").val();
                }
                if ($("#aCIU_id_apli").is(':checked')) {
                    parametros["CIU_id_apli"] = $("#CIU_id_apli").val();
                }
                if ($("#aRUT_num_vuelo_apli").is(':checked')) {
                    parametros["RUT_num_vuelo_apli"] = $("#RUT_num_vuelo_apli").val();
                }
                if ($("#aNIVING_id_apli").is(':checked')) {
                    parametros["NIVING_id_apli"] = $("#NIVING_id_apli").val();
                }
                
                $.post(url,parametros,
                function(data){
                    if(data == ""){
                        alert("Hubo un error en la modificación de la Información.");
                    } else {
                        limpiarFormAusencia();
                        $("#preloader").css("display", "none");
                        alert("Se ha modificado correctamente la Condición.");
                    }
                    $('#condicionRegistro').modal('hide')
                    location.reload(true);
                });
            } else{
                $("#preloader").css("display","none");
            }
        }
        
        $('#condicionRegistro').on('show.bs.modal', function (e) {
            $("#updateCondicion").hide();
        })
        $('#condicionRegistro').on('hidden.bs.modal', function (e) {
            limpiarFormCondicion();
        })
    </script>
    <!-- /.content-wrapper -->
    <?php include "footer_view.php";?>
