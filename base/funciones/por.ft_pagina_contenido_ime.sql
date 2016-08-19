CREATE OR REPLACE FUNCTION "por"."ft_pagina_contenido_ime" (	
				p_administrador integer, p_id_usuario integer, p_tabla character varying, p_transaccion character varying)
RETURNS character varying AS
$BODY$

/**************************************************************************
 SISTEMA:		portal
 FUNCION: 		por.ft_pagina_contenido_ime
 DESCRIPCION:   Funcion que gestiona las operaciones basicas (inserciones, modificaciones, eliminaciones de la tabla 'por.tpagina_contenido'
 AUTOR: 		 (admin)
 FECHA:	        03-04-2016 17:58:58
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
	v_id_pagina_contenido	integer;
			    
BEGIN

    v_nombre_funcion = 'por.ft_pagina_contenido_ime';
    v_parametros = pxp.f_get_record(p_tabla);

	/*********************************    
 	#TRANSACCION:  'POR_PAGCON_INS'
 	#DESCRIPCION:	Insercion de registros
 	#AUTOR:		admin	
 	#FECHA:		03-04-2016 17:58:58
	***********************************/

	if(p_transaccion='POR_PAGCON_INS')then
					
        begin
        	--Sentencia de la insercion
        	insert into por.tpagina_contenido(
			ruta_archivo,
			estado_reg,
			nombre_archivo,
			contenido,
			extension,
			id_pagina,
			titulo,
			id_usuario_reg,
			fecha_reg,
			usuario_ai,
			id_usuario_ai,
			id_usuario_mod,
			fecha_mod
          	) values(
			v_parametros.ruta_archivo,
			'activo',
			v_parametros.nombre_archivo,
			v_parametros.contenido,
			v_parametros.extension,
			v_parametros.id_pagina,
			v_parametros.titulo,
			p_id_usuario,
			now(),
			v_parametros._nombre_usuario_ai,
			v_parametros._id_usuario_ai,
			null,
			null
							
			
			
			)RETURNING id_pagina_contenido into v_id_pagina_contenido;
			
			--Definicion de la respuesta
			v_resp = pxp.f_agrega_clave(v_resp,'mensaje','pagina_contenido almacenado(a) con exito (id_pagina_contenido'||v_id_pagina_contenido||')'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_pagina_contenido',v_id_pagina_contenido::varchar);

            --Devuelve la respuesta
            return v_resp;

		end;

	/*********************************    
 	#TRANSACCION:  'POR_PAGCON_MOD'
 	#DESCRIPCION:	Modificacion de registros
 	#AUTOR:		admin	
 	#FECHA:		03-04-2016 17:58:58
	***********************************/

	elsif(p_transaccion='POR_PAGCON_MOD')then

		begin
			--Sentencia de la modificacion
			update por.tpagina_contenido set
			ruta_archivo = v_parametros.ruta_archivo,
			nombre_archivo = v_parametros.nombre_archivo,
			contenido = v_parametros.contenido,
			extension = v_parametros.extension,
			id_pagina = v_parametros.id_pagina,
			titulo = v_parametros.titulo,
			id_usuario_mod = p_id_usuario,
			fecha_mod = now(),
			id_usuario_ai = v_parametros._id_usuario_ai,
			usuario_ai = v_parametros._nombre_usuario_ai
			where id_pagina_contenido=v_parametros.id_pagina_contenido;
               
			--Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','pagina_contenido modificado(a)'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_pagina_contenido',v_parametros.id_pagina_contenido::varchar);
               
            --Devuelve la respuesta
            return v_resp;
            
		end;

	/*********************************    
 	#TRANSACCION:  'POR_PAGCON_ELI'
 	#DESCRIPCION:	Eliminacion de registros
 	#AUTOR:		admin	
 	#FECHA:		03-04-2016 17:58:58
	***********************************/

	elsif(p_transaccion='POR_PAGCON_ELI')then

		begin
			--Sentencia de la eliminacion
			delete from por.tpagina_contenido
            where id_pagina_contenido=v_parametros.id_pagina_contenido;
               
            --Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','pagina_contenido eliminado(a)'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_pagina_contenido',v_parametros.id_pagina_contenido::varchar);
              
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
ALTER FUNCTION "por"."ft_pagina_contenido_ime"(integer, integer, character varying, character varying) OWNER TO postgres;
