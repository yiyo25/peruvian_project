{include file="inc/data_vuelo_cabecera.tpl"}
<input type="hidden" id="id_vuelo_detalle" value="{$id_vuelo_detalle}">
 <div class="panel panel-danger " style="margin-top: 20px;">
      <div class="panel-heading" style="padding-bottom: 5px !important; padding-top: 5px!important;text-align: center"><b>Incidencia</b></div>
    <div class="panel-body">
        <form class="form-horizontal" role="form">
            <div class="form-group">

                <label class="control-label col-sm-2">Incidencia</label> 
                <div class="col-sm-6">
                    <select id="cbo_incidencia" class="form-control select2" {$txtReadonly}>
                        <option value="-1" enabled>Seleccion una Incidencia</option>
                        {section name=desc loop=$array_inci["datainc"]}
                            <option value="{$array_inci["datainc"][desc]->id_incidencia}" title="{$array_inci["datainc"][desc]->detalle_incidencia}">{$array_inci["datainc"][desc]->descripcion}</option>
                        {/section}
                    </select>
                </div>
            </div>
            <div class="form-group">

                <label class="control-label col-sm-2">Observaciones</label> 
                <div class="col-sm-6">
                    <textarea id="txt_observacion" class="form-control" rows="3" {$txtReadonly}></textarea>
                </div>
            </div>
            
            {if $view_component eq 1 && $permiso_inc[0]["Agregar"] eq 1}
            <div class="form-group">
                <div class="col-lg-offset-2 col-lg-10">
                    <div class="buttonrigth">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>   
                        <button class="btn btn-success" id="btnSaveIncidencia">Guardar</button>
                    </div>
                </div>
            </div>
            {/if}
        </form>
    </div>
</div>
<div id="table_incidencias">
    
</div>