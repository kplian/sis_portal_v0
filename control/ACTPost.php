<?php
/**
*@package pXP
*@file gen-ACTPost.php
*@author  (admin)
*@date 20-09-2015 18:43:35
*@description Clase que recibe los parametros enviados por la vista para mandar a la capa de Modelo
*/

class ACTPost extends ACTbase{    
			
	function listarPost(){
		$this->objParam->defecto('ordenacion','id_post');

		$this->objParam->defecto('dir_ordenacion','asc');


		if($this->objParam->getParametro('id_post')!=''){
			$this->objParam->addFiltro("pos.id_post = ''".$this->objParam->getParametro('id_post')."''");
		}

		if($this->objParam->getParametro('tipoReporte')=='excel_grid' || $this->objParam->getParametro('tipoReporte')=='pdf_grid'){
			$this->objReporte = new Reporte($this->objParam,$this);
			$this->res = $this->objReporte->generarReporteListado('MODPost','listarPost');
		} else{
			$this->objFunc=$this->create('MODPost');
			
			$this->res=$this->objFunc->listarPost($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
				
	function insertarPost(){
		$this->objFunc=$this->create('MODPost');	
		if($this->objParam->insertar('id_post')){
			$this->res=$this->objFunc->insertarPost($this->objParam);			
		} else{			
			$this->res=$this->objFunc->modificarPost($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
						
	function eliminarPost(){
			$this->objFunc=$this->create('MODPost');	
		$this->res=$this->objFunc->eliminarPost($this->objParam);
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
			
}

?>