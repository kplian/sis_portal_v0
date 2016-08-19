<?php
/**
 * @package pXP
 * @file gen-Img.php
 * @author  (admin)
 * @date 24-09-2015 18:53:20
 * @description Archivo con la interfaz de usuario que permite la ejecucion de todas las funcionalidades del sistema
 */

header("content-type: text/javascript; charset=UTF-8");
?>
<script>
    Phx.vista.Img = Ext.extend(Phx.gridInterfaz, {

            constructor: function (config) {
                this.maestro = config.maestro;
                //llama al constructor de la clase padre
                Phx.vista.Img.superclass.constructor.call(this, config);
                this.init();


                //this.load({params:{start:0, limit:this.tam_pag}})
            },

            Atributos: [
                {
                    //configuracion del componente
                    config: {
                        labelSeparator: '',
                        inputType: 'hidden',
                        name: 'id_img'
                    },
                    type: 'Field',
                    form: true
                },

                {
                    //configuracion del componente
                    config: {
                        labelSeparator: '',
                        inputType: 'hidden',
                        name: 'id_album'
                    },
                    type: 'Field',
                    form: true
                },
                {
                    //configuracion del componente
                    config: {
                        labelSeparator: '',
                        inputType: 'hidden',
                        name: 'album'
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
                    filters: {pfiltro: 'img.estado_reg', type: 'string'},
                    id_grupo: 1,
                    grid: true,
                    form: false
                },

                {
                    config:{
                        fieldLabel: "Foto",
                        gwidth: 130,
                        inputType:'file',
                        name: 'foto',
                        //allowBlank:true,
                        buttonText: '',
                        maxLength:150,
                        anchor:'100%',
                        renderer:function (value, p, record){
                            var img = record.data['nombre_archivo'];
                            var extension = record.data['extension'];
                            var url = record.data['folder']+'pequeno/';
                            if(img != ''){
                                return  "<div style='text-align:center'><img src = '"+url+img+"."+extension+"' align='center' width='70' height='70'/></div>";

                            }else{
                                return  "<div style='text-align:center'><img src = '../../../lib/imagenes/NoPerfilImage.jpg' align='center' width='70' height='70'/></div>";
                            }
                        },
                        buttonCfg: {
                            iconCls: 'upload-icon'
                        }
                    },
                    //type:'FileUploadField',
                    type:'Field',
                    sortable:false,
                    //filters:{type:'string'},
                    id_grupo:0,
                    grid:true,
                    form:false
                },


                {
                    config: {
                        fieldLabel: "Documento (archivo)",
                        gwidth: 130,
                        inputType: 'file',
                        name: 'archivo[]',
                        allowBlank: false,
                        buttonText: '',
                        maxLength: 150,
                        anchor: '100%',
                        listeners: {
                            render: function (me, eOpts) {

                                var el = Ext.get(me.id);
                                console.log(el)
                                el.set({
                                    multiple: 'multiple'
                                });

                            }
                        }

                    },
                    type: 'Field',
                    form: true
                },

                {
                    config: {
                        name: 'estado',
                        fieldLabel: 'estado',
                        allowBlank: true,
                        anchor: '80%',
                        gwidth: 100,
                        maxLength: 255
                    },
                    type: 'TextField',
                    filters: {pfiltro: 'img.estado', type: 'string'},
                    id_grupo: 1,
                    grid: true,
                    form: false
                },
                {
                    config: {
                        name: 'folder',
                        fieldLabel: 'folder',
                        allowBlank: true,
                        anchor: '80%',
                        gwidth: 100,
                        maxLength: 4
                    },
                    type: 'NumberField',
                    filters: {pfiltro: 'img.folder', type: 'numeric'},
                    id_grupo: 1,
                    grid: true,
                    form: false
                },
                {
                    config: {
                        name: 'extension',
                        fieldLabel: 'extension',
                        allowBlank: true,
                        anchor: '80%',
                        gwidth: 100,
                        maxLength: 255
                    },
                    type: 'TextField',
                    filters: {pfiltro: 'img.extension', type: 'string'},
                    id_grupo: 1,
                    grid: true,
                    form: false
                },

                {
                    config: {
                        name: 'nombre_archivo',
                        fieldLabel: 'nombre_archivo',
                        allowBlank: true,
                        anchor: '80%',
                        gwidth: 100,
                        maxLength: 255
                    },
                    type: 'TextField',
                    filters: {pfiltro: 'img.nombre_archivo', type: 'string'},
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
                    filters: {pfiltro: 'img.fecha_reg', type: 'date'},
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
                    filters: {pfiltro: 'img.usuario_ai', type: 'string'},
                    id_grupo: 1,
                    grid: true,
                    form: false
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
                        name: 'id_usuario_ai',
                        fieldLabel: 'Creado por',
                        allowBlank: true,
                        anchor: '80%',
                        gwidth: 100,
                        maxLength: 4
                    },
                    type: 'Field',
                    filters: {pfiltro: 'img.id_usuario_ai', type: 'numeric'},
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
                    filters: {pfiltro: 'img.fecha_mod', type: 'date'},
                    id_grupo: 1,
                    grid: true,
                    form: false
                }
            ],
            fileUpload:true,
            tam_pag: 50,
            title: 'imagenes',
            ActSave: '../../sis_portal/control/Img/insertarImg',
            ActDel: '../../sis_portal/control/Img/eliminarImg',
            ActList: '../../sis_portal/control/Img/listarImg',
            id_store: 'id_img',
            fields: [
                {name: 'id_img', type: 'numeric'},
                {name: 'estado_reg', type: 'string'},
                {name: 'estado', type: 'string'},
                {name: 'folder', type: 'string'},
                {name: 'extension', type: 'string'},
                {name: 'id_album', type: 'numeric'},
                {name: 'nombre_archivo', type: 'string'},
                {name: 'fecha_reg', type: 'date', dateFormat: 'Y-m-d H:i:s.u'},
                {name: 'usuario_ai', type: 'string'},
                {name: 'id_usuario_reg', type: 'numeric'},
                {name: 'id_usuario_ai', type: 'numeric'},
                {name: 'id_usuario_mod', type: 'numeric'},
                {name: 'fecha_mod', type: 'date', dateFormat: 'Y-m-d H:i:s.u'},
                {name: 'usr_reg', type: 'string'},
                {name: 'usr_mod', type: 'string'},

            ],
            sortInfo: {
                field: 'id_img',
                direction: 'ASC'
            },
            bdel: true,
            bsave: true,

            bedit: false,
            // bnew: false,

            preparaMenu: function (tb) {
                // llamada funcion clace padre
                Phx.vista.Img.superclass.preparaMenu.call(this, tb)
            },
            onButtonNew: function () {
                Phx.vista.Img.superclass.onButtonNew.call(this);
                this.getComponente('id_album').setValue(this.maestro.id_album);
                this.getComponente('album').setValue(this.maestro.nombre);
            },
            onReloadPage: function (m) {
                this.maestro = m;
                console.log(this.maestro);
                this.store.baseParams = {id_album: this.maestro.id_album, album: this.maestro.nombre};
                this.load({params: {start: 0, limit: 50}})
            }
        }
    )
</script>
		
		