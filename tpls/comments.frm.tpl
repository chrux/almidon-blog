            <a name="frmcomentarios"></a>
            <div id="tucomentario" class="alinear-izq">
              <form class="formulario1" name="form" method="post" action="">
                <input type="hidden" name="action" value="comment" />
                <input type="hidden" name="idab_entry" value="{$entrada.idab_entry}" />
                {dynamic}
                {if $msg}
                <div id="msg">{$msg}</div>
                {/if}
                {/dynamic}
                <div class="titulo-comentario texto-arial">Tu Comentario</div>
                <textarea class="edit-comentario" name="ab_comment">{dynamic}{$data.ab_comment}{/dynamic}</textarea>
                <div class="columnas-comentario texto-arial">
                  <div class="columnas-comentario-izq flotar-izq">
                    <div class="etiqueta">Nombre <span class="requerido">*</span></div>
                    <input class="campo-texto" name="name" type="text" value="{dynamic}{$data.name}{/dynamic}" />
                    <div class="etiqueta">Correo Electrónico <span class="requerido">*</span></div>
                    <input class="campo-texto" name="email" type="text" value="{dynamic}{$data.email}{/dynamic}" />
                    <div class="etiqueta">Página Web</div>
                    <input class="campo-texto" name="web" type="text" value="{dynamic}{$data.web}{/dynamic}" />
                  </div><!-- columnas-comentario-izq -->
                  <div class="columnas-comentario-der flotar-der">
                    <div class="etiqueta">Eres Humano? <span class="requerido">*</span></div>
                    <div class="codigo">
                      <img src="{$smarty.const.AB_URL}/securimage/securimage_show.php" width="140" height="65" alt="CAPTCHA" id="captcha"/>
                    </div><!-- codigo -->
                    <a href="javascript:;" onclick="document.getElementById('captcha').src = '{$smarty.const.AB_URL}/securimage/securimage_show.php?' + Math.random(); return false"><img src="{$smarty.const.AB_URL}/securimage/images/refresh.gif" width="22" height="20" alt="Actualizar" /></a>
                    <object type="application/x-shockwave-flash" data="{$smarty.const.AB_URL}/securimage/securimage_play.swf?audio={$smarty.const.AB_URI}/securimage/securimage_play.php&amp;bgColor1=#fff&amp;bgColor2=#fff&amp;iconColor=#777&amp;borderWidth=0&amp;borderColor=#000" width="19" height="19"><param name="movie" value="{$smarty.const.AB_URL}/securimage/securimage_play.swf?audio={$smarty.const.AB_URI}/securimage/securimage_play.php&amp;bgColor1=#fff&amp;bgColor2=#fff&amp;iconColor=#777&amp;borderWidth=1&amp;borderColor=#000" /></object>
                    <input class="campo-texto" name="captcha" type="text" maxlength="6" />
                    <div class="limpiar"></div>
                    <div class="etiqueta1">Código de verificación</div>
                  </div><!-- columnas-comentario-der -->
                  <div class="limpiar"></div>
                  <div class="controls">
                    <input type="submit" value="Enviar Comentario" class="btn-small" />
                  </div>
                </div><!-- columnas-comentario -->
              </form>
            </div><!-- tucomentario -->
            <div id="comment_norms"> 
              {if "AB_TERM_COM"|defined}{$smarty.const.AB_TERM_COM|nl2br}{/if}
            </div>
