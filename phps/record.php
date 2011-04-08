<?php
require './common.inc.php';

#define('ENTRY',8);

$tpl = AB_TPL_DIR . 'index.tpl';
$pattern = 'blog|archivo';
$_REQUEST['y'] = (int)$_REQUEST['y'];
$_REQUEST['m'] = (int)$_REQUEST['m'];
if ( $_REQUEST['y'] ) {
  $valid = true;
  $pattern .= '|' . $_REQUEST['y'];
  if ( $_REQUEST['m']>=1 && $_REQUEST['m']<=12 ) {
    $pattern .= '|' . $_REQUEST['m'];
  } else {
    $pattern .= '|all';
  }
} else $valid = false;

# Contenido, cache c/30 mins
$smarty->cache_lifetime = 1800;
# Cache de 1 dia
if(!$smarty->is_cached($tpl,$pattern)) {
  # Paginas
  $pagina = new ab_pageTable();
  $rows = $pagina->readDataSQL("SELECT idab_page,ab_page FROM ab_page WHERE menu IS TRUE ORDER BY orden");
  $smarty->assign('paginas',$rows);
  unset($pagina);
  unset($rows);
  # Entradas
  $entrada = new ab_entryTable();
  $entrada->readEnv();
  #$entrada->limit = ENTRY;
  #$entrada->offset = (($pg>1)?(($pg-1)*$entrada->limit):0);
  if ( $_REQUEST['m'] ) {
    $period = strftime("%B/%Y",strtotime($_REQUEST['y'].'-'.$_REQUEST['m'].'-01'));
    $range_filter = "extract(month from ab_entry.creation) = " . $_REQUEST['m'] . " AND extract(year from ab_entry.creation) = " . $_REQUEST['y'];
  } else {
    $period = $_REQUEST['y'];
    $range_filter = "extract(year from ab_entry.creation) = " . $_REQUEST['y'];
  }
  $rows = $entrada->readDataFilter("ab_entry.public IS TRUE AND $range_filter");
  for($i=0;$i<count($rows);$i++) {
    $rows[$i]['seo_title'] = generate_seo_link($rows[$i]['ab_entry']);
    $rows[$i]['texto'] = strip_code($rows[$i]['texto']);
  }
  $smarty->assign('entradas',$rows);
  $smarty->assign('title',$period . ' &#8212; Archivo');
  $smarty->assign('period',$period);
  unset($rows);
  $smarty->assign('pgs',$pgs);
  $smarty->assign('pg',$pg);
  unset($rows);
  # Ultimas Entradas
  $entrada->readEnv();
  $entrada->limit = 10;
  $rows = $entrada->readDataFilter("public IS TRUE");
  $smarty->assign('ult_entradas',$rows);
  unset($rows);
  # Meses
  $rows = $entrada->readDataSQL("SELECT DISTINCT (extract(year from creation)||'-'||extract(month from creation)||'-01')::date AS mes FROM ab_entry WHERE public IS TRUE ORDER BY mes DESC");
  $smarty->assign('periodos',$rows);
  unset($rows);
  unset($var);
  unset($entrada);
}
$smarty->display($tpl,$pattern);
