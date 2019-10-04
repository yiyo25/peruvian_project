{include file="inc/data_vuelo_cabecera.tpl"}
        
<div class="panel panel-danger panel-margin">
  <div class="panel-heading" style="padding-bottom: 5px !important; padding-top: 5px!important"><b>TT/TT</b></div>
  <div class="panel-body" style="padding-bottom: 5px;">
    {if $view_component eq 1}
    <form id="frm_vuelo" name="frm_vuelo" class="form-horizontal" >
        <input type="hidden" id="id_vuelo_cabecera" value="{$id_vuelo_cabecera}">
        <input type="hidden" id="id_funcion" value="0">
        
            <label class="control-label col-xs-12 col-sm-2 col-md-1" for="matricula">Nombre:</label>
            <div class="col-xs-12 col-sm-12 col-md-4">
                <select name="tripulacionCabina" id="tripulacionCabina" class="selector select2"  style="width: 80% !important;" required >
                    <option value="0">Seleccion un Tripulante</option>
                    {assign var="ca" value=0}
                    {section name=cont loop=$cbo_cabina}

                        <option value="{$cbo_cabina[$ca]['id_tripulacion']}" 
                                data-funcion="{$cbo_cabina[$ca]['id_funcion']}" 
                                data-idTipoTripulacion="{$cbo_cabina[$ca]['idTipoTripulacion']}">
                            {$cbo_cabina[$ca]['apellidos']} {$cbo_cabina[$ca]['nombres']}
                        </option>

                        {assign var="ca" value=$ca+1}

                        {if $cbo_cabina[$ca]['id_funcion']!=$cbo_cabina[$ca-1]['id_funcion']}
                            <option></option>
                        {/if}

                    {/section}
                </select>
            </div>

            <label class="control-label col-xs-12 col-sm-2 col-md-1" for="funcion_tt">Función:</label>
            <div id="cbo_functionCabina" class=" col-xs-12 col-sm-12 col-md-3">
                <select name="funcion_tt" id="funcion_tt" class="selector select2" disabled>
                    <option value="0">Selecione una función</option>  
                </select>
            </div> 
            {if $permiso_tri[0]["Agregar"] eq 1}
            <div class="col-xs-12 col-sm-12 col-md-2">
                <button type="button" class="btn btn-info btn-agregar-tripulacion" id="btngenerarTripcabina" tipo_tripulacion="cabina"><i class="fa fa-plus"></i> Agregar</button>
            </div>
            {/if}
        
    </form>
    {/if}
    <br>
    <div class="col-xs-12 col-sm-8" style="margin-top: 5px;">
        <div id="table_tripulacion-cabina" class="table-responsive" >
            
            {if $list_tripulacion_cabina|@count gt 0}
                
                <table class="table table-striped table-hover table-bordered" style="font-size: 12px;margin-bottom: 0px;">
                    <thead>
                        <tr>
                            <th  width='350px' >Nombre</th>
                            <th  width='150px' >Función</th>
                            <th class='text-center' width='100px'>Instructo</th>
                            <th class='text-center' width='100px' >Acción</th>
                        </tr>
                    </thead>
                    <tbody style="font-size: 10px; color: #566787;">
                        {section name=cont loop=$list_tripulacion_cabina}
                            <tr >
                                <td>{$list_tripulacion_cabina[cont]['nombres']}</td>
                                <td>{$list_tripulacion_cabina[cont]['descripcion_funcion']}</td>
                                <td align='center'>
                                    {if $view_component eq 1}
                                    {if $statusInstructor eq 0}
                                        <input type='checkbox' 
                                           name='chk_insctructor' 
                                           class='chkInstructor'
                                           data-id-vt="{$list_tripulacion_cabina[cont]['id_vuelo_tripulacion']}"
                                           data-nombre='{$list_tripulacion_cabina[cont]['nombres']}'
                                           data-id-vuelo-cabecera='{$list_tripulacion_cabina[cont]['id_vuelo_cabecera']}'
                                           ></td>
                                    {else}
                                        {if $list_tripulacion_cabina[cont]['estado_instructor'] eq 1}
                                        
                                            <font color='red'>Instructor</font>
                                        {/if}
                                    {/if}
                                   {/if}
                                <td align='center'>
                                    {if $view_component eq 1 && $permiso_tri[0]["Eliminar"] eq 1}
                                    <a href="#" class='deleteTripulacion' id='tripulacion' 
                                        data-id='{$list_tripulacion_cabina[cont]['id_vuelo_tripulacion']}' 
                                        data-tipoTripulacion='{$list_tripulacion_cabina[cont]['tipo_tripulacion']}'
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
            
        </div>
    </div>
    
  </div>
