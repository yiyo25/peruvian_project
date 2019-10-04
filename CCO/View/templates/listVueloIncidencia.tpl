{if $listVueloIncidencias|@count gt 0}
    <table class="table" style="font-size: 12px;">
        <thead>
            <tr>
                <th  width='50px' style='background-color: #d9edf7'>Código</th>
                <th  width='100px' style='background-color: #d9edf7'>Incidencia</th>
                <th  width='250px' style='background-color: #d9edf7'>Detalle</th>
                <th  width='250px' style='background-color: #d9edf7'>Observacion</th>
                <th style='text-align:center;background-color: #d9edf7' width='100px' >Acción</th>
            </tr>
        </thead>
        <tbody>
            {section name=cont loop=$listVueloIncidencias}
                <tr>
                    <td>{$listVueloIncidencias[cont]['codigo']}</td>
                    <td>{$listVueloIncidencias[cont]['Descripcion']}</td>
                    <td>{$listVueloIncidencias[cont]['detalle']}</td>
                    <td>{$listVueloIncidencias[cont]['observacion']}</td>
                    <td align='center'>
                        {if $view_component eq 1 && $permiso_inc[0]["Eliminar"] eq 1}
                        <a href="#" class='deleteVueloIncidencias' id='VueoIncidencias' 
                            data-id='{$listVueloIncidencias[cont]['id_vuelo_incidencias']}' 
                            data-id-vuelo-detalle='{$listVueloIncidencias[cont]['id_vuelo_detalle']}'
                            >
                            <img src="{$SERVER_PUBLIC}img/delete_cicle.png"width='20px' />
                        </a>
                        {/if}
                    </td>
                </tr>
            {/section}    
        </tbody>
    </table>
{/if} 