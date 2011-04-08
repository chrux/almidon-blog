<?php
/**
 * Project: A single blog in almidon
 * File: blog.class.php
 * Description: Structures
 * Author: Christian Torres <chtorrez at gmail dot com>
 * Date: 2011-03-29
 *
 * Tables for Blogs
 *
 * @author Christian Torres <chtorrez at gmail dot com>
 * @category almidon
 * @package almidon-blog
 * @version 1.0
 */

/**
 * ab_pageTable
 *
 * create a page, normally it is used to save info which it is not frecuently modified
 */
class ab_pageTable extends Table {
  function ab_pageTable() {
    $this->Table('ab_page');
    $this->key = 'idab_page';
    $this->title = 'Páginas';
    $this->maxrows = 20;
    $this->order = 'idab_page';
    $this->addColumn('idab_page','varchar',48,1,0,'URI');
    $this->addColumn('ab_page','varchar',500,0,0,'Titulo');
    $this->addColumn('body','xhtml',0,0,0,'Texto');
    $this->addColumn('menu','bool',0,0,0,'Menu Superior?');
    $this->addColumn('orden','int',0,0,0,'Orden');
  }
}
/**
 * ab_authorTable
 *
 * create a structure for saving authors
 */
class ab_authorTable extends Table {
  function ab_authorTable() {
    $this->Table('ab_author');
    $this->title = 'Autores';
    $this->key = 'idab_author';
    $this->order = 'ab_author,idab_author';
    $this->addColumn('idab_author','serial',0,1,0,'Id');
    $this->addColumn('ab_author','varchar',120,0,0,'Nombre');
    $this->addColumn('birthdate','date',0,0,0,'Fecha de Nacimiento',array('range'=>'-20:'.(date("Y")-80)));
    $this->addColumn('photo','image',0,0,0,'Foto');//,array('sizes'=>'145x100x1,101x67x1'));
    $this->addColumn('bio','text',0,0,0,'Biograf&iacute;a');
  }
}

/**
 * ab_entryTable
 *
 * create a structure for saving entries
 */
class ab_entryTable extends Table {
  function ab_entryTable() {
    $this->Table('ab_entry');
    $this->key = 'idab_entry';
    $this->title = 'Entradas';
    $this->order = 'public DESC,creation DESC';
    $this->addColumn('idab_entry','serial',0,1,0,'Id');
    $this->addColumn('ab_entry','varchar',500,0,0,'Titulo');
    $this->addColumn('body','xhtml',0,0,0,'Texto',array('style'=>'height:150px;width:200px;'));
    $this->addColumn('public','bool',0,0,0,'Publicar?');
    $this->addColumn('idab_author','int',0,0,'ab_author','Autor');
    $this->addColumn('creation','auto',0,0,0,'Creación');
    $this->addColumn('read','auto',0,0,0,'Leida');
    $this->addColumn('print','auto',0,0,0,'Impresa');
    $this->addColumn('sent','auto',0,0,0,'Enviada');
    $this->addColumn('ab_author.photo AS authorpic','external');
    $this->addColumn('(SELECT count(idab_comment) FROM ab_comment WHERE idab_entry=ab_entry.idab_entry AND public) AS comments','external');
  }
}

/**
 * ab_commentTable
 *
 * create a structure for saving comments of guests
 */
class ab_commentTable extends Table {
  function ab_commentTable() {
    $this->Table('ab_comment');
    $this->key = 'idab_comment';
    $this->title = 'Comentarios';
    $this->order = 'ab_comment.public, sentdate DESC';
    //$this->filter = "ab_comment.public IS NOT TRUE";
    $this->addColumn('idab_comment','serial',0,1,0,'Id');
    $this->addColumn('idab_entry','int',0,0,'ab_entry','Entrada',array('readonly'=>true));
    $this->addColumn('name','varchar',180,0,0,'Nombre');
    $this->addColumn('web','varchar',200,0,0,'Web');
    $this->addColumn('email','varchar',300,0,0,'Email');
    $this->addColumn('ab_comment','text',0,0,0,'Comentario');
    $this->addColumn('public','bool',0,0,0,'Publicar?');
    $this->addColumn('ip',(ADMIN===true?'auto':'varchar'),120,0,0,'IP');
    $this->addColumn('sentdate','auto',0,0,0,'Fecha');
  }
}

