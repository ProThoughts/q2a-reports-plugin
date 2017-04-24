/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$(document).ready(function () {
    // This WILL work because we are listening on the 'document',
    // for a click on an element with an ID of #test-element

    $.ajax({
        url: getAjaxLoadReportWizard(),
        data: {id: 0},
        type: "GET",
        dataType: 'json',
        success: function (data) {
            $("body").append(data);
        }
    });
    $('.qa-form-light-button-flag').remove();///remove flag button. 
    $(document).on("change", "#radioanswervalue07", function () {
        $('#selectreporta07').val("Other: " + $("#radioanswervalue07").val());
        $("#selectreporta07").prop('checked', 'checked');
    });
    $(document).on("change", "#radioquestionvalue07", function () {
        $('#selectreportq07').val("Other: " + $("#radioquestionvalue07").val());
        $("#selectreportq07").prop('checked', 'checked');
    });
    $(document).on("change", "#radiotopicvalue07", function () {
        $('#selectreportt07').val("Other: " + $("#radiotopicvalue07").val());
        $("#selectreportt07").prop('checked', 'checked');
    });
    $(document).on("change", "#radiouservalue07", function () {
        $('#selectreportu06').val("Other: " + $("#radiouservalue07").val());
        $("#selectreportu06").prop('checked', 'checked');
    });
    $(document).on("click", "span.iconclose", function () {
        $(".ui-dialog-titlebar-close").trigger('click');
    });
    $(document).on("click", "#new_report_q #cancelreport", function () {
        $(".ui-dialog-titlebar-close").trigger('click');
    });
    $(document).on("click", "#new_report_q #postreport", function () {
        NewReportQuestion();
        return false;
    });
    $(document).on("click", "#new_report_a #cancelreport", function () {
        $(".ui-dialog-titlebar-close").trigger('click');
    });
    $(document).on("click", "#new_report_a #postreport", function () {
        NewReportAnswer();
        return false;
    });
    $(document).on("click", "#new_report_t #cancelreport", function () {
        $(".ui-dialog-titlebar-close").trigger('click');
    });
    $(document).on("click", "#new_report_t #postreport", function () {
        NewReportTopic();
        return false;
    });
    $(document).on("click", "#new_report_c #cancelreport", function () {
        $(".ui-dialog-titlebar-close").trigger('click');
    });
    $(document).on("click", "#new_report_c #postreport", function () {
        NewReportCategory();
        return false;
    });
    $(document).on("click", "#new_report_u #cancelreport", function () {
        $(".ui-dialog-titlebar-close").trigger('click');
    });
    $(document).on("click", "#new_report_u #postreport", function () {
        NewReportUser();
        return false;
    });
});

