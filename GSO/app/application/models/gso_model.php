<?php
class Gso_Model extends CI_Model {
	/*************
	** Reportes **
	**************/
	/*
	** Grilla de Procesos
	*/
	
	/*function listaReporte($estado,$Pro_ID=NULL, $SubPro_ID=NULL){
		$db_admin = $this->load->database('db_admin', TRUE);		
		if(!is_null($Pro_ID)){
			$db_admin->where_in('r.SubPro_ID',$SubPro_ID);			
			$db_admin->where_in('r.Pro_ID',$Pro_ID);
			$db_admin->where_in('r.Rep_Estado',$estado);
		}else{
			$db_admin->where_in('r.Rep_Estado',$estado);
		}
		$db_admin->join('gso_subproceso sp','sp.SubPro_ID=r.SubPro_ID','LEFT');
		$db_admin->join('gso_proceso p','p.Pro_ID=r.Pro_ID','LEFT');
		$db_admin->order_by('r.Rep_Id','DESC');
		return $db_admin->get('gso_reporte r')->result();
	}*/
	
		function listaReporte($estado,$Pro_ID=NULL, $SubPro_ID=NULL){
		$db_admin = $this->load->database('db_admin', TRUE);
		$db_admin->select(" GROUP_CONCAT(distinct concat_ws(' ',u.nombre,u.apellido)) as nombre",FALSE);
		
		//$db_admin->select('GROUP_CONCAT(product_type.tName SEPARATOR ",") as product_type.tName', FALSE);
		$db_admin->select('r.*');
		$db_admin->select('sp.*');
		$db_admin->select('p.*');
		$db_admin->select('h.*');		
		if(!is_null($Pro_ID)){
			$db_admin->where_in('r.SubPro_ID',$SubPro_ID);			
			$db_admin->where_in('r.Pro_ID',$Pro_ID);
			$db_admin->where_in('r.Rep_Estado',$estado);
		}else{
			$db_admin->where_in('r.Rep_Estado',$estado);
		}
		
		$db_admin->join('gso_subproceso sp','sp.SubPro_ID=r.SubPro_ID','LEFT');
		$db_admin->join('gso_proceso p','p.Pro_ID=r.Pro_ID','LEFT');
		$db_admin->join('gso_responsable h','h.Pro_ID=r.Pro_ID and h.SubPro_ID=r.SubPro_ID','LEFT');
		$db_admin->join('db_admin.usuario u','u.idusuario= h.idusuario','LEFT');
	    $db_admin->group_by('r.Rep_Id');
		$db_admin->order_by('r.Rep_Fecha','DESC');
		
		return $db_admin->get('gso_reporte r')->result();
	}
	
	/*************************************
	**        Filtro para Procesos      **
	**      Procesos y Sub Procesos     **
	** Para la Creación de los CheckBox ****
	**************************************/
	/*
	** Proceso
	*/
	function filtrarReporteProceso($estado){
		$db_admin = $this->load->database('db_admin', TRUE);
		$db_admin->select('p.Pro_Abreviatura');
		$db_admin->join('gso_proceso p','p.Pro_ID=r.Pro_ID','LEFT');	
		$db_admin->where_in('r.Rep_Estado',$estado);
		$db_admin->group_by('p.Pro_Abreviatura');
		return $db_admin->get('gso_reporte r')->result();
	}
	/*
	** Sub Proceso
	*/
	function filtrarReporteSubProceso($estado){
		$db_admin = $this->load->database('db_admin', TRUE);
		$db_admin->select('sp.SubPro_Abreviatura');
		$db_admin->join('gso_subproceso sp','sp.SubPro_ID=r.SubPro_ID','LEFT');
		$db_admin->where_in('r.Rep_Estado',$estado);
		$db_admin->group_by('sp.SubPro_Abreviatura');
		return $db_admin->get('gso_reporte r')->result();
	}
	
	
	
	
	
	
	/*
	** Lista Usuario
	*/
	function listaUsuario(){
		$db_admin = $this->load->database('db_admin', TRUE);
		$db_admin->where('activo','1');
		return $db_admin->get('usuario')->result();
	}
	/*
	** Data Usuario
	*/
	function dataUsuario($id){
		$db_admin = $this->load->database('db_admin', TRUE);
		$db_admin->where('activo','1');
		$db_admin->where('idusuario',$id);
		return $db_admin->get('usuario')->row();
	}
	function secciones($id){
		$db_admin = $this->load->database('db_admin', TRUE);
		$db_admin->where('Sec_Id',$id);
		return $db_admin->get('gso_secciones')->row();
	}
	function listaSubCategoria($categoria){
		$db_admin = $this->load->database('db_admin', TRUE);
		$db_admin->where('SubCat_Estado','1');
		$db_admin->where('Cat_ID',$categoria);	
		return $db_admin->get('gso_subcategoria')->result();
	}
	/*
	** Reporte
	*/
	
