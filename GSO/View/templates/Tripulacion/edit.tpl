<div class="row">  
    <div class="col-md-10 col-md-offset-2 col-sm-10 col-sm-offset-2">  
        <form id="tripulacion-form" class="form-horizontal" >
            <input type="hidden" name="id_tripulante" id="id_tripulante" value="{$id_tripulante}">
            <input type="hidden" id="tipo_funcion" value="{$tipo_funcion}">
            <div class="form-group">
              <label for="funcion" class="col-xs-12 col-xs-3 col-md-3 control-label">Función:</label>
              <div class="col-xs-12 col-sm-6 col-md-6">
                    <select id="funcion" class="select2" >
                        <option value="0">Seleccione una función</option>
                        {section  name=trif loop=$list_tripfuncion}
                          <option value="{$list_tripfuncion[trif]["TRIPFUN_id"]}" {if $list_tripfuncion[trif]["TRIPFUN_id"] eq $id_funcion}selected{/if}>{$list_tripfuncion[trif]["TRIPFUN_descripcion"]}</option>
                        {/section}    
                    </select>
              </div>
            </div>
            <div class="form-group">
              <label for="licencia" class="col-xs-12 col-xs-3 col-md-3 control-label">Licencia:</label>
              <div class="col-xs-12 col-sm-6 col-md-6">
                  <input type="text" class="form-control input-sm" id="licencia" placeholder="Licencia" value="{$licencia}">
              </div>
            </div>
            <div class="form-group">
              <label for="num_documento" class="col-xs-12 col-xs-3 col-md-3 control-label">Documento:</label>
              <div class="col-xs-12 col-sm-6 col-md-6">
                <input type="text" class="form-control input-sm" id="num_documento" placeholder="DNI" value="{$num_doc}">
              </div>
            </div>
            <div class="form-group">
              <label for="nombre" class="col-xs-12 col-xs-3 col-md-3 control-label">Nombres:</label>
              <div class="col-xs-12 col-sm-6 col-md-6">
                  <input type="text" class="form-control input-sm" name="nombre" id="nombre" placeholder="Nombres" value="{$nombre}">
              </div>
            </div>
            <div class="form-group">
              <label for="apellidos" class="col-xs-12 col-xs-3 col-md-3 control-label">Apellidois:</label>
              <div class="col-xs-12 col-sm-6 col-md-6">
                  <input type="text" class="form-control input-sm" name="apellidos" id="apellidos" placeholder="Apellidos" value="{$apellido}">
              </div>
            </div>
            {*<div class="form-group">
              <label for="nombre_cco" class="col-xs-12 col-xs-3 col-md-3 control-label">Nombre CCO:</label>
              <div class="col-xs-12 col-sm-6 col-md-6">
                <input type="text" class="form-control input-sm" id="nombre_cco" placeholder="nombre cco">
              </div>
            </div>*}
            <div class="form-group">
              <label for="telefono" class="col-xs-12 col-xs-3 col-md-3 control-label">Telefono:</label>
              <div class="col-xs-12 col-sm-6 col-md-6">
                  <input type="text" class="form-control input-sm" id="telefono" placeholder="telegono" value="{$telefono}">
              </div>
            </div>
            <div class="form-group">
              <label for="phone" class="col-xs-12 col-xs-3 col-md-3 control-label">Celular:</label>
              <div class="col-xs-12 col-sm-6 col-md-6">
                  <input type="text" class="form-control input-sm" id="phone" placeholder="celular" value="{$celular}">
              </div>
            </div>
            <div class="form-group">
              <label for="email" class="col-xs-12 col-xs-3 col-md-3 control-label">Email:</label>
              <div class="col-xs-12 col-sm-6 col-md-6">
                  <input type="email" class="form-control input-sm" id="email" placeholder="email" value="{$email}">
              </div>
            </div>
            <div class="form-group">
                <div class="col-lg-offset-2 col-lg-10">
                    <div class="buttonrigth">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>   
                        <button type="submit" class="btn btn-success" id="btnSaveIncidencia">Actualizar</button>
                    </div>
                </div>
            </div>
        </form> 
    </div>  
</div>
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