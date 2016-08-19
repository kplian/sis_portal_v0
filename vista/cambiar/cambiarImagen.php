<?php
/**
 *@package pXP
 *@file    SubirArchivo.php
 *@author  favio figueroa
 *@date    22-03-2015
 *@description permites subir archivos a la tabla de documento_sol
 */
header("content-type: text/javascript; charset=UTF-8");
?>
<script>
    Phx.vista.CambiarImagen=Ext.extend(Phx.frmInterfaz,{
            ActSave:'../../sis_portal/control/Upload/modificarUpload',

            constructor:function(config)
            {
                Phx.vista.CambiarImagen.superclass.constructor.call(this,config);
                this.init();
                this.loadValoresIniciales();
            },

            loadValoresIniciales:function()
            {
                Phx.vista.CambiarImagen.superclass.loadValoresIniciales.call(this);
                console.log(this.datos_extras_clase)
                this.getComponente('id_cambiar').setValue(this.datos_extras_id);
                this.getComponente('clase').setValue(this.datos_extras_clase);
                this.getComponente('tabla').setValue(this.datos_extras_tabla);
                this.getComponente('folder').setValue(this.datos_extras_folder);
                this.getComponente('nombre_archivo').setValue(this.datos_extras_nombre_archivo);
                this.getComponente('tipo').setValue(this.datos_extras_tipo);
                this.getComponente('nombre_id').setValue(this.datos_extras_nombre_id);
                this.getComponente('foler_descriptivo').setValue(this.datos_extras_folder_descriptivo);
            },


            successSave:function(resp)
            {
                console.log('resp',resp);
                Phx.CP.loadingHide();
                Phx.CP.getPagina(this.idContenedorPadre).reload();
                this.panel.close();
            },


            Atributos:[
                {
                    config:{
                        labelSeparator:'',
                        inputType:'hidden',
                        name: 'id_cambiar'
                    },
                    type:'Field',
                    form:true
                },
                {
                    config:{
                        labelSeparator:'',
                        inputType:'hidden',
                        name: 'nombre_id'
                    },
                    type:'Field',
                    form:true
                },
                {
                    config:{
                        labelSeparator:'',
                        inputType:'hidden',
                        name: 'foler_descriptivo'
                    },
                    type:'Field',
                    form:true
                },

                {
                    config:{
                        labelSeparator:'',
                        inputType:'hidden',
                        name: 'tipo'
                    },
                    type:'Field',
                    form:true
                },
                {
                    config:{
                        labelSeparator:'',
                        inputType:'hidden',
                        name: 'clase'
                    },
                    type:'Field',
                    form:true
                },
                {
                    config:{
                        labelSeparator:'',
                        inputType:'hidden',
                        name: 'tabla'
                    },
                    type:'Field',
                    form:true
                },
                {
                    config:{
                        labelSeparator:'',
                        inputType:'hidden',
                        name: 'folder'
                    },
                    type:'Field',
                    form:true
                },
                {
                    config:{
                        labelSeparator:'',
                        inputType:'hidden',
                        name: 'nombre_archivo'
                    },
                    type:'Field',
                    form:true
                },
                {
                    config:{
                        fieldLabel: "Documento (archivo Pdf,Word)",
                        gwidth: 130,
                        inputType: 'file',
                        name: 'archivo',
                        allowBlank: false,
                        buttonText: '',
                        maxLength: 150,
                        anchor:'100%'
                    },
                    type:'Field',
                    form:true
                },
            ],
            title:'Subir Archivo',
            fileUpload:true

        }
    )
</script>
