$(".registreren").click(function () {
    $("div.registreren").show("slow");

    $("div.wijzigen").hide("slow");
    $("div.Close-div-1").hide("slow");
});

$(".wijzigen").click(function () {
    $("div.wijzigen").show("slow");

    $("div.registreren").hide("slow");
    $("div.Close-div-1").hide("slow");
});

// $(".Close-open-button-1").click(function () {
//     $("div.Close-div-1").show("slow");
//
//     $("div.wijzigen").hide("slow");
//     $("div.registreren").hide("slow");
// });




$(".Hide-1").click(function() {
    $(".div-1").hide("slow");
});