</div>


<div class="panel panel-danger panel-margin">
  <div class="panel-heading" style="padding-bottom: 5px !important; padding-top: 5px!important"><b>TT/AA</b></div>
  <div class="panel-body" style="padding-bottom: 5px;">
    {if $view_component eq 1}
    <form id="frm_vuelo" name="frm_vuelo" class="form-horizontal" >
        <input type="hidden" id="id_vuelo_cabecera" value="{$id_vuelo_cabecera}">

        <label class="control-label col-xs-12 col-sm-2 col-md-1" for="nombre_tp_servicio">Nombre:</label>
        <div class="col-xs-12 col-sm-12 col-md-4">
            <select name="nombre_tp_servicio" id="tp_servicio" class="selector select2"  style="width: 80% !important" required>
                <option value="0">Seleccion un Tripulante</option>
                {assign var="a" value=0}
                {section name=cont loop=$cbo_servicios}
                    <option value="{$cbo_servicios[$a]['id_tripulacion']}">{$cbo_servicios[$a]['apellidos']} {$cbo_servicios[$a]['nombres']}</option>
                    {assign var="a" value=$a+1}
                    {if $cbo_servicios[$a]['id_funcion']!=$cbo_servicios[$a-1]['id_funcion']}
                        <option></option>
                    {/if}
                {/section}
            </select>
        </div>

        <label class="control-label col-xs-12 col-sm-2 col-md-1" for="function_aa">Función:</label>
        <div class="col-xs-12 col-sm-12 col-md-3">
            <select name="function_serv" id="function_serv" class="selector select2" required>
                <option value="0">Seleccion una función</option>
                {section name=tc loop=$list_funciones}
                    <option value="{$list_funciones[tc]["TRIPFUN_id"]}">{$list_funciones[tc]["TRIPFUN_descripcion"]}</option>
                {/section}
            </select>
        </div>
        {if $permiso_tri[0]["Agregar"] eq 1}
        <div class="col-xs-12 col-sm-12 col-md-2">
            <button type="button" class="btn btn-info btn-agregar-tripulacion" id="btngenerarTriServicio" tipo_tripulacion="servicio"><i class="fa fa-plus"></i> Agregar</button>
        </div> 
        {/if}
    </form> 
    {/if}
    <br>
    <div class="col-xs-12 col-sm-8" style="margin-top: 5px;">
        <div id="table_tripulacion_servicio" class="table-responsive">
            {if $list_tripulacion_servicio|@count gt 0}
                <table class="table table-striped table-hover table-bordered" style="font-size: 12px; margin-bottom: 0px;" >
                    <thead>
                        <tr>
                            <th  width='350px' >Nombre</th>
                            <th  width='150px' >Función</th>
                            <th class='text-center' width='100px' >Acción</th>
                        </tr>
                    </thead>
                    <tbody style="font-size: 10px; color: #566787;">
                        {section name=cont loop=$list_tripulacion_servicio}
                            <tr>
                                <td>{$list_tripulacion_servicio[cont]['nombres']}</td>
                                <td>{$list_tripulacion_servicio[cont]['descripcion_funcion']}</td>
                                <td align='center'>
                                    {if $view_component eq 1 && $permiso_tri[0]["Eliminar"] eq 1}
                                    <a href="#" class='deleteTripulacion' id='tripulacion' 
                                        data-id='{$list_tripulacion_servicio[cont]['id_vuelo_tripulacion']}' 
                                        data-tipoTripulacion='{$list_tripulacion_servicio[cont]['tipo_tripulacion']}'
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
        </div>
    </div>
  </div>
