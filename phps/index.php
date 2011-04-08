<?php
require './common.inc.php';

$tpl = AB_TPL_DIR . 'index.tpl';
$pattern = 'blog|portada';
$patron = "^[[:digit:]]+$";

# Numero de ab_pages
$table = new Table('ab_page');
$var = (int)$table->getVar("SELECT count(idab_entry) FROM ab_entry WHERE public IS TRUE");
$pgs = ceil( $var / AB_ENTRIES_PAGE );
$pg = (int)$_REQUEST['pg'];
unset($var);

if( $pg > $pgs ) {
  require ROOTDIR . '/classes/include.d/404.inc.php';
  if($tpl_id)
    $grp_id = 'blog|404';
  else {
    $tpl_id = 'notallowed';
  }
  $smarty->assign('title','Página no disponible');
  $exist = false;
} elseif($pg==0) $pg = 1;


unset($table);
$pattern .= "|$pg";

# Contenido, cache c/30 mins
$smarty->cache_lifetime = 1800;
if($exist!==false) {
  # Cache de 1 dia
  if(!$smarty->is_cached($tpl,$pattern)) {
    # Paginas
    $ab_page = new ab_pageTable();
    $rows = $ab_page->readDataSQL("SELECT idab_page,ab_page FROM ab_page WHERE menu IS TRUE ORDER BY orden");
    $smarty->assign('paginas',$rows);
    unset($rows);
    # Entradas
    $ab_entry = new ab_entryTable();
    $ab_entry->readEnv();
    $ab_entry->limit = AB_ENTRIES_PAGE;
    $ab_entry->offset = (($pg>1)?(($pg-1)*$ab_entry->limit):0);
    $rows = $ab_entry->readDataFilter("public IS TRUE");
    for($i=0;$i<count($rows);$i++) {
      $rows[$i]['seo_title'] = generate_seo_link($rows[$i]['ab_entry']);
      $rows[$i]['texto'] = strip_code($rows[$i]['body']);
    }
    $smarty->assign('entradas',$rows);
    # Portada
    $smarty->assign('portada',true);
    if($rows) $smarty->assign('title',$rows[0]['ab_entry']);
    unset($rows);
    $smarty->assign('pgs',$pgs);
    $smarty->assign('pg',$pg);
    unset($rows);
    # Ultimas Entradas
    $ab_entry->limit = 10;
    $rows = $ab_entry->readDataFilter("public IS TRUE");
    for($i=0;$i<count($rows);$i++) {
      $rows[$i]['seo_title'] = generate_seo_link($rows[$i]['ab_entry']);
    }
    $smarty->assign('ult_entradas',$rows);
    unset($rows);
    # Meses
    $smarty->assign('periodos',getArchive($ab_entry));
    unset($ab_entry);
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