	/*
	** Dato Reporte
	*/
	function datoReporte($id){
		$db_admin = $this->load->database('db_admin', TRUE);
		$db_admin->where('Rep_Id',$id);
		return $db_admin->get('gso_reporte')->row();
	}
	/*
	** Lista Códigos para los reportes
	*/
	function listaCodigo(){
		$db_admin = $this->load->database('db_admin', TRUE);
		$db_admin->where('Cod_Estado','1');
		return $db_admin->get('gso_codigo')->result();
	}
	/*
	** Buscar Código
	*/
	function buscarCodigo($id){
		$db_admin	=	$this->load->database('db_admin',TRUE);
		$db_admin->where('Cod_ID',$id);
		return $db_admin->get('gso_codigo')->row();
	}
	/*
	** Editar Reporte
	*/
	/*
	** Editar Sub Proceso
	*/
	function editarReporte($id,$arrayReporte){
		$db_admin = $this->load->database('db_admin', TRUE);
		$db_admin->where('Rep_ID',$id);
		$db_admin->update('gso_reporte',$arrayReporte);
		return 1;
	}
	function eliminarReporte($id,$arrayReporte){
		$db_admin = $this->load->database('db_admin', TRUE);
		$db_admin->where('Rep_ID',$id);
		$db_admin->update('gso_reporte',$arrayReporte);
		return 1;
	
	}
	
	
		function pasaraIOSA($id,$arrayReporte){
		$db_admin = $this->load->database('db_admin', TRUE);
		$db_admin->where('Rep_ID',$id);
		$db_admin->update('gso_reporte',$arrayReporte);
		return 1;
		
		/*
		$db_admin = $this->load->database('db_admin2', TRUE);		
		$db_admin->insert('gso_reporte', $dataReporte); 
		return $db_admin->insert_id();*/
		
	}
	
	
	
	function crearSeccionesReporte($id){
		$db_admin = $this->load->database('db_admin', TRUE);
		for($s=3;$s<=6;$s++){
			$data	=	array(
							'Rep_ID'	=>	$id,
							'Sec_ID'	=>	$s
						);
			$db_admin->insert('gso_rep_sec', $data); 
		}		
	}
	function reporteSeccion($id,$arrayIn=NULL){
		$db_admin	=	$this->load->database('db_admin', TRUE);
		$db_admin->join('gso_secciones s','s.Sec_ID=rs.Sec_ID','LEFT');
		$db_admin->where('rs.Rep_Id',$id);
		$db_admin->group_by('s.Sec_ID');
		if(!is_null($arrayIn)){
			$db_admin->where_in('s.Sec_Tipo',$arrayIn);
		}
		return $db_admin->get('gso_rep_sec rs')->result();
	}
	
	
	/*
	** Valida si el codigo existe
	*/
	function validadorCodigoReporte($codigo){
		$db_admin = $this->load->database('db_admin', TRUE);
		$db_admin->where('Rep_Codigo',$codigo);
		$data	=	$db_admin->get('gso_reporte')->result();
		if(count($data)==0){
			return 0;
		}else{
			return 1;
		}
	}

	function grabarReporte($dataReporte){
		$db_admin = $this->load->database('db_admin', TRUE);		
		$db_admin->insert('gso_reporte', $dataReporte); 
		return $db_admin->insert_id();
	}



        function grabarReporte2($dataReporte){
		$db_admin = $this->load->database('db_admin2', TRUE);		
		$db_admin->insert('gso_reporte', $dataReporte); 
		return $db_admin->insert_id();
	}


	/*
	** Procesos
	*/
	function listaProcesos(){
		$db_admin = $this->load->database('db_admin', TRUE);
		$db_admin->where('Pro_Estado','1');
		$db_admin->order_by('Pro_ID','DESC');
		return $db_admin->get('gso_proceso')->result();
	}	
	/*
	** Grabar Proceso
	*/
	function grabarProceso($arrayProceso){
		$db_admin = $this->load->database('db_admin', TRUE);
		$db_admin->insert('gso_proceso',$arrayProceso);
		return $db_admin->insert_id();
	}


