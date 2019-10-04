<?php include "header_view.php";?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
				Listado de Reprogramación <small>Resúmen Reprogramación de Vuelo</small>
            </h1>
            <ol class="breadcrumb">
                <li><i class="fa fa-thumb-tack"></i> Reprogramación de Vuelo</li>
                <li class="active">
                    Listado de Reprogramación de Vuelo
                </li>
            </ol>
        </section>
        <!-- Main content -->
        <section class="content">
            <div class='box box-danger'>
                <div class="box-body">
                    <div id="MainContent_Div1" class="panel panel-default">
                        <div class="panel-heading clearfix"  style="padding: 7px !important">
                            <span><strong>Buscar Fecha</strong></span>
                        </div>
                            <div class="row-fluid">
                                <div class="form-group">
                                    <label for="bITI_fch" class="col-md-2 control-label">Fch. de Programación </label>
                                    <div class="col-md-2">
                                        <div class='input-group date datetimepicker1'>
                                            <input type="text" name="bITI_fch" id="bITI_fch" value="<?php if($_SESSION["ITI_fch"] != '') { echo $_SESSION["ITI_fch"]; } else { echo date("d/m/Y"); }?>" class="form-control input-sm" style="text-transform: uppercase; width: 100% !important;" />
                                            <span class="input-group-addon">
                                                <span class="glyphicon glyphicon-calendar"></span>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-2">
                                        <button type="button" id="listarProgramacionFchResumen" class="btn btn-danger btn-block" onclick="listarReprogramacionFchResumen('<?php echo URLLOGICA?>programacion/listarProgramacionFchResumenMatriz/','<?php echo URLLOGICA?>programacion/listarProgramacionFchResumen/','listar');">Listar</button>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="bAVI_num_cola" class="col-md-2 control-label">N° de Cola</label>
                                    <div class="col-md-2">
                                        <select name="bAVI_id" id="bAVI_id" class="form-control input-sm js-example-basic-single">
                                            <option value="">Selecccione Avión</option>
                                        <?php foreach($this->objAvion as $listaAv){ ?>
                                            <option value="<?php echo $listaAv["AVI_id"];?>"><?php echo $listaAv["AVI_num_cola"];?></option>
                                        <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-2">
                                        <button type="button" class="btn btn-danger btn-block" onclick="listarReprogramacionFchResumen('<?php echo URLLOGICA?>programacion/listarProgramacionFchResumenMatriz/','<?php echo URLLOGICA?>programacion/listarProgramacionFchResumen/','buscar');">Buscar</button>
                                    </div>
                                </div>
                            </div>
                            <div class="clearfix" style="padding: 5px;"></div>
                    </div>
                    <div id="MainContent_listaPro" class="panel panel-default">
                        <div class="panel-heading clearfix" style="padding: 7px !important">
                            <span id="MainContent_tituloPro"><strong>Lista de Itinerario</strong></span>
                        </div>
                        <div class="area_resultado table-responsive">
                            <table id="listaItinerario" class="display" cellspacing="0" cellpadding="2">
                                <thead>
                                    <tr>
                                        <th scope="col" rowspan="2" style="text-align: center">N° de Vuelo</th>
                                        <th scope="col" rowspan="2" style="text-align: center">Avión</th>
                                        <th scope="col" rowspan="2" style="text-align: center">Origen</th>
                                        <th scope="col" rowspan="2" style="text-align: center">Destino</th>
                                        <th scope="col" rowspan="2" style="text-align: center">Hora Salida</th>
                                        <th scope="col" rowspan="2" style="text-align: center">Hora Llegada</th>
                                        <th scope="col" colspan="6" style="text-align: center">Tripulantes</th>
                                    </tr>
                                    <tr>
                                        <th scope="col">Piloto/<br/>Instructor</th>
                                        <th scope="col">Copiloto</th>
                                        <th scope="col">Jefe Cabina</th>
                                        <th scope="col">Trip. Cabina</th>
                                        <th scope="col">Apoyo Vuelo</th>
                                    </tr>
                                </thead>
                                <tbody id="listaProgramacion">
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- /.content -->
    </div>
    
    <script type="text/javascript">
        $(function () {
            $("#listarProgramacionFchResumen").click();
        });
        
        function listarComboAvionDisponiblesView(select,ITI_fchini,ITI_fchfin){
            listarComboAvionDisponibles('<?php echo URLLOGICA?>avion/listarAvionDisponiblesxFecha/',select,ITI_fchini,ITI_fchfin);
        }
        
        function listarReprogramacionFchResumen(url_matriz,url,accion){
            $("#preloader").css("display","block");

            var table = $('#listaItinerario').DataTable();
            table.destroy();

            if(accion == 'listar'){
                $("#bAVI_id").val("").trigger('change.select2');
                var parametros = {
                    "accion" : accion,
                    "ITI_fch" : $("#bITI_fch").val(),
                };
            }
            if(accion == 'buscar'){
                var parametros = {
                    "accion" : accion,
                    "ITI_fch" : $("#bITI_fch").val(),
                    "AVI_id" : $("#bAVI_id").val()
                };
            }

            $.post(url_matriz,parametros,
            function(data_matriz){
                if(data_matriz == ""){
                    //alert("No existe datos de la Fecha Seleccionada.");
                    $("#listaProgramacion").empty();
                    myDataTables_sinPaginacion('listaItinerario');
                    $("#preloader").css("display", "none");
                } else {
                    $.post(url,parametros,
                    function(data){
                        if(data == ""){
                            //alert("No existe datos de la Fecha Seleccionada.");
                            $("#listaProgramacion").empty();
                            myDataTables_sinPaginacion('listaItinerario');
                            $("#preloader").css("display", "none");
                        } else {
                            $("#listaProgramacion").empty();
                            var q = 0;
                            var p = {};
                            for (var i = 1; i <= data_matriz.length; i++) {
                                html = '<tr>'
                                    + '<td style="width:auto;">' + data_matriz[i-1]["RUT_num_vuelo"] + '</td>'
                                    + '<td style="width:auto;">'
                                        + '<select name="AVI_id' + (i) + '" id="AVI_id' + (i) + '" class="form-control input-sm js-example-basic-single_extra">'
                                            + '<option value="">Selecccione Avión</option>'
                                        + '</select>'
                                    + '</td>'
                                    + '<td style="width:auto;">' + data_matriz[i-1]["CIU_id_origen"] + '</td>'
                                    + '<td style="width:auto;">' + data_matriz[i-1]["CIU_id_destino"] + '</td>'
                                    + '<td style="width:auto;">' + data_matriz[i-1]["RUT_hora_salida"] + '</td>'
                                    + '<td style="width:auto;">' + data_matriz[i-1]["RUT_hora_llegada"] + '</td>'
                                    var Instructor = "";
                                    var Piloto = "";
                                    var Copiloto = "";
                                    var JefeCabina = "";
                                    var TripCabina = "";
                                    var ApoyoVuelo = "---";
                                    for (var j = 1; j <= data.length; j++) {
                                        if(data_matriz[i-1]["ITI_id"] == data[j-1]["ITI_id"]){
                                            if(data[j - 1]["ITI_TRIP_tipo"] == 'Instructor'){
                                                Instructor = data[j - 1]["TRIP_nombre"];
                                            } else if(data[j - 1]["ITI_TRIP_tipo"] == 'Piloto'){
                                                Piloto = data[j - 1]["TRIP_nombre"] + " " + data[j - 1]["TRIP_apellido"];
                                            } else if(data[j - 1]["ITI_TRIP_tipo"] == 'Copiloto'){
                                                Copiloto = data[j - 1]["TRIP_nombre"] + " " + data[j - 1]["TRIP_apellido"];
                                            } else if(data[j - 1]["ITI_TRIP_tipo"] == 'JefeCabina'){
                                                JefeCabina = data[j - 1]["TRIP_nombre"] + " " + data[j - 1]["TRIP_apellido"];
                                            } else if(data[j - 1]["ITI_TRIP_tipo"] == 'ApoyoVuelo'){
                                                ApoyoVuelo = data[j - 1]["TRIP_nombre"] + " " + data[j - 1]["TRIP_apellido"];
                                            } else if((data[j - 1]["ITI_TRIP_tipo"]).substring(0,10) == 'TripCabina'){
                                                TripCabina += data[j - 1]["TRIP_nombre"] + " " + data[j - 1]["TRIP_apellido"] + "/ <br/>";
                                            }
                                        }
                                    }
                                    if(Piloto != "" && Instructor == ""){
                                        html += '<td style="width:auto;">' + Piloto + '</td>'
                                    } else if(Piloto == "" && Instructor != ""){
                                        html += '<td style="width:auto;">' + Instructor + '</td>'
                                    } else {
                                        html += '<td style="width:auto;">' + Piloto + " /<br/>" + Instructor + '</td>'
                                    }
                                html += '<td style="width:auto;">' + Copiloto + '</td>'
                                html += '<td style="width:auto;">' + JefeCabina + '</td>'
                                html += '<td style="width:auto;">' + TripCabina + '</td>'
                                html += '<td style="width:auto;">' + ApoyoVuelo + '</td>'
                                + '</tr>';
                                $("#listaProgramacion").append(html);
                                listarComboAvionDisponiblesView($("#AVI_id" + i),$("#bITI_fch").val(),$("#bITI_fch").val());
                                q++;
                                p[q] = i;
                            };
                            setTimeout(function(){
                                for(var r = 1; r <= data_matriz.length; r++){
                                    var s = p[r];
                                    $("#AVI_id" + r).val(data_matriz[s-1]["AVI_id"]).trigger('change.select2');;
                                }
                            },1000);
                        }
                    $(document).ready(function() { $(".js-example-basic-single_extra").select2(); });
                    myDataTables_sinPaginacion('listaItinerario');
                    $("#preloader").css("display", "none");
                    });
                }
            });
        }
    </script>
    <!-- /.content-wrapper -->
<?php include "footer_view.php";?>