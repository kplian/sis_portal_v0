CREATE OR REPLACE FUNCTION "por"."ft_descarga_ime" (	
				p_administrador integer, p_id_usuario integer, p_tabla character varying, p_transaccion character varying)
RETURNS character varying AS
$BODY$

/**************************************************************************
 SISTEMA:		portal
 FUNCION: 		por.ft_descarga_ime
 DESCRIPCION:   Funcion que gestiona las operaciones basicas (inserciones, modificaciones, eliminaciones de la tabla 'por.tdescarga'
 AUTOR: 		 (admin)
 FECHA:	        20-09-2015 19:00:21
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
	v_id_descarga	integer;
			    
BEGIN

    v_nombre_funcion = 'por.ft_descarga_ime';
    v_parametros = pxp.f_get_record(p_tabla);

	/*********************************    
 	#TRANSACCION:  'POR_DES_INS'
 	#DESCRIPCION:	Insercion de registros
 	#AUTOR:		admin	
 	#FECHA:		20-09-2015 19:00:21
	***********************************/

	if(p_transaccion='POR_DES_INS')then
					
        begin

			
        	--Sentencia de la insercion
        	insert into por.tdescarga(
			titulo,
			url_archivo,
			descripcion,
			tamano,
			nombre_archivo,
							extension,
			id_categoria,
			estado_reg,
			id_usuario_ai,
			fecha_reg,
			usuario_ai,
			id_usuario_reg,
			fecha_mod,
			id_usuario_mod,
							anio
          	) values(
			v_parametros.titulo,
			v_parametros.folder,
			v_parametros.descripcion,
			v_parametros.tamano,
			v_parametros.nombre_archivo,
							v_parametros.extension,
			v_parametros.id_categoria,
			'activo',
			v_parametros._id_usuario_ai,
			now(),
			v_parametros._nombre_usuario_ai,
			p_id_usuario,
			null,
			null,
							v_parametros.anio
							
			
			
			)RETURNING id_descarga into v_id_descarga;
			
			--Definicion de la respuesta
			v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Descarga almacenado(a) con exito (id_descarga'||v_id_descarga||')'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_descarga',v_id_descarga::varchar);

            --Devuelve la respuesta
            return v_resp;

		end;

	/*********************************    
 	#TRANSACCION:  'POR_DES_MOD'
 	#DESCRIPCION:	Modificacion de registros
 	#AUTOR:		admin	
 	#FECHA:		20-09-2015 19:00:21
	***********************************/

	elsif(p_transaccion='POR_DES_MOD')then

		begin
			--Sentencia de la modificacion
			update por.tdescarga set
			titulo = v_parametros.titulo,
			url_archivo = v_parametros.url_archivo,
			descripcion = v_parametros.descripcion,
			tamano = v_parametros.tamano,
			id_categoria = v_parametros.id_categoria,
			fecha_mod = now(),
			id_usuario_mod = p_id_usuario,
			id_usuario_ai = v_parametros._id_usuario_ai,
			usuario_ai = v_parametros._nombre_usuario_ai
			where id_descarga=v_parametros.id_descarga;
               
			--Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Descarga modificado(a)'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_descarga',v_parametros.id_descarga::varchar);
               
            --Devuelve la respuesta
            return v_resp;
            
		end;

	/*********************************    
 	#TRANSACCION:  'POR_DES_ELI'
 	#DESCRIPCION:	Eliminacion de registros
 	#AUTOR:		admin	
 	#FECHA:		20-09-2015 19:00:21
	***********************************/

	elsif(p_transaccion='POR_DES_ELI')then

		begin
			--Sentencia de la eliminacion
			delete from por.tdescarga
            where id_descarga=v_parametros.id_descarga;
               
            --Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Descarga eliminado(a)'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_descarga',v_parametros.id_descarga::varchar);
              
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
ALTER FUNCTION "por"."ft_descarga_ime"(integer, integer, character varying, character varying) OWNER TO postgres;