	/*
	** Editar Proceso
	*/
	function editarProceso($id,$arrayProceso){
		$db_admin = $this->load->database('db_admin', TRUE);
		$db_admin->where('Pro_ID',$id);
		$db_admin->update('gso_proceso',$arrayProceso);
		return 1;
	}
	/*
	** Dato Proceso
	*/
	function datoProceso($id){
		$db_admin = $this->load->database('db_admin', TRUE);
		$db_admin->where('Pro_ID',$id);
		return $db_admin->get('gso_proceso')->row();
	}
	/*
	** Funcion Repetidos
	*/
	function datosRepetidos($query){
		$db_admin = $this->load->database('db_admin', TRUE);
		return $db_admin->query($query)->row()->Contador;
	}
	/*
	** Sub Procesos
	*/	
	function listaSubProcesos($id=NULL){
		$db_admin = $this->load->database('db_admin', TRUE);
		if(!is_null($id)){
			$db_admin->where('sp.Pro_ID',$id);
		}
		$db_admin->where('sp.SubPro_Estado','1');
		$db_admin->order_by('sp.SubPro_ID','DESC');
		$db_admin->join('gso_proceso p','p.Pro_Id=sp.Pro_Id','LEFT');
		return $db_admin->get('gso_subproceso sp')->result();
	}
	/*
	**	Grabar Proceso
	*/
	function grabarSubProceso($arraySubProceso){
		$db_admin = $this->load->database('db_admin', TRUE);
		$db_admin->insert('gso_subproceso',$arraySubProceso);
		return $db_admin->insert_id();
	}
	/*
	** Dato Sub Proceso
	*/
	function datoSubProceso($id){
		$db_admin = $this->load->database('db_admin', TRUE);
		$db_admin->where('SubPro_ID',$id);
		return $db_admin->get('gso_subproceso')->row();
	}
	/*
	** Editar Sub Proceso
	*/
	function editarSubProceso($id,$arraySubProceso){
		$db_admin = $this->load->database('db_admin', TRUE);
		$db_admin->where('SubPro_ID',$id);
		$db_admin->update('gso_subproceso',$arraySubProceso);
		return 1;
	}
	/*
	** Aspectos
	*/
	function listaSubcategorias(){
		$db_admin = $this->load->database('db_admin', TRUE);
		$db_admin->where('c.Cat_ID',1);
		$db_admin->join('gso_categoria c','c.Cat_ID=sc.Cat_ID','LEFT');
		$db_admin->order_by('Pro_ID','DESC');
		return $db_admin->get('gso_subcategoria sc')->result();
	}
	/*
	** Lista Responsables
	*/
	function listaResponsables(){
		$db_admin = $this->load->database('db_admin', TRUE);
		$db_admin->join('usuario u','r.idusuario=u.idusuario','LEFT');
		$db_admin->join('gso_proceso p','p.Pro_ID=r.Pro_ID','LEFT');
		$db_admin->join('gso_subproceso sp','sp.SubPro_ID=r.SubPro_ID','LEFT');
		$db_admin->where('r.Res_Estado',1);
		return $db_admin->get('gso_responsable r')->result();
	}
	/*
	** Responsable por Categoria
	*/
	function listaResponsablesProceso($id){
		$db_admin = $this->load->database('db_admin', TRUE);
		$db_admin->where('r.idusuario',$id);
		$db_admin->where_in('r.Res_Estado',1);
		return $db_admin->get('gso_responsable r')->result();
	}
	/*
	** Reporte por Responsable
	*/
	function listaResponsablesReporte($Pro_ID,$SubPro_ID){
		$db_admin = $this->load->database('db_admin', TRUE);
		$db_admin->where('r.Pro_ID',$Pro_ID);
		$db_admin->where('r.SubPro_ID',$SubPro_ID);
		$db_admin->where('r.Rep_Estado',1);
		return $db_admin->get('gso_reporte r')->result();
	}
	/*
	** Correo de Responsables
	*/
	function dataCorreoResponsables($ProId,$subProId){
		$db_admin = $this->load->database('db_admin', TRUE);
		$db_admin->where('r.Pro_ID',$ProId);
		$db_admin->where('r.SubPro_ID',$subProId);
		return $db_admin->get('gso_responsable r')->result();
	}
	/*
	** UTILITARIOS
	*/
	function haySubproceso($idProceso){
		$db_admin = $this->load->database('db_admin', TRUE);
		$db_admin->where('Pro_Id',$idProceso);
		$db_admin->where('SubPro_Estado',1);
		return $db_admin->get('gso_subproceso')->result();
	}
	/*
	** Grabar Secciones Reporte
	*/
	function grabarSeccionesReporte($id,$arraySeccion){
		$db_admin = $this->load->database('db_admin', TRUE);
		$db_admin->where('RepSec_ID',$id);
		$db_admin->update('gso_rep_sec',$arraySeccion);
		return 1;
	}	
	/*
	** Grabar Responsable
	*/
	function grabarResponsable($arrayResponsable){
		$db_admin = $this->load->database('db_admin', TRUE);		
		$db_admin->insert('gso_responsable', $arrayResponsable);
		$str = $this->db->last_query();
		return $str; 
		//return $db_admin->insert_id();
	}
	/*
	** Editar Responsable
	*/
	function editarResponsable($id,$arrayResponsable){
		$db_admin = $this->load->database('db_admin', TRUE);
		$db_admin->where('Res_Id',$id);
		$db_admin->update('gso_responsable',$arrayResponsable);
		return 1;
	}
    /*
	** Dato Responsable
	*/
	function datoResponsable($id){
		$db_admin = $this->load->database('db_admin', TRUE);
		$db_admin->where('Res_Id',$id);
		return $db_admin->get('gso_responsable')->row();
	}
	/*
	** Lista códigos 
	*/
	function listaCodigos(){
		$db_admin = $this->load->database('db_admin', TRUE);
		$db_admin->join('gso_proceso p','p.Pro_ID=c.Pro_ID','LEFT');
		$db_admin->join('gso_subproceso sp','sp.SubPro_ID=c.SubPro_ID','LEFT');
		$db_admin->where('c.Cod_Estado',1);
		
		return $db_admin->get('gso_codigo c')->result();
	}
	/*
	** Grabar Codigo
	*/
	function grabarCodigo($arrayCodigo){
		$db_admin = $this->load->database('db_admin', TRUE);		
		$db_admin->insert('gso_codigo', $arrayCodigo); 
		return $db_admin->insert_id();
	}
	/*
	** Editar Responsable
	*/
	function editarCodigo($id,$arrayCodigo){
		$db_admin = $this->load->database('db_admin', TRUE);
		$db_admin->where('Cod_ID',$id);
		$db_admin->update('gso_codigo',$arrayCodigo);
		return 1;
	}
	/*
	** Dato Código
	*/
	function datoCodigo($id){
		$db_admin = $this->load->database('db_admin', TRUE);
		$db_admin->where('Cod_ID',$id);
		return $db_admin->get('gso_codigo')->row();
	}
	
