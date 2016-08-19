<?php
/**
*@package pXP
*@file gen-ACTCodigoControl.php
*@author  (admin)
*@date 23-09-2015 04:07:03
*@description Clase que recibe los parametros enviados por la vista para mandar a la capa de Modelo
*/

class ACTCodigoControl extends ACTbase{    
			
	function listarCodigoControl(){
		$this->objParam->defecto('ordenacion','id_codigo_control');

		$this->objParam->defecto('dir_ordenacion','asc');
		if($this->objParam->getParametro('tipoReporte')=='excel_grid' || $this->objParam->getParametro('tipoReporte')=='pdf_grid'){
			$this->objReporte = new Reporte($this->objParam,$this);
			$this->res = $this->objReporte->generarReporteListado('MODCodigoControl','listarCodigoControl');
		} else{
			$this->objFunc=$this->create('MODCodigoControl');
			
			$this->res=$this->objFunc->listarCodigoControl($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
				
	function insertarCodigoControl(){
		$this->objFunc=$this->create('MODCodigoControl');	
		if($this->objParam->insertar('id_codigo_control')){
			$this->res=$this->objFunc->insertarCodigoControl($this->objParam);			
		} else{			
			$this->res=$this->objFunc->modificarCodigoControl($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
						
	function eliminarCodigoControl(){
			$this->objFunc=$this->create('MODCodigoControl');	
		$this->res=$this->objFunc->eliminarCodigoControl($this->objParam);
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
	
	function generarCodigoControl()
    {
        
        $this->objFunc=$this->create('MODCodigoControl');	
		$this->res=$this->objFunc->generarCodigoControl($this->objParam);
		$this->res->imprimirRespuesta($this->res->generarJson());
    }
	
			
}

?>