function reportQuestion_dialog(fnopen)
{

    return $("div#new_report_q").dialog({
        dialogClass: 'new_report_q',
        autoOpen: false,
        modal: true,
        width: 650,
        height: 'auto',
        resizable: false,
        closeOnEscape: true,
        autoReposition: true,
        open: fnopen,
        close: function (event) {
            // Remove instance from CKEditor on close
            var instance = CKEDITOR.instances['qa_editor'];
            if (instance) {
                instance.destroy(true);
                instance = null;
            }
        }
    });

}
function reportAnswer_dialog(fnopen)
{

    return $("div#new_report_a").dialog({
        dialogClass: 'new_report_a',
        autoOpen: false,
        modal: true,
        width: 650,
        height: 'auto',
        resizable: false,
        closeOnEscape: true,
        autoReposition: true,
        open: fnopen,
        close: function (event) {
            // Remove instance from CKEditor on close
            var instance = CKEDITOR.instances['qa_editor'];
            if (instance) {
                instance.destroy(true);
                instance = null;
            }
        }
    });

}
function reportTopic_dialog(fnopen)
{

    return $("div#new_report_t").dialog({
        dialogClass: 'new_report_t',
        autoOpen: false,
        modal: true,
        width: 650,
        height: 'auto',
        resizable: false,
        closeOnEscape: true,
        autoReposition: true,
        open: fnopen,
        close: function (event) {
            // Remove instance from CKEditor on close
            var instance = CKEDITOR.instances['qa_editor'];
            if (instance) {
                instance.destroy(true);
                instance = null;
            }
        }
    });

}
function reportCategory_dialog(fnopen)
{

    return $("div#new_report_c").dialog({
        dialogClass: 'new_report_c',
        autoOpen: false,
        modal: true,
        width: 650,
        height: 'auto',
        resizable: false,
        closeOnEscape: true,
        autoReposition: true,
        open: fnopen,
        close: function (event) {
            // Remove instance from CKEditor on close
            var instance = CKEDITOR.instances['qa_editor'];
            if (instance) {
                instance.destroy(true);
                instance = null;
            }
        }
    });

}
function reportUser_dialog(fnopen)
{

    return $("div#new_report_u").dialog({
        dialogClass: 'new_report_u',
        autoOpen: false,
        modal: true,
        width: 650,
        height: 'auto',
        resizable: false,
        closeOnEscape: true,
        autoReposition: true,
        open: fnopen,
        close: function (event) {
            // Remove instance from CKEditor on close
            var instance = CKEDITOR.instances['qa_editor'];
            if (instance) {
                instance.destroy(true);
                instance = null;
            }
        }
    });

}
function validate_callback(callback, unsuccess_callback, link, parameter)
{
    var parameter = parameter || null;

    if (typeof unsuccess_callback !== "function") {
        unsuccess_callback = function (msg) {
            alert(msg);
        };
    }

    $.ajax({
        url: link,
        data: parameter,
        type: 'POST',
        dataType: 'json',
        success: function (data) {
            if (data.success)
                callback();
            else
                unsuccess_callback(data.msg);
        }
    });

}
function reportQuestion(postid)
{
    // Set function on open
    var fnopen = function () {

        $.ajax({
            url: getAjaxGetUserReportStatus(),
            data: {"id": postid, type: "Q"},
            type: "POST",
            dataType: "json",
            success: function (resp) {
                if (resp['success']) {
                    // Set function on open dialog
                    var fnopendialog = function (event, ui) {

                        // Attach CKEditor
                        var edit_ans = CKEDITOR.replace('qa_editor', {defaultLanguage: 'en', language: '', height: '200px', width: '610px', resize_enabled: true, resize_dir: 'vertical', startupFocus: true});
                        edit_ans.on('key', function (evt) {
                            if (evt.data.keyCode === 27) {
                                $("div#new_report_q").dialog('close');
                                evt.cancel();
                                return false;
                            }
                        });
                    };
                    $("#new_report_q #q_id").val(postid);
                    // Open box
                    reportQuestion_dialog(fnopendialog).dialog('open');
                    $(window).trigger('resize');
                    return;
                } else {
                    alert(resp['reason']);
                }
            },
            error: function (req, status, err) {
                alert('ERROR: Plugin is not active for question.')
            }
        });

    };

    // Validate before execute
    validate_callback(fnopen, null, getAjaxLinkLoginAnonymousAnswer(), {'qid': postid});

    event.preventDefault();
    return false;
}
function reportAnswer(postid)
{
    // Set function on open
    var fnopen = function () {

        $.ajax({
            url: getAjaxGetUserReportStatus(),
            data: {"id": postid, type: "A"},
            type: "POST",
            dataType: "json",
            success: function (resp) {
                if (resp['success']) {
                    // Set function on open dialog
                    var fnopendialog = function (event, ui) {

                        // Attach CKEditor
                        var edit_ans = CKEDITOR.replace('qa_editor', {defaultLanguage: 'en', language: '', height: '200px', width: '610px', resize_enabled: true, resize_dir: 'vertical', startupFocus: true});
                        edit_ans.on('key', function (evt) {
                            if (evt.data.keyCode === 27) {
                                $("div#new_report_a").dialog('close');
                                evt.cancel();
                                return false;
                            }
                        });
                    };
                    $("#new_report_a #q_id").val(postid);

                    // Open box
                    reportAnswer_dialog(fnopendialog).dialog('open');
                    $(window).trigger('resize');
                    return;
                } else {
                    alert(resp['reason']);
                }
            },
            error: function (req, status, err) {
                alert('ERROR: Plugin is not active for answer.')
            }
        });

    };

    // Validate before execute
    validate_callback(fnopen, null, getAjaxLinkLoginAnonymousAnswer(), {'qid': postid});

    event.preventDefault();
    return false;
}
function reportTopic(postid)
{
    // Set function on open
    var fnopen = function () {

        $.ajax({
            url: getAjaxGetUserReportStatus(),
            data: {id: postid, type: "T"},
            type: "POST",
            dataType: "json",
            success: function (resp) {
                if (resp['success']) {
                    // Set function on open dialog
                    var fnopendialog = function (event, ui) {

                        // Attach CKEditor
                        var edit_ans = CKEDITOR.replace('qa_editor', {defaultLanguage: 'en', language: '', height: '200px', width: '610px', resize_enabled: true, resize_dir: 'vertical', startupFocus: true});
                        edit_ans.on('key', function (evt) {
                            if (evt.data.keyCode === 27) {
                                $("div#new_report_t").dialog('close');
                                evt.cancel();
                                return false;
                            }
                        });
                    };
                    $("#new_report_t #q_id").val(postid);
                    // Open box
                    reportTopic_dialog(fnopendialog).dialog('open');
                    $(window).trigger('resize');
                    return;
                } else {
                    alert(resp['reason']);
                }
            },
            error: function (req, status, err) {
                alert('ERROR: Plugin is not active for topic.')
            }
        });

    };

    // Validate before execute
    validate_callback(fnopen, null, getAjaxLinkLoginAnonymousAnswer(), {'qid': postid});

    event.preventDefault();
    return false;
}
function reportCategory(postid)
{

    // Set function on open
    var fnopen = function () {

        $.ajax({
            url: getAjaxGetUserReportStatus(),
            data: {id: postid, type: "C"},
            type: "POST",
            dataType: "json",
            success: function (resp) {
                if (resp['success']) {
                    // Set function on open dialog
                    var fnopendialog = function (event, ui) {

                        // Attach CKEditor
                        var edit_ans = CKEDITOR.replace('qa_editor', {defaultLanguage: 'en', language: '', height: '200px', width: '610px', resize_enabled: true, resize_dir: 'vertical', startupFocus: true});
                        edit_ans.on('key', function (evt) {
                            if (evt.data.keyCode === 27) {
                                $("div#new_report_c").dialog('close');
                                evt.cancel();
                                return false;
                            }
                        });
                    };
                    $("#new_report_c #q_id").val(postid);
                    // Open box
                    reportCategory_dialog(fnopendialog).dialog('open');
                    $(window).trigger('resize');
                    return;
                } else {
                    alert(resp['reason']);
                }
            },
            error: function (req, status, err) {
                alert('ERROR: Plugin is not active for category.')
            }
        });

    };

    // Validate before execute
    validate_callback(fnopen, null, getAjaxLinkLoginAnonymousAnswer(), {'qid': postid});

    event.preventDefault();
    return false;
}
function reportUser(postid)
{
//    console.log(code);
    // Set function on open
    var fnopen = function () {

        $.ajax({
            url: getAjaxGetUserReportStatus(),
            data: {id: postid, type: "U"},
            type: "POST",
            dataType: "json",
            success: function (resp) {
                if (resp['success']) {
                    // Set function on open dialog
                    var fnopendialog = function (event, ui) {

                        // Attach CKEditor
                        var edit_ans = CKEDITOR.replace('qa_editor', {defaultLanguage: 'en', language: '', height: '200px', width: '610px', resize_enabled: true, resize_dir: 'vertical', startupFocus: true});
                        edit_ans.on('key', function (evt) {
                            if (evt.data.keyCode === 27) {
                                $("div#new_report_u").dialog('close');
                                evt.cancel();
                                return false;
                            }
                        });
                    };
                    $("#new_report_u #q_id").val(postid);
                    // Open box
                    reportUser_dialog(fnopendialog).dialog('open');
                    $(window).trigger('resize');
                    return;
                } else {
                    alert(resp['reason']);

                }
            },
            error: function (req, status, err) {
                alert('ERROR: Plugin is not active for category.')
            }
        });

    };

    // Validate before execute
    validate_callback(fnopen, null, getAjaxLinkLoginAnonymousAnswer(), {'qid': postid});

    event.preventDefault();
    return false;
}
function NewReportQuestion()
{

    var id = $("#new_report_q #q_id").val(); // Question Id or Post ID
    var setchk = [];
    $("#selectreportq01:checked").val() ? setchk.push($("#selectreportq01:checked").val()) : "";
    $("#selectreportq02:checked").val() ? setchk.push($("#selectreportq02:checked").val()) : "";
    $("#selectreportq03:checked").val() ? setchk.push($("#selectreportq03:checked").val()) : "";
    $("#selectreportq04:checked").val() ? setchk.push($("#selectreportq04:checked").val()) : "";
    $("#selectreportq05:checked").val() ? setchk.push($("#selectreportq05:checked").val()) : "";
    $("#selectreportq06:checked").val() ? setchk.push($("#selectreportq06:checked").val()) : "";
    $("#selectreportq07:checked").val() ? setchk.push($("#selectreportq07:checked").val()) : "";
    if (setchk.length == 0) {
        alert("Please click at least an option");
        return false;
    }
    $.ajax({
        url: getAjaxSetReport(),
        data: {questionid: id, descriptions: setchk},
        type: "POST",
        dataType: "json",
        success: function (resp) {
            if (resp['success']) {
                alert(resp['reason']);
                $('div#new_report_q').dialog('close');
            } else {
                alert(resp['reason']);
                $('div#new_report_q').dialog('close');
            }

        },
        error: function (req, status, err) {
            alert("ERROR: Posting Report");
        }
    });
    $("#selectreportq01").attr('checked', false);
    $("#selectreportq02").attr('checked', false);
    $("#selectreportq03").attr('checked', false);
    $("#selectreportq04").attr('checked', false);
    $("#selectreportq05").attr('checked', false);
    $("#selectreportq06").attr('checked', false);
    $("#selectreportq07").attr('checked', false);
    $("#selectreportq07").val("Other:");
    $("#radioquestionvalue07").val("");
}
function NewReportAnswer()
{

    var id = $("#new_report_a #q_id").val(); // Question Id or Post ID
    var setchk = [];
    $("#selectreporta01:checked").val() ? setchk.push($("#selectreporta01:checked").val()) : "";
    $("#selectreporta02:checked").val() ? setchk.push($("#selectreporta02:checked").val()) : "";
    $("#selectreporta03:checked").val() ? setchk.push($("#selectreporta03:checked").val()) : "";
    $("#selectreporta04:checked").val() ? setchk.push($("#selectreporta04:checked").val()) : "";
    $("#selectreporta05:checked").val() ? setchk.push($("#selectreporta05:checked").val()) : "";
    $("#selectreporta06:checked").val() ? setchk.push($("#selectreporta06:checked").val()) : "";
    $("#selectreporta07:checked").val() ? setchk.push($("#selectreporta07:checked").val()) : "";
    if (setchk.length == 0) {
        alert("Please click at least an option");
        return false;
    }
    $.ajax({
        url: getAjaxSetReport(),
        data: {questionid: id, descriptions: setchk},
        type: "POST",
        dataType: "json",
        success: function (resp) {
            if (resp['success']) {
                alert(resp['reason']);
                $('div#new_report_a').dialog('close');
            } else {
                alert(resp['reason']);
                $('div#new_report_a').dialog('close');
            }

        },
        error: function (req, status, err) {
            alert("ERROR: Posting Report");
        }
    });
    $("#selectreporta01").attr('checked', false);
    $("#selectreporta02").attr('checked', false);
    $("#selectreporta03").attr('checked', false);
    $("#selectreporta04").attr('checked', false);
    $("#selectreporta05").attr('checked', false);
    $("#selectreporta06").attr('checked', false);
    $("#selectreporta07").attr('checked', false);
    $("#selectreporta07").val("Other:");
    $("#radioanswervalue07").val("");
}
function NewReportTopic()
{

    var id = $("#new_report_t #q_id").val(); // Question Id or Post ID
    var setchk = [];
    $("#selectreportt01:checked").val() ? setchk.push($("#selectreportt01:checked").val()) : "";
    $("#selectreportt02:checked").val() ? setchk.push($("#selectreportt02:checked").val()) : "";
    $("#selectreportt03:checked").val() ? setchk.push($("#selectreportt03:checked").val()) : "";
    $("#selectreportt04:checked").val() ? setchk.push($("#selectreportt04:checked").val()) : "";
    $("#selectreportt05:checked").val() ? setchk.push($("#selectreportt05:checked").val()) : "";
    $("#selectreportt06:checked").val() ? setchk.push($("#selectreportt06:checked").val()) : "";
    $("#selectreportt07:checked").val() ? setchk.push($("#selectreportt07:checked").val()) : "";
    if (setchk.length == 0) {
        alert("Please click at least an option");
        return false;
    }
    $.ajax({
        url: getAjaxSetTypeReport(),
        data: {questionid: id, descriptions: setchk, type: 'T'},
        type: "POST",
        dataType: "json",
        success: function (resp) {
            if (resp['success']) {
                alert(resp['reason']);
                $('div#new_report_t').dialog('close');
            } else {
                alert(resp['reason']);
                $('div#new_report_t').dialog('close');
            }

        },
        error: function (req, status, err) {
            alert("ERROR: Posting Report");
        }
    });
    $("#selectreportt01").attr('checked', false);
    $("#selectreportt02").attr('checked', false);
    $("#selectreportt03").attr('checked', false);
    $("#selectreportt04").attr('checked', false);
    $("#selectreportt05").attr('checked', false);
    $("#selectreportt06").attr('checked', false);
    $("#selectreportt07").attr('checked', false);
    $("#selectreportt07").val("Other:");
    $("#radiotopicvalue07").val("");
}
function NewReportCategory()
{

    var id = $("#new_report_c #q_id").val(); // Question Id or Post ID
    var setchk = [];
    $("#selectreportc01:checked").val() ? setchk.push($("#selectreportc01:checked").val()) : "";
    $("#selectreportc02:checked").val() ? setchk.push($("#selectreportc02:checked").val()) : "";
    $("#selectreportc03:checked").val() ? setchk.push($("#selectreportc03:checked").val()) : "";
    $("#selectreportc04:checked").val() ? setchk.push($("#selectreportc04:checked").val()) : "";
    $("#selectreportc05:checked").val() ? setchk.push($("#selectreportc05:checked").val()) : "";
    $("#selectreportc06:checked").val() ? setchk.push($("#selectreportc06:checked").val()) : "";
    $("#selectreportc07:checked").val() ? setchk.push($("#selectreportc07:checked").val()) : "";
    if (setchk.length == 0) {
        alert("Please click at least an option");
        return false;
    }
    $.ajax({
        url: getAjaxSetTypeReport(),
        data: {questionid: id, descriptions: setchk, type: 'C'},
        type: "POST",
        dataType: "json",
        success: function (resp) {
            if (resp['success']) {
                alert(resp['reason']);
                $('div#new_report_c').dialog('close');
            } else {
                alert(resp['reason']);
                $('div#new_report_c').dialog('close');
            }

        },
        error: function (req, status, err) {
            alert("ERROR: Posting Report");
        }
    });
    $("#selectreportc01").attr('checked', false);
    $("#selectreportc02").attr('checked', false);
    $("#selectreportc03").attr('checked', false);
    $("#selectreportc04").attr('checked', false);
    $("#selectreportc05").attr('checked', false);
    $("#selectreportc06").attr('checked', false);
    $("#selectreportc07").attr('checked', false);
    $("#selectreportc07").val("Other:");
    $("#radiocategoryvalue07").val("");
}

