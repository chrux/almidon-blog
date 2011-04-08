<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>{if $title&&!$portada}{$title} | {/if} {if "AB_TITLE_WEBSITE"|defined}{$smarty.const.AB_TITLE_WEBSITE}{else}{$smarty.const.DOMAIN}{/if}{if $title && $portada} | &#8220;{$title}&#8221;{/if}</title>
<link href="{$smarty.const.AB_URL}/css/common.css" rel="stylesheet" type="text/css" />
<link href="{$smarty.const.AB_URL}/css/style.css" rel="stylesheet" type="text/css" />
{if $entrada}
<link href="{$smarty.const.AB_URL}/css/comments.css" rel="stylesheet" type="text/css" />
{/if}
<!--[if lt IE 7]><link href="{$smarty.const.AB_URL}/css/iestyle.css" rel="stylesheet" type="text/css" /><![endif]-->
{if $entrada}
<script type="text/javascript" src="{$smarty.const.AB_URL}/js/jquery.js"></script>
<script type="text/javascript" src="{$smarty.const.AB_URL}/js/jquery-cookie.js"></script>
<script type="text/javascript" src="{$smarty.const.AB_URL}/js/inside.js"></script>
{/if}
</head>
<body>
  <div align="center">
    <div id="contenedor">
      <div id="contenido">
        <div class="menu1 flotar-izq texto-arial alinear-izq">
           <a href="{$smarty.const.AB_URL}/" class="page{if $cur_page==''} stay{/if}">Inicio</a>{if $paginas}&nbsp; | &nbsp;{section name=i loop=$paginas}<a href="{$smarty.const.AB_URL}/pagina/{$paginas[i].idab_page}" class="page{if $cur_page==$paginas[i].idab_page} stay{/if}">{$paginas[i].ab_page}</a>{if !$smarty.section.i.last}&nbsp; | &nbsp;{/if}{/section}{/if}
        </div>
        <div class="flotar-der"><a id="logochico" href="{$smarty.const.AB_URL}"><img src="{$smarty.const.AB_URL}/img/almidon_blog.png" width="135" height="43" alt="" /></a></div>
	<div class="limpiar"></div>                
        <div id="todo-contenido">
          <div class="arriba"><img src="{$smarty.const.AB_URL}/img/ab_top.png" width="1000" height="20" alt="" /></div>
          <div class="centroblog">
            <div class="izq">
              <div class="bannerblog"><h1><a href="{$smarty.const.AB_URL}/">{$smarty.const.AB_TITLE_WEBSITE}</a><br/><span class="texto-arial">{$smarty.const.AB_SUBTITLE_WEBSITE}</span></h1></div>
              {if $entrada}
              <div class="izqblog">
                {* If the page is a blog's entry *}
                <div class="fechablog">
                  <div class="diablog">{$entrada.creation|date_format:"%d"}</div>
                  <div class="upper mes texto-arial">{$entrada.creation|date_format:'<span class="grisoscuro">%b</span> %Y'}</div>
                  <div class="horablog texto-arial">{$entrada.creation|date_format:"%H:%M"}</div>
                  <div class="limpiar"></div>
                </div><!--fechablog-->
                <a class="botoncomentarios texto-arial" href="{$smarty.const.AB_URL}/{$entrada.idab_entry}#comentarios">Comentarios ({$entrada.comments})</a> 
                <div style="height:60px;">
                  {literal}
                  <span class="st_facebook_vcount"></span>
                  <span class="st_twitter_vcount"></span>
                  <script type="text/javascript" src="http://w.sharethis.com/button/buttons.js"></script>
                  <script type="text/javascript">
                  stLight.options({
                    publisher:'12345'
                  });
                  </script>
                  {/literal}
                </div>
                <div class="limpiar"></div>
                <div class="compartirblog">
                  {share_bookmarklet title=$entrada.ab_entry facebook=false}
                  <div class="limpiar"></div>
                </div><!--compartirblog-->  
                <a class="enviarblog mail texto-arial" href="javascript:openwindow('{$smarty.const.AB_URL}/enviar/{$entrada.idab_entry}',400,460);">Enviar a un amigo</a>
                <a class="enviarblog print texto-arial" href="{$smarty.const.AB_URL}/imprimir/{$entrada.idab_entry}">Imprimir</a>
              </div><!--izqblog--> 
              <div class="derblog">
                <h1>{$entrada.ab_entry}</h1>
                <div class="autor_info">Publicado por <span class="autor">{$entrada.ab_author}</span></div>
                <div class="texto-arial">{$entrada.body}</div>
              </div><!--derblog-->                                                
              <div class="limpiar"></div>
              <a name="comentarios"></a>
              {elseif $entradas}
              {* If the page is a blog's front or record section *}
              {if !$portada}<div class="title">Archivo: {$period} &#187;</div>{/if}
              {section name=i loop=$entradas}
              <div class="entry{if $smarty.section.i.last} last{/if}{if $smarty.section.i.first&&(!$pg||$pg==1)} first{/if}">
                <div class="izqblog">
                  <div class="fechablog">
                    <div class="diablog">{$entradas[i].creation|date_format:"%d"}</div>
                    <div class="upper mes texto-arial">{$entradas[i].creation|date_format:'<span class="grisoscuro">%b</span> %Y'}</div>
                    <div class="horablog texto-arial">{$entradas[i].creation|date_format:"%H:%M"}</div>
                    <div class="limpiar"></div>
                  </div><!--class:fechablog-->
                  <div class="options_content"><a href="{$smarty.const.AB_URL}/entrada/{$entradas[i].idab_entry}/{$entradas[i].seo_title}#comentarios">{$entradas[i].comments} Comentarios</a> {*| Enviar *}| <a href="{$smarty.const.AB_URL}/imprimir/{$entradas[i].idab_entry}">Imprimir</a></div>
                </div><!--izqblog--> 
                <div class="derblog">
                  <h1><a href="{$smarty.const.AB_URL}/entrada/{$entradas[i].idab_entry}/{$entradas[i].seo_title}">{$entradas[i].ab_entry}</a></h1>
                  <div class="texto-arial">
                    <div class="autor_info">Publicado por <span class="autor">{$entradas[i].ab_author}</span></div>
                    {if $smarty.section.i.total>1}
                    {$entradas[i].body|strip_tags|truncate:350:"..."}
                    {else}
                    {$entradas[i].body}
                    {/if}
                  </div>
                </div><!--class:derblog-->
                <div class="limpiar"></div>
              </div>{if $smarty.section.i.first}<!--class:lasttitle-->{else}<!--class:new-->{/if}
              {/section}
              {if $pgs > 1}
              <br /><br />
              <div id="nav">
                {if $pg<$pgs}
                <div class="left">
                  <a href="{$smarty.const.AB_URL}/pagina/{$pg+1}" class="link3">&laquo; Entradas Anteriores</a>
                </div>
                {/if}
                {if $pg>1}
                <div class="right">
                  <a href="{$smarty.const.Ab_URL}/pagina/{$pg-1}" class="link3">Entradas Recientes &raquo;</a>
                </div>
                {/if}
                <br clear="all"/>
              </div>
              {/if}
              {include file=$smarty.const.AB_TPL_DIR|cat:"bottom.tpl"}
              {else}
              No hay entradas
              {include file=$smarty.const.AB_TPL_DIR|cat:"bottom.tpl"}
              {/if}
