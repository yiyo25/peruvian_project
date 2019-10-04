{if $array_data|@count gt 0} 
    <div class="panel panel-danger " style="margin-top: 20px;">
        <div class="panel-heading" style="padding-bottom: 5px !important; padding-top: 5px!important;text-align: center"><b>Lista Cierre Vuelo</b></div>
        <div class="panel-body">

            <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>Matricula</th>
                            <th>Nro. Vuelo</th>
                            <th style="width: 100px;">Ruta</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        {section name=ci loop=$array_data["data"]}
                        <tr>	
                            <td style="vertical-align: middle;">{$array_data["data"][ci]->fecha_vuelo}</td>
                            <td style="vertical-align: middle;">{$array_data["data"][ci]->id_matricula}</td>
                            <td style="vertical-align: middle;">{$array_data["data"][ci]->nro_vuelo}</td>
                            <td style="vertical-align: middle;">{$array_data["data"][ci]->ruta}</td>
                            <td style="color:red;">{$array_data["data"][ci]->error["mensaje"]}</td>
                        </tr>
                        {/section}
                    </tbody>
                </table>
            </div>

        </div>
    </div>
{else}
    
   
    <div class="panel panel-danger">
        
        <div class="panel-body">
            <div  class="col-md-10 col-md-offset-1">
                <div class="row">
                    
                    <p style="text-align: center;">
                        {if $verificar_cierre gt 0}
                            <b>Todos los vuelos fueron llenados de forma comforme.
                               ¿desea realizar el cierre respectivo del dia {$fecha_cierre}? , despues de realizar dicho cierre ya no podra modificar.
                            </b>
                        {else}
                            <b>
                                Los vuelos del dia {$fecha_cierre} ya fueron cerados, si falta cerrar algun vuelo contactar con el administrador.
                            </b>
                        {/if}
                    </p>
                </div>
                
            </div>
            {if $verificar_cierre gt 0}
                <div class="col-xs-9 col-sm-6 col-md-6 col-md-offset-5 col-sm-offset-5 col-xs-offset-3">
                    <div class="row">
                        <button type="button" class="btn btn-danger " data-dismiss="modal">Cancelar</button>   
                        <button type="button" class="btn btn-success btn_cerrar_vuelo_dia">Aceptar</button>
                    </div>
                </div>
            {else}
                <div class="col-xs-7 col-sm-7 col-md-6 col-md-offset-6 col-sm-offset-5 col-xs-offset-5">
                    <div class="row">
                        <button type="button" class="btn btn-danger " data-dismiss="modal">OK</button> 
                    </div>
                </div>
                
            {/if}
        </div>
        
    </div>
    
{/if}