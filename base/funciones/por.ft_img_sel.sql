CREATE OR REPLACE FUNCTION "por"."ft_img_sel"(	
				p_administrador integer, p_id_usuario integer, p_tabla character varying, p_transaccion character varying)
RETURNS character varying AS
$BODY$
/**************************************************************************
 SISTEMA:		portal
 FUNCION: 		por.ft_img_sel
 DESCRIPCION:   Funcion que devuelve conjuntos de registros de las consultas relacionadas con la tabla 'por.timg'
 AUTOR: 		 (admin)
 FECHA:	        24-09-2015 18:53:20
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

	v_nombre_funcion = 'por.ft_img_sel';
    v_parametros = pxp.f_get_record(p_tabla);

	/*********************************    
 	#TRANSACCION:  'POR_IMG_SEL'
 	#DESCRIPCION:	Consulta de datos
 	#AUTOR:		admin	
 	#FECHA:		24-09-2015 18:53:20
	***********************************/

	if(p_transaccion='POR_IMG_SEL')then
     				
    	begin
    		--Sentencia de la consulta
			v_consulta:='select
						img.id_img,
						img.estado_reg,
						img.estado,
						img.folder,
						img.extension,
						img.id_album,
						img.nombre_archivo,
						img.fecha_reg,
						img.usuario_ai,
						img.id_usuario_reg,
						img.id_usuario_ai,
						img.id_usuario_mod,
						img.fecha_mod,
						usu1.cuenta as usr_reg,
						usu2.cuenta as usr_mod,
							al.nombre as desc_album
						from por.timg img
						inner join segu.tusuario usu1 on usu1.id_usuario = img.id_usuario_reg
						left join segu.tusuario usu2 on usu2.id_usuario = img.id_usuario_mod
						  inner join por.talbum al on al.id_album = img.id_album
 						 inner join por.tcategoria cat on cat.id_categoria = al.id_categoria
				        where  ';
			
			--Definicion de la respuesta
			v_consulta:=v_consulta||v_parametros.filtro;
			v_consulta:=v_consulta||' order by ' ||v_parametros.ordenacion|| ' ' || v_parametros.dir_ordenacion || ' limit ' || v_parametros.cantidad || ' offset ' || v_parametros.puntero;

			--Devuelve la respuesta
			return v_consulta;
						
		end;

	/*********************************    
 	#TRANSACCION:  'POR_IMG_CONT'
 	#DESCRIPCION:	Conteo de registros
 	#AUTOR:		admin	
 	#FECHA:		24-09-2015 18:53:20
	***********************************/

	elsif(p_transaccion='POR_IMG_CONT')then

		begin
			--Sentencia de la consulta de conteo de registros
			v_consulta:='select count(id_img)
					    from por.timg img
					    inner join segu.tusuario usu1 on usu1.id_usuario = img.id_usuario_reg
						left join segu.tusuario usu2 on usu2.id_usuario = img.id_usuario_mod
						 inner join por.talbum al on al.id_album = img.id_album
 						 inner join por.tcategoria cat on cat.id_categoria = al.id_categoria
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
ALTER FUNCTION "por"."ft_img_sel"(integer, integer, character varying, character varying) OWNER TO postgres;
