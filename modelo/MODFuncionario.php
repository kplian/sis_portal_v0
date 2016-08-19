<?php
/**
*@package pXP
*@file gen-MODFuncionario.php
*@author  (admin)
*@date 20-09-2015 19:42:44
*@description Clase que envia los parametros requeridos a la Base de datos para la ejecucion de las funciones, y que recibe la respuesta del resultado de la ejecucion de las mismas
*/

class MODFuncionario extends MODbase{
	
	function __construct(CTParametro $pParam){
		parent::__construct($pParam);
	}
			
	function listarFuncionario(){
		//Definicion de variables para ejecucion del procedimientp
		$this->procedimiento='por.ft_funcionario_sel';
		$this->transaccion='POR_FUNCI_SEL';
		$this->tipo_procedimiento='SEL';//tipo de transaccion
				
		//Definicion de la lista del resultado del query
		$this->captura('id_funcionario','int4');
		$this->captura('email_funcionario','varchar');
		$this->captura('id_persona','int4');
		$this->captura('cargo','varchar');
		$this->captura('estado_reg','varchar');
		$this->captura('id_usuario_ai','int4');
		$this->captura('fecha_reg','timestamp');
		$this->captura('usuario_ai','varchar');
		$this->captura('id_usuario_reg','int4');
		$this->captura('fecha_mod','timestamp');
		$this->captura('id_usuario_mod','int4');
		$this->captura('usr_reg','varchar');
		$this->captura('usr_mod','varchar');

		$this->captura('desc_person','text');
		
		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();
		
		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function insertarFuncionario(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='por.ft_funcionario_ime';
		$this->transaccion='POR_FUNCI_INS';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('email_funcionario','email_funcionario','varchar');
		$this->setParametro('id_persona','id_persona','int4');
		$this->setParametro('cargo','cargo','varchar');
		$this->setParametro('estado_reg','estado_reg','varchar');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function modificarFuncionario(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='por.ft_funcionario_ime';
		$this->transaccion='POR_FUNCI_MOD';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_funcionario','id_funcionario','int4');
		$this->setParametro('email_funcionario','email_funcionario','varchar');
		$this->setParametro('id_persona','id_persona','int4');
		$this->setParametro('cargo','cargo','varchar');
		$this->setParametro('estado_reg','estado_reg','varchar');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function eliminarFuncionario(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='por.ft_funcionario_ime';
		$this->transaccion='POR_FUNCI_ELI';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_funcionario','id_funcionario','int4');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
}
?>