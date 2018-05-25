

$('#alertBar').click(function(){
  $('#alertBar').hide(800);
});

$('.alertBar').click(function(){
  $('#alertBar').hide(800);
});

$('.hideOnClick').click(function(){
  $('.hideOnClick').hide(800);
});


// if ($('.alertBar').html) {
//         window.setInterval(10);
//         $('.alertBar').html.remove();
//     }
//


$(".bookcaseNoSpace").click(function(){
  $(".bookingLogicErr").html("This exhibition is full. - Click to dismiss");
  $(".bookingLogicErr").show(300);
});

$(".bookcaseEnded").click(function(){
  $(".bookingLogicErr").html("This exhibition has ended and tickets can no longer be purchased. - Click to dismiss");
  $(".bookingLogicErr").show(300);
});

$(".bookcaseCncl").click(function(){
  $(".bookingLogicErr").html("This exhibition was canceled and can no longer be booked. - Click to dismiss");
  $(".bookingLogicErr").show(300);
});

$(".bookcaseLoggedOut").click(function(){
  $(".bookingLogicErr").html("You must be logged in to book exhibitons!");
  $(".bookingLogicErr").show(300);
});


$(".revwBtnNotLogged").click(function(){
  $(".reviewBtnErr").html("You must be logged in to post reviews!");
  $(".reviewBtnErr").show(300);
});

$(".revwBtnReadOnly").click(function(){
  $(".reviewBtnErr").html("Your account has been locked for misbehaving. You will be unable to post reviews while we investigate this further.");
  $(".reviewBtnErr").show(300);
});

$(".revwBtnNoBooking").click(function(){
  $(".reviewBtnErr").html("Only users with a ticket to the exhibition can post reviews.");
  $(".reviewBtnErr").show(300);
});

$(".revwBtnNotStartedYet").click(function(){
  $(".reviewBtnErr").html("This exhibition has not opened yet! You wont be able to review it till it does.");
  $(".reviewBtnErr").show(300);
});
