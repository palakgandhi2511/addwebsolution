jQuery(document).ready(function() {
 
  //For Mobile Menu
  jQuery(".mobile-menu-trigger").click(function(){
    jQuery(this).toggleClass("active");
    jQuery(".header-menu").slideToggle("active");
  });
  jQuery(".header-menu ul.menu-item li.menu-item a").click(function(){
    jQuery(".header-menu").slideToggle("active");
  });

  //For Sticky Header
  jQuery(window).scroll(function() { 
    if (jQuery(this).scrollTop() > 130){  
      jQuery('header').addClass("sticky");
    }
    else{
      jQuery('header').removeClass("sticky");
    }
  });
    
});



