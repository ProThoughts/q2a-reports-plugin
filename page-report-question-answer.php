<?php

class qa_report_question_answer_page {

    private $directory;

    public function load_module($directory, $urltoroot) {
        $this->directory = $directory;
    }

    public function match_request($request) {
        switch ($request) {
            case 'qajax-report-wizard':
            case 'qajax-set-report':
            case 'qajax-set-type-report':
            case 'qajax-get-user-report-status':
            case "qajax-login-a-anonymous":
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
     */ {
        if (qa_opt(REPORTQA)) {
            switch ($request) {
                case 'qajax-report-wizard' : $this->wizardOutput();
                    break;
                case 'qajax-set-report' : $this->setReport();
                    break;
                case 'qajax-set-type-report' : $this->setTypeReport();
                    break;
                case 'qajax-get-user-report-status': $this->getUserReportStatus();
                    break;
                case 'qajax-login-a-anonymous': $this->isLoggedAnonAnswer();
                    break;
            }
        }  else {
            $result['reason'] = qa_lang('lang_report_question_answer/permission');
            $error = TRUE;
            $result['success'] = !$error;
            print json_encode($result);
        }
    }

    protected function isLoggedAnonAnswer()
    /*
     *  Check if user could post answer anonymously using option
     */ {

        print(json_encode(array('success' => true)));
        return;
    }

    public function wizardOutput() {

        echo json_encode("<div class='new_report_q' id='new_report_q' style='display:none'>
				<input type='hidden' id='q_id' name='q_id' value=''>
				<div class='heading-report' id='q_report'></div>
				<h2 class='editor text-left'>".qa_lang('lang_report_question_answer/reportlabelquestion')." <span class='iconclose'><i class='fa fa-close fa-lg'></i></span></h2>
                                <div class='col-xs-12 col-sm-12 col-lg-12' style='text-align:center'>
                                    <span class='inputreportgrp'>
					<input type='checkbox' name='selectreportq[]' class='magic-check' id='selectreportq01' value='".qa_lang('lang_report_question_answer/report1value')."'>
                                       <label for='selectreportq01' class='first-span'> ".qa_lang('lang_report_question_answer/report1')." </label>
                                    </span>
                                    <span class='inputreportgrp'>
					<input type='checkbox' name='selectreportq[]' class='magic-check' id='selectreportq02' value='".qa_lang('lang_report_question_answer/report2value')."'>
                                       <label for='selectreportq02' class='first-span'> ".qa_lang('lang_report_question_answer/report2')." </label>
                                    </span>
                                    <span class='inputreportgrp'>
					<input type='checkbox' name='selectreportq[]' class='magic-check' id='selectreportq03' value='".qa_lang('lang_report_question_answer/report3value')."'>
                                       <label for='selectreportq03' class='first-span'> ".qa_lang('lang_report_question_answer/report3')." </label>
                                    </span>
                                    <span class='inputreportgrp'>
					<input type='checkbox' name='selectreportq[]' class='magic-check' id='selectreportq04' value='".qa_lang('lang_report_question_answer/report4valueq')."'>
                                       <label for='selectreportq04' class='first-span'> ".qa_lang('lang_report_question_answer/report4q')." </label>
                                    </span>
                                    <span class='inputreportgrp'>
					<input type='checkbox' name='selectreportq[]' class='magic-check' id='selectreportq05' value='".qa_lang('lang_report_question_answer/report5value')."'>
                                       <label for='selectreportq05' class='first-span'> ".qa_lang('lang_report_question_answer/report5')." </label>
                                    </span>
                                    <span class='inputreportgrp'>
					<input type='checkbox' name='selectreportq[]' class='magic-check' id='selectreportq06' value='".qa_lang('lang_report_question_answer/report6value')."'>
                                       <label for='selectreportq06' class='first-span'> ".qa_lang('lang_report_question_answer/report6')." </label>
                                    </span>
                                    <span class='inputreportgrp'>
					<input type='checkbox' name='selectreportq[]' class='magic-check' id='selectreportq07' value='".qa_lang('lang_report_question_answer/report7value')."'>
                                       <label for='selectreportq07' class='first-span'> ".qa_lang('lang_report_question_answer/report7')." <input type='text' maxlength='93' id='radioquestionvalue07' style='margin-top: -2%;width:80%;'/>
                                    </span>
                                    
				</div>
				<br>
				<div class='col-xs-3 col-sm-3 col-lg-3 reportbutton'>
                                    		
                                    <button type='button' class='postreport' id='postreport'>Send Report</button>
                                    
				</div>
				<div class='col-xs-3 col-sm-3 col-lg-3 reportbutton'>
                                    		
                                    <button type='button' class='cancelreport' id='cancelreport'>Cancel</button>
                                    
				</div>
				</div>
                        <div class='new_report_a' id='new_report_a' style='display:none'>
				<input type='hidden' id='q_id' name='q_id' value=''>
				<div class='heading-report' id='q_report'></div>
				<h2 class='editor text-left'>".qa_lang('lang_report_question_answer/reportlabelanswer')." <span class='iconclose'><i class='fa fa-close fa-lg'></i></span></h2>
                                <div class='col-xs-12 col-sm-12 col-lg-12' style='text-align:center'>
                                    <span class='inputreportgrp'>
					<input type='checkbox' name='selectreporta[]' class='magic-check' id='selectreporta01' value='".qa_lang('lang_report_question_answer/report1value')."'>
                                       <label for='selectreporta01' class='first-span'> ".qa_lang('lang_report_question_answer/report1')." </label>
                                    </span>
                                    <span class='inputreportgrp'>
					<input type='checkbox' name='selectreporta[]' class='magic-check' id='selectreporta02' value='".qa_lang('lang_report_question_answer/report2value')."'>
                                       <label for='selectreporta02' class='first-span'> ".qa_lang('lang_report_question_answer/report2')." </label>
                                    </span>
                                    <span class='inputreportgrp'>
					<input type='checkbox' name='selectreporta[]' class='magic-check' id='selectreporta03' value='".qa_lang('lang_report_question_answer/report3value')."'>
                                       <label for='selectreporta03' class='first-span'> ".qa_lang('lang_report_question_answer/report3')." </label>
                                    </span>
                                    <span class='inputreportgrp'>
					<input type='checkbox' name='selectreporta[]' class='magic-check' id='selectreporta04' value='".qa_lang('lang_report_question_answer/report4valuea')."'>
                                       <label for='selectreporta04' class='first-span'> ".qa_lang('lang_report_question_answer/report4a')." </label>
                                    </span>
                                    <span class='inputreportgrp'>
					<input type='checkbox' name='selectreporta[]' class='magic-check' id='selectreporta05' value='".qa_lang('lang_report_question_answer/report5value')."'>
                                       <label for='selectreporta05' class='first-span'> ".qa_lang('lang_report_question_answer/report5')." </label>
                                    </span>
                                    <span class='inputreportgrp'>
					<input type='checkbox' name='selectreporta[]' class='magic-check' id='selectreporta06' value='".qa_lang('lang_report_question_answer/report6value')."'>
                                       <label for='selectreporta06' class='first-span'> ".qa_lang('lang_report_question_answer/report6')." </label>
                                    </span>
                                    <span class='inputreportgrp'>
					<input type='checkbox' name='selectreporta[]' class='magic-check' id='selectreporta07' value='".qa_lang('lang_report_question_answer/report7value')."'>
                                       <label for='selectreporta07' class='first-span'> ".qa_lang('lang_report_question_answer/report7')." <input type='text' maxlength='93' id='radioanswervalue07' style='margin-top: -2%;width:80%;'/>
                                    </span>
                                    
				</div>
				<br>
				<div class='col-xs-3 col-sm-3 col-lg-3 reportbutton'>
                                    		
                                    <button type='button' class='postreport' id='postreport'>Send Report</button>
                                    
				</div>
				<div class='col-xs-3 col-sm-3 col-lg-3 reportbutton'>
                                    		
                                    <button type='button' class='cancelreport' id='cancelreport'>Cancel</button>
                                    
				</div>
			</div>
                        
                        <div class='new_report_t' id='new_report_t' style='display:none'>
				<input type='hidden' id='q_id' name='q_id' value=''>
				<div class='heading-report' id='q_report'></div>
				<h2 class='editor text-left'>".qa_lang('lang_report_question_answer/reportlabeltopic')." <span class='iconclose'><i class='fa fa-close fa-lg'></i></span></h2>
                                <div class='col-xs-12 col-sm-12 col-lg-12' style='text-align:center'>
                                    <span class='inputreportgrp'>
					<input type='checkbox' name='selectreportt[]' class='magic-check' id='selectreportt01' value='".qa_lang('lang_report_question_answer/report1value')."'>
                                       <label for='selectreportt01' class='first-span'> ".qa_lang('lang_report_question_answer/report1')." </label>
                                    </span>
                                    <span class='inputreportgrp'>
					<input type='checkbox' name='selectreportt[]' class='magic-check' id='selectreportt02' value='".qa_lang('lang_report_question_answer/report2value')."'>
                                       <label for='selectreportt02' class='first-span'> ".qa_lang('lang_report_question_answer/report2')." </label>
                                    </span>
                                    <span class='inputreportgrp'>
					<input type='checkbox' name='selectreportt[]' class='magic-check' id='selectreportt03' value='".qa_lang('lang_report_question_answer/report3value')."'>
                                       <label for='selectreportt03' class='first-span'> ".qa_lang('lang_report_question_answer/report3')." </label>
                                    </span>
                                    <span class='inputreportgrp'>
					<input type='checkbox' name='selectreportt[]' class='magic-check' id='selectreportt04' value='".qa_lang('lang_report_question_answer/report4valuet')."'>
                                       <label for='selectreportt04' class='first-span'> ".qa_lang('lang_report_question_answer/report4t')." </label>
                                    </span>
                                    <span class='inputreportgrp'>
					<input type='checkbox' name='selectreportt[]' class='magic-check' id='selectreportt05' value='".qa_lang('lang_report_question_answer/report5value')."'>
                                       <label for='selectreportt05' class='first-span'> ".qa_lang('lang_report_question_answer/report5')." </label>
                                    </span>
                                    <span class='inputreportgrp'>
					<input type='checkbox' name='selectreportt[]' class='magic-check' id='selectreportt06' value='".qa_lang('lang_report_question_answer/report6value')."'>
                                       <label for='selectreportt06' class='first-span'> ".qa_lang('lang_report_question_answer/report6')." </label>
                                    </span>
                                    <span class='inputreportgrp'>
					<input type='checkbox' name='selectreportt[]' class='magic-check' id='selectreportt07' value='".qa_lang('lang_report_question_answer/report7value')."'>
                                       <label for='selectreportt07' class='first-span'> ".qa_lang('lang_report_question_answer/report7')." <input type='text' maxlength='93' id='radiotopicvalue07' style='margin-top: -2%;width:80%;'/>
                                    </span>
                                    
				</div>
				<br>
				<div class='col-xs-3 col-sm-3 col-lg-3 reportbutton'>
                                    		
                                    <button type='button' class='postreport' id='postreport'>Send Report</button>
                                    
				</div>
				<div class='col-xs-3 col-sm-3 col-lg-3 reportbutton'>
                                    		
                                    <button type='button' class='cancelreport' id='cancelreport'>Cancel</button>
                                    
				</div>
			</div>  
                        <div class='new_report_c' id='new_report_c' style='display:none'>
				<input type='hidden' id='q_id' name='q_id' value=''>
				<div class='heading-report' id='q_report'></div>
				<h2 class='editor text-left'>".qa_lang('lang_report_question_answer/reportlabelcategory')." <span class='iconclose'><i class='fa fa-close fa-lg'></i></span></h2>
                                <div class='col-xs-12 col-sm-12 col-lg-12' style='text-align:center'>
                                    <span class='inputreportgrp'>
					<input type='checkbox' name='selectreportc[]' class='magic-check' id='selectreportc01' value='".qa_lang('lang_report_question_answer/report1value')."'>
                                       <label for='selectreportc01' class='first-span'> ".qa_lang('lang_report_question_answer/report1')." </label>
                                    </span>
                                    <span class='inputreportgrp'>
					<input type='checkbox' name='selectreportc[]' class='magic-check' id='selectreportc02' value='".qa_lang('lang_report_question_answer/report2value')."'>
                                       <label for='selectreportc02' class='first-span'> ".qa_lang('lang_report_question_answer/report2')." </label>
                                    </span>
                                    <span class='inputreportgrp'>
					<input type='checkbox' name='selectreportc[]' class='magic-check' id='selectreportc03' value='".qa_lang('lang_report_question_answer/report3value')."'>
                                       <label for='selectreportc03' class='first-span'> ".qa_lang('lang_report_question_answer/report3')." </label>
                                    </span>
                                    <span class='inputreportgrp'>
					<input type='checkbox' name='selectreportc[]' class='magic-check' id='selectreportc04' value='".qa_lang('lang_report_question_answer/report4valuec')."'>
                                       <label for='selectreportc04' class='first-span'> ".qa_lang('lang_report_question_answer/report4c')." </label>
                                    </span>
                                    <span class='inputreportgrp'>
					<input type='checkbox' name='selectreportc[]' class='magic-check' id='selectreportc05' value='".qa_lang('lang_report_question_answer/report5value')."'>
                                       <label for='selectreportc05' class='first-span'> ".qa_lang('lang_report_question_answer/report5')." </label>
                                    </span>
                                    <span class='inputreportgrp'>
					<input type='checkbox' name='selectreportc[]' class='magic-check' id='selectreportc06' value='".qa_lang('lang_report_question_answer/report6value')."'>
                                       <label for='selectreportc06' class='first-span'> ".qa_lang('lang_report_question_answer/report6')." </label>
                                    </span>
                                    <span class='inputreportgrp'>
					<input type='checkbox' name='selectreportc[]' class='magic-check' id='selectreportc07' value='".qa_lang('lang_report_question_answer/report7value')."'>
                                       <label for='selectreportc07' class='first-span'> ".qa_lang('lang_report_question_answer/report7')." <input type='text' maxlength='93' id='radiocategoryvalue07' style='margin-top: -2%;width:80%;'/>
                                    </span>
                                    
				</div>
				<br>
				<div class='col-xs-3 col-sm-3 col-lg-3 reportbutton'>
                                    		
                                    <button type='button' class='postreport' id='postreport'>Send Report</button>
                                    
				</div>
				<div class='col-xs-3 col-sm-3 col-lg-3 reportbutton'>
                                    		
                                    <button type='button' class='cancelreport' id='cancelreport'>Cancel</button>
                                    
				</div>
			</div>
                        <div class='new_report_u' id='new_report_u' style='display:none'>
				<input type='hidden' id='q_id' name='q_id' value=''>
				<div class='heading-report' id='q_report'></div>
				<h2 class='editor text-left'>".qa_lang('lang_report_question_answer/reportlabeluser')." <span class='iconclose'><i class='fa fa-close fa-lg'></i></span></h2>
                                <div class='col-xs-12 col-sm-12 col-lg-12' style='text-align:center'>
                                    <span class='inputreportgrp'>
                                        <input type='checkbox' name='selectreportu[]' class='magic-check' id='selectreportu01' value='".qa_lang('lang_report_question_answer/report8value')."'>
                                       <label for='selectreportu01' class='first-span'> ".qa_lang('lang_report_question_answer/report8')." </label>
                                    </span>
                                    <span class='inputreportgrp'>
					<input type='checkbox' name='selectreportu[]' class='magic-check' id='selectreportu02' value='".qa_lang('lang_report_question_answer/report9value')."'>
                                       <label for='selectreportu02' class='first-span'> ".qa_lang('lang_report_question_answer/report9')." </label>
                                    </span>
                                    <span class='inputreportgrp'>
					<input type='checkbox' name='selectreportu[]' class='magic-check' id='selectreportu03' value='".qa_lang('lang_report_question_answer/report10value')."'>
                                       <label for='selectreportu03' class='first-span'> ".qa_lang('lang_report_question_answer/report10')." </label>
                                    </span>
                                    <span class='inputreportgrp'>
					<input type='checkbox' name='selectreportu[]' class='magic-check' id='selectreportu04' value='".qa_lang('lang_report_question_answer/report11value')."'>
                                       <label for='selectreportu04' class='first-span'> ".qa_lang('lang_report_question_answer/report11')." </label>
                                    </span>
                                    <span class='inputreportgrp'>
					<input type='checkbox' name='selectreportu[]' class='magic-check' id='selectreportu05' value='".qa_lang('lang_report_question_answer/report12value')."'>
                                       <label for='selectreportu05' class='first-span'> ".qa_lang('lang_report_question_answer/report12')." </label>
                                    </span>
                                    <span class='inputreportgrp'>
					<input type='checkbox' name='selectreportu[]' class='magic-check' id='selectreportu06' value='".qa_lang('lang_report_question_answer/report7value')."'>
                                       <label for='selectreportu06' class='first-span'> ".qa_lang('lang_report_question_answer/report7')." <input type='text' maxlength='93' id='radiouservalue07' style='margin-top: -2%;width:80%;'/>
                                    </span>
                                    
				</div>
				<br>
				<div class='col-xs-3 col-sm-3 col-lg-3 reportbutton'>
                                    		
                                    <button type='button' class='postreport' id='postreport'>Send Report</button>
                                    
				</div>
				<div class='col-xs-3 col-sm-3 col-lg-3 reportbutton'>
                                    		
                                    <button type='button' class='cancelreport' id='cancelreport'>Cancel</button>
                                    
				</div>
			</div> 
                        ");
    }

    public function setReport() {
        //$user_id=qa_
        $postid = $_POST["questionid"];
        $descriptions = $_POST["descriptions"];
        $userid = qa_get_logged_in_userid();
        if ($postid == "") {
            $result['reason'] = qa_lang('lang_report_question_answer/postidempty');
            $error = TRUE;
        } else {
            require_once QA_INCLUDE_DIR . 'app/posts.php';
            $row = qa_post_get_full($postid);
            $sqlresult = qa_db_read_one_value(qa_db_query_sub("select count(*) from ^reports where entityid=# and entitytype=$ and userid=#", $postid, $row['type'], $userid));
            if ($sqlresult == 0) {
                $query = "UPDATE ^posts SET flagcount=# WHERE postid=#";
                qa_db_query_sub($query, $row['flagcount'] + 1, $postid);
                foreach ($descriptions as $des) {
                    qa_db_query_sub(
                            'INSERT INTO ^reports (entitytype,entityid, userid, descriptions, created, updated) ' .
                            'VALUES ($, #, #, $,Now(),Now())', $row['type'], $postid, $userid, $des
                    );
                }

                qa_opt('cache_flaggedcount',qa_opt('cache_flaggedcount')+1);
                


                if ($row['type'] == 'A') {
                    $result['reason'] = qa_lang('lang_report_question_answer/answersuccessful');
                } else if ($row['type'] == 'Q') {
                    $result['reason'] = qa_lang('lang_report_question_answer/questionsuccessful');
                }
                $error = FALSE;
            } else {
                $result['reason'] = qa_lang('lang_report_question_answer/alreadyreport');
                $error = TRUE;
            }
        }
        $result['success'] = !$error;
        print json_encode($result);
    }
    public function setTypeReport() {
        //$user_id=qa_
        $postid = $_POST["questionid"];
        $descriptions = $_POST["descriptions"];
        $type = $_POST["type"];
        $userid = qa_get_logged_in_userid();
        if ($postid == "") {
            $result['reason'] = qa_lang('lang_report_question_answer/postidempty');
            $error = TRUE;
        } else {
//            $row = qa_post_get_full($postid);
            $sqlresult = qa_db_read_one_value(qa_db_query_sub("select count(*) from ^reports where entityid=# and entitytype=$ and userid=#", $postid, $type, $userid));
            if ($sqlresult == 0) {
//                $query = "UPDATE ^posts SET flagcount=# WHERE postid=#";
//                qa_db_query_sub($query, $row['flagcount'] + 1, $postid);
                foreach ($descriptions as $des) {
                    qa_db_query_sub(
                            'INSERT INTO ^reports (entitytype,entityid, userid, descriptions, created, updated) ' .
                            'VALUES ($, #, #, $,Now(),Now())', $type, $postid, $userid, $des
                    );
                }


                qa_opt('cache_flaggedcount',qa_opt('cache_flaggedcount')+1);


                if ($type == 'T') {
                    $result['reason'] = qa_lang('lang_report_question_answer/topicsuccessful');
                } else if ($type == 'C') {
                    $result['reason'] = qa_lang('lang_report_question_answer/categorysuccessful');
                } else if ($type == 'U') {
                    $result['reason'] = qa_lang('lang_report_question_answer/usersuccessful');
                }
                $error = FALSE;
            } else {
                $result['reason'] = qa_lang('lang_report_question_answer/alreadyreport');
                $error = TRUE;
            }
        }
        $result['success'] = !$error;
        print json_encode($result);
    }

    public function getUserReportStatus() {

        $postid = $_POST["id"];
        $type = $_POST["type"];

        $userid = qa_get_logged_in_userid();
        $sqlresult = qa_db_read_one_value(qa_db_query_sub("select count(*) from ^reports where entityid=# and entitytype=$ and userid=#", $postid, $type, $userid));
        
        if ($sqlresult == 0) {
            if ($type == 'A') {
                $result['reason'] =  qa_lang('lang_report_question_answer/answerpluginnotactive');
                $error = !qa_opt('enable_report_answer');
            } else if ($type == 'Q') {
                $result['reason'] =  qa_lang('lang_report_question_answer/questionpluginnotactive');
                $error = !qa_opt('enable_report_question');
            }else if ($type == 'T') {
                $result['reason'] =  qa_lang('lang_report_question_answer/topicpluginnotactive');
                $error = !qa_opt('enable_report_topic');
            } else if ($type == 'C') {
                $result['reason'] =  qa_lang('lang_report_question_answer/categorypluginnotactive');
                $error = !qa_opt('enable_report_category');
            } else if ($type == 'U') {
                $result['reason'] =  qa_lang('lang_report_question_answer/userpluginnotactive');
                $error = !qa_opt('enable_report_user');
            } else
                $error = FALSE;
        }else {
            if ($type == 'A') {
                $result['reason'] = qa_lang('lang_report_question_answer/answeralreadyreport');
            } else if ($type == 'Q') {
                $result['reason'] = qa_lang('lang_report_question_answer/questionalreadyreport');
            }else if ($type == 'T') {
                $result['reason'] =  qa_lang('lang_report_question_answer/topicalreadyreport');
            } else if ($type == 'C') {
                $result['reason'] =  qa_lang('lang_report_question_answer/categoryalreadyreport');
            } else if ($type == 'U') {
                $result['reason'] =  qa_lang('lang_report_question_answer/useralreadyreport');
            }
            $error = TRUE;
        }
        $result['success'] = !$error;
        print json_encode($result);
    }

}
