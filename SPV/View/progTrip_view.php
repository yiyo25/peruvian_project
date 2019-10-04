<?php include "header_view.php";?>
<div class="preloaderMotor" id="preloaderMotor"></div>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
				Gestionar de Programación <small>Administrar Programación.</small>
            </h1>
            <ol class="breadcrumb">
                <li><i class="fa fa-thumb-tack"></i> Programación por Tripulante.</li>
                <li class="active"></li>
            </ol>
        </section>
        <!-- Main content -->
        <section class="content">
            <div class='box box-danger'>
                <div class="box-body">
                    <div id="MainContent_Div1" class="panel panel-default col-md-8">
                        <div class="panel-heading clearfix"  style="padding: 5px !important">
                            <span><strong>Buscar en Plantilla</strong></span>
                        </div>
                    <form method="post" action="<?php echo URLLOGICA?>programacion/resumenProgrTrip/" onsubmit="document.forms['buscar']['buscar'].disabled=true;" name="buscar">
                        <div class="row-fluid">
                            <div class="form-group">
                                <label for="bPROG_fch_Mes" class="col-md-2 control-label">Mes de Prog.</label>
                                <div class="col-md-2">
                                    <select name="bPROG_fch_Mes" id="bPROG_fch_Mes" class="form-control input-sm js-example-basic-single" required >
                                        <option value="" selected>Seleccionar Mes</option>
                                    <?php foreach($this->objMes as $lista){ ?>
                                        <?php $selected = "";?>
                                        <?php if(isset($_SESSION["PROG_fch_Mes"])) { ?>
                                            <?php if($_SESSION["PROG_fch_Mes"] == $lista["MES_id"]) { ?>
                                                <?php $selected = "selected";?>
                                            <?php } ?>
                                        <?php } ?>
                                        <option value="<?php echo $lista["MES_id"];?>" <?php echo $selected;?>><?php echo utf8_encode(($lista["MES_descripcion"]));?></option>
                                    <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="bPROG_fch_Anio" class="col-md-2 control-label">Año de Prog.</label>
                                <div class="col-md-2">
                                    <select name="bPROG_fch_Anio" id="bPROG_fch_Anio" class="form-control input-sm js-example-basic-single" required >
                                        <option value="" selected>Seleccionar Mes</option>
                                    <?php foreach($this->objAnio as $lista){ ?>
                                        <?php $selected = "";?>
                                        <?php if(isset($_SESSION["PROG_fch_Anio"])) { ?>
                                            <?php if($_SESSION["PROG_fch_Anio"] == $lista["ANIO_descripcion"]) { ?>
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
                                <div class="col-md-2">
                                    <button type="button" name="limpiar" class="btn btn-danger btn-block" onclick="resetFormApto('<?php echo URLLOGICA?>programacion/resumenProgrTrip/');"> Limpiar Campos</button>
                                </div>
                            </div>
                        </div>
                    </form>
                        <div class="clearfix" style="padding: 5px;"></div>
                        <div class="row-fluid">
                            <div class="form-group">
                                <label for="TIP_trabajo" class="col-md-2 control-label">Modo de Trabajo</label>
                                <div class="col-md-2">
                                    <?php 
                                    $disabled = '';
                                    $activo = 'OBSERVAR';
                                    $colorActivo = 'success';

                                    $inactivo = 'REPROGRAMAR';
                                    $colorInactivo = 'info';
                                    $checked = "checked";

                                    if($this->objModoTrabajo[0]["FLAG_estado"] == '1' and $this->objModoTrabajo[0]["AUD_usu_cre"] == $this->objUsu["Usuario"]){  
                                        $checked = '';
                                    } else if($this->objModoTrabajo[0]["FLAG_estado"] == '1' and $this->objModoTrabajo[0]["AUD_usu_cre"] != $this->objUsu["Usuario"]){
                                        $disabled2 = 'disabled';
                                        $checked = 'checked="checked"';
                                    }
                                    ?>

                                    <?php  $Bdisabled = 0; ?>
                                    <?php foreach ($this->objBotton as $botton) { ?>
                                        <?php if($botton["Funcion"] == "swicthProgramacion"){ ?>
                                            <?php  $Bdisabled += 1; ?>
                                        <?php } ?>
                                    <?php } ?>
                                    <?php if($Bdisabled > 0){ $disabled = ""; } else { $disabled = "disabled"; } ?>

                                    <input type="checkbox" id="TIP_trabajo" data-toggle="toggle" data-on="<?php echo $activo;?>" data-off="<?php echo $inactivo;?>" data-onstyle="<?php echo $colorActivo;?>" data-offstyle="<?php echo $colorInactivo;?>" <?php echo $disabled;?> <?php echo $disabled2;?> onchange="insertEstadoFlag();" <?php echo $checked?>>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="TIP_procesar" class="col-md-2 control-label">Descargar Excel</label>
                                <div class="col-md-2">
                                    <a id="excelProgramacion" href="<?php echo URLLOGICA;?>excel/progrDiaxTrip_excel/<?php echo $this->fechaInicio;?>" class="logo">
                                        <img src="<?php echo URLPUBLIC;?>/img/excel.png" />
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="clearfix" style="padding: 5px;"></div>
                        <div class="row-fluid">
                            <div class="form-group">
                                <label for="TIP_procesar" class="col-md-2 control-label">Procesar</label>
                                <div class="col-md-2">
                                    <button type="button" name="procesoProgMensual" class="btn btn-danger btn-block" onclick="procesoProgMensual();" style="background: #32c0d6">
                                        <i class="fa fa-cogs"></i>
                                        <span>Procesar</span>
                                    </button>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="TIP_procesar" class="col-md-2 control-label">Enviar Correo</label>
                                <div class="col-md-2">
                                    <button type="button" class="fa fa-envelope" onclick="enviarCorreoProgrxDia('<?php echo $this->fechaInicio;?>')"></button>
                            <input type="hidden" name="TIPTRIPDET_idHidden" id="TIPTRIPDET_idHidden" value="1" />
                                </div>
                            </div>
                        </div>
                        <div class="clearfix" style="padding: 5px;"></div>
                    </div>
                    <div id="MainContent_Div1" class="panel panel-default col-md-4 ">
                        <div class="panel-heading clearfix"  style="padding: 5px !important">
                            <span><strong>Buscar Detalle</strong></span>
                        </div>
                        <div class="row-fluid">
                            <div class="form-group">
                                <label for="bITI_fch" class="col-md-6 control-label">Fecha </label>
                                <div class="col-md-6">
                                    <div class='input-group date datetimepicker1'>
                                        <input type="text" name="bITI_fch" id="bITI_fch" value="<?php if(isset($_SESSION["bITI_fch"])) { echo $_SESSION["bITI_fch"]; } else { echo ""; }?>" class="form-control input-sm" style="text-transform: uppercase; width: 100% !important;" />
                                        <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-calendar"></span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="clearfix" style="padding: 5px;"></div>
                        <div class="row-fluid">
                            <div class="form-group">
                                <label for="bRUT_num_vuelo" class="col-md-6 control-label">N° de Ruta</label>
                                <div class="col-md-6">
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
                        </div>
                        <div class="clearfix" style="padding: 5px;"></div>
                        <div class="row-fluid">
                            <div class="form-group">
                                <div class="col-md-6">
                                    <button type="button" name="PROG_fchxRuta" class="btn btn-danger btn-block" onclick="listarDetProgramacion();"> Buscar </button>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-6">
                                    <button type="button" name="limpiar" class="btn btn-danger btn-block" onclick="resetFormApto('<?php echo URLLOGICA?>programacion/resumenProgrTrip/');"> Limpiar Campos</button>
                                </div>
                            </div>
                        </div>
                        <div class="clearfix" style="padding: 11px;"></div>
                    </div>
                    <div class="clearfix" style="padding: 5px;"></div>
                    <div id="MainContent_listaPro" class="panel panel-default">
                        <div class="panel-heading clearfix" style="padding: 7px !important">
                            <div class="col-xs-12 col-md-3">
                                <span id="MainContent_tituloPro"><strong>Lista de Tripulantes por Día</strong></span>
                            </div>
                            <!--<div class="col-xs-12 col-md-3 col-md-offset-3">
                                <label for="TIP_trabajo" class="col-xs-4 col-md-6 control-label">Modo de Trabajo</label>
                                <div class="col-xs-6 col-md-6">
                                    <?php 
                                    $disabled = '';
                                    $activo = 'OBSERVAR';
                                    $colorActivo = 'success';
                                                
                                    $inactivo = 'REPROGRAMAR';
                                    $colorInactivo = 'info';
                                    $checked = "checked";
                                    
                                    if($this->objModoTrabajo[0]["FLAG_estado"] == '1' and $this->objModoTrabajo[0]["AUD_usu_cre"] == $this->objUsu["Usuario"]){  
                                        $checked = '';
                                    } else if($this->objModoTrabajo[0]["FLAG_estado"] == '1' and $this->objModoTrabajo[0]["AUD_usu_cre"] != $this->objUsu["Usuario"]){
                                        $disabled2 = 'disabled';
                                        $checked = 'checked="checked"';
                                    }
                                    ?>
                                    
                                    <?php  $Bdisabled = 0; ?>
                                    <?php foreach ($this->objBotton as $botton) { ?>
                                        <?php if($botton["Funcion"] == "swicthProgramacion"){ ?>
                                            <?php  $Bdisabled += 1; ?>
                                        <?php } ?>
                                    <?php } ?>
                                    <?php if($Bdisabled > 0){ $disabled = ""; } else { $disabled = "disabled"; } ?>
                                    
                                    <input type="checkbox" id="TIP_trabajo" data-toggle="toggle" data-on="<?php echo $activo;?>" data-off="<?php echo $inactivo;?>" data-onstyle="<?php echo $colorActivo;?>" data-offstyle="<?php echo $colorInactivo;?>" <?php echo $disabled;?> <?php echo $disabled2;?> onchange="insertEstadoFlag();" <?php echo $checked?>>
                                </div>
                            </div>
                            <div class="col-xs-6 col-md-2">
                                <button type="button" name="procesoProgMensual" class="btn btn-danger btn-block" onclick="procesoProgMensual();" style="background: #32c0d6">
                                    <i class="fa fa-cogs"></i>
                                    <span>Procesar</span>
                                </button>
                            </div>
                            <div class="col-xs-6 col-md-1">
                                <a id="excelProgramacion" href="<?php echo URLLOGICA;?>excel/progrDiaxTrip_excel/<?php echo $this->fechaInicio;?>" class="logo">
                                    <img src="<?php echo URLPUBLIC;?>/img/excel.png" />
                                </a>
                                <button type="button" class="fa fa-envelope" onclick="enviarCorreoProgrxDia('<?php echo $this->fechaInicio;?>')"></button>
                                <input type="hidden" name="TIPTRIPDET_idHidden" id="TIPTRIPDET_idHidden" value="1" />
                            </div>-->
                        </div>
                        <!--<div class="clearfix" style="padding: 7px !important">
                            <div class="col-xs-6 col-md-1">
                                <button type="button" name="anteriorDiaProgxDia" id="anteriorDiaProgxDia" class="fa fa-arrow-left" onclick="anteriorDiaProgxDia();"></button>
                            </div>
                            <div class="col-xs-6 col-md-1 col-md-offset-10">
                                <button type="button" name="siguienteDiaProgxDia" id="siguienteDiaProgxDia" class="fa fa-arrow-right" onclick="siguienteDiaProgxDia();"></button>
                            </div>
                        </div>-->
                        <?php                                           
                            $nomMesAnio = strtoupper(strftime('%B del %Y',strtotime($this->fechaInicio)));
                            
                            $cantDias = 0;
                            for($j=$this->fecha_antes;$j<=$this->fecha_despues;$j = date("Y-m-d", strtotime($j ."+ 1 days"))){
                                $cantDias++;
                            }

                            $Vfecha_actual = explode('-',$this->fechaInicio);
                            $Vfecha_antes = explode('-',$this->fecha_antes);
                            $Vfecha_despues = explode('-',$this->fecha_despues);
                        ?>
                        <input type="hidden" name="fecha_actual" id="fecha_actual" value="<?php echo $this->fechaInicio; ?>" />
                        <input type="hidden" name="fecha_antes" id="fecha_antes" value="<?php echo $this->fecha_antes; ?>" />
                        <input type="hidden" name="fecha_despues" id="fecha_despues" value="<?php echo $this->fecha_despues; ?>" />
                        
                        <!-- Nav tabs -->
                        <!--<ul class="nav nav-tabs" role="tablist">
                            <li role="presentation" class="active"><a href="#example1-tab1" onclick="listarTripxDia('1');" aria-controls="example1-tab1" role="tab" data-toggle="tab">Piloto</a></li>
                            <li role="presentation">               <a href="#example1-tab2" onclick="listarTripxDia('2');" aria-controls="example1-tab2" role="tab" data-toggle="tab">Copiloto</a></li>
                            <li role="presentation">               <a href="#example1-tab3" onclick="listarTripxDia('8');" aria-controls="example1-tab3" role="tab" data-toggle="tab">Jefe Cabina</a></li>
                            <li role="presentation">               <a href="#example1-tab4" onclick="listarTripxDia('5');" aria-controls="example1-tab4" role="tab" data-toggle="tab">Trip. Cabina</a></li>
                        </ul>-->
                        <ul class="nav nav-tabs" role="tablist">
                            <?php  $Bdisabled_Pi = 0; ?>
                            <?php foreach ($this->objTab as $botton) { ?>
                                <?php if($botton["Funcion"] == "TabpilotoProg"){ ?>
                                    <?php  $Bdisabled_Pi += 1; ?>
                           <?php } ?>
                                    <?php } ?>
                            <?php if($Bdisabled_Pi > 0){ $activePi = ''; $disabled_Pi = ""; } else { $disabled_Pi = "style='display:none'"; } ?>				
                            <li id="Tab_piloto" role="presentation" class="active" <?php echo $disabled_Pi;?>><a href="#example1-tab1" onclick="listarTripxDia('1');" aria-controls="example1-tab1" role="tab" data-toggle="tab" >Piloto</a></li>
                            <?php  $Bdisabled_Co = 0; ?>
                                    <?php foreach ($this->objTab as $botton) { ?>
                                        <?php if($botton["Funcion"] == "TabcopilotoProg"){ ?>
                                            <?php  $Bdisabled_Co += 1; ?>
                                   <?php } ?>
                            <?php } ?>
                            <?php if($Bdisabled_Co > 0){ $disabled_Co = ""; } else { $disabled_Co = "style='display:none'"; } ?>	
                            <li id="Tab_copiloto" role="presentation" <?php echo $disabled_Co;?> >               <a href="#example1-tab2" onclick="listarTripxDia('2');" aria-controls="example1-tab2" role="tab" data-toggle="tab" >Copiloto</a></li>
                                  <?php  $Bdisabled_Jc = 0; ?>
                                            <?php foreach ($this->objTab as $botton) { ?>
                                                <?php if($botton["Funcion"] == "TabjefecabinProg"){ ?>
                                                    <?php  $Bdisabled_Jc += 1; ?>
                                           <?php } ?>
                                    <?php } ?>
                            <?php if($Bdisabled_Jc > 0){ $disabled_Jc = ""; } else { $disabled_Jc = "style='display:none'"; } ?>	
                            <li id="Tab_jefecabina" role="presentation" <?php echo $disabled_Jc;?> >               <a href="#example1-tab3" onclick="listarTripxDia('8');" aria-controls="example1-tab3" role="tab" data-toggle="tab" >Jefe Cabina</a></li>
                               <?php  $Bdisabled_Tc = 0; ?>
                                            <?php foreach ($this->objTab as $botton) { ?>
                                                <?php if($botton["Funcion"] == "TabtripcabinaProg"){ ?>
                                                    <?php  $Bdisabled_Tc += 1; ?>
                                           <?php } ?>
                                    <?php } ?>
                            <?php if($Bdisabled_Tc > 0){ $disabled_Tc = ""; } else { $disabled_Tc = "style='display:none'"; } ?>	
                            <li id="Tab_tripcabina" role="presentation" <?php echo $disabled_Tc;?> >               <a href="#example1-tab4" onclick="listarTripxDia('5');" aria-controls="example1-tab4" role="tab" data-toggle="tab" >Trip. Cabina</a></li>
                        </ul>
                        
                        <input type="hidden" value="<?php echo $disabled_Pi;?>" id="tab_Piloto" />
                        <input type="hidden" value="<?php echo $disabled_Co;?>" id="tab_Copiloto" />
                        <input type="hidden" value="<?php echo $disabled_Jc;?>" id="tab_JefeCabina" />
                        <input type="hidden" value="<?php echo $disabled_Tc;?>" id="tab_TripCabina" />
                        
                        <div class="area_resultado table-responsive tab-content contenido_tabla "> <!--innerWrapper-->
                            <!------------------------------------------------------------------------------------------------------------------------------------------>
                            <div role="tabpanel" class="tab-pane fade dimenDiv" <?php echo $disabled_Pi;?> id="example1-tab1">
                                <table id="myTable1" class="stripe row-border order-column display myDataTables_sinPaginacionBusqueda table-bordered" cellspacing="0" cellpadding="2">
                                    <thead>
                                        <tr class="tr_theadTabla" id="tr_theadTabla">
                                            <th class="" rowspan="2"  style='text-align: center;' scope="col">Item</th>
                                            <th class="" rowspan="2"  style='text-align: center;' scope="col" id="TRIP_datos" >Tripulantes</th>
                                            <th class="" rowspan="2"  style='text-align: center;' scope="col">TimeBT</th>
                                            <th class="" colspan="<?php echo ($cantDias);?>" style='text-align: center;' scope="col"><?php echo $nomMesAnio;?></th>
                                        </tr>
                                        <tr>
                                        <?php for($j=$this->fecha_antes;$j<=$this->fecha_despues;$j = date("Y-m-d", strtotime($j ."+ 1 days"))){ ?>
                                            <?php $style = "" ?>
                                            <?php $nomDia = utf8_encode(strtoupper(substr(strftime('%A',strtotime($j)),0,3))); ?>
                                            <?php $Vj = explode('-',$j); ?>
                                            <?php if( $j == $fechaActual){ ?>
                                                <?php $style = "background-color: #B9F5B0;"; ?> 
                                            <?php } ?>                                            
                                            <th class="columnaDia" scope="col" style='text-align: center; <?php echo $style;?>'><?php echo $nomDia; ?><br/><?php echo $Vj[2]; ?></th>
                                        <?php } ?>
                                        </tr>
                                        <tr>
                                            <th class="" colspan="3"  style='text-align: center;' scope="col">Rutas Faltantes</th>
                                        <?php for($j=$this->fecha_antes;$j<=$this->fecha_despues;$j = date("Y-m-d", strtotime($j ."+ 1 days"))){ ?>
                                            <?php $style = "" ?>
                                            <?php $nomDia = utf8_encode(strtoupper(substr(strftime('%A',strtotime($j)),0,3))); ?>
                                            <?php $Vj = explode('-',$j); ?>
                                            <?php if( $j == $fechaActual){ ?>
                                                <?php $style = "background-color: #B9F5B0;"; ?> 
                                            <?php } ?>                                            
                                            <th id = "<?php echo $j;?>-1" class="columnaDia" scope="col" style='text-align: center; <?php echo $style;?>'></th>
                                        <?php } ?>
                                        </tr>
                                    </thead>
                                    <tbody id="tripxDia">
                                        <?php if (count($this->objPiloto) > 0) { ?>
                                            <?php $item = 1; ?>
                                            <?php foreach ($this->objPiloto as $listaTrip) { ?>
                                        <tr class="tr_tbodyTabla" >
                                            <input type="hidden" name="TRIP_idHidden<?php echo $item;?>" id="TRIP_idHidden<?php echo $item;?>" value="<?php echo $listaTrip["TRIP_id"]; ?>" />
                                            <input type="hidden" name="num_objPiloto" id="num_objPiloto" value="<?php echo count($this->objPiloto);?>" />
                                            
                                            <td style="width:auto;">
                                                <b><?php echo $item;?></b>
                                                <button type="button" class="fa fa-envelope fa-xs" onclick="enviarCorreoProgrxTrip('<?php echo $this->fechaInicio;?>','<?php echo $listaTrip["TRIP_id"]; ?>','<?php echo $listaTrip["TRIP_apellido"]." ".$listaTrip["TRIP_nombre"]; ?>')"></button>
                                            </td>
                                            <td class="" style=""><b><?php echo utf8_encode( substr($listaTrip["TRIP_apellido"],0,strpos($listaTrip["TRIP_apellido"],' '))." ".substr($listaTrip["TRIP_nombre"],0,1)."." );?><sup><?php if( $listaTrip["TRIP_edad"] > 60 ) { echo "[".$listaTrip["TRIP_edad"]."]"; } ?></sup></b></td>
                                            <td class="" id="cantTimeBT<?php echo $listaTrip["TRIP_id"]; ?>" name="cantTimeBT<?php echo $listaTrip["TRIP_id"]; ?>" ><b></b></td>
                                            
                                            <?php $valor = 1; ?>
                                            <?php for($j=$this->fecha_antes;$j<=$this->fecha_despues;$j = date("Y-m-d", strtotime($j ."+ 1 days"))){ ?>

                                                <td id="TD_tripxDia<?php echo ($listaTrip["TRIP_id"]."-".$valor);?>" style="text-align: center;" data-toggle="modal" data-target="#updateTripxDia" onclick="listarTripxDiaDet('<?php echo $listaTrip["TRIP_id"]?>','<?php echo $j;?>','TD_tripxDia<?php echo ($listaTrip["TRIP_id"]."-".$valor);?>')" ></td>
                                                <?php $valor++;?>
                                            <?php } ?>
                                            
                                        </tr>
                                            <?php $item++; ?>
                                            <?php } ?>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                            <!------------------------------------------------------------------------------------------------------------------------------------------>
                            <div role="tabpanel" class="tab-pane fade dimenDiv" <?php echo $disabled_Co;?> id="example1-tab2">
                                <table id="myTable2" class="display table-bordered myDataTables_sinPaginacionBusqueda" cellspacing="0" cellpadding="2">
                                    <thead>
                                        <tr class="tr_theadTabla" id="tr_theadTabla">
                                            <th class="" rowspan="2"  style='text-align: center;' scope="col">Item</th>
                                            <th class="" rowspan="2"  style='text-align: center;' scope="col" id="TRIP_datos" >Tripulantes</th>
                                            <th class="" rowspan="2"  style='text-align: center;' scope="col">TimeBT</th>
                                            <th class="" colspan="<?php echo ($cantDias);?>" style='text-align: center;' scope="col"><?php echo $nomMesAnio;?></th>
                                        </tr>
                                        <tr>
                                        <?php for($j=$this->fecha_antes;$j<=$this->fecha_despues;$j = date("Y-m-d", strtotime($j ."+ 1 days"))){ ?>
                                            <?php $style = "" ?>
                                            <?php $nomDia = utf8_encode(strtoupper(substr(strftime('%A',strtotime($j)),0,3))); ?>
                                            <?php $Vj = explode('-',$j); ?>
                                            <?php if( $j == $fechaActual){ ?>
                                                <?php $style = "background-color: #B9F5B0;"; ?> 
                                            <?php } ?>                                            
                                            <th class="columnaDia" scope="col" style='text-align: center; <?php echo $style;?>'><?php echo $nomDia; ?><br/><?php echo $Vj[2]; ?></th>
                                        <?php } ?>
                                        </tr>
                                        <tr>
                                            <th class="" colspan="3"  style='text-align: center;' scope="col">Rutas Faltantes</th>
                                        <?php for($j=$this->fecha_antes;$j<=$this->fecha_despues;$j = date("Y-m-d", strtotime($j ."+ 1 days"))){ ?>
                                            <?php $style = "" ?>
                                            <?php $nomDia = utf8_encode(strtoupper(substr(strftime('%A',strtotime($j)),0,3))); ?>
                                            <?php $Vj = explode('-',$j); ?>
                                            <?php if( $j == $fechaActual){ ?>
                                                <?php $style = "background-color: #B9F5B0;"; ?> 
                                            <?php } ?>                                            
                                            <th id = "<?php echo $j;?>-2" class="columnaDia" scope="col" style='text-align: center; <?php echo $style;?>'></th>
                                        <?php } ?>
                                        </tr>
                                    </thead>
                                    <tbody id="tripxDia">
                                        <?php if (count($this->objCopiloto) > 0) { ?>
                                            <?php //$item = 1; ?>
                                            <?php foreach ($this->objCopiloto as $listaTrip) { ?>
                                        <tr class="tr_tbodyTabla">
                                            <input type="hidden" name="TRIP_idHidden<?php echo $item;?>" id="TRIP_idHidden<?php echo $item;?>" value="<?php echo $listaTrip["TRIP_id"]; ?>" />
                                            <input type="hidden" name="num_objCopiloto" id="num_objCopiloto" value="<?php echo count($this->objCopiloto);?>" />
                                            
                                            <td style="width:auto;">
                                                <b><?php echo $item;?></b>
                                                <button type="button" class="fa fa-envelope fa-xs" onclick="enviarCorreoProgrxTrip('<?php echo $this->fechaInicio;?>','<?php echo $listaTrip["TRIP_id"]; ?>','<?php echo $listaTrip["TRIP_apellido"]." ".$listaTrip["TRIP_nombre"]; ?>')"></button>
                                            </td>
                                            <td class="" style=""><b><?php echo utf8_encode( substr($listaTrip["TRIP_apellido"],0,strpos($listaTrip["TRIP_apellido"],' '))." ".substr($listaTrip["TRIP_nombre"],0,1)."." );?><sup><?php if( $listaTrip["TRIP_edad"] > 60 ) { echo "[".$listaTrip["TRIP_edad"]."]"; } ?></sup></b></td>
                                            <td class="" id="cantTimeBT<?php echo $listaTrip["TRIP_id"]; ?>" name="cantTimeBT<?php echo $listaTrip["TRIP_id"]; ?>" ></td>
                                            
                                            <?php $valor = 1; ?>
                                            <?php for($j=$this->fecha_antes;$j<=$this->fecha_despues;$j = date("Y-m-d", strtotime($j ."+ 1 days"))){ ?>

                                                <td id="TD_tripxDia<?php echo ($listaTrip["TRIP_id"]."-".$valor);?>" style="text-align: center;" data-toggle="modal" data-target="#updateTripxDia" onclick="listarTripxDiaDet('<?php echo $listaTrip["TRIP_id"]?>','<?php echo $j;?>','TD_tripxDia<?php echo ($listaTrip["TRIP_id"]."-".$valor);?>')" ></td>
                                                <?php $valor++;?>
                                            <?php } ?>                                        
                                        </tr>
                                            <?php $item++; ?>
                                            <?php } ?>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                            <!------------------------------------------------------------------------------------------------------------------------------------------>
                            <div role="tabpanel" class="tab-pane fade dimenDiv" <?php echo $disabled_Jc;?> id="example1-tab3">
                                <table id="myTable3" class="display table-bordered myDataTables_sinPaginacionBusqueda" cellspacing="0" cellpadding="2">
                                    <thead>
                                        <tr class="tr_theadTabla" id="tr_theadTabla">
                                            <th class="" rowspan="2"  style='text-align: center;' scope="col">Item</th>
                                            <th class="" rowspan="2"  style='text-align: center;' scope="col" id="TRIP_datos" >Tripulantes</th>
                                            <th class="" rowspan="2"  style='text-align: center;' scope="col">TimeBT</th>
                                            <th class="" colspan="<?php echo ($cantDias);?>" style='text-align: center;' scope="col"><?php echo $nomMesAnio;?></th>
                                        </tr>
                                        <tr>
                                        <?php for($j=$this->fecha_antes;$j<=$this->fecha_despues;$j = date("Y-m-d", strtotime($j ."+ 1 days"))){ ?>
                                            <?php $style = "" ?>
                                            <?php $nomDia = utf8_encode(strtoupper(substr(strftime('%A',strtotime($j)),0,3))); ?>
                                            <?php $Vj = explode('-',$j); ?>
                                            <?php if( $j == $fechaActual){ ?>
                                                <?php $style = "background-color: #B9F5B0;"; ?> 
                                            <?php } ?>                                            
                                            <th class="columnaDia" scope="col" style='text-align: center; <?php echo $style;?>'><?php echo $nomDia; ?><br/><?php echo $Vj[2]; ?></th>
                                        <?php } ?>
                                        </tr>
                                        <tr>
                                            <th class="" colspan="3"  style='text-align: center;' scope="col">Rutas Faltantes</th>
                                        <?php for($j=$this->fecha_antes;$j<=$this->fecha_despues;$j = date("Y-m-d", strtotime($j ."+ 1 days"))){ ?>
                                            <?php $style = "" ?>
                                            <?php $nomDia = utf8_encode(strtoupper(substr(strftime('%A',strtotime($j)),0,3))); ?>
                                            <?php $Vj = explode('-',$j); ?>
                                            <?php if( $j == $fechaActual){ ?>
                                                <?php $style = "background-color: #B9F5B0;"; ?> 
                                            <?php } ?>                                            
                                            <th id = "<?php echo $j;?>-8" class="columnaDia" scope="col" style='text-align: center; <?php echo $style;?>'></th>
                                        <?php } ?>
                                        </tr>
                                    </thead>
                                    <tbody id="tripxDia">
                                    <?php if (count($this->objJefeCabina) > 0) { ?>
                                        <?php //$item = 1; ?>
                                        <?php foreach ($this->objJefeCabina as $listaTrip) { ?>
                                    <tr class="tr_tbodyTabla">
                                        <input type="hidden" name="TRIP_idHidden<?php echo $item;?>" id="TRIP_idHidden<?php echo $item;?>" value="<?php echo $listaTrip["TRIP_id"]; ?>" />
                                        <input type="hidden" name="num_objJefeCabina" id="num_objJefeCabina" value="<?php echo count($this->objJefeCabina);?>" />
                                        <td style="width:auto;">
                                            <b><?php echo $item;?></b>
                                            <button type="button" class="fa fa-envelope fa-xs" onclick="enviarCorreoProgrxTrip('<?php echo $this->fechaInicio;?>','<?php echo $listaTrip["TRIP_id"]; ?>','<?php echo $listaTrip["TRIP_apellido"]." ".$listaTrip["TRIP_nombre"]; ?>')"></button>
                                        </td>
                                        <td class="" style=""><b><?php echo utf8_encode( substr($listaTrip["TRIP_apellido"],0,strpos($listaTrip["TRIP_apellido"],' '))." ".substr($listaTrip["TRIP_nombre"],0,1)."." );?><sup><?php if( $listaTrip["TRIP_edad"] > 60 ) { echo "[".$listaTrip["TRIP_edad"]."]"; } ?></sup></b></td>
                                        <td class="" id="cantTimeBT<?php echo $listaTrip["TRIP_id"]; ?>" name="cantTimeBT<?php echo $listaTrip["TRIP_id"]; ?>" ></td>
                                        
                                        <?php $valor = 1; ?>
                                        <?php for($j=$this->fecha_antes;$j<=$this->fecha_despues;$j = date("Y-m-d", strtotime($j ."+ 1 days"))){ ?>
                                            
                                            <td id="TD_tripxDia<?php echo ($listaTrip["TRIP_id"]."-".$valor);?>" style="text-align: center;" data-toggle="modal" data-target="#updateTripxDia" onclick="listarTripxDiaDet('<?php echo $listaTrip["TRIP_id"]?>','<?php echo $j;?>','TD_tripxDia<?php echo ($listaTrip["TRIP_id"]."-".$valor);?>')" ></td>
                                            <?php $valor++;?>
                                        <?php } ?>
                                    </tr>
                                        <?php $item++; ?>
                                        <?php } ?>
                                    <?php } ?>
                                </tbody>
                            </table>
                            </div>
                            <!------------------------------------------------------------------------------------------------------------------------------------------>
                            <div role="tabpanel" class="tab-pane fade dimenDiv" <?php echo $disabled_Tc;?> id="example1-tab4">
                                <table id="myTable4" class="display table-bordered myDataTables_sinPaginacionBusqueda" cellspacing="0" cellpadding="2">
                                    <thead>
                                        <tr class="tr_theadTabla" id="tr_theadTabla">
                                            <th class="" rowspan="2"  style='text-align: center;' scope="col">Item</th>
                                            <th class="" rowspan="2"  style='text-align: center;' scope="col" id="TRIP_datos" >Tripulantes</th>
                                            <th class="" rowspan="2"  style='text-align: center;' scope="col">TimeBT</th>
                                            <th class="" colspan="<?php echo ($cantDias);?>" style='text-align: center;' scope="col"><?php echo $nomMesAnio;?></th>
                                        </tr>
                                        <tr>
                                        <?php for($j=$this->fecha_antes;$j<=$this->fecha_despues;$j = date("Y-m-d", strtotime($j ."+ 1 days"))){ ?>
                                            <?php $style = "" ?>
                                            <?php $nomDia = utf8_encode(strtoupper(substr(strftime('%A',strtotime($j)),0,3))); ?>
                                            <?php $Vj = explode('-',$j); ?>
                                            <?php if( $j == $fechaActual){ ?>
                                                <?php $style = "background-color: #B9F5B0;"; ?> 
                                            <?php } ?>                                            
                                            <th class="columnaDia" scope="col" style='text-align: center; <?php echo $style;?>'><?php echo $nomDia; ?><br/><?php echo $Vj[2]; ?></th>
                                        <?php } ?>
                                        </tr>
                                        <tr>
                                            <th class="" colspan="3"  style='text-align: center;' scope="col">Rutas Faltantes</th>
                                        <?php for($j=$this->fecha_antes;$j<=$this->fecha_despues;$j = date("Y-m-d", strtotime($j ."+ 1 days"))){ ?>
                                            <?php $style = "" ?>
                                            <?php $nomDia = utf8_encode(strtoupper(substr(strftime('%A',strtotime($j)),0,3))); ?>
                                            <?php $Vj = explode('-',$j); ?>
                                            <?php if( $j == $fechaActual){ ?>
                                                <?php $style = "background-color: #B9F5B0;"; ?> 
                                            <?php } ?>                                            
                                            <th id = "<?php echo $j;?>-5" class="columnaDia" scope="col" style='text-align: center; <?php echo $style;?>'></th>
                                        <?php } ?>
                                        </tr>
                                    </thead>
                                    <tbody id="tripxDia">
                                        <?php if (count($this->objTripCabina) > 0) { ?>
                                            <?php //$item = 1; ?>
                                            <?php foreach ($this->objTripCabina as $listaTrip) { ?>
                                        <tr class="tr_tbodyTabla">
                                            <input type="hidden" name="TRIP_idHidden<?php echo $item;?>" id="TRIP_idHidden<?php echo $item;?>" value="<?php echo $listaTrip["TRIP_id"]; ?>" />
                                            <input type="hidden" name="num_objTripCabina" id="num_objTripCabina" value="<?php echo count($this->objTripCabina);?>" />
                                            <td style="width:auto;">
                                                <b><?php echo $item;?></b>
                                                <button type="button" class="fa fa-envelope fa-xs" onclick="enviarCorreoProgrxTrip('<?php echo $this->fechaInicio;?>','<?php echo $listaTrip["TRIP_id"]; ?>','<?php echo $listaTrip["TRIP_apellido"]." ".$listaTrip["TRIP_nombre"]; ?>')"></button>
                                            </td>
                                            <td class="" style=""><b><?php echo utf8_encode( substr($listaTrip["TRIP_apellido"],0,strpos($listaTrip["TRIP_apellido"],' '))." ".substr($listaTrip["TRIP_nombre"],0,1)."." );?><sup><?php if( $listaTrip["TRIP_edad"] > 60 ) { echo "[".$listaTrip["TRIP_edad"]."]"; } ?></sup></b></td>
                                            <td class="" id="cantTimeBT<?php echo $listaTrip["TRIP_id"]; ?>" name="cantTimeBT<?php echo $listaTrip["TRIP_id"]; ?>" ></td>
                                            
                                            <?php $valor = 1; ?>
                                            <?php for($j=$this->fecha_antes;$j<=$this->fecha_despues;$j = date("Y-m-d", strtotime($j ."+ 1 days"))){ ?>

                                                <td id="TD_tripxDia<?php echo ($listaTrip["TRIP_id"]."-".$valor);?>" style="text-align: center;" data-toggle="modal" data-target="#updateTripxDia" onclick="listarTripxDiaDet('<?php echo $listaTrip["TRIP_id"]?>','<?php echo $j;?>','TD_tripxDia<?php echo ($listaTrip["TRIP_id"]."-".$valor);?>')" ></td>
                                                <?php $valor++;?>
                                            <?php } ?>
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
            </div>
        </section>
        <input type="hidden" id="FLAG_estado" name="FLAG_estado" value="<?php echo $_SESSION["FLAG_estado"];?>" />
        <!-- /.content -->
    </div>
    
    <div id="programacionRegistro" class="modal fade" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header" style="padding: 10px !important">
                    <table class="col-xs-12">
                        <tr>
                            <td style="text-align:left;">
                                <h4><strong id="titleForm">Ingresar la Tripulación</strong></h4>
                            </td>
                            <td>
                                <button type="button" class="close btn-lg" data-dismiss="modal" onclick="limpiarFormProgramacion();" style="background-color: red; color:white; margin:10px; padding: 0px 6px 2px 6px;text-align:right;">
                                    <span aria-hidden="true">&times;</span><span class="sr-only">Cerrar</span>
                                </button>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="modal-body" style="padding-bottom: 10px !important">
                    <div class="row">
                        <div class="col-md-12" style="padding-bottom: 10px;">
                            <label for="bRUT_num_vuelo" class="col-md-4 control-label">N° de Ruta: </label>
                            <div class="col-md-7">
                                <input type="text" name="RUT_num_vuelo" id="RUT_num_vuelo" class="form-control input-sm numberEntero" style="width: 100% !important;" />
                            </div>
                        </div>
                        <div class="col-md-12" style="padding-bottom: 10px;">
                            <label for="TRIP_id_Piloto" class="col-md-4 control-label" id="TRIP_id_Piloto_label">Piloto:</label>
                            <div class="col-md-7">
                                <select name="TRIP_id_Piloto" id="TRIP_id_Piloto" class="form-control input-sm js-example-basic-single"  onchange="validarCopilotoxPiloto('<?php echo URLLOGICA?>motor/listarTripulantesMotorView/','1');"> <!-- validarObligatorioPiloto(); -->
                                    <option value="" selected>Seleccionar Piloto</option>
                                <?php foreach($this->objPiloto as $lista){ ?>
                                    <option value="<?php echo $lista["TRIP_id"];?>"><?php echo utf8_encode($lista["TRIP_nombre"]." ".$lista["TRIP_apellido"]);?></option>
                                <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12" style="padding-bottom: 10px;">
                            <label for="TRIP_id_Copiloto" class="col-md-4 control-label" id="TRIP_id_Copiloto_label">Copiloto:</label>
                            <div class="col-md-7">
                                <input name="TRIP_id_CopilotoHidden" id="TRIP_id_CopilotoHidden" value="" type="hidden">
                                <select name="TRIP_id_Copiloto" id="TRIP_id_Copiloto" class="form-control input-sm js-example-basic-single" > <!--onchange="validarObligatorioCopiloto();"-->
                                    <option value="" selected>Seleccionar Copiloto</option>
                                <?php foreach($this->objCopiloto as $lista){ ?>
                                    <option value="<?php echo $lista["TRIP_id"];?>"><?php echo utf8_encode($lista["TRIP_nombre"]." ".$lista["TRIP_apellido"]);?></option>
                                <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12" style="padding-bottom: 10px;">
                            <label for="TRIP_id_JejeCabina" class="col-md-4 control-label" id="TRIP_id_JejeCabina_label">Jefe de Cabina:</label>
                            <div class="col-md-7">
                                <select name="TRIP_id_JejeCabina" id="TRIP_id_JejeCabina" class="form-control input-sm js-example-basic-single" >
                                    <option value="" selected>Seleccionar Jefe Cabina</option>
                                <?php foreach($this->objJefeCabina as $lista){ ?>
                                    <option value="<?php echo $lista["TRIP_id"];?>"><?php echo utf8_encode($lista["TRIP_nombre"]." ".$lista["TRIP_apellido"]);?></option>
                                <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12" style="padding-bottom: 10px;">
                            <label for="TRIP_id_TripCabina" class="col-md-4 control-label" id="TRIP_id_TripCabina1_label">Tripulante de Cabina N° 1</label>
                            <div class="col-md-7">
                                <input name="num-TripCabina" id="num-TripCabina" value="1" type="hidden">
                                <select name="TRIP_id_TripCabina1" id="TRIP_id_TripCabina1" class="form-control input-sm js-example-basic-single" >
                                    <option value="" selected>Seleccionar Trip. Cabina</option>
                                <?php foreach($this->objTripCabina as $lista){ ?>
                                    <option value="<?php echo $lista["TRIP_id"];?>"><?php echo utf8_encode($lista["TRIP_nombre"]." ".$lista["TRIP_apellido"]);?></option>
                                <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div id="divTripCabina"></div>
                    </div>
                </div>
                <div class="modal-footer" style="padding: 10px !important">
                    <button name="closeProgramacion" id="closeProgramacion" type="button" class="btn btn-danger btn-sm" data-dismiss="modal" onclick="limpiarFormProgramacion();">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
    
    <!--<input type="hidden" id="divCambio" name="divCambio" value="<?php //echo $this->objCambio;?>" />-->
    <div class="modal fade" id="divCambioMotor" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4>
                        <i class="fa fa-exclamation-triangle" aria-hidden="true" style="color:#1175AA; font-size: 20px;"></i>
                        <strong id="titleForm">        MENSAJE IMPORTANTE</strong>
                        <button type="button" class="close btn-lg" data-dismiss="modal" style="background-color: red; color:white; margin:10px; padding: 0px 6px 2px 6px;text-align:right;">
                            <span aria-hidden="true">&times;</span><span class="sr-only">Cerrar</span>
                        </button>
                    </h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12" style="padding-bottom: 10px;">
                            <p>Se ha detectado cambios que afectan la programación vigente, se procederá a realizar la reprogramación correspondiente</p>
                            <p>Por el momento, sólo podrá acceder en modo consulta. Dar click en [Continuar].</p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type='button' id='' name='' class="btn btn-sm" data-dismiss="modal">Continuar</button>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Inicio Modal-->
    <div id="cargaProgreso" class="modal fade" data-backdrop=”static” data-keyboard=”false” role="dialog" aria-labelledby="myModalLabel" >
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header" style="padding: 10px !important">
                    <table class="col-xs-12">
                        <tr>
                            <td style="text-align:left;">
                                <h4><strong id="titleForm">Cargando Programación</strong></h4>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="modal-body" style="padding-bottom: 10px;">
                    <div class="progress" style="margin:20px">
                        <div id="bar" class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%">
                            <!--<span class="sr-only" id="sr-only" >0% Complete</span>-->
                        </div>
                    </div>
                </div>
                <div class="modal-footer" style="padding: 10px !important">
                </div>
            </div>
        </div>
    </div>
    <!-- Fin Modal-->
    
    <!-- Inicio Modal-->
    <div id="updateTripxDia" class="modal fade" data-backdrop=”static” data-keyboard=”false” role="dialog" aria-labelledby="myModalLabel" >
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header" style="padding: 10px !important">
                    <table class="col-xs-12">
                        <tr>
                            <td style="text-align:left;">
                                <h4><strong id="titleForm">Modificar Tripulante y Ruta.</strong></h4>
                            </td>
                            <td>
                                <button type="button" class="close btn-lg" data-dismiss="modal" onclick="limpiarTripxDia();" style="background-color: red; color:white; margin:10px; padding: 0px 6px 2px 6px;text-align:right;">
                                    <span aria-hidden="true">&times;</span><span class="sr-only">Cerrar</span>
                                </button>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="modal-body" style="padding-bottom: 10px;">
                    <div class="row">
                        <div class="col-md-12" style="padding-bottom: 10px;">
                            <label for="fch_prog" class="col-md-5 control-label">Fch. Programación </label>
                            <div class="col-md-7">
                                <div class='input-group date datetimepicker1' id="fch_prog_Date">
                                    <input name="tipCondicional" id="tipCondicional" value="" type="hidden">
                                    <input name="num-condicional" id="num-condicional" value="" type="hidden">
                                    <input type="text" name="fch_prog" id="fch_prog" class="form-control input-sm" style="text-transform: uppercase; width: 100% !important;"/>
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <!------------------------------------------------------------ Inicio Condicional --------------------------------------------------------->
                        <div id="divCondicional"></div>
                        <!------------------------------------------------------------ Fin Condicional ------------------------------------------------------------>
                        <div class="col-md-12" style="padding-bottom: 10px;">
                            <label for="TIPTRIP_id" class="col-md-5 control-label">Tipo de Tripulante </label>
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
                            <label for="TIPTRIPDET_id" class="col-md-5 control-label">Tipo de Detalle de Trip. </label>
                            <div class="col-md-7">
                                <select name="TIPTRIPDET_id" id="TIPTRIPDET_id" class="form-control input-sm js-example-basic-single" >
                                    <option value="" selected>Tipo Detalle de Trip.</option>
                                <?php foreach($this->objTipoDetTripulante as $lista){ ?>
                                    <option class="<?php echo $lista["TIPTRIP_id"];?>" value="<?php echo $lista["TIPTRIPDET_id"];?>"><?php echo ($lista["TIPTRIPDET_descripcion"]);?></option>
                                <?php } ?>
                                </select>
                            </div>
                        </div>                        
                        <!------------------------------------------------------------ Tripulante Afectado ------------------------------------------------------------>
                        <div class="col-md-12" style="padding-bottom: 10px;">
                            <label for="TRIP_id1" class="col-md-5 control-label">Tripulante Afectado </label>
                            <div class="col-md-7">
                                <select name="TRIP_id1" id="TRIP_id1" class="form-control input-sm js-example-basic-single" >
                                    <option value="" selected>Tripulante Afectado</option>
                                <?php foreach($this->objTripulante as $lista){ ?>
                                    <option class="<?php echo $lista["TIPTRIPDET_id"];?>" value="<?php echo $lista["TRIP_id"];?>"><?php echo utf8_encode($lista["TRIP_nombre"]." ".$lista["TRIP_apellido"]);?></option>
                                <?php } ?>
                                </select>
                            </div>
                        </div>
                        <!------------------------------------------------------------ Inicio Cambio --------------------------------------------------------->
                        <div id="divCambioTrip"></div>
                    </div>
                </div>
                <div class="modal-footer" style="padding: 10px !important">
                    <button name='updateTripxDia' id='updateTripxDia' type="button" class="btn btn-sm" onclick="updateTripxDia()" >Modificar</button>
                    <button name="closeAptoTripxDia" id="closeAptoTripxDia" type="button" class="btn btn-danger btn-sm" data-dismiss="modal" onclick="limpiarTripxDia();">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Fin Modal-->
    
    <div id="programacionHistorial" class="modal fade" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content modal-lg">
                <div class="modal-header" style="padding: 10px !important">
                    <table class="col-xs-12">
                        <tr>
                            <td style="text-align:left;">
                                <h4><strong id="titleForm">Detalle Historial Tripulante</strong></h4>
                            </td>
                            <td>
                                <button type="button" class="close btn-lg" data-dismiss="modal" onclick="" style="background-color: red; color:white; margin:10px; padding: 0px 6px 2px 6px;text-align:right;">
                                    <span aria-hidden="true">&times;</span><span class="sr-only">Cerrar</span>
                                </button>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="modal-body" style="padding-bottom: 10px;">
                    <div class="area_resultado table-responsive">
                        <table id="listaHistorialTrip" class="display" cellspacing="0" cellpadding="2">
                            <thead>
                                <tr>
                                    <th scope="col">Item</th>
                                    <th scope="col">Fch. de Vuelo</th>
                                    <th scope="col">Tipo de Cambio</th>
                                    <th scope="col">Origen</th>
                                    <th scope="col">Cambio</th>
                                    <th scope="col">Usu. Mod.</th>
                                    <th scope="col">Fch. Mod.</th>
                                </tr>
                            </thead>
                            <tbody id="listaHistorialDetTrip">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <style>
        .contenido_tabla{
            font-size: 9.5px;
        }
        .tr_theadTabla {
            line-height: 1.50;
        }
        .tr_tbodyTabla {
            line-height: 1.00;
            height: 75px !important;
        }
        .dimenDiv{
            height: 800px;
        }
        .note {
            position: relative;
        }
        .note:after { /* Magic Happens Here!!! */
            content: "";
            position: absolute;
            top: 0;
            right: 0;
            width: 0; 
            height: 0; 
            display: block;
            border-left: 10px solid transparent;
            border-bottom: 10px solid transparent;
            border-top: 10px solid #9A1B24;
        }
    </style>
    
    <script>
        var myVar1 = setInterval(flagEstado, 1500);
        var myVar2 = setInterval(flagCambio, 2500);
        var cambioEstado = false;
        var usu_trabajo = 'MOTOR';
        
        $(document).ready(function() {
            resetEstado_Motor();
            $("#bodyProgVuelo").prop("class","skin-blue sidebar-mini sidebar-collapse");
            
            if( $("#tab_Piloto").val() == ""  ){
                //in active
                listarTripxDia('1');
                $("#example1-tab1").attr("class", "tab-pane fade dimenDiv in active");
                $("#Tab_piloto").attr("class", "active");
            } else if( $("#tab_Copiloto").val() == ""  ){
                listarTripxDia('2');
                $("#example1-tab2").attr("class", "tab-pane fade dimenDiv in active");
                $("#Tab_copiloto").attr("class", "active");
            } else if( $("#tab_JefeCabina").val() == ""  ){
                listarTripxDia('8');
                $("#example1-tab3").attr("class", "tab-pane fade dimenDiv in active");
                $("#Tab_jefecabina").attr("class", "active");
            } else if( $("#tab_TripCabina").val() == ""  ){
                listarTripxDia('5');
                $("#example1-tab3").attr("class", "tab-pane fade dimenDiv in active");
                $("#Tab_tripcabina").attr("class", "active");
            }
            
            /*if($("#divCambio").val() == 'divCambio' ){
                $("#divCambioMotor").modal('show');
                ejecucionMotorView();
            }*/
            $("#TRIP_datos").click();
        } );
        
        function insertEstadoFlag(){            
            var url = "<?php echo URLLOGICA?>motor/insertEstadoFlag/";
            $("#preloader").css("display","block");
            
            if ($('#TIP_trabajo').bootstrapSwitch('state') == true){
                var TIP_trabajo = 0;
            } else if ($('#TIP_trabajo').bootstrapSwitch('state') == false){
                var TIP_trabajo = 1;
            }
                
            var parametros = {
                "TIP_trabajo" : TIP_trabajo,
            };

            $.post(url,parametros,
            function(data){
                listarTripxDia('1');
                $("#preloader").css("display", "none");
            });
        }
        
        function flagEstado() {
            var url = "<?php echo URLLOGICA?>motor/verificarEstadoFlag/";

            var parametros = {};
            $.post(url,parametros,
            function(data){
                
                if(data[0]["FLAG_estado"] != $("#FLAG_estado").val()){
                    $("#FLAG_estado").val(data[0]["FLAG_estado"]);
                    cambioEstado = true;
                } else{
                    cambioEstado = false;
                }

                if($("#FLAG_estado").val() == '1' && cambioEstado){
                    usu_trabajo = data[0]["AUD_usu_cre"];
                    if($("#Usuario").val() !=  data[0]["AUD_usu_cre"]){
                        $("#TIP_trabajo").val(data[0]["FLAG_estado"]);
                        $("#TIP_trabajo").prop("disabled","disabled");
                        $("#usuEdicion").text(usu_trabajo);
                        clearInterval(myVar1);
                        $("#TipoTrabajoMensaje").modal('show');
                    }
                }
                if($("#FLAG_estado").val() == '0' && cambioEstado){
                    $("#TIP_trabajo").val(data[0]["FLAG_estado"]);
                    $("#TIP_trabajo").removeAttr("disabled");
                }
            });
        }
        
        function flagCambio() {
            var url = "<?php echo URLLOGICA?>motor/verificarCambio/";

            var parametros = {};
            $.post(url,parametros,
            function(data){
                if(data == 'divCambio' ){
                    $("#divCambioMotor").modal('show');
                    ejecucionMotorView();
                    //listarTripxDia('1');
                    clearInterval(myVar2);
                    //location.reload(true);
                }
            });
        }
        
        function listarTripxDia(TIPTRIPDET_id){
            var fechaInicio = $("#fecha_antes").val();
            var fechaFin = $("#fecha_despues").val();
            
            var fechaInicio = new Date(fechaInicio);
            var fechaFin = new Date(fechaFin);
            var validacion = false;
            
            if ($('#TIP_trabajo').bootstrapSwitch('state') == true && $("#Usuario").val() != usu_trabajo){
                validacion = true;
            } else if ($('#TIP_trabajo').bootstrapSwitch('state') == true && $("#Usuario").val() == usu_trabajo){
                validacion = true;
            } else if ($('#TIP_trabajo').bootstrapSwitch('state') == false && $("#Usuario").val() != usu_trabajo){
                validacion = false;
            }
            
            $("#TIPTRIPDET_idHidden").val(TIPTRIPDET_id);
            
            if( TIPTRIPDET_id == "1" ){
                var num_objPiloto = $("#num_objPiloto").val();
                var inicio = 1;
            } else if( TIPTRIPDET_id == "2" ){
                var num_objPiloto = parseInt($("#num_objPiloto").val()) + parseInt($("#num_objCopiloto").val());
                var inicio = parseInt($("#num_objPiloto").val()) + parseInt("1");
            } else if( TIPTRIPDET_id == "8" ){
                var num_objPiloto = parseInt($("#num_objPiloto").val()) + parseInt($("#num_objCopiloto").val()) + parseInt($("#num_objJefeCabina").val());
                var inicio = parseInt($("#num_objPiloto").val()) + parseInt($("#num_objCopiloto").val()) + parseInt("1");
            } else if( TIPTRIPDET_id == "5" ){
                var num_objPiloto = parseInt($("#num_objPiloto").val()) + parseInt($("#num_objCopiloto").val()) + parseInt($("#num_objJefeCabina").val()) + parseInt($("#num_objTripCabina").val());
                var inicio = parseInt($("#num_objPiloto").val()) + parseInt($("#num_objCopiloto").val()) + parseInt($("#num_objJefeCabina").val()) + parseInt("1");
            } else if( TIPTRIPDET_id == "0" ){
                var num_objPiloto = parseInt($("#num_objPiloto").val()) + parseInt($("#num_objCopiloto").val()) + parseInt($("#num_objJefeCabina").val()) + parseInt($("#num_objTripCabina").val()) + parseInt($("#num_objTripBuscado").val());
                var inicio = parseInt($("#num_objPiloto").val()) + parseInt($("#num_objCopiloto").val()) + parseInt($("#num_objJefeCabina").val()) + parseInt($("#num_objTripCabina").val()) + parseInt("1");
            }
            
            var url = '<?php echo URLLOGICA?>programacion/listarTripxDia/';
            
            var num = 0;
            while(fechaFin.getTime() >= fechaInicio.getTime()){
                $("#preloader").css("display","block");
                fechaInicio.setDate(fechaInicio.getDate() + 1);
                var fchLista = fechaInicio.getFullYear() + '-' + (((fechaInicio.getMonth() + 1) < 10) ? '0' : '') + (fechaInicio.getMonth() + 1) + '-' + (((fechaInicio.getDate() + 1) < 11) ? '0' : '') + (fechaInicio.getDate());
                num++;
                
                listarRutasFaltantesxDia(TIPTRIPDET_id,fchLista);
                
                var parametros = {
                    "fch_ini" : fchLista,
                    "fch_fin" : fchLista,
                    "TIPTRIPDET_id" : TIPTRIPDET_id,
                    "TRIP_id" : "",
                };
                $.ajax({
                    async:false,    
                    cache:false,   
                    dataType:"json",
                    type: 'POST',   
                    url: url,
                    data: parametros, 
                    success:  function(data){  
                        for (var k = 0; k < data.length; k++) {
                            color = "";
                            for(var i = inicio; i <= num_objPiloto; i++ ){
                                var valor = "";
                                if( $("#TRIP_idHidden" + i).val() == data[k]["TRIP_id"] ){
                                    if( (data[k]["AptoMedico"]).trim() != "" ){
                                        valor = data[k]["AptoMedico"];
                                        color = "#f6695a";
                                    } 
                                    else if( (data[k]["Curso"]).trim() != "" ){
                                        valor = data[k]["Curso"];
                                        color = "#ef9e6c";
                                    } 
                                    else if( (data[k]["Chequeo"]).trim() != "" ){
                                        valor = data[k]["Chequeo"];
                                        color = "#5ab348";
                                    }
                                    else if( (data[k]["Simulador"]).trim() != "" ){
                                        valor = data[k]["Simulador"];
                                        color = "#6789f2";
                                    }
                                    else if( (data[k]["Ausencia"]).trim() != "" ){
                                        if( data[k]["Ausencia"] == "LP" ){ color = "#f085ef"; }
                                        if( data[k]["Ausencia"] == "VAC" ){ color = "#d7b25b"; }
                                        if( data[k]["Ausencia"] == "DM" ){ color = "#f085ef"; }
                                        if( data[k]["Ausencia"] == "GEST" ){ color = "#f085ef"; }
                                        if( data[k]["Ausencia"] == "PJ" ){ color = "#f085ef"; }
                                           
                                        valor = data[k]["Ausencia"];
                                    }
                                    else if( (data[k]["Libre"]).trim() != "" ){
                                        valor = data[k]["Libre"];
                                        color = "#b4f090";
                                    }
                                    else if( (data[k]["Reserva"]).trim() != "" ){
                                        valor = data[k]["Reserva"];
                                        color = "#7ffaf8";
                                    }
                                    else if( (data[k]["Rutas"]).trim() != "" ){
                                        var rutas = data[k]["Rutas"];
                                        var rutaArray = rutas.split('-');
                                        cantRutas = rutaArray.length;
                                        for (var j = 1; j <= cantRutas; j++) {
                                            var rutaSgte = rutaArray[(j)];
                                            if(rutaSgte == undefined){
                                                rutaSgte = "";
                                            }
                                            valor = valor + rutaArray[(j-1)]+"-"+rutaSgte+"\n";
                                            
                                            if(rutaArray[(j)] == undefined){
                                                valor = valor.substr(0,valor.length-2);
                                            }
                                            j++;
                                        }
                                    } else {
                                        valor = 'TD';
                                        color = "#7ffaf8";
                                    }
                                    
                                    if( valor == "AM" || valor == "CUR" || valor == "CHEQ" || valor == "SIM" || valor == "LP" || valor == "VAC" || valor == "DM" || valor == "GEST" || valor == "PJ" || validacion == true ){
                                        //$("#TD_tripxDia" + data[k]["TRIP_id"] + "-" + num).prop('onclick',null).off('click');
                                        $("#TD_tripxDia" + data[k]["TRIP_id"] + "-" + num).removeAttr("data-toggle", "");
                                        $("#TD_tripxDia" + data[k]["TRIP_id"] + "-" + num).removeAttr("data-target", "");
                                    } else {                                        
                                        $("#TD_tripxDia" + data[k]["TRIP_id"] + "-" + num).attr("data-toggle", "modal");
                                        $("#TD_tripxDia" + data[k]["TRIP_id"] + "-" + num).attr("data-target", "#updateTripxDia");
                                    }
                                    
                                    $("#TD_tripxDia" + data[k]["TRIP_id"] + "-" + num).css("background",color);
                                    $("#TD_tripxDia" + data[k]["TRIP_id"] + "-" + num).text(valor);
                                    
                                    var timeBT = conversor_segundos( (data[k]["TimeBT"]*60) );
                                    if( TIPTRIPDET_id == "1" || TIPTRIPDET_id == "2" ){
                                        var difHoras1 = CompararHoras(timeBT,"90:00");
                                        var difHoras2 = CompararHoras(timeBT,"70:00");
                                        var timeNormativo = "90:00";
                                    }
                                    if( TIPTRIPDET_id == "5" || TIPTRIPDET_id == "8" ){
                                        var difHoras1 = CompararHoras(timeBT,"100:00");
                                        var difHoras2 = CompararHoras(timeBT,"80:00");
                                        var timeNormativo = "100:00";
                                    }                                   
                                    
                                    var semaforo = "";
                                    if(difHoras1){
                                       semaforo = "#f79694";
                                    }
                                    if(difHoras1 == false && difHoras2){
                                       semaforo = "#f7d294";
                                    }
                                    $("#cantTimeBT" + data[k]["TRIP_id"]).css("background",semaforo);
                                    //var timeBT = timeBT.bold();
                                    $("#cantTimeBT" + data[k]["TRIP_id"]).text(timeBT + " / " + timeNormativo );
                                    
                                    if( data[k]["Cambio"] == "Si" ){
                                        //class="note"
                                        $("#TD_tripxDia" + data[k]["TRIP_id"] + "-" + num).attr("class", "note");
                                    }
                                }
                            }
                        }
                  },
                  beforeSend:function(){},
                  error:function(objXMLHttpRequest){},
                    
                });
            }
            
            
            $("#preloader").css("display","none");
        }
        
        function listarRutasFaltantesxDia(TIPTRIPDET_id,fchLista){
            
            var url = '<?php echo URLLOGICA?>programacion/listarRutasFaltantesxDia/';
            var valor = '';
            
            var parametros = {
                "fch_ini" : fchLista,
                "fch_fin" : fchLista,
                "TIPTRIPDET_id" : TIPTRIPDET_id
            };
            $.ajax({
                async:false,    
                cache:false,   
                dataType:"json",
                type: 'POST',   
                url: url,
                data: parametros, 
                success:  function(data){
                    var RutFaltantes = '';
                    for(var i=0;i<data.length;i++){
                        RutFaltantes = RutFaltantes + '-' + data[i]["RUT_num_vuelo"]
                    }
                    var RutFaltantes = RutFaltantes.substring(1);
                    
                    if( RutFaltantes == "" )
                    {
                        valor  = 'OK';
                    }
                    
                    var rutaArray = RutFaltantes.split('-');
                    cantRutas = rutaArray.length;
                    for (var j = 1; j <= cantRutas; j++) {
                        var rutaSgte = rutaArray[(j)];
                        if(rutaSgte == undefined){
                            rutaSgte = "";
                        }
                        valor = valor + rutaArray[(j-1)]+"-"+rutaSgte+"\n";

                        if(rutaArray[(j)] == undefined){
                            valor = valor.substr(0,valor.length-2);
                        }
                        j++;
                    }
                    $("#" + fchLista + '-' + TIPTRIPDET_id).text(valor);
                },
                beforeSend:function(){},
                error:function(objXMLHttpRequest){},

            });
        }
        
        function procesoProgMensual(){
            var f = new Date();
            var fch_actual = (f.getMonth() +2) + "/" + (f.getDate() + "/" + f.getFullYear());
            
            var date = new Date(fch_actual);
            locale = "es-al";
            var mesProg = date.toLocaleString(locale,{ month: "long" });
            
            var envio = confirm("Advertencia: Se procesará la Programación de Vuelos del Mes de " + mesProg + ". ¿Continuar (SI [ok] / NO [cancelar])?." );
            
            var url = '<?php echo URLLOGICA?>motor/programacionAutomaticaMensual/';
            clearInterval(myVar1);
            clearInterval(myVar2);
            
            if (envio){
                $("#cargaProgreso").modal({
                    show: false,
                    backdrop: 'static'
                });
                $('#cargaProgreso').modal('show');
                var progreso = 1;
                var idIterval = setInterval(function(){
                    // Aumento en 10 el progeso
                    progreso +=1;
                    $('#bar').css('width', progreso + '%');
                    $('#bar').text( progreso + '%');

                    //Si llegó a 100 elimino el interval
                    if(progreso == 100){
                        clearInterval(idIterval);
                        $('#cargaProgreso').modal('hide');
                        location.reload(true);
                    }
                },3500);
                
                var parametros = {};
                $.post(url,parametros,
                function(data){
                    if( data == "procesado" ){
                        alert("El mes de " + mesProg + " ya ha sido procesado y cuenta con la Programación Mensual realizada, favor de verificar.");
                    }
                });
            } else {
                return false;
            }
        }
        
        function listarTripxDiaDet(TRIP_id,fchLista,idTrip){
            
            //var disabled = '';
            var validacion = false;
            if ($('#TIP_trabajo').bootstrapSwitch('state') == true && $("#Usuario").val() != usu_trabajo){
                validacion = true;
            } else if ($('#TIP_trabajo').bootstrapSwitch('state') == true && $("#Usuario").val() == usu_trabajo){
                validacion = true;
            } else if ($('#TIP_trabajo').bootstrapSwitch('state') == false && $("#Usuario").val() != usu_trabajo){
                validacion = false;
            }
            
            if( validacion == true ){
                if( $( "#" + idTrip ).hasClass( "note" ) ){
                    $("#preloader").css("display","block");
                    var url = '<?php echo URLLOGICA?>programacion/listarHistorialTripxDia/';
                    var parametros = {
                        "TRIP_id" : TRIP_id,
                        "fchLista" : fchLista,
                    };
                    $.post(url,parametros,
                    function(data){
                        $('#programacionHistorial').modal('show');
                        
                        var table = $('#listaHistorialTrip').DataTable();
                        table.destroy();
                        
                        $("#listaHistorialDetTrip").empty();                   
                        for (var i = 1; i <= data.length; i++) {
                        html = '<tr>'
                                + '<td style="width:auto;">' + i + '</td>'
                                + '<td style="width:auto;">' + data[i-1]["ITI_fch"] + '</td>'
                                + '<td style="width:auto;">' + data[i-1]["MOTCAMB_tipoCambio"] + '</td>'
                                + '<td style="width:auto;">' + data[i-1]["MOTCAMB_original"] + '</td>'
                                + '<td style="width:auto;">' + data[i-1]["MOTCAMB_modificado"] + '</td>'
                                + '<td style="width:auto;">' + data[i-1]["AUD_usu_mod"] + '</td>'
                                + '<td style="width:auto;">' + data[i-1]["AUD_fch_mod"] + '</td>'
                            + '</tr>';
                            $("#listaHistorialDetTrip").append(html);
                        };                        
                        myDataTables('listaHistorialTrip');
                        $("#preloader").css("display", "none");
                    });
                } else {   
                    return false;
                }
            }
            
            $("#preloader").css("display","block");
            var url = '<?php echo URLLOGICA?>programacion/listarTripxDia/';
            var parametros = {
                "fch_ini" : fchLista,
                "fch_fin" : fchLista,
                "TIPTRIPDET_id" : "",
                "TRIP_id" : TRIP_id,
            };
            $.post(url,parametros,
            function(data){
                
                nombreTrip=data[0]["TRIP_nombreApellido"];
                
                fch_prog = fchLista.replace(/^(\d{4})-(\d{2})-(\d{2})$/g,'$3/$2/$1');
                $("#fch_prog").val(fch_prog);
                
                $("#TIPTRIP_id").val(data[0]["TIPTRIP_id"]).trigger('change.select2');
                listarComboDetalleTripView();
                setTimeout(function(){
                    $("#TIPTRIPDET_id").chained("#TIPTRIP_id");
                    $("#TIPTRIPDET_id").val(data[0]["TIPTRIPDET_id"]).trigger('change.select2');
                    listarComboTripulanteView($("#TRIP_id1"));
                    
                    setTimeout(function(){
                        $("#TRIP_id1").val(data[0]["TRIP_id"]).trigger('change.select2');
                        $("#TRIP_id1").chained("#TIPTRIPDET_id");
                        
                        $("#divCondicional").empty();
                        $("#divCambioTrip").empty();
                        
                        if( data[0]["AptoMedico"] != "" ){
                            $("#labelCondicional").text("AptoMedico");
                            $("#textCondicional").val(data[0]["AptoMedico"]);
                            
                            /*$("#divCondicional").empty();
                            var valor = fch_prog;
                            var item = 1;
                            html = '<div class="col-md-12" style="padding-bottom: 10px;" >'
                                    + '<label id="labelCondicional' + item + '" for="textCondicional" class="col-md-5 control-label"> Fch. Apto Médico '+ (item)+'</label>'
                                    + '<div class="col-md-7">'
                                        + '<input type="text" name="textCondicional' + item + '" id="textCondicional' + item + '" value="'+ valor +'" class="form-control input-sm" style="text-transform: uppercase; width: 100% !important;" />'
                                    + '</div>'
                                + '</div>';
                            $("#divCondicional").append(html);
                            
                            $("#textCondicional" + item).prop("disabled","disabled");
                            $("#fch_prog").prop("disabled","disabled");
                            $("#TIPTRIP_id").prop("disabled","disabled");
                            $("#TIPTRIPDET_id").prop("disabled","disabled");
                            $("#TRIP_id1").prop("disabled","disabled");*/
                        } 
                        else  if( data[0]["Curso"] != "" ){
                            $("#labelCondicional").text("Curso");
                            $("#textCondicional").val(data[0]["Curso"]);
                        } 
                        else  if( data[0]["Chequeo"] != "" ){
                            $("#labelCondicional").text("Chequeo");
                            $("#textCondicional").val(data[0]["Chequeo"]);
                        }
                        else  if( data[0]["Simulador"] != "" ){
                            $("#labelCondicional").text("Simulador");
                            $("#textCondicional").val(data[0]["Simulador"]);                         
                        }
                        else  if( data[0]["Ausencia"] != "" ){
                            $("#labelCondicional").text("Ausencia");
                            $("#textCondicional").val(data[0]["Ausencia"]);
                        }
                        else  if( data[0]["Libre"] != "" ){
                            $("#labelCondicional").text("Libre");
                            $("#textCondicional").val(data[0]["Libre"]);
                        }
                        else if( (data[0]["Reserva"]).trim() != "" ){
                            $("#labelCondicional").text("Reserva");
                            $("#textCondicional").val(data[0]["Reserva"]);
                        }
                        else  if( data[0]["Rutas"] != "" ){
                            $("#tipCondicional").val("Rutas");
                            
                            var pernocte = data[0]["Pernocte"];
                            var pernocteArray = pernocte.split('-');
                            
                            var salidaPernocte = data[0]["salidaPernocte"];
                            if( salidaPernocte != "" && salidaPernocte != null ){
                               salidaPernocte = "Si";
                            }
                            
                            var item = 1;
                            var rutas = "";

                            var rutas = data[0]["Rutas"];
                            var rutaArray = rutas.split('-');
                            cantRutas = rutaArray.length;
                            
                            var r = 0;
                            for (var i = 1; i <= cantRutas; i++) {
                                var pernocteUnica = pernocteArray[(i-1)];
                                var rutaUnica = rutaArray[(i)];
                                var str = ""+rutaUnica+"";
                                var n = str.indexOf("E");
                                
                                if( n == -1 ){
                                    var valor = "";
                                    if( pernocteUnica == "Si" ){
                                        valor = valor + rutaArray[(i-1)]+"\n";
                                    } else if( pernocteUnica == "No"){
                                        if( salidaPernocte != "Si" ){
                                            valor = valor + rutaArray[(i-1)]+"-"+rutaArray[(i)]+"\n";
                                        } else if( salidaPernocte != "Si" ) {
                                            valor = valor + rutaArray[(i-1)]+"\n";
                                            r++;
                                        }  else if( salidaPernocte == "Si" && r > 0 ) {
                                            valor = valor + rutaArray[(i-2)]+"-"+rutaArray[(i-1)]+"\n";
                                        } else {
                                            valor = valor + rutaArray[(i-1)]+"\n";
                                            r++;
                                        }
                                    }
                                    i++;
                                } else {
                                    var valor = "";
                                    valor = valor + rutaArray[(i-1)]+"-"+rutaArray[(i)]+"-"+rutaArray[(i+1)]+"-"+rutaArray[(i+2)]+"\n";
                                    i++;
                                    i++;
                                    i++;
                                }
                                
                                html1 = '<div class="col-md-12" style="padding-bottom: 10px;" >'
                                        + '<label id="labelCondicional' + item + '" for="textCondicional" class="col-md-5 control-label"> Ruta '+ (item)+'</label>'
                                        + '<div class="col-md-6">'
                                            + '<input type="text" name="textCondicional' + item + '" id="textCondicional' + item + '" value="'+ valor +'" class="form-control input-sm" style="text-transform: uppercase; width: 100% !important;" />'
                                        + '</div>'
                                        + '<div class="col-md-1">'
                                            + '<input type="checkbox" id="checkCondicional' + item + '" name="checkCondicional' + item + '" class="form-check-input" />'
                                        + '</div>'
                                    + '</div>';
                                $("#divCondicional").append(html1);
                                
                                $("#textCondicional"+ item).prop("disabled","disabled");
                                item++;
                            }
                            $("#num-condicional").val((item-1));

                            html2 = '<div class="col-md-12" style="padding-bottom: 10px;">'
                                    + '<label for="TRIP_id2" class="col-md-5 control-label">Tripulante de Cambio'
                                    + '<span style="color: #FF0000"><strong>*</strong></span></label>'
                                    + '<div class="col-md-7">'
                                        + '<select name="TRIP_id2" id="TRIP_id2" class="form-control input-sm js-example-basic-single_extra" >'
                                            + '<option value="" selected>Tripulante Cambio</option>'
                                        <?php foreach($this->objTripulante as $lista){ ?>
                                            + '<option class="<?php echo $lista["TIPTRIPDET_id"];?>" value="<?php echo $lista["TRIP_id"];?>"><?php echo utf8_encode($lista["TRIP_nombre"]." ".$lista["TRIP_apellido"]);?></option>'
                                        <?php } ?>
                                        + '</select>'
                                    + '</div>'
                                + '</div>';
                            $("#divCambioTrip").append(html2);
                            
                            listarComboTripulanteView($("#TRIP_id2"));
                            
                            setTimeout(function(){
                                $("#TRIP_id2").chained("#TIPTRIPDET_id");
                            },150);
                            
                            $(document).ready(function() { $(".js-example-basic-single_extra").select2(); });
                        }
                        else {
                            $("#tipCondicional").val("Vacio");
                            $("#num-condicional").val("");
                            
                            html2 = '<div class="col-md-12" style="padding-bottom: 10px;">'
                                    + '<label for="RUT_num_vuelo" class="col-md-5 control-label">Ruta Asignar'
                                    + '<span style="color: #FF0000"><strong>*</strong></span></label>'
                                    + '<div class="col-md-7">'
                                        + '<select name="RUT_num_vuelo_mod" id="RUT_num_vuelo_mod" multiple="multiple" class="form-control input-sm js-example-basic-single-multiple" >'
                                        <?php foreach($this->objRuta as $lista){ ?>
                                            + '<option value="<?php echo $lista["RUT_num_vuelo"];?>"><?php echo ($lista["RUT_num_vuelo"]);?></option>'
                                        <?php } ?>
                                        + '</select>'
                                    + '</div>'
                                + '</div>';
                            $("#divCambioTrip").append(html2);
                            $(document).ready(function() { $(".js-example-basic-single-multiple").select2(); });
                        }
                        
                        $("#fch_prog").prop("disabled","disabled");
                        $("#TIPTRIP_id").prop("disabled","disabled");
                        $("#TIPTRIPDET_id").prop("disabled","disabled");
                        $("#TRIP_id1").prop("disabled","disabled");
                        $("#TRIP_id2").removeAttr("disabled");
                        $("#preloader").css("display","none");
                    },350);
                },750);
            });
        }
        
        function updateTripxDia(){
            $("#preloader").css("display","block");
            if( $("#TRIP_id2").val() != "" ){
                var url = '<?php echo URLLOGICA?>programacion/updateTripxDia/';
                
                var numCondicional = $("#num-condicional").val();
                var tipCondicional = $("#tipCondicional").val();
                
                var parametros = {
                    "numCondicional" : numCondicional,
                    "tipCondicional" : tipCondicional,
                    "fch_prog" : $("#fch_prog").val(),
                    "TRIP_id1" : $("#TRIP_id1").val(),
                    "TRIP_id2" : $("#TRIP_id2").val(),
                    "RUT_num_vuelo" : $("#RUT_num_vuelo_mod").val(),
                    "TIPTRIPDET_id" : $("#TIPTRIPDET_id").val(),
                };
                
                var RutasCambio = "";
                if( tipCondicional == "Rutas" ){
                    for (var i = 1; i <= numCondicional; i++) {
                        parametros["textCondicional" + i] = $("#textCondicional" + i).val();
                        if( $("#checkCondicional" + i).is(':checked') ){
                            parametros["checkCondicional" + i] = "Si";
                            var RutasCambio = RutasCambio + $("#textCondicional" + i).val() + " / ";
                            var demo = true;
                        } else {
                            parametros["checkCondicional" + i] = "No";
                        }
                        
                    }
                }
                
                if( RutasCambio == "" && $("#tipCondicional").val() == "Rutas" ){
                    $("#preloader").css("display","none");
                    alert("Debe seleccionar la Ruta a modificar");
                    return false;
                }
                
                var PilotoCambio = $("#TRIP_id2 option:selected").text();
                var envio = true;
                if( RutasCambio == "" && $("#tipCondicional").val() == "Rutas" ){
                    var envio = confirm('1-Advertencia: Se realizará la modificación de la(s) Ruta(s) N° ' + RutasCambio + ', que se encontraban asignados al Tripulante '+nombreTrip+' y ahora serán asignados al Tripulante '+PilotoCambio+'. ¿Estas seguro de enviarlo (SI [ok] / NO [cancelar])?.');
                } else {
                    var envio = confirm('2-Advertencia: Se realizará la modificación de la(s) Ruta(s) N° ' + RutasCambio + ', que se encontraban asignados al Tripulante '+nombreTrip+' y ahora serán asignados al Tripulante '+PilotoCambio+'. ¿Estas seguro de enviarlo (SI [ok] / NO [cancelar])?.');
                }
                
                if(envio){
                    $("#preloader").css("display","none");
                    //alert("Demo");
                    $.post(url,parametros,
                    function(data){
                        alert("Se ha modificado correctamente el la Ruta.");
                        location.reload(true);
                        $("#preloader").css("display","none");
                    }); 
                } else{
                    $("#preloader").css("display","none");
                    return false;
                }
            } else {
                $("#preloader").css("display","none");
                origen = $("#TRIP_id2");
                origen.tooltip({title:"Ingrese Tripulante"});
                origen.tooltip("show");
                origen.focus();
            }
        }
        
        function listarComboDetalleTripView(){
            listarComboDetalleTrip('<?php echo URLLOGICA?>detalle/listarTipoTripDetalle/');
        }
        
        function listarComboTripulanteView(select){
            listarComboTripulante('<?php echo URLLOGICA?>tripulante/listarTripulantes/',select);
        }
        
        function listarCabinaView(newnum,TIPTRIPU_id_cabina,TIPTRIPU_id_piloto){
            listarCabina('<?php echo URLLOGICA?>motor/listarTripulantesMotorView/',newnum,TIPTRIPU_id_cabina,TIPTRIPU_id_piloto);
        }
        
        function listarDetProgramacion(){
            $("#preloader").css("display","block");
            var ITI_fch = $("#bITI_fch").val();
            var RUT_num_vuelo = $("#bRUT_num_vuelo").val();
            
            if( ITI_fch == "" || RUT_num_vuelo == "" ){
               alert("Deberá ingresar Fecha y Ruta a consultar");
            } else {
                var url = "<?php echo URLLOGICA?>programacion/listarDetProgramacion/";
                $.post(url,
                {
                    "ITI_fch" : ITI_fch,
                    "RUT_num_vuelo" : RUT_num_vuelo
                },
                function(data){
                    if(data == ""){
                        alert("No se encuentra tripulación para la Ruta:" + RUT_num_vuelo + " de fecha " + ITI_fch);
                        return false;
                    } else {
                        $('#programacionRegistro').modal('show');
                        verFormProgramacion();
                        var ITI_id = "";
                        $("#titleForm").text("Detalle de Programación");
                        $("#RUT_num_vuelo").val(RUT_num_vuelo);
                        $("#RUT_num_vuelo").prop("disabled","disabled");

                        var TRIP_id = '';
                        var TIPTRIPU_id_cabina = '';
                        var TIPTRIPU_id_piloto = '';
                        listarTripulantesMotor('<?php echo URLLOGICA?>motor/listarTripulantesMotorView/',ITI_id,TRIP_id,RUT_num_vuelo,TIPTRIPU_id_cabina,TIPTRIPU_id_piloto);
                        var q = 0;
                        var p = {};
                        for (var i = 0; i < data.length; i++) {
                            if(data[i]["ITI_TRIP_tipo"] == "Piloto"){
                                var k = i;
                                setTimeout(function(){
                                    $("#TRIP_id_Piloto").val(data[k]["TRIP_id"]).trigger('change.select2');
                                    if( data[k]["TRIP_id"] == null || data[k]["TRIP_id"] == "" ){
                                        $("#TRIP_id_Piloto_label").css("color","red"); 
                                    }
                                },1000);
                            }
                            if(data[i]["ITI_TRIP_tipo"] == "Copiloto"){
                                var l = i;
                                setTimeout(function(){
                                    $("#TRIP_id_Copiloto").val(data[l]["TRIP_id"]).trigger('change.select2');
                                    if( data[l]["TRIP_id"] == null || data[l]["TRIP_id"] == "" ){
                                        $("#TRIP_id_Copiloto_label").css("color","red");
                                    }
                                },1500);
                            }
                            if(data[i]["ITI_TRIP_tipo"] == "JefeCabina"){
                                var m = i;
                                setTimeout(function(){
                                    $("#TRIP_id_JejeCabina").val(data[m]["TRIP_id"]).trigger('change.select2');
                                    if( data[m]["TRIP_id"] == null || data[m]["TRIP_id"] == "" ){
                                        $("#TRIP_id_JejeCabina_label").css("color","red");
                                    }
                                },1000);
                            }
                            if((data[i]["ITI_TRIP_tipo"]).substring(0,10) == 'TripCabina'){
                                q++;
                                if(q < 2){
                                    var o = i;
                                    setTimeout(function(){
                                        $("#TRIP_id_TripCabina1").val(data[o]["TRIP_id"]).trigger('change.select2');
                                        if( data[o]["TRIP_id"] == null || data[o]["TRIP_id"] == "" ){
                                            $("#TRIP_id_TripCabina1_label").css("color","red");
                                        }
                                    },1000);
                                }
                                if(q > 1){
                                    p[q] = i;
                                    agregar_TripCabinaProg();
                                    setTimeout(function(){
                                        for(var r = 2; r <= q; r++){
                                            var s = p[r];
                                            $("#TRIP_id_TripCabina" + r).val(data[s]["TRIP_id"]).trigger('change.select2');
                                            $("#TRIP_id_TripCabina" + r).prop("disabled","disabled");
                                            if( data[s]["TRIP_id"] == null || data[s]["TRIP_id"] == "" ){
                                                $("#TRIP_id_TripCabina" + r + "_label").css("color","red");
                                            }
                                        }
                                    },1000);
                                }
                            }
                        }

                        $("#TIPTRIPU_id_cabina").val(data[0]["TIPTRIPU_id"]).trigger('change.select2');
                    };
                });
            }
            $("#preloader").css("display","none");
        }
        
        function enviarCorreoProgrxDia(fchProg){
            var TIPTRIPDET_id = $("#TIPTRIPDET_idHidden").val();
            if( TIPTRIPDET_id = "1" ){
               var TipoTripulante = "Pilotos";
            } else if( TIPTRIPDET_id = "2" ){
                var TipoTripulante = "Copilotos";
            } else if( TIPTRIPDET_id = "8" ){
                var TipoTripulante = "Jefes de Cabina";
            } else if( TIPTRIPDET_id = "5" ){
                var TipoTripulante = "Tripulantes de Cabina";
            }
            
            var envio = confirm('Advertencia: Se enviará el Correo de la Programación Mensual (El Mes Completo) a todos los' + TipoTripulante + '. ¿Estas seguro de enviarlo (SI [ok] / NO [cancelar])?.');
            if (envio){
                var url = "<?php echo URLLOGICA?>programacion/enviarCorreoProgramacionMes/";
                $("#preloader").css("display","block");
                var parametros = {
                    "fchProg" : fchProg,
                    "TIPTRIPDET_id" : $("#TIPTRIPDET_idHidden").val(),
                };
                $.post(url,parametros,
                function(data){
                    $("#preloader").css("display","none");
                });
            } else {
                return false;
            }
        }
        
        function enviarCorreoProgrxTrip(fchProg,TRIP_id,Tripulante){
            
            var envio = confirm('Advertencia: Se enviará el Correo de la Programación Mensual del Tripulante ' + Tripulante + '. ¿Estas seguro de enviarlo (SI [ok] / NO [cancelar])?.');
            if (envio){
                var url = "<?php echo URLLOGICA?>programacion/enviarCorreoProgramacionMes/";
                $("#preloader").css("display","block");
                var parametros = {
                    "fchProg" : fchProg,
                    "TRIP_id" : TRIP_id,
                };
                $.post(url,parametros,
                function(data){
                    $("#preloader").css("display","none");
                });
            } else {
                return false;
            }
        }
        
        /*function siguienteDiaProgxDia(){
            var leftPos = $('.innerWrapper').scrollLeft();
            $(".innerWrapper").animate({scrollLeft: leftPos + 60}, 800);
        }
        
        function anteriorDiaProgxDia(){
            var leftPos = $('.innerWrapper').scrollLeft();
            $(".innerWrapper").animate({scrollLeft: leftPos - 60}, 800);
        }*/
        
    </script>
    <!-- /.content-wrapper -->
    <?php include "footer_view.php";?>
