<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class ConceptController extends AppController{
    
    public $name = "Concept";
    public $uses = array("Concept","Slide",'Question', 'Element','StudentSkipLessons','CourseLessonMap','Course',
                      'StudentLessonMap','StudentActivity','Lesson','Test','Concept','Exercise','StudentTestAttempt',
                      'StudentConceptAttempt','LessonElementMap','StudentExerciseAttempt');
    
    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow("student_view","getelements","sdata_view");
    }

    public function index(){
        $this->layout = "ahaguru";
    }
    
    public function allconcepts(){
        $this->layout ="default";
        $this->set("json", json_encode($this->Concept->find('all')));
    }

    public function adata_delete($conceptid) {
        if($this->Concept->setDelete($conceptid))
	      $this->set("stat", json_encode( array( "message" => "deleted") ));
        else 
	      $this->set("stat", json_encode( array("message" => "error") ));
    }

    public function adata_slide($id) {
	     $result;
	     $data = $this->request->data;
      $data['File']['content']['name'] = str_replace(' ', '_', $data['File']['content']['name']);
  	     if($data['slide_type'] == 1) {
	         $result = $this->uploadFiles("content", $this->data['File']);
	     }
       if($data['slide_type'] == 6 || $data['slide_type'] == 7) {
           $result = $this->uploadFiles("content", $this->data['File']);
       }
	     if($data['slide_type'] == 5) {
	         $this->Question->save($data['question']);
	         $data['content'] = $this->Question->id;
	     }
       if(empty($result) || (!empty($result) && !array_key_exists("errors", $result)) || (!empty($result) 
                && !array_key_exists("nofiles", $result))) {
	         if(!empty($result) && !array_key_exists("nofiles", $result) && $data['slide_type'] != 5) {
 		            $data['content'] = $data['File']['content']['name'];
	         }
            $this->Slide->save($data);
	         $slideid = $this->Slide->id;
           $concept = $this->Concept->findById($id);
	         $cdata = array();
	         $cdata['slides'] = $concept['Concept']['slides'];
	         $cdata['slides'] = empty($cdata['slides']) ? $slideid : $cdata['slides'].",".$slideid;
           $this->Concept->id = $id;
           $this->Concept->save($cdata);
           $this->StudentConceptAttempt->updateAll(array('slide_modified'=>1),
            array('StudentConceptAttempt.element_id'=>$id));
       }
       if(!isset($data['practice']))
	        $this->redirect("/admin/concept/edit/$id");
	     else 
	        $this->redirect("/admin/practicetest/$id");
    }

    public function admin_practicetest($id) {
	     $this->layout = "ahaguru_math";
    }

    public function adata_remove_slide() {
       $data = $this->request->data;
	     $concept = $this->Concept->findById($data['conceptid']);
	     $slides = explode(",",$concept['Concept']['slides']);
	     foreach($slides as $key => $value) {
	          if($value == $data['slideid']) {
		        unset($slides[$key]);
	          }
	     }
	     $concept['Concept']['slides'] = implode(",",$slides);
	     $this->Concept->id = $data['conceptid'];
	     $this->Concept->save($concept['Concept']);
	     $this->set("json", json_encode(array("message" => "success")));
    }

    public function adata_edit_slide() {
	     $result;
	     $data = $this->request->data;
	     if($data['slide_type'] == 1) {
	        $result = $this->uploadFiles("content", $this->data['File']);
       	}
        if($data['slide_type'] == 6 || $data['slide_type'] == 7) {
          $result = $this->uploadFiles("content", $this->data['File']);
        }
	     if($data['slide_type'] == 5) {
	          $this->Question->id = $data['question_id'];
	          $this->Question->save($data['question']);
	          $data['content'] = $this->Question->id;
	      }
	      if(empty($result) || (!empty($result) && !array_key_exists("errors", $result)) || (!empty($result) 
	              && !array_key_exists("nofiles", $result))) {
	        if(!empty($result) && !array_key_exists("nofiles", $result) && $data['slide_type'] != 5)
         	    $data['content'] = $data['File']['content']['name'];
	            $this->Slide->id = $data['slide_id'];
	            $this->Slide->save($data);
        }
	      if(!isset($data['practice']))
           $this->redirect("/admin/concept/edit/".$data['concept_id']);
	      else 
	         $this->redirect("/admin/practicetest/".$data['concept_id']);
    }

    public function adata_view($id) {
	    $concept = $this->Concept->findById($id);
	    $slideids = explode(",",$concept['Concept']['slides']);
	    $concept['slide'] = array();
	    foreach($slideids as $key => $slide) {
	       $concept['slide'][$key] = $this->Slide->findById($slide);
	       if($concept['slide'][$key]['Slide']['slide_type'] == 5) {
		       $concept['slide'][$key]['Slide']['content'] =
        	 $this->Question->findById($concept['slide'][$key]['Slide']['content']);
	       }
	    }
       $lesson = $this->LessonElementMap->find('first',array('conditions' => array(
         'LessonElementMap.element_id' => $id,
         'LessonElementMap.element_type'=>2,
         'LessonElementMap.deleted'=>0)));
      $concept['lesson'] = $this->Lesson->findById($lesson['LessonElementMap']['lesson_id']); 
      $course = $this->CourseLessonMap->find('first',array('conditions' => array(
         'CourseLessonMap.lesson_id' => $lesson['LessonElementMap']['lesson_id'],
           'CourseLessonMap.deleted'=>0)));
        $concept['course'] = $this->Course->findById($course['CourseLessonMap']['course_id']);
	    $this->set("json", json_encode($concept));
    }

    public function allslides($id){
        $this->layout ="default";
        $slide = array();
        $slides = $this->Concept->findById($id);
        $slides = $slides['Concept']['slides'];
        $slides = explode(",",$slides);
        for($i=0; $i < count($slides); $i++){
            $slide[$i] = $this->Slide->findById($slides[$i]);
        }
        $this->set("json",json_encode($slide));
    }

    public function admin_edit($id) {
       $this->layout = "ahaguru_math";
    }
  
    public function student_index() {
       $this->layout = "ahaguru_nonav";
       $user = $this->Auth->user("Student");
       $this->redirect("/student/concept/0");
    }
 
    public function student_view($id) {
	      $this->layout = "ahaguru_math_nonav";
        $user = $this->Auth->user();
        $studentid = $user['Student']['id'];
    }

    public function sdata_view($id) {
       $this->layout = "default";      
     if($this->Auth->user()) {
       $user = $this->Auth->user();
       $studentid = $user['Student']['id'];

       $attempts=$this->StudentConceptAttempt->query("select * from student_concept_attempt where element_id = $id and
                                                     student_id = $studentid "); 
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

        $skip_modules = $this->StudentSkipLessons->getSkipLessons($studentid,$concept['course']['id']);;
      $skip_lesson = explode(",", $skip_modules);
      if(in_array($concept['lesson']['id'], $skip_lesson) || $concept['course']['course_type'] == 2){

               $concept['lesson']['skip'] = 1;
           }

       $concept['attempts'] = count($attempts);
       $this->set("json", json_encode($concept));
    }else{
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
         $concept['status'] = 0;
         $concept['last_visited'] = 1;
      $concept['lesson'] = $this->Element->module($id, $type);
       $concept['course'] = $this->Lesson->getcourse($concept['lesson']['id']);
              $modules = $this->CourseLessonMap->find('all', array('conditions' => array(
          'CourseLessonMap.course_id =' => $concept['course']['id'],
          'CourseLessonMap.deleted !=' => 1,
            )));      
               $concept['lesson']['skip'] = 1;
       //$concept['attempts'] = 0;
       $this->set("json", json_encode($concept));
    }
  }
    
    
             
    public function adata_order($id){
       $data = $this->request->data;
       if(isset($data['slides'])){
          $this->Concept->query("update concepts set slides = '".$data['slides']."' where id = $id;");
          $this->set("json",json_encode(array("message" => "success")));
           $this->StudentConceptAttempt->updateAll(array('slide_modified'=>1,'last_visited'=>1),
            array('StudentConceptAttempt.element_id'=>$id));
       }
    }    

    public function attempt() {
  //  if($this->Auth->user()){
       $data = $this->request->data;
       $user = $this->Auth->user();
       $this->layout = "default";
       $data['student_id'] = $user['Student']['id'];
              $str = "select * from student_concept_attempt where student_id=".$data['student_id']." and deleted = 0 and
                element_id = ".$data['element_id'];
       $attempts = $this->StudentConceptAttempt->query($str) ;
       if($attempts == null) {
         $data['attempt'] = 1;
       }
       else if($attempts[count($attempts) - 1]['student_concept_attempt']['attempt'] == 1 && 
              $attempts[count($attempts) - 1]['student_concept_attempt']['status'] == 2 &&
              $attempts[count($attempts) - 1]['student_concept_attempt']['slide_modified'] == 0) { 
           $data['id'] = $attempts[count($attempts) - 1]['student_concept_attempt']['id'];
         $data['attempt'] = 2;
       }
       else {
         $data['id'] = $attempts[count($attempts) - 1]['student_concept_attempt']['id'];
         $data['attempt'] = $attempts[count($attempts) - 1]['student_concept_attempt']['attempt'];
         }
       if(!array_key_exists("stat", $data)) {
         $data['id'] = $attempts[count($attempts) - 1]['student_concept_attempt']['id'];
         $data['status'] = 2;
         }
       else {
         $data['status'] = $data['stat'];
       }
       $this->set("json",json_encode($attempts));
      if($data['attempt'] != 2 || $attempts[count($attempts) - 1]['student_concept_attempt']['slide_modified'] != 0){

          $this->StudentConceptAttempt->save($data);                         
          $marker['element_id'] = $data['element_id'];
          $marker['student_id'] = $data['student_id'];
          
          $marker['slide_id'] = $data['slide_id'];
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

       }
       if($data['status'] == 1) {
         $this->StudentActivity->addOrUpdate($this->StudentActivity->ACTIVITY_TYPES['CONCEPT'],$data['element_id'],
                   $this->StudentActivity->ACTIVITY_STATUS['IN PROGRESS'],"0"); 
       } 
       else {
         $this->StudentActivity->addOrUpdate($this->StudentActivity->ACTIVITY_TYPES['CONCEPT'],$data['element_id'],
         $this->StudentActivity->ACTIVITY_STATUS['FINISHED'],"0"); 
       }
       return $data;
    }

  
    public function getelements($cnptid){
          $this->layout = "default";          
           $user = $this->Auth->user();
              $student_id = $user['Student']['id'];

                $condition = array(
            'LessonElementMap.element_id' => $cnptid,
            'LessonElementMap.element_type' => 2,
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
                 if(!empty($student_test_attempt)){
               $lessons['elements']['test'][$t]['Test']['status'] = $student_test_attempt[0]['StudentTestAttempt']['status'];                 
             }
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
                 if(!empty($student_concept_attempt)){
               $lessons['elements']['concept'][$c]['Concept']['status'] = $student_concept_attempt[0]['StudentConceptAttempt']['status'];               
              }
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
                 if(!empty($student_exercise_attempt)){
               $lessons['elements']['exercise'][$e]['Exercise']['status'] = $student_exercise_attempt[0]['StudentExerciseAttempt']['status'];               
             }
             $e++;
           }}
          }          
          $this->set("json",json_encode($lessons));
    }
}
?>
