<div class='box box-danger' id="principal">
    <div class="box-body">
        <div id="MainContent_search" class="panel panel-default">
            <div class="panel-body">
                <div class="row">
                    <form class="form-horizontal" method="GET" action="" style="background-color:#FFF;padding:5px">
                        <div class="row">
                            <div class="col-xs-12 col-sm-6 col-md-4" style="padding-top: 10px;">
                                <div class="form-group">
                                    <label for="search" class="control-label col-xs-12 col-sm-12 col-md-5" style="padding-top: 8px !important;">Fecha Inicio:</label>
                                    <div class="col-xs-12 col-sm-12 col-md-7">
                                        <div class='input-group date' id='datetimepickerini'>
                                            <input type='text' class="form-control" id="fecha_ini" name="fecha_inicio" value="{$fecha_ini}"/>
                                            <span class="input-group-addon">
                                                <span class="glyphicon glyphicon-calendar"></span>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-4" style="padding-top: 10px;">
                                <div class="form-group">
                                    <label for="search" class="control-label col-xs-12 col-sm-12 col-md-5" style="padding-top: 8px !important;">Fecha fin:</label>
                                    <div class="col-xs-12 col-sm-12 col-md-7">
                                        <div class='input-group date' id='datetimepickerfin'>
                                            <input type='text' class="form-control" id="fecha_fin" name="fecha_fin" value="{$fecha_fin}"/>
                                            <span class="input-group-addon">
                                                <span class="glyphicon glyphicon-calendar"></span>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-3 col-md-2" style="padding-top: 10px;" style="float: left !important;">
                                <button type="submit"  class="btn btn-danger btn-search col-xs-12"><i class="fa fa-search"></i> Buscar</button>
                            </div>
                        </div>
                    </form>   
                </div>
            </div>
        </div>
        
        <div id="MainContent_search" class="panel panel-default">
            <div class="panel-body">
                <ul class="nav nav-tabs">
                    <li class="active"><a data-toggle="tab" href="#tab1"><b>VR sin escalas</b></a></li>
                    <li><a data-toggle="tab" href="#tab2"><b>VR con escalas</b></a></li>
                </ul>
                <div class="tab-content">
                    <div id="tab1" class="tab-pane fade in active">
                       <div id="MainContent_search" class="panel panel-default">
                          <div class="panel-body">
                                {if $data["sin_escala"]|@count gt 0}
                                    {if $permiso[0]["Exportar"] eq 1}
                                        <div class="row">
                                            <div class="col-xs-4 col-sm-4 col-md-3">
                                                <a href="{$SERVER_NAME}reportes/exportarExcelDGAC?fecha_ini={$fecha_ini}&fecha_fin={$fecha_fin}&tipo=sin_escala" ><img src="{$SERVER_PUBLIC}img/excel-import.png" width="50" height="50"></a>
                                            </div>
                                        </div>
                                    {/if}
                                    <div class="row">
                                        <div class="table-responsive">
                                            <table id="tblvuelos" class="table table-striped table-hover table-bordered">
                                                <thead>
                                                    <tr style="font-size: 12px !important;background-color: #C00000; color:white;">
                                                        <th scope="col">Empresa</th>
                                                        <th scope="col">Fecha</th>
                                                        <th scope="col">Origen</th>
                                                        <th scope="col">Departamento origen</th>
                                                        <th scope="col">Destino</th>
                                                        <th scope="col">Departamento destino</th>        
                                                        <th scope="col">Pasajero Pago Directos</th>        
                                                        <th scope="col">Pasajeros en Conexión</th>            
                                                        <th scope="col">Total Pasajeros no Pagos</th>
                                                        <th scope="col">Total Pasajeros</th>
                                                        <th scope="col">Total Infantes</th>        
                                                        <th scope="col">Carga (Kg.) Pago Directo</th>
                                                        <th scope="col">Carga (Kg.) en Conexión</th>
                                                        <th scope="col">Total Carga (Kg.)</th>
                                                        <th scope="col">Correo (Kg.) Pago Directo</th>
                                                        <th scope="col">Correo (Kg.) en Conexión</th>
                                                        <th scope="col">Total Correo (Kg.)</th>
                                                        <th scope="col">Vuelos Realizados</th>
                                                        <th scope="col">Distancia (Km)</th>
                                                        <th scope="col">Capacidad de Asientos que tiene la aeronave</th>
                                                        <th scope="col">Factor de Ocupación de Pasajeros</th>
                                                        <th scope="col">Capacidad de Carga(KG.) disponible de la Aeronave</th>
                                                        <th scope="col">Factor de Ocupación de la Carga(Kg.)</th>
                                                        <th scope="col">Número de Vuelo</th>
                                                        <th scope="col">Matrícula del avión</th>
                                                        <th scope="col">Fabricante</th>
                                                        <th scope="col">Modelo</th>

                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    {section name=cont loop=$data["sin_escala"]}
                                                        <tr style="font-size: 12px !important;">
                                                            <td align='center'>{$data["sin_escala"][cont]->empresa}</td>
                                                            <td align='center'>{$data["sin_escala"][cont]->fecha}</td>
                                                            <td align='center'>{$data["sin_escala"][cont]->Origen}</td>
                                                            <td align='center'>{$data["sin_escala"][cont]->departamento_origen}</td>
                                                            <td align='center'>{$data["sin_escala"][cont]->destino}</td>
                                                            <td align='center'>{$data["sin_escala"][cont]->departamento_destino}</td>
                                                            <td align='center'>{$data["sin_escala"][cont]->pasajero_pago_directo}</td>
                                                            <td align='center'>{$data["sin_escala"][cont]->pasajeros_en_conexion}</td>
                                                            <td align='center'>{$data["sin_escala"][cont]->tota_pasajero_nopago}</td>
                                                            <td align='center'>{$data["sin_escala"][cont]->total_pasajeros}</td>
                                                            <td align='center'>{$data["sin_escala"][cont]->total_infantes}</td>
                                                            <td align='center'>{$data["sin_escala"][cont]->carga_pago_directo}</td>
                                                            <td align='center'>{$data["sin_escala"][cont]->cargaPagoConexion}</td>
                                                            <td align='center'>{$data["sin_escala"][cont]->cargaPagoTotal}</td>
                                                            <td align='center'>{$data["sin_escala"][cont]->correoPagoDirecto}</td>
                                                            <td align='center'>{$data["sin_escala"][cont]->correoPagoConexion}</td>
                                                            <td align='center'>{$data["sin_escala"][cont]->correoPagoTotal}</td>
                                                            <td align='center'>{$data["sin_escala"][cont]->vueloRealizados}</td>
                                                            <td align='center'>{$data["sin_escala"][cont]->Distancia}</td>
                                                            <td align='center'>{$data["sin_escala"][cont]->capacidadAsientos}</td>
                                                            <td align='center'>{$data["sin_escala"][cont]->factorAsientos}</td>
                                                            <td align='center'>{$data["sin_escala"][cont]->capacidadCarga}</td>
                                                            <td align='center'>{$data["sin_escala"][cont]->factorCarga}</td>
                                                            <td align='center'>{$data["sin_escala"][cont]->nro_vuelo}</td>
                                                            <td align='center'>{$data["sin_escala"][cont]->matricula}</td>
                                                            <td align='center'>{$data["sin_escala"][cont]->fabricante}</td>
                                                            <td align='center'>{$data["sin_escala"][cont]->modelo}</td>
                                                        </tr>
                                                    {/section}
                                                </tbody>
                                            </table>
                                        </div> 
                                    </div>
                                {else}
                                    <div class="row">
                                        <div class="col-xs-4 col-sm-4 col-md-3">
                                            <p>Seleccione un rango de fecha.</p>
                                        </div>
                                        
                                    </div>
                                {/if}
                          </div>
                      </div>
                      
                    </div>
                    <div id="tab2" class="tab-pane fade">
                        <div id="MainContent_search" class="panel panel-default">
                            <div class="panel-body">
                                {if $data["escala"]|@count gt 0}
                                    {if $permiso[0]["Exportar"] eq 1}
                                        <div class="row">
                                           <div class="col-xs-4 col-sm-4 col-md-3">
                                                <a href="{$SERVER_NAME}reportes/exportarExcelDGAC?fecha_ini={$fecha_ini}&fecha_fin={$fecha_fin}&tipo=escala" ><img src="{$SERVER_PUBLIC}img/excel-import.png" width="50" height="50"></a>
                                            </div>
                                        </div>
                                    {/if}
                                    <div class="row">
                                        <div class="table-responsive">
                                            <table  class="table table-striped table-hover table-bordered">
                                                <thead>
                                                    <tr style="font-size: 12px !important; background-color: #C00000; color:white;">
                                                        <th scope="col">Empresa</th>
                                                        <th scope="col">Fecha</th>
                                                        <th scope="col">Origen</th>
                                                        <th scope="col">Departamento Origen</th>
                                                        <th scope="col">Destino</th>
                                                        <th scope="col">Departamento Destino</th>        
                                                        <th scope="col">Pasajero Pago Directos</th>        
                                                        <th scope="col">Pasajeros en Conexión</th>            
                                                        <th scope="col">Total Pasajeros no Pagos</th>
                                                        <th scope="col">Total Pasajeros</th>
                                                        <th scope="col">Total Infantes</th>        
                                                        <th scope="col">Carga (Kg.) Pago Directo</th>
                                                        <th scope="col">Carga (Kg.) en Conexión</th>
                                                        <th scope="col">Total Carga (Kg.)</th>
                                                        <th scope="col">Correo (Kg.) Pago Directo</th>
                                                        <th scope="col">Correo (Kg.) en Conexión</th>
                                                        <th scope="col">Total Correo (Kg.)</th>
                                                        <th scope="col">Vuelos Realizados</th>
                                                        <th scope="col">Distancia (Km)</th>
                                                        <th scope="col">Capacidad de Asientos que tiene la aeronave</th>
                                                        <th scope="col">Factor de Ocupación de Pasajeros</th>
                                                        <th scope="col">Capacidad de Carga(KG.) disponible de la Aeronave</th>
                                                        <th scope="col">Factor de Ocupación de la Carga(Kg.)</th>
                                                        <th scope="col">Número de Vuelo</th>
                                                        <th scope="col">Matrícula del avión</th>
                                                        <th scope="col">Fabricante</th>
                                                        <th scope="col">Modelo</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    {section name=cont loop=$data["escala"]}
                                                        <tr {if $data["escala"][cont]->nro_paradas eq 1} class="danger"{/if} style="font-size: 12px !important;">
                                                            <td align='center'>{$data["escala"][cont]->empresa}</td>
                                                            <td align='center'>{$data["escala"][cont]->fecha}</td>
                                                            <td align='center'>{$data["escala"][cont]->Origen}</td>
                                                            <td align='center'>{$data["escala"][cont]->departamento_origen}</td>
                                                            <td align='center'>{$data["escala"][cont]->destino}</td>
                                                            <td align='center'>{$data["escala"][cont]->departamento_destino}</td>
                                                            <td align='center'>{$data["escala"][cont]->pasajero_pago_directo}</td>
                                                            <td align='center'>{$data["escala"][cont]->pasajeros_en_conexion}</td>
                                                            <td align='center'>{$data["escala"][cont]->tota_pasajero_nopago}</td>
                                                            <td align='center'>{$data["escala"][cont]->total_pasajeros}</td>
                                                            <td align='center'>{$data["escala"][cont]->total_infantes}</td>
                                                            <td align='center'>{$data["escala"][cont]->carga_pago_directo}</td>
                                                            <td align='center'>{$data["escala"][cont]->cargaPagoConexion}</td>
                                                            <td align='center'>{$data["escala"][cont]->cargaPagoTotal}</td>
                                                            <td align='center'>{$data["escala"][cont]->correoPagoDirecto}</td>
                                                            <td align='center'>{$data["escala"][cont]->correoPagoConexion}</td>
                                                            <td align='center'>{$data["escala"][cont]->correoPagoTotal}</td>
                                                            <td align='center'>{$data["escala"][cont]->vueloRealizados}</td>
                                                            <td align='center'>{$data["escala"][cont]->Distancia}</td>
                                                            <td align='center'>{$data["escala"][cont]->capacidadAsientos}</td>
                                                            <td align='center'>{$data["escala"][cont]->factorAsientos}</td>
                                                            <td align='center'>{$data["escala"][cont]->capacidadCarga}</td>
                                                            <td align='center'>{$data["escala"][cont]->factorCarga}</td>
                                                            <td align='center'>{$data["escala"][cont]->nro_vuelo}</td>
                                                            <td align='center'>{$data["escala"][cont]->matricula}</td>
                                                            <td align='center'>{$data["escala"][cont]->fabricante}</td>
                                                            <td align='center'>{$data["escala"][cont]->modelo}</td>
                                                        </tr>
                                                    {/section}
                                                </tbody>
                                            </table>
                                        </div> 
                                    </div>
                                {else}
                                    <div class="row">
                                        <div class="col-xs-4 col-sm-4 col-md-3">
                                            <p>Seleccione un rango de fecha.</p>
                                        </div>
                                        
                                    </div>
                                {/if}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
