<?php
/**
 * @package pXP
 * @file gen-Slider.php
 * @author  (admin)
 * @date 18-09-2015 13:41:35
 * @description Archivo con la interfaz de usuario que permite la ejecucion de todas las funcionalidades del sistema
 */

header("content-type: text/javascript; charset=UTF-8");
?>
<script>
    Phx.vista.Slider = Ext.extend(Phx.gridInterfaz, {

            constructor: function (config) {

                //FAVIO
                this.maestro = config.maestro;
                //llama al constructor de la clase padre
                Phx.vista.Slider.superclass.constructor.call(this, config);
                this.init();
                this.addButton('cambiar Imagen', {
                    argument: {imprimir: 'cambiar Imagen'},
                    text: '<i class="fa fa-thumbs-o-up fa-2x"></i> cambiar Imagen', /*iconCls:'' ,*/
                    disabled: false,
                    handler: this.cambiar
                });

                this.addButton('Subir FB', {
                    argument: {imprimir: 'Subir FB'},
                    text: '<i class="fa fa-facebook-official fa-2x"></i> Subir FB', /*iconCls:'' ,*/
                    disabled: false,
                    handler: this.subirFb
                });


                this.addButton('Enviar Mensaje', {
                    argument: {imprimir: 'Mensaje'},
                    text: '<i class="fa fa-facebook-official fa-2x"></i> Mensaje', /*iconCls:'' ,*/
                    disabled: false,
                    handler: this.mensaje
                });


                this.load({params: {start: 0, limit: this.tam_pag}})
            },

            Atributos: [
                {
                    //configuracion del componente
                    config: {
                        labelSeparator: '',
                        inputType: 'hidden',
                        name: 'id_slider'
                    },
                    type: 'Field',
                    form: true
                },

                {
                    config: {
                        fieldLabel: "Documento (archivo)",
                        gwidth: 130,
                        inputType: 'file',
                        name: 'archivo',
                        allowBlank: false,
                        buttonText: '',
                        maxLength: 150,
                        anchor: '100%'
                    },
                    type: 'Field',
                    form: true
                },


                {
                    config: {
                        name: 'estado_reg',
                        fieldLabel: 'Estado Reg.',
                        allowBlank: true,
                        anchor: '80%',
                        gwidth: 100,
                        maxLength: 10
                    },
                    type: 'TextField',
                    filters: {pfiltro: 'slid.estado_reg', type: 'string'},
                    id_grupo: 1,
                    grid: true,
                    form: false
                },

                {
                    config: {
                        fieldLabel: "Foto",
                        gwidth: 130,
                        inputType: 'file',
                        name: 'foto',
                        //allowBlank:true,
                        buttonText: '',
                        maxLength: 150,
                        anchor: '100%',
                        renderer: function (value, p, record) {
                            var img = record.data['nombre_archivo'];
                            var extension = record.data['extension'];
                            var url = record.data['url_original'] + 'pequeno/';
                            if (img != '') {
                                return "<div style='text-align:center'><img src = '" + url + img + "." + extension + "' align='center' width='70' height='70'/></div>";

                            } else {
                                return "<div style='text-align:center'><img src = '../../../lib/imagenes/NoPerfilImage.jpg' align='center' width='70' height='70'/></div>";
                            }
                        },
                        buttonCfg: {
                            iconCls: 'upload-icon'
                        }
                    },
                    //type:'FileUploadField',
                    type: 'Field',
                    sortable: false,
                    //filters:{type:'string'},
                    id_grupo: 0,
                    grid: true,
                    form: false
                },

                {
                    config: {
                        name: 'titulo',
                        fieldLabel: 'titulo',
                        allowBlank: true,
                        anchor: '80%',
                        gwidth: 100,
                        maxLength: 255
                    },
                    type: 'TextField',
                    filters: {pfiltro: 'slid.titulo', type: 'string'},
                    id_grupo: 1,
                    grid: true,
                    form: true
                },

                {
                    config: {
                        name: 'descripcion',
                        fieldLabel: 'descripcion',
                        allowBlank: true,
                        anchor: '80%',
                        gwidth: 100,
                        maxLength: 255
                    },
                    type: 'TextField',
                    filters: {pfiltro: 'slid.descripcion', type: 'string'},
                    id_grupo: 1,
                    grid: true,
                    form: true
                },
                {
                    config: {
                        name: 'orden',
                        fieldLabel: 'orden',
                        allowBlank: true,
                        anchor: '80%',
                        gwidth: 100,
                        maxLength: 4
                    },
                    type: 'NumberField',
                    filters: {pfiltro: 'slid.orden', type: 'numeric'},
                    id_grupo: 1,
                    grid: true,
                    form: true
                },


                {
                    config: {
                        name: 'usr_reg',
                        fieldLabel: 'Creado por',
                        allowBlank: true,
                        anchor: '80%',
                        gwidth: 100,
                        maxLength: 4
                    },
                    type: 'Field',
                    filters: {pfiltro: 'usu1.cuenta', type: 'string'},
                    id_grupo: 1,
                    grid: true,
                    form: false
                },
                {
                    config: {
                        name: 'fecha_reg',
                        fieldLabel: 'Fecha creación',
                        allowBlank: true,
                        anchor: '80%',
                        gwidth: 100,
                        format: 'd/m/Y',
                        renderer: function (value, p, record) {
                            return value ? value.dateFormat('d/m/Y H:i:s') : ''
                        }
                    },
                    type: 'DateField',
                    filters: {pfiltro: 'slid.fecha_reg', type: 'date'},
                    id_grupo: 1,
                    grid: true,
                    form: false
                },
                {
                    config: {
                        name: 'usuario_ai',
                        fieldLabel: 'Funcionaro AI',
                        allowBlank: true,
                        anchor: '80%',
                        gwidth: 100,
                        maxLength: 300
                    },
                    type: 'TextField',
                    filters: {pfiltro: 'slid.usuario_ai', type: 'string'},
                    id_grupo: 1,
                    grid: true,
                    form: false
                },
                {
                    config: {
                        name: 'id_usuario_ai',
                        fieldLabel: 'Funcionaro AI',
                        allowBlank: true,
                        anchor: '80%',
                        gwidth: 100,
                        maxLength: 4
                    },
                    type: 'Field',
                    filters: {pfiltro: 'slid.id_usuario_ai', type: 'numeric'},
                    id_grupo: 1,
                    grid: false,
                    form: false
                },
                {
                    config: {
                        name: 'usr_mod',
                        fieldLabel: 'Modificado por',
                        allowBlank: true,
                        anchor: '80%',
                        gwidth: 100,
                        maxLength: 4
                    },
                    type: 'Field',
                    filters: {pfiltro: 'usu2.cuenta', type: 'string'},
                    id_grupo: 1,
                    grid: true,
                    form: false
                },
                {
                    config: {
                        name: 'fecha_mod',
                        fieldLabel: 'Fecha Modif.',
                        allowBlank: true,
                        anchor: '80%',
                        gwidth: 100,
                        format: 'd/m/Y',
                        renderer: function (value, p, record) {
                            return value ? value.dateFormat('d/m/Y H:i:s') : ''
                        }
                    },
                    type: 'DateField',
                    filters: {pfiltro: 'slid.fecha_mod', type: 'date'},
                    id_grupo: 1,
                    grid: true,
                    form: false
                }
            ],
            fileUpload: true,
            tam_pag: 50,
            title: 'SLIDER',
            ActSave: '../../sis_portal/control/Slider/insertarSlider',
            ActDel: '../../sis_portal/control/Slider/eliminarSlider',
            ActList: '../../sis_portal/control/Slider/listarSlider',
            id_store: 'id_slider',
            fields: [
                {name: 'id_slider', type: 'numeric'},
                {name: 'extension', type: 'string'},
                {name: 'url_pequeno', type: 'string'},
                {name: 'estado_reg', type: 'string'},
                {name: 'url_original', type: 'string'},
                {name: 'estado', type: 'string'},
                {name: 'url_mediano', type: 'string'},
                {name: 'descripcion', type: 'string'},
                {name: 'orden', type: 'numeric'},
                {name: 'nombre_archivo', type: 'string'},
                {name: 'titulo', type: 'string'},
                {name: 'id_usuario_reg', type: 'numeric'},
                {name: 'fecha_reg', type: 'date', dateFormat: 'Y-m-d H:i:s.u'},
                {name: 'usuario_ai', type: 'string'},
                {name: 'id_usuario_ai', type: 'numeric'},
                {name: 'id_usuario_mod', type: 'numeric'},
                {name: 'fecha_mod', type: 'date', dateFormat: 'Y-m-d H:i:s.u'},
                {name: 'usr_reg', type: 'string'},
                {name: 'usr_mod', type: 'string'},


            ],
            sortInfo: {
                field: 'id_slider',
                direction: 'ASC'
            },
            bdel: true,
            bsave: true,
            onButtonNew: function () {
                alert('asd');
                Phx.vista.Slider.superclass.onButtonNew.call(this);
                this.getComponente('archivo').show();

            },
            onButtonEdit: function () {
                alert('asd');
                Phx.vista.Slider.superclass.onButtonEdit.call(this);
                this.getComponente('archivo').hide();

            },
            cambiar: function () {
                var rec = this.sm.getSelected();


                rec.datos_extras_id = rec.data.id_slider;
                rec.datos_extras_clase = 'Slider';
                rec.datos_extras_tipo = 'imagen'; //puede ser documento
                rec.datos_extras_tabla = 'tslider';
                rec.datos_extras_nombre_archivo = 'nombre_archivo';
                rec.datos_extras_folder = 'url_original';
                rec.datos_extras_nombre_id = 'id_slider';
                rec.datos_extras_folder_descriptivo = './../../../uploaded_files/sis_portal/Slider/';


                console.log(rec);


                Phx.CP.loadWindows('../../../sis_portal/vista/cambiar/cambiarImagen.php',
                    'Interfaces',
                    {
                        width: 900,
                        height: 400
                    }, rec, this.idContenedor, 'CambiarImagen');

                /*Ext.Ajax.request({
                 url:'../../sis_facturacion/control/Nota/generarNota',
                 params:{'notas':rec.data['id_nota'],'reimpresion':'si'},
                 success: this.successExport,
                 failure: this.conexionFailure,
                 timeout:this.timeout,
                 scope:this
                 });*/
            },
            subirFb: function () {
                var rec = this.sm.getSelected();

                console.log(rec);
                Phx.CP.loadingShow();
                Ext.Ajax.request({
                        url:'../../sis_portal/control/RedesSociales/subirfb',
                        params:{'start':0,'limit':1,'id':rec.data['id_slider'],
                                'nombre_id':'id_slider','tabla':'tslider',
                                'clase':'Slider','extension':rec.data['extension'],
                                'tipo':'facebook','folder':rec.data['url_original'],
                                'nombre_archivo':rec.data['nombre_archivo'],
                                'extension':rec.data['extension'],
                                'contenido':rec.data['descripcion']},
                        success: this.successFace,
                        failure: this.conexionFailure,
                        timeout:this.timeout,
                        scope:this
                });



            },
            successFace:function(resp){
                Phx.CP.loadingHide();
                var objRes = Ext.util.JSON.decode(Ext.util.Format.trim(resp.responseText));
                console.log(objRes.datos)
            },

            mensaje: function () {

                Ext.Ajax.request({
                    url:'../../sis_portal/control/Mail/mandarMensaje',
                    params:{'destino':'fabiofigueroap@gmail.com','mensaje':'hola amigo',

                        'nombre':'el jefe'},
                    success: this.successMensaje,
                    failure: this.conexionFailure,
                    timeout:this.timeout,
                    scope:this
                });
            },
            successMensaje:function(resp){
                console.log(resp)
            },

        }
    )
</script>
		
		