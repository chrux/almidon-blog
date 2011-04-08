            {if $comentarios}
            {dynamic}{if $smarty.request.from!='js'}
            <div id="comentarios">
              <h2>Comentarios <span class="num_comentarios"></span></h2>
              <div id="comentarios_loading"><img src="{$smarty.const.AB_URL}/img/loading.gif" width="70" height="64" alt="Cargando..." /><h3>Cargando...</h3></div>
              <div id="comentarios_content">
            {/if}{/dynamic}
                {assign var="idab_entry" value=$comentarios[0].idab_entry}
                {if $pgs>=1}
                <div id="pages">
                  <div class="left">P&aacute;gina {$pg} de {$pgs}</div>
                  <ul class="right">
                  {if $pg>1}<li><a href="javascript:goPage({$idab_entry},{$pg-1});">&laquo; Anterior</a></li><li><a href="javascript:goPage({$idab_entry},1);">Primera</a></li>{/if}
                  {section name=i loop=$pgs}<li><a href="javascript:goPage({$idab_entry},{$smarty.section.i.iteration});">{$smarty.section.i.iteration}</a></li>{/section}
                  {if $pg<$pgs}<li><a href="javascript:goPage({$idab_entry},{$pgs})">&Uacute;ltima</a></li><li><a href="javascript:goPage({$idab_entry},{$pg+1});">Siguiente &raquo;</a></li>{/if}
                  </ul>
                  <br clear="all"/>
                </div>
                {/if}
                {if $comentarios}
                <ul>
                  {section name=i loop=$comentarios}
                  <li>
                    <div class="info_com"><span class="num_com">{$prev_num-$smarty.section.i.index}</span>&nbsp;|&nbsp;<span class="autor">{$comentarios[i].name}</span><span class="date_com"> - {$comentarios[i].sentdate|date_format:"%d-%m-%Y - %Th"}</span></div>
                    {$comentarios[i].ab_comment|strip_tags|escape|nl2br}
                  </li>
                  {/section}
                </ul>
                {/if}
                {if $pgs>=1}
                <div id="pages_2">
                  <div class="left">P&aacute;gina {$pg} de {$pgs}</div>
                  <ul class="right">
                    {if $pg>1}<li><a href="javascript:goPage({$idab_entry},{$pg-1});">&laquo; Anterior</a></li><li><a href="javascript:goPage({$idab_entry},1);">Primera</a></li>{/if}
                    {section name=i loop=$pgs}<li><a href="javascript:goPage({$idab_entry},{$smarty.section.i.iteration});">{$smarty.section.i.iteration}</a></li>{/section}
                    {if $pg<$pgs}<li><a href="javascript:goPage({$idab_entry},{$pgs})">&Uacute;ltima</a></li><li><a href="javascript:goPage({if $blog_id}'{$blog_id}',{/if}{$idab_entry},{$pg+1});">Siguiente &raquo;</a></li>{/if}
                  </ul>
                  <br clear="all"/>
                </div>
                {/if}
                <script type="text/javascript">setNumComments({$num_comentarios})</script>
            {dynamic}{if $smarty.request.from!='js'}
              </div><!--id:comentarios_content-->
            </div><!--#comentarios-->
            {/if}{/dynamic}
            {else}
    	    <hr />
            {/if}
