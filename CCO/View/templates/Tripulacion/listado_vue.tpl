<input type="hidden" id="tipo_funcion" value="{$tipo_funcion}">
{literal}
<div id="principal" class='box box-danger' >
    <div class="box-body table-wrapper">
        <div id="MainContent_search" class="panel panel-default">
            <div class="panel-body">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-8" style="padding-top: 10px;">
                        <form class="form-horizontal" method="GET" action="">
                            <div class="form-group">
                                <label for="search" class="control-label col-sm-2" style="padding-top: 8px !important;">Buscar:</label>
                                <div class="col-xs-12 col-sm-6 col-md-6">
                                <input type="text" id="search" class="form-control" name="search" value="" placeholder="Ingrese dato a buscar">
                                </div>
                                <div class="col-xs-12 col-sm-4 col-md-4">
                                <button type="submit"  class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                </div>
                            </div>
                        </form>
                     </div>
                    <div class="col-xs-12 col-sm-2 col-md-4" style="padding-top: 10px;">
                        <button id="btn-create" type="button" class="btn btn-info "><i class="fa fa-plus"></i> Nueva Tripulacion</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="table-responsive ">
            <table id="tblvuelos" class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th  scope="col" >Licéncia</th>
                        <th  scope="col" >DNI</th>
                        <th scope="col" >Tripulante</th>
                        <th scope="col" >Funcion</th>
                        <th  scope="col" >Telefono</th>
                        <th  scope="col" >Celular</th>
                        <th  scope="col" >Correo Electronico</th>
                        <th  scope="col" >Estado</th>
                        <th scope="col"  style="width: 180px; "></th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="trip in tripulacion">
                        <td>{{trip.TRIP_numLicencia}}</td>
                        <td>{{trip.TRIP_numdoc}}</td>
                        <td>{{trip.TRIP_nombre}}  {{trip.TRIP_apellido}}</td>
                        <td>{{trip.TRIPFUN_descripcion}}</td>
                        <td>{{trip.TRIP_telefono}}</td>
                        <td>{{trip.TRIP_celular}}</td>
                        <td>{{trip.TRIP_correo}}</td>
                        <td>
                            <template v-if="trip.TRIP_estado == 1">
                                <span class="label label-success">Acivo</span>
                            </template>
                            <template v-else>
                                <span class="label label-danger">Inactive</span>
                            </template>
                        </td>
                        <td>
                            <a href="#"  class="settings btn-edit" title="Editar" data-toggle="tooltip"><i class="fa fa-edit"></i></a>
                            <a href="#" class="delete eliminar_tri"  title="Eliminar" data-toggle="tooltip"><i class="fa fa-trash" aria-hidden="true"></i></a>
                            <template v-if="trip.TRIP_estado == 1">
                                <a href="#" class="inactive btn_inactive " id="btn_inactive"  title="desactivar" data-toggle="tooltip"><i class="fa fa-ban" aria-hidden="true"></i></a>
                            </template>
                            <template v-else>
                                <a href="#" class="active btn_active" id="btn_active"  title="Activar" data-toggle="tooltip"><i class="fa fa-check" aria-hidden="true"></i></a>
                            </template>
                        </td>
                    </tr>
                    
                </tbody>
            </table>
        </div>   
    </div>
    
    
</div>

<div class="modal fade" id="dinamicModal" role="dialog"   aria-hidden="true" style="overflow-y: scroll;">
    <div id="dialogM" class="modal-dialog modal-xs">

     <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header modal-header-danger" style='padding-top: 5px !important; padding-bottom: 5px !important; '>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 id="title_modal" class="modal-title"></h4>
      </div>
      <div id="body_dinamicac_modal" class="modal-body">

      </div>
     </div>
    </div>
</div>
    {/literal}



<style type="text/css">
    Body {
        color: #566787;
        background: #f5f5f5;
        font-family: 'Varela Round', sans-serif;
        font-size: 13px;
    }
    .table-wrapper {
        background: #fff;
        padding: 20px 25px;
        margin: 20px 0;
        border-radius: 3px;
        box-shadow: 0 1px 1px rgba(0,0,0,.05);
    }
    
    .table-title .btn:hover, .table-title .btn:focus {
        color: #566787;
        background: #f2f2f2;
    }
    .table-title .btn i {
        float: left;
        font-size: 21px;
        margin-right: 5px;
    }
    .table-title .btn span {
        float: left;
        margin-top: 2px;
    }
    table.table tr th, table.table tr td {
        border-color: #e9e9e9;
	padding: 12px 15px;
        vertical-align: middle;
    }
    table.table tr th:first-child {
        width: 60px;
    }
    table.table tr th:last-child {
        width: 100px;
    }
    table.table-striped tbody tr:nth-of-type(odd) {
        background-color: #fcfcfc;
    }
    table.table-striped.table-hover tbody tr:hover {
        background: #f5f5f5;
    }
    table.table th i {
        font-size: 13px;
        margin: 0 5px;
        cursor: pointer;
    }	
    table.table td:last-child i {
        opacity: 0.9;
	font-size: 22px;
        margin: 0 5px;
    }
    table.table td a {
        font-weight: bold;
        color: #566787;
        display: inline-block;
        text-decoration: none;
    }
    table.table td a:hover {
        color: #2196F3;
    }
    table.table td a.settings {
        color: #2196F3;
    }
    table.table td a.delete {
        color: #F44336;
    }
    table.table td a.add {
        color: #27C46B;
    }
    table.table td a.edit {
        color: #FFC107;
    }
    table.table td a.active {
        color: #10c469;
    }
    table.table td a.inactive {
        color: #FFC107;
    }
    table.table td i {
        font-size: 19px;
    }
    table.table .avatar {
            border-radius: 50%;
            vertical-align: middle;
            margin-right: 10px;
    }
    .status {
            font-size: 30px;
            margin: 2px 2px 0 0;
            display: inline-block;
            vertical-align: middle;
            line-height: 10px;
    }
    .text-success {
        color: #10c469;
    }
    .text-info {
        color: #62c9e8;
    }
    .text-warning {
        color: #FFC107;
    }
    .text-danger {
        color: #ff5b5b;
    }
    .pagination {
        float: right;
        margin: 0 0 5px;
    }
    .pagination li a {
        border: none;
        font-size: 13px;
        min-width: 30px;
        min-height: 30px;
        color: #999;
        margin: 0 2px;
        line-height: 30px;
        border-radius: 2px !important;
        text-align: center;
        padding: 0 6px;
    }
    .pagination li a:hover {
        color: #666;
    }	
    .pagination li.active a, .pagination li.active a.page-link {
        background: #03A9F4;
    }
    .pagination li.active a:hover {        
        background: #0397d6;
    }
	.pagination li.disabled i {
        color: #ccc;
    }
    .pagination li i {
        font-size: 16px;
        padding-top: 6px
    }
    .hint-text {
        float: left;
        margin-top: 10px;
        font-size: 13px;
    }
    .btn-info {
        color: #fff;
        background-color: #5bc0de;
        border-color: #46b8da;
    }
    .btn.btn-primary {
        color: #fff;
        background: #03A9F4;
        border-color: #03A9F4;
    }
    
    .add-new{
        float: right;
        height: 30px;
        font-weight: bold;
        font-size: 12px;
        text-shadow: none;
        min-width: 100px;
        border-radius: 50px;
        line-height: 13px;
    }
</style>
