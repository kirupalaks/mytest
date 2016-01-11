<?php

class TestsController extends AppController {

  public $name = "Tests";
    public $components = array('RequestHandler');
  public $uses = array("Test","Question","Student","StudentLessonMap","CourseLessonMap","StudentExerciseAttempt","StudentConceptAttempt",
    "StudentTestAttempt","Dashboard","LessonElementMap", "Lesson", "Element","StudentActivity","NewsTypes",
    "Exercise","Concept","StudentSkipLessons");

  public function beforeFilter() {
    parent::beforeFilter();
    $this->Auth->allow("student_view","getelements");
    $this->layout = "default";
  }

  public function index() {
    $this->set("tests", json_encode($this->Test->find('all')));

  }

  public function admin_review($attemptId) {
      $this->layout = "ahaguru_math";
  }

  public function adata_recalculate($moduleid,$testid) {
         $cond = array(
           "StudentTestAttempt.module_id" => $moduleid,
            "StudentTestAttempt.test_id" => $testid,
             'StudentTestAttempt.deleted =' => 0
                   );
      $tests = $this->StudentTestAttempt->find("all",array("conditions" =>$cond));
         foreach($tests as $test) {
        $newData = array();
        $newData['id'] = $test['StudentTestAttempt']['id'];
        $newData['score'] = $this->_calculatescore($testid, $test['StudentTestAttempt']['answers']);
        $this->StudentTestAttempt->save($newData);}
   $maxscore = $this->StudentTestAttempt->query("select max(score) from student_test_attempt where test_id = $testid and module_id = $moduleid and deleted = 0;"); 
         $students= $this->StudentTestAttempt->query("select * from student_test_attempt where test_id = $testid and module_id = $moduleid and deleted = 0;");
                   foreach($students as $student){
                    $mark = round($student['student_test_attempt']['score']);
              if ( file_exists(WWW_ROOT."/img/usr".$student['student_test_attempt']['student_id']."/profile_200.jpg") ) {
      $photo['photo'] = "/img/usr".$student['student_test_attempt']['student_id']."/profile_200.jpg";
    } else {
      $photo['photo'] = "Photo Not Available";
    }
     
       $news=$this->Dashboard->query("select * from news where test_id = $testid and student_id = ".$student['student_test_attempt']['student_id']);
                              if(!empty($news)){
                    $str=explode(" ",$news[0]['news']['news']);
           $key = array_search('scored',$str);
             if($student['student_test_attempt']['score'] == $maxscore[0][0]['max(score)']){
                 $str[$key + 1]= round($student['student_test_attempt']['score']);
             $data['id'] = $news[0]['news']['id'];
                 $data['news'] = implode(" ",$str);
                    $this->Dashboard->save($data);
                                     }
             else{
               $data['id'] = $news[0]['news']['id'];
                $this->Dashboard->delete($data);}}
           else if(empty($news) && $student['student_test_attempt']['score'] == $maxscore[0][0]['max(score)'] && $maxscore[0][0]['max(score)'] > 0){
                  if($photo['photo'] != "Photo Not Available"){
          $name= $this->Student->query('select name from students where id = '.$student['student_test_attempt']['student_id']. " and deleted = 0;");
           $testname=$this->Test->query('select name from test where id = '.$student['student_test_attempt']['test_id']. ' and deleted = 0;');
            $new = "<img src=".$photo['photo']." width=50px height=50px/> Congrats! ". $name[0]['students']['name']. " has scored " .$mark." in ".$testname[0]['test']['name'];
 $newscnt = $this->Dashboard->query("select count(*) from news where news_status = 2");
           if($newscnt[0][0]['count(*)'] < 10){
                      $this->NewsTypes->savenews($new,$this->NewsTypes->NEWS_TYPES['STUDENT NEWS'],null,$student['student_test_attempt']['test_id'],$student['student_test_attempt']['student_id']);         
       }
           else {
          $stdnew = $this->Dashboard->query("select * from news where news_status = 2");
           $this->Dashboard->query("delete from news where id = ".$stdnew[0]['news']['id']);     
     $this->NewsTypes->savenews($new,$this->NewsTypes->NEWS_TYPES['STUDENT NEWS'],null,$student['student_test_attempt']['test_id'],$student['student_test_attempt']['student_id']);         
           }}
      else{
         $name= $this->Student->query('select name from students where id = '.$student['student_test_attempt']['student_id']. " and deleted = 0;");
           $testname=$this->Test->query('select name from test where id = '.$student['student_test_attempt']['test_id']. ' and deleted = 0;');
                   $new = "<img src='/img/noimage.png' width=50px height=50px/> Congrats! ". $name[0]['students']['name']. " has scored " .$mark." in ".$testname[0]['test']['name'];
            $newscnt = $this->Dashboard->query("select count(*) from news where news_status = 2");
           if($newscnt[0][0]['count(*)'] < 10){
                      $this->NewsTypes->savenews($new,$this->NewsTypes->NEWS_TYPES['STUDENT NEWS'],null,$student['student_test_attempt']['test_id'],$student['student_test_attempt']['student_id']);         
       }
           else {
          $stdnew = $this->Dashboard->query("select * from news where news_status = 2");
           $this->Dashboard->query("delete from news where id = ".$stdnew[0]['news']['id']);     
     $this->NewsTypes->savenews($new,$this->NewsTypes->NEWS_TYPES['STUDENT NEWS'],null,$student['student_test_attempt']['test_id'],$student['student_test_attempt']['student_id']);         
           }}}}
      $this->set("json", json_encode(array("message" => "success")));
  }

