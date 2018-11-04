$(function(){
    /**
     * "Stay on top" nav
     */
    var nav = $("nav");
    var navPosition = nav.offset();

    $(window).scroll(function(){
        if($(this).scrollTop() > navPosition.top - 2){
            nav.css({
                position    : "fixed",
                top         : "0px",
                left        : "0px",
                "z-index"   : "98",
                "border-top-left-radius"    : "0px",
                "border-top-right-radius"   : "0px"
            });
        }
        else{
            nav.css({
                width        : "100%",
                position     : "relative",
                "border-top-left-radius"    : "4px",
                "border-top-right-radius"   : "4px"
            });
        }
    });

    /**
     * Display category content
     */
    $(".glyphicon").click(function(){
        var id = $(this).parent().parent().parent().attr("id");
        if($("#category-"+id).is(":visible")){
            $("#category-"+id).slideUp();
        }
        else{
            $("#category-"+id).slideDown();
        }
    });
});
