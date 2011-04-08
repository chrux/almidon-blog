<?php
//define ('PATH', dirname(__FILE__));
define ('PATH',$_SERVER['DOCUMENT_ROOT']);
require_once PATH . '/../classes/app.class.php';

define ('APP_CLASS',$_SERVER['DOCUMENT_ROOT'] . '/../classes/app.class.php');

/**
 * Getting the current URL
 *
 */
function selfURL() {
  return selfWww() . $_SERVER['REQUEST_URI'];
}
function selfWww() {
  $s = empty($_SERVER["HTTPS"]) ? '' : ($_SERVER["HTTPS"] == "on") ? "s" : "";
  $protocol = strleft(strtolower($_SERVER["SERVER_PROTOCOL"]), "/").$s;
  $port = ($_SERVER["SERVER_PORT"] == "80") ? "" : (":".$_SERVER["SERVER_PORT"]);
  return $protocol."://".$_SERVER['SERVER_NAME'].$port;
}
function strleft($s1, $s2) { return substr($s1, 0, strpos($s1, $s2)); }


function strip_code($str) {
  # Imagenes
  $patron = "/\[\[img(.+?)\]\]/is";
  $replace = '';
  $str = preg_replace($patron, $replace, $str);
  # Docs
  $patron = "/\[\[doc(.+?)\]\]/is";
  $replace = '';
  $str = preg_replace($patron, $replace, $str);
  # Videos
  $patron = "/\[\[video(.+?)\]\]/is";
  $replace = '';
  $str = preg_replace($patron, $replace, $str);
  return $str;
}

function get_imgs($str,$count=null) {
  $pattern = "/\[\[img(.+?)\]\]/is";
  preg_match_all($pattern, $str, &$imgs);
  if ( !count($imgs[1]) ) {
    //$pattern = '/<img[^>]+?src=[\'"]+(http:\/\/[^\'"]*)[\'"][^>]*>/i';
    $pattern = '/\<img.+?src="(.+?)".+?\/>/';
    preg_match_all($pattern, $str, &$imgs);
  }
  if ( count($imgs[1]) ) {
    require_once APP_CLASS;
    $imagen = new ab_imageTable();
    $filenames = array();
    if ( $count ) $total = $count;
    else  $total = count($imgs[1]);
    $inStr = '';
    for($i=0;$i<$total;$i++) {
      if ( !empty($inStr) )
        $inStr .= ',';
      $imgs[1][$i] = str_replace('&nbsp;', ' ', strip_tags($imgs[1][$i]));
      $imgs[1][$i] = preg_replace("/id=\"(.*)?\"/is","$1",trim(strip_tags($imgs[1][$i])));
      $idimg .= (int)$imgs[1][$i];
      if ( $idimg )
        $inStr .= $idimg;
      else {
        $filenames[]['archivo'] = basename($imgs[1][$i]);
      }
    }
    if ( $inStr )
      $img = $imagen->readDataFilter("idab_image IN ($inStr)");
    if ( $img && $filenames ) {
      $img = array_merge($img,$filenames);
    } elseif ( $filenames ) $img = $filenames;
    return $img;
  }
  return false;
}