  public function demo_review($testid, $answer_string, $time) {

    $test = array();
    $test['score'] = $this->_calculatescore($testid, $answer_string);
    $test['time'] = $time;
    $test['answers'] = $answer_string;
    $test['test'] = $this->Test->findById($testid);

    $answers=explode("##",$test['answers']);
    $question_ids = explode("@",$test['answers']);

    $questions = array();
    for($j = 0; $j < count($question_ids) - 1; $j++) {
      $questions[$j] = $question_ids[$j];
      if($j != 0) {
        $question_ids[$j] = explode("##", $question_ids[$j]);
        $question_ids[$j] = isset($question_ids[$j][1]) == 1 ? $question_ids[$j][1] : 0;
      }
      $questions[$j] = $question_ids[$j];
       $test['scr'][$j]=$this->quesscore($testid,$answers[$j]);      
    }

    $test['test']['Test']['quest'] = array();
    for($i = 0; $i < count($questions); $i++) {
      if(array_key_exists($i, $questions) && $questions[$i] != 0) {
        $test['test']['Test']['quest'][$i] = $this->Question->findById($questions[$i]);
        if(!empty($test['test']['Test']['quest'][$i]['Question'])) {
          $test['test']['Test']['quest'][$i]['Question']['hints'] = 0;
          if($test['test']['Test']['quest'][$i]['Question']['hint1'] != "") {
            $test['test']['Test']['quest'][$i]['Question']['hints'] += 1;
          }
          if($test['test']['Test']['quest'][$i]['Question']['hint2'] != "") {
            $test['test']['Test']['quest'][$i]['Question']['hints'] += 1;
          }
          if($test['test']['Test']['quest'][$i]['Question']['hint3'] != "") {
            $test['test']['Test']['quest'][$i]['Question']['hints'] += 1;
          }
          unset($test['test']['Test']['quest'][$i]['Question']['hint1']);
          unset($test['test']['Test']['quest'][$i]['Question']['hint2']);
          unset($test['test']['Test']['quest'][$i]['Question']['hint3']);
        }
      }
    }
    return $test;
  }

  public function adata_review($attemptId) {

    $attempts = $this->StudentTestAttempt->query("select * from student_test_attempt where id=$attemptId and deleted = 0;");

    $test = array();
    $test['attempts'] = count($attempts);
    if(count($attempts) == 1) {
      $testid = $attempts[0]['student_test_attempt']['test_id'];
      $test['score'] = $attempts[0]['student_test_attempt']['score'];
      $test['status'] = $attempts[0]['student_test_attempt']['status'];
      $test['time'] = $attempts[0]['student_test_attempt']['duration'];
      $test['answers'] = $attempts[0]['student_test_attempt']['answers'];
      $test['test'] = $this->Test->findById($testid);
          $answers=explode("##",$test['answers']);
      $question_ids = explode("@",$test['answers']);

      $questions = array();
      for($j = 0; $j < count($question_ids) - 1; $j++) {
        $questions[$j] = $question_ids[$j];
        if($j != 0) {
          $question_ids[$j] = explode("##", $question_ids[$j]);
          $question_ids[$j] = isset($question_ids[$j][1]) == 1 ? $question_ids[$j][1] : 0;
        }
        $questions[$j] = $question_ids[$j];
       $test['scr'][$j]=$this->quesscore($testid,$answers[$j]);      
      }

      $test['test']['Test']['quest'] = array();
      for($i = 0; $i < count($questions); $i++) {
        if(array_key_exists($i, $questions) && $questions[$i] != 0) {
          $test['test']['Test']['quest'][$i] = $this->Question->findById($questions[$i]);
          if(!empty($test['test']['Test']['quest'][$i]['Question'])) {
            $test['test']['Test']['quest'][$i]['Question']['hints'] = 0;
            if($test['test']['Test']['quest'][$i]['Question']['hint1'] != "") {
              $test['test']['Test']['quest'][$i]['Question']['hints'] += 1;
            }
            if($test['test']['Test']['quest'][$i]['Question']['hint2'] != "") {
              $test['test']['Test']['quest'][$i]['Question']['hints'] += 1;
            }
            if($test['test']['Test']['quest'][$i]['Question']['hint3'] != "") {
              $test['test']['Test']['quest'][$i]['Question']['hints'] += 1;
            }
            unset($test['test']['Test']['quest'][$i]['Question']['hint1']);
            unset($test['test']['Test']['quest'][$i]['Question']['hint2']);
            unset($test['test']['Test']['quest'][$i]['Question']['hint3']);
          }
        }
      }
    }
      $this->set("json", json_encode($test));
  }

