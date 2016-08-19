<?php
/**
*@package pXP
*@file gen-ACTPagina.php
*@author  (admin)
*@date 03-04-2016 17:58:39
*@description Clase que recibe los parametros enviados por la vista para mandar a la capa de Modelo
*/

class ACTPagina extends ACTbase{    
			
	function listarPagina(){
		$this->objParam->defecto('ordenacion','id_pagina');

		$this->objParam->defecto('dir_ordenacion','asc');

		if($this->objParam->getParametro('id_pagina')!=''){
			$this->objParam->addFiltro("pag.id_pagina = ''".$this->objParam->getParametro('id_pagina')."''");
		}

		if($this->objParam->getParametro('tipoReporte')=='excel_grid' || $this->objParam->getParametro('tipoReporte')=='pdf_grid'){
			$this->objReporte = new Reporte($this->objParam,$this);
			$this->res = $this->objReporte->generarReporteListado('MODPagina','listarPagina');
		} else{
			$this->objFunc=$this->create('MODPagina');
			
			$this->res=$this->objFunc->listarPagina($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
				
	function insertarPagina(){
		$this->objFunc=$this->create('MODPagina');	
		if($this->objParam->insertar('id_pagina')){
			$this->res=$this->objFunc->insertarPagina($this->objParam);			
		} else{			
			$this->res=$this->objFunc->modificarPagina($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
						
	function eliminarPagina(){
			$this->objFunc=$this->create('MODPagina');	
		$this->res=$this->objFunc->eliminarPagina($this->objParam);
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
			
}

?>