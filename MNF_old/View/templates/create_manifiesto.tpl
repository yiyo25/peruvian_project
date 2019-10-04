<div class="row">  
    <div class="col-md-10 col-md-offset-2 col-sm-10 col-sm-offset-2">
    
        <form id="manifiesto-form" class="form-horizontal" >

            <div class="form-group">
              <label for="fecha_vuelo" class="col-xs-12 col-xs-3 col-md-3 control-label">Fecha Vuelo:</label>
              <div class="col-xs-12 col-sm-6 col-md-6">
                  <div class='input-group date' id='dateFechavuelo'>
                      <input type='text' class="form-control" id="fecha_vuelo" name="fecha_vuelo" value=""/>
                      <span class="input-group-addon">
                          <span class="glyphicon glyphicon-calendar"></span>
                      </span>
                  </div>
              </div>
            </div>
            <div class="form-group">
                <label for="nro_vuelo" class="col-xs-12 col-xs-3 col-md-3 control-label">Nro Vuelo:</label>
                <div class="col-xs-12 col-sm-6 col-md-6">
                    <input type="text" class="form-control input-sm" name="nro_vuelo" id="nro_vuelo" placeholder="Ejemplo 230">
                </div>
            </div>
            <div class="form-group">
                <label for="origen" class="col-xs-12 col-xs-3 col-md-3 control-label">Origen:</label>
                <div class="col-xs-12 col-sm-6 col-md-6">
                  <input type="text" class="form-control input-sm" name="origen" minlength="3" maxlength="4" id="origen_mani" placeholder="Ejemplo LIM" >
                </div>
            </div>
            <div class="form-group">
              <label for="hora_despegue" class="col-xs-12 col-xs-3 col-md-3 control-label">C/P Itin:</label>
              <div class="col-xs-12 col-sm-6 col-md-6">
                  <input type="text" class="form-control input-sm" name="hora_despegue" id="hora_despegue" placeholder="Ejemplo 0600">
              </div>
            </div>
            <div class="form-group">
              <label for="hora_cierra_despegue" class="col-xs-12 col-xs-3 col-md-3 control-label">C/P:</label>
              <div class="col-xs-12 col-sm-6 col-md-6">
                  <input type="text" class="form-control input-sm" name="hora_cierra_despegue" id="hora_cierra_despegue" placeholder="Ejemplo 0601">
              </div>
            </div>

            <div class="form-group">
              <label for="hora_llegada_destino" class="col-xs-12 col-xs-3 col-md-3 control-label">Arr - In:</label>
              <div class="col-xs-12 col-sm-6 col-md-6">
                  <input type="text" class="form-control input-sm" name="hora_llegada_destino" id="hora_llegada_destino"  placeholder="Ejemplo 0701">
              </div>
            </div>
            <div class="form-group">
              <label for="matricula_avion" class="col-xs-12 col-xs-3 col-md-3 control-label">Matricula:</label>
              <div class="col-xs-12 col-sm-6 col-md-6">
                  <input type="text" class="form-control input-sm" name="Matricula" id="matricula_avion" placeholder="Ejemplo OB2079" >
              </div>
            </div>

            <div class="form-group">
                <div class="col-lg-offset-2 col-lg-10">
                    <div class="buttonrigth">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                        {if $typeForm eq "create"}
                            <button type="button" class="btn btn-success" id="btnSaveManifiesto">Guardar</button>
                        {/if}
                        {if $typeForm eq "edit"}
                            <button type="button" class="btn btn-success" id="btnEditManifiesto">Actualizar</button>
                        {/if}

                    </div>
                </div>
            </div>
        </form> 
    </div>  
</div>
<div id="alert"></div>
<style>

.buttonrigth{
    text-align: right;
    padding: 15px;
}
label.error{
    color: red;
    font-size: 12px;
}


</style>
