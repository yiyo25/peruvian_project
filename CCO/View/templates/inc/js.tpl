
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
</script>


{if $JS eq "lista_vuelo"}
    <script type="text/javascript" src="{$SERVER_PUBLIC}js/app/crearvuelo.js"></script>
    <script type="text/javascript" src="{$SERVER_PUBLIC}js/app/vuelo_tripulacion.js"></script>
    <script type="text/javascript" src="{$SERVER_PUBLIC}js/app/hora.js"></script>
    <script type="text/javascript" src="{$SERVER_PUBLIC}js/app/pasajeros.js"></script>
    <script type="text/javascript" src="{$SERVER_PUBLIC}js/app/equipaje.js"></script>
    <script type="text/javascript" src="{$SERVER_PUBLIC}js/app/combustible.js"></script>

{/if}

{if $JS eq  "tripulacion" || $JS eq "reporte"}
    {*<script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>*}
    {*<script type="text/javascript" src="{$SERVER_PUBLIC}js/app/Tripulacion.js"></script>*}
   {* <script type="text/javascript" src="{$SERVER_PUBLIC}js/app/reporte.js"></script>*}
{/if}


{if $JS eq "dashboard"}
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js"></script>
    <script type="text/javascript" src="{$SERVER_PUBLIC}js/app/dashboard.js"></script>
{/if}    