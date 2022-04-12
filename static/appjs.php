<?php
header("Content-type: text/javascript");
include("../config.php");
?>
$(document).ready(function() {
    // Twemoji
    $("body").html(twemoji.parse($("body").html(), {folder: "svg", ext: ".svg"}));

    // Discord
    $("#discord").html("<img src=\"https://lanyard-profile-readme.vercel.app/api/<?php echo $discord_id; ?>?bg=000&date="+new Date().getTime()+"\">")
    window.setInterval(function() {
        $("#discord img").attr("src", "https://lanyard-profile-readme.vercel.app/api/<?php echo $discord_id; ?>?bg=000&date="+new Date().getTime());
    }, 500);
});