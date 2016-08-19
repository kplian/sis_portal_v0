<?php
/**
*@package pXP
*@file gen-ACTRedesSociales.php
*@author  (admin)
*@date 30-09-2015 14:38:24
*@description Clase que recibe los parametros enviados por la vista para mandar a la capa de Modelo
*/

class ACTRedesSociales extends ACTbase{    
			
	function listarRedesSociales(){
		$this->objParam->defecto('ordenacion','id_redes_sociales');

		$this->objParam->defecto('dir_ordenacion','asc');
		if($this->objParam->getParametro('tipoReporte')=='excel_grid' || $this->objParam->getParametro('tipoReporte')=='pdf_grid'){
			$this->objReporte = new Reporte($this->objParam,$this);
			$this->res = $this->objReporte->generarReporteListado('MODRedesSociales','listarRedesSociales');
		} else{
			$this->objFunc=$this->create('MODRedesSociales');
			
			$this->res=$this->objFunc->listarRedesSociales($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
				
	function insertarRedesSociales(){
		$this->objFunc=$this->create('MODRedesSociales');	
		if($this->objParam->insertar('id_redes_sociales')){
			$this->res=$this->objFunc->insertarRedesSociales($this->objParam);			
		} else{			
			$this->res=$this->objFunc->modificarRedesSociales($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
						
	function eliminarRedesSociales(){
			$this->objFunc=$this->create('MODRedesSociales');	
		$this->res=$this->objFunc->eliminarRedesSociales($this->objParam);
		$this->res->imprimirRespuesta($this->res->generarJson());
	}

	function subirfb(){

		$this->objParam->defecto('ordenacion','id_redes_sociales');

		$this->objParam->defecto('dir_ordenacion','asc');

		$this->objFunc=$this->create('MODRedesSociales');
		$this->res=$this->objFunc->subirfb($this->objParam);
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
			
}

?>