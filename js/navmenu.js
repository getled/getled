jQuery(".toggle-gmenu").click(function(){
	jQuery(this).toggleClass("active");
	jQuery(".boddycover").toggleClass("active");
	jQuery("body").toggleClass("active");
	jQuery("#getled-navigation").toggleClass("active");
});

jQuery("ul#primary-menu > li").hover(function(){
	if(jQuery(this).hasClass("active")){

	}else{
		jQuery("ul#primary-menu li").removeClass("active");
		jQuery("ul#primary-menu li .sub-menu").removeClass("active");
		jQuery(this).addClass("active");
		jQuery(this).find(".sub-menu:first").addClass("active");
	}
});


jQuery("ul#primary-menu ul.sub-menu:first > li").hover(function(){
	
	if(jQuery(this).hasClass("active")){
		event.stopPropagation();
	}else{
		jQuery("ul#primary-menu .sub-menu.active li").removeClass("active");
		jQuery("ul#primary-menu .sub-menu li .sub-menu").removeClass("active");
		jQuery(this).addClass("active");
		jQuery(this).find(".sub-menu").addClass("active");
	}
});



jQuery(".menu-headermenu-container").click(function() {
//Hide the menus if visible
	if(jQuery("#getled-navigation").hasClass("active")){
		jQuery("#getled-navigation").toggleClass("active");
		jQuery("ul#primary-menu li").removeClass("active");
		jQuery(".boddycover").toggleClass("active");
		jQuery("body").toggleClass("active");
		jQuery("ul#primary-menu li .sub-menu").removeClass("active");
	}
	
});

jQuery('ul#primary-menu li').click(function(event){
    
    event.stopPropagation();
});

jQuery("#getled-navigation .close, #getled-navigation .menu-close-icon").live("click", function(){
   jQuery(".toggle-gmenu").trigger("click");
});
jQuery(window).load(function(){
	jQuery("#primary-menu li").menuThum();	
        if(jQuery(window).width() <= 1024){
            jQuery("#getled-navigation").append("<a class='close'>&#10006;</a>");
            jQuery("#getled-navigation .menu-item-has-children > a").click(function(event){ 
                 
                if(jQuery(this).hasClass("clickable")){  }else{ event.preventDefault(); jQuery(this).addClass("clickable"); } 
              
            });
        }
        
});



jQuery.fn.menuThum = function() {
 
    return this.each(function() {
    	var medialk = '';
    	medialk = jQuery(this).find("a").attr("medialk");
    	if(typeof medialk !== typeof undefined && medialk !== false){
    		if(typeof mediaonlk !== typeof undefined && mediaonlk !== false){ }else{ mediaonlk = '';}
    		jQuery(this).find("ul.sub-menu:first").append( "<li class='menuthum'><a target='_blank' href='"+ mediaonlk +"'><img style='max-width:308px' src='"+medialk+"'/></a></li>" );
    		medialk = '';

    	}
        // Do something to each element here.
    });
 
};
