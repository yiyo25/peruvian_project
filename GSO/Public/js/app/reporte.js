/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$(document).ready(function () {
    $('#datetimepickerini').datetimepicker({
       format: 'YYYY-MM-DD'
   }); 

   $('#datetimepickerfin').datetimepicker({
       format: 'YYYY-MM-DD'
   }); 
});

var app = new Vue({
    el: '#principal',
    data: {
        search:'',
        data_reporte:[]   
    },
    methods:{
        listar:function(){
            var url = SERVER_NAME+'reportes/getDataReporte';
            axios.get(url)
            .then(function (response) {
                console.log(response.data[0]["empresa"]);
                //this.tripulacion = response.data.escala["empresa"];
            })
            .catch(function (error) {
                console.log(error);
            });
        }
    },
    mounted: function () {
        this.listar();
    } 
});
