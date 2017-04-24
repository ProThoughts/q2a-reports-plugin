<?php

class qa_report_question_answer_admin_page
{

    private $directory;

    public function load_module($directory, $urltoroot)
    {
        $this->directory = $directory;
    }

    public function match_request($request)
    {
        switch ($request) {
            case "qajax-flagged-other-report":
            case "qajax-remove-flagged-other-report":
                $isMatch = true;
                break;
            default:
                $isMatch = false;
                break;
        }

        return $isMatch;
    }

    public function process_request($request)
        /*
         * Empty because is not loaded directly
         */
    {
        if (qa_opt(REPORTQA)) {
            switch ($request) {
                case "qajax-flagged-other-report":
                    print json_encode($this->getTypeReport());
                    break;
                case "qajax-remove-flagged-other-report":
                    $this->removeTypeReport();
                    break;
            }
        }
    }

    private function getTypeReport()
    {

        $html = "";
        $results = qa_db_read_all_assoc(qa_db_query_sub("select DISTINCT entityid from ^reports where entitytype=$", "T"));
        foreach ($results as $result):
            $word = qa_db_read_one_value(qa_db_query_sub("select word from ^words where wordid=#", $result['entityid']));
            if ($word != "") {
                $link = 'tag/' . $word;
                $edit = 'tag-edit/' . $result['entityid'];
                $title = $word;
                $html .= $this->makeReport($result['entityid'], $link, $title, "T", $edit);
            }
        endforeach;
        $results = qa_db_read_all_assoc(qa_db_query_sub("select DISTINCT entityid from ^reports where entitytype=$", "C"));
        foreach ($results as $result):
            $cat = qa_db_read_all_assoc(qa_db_query_sub("select * from ^categories where categoryid=#", $result['entityid']));
            if (!empty($cat)) {
                $backpath = explode('/', $cat[0]['backpath']);
                $link = "";
                foreach ($backpath as $path):
                    $link = $path . "/" . $link;
                endforeach;
                $edit = 'admin/categories&edit=' . $result['entityid'];
                $title = $cat[0]['title'];
                $html .= $this->makeReport($result['entityid'], $link, $title, "C", $edit);
            }
        endforeach;
        $results = qa_db_read_all_assoc(qa_db_query_sub("select DISTINCT entityid from ^reports where entitytype=$", "U"));
        foreach ($results as $result):
            if (qa_userid_to_handle($result['entityid']) != NULL) {
                $link = "user/" . qa_userid_to_handle($result['entityid']);
                $title = qa_userid_to_handle($result['entityid']);
                $edit = "user/" . qa_userid_to_handle($result['entityid']) . "&state=edit";
                $html .= $this->makeReport($result['entityid'], $link, $title, "U", $edit);
            }
        endforeach;
        return $html;
    }

    private function makeReport($id, $link, $title, $type, $edit)
    {
        $html = '<div class="qa-q-list-item" id="' . $type . $id . '" data-entity="' . $type . '">
                    <div class="qa-q-item-stats">
                    </div>
                    <div class="qa-q-item-main allquestion">
                        <div class="col-image-fixed-absolute">
                            <div class="rounded-corner"></div>
                        </div>
                        <div class="col-image-fixed-after">
                            <div class="qa-item-header-button">
                                <a href="' . '.?qa=' . $edit . '" target="_blank" ><i class="fa fa-pencil-square-o fa-lg" title="Edit"  aria-hidden="true"></i></a>
                            </div>
                            <div class="qa-q-item-title">
                                <a href="' . qa_path_absolute($link) . '">' . ucfirst($title) . '</a>

                            </div>
                            <span class="qa-q-item-avatar-meta">
                                <span class="qa-q-item-flags">
                                    <span class="qa-q-item-flags-data">' . $this->getReportCount($id, $type) . '</span><span class="qa-q-item-flags-pad"> flag</span>
                                </span>
                            </span>
                        </div>
                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12">

                                <div class="col-md-12 col-sm-12 col-xs-12"><strong style="color:darkgrey;">Reports:</strong>
                                  ' . $this->getReport($id, $type) . '
                                </div>
                            </div>
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="qa-q-item-buttons">
                                    <div class="qa-q-item-buttons">
                                        <input name="admin_' . $type . $id . '_clearflags" onclick="return qa_clear_report_click(\'' . $id . '\',\'' . $type . '\');" value="clear flags" title="" class="qa-form-light-button qa-form-light-button-clearflags" type="button">';

        $type == "U" ? $html .= '<input name="doblock" onclick="return qa_block_report_click(\'' . $id . '\',\'' . qa_path_absolute($link) . '\');" value="Block User" title="" class="qa-form-light-button qa-form-light-button-hide" type="button">' : $html .= '<a class="qa-form-light-button qa-form-light-button-hide" href="' . '.?qa=' . $edit . '" target="_blank" >edit</a>';

        $html .= '</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="qa-q-item-clear">
                    </div>
                    <div class="qa-q-item-clear">
                    </div>
                </div>';
        return $html;
    }

    private function getReport($postid, $type)
    {

        $results = qa_db_read_all_assoc(qa_db_query_sub("select * from ^reports where entityid=# and entitytype=$ limit 5", $postid, $type));
        $html = "<ul id='users-list' class='ui-menu' style='margin: 2% 7%;text-align: left;'>";
        foreach ($results as $result):
            $html .= "<li class='ui-menu-item' role='presentation'>" . qa_userid_to_handle($result['userid']) . " : " . $result['descriptions'] . "</li>";
        endforeach;
        $html .= "</ul>";
        return $html;
    }

    private function getReportCount($postid, $type)
    {

        $results = qa_db_read_one_value(qa_db_query_sub("select count(DISTINCT userid) from ^reports where entityid=# and entitytype=$", $postid, $type));

        return $results;
    }

    private function removeTypeReport()
    {
        if (qa_opt('cache_flaggedcount') > 0) {

            qa_opt('cache_flaggedcount', qa_opt('cache_flaggedcount') - 1);

        }


        $postid = qa_get("postid");
        $type = qa_get("type");
        qa_db_query_sub('delete from ^reports where entityid=# and entitytype=$', $postid, $type);
        echo json_encode($postid);
    }
}
