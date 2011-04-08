<?php
require './common.inc.php';

if ( $_POST['action']=='sendtofriend' ) {
  session_start();
  include_once dirname(__FILE__) . '/securimage/securimage.php';
  $securimage = new Securimage();
  $_POST['captcha'] = str_replace(' ','',trim($_POST['captcha']));
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
  } elseif ( empty($_POST['tos']) ) {
    error_log("Error: Campo *Destinatarios* es requerido.");
    $msg = '<div class="error">Error: Campo *Destinatarios* es requerido.</div>';
    $smarty->assign('msg',$msg);
    $smarty->assign('data',$_POST);
  } elseif ( empty($_POST['name']) ) {
    error_log("Error: Campo *Tu Nombre* es requerido.");
    $msg = '<div class="error">Error: Campo *Tu Nombre* es requerido.</div>';
    $smarty->assign('msg',$msg);
    $smarty->assign('data',$_POST);
  } elseif ( empty($_POST['email']) ) {
    error_log("Error: Campo *Tu Correo Electrónico* es requerido.");
    $msg = '<div class="error">Error: Campo *Tu Correo Electrónico* es requerido.</div>';
    $smarty->assign('msg',$msg);
    $smarty->assign('data',$_POST);
  # Todo bien
  } else {
    $_REQUEST['ip'] = getip();
    $message = strip_tags($_REQUEST['ab_comment']);
    $tos = explode(',',trim($_REQUEST['tos']));
    $ab_entry = new ab_entryTable();
    $ab_entry->readEnv();
    $row = $ab_entry->readRecord();
    $subject = 'Recomendación: ' . $row['ab_entry'];
    $message = $_REQUEST['name'] . ' te ha enviado el siguiente articulo. Sus Comentarios son los siguientes:
----
' . $_REQUEST['ab_comment'] . '
----

<b>' . $row['ab_entry'] . '</b>
' . substr(trim(strip_tags(strip_code($row['body']))),0,125);
    $message = nl2br($message);
    # Headers
    $headers = 'From: ' . AB_NAME_NOREPLAY . '<' . AB_EMAIL_NOREPLAY . ">\r\n";
    $headers .= 'MIME-Version: 1.0' . "\r\n";
    //$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
    $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
    $headers .= 'Content-Transfer-Encoding: 8bit' . "\r\n";
    foreach($tos as $to) {
      if ( checkEmail($to) ) {
        mail($to,$subject,$message,$headers,'-f' . AB_EMAIL_NOREPLAY);
      }
    }
    header( "Location: " . selfURL() . '?m=1' );
    exit;
  }
} elseif ( $_REQUEST['m']==1) {
  $msg = '<div class="succ">Muchas Gracias su recomendación ha sida enviada.</div>';
  $smarty->assign('msg',$msg);
}

$tpl = AB_TPL_DIR . 'send.tpl';
$pattern = 'blog|entry|' . $tpl_id = $_REQUEST['idab_entry'] = trim(preg_replace('(\.(.*))','',$_REQUEST['idab_entry']),"/\t\n \r\0\x0B");
$pattern = '|send';
$patron = "^[[:digit:]]+$";
$table = new Table('ab_page');

if(eregi($patron,$tpl_id))
  $exist = (bool)$table->getVar("SELECT idab_entry FROM ab_entry WHERE idab_entry = ".((int)escape($table,$_REQUEST['idab_entry'])));
else $exist = false;

if($exist) {
  # Cache de 1 dia
  if(!$smarty->is_cached($tpl,$pattern)) {
    # Paginas
    $ab_page = new ab_pageTable();
    $rows = $ab_page->readDataSQL("SELECT idab_page,ab_page FROM ab_page WHERE menu IS TRUE ORDER BY orden");
    $smarty->assign('paginas',$rows);
    unset($rows);
    # Entradas
    $entrada = new ab_entryTable();
    $entrada->readEnv();
    list($row) = $entrada->readDataFilter("idab_entry = ".$entrada->request['idab_entry']." AND public IS TRUE");
    if( count($row) ) {
      $row['seo_title'] = generate_seo_link($row['ab_entry']);
      $row['body'] = strip_code($row['body']);
      $smarty->assign('entrada',$row);
      $smarty->assign('title', '(Enviar) ' . $row['ab_entry']);
    }
    unset($entrada);
    unset($ab_page);
  }
  $smarty->display($tpl,$pattern);
} else {
  require ROOTDIR . '/classes/include.d/404.inc.php';
  if(!$smarty->is_cached('blogs/404p.tpl',$grp_id)) {
    # Variables
    require_once ROOTDIR . '/classes/include.d/const.inc.php';
  }
  $smarty->display('blogs/404p.tpl',$grp_id);
}
