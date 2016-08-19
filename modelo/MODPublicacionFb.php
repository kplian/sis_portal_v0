<?php
/**
*@package pXP
*@file gen-MODPublicacionFb.php
*@author  (admin)
*@date 01-10-2015 13:41:00
*@description Clase que envia los parametros requeridos a la Base de datos para la ejecucion de las funciones, y que recibe la respuesta del resultado de la ejecucion de las mismas
*/

class MODPublicacionFb extends MODbase{
	
	function __construct(CTParametro $pParam){
		parent::__construct($pParam);
	}
			
	function listarPublicacionFb(){
		//Definicion de variables para ejecucion del procedimientp
		$this->procedimiento='por.ft_publicacion_fb_sel';
		$this->transaccion='POR_PFB_SEL';
		$this->tipo_procedimiento='SEL';//tipo de transaccion
				
		//Definicion de la lista del resultado del query
		$this->captura('id_publicacion_fb','int4');
		$this->captura('id_clase','varchar');
		$this->captura('user_fb','varchar');
		$this->captura('estado_reg','varchar');
		$this->captura('post_id','varchar');
		$this->captura('clase','varchar');
		$this->captura('id','varchar');
		$this->captura('id_usuario_reg','int4');
		$this->captura('fecha_reg','timestamp');
		$this->captura('usuario_ai','varchar');
		$this->captura('id_usuario_ai','int4');
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
			
	function insertarPublicacionFb(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='por.ft_publicacion_fb_ime';
		$this->transaccion='POR_PFB_INS';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_clase','id_clase','varchar');
		$this->setParametro('user_fb','user_fb','varchar');
		$this->setParametro('estado_reg','estado_reg','varchar');
		$this->setParametro('post_id','post_id','varchar');
		$this->setParametro('clase','clase','varchar');
		$this->setParametro('id','id','varchar');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function modificarPublicacionFb(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='por.ft_publicacion_fb_ime';
		$this->transaccion='POR_PFB_MOD';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_publicacion_fb','id_publicacion_fb','int4');
		$this->setParametro('id_clase','id_clase','varchar');
		$this->setParametro('user_fb','user_fb','varchar');
		$this->setParametro('estado_reg','estado_reg','varchar');
		$this->setParametro('post_id','post_id','varchar');
		$this->setParametro('clase','clase','varchar');
		$this->setParametro('id','id','varchar');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function eliminarPublicacionFb(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='por.ft_publicacion_fb_ime';
		$this->transaccion='POR_PFB_ELI';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_publicacion_fb','id_publicacion_fb','int4');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
}
?>