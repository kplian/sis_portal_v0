CREATE OR REPLACE FUNCTION "por"."ft_funcionario_sel"(	
				p_administrador integer, p_id_usuario integer, p_tabla character varying, p_transaccion character varying)
RETURNS character varying AS
$BODY$
/**************************************************************************
 SISTEMA:		portal
 FUNCION: 		por.ft_funcionario_sel
 DESCRIPCION:   Funcion que devuelve conjuntos de registros de las consultas relacionadas con la tabla 'por.tfuncionario'
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

	v_consulta    		varchar;
	v_parametros  		record;
	v_nombre_funcion   	text;
	v_resp				varchar;
			    
BEGIN

	v_nombre_funcion = 'por.ft_funcionario_sel';
    v_parametros = pxp.f_get_record(p_tabla);

	/*********************************    
 	#TRANSACCION:  'POR_FUNCI_SEL'
 	#DESCRIPCION:	Consulta de datos
 	#AUTOR:		admin	
 	#FECHA:		20-09-2015 19:42:44
	***********************************/

	if(p_transaccion='POR_FUNCI_SEL')then
     				
    	begin
    		--Sentencia de la consulta
			v_consulta:='select
						funci.id_funcionario,
						funci.email_funcionario,
						funci.id_persona,
						funci.cargo,
						funci.estado_reg,
						funci.id_usuario_ai,
						funci.fecha_reg,
						funci.usuario_ai,
						funci.id_usuario_reg,
						funci.fecha_mod,
						funci.id_usuario_mod,
						usu1.cuenta as usr_reg,
						usu2.cuenta as usr_mod	,
						PERSON.nombre_completo2 as desc_person
						from por.tfuncionario funci
						inner join segu.tusuario usu1 on usu1.id_usuario = funci.id_usuario_reg
						left join segu.tusuario usu2 on usu2.id_usuario = funci.id_usuario_mod
						INNER JOIN segu.vpersona PERSON on PERSON.id_persona = funci.id_persona
				        where  ';
			
			--Definicion de la respuesta
			v_consulta:=v_consulta||v_parametros.filtro;
			v_consulta:=v_consulta||' order by ' ||v_parametros.ordenacion|| ' ' || v_parametros.dir_ordenacion || ' limit ' || v_parametros.cantidad || ' offset ' || v_parametros.puntero;

			--Devuelve la respuesta
			return v_consulta;
						
		end;

	/*********************************    
 	#TRANSACCION:  'POR_FUNCI_CONT'
 	#DESCRIPCION:	Conteo de registros
 	#AUTOR:		admin	
 	#FECHA:		20-09-2015 19:42:44
	***********************************/

	elsif(p_transaccion='POR_FUNCI_CONT')then

		begin
			--Sentencia de la consulta de conteo de registros
			v_consulta:='select count(id_funcionario)
					    from por.tfuncionario funci
					    inner join segu.tusuario usu1 on usu1.id_usuario = funci.id_usuario_reg
						left join segu.tusuario usu2 on usu2.id_usuario = funci.id_usuario_mod
						INNER JOIN segu.vpersona PERSON on PERSON.id_persona = funci.id_persona

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
ALTER FUNCTION "por"."ft_funcionario_sel"(integer, integer, character varying, character varying) OWNER TO postgres;
