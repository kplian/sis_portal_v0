<?php
/**
*@package pXP
*@file gen-ACTImg.php
*@author  (admin)
*@date 24-09-2015 18:53:20
*@description Clase que recibe los parametros enviados por la vista para mandar a la capa de Modelo
*/

class ACTImg extends ACTbase{    
			
	function listarImg(){
		$this->objParam->defecto('ordenacion','id_img');

		$this->objParam->defecto('dir_ordenacion','asc');

		if($this->objParam->getParametro('id_album')!=''){
			$this->objParam->addFiltro("img.id_album = ''".$this->objParam->getParametro('id_album')."''");
		}

		if($this->objParam->getParametro('categoria')!=''){
			$this->objParam->addFiltro("cat.nombre = ''".$this->objParam->getParametro('categoria')."''");
		}

		if($this->objParam->getParametro('tipoReporte')=='excel_grid' || $this->objParam->getParametro('tipoReporte')=='pdf_grid'){
			$this->objReporte = new Reporte($this->objParam,$this);
			$this->res = $this->objReporte->generarReporteListado('MODImg','listarImg');
		} else{
			$this->objFunc=$this->create('MODImg');
			
			$this->res=$this->objFunc->listarImg($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
				
	function insertarImg(){
		$this->objFunc=$this->create('MODImg');	
		if($this->objParam->insertar('id_img')){
			$this->res=$this->objFunc->insertarImg($this->objParam);			
		} else{			
			$this->res=$this->objFunc->modificarImg($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
						
	function eliminarImg(){
			$this->objFunc=$this->create('MODImg');	
		$this->res=$this->objFunc->eliminarImg($this->objParam);
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
			
}

?>