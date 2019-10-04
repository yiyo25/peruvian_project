<?php include "header_view.php";?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
				Gestionar de Reservas <small>Administrar Reservas</small>
            </h1>
            <ol class="breadcrumb">
                <li><i class="fa fa-thumb-tack"></i> Reservas</li>
                <li class="active">
                    Listado de Reservas
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
                        <form method="post" action="<?php echo URLLOGICA?>reserva/buscarResumenReserva/" onsubmit="document.forms['buscar']['buscar'].disabled=true;" name="buscar">
                            <div class="form-group">
                                <label for="bRES_fch" class="col-md-2 control-label">Fch. de Reserva </label>
                                <div class="col-md-2">
                                    <div class='input-group date datetimepicker1'>
                                        <input type="text" name="bRES_fch" id="bRES_fch" value="<?php if($_SESSION["RES_fch"] != '') { echo $_SESSION["RES_fch"]; } else { echo date("d/m/Y"); }?>" class="form-control input-sm" style="text-transform: uppercase; width: 100% !important;" />
                                        <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-calendar"></span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="row-fluid">
                                <div class="form-group">
                                    <label for="bTRIP_apellido" class="col-md-2 control-label">Apellido</label>
                                    <div class="col-md-2">
                                        <input type="text" name="bTRIP_apellido" id="bTRIP_apellido" value="<?php if(isset($_SESSION["TRIP_apellido"])) { echo $_SESSION["TRIP_apellido"]; } else { echo ""; }?>" class="form-control input-sm" style="text-transform: uppercase;" />
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="bTRIP_numlicencia" class="col-md-2 control-label">N° de Licencia</label>
                                <div class="col-md-2">
                                    <input type="text" name="bTRIP_numlicencia" id="bTRIP_numlicencia" value="<?php if(isset($_SESSION["TRIP_numlicencia"])) { echo $_SESSION["TRIP_numlicencia"]; } else { echo ""; }?>" class="form-control input-sm numberEntero" style="text-transform: uppercase;" />
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
                                <button type="button" name="limpiar" class="btn btn-danger btn-block" onclick="resetFormAusencia('<?php echo URLLOGICA?>reserva/listarResumenReserva/');"> Limpiar </button>
                            </div>
                            <div class="clearfix" style="padding: 4px;"></div>
                    </div>
                    <div id="MainContent_listaPro" class="panel panel-default">
                        <div class="panel-heading clearfix" style="padding: 5px !important">
                            <span id="MainContent_tituloPro"><strong>Lista de Reservas</strong></span>
                            <?php  $Bdisabled = 0; ?>
                            <?php foreach ($this->objBotton as $botton) { ?>
                                <?php if($botton["Funcion"] == "insertReserva"){ ?>
                                    <?php  $Bdisabled += 1; ?>
                                <?php } ?>
                            <?php } ?>
                            <?php if($Bdisabled > 0){ $disabled = ""; } else { $disabled = "disabled"; } ?>
                                <button type="button" class="pull-right fa fa-child" data-toggle="modal" data-target="#reservaRegistro" <?php echo $disabled;?>></button>
                        </div>
                        <div class="area_resultado table-responsive">
                            <table id="listaReserva" class="display myDataTables" cellspacing="0" cellpadding="2">
                                <thead>
                                    <tr>
                                        <th scope="col">Item</th>
                                        <th scope="col">Fecha Reserva</th>
                                        <th scope="col">Cant. Tripulantes</th>
                                        <th scope="col">Ver</th>
                                        <th scope="col">Editar</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (count($this->objResumenReserva) > 0) { ?>
                                        <?php $item = 1; ?>
                                        <?php foreach ($this->objResumenReserva as $lista) { ?>
                                    <tr>
                                        <td style="width:auto;"><?php echo $item;?></td>
                                        <td style="width:auto;"><?php echo $lista["RES_fch"];?></td>
                                        <td style="width:auto;"><?php echo $lista["RES_afectados"];?></td>
                                        <td style="width:auto;">
                                            <?php  $Bdisabled = 0; ?>
                                            <?php foreach ($this->objBotton as $botton) { ?>
                                                <?php if($botton["Funcion"] == "listarReserva"){ ?>
                                                    <?php  $Bdisabled += 1; ?>
                                                <?php } ?>
                                            <?php } ?>
                                            <?php if($Bdisabled > 0){ $disabled = ""; } else { $disabled = "disabled"; } ?>
                                                <button type="button" class="fa fa-eye" data-toggle="modal"  data-target="#reservaRegistro" onclick="listarDetReserva(<?php echo utf8_encode($lista["RES_id"]);?>,'listar')" <?php echo $disabled;?>></button>
                                        </td>
                                        <td style="width:auto;">
                                            <?php  $Bdisabled = 0; ?>
                                            <?php foreach ($this->objBotton as $botton) { ?>
                                                <?php if($botton["Funcion"] == "updateReserva"){ ?>
                                                    <?php  $Bdisabled += 1; ?>
                                                <?php } ?>
                                            <?php } ?>
                                            <?php if($Bdisabled > 0){ $disabled = ""; } else { $disabled = "disabled"; } ?>
                                                <button type="button" class="fa fa-pencil" data-toggle="modal"  data-target="#reservaRegistro" onclick="listarDetReserva(<?php echo utf8_encode($lista["RES_id"]);?>,'modificar')" <?php echo $disabled;?>></button>
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
    <div id="reservaRegistro" class="modal fade" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header" style="padding: 10px !important">
                    <table class="col-xs-12">
                        <tr>
                            <td style="text-align:left;">
                                <h4><strong id="titleForm">Ingresar la Tripulación</strong></h4>
                            </td>
                            <td>
                                <button type="button" class="close btn-lg" data-dismiss="modal" onclick="limpiarFormReserva();" style="background-color: red; color:white; margin:10px; padding: 0px 6px 2px 6px;text-align:right;">
                                    <span aria-hidden="true">&times;</span><span class="sr-only">Cerrar</span>
                                </button>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="modal-body" style="padding-bottom: 10px !important">
                    <div class="row">
                        <div class="col-md-12" style="padding-bottom: 10px;">
                            <label for="RES_fch" class="col-md-4 control-label">Fch. de Programación </label>
                            <div class="col-md-7">
                                <div class='input-group date datetimepicker1' id="divRES_fch">
                                    <input type="hidden" name="RES_id" id="RES_id" value="" />
                                    <input type="text" name="bITI_fch" id="bITI_fch" value="<?php echo date("d/m/Y");?>" class="form-control input-sm" style="width: 100% !important;"  />
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12" style="padding-bottom: 10px;">
                            <label for="TRIP_id_Piloto" class="col-md-4 control-label">Piloto:
                            <span style="color: #FF0000" id="asteriscoPiloto"><strong>*</strong></span></label>
                            <div class="col-md-7">
                                <select name="TRIP_id_Piloto" id="TRIP_id_Piloto" class="form-control input-sm js-example-basic-single" onchange="validarCopilotoxPiloto('<?php echo URLLOGICA?>motor/listarTripulantesMotor/','1');" disabled="disabled">
                                    <option value="" selected>Seleccionar Piloto</option>
                                <?php foreach($this->objTripVuelo as $lista){ ?>
                                    <option value="<?php echo $lista["TRIP_id"];?>"><?php echo utf8_encode($lista["TRIP_nombre"]." ".$lista["TRIP_apellido"]);?></option>
                                <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12" style="padding-bottom: 10px;">
                            <label for="TRIP_id_Copiloto" class="col-md-4 control-label">Copiloto:
                            <span style="color: #FF0000" id="asteriscoCopiloto"><strong>*</strong></span></label>
                            <div class="col-md-7">
                                <select name="TRIP_id_Copiloto" id="TRIP_id_Copiloto" class="form-control input-sm js-example-basic-single" disabled="disabled">
                                    <option value="" selected>Seleccionar Copiloto</option>
                                <?php foreach($this->objTripVuelo as $lista){ ?>
                                    <option value="<?php echo $lista["TRIP_id"];?>"><?php echo utf8_encode($lista["TRIP_nombre"]." ".$lista["TRIP_apellido"]);?></option>
                                <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12" style="padding-bottom: 10px;">
                            <label for="TRIP_id_JejeCabina" class="col-md-4 control-label">Jefe de Cabina:
                            <span style="color: #FF0000"><strong>*</strong></span></label>
                            <div class="col-md-7">
                                <select name="TRIP_id_JejeCabina" id="TRIP_id_JejeCabina" class="form-control input-sm js-example-basic-single" disabled="disabled">
                                    <option value="" selected>Seleccionar Jefe Cabina</option>
                                <?php foreach($this->objTripCabina as $lista){ ?>
                                    <option value="<?php echo $lista["TRIP_id"];?>"><?php echo utf8_encode($lista["TRIP_nombre"]." ".$lista["TRIP_apellido"]);?></option>
                                <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12" style="padding-bottom: 10px;">
                            <label for="TRIP_id_TripCabina" class="col-md-4 control-label">Tripulante de Cabina
                            <span style="color: #FF0000"><strong>*</strong></span></label>
                            <div class="col-md-7" id="divTripCabina">
                                <div class="col-xs-8 col-md-8" style="padding: 0px">
                                    <select name="TRIP_id_TripCabina1" id="TRIP_id_TripCabina1" class="form-control input-sm js-example-basic-single" disabled="disabled">
                                        <option value="" selected>Seleccionar Trip. Cabina</option>
                                    <?php foreach($this->objTripCabina as $lista){ ?>
                                        <option value="<?php echo $lista["TRIP_id"];?>"><?php echo utf8_encode($lista["TRIP_nombre"]." ".$lista["TRIP_apellido"]);?></option>
                                    <?php } ?>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <span class="input-group-btn">
                                        <input name="num-TripCabina" id="num-TripCabina" value="1" type="hidden">
                                        <button id="agregar_TripCabina" class="btn btn-default input-group-abdon" type="button" onclick="agregar_TripCabina()" style="color:green" disabled>
                                            <span class="glyphicon glyphicon-plus"></span>
                                        </button>
                                        <button id="quitar_TripCabina" class="btn btn-default input-group-abdon" type="button" onclick="quitar_TripCabina()" style="color:red" disabled>
                                            <span class="glyphicon glyphicon-minus"></span>
                                        </button>
                                    </span>
                                </div>
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
                    <button name='insertReserva' id='insertReserva' type="button" class="btn btn-sm" onclick="insertReserva('insert','<?php echo URLLOGICA?>reserva/insertReserva/');">Grabar</button>
                    <button name='updateReserva' id='updateReserva' type="button" class="btn btn-sm" onclick="insertReserva('update','<?php echo URLLOGICA?>reserva/insertReserva/');">Modificar</button>
                    <button name="closeReserva" id="closeReserva" type="button" class="btn btn-danger btn-sm" data-dismiss="modal" onclick="limpiarFormReserva();">Cerrar</button>
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
        
        function listarTripulantesMotorView(){
            listarTripulantesMotor('<?php echo URLLOGICA?>motor/listarTripulantesMotor/','','','','2','1');
        }
        
        function listarCabinaView(newnum,TIPTRIPU_id_cabina,TIPTRIPU_id_piloto){
            listarCabina('<?php echo URLLOGICA?>motor/listarTripulantesMotor/',newnum,TIPTRIPU_id_cabina,TIPTRIPU_id_piloto);
        }
        
        function listarDetReserva(RES_id,accion){
            var url = "<?php echo URLLOGICA?>reserva/listarDetReserva/";
            $("#preloader").css("display","block");
            
            $.post(url,
            {
                "RES_id" : RES_id
            },
            function(data){
                if(data == ""){
                    alert("Hubo un error al cargar la información.");
                } else {
                    $("#titleForm").text("Detalle de Reserva");
                    
                    $("#RES_id").val(RES_id);
                    
                    /*var TRIP_id = '';
                    var ITI_id = '';
                    var RUT_num_vuelo = '';
                    var TIPTRIPU_id_cabina = '';
                    var TIPTRIPU_id_piloto = '';
                    listarTripulantesMotor('<?php //echo URLLOGICA?>motor/listarTripulantesMotorView/',ITI_id,TRIP_id,RUT_num_vuelo,TIPTRIPU_id_cabina,TIPTRIPU_id_piloto);*/
                    $("#bITI_fch").val(data[0]["RES_fch"]);
                    listarTripulantesMotorView();
                    
                    var q = 0;
                    var p = {};
                    for (var i = 0; i < data.length; i++) {
                        if(data[i]["RES_descripcion"] == "Piloto"){
                            var k = i;
                            setTimeout(function(){
                                $("#TRIP_id_Piloto").val(data[k]["TRIP_id"]).trigger('change.select2');
                            },1000);
                        }
                        else if(data[i]["RES_descripcion"] == "Copiloto"){
                            var l = i;
                            setTimeout(function(){
                                $("#TRIP_id_Copiloto").val(data[l]["TRIP_id"]).trigger('change.select2');
                            },1500);
                        }
                        else if(data[i]["RES_descripcion"] == "JefeCabina"){
                            var m = i;
                            setTimeout(function(){
                                $("#TRIP_id_JejeCabina").val(data[m]["TRIP_id"]).trigger('change.select2');
                            },1000);
                        }
                        else {
                            q++;
                            if(q < 2){
                                var o = i;
                                setTimeout(function(){
                                    $("#TRIP_id_TripCabina1").val(data[o]["TRIP_id"]).trigger('change.select2');
                                },1000);
                            }
                            if(q > 1){
                                p[q] = i;
                                agregar_TripCabina();
                                setTimeout(function(){
                                    for(var r = 2; r <= q; r++){
                                        var s = p[r];
                                        $("#TRIP_id_TripCabina" + r).val(data[s]["TRIP_id"]).trigger('change.select2');
                                    }
                                },1000);
                            }
                        }
                    }
                    
                    $("#AUD_usu_cre").val(data[0]["AUD_usu_cre"]);
                    $("#AUD_fch_cre").val(data[0]["AUD_fch_cre"]);
                    $("#AUD_usu_mod").val(data[0]["AUD_usu_mod"]);
                    $("#AUD_fch_mod").val(data[0]["AUD_fch_mod"]);
                    if(accion == "listar"){
                        $("#agregar_TripCabina").prop("disabled","disabled");
                        $("#quitar_TripCabina").prop("disabled","disabled");
                        $("#insertReserva").show();
                        verFormReserva();
                    } else {
                        $("#TRIP_id_Piloto").removeAttr("disabled");
                        $("#TRIP_id_Copiloto").removeAttr("disabled");
                        $("#TRIP_id_JejeCabina").removeAttr("disabled");
                        $("#TRIP_id_TripCabina1").removeAttr("disabled");
                        $("#agregar_TripCabina").removeAttr("disabled");
                        $("#quitar_TripCabina").removeAttr("disabled");
                        $("#insertReserva").hide();
                        $("#updateReserva").show();
                    }
                };
            });
            
            $("#preloader").css("display","none");
        }
        
        /*function listarComboDetalleTripView(){
            listarComboDetalleTrip('<?php //echo URLLOGICA?>detalle/listarTipoTripDetalle/');
        }
        
        function listarComboTripulanteView(select){
            listarComboTripulante('<?php //echo URLLOGICA?>tripulante/listarTripulantes/',select);
        }*/
    </script>
    <!-- /.content-wrapper -->
    <?php include "footer_view.php";?>
