<?php
/**
*@package pXP
*@file gen-MODCodigoControl.php
*@author  (admin)
*@date 23-09-2015 04:07:03
*@description Clase que envia los parametros requeridos a la Base de datos para la ejecucion de las funciones, y que recibe la respuesta del resultado de la ejecucion de las mismas
*/

class MODCodigoControl extends MODbase{
	
	function __construct(CTParametro $pParam){
		parent::__construct($pParam);
		
		
		$this->cone = new conexion();
		$this->link = $this->cone->conectarpdo(); //conexion a pxp(postgres)
		
	}
			
	function listarCodigoControl(){
		//Definicion de variables para ejecucion del procedimientp
		$this->procedimiento='por.ft_codigo_control_sel';
		$this->transaccion='POR_CODC_SEL';
		$this->tipo_procedimiento='SEL';//tipo de transaccion
				
		//Definicion de la lista del resultado del query
		$this->captura('id_codigo_control','int4');
		$this->captura('llave','varchar');
		$this->captura('importe','numeric');
		$this->captura('autorizacion','varchar');
		$this->captura('nit','varchar');
		$this->captura('factura','varchar');
		$this->captura('fecha','date');
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
			
	function insertarCodigoControl(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='por.ft_codigo_control_ime';
		$this->transaccion='POR_CODC_INS';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('llave','llave','varchar');
		$this->setParametro('importe','importe','numeric');
		$this->setParametro('autorizacion','autorizacion','varchar');
		$this->setParametro('nit','nit','varchar');
		$this->setParametro('factura','factura','varchar');
		$this->setParametro('fecha','fecha','date');
		$this->setParametro('estado_reg','estado_reg','varchar');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function modificarCodigoControl(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='por.ft_codigo_control_ime';
		$this->transaccion='POR_CODC_MOD';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_codigo_control','id_codigo_control','int4');
		$this->setParametro('llave','llave','varchar');
		$this->setParametro('importe','importe','numeric');
		$this->setParametro('autorizacion','autorizacion','varchar');
		$this->setParametro('nit','nit','varchar');
		$this->setParametro('factura','factura','varchar');
		$this->setParametro('fecha','fecha','date');
		$this->setParametro('estado_reg','estado_reg','varchar');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function eliminarCodigoControl(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='por.ft_codigo_control_ime';
		$this->transaccion='POR_CODC_ELI';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_codigo_control','id_codigo_control','int4');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}


	 function generarCodigoControl()
    {
        
		$llave = $this->aParam->getParametro('llave');
		$autorizacion = $this->aParam->getParametro('autorizacion');
		$factura = $this->aParam->getParametro('factura');
		$nit = $this->aParam->getParametro('nit');
		$fecha = $this->aParam->getParametro('fecha');
		$importe = $this->aParam->getParametro('importe');
		
		try {
			//obtener sucursal del usuario
			$this->link->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$this->link->beginTransaction();

			 /*$func_cod_con = $this->link->prepare("select pxp.f_gen_cod_control(
										'" . $llave . "',
										'" . $autorizacion. "','" . $factura . "','" . $nit . "','" . $fecha . "', round('$importe',0) )");
	        */
	        
	       $func_cod_con = $this->link->prepare("select pxp.f_gen_cod_control(
										      '" . $llave . "',
										      '" . $autorizacion. "',
										       '" . $factura . "',
										        '" . $nit . "',
										         '" . $fecha . "',
          											round('$importe',0) )");
													
												
	       
	        $func_cod_con->execute();
	        $codigo_control = $func_cod_con->fetchAll(PDO::FETCH_ASSOC);
		
			$this->link->commit();
			$this->respuesta = new Mensaje();
			$this->respuesta->setMensaje('EXITO', $this->nombre_archivo, 'La consulta se ejecuto con exito de insercion de nota', 'La consulta se ejecuto con exito', 'base', 'no tiene', 'no tiene', 'SEL', '$this->consulta', 'no tiene');
			$this->respuesta->setTotal(1);
			$this->respuesta->setDatos($codigo_control);
			return $this->respuesta;

		} catch (Exception $e) {
			$this->link->rollBack();
			$this->respuesta = new Mensaje();
			if ($e->getCode() == 3) {//es un error de un procedimiento almacenado de pxp
			$this->respuesta->setMensaje($resp_procedimiento['tipo_respuesta'], $this->nombre_archivo, $resp_procedimiento['mensaje'], $resp_procedimiento['mensaje_tec'], 'base', $this->procedimiento, $this->transaccion, $this->tipo_procedimiento, $this->consulta);
			} else if ($e->getCode() == 2) {//es un error en bd de una consulta
				$this->respuesta->setMensaje('ERROR', $this->nombre_archivo, $e->getMessage(), $e->getMessage(), 'modelo', '', '', '', '');
			} else {//es un error lanzado con throw exception
				throw new Exception($e->getMessage(), 2);
			}
		}
		return $this->respuesta;
		
		
       
    }
			
}
?>