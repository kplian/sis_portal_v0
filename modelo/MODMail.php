<?php
/**
 * @package pXP
 * @file gen-MODSlider.php
 * @author  (favio figueroa)
 * @date 18-09-2015 13:41:35
 * @description Clase que envia los parametros requeridos a la Base de datos para la ejecucion de las funciones, y que recibe la respuesta del resultado de la ejecucion de las mismas
 */

include(dirname(__FILE__).'/../lib/PHPMailer-master/PHPMailerAutoload.php');

class MODMail extends MODbase
{

    function __construct(CTParametro $pParam)
    {
        parent::__construct($pParam);

        $this->cone = new conexion();
        $this->link = $this->cone->conectarpdo(); //conexion a pxp(postgres)
    }

    function mandarMensaje(){


        $destino  = $this->aParam->getParametro('destino');
        $mensaje  = $this->aParam->getParametro('mensaje');
        $nombre  = $this->aParam->getParametro('nombre');
        $email_emisor  = $this->aParam->getParametro('email');

        $mail = new PHPMailer;
        $mail->isSMTP();
        $mail->SMTPDebug = false;
        $mail->Debugoutput = 'html';
        $mail->Host = 'smtp.gmail.com';
        $mail->Port = 587;

        $mail->SMTPSecure = 'tls';

        $mail->SMTPAuth = true;

        $mail->Username = "tiquipayaweb@gmail.com";

        $mail->Password = "Mund0libre";

        $mail->setFrom('web_tiqui', 'web_tiqui');


        $mail->addAddress($destino, $nombre);


        $mail->Subject = 'de:'.$email_emisor;


        $mail->msgHTML('<div style="background-color: #006699;">'.$mensaje.'</div>');

        $mail->AltBody = 'This is a plain-text message body';


        //$mail->addAttachment('images/phpmailer_mini.png');

        if (!$mail->send()) {
            echo "Mailer Error: " . $mail->ErrorInfo;
        } else {
            //echo "Message sent!";

            $this->respuesta = new Mensaje();
            $this->respuesta->setMensaje('EXITO', $this->nombre_archivo, 'la subida fue con exito', 'La consulta se ejecuto con exito', 'base', 'no tiene', 'no tiene', 'SEL', '$this->consulta', 'no tiene');
            $this->respuesta->setTotal(1);
            $this->respuesta->setDatos('mensaje enviado correctamente');
            return $this->respuesta;
        }

    }

}

?>