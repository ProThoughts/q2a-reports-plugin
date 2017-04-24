<?php


class qa_report_question_answer {

    var $directory;

    function load_module($directory, $urltoroot) {
        $this->directory = $directory;
    }

    function init_queries($tableslc) {

        $tablename = qa_db_add_table_prefix('reports');

        // check if event logger has been initialized already (check for one of the options and existing table)
        require_once QA_INCLUDE_DIR . 'qa-app-options.php';
        if (qa_opt(REPORTQA) && !in_array($tablename, $tableslc)) {
            // options exist, but check if really enabled
            if (!in_array($tablename, $tableslc)) {
                require_once QA_INCLUDE_DIR . 'qa-app-users.php';
                require_once QA_INCLUDE_DIR . 'qa-db-maxima.php';

                return 'CREATE TABLE IF NOT EXISTS ' . $tablename . ' (' .
                  "`reportid` int(11) NOT NULL AUTO_INCREMENT,
                  `entitytype` ENUM('A','C','Q','T','U') NOT NULL,
                  `entityid` int(11) NOT NULL,
                  `userid` int(11) NOT NULL,
                  `descriptions` varchar(500) NOT NULL,
                  `created` datetime NOT NULL,
                  `updated` datetime NOT NULL,
                   PRIMARY KEY (`reportid`)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
            }
        }
    }

    function admin_form(&$qa_content) {
        $saved = false;

        if (qa_clicked('report_save_button')) {
            $flag = (int) qa_post_text('enable_report_question') || (int) qa_post_text('enable_report_answer') ||(int) qa_post_text('enable_report_topic')||(int) qa_post_text('enable_report_category');

            if ($flag) {
                qa_opt('plugin_report_question_answer', 1);
            } else {
                qa_opt('plugin_report_question_answer', 0);
            }
            qa_opt('enable_report_question', (int) qa_post_text('enable_report_question'));
            qa_opt('enable_report_answer', (int) qa_post_text('enable_report_answer'));
            qa_opt('enable_report_topic', (int) qa_post_text('enable_report_topic'));
            qa_opt('enable_report_category', (int) qa_post_text('enable_report_category'));
            qa_opt('enable_report_user', (int) qa_post_text('enable_report_user'));
            $saved = true;
        }

        return array(
            'ok' => $saved ? qa_lang('lang_report_question_answer/pluginsavetext') : null,
            'fields' => array(
                array(
                    'label' => qa_lang('lang_report_question_answer/questionplugintext'),
                    'value' => qa_opt('enable_report_question'),
                    'tags' => 'NAME="enable_report_question"',
                    'type' => 'checkbox',
                    'value' => (int) qa_opt('enable_report_question'),
                ),
                array(
                    'label' => qa_lang('lang_report_question_answer/answerplugintext'),
                    'value' => qa_opt('enable_report_answer'),
                    'tags' => 'NAME="enable_report_answer"',
                    'type' => 'checkbox',
                    'value' => (int) qa_opt('enable_report_answer'),
                ),
                array(
                    'label' => qa_lang('lang_report_question_answer/topicplugintext'),
                    'value' => qa_opt('enable_report_topic'),
                    'tags' => 'NAME="enable_report_topic"',
                    'type' => 'checkbox',
                    'value' => (int) qa_opt('enable_report_topic'),
                ),
                array(
                    'label' => qa_lang('lang_report_question_answer/categoryplugintext'),
                    'value' => qa_opt('enable_report_category'),
                    'tags' => 'NAME="enable_report_category"',
                    'type' => 'checkbox',
                    'value' => (int) qa_opt('enable_report_category'),
                ),
                array(
                    'label' => qa_lang('lang_report_question_answer/userplugintext'),
                    'value' => qa_opt('enable_report_user'),
                    'tags' => 'NAME="enable_report_user"',
                    'type' => 'checkbox',
                    'value' => (int) qa_opt('enable_report_user'),
                )
            ),
            'buttons' => array(
                array(
                    'label' => qa_lang('lang_report_question_answer/pluginsubmittext'),
                    'tags' => 'NAME="report_save_button"',
                ),
            ),
        );
    }

}

/*
	Omit PHP closing tag to help avoid accidental output
*/
