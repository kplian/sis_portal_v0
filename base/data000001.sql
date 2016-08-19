/********************************************I-DAT-FFP-CAT-0-18/09/2015********************************************/

INSERT INTO segu.tsubsistema ( codigo, nombre, fecha_reg, prefijo, estado_reg, nombre_carpeta, id_subsis_orig)
VALUES ('POR', 'portal', '2015-09-18', 'POR', 'activo', 'portal', NULL);


select pxp.f_insert_tgui ('PORTAL', '', 'POR', 'si', 1, '', 1, '', '', 'POR');
select pxp.f_insert_tgui ('slider', 'slider', 'SLIDER', 'si', 1, 'sis_portal/vista/slider/Slider.php', 2, '', 'Slider', 'POR');
select pxp.f_insert_tgui ('configuraciones', 'configuraciones', 'CONFIM', 'si', 2, 'sis_portal/vista/config_img/ConfigImg.php', 2, '', 'ConfigImg', 'POR');



select pxp.f_insert_tgui ('Post', 'Post', 'POST', 'si', 3, 'sis_portal/vista/post/Post.php', 2, '', 'Post', 'POR');
select pxp.f_insert_tgui ('descarga', 'descarga', 'DESCA', 'si', 4, 'sis_portal/vista/descarga/Descarga.php', 2, '', 'Descarga', 'POR');
select pxp.f_insert_tgui ('configu', 'configu', 'CONFIGU', 'si', 1, '', 2, '', '', 'POR');
select pxp.f_insert_tgui ('Categoria', 'Categoria', 'CATE', 'si', 1, 'sis_portal/vista/categoria/Categoria.php', 3, '', 'Categoria', 'POR');
select pxp.f_insert_tgui ('Funcionario', 'Funcionario', 'FUN', 'si', 5, 'sis_portal/vista/funcionario/Funcionario.php', 2, '', 'Funcionario', 'POR');



select pxp.f_insert_tgui ('album', 'album', 'ALBM', 'si', 5, 'sis_portal/vista/album/Album.php', 2, '', 'Album', 'POR');


/********************************************F-DAT-FFP-CAT-0-18/09/2015********************************************/


/********************************************I-DAT-FFP-CAT-0-04/04/2016********************************************/

select pxp.f_insert_tgui ('FaceBook', 'facebook', 'FACEBO', 'si', 1, 'sis_portal/vista/redes_sociales/RedesSociales.php', 2, '', 'RedesSociales', 'POR');
select pxp.f_insert_tgui ('Paginas', 'paginas', 'PAGI', 'si', 1, 'sis_portal/vista/pagina/Pagina.php', 2, '', 'Pagina', 'POR');
/********************************************F-DAT-FFP-CAT-0-04/04/2016********************************************/