</div>

<div class="panel panel-danger panel-margin">
  <div class="panel-heading" style="padding-bottom: 5px !important; padding-top: 5px!important"><b>TT/TT Practicante</b> (Tripulacion Extras)</div>
  <div class="panel-body" style="padding-bottom: 5px;">
      
    {if $view_component eq 1}
    <form id="frm_vuelo" name="frm_vuelo" class="form-horizontal" >

        <label class="control-label col-xs-12 col-sm-2 col-md-1" for="nombre_ttpp">Nombre:</label>
        <div class="col-xs-12 col-sm-12 col-md-4">
            <select name="nombre_ttpp" id="tripulacion_pp" class="selector select2"  style="width: 80% !important;" required>
                <option value="0">Seleccion un tripulante</option>
                {section name=cont loop=$cbo_practicante}
                    <option value="{$cbo_practicante[cont]['id_tripulacion']}">{$cbo_practicante[cont]['apellidos']} {$cbo_practicante[cont]['nombres']}</option>
                {/section}
            </select>
        </div>

        <label class="control-label col-sm-1" for="funccion_tt_pp">Función:</label>
        <div class="col-xs-12 col-sm-12 col-md-3">
            <select name="funccion_tt_pp" id="funccion_tt_pp" class="selector select2" required>
                <option value="0">Seleccion una función</option>
                <option value="18">Practicante</option>
            </select>
        </div>
        {if $permiso_tri[0]["Agregar"] eq 1}
        <div class="col-xs-12 col-sm-12 col-md-2">
            <button type="button" class="btn btn-info btn-agregar-tripulacion" id="btngenerarPract" tipo_tripulacion="practicante"><i class="fa fa-plus"></i> Agregar</button>
        </div>  
        {/if}
    </form> 
     {/if}
    <div class="col-xs-12 col-sm-8" style="margin-top: 5px;">
        <div id="table_tripulacion_practicante" class="table-responsive">
            {if $list_tripulacion_practicante|@count gt 0}
                <table  class="table table-striped table-hover table-bordered" style="font-size: 12px;margin-bottom: 0px;">
                    <thead>
                        <tr>
                            <th  width='350px' >Nombre</th>
                            <th  width='150px' >Función</th>
                            <th class='text-center' width='100px' >Acción</th>
                        </tr>
                    </thead>
                    <tbody style="font-size: 10px; color: #566787;">
                        {section name=cont loop=$list_tripulacion_practicante}
                            <tr>
                                <td>{$list_tripulacion_practicante[cont]['nombres']}</td>
                                <td>{$list_tripulacion_practicante[cont]['descripcion_funcion']}</td>
                                <td align='center'>
                                    {if $view_component eq 1 && $permiso_tri[0]["Eliminar"] eq 1}
                                    <a href="#" class='deleteTripulacion' id='tripulacion' 
                                        data-id='{$list_tripulacion_practicante[cont]['id_vuelo_tripulacion']}' 
                                        data-tipoTripulacion='{$list_tripulacion_practicante[cont]['tipo_tripulacion']}'
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
        </div>
    </div>
  </div>
</div>

<style>
/*table {
    color: #566787;
    background: #f5f5f5;
    font-family: 'Varela Round', sans-serif;
    font-size: 10px;
}*/
.panel-margin{
    margin-bottom: 5px !important;
}
.btn-info {
    color: #fff;
    background-color: #5bc0de;
    border-color: #46b8da;
}

</style>


