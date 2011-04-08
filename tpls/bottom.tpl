            </div><!--izq-->
            <div class="der">
              <hr class="derecha-loggin" />
              <div class="cajaazulder">
                <h1 class="titularcajader">Sobre el blog</h1>
                {if "AB_ABOUT_PIC"|defined && $smarty.const.AB_ABOUT_PIC}
                <div class="imagen"><img src="{$smarty.const.AB_ABOUT_PIC}" width="70" alt="" /></div>
                <div class="texto">
                {/if}
                  <div class="texto-arial f12">{if "AB_ABOUT"|defined && $smarty.const.AB_ABOUT}{$smarty.const.AB_ABOUT|nl2br}{/if}</div>
                {if "AB_ABOUT_PIC"|defined && $smarty.const.AB_ABOUT_PIC}
                </div><!-- texto -->
                {/if}
                <div class="limpiar"></div>
              </div><!-- cajaazulder -->
              {if $ult_entradas}
              <div class="cajaazulder sepbottom30">
                <h1 class="titularcajader">Últimos Entradas</h1>
                <ol class="list texto-arial">
                {section name=i loop=$ult_entradas}
                  <li><a href="{$smarty.const.AB_URL}/entrada/{$ult_entradas[i].idab_entry}/{$ult_entradas[i].seo_title}">{$ult_entradas[i].ab_entry}</a> - {$ult_entradas[i].creation|date_format:"%d de %B de %Y"}</li>
                {/section}
                </ol><!--class:list-->
              </div><!-- cajaazulder -->
              {/if}
              <div class="cajaazulder sepbottom30">
                <h1 class="titularcajader">Archivo</h1>
                <div class="archivo">
                  {section name=i loop=$periodos}
                  {if $periodos[i].mes|date_format:"%Y"!=$periodos[$smarty.section.i.index_prev].mes|date_format:"%Y"}
                  <div class="botonanno"><a href="javascript:;">{$periodos[i].mes|date_format:"%Y"}</a></div>
                  {/if}
                  <a href="{$smarty.const.AB_URL}/archivo/{$periodos[i].mes|date_format:"%Y/%m"}/" class="mesarchivo texto-arial">{$periodos[i].mes|date_format:"%B"|capitalize}</a></li>
                  {/section}
                </div><!-- archivo -->
              </div><!-- cajaazulder -->
            </div><!-- der -->
            <div class="limpiar"></div>
          </div><!-- centro -->
          <div class="abajo"><img src="{$smarty.const.AB_URL}/img/ab_bottom.png" width="1000" height="22" alt="" /></div>
        </div><!-- todo-contenido -->
      </div><!-- contenido -->
      <div id="footer">
        <div id="contenedor-footer">
          <div class="flotar-izq texto-arial menu-footer">
            <a href="{$smarty.const.AB_URL}" class="page{if $cur_page==''} stay{/if}">Inicio</a>{if $paginas}&nbsp; | &nbsp;{section name=i loop=$paginas}<a href="{$smarty.const.AB_URL}/pagina/{$paginas[i].idab_page}" class="page{if $cur_page==$paginas[i].idab_page} stay{/if}">{$paginas[i].idab_page}</a>{if !$smarty.section.i.last}&nbsp; | &nbsp;{/if}{/section}{/if}
          </div>
          <div class="flotar-der">
            <div class="texto-footer texto-arial alinear-izq">
               {if "AB_FOOTER"|defined===true}{$smarty.const.AB_FOOTER|nl2br}{else}&nbsp;{/if}
            </div>
            <div class="guegue texto-arial alinear-der"><a href="http://www.guegue.com" target="_blank">Guegue.Com - Desarrollo y Hospedaje Web</a></div>
          </div>
          <div class="limpiar"></div>
        </div><!-- contenedor-footer -->
      </div><!-- footer -->
    </div><!-- contenedor -->
  </div><!-- centrar -->
</body>
</html>
