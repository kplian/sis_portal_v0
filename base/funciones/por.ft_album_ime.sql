CREATE OR REPLACE FUNCTION "por"."ft_album_ime" (	
				p_administrador integer, p_id_usuario integer, p_tabla character varying, p_transaccion character varying)
RETURNS character varying AS
$BODY$

/**************************************************************************
 SISTEMA:		portal
 FUNCION: 		por.ft_album_ime
 DESCRIPCION:   Funcion que gestiona las operaciones basicas (inserciones, modificaciones, eliminaciones de la tabla 'por.talbum'
 AUTOR: 		 (admin)
 FECHA:	        24-09-2015 18:53:01
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
	v_id_album	integer;
			    
BEGIN

    v_nombre_funcion = 'por.ft_album_ime';
    v_parametros = pxp.f_get_record(p_tabla);

	/*********************************    
 	#TRANSACCION:  'POR_ALB_INS'
 	#DESCRIPCION:	Insercion de registros
 	#AUTOR:		admin	
 	#FECHA:		24-09-2015 18:53:01
	***********************************/

	if(p_transaccion='POR_ALB_INS')then
					
        begin
        	--Sentencia de la insercion
        	insert into por.talbum(
			nombre,
			estado,
			id_categoria,
			estado_reg,
			id_usuario_ai,
			id_usuario_reg,
			usuario_ai,
			fecha_reg,
			fecha_mod,
			id_usuario_mod
          	) values(
			v_parametros.nombre,
			v_parametros.estado,
			v_parametros.id_categoria,
			'activo',
			v_parametros._id_usuario_ai,
			p_id_usuario,
			v_parametros._nombre_usuario_ai,
			now(),
			null,
			null
							
			
			
			)RETURNING id_album into v_id_album;
			
			--Definicion de la respuesta
			v_resp = pxp.f_agrega_clave(v_resp,'mensaje','album almacenado(a) con exito (id_album'||v_id_album||')'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_album',v_id_album::varchar);

            --Devuelve la respuesta
            return v_resp;

		end;

	/*********************************    
 	#TRANSACCION:  'POR_ALB_MOD'
 	#DESCRIPCION:	Modificacion de registros
 	#AUTOR:		admin	
 	#FECHA:		24-09-2015 18:53:01
	***********************************/

	elsif(p_transaccion='POR_ALB_MOD')then

		begin
			--Sentencia de la modificacion
			update por.talbum set
			nombre = v_parametros.nombre,
			estado = v_parametros.estado,
			id_categoria = v_parametros.id_categoria,
			fecha_mod = now(),
			id_usuario_mod = p_id_usuario,
			id_usuario_ai = v_parametros._id_usuario_ai,
			usuario_ai = v_parametros._nombre_usuario_ai
			where id_album=v_parametros.id_album;
               
			--Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','album modificado(a)'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_album',v_parametros.id_album::varchar);
               
            --Devuelve la respuesta
            return v_resp;
            
		end;

	/*********************************    
 	#TRANSACCION:  'POR_ALB_ELI'
 	#DESCRIPCION:	Eliminacion de registros
 	#AUTOR:		admin	
 	#FECHA:		24-09-2015 18:53:01
	***********************************/

	elsif(p_transaccion='POR_ALB_ELI')then

		begin
			--Sentencia de la eliminacion
			delete from por.talbum
            where id_album=v_parametros.id_album;
               
            --Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','album eliminado(a)'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_album',v_parametros.id_album::varchar);
              
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
ALTER FUNCTION "por"."ft_album_ime"(integer, integer, character varying, character varying) OWNER TO postgres;
