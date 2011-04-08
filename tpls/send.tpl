<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>{if $title&&!$portada}{$title} | {/if} {if "AB_TITLE_WEBSITE"|defined}{$smarty.const.AB_TITLE_WEBSITE}{else}{$smarty.const.DOMAIN}{/if}{if $title && $portada} | &#8220;{$title}&#8221;{/if}</title>
<link href="{$smarty.const.AB_URL}/css/common.css" rel="stylesheet" type="text/css" />
<link href="{$smarty.const.AB_URL}/css/send.css" rel="stylesheet" type="text/css" />
</head>
<body>
  <div align="center">
    <div id="contenedor">
      <div id="contenido">
        <div id="todo-contenido">
          <div class="centroblog">
            <div class="bannerblog"><h1><a href="{$smarty.const.AB_URL}/">{$smarty.const.AB_TITLE_WEBSITE}</a><br/><span class="texto-arial">{$smarty.const.AB_SUBTITLE_WEBSITE}</span></h1></div>
            <h1>Enviar a un amigo</h1>
            <div class="fechablog">{$entrada.creation|date_format:'<span class="grisoscuro">%b</span> %d, %Y'}</div><!--fechablog-->
            <div class="derblog">
              <h2>{$entrada.ab_entry}</h2>
              <div class="texto-arial">{$entrada.body|strip_tags|truncate:125:"..."}</div>
	      <hr />
              <div id="tucomentario" class="alinear-izq">
              <form class="formulario1" name="form" method="post" action="">
                <input type="hidden" name="action" value="sendtofriend" />
                <input type="hidden" name="idab_entry" value="{$entrada.idab_entry}" />
                {dynamic}
                {if $msg}
                <div id="msg">{$msg}</div>
                {/if}
                {/dynamic}
                <div class="etiqueta">Destinatarios <span class="requerido">*</span> (hasta 5 direcciones, separadas por coma ",")</div>
                <input class="campo-texto" name="tos" type="text" value="{dynamic}{$data.tos}{/dynamic}" />
                <div class="etiqueta">Tu Nombre <span class="requerido">*</span></div>
                <input class="campo-texto" name="name" type="text" value="{dynamic}{$data.name|escape}{/dynamic}" />
                <div class="etiqueta">Tu Correo Electrónico <span class="requerido">*</span></div>
                <input class="campo-texto" name="email" type="text" value="{dynamic}{$data.email|escape}{/dynamic}" />
                <div class="etiqueta">Comentario</div>
                <textarea class="edit-comentario" name="ab_comment" rows="5" cols="100">{dynamic}{$data.ab_comment}{/dynamic}</textarea>
                <div class="columnas-comentario-der flotar-der">
                  <div class="etiqueta">Eres Humano? <span class="requerido">*</span></div>
                  <div class="codigo">
                    <img src="{$smarty.const.AB_URL}/securimage/securimage_show.php" width="140" height="65" alt="CAPTCHA" id="captcha"/>
                  </div><!-- codigo -->
                  <a href="javascript:;" onclick="document.getElementById('captcha').src = '{$smarty.const.AB_URL}/securimage/securimage_show.php?' + Math.random(); return false"><img src="{$smarty.const.AB_URL}/securimage/images/refresh.gif" width="22" height="20" alt="Actualizar" /></a>
                  <object type="application/x-shockwave-flash" data="{$smarty.const.AB_URL}/securimage/securimage_play.swf?audio={$smarty.const.AB_URI}/securimage/securimage_play.php&amp;bgColor1=#fff&amp;bgColor2=#fff&amp;iconColor=#777&amp;borderWidth=0&amp;borderColor=#000" width="19" height="19"><param name="movie" value="{$smarty.const.AB_URL}/securimage/securimage_play.swf?audio={$smarty.const.AB_URI}/securimage/securimage_play.php&amp;bgColor1=#fff&amp;bgColor2=#fff&amp;iconColor=#777&amp;borderWidth=1&amp;borderColor=#000" /></object>
                  <input class="campo-texto captcha" name="captcha" type="text" maxlength="6" />
                  <div class="limpiar"></div>
                  <div class="etiqueta1">Código de verificación</div>
                  <div class="controls">
                    <input type="submit" value="Enviar Comentario" class="btn-small" />
                  </div>
                </div>
              </form>
              </div><!-- tucomentario -->
              <div id="comment_norms"> 
                {if "AB_TERM_SEND"|defined}{$smarty.const.AB_TERM_SEND|nl2br}{/if}
              </div>
              <div class="limpiar"></div>
            </div><!--derblog-->                                                
          </div><!-- centro -->
        </div><!-- todo-contenido -->
      </div><!-- contenido -->
    </div><!-- contenedor -->
  </div><!-- centrar -->
</body>
</html>
