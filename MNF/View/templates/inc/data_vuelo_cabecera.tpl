
        
<div class="panel panel-default panel-margin">
    <div class="panel-body">
        <div class="row" style='margin-bottom: 5px;'>
            <div class="col-sm-3" style="">
                <label class="control-label col-sm-4" for="fecha" style="">Fecha:</label>
                <input type="text" class="form-control" id="fecha" value="{$fecha}" disabled>
            </div>
            <div class="col-sm-3" style="">
                <label class="control-label " for="ruta" style="">Nro Vuelo:</label>
                <input type="text" class="form-control" name='nro_vuelo' id="nro_vuelo" value="{$nro_vuelo}" disabled>
            </div>
            <div class="col-sm-3" style="">
                <label class="control-label col-sm-5" for="ruta" style="">Matrícula:</label>
                <input type="text" class="form-control" name="matricula" id="matricula"  value="{$matricula}" disabled>
            </div>
            <div class=" col-xs-12 col-sm-3 col-md-3" style="">
                <label class="control-label"  for="ruta" style="">Ruta:</label>
                <input type="text" class="form-control" name="ruta" id="ruta" value="{$ruta}" disabled>
                {*<div id="txt_ruta" class="row">
                    <div class="col-xs-12 col-sm-3 col-md-8">
                       <input type="text" class="form-control" name="ruta" id="ruta" value="{$ruta}" disabled>
                    </div>
                     
                    {if $edit_ruta eq 1}
                    <a id="edit_new_ruta" class="btn btn-info " style="font-size:15px"> <i class="fa fa-edit"></i></a>
                    {/if}
                    
                </div>*}

            </div>
            
            
                {*{if $edit_ruta eq 1}
                    <div id="edit_ruta" class=" col-xs-12 col-sm-3 col-md-4" style="">
                        <div id="new_ruta" class="row" style="display: none">
                            <div class="col-xs-10 col-sm-10">
                                {if $listCiudad|@count gt 0}
                                <div class="row" >
                                     <div class="col-xs-5 col-sm-6 ">
                                        <select id='ciudad_ida' class="select2">
                                            {section name=ciu loop=$listCiudad}
                                                <option value="$listCiudad">{$listCiudad[ciu]['CIU_id']}</option>
                                            {/section}
                                        </select>
                                     </div>
                                     <div class="col-xs-5 col-sm-6">
                                         <select id='ciudad_vuelta' class="select2">
                                            {section name=ciu loop=$listCiudad}
                                                <option value="$listCiudad">{$listCiudad[ciu]['CIU_id']}</option>
                                            {/section}
                                         </select>
                                     </div>
                                 </div>
                                {/if}
                            </div>
                            <div class="col-xs-10 col-sm-2">
                                <a id="save_edit_ruta" class="btn btn-info " style="font-size:15px"> <i class="fa fa-save"></i></a>
                            </div>

                        </div>
                    </div>
                {/if}*}
            
        </div>
        {*{if $edit_ruta eq 0}  
        <div class="row">
            <div class="col-lg-offset-0 col-lg-10">
                <div class="checkbox col-sm-8">
                    <label class="col-sm-4">
                      <input type="checkbox"> Asignar TT (TT/AA) 
                    </label>
                    <div class="col-xs-12 col-sm-8" style="padding-left: 5px; display: none">
                      <label class="col-xs-4 col-sm-5" for="ruta" style="padding-left: 5px;padding-right: 5px;margin-top: 5px;">Nro Vuelo:</label>
                      <div class="col-xs-5 col-sm-4">
                          <select id='ciudad_vuelta' class="select2">
                                
                                <option value="">215</option>
                                <option value="">225</option>
                                <option value="">230</option>
                                <option value="">212</option>
                                
                           </select>
                      </div>  
                      <a id="save_edit_ruta" class="btn btn-info " style="font-size:15px"> <i class="fa fa-save"></i></a>
                    </div>  
                </div>
                
                
            </div>
            
        </div>
        {/if}*}
    </div>
</div>