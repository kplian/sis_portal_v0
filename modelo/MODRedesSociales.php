<?php
/**
*@package pXP
*@file gen-MODRedesSociales.php
*@author  (favio figueroa)
*@date 30-09-2015 14:38:24
*@description Clase que envia los parametros requeridos a la Base de datos para la ejecucion de las funciones, y que recibe la respuesta del resultado de la ejecucion de las mismas
*/




require_once(dirname(__DIR__).'/lib/src/Facebook/autoload.php');

class MODRedesSociales extends MODbase{
	
	function __construct(CTParametro $pParam){
		parent::__construct($pParam);

		$this->cone = new conexion();
		$this->link = $this->cone->conectarpdo(); //conexion a pxp(postgres)

	}
			
	function listarRedesSociales(){

		//Definicion de variables para ejecucion del procedimientp
		$this->procedimiento='por.ft_redes_sociales_sel';
		$this->transaccion='POR_REDS_SEL';
		$this->tipo_procedimiento='SEL';//tipo de transaccion



		//Definicion de la lista del resultado del query
		$this->captura('id_redes_sociales','int4');
		$this->captura('url_page','varchar');
		$this->captura('estado_reg','varchar');
		$this->captura('token_api','text');
		$this->captura('nombre','varchar');
		$this->captura('descripcion','varchar');
		$this->captura('id','varchar');
		$this->captura('fecha_reg','timestamp');
		$this->captura('usuario_ai','varchar');
		$this->captura('id_usuario_reg','int4');
		$this->captura('id_usuario_ai','int4');
		$this->captura('id_usuario_mod','int4');
		$this->captura('fecha_mod','timestamp');
		$this->captura('usr_reg','varchar');
		$this->captura('usr_mod','varchar');
		$this->captura('tipo','varchar');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();
		
		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function insertarRedesSociales(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='por.ft_redes_sociales_ime';
		$this->transaccion='POR_REDS_INS';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('url_page','url_page','varchar');
		$this->setParametro('estado_reg','estado_reg','varchar');
		$this->setParametro('token_api','token_api','text');
		$this->setParametro('nombre','nombre','varchar');
		$this->setParametro('descripcion','descripcion','varchar');
		$this->setParametro('id','id','varchar');
		$this->setParametro('tipo','tipo','varchar');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function modificarRedesSociales(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='por.ft_redes_sociales_ime';
		$this->transaccion='POR_REDS_MOD';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_redes_sociales','id_redes_sociales','int4');
		$this->setParametro('url_page','url_page','varchar');
		$this->setParametro('estado_reg','estado_reg','varchar');
		$this->setParametro('token_api','token_api','text');
		$this->setParametro('nombre','nombre','varchar');
		$this->setParametro('descripcion','descripcion','varchar');
		$this->setParametro('id','id','varchar');
		$this->setParametro('tipo','tipo','varchar');


		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function eliminarRedesSociales(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='por.ft_redes_sociales_ime';
		$this->transaccion='POR_REDS_ELI';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_redes_sociales','id_redes_sociales','int4');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}

	function subirfb(){


		$arra = array();
		$id = $this->aParam->getParametro('id');
		$tabla = $this->aParam->getParametro('tabla');
		$nombre_id = $this->aParam->getParametro('nombre_id');
		$nombre_archivo = $this->aParam->getParametro('nombre_archivo');
		$clase = $this->aParam->getParametro('clase');
		$extension = $this->aParam->getParametro('extension');
		$contenido = $this->aParam->getParametro('contenido');

		$carpeta_contenedora_del_archivo = '../../../uploaded_files/sis_portal/'.$clase.'/'.$nombre_archivo.'.'.$extension;





		$tipo_red_social =$this->aParam->getParametro('tipo');

		try {
			$this->link->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$this->link->beginTransaction();
			$stmt = $this->link->prepare("select * from por.tredes_sociales
								where tipo = '$tipo_red_social'");
			$stmt->execute();
			$result = $stmt->fetch(PDO::FETCH_ASSOC);


			//$stmt2 = $this->link->prepare("select * from por.".$tabla." where ".$nombre_id." = '$id'  ");
			//$stmt2->execute();
			//$result2 = $stmt2->fetch(PDO::FETCH_ASSOC);





			$fb = new Facebook\Facebook([
				'app_id' => '479185945595705',
				'app_secret' => '4b23ed39dd600dec903d3b43ec86c167',
				'default_graph_version' => 'v2.4',

				//'cookie' => true,
			]);

			$helper = $fb->getRedirectLoginHelper();

			$_SESSION['facebook_access_token'] = $result['token_api'];


			try {
				if (isset($_SESSION['facebook_access_token'])) {
					$accessToken = $_SESSION['facebook_access_token'];
				} else {
					$accessToken = $helper->getAccessToken();


				}
			} catch(Facebook\Exceptions\FacebookResponseException $e) {
				// When Graph returns an error
				echo 'Graph returned an error: ' . $e->getMessage();
				exit;
			} catch(Facebook\Exceptions\FacebookSDKException $e) {
				// When validation fails or other local issues
				echo 'Facebook SDK returned an error: ' . $e->getMessage();
				exit;
			}

			if (isset($accessToken)) {


				if(isset($_SESSION['facebook_access_token'])) {
					$fb->setDefaultAccessToken($_SESSION['facebook_access_token']);
				} else {
					// Logged in!
					$_SESSION['facebook_access_token'] = (string) $accessToken;

					// OAuth 2.0 client handler
					$oAuth2Client = $fb->getOAuth2Client();

					// Exchanges a short-lived access token for a long-lived one
					$longLivedAccessToken = $oAuth2Client->getLongLivedAccessToken($_SESSION['facebook_access_token']);

					$fb->setDefaultAccessToken($_SESSION['facebook_access_token']);
				}

				try {


					$response = $fb->get('/me');
					$userNode = $response->getGraphUser();

					/*$data = ['message' => 'mensaje de prueba del sistema...',
							'link'=>'http://www.motorepuestosledezma.com'];
                    // updating status on user timeline
                    $request = $fb->post('/me/feed', $data);
                    $response = $request->getGraphUser();*/

					// message must come from the user-end
					$data = ['source' => $fb->fileToUpload($carpeta_contenedora_del_archivo), 'message' => $contenido];

					$request = $fb->post('/me/photos', $data);
					$response = $request->getGraphUser();



				} catch(Facebook\Exceptions\FacebookResponseException $e) {
					// When Graph returns an error
					echo 'Graph returned an error: ' . $e->getMessage();
					unset($_SESSION['facebook_access_token']);
					exit;
				} catch(Facebook\Exceptions\FacebookSDKException $e) {
					// When validation fails or other local issues
					echo 'Facebook SDK returned an error: ' . $e->getMessage();
					exit;
				}

				//echo 'Logged in as ' . $userNode->getName() . 'y el id de la subida'. $response['id'];
				//echo 'Logged in as ' . $userNode->getName() . 'y el id de la subida';

				// Now you can redirect to another page and use the
				// access token from $_SESSION['facebook_access_token']


				$arra[] = array(
					"post_id" => $response['post_id'],
					"id" => $response['id'],
					"usuario_face" => $userNode->getName()
				);

				$this->respuesta = new Mensaje();
				$this->respuesta->setMensaje('EXITO', $this->nombre_archivo, 'la subida fue con exito', 'La consulta se ejecuto con exito', 'base', 'no tiene', 'no tiene', 'SEL', '$this->consulta', 'no tiene');
				$this->respuesta->setTotal(1);
				$this->respuesta->setDatos($arra);
				return $this->respuesta;

			} else {
				$permissions = ['email', 'publish_actions']; // optional
				$loginUrl = $helper->getLoginUrl('http://www.prueba.motorepuestosledezma.com/', $permissions);

				echo '<a href="' . $loginUrl . '">Log in with Facebook!</a>';
			}








		}catch (Exception $e) {


		}






	}
			
}
?>