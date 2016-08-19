<?php
/**
*@package pXP
*@file gen-MODAlbum.php
*@author  (admin)
*@date 24-09-2015 18:53:01
*@description Clase que envia los parametros requeridos a la Base de datos para la ejecucion de las funciones, y que recibe la respuesta del resultado de la ejecucion de las mismas
*/

class MODAlbum extends MODbase{
	
	function __construct(CTParametro $pParam){
		parent::__construct($pParam);
	}
			
	function listarAlbum(){
		//Definicion de variables para ejecucion del procedimientp
		$this->procedimiento='por.ft_album_sel';
		$this->transaccion='POR_ALB_SEL';
		$this->tipo_procedimiento='SEL';//tipo de transaccion
				
		//Definicion de la lista del resultado del query
		$this->captura('id_album','int4');
		$this->captura('nombre','varchar');
		$this->captura('estado','varchar');
		$this->captura('id_categoria','int4');
		$this->captura('estado_reg','varchar');
		$this->captura('id_usuario_ai','int4');
		$this->captura('id_usuario_reg','int4');
		$this->captura('usuario_ai','varchar');
		$this->captura('fecha_reg','timestamp');
		$this->captura('fecha_mod','timestamp');
		$this->captura('id_usuario_mod','int4');
		$this->captura('usr_reg','varchar');
		$this->captura('usr_mod','varchar');
		
		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();
		
		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function insertarAlbum(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='por.ft_album_ime';
		$this->transaccion='POR_ALB_INS';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('nombre','nombre','varchar');
		$this->setParametro('estado','estado','varchar');
		$this->setParametro('id_categoria','id_categoria','int4');
		$this->setParametro('estado_reg','estado_reg','varchar');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function modificarAlbum(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='por.ft_album_ime';
		$this->transaccion='POR_ALB_MOD';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_album','id_album','int4');
		$this->setParametro('nombre','nombre','varchar');
		$this->setParametro('estado','estado','varchar');
		$this->setParametro('id_categoria','id_categoria','int4');
		$this->setParametro('estado_reg','estado_reg','varchar');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function eliminarAlbum(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='por.ft_album_ime';
		$this->transaccion='POR_ALB_ELI';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_album','id_album','int4');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
}
?>