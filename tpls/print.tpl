<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>(Versión Impresa) {if $entrada}{$entrada.ab_entry} | {/if} {if "AB_TITLE_WEBSITE"|defined}{$smarty.const.AB_TITLE_WEBSITE}{else}{$smarty.const.DOMAIN}{/if}{if $title && $portada} | &#8220;{$title}&#8221;{/if}</title>
<link href="{$smarty.const.AB_URL}/css/print.css" rel="stylesheet" type="text/css" />
</head>
<body>
<div id="wrapper">
  <div id="header">
    <a href="{$smarty.const.AB_URL}"><img src="{$smarty.const.AB_URL}/img/almidon_blog.png" alt="{if "AB_TITLE_WEBSITE"|defined}{$smarty.const.AB_TITLE_WEBSITE}{else}{$smarty.const.DOMAIN}{/if}" width="135" height="43" border="0" /></a>
  </div><!--id:header-->
  <div id="body">
    <div class="headline">
      <div class="title">
        <h1>{$entrada.ab_entry}</h1>
        <div class="details"><a href="{$smarty.const.AB_URL}/" class="link">{if "AB_TITLE_WEBSITE"|defined}{$smarty.const.AB_TITLE_WEBSITE}{else}{$smarty.const.DOMAIN}{/if}</a> / <span class="autor">{$entrada.ab_author}</span> / <span class="date">{$entrada.creation|date_format:"%b %d, %Y %H:%M"}</span></div>
      </div><!--title-->
    </div><!--class:headline-->
    <div class="entry_content" id="content">
      {$entrada.body}
    </div><!--class:new_content-->
    <br />
  </div><!--id:body-->
  <div id="footer">
   <div>{$smarty.const.AB_FOOTER|nl2br}</div>
   <a href="http://www.guegue.com">Guegue.Com - Desarrollo y Hospedaje Web</a>
  </div>
</div><!--id:wrap-->
<script type="text/javascript">
window.print();
</script>
</body>
</html>
