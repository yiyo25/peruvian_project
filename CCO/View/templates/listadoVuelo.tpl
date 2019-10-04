
<div class='box box-danger' id="el">
    <input type="hidden" id="fecha_vuelo_dia" value="{$fecha}">
    <div class="box-body">
        <div id="MainContent_search" class="panel panel-default">
            <div class="panel-body">
                <div class="row">
                    <form class="form-horizontal" method="GET" action="" style="background-color:#FFF;padding:5px">
                        <div class="row">
                            <div class="col-xs-12 col-sm-4 col-md-3" style="padding-top: 10px;">
                                <div class="form-group">
                                    <label for="search" class="control-label col-xs-12 col-sm-12 col-md-4" style="padding-top: 8px !important;">Fecha:</label>
                                    <div class="col-xs-12 col-sm-12 col-md-8">
                                        <div class='input-group date' id='datetimepicker3'>
                                            <input type='text' class="form-control" id="fecha" name="fecha" value="{$fecha}"/>
                                            <span class="input-group-addon">
                                                <span class="glyphicon glyphicon-calendar"></span>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-4 col-md-3" style="padding-top: 10px;">
                                <div class="form-group">
                                    <label for="search" class="control-label col-xs-12 col-sm-12 col-md-6" style="padding-top: 8px !important;">Localidad:</label>
                                    <div class="col-xs-12 col-sm-12 col-md-6">
                                        <input type='text' class="form-control" id="fecha" name="origen" value="{$ciudad_origen}" maxlength="3"/>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-4 col-md-3" style="padding-top: 10px;">
                                <div class="form-group">
                                    <label for="search" class="control-label col-xs-12 col-sm-12 col-md-6" style="padding-top: 8px !important;">Nro. Vuelo:</label>
                                    <div class="col-xs-12 col-sm-12 col-md-6">
                                        <input type='text' class="form-control" id="fecha" name="nro_vuelo" value="{$nro_vuelo}" maxlength="4"/>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-3 col-md-2" style="padding-top: 10px;" style="float: left !important;">
                                <button type="submit"  class="btn btn-danger btn-search col-xs-12"><i class="fa fa-search"></i> Buscar</button>
                            </div>
                        </div>
                    </form>
                    <div class="col-md-6 col-md-offset-6 text-center">
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-10" style="padding-top: 10px;">

                                {if $array_vuelos|@count gt 0}
                                    {if $permiso[0]["Exportar"] eq 1}
                                    <div class="col-xs-4 col-sm-4 col-md-3" style="float: right !important;">
                                        <a href="{$SERVER_NAME}index/exportarExcel?fecha={$fecha}" ><img src="{$SERVER_PUBLIC}img/excel-import.png" width="50" height="50"></a>
                                    </div>
                                    {/if}
                                    {if $permiso[0]["Procesar"] eq 1}
                                    <div class="col-xs-4 col-sm-4 col-md-3" style="float: right !important;">
                                       <a href="#" id="cierre_vuelo"><img src="{$SERVER_PUBLIC}img/closed-airplane.png" width="50" height="50" title="Cerrar Vuelos"></a>
                                    </div>
                                    {/if}

                                {/if}
                                {if $permiso[0]["Agregar"] eq 1 }
                                <div class="col-xs-4 col-sm-4 col-md-3" style="float: right !important;">
                                    <a href="{$SERVER_NAME}vuelo/create?fecha={$fecha}" ><img src="{$SERVER_PUBLIC}img/add_flight.png" width="50" height="50"></a>
                                </div>
                                {/if}
                            </div>
                        </div>
                    </div>
                     
                </div>
            </div>
        </div>

        {*<div id="MainContent_listaVuelo" class="panel panel-default">*}
            <div class="table-responsive">
                <table id="tblvuelos" class="table table-striped table-hover table-bordered" >
                    <thead>
                        <tr >
                            <th colspan="4"></th>
                            <th colspan="3" style="text-align: center; border-color: #f2dede; box-shadow: 2px 2px 4px #f2dede;" >Pasajero</th>
                            <th colspan="2" style="text-align: center; border-color: #f2dede; box-shadow: 2px 2px 4px #f2dede;" >Equipaje</th>
                            <th colspan="2" style="text-align: center; border-color: #f2dede; box-shadow: 2px 2px 4px #f2dede;" >Hora</th>
                            {*<th colspan="2" style="text-align: center; border-color: #f2dede; box-shadow: 2px 2px 4px #f2dede;" >Combustible</th>*}
                            
                        </tr>
                        <tr style="background-color: red; color:white;">
                          <th  scope="col" >Fecha</th>
                          <th  scope="col" >Matrícula</th>
                          <th scope="col" >Nro. Vuelo</th>
                          <th  scope="col" >Ruta</th>
                          <th  scope="col" >AD</th>
                          <th  scope="col" >CD</th>
                          <th  scope="col" >IF</th>
                          <th  scope="col" >KGS</th>
                          <th  scope="col" >PZS</th>
                          <th  scope="col">T Off</th>
                          <th  scope="col" >Arr-in</th>
                          <th  colspan="5" >Opciones</th>
                        </tr>
                      
                    </thead>
                    <tbody>
                         {assign var="ca" value=0}
                        {section name=cont loop=$array_vuelos["data"]}
                           
                            <tr class="{$array_vuelos["data"][cont]->class_tr} ">
                                <td class="row" {if $array_vuelos["data"][cont]->filas_incompleta eq "incompleto"} style="color:red;" {/if}>{$array_vuelos["data"][cont]->fecha_vuelo}</td>
                            <td {if $array_vuelos["data"][cont]->filas_incompleta eq "incompleto"} style="color:red;" {/if}>{$array_vuelos["data"][cont]->id_matricula|replace:"-":""}</td>
                            <td {if $array_vuelos["data"][cont]->filas_incompleta eq "incompleto"} style="color:red;" {/if}>{$array_vuelos["data"][cont]->nro_vuelo}</td>
                            <td {if $array_vuelos["data"][cont]->filas_incompleta eq "incompleto"} style="color:red;" {/if}>{$array_vuelos["data"][cont]->ruta}</td>

                            <td>{$array_vuelos["data"][cont]->nro_adultos}</td>
                            <td>{$array_vuelos["data"][cont]->nro_menores}</td>
                            <td>{$array_vuelos["data"][cont]->nro_infantes}</td>
                            <td>{$array_vuelos["data"][cont]->nro_klos}</td>
                            <td>{$array_vuelos["data"][cont]->nro_piezas}</td>
                            <td>{$array_vuelos["data"][cont]->t_off}</td>
                            <td ><span {if $array_vuelos["data"][cont]->color_arr_in neq ""} class="notime" {/if}>
                                    {$array_vuelos["data"][cont]->arr_in}</span></td>
                           {* <td>0000</td>
                            <td>0000</td>*}
                          
                                 {*<div class="btn-group">
                                    <button type="button" class="btn btn-danger dropdown-toggle"
                                            data-toggle="dropdown" >
                                      Ver Opciones <span class="caret"></span>
                                    </button>

                                    <ul class="dropdown-menu" role="menu">*}
                                        {section name=opt loop=$opciones}

                                            {if $array_vuelos["data"][cont]->orden==1 && 
                                                $array_vuelos["data"][cont]->vuelo_direccion=="IDA" && 
                                                $array_vuelos["data"][cont]->vuelo_operativo=="O"}
                                                    {assign var="ca" value=1}
                                            {else}   
                                                 {assign var="ca" value=0}
                                            {/if}

                                            {if $array_vuelos["data"][cont]->vuelo_operativo=="O"}
                                                {assign var="op" value=0}
                                            {else}
                                                {assign var="op" value=1}
                                            {/if}    
                                            {*<li>*}
                                                {if $opciones[opt]["acceso"] eq 1}
                                                <td ><a {if ($ca==0 && $opciones[opt]["id"] == "tripulacion") or 
                                                        (   $op==1 && ($opciones[opt]["id"] == "flighttime" or 
                                                            $opciones[opt]["id"] == "combustible" or 
                                                            $opciones[opt]["id"] == "editarVuelo")
                                                        ) } 
                                                        style="display: none;"
                                                    {/if}href="#" id="{$opciones[opt]["id"]}" class="{$opciones[opt]["clase"]}"
                                                data-id-detalle="{$array_vuelos["data"][cont]->id_vuelo_detalle}" 
                                                data-vuelo-cabecera="{$array_vuelos["data"][cont]->id_vuelo_cabecera}" 
                                                data-matricula="{$array_vuelos["data"][cont]->id_matricula}"
                                                data-fecha-vuelo="{$array_vuelos["data"][cont]->fecha_vuelo}"
                                                data-nro-vuelo="{$array_vuelos["data"][cont]->nro_vuelo}"
                                                data-ruta="{$array_vuelos["data"][cont]->ruta}" 
                                                {if $opciones[opt]["id"] eq "flighttime"}data-flag_horablock ="{$array_vuelos["data"][cont]->flag_hora}"{/if}
                                                title="{$opciones[opt]["title"]}">
                                                 <img src="{$opciones[opt]["icon"]}" width="25" height="25" title="{$opciones[opt]["title"]}"/></a>
                                                </td>
                                                {/if}
                                            {*</li>*}
                                        {/section}
                                   {* </ul>
                                </div>*}
                               
                            
                        </tr>
                         {assign var="ca" value=$ca+1}
                        {/section}
                    </tbody>
                </table>
            </div>   
        {*</div>*}
    </div>
</div>


<!-- Dinamic modal -->

<div class="modal fade" id="dinamicModal" role="dialog"   aria-hidden="true" style="overflow-y: scroll;">
    <div id="dialogM" class="modal-dialog modal-lg ">

     <!-- Modal content-->
     <div class="modal-content">
        <div class="modal-header modal-header-danger" style='padding-top: 5px !important; padding-bottom: 5px !important;'>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 id="title_modal" class="modal-title"></h4>
        </div>
        <div id="body_dinamicac_modal" class="modal-body">

        </div>
     </div>
    </div>
</div>

<style>
    
.table-responsive {
    color: #566787;
    font-family: 'Varela Round', sans-serif;
    font-size: 13px;
}
table tr {
  text-align: center;
}
table th {
  text-align: center;
}

.btn-search {
    color: #fff;
    background-color: #d5040a;
    border-color: #d5040a;
}

.pagination > .active > a, 
.pagination > .active > span, 
.pagination > .active > a:hover, 
.pagination > .active > span:hover, 
.pagination > .active > a:focus, 
.pagination > .active > span:focus {
    z-index: 3;
    color: #fff;
    cursor: default;
    background-color: #d5040a;
    border-color: #d5040a;
}

.modal {
    text-align: center;
}

</style>



         
 