function NewReportUser()
{

    var id = $("#new_report_u #q_id").val(); // Question Id or Post ID
    var setchk = [];
    $("#selectreportu01:checked").val() ? setchk.push($("#selectreportu01:checked").val()) : "";
    $("#selectreportu02:checked").val() ? setchk.push($("#selectreportu02:checked").val()) : "";
    $("#selectreportu03:checked").val() ? setchk.push($("#selectreportu03:checked").val()) : "";
    $("#selectreportu04:checked").val() ? setchk.push($("#selectreportu04:checked").val()) : "";
    $("#selectreportu05:checked").val() ? setchk.push($("#selectreportu05:checked").val()) : "";
    $("#selectreportu06:checked").val() ? setchk.push($("#selectreportu06:checked").val()) : "";
    if (setchk.length == 0) {
        alert("Please click at least an option");
        return false;
    }
    $.ajax({
        url: getAjaxSetTypeReport(),
        data: {questionid: id, descriptions: setchk, type: 'U'},
        type: "POST",
        dataType: "json",
        success: function (resp) {
            if (resp['success']) {
                alert(resp['reason']);
                $('div#new_report_u').dialog('close');
            } else {
                alert(resp['reason']);
                $('div#new_report_u').dialog('close');
            }

        },
        error: function (req, status, err) {
            alert("ERROR: Posting Report");
        }
    });
    $("#selectreportu01").attr('checked', false);
    $("#selectreportu02").attr('checked', false);
    $("#selectreportu03").attr('checked', false);
    $("#selectreportu04").attr('checked', false);
    $("#selectreportu05").attr('checked', false);
    $("#selectreportu06").attr('checked', false);
    $("#selectreportu06").val("Other:");
    $("#radiouservalue07").val("");
}

function getBaseUrlReportWizard()
{
    return (window.location.origin + window.location.pathname);
}

function getAjaxLoadReportWizard()
{
    url = String(getBaseUrlReportWizard());
    url = url + 'qajax-report-wizard';
    return url;
}

function getAjaxSetReport()
{
    url = String(getBaseUrlReportWizard());
    url = url + 'qajax-set-report';
    return url;
}
function getAjaxSetTypeReport()
{
    url = String(getBaseUrlReportWizard());
    url = url + 'qajax-set-type-report';
    return url;
}

function getAjaxGetUserReportStatus()
{
    url = String(getBaseUrlReportWizard());
    url = url + 'qajax-get-user-report-status';
    return url;
}
function getAjaxLinkLoginAnonymousAnswer() {
    url = String(getBaseUrlReportWizard());
    url = url + 'qajax-login-a-anonymous';
    return url;
}