	/*
	** Lista Secciones
	*/
	function listaSecciones(){
		$db_admin = $this->load->database('db_admin', TRUE);
		$db_admin->where('s.Sec_Estado',1);
		return $db_admin->get('gso_secciones s')->result();
	}
	/*
	** dato Seccion
	*/
	function datoSeccion($id){
		$db_admin = $this->load->database('db_admin', TRUE);
		$db_admin->where('Sec_ID',$id);
		return $db_admin->get('gso_secciones')->row();
	}
	/*
	** editar seccion
	*/
	function editarSeccion($id,$arraySeccion){
		$db_admin = $this->load->database('db_admin', TRUE);
		$db_admin->where('Sec_ID',$id);
		$db_admin->update('gso_secciones',$arraySeccion);
		return 1;
	}
	/*
	** dato Sub Categoria
	*/
	function datoSubCategoria($id){
		$db_admin = $this->load->database('db_admin', TRUE);
		$db_admin->where('SubCat_ID',$id);
		return $db_admin->get('gso_subcategoria')->row();
	}	
	/*
	** editar Sub categoria
	*/
	function editarSubCategoria($id,$arraySubCategoria){
		$db_admin = $this->load->database('db_admin', TRUE);
		$db_admin->where('SubCat_ID',$id);
		$db_admin->update('gso_subcategoria',$arraySubCategoria);
		return 1;
	}
	/*
	** Grabar Sub Categoria
	*/
	function grabarSubCategoria($arraySubCategoria){
		$db_admin = $this->load->database('db_admin', TRUE);		
		$db_admin->insert('gso_subcategoria', $arraySubCategoria); 
		return $db_admin->insert_id();
	}
	/*
	** Verificar Codigo
	*/
	function verificarCodigo($codigo){
		$db_admin = $this->load->database('db_admin', TRUE);
		$db_admin->where('Rep_Codigo',$codigo);
		$db_admin->order_by('Rep_ID','DESC');
		$db_admin->limit('1');	
		return $db_admin->get('gso_reporte')->row();		
	}
	
