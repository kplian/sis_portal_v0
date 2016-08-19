CREATE OR REPLACE FUNCTION "por"."ft_redes_sociales_ime" (	
				p_administrador integer, p_id_usuario integer, p_tabla character varying, p_transaccion character varying)
RETURNS character varying AS
$BODY$

/**************************************************************************
 SISTEMA:		portal
 FUNCION: 		por.ft_redes_sociales_ime
 DESCRIPCION:   Funcion que gestiona las operaciones basicas (inserciones, modificaciones, eliminaciones de la tabla 'por.tredes_sociales'
 AUTOR: 		 (admin)
 FECHA:	        30-09-2015 14:38:24
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
	v_id_redes_sociales	integer;
			    
BEGIN

    v_nombre_funcion = 'por.ft_redes_sociales_ime';
    v_parametros = pxp.f_get_record(p_tabla);

	/*********************************    
 	#TRANSACCION:  'POR_REDS_INS'
 	#DESCRIPCION:	Insercion de registros
 	#AUTOR:		admin	
 	#FECHA:		30-09-2015 14:38:24
	***********************************/

	if(p_transaccion='POR_REDS_INS')then
					
        begin
        	--Sentencia de la insercion
        	insert into por.tredes_sociales(
			url_page,
			estado_reg,
			token_api,
			nombre,
			descripcion,
			id,
							tipo,
			fecha_reg,
			usuario_ai,
			id_usuario_reg,
			id_usuario_ai,
			id_usuario_mod,
			fecha_mod
          	) values(
			v_parametros.url_page,
			'activo',
			v_parametros.token_api,
			v_parametros.nombre,
			v_parametros.descripcion,
			v_parametros.id,
							v_parametros.tipo,
			now(),
			v_parametros._nombre_usuario_ai,
			p_id_usuario,
			v_parametros._id_usuario_ai,
			null,
			null
							
			
			
			)RETURNING id_redes_sociales into v_id_redes_sociales;
			
			--Definicion de la respuesta
			v_resp = pxp.f_agrega_clave(v_resp,'mensaje','redes sociales almacenado(a) con exito (id_redes_sociales'||v_id_redes_sociales||')'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_redes_sociales',v_id_redes_sociales::varchar);

            --Devuelve la respuesta
            return v_resp;

		end;

	/*********************************    
 	#TRANSACCION:  'POR_REDS_MOD'
 	#DESCRIPCION:	Modificacion de registros
 	#AUTOR:		admin	
 	#FECHA:		30-09-2015 14:38:24
	***********************************/

	elsif(p_transaccion='POR_REDS_MOD')then

		begin
			--Sentencia de la modificacion
			update por.tredes_sociales set
			url_page = v_parametros.url_page,
			token_api = v_parametros.token_api,
			nombre = v_parametros.nombre,
			descripcion = v_parametros.descripcion,
			id = v_parametros.id,
				tipo = v_parametros.tipo,
			id_usuario_mod = p_id_usuario,
			fecha_mod = now(),
			id_usuario_ai = v_parametros._id_usuario_ai,
			usuario_ai = v_parametros._nombre_usuario_ai
			where id_redes_sociales=v_parametros.id_redes_sociales;
               
			--Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','redes sociales modificado(a)'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_redes_sociales',v_parametros.id_redes_sociales::varchar);
               
            --Devuelve la respuesta
            return v_resp;
            
		end;


	/*********************************    
 	#TRANSACCION:  'POR_REDS_ELI'
 	#DESCRIPCION:	Eliminacion de registros
 	#AUTOR:		admin	
 	#FECHA:		30-09-2015 14:38:24
	***********************************/

	elsif(p_transaccion='POR_REDS_ELI')then

		begin
			--Sentencia de la eliminacion
			delete from por.tredes_sociales
            where id_redes_sociales=v_parametros.id_redes_sociales;
               
            --Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','redes sociales eliminado(a)'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_redes_sociales',v_parametros.id_redes_sociales::varchar);
              
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
ALTER FUNCTION "por"."ft_redes_sociales_ime"(integer, integer, character varying, character varying) OWNER TO postgres;
