$(".registreren").click(function () {
    $("div.registreren").show("slow");

    $("div.wijzigen").hide("slow");
});

$(".wijzigen").click(function () {
    $("div.wijzigen").show("slow");

    $("div.registreren").hide("slow");
});

