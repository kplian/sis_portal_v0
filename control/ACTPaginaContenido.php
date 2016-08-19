<?php
/**
*@package pXP
*@file gen-ACTPaginaContenido.php
*@author  (admin)
*@date 03-04-2016 17:58:58
*@description Clase que recibe los parametros enviados por la vista para mandar a la capa de Modelo
*/

class ACTPaginaContenido extends ACTbase{    
			
	function listarPaginaContenido(){
		$this->objParam->defecto('ordenacion','id_pagina_contenido');

		$this->objParam->defecto('dir_ordenacion','asc');

		if($this->objParam->getParametro('id_pagina')!=''){
			$this->objParam->addFiltro("pagcon.id_pagina = ''".$this->objParam->getParametro('id_pagina')."''");
		}
		if($this->objParam->getParametro('tipoReporte')=='excel_grid' || $this->objParam->getParametro('tipoReporte')=='pdf_grid'){
			$this->objReporte = new Reporte($this->objParam,$this);
			$this->res = $this->objReporte->generarReporteListado('MODPaginaContenido','listarPaginaContenido');
		} else{
			$this->objFunc=$this->create('MODPaginaContenido');
			
			$this->res=$this->objFunc->listarPaginaContenido($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
				
	function insertarPaginaContenido(){
		$this->objFunc=$this->create('MODPaginaContenido');	
		if($this->objParam->insertar('id_pagina_contenido')){
			$this->res=$this->objFunc->insertarPaginaContenido($this->objParam);			
		} else{			
			$this->res=$this->objFunc->modificarPaginaContenido($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
						
	function eliminarPaginaContenido(){
			$this->objFunc=$this->create('MODPaginaContenido');	
		$this->res=$this->objFunc->eliminarPaginaContenido($this->objParam);
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
			
}

?>