function replace_code($str) {
  preg_match_all("/\[\[img(.+?)\]\]/is", $str, &$imgs);
  preg_match_all("/\[\[doc(.+?)\]\]/is", $str, &$docs);
  preg_match_all("/\[\[video(.+?)\]\]/is", $str, &$videos);
  preg_match_all("/\[\[audio(.+?)\]\]/is", $str, &$audios);
  if($imgs) {
    require_once APP_CLASS;
    #require_once ALMIDONDIR . '/smarty/modifier.time_pic.php';
    $imagen = new ab_imageTable();
    //if($_SERVER['REMOTE_ADDR'] == '165.98.184.18')
    //  print_r($imgs);
    for($i=0;$i<count($imgs[1]);$i++) {
      # Delete &nbsp; and other html chars
      $imgs[1][$i] = str_replace('&nbsp;', ' ', strip_tags($imgs[1][$i]));
      $imgs[1][$i] = preg_replace("/id=\"(.*)?\"/is","$1",trim(strip_tags($imgs[1][$i])));
      $_REQUEST['idab_image'] = $imgs[1][$i];
      $imagen->readEnv();
      $img = $imagen->readRecord();
      if($img) {
        $imgs[1][$i] = '<div class="new_pic">';
        print_r ( $imagen->dd['file'] ); exit;
        $imgs[1][$i] .= '<img src="'.PIXURL.'/'.time_pic($img['archivo'],"%Y/%m").'/480_'.$img['file'].'" alt="'.$img['ab_image'].'" title="'.$img['ab_image'].'" />';
        if(!(empty($img['credit'])&&empty($img['ab_image'])))  $imgs[1][$i] .= '<div class="new_pic_note">'.($img['ab_image']?$img['ab_image'].'.':'').$img['credit'].'</div>';
        $imgs[1][$i] .= '</div><!--class:new_pic-->';
      }
      $str = str_replace($imgs[0][$i],$imgs[1][$i],$str);
    }
  }
  if($docs) {
    require_once APP_CLASS;
    $document = new ab_docTable();
    for($i=0;$i<count($docs[1]);$i++) {
      # Delete &nbsp; and other html chars
      $docs[1][$i] = str_replace('&nbsp;', ' ', strip_tags($docs[1][$i]));
      $docs[1][$i] = preg_replace("/id=\"(.*)?\"/is","$1",trim(strip_tags($docs[1][$i])));
      $_REQUEST['idab_doc'] = $docs[1][$i];
      $document->readEnv();
      $doc = $document->readRecord();
      if($doc) {
        $docs[1][$i] = '<a href="'.URL.'/files/ab_doc/'.$doc['file'].'">'.$doc['ab_doc'].'</a>';
      }
      $str = str_replace($docs[0][$i],$docs[1][$i],$str);
    }
  }
  if($videos) {
    require_once APP_CLASS;
    $video = new ab_videoTable();
    for($i=0;$i<count($videos[1]);$i++) {
      $v = null;
      # Delete &nbsp; and other html chars
      $videos[1][$i] = str_replace('&nbsp;', ' ', strip_tags($videos[1][$i]));
      $videos[1][$i] = preg_replace("/id=\"(.*)?\"/is","$1",trim(strip_tags($videos[1][$i])));
      $_REQUEST['idvideo'] = $videos[1][$i];
      $video->readEnv();
      $row = $video->readRecord();
      if($row) {
        $videos[1][$i] = '<div class="video" align="center">';
        $arr = parse_url($row['url']);
        parse_str($arr['query']);
        if(isset($v)) {
          if($docid)
            $videos[1][$i] .= '<embed style="width:480px;height:400px;" id="VideoPlayback" type="application/x-shockwave-flash" src="http://video.google.com/googleplayer.swf?docId=' . $docid . '&hl=es" flashvars=""></embed>';
          else
            $videos[1][$i] .= '<object type="application/x-shockwave-flash" style="width:480px;height:400px;" data="http://www.youtube.com/v/'.$v.'"><param name="movie" value="http://www.youtube.com/v/'.$v.'" /><param name="wmode" value="transparent" /></object>';
        }
        if($row['ab_video']||$row['credit'])
          $videos[1][$i] .= '<div class="video_note">'.$row['video'].(!empty($row['video'])?".":"").(!empty($row['credit'])?".".$row['credit']:"").'</div>';
        $videos[1][$i] .= '</div>';
      }
      $str = str_replace($videos[0][$i],$videos[1][$i],$str);
    }
  }
  if($audios) {
    require_once APP_CLASS;
    $audio = new ab_audioTable();
    for($i=0;$i<count($audios[1]);$i++) {
      $v = null;
      # Delete &nbsp; and other html chars
      $audios[1][$i] = str_replace('&nbsp;', ' ', strip_tags($audios[1][$i]));
      $audios[1][$i] = preg_replace("/id=\"(.*)?\"/is","$1",trim(strip_tags($audios[1][$i])));
      $_REQUEST['idab_audio'] = $audios[1][$i];
      $audio->readEnv();
      $row = $audio->readRecord();
      if($row) {
        $audios[1][$i] = '<div class="audio" align="center"><div class="audio_fl">';
        $audios[1][$i] .= '<p id="audioplayer_' . ($i+1) . '">Audio clip: Adobe Flash Player (version 9 or above) es requerido para tocar este audio clip. Instala la ultima versión</p><script type="text/javascript">AudioPlayer.embed("audioplayer_' . ($i+1) . '", {soundFile: "' . URL . '/files/ab_audio/' . $row['file'] . '",titles:"' . $row['ab_audio'] . '",artists:"LaBrujula.com.ni"});</script></div>';
        if($row['ab_audio']||$row['credit'])
          $audios[1][$i] .= '<div class="audio_note">'.$row['ab_udio'].(!empty($row['ab_audio'])?".":"").(!empty($row['credit'])?".".$row['credit']:"").'</div>';
        $audios[1][$i] .= '</div>';
      }
      $str = str_replace($audios[0][$i],$audios[1][$i],$str);
    }
  }
  return $str;
}

