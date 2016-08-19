<?php
/**
 * Created by PhpStorm.
 * User: isa
 * Date: 9/20/2015
 * Time: 9:48 PM
 */

class ACTUpload extends ACTbase
{

    function modificarUpload()
    {
        $this->objFunc=$this->create('MODUpload');
        $this->res=$this->objFunc->modificarUpload($this->objParam);
        $this->res->imprimirRespuesta($this->res->generarJson());

    }
}