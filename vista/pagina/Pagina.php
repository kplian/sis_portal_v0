<?php
/**
*@package pXP
*@file gen-Pagina.php
*@author  (admin)
*@date 03-04-2016 17:58:39
*@description Archivo con la interfaz de usuario que permite la ejecucion de todas las funcionalidades del sistema
*/

header("content-type: text/javascript; charset=UTF-8");
?>
<script>
Phx.vista.Pagina=Ext.extend(Phx.gridInterfaz,{

	constructor:function(config){
		this.maestro=config.maestro;
    	//llama al constructor de la clase padre
		Phx.vista.Pagina.superclass.constructor.call(this,config);
		this.init();
		this.load({params:{start:0, limit:this.tam_pag}})
	},
			
	Atributos:[
		{
			//configuracion del componente
			config:{
					labelSeparator:'',
					inputType:'hidden',
					name: 'id_pagina'
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
					var img = record.data['nombre_archivo'];
					var extension = record.data['extension'];
					var url = record.data['ruta_archivo']+'pequeno/';
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
				name: 'descripcion',
				fieldLabel: 'descripcion',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				maxLength:255
			},
				type:'TextField',
				filters:{pfiltro:'pag.descripcion',type:'string'},
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
				filters:{pfiltro:'pag.estado_reg',type:'string'},
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
				filters:{pfiltro:'pag.titulo',type:'string'},
				id_grupo:1,
				grid:true,
				form:true
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
				filters:{pfiltro:'pag.id_usuario_ai',type:'numeric'},
				id_grupo:1,
				grid:false,
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
				filters:{pfiltro:'pag.fecha_reg',type:'date'},
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
				filters:{pfiltro:'pag.usuario_ai',type:'string'},
				id_grupo:1,
				grid:true,
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
				filters:{pfiltro:'pag.fecha_mod',type:'date'},
				id_grupo:1,
				grid:true,
				form:false
		}
	],
		fileUpload:true,
	tam_pag:50,	
	title:'Pagina',
	ActSave:'../../sis_portal/control/Pagina/insertarPagina',
	ActDel:'../../sis_portal/control/Pagina/eliminarPagina',
	ActList:'../../sis_portal/control/Pagina/listarPagina',
	id_store:'id_pagina',
	fields: [
		{name:'id_pagina', type: 'numeric'},
		{name:'descripcion', type: 'string'},
		{name:'estado_reg', type: 'string'},
		{name:'titulo', type: 'string'},
		{name:'id_usuario_ai', type: 'numeric'},
		{name:'fecha_reg', type: 'date',dateFormat:'Y-m-d H:i:s.u'},
		{name:'usuario_ai', type: 'string'},
		{name:'id_usuario_reg', type: 'numeric'},
		{name:'id_usuario_mod', type: 'numeric'},
		{name:'fecha_mod', type: 'date',dateFormat:'Y-m-d H:i:s.u'},
		{name:'usr_reg', type: 'string'},
		{name:'usr_mod', type: 'string'},

		{name:'ruta_archivo', type: 'string'},
		{name:'extension', type: 'string'},
		{name:'nombre_archivo', type: 'string'},
		
	],
	sortInfo:{
		field: 'id_pagina',
		direction: 'ASC'
	},
	bdel:true,
	bsave:true,
		east:{
			url:'../../../sis_portal/vista/pagina_contenido/PaginaContenido.php',
			title:'PaginaContenido',
			width:300,
			cls:'PaginaContenido'
		},
	}
)
</script>
		
		