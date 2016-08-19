CREATE OR REPLACE FUNCTION "por"."ft_post_ime" (	
				p_administrador integer, p_id_usuario integer, p_tabla character varying, p_transaccion character varying)
RETURNS character varying AS
$BODY$

/**************************************************************************
 SISTEMA:		portal
 FUNCION: 		por.ft_post_ime
 DESCRIPCION:   Funcion que gestiona las operaciones basicas (inserciones, modificaciones, eliminaciones de la tabla 'por.tpost'
 AUTOR: 		 (admin)
 FECHA:	        20-09-2015 18:43:35
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
	v_id_post	integer;
			    
BEGIN

    v_nombre_funcion = 'por.ft_post_ime';
    v_parametros = pxp.f_get_record(p_tabla);

	/*********************************    
 	#TRANSACCION:  'POR_POS_INS'
 	#DESCRIPCION:	Insercion de registros
 	#AUTOR:		admin	
 	#FECHA:		20-09-2015 18:43:35
	***********************************/

	if(p_transaccion='POR_POS_INS')then
					
        begin
        	--Sentencia de la insercion
        	insert into por.tpost(
			fecha,
			folder,
			titulo,
			estado,
			contenido,
			nombre_imagen,
			subtitulo,
			url_autor,
			estado_reg,
			extension,
			id_usuario_ai,
			id_usuario_reg,
			fecha_reg,
			usuario_ai,
			fecha_mod,
			id_usuario_mod
          	) values(
			v_parametros.fecha,
			v_parametros.folder,
			v_parametros.titulo,
			v_parametros.estado,
			v_parametros.contenido,
			v_parametros.nombre_imagen,
			v_parametros.subtitulo,
			v_parametros.url_autor,
			'activo',
			v_parametros.extension,
			v_parametros._id_usuario_ai,
			p_id_usuario,
			now(),
			v_parametros._nombre_usuario_ai,
			null,
			null
							
			
			
			)RETURNING id_post into v_id_post;
			
			--Definicion de la respuesta
			v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Post almacenado(a) con exito (id_post'||v_id_post||')'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_post',v_id_post::varchar);

            --Devuelve la respuesta
            return v_resp;

		end;

	/*********************************    
 	#TRANSACCION:  'POR_POS_MOD'
 	#DESCRIPCION:	Modificacion de registros
 	#AUTOR:		admin	
 	#FECHA:		20-09-2015 18:43:35
	***********************************/

	elsif(p_transaccion='POR_POS_MOD')then

		begin
			--Sentencia de la modificacion
			update por.tpost set
			fecha = v_parametros.fecha,
			folder = v_parametros.folder,
			titulo = v_parametros.titulo,
			estado = v_parametros.estado,
			contenido = v_parametros.contenido,
			nombre_imagen = v_parametros.nombre_imagen,
			subtitulo = v_parametros.subtitulo,
			url_autor = v_parametros.url_autor,
			extension = v_parametros.extension,
			fecha_mod = now(),
			id_usuario_mod = p_id_usuario,
			id_usuario_ai = v_parametros._id_usuario_ai,
			usuario_ai = v_parametros._nombre_usuario_ai
			where id_post=v_parametros.id_post;
               
			--Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Post modificado(a)'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_post',v_parametros.id_post::varchar);
               
            --Devuelve la respuesta
            return v_resp;
            
		end;

	/*********************************    
 	#TRANSACCION:  'POR_POS_ELI'
 	#DESCRIPCION:	Eliminacion de registros
 	#AUTOR:		admin	
 	#FECHA:		20-09-2015 18:43:35
	***********************************/

	elsif(p_transaccion='POR_POS_ELI')then

		begin
			--Sentencia de la eliminacion
			delete from por.tpost
            where id_post=v_parametros.id_post;
               
            --Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Post eliminado(a)'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_post',v_parametros.id_post::varchar);
              
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
ALTER FUNCTION "por"."ft_post_ime"(integer, integer, character varying, character varying) OWNER TO postgres;
