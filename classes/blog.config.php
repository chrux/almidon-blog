<?php
/**
 * Project: A single blog in almidon
 * File: blog.config.php
 * Description: Addiccional constants
 * Author: Christian Torres <chtorrez at gmail dot com>
 * Date: 2011-03-29
 *
 * Tables for Blogs
 *
 * @author Christian Torres <chtorrez at gmail dot com>
 * @category almidon
 * @package almidon_blog
 * @version 1.0
 */

# Constants for URL of Blog
define ('AB_URL', 'http://' . DOMAIN . '/blog');
# TPLs directory
define ('AB_TPL_DIR', 'blog/');
# amount of entries by page
define ('AB_ENTRIES_PAGE', 8);
# Amount of comments by page
define ('AB_COMMENT_PAGE' , 5);
# Blog logo
define ('AB_ABOUT_PIC','');
# Blnfo
define ('AB_ABOUT','Descripci�n del Blog');
# Web Site Title
define ('AB_TITLE_WEBSITE','bloggin&#8217;  &#8226; almidon');
# Web Site SubTitle
define ('AB_SUBTITLE_WEBSITE','');
# Here you can put html code
define ('AB_FOOTER', 'Copyleft - almidon');
# Text you recieve when comment
define ('AB_THANKS_COM', 'Muchas gracias. Tu comentario ha sido enviado correctamente.');
# Comment terms
define ('AB_TERM_COM','<b>Normas de uso:</b>

Estos comentarios están sujetos a moderación.

Tu comentario será publicado en la mayor brevedad posible.');
# 404 Title and Body
define ('AB_404_TITLE', 'Error 404: Documento No Encontrado');
define ('AB_404_BODY', 'Página no disponible
<hr />
La página que usted solicitó no se encuentra disponible en este momento.

Puede tratar de encontrar la página accediendo a la página de inicio de ' . DOMAIN . ': ' . AB_URL);
define ('AB_TERM_SEND','<b>Forma de uso:</b>
El <b>Comentario</b> es opcional, introduzca aqui algún texto que desee se envie en el correo que se le enviara a su amigo.
En <b>Destinatarios</b> ud. puede escribir una o más direcciones (hasta 5) separandolas por , (coma).
Los campos que posean un * (asterisco en rojo) son requeridos y no se procedera a no ser que sean llenados.');
define ('AB_NAME_NOREPLAY','No-Replay');
define ('AB_EMAIL_NOREPLAY','no-replay@' . DOMAIN);