/**
 * ab_image
 *
 * A media library for images
 */
class ab_imageTable extends Table {
  function ab_imageTable() {
    $this->Table('ab_image');
    $this->key = 'idab_image';
    $this->title = 'Imagenes';
    $this->order = 'creation DESC, idab_image DESC';
    $this->addColumn('idab_image','serial',0,1,0,'Id');
    $this->addColumn('ab_image','varchar',200,0,0,'Titulo');
    $this->addColumn('file','image',0,0,0,'Imagen',array('sizes'=>'480,407x222x1,131x130x1,230x160x1,365x235x1'));
    $this->addColumn('credit','varchar',500,0,0,'Texto/Credito');
    $this->addColumn('creation','auto',0,0,0,'Fecha');
  }
}

/**
 * ab_video
 *
 * A media library for videos
 */
class ab_videoTable extends Table {
  function ab_videoTable() {
    $this->Table('ab_video');
    $this->key = 'idab_video';
    $this->title = 'Videos';
    $this->order = 'creation DESC, idab_video DESC';
    $this->addColumn('idab_video','serial',0,1,0,'Id');
    $this->addColumn('ab_video','varchar',200,0,0,'Titulo');
    $this->addColumn('url','varchar',500,0,0,'Video(youtube/google video)');
    $this->addColumn('credit','varchar',500,0,0,'Texto/Credito');
    $this->addColumn('creation','auto',0,0,0,'Fecha');
  }
}

/**
 * ab_audio
 *
 * A media library for audios
 */
class ab_audioTable extends Table {
  function ab_audioTable() {
    $this->Table('ab_audio');
    $this->title = 'Audio';
    $this->key = 'idab_audio';
    $this->order = 'idab_audio';
    $this->addColumn('idab_audio','serial',0,1,0,'Id');
    $this->addColumn('ab_audio','varchar',250,0,0,'Titulo');
    $this->addColumn('credit','varchar',500,0,0,'Texto/Creditos'); // en un text area seria mejor
    $this->addColumn('file','file',0,0,0,'MP3');
    $this->addColumn('creation','auto',0,0,0,'Fecha');
  }
}

/**
 * ab_gallery
 *
 * A media library for gallery
 */
class ab_galleryTable extends Table {
  function ab_galleryTable() {
    $this->Table('ab_gallery');
    $this->key = 'idab_gallery';
    $this->title ='Galeria de Fotos';
    $this->order ='creation DESC, idab_gallery DESC';
    $this->child = 'ab_photo';
    $this->addColumn('idab_gallery','serial',0,1,0,'Id');
    $this->addColumn('ab_gallery','varchar',500,0,0,'Titulo');
    $this->addColumn('body','text',0,0,0,'Texto');
    $this->addColumn('creation','auto',0,0,0,'Fecha');
  }
}

/**
 * ab_photo
 *
 * A media library for gallery's photos
 */
class ab_photoTable extends Table {
  function ab_photoTable() {
    $this->Table('ab_photo');
    $this->key = 'idab_photo';
    $this->title ='Fotos';
    $this->order ='idab_gallery DESC, idab_photo DESC';
    $this->is_detail = true;
    $this->addColumn('idab_photo','serial',0,1,0,'Id');
    $this->addColumn('idab_gallery','int',0,0,'galeria','Galeria');
    $this->addColumn('ab_photo','varchar',500,0,0,'Titulo/Credito');
    $this->addColumn('image','image',0,0,0,'Foto');
    $this->addColumn('creation','auto',0,0,0,'Fecha');
  }
}

/**
 * ab_doc
 *
 * A media library documents
 */
class ab_docTable extends Table {
  function ab_docTable() {
    $this->Table('ab_doc');
    $this->key = 'idab_doc';
    $this->title ='Documentos';
    $this->order ='creation DESC, idab_doc DESC';
    $this->addColumn('idab_doc','serial',0,1,0,'Id');
    $this->addColumn('ab_doc','varchar',500,0,0,'Titulo');
    $this->addColumn('file','file',0,0,0,'Archivo');
    $this->addColumn('description','text',0,0,0,'Descripcion');
    $this->addColumn('creation','auto',0,0,0,'Fecha');
  }
}