	/*---------------------estadisticas----------------------------------------------*/
	function listaProcesosEst(){
	    $db_admin = $this->load->database('db_admin', TRUE);
		$db_admin->where('Pro_Estado','1');
		$db_admin->order_by('Pro_ID','DESC');
		return $db_admin->get('gso_proceso')->result();
	}
	
	
	// Lista Responsables
	
	function listaResponsables_EST(){
		$db_admin = $this->load->database('db_admin', TRUE);
		$db_admin->join('usuario u','r.idusuario=u.idusuario','LEFT');
		$db_admin->join('gso_proceso p','p.Pro_ID=r.Pro_ID','LEFT');
		$db_admin->join('gso_subproceso sp','sp.SubPro_ID=r.SubPro_ID','LEFT');
		$db_admin->where('r.Res_Estado',1);
		$db_admin->group_by('u.idusuario');
		$db_admin->order_by('apellido','ASC');
		$db_admin->order_by('nombre','ASC');
	
		return $db_admin->get('gso_responsable r')->result();
		
	
	}
	
	
	
	function listaProcesoporDia_EST($var_ano,$var_pro){

		$db_admin = $this->load->database('db_admin', TRUE);
		$db_admin->SET("lc_time_names = 'es_ES'");
		$db_admin->select('MONTHNAME(Rep_Fecha) as Rep_Fechav');
		$db_admin->select('month(Rep_Fecha) as ddmes');
		$db_admin->select('(select count(r.Pro_ID) as Pro_ID from gso_reporte r  WHERE r.Rep_Estado=0 and month(r.Rep_Fecha)=month(g.Rep_Fecha) and year(r.Rep_Fecha)=year(g.Rep_Fecha) and r.Pro_ID=g.Pro_ID and r.Pro_ID='.$var_pro.') as cero');
		$db_admin->select('(select count(r.Pro_ID) as Pro_ID from gso_reporte r  WHERE r.Rep_Estado=1 and month(r.Rep_Fecha)=month(g.Rep_Fecha) and year(r.Rep_Fecha)=year(g.Rep_Fecha) and r.Pro_ID=g.Pro_ID and r.Pro_ID='.$var_pro.') as uno');
		$db_admin->select('(select count(r.Pro_ID) as Pro_ID from gso_reporte r  WHERE r.Rep_Estado=2 and month(r.Rep_Fecha)=month(g.Rep_Fecha) and year(r.Rep_Fecha)=year(g.Rep_Fecha) and r.Pro_ID=g.Pro_ID and r.Pro_ID='.$var_pro.') as dos');
        $db_admin->select('(select count(r.Pro_ID) as Pro_ID from gso_reporte r  WHERE r.Rep_Estado=3 and month(r.Rep_Fecha)=month(g.Rep_Fecha) and year(r.Rep_Fecha)=year(g.Rep_Fecha) and r.Pro_ID=g.Pro_ID and r.Pro_ID='.$var_pro.') as tres');
        //$db_admin->select('(select count(r.Pro_ID) as Pro_ID from gso_reporte r  WHERE  r.Rep_Estado=4 and month(r.Rep_Fecha)=month(g.Rep_Fecha)and r.Pro_ID=g.Pro_ID) as cuatro');
		//$db_admin->select('(select count(r.Pro_ID) as Pro_ID from gso_reporte r  WHERE  r.Rep_Estado=5 and month(r.Rep_Fecha)=month(g.Rep_Fecha) and r.Pro_ID=g.Pro_ID) as cinco');
        $db_admin->select('(select count(r.Pro_ID) as Pro_ID from gso_reporte r  WHERE  r.Rep_Estado=6 and month(r.Rep_Fecha)=month(g.Rep_Fecha) and year(r.Rep_Fecha)=year(g.Rep_Fecha) and r.Pro_ID=g.Pro_ID and r.Pro_ID='.$var_pro.') as seis');
        //$db_admin->select('(select count(r.Pro_ID) as Pro_ID from gso_reporte r  WHERE  r.Rep_Estado=7 and month(r.Rep_Fecha)=month(g.Rep_Fecha) and r.Pro_ID=g.Pro_ID) as siete');
		/*$db_admin->join('usuario u','r.idusuario=u.idusuario','LEFT');
		$db_admin->join('gso_proceso p','p.Pro_ID=r.Pro_ID','LEFT');
		$db_admin->join('gso_subproceso sp','sp.SubPro_ID=r.SubPro_ID','LEFT');*/
		$db_admin->where('year(g.Rep_Fecha)',$var_ano);
		$db_admin->where('g.Pro_ID',$var_pro);
		/*$db_admin->where('Rep_Estado',3);*/
		$db_admin->group_by('month(g.Rep_Fecha)');
		$db_admin->order_by('month(g.Rep_Fecha)','ASC');
		//$db_admin->order_by('nombre','ASC');
	
		return $db_admin->get('gso_reporte g')->result();
		
	
	}


