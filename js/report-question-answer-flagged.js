/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$(document).ready(function () {
    // This WILL work because we are listening on the 'document',
    // for a click on an element with an ID of #test-element

    $(".container-votes").css('display', 'none');

    $.ajax({
        url: getAjaxFlaggedOtherReport(),
        data: {id: 0},
        type: "GET",
        dataType: 'json',
        success: function (data) {
            if ($(".qa-main > h1").html()=="Flagged content") {
                $(".qa-part-q-list > form > div:first").first().append(data);
            } else {
                $(".qa-main > h1").html("Flagged content");
                $("head > title").html("Flagged content");
                //$(".qa-part-q-list > form > div").first().append("<div class='row'></div>");
                $(".qa-part-q-list > form > div:first").first().append(data);
            }
        }
    });

});

function qa_clear_report_click(postid, type) {
    $.ajax({
        url: getAjaxRemoveFlaggedOtherReport(),
        data: {postid: postid, type: type},
        type: "GET",
        dataType: 'json',
        success: function (data) {
            $("#" +type+ postid).remove();
            return false;
        }
    });
}
function qa_block_report_click(postid,link){
    $.ajax({
        url: link,
        data: {doblock: 'Block User'},
        type: "post",
        success: function (data) {
            return qa_clear_report_click(postid, "U");
        }
    });
}
function getAjaxFlaggedOtherReport()
{
    url = String(getBaseUrlReportWizard());
    url = url + 'qajax-flagged-other-report';
    return url;
}
function getAjaxRemoveFlaggedOtherReport()
{
    url = String(getBaseUrlReportWizard());
    url = url + 'qajax-remove-flagged-other-report';
    return url;
}