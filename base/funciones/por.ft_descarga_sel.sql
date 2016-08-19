CREATE OR REPLACE FUNCTION "por"."ft_descarga_sel"(	
				p_administrador integer, p_id_usuario integer, p_tabla character varying, p_transaccion character varying)
RETURNS character varying AS
$BODY$
/**************************************************************************
 SISTEMA:		portal
 FUNCION: 		por.ft_descarga_sel
 DESCRIPCION:   Funcion que devuelve conjuntos de registros de las consultas relacionadas con la tabla 'por.tdescarga'
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

	v_consulta    		varchar;
	v_parametros  		record;
	v_nombre_funcion   	text;
	v_resp				varchar;
			    
BEGIN

	v_nombre_funcion = 'por.ft_descarga_sel';
    v_parametros = pxp.f_get_record(p_tabla);

	/*********************************    
 	#TRANSACCION:  'POR_DES_SEL'
 	#DESCRIPCION:	Consulta de datos
 	#AUTOR:		admin	
 	#FECHA:		20-09-2015 19:00:21
	***********************************/

	if(p_transaccion='POR_DES_SEL')then
     				
    	begin
    		--Sentencia de la consulta
			v_consulta:='select
						des.id_descarga,
						des.titulo,
						des.url_archivo,
						des.descripcion,
						des.tamano,
						des.id_categoria,
						des.estado_reg,
						des.id_usuario_ai,
						des.fecha_reg,
						des.usuario_ai,
						des.id_usuario_reg,
						des.fecha_mod,
						des.id_usuario_mod,
						usu1.cuenta as usr_reg,
						usu2.cuenta as usr_mod,
							cat.nombre as desc_categoria,
							des.nombre_archivo,
							des.extension,
							des.anio
						from por.tdescarga des
						inner join segu.tusuario usu1 on usu1.id_usuario = des.id_usuario_reg
						left join segu.tusuario usu2 on usu2.id_usuario = des.id_usuario_mod
						inner join por.tcategoria cat on cat.id_categoria = des.id_categoria
				        where  ';


			--Definicion de la respuesta
			v_consulta:=v_consulta||v_parametros.filtro;
			v_consulta:=v_consulta||' order by ' ||v_parametros.ordenacion|| ' ' || v_parametros.dir_ordenacion || ' limit ' || v_parametros.cantidad || ' offset ' || v_parametros.puntero;

			--Devuelve la respuesta
			return v_consulta;
						
		end;

	/*********************************    
 	#TRANSACCION:  'POR_DES_CONT'
 	#DESCRIPCION:	Conteo de registros
 	#AUTOR:		admin	
 	#FECHA:		20-09-2015 19:00:21
	***********************************/

	elsif(p_transaccion='POR_DES_CONT')then

		begin
			--Sentencia de la consulta de conteo de registros
			v_consulta:='select count(id_descarga)
					    from por.tdescarga des
					    inner join segu.tusuario usu1 on usu1.id_usuario = des.id_usuario_reg
						left join segu.tusuario usu2 on usu2.id_usuario = des.id_usuario_mod
						inner join por.tcategoria cat on cat.id_categoria = des.id_categoria
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
ALTER FUNCTION "por"."ft_descarga_sel"(integer, integer, character varying, character varying) OWNER TO postgres;
