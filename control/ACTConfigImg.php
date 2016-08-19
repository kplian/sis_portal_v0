<?php
/**
*@package pXP
*@file gen-ACTConfigImg.php
*@author  (admin)
*@date 18-09-2015 16:11:47
*@description Clase que recibe los parametros enviados por la vista para mandar a la capa de Modelo
*/

class ACTConfigImg extends ACTbase{    
			
	function listarConfigImg(){
		$this->objParam->defecto('ordenacion','id_config_img');

		$this->objParam->defecto('dir_ordenacion','asc');
		if($this->objParam->getParametro('tipoReporte')=='excel_grid' || $this->objParam->getParametro('tipoReporte')=='pdf_grid'){
			$this->objReporte = new Reporte($this->objParam,$this);
			$this->res = $this->objReporte->generarReporteListado('MODConfigImg','listarConfigImg');
		} else{
			$this->objFunc=$this->create('MODConfigImg');
			
			$this->res=$this->objFunc->listarConfigImg($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
				
	function insertarConfigImg(){
		$this->objFunc=$this->create('MODConfigImg');	
		if($this->objParam->insertar('id_config_img')){
			$this->res=$this->objFunc->insertarConfigImg($this->objParam);			
		} else{			
			$this->res=$this->objFunc->modificarConfigImg($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
						
	function eliminarConfigImg(){
			$this->objFunc=$this->create('MODConfigImg');	
		$this->res=$this->objFunc->eliminarConfigImg($this->objParam);
		$this->res->imprimirRespuesta($this->res->generarJson());
	}

	function cambiarValidacion(){

		$this->objFunc=$this->create('MODConfigImg');
		$this->res=$this->objFunc->cambiarValidacion($this->objParam);

		$this->res->imprimirRespuesta($this->res->generarJson());

	}
			
}

?>