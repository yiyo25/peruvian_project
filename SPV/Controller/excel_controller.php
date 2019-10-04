<?php
ini_set('memory_limit', '1024M');
ini_set('max_execution_time', 2400); 

if( !isset($_SESSION)){
	session_start();
}

include './Model/Excel/PHPExcel.php'; 
	
class excel extends Controller {
    function __construct(){
        parent::__construct();  //Llama al constructor de su padre
    }

    function itinerario_excel($diai,$mesi,$anioi,$diaf,$mesf,$aniof){
        
        $itinerario = new Itinerario_model();

        $ITI_fchini_i = $diai . '/' . $mesi . '/' . $anioi;
        $ITI_fchfin_i = $diaf . '/' . $mesf . '/' . $aniof;

        $parts = explode('/',$ITI_fchini_i);
        $ITI_fchini = $parts[2] . '-' . $parts[1] . '-' . $parts[0];

        $parts = explode('/',$ITI_fchfin_i);
        $ITI_fchfin = $parts[2] . '-' . $parts[1] . '-' . $parts[0];

        $objPHPExcel = new PHPExcel();	
        $objPHPExcel->getProperties()->setCreator("Peruvian Airlines S.A.C.")
                                        ->setLastModifiedBy("Peruvian Airlines S.A.C.")
                                        ->setTitle("Office 2007 XLSX Test Document")
                                        ->setSubject("Office 2007 XLSX Test Document")
                                        ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
                                        ->setKeywords("office 2007 openxml php")
                                        ->setCategory("Test result file");
        $borders = 
            array(
                'borders' => array(
                    'allborders' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN,
                        'color' => array(
                            'argb' => 'FF000000'),
                    )
                ),
            );

        $style = 
            array(
                'alignment' => array(
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                )
            );


        $i = 3;
        $k = 2;


        $objPHPExcel->getActiveSheet()->setTitle('Itinerario');

        for($j=$ITI_fchini;$j<=$ITI_fchfin;$j = date("Y-m-d", strtotime($j ."+ 1 days"))){

            $parts = explode('-',$j);
            $ITI_fchini = $parts[2] . '/' . $parts[1] . '/' . $parts[0];

            $objDetItinerario = $itinerario->listarItinerario($ITI_fchini,$ITI_fchini,'');
            $objDetItinerario = $this->array_utf8_encode($objDetItinerario);
            
            $diaNombre = strftime('%A',strtotime($objDetItinerario[0]["ITI_fch2"]));
                
            $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A'.($k-1).':F'.($k-1));
            $objPHPExcel->getActiveSheet()->SetCellValue('A'.($k-1),'PROGRAMACIÓN '.strtoupper(utf8_encode($diaNombre)).' '.$objDetItinerario[0]["ITI_fch"]);

            $objPHPExcel->getActiveSheet()->getStyle('A'.$k.':F'.$k)->applyFromArray($borders);
            $objPHPExcel->getDefaultStyle()->applyFromArray($style);

            $objPHPExcel->getActiveSheet()->SetCellValue('A'.$k,'N° de Vuelo');
            $objPHPExcel->getActiveSheet()->SetCellValue('B'.$k,'N° de Cola');
            $objPHPExcel->getActiveSheet()->SetCellValue('C'.$k,'Origen');
            $objPHPExcel->getActiveSheet()->SetCellValue('D'.$k,'Destino');
            $objPHPExcel->getActiveSheet()->SetCellValue('E'.$k,'Hora Salida'); 
            $objPHPExcel->getActiveSheet()->SetCellValue('F'.$k,'Hora Llegada');

            $i = ($k+1);
            foreach($objDetItinerario as $lista){
                $objPHPExcel->getActiveSheet()->getStyle('A'.$i.':F'.$i)->applyFromArray($borders);

                $objPHPExcel->setActiveSheetIndex(0)
                                ->setCellValue('A'.$i, $lista["RUT_num_vuelo"])
                                ->setCellValue('B'.$i, $lista["AVI_num_cola"])
                                ->setCellValue('C'.$i, $lista["CIU_id_origen"])
                                ->setCellValue('D'.$i, $lista["CIU_id_destino"])
                                ->setCellValue('E'.$i, $lista["RUT_hora_salida"])
                                ->setCellValue('F'.$i, $lista["RUT_hora_llegada"]);
                $i++;
            }
            $k = ($i+2);
        }
        
        foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) {
            $objPHPExcel->setActiveSheetIndex($objPHPExcel->getIndex($worksheet));
            $sheet = $objPHPExcel->getActiveSheet();
            $cellIterator = $sheet->getRowIterator()->current()->getCellIterator();
            $cellIterator->setIterateOnlyExistingCells(true);
            /** @var PHPExcel_Cell $cell */
            foreach ($cellIterator as $cell) {
                $sheet->getColumnDimension($cell->getColumn())->setAutoSize(true);
            }
        }
        
        $parts = explode('/',$ITI_fchini_i);
        $ITI_fchini = $parts[2] . '-' . $parts[1] . '-' . $parts[0];

        header("Content-Type: application/force-download"); 
        header("Content-Type: application/octet-stream"); 
        header("Content-Type: application/download"); 
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: inline;filename="itinerario_'.$ITI_fchini.'_'.$ITI_fchfin.'.xlsx"');
        header('Cache-Control: no-cache');
        
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        
        $name = URLRUTAITINERARIO."itinerario_".$ITI_fchini."_".$ITI_fchfin.".xlsx";
        $objWriter->save(str_replace(__FILE__,$name,__FILE__));
        $objWriter->save('php://output');

        exit(); 
}

    function programacion_excel($dia,$mes,$anio){
        $programacion = new Programacion_model();

        $ITI_fch = $dia . '/' . $mes . '/' . $anio;

        $objPHPExcel = new PHPExcel();	
        $objPHPExcel->getProperties()->setCreator("Peruvian Airlines S.A.C.")
                                        ->setLastModifiedBy("Peruvian Airlines S.A.C.")
                                        ->setTitle("Office 2007 XLSX Test Document")
                                        ->setSubject("Office 2007 XLSX Test Document")
                                        ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
                                        ->setKeywords("office 2007 openxml php")
                                        ->setCategory("Test result file");
        $borders = 
            array(
                'borders' => array(
                    'allborders' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN,
                        'color' => array(
                            'argb' => 'FF000000'),
                    )
                ),
            );

        $style = 
            array(
                'alignment' => array(
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                )
            );


        $objPHPExcel->getActiveSheet()->setTitle('Programación');
        
        $objDetProgramacionMatriz = $programacion->listarProgramacionResumenMatriz($ITI_fch,'','');
        $objDetProgramacionMatriz = $this->array_utf8_encode($objDetProgramacionMatriz);

        $objDetProgramacion = $programacion->listarProgramacionResumen($ITI_fch,'','');
        $objDetProgramacion = $this->array_utf8_encode($objDetProgramacion);

        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:L1');
        $objPHPExcel->getActiveSheet()->SetCellValue('A1','PROGRAMACIÓN DE VUELOS: ');
        
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('M1:Q1');
        $objPHPExcel->getActiveSheet()->SetCellValue('M1',$objDetProgramacionMatriz[0]["ITI_dia"]." ".$objDetProgramacionMatriz[0]["ITI_fchdiaN"]." de ".$objDetProgramacionMatriz[0]["ITI_fchmes"]." del ".$objDetProgramacionMatriz[0]["ITI_fchanio"]);
        
        $objPHPExcel->getDefaultStyle()->applyFromArray($style);
        $objPHPExcel->getActiveSheet()->getStyle('A1:Q4')->applyFromArray($borders);

        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A2:A4');
        $objPHPExcel->getActiveSheet()->SetCellValue('A2','N° de Vuelo');
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('B2:B4');
        $objPHPExcel->getActiveSheet()->SetCellValue('B2','N° de Cola');
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('C2:D2');
        $objPHPExcel->getActiveSheet()->SetCellValue('C2','Ruta');
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('C3:C4');
        $objPHPExcel->getActiveSheet()->SetCellValue('C3','Origen');
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('D3:D4');
        $objPHPExcel->getActiveSheet()->SetCellValue('D3','Destino');
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('E2:E4');
        $objPHPExcel->getActiveSheet()->SetCellValue('E2','Hora Salida (ETD)'); 
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('F2:F4');
        $objPHPExcel->getActiveSheet()->SetCellValue('F2','Hora Llegada (ETA)');
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('G2:G4');
        $objPHPExcel->getActiveSheet()->SetCellValue('G2','ATD');
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('H2:H4');
        $objPHPExcel->getActiveSheet()->SetCellValue('H2','ATA');
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('I2:I4');
        $objPHPExcel->getActiveSheet()->SetCellValue('I2','DLY1');
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('J2:J4');
        $objPHPExcel->getActiveSheet()->SetCellValue('J2','DLY2');
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('K2:K4');
        $objPHPExcel->getActiveSheet()->SetCellValue('K2','PAX');
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('L2:L4');
        $objPHPExcel->getActiveSheet()->SetCellValue('L2','TOMA');
        
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('M2:P2');
        $objPHPExcel->getActiveSheet()->SetCellValue('M2','TRIPULACIÓN');
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('M3:N3');
        $objPHPExcel->getActiveSheet()->SetCellValue('M3','PILOTO');
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('O3:P3');
        $objPHPExcel->getActiveSheet()->SetCellValue('O3','COPILOTO');
        
        $objPHPExcel->getActiveSheet()->SetCellValue('M4','JEFE CABINA');
        $objPHPExcel->getActiveSheet()->SetCellValue('N4','TRIP. N° 1');
        $objPHPExcel->getActiveSheet()->SetCellValue('O4','TRIP. N° 2');
        $objPHPExcel->getActiveSheet()->SetCellValue('P4','TRIP. N° 3');
        
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('Q2:Q4');
        $objPHPExcel->getActiveSheet()->SetCellValue('Q2','APOYO EN VLO.');
        
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A5:Q5');
        
        $objPHPExcel->getActiveSheet()->getStyle('A2')->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getStyle('B2')->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getStyle('C2')->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getStyle('D2')->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getStyle('E2')->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getStyle('F2')->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getStyle('G2')->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getStyle('H2')->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getStyle('I2')->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getStyle('J2')->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getStyle('K2')->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getStyle('L2')->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getStyle('M2')->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getStyle('N2')->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getStyle('O2')->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getStyle('P2')->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getStyle('M4')->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getStyle('N4')->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getStyle('O4')->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getStyle('P4')->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getStyle('Q2')->getAlignment()->setWrapText(true);
        
        /*echo "<pre>".print_r($objDetProgramacionMatriz,true)."<pre>";
        echo "<pre>".print_r($objDetProgramacion,true)."<pre>";die();*/
        
        $i = 6;
        foreach($objDetProgramacionMatriz as $listaMatriz){
            $objPHPExcel->getActiveSheet()->getStyle('A'.$i.':Q'.($i+1))->applyFromArray($borders);
            
            $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A'.$i.':A'.($i+1));
            $objPHPExcel->setActiveSheetIndex(0)->mergeCells('B'.$i.':B'.($i+1));
            $objPHPExcel->setActiveSheetIndex(0)->mergeCells('C'.$i.':C'.($i+1));
            $objPHPExcel->setActiveSheetIndex(0)->mergeCells('D'.$i.':D'.($i+1));
            $objPHPExcel->setActiveSheetIndex(0)->mergeCells('E'.$i.':E'.($i+1));
            $objPHPExcel->setActiveSheetIndex(0)->mergeCells('F'.$i.':F'.($i+1));
            $objPHPExcel->setActiveSheetIndex(0)->mergeCells('G'.$i.':G'.($i+1));
            $objPHPExcel->setActiveSheetIndex(0)->mergeCells('H'.$i.':H'.($i+1));
            $objPHPExcel->setActiveSheetIndex(0)->mergeCells('I'.$i.':I'.($i+1));
            $objPHPExcel->setActiveSheetIndex(0)->mergeCells('J'.$i.':J'.($i+1));
            $objPHPExcel->setActiveSheetIndex(0)->mergeCells('K'.$i.':K'.($i+1));
            $objPHPExcel->setActiveSheetIndex(0)->mergeCells('L'.$i.':L'.($i+1));
            
            $objPHPExcel->setActiveSheetIndex(0)
                            ->setCellValue('A'.$i,$listaMatriz["RUT_num_vuelo"])
                            ->setCellValue('B'.$i, $listaMatriz["AVI_num_cola"])
                            ->setCellValue('C'.$i, $listaMatriz["CIU_id_origen"])
                            ->setCellValue('D'.$i, $listaMatriz["CIU_id_destino"])
                            ->setCellValue('E'.$i, $listaMatriz["RUT_hora_salida"])
                            ->setCellValue('F'.$i, $listaMatriz["RUT_hora_llegada"])
                            ->setCellValue('G'.$i, '')
                            ->setCellValue('H'.$i, '')
                            ->setCellValue('I'.$i, '')
                            ->setCellValue('J'.$i, '')
                            ->setCellValue('K'.$i, '')
                            ->setCellValue('L'.$i, '')
            ;
        
            foreach($objDetProgramacion as $lista){
                if( $listaMatriz["RUT_num_vuelo"] == $lista["RUT_num_vuelo"] ){
                    
                    $objPHPExcel->setActiveSheetIndex(0)->mergeCells('M'.$i.':N'.$i);
                    $objPHPExcel->setActiveSheetIndex(0)->mergeCells('O'.$i.':P'.$i);
                    $objPHPExcel->setActiveSheetIndex(0)->mergeCells('Q'.$i.':Q'.($i+1));
                    
                    if( $lista["ITI_TRIP_tipo"] == 'Piloto' ){
                        $objPHPExcel->setActiveSheetIndex(0)
                                    ->setCellValue('M'.$i, $lista["TRIP_nombre"] ." ". $lista["TRIP_apellido"])
                        ;
                    }
                    if( $lista["ITI_TRIP_tipo"] == 'Copiloto' ){
                        $objPHPExcel->setActiveSheetIndex(0)
                                    ->setCellValue('O'.$i, $lista["TRIP_nombre"] ." ". $lista["TRIP_apellido"])
                        ;
                    }
                    if( $lista["ITI_TRIP_tipo"] == 'JefeCabina' ){
                        $objPHPExcel->setActiveSheetIndex(0)
                                    ->setCellValue('M'.($i+1), $lista["TRIP_nombre"] ." ". $lista["TRIP_apellido"])
                        ;
                    }
                    if( $lista["ITI_TRIP_tipo"] == 'TripCabina1' ){
                        $objPHPExcel->setActiveSheetIndex(0)
                                    ->setCellValue('N'.($i+1), $lista["TRIP_nombre"] ." ". $lista["TRIP_apellido"])
                        ;
                    }
                    if( $lista["ITI_TRIP_tipo"] == 'TripCabina2' ){
                        $objPHPExcel->setActiveSheetIndex(0)
                                    ->setCellValue('O'.($i+1), $lista["TRIP_nombre"] ." ". $lista["TRIP_apellido"])
                        ;
                    }
                    if( $lista["ITI_TRIP_tipo"] == 'TripCabina3' ){
                        $objPHPExcel->setActiveSheetIndex(0)
                                    ->setCellValue('P'.($i+1), $lista["TRIP_nombre"] ." ". $lista["TRIP_apellido"])
                        ;
                    }
                    if( $lista["ITI_TRIP_tipo"] == 'ApoyoVuelo' ){
                        $objPHPExcel->setActiveSheetIndex(0)
                                    ->setCellValue('Q'.$i, $lista["TRIP_nombre"] ." ". $lista["TRIP_apellido"])
                        ;
                    }   
                }
            }  
            $i++;
            $i++;
        }
        
        foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) {
            $objPHPExcel->setActiveSheetIndex($objPHPExcel->getIndex($worksheet));
            $sheet = $objPHPExcel->getActiveSheet();
            $cellIterator = $sheet->getRowIterator()->current()->getCellIterator();
            $cellIterator->setIterateOnlyExistingCells(true);
            /** @var PHPExcel_Cell $cell */
            foreach ($cellIterator as $cell) {
                $sheet->getColumnDimension($cell->getColumn())->setAutoSize(true);
            }
        }
        
        header("Content-Type: application/force-download"); 
        header("Content-Type: application/octet-stream"); 
        header("Content-Type: application/download"); 
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: inline;filename="programación.xlsx"');
        header('Cache-Control: no-cache'); 
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');

        exit();
    }
    
    function simulador_excel(){
        
        $simulador = new Simulador_model();

        $objPHPExcel = new PHPExcel();	
        $objPHPExcel->getProperties()->setCreator("Peruvian Airlines S.A.C.")
                                        ->setLastModifiedBy("Peruvian Airlines S.A.C.")
                                        ->setTitle("Office 2007 XLSX Test Document")
                                        ->setSubject("Office 2007 XLSX Test Document")
                                        ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
                                        ->setKeywords("office 2007 openxml php")
                                        ->setCategory("Test result file");
        $borders = 
            array(
                'borders' => array(
                    'allborders' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN,
                        'color' => array(
                            'argb' => 'FF000000'),
                    )
                ),
            );

        $style = 
            array(
                'alignment' => array(
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                )
            );
        
        $negrita = 
            array(
                'font' => array(
                    'bold' => true,
                )
            );
        
        $alto = 
            array(
                'font' => array(
                    'size' => 25,
                )
            );

        $objPHPExcel->getActiveSheet()->setTitle('Simulador');
        
        $objSimulador = $simulador->listarSimulador('',date("Y"),'');//date("Y")
        $objSimulador = $this->array_utf8_encode($objSimulador);
        
        //echo "<pre>".print_r($objSimulador,true)."</pre>";

        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:P1');
        $objPHPExcel->getActiveSheet()->SetCellValue( 'A1','PROGRAMACIÓN DE SIMULADORES - AÑO '. date("Y") );
        $objPHPExcel->getDefaultStyle()->applyFromArray($style);
        $objPHPExcel->getActiveSheet()->getStyle('A1:P1')->applyFromArray($borders);
        
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A3:P3');
        $objPHPExcel->getActiveSheet()->SetCellValue('A3',utf8_encode(strftime('%A %d de %B del %Y',strtotime(date("Y-m-d")))));
        
        $i = 4;
        $k = 4;
        $j = 1;
        $mesSimulador = "";
        $mesSimulador2 = "";
        foreach($objSimulador as $listaSimulador){
            
            $objPHPExcel->getActiveSheet()->getStyle('A'.$i.':P'.($i+1))->applyFromArray($borders);
            
            $mesSimulador = strtoupper(strftime('%B',strtotime($listaSimulador["SIMU_fchini2"])));
            
            if( $mesSimulador != $mesSimulador2 ){
                $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A'.$k.':A'.$k);
                $objPHPExcel->setActiveSheetIndex(0)->mergeCells('B'.$k.':B'.$k);
                $objPHPExcel->setActiveSheetIndex(0)->mergeCells('C'.$k.':C'.$k);
                $objPHPExcel->setActiveSheetIndex(0)->mergeCells('D'.$k.':D'.$k);
                $objPHPExcel->setActiveSheetIndex(0)->mergeCells('E'.$k.':E'.$k);
                $objPHPExcel->setActiveSheetIndex(0)->mergeCells('F'.$k.':F'.$k);
                $objPHPExcel->setActiveSheetIndex(0)->mergeCells('G'.$k.':G'.$k);
                $objPHPExcel->setActiveSheetIndex(0)->mergeCells('H'.$k.':H'.$k);
                $objPHPExcel->setActiveSheetIndex(0)->mergeCells('I'.$k.':I'.$k);
                $objPHPExcel->setActiveSheetIndex(0)->mergeCells('J'.$k.':J'.$k);
                $objPHPExcel->setActiveSheetIndex(0)->mergeCells('K'.$k.':K'.$k);
                $objPHPExcel->setActiveSheetIndex(0)->mergeCells('L'.$k.':L'.$k);
                $objPHPExcel->setActiveSheetIndex(0)->mergeCells('M'.$k.':M'.$k);
                $objPHPExcel->setActiveSheetIndex(0)->mergeCells('N'.$k.':N'.$k);
                $objPHPExcel->setActiveSheetIndex(0)->mergeCells('O'.$k.':O'.$k);
                $objPHPExcel->setActiveSheetIndex(0)->mergeCells('P'.$k.':P'.$k);

                $objPHPExcel->getActiveSheet()->SetCellValue('A'.$k,'MES');
                $objPHPExcel->getActiveSheet()->SetCellValue('B'.$k,'ÍTEM');
                $objPHPExcel->getActiveSheet()->SetCellValue('C'.$k,'CAPITÁN');
                $objPHPExcel->getActiveSheet()->SetCellValue('D'.$k,'LICENCIA');
                $objPHPExcel->getActiveSheet()->SetCellValue('E'.$k,'PRIMER OFICIAL');
                $objPHPExcel->getActiveSheet()->SetCellValue('F'.$k,'LICENCIA'); 
                $objPHPExcel->getActiveSheet()->SetCellValue('G'.$k,'LIBRE');
                $objPHPExcel->getActiveSheet()->SetCellValue('H'.$k,'SALIDA');
                $objPHPExcel->getActiveSheet()->SetCellValue('I'.$k,'TRAINING');
                $objPHPExcel->getActiveSheet()->SetCellValue('J'.$k,'CHECK RIDE');
                $objPHPExcel->getActiveSheet()->SetCellValue('K'.$k,'LLEGADA');
                $objPHPExcel->getActiveSheet()->SetCellValue('L'.$k,'LIBRE');
                $objPHPExcel->getActiveSheet()->SetCellValue('M'.$k,'TIME');
                $objPHPExcel->getActiveSheet()->SetCellValue('N'.$k,'B-737');
                $objPHPExcel->getActiveSheet()->SetCellValue('O'.$k,'DGAC/IDCEE');
                $objPHPExcel->getActiveSheet()->SetCellValue('P'.$k,'OBSERV.');

                $objPHPExcel->getActiveSheet()->getStyle('A'.$k)->getAlignment()->setWrapText(true);
                $objPHPExcel->getActiveSheet()->getStyle('B'.$k)->getAlignment()->setWrapText(true);
                $objPHPExcel->getActiveSheet()->getStyle('C'.$k)->getAlignment()->setWrapText(true);
                $objPHPExcel->getActiveSheet()->getStyle('D'.$k)->getAlignment()->setWrapText(true);
                $objPHPExcel->getActiveSheet()->getStyle('E'.$k)->getAlignment()->setWrapText(true);
                $objPHPExcel->getActiveSheet()->getStyle('F'.$k)->getAlignment()->setWrapText(true);
                $objPHPExcel->getActiveSheet()->getStyle('G'.$k)->getAlignment()->setWrapText(true);
                $objPHPExcel->getActiveSheet()->getStyle('H'.$k)->getAlignment()->setWrapText(true);
                $objPHPExcel->getActiveSheet()->getStyle('I'.$k)->getAlignment()->setWrapText(true);
                $objPHPExcel->getActiveSheet()->getStyle('J'.$k)->getAlignment()->setWrapText(true);
                $objPHPExcel->getActiveSheet()->getStyle('K'.$k)->getAlignment()->setWrapText(true);
                $objPHPExcel->getActiveSheet()->getStyle('L'.$k)->getAlignment()->setWrapText(true);
                $objPHPExcel->getActiveSheet()->getStyle('M'.$k)->getAlignment()->setWrapText(true);
                $objPHPExcel->getActiveSheet()->getStyle('N'.$k)->getAlignment()->setWrapText(true);
                $objPHPExcel->getActiveSheet()->getStyle('O'.$k)->getAlignment()->setWrapText(true);
                $objPHPExcel->getActiveSheet()->getStyle('P'.$k)->getAlignment()->setWrapText(true);

                $objPHPExcel->getActiveSheet()->getStyle('A'.$k.':P'.$k)->applyFromArray($negrita);
                
                $j = 1;
                $i++;
                $mesSimulador2 = strtoupper(strftime('%B',strtotime($listaSimulador["SIMU_fchini2"])));
            }
            
            $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A'.$i.':A'.$i);
            $objPHPExcel->setActiveSheetIndex(0)->mergeCells('B'.$i.':B'.$i);
            $objPHPExcel->setActiveSheetIndex(0)->mergeCells('C'.$i.':C'.$i);
            $objPHPExcel->setActiveSheetIndex(0)->mergeCells('D'.$i.':D'.$i);
            $objPHPExcel->setActiveSheetIndex(0)->mergeCells('E'.$i.':E'.$i);
            $objPHPExcel->setActiveSheetIndex(0)->mergeCells('F'.$i.':F'.$i);
            $objPHPExcel->setActiveSheetIndex(0)->mergeCells('G'.$i.':G'.$i);
            $objPHPExcel->setActiveSheetIndex(0)->mergeCells('H'.$i.':H'.$i);
            $objPHPExcel->setActiveSheetIndex(0)->mergeCells('I'.$i.':I'.$i);
            $objPHPExcel->setActiveSheetIndex(0)->mergeCells('J'.$i.':J'.$i);
            $objPHPExcel->setActiveSheetIndex(0)->mergeCells('K'.$i.':K'.$i);
            $objPHPExcel->setActiveSheetIndex(0)->mergeCells('L'.$i.':L'.$i);
            $objPHPExcel->setActiveSheetIndex(0)->mergeCells('M'.$i.':M'.$i);
            $objPHPExcel->setActiveSheetIndex(0)->mergeCells('N'.$i.':N'.$i);
            $objPHPExcel->setActiveSheetIndex(0)->mergeCells('O'.$i.':O'.$i);
            $objPHPExcel->setActiveSheetIndex(0)->mergeCells('P'.$i.':P'.$i);

            if( $listaSimulador["TRIP_id2"] != "0" ){
                $TRIP_nombre2 = $listaSimulador["TRIP_nombre2"];
                $TRIP_apellido2 = $listaSimulador["TRIP_apellido2"];
                $TRIP_num_licencia2 = $listaSimulador["TIPLIC_abreviatura2"]."".$listaSimulador["TRIP_numlicencia2"];
            }
            else {
                $TRIP_nombre2 = "---";
                $TRIP_apellido2 = "---";
                $TRIP_num_licencia2 = "---";
            }

            $SIMU_fchtraining = strtotime ( '+1 day' , strtotime ( $listaSimulador["SIMU_fchini2"] ) ) ;
            $SIMU_fchtraining = date ( 'd/m/Y' , $SIMU_fchtraining );
            $SIMU_fchcheck = strtotime ( '+2 day' , strtotime ( $listaSimulador["SIMU_fchini2"] ) ) ;
            $SIMU_fchcheck = date ( 'd/m/Y' , $SIMU_fchcheck );

            $SIMU_fchlibreIni = strtotime ( '-1 day' , strtotime ( $listaSimulador["SIMU_fchini2"] ) ) ;
            $SIMU_fchlibreIni = date ( 'd/m/Y' , $SIMU_fchlibreIni );

            $SIMU_fchlibreFin = strtotime ( '+1 day' , strtotime ( $listaSimulador["SIMU_fchfin2"] ) ) ;
            $SIMU_fchlibreFin = date ( 'd/m/Y' , $SIMU_fchlibreFin );

            $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue('A'.$i, $mesSimulador)
                        ->setCellValue('B'.$i, $j)

                        ->setCellValue('C'.$i, $listaSimulador["TRIP_nombre"]." ".$listaSimulador["TRIP_apellido"])
                        ->setCellValue('D'.$i, $listaSimulador["TIPLIC_abreviatura"]."".$listaSimulador["TRIP_numlicencia"])

                        ->setCellValue('E'.$i, $TRIP_nombre2." ".$TRIP_apellido2)
                        ->setCellValue('F'.$i, $TRIP_num_licencia2)

                        ->setCellValue('G'.$i, $SIMU_fchlibreIni)
                        ->setCellValue('H'.$i, $listaSimulador["SIMU_fchini"])
                        ->setCellValue('I'.$i, $SIMU_fchtraining)
                        ->setCellValue('J'.$i, $SIMU_fchcheck)
                        ->setCellValue('K'.$i, $listaSimulador["SIMU_fchfin"])
                        ->setCellValue('L'.$i, $SIMU_fchlibreFin)
                        ->setCellValue('M'.$i, "1115-1515")
                        ->setCellValue('N'.$i, "400")
                        ->setCellValue('O'.$i, "IDCEE")
                        ->setCellValue('P'.$i, "")
            ;
            $i++;
            $j++;
            $k = $i;
        }
        foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) {
            $objPHPExcel->setActiveSheetIndex($objPHPExcel->getIndex($worksheet));
            $sheet = $objPHPExcel->getActiveSheet();
            $cellIterator = $sheet->getRowIterator()->current()->getCellIterator();
            $cellIterator->setIterateOnlyExistingCells(true);
            /** @var PHPExcel_Cell $cell */
            foreach ($cellIterator as $cell) {
                $sheet->getColumnDimension($cell->getColumn())->setAutoSize(true);
            }
        }
        $date = date("Y-m-d");
        //echo $date;die();

        header("Content-Type: application/force-download"); 
        header("Content-Type: application/octet-stream"); 
        header("Content-Type: application/download"); 
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: inline;filename="simulador_'.$date.'.xlsx"');
        header('Cache-Control: no-cache'); 
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        
        $name = URLRUTASIMULADOR."simulador_".$date.".xlsx";
        
        $objWriter->save(str_replace(__FILE__,$name,__FILE__));
        $objWriter->save('php://output');

        exit();
    }
    

    function progrDiaxTrip_excel($fchProg){
        $programacion = new Programacion_model();
        $tripulante = new Tripulante_model();
        //$ITI_fch = $dia . '/' . $mes . '/' . $anio;

        $objPHPExcel = new PHPExcel();	
        $objPHPExcel->getProperties()->setCreator("Peruvian Airlines S.A.C.")
                                        ->setLastModifiedBy("Peruvian Airlines S.A.C.")
                                        ->setTitle("Office 2007 XLSX Test Document")
                                        ->setSubject("Office 2007 XLSX Test Document")
                                        ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
                                        ->setKeywords("office 2007 openxml php")
                                        ->setCategory("Test result file");
        $borders = 
            array(
                'borders' => array(
                    'allborders' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN,
                        'color' => array(
                            'argb' => 'FF000000'),
                    )
                ),
            );

        $style = 
            array(
                'alignment' => array(
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                )
            );
        
        $parts = explode('-',$fchProg);
        $mesProgramar = $parts[1];
        $firtDay = $programacion->data_first_month_day($mesProgramar);
        $lastDay = $programacion->data_last_month_day($mesProgramar);
        $nomMesAnio = strtoupper(strftime('%B del %Y',strtotime($fchProg)));
        
        $cantidadDia = 0;
        for($q=$firtDay;$q<=$lastDay;$q = date("Y-m-d", strtotime($q ."+ 1 days"))){
            $cantidadDia++;            
        }
        
        $Contador=0;
        $Letra='A';
        while($Contador<$cantidadDia)
        {
            $Contador++;
            $Letra++;
        }
        
        // ----------------------------------------------------- Pilotos -----------------------------------------------------
        $objPHPExcel->getActiveSheet()->setTitle('Pilotos');
        
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:'.$Letra.'1');
        $objPHPExcel->getActiveSheet()->SetCellValue('A1','PROGRAMACIÓN DE VUELOS: '.$nomMesAnio);
        
        $objPHPExcel->getDefaultStyle()->applyFromArray($style);
        //$objPHPExcel->getActiveSheet()->getStyle('A1:Q4')->applyFromArray($borders);

        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A2:A3');
        $objPHPExcel->getActiveSheet()->SetCellValue('A2','Item');
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('B2:B3');
        $objPHPExcel->getActiveSheet()->SetCellValue('B2','Tripulante');
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('C2:C3');
        $objPHPExcel->getActiveSheet()->SetCellValue('C2','TimeBT');
        
        $j = 2;
        $m = 3;
        for($q=$firtDay;$q<=$lastDay;$q = date("Y-m-d", strtotime($q ."+ 1 days"))){
            $Contador=0;
            $Letra='A';
            while($Contador<$m)
            {
                $Contador++;
                $Letra++;
            }            
            
            $nomDia = utf8_encode(strtoupper(substr(strftime('%A',strtotime($q)),0,3)));
            $Vj = explode('-',$q);
            
            $objPHPExcel->setActiveSheetIndex(0)->mergeCells($Letra.$j.':'.$Letra.$j);
            $objPHPExcel->getActiveSheet()->SetCellValue($Letra.$j,$nomDia);
            
            $objPHPExcel->setActiveSheetIndex(0)->mergeCells($Letra.($j+1).':'.$Letra.($j+1));
            $objPHPExcel->getActiveSheet()->SetCellValue($Letra.($j+1)," ".$Vj[2]);
            $m++;
        }
        
        $TIPTRIPDET_id = "1";        
        
        $objPiloto = $tripulante->listarTripulante('','',$TIPTRIPDET_id,'');
        
        $k = 4;
        $m = 1;
        foreach ($objPiloto as $listaTrip) {
            $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A'.$k.':A'.$k.'');
            $objPHPExcel->getActiveSheet()->SetCellValue('A'.$k,$m);
            
            $objPHPExcel->setActiveSheetIndex(0)->mergeCells('B'.$k.':B'.$k.'');
            $objPHPExcel->getActiveSheet()->SetCellValue('B'.$k,utf8_encode(substr($listaTrip["TRIP_apellido"],0,strpos($listaTrip["TRIP_apellido"],' '))." ".substr($listaTrip["TRIP_nombre"],0,1)."."));
            $k++;
            $m++;
        }
        
        $m = 3;
        for($q=$firtDay;$q<=$lastDay;$q = date("Y-m-d", strtotime($q ."+ 1 days"))){
            $fch_ini = $q;
            $fch_fin = $q;
            $parts = explode('-',$fch_fin);
            $mesProgramar = $parts[1];
            $fch_ini2 = $programacion->data_first_month_day($mesProgramar);
            $fch_fin2 = $programacion->data_last_month_day($mesProgramar);
            
            $objTripxDia = $programacion->listarTripxDia('',$TIPTRIPDET_id,$fch_ini,$fch_fin,$fch_ini2,$fch_fin2 );
            
            $Contador=0;
            $Letra='A';
            while($Contador<$m){
                $Contador++;
                $Letra++;
            }
            
            /*echo "<pre>".print_r($objPiloto,true)."</pre>";
            echo "<pre>".print_r($objTripxDia,true)."</pre>";die();*/
            
            foreach ($objTripxDia as $listaTripxDia) {
                $l = 4;
                
                foreach ($objPiloto as $listaTrip) {
                    $valor="";
                    $color="EEEEEE";
                    if( $listaTrip["TRIP_id"] == $listaTripxDia["TRIP_id"] ){
                        if( $listaTripxDia["AptoMedico"] != "" || $listaTripxDia["Curso"] != "" || $listaTripxDia["Chequeo"] != "" || $listaTripxDia["Simulador"] != "" || $listaTripxDia["Ausencia"] != "" || $listaTripxDia["Rutas"] != "" || $listaTripxDia["Pernocte"] != "" || $listaTripxDia["salidaPernocte"] != "" || $listaTripxDia["Libre"] != "" ){
                            
                        
                        
                        $objPHPExcel->setActiveSheetIndex(0)->mergeCells($Letra.$l.':'.$Letra.$l);
                        
                        if( $listaTripxDia["AptoMedico"] != "" ){
                            $valor = $listaTripxDia["AptoMedico"];
                            $color = 'f6695a';
                        } 
                        else if( $listaTripxDia["Curso"] != "" ){
                            $valor = $listaTripxDia["Curso"];
                            $color = 'ef9e6c';
                        } 
                        else if( $listaTripxDia["Chequeo"] != "" ){
                            $valor = $listaTripxDia["Chequeo"];
                            $color = '5ab348';
                        }
                        else if( $listaTripxDia["Simulador"] != "" ){
                            $valor = $listaTripxDia["Simulador"];                                    
                            $color = '6789f2';
                        }
                        else if( ($listaTripxDia["Libre"]) != "" ){
                            $valor = $listaTripxDia["Libre"];
                            $color = "b4f090";
                        }
                        else if( $listaTripxDia["Ausencia"] != "" ){
                            $valor = $listaTripxDia["Ausencia"];
                            if( $listaTripxDia["Ausencia"] == "LP" ){ $color = "f085ef"; }
                            if( $listaTripxDia["Ausencia"] == "VAC" ){ $color = "d7b25b"; }
                            if( $listaTripxDia["Ausencia"] == "DM" ){ $color = "f085ef"; }
                            if( $listaTripxDia["Ausencia"] == "GEST" ){ $color = "f085ef"; }
                            if( $listaTripxDia["Ausencia"] == "PJ" ){ $color = "f085ef"; }
                        }
                        else if( $listaTripxDia["Rutas"] != "" ){
                            $rutas = $listaTripxDia["Rutas"];
                            $rutaArray = explode('-',$rutas);
                            $cantRutas = count($rutaArray);
                            for ($n = 1; $n <= $cantRutas; $n++) {
                                $valor = $valor."".$rutaArray[($n-1)]."-".$rutaArray[($n)]."\n";
                                $n++;
                            }
                            $valor = substr($valor,0, -1);
                        } else {
                            $valor = 'TD';
                            $color = 'c8f5f6';
                        }
                        $objPHPExcel->getActiveSheet()
                        ->getStyle($Letra.$l,$valor)
                        ->getFill()
                        ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
                        ->getStartColor()
                        ->setRGB($color);
                        
                        $objPHPExcel->getActiveSheet()->SetCellValue($Letra.$l,$valor);
                        
                        $TimeBT = $this->conversorSegundosHoras( ($listaTripxDia["TimeBT"]*60) );
                        $objPHPExcel->setActiveSheetIndex(0)->mergeCells("C".$l.':'."C".$l);
                        $objPHPExcel->getActiveSheet()->SetCellValue("C".$l,$TimeBT);
                    }
                    }
                    $l++;
                }
            }
            $m++;
        }
        
        $cantidadDia = 3;
        for($q=$firtDay;$q<=$lastDay;$q = date("Y-m-d", strtotime($q ."+ 1 days"))){
            $cantidadDia++;            
        }
        $Contador=0;
        $Letra='A';
        while($Contador<$cantidadDia)
        {
            $Contador++;
            $Letra++;
        }
        
        $objPHPExcel->getActiveSheet()->getStyle('A1:'.$Letra.(count($objPiloto)+3))->getFont()->setSize(9);
        $objPHPExcel->getActiveSheet()->getStyle('A1:'.$Letra.(count($objPiloto)+3))->applyFromArray($borders);
        
        for($i=4;$i<=count($objPiloto)+4;$i++){
            $objPHPExcel->getActiveSheet()->getRowDimension($i)->setRowHeight(30);
        }
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(7);
        
        /*foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) {
            $objPHPExcel->setActiveSheetIndex($objPHPExcel->getIndex($worksheet));
            $sheet = $objPHPExcel->getActiveSheet();
            $cellIterator = $sheet->getRowIterator()->current()->getCellIterator();
            $cellIterator->setIterateOnlyExistingCells(true);
            // @var PHPExcel_Cell $cell
            foreach ($cellIterator as $cell) {
                $sheet->getColumnDimension($cell->getColumn())->setAutoSize(true);
            }
        }*/
        
        // ----------------------------------------------------- Copilotos -----------------------------------------------------
        $myWorkSheet = new PHPExcel_Worksheet($objPHPExcel, 'Copilotos');
        $objPHPExcel->addSheet($myWorkSheet, 2);
        
        $objPHPExcel->setActiveSheetIndex(1)->mergeCells('A1:'.$Letra.'1');
        $objPHPExcel->getActiveSheet()->SetCellValue('A1','PROGRAMACIÓN DE VUELOS: '.$nomMesAnio);
        
        $objPHPExcel->getDefaultStyle()->applyFromArray($style);
        //$objPHPExcel->getActiveSheet()->getStyle('A1:Q4')->applyFromArray($borders);

        $objPHPExcel->setActiveSheetIndex(1)->mergeCells('A2:A3');
        $objPHPExcel->getActiveSheet()->SetCellValue('A2','Item');
        $objPHPExcel->setActiveSheetIndex(1)->mergeCells('B2:B3');
        $objPHPExcel->getActiveSheet()->SetCellValue('B2','Tripulante');
        $objPHPExcel->setActiveSheetIndex(1)->mergeCells('C2:C3');
        $objPHPExcel->getActiveSheet()->SetCellValue('C2','TimeBT');
        
        $j = 2;
        $m = 3;
        for($q=$firtDay;$q<=$lastDay;$q = date("Y-m-d", strtotime($q ."+ 1 days"))){
            $Contador=0;
            $Letra='A';
            while($Contador<$m)
            {
                $Contador++;
                $Letra++;
            }            
            
            $nomDia = utf8_encode(strtoupper(substr(strftime('%A',strtotime($q)),0,3)));
            $Vj = explode('-',$q);
            
            $objPHPExcel->setActiveSheetIndex(1)->mergeCells($Letra.$j.':'.$Letra.$j);
            $objPHPExcel->getActiveSheet()->SetCellValue($Letra.$j,$nomDia);
            
            $objPHPExcel->setActiveSheetIndex(1)->mergeCells($Letra.($j+1).':'.$Letra.($j+1));
            $objPHPExcel->getActiveSheet()->SetCellValue($Letra.($j+1)," ".$Vj[2]);
            $m++;
        }
        
        $TIPTRIPDET_id = "2";        
        
        $objCopiloto = $tripulante->listarTripulante('','',$TIPTRIPDET_id,'');
        
        $k = 4;
        $m = 1;
        foreach ($objCopiloto as $listaTrip) {
            $objPHPExcel->setActiveSheetIndex(1)->mergeCells('A'.$k.':A'.$k.'');
            $objPHPExcel->getActiveSheet()->SetCellValue('A'.$k,$m);
            
            $objPHPExcel->setActiveSheetIndex(1)->mergeCells('B'.$k.':B'.$k.'');
            $objPHPExcel->getActiveSheet()->SetCellValue('B'.$k,utf8_encode(substr($listaTrip["TRIP_apellido"],0,strpos($listaTrip["TRIP_apellido"],' '))." ".substr($listaTrip["TRIP_nombre"],0,1)."."));
            $k++;
            $m++;
        }
        
        $m = 3;
        for($q=$firtDay;$q<=$lastDay;$q = date("Y-m-d", strtotime($q ."+ 1 days"))){
            $fch_ini = $q;
            $fch_fin = $q;
            $parts = explode('-',$fch_fin);
            $mesProgramar = $parts[1];
            $fch_ini2 = $programacion->data_first_month_day($mesProgramar);
            $fch_fin2 = $programacion->data_last_month_day($mesProgramar);
            
            $objTripxDia = $programacion->listarTripxDia('',$TIPTRIPDET_id,$fch_ini,$fch_fin,$fch_ini2,$fch_fin2 );
            
            $Contador=0;
            $Letra='A';
            while($Contador<$m){
                $Contador++;
                $Letra++;
            }
            
            foreach ($objCopiloto as $listaTrip) {
                $l = 4;
                
                foreach ($objTripxDia as $listaTripxDia) {
                    $valor="";
                    $color="EEEEEE";
                    if( $listaTrip["TRIP_id"] == $listaTripxDia["TRIP_id"] ){
                        $objPHPExcel->setActiveSheetIndex(1)->mergeCells($Letra.$l.':'.$Letra.$l);
                        
                        if( $listaTripxDia["AptoMedico"] != "" ){
                            $valor = $listaTripxDia["AptoMedico"];
                            $color = 'f6695a';
                        } 
                        else if( $listaTripxDia["Curso"] != "" ){
                            $valor = $listaTripxDia["Curso"];
                            $color = 'ef9e6c';
                        } 
                        else if( $listaTripxDia["Chequeo"] != "" ){
                            $valor = $listaTripxDia["Chequeo"];
                            $color = '5ab348';
                        }
                        else if( $listaTripxDia["Simulador"] != "" ){
                            $valor = $listaTripxDia["Simulador"];                                    
                            $color = '6789f2';
                        }
                        else if( $listaTripxDia["Ausencia"] != "" ){
                            $valor = $listaTripxDia["Ausencia"];
                            if( $listaTripxDia["Ausencia"] == "LP" ){ $color = "f085ef"; }
                            if( $listaTripxDia["Ausencia"] == "VAC" ){ $color = "d7b25b"; }
                            if( $listaTripxDia["Ausencia"] == "DM" ){ $color = "f085ef"; }
                            if( $listaTripxDia["Ausencia"] == "GEST" ){ $color = "f085ef"; }
                            if( $listaTripxDia["Ausencia"] == "PJ" ){ $color = "f085ef"; }
                        }
                        else if( $listaTripxDia["Rutas"] != "" ){
                            $rutas = $listaTripxDia["Rutas"];
                            $rutaArray = explode('-',$rutas);
                            $cantRutas = count($rutaArray);
                            for ($n = 1; $n <= $cantRutas; $n++) {
                                $valor = $valor."".$rutaArray[($n-1)]."-".$rutaArray[($n)]."\n";
                                $n++;
                            }
                            $valor = substr($valor,0, -1);
                        } else {
                            $valor = '---';
                        }
                        $objPHPExcel->getActiveSheet()
                        ->getStyle($Letra.$l,$valor)
                        ->getFill()
                        ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
                        ->getStartColor()
                        ->setRGB($color);
                        
                        $objPHPExcel->getActiveSheet()->SetCellValue($Letra.$l,$valor);
                        
                        $TimeBT = $this->conversorSegundosHoras( ($listaTripxDia["TimeBT"]*60) );
                        $objPHPExcel->setActiveSheetIndex(1)->mergeCells("C".$l.':'."C".$l);
                        $objPHPExcel->getActiveSheet()->SetCellValue("C".$l,$TimeBT);
                    }
                    $l++;
                }
            }
            $m++;
        }
        
        $cantidadDia = 3;
        for($q=$firtDay;$q<=$lastDay;$q = date("Y-m-d", strtotime($q ."+ 1 days"))){
            $cantidadDia++;            
        }
        $Contador=0;
        $Letra='A';
        while($Contador<$cantidadDia)
        {
            $Contador++;
            $Letra++;
        }
        
        $objPHPExcel->getActiveSheet()->getStyle('A1:'.$Letra.(count($objCopiloto)+3))->getFont()->setSize(9);
        $objPHPExcel->getActiveSheet()->getStyle('A1:'.$Letra.(count($objCopiloto)+3))->applyFromArray($borders);
        
        for($i=4;$i<=count($objCopiloto)+4;$i++){
            $objPHPExcel->getActiveSheet()->getRowDimension($i)->setRowHeight(30);
        }
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(7);
        
        // ----------------------------------------------------- JefeCabina -----------------------------------------------------
        $myWorkSheet = new PHPExcel_Worksheet($objPHPExcel, 'JefeCabina');
        $objPHPExcel->addSheet($myWorkSheet, 3);
        
        $objPHPExcel->setActiveSheetIndex(2)->mergeCells('A1:'.$Letra.'1');
        $objPHPExcel->getActiveSheet()->SetCellValue('A1','PROGRAMACIÓN DE VUELOS: '.$nomMesAnio);
        
        $objPHPExcel->getDefaultStyle()->applyFromArray($style);
        //$objPHPExcel->getActiveSheet()->getStyle('A1:Q4')->applyFromArray($borders);

        $objPHPExcel->setActiveSheetIndex(2)->mergeCells('A2:A3');
        $objPHPExcel->getActiveSheet()->SetCellValue('A2','Item');
        $objPHPExcel->setActiveSheetIndex(2)->mergeCells('B2:B3');
        $objPHPExcel->getActiveSheet()->SetCellValue('B2','Tripulante');
        $objPHPExcel->setActiveSheetIndex(2)->mergeCells('C2:C3');
        $objPHPExcel->getActiveSheet()->SetCellValue('C2','TimeBT');
        
        $j = 2;
        $m = 3;
        for($q=$firtDay;$q<=$lastDay;$q = date("Y-m-d", strtotime($q ."+ 1 days"))){
            $Contador=0;
            $Letra='A';
            while($Contador<$m)
            {
                $Contador++;
                $Letra++;
            }            
            
            $nomDia = utf8_encode(strtoupper(substr(strftime('%A',strtotime($q)),0,3)));
            $Vj = explode('-',$q);
            
            $objPHPExcel->setActiveSheetIndex(2)->mergeCells($Letra.$j.':'.$Letra.$j);
            $objPHPExcel->getActiveSheet()->SetCellValue($Letra.$j,$nomDia);
            
            $objPHPExcel->setActiveSheetIndex(2)->mergeCells($Letra.($j+1).':'.$Letra.($j+1));
            $objPHPExcel->getActiveSheet()->SetCellValue($Letra.($j+1)," ".$Vj[2]);
            $m++;
        }
        
        $TIPTRIPDET_id = "8";        
        $objJefeCabina = $tripulante->listarTripulante('','',$TIPTRIPDET_id,'');
        
        $k = 4;
        $m = 1;
        foreach ($objJefeCabina as $listaTrip) {
            $objPHPExcel->setActiveSheetIndex(2)->mergeCells('A'.$k.':A'.$k.'');
            $objPHPExcel->getActiveSheet()->SetCellValue('A'.$k,$m);
            
            $objPHPExcel->setActiveSheetIndex(2)->mergeCells('B'.$k.':B'.$k.'');
            $objPHPExcel->getActiveSheet()->SetCellValue('B'.$k,utf8_encode(substr($listaTrip["TRIP_apellido"],0,strpos($listaTrip["TRIP_apellido"],' '))." ".substr($listaTrip["TRIP_nombre"],0,1)."."));
            $k++;
            $m++;
        }
        
        $m = 3;
        for($q=$firtDay;$q<=$lastDay;$q = date("Y-m-d", strtotime($q ."+ 1 days"))){
            $fch_ini = $q;
            $fch_fin = $q;
            $parts = explode('-',$fch_fin);
            $mesProgramar = $parts[1];
            $fch_ini2 = $programacion->data_first_month_day($mesProgramar);
            $fch_fin2 = $programacion->data_last_month_day($mesProgramar);
            
            $objTripxDia = $programacion->listarTripxDia('',$TIPTRIPDET_id,$fch_ini,$fch_fin,$fch_ini2,$fch_fin2 );
            
            $Contador=0;
            $Letra='A';
            while($Contador<$m){
                $Contador++;
                $Letra++;
            }
            
            foreach ($objJefeCabina as $listaTrip) {
                $l = 4;
                
                foreach ($objTripxDia as $listaTripxDia) {
                    $valor="";
                    $color="EEEEEE";
                    if( $listaTrip["TRIP_id"] == $listaTripxDia["TRIP_id"] ){
                        $objPHPExcel->setActiveSheetIndex(2)->mergeCells($Letra.$l.':'.$Letra.$l);
                        
                        if( $listaTripxDia["AptoMedico"] != "" ){
                            $valor = $listaTripxDia["AptoMedico"];
                            $color = 'f6695a';
                        } 
                        else if( $listaTripxDia["Curso"] != "" ){
                            $valor = $listaTripxDia["Curso"];
                            $color = 'ef9e6c';
                        } 
                        else if( $listaTripxDia["Chequeo"] != "" ){
                            $valor = $listaTripxDia["Chequeo"];
                            $color = '5ab348';
                        }
                        else if( $listaTripxDia["Simulador"] != "" ){
                            $valor = $listaTripxDia["Simulador"];                                    
                            $color = '6789f2';
                        }
                        else if( $listaTripxDia["Ausencia"] != "" ){
                            $valor = $listaTripxDia["Ausencia"];
                            if( $listaTripxDia["Ausencia"] == "LP" ){ $color = "f085ef"; }
                            if( $listaTripxDia["Ausencia"] == "VAC" ){ $color = "d7b25b"; }
                            if( $listaTripxDia["Ausencia"] == "DM" ){ $color = "f085ef"; }
                            if( $listaTripxDia["Ausencia"] == "GEST" ){ $color = "f085ef"; }
                            if( $listaTripxDia["Ausencia"] == "PJ" ){ $color = "f085ef"; }
                        }
                        else if( $listaTripxDia["Rutas"] != "" ){
                            $rutas = $listaTripxDia["Rutas"];
                            $rutaArray = explode('-',$rutas);
                            $cantRutas = count($rutaArray);
                            for ($n = 1; $n <= $cantRutas; $n++) {
                                $valor = $valor."".$rutaArray[($n-1)]."-".$rutaArray[($n)]."\n";
                                $n++;
                            }
                            $valor = substr($valor,0, -1);
                        } else {
                            $valor = '---';
                        }
                        $objPHPExcel->getActiveSheet()
                        ->getStyle($Letra.$l,$valor)
                        ->getFill()
                        ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
                        ->getStartColor()
                        ->setRGB($color);
                        
                        $objPHPExcel->getActiveSheet()->SetCellValue($Letra.$l,$valor);
                        
                        $TimeBT = $this->conversorSegundosHoras( ($listaTripxDia["TimeBT"]*60) );
                        $objPHPExcel->setActiveSheetIndex(2)->mergeCells("C".$l.':'."C".$l);
                        $objPHPExcel->getActiveSheet()->SetCellValue("C".$l,$TimeBT);
                    }
                    $l++;
                }
            }
            $m++;
        }
        
        $cantidadDia = 3;
        for($q=$firtDay;$q<=$lastDay;$q = date("Y-m-d", strtotime($q ."+ 1 days"))){
            $cantidadDia++;            
        }
        $Contador=0;
        $Letra='A';
        while($Contador<$cantidadDia)
        {
            $Contador++;
            $Letra++;
        }
        
        $objPHPExcel->getActiveSheet()->getStyle('A1:'.$Letra.(count($objJefeCabina)+3))->getFont()->setSize(9);
        $objPHPExcel->getActiveSheet()->getStyle('A1:'.$Letra.(count($objJefeCabina)+3))->applyFromArray($borders);
        
        for($i=4;$i<=count($objJefeCabina)+4;$i++){
            $objPHPExcel->getActiveSheet()->getRowDimension($i)->setRowHeight(30);
        }
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(7);
        
        // ----------------------------------------------------- TripCabina -----------------------------------------------------
        $myWorkSheet = new PHPExcel_Worksheet($objPHPExcel, 'TripCabina');
        $objPHPExcel->addSheet($myWorkSheet, 4);
        
        $objPHPExcel->setActiveSheetIndex(3)->mergeCells('A1:'.$Letra.'1');
        $objPHPExcel->getActiveSheet()->SetCellValue('A1','PROGRAMACIÓN DE VUELOS: '.$nomMesAnio);
        
        $objPHPExcel->getDefaultStyle()->applyFromArray($style);
        //$objPHPExcel->getActiveSheet()->getStyle('A1:Q4')->applyFromArray($borders);

        $objPHPExcel->setActiveSheetIndex(3)->mergeCells('A2:A3');
        $objPHPExcel->getActiveSheet()->SetCellValue('A2','Item');
        $objPHPExcel->setActiveSheetIndex(3)->mergeCells('B2:B3');
        $objPHPExcel->getActiveSheet()->SetCellValue('B2','Tripulante');
        $objPHPExcel->setActiveSheetIndex(3)->mergeCells('C2:C3');
        $objPHPExcel->getActiveSheet()->SetCellValue('C2','TimeBT');
        
        $j = 2;
        $m = 3;
        for($q=$firtDay;$q<=$lastDay;$q = date("Y-m-d", strtotime($q ."+ 1 days"))){
            $Contador=0;
            $Letra='A';
            while($Contador<$m)
            {
                $Contador++;
                $Letra++;
            }            
            
            $nomDia = utf8_encode(strtoupper(substr(strftime('%A',strtotime($q)),0,3)));
            $Vj = explode('-',$q);
            
            $objPHPExcel->setActiveSheetIndex(3)->mergeCells($Letra.$j.':'.$Letra.$j);
            $objPHPExcel->getActiveSheet()->SetCellValue($Letra.$j,$nomDia);
            
            $objPHPExcel->setActiveSheetIndex(3)->mergeCells($Letra.($j+1).':'.$Letra.($j+1));
            $objPHPExcel->getActiveSheet()->SetCellValue($Letra.($j+1)," ".$Vj[2]);
            $m++;
        }
        
        $TIPTRIPDET_id = "5";        
        $objTripCabina = $tripulante->listarTripulante('','',$TIPTRIPDET_id,'');
        
        $k = 4;
        $m = 1;
        foreach ($objTripCabina as $listaTrip) {
            $objPHPExcel->setActiveSheetIndex(3)->mergeCells('A'.$k.':A'.$k.'');
            $objPHPExcel->getActiveSheet()->SetCellValue('A'.$k,$m);
            
            $objPHPExcel->setActiveSheetIndex(3)->mergeCells('B'.$k.':B'.$k.'');
            $objPHPExcel->getActiveSheet()->SetCellValue('B'.$k,utf8_encode(substr($listaTrip["TRIP_apellido"],0,strpos($listaTrip["TRIP_apellido"],' '))." ".substr($listaTrip["TRIP_nombre"],0,1)."."));
            $k++;
            $m++;
        }
        
        $m = 3;
        for($q=$firtDay;$q<=$lastDay;$q = date("Y-m-d", strtotime($q ."+ 1 days"))){
            $fch_ini = $q;
            $fch_fin = $q;
            $parts = explode('-',$fch_fin);
            $mesProgramar = $parts[1];
            $fch_ini2 = $programacion->data_first_month_day($mesProgramar);
            $fch_fin2 = $programacion->data_last_month_day($mesProgramar);
            
            $objTripxDia = $programacion->listarTripxDia('',$TIPTRIPDET_id,$fch_ini,$fch_fin,$fch_ini2,$fch_fin2 );
            
            $Contador=0;
            $Letra='A';
            while($Contador<$m){
                $Contador++;
                $Letra++;
            }
            
            foreach ($objTripCabina as $listaTrip) {
                $l = 4;
                
                foreach ($objTripxDia as $listaTripxDia) {
                    $valor="";
                    $color="EEEEEE";
                    if( $listaTrip["TRIP_id"] == $listaTripxDia["TRIP_id"] ){
                        $objPHPExcel->setActiveSheetIndex(3)->mergeCells($Letra.$l.':'.$Letra.$l);
                        
                        if( $listaTripxDia["AptoMedico"] != "" ){
                            $valor = $listaTripxDia["AptoMedico"];
                            $color = 'f6695a';
                        } 
                        else if( $listaTripxDia["Curso"] != "" ){
                            $valor = $listaTripxDia["Curso"];
                            $color = 'ef9e6c';
                        } 
                        else if( $listaTripxDia["Chequeo"] != "" ){
                            $valor = $listaTripxDia["Chequeo"];
                            $color = '5ab348';
                        }
                        else if( $listaTripxDia["Simulador"] != "" ){
                            $valor = $listaTripxDia["Simulador"];                                    
                            $color = '6789f2';
                        }
                        else if( $listaTripxDia["Ausencia"] != "" ){
                            $valor = $listaTripxDia["Ausencia"];
                            if( $listaTripxDia["Ausencia"] == "LP" ){ $color = "f085ef"; }
                            if( $listaTripxDia["Ausencia"] == "VAC" ){ $color = "d7b25b"; }
                            if( $listaTripxDia["Ausencia"] == "DM" ){ $color = "f085ef"; }
                            if( $listaTripxDia["Ausencia"] == "GEST" ){ $color = "f085ef"; }
                            if( $listaTripxDia["Ausencia"] == "PJ" ){ $color = "f085ef"; }
                        }
                        else if( $listaTripxDia["Rutas"] != "" ){
                            $rutas = $listaTripxDia["Rutas"];
                            $rutaArray = explode('-',$rutas);
                            $cantRutas = count($rutaArray);
                            for ($n = 1; $n <= $cantRutas; $n++) {
                                $valor = $valor."".$rutaArray[($n-1)]."-".$rutaArray[($n)]."\n";
                                $n++;
                            }
                            $valor = substr($valor,0, -1);
                        } else {
                            $valor = '---';
                        }
                        $objPHPExcel->getActiveSheet()
                        ->getStyle($Letra.$l,$valor)
                        ->getFill()
                        ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
                        ->getStartColor()
                        ->setRGB($color);
                        
                        $objPHPExcel->getActiveSheet()->SetCellValue($Letra.$l,$valor);
                        
                        $TimeBT = $this->conversorSegundosHoras( ($listaTripxDia["TimeBT"]*60) );
                        $objPHPExcel->setActiveSheetIndex(3)->mergeCells("C".$l.':'."C".$l);
                        $objPHPExcel->getActiveSheet()->SetCellValue("C".$l,$TimeBT);
                    }
                    $l++;
                }
            }
            $m++;
        }
        
        $cantidadDia = 3;
        for($q=$firtDay;$q<=$lastDay;$q = date("Y-m-d", strtotime($q ."+ 1 days"))){
            $cantidadDia++;            
        }
        $Contador=0;
        $Letra='A';
        while($Contador<$cantidadDia)
        {
            $Contador++;
            $Letra++;
        }
        
        $objPHPExcel->getActiveSheet()->getStyle('A1:'.$Letra.(count($objTripCabina)+3))->getFont()->setSize(9);
        $objPHPExcel->getActiveSheet()->getStyle('A1:'.$Letra.(count($objTripCabina)+3))->applyFromArray($borders);
        
        for($i=4;$i<=count($objTripCabina)+4;$i++){
            $objPHPExcel->getActiveSheet()->getRowDimension($i)->setRowHeight(30);
        }
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(7);
        
        header("Content-Type: application/force-download"); 
        header("Content-Type: application/octet-stream"); 
        header("Content-Type: application/download"); 
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: inline;filename="ProgramaciónxTrip.xlsx"');
        header('Cache-Control: no-cache'); 
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');

        exit();
    }
}
?>