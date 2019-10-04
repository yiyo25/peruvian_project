
<div class='box box-danger' id="el">
    <input type="hidden" id="flag" value="{$flag}">

    <div class="box-body">
        <div id="MainContent_search" class="panel panel-default">
            <div class="panel-body">
                <div class="row">
                    <form class="form-horizontal" method="GET" action="" style="background-color:#FFF;padding:5px">
                        <div class="row">
                            <div class="col-xs-12 col-sm-4 col-md-3" style="padding-top: 10px;">
                                <div class="form-group">
                                    <label for="search" class="control-label col-xs-12 col-sm-12 col-md-4" style="padding-top: 8px !important;">Fecha Ini:</label>
                                    <div class="col-xs-12 col-sm-12 col-md-8">
                                        <div class='input-group date' id='datetimepickerini'>
                                            <input type='text' class="form-control" id="fecha_ini" name="fecha" value="{$fecha_ini}"/>
                                            <span class="input-group-addon">
                                                <span class="glyphicon glyphicon-calendar"></span>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-4 col-md-3" style="padding-top: 10px;">
                                <div class="form-group">
                                    <label for="search" class="control-label col-xs-12 col-sm-12 col-md-4" style="padding-top: 8px !important;">Fecha Fin:</label>
                                    <div class="col-xs-12 col-sm-12 col-md-8">
                                        <div class='input-group date' id='datetimepickerfin'>
                                            <input type='text' class="form-control" id="fecha_fin" name="fecha" value="{$fecha_fin}"/>
                                            <span class="input-group-addon">
                                                <span class="glyphicon glyphicon-calendar"></span>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-4 col-md-3" style="padding-top: 10px;">
                                <div class="form-group">
                                    <label for="search" class="control-label col-xs-12 col-sm-12 col-md-6" style="padding-top: 8px !important;">Origen:</label>
                                    <div class="col-xs-12 col-sm-12 col-md-6">
                                        <input type='text' class="form-control" id="origen" name="origen" value="{$origen}" maxlength="3" placeholder="Origen"/>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-4 col-md-2" style="padding-top: 10px;" style="float: left !important;">
                                <button type="button" id="btn-buscar-pasajeros" class="btn btn-primary  col-xs-12"><i class="fa fa-search"></i> Buscar Pasajero</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-3 col-md-3 col-xl-12" >
                        <button id="btn-create" type="submit"  class="btn btn-danger col-xs-12"> Agregar Manifiesto</button>
                    </div>
                </div>
            </div>
        </div>

        <div id="table-listado-vuelos"></div>

    </div>
</div>


<!-- Dinamic modal -->

<div class="modal fade" id="dinamicModal" role="dialog"   aria-hidden="true" style="overflow-y: scroll;">
    <div id="dialogM" class="modal-dialog ">

     <!-- Modal content-->
     <div class="modal-content">
        <div class="modal-header modal-header-danger" style='padding-top: 5px !important; padding-bottom: 5px !important;'>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 id="title_modal" class="modal-title"></h4>
        </div>
        <div id="body_dinamicac_modal" class="modal-body">

        </div>
     </div>
    </div>
</div>


<style>
    .pagination > .active > a,
    .pagination > .active > span,
    .pagination > .active > a:hover,
    .pagination > .active > span:hover,
    .pagination > .active > a:focus,
    .pagination > .active > span:focus {
        z-index: 3;
        color: #fff;
        cursor: default;
        background-color: #D73925;
        border-color: #D73925;
    }
</style>



         
 