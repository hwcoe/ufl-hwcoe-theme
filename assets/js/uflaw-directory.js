$(document).ready(function(){
  if( !window.location.hash ){
    showDirectoryTab("#A");
    if( $(window).width() > 768 ){
      $(".directory-item").addClass("default");
    }
  } else {
    showDirectoryTab(window.location.hash);   
  }

  function showDirectoryTab(hash){
    var letter = hash.replace( '#', '' );
      navItem = "a[data-target='" + letter + "']",
      facItem = ".directory-item[data-id='" + letter + "']"; 

    $(".directory-item").removeClass("active");
    $(".directory-item").removeClass("default");
    $(".directory-nav a").removeClass("active");

    $(navItem).addClass("active");
    $(facItem).addClass("active");
  }
  
  $(".directory-nav a").click(function(){
    var target = $(this).data("target");
    showDirectoryTab(target);
  })

  // Search
  function doDirectorySearch(){
    searched = $(".slug-search").val();
    window.location = window.location.origin + window.location.pathname + '?expertise=' + searched;
  };

  $(".styled-select li").click(function(){
    setTimeout(
      doDirectorySearch
      , 200 );
  });
  // Close search
  $("#faculty-directory-nav .close").click(function(){
    window.location = window.location.origin + window.location.pathname;
  });
  function facultyContHeight(){
    var maxHeight = 1;
    var facElements = $('.directory-item .directory-entry.col-sm-6');
    $(facElements).each(function(){
      var contHeight = $(this).height();
      if( contHeight > maxHeight ){
        maxHeight = contHeight;
      }
    });
    facElements.height(maxHeight);
   };
  if( $(window).width() > 768 ){
    facultyContHeight();
  };
})
