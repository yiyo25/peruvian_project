<div class='box box-danger'>
    <div class="box-header with-border">
        <h3 class="box-title"></h3>
    </div>
    <div class="box-body">
	<div class="row">
            <div class="col-md-6">
                <label class="col-sm-12 col-md-5 control-label">Vuelos Demorados por Mes</label>
                <div class="chart">
                    <canvas id="chart_vuelos"></canvas>
                </div>
            </div>

            <div class="col-md-6">
                <label class="col-sm-12 col-md-4 control-label">Pasajeros por Mes</label>
                <div class="chart">
                    <canvas id="chart_pasajeros"></canvas>
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-6">
                <label class="col-sm-12 col-md-4 control-label">Horas Block por Mes</label>
                <div class="chart">
                    <canvas id="chart_horasBlock"></canvas>
                </div>
            </div>

           <div class="col-md-6">
                <label class="col-sm-12 col-md-5 control-label">Vuelos por localidad - Mes Actual</label>
                <div class="chart">
                    <canvas id="chart_vuelos_localidad"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>



<style>
    

canvas {
  border: 1px dotted red;
}

.chart-container {
  position: relative;
  margin: auto;
  height: 40vh;
  width: 40vw;
}

</style>