	function listaProcesoporDia_EST_sub($var_ano,$var_pro,$var_subpro_real){

		$db_admin = $this->load->database('db_admin', TRUE);
		$db_admin->SET("lc_time_names = 'es_ES'");
		$db_admin->select('MONTHNAME(Rep_Fecha) as Rep_Fechav');
		$db_admin->select('month(Rep_Fecha) as ddmes');
		$db_admin->select('(select count(*) as Pro_ID from gso_reporte r  WHERE r.Rep_Estado=0 and month(r.Rep_Fecha)=month(g.Rep_Fecha) and year(r.Rep_Fecha)=year(g.Rep_Fecha) and r.Pro_ID=g.Pro_ID and r.SubPro_ID=g.SubPro_ID  ) as cero');
		$db_admin->select('(select count(*) as Pro_ID from gso_reporte r  WHERE r.Rep_Estado=1 and month(r.Rep_Fecha)=month(g.Rep_Fecha) and year(r.Rep_Fecha)=year(g.Rep_Fecha) and r.Pro_ID=g.Pro_ID and r.SubPro_ID=g.SubPro_ID  ) as uno');
		$db_admin->select('(select count(*) as Pro_ID from gso_reporte r  WHERE r.Rep_Estado=2 and month(r.Rep_Fecha)=month(g.Rep_Fecha) and year(r.Rep_Fecha)=year(g.Rep_Fecha) and r.Pro_ID=g.Pro_ID and r.SubPro_ID=g.SubPro_ID  ) as dos');
        $db_admin->select('(select count(*) as Pro_ID from gso_reporte r  WHERE r.Rep_Estado=3 and month(r.Rep_Fecha)=month(g.Rep_Fecha) and year(r.Rep_Fecha)=year(g.Rep_Fecha) and r.Pro_ID=g.Pro_ID and r.SubPro_ID=g.SubPro_ID  ) as tres');
        $db_admin->select('(select count(*) as Pro_ID from gso_reporte r  WHERE r.Rep_Estado=4 and month(r.Rep_Fecha)=month(g.Rep_Fecha) and year(r.Rep_Fecha)=year(g.Rep_Fecha) and r.Pro_ID=g.Pro_ID and r.SubPro_ID=g.SubPro_ID  ) as cuatro');
		$db_admin->select('(select count(*) as Pro_ID from gso_reporte r  WHERE r.Rep_Estado=5 and month(r.Rep_Fecha)=month(g.Rep_Fecha) and year(r.Rep_Fecha)=year(g.Rep_Fecha) and r.Pro_ID=g.Pro_ID and r.SubPro_ID=g.SubPro_ID  ) as cinco');
        $db_admin->select('(select count(*) as Pro_ID from gso_reporte r  WHERE r.Rep_Estado=6 and month(r.Rep_Fecha)=month(g.Rep_Fecha) and year(r.Rep_Fecha)=year(g.Rep_Fecha) and r.Pro_ID=g.Pro_ID and r.SubPro_ID=g.SubPro_ID  ) as seis');
        $db_admin->select('(select count(*) as Pro_ID from gso_reporte r  WHERE r.Rep_Estado=7 and month(r.Rep_Fecha)=month(g.Rep_Fecha) and year(r.Rep_Fecha)=year(g.Rep_Fecha) and r.Pro_ID=g.Pro_ID and r.SubPro_ID=g.SubPro_ID  ) as siete');
		$db_admin->where('year(g.Rep_Fecha)',$var_ano);
		$db_admin->where('g.SubPro_ID',$var_subpro_real);
		$db_admin->where('g.Pro_ID',$var_pro);
		$db_admin->group_by('month(g.Rep_Fecha)');
		$db_admin->order_by('month(g.Rep_Fecha)','ASC');		
		return $db_admin->get('gso_reporte g')->result();
		
	
	}
	
