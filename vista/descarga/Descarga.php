<?php
/**
*@package pXP
*@file gen-Descarga.php
*@author  (admin)
*@date 20-09-2015 19:00:21
*@description Archivo con la interfaz de usuario que permite la ejecucion de todas las funcionalidades del sistema
*/

header("content-type: text/javascript; charset=UTF-8");
?>
<script>
Phx.vista.Descarga=Ext.extend(Phx.gridInterfaz,{

	constructor:function(config){
		this.maestro=config.maestro;
    	//llama al constructor de la clase padre
		Phx.vista.Descarga.superclass.constructor.call(this,config);
		this.init();
		this.addButton('cambiar Imagen',{argument: {imprimir: 'cambiar Imagen'},text:'<i class="fa fa-thumbs-o-up fa-2x"></i> cambiar documento',/*iconCls:'' ,*/disabled:false,handler:this.cambiar});

		this.load({params:{start:0, limit:this.tam_pag}})
	},
			
	Atributos:[
		{
			//configuracion del componente
			config:{
					labelSeparator:'',
					inputType:'hidden',
					name: 'id_descarga'
			},
			type:'Field',
			form:true 
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
				anchor:'100%'
			},
			type:'Field',
			form:true
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
				filters:{pfiltro:'des.titulo',type:'string'},
				id_grupo:1,
				grid:true,
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
				filters:{pfiltro:'des.descripcion',type:'string'},
				id_grupo:1,
				grid:true,
				form:true
		},

		{
			config:{
				name: 'anio',
				fieldLabel: 'anio',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				maxLength:255
			},
			type:'NumberField',
			filters:{pfiltro:'des.anio',type:'string'},
			id_grupo:1,
			grid:true,
			form:true
		},


		{
			config: {
				name: 'id_categoria',
				fieldLabel: 'id_categoria',
				allowBlank: true,
				emptyText: 'Elija una opción...',
				store: new Ext.data.JsonStore({
					url: '../../sis_portal/control/Categoria/listarCategoria',
					id: 'id_categoria',
					root: 'datos',
					sortInfo: {
						field: 'nombre',
						direction: 'ASC'
					},
					totalProperty: 'total',
					fields: ['id_categoria', 'nombre'],
					remoteSort: true,
					baseParams: {par_filtro: 'cat.nombre'}
				}),
				valueField: 'id_categoria',
				displayField: 'nombre',
				gdisplayField: 'desc_categoria',
				hiddenName: 'id_categoria',
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
					return String.format('{0}', record.data['desc_categoria']);
				}
			},
			type: 'ComboBox',
			id_grupo: 0,
			filters: {pfiltro: 'cat.nombre',type: 'string'},
			grid: true,
			form: true
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
				filters:{pfiltro:'des.estado_reg',type:'string'},
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
				filters:{pfiltro:'des.id_usuario_ai',type:'numeric'},
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
				filters:{pfiltro:'des.fecha_reg',type:'date'},
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
				filters:{pfiltro:'des.usuario_ai',type:'string'},
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
				name: 'fecha_mod',
				fieldLabel: 'Fecha Modif.',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
							format: 'd/m/Y', 
							renderer:function (value,p,record){return value?value.dateFormat('d/m/Y H:i:s'):''}
			},
				type:'DateField',
				filters:{pfiltro:'des.fecha_mod',type:'date'},
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
	title:'Descarga',
	ActSave:'../../sis_portal/control/Descarga/insertarDescarga',
	ActDel:'../../sis_portal/control/Descarga/eliminarDescarga',
	ActList:'../../sis_portal/control/Descarga/listarDescarga',
	id_store:'id_descarga',
	fields: [
		{name:'id_descarga', type: 'numeric'},
		{name:'titulo', type: 'string'},
		{name:'url_archivo', type: 'string'},
		{name:'descripcion', type: 'string'},
		{name:'tamano', type: 'string'},
		{name:'id_categoria', type: 'numeric'},
		{name:'estado_reg', type: 'string'},
		{name:'id_usuario_ai', type: 'numeric'},
		{name:'fecha_reg', type: 'date',dateFormat:'Y-m-d H:i:s.u'},
		{name:'usuario_ai', type: 'string'},
		{name:'id_usuario_reg', type: 'numeric'},
		{name:'fecha_mod', type: 'date',dateFormat:'Y-m-d H:i:s.u'},
		{name:'id_usuario_mod', type: 'numeric'},
		{name:'usr_reg', type: 'string'},
		{name:'usr_mod', type: 'string'},

		{name:'desc_categoria', type: 'string'},
		
	],
	sortInfo:{
		field: 'id_descarga',
		direction: 'ASC'
	},
	bdel:true,
	bsave:true,
		onButtonNew:function(){
			Phx.vista.Descarga.superclass.onButtonNew.call(this);
			this.getComponente('archivo').show();

		},
		onButtonEdit:function(){
			Phx.vista.Descarga.superclass.onButtonEdit.call(this);
			this.getComponente('archivo').hide();

		},
		cambiar:function(){
			var rec = this.sm.getSelected();

			rec.datos_extras_id = rec.data.id_descarga;
			rec.datos_extras_clase = 'Descarga';
			rec.datos_extras_tipo = 'documento'; //puede ser documento
			rec.datos_extras_tabla = 'tdescarga';
			rec.datos_extras_nombre_archivo = 'nombre_archivo';
			rec.datos_extras_folder = 'url_archivo';
			rec.datos_extras_nombre_id = 'id_descarga';
			rec.datos_extras_folder_descriptivo = './../../../uploaded_files/sis_portal/Descarga/';


			console.log(rec);


			Phx.CP.loadWindows('../../../sis_portal/vista/cambiar/cambiarImagen.php',
				'Interfaces',
				{
					width:900,
					height:400
				},rec,this.idContenedor,'CambiarImagen');

			/*Ext.Ajax.request({
			 url:'../../sis_facturacion/control/Nota/generarNota',
			 params:{'notas':rec.data['id_nota'],'reimpresion':'si'},
			 success: this.successExport,
			 failure: this.conexionFailure,
			 timeout:this.timeout,
			 scope:this
			 });*/
		}
	}
)
</script>
		
		