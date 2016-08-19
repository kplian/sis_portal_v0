CREATE OR REPLACE FUNCTION "por"."ft_pagina_ime" (	
				p_administrador integer, p_id_usuario integer, p_tabla character varying, p_transaccion character varying)
RETURNS character varying AS
$BODY$

/**************************************************************************
 SISTEMA:		portal
 FUNCION: 		por.ft_pagina_ime
 DESCRIPCION:   Funcion que gestiona las operaciones basicas (inserciones, modificaciones, eliminaciones de la tabla 'por.tpagina'
 AUTOR: 		 (admin)
 FECHA:	        03-04-2016 17:58:39
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
	v_id_pagina	integer;
			    
BEGIN

    v_nombre_funcion = 'por.ft_pagina_ime';
    v_parametros = pxp.f_get_record(p_tabla);

	/*********************************    
 	#TRANSACCION:  'POR_PAG_INS'
 	#DESCRIPCION:	Insercion de registros
 	#AUTOR:		admin	
 	#FECHA:		03-04-2016 17:58:39
	***********************************/

	if(p_transaccion='POR_PAG_INS')then
					
        begin
        	--Sentencia de la insercion
        	insert into por.tpagina(
			descripcion,
			estado_reg,
			titulo,
			id_usuario_ai,
			fecha_reg,
			usuario_ai,
			id_usuario_reg,
			id_usuario_mod,
			fecha_mod,
							ruta_archivo,
							extension,
							nombre_archivo
          	) values(
			v_parametros.descripcion,
			'activo',
			v_parametros.titulo,
			v_parametros._id_usuario_ai,
			now(),
			v_parametros._nombre_usuario_ai,
			p_id_usuario,
			null,
			null,
      v_parametros.ruta_archivo,
      v_parametros.extension,
      v_parametros.nombre_archivo
							
			
			
			)RETURNING id_pagina into v_id_pagina;
			
			--Definicion de la respuesta
			v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Pagina almacenado(a) con exito (id_pagina'||v_id_pagina||')'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_pagina',v_id_pagina::varchar);

            --Devuelve la respuesta
            return v_resp;

		end;

	/*********************************    
 	#TRANSACCION:  'POR_PAG_MOD'
 	#DESCRIPCION:	Modificacion de registros
 	#AUTOR:		admin	
 	#FECHA:		03-04-2016 17:58:39
	***********************************/

	elsif(p_transaccion='POR_PAG_MOD')then

		begin
			--Sentencia de la modificacion
			update por.tpagina set
			descripcion = v_parametros.descripcion,
			titulo = v_parametros.titulo,
			id_usuario_mod = p_id_usuario,
			fecha_mod = now(),
			id_usuario_ai = v_parametros._id_usuario_ai,
			usuario_ai = v_parametros._nombre_usuario_ai
			where id_pagina=v_parametros.id_pagina;
               
			--Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Pagina modificado(a)'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_pagina',v_parametros.id_pagina::varchar);
               
            --Devuelve la respuesta
            return v_resp;
            
		end;

	/*********************************    
 	#TRANSACCION:  'POR_PAG_ELI'
 	#DESCRIPCION:	Eliminacion de registros
 	#AUTOR:		admin	
 	#FECHA:		03-04-2016 17:58:39
	***********************************/

	elsif(p_transaccion='POR_PAG_ELI')then

		begin
			--Sentencia de la eliminacion
			delete from por.tpagina
            where id_pagina=v_parametros.id_pagina;
               
            --Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Pagina eliminado(a)'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_pagina',v_parametros.id_pagina::varchar);
              
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
ALTER FUNCTION "por"."ft_pagina_ime"(integer, integer, character varying, character varying) OWNER TO postgres;
