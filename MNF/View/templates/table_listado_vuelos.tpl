<div class="table-responsive">
    <div class="row">
        <div class="col-lg-12 col-sm-12 col-md-12">
            <div class="col-lg-12">
                <table id="tblvuelos" class="table-hover table table-striped table-bordered " >
                    <thead>
                        <tr>
                            <th  >Id File</th>
                            <th  >Nombre Archivo</th>
                            <th  >Vuelo</th>
                            <th  >Fecha</th>
                            <th >Origen</th>
                            <th  ># Pax</th>
                            <th >Id Mani.</th>
                            <th >Estado</th>
                            <th >Opciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        {section name=cont loop=$data}
                            <tr >
                                <td >{$data[cont]["idFileTuua"]}</td>
                                <td >{$data[cont]["nombreArchivo"]}</td>
                                <td >{$data[cont]["nroVuelo"]}</td>
                                <td >{$data[cont]["Fecha"]}</td>
                                <td >{$data[cont]["aeroEmbarque"]}</td>
                                <td>{$data[cont]["Pax"]}</td>
                                <td >{$data[cont]["IdManifiesto"]}</td>
                                <td >{$data[cont]["nEstado"]} - {$data[cont]["Estado"]}</td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-danger dropdown-toggle" type="button" data-toggle="dropdown">Opciones
                                            <span class="caret"></span></button>
                                        <ul class="dropdown-menu">
                                            {section name=opt loop=$permisos_opciones}
                                                {if $permisos_opciones[opt]["acceso"] eq 1}
                                                    {if $permisos_opciones[opt]["id"] eq "Eliminar"}
                                                        <li class="divider"></li>
                                                    {/if}
                                                    <li>
                                                        <a {if $permisos_opciones[opt]["id"]  eq "MNF_DETALLE_PAX"} href="{$permisos_opciones[opt]['link']}/{$data[cont]["idFileTuua"]}"{else} href="{$permisos_opciones[opt]['link']}"{/if}

                                                            {if $permisos_opciones[opt]["id"]  eq "MNF_IMPORTAR_PAX"}
                                                                onclick="importar_pax({$data[cont]['idFileTuua']},'{$data[cont]["aeroEmbarque"]}','{$data[cont]["Fecha"]}','{$data[cont]["nroVuelo"]}')"
                                                            {/if}
                                                            {if $permisos_opciones[opt]["id"]  eq "Reprocesar"}
                                                                onclick="reprocesar({$data[cont]['idFileTuua']},'{$data[cont]["aeroEmbarque"]}')"
                                                            {/if}
                                                            {if $permisos_opciones[opt]["id"]  eq "Modificar"}
                                                                onclick="opendEdit({$data[cont]['idFileTuua']})"
                                                            {/if}
                                                            {if $permisos_opciones[opt]["id"]  eq "Eliminar"}
                                                                onclick="eliminar({$data[cont]['idFileTuua']},'{$data[cont]["aeroEmbarque"]}')"
                                                            {/if}
                                                           style="color: {$permisos_opciones[opt]["color"]}"><img src="{$permisos_opciones[opt]["icon"]}" width="25" height="25" /> {$permisos_opciones[opt]["text"]}
                                                        </a>
                                                    </li>
                                                {/if}
                                            {/section}
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        {/section}
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


