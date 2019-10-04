{include file="inc/data_vuelo_cabecera.tpl"}
<input type="hidden" id="id_vuelo_detalle" value="{$id_vuelo_detalle}">

<div class="panel panel-info " style="margin-top: 20px;">
    <div class="panel-heading" style="padding-bottom: 5px !important; padding-top: 5px!important;text-align: center"><b>Ingreso de Combustible (Tipo Ingreso : kilos )</b></div>
    <div id="content_combustible" class="panel-body">
        <div class="col-md-10 col-md-offset-1 ">
            <div  class="row" >
                <form class="form-horizontal" role="form">
                    <div class="col-xs-12 col-sm-4">
                        <label class="control-label">Rmnte Fuel kgs</label>
                        <div class="form-group">
                            <label class="control-label col-xs-2">Kgs:</label>
                            <div class="col-xs-12 col-sm-6">
                               <input type="text" class="form-control input-sm " id="txtBAGPZS" value="" maxlength="4" >
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-4">
                        <label class="control-label">Recarg Fuel Gal</label>
                        <div class="form-group" >
                            <label class="control-label col-xs-2">GAL</label>
                            <div class="col-xs-12 col-sm-6">
                               <input type="text" class="form-control input-sm " id="txtBAGPZS" value="" maxlength="4" >
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-xs-2"></label>
                            <div class="col-xs-12 col-sm-6">
                               <input type="text" class="form-control input-sm " id="txtBAGPZS" value="" maxlength="4" >
                            </div>
                        </div>
                        <div class="form-group" >
                            <label class="control-label col-xs-2"></label>
                            <div class="col-xs-12 col-sm-6">
                               <input type="text" class="form-control input-sm " id="txtBAGPZS" value="" maxlength="4" >
                            </div>
                        </div>
                        <div class="form-group" >
                            <label class="control-label col-xs-2">Total</label>
                            <div class="col-xs-12 col-sm-6">
                               <input type="text" class="form-control input-sm " id="txtBAGPZS" value="" maxlength="4" >
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-4">
                        <label class="control-label">nro Entrega Exxon Movi</label>
                        <div class="form-group" >
                            <label class="control-label col-xs-1">1.</label>
                            <div class="col-xs-12 col-sm-6">
                               <input type="text" class="form-control input-sm " id="txtBAGPZS" value="" maxlength="4" >
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-xs-1">2.</label>
                            <div class="col-xs-12 col-sm-6">
                               <input type="text" class="form-control input-sm " id="txtBAGPZS" value="" maxlength="4" >
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-xs-1">3.</label>
                            <div class="col-xs-12 col-sm-6">
                               <input type="text" class="form-control input-sm " id="txtBAGPZS" value="" maxlength="4" >
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>   
        <hr>
        <div class="col-md-7 col-md-offset-3 text-center">
            <div class="row">

                <div class="col-xs-12 col-sm-3">
                    <label class="control-label">Total</label>
                    <input type="text" class="form-control input-sm " id="txtBAGPZS" value="" maxlength="4" >
                </div>
                <div class="col-xs-12 col-sm-3">
                    <label class="control-label">Sala</label>
                    <input type="text" class="form-control input-sm " id="txtBAGPZS" value="" maxlength="4" >
                </div>
                <div class="col-xs-12 col-sm-3">
                    <label class="control-label text-danger">Nivel de Vuelo</span></label>
                    <input type="text" class="form-control input-sm " id="txtBAGPZS" value="" maxlength="4" >
                </div>
            </div>
        </div>    
    </div>
</div>
<div class="buttonrigth">
    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>     
    <button class="btn btn-success" id="btnSavePasajero">Guardar</button>
</div>


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
