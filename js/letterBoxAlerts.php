<!-- scripts for open /close letterbox modal box -->
<script>
$(".ALERTEDletterBox").on("click",function(e){
    e.preventDefault();
    $(".ALERTEDletterBox").attr('src', "img/letter.png");
    $('#letterAlertModal').modal('show');
});

$(".letterNoAlert").on("click",function(e){
    e.preventDefault();
    $('#letterNoAlert').modal('show');
});
</script>
