<?php
/**
*@package pXP
*@file gen-ACTPublicacionFb.php
*@author  (admin)
*@date 01-10-2015 13:41:00
*@description Clase que recibe los parametros enviados por la vista para mandar a la capa de Modelo
*/

class ACTPublicacionFb extends ACTbase{    
			
	function listarPublicacionFb(){
		$this->objParam->defecto('ordenacion','id_publicacion_fb');

		$this->objParam->defecto('dir_ordenacion','asc');
		if($this->objParam->getParametro('tipoReporte')=='excel_grid' || $this->objParam->getParametro('tipoReporte')=='pdf_grid'){
			$this->objReporte = new Reporte($this->objParam,$this);
			$this->res = $this->objReporte->generarReporteListado('MODPublicacionFb','listarPublicacionFb');
		} else{
			$this->objFunc=$this->create('MODPublicacionFb');
			
			$this->res=$this->objFunc->listarPublicacionFb($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
				
	function insertarPublicacionFb(){
		$this->objFunc=$this->create('MODPublicacionFb');	
		if($this->objParam->insertar('id_publicacion_fb')){
			$this->res=$this->objFunc->insertarPublicacionFb($this->objParam);			
		} else{			
			$this->res=$this->objFunc->modificarPublicacionFb($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
						
	function eliminarPublicacionFb(){
			$this->objFunc=$this->create('MODPublicacionFb');	
		$this->res=$this->objFunc->eliminarPublicacionFb($this->objParam);
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
			
}

?>