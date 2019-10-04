<div class="row">  
    <div class="col-md-10 col-md-offset-2 col-sm-10 col-sm-offset-2">     
    
        <form id="tripulacion-form" class="form-horizontal" >
            
            <div class="form-group">
              <label for="funcion" class="col-xs-12 col-xs-3 col-md-3 control-label">Función:</label>
              <div class="col-xs-12 col-sm-6 col-md-6">
                    <select id="funcion" class="select2" >
                        <option value="0">Seleccione una función</option>
                        {section  name=trif loop=$list_tripfuncion}
                          <option value="{$list_tripfuncion[trif]["TRIPFUN_id"]}">{$list_tripfuncion[trif]["TRIPFUN_descripcion"]}</option>
                        {/section}    
                    </select>
              </div>
            </div>
            <div class="form-group">
                <label for="licencia" class="col-xs-12 col-xs-3 col-md-3 control-label">Licencia:</label>
                <div class="col-xs-12 col-sm-6 col-md-6">
                    <input type="text" class="form-control input-sm" name="licencia" id="licencia" placeholder="Licencia">
                </div>
            </div>
            <div class="form-group">
                <label for="num_documento" class="col-xs-12 col-xs-3 col-md-3 control-label">Documento:</label>
                <div class="col-xs-12 col-sm-6 col-md-6">
                  <input type="text" class="form-control input-sm" name="num_documento" minlength="8" maxlength="8" id="num_documento" placeholder="DNI" >
                </div>
            </div>
            <div class="form-group">
              <label for="nombre" class="col-xs-12 col-xs-3 col-md-3 control-label">Nombres:</label>
              <div class="col-xs-12 col-sm-6 col-md-6">
                  <input type="text" class="form-control input-sm" name="nombre" id="nombre" placeholder="Nombres">
              </div>
            </div>
            <div class="form-group">
              <label for="apellidos" class="col-xs-12 col-xs-3 col-md-3 control-label">Apellidois:</label>
              <div class="col-xs-12 col-sm-6 col-md-6">
                  <input type="text" class="form-control input-sm" name="apellidos" id="apellidos" placeholder="Apellidos" >
              </div>
            </div>
            
            <div class="form-group">
              <label for="telefono" class="col-xs-12 col-xs-3 col-md-3 control-label">Telefono:</label>
              <div class="col-xs-12 col-sm-6 col-md-6">
                  <input type="text" class="form-control input-sm" id="telefono" placeholder="telegono" >
              </div>
            </div>
            <div class="form-group">
              <label for="phone" class="col-xs-12 col-xs-3 col-md-3 control-label">Celular:</label>
              <div class="col-xs-12 col-sm-6 col-md-6">
                  <input type="text" class="form-control input-sm" id="phone" placeholder="celular" >
              </div>
            </div>
            <div class="form-group">
              <label for="email" class="col-xs-12 col-xs-3 col-md-3 control-label">Email:</label>
              <div class="col-xs-12 col-sm-6 col-md-6">
                  <input type="email" class="form-control input-sm" name="email" id="email" placeholder="email" >
              </div>
            </div>
            <div class="form-group">
                <div class="col-lg-offset-2 col-lg-10">
                    <div class="buttonrigth">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>   
                        <button type="submit" class="btn btn-success" id="btnSaveTripulacion">Guardar</button>
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