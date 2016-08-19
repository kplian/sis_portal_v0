<?php
/**
*@package pXP
*@file gen-MODImg.php
*@author  (admin)
*@date 24-09-2015 18:53:20
*@description Clase que envia los parametros requeridos a la Base de datos para la ejecucion de las funciones, y que recibe la respuesta del resultado de la ejecucion de las mismas
*/

class MODImg extends MODbase{
	
	function __construct(CTParametro $pParam){
		parent::__construct($pParam);
	}
			
	function listarImg(){
		//Definicion de variables para ejecucion del procedimientp
		$this->procedimiento='por.ft_img_sel';
		$this->transaccion='POR_IMG_SEL';
		$this->tipo_procedimiento='SEL';//tipo de transaccion
				
		//Definicion de la lista del resultado del query
		$this->captura('id_img','int4');
		$this->captura('estado_reg','varchar');
		$this->captura('estado','varchar');
		$this->captura('folder','varchar');
		$this->captura('extension','varchar');
		$this->captura('id_album','int4');
		$this->captura('nombre_archivo','varchar');
		$this->captura('fecha_reg','timestamp');
		$this->captura('usuario_ai','varchar');
		$this->captura('id_usuario_reg','int4');
		$this->captura('id_usuario_ai','int4');
		$this->captura('id_usuario_mod','int4');
		$this->captura('fecha_mod','timestamp');
		$this->captura('usr_reg','varchar');
		$this->captura('usr_mod','varchar');
		$this->captura('desc_album','varchar');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();
		
		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function insertarImg(){


		$arra = array();
		$id_album = $this->aParam->getParametro('id_album');
		$nombre_album = $this->aParam->getParametro('album');

		$ruta_destino="./../../../uploaded_files/sis_portal/Img/".$nombre_album."/";
		$url_mediano = $ruta_destino.'mediano/';
		$url_pequeno = $ruta_destino.'pequeno/';

		if (!file_exists($ruta_destino)) {
			//echo $upload_folder;
			//exit;
			if (!mkdir($ruta_destino,0744,true)) {
				throw new Exception("No se puede crear el directorio uploaded_files/" . $this->objParam->getSistema() . "/" .
					$this->objParam->getClase() . " para escribir el archivo " );
			}
		} else {
			if (!is_writable($ruta_destino)) {
				throw new Exception("No tiene permisos o no existe el directorio uploaded_files/" . $this->objParam->getSistema() . "/" .
					$this->objParam->getClase() . " para escribir el archivo " );
			}

		}

		$aux = count($this->arregloFiles['archivo']['name']);
		for ($i = 0; $i < $aux; $i++){
			$img = pathinfo($this->arregloFiles['archivo']['name'][$i]);
			$tmp_name = $this->arregloFiles['archivo']['tmp_name'][$i];
			$tamano= ($this->arregloFiles['archivo']['size'][$i] / 1000)."Kb"; //Obtenemos el tamaño en KB

			$nombre_archivo = $img['filename'];
			$extension = $img['extension'];
			$basename = $img['basename'];

			$unico_id = uniqid();

			$file_name = md5($unico_id . $_SESSION["_SEMILLA"]);
			$file_server_name = $file_name . ".$extension";
			move_uploaded_file($tmp_name, $ruta_destino . $file_server_name);

			$ruta_de_grabado =  $ruta_destino.$file_server_name;



			$this->aParam->addParametro('ruta_de_grabado', $ruta_de_grabado);
			$this->arreglo['ruta_de_grabado'] = $ruta_de_grabado; // esta ruta contiene con el archivo mas

			$this->aParam->addParametro('extension', $ruta_de_grabado);
			$this->arreglo['extension'] = $extension;



			$mediana = $this->convertirTamanoImagen('ruta_de_grabado',720,'extension',$url_mediano,$file_name);
			$mediana = $this->convertirTamanoImagen('ruta_de_grabado',400,'extension',$url_pequeno,$file_name);


			$arra[] = array(
				"nombre_archivo" => $file_name,
				"extension" => $extension,
				"folder" => $ruta_destino,
				"id_album" => $id_album

			);

		}

		$arra_json = json_encode($arra);

		$this->aParam->addParametro('arra_json', $arra_json);
		$this->arreglo['arra_json'] = $arra_json;



		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='por.ft_img_ime';
		$this->transaccion='POR_IMG_JSON';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('arra_json','arra_json','text');
		$this->setParametro('id_album','id_album','int4');


		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function modificarImg(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='por.ft_img_ime';
		$this->transaccion='POR_IMG_MOD';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_img','id_img','int4');
		$this->setParametro('estado_reg','estado_reg','varchar');
		$this->setParametro('estado','estado','varchar');
		$this->setParametro('folder','folder','int4');
		$this->setParametro('extension','extension','varchar');
		$this->setParametro('id_album','id_album','int4');
		$this->setParametro('nombre_archivo','nombre_archivo','varchar');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function eliminarImg(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='por.ft_img_ime';
		$this->transaccion='POR_IMG_ELI';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_img','id_img','int4');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
}
?>