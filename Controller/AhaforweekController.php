<?php

class AhaforweekController extends AppController {

    public $name = "Ahaforweek";

    public $uses = array('Lesson','Course','Element','Exercise','StudentConceptAttempt','StudentExerciseAttempt','StudentTestAttempt',
      'LessonElementMap','Test','LessonType','CourseLessonMap','Concept','Student','Question','StudentActivity','Slide');

    public function beforeFilter() {
  parent::beforeFilter();
    }

// /*ahaforweek lesson*/
// public function student_view($lessonid) {
//    $this->layout = "ahaguru";
//     // $lesson = $this->Lesson->findById($lessonid);
//     // $data = array();
//     // $user = $this->Auth->user("Student");
//     // $studentid = $user['id'];    
//     // $courseid = $this->Lesson->moduleCourse($lessonid);   
//     //   $lesson = array();
//     //   $lesson = $this->Course->findById("43");
//     //   $mod= $this->Course->getAhaLessons($courseid);
//     //   $lesson['lesson'] = $this->Lesson->findById($lessonid);
//     //   for($i = 0; $i < count($mod);$i++)
//     //   {
//     //     if($mod[$i]['Lesson']['id'] == $lessonid)
//     //     { 
//     //       $lesson['lesson']['moduleno']= $i;
//     //     }
//     //   }
//     //   $lesson['elements'] = $this->Lesson->getAllElements($lessonid);     
//     //     $concept_completed = 0;$exercise_completed =0;$test_completed = 0;       
//     //     if(!empty($lesson['elements']['concept'])){
             
//     //            foreach ($lesson['elements']['concept'] as $concept) {
//     //                  if($concept['status'] == 2 ){
//     //                       $concept_completed++;
//     //              }
//     //              else{                   
//     //                $this->redirect("/student/ahaforweek/concept_view/".$concept['details']['Concept']['id']);  
//     //              }
//     //            }
//     //          }
//     //          if(!empty($lesson['elements']['exercise']) && $concept_completed == count($lesson['elements']['concept'])){
                       
//     //            foreach ($lesson['elements']['exercise'] as $exercise) {

//     //                  if($exercise['status'] == 2){
//     //                               $exercise_completed++;  
//     //              }
//     //              else{
                                     
//     //                $this->redirect("/student/ahaforweek/exercise_view/".$exercise['details']['Exercise']['id']);                    
//     //              }
//     //            }
//     //          }
//     //           if(!empty($lesson['elements']['test']) && ($concept_completed + $exercise_completed) == (count($lesson['elements']['concept']) + count($lesson['elements']['exercise'])))
//     //          {
             
//     //            foreach ($lesson['elements']['test'] as $test) {
//     //                  if($test['status'] == 2){
//     //                       $test_completed ++;
//     //              }
//     //              else{
//     //                 $this->redirect("/student/ahaforweek/taketest_view/".$test['details']['Test']['id']);                    
//     //              }
            
//     //            }
//     //          }

//     //          if(($concept_completed + $exercise_completed + $test_completed) == (count($lesson['elements']['concept']) + count($lesson['elements']['exercise'])+count($lesson['elements']['test']))){
//     //          if(!empty($lesson['elements']['concept']))              
//     //          $this->redirect("/student/ahaforweek/concept_view/".$lesson['elements']['concept'][0]['details']['Concept']['id']);  
//     //          else if(!empty($lesson['elements']['exercise']))              
//     //           $this->redirect("/student/ahaforweek/exercise_view/".$lesson['elements']['exercise'][0]['details']['Exercise']['id']);  
//     //           else if(!empty($lesson['elements']['test']))                
//     //           $this->redirect("/student/ahaforweek/taketest_view/".$lesson['elements']['test'][0]['details']['Test']['id']);    
//     //          }
//   }
  
// public function sdata_view($lessonid) {
//     $this->layout ="default";
//     $lesson = $this->Lesson->findById($lessonid);
//     $data = array();
//     $user = $this->Auth->user("Student");
//     $studentid = $user['id'];    
//     $courseid = $this->Lesson->moduleCourse($lessonid);   
//       $lesson = array();
//       $lesson = $this->Course->findById("43");
//       $mod= $this->Course->getAhaLessons($courseid);
//       $lesson['lesson'] = $this->Lesson->findById($lessonid);
//       for($i = 0; $i < count($mod);$i++)
//       {
//         if($mod[$i]['Lesson']['id'] == $lessonid)
//         { 
//           $lesson['lesson']['moduleno']= $i;
//         }
//       }
//       $lesson['elements'] = $this->Lesson->getAllElements($lessonid);     
//         $concept_completed = 0;$exercise_completed =0;$test_completed = 0;       
//         if(!empty($lesson['elements']['concept'])){
             
//                foreach ($lesson['elements']['concept'] as $concept) {
//                      if($concept['status'] == 2 ){
//                           $concept_completed++;
//                  }
//                  else{
//                       $lesson_redirect = array("redirect" =>"concept","id"=> $concept['details']['Concept']['id']);               
//                    // $this->redirect("/student/concept/".$concept['details']['Concept']['id']);  
//                  }
//                }
//              }
//              if(!empty($lesson['elements']['exercise']) && $concept_completed == count($lesson['elements']['concept'])){
                       
//                foreach ($lesson['elements']['exercise'] as $exercise) {

//                      if($exercise['status'] == 2){
//                                   $exercise_completed++;  
//                  }
//                  else{
                                     
//                    // $this->redirect("/student/exercise/".$exercise['details']['Exercise']['id']);  
//                   $lesson_redirect = array("redirect" =>"exercise","id"=> $exercise['details']['Exercise']['id']);
//                  }
//                }
//              }
//               if(!empty($lesson['elements']['test']) && ($concept_completed + $exercise_completed) == (count($lesson['elements']['concept']) + count($lesson['elements']['exercise'])))
//              {
             
//                foreach ($lesson['elements']['test'] as $test) {
//                      if($test['status'] == 2){
//                           $test_completed ++;
//                  }
//                  else{
                                     
//                    // $this->redirect("/student/taketest/".$test['details']['Test']['id']);  
//                   $lesson_redirect = array("redirect" =>"taketest","id"=> $test['details']['Test']['id']);
//                  }
            
//                }
//              }

//              if(($concept_completed + $exercise_completed + $test_completed) == (count($lesson['elements']['concept']) + count($lesson['elements']['exercise'])+count($lesson['elements']['test']))){
//              if(!empty($lesson['elements']['concept'])) 
//               $lesson_redirect = array("redirect" =>"concept","id"=> $lesson['elements']['concept'][0]['details']['Concept']['id']);                            
//              else if(!empty($lesson['elements']['exercise']))
//               $lesson_redirect = array("redirect" =>"exercise","id"=> $lesson['elements']['exercise'][0]['details']['Exercise']['id']);                             
//               else if(!empty($lesson['elements']['test']))
//                 $lesson_redirect = array("redirect" =>"taketest","id"=> $lesson['elements']['test'][0]['details']['Test']['id']);                             
//              }
//       $this->set("json", json_encode($lesson_redirect));
//   }    