function time_pic($picname,$format = '%D %T')
{
    $timemark = substr($picname,0,strpos($picname,'_'));
    return strftime($format,$timemark);
} //~ end function

function generate_seo_link($input,$replace = '-',$remove_words = true,$words_array = array()) {
  $words_array = array('un','una','el','la','es','esta','con','de','a','y','su','del');
  $unPretty = array('/á/','/é/','/í/','/ó/','/ú/','/ü/','/ñ/','/Á/','/É/','/Í/','/Ó/','/Ú/','/Ü/','/Ñ/');
  $pretty   = array('a','e','i','o','u','u','n','A','E','I','O','U','U','N');
  $return = preg_replace($unPretty, $pretty, $input);
  $return = trim(preg_replace('/ +/',' ',preg_replace('/[^a-zA-Z0-9\s]/','',strtolower($return))));
  if($remove_words) { $return = remove_words($return,$replace,$words_array); }
  return str_replace(' ',$replace,$return);
}

function remove_words($input,$replace,$words_array = array(),$unique_words = true) {
  $input_array = explode(' ',$input);
  $return = array();
  foreach($input_array as $word)
    if(!in_array($word,$words_array) && ($unique_words ? !in_array($word,$return) : true))
      $return[] = $word;
  return implode($replace,$return);
}

function escape($table,$string) {
  if ( method_exists($table,'escape') )
    return $table->escape($string);
  elseif ( method_exists($table->database,'escapeSimple') )
    return $table->database->escapeSimple($string);
  elseif ( method_exists($table->database,'escape') )
    return $table->database->escape($string);
  else return false;
}

function getArchive($table) {
  # Meses
  return $table->readDataSQL("SELECT DISTINCT (extract(year from creation)||'-'||extract(month from creation)||'-01')::date AS mes FROM ab_entry WHERE public IS TRUE ORDER BY mes DESC");
}

function getip() {
  if ( !empty($_SERVER['HTTP_CLIENT_IP']) )
    return $_SERVER['HTTP_CLIENT_IP'];
  elseif ( !empty($_SERVER['HTTP_X_FORWARDED_FOR']) )
    return $_SERVER['HTTP_X_FORWARDED_FOR'];
  elseif ( !empty($_SERVER['REMOTE_ADDR']) )
    return $_SERVER['REMOTE_ADDR'];
  else return false;
}

function checkEmail($email) {
  if(preg_match("/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/" , $email)) {
    list($username,$domain)=preg_split('/@/',$email);
    $checked = checkdnsrr($domain,'MX');
    return $checked;
  }
  return false;
}

function smarty_block_dynamic($param, $content, &$smarty) {
  return $content;
}
$smarty->register_block('dynamic', 'smarty_block_dynamic', false);
