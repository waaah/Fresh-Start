$(document).ready(function() {
    $('#rightPointer').hide();
    $(".selectedCandidate").css("border", "0px solid white");
    $(".selectedSearch").css("border", "5px solid white");

});
$(document).ready(function() {
    $('.selectedCandidate').click(function(){
      $('#rightPointer').fadeIn('slow');
      $('#leftPointer').fadeOut('slow');
      $(".selectedSearch").css("border", "0px solid white");
      $(this).css("border", "5px solid white");
  });
});
$(document).ready(function() {
    $('.selectedSearch').click(function(){
      $('#leftPointer').fadeIn('slow');
      $('#rightPointer').fadeOut('slow');
        $(".selectedCandidate").css("border", "0px solid white");
        $(this).css("border", "5px solid white");
  });
});

$(document).ready(function(){
    $("#job, #candidate").hover(function(){
        $(this).css("opacity", "0.5");
      }, function(){
      $(this).css("opacity", "1");
    });
});
