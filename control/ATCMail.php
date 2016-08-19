<?php
/**
*@package pXP
*@file gen-ACTSlider.php
*@author  (favio figueoa)
*@date 18-09-2015 13:41:35
*@description Clase que recibe los parametros enviados por la vista para mandar a la capa de Modelo
*/

class ACTMail extends ACTbase{

	
	function mandarMensaje(){
		$this->objFunc=$this->create('MODMail');
		$this->res=$this->objFunc->mandarMensaje($this->objParam);
		$this->res->imprimirRespuesta($this->res->generarJson());
	}

}

?>