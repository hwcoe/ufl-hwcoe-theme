$(document).ready(function(){
  // Search
  function doDirectorySearch(){
    searched = $(".slug-search").val();
    window.location = window.location.origin + '/experts-guide/' + searched;
  };

  $(".styled-select li").click(function(){
    setTimeout(
      doDirectorySearch
      , 200 );
  });
})
