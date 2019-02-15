jQuery(function($){
  $(".toggle-gmenu").click(function(){
    if(document.getElementById("wpadminbar")){
      var menuHeight = $('#masthead').height()+30;
    } else {
	  var border=$('#masthead').css("border-bottom-width");
	  var newborder = border.substr(0, border.length-2);
	  if (screen.width >=800) {
	  var menuHeight = $('#masthead').height()+parseInt(newborder);
      } else {
	  var menuHeight = $('#masthead').height()+parseInt(newborder)-20;
	  }
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
