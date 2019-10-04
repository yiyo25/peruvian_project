<?php

/**
 * Description of CombustibleController
 *
 * @author ihuapaya
 */
class CombustibleController extends Controller{
    
    public function __construct() {
        parent::__construct();
    }
    
    public function indexAction(){
        if($this->isPost()){
            
            $this->_view->maintpl = "mainx";
            $obj_ciudad =new Ciudad();
            $listCiudad = $obj_ciudad->getAll();
            
            $id_vuelo_detalle = $_POST['id_vuelo_detalle'];

            $obj_vuelo_detalle = new VueloDetalle();
            $row_detalle = $obj_vuelo_detalle->getRowById($id_vuelo_detalle);

            $rpt = 0;
            $html_hora = "";
            $msg_error = "";
            if(count($row_detalle)>0)
            {
                $id_matricula = $row_detalle[0]['IdMatricula'];
                $obj_matricula = new Matriculas();
                $row_matricula = $obj_matricula->getRowById($id_matricula);
                $txt_toma_in = $txt_toma_out = $txt_nivel_vuelo = $txt_rmntFull_lbs_kgs = $txt_recagFull_lbs_gal = $txt_total_full_lbs = $txt_total_full_kgs="";
                $txt_nro_entrega_Exxon_1 = $txt_nro_entrega_Exxon_1_nro2 = $txt_nro_entrega_Exxon_1_nro3 = $txt_recagFull_lbs_gal_nro1 = $txt_recagFull_lbs_gal_nro2="";
                $txt_recagFull_lbs_gal_nro3 = $txt_nro_entrega_Exxon_2 = $txt_cantidad_ingreso_kilos_libras = $txt_cantidad_ingreso_libras_de_galones = $txt_total_full_lbs_kgs ="";
                $txt_total_full_kgs_kgs = "";
                if(count($row_matricula)>0){
                    
                    $txt_toma_in=trim($row_detalle[0]["toma_in"]);
                    $txt_toma_out=trim($row_detalle[0]["toma_out"]);
                    $txt_nivel_vuelo=trim($row_detalle[0]["nivel_vuelo"]);

                    $txt_rmntFull_lbs_kgs=trim($row_detalle[0]["rmntFull_lbs_kgs"]);
                    $txt_recagFull_lbs_gal=trim($row_detalle[0]["recagFull_lbs_gal"]);
                    $txt_total_full_lbs=trim($row_detalle[0]["total_full_lbs_kgs"]);

                    $txt_total_full_kgs=trim($row_detalle[0]["total_full_kgs_kgs"]);

                    $txt_nro_entrega_Exxon_1=trim($row_detalle[0]["nro_entrega_Exxon_1"]);

                    $txt_nro_entrega_Exxon_1_nro2=trim($row_detalle[0]["nro_entrega_Exxon_1_nro2"]);
                    $txt_nro_entrega_Exxon_1_nro3=trim($row_detalle[0]["nro_entrega_Exxon_1_nro3"]);

                    $txt_recagFull_lbs_gal_nro1=trim($row_detalle[0]["recagFull_lbs_gal_nro1"]);
                    $txt_recagFull_lbs_gal_nro2=trim($row_detalle[0]["recagFull_lbs_gal_nro2"]);
                    $txt_recagFull_lbs_gal_nro3=trim($row_detalle[0]["recagFull_lbs_gal_nro3"]);

                    $txt_nro_entrega_Exxon_2=trim($row_detalle[0]["nro_entrega_Exxon_2"]);

                    $txt_cantidad_ingreso_kilos_libras=trim($row_detalle[0]["cantidad_ingreso_kilos_libras"]);
                    $txt_cantidad_ingreso_libras_de_galones=trim($row_detalle[0]["cant_librasGalones"]);

                    $txt_total_full_lbs_kgs=trim($row_detalle[0]["total_full_lbs_kgs"]);
                    $txt_total_full_kgs_kgs=trim($row_detalle[0]["total_full_kgs_kgs"]);


                    if($row_detalle[0]["tipo_ingreso_kgs_lbs"]=="Kgs")
                    {
                        $txt_rmntFull_lbs_kgs=trim($row_detalle[0]["rmntFull_lbs_kgs"]);
                        $txt_rmntFull_lbs_kgs2=trim($row_detalle[0]["rmntFull_lbs_kgs_libras"]);
                        $txt_cantidad_ingreso_kilos_libras=trim($row_detalle[0]["rmntFull_lbs_kgs_libras"]);
                        $txt_cantidad_ingreso_kilos_libras2=trim($row_detalle[0]["rmntFull_lbs_kgs"]);

                    }
                    
                    if($row_detalle[0]["tipo_ingreso_kgs_lbs"]=="Lbs")
                    {
                        $txt_rmntFull_lbs_kgs=trim($row_detalle[0]["rmntFull_lbs_kgs_libras"]);
                        $txt_cantidad_ingreso_kilos_libras=trim($row_detalle[0]["rmntFull_lbs_kgs"]);

                        $txt_rmntFull_lbs_kgs2=trim($row_detalle[0]["rmntFull_lbs_kgs"]);
                        $txt_cantidad_ingreso_kilos_libras2=trim($row_detalle[0]["rmntFull_lbs_kgs_libras"]);
                    }	

                    $txt_rmnte_final_vuelo_kilos=trim($row_detalle[0]["rmntFull_Termino_kilos"]);
                    $txt_rmnte_final_vuelo_libras=trim($row_detalle[0]["rmntFull_Termino_libras"]);

                    $tipoIngreso=trim($row_matricula[0]["tipo_ingreso_combustible"]);
	
                    
                    /*                 * ******** cabecera******************************* */
                   $this->_view->assign("fecha", $_POST["fecha_vuelo"]);
                   $this->_view->assign("matricula", $_POST["matricula"]);
                   $this->_view->assign("nro_vuelo", $_POST["nro_vuelo"]);
                   $this->_view->assign("ruta", $_POST["ruta"]);
                   $this->_view->assign("id_vuelo_cabecera", $_POST["id_vuelo_cabecera"]);
                   $this->_view->assign("listCiudad",$listCiudad);
                   $this->_view->assign("edit_ruta",1);
                   /*                 * *************************************************** */
                    $rpt = 1;
                    $html_hora = $this->_view->fetch('combustible.tpl');
                }
                
            }else {
                $rpt = 0;
                $msg_error = "No existe el Id =>" . $id_vuelo_detalle;
            }
            
        }else {
            $rpt = 0;
            $html_hora = "";
            $msg_error = "Error Metodo POST";
        }

        echo json_encode(array(
            "rpt" => $rpt,
            "html_hora" => $html_hora,
            "msg_error" => $msg_error
                )
        );

        exit;
    }
    
    
    public function saveAction(){
        if($this->isPost()){
            
        }
    }
}
