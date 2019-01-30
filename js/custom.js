jQuery(function($){
  $(".toggle-gmenu").click(function(){
    if(document.getElementById("wpadminbar")){
      var menuHeight = $('#masthead').height()+40;
    } else {
      var menuHeight = $('#masthead').height();
    }
    $('#getled-navigation').css('margin-top', menuHeight);
  });
});
function updateHeight(){
  var winHeight = jQuery(window).height();
  var headerHeight = jQuery("header").height();
  var contentHeight = winHeight - headerHeight;
  jQuery('.main-navigation-menus').css("height", contentHeight);
}
jQuery(window).resize(function(){
  updateHeight();
});

jQuery(document).ready(function(){
  updateHeight();
})