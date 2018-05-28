// scripts for the letterbox - open / close the modal

//this first one changes the highlighted letter to a blank one when clicked
$(".ALERTEDletterBox").on("click",function(e){
    e.preventDefault();
    $(".ALERTEDletterBox").attr('src', "img/letter.png");
    $('#letterAlertModal').modal('show');
});

$(".letterNoAlert").on("click",function(e){
    e.preventDefault();
    $('#letterNoAlert').modal('show');
});
