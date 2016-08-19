CREATE OR REPLACE FUNCTION "por"."ft_img_ime"(
  p_administrador INTEGER, p_id_usuario INTEGER, p_tabla CHARACTER VARYING, p_transaccion CHARACTER VARYING)
  RETURNS CHARACTER VARYING AS
  $BODY$

  /**************************************************************************
   SISTEMA:		portal
   FUNCION: 		por.ft_img_ime
   DESCRIPCION:   Funcion que gestiona las operaciones basicas (inserciones, modificaciones, eliminaciones de la tabla 'por.timg'
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

    v_nro_requerimiento INTEGER;
    v_parametros        RECORD;
    v_id_requerimiento  INTEGER;
    v_resp              VARCHAR;
    v_nombre_funcion    TEXT;
    v_mensaje_error     TEXT;
    v_id_img            INTEGER;
    v_registros_json    RECORD;

  BEGIN

    v_nombre_funcion = 'por.ft_img_ime';
    v_parametros = pxp.f_get_record(p_tabla);

    /*********************************
     #TRANSACCION:  'POR_IMG_INS'
     #DESCRIPCION:	Insercion de registros
     #AUTOR:		admin
     #FECHA:		24-09-2015 18:53:20
    ***********************************/

    IF (p_transaccion = 'POR_IMG_INS')
    THEN

      BEGIN
        --Sentencia de la insercion
        INSERT INTO por.timg (
          estado_reg,
          estado,
          folder,
          extension,
          id_album,
          nombre_archivo,
          fecha_reg,
          usuario_ai,
          id_usuario_reg,
          id_usuario_ai,
          id_usuario_mod,
          fecha_mod
        ) VALUES (
          'activo',
          v_parametros.estado,
          v_parametros.folder,
          v_parametros.extension,
          v_parametros.id_album,
          v_parametros.nombre_archivo,
          now(),
          v_parametros._nombre_usuario_ai,
          p_id_usuario,
          v_parametros._id_usuario_ai,
          NULL,
          NULL


        )
        RETURNING id_img
          INTO v_id_img;

        --Definicion de la respuesta
        v_resp = pxp.f_agrega_clave(v_resp, 'mensaje', 'imagenes almacenado(a) con exito (id_img' || v_id_img || ')');
        v_resp = pxp.f_agrega_clave(v_resp, 'id_img', v_id_img :: VARCHAR);

        --Devuelve la respuesta
        RETURN v_resp;

      END;

    /*********************************
     #TRANSACCION:  'POR_IMG_MOD'
     #DESCRIPCION:	Modificacion de registros
     #AUTOR:		admin
     #FECHA:		24-09-2015 18:53:20
    ***********************************/

    ELSIF (p_transaccion = 'POR_IMG_MOD')
      THEN

        BEGIN
          --Sentencia de la modificacion
          UPDATE por.timg
          SET
            estado         = v_parametros.estado,
            folder         = v_parametros.folder,
            extension      = v_parametros.extension,
            id_album       = v_parametros.id_album,
            nombre_archivo = v_parametros.nombre_archivo,
            id_usuario_mod = p_id_usuario,
            fecha_mod      = now(),
            id_usuario_ai  = v_parametros._id_usuario_ai,
            usuario_ai     = v_parametros._nombre_usuario_ai
          WHERE id_img = v_parametros.id_img;

          --Definicion de la respuesta
          v_resp = pxp.f_agrega_clave(v_resp, 'mensaje', 'imagenes modificado(a)');
          v_resp = pxp.f_agrega_clave(v_resp, 'id_img', v_parametros.id_img :: VARCHAR);

          --Devuelve la respuesta
          RETURN v_resp;

        END;

    /*********************************
     #TRANSACCION:  'POR_IMG_ELI'
     #DESCRIPCION:	Eliminacion de registros
     #AUTOR:		admin
     #FECHA:		24-09-2015 18:53:20
    ***********************************/

    ELSIF (p_transaccion = 'POR_IMG_ELI')
      THEN

        BEGIN
          --Sentencia de la eliminacion
          DELETE FROM por.timg
          WHERE id_img = v_parametros.id_img;

          --Definicion de la respuesta
          v_resp = pxp.f_agrega_clave(v_resp, 'mensaje', 'imagenes eliminado(a)');
          v_resp = pxp.f_agrega_clave(v_resp, 'id_img', v_parametros.id_img :: VARCHAR);

          --Devuelve la respuesta
          RETURN v_resp;

        END;


    /*********************************
   #TRANSACCION:  'POR_IMG_JSON'
   #DESCRIPCION:	INSERCION de registros via json
   #AUTOR:		admin
   #FECHA:		24-09-2015 18:53:20
  ***********************************/

    ELSIF (p_transaccion = 'POR_IMG_JSON')
      THEN

        BEGIN
          FOR v_registros_json
          IN (SELECT *
              FROM json_populate_recordset(NULL :: por.json_img_ins, v_parametros.arra_json :: JSON))
          LOOP
            --RAISE EXCEPTION '%', v_registros_json;

            INSERT INTO por.timg (
              estado_reg,
              estado,
              folder,
              extension,
              id_album,
              nombre_archivo,
              fecha_reg,
              usuario_ai,
              id_usuario_reg,
              id_usuario_ai,
              id_usuario_mod,
              fecha_mod
            ) VALUES (
              'activo',
              'activo',
              v_registros_json.folder,
              v_registros_json.extension,
              v_registros_json.id_album,
              v_registros_json.nombre_archivo,
              now(),
              v_parametros._nombre_usuario_ai,
              p_id_usuario,
              v_parametros._id_usuario_ai,
              NULL,
              NULL


            );



          END LOOP;


          --Definicion de la respuesta
          v_resp = pxp.f_agrega_clave(v_resp, 'mensaje', 'imagenes(a)');
          v_resp = pxp.f_agrega_clave(v_resp, 'id_album', v_parametros.id_album :: VARCHAR);

          --Devuelve la respuesta
          RETURN v_resp;

        END;


    ELSE

      RAISE EXCEPTION 'Transaccion inexistente: %', p_transaccion;

    END IF;

    EXCEPTION

    WHEN OTHERS THEN
      v_resp='';
      v_resp = pxp.f_agrega_clave(v_resp, 'mensaje', SQLERRM);
      v_resp = pxp.f_agrega_clave(v_resp, 'codigo_error', SQLSTATE);
      v_resp = pxp.f_agrega_clave(v_resp, 'procedimientos', v_nombre_funcion);
      RAISE EXCEPTION '%', v_resp;

  END;
  $BODY$
LANGUAGE 'plpgsql' VOLATILE
COST 100;
ALTER FUNCTION "por"."ft_img_ime"( INTEGER, INTEGER, CHARACTER VARYING, CHARACTER VARYING )
OWNER TO postgres;
