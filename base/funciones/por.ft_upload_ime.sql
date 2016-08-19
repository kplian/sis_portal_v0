CREATE OR REPLACE FUNCTION por.ft_upload_ime (
  p_administrador integer,
  p_id_usuario integer,
  p_tabla varchar,
  p_transaccion varchar
)
RETURNS varchar AS
$body$
/**************************************************************************
 SISTEMA:		Sistema de subidas
 FUNCION: 		conta.ft_upload_ime
 DESCRIPCION:   revision
 AUTOR: 		Favio Figuero Penarrieta
 FECHA:	        21-09-2015 20:44:52
 COMENTARIOS:
***************************************************************************
 HISTORIAL DE MODIFICACIONES:

 DESCRIPCION:
 AUTOR:
 FECHA:
***************************************************************************/

DECLARE

	v_aux					varchar;
    v_arra				text[];



	v_parametros           	record;
	v_id_requerimiento     	integer;
	v_resp		            varchar;
	v_nombre_funcion        text;
	v_mensaje_error         text;
	v_id_auxiliar	integer;
	v_consulta						VARCHAR;
BEGIN

    v_nombre_funcion = 'por.ft_upload_ime';
    v_parametros = pxp.f_get_record(p_tabla);

	/*********************************
 	#TRANSACCION:  'POR_UPLOAD_MOD'
 	#DESCRIPCION:	modifica el nombre de subida
 	#AUTOR:		Favio Figueroa
 	#FECHA:		21-09-2015 20:44:52
	***********************************/

	if(p_transaccion='POR_UPLOAD_MOD')then

        begin


          v_arra := string_to_array(v_parametros.consulta,',');

					v_consulta := 'update por.'||v_arra[1]||' set '||v_arra[2]||'  = '''||v_arra[3]||''' , extension = '''||v_arra[4]||'''
          							where '||v_arra[5]||' = '||v_arra[6]||' ';



					EXECUTE v_consulta;

			--Definicion de la respuesta
          v_resp = pxp.f_agrega_clave(v_resp,'mensaje','modificado(a)');
          v_resp = pxp.f_agrega_clave(v_resp,'id_cambio',v_arra[6]::varchar);

					--RAISE EXCEPTION '%',v_resp;
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
$body$
LANGUAGE 'plpgsql'
VOLATILE
CALLED ON NULL INPUT
SECURITY INVOKER
COST 100;