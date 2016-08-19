CREATE OR REPLACE FUNCTION "por"."ft_pagina_sel"(	
				p_administrador integer, p_id_usuario integer, p_tabla character varying, p_transaccion character varying)
RETURNS character varying AS
$BODY$
/**************************************************************************
 SISTEMA:		portal
 FUNCION: 		por.ft_pagina_sel
 DESCRIPCION:   Funcion que devuelve conjuntos de registros de las consultas relacionadas con la tabla 'por.tpagina'
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

	v_consulta    		varchar;
	v_parametros  		record;
	v_nombre_funcion   	text;
	v_resp				varchar;
			    
BEGIN

	v_nombre_funcion = 'por.ft_pagina_sel';
    v_parametros = pxp.f_get_record(p_tabla);

	/*********************************    
 	#TRANSACCION:  'POR_PAG_SEL'
 	#DESCRIPCION:	Consulta de datos
 	#AUTOR:		admin	
 	#FECHA:		03-04-2016 17:58:39
	***********************************/

	if(p_transaccion='POR_PAG_SEL')then
     				
    	begin
    		--Sentencia de la consulta
			v_consulta:='select
						pag.id_pagina,
						pag.descripcion,
						pag.estado_reg,
						pag.titulo,
						pag.id_usuario_ai,
						pag.fecha_reg,
						pag.usuario_ai,
						pag.id_usuario_reg,
						pag.id_usuario_mod,
						pag.fecha_mod,
						usu1.cuenta as usr_reg,
						usu2.cuenta as usr_mod,
								pag.ruta_archivo,
							pag.extension,
							pag.nombre_archivo
						from por.tpagina pag
						inner join segu.tusuario usu1 on usu1.id_usuario = pag.id_usuario_reg
						left join segu.tusuario usu2 on usu2.id_usuario = pag.id_usuario_mod
				        where  ';


			--Definicion de la respuesta
			v_consulta:=v_consulta||v_parametros.filtro;
			v_consulta:=v_consulta||' order by ' ||v_parametros.ordenacion|| ' ' || v_parametros.dir_ordenacion || ' limit ' || v_parametros.cantidad || ' offset ' || v_parametros.puntero;

			--Devuelve la respuesta
			return v_consulta;
						
		end;

	/*********************************    
 	#TRANSACCION:  'POR_PAG_CONT'
 	#DESCRIPCION:	Conteo de registros
 	#AUTOR:		admin	
 	#FECHA:		03-04-2016 17:58:39
	***********************************/

	elsif(p_transaccion='POR_PAG_CONT')then

		begin
			--Sentencia de la consulta de conteo de registros
			v_consulta:='select count(id_pagina)
					    from por.tpagina pag
					    inner join segu.tusuario usu1 on usu1.id_usuario = pag.id_usuario_reg
						left join segu.tusuario usu2 on usu2.id_usuario = pag.id_usuario_mod
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
ALTER FUNCTION "por"."ft_pagina_sel"(integer, integer, character varying, character varying) OWNER TO postgres;
