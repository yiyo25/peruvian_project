
<div class='box box-danger' id="el">
    <div class="box-body">
        <div id="MainContent_search" class="panel panel-default">
            <div class="panel-body">
                <div class="row">
                       
                    <form id="form_principal" class="form-horizontal" style="background-color:#FFF;padding:5px">
                        <div class="row">
                            <div class="col-xs-12 col-md-4 col-sm-4">
                                <div class="form-group">
                                    <label class="col-sm-12 col-md-3 control-label">Fecha:</label>
                                    <div class="col-sm-12 col-md-6">
                                        <input type="input" class="form-control input-sm" id="fecha" name="fecha_vuelo" value="{$fecha}" readonly>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-xs-12  col-md-4 col-sm-4">
                                <div class="form-group">
                                    <label class="col-sm-12 col-md-4 control-label">Nro. Vuelo:</label>
                                    <div class="col-sm-12 col-md-6">
                                        <input type="number" class="form-control input-sm" id="nro_vuelo" placeholder="Nro.">
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12  col-md-4 col-sm-4"> 
                                <div class="form-group">
                                    <label class="col-sm-12 col-md-3 control-label">Matricula:</label>
                                    <div class="col-sm-12 col-md-8">
                                        <select id="matricula" class="form-control input-sm select2" style="width:100%;">
                                            {section name=cont loop=$list_matriculas}
                                                <option value="{$list_matriculas[cont]["id"]}">{$list_matriculas[cont]["matricula"]}</option>
                                            {/section}
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>  
                                        
                        <div class="row">
                            <div class="col-xs-12 col-md-4 col-sm-4">
                                <div class="form-group">
                                    <label class="col-sm-12 col-md-3 control-label">Ruta:</label>
                                    <div class="col-sm-12 col-md-8">

                                        <select id="ruta"   class="select-multiple select2"  multiple="multiple" data-placeholder="Seleccione los ruta"  >
                                            {section name=cont loop=$list_ciudad}
                                                <option value="{$list_ciudad[cont]["CIU_id"]}">{$list_ciudad[cont]["CIU_id"]}</option>
                                            {/section}
                                        </select>

                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-xs-12  col-md-4 col-sm-4">
                                <div class="form-group">
                                    <label class="col-sm-12 col-md-4 control-label">T. Operación:</label>
                                    <div class="col-sm-12 col-md-8">
                                        <select id="tipo_op" class="form-control input-sm select2" >
                                            {section name=cont loop=$tipo_operacion}
                                                <option value="{$tipo_operacion[cont]["TIPVUE_id"]}">{$tipo_operacion[cont]["TIPVUE_descripcion"]}</option>
                                            {/section}
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12  col-md-4 col-sm-4"> 
                                <div class="form-group">
                                    <label class="col-sm-12 col-md-3 control-label">H. Inicio:</label>
                                    <div class="col-sm-12 col-md-6">
                                        <input type="time" class="form-control input-sm" id="hora_vuelo" placeholder="H. Inicio" >
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-xs-12  col-md-4 col-sm-3">
                                <div class="form-group">
                                    <label class="col-sm-12 col-md-3 control-label">Tipo:</label>
                                    <div class="col-sm-12 col-md-6">
                                        <select id="tipovuelo" class="form-control input-sm select2 " style="width:100%;">
                                            {section name=cont loop=$tipo_vuelo}
                                                <option value="{$tipo_vuelo[cont]["IdTipoVuelo"]}">{$tipo_vuelo[cont]["NomTipoVuelo"]}</option>
                                            {/section}
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-9 col-md-8" >
                                <div class="col-xs-12  col-md-3 col-sm-4">
                                    <div class="form-group">
                                        <div class="col-xs-12 col-sm-12 col-md-10" >
                                            <a href="{$SERVER_NAME}index" class="col-xs-12 btn btn-danger" >Cancelar</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-12  col-md-3 col-sm-4">
                                    <div class="form-group">
                                        <div class="col-xs-12 col-sm-12 col-md-10" >
                                            <button type="button" id="btngenerar" class=" col-xs-12 btn btn-info" >Generar</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-12  col-md-3 col-sm-4">
                                    <div class="form-group">
                                         <div class="col-xs-12 col-sm-12 col-md-10" >
                                            <button type="button" id="btn_save" class="col-xs-12 btn btn-success " >Guardar</button>
                                        </div>  
                                    </div>
                                </div> 
                            </div>
                        </div>                
                    </form>
                </div>
                                
                <div class="row">
                    <div id="table_resul">
                        
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>





