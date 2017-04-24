<?php

/*
  Plugin Name: Q2A Reports Plugin
  Plugin Description: You can give report for question, answer, category, Topics and Users. It will show on `admin/flagged`
  Plugin Version: 1.0
  Plugin Date: 2017-21-03
  Plugin Author: Ratonshahadat
  Plugin Author URI:https://github.com/ratonshahadat
  Plugin Minimum Question2Answer Version:
  Plugin Minimum PHP Version:
  Plugin License: copy lifted
 */


if (!defined('QA_VERSION')) { // don't allow this page to be requested directly from browser
    header('Location: ../../');
    exit;
}
/**
 * Define the directory name of the theme directory to use in HTML format
 */
if (!defined('REPORTQA_PLUGIN_BASE_DIR_NAME')) {
	define('REPORTQA_PLUGIN_BASE_DIR_NAME', 'qa-plugin/'.basename(dirname(__FILE__)));
}
if (!defined('REPORTQA')) {
    define('REPORTQA', 'plugin_report_question_answer'); // Name plugin on admin page
}

/**
  * Overrides 
  */
qa_register_plugin_overrides('override.php');


// language file
qa_register_plugin_phrases('lang-report-question-answer-*.php', 'lang_report_question_answer');
qa_register_plugin_layer('layer-report-question-answer.php','layer report question answer');
qa_register_plugin_module('page','page-report-question-answer.php', 'qa_report_question_answer_page','qa_report_question_answer_page' );
qa_register_plugin_module('page','page-report-question-answer-admin.php', 'qa_report_question_answer_admin_page','qa_report_question_answer_admin_page' );
qa_register_plugin_module('widget','widget-report-question-answer.php', 'qa_report_question_answer',REPORTQA );
/*
	Omit PHP closing tag to help avoid accidental output
*/