  public function student_index() {
      $tests = $this->Test->find("all");
    $user = $this->Auth->user();
    $student_id = $user['Student']['id'];
    for($i = 0; $i < count($tests); $i++) {
        $attempt = $this->StudentTestAttempt->query(
            "select * from student_test_attempt 
            where 
                student_id = $student_id and
                   deleted = 0 and
                test_id =". $tests[$i]['Test']['id'].";
            ");
        if(count($attempt) >= 1) {
            $tests[$i]['Test']['status'] = $attempt[0]['student_test_attempt']['status'];
        }
        else 
        $tests[$i]['Test']['status'] = 0;
    }
    error_log("debug"."test data from db");    
    $this->set("tests", json_encode($tests));
  }

  public function adata_student($id) {
    $user = $this->Auth->user('Student');
    $attempts = $this->StudentTestAttempt->getStudentAttempts($id);
    $this->set("json", json_encode($attempts));
  }

  public function adata_reset($studentid) {
    $data = $this->request->data;
      $this->StudentTestAttempt->delete($data['id']);
          
    $this->set("json", json_encode(array("message"=>"Reset Success")));
     }

    public function adata_deleteactivity($testid) {
     $data = $this->request->data; 
   $this->StudentActivity->query("delete from student_activity where student =".$data['id']." and element_id = $testid ;");
       $this->Dashboard->query("delete from news where test_id = $testid and student_id =".$data['id'].";");
        $this->set("json", json_encode(array("message"=>"Reset")));
     }


  public function student_attempts() {
    $user = $this->Auth->user();
    $studentid = $user['Student']['id'];
    $testid = $this->request->data['test_id'];
     $modid = $this->request->data['module_id'];
    $this->set("attempts", json_encode($this->StudentTestAttempt->query("select * from student_test_attempt where student_id=$studentid and test_id=$testid and deleted = 0;")));
  }

  public function adata_questions() {
    $tags = $this->request->params['pass'][0];
    $questions = $this->Question->getQuestions($tags);
    if($questions)
      $this->set("json", json_encode($questions));
    else
      $this->set("json", json_encode(array("message"=>"error")));
  }

  public function adata_addquestion() {
    $data = $this->request->data;
    $test = $this->Test->findById($data['testid']);
    $test['Test']['questions'] = $test['Test']['questions'] == 0 ? $data['questionid'] : 
				 $test['Test']['questions'].",".$data['questionid'];
    if($this->Test->save($test)) {
      $this->set("json", json_encode(array("message" => "added")));
    } else {
      $this->set("json", json_encode(array("message" => "error")));
    }
  }

  public function admin_view($modid,$testid) {
    $test = array();
       $test['test'] = $this->Test->findById($testid);
    $questions = explode(",",$test['test']['Test']['questions']);
    $test['test']['Test']['quest'] = array();
    for($i = 0; $i < count($questions); $i++) {
      if(array_key_exists($i, $questions) && $questions[$i] != 0) {
        $test['test']['Test']['quest'][$i] = $this->Question->findById($questions[$i]);
        $test['test']['Test']['quest'][$i]['Question']['hints'] = 0;
        $question = $test['test']['Test']['quest'][$i]['Question'];
        if(array_key_exists("hint1", $question) && $question['hint1'] != "") {
          $test['test']['Test']['quest'][$i]['Question']['hints'] += 1;
        }
        if(array_key_exists("hint2", $question) && $question['hint2'] != "") {
          $test['test']['Test']['quest'][$i]['Question']['hints'] += 1;
        }
        if(array_key_exists("hint3", $question) && $question['hint3'] != "") {
          $test['test']['Test']['quest'][$i]['Question']['hints'] += 1;
        }
      }
    }
   $test['lesson'] = $this->Element->module($testid, 1,$modid);
    $test['course'] = $this->Lesson->course($modid);
    $this->set("tests", json_encode($test));
  }

  public function demo($id) {
    $test = array();
    $test['test'] = $this->Test->findById($id);
    $questions = explode(",",$test['test']['Test']['questions']);
    $test['test']['Test']['quest'] = array();
    for($i = 0; $i < count($questions); $i++) {
      if(array_key_exists($i, $questions) && $questions[$i] != 0) {
        $test['test']['Test']['quest'][$i] = $this->Question->findById($questions[$i]);
        $test['test']['Test']['quest'][$i]['Question']['hints'] = 0;
        $question = $test['test']['Test']['quest'][$i]['Question'];
        if(array_key_exists("hint1", $question) && $question['hint1'] != "") {
          $test['test']['Test']['quest'][$i]['Question']['hints'] += 1;
        }
        if(array_key_exists("hint2", $question) && $question['hint2'] != "") {
          $test['test']['Test']['quest'][$i]['Question']['hints'] += 1;
        }
        if(array_key_exists("hint3", $question) && $question['hint3'] != "") {
          $test['test']['Test']['quest'][$i]['Question']['hints'] += 1;
        }
      }
    }
    $module = $this->Element->module($id, 1);
    $test['course'] = $this->Lesson->course($module['id']);

    return $test;
  }

  public function student_view($testid) {
     $data = $this->request->data;
     $type = 1;
         if($this->Auth->user()){
         $user = $this->Auth->user();
    $studentid = $user['Student']['id'];
      
    $attempts = $this->StudentTestAttempt->query("select * from student_test_attempt where student_id= $studentid and test_id= $testid and deleted = 0;");
  $con  =array(
        'LessonElementMap.element_id' =>$testid,
       'LessonElementMap.element_type' => 1
           );
         $lesson = $this->LessonElementMap->find("all",array('conditions' => $con));
          $test['lesson'] = $this->Lesson->findById($lesson[0]['LessonElementMap']['lesson_id']);
                  $test['attempts'] = count($attempts);
    if(count($attempts) == 0) {
      $test['test'] = $this->Test->findById($testid);
      $questions = explode(",",$test['test']['Test']['questions']);
      $test['test']['Test']['quest'] = array();
      for($i = 0; $i < count($questions); $i++) {
        if(array_key_exists($i, $questions) && $questions[$i] != 0) {
          $test['test']['Test']['quest'][$i] = $this->Question->findById($questions[$i]);
          if(!empty($test['test']['Test']['quest'][$i]['Question']))
          {
            unset($test['test']['Test']['quest'][$i]['Question']['correct_answer']);
            $test['test']['Test']['quest'][$i]['Question']['hints'] = 0;
            if($test['test']['Test']['quest'][$i]['Question']['hint1'] != "") {
              $test['test']['Test']['quest'][$i]['Question']['hints'] += 1;
            }
            if($test['test']['Test']['quest'][$i]['Question']['hint2'] != "") {
              $test['test']['Test']['quest'][$i]['Question']['hints'] += 1;
            }
            if($test['test']['Test']['quest'][$i]['Question']['hint3'] != "") {
              $test['test']['Test']['quest'][$i]['Question']['hints'] += 1;
            }
            unset($test['test']['Test']['quest'][$i]['Question']['hint1']);
            unset($test['test']['Test']['quest'][$i]['Question']['hint2']);
            unset($test['test']['Test']['quest'][$i]['Question']['hint3']);
          }
        }
      }
          $test['status'] = 0;
    $this->StudentActivity->addOrUpdate(
          $this->StudentActivity->ACTIVITY_TYPES['TEST'], 
          $testid, 
        $this->StudentActivity->ACTIVITY_STATUS['STARTED'],
        "0");
    }
    if(count($attempts) == 1 && $attempts[0]['student_test_attempt']['status'] == 1) {
      $test['test'] = $this->Test->findById($testid);
      $questions = explode(",",$test['test']['Test']['questions']);
      $test['test']['Test']['quest'] = array();
      for($i = 0; $i < count($questions); $i++) {
        if(array_key_exists($i, $questions) && $questions[$i] != 0) {
          $test['test']['Test']['quest'][$i] = $this->Question->findById($questions[$i]);
          if(!empty($test['test']['Test']['quest'][$i]['Question'])) {
            unset($test['test']['Test']['quest'][$i]['Question']['correct_answer']);
            $test['test']['Test']['quest'][$i]['Question']['hints'] = 0;
            if($test['test']['Test']['quest'][$i]['Question']['hint1'] != "") {
              $test['test']['Test']['quest'][$i]['Question']['hints'] += 1;
            }
            if($test['test']['Test']['quest'][$i]['Question']['hint2'] != "") {
              $test['test']['Test']['quest'][$i]['Question']['hints'] += 1;
            }
            if($test['test']['Test']['quest'][$i]['Question']['hint3'] != "") {
              $test['test']['Test']['quest'][$i]['Question']['hints'] += 1;
            }
            unset($test['test']['Test']['quest'][$i]['Question']['hint1']);
            unset($test['test']['Test']['quest'][$i]['Question']['hint2']);
            unset($test['test']['Test']['quest'][$i]['Question']['hint3']);
          }
        }
      }
       $test['status'] = $attempts[0]['student_test_attempt']['status'];
      $test['time'] = $attempts[0]['student_test_attempt']['duration'];
      $test['answers'] = $attempts[0]['student_test_attempt']['answers'];
    }
     
    if(count($attempts) == 1 && $attempts[0]['student_test_attempt']['status'] == 2) {
       
      $test['score'] = $attempts[0]['student_test_attempt']['score'];
      $test['status'] = $attempts[0]['student_test_attempt']['status'];
      $test['time'] = $attempts[0]['student_test_attempt']['duration'];
      $test['answers'] = $attempts[0]['student_test_attempt']['answers'];
      $test['test'] = $this->Test->findById($testid);
       
    $answers=explode("##",$test['answers']);
       $question_ids = explode("@",$test['answers']);

      $questions = array();
      for($j = 0; $j < count($question_ids) - 1; $j++) {
        $questions[$j] = $question_ids[$j];
        if($j != 0) {
          $question_ids[$j] = explode("##", $question_ids[$j]);
          $question_ids[$j] = isset($question_ids[$j][1]) == 1 ? $question_ids[$j][1] : 0;
        }
        $questions[$j] = $question_ids[$j];
           $test['scr'][$j]=$this->quesscore($testid,$answers[$j]);      
    }
           
      $test['test']['Test']['quest'] = array();
      for($i = 0; $i < count($questions); $i++) {
        if(array_key_exists($i, $questions) && $questions[$i] != 0) {
          $test['test']['Test']['quest'][$i] = $this->Question->findById($questions[$i]);
          if(!empty($test['test']['Test']['quest'][$i]['Question'])) {
            $test['test']['Test']['quest'][$i]['Question']['hints'] = 0;
            if($test['test']['Test']['quest'][$i]['Question']['hint1'] != "") {
              $test['test']['Test']['quest'][$i]['Question']['hints'] += 1;
            }
            if($test['test']['Test']['quest'][$i]['Question']['hint2'] != "") {
              $test['test']['Test']['quest'][$i]['Question']['hints'] += 1;
            }
            if($test['test']['Test']['quest'][$i]['Question']['hint3'] != "") {
              $test['test']['Test']['quest'][$i]['Question']['hints'] += 1;
            }
            unset($test['test']['Test']['quest'][$i]['Question']['hint1']);
            unset($test['test']['Test']['quest'][$i]['Question']['hint2']);
            unset($test['test']['Test']['quest'][$i]['Question']['hint3']);
          }
        }
      }
    }
             $test['lesson'] = $this->Element->module($testid, $type);
         $test['course'] = $this->Lesson->getcourse($test['lesson']['id']);
            $modules = $this->CourseLessonMap->find('all', array('conditions' => array(
          'CourseLessonMap.course_id =' => $test['course']['id'],
          'CourseLessonMap.deleted !=' => 1,
            )));
        $skip_modules = $this->StudentSkipLessons->getSkipLessons($studentid, $test['course']['id']);
       $skip_lesson = explode(",", $skip_modules);

       if(in_array($test['lesson']['id'], $skip_lesson) || $test['course']['course_type'] == 2){

               $test['lesson']['skip'] = 1;
           }
      $this->set("tests", json_encode($test));
    
  }else{
     $test['test'] = $this->Test->findById($testid);
      $questions = explode(",",$test['test']['Test']['questions']);
      $test['test']['Test']['quest'] = array();
      for($i = 0; $i < count($questions); $i++) {
        if(array_key_exists($i, $questions) && $questions[$i] != 0) {
          $test['test']['Test']['quest'][$i] = $this->Question->findById($questions[$i]);
          if(!empty($test['test']['Test']['quest'][$i]['Question']))
          {
            unset($test['test']['Test']['quest'][$i]['Question']['correct_answer']);
            $test['test']['Test']['quest'][$i]['Question']['hints'] = 0;
            if($test['test']['Test']['quest'][$i]['Question']['hint1'] != "") {
              $test['test']['Test']['quest'][$i]['Question']['hints'] += 1;
            }
            if($test['test']['Test']['quest'][$i]['Question']['hint2'] != "") {
              $test['test']['Test']['quest'][$i]['Question']['hints'] += 1;
            }
            if($test['test']['Test']['quest'][$i]['Question']['hint3'] != "") {
              $test['test']['Test']['quest'][$i]['Question']['hints'] += 1;
            }
            unset($test['test']['Test']['quest'][$i]['Question']['hint1']);
            unset($test['test']['Test']['quest'][$i]['Question']['hint2']);
            unset($test['test']['Test']['quest'][$i]['Question']['hint3']);
          }
        }
      }
          $test['status'] = 0;
          $test['lesson'] = $this->Element->module($testid, $type);
         $test['course'] = $this->Lesson->getcourse($test['lesson']['id']);
            $modules = $this->CourseLessonMap->find('all', array('conditions' => array(
          'CourseLessonMap.course_id =' => $test['course']['id'],
          'CourseLessonMap.deleted !=' => 1,
            )));
          $test['lesson']['skip'] = 1;
     $this->set("tests", json_encode($test));
  }
  }
  public function add() {
    if($this->Auth->isAuthorized()) {
      $data = $this->request->data;
      $data['Test']['create'] = 1;
      if($this->Test->save($data))
      $this->set("stat", json_encode( array("id"=>$this->Test->id, "message" => "added") ));
      else 
      $this->set("stat", json_encode( array("message" => "error") ));
    }
    else 
    $this->set("stat", json_encode( array("message" => "error") ));
  }

  public function edit($id) {
    if($this->request->is("post")) {
        $test = $this->Test->findById($id);
    $test['Test']['questions'] = $this->data['questions'];
    if($this->Test->save($test))
    $this->set("json",json_encode(array("message"=>"success")));
    else
    $this->set("json",json_encode(array("message"=>"fail")));
    }
    
  }
  public function adata_delete($testid) {
    if($this->Test->setDelete($testid))
      $this->set("stat", json_encode( array( "message" => "deleted") ));
    else 
      $this->set("stat", json_encode( array("message" => "error") ));
  }

  public function delete($id) {
    if($this->Auth->isAuthorized()) {
      if($this->Test->delete($id))
      $this->set("stat", json_encode( array( "message" => "deleted") ));
      else 
      $this->set("stat", json_encode( array("message" => "error") ));
    }
    else 
    $this->set("stat", json_encode( array("message" => "error") ));
  }

  public function admin_save_test_question($modid,$id) {
    $question = $this->request->data;

      $question['tags'] = trim($question['tags']);
      $question['tags'] = preg_replace("/'/",",",$question['tags']);
      $question['tags'] = preg_replace("/\"/",",",$question['tags']);
      $question['tags'] = preg_replace("/\s+/",",",$question['tags']);

      if($this->Question->save($question)) {

        $test = $this->Test->findById($id);

        $test['Test']['questions'] = $test['Test']['questions'] == 0 ? $this->Question->id : 
                                     $test['Test']['questions'].",".$this->Question->id;

        $this->Test->save($test);
      }
    $this->redirect("/admin/edit/test/".$modid."/".$id);
  }

  public function admin_delete_test_question($id) {
    $question = $this->request->data;
    $test = $this->Test->findById($id);

    $questions = explode(",",$test['Test']['questions']);
    $index = array_search($question['question'], $questions);
    unset($questions[$question['question']]);
    $questions = implode(",",$questions);
    $test['Test']['questions'] = $questions;
    $this->Test->save($test);

    $this->set("json", json_encode(array("message" => "success")));
  }

  public function admin_edit_test_question($modid,$id) {
    $data = $this->request->data;
    $test = $this->Test->findById($id);


      $data['tags'] = trim($data['tags']);
      $data['tags'] = preg_replace("/'/",",",$data['tags']);
      $data['tags'] = preg_replace("/\"/",",",$data['tags']);
      $data['tags'] = preg_replace("/\s+/",",",$data['tags']);

      $this->Question->id = $data['id'];
      if($this->Question->save($data)) {

        $questions = explode(",",$test['Test']['questions']);
        $index = array_search($data['id'], $questions);
        if(!($index >= 0))
        $questions[count($questions)] = $data['id'];
        $questions = implode(",",$questions);
        $test['Test']['questions'] = $questions;
        $this->Test->save($test);

      }
    $this->redirect("/admin/edit/test/".$modid."/".$id);
    //$this->set("json", json_encode($data));
  }

  public function admin_test_question($modid,$id) {
    $data = $this->request->data;

    $test = $this->Test->findById($id);
    $questions = explode(",",$test['Test']['questions']);
    $index = array_search($data['question'], $questions);

    if($index >= 0) {
      $question = $this->Question->findById($data['question']);
      $this->set("json", json_encode($question));
    }
    else {
      $this->set("json", json_encode(array("message" => "error")));
    }
  }
  
  public function testquestions() {
    $test = array();
    $test['test'] = $this->Test->findById($this->request->params['id']);
    $questions = explode(",",$test['test']['Test']['questions']);
    $test['test']['Test']['quest'] = array();
    for($i = 0; $i < count($questions); $i++) {
      if(array_key_exists($i, $questions) && $questions[$i] !== 0)
      $test['test']['Test']['quest'][$i] = $this->Question->findById($questions[$i]);
      unset($test['test']['Test']['quest'][$i]['Question']['correct_answer']);
    }
    $this->set("tests", json_encode($test));
  }

  public function attempt() {
    $data = $this->request->data;
    $user = $this->Auth->user();    
    $this->layout = "default";
     $data['student_id'] = $user['Student']['id'];
    	$str = "select * from student_test_attempt where student_id=".$data['student_id']." and deleted = 0 and test_id = ".$data['test_id'];
    	     $attempts = $this->StudentTestAttempt->query($str) ;

      if ( file_exists(WWW_ROOT."/img/usr".$user['Student']['id']."/profile_200.jpg") ) {
      $user['photo'] = "/img/usr".$user['Student']['id']."/profile_200.jpg";
    } else {
      $user['photo'] = "Photo Not Available";
    }
    if($attempts == null) {
      $data['attempt'] = 1;
 }
    else if($attempts[count($attempts) - 1]['student_test_attempt']['attempt'] == 1 && 
      $attempts[count($attempts) - 1]['student_test_attempt']['status'] == 2) {
      $data['attempt'] = 2;
    }
    else {
      $data['id'] = $attempts[count($attempts) - 1]['student_test_attempt']['id'];
      $data['attempt'] = $attempts[count($attempts) - 1]['student_test_attempt']['attempt'];
      CakeLog::write('debug', "prev attempts ".print_r($attempts,true)); 
    }

    if(!array_key_exists("stat", $data)) {
      $data['id'] = $attempts[count($attempts) - 1]['student_test_attempt']['id'];
      $data['status'] = 2;
        CakeLog::write('debug', "saved attempts ".print_r($data,true)); 
    }
    else {
      $data['status'] = $data['stat'];
              }
        $this->set("json",json_encode($attempts));
     $data['score'] = $this->_calculatescore($data['test_id'],$data['answers']);
   $que=$this->quesscore($data['test_id'],$data['answers']);
    if($data['attempt'] != 2){
       
  $maxscore = $this->StudentTestAttempt->query('select max(score) from student_test_attempt where deleted = 0 and status = 2 and test_id ='.$data['test_id']);

              $this->StudentTestAttempt->save($data);
              $marker['element_id'] = $data['element_id'];
          $marker['student_id'] = $data['student_id'];         
          $lesson_id = $this->LessonElementMap->find("first",array("conditions" => 
            array('LessonElementMap.element_id' => $data['element_id'],
                     'LessonElementMap.element_type'=>2,
                     'LessonElementMap.deleted' =>0
            )));
          $marker['lesson_id']=$lesson_id['LessonElementMap']['lesson_id'];
          $course_id = $this->CourseLessonMap->find("first",array("conditions" => 
            array('CourseLessonMap.lesson_id' => $lesson_id['LessonElementMap']['lesson_id'],
                     'CourseLessonMap.deleted' =>0
            )));
          $marker['position'] = $course_id['CourseLessonMap']['srno'];
           $marker['course_id']=$course_id['CourseLessonMap']['course_id'];
           $mapping = $this->StudentLessonMap->find("first",array("conditions"=> 
            array('StudentLessonMap.course_id' =>$course_id['CourseLessonMap']['course_id'],
                    'StudentLessonMap.deleted' =>0
            )));
          
           if(empty($mapping)){
          $this->StudentLessonMap->save($marker);
          
        }
           else{
            $this->StudentLessonMap->updatemarker($marker);
            }
               if($user['photo'] != "Photo Not Available"){
       if($data['score'] > $maxscore[0][0]['max(score)'] && $data['score'] > 0){
       $name= $this->Student->query('select name from students where id = '.$data['student_id']. " and deleted = 0;");
          $testname=$this->Test->query('select name from test where id = '.$data['test_id']. ' and deleted = 0;');
          $new = "<img src=".$user['photo']." width=50px height=50px/> Congrats! ". $name[0]['students']['name']. " has scored " .$data['score']." in ".$testname[0]['test']['name'];
            $this->Dashboard->query('delete from news where test_id = '.$data['test_id'].';');
           $newscnt = $this->Dashboard->query("select count(*) from news where news_status = 2");
            if($newscnt[0][0]['count(*)'] < 10){         
          $this->NewsTypes->savenews($new,$this->NewsTypes->NEWS_TYPES['STUDENT NEWS'],null,$data['test_id'],$data['student_id']);
       }
           else {
          $stdnew = $this->Dashboard->query("select * from news where news_status = 2");
           $this->Dashboard->query("delete from news where id = ".$stdnew[0]['news']['id']);     
           $this->NewsTypes->savenews($new,$this->NewsTypes->NEWS_TYPES['STUDENT NEWS'],null,$data['test_id'],$data['student_id']);
           }}
          else if($data['score'] == $maxscore[0][0]['max(score)'] && $data['score'] > 0){
   $name= $this->Student->query('select name from students where id = '.$data['student_id']. " and deleted = 0;");
                $testname=$this->Test->query('select name from test where id = '.$data['test_id']. " and deleted = 0;");
                   $new = "<img src=".$user['photo']." width=50px height=50px/> Congrats! ". $name[0]['students']['name']. " has scored " .$data['score']." in ".$testname[0]['test']['name'];
               $newscnt = $this->Dashboard->query("select count(*) from news where news_status = 2");
           if($newscnt[0][0]['count(*)'] < 10){
                     $this->NewsTypes->savenews($new,$this->NewsTypes->NEWS_TYPES['STUDENT NEWS'],null,$data['test_id'],$data['student_id']);
       }
           else {
          $stdnew = $this->Dashboard->query("select * from news where news_status = 2");
           $this->Dashboard->query("delete from news where id = ".$stdnew[0]['news']['id']);     
           $this->NewsTypes->savenews($new,$this->NewsTypes->NEWS_TYPES['STUDENT NEWS'],null,$data['test_id'],$data['student_id']);
           }
                
         }}
      else{
                if($data['score'] > $maxscore[0][0]['max(score)'] && $data['score'] > 0){
    $name= $this->Student->query('select name from students where id = '.$data['student_id']. " and deleted = 0;");
                $testname=$this->Test->query('select name from test where id = '.$data['test_id']. " and deleted = 0;");
                   $new = "<img src='/img/noimage.png' height=50px width=50px/'> Congrats! ".$name[0]['students']['name']. " has scored " .$data['score']." in ".$testname[0]['test']['name'];
           $this->Dashboard->query('delete from news where test_id = '.$data['test_id'].';');
       $newscnt = $this->Dashboard->query("select count(*) from news where news_status = 2");
           if($newscnt[0][0]['count(*)'] < 10){
                     $this->NewsTypes->savenews($new,$this->NewsTypes->NEWS_TYPES['STUDENT NEWS'],null,$data['test_id'],$data['student_id']);
       }
           else {
          $stdnew = $this->Dashboard->query("select * from news where news_status = 2");
           $this->Dashboard->query("delete from news where id = ".$stdnew[0]['news']['id']);     
           $this->NewsTypes->savenews($new,$this->NewsTypes->NEWS_TYPES['STUDENT NEWS'],null,$data['test_id'],$data['student_id']);
           }
              }
          else if($data['score'] == $maxscore[0][0]['max(score)'] && $data['score'] > 0){
   $name= $this->Student->query('select name from students where id = '.$data['student_id']. " and deleted = 0;");
                $testname=$this->Test->query('select name from test where id = '.$data['test_id']. " and deleted = 0;");
                   $new = "<img src='/img/noimage.png' height=50px width=50px/> Congrats! ".$name[0]['students']['name']. " has scored " .$data['score']." in ".$testname[0]['test']['name'];
     $newscnt = $this->Dashboard->query("select count(*) from news where news_status = 2");
           if($newscnt[0][0]['count(*)'] < 10){
                     $this->NewsTypes->savenews($new,$this->NewsTypes->NEWS_TYPES['STUDENT NEWS'],null,$data['test_id'],$data['student_id']);
       }
           else {
          $stdnew = $this->Dashboard->query("select * from news where news_status = 2");
           $this->Dashboard->query("delete from news where id = ".$stdnew[0]['news']['id']);     
           $this->NewsTypes->savenews($new,$this->NewsTypes->NEWS_TYPES['STUDENT NEWS'],null,$data['test_id'],$data['student_id']);
           }
              }}
           
           }
	if($data['status'] == 1) {
         $this->StudentActivity->addOrUpdate(
          $this->StudentActivity->ACTIVITY_TYPES['TEST'], 
        $data['test_id'],
        $this->StudentActivity->ACTIVITY_STATUS['IN PROGRESS'],
        "0"); 
       } 
      else {
    $this->StudentActivity->addOrUpdate(
          $this->StudentActivity->ACTIVITY_TYPES['TEST'], 
        $data['test_id'],
        $this->StudentActivity->ACTIVITY_STATUS['FINISHED'],
        "0"); 
          }
       return $que;
  }
  
     protected function quesscore($testid,$answer){
                $score=0;
            $questionid = explode("@", $answer);
            $answers = explode("!",$questionid[1]);
             $number_of_hints = $answers[1];
                          $answers = $answers[0];
             $questionid = $questionid[0];
                    $question = $this->Question->findById($questionid);     
                   if($question['Question']['question_type'] == 1){
                 if($answers != "NA" && $question['Question']['correct_answer'] == $answers) {
                     $score = $question['Question']['mark'];
                     $negative_mark = 0;
                     for($i =1; $i<= $number_of_hints; $i++) {
                        $negative_mark += $question['Question']['hint'.$i.'_negative_mark'];
                       }
                    $score -= $negative_mark;

                 } else if($answers != "NA") {
                     $score -= $question['Question']['negative_mark'];
                     }
                 
             }
             if($question['Question']['question_type'] == 3){
                 $max = $min = $equal = 0;  
                 if($question['Question']['answer_range1'] > $question['Question']['answer_range2'])  {
                    $max = $question['Question']['answer_range1'];
                    $min = $question['Question']['answer_range2'];
                 } else if($question['Question']['answer_range1'] < $question['Question']['answer_range2']){
                    $max = $question['Question']['answer_range2'];
                    $min = $question['Question']['answer_range1'];
                 }  else if($question['Question']['answer_range1'] == "" && $question['Question']['answer_range2'] == ""){
                    $equal = 1;
                    $max = $min = $question['Question']['correct_answer'];
                 }
                 else if($question['Question']['answer_range1'] == "" && $question['Question']['answer_range2'] != ""){
                       $min = $question['Question']['correct_answer'];
                       $max = $question['Question']['answer_range2'];
                 }                 
                 else if($question['Question']['answer_range1'] != "" && $question['Question']['answer_range2'] == ""){
                       $max = $question['Question']['correct_answer'];
                       $min = $question['Question']['answer_range2'];
                 }        
                 else {
                    $equal = 1;
                    $max = $min = $question['Question']['answer_range2'];
                 }                 

                 if($answers != "NA" && $equal == 0 && (($answers >= $min) && ($answers <= $max))){
                     $score = $question['Question']['mark'];
                     $negative_mark = 0;
                     for($i =1; $i<= $number_of_hints; $i++) {
                        $negative_mark += $question['Question']['hint'.$i.'_negative_mark'];
                                             }
                     $score -= $negative_mark;

                  }                  
                  else if($answers != "NA" && $equal == 1 && $answers == $min){
                     $score = $question['Question']['mark'];
                     
                     $negative_mark = 0;
                     for($i =1; $i<= $number_of_hints; $i++) {
                        $negative_mark += $question['Question']['hint'.$i.'_negative_mark'];
                        }
                     $score -= $negative_mark;

                 } else {
                     if($answers != "NA") {
                     $score -= $question['Question']['negative_mark'];
                     }
            
           
   }  }
       return $score;
  }

  protected function _calculatescore($testid,$answerstring){
     $questionanswer = explode("##",$answerstring);
        $score = 0;
     foreach($questionanswer as $value) {

         if($value != "") {

             $questionid = explode("@", $value);
             $answers = explode("!",$questionid[1]);
             $number_of_hints = $answers[1];
             $answers = $answers[0];
             $questionid = $questionid[0];

             $question = $this->Question->findById($questionid);
             if($question['Question']['question_type'] == 1){
                 if($answers != "NA" && $question['Question']['correct_answer'] == $answers) {
                            
                 $score += $question['Question']['mark'];
                   $negative_mark = 0;
                     for($i =1; $i<= $number_of_hints; $i++) {
                        $negative_mark += $question['Question']['hint'.$i.'_negative_mark'];
                           }
                     $score -= $negative_mark;

                 } else {
                     if($answers != "NA") {    
                        $score -= $question['Question']['negative_mark'];
                     }
                 }
             }
             if($question['Question']['question_type'] == 3){
                 $max = $min = $equal = 0;

                 if($question['Question']['answer_range1'] > $question['Question']['answer_range2'])  {
                    $max = $question['Question']['answer_range1'];
                    $min = $question['Question']['answer_range2'];
                 } else if($question['Question']['answer_range1'] < $question['Question']['answer_range2']){
                    $max = $question['Question']['answer_range2'];
                    $min = $question['Question']['answer_range1'];
                 }
                 else if($question['Question']['answer_range1'] == "" && $question['Question']['answer_range2'] == ""){
                    $equal = 1;
                    $max = $min = $question['Question']['correct_answer'];
                 }
                 else if($question['Question']['answer_range1'] == "" && $question['Question']['answer_range2'] != ""){
                       $min = $question['Question']['correct_answer'];
                       $max = $question['Question']['answer_range2'];
                 }                 
                 else if($question['Question']['answer_range1'] != "" && $question['Question']['answer_range2'] == ""){
                       $max = $question['Question']['correct_answer'];
                       $min = $question['Question']['answer_range2'];
                 }                 
                  else {
                    $equal = 1;
                    $max = $min = $question['Question']['answer_range2'];
                 }

                 if($answers != "NA" && $equal == 0 && (($answers >= $min) && ($answers <= $max))){
                     $score += $question['Question']['mark'];
                     $negative_mark = 0;
                     for($i =1; $i<= $number_of_hints; $i++) {
                        $negative_mark += $question['Question']['hint'.$i.'_negative_mark'];
                                       }
                     $score -= $negative_mark;

                  } else if($answers != "NA" && $equal == 1 && $answers == $min){
                     $score += $question['Question']['mark'];
                                   $negative_mark = 0;
                     for($i =1; $i<= $number_of_hints; $i++) {
                        $negative_mark += $question['Question']['hint'.$i.'_negative_mark'];
                                 }
                     $score -= $negative_mark;

                 } else {
                     if($answers != "NA") {                    
                      $score -= $question['Question']['negative_mark'];
                     }
                 }
             }
         }
     }

    return $score;
  }

  public function getelements($testid){
          $this->layout = "default";
           $user = $this->Auth->user();
              $student_id = $user['Student']['id'];
          $condition = array(
            'LessonElementMap.element_id' => $testid,
            'LessonElementMap.element_type' => 1,
            'LessonElementMap.deleted' => 0
          );
          $t=0;$c=0;$e=0;
          $lesson = $this->LessonElementMap->find("all",array("conditions"=>$condition));
          $cond = array(
            'LessonElementMap.lesson_id' => $lesson[0]['LessonElementMap']['lesson_id'],
            'LessonElementMap.deleted' => 0
          );
          $lesson = $this->LessonElementMap->find("all",array("conditions"=>$cond));
          foreach($lesson as $less){
             if($less['LessonElementMap']['element_type'] == 1){
               $test = $this->Test->findById($less['LessonElementMap']['element_id']);
                if($test['Test']['questions'] != ""){
               $lessons['elements']['test'][$t] = $test;
                $con = array(
                   'StudentTestAttempt.test_id' => $less['LessonElementMap']['element_id'],
                   'StudentTestAttempt.student_id'=> $student_id,
                   'StudentTestAttempt.deleted' => 0
                  );
                 $student_test_attempt = $this->StudentTestAttempt->find("all",array('conditions'=>$con));
                 if(!empty($student_test_attempt))
               $lessons['elements']['test'][$t]['Test']['status'] = $student_test_attempt[0]['StudentTestAttempt']['status'];
                 $t++;
             }
             }
             else if($less['LessonElementMap']['element_type'] == 2){
               $concept = $this->Concept->findById($less['LessonElementMap']['element_id']);
               if($concept['Concept']['slides'] != ""){
               $lessons['elements']['concept'][$c] = $concept;
                $con = array(
                   'StudentConceptAttempt.element_id' => $less['LessonElementMap']['element_id'],
                   'StudentConceptAttempt.student_id'=> $student_id,
                   'StudentConceptAttempt.deleted' => 0
                  );
                 $student_concept_attempt = $this->StudentConceptAttempt->find("all",array('conditions'=>$con));
                 
               $lessons['elements']['concept'][$c]['Concept']['status'] = $student_concept_attempt[0]['StudentConceptAttempt']['status'];

               $c++;
              }
             }
             else if($less['LessonElementMap']['element_type'] == 3){
              $exercise = $this->Exercise->findById($less['LessonElementMap']['element_id']);
               if($exercise['Exercise']['slides'] != ""){
               $lessons['elements']['exercise'][$e] = $exercise;
                $con = array(
                   'StudentExerciseAttempt.element_id' => $less['LessonElementMap']['element_id'],
                   'StudentExerciseAttempt.student_id'=> $student_id,
                   'StudentExerciseAttempt.deleted' => 0
                  );
                 $student_exercise_attempt = $this->StudentExerciseAttempt->find("all",array('conditions'=>$con));
               $lessons['elements']['exercise'][$e]['Exercise']['status'] = $student_exercise_attempt[0]['StudentExerciseAttempt']['status'];
               $e++;
             }}
          }
          $this->set("json",json_encode($lessons));
    }
}