		function listaProcesoporDia_EST_all($var_ano){
			
				$db_admin = $this->load->database('db_admin', TRUE);
		        $db_admin->SET("lc_time_names = 'es_ES'");				
				$db_admin->select('CONVERT(MONTHNAME(Rep_Fecha) USING utf8) as Rep_Fechav');
		        $db_admin->select('month(Rep_Fecha) as ddmes');
		        $db_admin->select('(select count(*) as Pro_ID from gso_reporte r  WHERE r.Rep_Estado=0 and month(r.Rep_Fecha)=month(g.Rep_Fecha) and year(r.Rep_Fecha)=year(g.Rep_Fecha)  ) as cero');
		        $db_admin->select('(select count(*) as Pro_ID from gso_reporte r  WHERE r.Rep_Estado=1 and month(r.Rep_Fecha)=month(g.Rep_Fecha) and year(r.Rep_Fecha)=year(g.Rep_Fecha)  ) as uno');
		        $db_admin->select('(select count(*) as Pro_ID from gso_reporte r  WHERE r.Rep_Estado=2 and month(r.Rep_Fecha)=month(g.Rep_Fecha) and year(r.Rep_Fecha)=year(g.Rep_Fecha)  ) as dos');
		        $db_admin->select('(select count(*) as Pro_ID from gso_reporte r  WHERE r.Rep_Estado=3 and month(r.Rep_Fecha)=month(g.Rep_Fecha) and year(r.Rep_Fecha)=year(g.Rep_Fecha)  ) as tres');
				$db_admin->select('(select count(*) as Pro_ID from gso_reporte r  WHERE r.Rep_Estado=4 and month(r.Rep_Fecha)=month(g.Rep_Fecha) and year(r.Rep_Fecha)=year(g.Rep_Fecha)  ) as cuatro');
				$db_admin->select('(select count(*) as Pro_ID from gso_reporte r  WHERE r.Rep_Estado=5 and month(r.Rep_Fecha)=month(g.Rep_Fecha) and year(r.Rep_Fecha)=year(g.Rep_Fecha)  ) as cinco');
				$db_admin->select('(select count(*) as Pro_ID from gso_reporte r  WHERE r.Rep_Estado=6 and month(r.Rep_Fecha)=month(g.Rep_Fecha) and year(r.Rep_Fecha)=year(g.Rep_Fecha)  ) as seis');
				$db_admin->select('(select count(*) as Pro_ID from gso_reporte r  WHERE r.Rep_Estado=7 and month(r.Rep_Fecha)=month(g.Rep_Fecha) and year(r.Rep_Fecha)=year(g.Rep_Fecha)  ) as siete');
		       	// $db_admin->from('gso_reporte g');
				$db_admin->where('year(g.Rep_Fecha)',$var_ano);
				$db_admin->group_by('month(g.Rep_Fecha)');
		        $db_admin->order_by('month(g.Rep_Fecha) ASC');		
				return $db_admin->get('gso_reporte g')->result();
			}
	

	
	
	
	
		function listarSubProceso($var_subpro){
				$db_admin = $this->load->database('db_admin', TRUE);
				$db_admin->select('sp.SubPro_Abreviatura');
				$db_admin->select('sp.SubPro_Descripcion');
				$db_admin->select('sp.SubPro_ID');
				$db_admin->join('gso_subproceso sp','sp.SubPro_ID=r.SubPro_ID','LEFT');
				$db_admin->where_in('sp.SubPro_Estado',1);
				$db_admin->where_in('r.Pro_ID',$var_subpro);
				$db_admin->group_by('sp.SubPro_Abreviatura');
				return $db_admin->get('gso_reporte r')->result();
		
	    }
	
	/*-------------------------------------------------------------------------------*/
	
}
