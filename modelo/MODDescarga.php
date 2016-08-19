<?php
/**
*@package pXP
*@file gen-MODDescarga.php
*@author  (admin)
*@date 20-09-2015 19:00:21
*@description Clase que envia los parametros requeridos a la Base de datos para la ejecucion de las funciones, y que recibe la respuesta del resultado de la ejecucion de las mismas
*/

class MODDescarga extends MODbase{
	
	function __construct(CTParametro $pParam){
		parent::__construct($pParam);

		$this->cone = new conexion();
		$this->link = $this->cone->conectarpdo(); //conexion a pxp(postgres)
	}
			
	function listarDescarga(){
		//Definicion de variables para ejecucion del procedimientp
		$this->procedimiento='por.ft_descarga_sel';
		$this->transaccion='POR_DES_SEL';
		$this->tipo_procedimiento='SEL';//tipo de transaccion
				
		//Definicion de la lista del resultado del query
		$this->captura('id_descarga','int4');
		$this->captura('titulo','varchar');
		$this->captura('url_archivo','varchar');
		$this->captura('descripcion','varchar');
		$this->captura('tamano','varchar');
		$this->captura('id_categoria','int4');
		$this->captura('estado_reg','varchar');
		$this->captura('id_usuario_ai','int4');
		$this->captura('fecha_reg','timestamp');
		$this->captura('usuario_ai','varchar');
		$this->captura('id_usuario_reg','int4');
		$this->captura('fecha_mod','timestamp');
		$this->captura('id_usuario_mod','int4');
		$this->captura('usr_reg','varchar');
		$this->captura('usr_mod','varchar');

		$this->captura('desc_categoria','varchar');
		$this->captura('nombre_archivo','varchar');
		$this->captura('extension','varchar');
		$this->captura('anio','int4');


		
		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();
		
		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function insertarDescarga(){


		$cone = new conexion();
		$link = $cone->conectarpdo();
		$copiado = false;
		try {
			$link->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$link->beginTransaction();


			if ($this->arregloFiles['archivo']['name'] == "") {
				throw new Exception("El archivo no puede estar vacio");
			}


			//Definicion de variables para ejecucion del procedimiento
			$this->procedimiento='por.ft_descarga_ime';
			$this->transaccion='POR_DES_INS';
			$this->tipo_procedimiento='IME';

			//Define los parametros para la funcion
			$this->setParametro('titulo','titulo','varchar');

			$this->setParametro('descripcion','descripcion','varchar');
			$this->setParametro('id_categoria','id_categoria','int4');
			$this->setParametro('estado_reg','estado_reg','varchar');
			$this->setParametro('anio','anio','int4');

			$ext = pathinfo($this->arregloFiles['archivo']['name']);
			$this->arreglo['extension'] = $ext['extension'];


			//validar que no sea un arhvio en blanco
			$file_name = $this->getFileName2('archivo', 'titulo', '', false);

			//Define los parametros para la funcion
			$this->setParametro('extension','extension','varchar');



			$this->aParam->addParametro('tamano', 150);
			$this->arreglo['tamano'] = 150;
			$this->setParametro('tamano','tamano','varchar');

			//manda como parametro la url completa del archivo
			$this->aParam->addParametro('file_name', $file_name[2]);
			$this->arreglo['file_name'] = $file_name[2];
			$this->setParametro('url_original','file_name','varchar');


			//manda como parametro el folder del arhivo
			$this->aParam->addParametro('folder', $file_name[1]);
			$this->arreglo['folder'] = $file_name[1];
			$this->setParametro('folder','folder','varchar');

			//manda como parametro el solo el nombre del arhivo  sin extencion
			$this->aParam->addParametro('only_file', $file_name[0]);
			$this->arreglo['only_file'] = $file_name[0];
			$this->setParametro('nombre_archivo','only_file','varchar');


			$configuraciones  = $this->verConfiguracion('descarga');
			$validado = $configuraciones[0]['validado'];
			$ancho_original = $configuraciones[0]['ancho_original'];
			$ancho_mediano = $configuraciones[0]['ancho_mediano'];
			$ancho_pequeno = $configuraciones[0]['ancho_pequeno'];



			//Ejecuta la instruccion
			$this->armarConsulta();
			$stmt = $link->prepare($this->consulta);
			$stmt->execute();
			$result = $stmt->fetch(PDO::FETCH_ASSOC);
			$resp_procedimiento = $this->divRespuesta($result['f_intermediario_ime']);



			if ($resp_procedimiento['tipo_respuesta']=='ERROR') {
				throw new Exception("Error al ejecutar en la bd", 3);
			}

			if($resp_procedimiento['tipo_respuesta'] == 'EXITO'){
				//cipiamos el nuevo archivo
				$this->setFile('archivo','titulo', false,500000 ,array('doc','pdf','docx','jpg','jpeg','bmp','gif','png','PDF','DOC','DOCX','xls','xlsx','XLS','XLSX','rar'));


			}

			$link->commit();
			$this->respuesta=new Mensaje();
			$this->respuesta->setMensaje($resp_procedimiento['tipo_respuesta'],$this->nombre_archivo,$resp_procedimiento['mensaje'],$resp_procedimiento['mensaje_tec'],'base',$this->procedimiento,$this->transaccion,$this->tipo_procedimiento,$this->consulta);
			$this->respuesta->setDatos($respuesta);
		}
		catch (Exception $e) {
			$link->rollBack();

			if($copiado){
				$this->copyFile($respuesta['url_origen'], $respuesta['url_destino'],  $folder = 'historico', true);
			}
			$this->respuesta=new Mensaje();
			if ($e->getCode() == 3) {//es un error de un procedimiento almacenado de pxp
				$this->respuesta->setMensaje($resp_procedimiento['tipo_respuesta'],$this->nombre_archivo,$resp_procedimiento['mensaje'],$resp_procedimiento['mensaje_tec'],'base',$this->procedimiento,$this->transaccion,$this->tipo_procedimiento,$this->consulta);
			} else if ($e->getCode() == 2) {//es un error en bd de una consulta
				$this->respuesta->setMensaje('ERROR',$this->nombre_archivo,$e->getMessage(),$e->getMessage(),'modelo','','','','');
			} else {//es un error lanzado con throw exception
				throw new Exception($e->getMessage(), 2);
			}
		}

		return $this->respuesta;
	}

	function verConfiguracion($clase){
		$res = $this->link->prepare("select * from  por.tconfig_img WHERE clase = '$clase' limit 1");
		$res->execute();
		$result = $res->fetchAll(PDO::FETCH_ASSOC);
		return $result;
	}
			
	function modificarDescarga(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='por.ft_descarga_ime';
		$this->transaccion='POR_DES_MOD';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_descarga','id_descarga','int4');
		$this->setParametro('titulo','titulo','varchar');
		$this->setParametro('url_archivo','url_archivo','varchar');
		$this->setParametro('descripcion','descripcion','varchar');
		$this->setParametro('tamano','tamano','varchar');
		$this->setParametro('id_categoria','id_categoria','int4');
		$this->setParametro('estado_reg','estado_reg','varchar');
		$this->setParametro('anio','anio','int4');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function eliminarDescarga(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='por.ft_descarga_ime';
		$this->transaccion='POR_DES_ELI';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_descarga','id_descarga','int4');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
}
?>