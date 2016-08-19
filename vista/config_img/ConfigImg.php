<?php
/**
*@package pXP
*@file gen-ConfigImg.php
*@author  (admin)
*@date 18-09-2015 16:11:47
*@description Archivo con la interfaz de usuario que permite la ejecucion de todas las funcionalidades del sistema
*/

header("content-type: text/javascript; charset=UTF-8");
?>
<script>
Phx.vista.ConfigImg=Ext.extend(Phx.gridInterfaz,{

	constructor:function(config){
		this.maestro=config.maestro;
    	//llama al constructor de la clase padre
		Phx.vista.ConfigImg.superclass.constructor.call(this,config);
		this.grid.addListener('cellclick', this.oncellclick,this);
		this.init();
		this.load({params:{start:0, limit:this.tam_pag}})
	},
			
	Atributos:[
		{
			//configuracion del componente
			config:{
					labelSeparator:'',
					inputType:'hidden',
					name: 'id_config_img'
			},
			type:'Field',
			form:true 
		},

		{
			config:{
				name: 'validado',
				fieldLabel: 'validado',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				maxLength:3,
				renderer: function (value, p, record, rowIndex, colIndex){

					//check or un check row
					var checked = '',
						momento = 'no';
					console.log(value);
					if(value == 'si'){
						checked = 'checked';;
					}
					return  String.format('<div style="vertical-align:middle;text-align:center;"><input style="height:37px;width:37px;" type="checkbox"  {0}></div>',checked);

				}
			},
			type: 'TextField',
			filters: { pfiltro:'dcv.validado',type:'string'},
			id_grupo: 0,
			grid: true,
			form: false
		},

		{
			config:{
				name: 'clase',
				fieldLabel: 'clase',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				maxLength:255
			},
				type:'TextField',
				filters:{pfiltro:'confim.clase',type:'string'},
				id_grupo:1,
				grid:true,
				form:true
		},
		{
			config:{
				name: 'ancho_original',
				fieldLabel: 'ancho_original',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				maxLength:255
			},
			type:'TextField',
			filters:{pfiltro:'confim.ancho_original',type:'string'},
			id_grupo:1,
			grid:true,
			form:true
		},
		{
			config:{
				name: 'alto_original',
				fieldLabel: 'alto_original',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				maxLength:255
			},
			type:'TextField',
			filters:{pfiltro:'confim.alto_original',type:'string'},
			id_grupo:1,
			grid:true,
			form:true
		},
		{
			config:{
				name: 'ancho_mediano',
				fieldLabel: 'ancho_mediano',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				maxLength:255
			},
				type:'TextField',
				filters:{pfiltro:'confim.ancho_mediano',type:'string'},
				id_grupo:1,
				grid:true,
				form:true
		},
		{
			config:{
				name: 'ancho_pequeno',
				fieldLabel: 'ancho_pequeno',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				maxLength:255
			},
				type:'TextField',
				filters:{pfiltro:'confim.ancho_pequeno',type:'string'},
				id_grupo:1,
				grid:true,
				form:true
		},
		{
			config:{
				name: 'alto_mediano',
				fieldLabel: 'alto_mediano',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				maxLength:255
			},
				type:'TextField',
				filters:{pfiltro:'confim.alto_mediano',type:'string'},
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
				filters:{pfiltro:'confim.estado_reg',type:'string'},
				id_grupo:1,
				grid:true,
				form:false
		},
		{
			config:{
				name: 'alto_pequeno',
				fieldLabel: 'alto_pequeno',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				maxLength:255
			},
				type:'TextField',
				filters:{pfiltro:'confim.alto_pequeno',type:'string'},
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
				filters:{pfiltro:'confim.id_usuario_ai',type:'numeric'},
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
				name: 'usuario_ai',
				fieldLabel: 'Funcionaro AI',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				maxLength:300
			},
				type:'TextField',
				filters:{pfiltro:'confim.usuario_ai',type:'string'},
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
				filters:{pfiltro:'confim.fecha_reg',type:'date'},
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
				filters:{pfiltro:'confim.fecha_mod',type:'date'},
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
	tam_pag:50,	
	title:'configuracion imagenes',
	ActSave:'../../sis_portal/control/ConfigImg/insertarConfigImg',
	ActDel:'../../sis_portal/control/ConfigImg/eliminarConfigImg',
	ActList:'../../sis_portal/control/ConfigImg/listarConfigImg',
	id_store:'id_config_img',
	fields: [
		{name:'id_config_img', type: 'numeric'},
		{name:'clase', type: 'string'},
		{name:'ancho_original', type: 'string'},
		{name:'alto_original', type: 'string'},
		{name:'ancho_mediano', type: 'string'},
		{name:'ancho_pequeno', type: 'string'},
		{name:'alto_mediano', type: 'string'},
		{name:'estado_reg', type: 'string'},
		{name:'alto_pequeno', type: 'string'},
		{name:'id_usuario_ai', type: 'numeric'},
		{name:'id_usuario_reg', type: 'numeric'},
		{name:'usuario_ai', type: 'string'},
		{name:'fecha_reg', type: 'date',dateFormat:'Y-m-d H:i:s.u'},
		{name:'fecha_mod', type: 'date',dateFormat:'Y-m-d H:i:s.u'},
		{name:'id_usuario_mod', type: 'numeric'},
		{name:'usr_reg', type: 'string'},
		{name:'usr_mod', type: 'string'},
		{name:'validado', type: 'string'},
		
	],
	sortInfo:{
		field: 'id_config_img',
		direction: 'ASC'
	},
	bdel:true,
	bsave:true,

		oncellclick : function(grid, rowIndex, columnIndex, e) {

			var record = this.store.getAt(rowIndex),
				fieldName = grid.getColumnModel().getDataIndex(columnIndex); // Get field name

			if(fieldName == 'validado') {
				//if(record.data['revisado'] == 'si'){
				this.cambiarValidado(record);
				//	}
			}
		},
		cambiarValidado: function(record){
			Phx.CP.loadingShow();
			var d = record.data
			console.log(d)
			Ext.Ajax.request({
				url:'../../sis_portal/control/ConfigImg/cambiarValidacion',
				params:{ id_config_img: d.id_config_img,validado:d.validado},
				success: this.successRevision,
				failure: this.conexionFailure,
				timeout: this.timeout,
				scope: this
			});
		},
		successRevision: function(resp){

			console.log(resp);
			Phx.CP.loadingHide();
			var reg = Ext.util.JSON.decode(Ext.util.Format.trim(resp.responseText));
			if(reg.datos = 'correcto'){
				this.reload();
			}
		},

	}
)
</script>
		
		