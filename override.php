<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function qa_get_one_user_html($handle, $microformats = false, $favorited = false)
/*
  Return HTML to display for user with username $handle, with microformats if $microformats is true. Set $favorited to true to show the user as favorited.
 */ {
    if (!strlen($handle))
        return '';

    $url = qa_path_html('user/' . $handle);
    $favclass = $favorited ? ' qa-user-favorited' : '';
    $mfclass = $microformats ? ' url fn entry-title nickname' : '';
    $mfclass1= !$microformats ? ' link-user-report ':'';
    $mfclass2= $microformats ? ' link-user-report ':'';

    $html = '<a href="' . $url . '" class="qa-user-link '.$mfclass1 . $favclass . $mfclass . '">' . qa_html($handle) . '</a>';
//    if ($microformats != 1) {
        $html.='<div class="tooltip-inner tooltip-inner2 user-report">
        <a href="#" id="reportqa"';
        qa_opt('enable_report_user') &&  qa_get_logged_in_userid() ? $html .=' class="reportqa'.$mfclass2.'"  onclick="reportUser(\'' . qa_handle_to_userid($handle) . '\')"' : $html .=' class="reportqa report-disappear"';
        $html .=' >' . qa_lang('lang_report_question_answer/reportlabeluser') . '</a></div>';
//    }
    return $html;
}

