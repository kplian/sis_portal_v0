CREATE OR REPLACE FUNCTION "por"."ft_publicacion_fb_sel"(	
				p_administrador integer, p_id_usuario integer, p_tabla character varying, p_transaccion character varying)
RETURNS character varying AS
$BODY$
/**************************************************************************
 SISTEMA:		portal
 FUNCION: 		por.ft_publicacion_fb_sel
 DESCRIPCION:   Funcion que devuelve conjuntos de registros de las consultas relacionadas con la tabla 'por.tpublicacion_fb'
 AUTOR: 		 (admin)
 FECHA:	        01-10-2015 13:41:00
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

	v_nombre_funcion = 'por.ft_publicacion_fb_sel';
    v_parametros = pxp.f_get_record(p_tabla);

	/*********************************    
 	#TRANSACCION:  'POR_PFB_SEL'
 	#DESCRIPCION:	Consulta de datos
 	#AUTOR:		admin	
 	#FECHA:		01-10-2015 13:41:00
	***********************************/

	if(p_transaccion='POR_PFB_SEL')then
     				
    	begin
    		--Sentencia de la consulta
			v_consulta:='select
						pfb.id_publicacion_fb,
						pfb.id_clase,
						pfb.user_fb,
						pfb.estado_reg,
						pfb.post_id,
						pfb.clase,
						pfb.id,
						pfb.id_usuario_reg,
						pfb.fecha_reg,
						pfb.usuario_ai,
						pfb.id_usuario_ai,
						pfb.fecha_mod,
						pfb.id_usuario_mod,
						usu1.cuenta as usr_reg,
						usu2.cuenta as usr_mod	
						from por.tpublicacion_fb pfb
						inner join segu.tusuario usu1 on usu1.id_usuario = pfb.id_usuario_reg
						left join segu.tusuario usu2 on usu2.id_usuario = pfb.id_usuario_mod
				        where  ';
			
			--Definicion de la respuesta
			v_consulta:=v_consulta||v_parametros.filtro;
			v_consulta:=v_consulta||' order by ' ||v_parametros.ordenacion|| ' ' || v_parametros.dir_ordenacion || ' limit ' || v_parametros.cantidad || ' offset ' || v_parametros.puntero;

			--Devuelve la respuesta
			return v_consulta;
						
		end;

	/*********************************    
 	#TRANSACCION:  'POR_PFB_CONT'
 	#DESCRIPCION:	Conteo de registros
 	#AUTOR:		admin	
 	#FECHA:		01-10-2015 13:41:00
	***********************************/

	elsif(p_transaccion='POR_PFB_CONT')then

		begin
			--Sentencia de la consulta de conteo de registros
			v_consulta:='select count(id_publicacion_fb)
					    from por.tpublicacion_fb pfb
					    inner join segu.tusuario usu1 on usu1.id_usuario = pfb.id_usuario_reg
						left join segu.tusuario usu2 on usu2.id_usuario = pfb.id_usuario_mod
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
ALTER FUNCTION "por"."ft_publicacion_fb_sel"(integer, integer, character varying, character varying) OWNER TO postgres;
