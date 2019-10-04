{include file="inc/data_vuelo_cabecera.tpl"}
<input type="hidden" id="id_vuelo_detalle" value="{$id_vuelo_detalle}">

<form id="frm_vuelo_pasajero">
<div class="panel panel-danger " style="margin-top: 20px;">
    <div class="panel-heading" style="padding-bottom: 5px !important; padding-top: 5px!important;text-align: center"><b>Pasajeros</b></div>
    <div id="panelBody" class="panel-body">
        <div class="col-md-11 col-md-offset-1 text-center">
            <div class="row">
                <div class="col-xs-12 col-sm-2 ">
                    <label class="control-label">Adulto</label>
                    <input type="text" class="form-control input-sm " id="txt_nro_adulto" value="{$nro_adulto}" maxlength="4" onBlur="sumarPasajeros();" {$txtReadonly}>
                </div>
                <div class="col-xs-12 col-sm-2 ">
                    <label class="control-label">Menores</label>

                    <input type="text" class="form-control input-sm" id="txt_nro_menores" value="{$nro_menores}" maxlength="4" onBlur="sumarPasajeros();" {$txtReadonly}>
                </div>
                <div class="col-xs-12 col-sm-2 ">
                    <label class="control-label">Infantes</label>
                    <input type="text" class="form-control input-sm" id="txt_nro_infantes" value="{$nro_infantes}" maxlength="4" onBlur="sumarPasajeros();" {$txtReadonly}>
                </div>
                <div class="col-xs-12 col-sm-2 ">
                    <label class="control-label">NR</label>
                    <input type="text" class="form-control input-sm" id="txt_nro_nr" value="{$nro_nr}" maxlength="4" onBlur="sumarPasajeros();" {$txtReadonly}>
                </div>
                <div class="col-xs-12 col-sm-2 ">
                    <label class="control-label">T.Pax</label>
                    <input type="text" class="form-control input-sm" id="txt_total" value="{$total}" maxlength="4" disabled="disabled" style="text-align: center;" onBlur="sumarPasajeros();" {$txtReadonly}>
                </div>
                <div class="col-xs-12 col-sm-2" style="display:none;"> 
                    <label class="control-label">Clase J</label>
                    <input type="text" class="form-control input-sm" id="txt_clase_j" value="0" maxlength="4" disabled="disabled" style="text-align: center;" onBlur="sumarPasajeros();" {$txtReadonly}>
                    <label class="control-label">Clase Y</label>
                    <input type="text" class="form-control input-sm" id="txt_clase_y" value="{$clase_y}" maxlength="4" disabled="disabled" style="text-align: center;" onBlur="sumarPasajeros();" {$txtReadonly}>
                </div>
            </div>
        </div>
    </div>
</div>
</form>
   

{if $view_component eq 1 && $permiso_pax[0]["Agregar"] eq 1}
    <div class="buttonrigth">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>   
        <button class="btn btn-success" id="btnSavePasajero">Guardar</button>
    </div>
{/if}

<style>
.panel-margin{
    margin-bottom: 5px !important;
}
.buttonrigth{
    text-align: right;
    padding: 15px;
}

.error-input{
    border-color: #d51f1f !important;
}

.success-input{
    border-color: #d2d6de !important;
}


</style>