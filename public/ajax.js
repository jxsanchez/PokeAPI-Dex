function likeTeam(teamId, userId, likeCount) {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": jQuery('meta[name="csrf-token"]').attr("content"),
        },
    });

    $.ajax({
        type: "POST",
        url: "/liketeam",
        data: {
            teamId: teamId,
            userId: userId,
            likeCount: likeCount,
        },
        success: function (data) {
            $("#likes-container-" + teamId).html(data.msg);
        },
        error: function (data) {
            $("#likes-container-" + teamId).html("there was an error, please reload the page!");
        },
    });

    return false;
}
