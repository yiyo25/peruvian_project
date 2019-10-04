{include file="inc/data_vuelo_cabecera.tpl"}
<input type="hidden" id="horas_block_flag" value="{$flag_horas_block}">
<input type="hidden" id="id_vuelo_detalle" value="{$id_vuelo_detalle}">

<form id="frm_hora_vuelo">
<div class="panel panel-info " style="margin-top: 20px;">
    <div class="panel-heading" style="padding-bottom: 5px !important; padding-top: 5px!important"><b>Hora de salida</b></div>
    <div class="panel-body">
        <div class="col-md-12 col-md-offset-0 text-center">
            <div class="row">
                <div class="col-xs-12 col-sm-2 col-md-2">
                    <label class="control-label">C/P ITIN</label>
                    <input type="text" class="form-control input-sm " id="txt_ci_pu_iti" value="{$hora_cierre_puerta_iti}" maxlength="4" {$txtReadonly}>
                </div>
                <div class="col-xs-12 col-sm-2 col-md-2">
                    <label class="control-label">C/P</label>

                    <input type="text" class="form-control input-sm" id="txt_ci_pu" value="{$hora_cierra_puerta}" maxlength="4" {$txtReadonly}>
                </div>
                <div class="col-xs-12 col-sm-2 col-md-2">
                    <label class="control-label">P/B</label>
                    <input type="text" class="form-control input-sm" id="txt_pu_pb" value="{$puerta_PB}" maxlength="4" {$txtReadonly}>
                </div>
                <div class="col-xs-12 col-sm-2 col-md-2">
                    <label class="control-label">ENG ON</label>
                    <input type="text" class="form-control input-sm" id="txt_eng_on" value="{$ENG_ON}" maxlength="4" {$txtReadonly}>
                </div>
                <div class="col-xs-12 col-sm-2 col-md-2">
                    <label class="control-label">Take off</label>
                    <input type="text" class="form-control input-sm" id="txt_take_off" value="{$TAKE_OFF}" maxlength="4" {$txtReadonly}>
                </div>
                <div class="col-xs-12 col-sm-2 col-md-2">
                    <label class="control-label">ETA</label>
                    <input type="text" class="form-control input-sm" id="txt_eta" value="{$ETA}" maxlength="4" {$txtReadonly}>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="panel panel-danger ">
    <div class="panel-heading" style="padding-bottom: 5px !important; padding-top: 5px!important"><b>Hora de llegada</b></div>
    <div class="panel-body">
        <div class="col-md-12 col-md-offset-0 text-center">
            <div class="row" >
                <div class="col-xs-12 col-sm-2 col-md-2">
                    <label class="control-label">Arr-in</label>
                    <input type="text" class="form-control input-sm" id="txt_arr_in" value="{$HoraAirr}" maxlength="4" onblur="calculaTiempoVuelo();" {$txtReadonly}>
                </div>
                <div class="col-xs-12 col-sm-2 col-md-2">
                    <label class="control-label">STOP</label>

                    <input type="text" class="form-control input-sm"  id="txt_stop" value="{$Stop}" maxlength="4" {$txtReadonly}>
                </div>
                <div class="col-xs-12 col-sm-2 col-md-2">
                    <label class="control-label">A/P</label>
                    <input type="text" class="form-control input-sm" id="txt_AP" value="{$apertura_puerta}" maxlength="4" {$txtReadonly}>
                </div>
                <div class="col-xs-12 col-sm-2 col-md-2">
                    <label class="control-label">T. Vuelo</label>
                    <input type="text" class="form-control input-sm" id="txt_tiempoVuelo" value="{$TiempoVuelo}" maxlength="4" readonly >
                </div>
                <div class="col-xs-12 col-sm-2 col-md-2" >
                    <label class="control-label">H. Block</label>
                    <input type="text" class="form-control input-sm" id="horas_block"  value="{$HorasBlock}" maxlength="4" readonly style="text-align: center;" {$txtReadonly}>
                </div>
                <div class="col-xs-12 col-sm-2 col-md-2" {if $flag_horas_block eq 0} style="display:none;"{/if}>
                    <label class="control-label">H. Block</label>
                    <input type="text" class="form-control input-sm" id="txt_TiempoHorasBlock" value="{$HorasBlock_m}" maxlength="4"  style="text-align: center;" {$txtReadonly}>
                </div>
            </div>
        </div>
    </div>
</div>
</form>
{if $view_component eq 1 && $permiso_hora[0]["Agregar"] eq 1}
<div class="buttonrigth">
    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>   
    <button class="btn btn-success" id="btnSaveHora">Guardar</button>
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