  public function student_concept_view($id) {
     $this->layout = "ahaguru_math_nonav";
        $user = $this->Auth->user();
        $studentid = $user['Student']['id'];
  }
  public function student_exercise_view($id) {
    $this->layout = "ahaguru_math_nonav";
        $user = $this->Auth->user();
          $studentid = $user['Student']['id'];
  }
  public function student_taketest_view($testid) {
     $this->layout = "ahaguru_math_nonav";  
    $user = $this->Auth->user();
  }
  public function sdata_concept_view($id) {
     $this->layout = "default";           
       $user = $this->Auth->user();
       $studentid = $user['Student']['id'];

       $attempts=$this->StudentConceptAttempt->query("select * from student_concept_attempt where element_id = $id and
                                                     student_id = $studentid "); 
       $con  =array(
        'LessonElementMap.element_id' =>$id,
       'LessonElementMap.element_type' => 2
           );
         $lesson = $this->LessonElementMap->find("all",array('conditions' => $con));
       $type = 2;
       if(count($attempts) == 0){
         $concept = $this->Concept->findById($id);
         $elements= $this->LessonElementMap->query("select * from lesson_element_map where element_id = $id and element_type = 3;");
         $slideids = explode(",",$concept['Concept']['slides']);
         $concept['slide'] = array();
         $type = 2;
         foreach($slideids as $key => $slide){
           $concept['slide'][$key] = $this->Slide->findById($slide);
           if($concept['slide'][$key]['Slide']['slide_type'] == 5){
                $concept['slide'][$key]['Slide']['content'] =
                $this->Question->findById($concept['slide'][$key]['Slide']['content']);
           }
         }
         if($elements[0]['lesson_element_map']['element_type'] == 2){
          $this->StudentActivity->addOrUpdate(
             $this->StudentActivity->ACTIVITY_TYPES['CONCEPT'],$id,$this->StudentActivity->ACTIVITY_STATUS['STARTED'],"SLIDE:0");
         }
         $concept['status'] = 0;
         $concept['last_visited'] = 1;
         $this->StudentActivity->addOrUpdate($this->StudentActivity->ACTIVITY_TYPES['CONCEPT'],$id,
                                              $this->StudentActivity->ACTIVITY_STATUS['STARTED'],"0");
       }
       if(count($attempts) == 1 && $attempts[0]['student_concept_attempt']['status'] == 1) {
            $concept = $this->Concept->findById($id);
            $elements= $this->LessonElementMap->query("select * from lesson_element_map where element_id = $id and element_type = 3;");
            $slideids = explode(",",$concept['Concept']['slides']);
            $concept['last_visited'] = $attempts[0]['student_concept_attempt']['last_visited'];
            $concept['slide'] = array();
            $type = 2;
            foreach($slideids as $key => $slide){
                $concept['slide'][$key] = $this->Slide->findById($slide);
                if($concept['slide'][$key]['Slide']['slide_type'] == 5){
                      $concept['slide'][$key]['Slide']['content'] =$this->Question->findById($concept['slide'][$key]['Slide']['content']);
                }
            }
            $concept['status'] = $attempts[0]['student_concept_attempt']['status'];    
            $concept['answers'] = $attempts[0]['student_concept_attempt']['answers']; 
            $concept['last_visited'] = $attempts[0]['student_concept_attempt']['last_visited']; 
            $concept['slide_modified'] = $attempts[0]['student_concept_attempt']['slide_modified']; 
       }
       if(count($attempts) == 1 && $attempts[0]['student_concept_attempt']['status'] == 2){ 
             $concept = $this->Concept->findById($id);
             $concept['status'] = $attempts[0]['student_concept_attempt']['status'];
             $concept['last_visited'] = $attempts[0]['student_concept_attempt']['last_visited'];
             $concept['answers'] = $attempts[0]['student_concept_attempt']['answers'];
            $concept['slide_modified'] = $attempts[0]['student_concept_attempt']['slide_modified']; 
             $answers=explode("##",$concept['answers']);
             $question_ids = explode("@",$concept['answers']);
             $questions = array();
             for($j = 0; $j < count($question_ids) - 1; $j++) {
               $questions[$j] = $question_ids[$j];
               if($j != 0) {
                 $question_ids[$j] = explode("##", $question_ids[$j]);
                 $question_ids[$j] = isset($question_ids[$j][1]) == 1 ? $question_ids[$j][1] : 0;
               }
               $questions[$j] = $question_ids[$j];
             }
             $elements= $this->LessonElementMap->query("select * from lesson_element_map where element_id = $id and element_type = 3;");
             $slideids = explode(",",$concept['Concept']['slides']);
             $concept['slide'] = array();
             $type = 2;
             foreach($slideids as $key => $slide){
               $concept['slide'][$key] = $this->Slide->findById($slide);
               if($concept['slide'][$key]['Slide']['slide_type'] == 5){
                  $concept['slide'][$key]['Slide']['content'] =
                  $this->Question->findById($concept['slide'][$key]['Slide']['content']);
               }
             }
       }
       $concept['lesson'] = $this->Element->module($id, $type);
       $concept['course'] = $this->Lesson->getcourse($concept['lesson']['id']);
              $modules = $this->CourseLessonMap->find('all', array('conditions' => array(
          'CourseLessonMap.course_id =' => $concept['course']['id'],
          'CourseLessonMap.deleted !=' => 1,
            )));
                $concept['lesson']['skip'] = 1;
                  $lesson = $this->Lesson->find("first",array('conditions' => 
                array('Lesson.id' => $lesson[0]['LessonElementMap']['lesson_id'],
                       'Lesson.start_date <=' => date("Y-m-d", strtotime(date("Y-m-d")." +1 day")),
                      'Lesson.end_date >'=> date("Y-m-d", strtotime(date("Y-m-d"))),
                'Lesson.deleted' => 0)));       
           if(!empty($lesson))
            $concept['lesson']['thisweek'] = 1;        
          else
            $concept['lesson']['thisweek'] = 0; 
       
      $concept['attempts'] = count($attempts);
       $this->set("json", json_encode($concept));
  
    }  
  public function sdata_exercise_view($id) {
        $this->layout = "default";         
         $user = $this->Auth->user();
         $studentid = $user['Student']['id'];
    
         $attempts=$this->StudentExerciseAttempt->query("select * from student_exercise_attempt where element_id = $id and student_id = $studentid and deleted=0");
                 
		$con  =array(
			'LessonElementMap.element_id' =>$id,
		       'LessonElementMap.element_type' => 3
			   );
         $lesson = $this->LessonElementMap->find("all",array('conditions' => $con));
         if(count($attempts) == 0) 
         {
           $exercise = $this->Exercise->findById($id);
           $elements= $this->LessonElementMap->query("select * from lesson_element_map where element_id = $id and element_type = 3;");
           $slideids = explode(",",$exercise['Exercise']['slides']);
           $exercise['slide'] = array();
           $type = 3;
           foreach($slideids as $key => $slide)
           {
              $exercise['slide'][$key] = $this->Slide->findById($slide);
              if($exercise['slide'][$key]['Slide']['slide_type'] == 5) 
              {
                $exercise['slide'][$key]['Slide']['content'] =
                $this->Question->findById($exercise['slide'][$key]['Slide']['content']);
              }
           }
           if($elements[0]['lesson_element_map']['element_type'] == 3)
           {
             $this->StudentActivity->addOrUpdate(
             $this->StudentActivity->ACTIVITY_TYPES['EXERCISE'],$id,$this->StudentActivity->ACTIVITY_STATUS['STARTED'],"SLIDE:0");
           }
            $exercise['status'] = 0;
            $exercise['last_visited'] = 1;
            $this->StudentActivity->addOrUpdate($this->StudentActivity->ACTIVITY_TYPES['EXERCISE'],$id,$this->StudentActivity->ACTIVITY_STATUS['STARTED'],"0");
         }
           if(count($attempts) == 1 && $attempts[0]['student_exercise_attempt']['status'] == 1) 
         {
            $exercise = $this->Exercise->findById($id);
            $elements= $this->LessonElementMap->query("select * from lesson_element_map where element_id = $id and element_type = 3;");
            $slideids = explode(",",$exercise['Exercise']['slides']);
            
            $exercise['slide'] = array();
            $type = 3;
            foreach($slideids as $key => $slide)
           {
              $exercise['slide'][$key] = $this->Slide->findById($slide);
              if($exercise['slide'][$key]['Slide']['slide_type'] == 5) 
             {
                $exercise['slide'][$key]['Slide']['content'] =
                $this->Question->findById($exercise['slide'][$key]['Slide']['content']);
             }
           }
            $exercise['status'] = $attempts[0]['student_exercise_attempt']['status'];
            $exercise['time'] = $attempts[0]['student_exercise_attempt']['duration'];
            $exercise['answers'] = $attempts[0]['student_exercise_attempt']['answers']; 
            $exercise['score'] = $attempts[0]['student_exercise_attempt']['score']; 
            $exercise['last_visited'] = $attempts[0]['student_exercise_attempt']['last_visited']; 
            $exercise['slide_modified'] = $attempts[0]['student_exercise_attempt']['slide_modified']; 
            $exercise['isMobileAttempt'] = $attempts[0]['student_exercise_attempt']['isMobileAttempt']; // add for Message in web
          }
          if(count($attempts) == 1 && $attempts[0]['student_exercise_attempt']['status'] == 2) 
         { 
                  $exercise = $this->Exercise->findById($id);
                  $exercise['score'] = $attempts[0]['student_exercise_attempt']['score'];
                  $exercise['status'] = $attempts[0]['student_exercise_attempt']['status'];
                  $exercise['time'] = $attempts[0]['student_exercise_attempt']['duration'];
                  $exercise['answers'] = $attempts[0]['student_exercise_attempt']['answers'];
                  $exercise['slide_modified'] = $attempts[0]['student_exercise_attempt']['slide_modified']; 
                  $exercise['last_visited'] = $attempts[0]['student_exercise_attempt']['last_visited']; 
				  $exercise['isMobileAttempt'] = $attempts[0]['student_exercise_attempt']['isMobileAttempt']; 
                  $answers=explode("##",$exercise['answers']);
                  $question_ids = explode("@",$exercise['answers']);
                  $questions = array();
                   for($j = 0; $j < count($question_ids) - 1; $j++) {
                   $questions[$j] = $question_ids[$j];
                  if($j != 0) {
                     $question_ids[$j] = explode("##", $question_ids[$j]);
                     $question_ids[$j] = isset($question_ids[$j][1]) == 1 ? $question_ids[$j][1] : 0;
                   }
                  $questions[$j] = $question_ids[$j];
                  }
                 $elements= $this->LessonElementMap->query("select * from lesson_element_map where element_id = $id and element_type = 3;");
                $slideids = explode(",",$exercise['Exercise']['slides']);
                $exercise['slide'] = array();
                $type = 3;
               foreach($slideids as $key => $slide)
             {
               $exercise['slide'][$key] = $this->Slide->findById($slide);
              if($exercise['slide'][$key]['Slide']['slide_type'] == 5) 
               {
                $exercise['slide'][$key]['Slide']['content'] =
                $this->Question->findById($exercise['slide'][$key]['Slide']['content']);
              }
            }
        }
     
         $exercise['lesson'] = $this->Element->module($id, $type);
         $exercise['course'] = $this->Lesson->getcourse($exercise['lesson']['id']);
            $modules = $this->CourseLessonMap->find('all', array('conditions' => array(
          'CourseLessonMap.course_id =' => $exercise['course']['id'],
          'CourseLessonMap.deleted !=' => 1,
            )));
              
               $exercise['lesson']['skip'] = 1;
                $lesson = $this->Lesson->find("first",array('conditions' => 
                array('Lesson.id' => $lesson[0]['LessonElementMap']['lesson_id'],
                       'Lesson.start_date <=' => date("Y-m-d", strtotime(date("Y-m-d")." +1 day")),
                      'Lesson.end_date >'=> date("Y-m-d", strtotime(date("Y-m-d"))),
                'Lesson.deleted' => 0)));       
           if(!empty($lesson))
            $exercise['lesson']['thisweek'] = 1;        
          else
            $exercise['lesson']['thisweek'] = 0; 
       
         $exercise['attempts'] = count($attempts);
      
         $this->set("json", json_encode($exercise));
   
  }
  public function sdata_taketest_view($testid) {
      $data = $this->request->data;
     $type = 1;
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
      $lessons = $this->Lesson->find("first",array('conditions' => 
                array('Lesson.id' => $lesson[0]['LessonElementMap']['lesson_id'],
                       'Lesson.start_date <=' => date("Y-m-d", strtotime(date("Y-m-d")." +1 day")),
                      'Lesson.end_date >'=> date("Y-m-d", strtotime(date("Y-m-d")." +1 day")),
                'Lesson.deleted' => 0)));  
      if(empty($lessons)){
      $test['score'] = $attempts[0]['student_test_attempt']['score'];
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
    }
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
          $test['lesson']['skip'] = 1;     
          error_log("sdds".print_r($lesson,true));
           $lessons = $this->Lesson->find("first",array('conditions' => 
                array('Lesson.id' => $lesson[0]['LessonElementMap']['lesson_id'],
                       'Lesson.start_date <=' => date("Y-m-d", strtotime(date("Y-m-d")." +1 day")),
                      'Lesson.end_date >'=> date("Y-m-d", strtotime(date("Y-m-d"))),
                'Lesson.deleted' => 0)));       
           if(!empty($lessons))
            $test['lesson']['thisweek'] = 1;        
          else
            $test['lesson']['thisweek'] = 0;        
      $this->set("json", json_encode($test));
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
}

