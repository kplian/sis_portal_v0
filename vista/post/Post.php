<?php
/**
*@package pXP
*@file gen-Post.php
*@author  (admin)
*@date 20-09-2015 18:43:35
*@description Archivo con la interfaz de usuario que permite la ejecucion de todas las funcionalidades del sistema
*/

header("content-type: text/javascript; charset=UTF-8");
?>
<script>
Phx.vista.Post=Ext.extend(Phx.gridInterfaz,{

	constructor:function(config){
		this.maestro=config.maestro;
    	//llama al constructor de la clase padre
		Phx.vista.Post.superclass.constructor.call(this,config);
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

		this.load({params:{start:0, limit:this.tam_pag}})

		this.iniciarEventos();

	},
		iniciarEventos: function () {




		},
			
	Atributos:[
		{
			//configuracion del componente
			config:{
					labelSeparator:'',
					inputType:'hidden',
					name: 'id_post'
			},
			type:'Field',
			form:true 
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
					var img = record.data['nombre_imagen'];
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
			config:{
				fieldLabel: "Documento (archivo)",
				gwidth: 130,
				inputType: 'file',
				name: 'archivo',
				allowBlank: false,
				buttonText: '',
				maxLength: 150,
				anchor:'100%',
				/*listeners: {
						render: function (me, eOpts) {

							var el = Ext.get(me.id);
							console.log(el)
							el.set({
								multiple: 'multiple'
							});

						}
					}*/
			},
			type:'Field',
			form:true
		},
		{
			config:{
				name: 'fecha',
				fieldLabel: 'fecha',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
							format: 'd/m/Y', 
							renderer:function (value,p,record){return value?value.dateFormat('d/m/Y'):''}
			},
				type:'DateField',
				filters:{pfiltro:'pos.fecha',type:'date'},
				id_grupo:1,
				grid:true,
				form:true
		},
		{
			config:{
				name: 'folder',
				fieldLabel: 'folder',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				maxLength:255
			},
				type:'TextField',
				filters:{pfiltro:'pos.folder',type:'string'},
				id_grupo:1,
				grid:true,
				form:false
		},
		{
			config:{
				name: 'titulo',
				fieldLabel: 'titulo',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				maxLength:255
			},
				type:'TextField',
				filters:{pfiltro:'pos.titulo',type:'string'},
				id_grupo:1,
				grid:true,
				form:true
		},
		{
			config:{
				name: 'estado',
				fieldLabel: 'estado',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				maxLength:255
			},
				type:'TextField',
				filters:{pfiltro:'pos.estado',type:'string'},
				id_grupo:1,
				grid:true,
				form:true
		},
		{
			config:{
				name: 'contenido',
				fieldLabel: 'Contenido',
				anchor: '80%'
			},
			type:'HtmlEditor',
			id_grupo:1,
			form:true
		},
		/*{
			config:{
				name: 'contenido',
				fieldLabel: 'contenido',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				maxLength:-5
			},
				type:'TextField',
				filters:{pfiltro:'pos.contenido',type:'string'},
				id_grupo:1,
				grid:true,
				form:true
		},*/
		{
			config:{
				name: 'nombre_imagen',
				fieldLabel: 'nombre_imagen',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				maxLength:255
			},
				type:'TextField',
				filters:{pfiltro:'pos.nombre_imagen',type:'string'},
				id_grupo:1,
				grid:true,
				form:false
		},
		{
			config:{
				name: 'subtitulo',
				fieldLabel: 'subtitulo',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				maxLength:255
			},
				type:'TextField',
				filters:{pfiltro:'pos.subtitulo',type:'string'},
				id_grupo:1,
				grid:true,
				form:true
		},
		{
			config:{
				name: 'url_autor',
				fieldLabel: 'url_autor',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				maxLength:255
			},
				type:'TextField',
				filters:{pfiltro:'pos.url_autor',type:'string'},
				id_grupo:1,
				grid:true,
				form:true
		},
		{
			config:{
				name: 'estado_reg',
				fieldLabel: 'Estado Reg.',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				maxLength:10
			},
				type:'TextField',
				filters:{pfiltro:'pos.estado_reg',type:'string'},
				id_grupo:1,
				grid:true,
				form:false
		},
		{
			config:{
				name: 'extension',
				fieldLabel: 'extension',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				maxLength:255
			},
				type:'TextField',
				filters:{pfiltro:'pos.extension',type:'string'},
				id_grupo:1,
				grid:true,
				form:false
		},
		{
			config:{
				name: 'id_usuario_ai',
				fieldLabel: '',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				maxLength:4
			},
				type:'Field',
				filters:{pfiltro:'pos.id_usuario_ai',type:'numeric'},
				id_grupo:1,
				grid:false,
				form:false
		},
		{
			config:{
				name: 'usr_reg',
				fieldLabel: 'Creado por',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				maxLength:4
			},
				type:'Field',
				filters:{pfiltro:'usu1.cuenta',type:'string'},
				id_grupo:1,
				grid:true,
				form:false
		},
		{
			config:{
				name: 'fecha_reg',
				fieldLabel: 'Fecha creación',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
							format: 'd/m/Y', 
							renderer:function (value,p,record){return value?value.dateFormat('d/m/Y H:i:s'):''}
			},
				type:'DateField',
				filters:{pfiltro:'pos.fecha_reg',type:'date'},
				id_grupo:1,
				grid:true,
				form:false
		},
		{
			config:{
				name: 'usuario_ai',
				fieldLabel: 'Funcionaro AI',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				maxLength:300
			},
				type:'TextField',
				filters:{pfiltro:'pos.usuario_ai',type:'string'},
				id_grupo:1,
				grid:true,
				form:false
		},
		{
			config:{
				name: 'fecha_mod',
				fieldLabel: 'Fecha Modif.',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
							format: 'd/m/Y', 
							renderer:function (value,p,record){return value?value.dateFormat('d/m/Y H:i:s'):''}
			},
				type:'DateField',
				filters:{pfiltro:'pos.fecha_mod',type:'date'},
				id_grupo:1,
				grid:true,
				form:false
		},
		{
			config:{
				name: 'usr_mod',
				fieldLabel: 'Modificado por',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				maxLength:4
			},
				type:'Field',
				filters:{pfiltro:'usu2.cuenta',type:'string'},
				id_grupo:1,
				grid:true,
				form:false
		}
	],
		fileUpload:true,
	tam_pag:50,	
	title:'Post',
	ActSave:'../../sis_portal/control/Post/insertarPost',
	ActDel:'../../sis_portal/control/Post/eliminarPost',
	ActList:'../../sis_portal/control/Post/listarPost',
	id_store:'id_post',
	fields: [
		{name:'id_post', type: 'numeric'},
		{name:'fecha', type: 'date',dateFormat:'Y-m-d'},
		{name:'folder', type: 'string'},
		{name:'titulo', type: 'string'},
		{name:'estado', type: 'string'},
		{name:'contenido', type: 'string'},
		{name:'nombre_imagen', type: 'string'},
		{name:'subtitulo', type: 'string'},
		{name:'url_autor', type: 'string'},
		{name:'estado_reg', type: 'string'},
		{name:'extension', type: 'string'},
		{name:'id_usuario_ai', type: 'numeric'},
		{name:'id_usuario_reg', type: 'numeric'},
		{name:'fecha_reg', type: 'date',dateFormat:'Y-m-d H:i:s.u'},
		{name:'usuario_ai', type: 'string'},
		{name:'fecha_mod', type: 'date',dateFormat:'Y-m-d H:i:s.u'},
		{name:'id_usuario_mod', type: 'numeric'},
		{name:'usr_reg', type: 'string'},
		{name:'usr_mod', type: 'string'},
		
	],
	sortInfo:{
		field: 'id_post',
		direction: 'ASC'
	},
	bdel:true,
	bsave:true,
		cambiar: function () {
			var rec = this.sm.getSelected();

			rec.datos_extras_id = rec.data.id_post;
			rec.datos_extras_clase = 'Post';
			rec.datos_extras_tipo = 'imagen'; //puede ser documento
			rec.datos_extras_tabla = 'tpost';
			rec.datos_extras_nombre_archivo = 'nombre_imagen';
			rec.datos_extras_folder = 'folder';
			rec.datos_extras_nombre_id = 'id_post';
			rec.datos_extras_folder_descriptivo = './../../../uploaded_files/sis_portal/Post/';


			console.log(rec);


			Phx.CP.loadWindows('../../../sis_portal/vista/cambiar/cambiarImagen.php',
				'Interfaces',
				{
					width: 400,
					height: 200
				}, rec, this.idContenedor, 'CambiarImagen');


		},

		subirFb: function () {
			var rec = this.sm.getSelected();

			console.log(rec);
			Phx.CP.loadingShow();
			Ext.Ajax.request({
				url:'../../sis_portal/control/RedesSociales/subirfb',
				params:{'start':0,'limit':1,'id':rec.data['id_post'],
					'nombre_id':'id_post','tabla':'tpost',
					'clase':'Post','extension':rec.data['extension'],
					'tipo':'facebook','folder':rec.data['folder'],
					'nombre_archivo':rec.data['nombre_imagen'],
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
		}
	}
)
</script>
		
		