jQuery(function($){
  $(".toggle-gmenu").click(function(){
  var menuHeight = $('#masthead').height();
  $('#getled-navigation').css('margin-top', menuHeight);
  });
});