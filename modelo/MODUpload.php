<?php

/**
 * Created by PhpStorm.
 * User: isa
 * Date: 9/20/2015
 * Time: 9:51 PM
 */
class MODUpload extends MODbase{

    function __construct(CTParametro $pParam){
        parent::__construct($pParam);

        $this->cone = new conexion();
        $this->link = $this->cone->conectarpdo(); //conexion a pxp(postgres)
    }

    function modificarUpload()
    {

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
            $this->procedimiento='por.ft_upload_ime';
            $this->transaccion='POR_UPLOAD_MOD';
            $this->tipo_procedimiento='IME';


            $ext = pathinfo($this->arregloFiles['archivo']['name']);
            $this->arreglo['extension'] = $ext['extension'];
            $extension = $ext['extension'];
            $unico_id = uniqid();

            //crea un unico id para el nombre
            $this->aParam->addParametro('unico_id', $unico_id);
            $this->arreglo['unico_id'] = $unico_id;
            $this->setParametro('unico_id','unico_id','varchar');


            //validar que no sea un arhvio en blanco
            $file_name = $this->getFileName2('archivo', 'unico_id', '', false);


            //Define los parametros para la funcion
            $this->setParametro('extension','extension','varchar');

            //manda como parametro la url completa del archivo
            $this->aParam->addParametro('file_name', $file_name[2]);
            $this->arreglo['file_name'] = $file_name[2];
            $this->setParametro('url_original','file_name','varchar');


            //manda como parametro el folder del arhivo
            $this->aParam->addParametro('folder2', $file_name[1]);
            $this->arreglo['folder2'] = $file_name[1];
            $this->setParametro('folder2','folder','varchar');

            //manda como parametro el solo el nombre del arhivo  sin extencion
            $this->aParam->addParametro('only_file2', $file_name[0]);
            $this->arreglo['only_file2'] = $file_name[0];
            $this->setParametro('nombre_archivo2','only_file','varchar');




            $configuraciones  = $this->verConfiguracion($this->aParam->getParametro('clase'));
            $validado = $configuraciones[0]['validado'];
            $ancho_original = $configuraciones[0]['ancho_original'];
            $ancho_mediano = $configuraciones[0]['ancho_mediano'];
            $ancho_pequeno = $configuraciones[0]['ancho_pequeno'];
            $url_original_registrado = $this->aParam->getParametro('foler_descriptivo').$file_name[0].'.'.$extension;


            $this->aParam->addParametro('url_original_registrado', $url_original_registrado);
            $this->arreglo['url_original_registrado'] = $url_original_registrado;
            $this->setParametro('url_original_registrado','url_original_registrado','varchar');


            $tabla = $this->aParam->getParametro('tabla');
            $nombre_archivo = $this->aParam->getParametro('nombre_archivo');
            $folder = $this->aParam->getParametro('folder');
            $nombre_id = $this->aParam->getParametro('nombre_id');
            $id_cambiar = $this->aParam->getParametro('id_cambiar');



            $consulta = "".$tabla.",".$nombre_archivo.",".$file_name[0].",".$extension.",".$nombre_id.",".$id_cambiar."";

            $this->aParam->addParametro('consulta', $consulta);
            $this->arreglo['consulta'] = $consulta;
            $this->setParametro('consulta','consulta','varchar');

            //Ejecuta la instruccion
            $this->armarConsulta();
            $stmt = $link->prepare($this->consulta);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            $resp_procedimiento = $this->divRespuesta($result['f_intermediario_ime']);




            if ($resp_procedimiento['tipo_respuesta']=='ERROR') {
                throw new Exception("Error al ejecutar en la bd", 3);
            }



            /*$res = $this->link->prepare("update por.".$tabla." set ".$nombre_archivo." = '$file_name[0]' , extension = '$extension'
                                        where ".$nombre_id." = '$id_cambiar' ");*/



            $clase = $this->aParam->getParametro('clase');

            $this->setFileModificacion('sis_portal',$clase,'archivo','unico_id', false,100000 ,array('doc','pdf','docx','jpg','jpeg','bmp','gif','png','PDF','DOC','DOCX','xls','xlsx','XLS','XLSX','rar'));


            if($this->aParam->getParametro('tipo') == 'imagen'){
                if($validado == 'si'){
                    if($this->validacionImagen('file_name','extension',$ancho_original) == false){
                        throw new Exception("el tamaño de imagen esta mal debe ser ".$ancho_original."");
                    }
                }

                $url_original = $this->aParam->getParametro('foler_descriptivo');
                $url_mediano = $url_original."mediano/";
                $url_pequeno = $url_original."pequeno/";

                $mediana = $this->convertirTamanoImagen('url_original_registrado',$ancho_mediano,'extension',$url_mediano,$file_name[0]);
                $pequena = $this->convertirTamanoImagen('url_original_registrado',$ancho_pequeno,'extension',$url_pequeno,$file_name[0]);

            }


            $link->commit();
            $this->respuesta=new Mensaje();
            $this->respuesta->setMensaje($resp_procedimiento['tipo_respuesta'],$this->nombre_archivo,$resp_procedimiento['mensaje'],$resp_procedimiento['mensaje_tec'],'base',$this->procedimiento,$this->transaccion,$this->tipo_procedimiento,$this->consulta);
            $this->respuesta->setDatos($respuesta);



        }catch (Exception $e) {
            $link->rollBack();


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
}
