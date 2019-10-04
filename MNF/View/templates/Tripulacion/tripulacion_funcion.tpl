<select name="funcion_tt" id="funcion_tt" class="selector select2">
    {section name=cont loop=$list_funciones}
        {if $list_funciones[cont]['TRIPFUN_id']>=$id_funcion}
            <option value='{$list_funciones[cont]['TRIPFUN_id']}'>{$list_funciones[cont]['TRIPFUN_descripcion']}</option>
        {/if}
    {/section}
</select>