<?php
require './common.inc.php';

if ( $_POST['action']=='comment' ) {
  session_start();
  include_once dirname(__FILE__) . '/securimage/securimage.php';
  $securimage = new Securimage();
  $_POST['captcha'] = str_replace(' ','',trim($_POST['captcha']));
  $_POST['name'] = trim(strip_tags($_POST['name']));
  $_POST['email'] = trim(strip_tags($_POST['email']));
  $_POST['ab_comment'] = trim(strip_tags($_POST['ab_comment']));
  if (empty($_POST['captcha'])) {
    error_log("Error CAPTCHA: Codigo vacio, no se introdujo ninguno.");
    $msg = '<div class="error">Error CAPTCHA: Codigo vacio, no se introdujo ninguno.</div>';
    $smarty->assign('msg',$msg);
    $smarty->assign('data',$_POST);
  } elseif ($securimage->check($_POST['captcha']) == false) {
    error_log("Error CAPTCHA: Codigo ".$_POST['captcha']." equivocado, los captcha no coinciden.");
    $msg = '<div class="error">Error CAPTCHA: Codigo digitado no es correcto.</div>';
    $smarty->assign('msg',$msg);
    $smarty->assign('data',$_POST);
  # Si los campos requeridos son vacios
  } elseif ( empty($_POST['name']) ) {
    error_log("Error: Campo *Nombre* es requerido.");
    $msg = '<div class="error">Error: Campo *Nombre* es requerido.</div>';
    $smarty->assign('msg',$msg);
    $smarty->assign('data',$_POST);
  } elseif ( empty($_POST['email']) ) {
    error_log("Error: Campo *Correo Electrónico* es requerido.");
    $msg = '<div class="error">Error: Campo *Correo Electrónico* es requerido.</div>';
    $smarty->assign('msg',$msg);
    $smarty->assign('data',$_POST);
  } elseif ( empty($_POST['ab_comment']) ) {
    error_log("Error: Campo Comentario es requerido.");
    $msg = '<div class="error">Error: Campo *Comentario* es requerido.</div>';
    $smarty->assign('msg',$msg);
    $smarty->assign('data',$_POST);
  # Todo bien
  } else {
    $_REQUEST['ip'] = getip();
    $ab_comment = new ab_commentTable();
    $ab_comment->readEnv();
    $ab_comment->addRecord();
    header( "Location: " . selfURL() . '?m=1#frmcomentarios' );
    exit;
  }
} elseif ( $_REQUEST['m']==1) {
  $msg = '<div class="succ">Muchas Gracias su comentario ha sido enviado.</div>';
  $smarty->assign('msg',$msg);
}

$tpl = AB_TPL_DIR . 'index.tpl';
$pattern = 'blog|entry|' . $tpl_id = $_REQUEST['idab_entry'] = trim(preg_replace('(\.(.*))','',$_REQUEST['idab_entry']),"/\t\n \r\0\x0B");
$patron = "^[[:digit:]]+$";
$table = new Table('ab_page');

if(eregi($patron,$tpl_id))
  $exist = (bool)$table->getVar("SELECT idab_entry FROM ab_entry WHERE idab_entry = ".((int)escape($table,$_REQUEST['idab_entry'])));
else $exist = false;
if(!$exist) {
  if($tpl_id) 
    $grp_id = 'blog|404';
  else {
    $tpl_id = 'notallowed';
  }
  $smarty->assign('title','Página no disponible');
}
unset($table);
# Header
$smarty->assign('js','<script type="text/javascript" src="/js/jquery.js"></script>
<script type="text/javascript" src="/js/functions.js"></script>
<script type="text/javascript" src="/js/grading.js"></script>
<script type="text/javascript" src="/audio-player/audio-player.js"></script>
<script type="text/javascript">  
  AudioPlayer.setup("/audio-player/player.swf", {  
    width: 290,
    initialvolume: 100,
    transparentpagebg: "yes"
  });  
</script>
');
# Contenido
#$smarty->cache_lifetime = 86400;
$smarty->cache_lifetime = 1800;
if($exist) {
  # Cache de 1 dia
  if(!$smarty->is_cached($tpl,$pattern)) {
    # Paginas
    $ab_page = new ab_pageTable();
    $rows = $ab_page->readDataSQL("SELECT idab_page,ab_page FROM ab_page ORDER BY orden");
    $smarty->assign('ab_pages',$rows);
    unset($rows);
    # Entradas
    $entrada = new ab_entryTable();
    $entrada->readEnv();
    list($row) = $entrada->readDataFilter("idab_entry = ".$entrada->request['idab_entry']." AND public IS TRUE");
    if( count($row) ) {
      $row['seo_title'] = generate_seo_link($row['ab_entry']);
      $row['body'] = replace_code($row['body']);
      $smarty->assign('entrada',$row);
      $smarty->assign('title',$row['ab_entry']);
    }
    $comentarioent = new ab_commentTable();
    $comentarioent->order = 'sentdate DESC';
    $comentarioent->filter = '';
    if($row) {
      $rows = $comentarioent->readDataFilter("ab_comment.public IS TRUE AND ab_comment.idab_entry = ".$row['idab_entry']);
      $pgs = ceil($comentarioent->getVar("SELECT count(idab_comment) FROM ab_comment WHERE ab_comment.public IS TRUE AND ab_comment.idab_entry = ".$row['idab_entry']) / AB_COMMENT_PAGE);
      $smarty->assign('pg',1);
      $smarty->assign('prev_num',1);
      $smarty->assign('pgs',$pgs);
      $smarty->assign('comentarios',$rows);
    }
    unset($row);
    unset($comentarios);
  }
  $smarty->display($tpl,$pattern);
  # Comments
  include_once 'comments.php';
  # Formulario, 1 semana
  $smarty->cache_lifetime = 604800;
  $tpl = AB_TPL_DIR . 'comments.frm.tpl';
  $pattern = "blog|form|comentario";
  if (!$smarty->is_cached($tpl,$pattern)) {
  }
  $smarty->display($tpl,$pattern);
  # Bottom
  $tpl = AB_TPL_DIR . 'bottom.tpl';
  # Cache de 1 dia
  if(!$smarty->is_cached($tpl,$pattern)) {
    # Paginas
    if(!isset($ab_page)) {
      $ab_page = new ab_pageTable();
      $entrada = new ab_entryTable();
    }
    $rows = $ab_page->readDataSQL("SELECT idab_page,ab_page FROM ab_page ORDER BY orden");
    $smarty->assign('ab_pages',$rows);
    unset($rows);
    # Ultimas Entradas
    $entrada->readEnv();
    $entrada->limit = 10;
    $rows = $entrada->readDataFilter("public IS TRUE");
    $smarty->assign('ult_entradas',$rows);
    unset($rows);
    # Meses
    $smarty->assign('periodos',getArchive($entrada));
    unset($rows);
  }
  $smarty->display($tpl,$pattern);
  if ( is_object($entrada) ) {
    unset($entrada);
    unset($ab_page);
  }
} else {
  require ROOTDIR . '/classes/include.d/404.inc.php';
  if(!$smarty->is_cached('blogs/404p.tpl',$grp_id)) {
    # Variables
    require_once ROOTDIR . '/classes/include.d/const.inc.php';
  }
  $smarty->display('blogs/404p.tpl',$grp_id);
}
