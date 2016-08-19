<?php
/**
*@package pXP
*@file gen-CodigoControl.php
*@author  (admin)
*@date 23-09-2015 04:07:03
*@description Archivo con la interfaz de usuario que permite la ejecucion de todas las funcionalidades del sistema
*/

header("content-type: text/javascript; charset=UTF-8");
?>
<script>
Phx.vista.CodigoControl=Ext.extend(Phx.gridInterfaz,{

	constructor:function(config){
		this.maestro=config.maestro;
    	//llama al constructor de la clase padre
		Phx.vista.CodigoControl.superclass.constructor.call(this,config);
		this.init();
		this.iniciarEventos();
		this.load({params:{start:0, limit:this.tam_pag}})
	},
	iniciarEventos: function () {
		
		
		this.Cmp.fecha.on('change', function (rec) {
			
			//this.Cmp.llave.setValue(encodeURIComponent(this.Cmp.llave.getValue()));
			
			//this.Cmp.llave.setValue(encodeURIComponent(this.Cmp.llave.getValue()));
			var llave = encodeURIComponent(this.Cmp.llave.getValue());
			Ext.Ajax.request({
			 url: '../../sis_portal/control/CodigoControl/GenerarCodigoControl',
			 params: {
			 'llave': llave,
			 'autorizacion': this.Cmp.autorizacion.getValue(),
			 'factura': this.Cmp.factura.getValue(),
			 'nit': this.Cmp.nit.getValue(),
			 'fecha': this.Cmp.fecha.getValue(),
			 'importe': this.Cmp.importe.getValue(),
			 'start': 0, 'limit': 10
			 },
			 success: this.gen_codigo_control,
			 failure: this.conexionFailure,
            timeout: this.timeout,
            scope: this
			 
			 });
			 
			 /*
			  select pxp.f_gen_cod_control(
										      '-7we(Id]76vp%rGq%SGfZ5LJyx]+5MR[RP\LUW4Qxk4%y}jt]NgftTdp=qQ-b#=W',
										      '7904002128010',
										       '7905',
										        '124941011',
										         '20070916',
          											round('60533',0) )
			  * */




		}, this);
		
		
	},
			
	Atributos:[
		{
			//configuracion del componente
			config:{
					labelSeparator:'',
					inputType:'hidden',
					name: 'id_codigo_control'
			},
			type:'Field',
			form:true 
		},
		{
			config:{
				name: 'llave',
				fieldLabel: 'llave',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				maxLength:255
			},
				type:'TextField',
				filters:{pfiltro:'codc.llave',type:'string'},
				id_grupo:1,
				grid:true,
				form:true
		},
		{
			config:{
				name: 'importe',
				fieldLabel: 'importe',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				maxLength:655362
			},
				type:'NumberField',
				filters:{pfiltro:'codc.importe',type:'numeric'},
				id_grupo:1,
				grid:true,
				form:true
		},
		{
			config:{
				name: 'autorizacion',
				fieldLabel: 'autorizacion',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				maxLength:255
			},
				type:'TextField',
				filters:{pfiltro:'codc.autorizacion',type:'string'},
				id_grupo:1,
				grid:true,
				form:true
		},
		{
			config:{
				name: 'nit',
				fieldLabel: 'nit',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				maxLength:255
			},
				type:'TextField',
				filters:{pfiltro:'codc.nit',type:'string'},
				id_grupo:1,
				grid:true,
				form:true
		},
		{
			config:{
				name: 'factura',
				fieldLabel: 'factura',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				maxLength:255
			},
				type:'TextField',
				filters:{pfiltro:'codc.factura',type:'string'},
				id_grupo:1,
				grid:true,
				form:true
		},
		/*{
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
				filters:{pfiltro:'codc.fecha',type:'date'},
				id_grupo:1,
				grid:true,
				form:true
		},*/
		{
			config:{
				name: 'fecha',
				fieldLabel: 'fecha',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				maxLength:255
			},
				type:'TextField',
				filters:{pfiltro:'codc.fecha',type:'string'},
				id_grupo:1,
				grid:true,
				form:true
		},
		{
			config:{
				name: 'codigo_control',
				fieldLabel: 'codigo_control',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				maxLength:255
			},
				type:'TextField',
				filters:{pfiltro:'codc.codigo_control',type:'string'},
				id_grupo:1,
				grid:false,
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
				filters:{pfiltro:'codc.estado_reg',type:'string'},
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
				filters:{pfiltro:'codc.id_usuario_ai',type:'numeric'},
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
				filters:{pfiltro:'codc.usuario_ai',type:'string'},
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
				filters:{pfiltro:'codc.fecha_reg',type:'date'},
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
				filters:{pfiltro:'codc.fecha_mod',type:'date'},
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
	title:'codigo control',
	ActSave:'../../sis_portal/control/CodigoControl/insertarCodigoControl',
	ActDel:'../../sis_portal/control/CodigoControl/eliminarCodigoControl',
	ActList:'../../sis_portal/control/CodigoControl/listarCodigoControl',
	id_store:'id_codigo_control',
	fields: [
		{name:'id_codigo_control', type: 'numeric'},
		{name:'llave', type: 'string'},
		{name:'importe', type: 'numeric'},
		{name:'autorizacion', type: 'string'},
		{name:'nit', type: 'string'},
		{name:'factura', type: 'string'},
		{name:'fecha', type: 'date',dateFormat:'Y-m-d'},
		{name:'estado_reg', type: 'string'},
		{name:'id_usuario_ai', type: 'numeric'},
		{name:'id_usuario_reg', type: 'numeric'},
		{name:'usuario_ai', type: 'string'},
		{name:'fecha_reg', type: 'date',dateFormat:'Y-m-d H:i:s.u'},
		{name:'fecha_mod', type: 'date',dateFormat:'Y-m-d H:i:s.u'},
		{name:'id_usuario_mod', type: 'numeric'},
		{name:'usr_reg', type: 'string'},
		{name:'usr_mod', type: 'string'},
		
	],
	sortInfo:{
		field: 'id_codigo_control',
		direction: 'ASC'
	},
	bdel:true,
	bsave:true,
		gen_codigo_control : function (resp){
			
			 var reg = Ext.util.JSON.decode(Ext.util.Format.trim(resp.responseText));
			 console.log(reg.datos[0].f_gen_cod_control);
			 this.Cmp.codigo_control.setValue(reg.datos[0].f_gen_cod_control);

			
		},
	}
)
</script>
		
		