<?php
require './common.inc.php';

if ( empty($tpl_id) && !empty($_REQUEST['aid']) ) $tpl_id = (int)$_REQUEST['aid'];
$blog_id = trim(preg_replace('(\.(.*))','',$_REQUEST['idblog']),"/\t\n \r\0\x0B");

# Comentarios, 1 hr
$pg = (int)$_REQUEST['pg']?(int)$_REQUEST['pg']:1;
$smarty->cache_lifetime = 3600;
$tpl = AB_TPL_DIR . 'comments.tpl';
$pattern = "blogs|$blog_id|$tpl_id|comentarios|$pg";
if(!$smarty->is_cached($tpl,$pattern)) {
  $comentario = new ab_commentTable();
  $comentario->order = 'sentdate DESC';
  $comentario->limit = defined('AB_COMMENT_PAGE')&&AB_COMMENT_PAGE>0?AB_COMMENT_PAGE:10;
  $comentario->offset = ($pg - 1) * $comentario->limit;
  $comentario->filter = '';
  $_REQUEST['idab_entry'] = $tpl_id;
  $comentario->readEnv();
  if($comentario->request['identrada']) {
    $w = $comentario->name . ".public IS TRUE AND " . $comentario->name . ".idab_entry = ". $comentario->request['idab_entry'];
    $rows = $comentario->readDataFilter($w);
    if ( !empty($rows) ) {
      $num_comentarios = $comentario->getVar("SELECT count(" . $comentario->key . ") FROM " . $comentario->name  . " WHERE $w");
      $pgs = ceil($num_comentarios / $comentario->limit);
      $smarty->assign('pg',$pg);
      $smarty->assign('pgs',$pgs);
      $smarty->assign('prev_num',$num_comentarios - ( ($pg - 1) * $comentario->limit ));
      $smarty->assign('comentarios',$rows);
      $smarty->assign('num_comentarios',$num_comentarios);
      unset($rows);
    }
  }
  unset($comentario);
}
$smarty->display($tpl,$pattern);
