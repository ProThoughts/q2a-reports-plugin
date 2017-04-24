<?php

/// Viewed question for layer, works for every general calling

class qa_html_theme_layer extends qa_html_theme_base {

    //add own js file
    function head_script() {

        if (qa_opt(REPORTQA)) {
            $this->url_path = REPORTQA_PLUGIN_BASE_DIR_NAME;
            $folder = REPORTQA_PLUGIN_BASE_DIR_NAME . "/js/report-question-answer.js";
            $script = "<script src='" . $folder . "'></script>";
            $this->content['script'][] = $script;
            $this->content['script'][] = "<script src='" . $this->url_path . "/js/jquery.min.js'></script>";
            $this->content['script'][] = "<script src='" . $this->url_path . "/js/jquery-ui.js'></script>";
            $this->content['script'][] = "<script src='" . $this->url_path . "/js/autoreposition.js'></script>";
            $this->content['script'][] = "<script src='" . $this->url_path . "/js/formvalidation.min.js'></script>";
            $this->content['script'][] = "<script src='" . $this->url_path . "/js/bootstrap.min.js'></script>";

            if ($this->request == 'admin/flagged') {
                $folder = REPORTQA_PLUGIN_BASE_DIR_NAME . "/js/report-question-answer-flagged.js";
                $script = "<script src='" . $folder . "'></script>";
                $this->content['script'][] = $script;
            }
        }
        qa_html_theme_base::head_script();
    }

    /**
     * Load custom css files
     */
    function head_css() {

        $this->url_path = REPORTQA_PLUGIN_BASE_DIR_NAME;
        $this->content['css_src'][] = REPORTQA_PLUGIN_BASE_DIR_NAME . '/css/report_style.css';
        // First vendor css
        $this->content['css_src'][] = '//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css';
        $this->content['css_src'][] = '//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css';
        $this->content['css_src'][] = $this->url_path . '/css/jquery-ui.css';
        $this->content['css_src'][] = $this->url_path . '/css/magic-check.css';

        // Second app css
        // IMPORTANT: Add new custom css after vendor
        $this->content['css_src'][] = $this->url_path . '/css/style.css';
        $this->content['css_src'][] = $this->url_path . '/css/style_font.css';
        $this->content['css_src'][] = $this->url_path . '/css/themestyle.css';
        qa_html_theme_base::head_css();
    }

    function q_item_main($q_item) {

        if (!empty($q_item) && qa_opt(REPORTQA) && 'admin/flagged' == $this->request) {
            $this->output('<div class="qa-q-item-main">');

            $this->view_count($q_item);
            $this->q_item_title($q_item);
            $this->q_item_content($q_item);

            $this->output(' <div class="col-md-12 col-sm-12 col-xs-12"><strong style="color:darkgrey;">Reports:</strong>');
            if (isset($q_item['raw']['opostid']) && $q_item['raw']['opostid'] != $q_item['raw']['postid']) {
                $this->getReport($q_item['raw']['opostid']);
            } else {
                $this->getReport($q_item['raw']['postid']);
            }
            $this->output(' </div>');
            
            $this->post_avatar_meta($q_item, 'qa-q-item');
            $this->post_tags($q_item, 'qa-q-item');
            $this->q_item_buttons($q_item);

            $this->output('</div>');
        } else {
            qa_html_theme_base::q_item_main($q_item);
        }
    }

    private function getReport($postid) {

        $row = qa_db_read_all_assoc(qa_db_query_sub("select * from ^posts where postid=#", $postid));
        if (count($row) == 1) {
            if ($row[0]['updated'] == "")
                $row[0]['updated'] = "2012-04-14";// If post update date is empty. It's need to take the post report. 
            $results = qa_db_read_all_assoc(qa_db_query_sub("select * from ^reports where entityid=# and entitytype=$ and created > # limit 5", $postid, $row[0]['type'], $row[0]['updated']));
            $this->output("<ul id='users-list' class='ui-menu' style='margin: 2% 7%;text-align: left;'>");
            foreach ($results as $result):
                $this->output("<li class='ui-menu-item' role='presentation'>" . qa_userid_to_handle($result['userid']) . " : " . $result['descriptions'] . "</li>");

            endforeach;
            $this->output("</ul>");
        }
    }

    public function q_view_buttons($q_view) {

        qa_opt('enable_report_question') && qa_get_logged_in_userid() ? $html = 'class="qa-form-light-button reportqa" onclick="reportQuestion(' . $q_view["raw"]["postid"] . ')"' : $html = 'class="qa-form-light-button reportqa report-disappear"';
        $q_view['form']['buttons']['report'] = Array
            (
            'tags' => 'type="button" href="#" id="reportqa"' . $html,
            'label' => 'Report Question',
            'popup' => 'Report Question'
        );
        qa_html_theme_base::q_view_buttons($q_view);
    }

    public function a_item_buttons($a_item) {
        qa_opt('enable_report_answer') && qa_get_logged_in_userid() ? $html.=' class="qa-form-light-button reportqa" onclick="reportAnswer(' . $a_item["raw"]["postid"] . ')"' : $html.=' class="qa-form-light-button reportqa report-disappear"';

        $a_item['form']['buttons']['report'] = Array
            (
            'tags' => 'type="button" href="#" id="reportqa"' . $html,
            'label' => 'Report Answer',
            'popup' => 'Report Answer'
        );
        qa_html_theme_base::a_item_buttons($a_item);
    }

    public function favorite() {
        $favorite = isset($this->content['favorite']) ? $this->content['favorite'] : null;
        if (isset($favorite)) {
            $favoritetags = isset($favorite['favorite_tags']) ? $favorite['favorite_tags'] : '';
            $this->output('<span class="qa-favoriting ds" ' . $favoritetags . '>');

            isset($favorite['favorite_add_tags']) ? $id = $favorite['favorite_add_tags'] : $id = $favorite['favorite_remove_tags'];
            $ids = explode("_", $id);
            if (preg_match('/(user)/', $this->request) == 1) {
                $this->output('<div class="tooltip-question tooltip-question-category">
                                            <i class="fa fa-ellipsis-h"></i>
                                            <div class="tooltip-inner tooltip-inner2 report-category">
                                                <a href="#" id="reportqa"');
                qa_opt('enable_report_user') && qa_get_logged_in_userid() ? $this->output(' class="reportqa" onclick="reportUser(\'' . qa_handle_to_userid(explode('/', $this->request)[1]) . '\')"') : $this->output(' class="reportqa report-disappear"');
                $this->output(' >Report User</a>
                                            </div>
                                        </div>');
            } else if ($ids[1] == 'C') {
                $this->output('<a href="#" id="reportqa"');
                qa_opt('enable_report_category') && qa_get_logged_in_userid() ? $this->output(' class="reportqa" onclick="reportCategory(\'' . $ids[2] . '\')"') : $this->output(' class="reportqa report-disappear"');
                $this->output(' >Report Category</a>');
            } else if ($ids[1] == 'T') {
                $this->output('<a href="#" id="reportqa"');
                qa_opt('enable_report_topic') && qa_get_logged_in_userid() ? $this->output(' class="reportqa" onclick="reportTopic(' . $ids[2] . ')"') : $this->output(' class="reportqa report-disappear"');
                $this->output(' >Report Topic</a>');
            }


            $this->favorite_inner_html($favorite);
            $this->output('</span>');
        }
    }

}

/*
	Omit PHP closing tag to help avoid accidental output
*/
