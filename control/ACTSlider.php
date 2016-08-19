<?php
/**
*@package pXP
*@file gen-ACTSlider.php
*@author  (admin)
*@date 18-09-2015 13:41:35
*@description Clase que recibe los parametros enviados por la vista para mandar a la capa de Modelo
*/

class ACTSlider extends ACTbase{    
			
	function listarSlider(){
		$this->objParam->defecto('ordenacion','id_slider');

		$this->objParam->defecto('dir_ordenacion','asc');
		if($this->objParam->getParametro('tipoReporte')=='excel_grid' || $this->objParam->getParametro('tipoReporte')=='pdf_grid'){
			$this->objReporte = new Reporte($this->objParam,$this);
			$this->res = $this->objReporte->generarReporteListado('MODSlider','listarSlider');
		} else{
			$this->objFunc=$this->create('MODSlider');
			
			$this->res=$this->objFunc->listarSlider($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
				
	function insertarSlider(){
		$this->objFunc=$this->create('MODSlider');	
		if($this->objParam->insertar('id_slider')){
			$this->res=$this->objFunc->insertarSlider($this->objParam);			
		} else{			
			$this->res=$this->objFunc->modificarSlider($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
						
	function eliminarSlider(){
			$this->objFunc=$this->create('MODSlider');	
		$this->res=$this->objFunc->eliminarSlider($this->objParam);
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
			
}

?>