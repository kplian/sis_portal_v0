CREATE OR REPLACE FUNCTION "por"."ft_codigo_control_sel"(	
				p_administrador integer, p_id_usuario integer, p_tabla character varying, p_transaccion character varying)
RETURNS character varying AS
$BODY$
/**************************************************************************
 SISTEMA:		portal
 FUNCION: 		por.ft_codigo_control_sel
 DESCRIPCION:   Funcion que devuelve conjuntos de registros de las consultas relacionadas con la tabla 'por.tcodigo_control'
 AUTOR: 		 (admin)
 FECHA:	        23-09-2015 04:07:03
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

	v_nombre_funcion = 'por.ft_codigo_control_sel';
    v_parametros = pxp.f_get_record(p_tabla);

	/*********************************    
 	#TRANSACCION:  'POR_CODC_SEL'
 	#DESCRIPCION:	Consulta de datos
 	#AUTOR:		admin	
 	#FECHA:		23-09-2015 04:07:03
	***********************************/

	if(p_transaccion='POR_CODC_SEL')then
     				
    	begin
    		--Sentencia de la consulta
			v_consulta:='select
						codc.id_codigo_control,
						codc.llave,
						codc.importe,
						codc.autorizacion,
						codc.nit,
						codc.factura,
						codc.fecha,
						codc.estado_reg,
						codc.id_usuario_ai,
						codc.id_usuario_reg,
						codc.usuario_ai,
						codc.fecha_reg,
						codc.fecha_mod,
						codc.id_usuario_mod,
						usu1.cuenta as usr_reg,
						usu2.cuenta as usr_mod	
						from por.tcodigo_control codc
						inner join segu.tusuario usu1 on usu1.id_usuario = codc.id_usuario_reg
						left join segu.tusuario usu2 on usu2.id_usuario = codc.id_usuario_mod
				        where  ';
			
			--Definicion de la respuesta
			v_consulta:=v_consulta||v_parametros.filtro;
			v_consulta:=v_consulta||' order by ' ||v_parametros.ordenacion|| ' ' || v_parametros.dir_ordenacion || ' limit ' || v_parametros.cantidad || ' offset ' || v_parametros.puntero;

			--Devuelve la respuesta
			return v_consulta;
						
		end;

	/*********************************    
 	#TRANSACCION:  'POR_CODC_CONT'
 	#DESCRIPCION:	Conteo de registros
 	#AUTOR:		admin	
 	#FECHA:		23-09-2015 04:07:03
	***********************************/

	elsif(p_transaccion='POR_CODC_CONT')then

		begin
			--Sentencia de la consulta de conteo de registros
			v_consulta:='select count(id_codigo_control)
					    from por.tcodigo_control codc
					    inner join segu.tusuario usu1 on usu1.id_usuario = codc.id_usuario_reg
						left join segu.tusuario usu2 on usu2.id_usuario = codc.id_usuario_mod
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
ALTER FUNCTION "por"."ft_codigo_control_sel"(integer, integer, character varying, character varying) OWNER TO postgres;
