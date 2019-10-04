            <div class="modal fade" id="TipoTrabajoMensaje" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-keyboard="false" data-backdrop="static">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4>
                                <i class="fa fa-exclamation-triangle" aria-hidden="true" style="color:#1175AA; font-size: 20px;"></i>
                                <strong id="titleForm"> MENSAJE IMPORTANTE</strong>
                                <button type="button" class="close btn-lg" data-dismiss="modal" style="background-color: red; color:white; margin:10px; padding: 0px 6px 2px 6px;text-align:right;">
                                    <span aria-hidden="true">&times;</span><span class="sr-only">Cerrar</span>
                                </button>
                            </h4>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-12" style="padding-bottom: 10px;">
                                    <p>El Usuario <b id="usuEdicion"></b> esta realizando una reprogramación de vuelos. Favor contactarlo.</p>
                                    <p>Por el momento, sólo podrá acceder en modo consulta. Dar click en [Continuar].</p>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type='button' id='' name='' class="btn btn-sm" data-dismiss="modal">Continuar</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Footer -->
            <footer class="main-footer">
                <div class="pull-right hidden-xs">
                    Sistema de Programación de Vuelo
                </div>
                <span>Copyright © 2018 Peruvian.</span>                
            </footer>
            <script type="text/javascript">
                $(document).ready(function() { $(".js-example-basic-single").select2(); });
                $(document).ready(function() { $('.js-example-basic-multiple').select2(); });
                
                
                function flagEstadoModulo(url,accion,tabla) {
                    var url_estado = '<?php echo URLLOGICA?>motor/verificarEstadoFlag/';
                    var variable = '';
                    var parametros = {};
                    $.post(url_estado,parametros,
                    function(data){
                        variable = data;
                        if(accion == 'listar'){
                            if(tabla == 'apto'){
                                insertApto(url,variable);
                            }
                            if(tabla == 'curso'){
                                insertCurso(url,variable);
                            }
                            if(tabla == 'chequeo'){
                                insertChequeo(url,variable);
                            }
                            if(tabla == 'simulador'){
                                insertSimulador(url,variable);
                            }
                            if(tabla == 'ausencia'){
                                insertAusencia(url,variable);
                            }
                        }
                        if(accion == 'modificar'){
                            if(tabla == 'apto'){
                                updateApto(url,variable);
                            }
                            if(tabla == 'curso'){
                                updateCurso(url,variable);
                            }
                            if(tabla == 'chequeo'){
                                updateChequeo(url,variable);
                            }
                            if(tabla == 'simulador'){
                                updateSimulador(url,variable);
                            }
                            if(tabla == 'ausencia'){
                                updateAusencia(url,variable);
                            }
                        }
                    });
                }
                
                function resetEstado_Motor(){
                    var url_estado = '<?php echo URLLOGICA?>motor/insertEstadoFlag/';
                    //console.log("demo");
                    //alert($('#TIP_trabajo').bootstrapSwitch('state'));
                    if( $('#TIP_trabajo').bootstrapSwitch('state') == "true" ){
                        var TIP_trabajo1 = '1';
                    } else {
                        var TIP_trabajo1 = '0';
                    }
                    var parametros = {
                        TIP_trabajo : TIP_trabajo1,
                    };
                    $.post(url_estado,parametros,
                    function(data){
                        //alert("prueba9");
                    });
                }
                
                
                //window.onbeforeunload = resetEstado_Motor;
                
                function ejecucionMotorView(){
                    ejecucionMotor('<?php echo URLLOGICA?>motor/programacionAutomaticaMensual/');
                }
                
            </script>
            <script src="<?php echo URLPUBLIC;?>/js/funciones.js?version=2.0.0"></script>
        </div>
    </body>
</html>
