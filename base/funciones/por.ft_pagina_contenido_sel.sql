CREATE OR REPLACE FUNCTION "por"."ft_pagina_contenido_sel"(	
				p_administrador integer, p_id_usuario integer, p_tabla character varying, p_transaccion character varying)
RETURNS character varying AS
$BODY$
/**************************************************************************
 SISTEMA:		portal
 FUNCION: 		por.ft_pagina_contenido_sel
 DESCRIPCION:   Funcion que devuelve conjuntos de registros de las consultas relacionadas con la tabla 'por.tpagina_contenido'
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

	v_consulta    		varchar;
	v_parametros  		record;
	v_nombre_funcion   	text;
	v_resp				varchar;
			    
BEGIN

	v_nombre_funcion = 'por.ft_pagina_contenido_sel';
    v_parametros = pxp.f_get_record(p_tabla);

	/*********************************    
 	#TRANSACCION:  'POR_PAGCON_SEL'
 	#DESCRIPCION:	Consulta de datos
 	#AUTOR:		admin	
 	#FECHA:		03-04-2016 17:58:58
	***********************************/

	if(p_transaccion='POR_PAGCON_SEL')then
     				
    	begin
    		--Sentencia de la consulta
			v_consulta:='select
						pagcon.id_pagina_contenido,
						pagcon.ruta_archivo,
						pagcon.estado_reg,
						pagcon.nombre_archivo,
						pagcon.contenido,
						pagcon.extension,
						pagcon.id_pagina,
						pagcon.titulo,
						pagcon.id_usuario_reg,
						pagcon.fecha_reg,
						pagcon.usuario_ai,
						pagcon.id_usuario_ai,
						pagcon.id_usuario_mod,
						pagcon.fecha_mod,
						usu1.cuenta as usr_reg,
						usu2.cuenta as usr_mod	
						from por.tpagina_contenido pagcon
						inner join segu.tusuario usu1 on usu1.id_usuario = pagcon.id_usuario_reg
						left join segu.tusuario usu2 on usu2.id_usuario = pagcon.id_usuario_mod
				        where  ';
			
			--Definicion de la respuesta
			v_consulta:=v_consulta||v_parametros.filtro;
			v_consulta:=v_consulta||' order by ' ||v_parametros.ordenacion|| ' ' || v_parametros.dir_ordenacion || ' limit ' || v_parametros.cantidad || ' offset ' || v_parametros.puntero;

			--Devuelve la respuesta
			return v_consulta;
						
		end;

	/*********************************    
 	#TRANSACCION:  'POR_PAGCON_CONT'
 	#DESCRIPCION:	Conteo de registros
 	#AUTOR:		admin	
 	#FECHA:		03-04-2016 17:58:58
	***********************************/

	elsif(p_transaccion='POR_PAGCON_CONT')then

		begin
			--Sentencia de la consulta de conteo de registros
			v_consulta:='select count(id_pagina_contenido)
					    from por.tpagina_contenido pagcon
					    inner join segu.tusuario usu1 on usu1.id_usuario = pagcon.id_usuario_reg
						left join segu.tusuario usu2 on usu2.id_usuario = pagcon.id_usuario_mod
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
ALTER FUNCTION "por"."ft_pagina_contenido_sel"(integer, integer, character varying, character varying) OWNER TO postgres;
