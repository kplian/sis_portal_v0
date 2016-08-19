<?php
/**
*@package pXP
*@file gen-MODConfigImg.php
*@author  (admin)
*@date 18-09-2015 16:11:47
*@description Clase que envia los parametros requeridos a la Base de datos para la ejecucion de las funciones, y que recibe la respuesta del resultado de la ejecucion de las mismas
*/

class MODConfigImg extends MODbase{
	
	function __construct(CTParametro $pParam){
		parent::__construct($pParam);

		$this->cone = new conexion();
		$this->link = $this->cone->conectarpdo(); //conexion a pxp(postgres)

	}
			
	function listarConfigImg(){
		//Definicion de variables para ejecucion del procedimientp
		$this->procedimiento='por.ft_config_img_sel';
		$this->transaccion='POR_CONFIM_SEL';
		$this->tipo_procedimiento='SEL';//tipo de transaccion
				
		//Definicion de la lista del resultado del query
		$this->captura('id_config_img','int4');
		$this->captura('clase','varchar');
		$this->captura('ancho_original','varchar');
		$this->captura('alto_original','varchar');
		
		$this->captura('ancho_mediano','varchar');
		$this->captura('ancho_pequeno','varchar');
		$this->captura('alto_mediano','varchar');
		$this->captura('estado_reg','varchar');
		$this->captura('alto_pequeno','varchar');
		$this->captura('id_usuario_ai','int4');
		$this->captura('id_usuario_reg','int4');
		$this->captura('usuario_ai','varchar');
		$this->captura('fecha_reg','timestamp');
		$this->captura('fecha_mod','timestamp');
		$this->captura('id_usuario_mod','int4');
		$this->captura('usr_reg','varchar');
		$this->captura('usr_mod','varchar');

		$this->captura('validado','varchar');
		
		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();
		
		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function insertarConfigImg(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='por.ft_config_img_ime';
		$this->transaccion='POR_CONFIM_INS';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('clase','clase','varchar');
		$this->setParametro('ancho_original','ancho_original','varchar');
		$this->setParametro('alto_original','alto_original','varchar');

		$this->setParametro('ancho_mediano','ancho_mediano','varchar');
		$this->setParametro('ancho_pequeno','ancho_pequeno','varchar');
		$this->setParametro('alto_mediano','alto_mediano','varchar');
		$this->setParametro('estado_reg','estado_reg','varchar');
		$this->setParametro('alto_pequeno','alto_pequeno','varchar');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function modificarConfigImg(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='por.ft_config_img_ime';
		$this->transaccion='POR_CONFIM_MOD';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_config_img','id_config_img','int4');
		$this->setParametro('clase','clase','varchar');
		$this->setParametro('ancho_original','ancho_original','varchar');
		$this->setParametro('alto_original','alto_original','varchar');
		$this->setParametro('ancho_mediano','ancho_mediano','varchar');
		$this->setParametro('ancho_pequeno','ancho_pequeno','varchar');
		$this->setParametro('alto_mediano','alto_mediano','varchar');
		$this->setParametro('estado_reg','estado_reg','varchar');
		$this->setParametro('alto_pequeno','alto_pequeno','varchar');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function eliminarConfigImg(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='por.ft_config_img_ime';
		$this->transaccion='POR_CONFIM_ELI';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_config_img','id_config_img','int4');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}


	function cambiarValidacion(){

		$id_config_img = $this->objParam->getParametro('id_config_img');
		$validado = $this->objParam->getParametro('validado');


		if($validado == 'si'){

			$res = $this->link->prepare("update por.tconfig_img set validado = 'no' where id_config_img = '$id_config_img'");
		}else if($validado == 'no'){

			$res = $this->link->prepare("update por.tconfig_img set validado = 'si' where id_config_img = '$id_config_img'");
		}

		$res->execute();


		$result = $res->fetchAll(PDO::FETCH_ASSOC);
		$this->respuesta = new Mensaje();
		$this->respuesta->setMensaje('EXITO', $this->nombre_archivo, 'La consulta se ejecuto con exito de insercion de nota', 'La consulta se ejecuto con exito', 'base', 'no tiene', 'no tiene', 'SEL', '$this->consulta', 'no tiene');
		$this->respuesta->setTotal(1);
		$this->respuesta->setDatos("correcto");

		return $this->respuesta;

	}
			
}
?>