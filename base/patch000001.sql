/***********************************I-SCP-FFP-POR-1-18/09/2015****************************************/


CREATE TABLE por.tslider (
  id_slider SERIAL,
  titulo varchar(255),
  descripcion varchar(255),
  url_original VARCHAR(255),
  nombre_archivo varchar(255),
  extension varchar(255),
  orden INTEGER,
  estado varchar(255),

  CONSTRAINT pk_tslider__id_slider PRIMARY KEY(id_slider)
) INHERITS (pxp.tbase)
WITHOUT OIDS;

ALTER TABLE por.tslider
  ADD COLUMN folder VARCHAR(255);


CREATE TABLE por.tconfig_img (
	id_config_img SERIAL,
	clase varchar(255),
	ancho_mediano varchar(255),
	alto_mediano varchar(255),
	ancho_pequeno varchar(255),
	alto_pequeno varchar(255),
	CONSTRAINT pk_tconfig_img__id_config_img PRIMARY KEY(id_config_img)
) INHERITS (pxp.tbase)
WITHOUT OIDS;

ALTER TABLE por.tconfig_img
  ADD COLUMN ancho_original VARCHAR(255);


ALTER TABLE por.tconfig_img
  ADD COLUMN alto_original VARCHAR(255);


ALTER TABLE por.tconfig_img
  ADD COLUMN validado VARCHAR(2);

  ALTER TABLE por.tconfig_img
  ALTER COLUMN validado SET DEFAULT 'no';


CREATE TABLE por.tpost (
	id_post SERIAL,
	titulo varchar(255),
	subtitulo varchar(255),
	contenido text,
	nombre_imagen varchar(255),
    extension varchar(255),
	folder varchar(255),
    url_autor varchar(255),
    fecha date,
    estado varchar(255),
	CONSTRAINT pk_tpost__id_post PRIMARY KEY(id_post)
) INHERITS (pxp.tbase)
WITHOUT OIDS;

CREATE TABLE por.tdescarga (
	id_descarga SERIAL,
	titulo varchar(255),
	descripcion varchar(255),
	url_archivo varchar(255),
	tamano varchar(255),
    id_categoria integer,
	CONSTRAINT pk_tdescarga__id_descarga PRIMARY KEY(id_descarga)
) INHERITS (pxp.tbase)
WITHOUT OIDS;



  CREATE TABLE por.tcategoria (
	id_categoria SERIAL,
	nombre varchar(255),
	CONSTRAINT pk_tcategoria__id_categoria PRIMARY KEY(id_categoria)
) INHERITS (pxp.tbase)
WITHOUT OIDS;



CREATE TABLE por.tfuncionario (
	id_funcionario SERIAL,
	email_funcionario varchar(255),
    cargo varchar(255),
    id_persona integer,
	CONSTRAINT pk_tfuncionario__id_funcionario PRIMARY KEY(id_funcionario)
) INHERITS (pxp.tbase)
WITHOUT OIDS;



ALTER TABLE por.tdescarga ADD extension VARCHAR(255) NOT NULL;
ALTER TABLE por.tdescarga ADD nombre_archivo VARCHAR(255) NOT NULL;



ALTER TABLE por.tpost ALTER COLUMN contenido TYPE TEXT USING contenido::TEXT;



CREATE TABLE por.talbum (
	id_album SERIAL,
	nombre varchar(255),
	estado varchar(255),
	id_categoria integer,
	CONSTRAINT pk_talbum__id_album PRIMARY KEY(id_album)
) INHERITS (pxp.tbase)
WITHOUT OIDS;


CREATE TABLE por.timg (
	id_img SERIAL,
	nombre_archivo varchar(255),
	extension varchar(255),
	folder integer,
	id_album INTEGER,
	estado VARCHAR(255),
	CONSTRAINT pk_timg__id_img PRIMARY KEY(id_img)
) INHERITS (pxp.tbase)
WITHOUT OIDS;


ALTER TABLE por.timg ALTER COLUMN folder TYPE VARCHAR(255) USING folder::VARCHAR(255);



CREATE TABLE por.tredes_sociales (
	id_redes_sociales SERIAL,
	id varchar(255),
	descripcion varchar(255),
	token_api varchar(255),
	nombre varchar(255),
	url_page VARCHAR(255),
	CONSTRAINT pk_tredes_sociales__id_descarga PRIMARY KEY(id_redes_sociales)
) INHERITS (pxp.tbase)
WITHOUT OIDS;

ALTER TABLE por.tredes_sociales ALTER COLUMN token_api TYPE TEXT USING token_api::TEXT;




CREATE TABLE por.tpublicacion_fb (
	id_publicacion_fb SERIAL,
	id_clase varchar(255),
	clase varchar(255),
	post_id varchar(255),
	id varchar(255),
	user_fb VARCHAR(255),
	CONSTRAINT pk_tpublicacion_fb__id_descarga PRIMARY KEY(id_publicacion_fb)
) INHERITS (pxp.tbase)
WITHOUT OIDS;

/***********************************F-SCP-FFP-POR-1-18/09/2015****************************************/



/***********************************I-SCP-FFP-POR-1-24/02/2016****************************************/

ALTER TABLE por.tredes_sociales ADD tipo VARCHAR(255) NULL;

/***********************************F-SCP-FFP-POR-1-24/02/2016****************************************/


/***********************************I-SCP-FFP-POR-1-03/04/2016****************************************/

ALTER TABLE por.tdescarga ADD anio INTEGER NULL;



CREATE TABLE por.tpagina (
  id_pagina SERIAL,
  titulo varchar(255),
  descripcion VARCHAR(255),
  CONSTRAINT pk_tpagina__id_pagina PRIMARY KEY(id_pagina)
) INHERITS (pxp.tbase)
WITHOUT OIDS;


CREATE TABLE por.tpagina_contenido (
  id_pagina_contenido SERIAL,
  titulo varchar(255),
  contenido TEXT,
  nombre_archivo VARCHAR(255),
  extension VARCHAR(255),
  ruta_archivo VARCHAR(255),
  id_pagina INTEGER,
  CONSTRAINT pk_tpagina_contenido__id_pagina_contenido PRIMARY KEY(id_pagina_contenido)
) INHERITS (pxp.tbase)
WITHOUT OIDS;


ALTER TABLE por.tpagina ADD extension VARCHAR(255) NULL;
ALTER TABLE por.tpagina ADD nombre_archivo VARCHAR(255) NULL;
ALTER TABLE por.tpagina ADD ruta_archivo VARCHAR(255) NULL;

/***********************************F-SCP-FFP-POR-1-03/04/2016****************************************/


