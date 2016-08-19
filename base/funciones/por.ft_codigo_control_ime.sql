CREATE OR REPLACE FUNCTION "por"."ft_codigo_control_ime" (	
				p_administrador integer, p_id_usuario integer, p_tabla character varying, p_transaccion character varying)
RETURNS character varying AS
$BODY$

/**************************************************************************
 SISTEMA:		portal
 FUNCION: 		por.ft_codigo_control_ime
 DESCRIPCION:   Funcion que gestiona las operaciones basicas (inserciones, modificaciones, eliminaciones de la tabla 'por.tcodigo_control'
 AUTOR: 		 (admin)
 FECHA:	        23-09-2015 04:07:03
 COMENTARIOS:	
***************************************************************************
 HISTORIAL DE MODIFICACIONES:

 DESCRIPCION:	
 AUTOR:			
 FECHA:		
***************************************************************************/

DECLARE

	v_nro_requerimiento    	integer;
	v_parametros           	record;
	v_id_requerimiento     	integer;
	v_resp		            varchar;
	v_nombre_funcion        text;
	v_mensaje_error         text;
	v_id_codigo_control	integer;
			    
BEGIN

    v_nombre_funcion = 'por.ft_codigo_control_ime';
    v_parametros = pxp.f_get_record(p_tabla);

	/*********************************    
 	#TRANSACCION:  'POR_CODC_INS'
 	#DESCRIPCION:	Insercion de registros
 	#AUTOR:		admin	
 	#FECHA:		23-09-2015 04:07:03
	***********************************/

	if(p_transaccion='POR_CODC_INS')then
					
        begin
        	--Sentencia de la insercion
        	insert into por.tcodigo_control(
			llave,
			importe,
			autorizacion,
			nit,
			factura,
			fecha,
			estado_reg,
			id_usuario_ai,
			id_usuario_reg,
			usuario_ai,
			fecha_reg,
			fecha_mod,
			id_usuario_mod
          	) values(
			v_parametros.llave,
			v_parametros.importe,
			v_parametros.autorizacion,
			v_parametros.nit,
			v_parametros.factura,
			v_parametros.fecha,
			'activo',
			v_parametros._id_usuario_ai,
			p_id_usuario,
			v_parametros._nombre_usuario_ai,
			now(),
			null,
			null
							
			
			
			)RETURNING id_codigo_control into v_id_codigo_control;
			
			--Definicion de la respuesta
			v_resp = pxp.f_agrega_clave(v_resp,'mensaje','codigo control almacenado(a) con exito (id_codigo_control'||v_id_codigo_control||')'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_codigo_control',v_id_codigo_control::varchar);

            --Devuelve la respuesta
            return v_resp;

		end;

	/*********************************    
 	#TRANSACCION:  'POR_CODC_MOD'
 	#DESCRIPCION:	Modificacion de registros
 	#AUTOR:		admin	
 	#FECHA:		23-09-2015 04:07:03
	***********************************/

	elsif(p_transaccion='POR_CODC_MOD')then

		begin
			--Sentencia de la modificacion
			update por.tcodigo_control set
			llave = v_parametros.llave,
			importe = v_parametros.importe,
			autorizacion = v_parametros.autorizacion,
			nit = v_parametros.nit,
			factura = v_parametros.factura,
			fecha = v_parametros.fecha,
			fecha_mod = now(),
			id_usuario_mod = p_id_usuario,
			id_usuario_ai = v_parametros._id_usuario_ai,
			usuario_ai = v_parametros._nombre_usuario_ai
			where id_codigo_control=v_parametros.id_codigo_control;
               
			--Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','codigo control modificado(a)'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_codigo_control',v_parametros.id_codigo_control::varchar);
               
            --Devuelve la respuesta
            return v_resp;
            
		end;

	/*********************************    
 	#TRANSACCION:  'POR_CODC_ELI'
 	#DESCRIPCION:	Eliminacion de registros
 	#AUTOR:		admin	
 	#FECHA:		23-09-2015 04:07:03
	***********************************/

	elsif(p_transaccion='POR_CODC_ELI')then

		begin
			--Sentencia de la eliminacion
			delete from por.tcodigo_control
            where id_codigo_control=v_parametros.id_codigo_control;
               
            --Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','codigo control eliminado(a)'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_codigo_control',v_parametros.id_codigo_control::varchar);
              
            --Devuelve la respuesta
            return v_resp;

		end;
         
	else
     
    	raise exception 'Transaccion inexistente: %',p_transaccion;

	end if;

EXCEPTION
				
	WHEN OTHERS THEN
		v_resp='';
		v_resp = pxp.f_agrega_clave(v_resp,'mensaje',SQLERRM);
		v_resp = pxp.f_agrega_clave(v_resp,'codigo_error',SQLSTATE);
		v_resp = pxp.f_agrega_clave(v_resp,'procedimientos',v_nombre_funcion);
		raise exception '%',v_resp;
				        
END;
$BODY$
LANGUAGE 'plpgsql' VOLATILE
COST 100;
ALTER FUNCTION "por"."ft_codigo_control_ime"(integer, integer, character varying, character varying) OWNER TO postgres;
