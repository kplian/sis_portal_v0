<?php
/**
*@package pXP
*@file gen-PaginaContenido.php
*@author  (admin)
*@date 03-04-2016 17:58:58
*@description Archivo con la interfaz de usuario que permite la ejecucion de todas las funcionalidades del sistema
*/

header("content-type: text/javascript; charset=UTF-8");
?>
<script>
Phx.vista.PaginaContenido=Ext.extend(Phx.gridInterfaz,{

	constructor:function(config){
		this.maestro=config.maestro;
    	//llama al constructor de la clase padre
		Phx.vista.PaginaContenido.superclass.constructor.call(this,config);
		this.init();
		//this.load({params:{start:0, limit:this.tam_pag}})
	},
			
	Atributos:[
		{
			//configuracion del componente
			config:{
					labelSeparator:'',
					inputType:'hidden',
					name: 'id_pagina_contenido'
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
				name: 'ruta_archivo',
				fieldLabel: 'ruta_archivo',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				maxLength:255
			},
				type:'TextField',
				filters:{pfiltro:'pagcon.ruta_archivo',type:'string'},
				id_grupo:1,
				grid:true,
				form:false
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
				filters:{pfiltro:'pagcon.estado_reg',type:'string'},
				id_grupo:1,
				grid:true,
				form:false
		},
		{
			config:{
				name: 'nombre_archivo',
				fieldLabel: 'nombre_archivo',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				maxLength:255
			},
				type:'TextField',
				filters:{pfiltro:'pagcon.nombre_archivo',type:'string'},
				id_grupo:1,
				grid:true,
				form:false
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
				filters:{pfiltro:'pagcon.extension',type:'string'},
				id_grupo:1,
				grid:true,
				form:false
		},
		{
			config: {
				name: 'id_pagina',
				fieldLabel: 'id_pagina',
				allowBlank: true,
				emptyText: 'Elija una opción...',
				store: new Ext.data.JsonStore({
					url: '../../sis_/control/Clase/Metodo',
					id: 'id_',
					root: 'datos',
					sortInfo: {
						field: 'nombre',
						direction: 'ASC'
					},
					totalProperty: 'total',
					fields: ['id_', 'nombre', 'codigo'],
					remoteSort: true,
					baseParams: {par_filtro: 'movtip.nombre#movtip.codigo'}
				}),
				valueField: 'id_',
				displayField: 'nombre',
				gdisplayField: 'desc_',
				hiddenName: 'id_pagina',
				forceSelection: true,
				typeAhead: false,
				triggerAction: 'all',
				lazyRender: true,
				mode: 'remote',
				pageSize: 15,
				queryDelay: 1000,
				anchor: '100%',
				gwidth: 150,
				minChars: 2,
				renderer : function(value, p, record) {
					return String.format('{0}', record.data['desc_']);
				}
			},
			type: 'ComboBox',
			id_grupo: 0,
			filters: {pfiltro: 'movtip.nombre',type: 'string'},
			grid: true,
			form: true
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
				filters:{pfiltro:'pagcon.titulo',type:'string'},
				id_grupo:1,
				grid:true,
				form:true
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
				filters:{pfiltro:'pagcon.fecha_reg',type:'date'},
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
				filters:{pfiltro:'pagcon.usuario_ai',type:'string'},
				id_grupo:1,
				grid:true,
				form:false
		},
		{
			config:{
				name: 'id_usuario_ai',
				fieldLabel: 'Funcionaro AI',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				maxLength:4
			},
				type:'Field',
				filters:{pfiltro:'pagcon.id_usuario_ai',type:'numeric'},
				id_grupo:1,
				grid:false,
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
				filters:{pfiltro:'pagcon.fecha_mod',type:'date'},
				id_grupo:1,
				grid:true,
				form:false
		}
	],
		fileUpload:true,
	tam_pag:50,	
	title:'pagina_contenido',
	ActSave:'../../sis_portal/control/PaginaContenido/insertarPaginaContenido',
	ActDel:'../../sis_portal/control/PaginaContenido/eliminarPaginaContenido',
	ActList:'../../sis_portal/control/PaginaContenido/listarPaginaContenido',
	id_store:'id_pagina_contenido',
	fields: [
		{name:'id_pagina_contenido', type: 'numeric'},
		{name:'ruta_archivo', type: 'string'},
		{name:'estado_reg', type: 'string'},
		{name:'nombre_archivo', type: 'string'},
		{name:'contenido', type: 'string'},
		{name:'extension', type: 'string'},
		{name:'id_pagina', type: 'numeric'},
		{name:'titulo', type: 'string'},
		{name:'id_usuario_reg', type: 'numeric'},
		{name:'fecha_reg', type: 'date',dateFormat:'Y-m-d H:i:s.u'},
		{name:'usuario_ai', type: 'string'},
		{name:'id_usuario_ai', type: 'numeric'},
		{name:'id_usuario_mod', type: 'numeric'},
		{name:'fecha_mod', type: 'date',dateFormat:'Y-m-d H:i:s.u'},
		{name:'usr_reg', type: 'string'},
		{name:'usr_mod', type: 'string'},
		
	],
	sortInfo:{
		field: 'id_pagina_contenido',
		direction: 'ASC'
	},
	bdel:true,
	bsave:true,
		preparaMenu: function (tb) {
			// llamada funcion clace padre
			Phx.vista.Pagina.superclass.preparaMenu.call(this, tb)
		},
		onButtonNew: function () {
			Phx.vista.Pagina.superclass.onButtonNew.call(this);
			this.getComponente('id_pagina').setValue(this.maestro.id_pagina);
		},
		onReloadPage: function (m) {
			this.maestro = m;
			console.log(this.maestro);
			this.store.baseParams = {id_pagina: this.maestro.id_pagina};
			this.load({params: {start: 0, limit: 50}})
		}
	}
)
</script>
		
		