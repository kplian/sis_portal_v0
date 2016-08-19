CREATE OR REPLACE FUNCTION "por"."ft_funcionario_ime" (	
				p_administrador integer, p_id_usuario integer, p_tabla character varying, p_transaccion character varying)
RETURNS character varying AS
$BODY$

/**************************************************************************
 SISTEMA:		portal
 FUNCION: 		por.ft_funcionario_ime
 DESCRIPCION:   Funcion que gestiona las operaciones basicas (inserciones, modificaciones, eliminaciones de la tabla 'por.tfuncionario'
 AUTOR: 		 (admin)
 FECHA:	        20-09-2015 19:42:44
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
	v_id_funcionario	integer;
			    
BEGIN

    v_nombre_funcion = 'por.ft_funcionario_ime';
    v_parametros = pxp.f_get_record(p_tabla);

	/*********************************    
 	#TRANSACCION:  'POR_FUNCI_INS'
 	#DESCRIPCION:	Insercion de registros
 	#AUTOR:		admin	
 	#FECHA:		20-09-2015 19:42:44
	***********************************/

	if(p_transaccion='POR_FUNCI_INS')then
					
        begin
        	--Sentencia de la insercion
        	insert into por.tfuncionario(
			email_funcionario,
			id_persona,
			cargo,
			estado_reg,
			id_usuario_ai,
			fecha_reg,
			usuario_ai,
			id_usuario_reg,
			fecha_mod,
			id_usuario_mod
          	) values(
			v_parametros.email_funcionario,
			v_parametros.id_persona,
			v_parametros.cargo,
			'activo',
			v_parametros._id_usuario_ai,
			now(),
			v_parametros._nombre_usuario_ai,
			p_id_usuario,
			null,
			null
							
			
			
			)RETURNING id_funcionario into v_id_funcionario;
			
			--Definicion de la respuesta
			v_resp = pxp.f_agrega_clave(v_resp,'mensaje','funcionario almacenado(a) con exito (id_funcionario'||v_id_funcionario||')'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_funcionario',v_id_funcionario::varchar);

            --Devuelve la respuesta
            return v_resp;

		end;

	/*********************************    
 	#TRANSACCION:  'POR_FUNCI_MOD'
 	#DESCRIPCION:	Modificacion de registros
 	#AUTOR:		admin	
 	#FECHA:		20-09-2015 19:42:44
	***********************************/

	elsif(p_transaccion='POR_FUNCI_MOD')then

		begin
			--Sentencia de la modificacion
			update por.tfuncionario set
			email_funcionario = v_parametros.email_funcionario,
			id_persona = v_parametros.id_persona,
			cargo = v_parametros.cargo,
			fecha_mod = now(),
			id_usuario_mod = p_id_usuario,
			id_usuario_ai = v_parametros._id_usuario_ai,
			usuario_ai = v_parametros._nombre_usuario_ai
			where id_funcionario=v_parametros.id_funcionario;
               
			--Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','funcionario modificado(a)'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_funcionario',v_parametros.id_funcionario::varchar);
               
            --Devuelve la respuesta
            return v_resp;
            
		end;

	/*********************************    
 	#TRANSACCION:  'POR_FUNCI_ELI'
 	#DESCRIPCION:	Eliminacion de registros
 	#AUTOR:		admin	
 	#FECHA:		20-09-2015 19:42:44
	***********************************/

	elsif(p_transaccion='POR_FUNCI_ELI')then

		begin
			--Sentencia de la eliminacion
			delete from por.tfuncionario
            where id_funcionario=v_parametros.id_funcionario;
               
            --Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','funcionario eliminado(a)'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_funcionario',v_parametros.id_funcionario::varchar);
              
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
ALTER FUNCTION "por"."ft_funcionario_ime"(integer, integer, character varying, character varying) OWNER TO postgres;
