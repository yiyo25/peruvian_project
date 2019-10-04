
$.ajax({
    url:SERVER_NAME+ "dashboard/vueloporLocalidad",
    type: 'post',
    dataType: "json",
    success: function (result) {
        renderChart("chart_vuelos_localidad","bar",result);
    }
});

$.ajax({
    url:SERVER_NAME+ "dashboard/reportexMes",
    type: 'post',
    dataType: "json",
    success: function (result) {
        result.forEach(function(item){ 
            renderChart(item.id,item.type,item.data);
        }); 
    }
});


function renderChart(idChart,type,result){
    var ctx = document.getElementById(idChart).getContext('2d');
    if(idChart==="chart_vuelos_localidad"){
        var myChart = new Chart(ctx, {
            type: type,
            data: result,
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                },
                tooltips: {
                  callbacks: {
                    label: function(tooltipItem, data) {
                        var dataset = data.datasets2[tooltipItem.datasetIndex];
                        return dataset.label+":" + dataset.data[tooltipItem.index];
                    }
                  }
                }
            }
        });
    }else{
        var myChart = new Chart(ctx, {
            type: type,
            data: result,
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        });
    }
    
}

