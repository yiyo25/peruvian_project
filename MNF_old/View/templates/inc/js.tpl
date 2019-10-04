
<script type="text/javascript" src="{$SERVER_PUBLIC}plugins/jQuery/jquery-2.2.3.min.js"></script>

{*<script type="text/javascript" src="{$SERVER_PUBLIC}plugins/jquery_validate/jquery.validate.js"></script>*}
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.min.js"></script>
<script type="text/javascript" src="{$SERVER_PUBLIC}js/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.7.14/js/bootstrap-datetimepicker.min.js"></script>
<script type="text/javascript" src="{$SERVER_PUBLIC}bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript" src="{$SERVER_PUBLIC}js/peruvian.js"></script>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/js/select2.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap.min.js"></script>
<script type="text/javascript" src="{$SERVER_PUBLIC}plugins/sweetalert/sweetalert.min.js"></script>


<script type="text/javascript" src="{$SERVER_PUBLIC}js/app/functions.js"></script>

<script language="javascript" type="text/javascript">

    {$aJSTxt}

    $('#datetimepickerini').datetimepicker({
        format: 'YYYY-MM-DD'
    });

    $('#datetimepickerfin').datetimepicker({
        format: 'YYYY-MM-DD'
    });
    /*$('#tblvuelos').DataTable({
        ordering: false,
        searching: true,
        lengthChange: true,
        info: false,
        pageLength: 20
    });*/
</script>

{if $JS eq "listadoVuelo"}

<script type="text/javascript" src="{$SERVER_PUBLIC}js/app/listado_vuelo.js"></script>
{/if}

{if $JS eq "detallePax"}

    <script type="text/javascript" src="{$SERVER_PUBLIC}js/app/detalle_pasajero.js"></script>
{/if}



