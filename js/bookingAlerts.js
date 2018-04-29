

$('#alertBar').click(function(){
  $('#alertBar').hide(800);
});

$(".bookcase1").click(function(){
  $("#alertBar").html("Sorry, you must be logged in to book tickets - click to dismiss");
  $("#alertBar").show(300);
});

$(".bookcase2").click(function(){
  $("#alertBar").html("Sorry, this exhibit has ended and you can no longer book tickets - click to dismiss");
  $("#alertBar").show(300);
});

$(".bookcase3").click(function(){
  $("#alertBar").html("Sorry, this exhibit is full - click to dismiss");
  $("#alertBar").show(300);
});
