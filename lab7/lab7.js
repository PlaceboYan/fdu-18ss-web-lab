$(document).ready(function() {
    var thumbBoxPic=document.getElementById('thumbBox');
    var bigPic=document.querySelector('figure img');
    var x;
    for (var i=0; i<5; i++) {
        $(thumbBoxPic.children[i]).bind("click", {index: i}, clickHandler);
    }
    function clickHandler(event) {
        var index = event.data.index;
        $(bigPic).attr('src', 'images/medium/painting'+(index+1)+'.jpg');
        var img=$("img:eq("+(index+1)+")");
        $('figcaption').html("<em>"+img.attr("alt")+"</em><br>"+img.attr("title"));
    }
    $("#sliderOpacity").bind("mousemove", {index: i}, moveHandlerOpacity);
    function moveHandlerOpacity(event) {
        x= $("#sliderOpacity").val();
        $('#numOpacity').text(x);
        $("#imgManipulated img").css("filter","opacity("+(x/100)+")");
    }
    $("#sliderBrightness").bind("mousemove", {index: i}, moveHandlerBrightness);
    function moveHandlerBrightness(event) {
        x= $("#sliderBrightness").val();
        $('#numBrightness').text(x);
        $("#imgManipulated img").css("filter","brightness("+(x/100)+")");
    }
    $("#sliderHue").bind("mousemove", {index: i}, moveHandlerHue);
    function moveHandlerHue(event) {
        x= $("#sliderHue").val();
        $('#numHue').text(x);
        $("#imgManipulated img").css("filter","hue-rotate("+(x)+"deg)");
    }
    $("#sliderGray").bind("mousemove", {index: i}, moveHandlerGray);
    function moveHandlerGray(event) {
        x= $("#sliderGray").val();
        $('#numGray').text(x);
        $("#imgManipulated img").css("filter","grayscale("+(x/100)+")");
    }
    $("#sliderBlur").bind("mousemove", {index: i}, moveHandlerBlur);
    function moveHandlerBlur(event) {
        x= $("#sliderBlur").val();
        $('#numBlur').text(x);
        $("#imgManipulated img").css("filter","blur("+x+"px)");
    }
    $("#sliderSaturation").bind("mousemove", {index: i}, moveHandlerSaturation);
    function moveHandlerSaturation(event) {
        x= $("#sliderSaturation").val();
        $('#numSaturation').text(x);
        $("#imgManipulated img").css("filter","saturate("+(x/100)+")");
    }

    $("#resetFilters").click(function () {
        $("#imgManipulated img").css("filter","none");
        $('#numOpacity').text(100);
        $('#numBrightness').text(100);
        $('#numHue').text(0);
        $('#numGray').text(0);
        $('#numSaturation').text(100);
        $('#numBlur').text(0);
    });

});
