<input type="hidden" value="{$id_file}" id="id_fileTuua">
<div class='box box-danger' id="el">
    <div class="box-body">
        <div id="MainContent_search" class="panel panel-default">
            <div class="panel-body">
                <div  class="row">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <a href="{$BASE_URL}tuua_application/ta_listado_vuelos?idFileTuua={$cabecera[0]['idFileTuua']}&fecha_ini={$cabecera[0]['fecVueloTip']}&aeroEmbarque={$cabecera[0]['aeroEmbarque']}"><img src="{$SERVER_PUBLIC}img/icon_back.png" width="30" height="30"></img>Atras</a>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-xs-12 col-xl-12">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <tr class="danger">
                                    <td colspan="4" align="center">Detalle del Vuelo</td>
                                </tr>
                                <tr>
                                    <td align="center">Id File Archivo : <br><strong class=""> {$cabecera[0]["idFileTuua"]}</strong></td>
                                    <td align="center">Nombre Archivo  :<br> <strong class="">{$cabecera[0]["nombreArchivo"]} </strong></td>
                                    <td align="center"># Vuelo : <br><strong class=" ">{$cabecera[0]["nroVuelo"]}</strong></td>
                                    <td align="center">Fecha de Vuelo : <br><strong class="">{$cabecera[0]["fecVueloTip"]}</strong></td>
                                </tr>
                                <tr>

                                    <td align="center">Matricula de Avion : <br><strong class="">{$cabecera[0]["matriculaAvion"]}</strong></td>
                                    <td align="center">Cantidad de Pax : <br><strong class="">{$cantidad_pax}</strong></td>
                                    <td align="center">Ciudad Embarque:<br> <strong class="">{$cabecera[0]["aeroEmbarque"]}</strong></td>
                                    <td align="center">Estado de Envio: <br><strong class="">{$cabecera[0]["Estado"]}</strong></td>
                                </tr>

                            </table>
                        </div>
                    </div>
                </div>
                {if $permisos[0]["Agregar"] eq 1}
                <div  class="row">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <button type="button" class="btn btn-danger button" id="btn-add-pax" data-toggle="modal" data-target="#modificarPasajero" >Agregar Pasajero</button>
                        </div>
                    </div>
                </div>
                {/if}
            </div>
        </div>
        <div id="MainContent_search" class="panel panel-default">
            <div class="panel-body">
                <div class="table-responsive">
                    <div class="row">
                        <div class="col-lg-12">
                            <table id="tblpasajeros" class="table table-hover  table-striped table-bordered">
                                <thead>
                                <tr style="text-align: center;">
                                    <th style="text-align: center;">Nro Ticket</th>
                                    <th style="text-align: center;">Apellido</th>
                                    <th style="text-align: center;">Nombre</th>
                                    <th style="text-align: center;">Pax</th>
                                    <th style="text-align: center;">Foid</th>
                                    <th style="text-align: center;">Destino</th>
                                    <th style="text-align: center;">Clase</th>
                                    <th style="text-align: center;">Cupon</th>
                                    <th style="text-align: center;">Ref</th>
                                    <th style="text-align: center;">Asiento</th>
                                    <th style="text-align: center;">Nro Doc.</th>
                                    <th style="text-align: center;">Nac</th>
                                    <th style="text-align: center;">Opciones</th>
                                </tr>
                                </thead>
                                <tbody>
                                {section name=cont loop=$pasajeros}
                                    <tr {if isset($pasajeros[cont]["color"])} class="danger" {/if}>
                                        <td align="center">{$pasajeros[cont]["nroTicketPax"]}</td>
                                        <td align="center">{$pasajeros[cont]["apellidoPax"]}</td>
                                        <td align="center">{$pasajeros[cont]["nombrePax"]}</td>
                                        <td align="center">{$pasajeros[cont]["tipoPax"]}</td>
                                        <td align="center">{$pasajeros[cont]["foidPax"]}</td>
                                        <td align="center">{$pasajeros[cont]["destinoPax"]}</td>
                                        <td align="center">{$pasajeros[cont]["clasePax"]}</td>
                                        <td align="center">{$pasajeros[cont]["nroCuponPax"]}</td>
                                        <td align="center">{$pasajeros[cont]["nroReferencia"]}</td>
                                        <td align="center">{$pasajeros[cont]["nroAsientoPax"]}</td>
                                        <td align="center">{$pasajeros[cont]["nroDoc"]}</td>
                                        <td align="center">{$pasajeros[cont]["nacPax"]}</td>
                                        <td align="center">
                                            {if $permisos[0]["Modificar"] eq 1 || $permisos[0]["Eliminar"] eq 1}
                                            <div class="dropdown">
                                                <button class="btn btn-danger dropdown-toggle" type="button" data-toggle="dropdown">Opciones
                                                    <span class="caret"></span></button>
                                                <ul class="dropdown-menu">
                                                    {if $permisos[0]["Modificar"] eq 1}
                                                    <li>
                                                        <a href="#"  class="modificar-pasajero" idItensPax="{$pasajeros[cont]["idItensPax"]}">Modificar</a>
                                                    </li>

                                                    {/if}

                                                    {if $permisos[0]["Eliminar"] eq 1}

                                                    <li>
                                                        <a href="#" class="eliminar-pasajero" style="color: red" idItensPax="{$pasajeros[cont]["idItensPax"]}" name_pax="{$pasajeros[cont]["nombrePax"]} {$pasajeros[cont]["apellidoPax"]}">Eliminar</a>
                                                    </li>
                                                    {/if}
                                                </ul>
                                            </div>
                                            {/if}
                                        </td>
                                    </tr>
                                {/section}
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Dinamic modal -->

<div class="modal fade" id="dinamicModal" role="dialog"   aria-hidden="true" style="overflow-y: scroll;">
    <div id="dialogM" class="modal-dialog ">
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
    .pagination > .active > a,
    .pagination > .active > span,
    .pagination > .active > a:hover,
    .pagination > .active > span:hover,
    .pagination > .active > a:focus,
    .pagination > .active > span:focus {
        z-index: 3;
        color: #fff;
        cursor: default;
        background-color: #D73925;
        border-color: #D73925;
    }
</style>


