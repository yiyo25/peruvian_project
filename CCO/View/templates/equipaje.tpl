{include file="inc/data_vuelo_cabecera.tpl"}
<input type="hidden" id="id_vuelo_detalle" value="{$id_vuelo_detalle}">
<div class="panel panel-default " style="margin-top: 20px;">
    <div class="panel-body">
        <form id="frm_equipaje">
            <div class="col-sm-6">
                <div class="panel panel-info " style="margin-top: 20px;">
                    <div class="panel-heading" style="padding-bottom: 5px !important; padding-top: 5px!important;text-align: center"><b>Equipaje</b></div>
                    <div class="panel-body">
                        <div class="col-md-10 col-md-offset-1 text-center">
                            <div class="row">
                                <div class="col-xs-12 col-sm-4 col-md-4">
                                    <label class="control-label">PZS</label>
                                    <input type="text" class="form-control input-sm " id="txtBAGPZS" value="{$txt_BAGPZS}" maxlength="9" {$txtReadonly}>
                                </div>
                                <div class="col-xs-12 col-sm-4 col-md-4">
                                    <label class="control-label">KGS</label>

                                    <input type="text" class="form-control input-sm" id="txtBAGKGS" value="{$txt_BAGKGS}" maxlength="9" {$txtReadonly}>
                                </div>
                                <div class="col-xs-12 col-sm-4 col-md-4">
                                    <label class="control-label">BIN</label>
                                    <input type="text" class="form-control input-sm" id="txtBAGBIN" value="{$txt_BAGBIN}" maxlength="9" {$txtReadonly}>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6">
                <div class="panel panel-info " style="margin-top: 20px; ">
                    <div class="panel-heading" style="padding-bottom: 5px !important; padding-top: 5px!important;text-align: center"><b>Carga</b></div>
                    <div class="panel-body">
                        <div class="col-md-10 col-md-offset-1 text-center">
                            <div  class="row">
                                <div class="col-xs-12 col-sm-4 col-md-4">
                                    <label class="control-label">PZS</label>
                                    <input type="text" class="form-control input-sm " id="txtCARPZS" value="{$txt_CARPZS}" maxlength="9" {$txtReadonly}>
                                </div>
                                <div class="col-xs-12 col-sm-4 col-md-4">
                                    <label class="control-label">KGS</label>

                                    <input type="text" class="form-control input-sm" id="txtCARKGS" value="{$txt_CARKGS}" maxlength="9" {$txtReadonly}>
                                </div>
                                <div class="col-xs-12 col-sm-4 col-md-4">
                                    <label class="control-label">BIN</label>
                                    <input type="text" class="form-control input-sm" id="txtCARBIN" value="{$txt_CARBIN}" maxlength="9" {$txtReadonly}>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
           </div>  
        </form>
    </div>                   
</div>
                                    
{if $view_component eq 1 && $permiso_equi[0]["Agregar"] eq 1}
    <div class="buttonrigth">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>   
        <button class="btn btn-success" id="btnSaveEquipaje">Guardar</button>
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
