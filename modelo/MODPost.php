<?php
/**
*@package pXP
*@file gen-MODPost.php
*@author  (admin)
*@date 20-09-2015 18:43:35
*@description Clase que envia los parametros requeridos a la Base de datos para la ejecucion de las funciones, y que recibe la respuesta del resultado de la ejecucion de las mismas
*/

class MODPost extends MODbase{
	
	function __construct(CTParametro $pParam){
		parent::__construct($pParam);

		$this->cone = new conexion();
		$this->link = $this->cone->conectarpdo(); //conexion a pxp(postgres)
	}
			
	function listarPost(){
		//Definicion de variables para ejecucion del procedimientp
		$this->procedimiento='por.ft_post_sel';
		$this->transaccion='POR_POS_SEL';
		$this->tipo_procedimiento='SEL';//tipo de transaccion
				
		//Definicion de la lista del resultado del query
		$this->captura('id_post','int4');
		$this->captura('fecha','date');
		$this->captura('folder','varchar');
		$this->captura('titulo','varchar');
		$this->captura('estado','varchar');
		$this->captura('contenido','text');
		$this->captura('nombre_imagen','varchar');
		$this->captura('subtitulo','varchar');
		$this->captura('url_autor','varchar');
		$this->captura('estado_reg','varchar');
		$this->captura('extension','varchar');
		$this->captura('id_usuario_ai','int4');
		$this->captura('id_usuario_reg','int4');
		$this->captura('fecha_reg','timestamp');
		$this->captura('usuario_ai','varchar');
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
			
	function insertarPost(){


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
			$this->procedimiento='por.ft_post_ime';
			$this->transaccion='POR_POS_INS';
			$this->tipo_procedimiento='IME';

			//Define los parametros para la funcion
			$this->setParametro('fecha','fecha','date');
			//$this->setParametro('folder','folder','varchar');
			$this->setParametro('titulo','titulo','varchar');
			$this->setParametro('estado','estado','varchar');
			$this->setParametro('contenido','contenido','codigo_html');

			$this->setParametro('subtitulo','subtitulo','varchar');
			$this->setParametro('url_autor','url_autor','varchar');
			$this->setParametro('estado_reg','estado_reg','varchar');

			$ext = pathinfo($this->arregloFiles['archivo']['name']);
			$this->arreglo['extension'] = $ext['extension'];

			//validar que no sea un arhvio en blanco
			$file_name = $this->getFileName2('archivo', 'titulo', '', false);

			//Define los parametros para la funcion
			$this->setParametro('extension','extension','varchar');



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
			$this->setParametro('nombre_imagen','only_file','varchar');


			$configuraciones  = $this->verConfiguracion('Post');
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
				$this->setFile('archivo','titulo', false,100000 ,array('doc','pdf','docx','jpg','jpeg','bmp','gif','png','PDF','DOC','DOCX','xls','xlsx','XLS','XLSX','rar'));

				if($validado == 'si'){
					if($this->validacionImagen('file_name','extension',$ancho_original) == false){
						throw new Exception("el tamaño de imagen esta mal debe ser ".$ancho_original."");
					}
				}


				//vemos en la configuracion si esta validado y cuanto es su tamaño para convertir




				//damos las rutas a guardar las conversiones de tamanios

				$url_original = $file_name[1];
				$url_mediano = $file_name[1]."mediano/";
				$url_pequeno = $file_name[1]."pequeno/";

				$mediana = $this->convertirTamanoImagen('file_name',$ancho_mediano,'extension',$url_mediano,$file_name[0]);
				$pequena = $this->convertirTamanoImagen('file_name',$ancho_pequeno,'extension',$url_pequeno,$file_name[0]);

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
			
	function modificarPost(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='por.ft_post_ime';
		$this->transaccion='POR_POS_MOD';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_post','id_post','int4');
		$this->setParametro('fecha','fecha','date');
		$this->setParametro('folder','folder','varchar');
		$this->setParametro('titulo','titulo','varchar');
		$this->setParametro('estado','estado','varchar');
		$this->setParametro('contenido','contenido','text');
		$this->setParametro('nombre_imagen','nombre_imagen','varchar');
		$this->setParametro('subtitulo','subtitulo','varchar');
		$this->setParametro('url_autor','url_autor','varchar');
		$this->setParametro('estado_reg','estado_reg','varchar');
		$this->setParametro('extension','extension','varchar');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function eliminarPost(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='por.ft_post_ime';
		$this->transaccion='POR_POS_ELI';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_post','id_post','int4');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
}
?>