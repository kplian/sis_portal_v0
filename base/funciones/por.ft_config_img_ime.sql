CREATE OR REPLACE FUNCTION "por"."ft_config_img_ime" (	
				p_administrador integer, p_id_usuario integer, p_tabla character varying, p_transaccion character varying)
RETURNS character varying AS
$BODY$

/**************************************************************************
 SISTEMA:		PORTAL
 FUNCION: 		por.ft_config_img_ime
 DESCRIPCION:   Funcion que gestiona las operaciones basicas (inserciones, modificaciones, eliminaciones de la tabla 'por.tconfig_img'
 AUTOR: 		 (admin)
 FECHA:	        18-09-2015 16:11:47
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
	v_id_config_img	integer;
			    
BEGIN

    v_nombre_funcion = 'por.ft_config_img_ime';
    v_parametros = pxp.f_get_record(p_tabla);

	/*********************************    
 	#TRANSACCION:  'POR_CONFIM_INS'
 	#DESCRIPCION:	Insercion de registros
 	#AUTOR:		admin	
 	#FECHA:		18-09-2015 16:11:47
	***********************************/

	if(p_transaccion='POR_CONFIM_INS')then
					
        begin
        	--Sentencia de la insercion
        	insert into por.tconfig_img(
			clase,
			ancho_original,
			alto_original,
			ancho_mediano,
			ancho_pequeno,
			alto_mediano,
			estado_reg,
			alto_pequeno,
			id_usuario_ai,
			id_usuario_reg,
			usuario_ai,
			fecha_reg,
			fecha_mod,
			id_usuario_mod
          	) values(
			v_parametros.clase,
			v_parametros.ancho_original,
			v_parametros.alto_original,
			v_parametros.ancho_mediano,
			v_parametros.ancho_pequeno,
			v_parametros.alto_mediano,
			'activo',
			v_parametros.alto_pequeno,
			v_parametros._id_usuario_ai,
			p_id_usuario,
			v_parametros._nombre_usuario_ai,
			now(),
			null,
			null
							
			
			
			)RETURNING id_config_img into v_id_config_img;
			
			--Definicion de la respuesta
			v_resp = pxp.f_agrega_clave(v_resp,'mensaje','configuracion imagenes almacenado(a) con exito (id_config_img'||v_id_config_img||')'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_config_img',v_id_config_img::varchar);

            --Devuelve la respuesta
            return v_resp;

		end;

	/*********************************    
 	#TRANSACCION:  'POR_CONFIM_MOD'
 	#DESCRIPCION:	Modificacion de registros
 	#AUTOR:		admin	
 	#FECHA:		18-09-2015 16:11:47
	***********************************/

	elsif(p_transaccion='POR_CONFIM_MOD')then

		begin
			--Sentencia de la modificacion
			update por.tconfig_img set
			clase = v_parametros.clase,
			ancho_original = v_parametros.ancho_original,
			alto_original = v_parametros.alto_original,
			ancho_mediano = v_parametros.ancho_mediano,
			ancho_pequeno = v_parametros.ancho_pequeno,
			alto_mediano = v_parametros.alto_mediano,
			alto_pequeno = v_parametros.alto_pequeno,
			fecha_mod = now(),
			id_usuario_mod = p_id_usuario,
			id_usuario_ai = v_parametros._id_usuario_ai,
			usuario_ai = v_parametros._nombre_usuario_ai
			where id_config_img=v_parametros.id_config_img;
               
			--Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','configuracion imagenes modificado(a)'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_config_img',v_parametros.id_config_img::varchar);
               
            --Devuelve la respuesta
            return v_resp;
            
		end;

	/*********************************    
 	#TRANSACCION:  'POR_CONFIM_ELI'
 	#DESCRIPCION:	Eliminacion de registros
 	#AUTOR:		admin	
 	#FECHA:		18-09-2015 16:11:47
	***********************************/

	elsif(p_transaccion='POR_CONFIM_ELI')then

		begin
			--Sentencia de la eliminacion
			delete from por.tconfig_img
            where id_config_img=v_parametros.id_config_img;
               
            --Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','configuracion imagenes eliminado(a)'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_config_img',v_parametros.id_config_img::varchar);
              
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
ALTER FUNCTION "por"."ft_config_img_ime"(integer, integer, character varying, character varying) OWNER TO postgres;
