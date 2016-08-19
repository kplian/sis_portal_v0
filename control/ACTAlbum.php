<?php
/**
*@package pXP
*@file gen-ACTAlbum.php
*@author  (admin)
*@date 24-09-2015 18:53:01
*@description Clase que recibe los parametros enviados por la vista para mandar a la capa de Modelo
*/

class ACTAlbum extends ACTbase{    
			
	function listarAlbum(){
		$this->objParam->defecto('ordenacion','id_album');

		$this->objParam->defecto('dir_ordenacion','asc');
		if($this->objParam->getParametro('tipoReporte')=='excel_grid' || $this->objParam->getParametro('tipoReporte')=='pdf_grid'){
			$this->objReporte = new Reporte($this->objParam,$this);
			$this->res = $this->objReporte->generarReporteListado('MODAlbum','listarAlbum');
		} else{
			$this->objFunc=$this->create('MODAlbum');
			
			$this->res=$this->objFunc->listarAlbum($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
				
	function insertarAlbum(){
		$this->objFunc=$this->create('MODAlbum');	
		if($this->objParam->insertar('id_album')){
			$this->res=$this->objFunc->insertarAlbum($this->objParam);			
		} else{			
			$this->res=$this->objFunc->modificarAlbum($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
						
	function eliminarAlbum(){
			$this->objFunc=$this->create('MODAlbum');	
		$this->res=$this->objFunc->eliminarAlbum($this->objParam);
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
			
}

?>