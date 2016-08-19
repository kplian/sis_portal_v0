CREATE OR REPLACE FUNCTION "por"."ft_publicacion_fb_ime" (	
				p_administrador integer, p_id_usuario integer, p_tabla character varying, p_transaccion character varying)
RETURNS character varying AS
$BODY$

/**************************************************************************
 SISTEMA:		portal
 FUNCION: 		por.ft_publicacion_fb_ime
 DESCRIPCION:   Funcion que gestiona las operaciones basicas (inserciones, modificaciones, eliminaciones de la tabla 'por.tpublicacion_fb'
 AUTOR: 		 (admin)
 FECHA:	        01-10-2015 13:41:00
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
	v_id_publicacion_fb	integer;
			    
BEGIN

    v_nombre_funcion = 'por.ft_publicacion_fb_ime';
    v_parametros = pxp.f_get_record(p_tabla);

	/*********************************    
 	#TRANSACCION:  'POR_PFB_INS'
 	#DESCRIPCION:	Insercion de registros
 	#AUTOR:		admin	
 	#FECHA:		01-10-2015 13:41:00
	***********************************/

	if(p_transaccion='POR_PFB_INS')then
					
        begin
        	--Sentencia de la insercion
        	insert into por.tpublicacion_fb(
			id_clase,
			user_fb,
			estado_reg,
			post_id,
			clase,
			id,
			id_usuario_reg,
			fecha_reg,
			usuario_ai,
			id_usuario_ai,
			fecha_mod,
			id_usuario_mod
          	) values(
			v_parametros.id_clase,
			v_parametros.user_fb,
			'activo',
			v_parametros.post_id,
			v_parametros.clase,
			v_parametros.id,
			p_id_usuario,
			now(),
			v_parametros._nombre_usuario_ai,
			v_parametros._id_usuario_ai,
			null,
			null
							
			
			
			)RETURNING id_publicacion_fb into v_id_publicacion_fb;
			
			--Definicion de la respuesta
			v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Publicaciones FB almacenado(a) con exito (id_publicacion_fb'||v_id_publicacion_fb||')'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_publicacion_fb',v_id_publicacion_fb::varchar);

            --Devuelve la respuesta
            return v_resp;

		end;

	/*********************************    
 	#TRANSACCION:  'POR_PFB_MOD'
 	#DESCRIPCION:	Modificacion de registros
 	#AUTOR:		admin	
 	#FECHA:		01-10-2015 13:41:00
	***********************************/

	elsif(p_transaccion='POR_PFB_MOD')then

		begin
			--Sentencia de la modificacion
			update por.tpublicacion_fb set
			id_clase = v_parametros.id_clase,
			user_fb = v_parametros.user_fb,
			post_id = v_parametros.post_id,
			clase = v_parametros.clase,
			id = v_parametros.id,
			fecha_mod = now(),
			id_usuario_mod = p_id_usuario,
			id_usuario_ai = v_parametros._id_usuario_ai,
			usuario_ai = v_parametros._nombre_usuario_ai
			where id_publicacion_fb=v_parametros.id_publicacion_fb;
               
			--Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Publicaciones FB modificado(a)'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_publicacion_fb',v_parametros.id_publicacion_fb::varchar);
               
            --Devuelve la respuesta
            return v_resp;
            
		end;

	/*********************************    
 	#TRANSACCION:  'POR_PFB_ELI'
 	#DESCRIPCION:	Eliminacion de registros
 	#AUTOR:		admin	
 	#FECHA:		01-10-2015 13:41:00
	***********************************/

	elsif(p_transaccion='POR_PFB_ELI')then

		begin
			--Sentencia de la eliminacion
			delete from por.tpublicacion_fb
            where id_publicacion_fb=v_parametros.id_publicacion_fb;
               
            --Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Publicaciones FB eliminado(a)'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_publicacion_fb',v_parametros.id_publicacion_fb::varchar);
              
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
ALTER FUNCTION "por"."ft_publicacion_fb_ime"(integer, integer, character varying, character varying) OWNER TO postgres;
