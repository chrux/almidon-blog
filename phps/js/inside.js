function goPage(bid,aid,pg) {
  $("#comentarios_content").hide();
  $("#comentarios_loading").show();
  $("#comentarios_content").load('../../comments.php?idblog='+bid+'&aid='+aid+'&&pg='+pg+'&from=js',function(response,status,xhr) {
    if ( status!='error' ) {
      $("#comentarios_loading").hide();
      $("#comentarios_content").show();
    } else
      alert('Se encontraron problemas');
  });
}

function setNumComments(num) {
  $(".num_comentarios").html(num);
}

$(document).ready(function(){
  if($.cookie('ZOOM_CLASS')) {
    $('.zoom').addClass($.cookie('ZOOM_CLASS'));	
  }
  // Reset
  $(".reset").click(function(){
    $(".zoom").removeClass("large");
    $(".zoom").removeClass("medium");
    $.cookie('ZOOM_CLASS',null, { path: '/', expires: 365 * 40 });
  });
  // Increase Zoom 2, one level
  $(".zoom2").click(function(){
    $(".zoom").removeClass("large");
    $(".zoom").addClass("medium");
    $.cookie('ZOOM_CLASS',"medium", { path: '/', expires: 365 * 40 });
  });
  // Increase Zoom 4, two level
  $(".zoom4").click(function(){
    $(".zoom").removeClass("medium");
    $(".zoom").addClass("large");
    $.cookie('ZOOM_CLASS',"large", { path: '/', expires: 365 * 40 });
  });
});

function openwindow(href, w, h) {
  if (!w) w = 350;
  if (!h) h = 160;
  desktop = window.open('','_blank','toolbar=no,location=no,status=no,menubar=no,  scrollbars=yes,resizable=yes,width='+ w +',height='+ h +',screenX=100,screenY=50,top=100,left=50');
  desktop.location.href = href;
}
