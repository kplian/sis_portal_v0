<?php
/**
*@package pXP
*@file gen-ACTDescarga.php
*@author  (admin)
*@date 20-09-2015 19:00:21
*@description Clase que recibe los parametros enviados por la vista para mandar a la capa de Modelo
*/

class ACTDescarga extends ACTbase{    
			
	function listarDescarga(){
		$this->objParam->defecto('ordenacion','id_descarga');

		$this->objParam->defecto('dir_ordenacion','asc');




		if($this->objParam->getParametro('desc_categoria')!=''){
			$this->objParam->addFiltro("cat.nombre = ''".$this->objParam->getParametro('desc_categoria')."''");
		}

		if($this->objParam->getParametro('tipoReporte')=='excel_grid' || $this->objParam->getParametro('tipoReporte')=='pdf_grid'){
			$this->objReporte = new Reporte($this->objParam,$this);
			$this->res = $this->objReporte->generarReporteListado('MODDescarga','listarDescarga');
		} else{
			$this->objFunc=$this->create('MODDescarga');
			
			$this->res=$this->objFunc->listarDescarga($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
				
	function insertarDescarga(){
		$this->objFunc=$this->create('MODDescarga');	
		if($this->objParam->insertar('id_descarga')){
			$this->res=$this->objFunc->insertarDescarga($this->objParam);			
		} else{			
			$this->res=$this->objFunc->modificarDescarga($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
						
	function eliminarDescarga(){
			$this->objFunc=$this->create('MODDescarga');	
		$this->res=$this->objFunc->eliminarDescarga($this->objParam);
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
			
}

?>