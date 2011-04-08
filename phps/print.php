<?php
require './common.inc.php';

$tpl = AB_TPL_DIR . 'print.tpl';
$pattern = 'blog|' . $tpl_id = $_REQUEST['idab_entry'] = (int)trim(preg_replace('(\.(.*))','',$_REQUEST['idab_entry']),"/\t\n \r\0\x0B") . '|imprimir';

# Cache de 1 dia
$smarty->cache_lifetime = 86400;
if(!$smarty->is_cached($tpl,$pattern)) {
  # Entradas
  $entrada = new ab_entryTable();
  $entrada->readEnv();
  list($row) = $entrada->readDataFilter("idab_entry = ".$entrada->request['idab_entry']." AND public IS TRUE");
  if( !empty($row) ) $smarty->assign('entrada',$row);
  unset($entrada);
  unset($row);
  print_r($row);
}

$smarty->display($tpl,$pattern);
?>
