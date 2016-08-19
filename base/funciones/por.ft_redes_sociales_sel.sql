CREATE OR REPLACE FUNCTION "por"."ft_redes_sociales_sel"(	
				p_administrador integer, p_id_usuario integer, p_tabla character varying, p_transaccion character varying)
RETURNS character varying AS
$BODY$
/**************************************************************************
 SISTEMA:		portal
 FUNCION: 		por.ft_redes_sociales_sel
 DESCRIPCION:   Funcion que devuelve conjuntos de registros de las consultas relacionadas con la tabla 'por.tredes_sociales'
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

	v_consulta    		varchar;
	v_parametros  		record;
	v_nombre_funcion   	text;
	v_resp				varchar;
			    
BEGIN

	v_nombre_funcion = 'por.ft_redes_sociales_sel';
    v_parametros = pxp.f_get_record(p_tabla);

	/*********************************    
 	#TRANSACCION:  'POR_REDS_SEL'
 	#DESCRIPCION:	Consulta de datos
 	#AUTOR:		admin	
 	#FECHA:		30-09-2015 14:38:24
	***********************************/

	if(p_transaccion='POR_REDS_SEL')then
     				
    	begin
    		--Sentencia de la consulta
			v_consulta:='select
						reds.id_redes_sociales,
						reds.url_page,
						reds.estado_reg,
						reds.token_api,
						reds.nombre,
						reds.descripcion,
						reds.id,
						reds.fecha_reg,
						reds.usuario_ai,
						reds.id_usuario_reg,
						reds.id_usuario_ai,
						reds.id_usuario_mod,
						reds.fecha_mod,
						usu1.cuenta as usr_reg,
						usu2.cuenta as usr_mod,
							tipo
						from por.tredes_sociales reds
						inner join segu.tusuario usu1 on usu1.id_usuario = reds.id_usuario_reg
						left join segu.tusuario usu2 on usu2.id_usuario = reds.id_usuario_mod
				        where  ';

			
			--Definicion de la respuesta
			v_consulta:=v_consulta||v_parametros.filtro;
			v_consulta:=v_consulta||' order by ' ||v_parametros.ordenacion|| ' ' || v_parametros.dir_ordenacion || ' limit ' || v_parametros.cantidad || ' offset ' || v_parametros.puntero;

			--Devuelve la respuesta
			return v_consulta;
						
		end;

	/*********************************    
 	#TRANSACCION:  'POR_REDS_CONT'
 	#DESCRIPCION:	Conteo de registros
 	#AUTOR:		admin	
 	#FECHA:		30-09-2015 14:38:24
	***********************************/

	elsif(p_transaccion='POR_REDS_CONT')then

		begin
			--Sentencia de la consulta de conteo de registros
			v_consulta:='select count(id_redes_sociales)
					    from por.tredes_sociales reds
					    inner join segu.tusuario usu1 on usu1.id_usuario = reds.id_usuario_reg
						left join segu.tusuario usu2 on usu2.id_usuario = reds.id_usuario_mod
					    where ';
			
			--Definicion de la respuesta		    
			v_consulta:=v_consulta||v_parametros.filtro;

			--Devuelve la respuesta
			return v_consulta;

		end;
					
	else
					     
		raise exception 'Transaccion inexistente';
					         
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
ALTER FUNCTION "por"."ft_redes_sociales_sel"(integer, integer, character varying, character varying) OWNER TO postgres;
