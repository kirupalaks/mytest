<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class ExerciseController extends AppController{
    
    public $name = "Exercise";
    public $uses = array("Exercise","Slide",'Question','StudentActivity','Test','Concept', 'Element', 'Lesson',
      'StudentExerciseAttempt','LessonElementMap','StudentConceptAttempt','StudentTestAttempt',
      'StudentLessonSkip','StudentLessonMap','CourseLessonMap','StudentSkipLessons','Course');
    
    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow("student_view","getelements","sdata_view");
    }

    public function index(){
        $this->layout = "ahaguru";
    }
    
    public function allconcepts(){
        $this->layout ="default";
        $this->set("json", json_encode($this->Exercise->find('all')));
    }

    public function adata_delete($conceptid) {
      if($this->Exercise->setDelete($conceptid))
	$this->set("stat", json_encode( array( "message" => "deleted") ));
      else 
	$this->set("stat", json_encode( array("message" => "error") ));
    }

    public function adata_slide($id) {

	$result;

	$data = $this->request->data; 
	if($data['slide_type'] == 1) {
	    $result = $this->uploadFiles("content", $this->data['File']);
	}
	
	if($data['slide_type'] == 5) {
	    $this->Question->save($data['question']);
	    $data['content'] = $this->Question->id;
	}

	if(empty($result) 
	   || (!empty($result) 
	       && !array_key_exists("errors", $result))
	   || (!empty($result) 
	       && !array_key_exists("nofiles", $result))) {

	   if(!empty($result) && !array_key_exists("nofiles", $result) && $data['slide_type'] != 5) {
		$data['content'] = $data['File']['content']['name'];
	   }
	    $this->Slide->save($data);
	    $slideid = $this->Slide->id;

	    $Exercise = $this->Exercise->findById($id);
	    $cdata = array();
	    $cdata['slides'] = $Exercise['Exercise']['slides'];
	    $cdata['slides'] = empty($cdata['slides']) 
				 ? $slideid 
				 : $cdata['slides'].",".$slideid;

	    $this->Exercise->id = $id;


	    $this->Exercise->save($cdata);
         $this->StudentExerciseAttempt->updateAll(array('slide_modified'=>1),
            array('StudentExerciseAttempt.element_id'=>$id));
}
	$this->redirect("/admin/Exercise/edit/$id");
     
	 }

    public function admin_practicetest($id) {
	$this->layout = "ahaguru_math";
    }

    public function adata_remove_slide() {
	$data = $this->request->data;
	$Exercise = $this->Exercise->findById($data['exerid']);
	$slides = explode(",",$Exercise['Exercise']['slides']);
	foreach($slides as $key => $value) {
	    if($value == $data['slideid']) {
		unset($slides[$key]);
	    }
	}
	$Exercise['Exercise']['slides'] = implode(",",$slides);
	$this->Exercise->id = $data['exerid'];
	$this->Exercise->save($Exercise['Exercise']);
	$this->set("json", json_encode(array("message" => "success")));
    }

    public function adata_edit_slide() {
	$result;

	$data = $this->request->data;
  	if($data['slide_type'] == 1) {
	    $result = $this->uploadFiles("content", $this->data['File']);
	}

	if($data['slide_type'] == 5) {
	    $this->Question->id = $data['question_id'];
	    $this->Question->save($data['question']);
	    $data['content'] = $this->Question->id;
	}

	if(empty($result) 
	   || (!empty($result) 
	       && !array_key_exists("errors", $result))
	   || (!empty($result) 
	       && !array_key_exists("nofiles", $result))) {

	    if(!empty($result) && !array_key_exists("nofiles", $result) && $data['slide_type'] != 5)
	    $data['content'] = $data['File']['content']['name'];
	    $this->Slide->id = $data['slide_id'];
	    $this->Slide->save($data);
		}

	if(!isset($data['practice']))
	$this->redirect("/admin/Exercise/edit/".$data['exercise_id']);
	else 
	$this->redirect("/admin/practicetest/".$data['exercise_id']);

    }

    public function adata_view($id) {
	$Exercise = $this->Exercise->findById($id);
	$slideids = explode(",",$Exercise['Exercise']['slides']);
	$Exercise['slide'] = array();
	foreach($slideids as $key => $slide) {
	    $Exercise['slide'][$key] = $this->Slide->findById($slide);

	    if($Exercise['slide'][$key]['Slide']['slide_type'] == 5) {
		$Exercise['slide'][$key]['Slide']['content'] =
		    $this
		    ->Question
		    ->findById($Exercise['slide'][$key]['Slide']['content']);
	    }

	}
   $lesson = $this->LessonElementMap->find('first',array('conditions' => array(
         'LessonElementMap.element_id' => $id,
         'LessonElementMap.element_type'=>3,
         'LessonElementMap.deleted'=>0)));
      $Exercise['lesson'] = $this->Lesson->findById($lesson['LessonElementMap']['lesson_id']); 
      $course = $this->CourseLessonMap->find('first',array('conditions' => array(
         'CourseLessonMap.lesson_id' => $lesson['LessonElementMap']['lesson_id'],
           'CourseLessonMap.deleted'=>0)));
        $Exercise['course'] = $this->Course->findById($course['CourseLessonMap']['course_id']);
	$this->set("json", json_encode($Exercise));
    }

  public function allslides($id){
        $this->layout ="default";
        $slide = array();
        $slides = $this->Exercise->findById($id);
        $slides = $slides['Exercise']['slides'];
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
          $this->redirect("/student/Exercise/0");
    }



  public function student_view($id) {
	$this->layout = "ahaguru_math_nonav";
        $user = $this->Auth->user();
          $studentid = $user['Student']['id'];

   
    }

    public function sdata_view($id) 
    {
         $this->layout = "default";
         if($this->Auth->user()){
         $user = $this->Auth->user();
         $studentid = $user['Student']['id'];
    
         $attempts=$this->StudentExerciseAttempt->query("select * from student_exercise_attempt where element_id = $id and student_id = $studentid and deleted=0");
                         
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
       $skip_modules = $this->StudentSkipLessons->getSkipLessons($studentid, $exercise['course']['id']);
       $skip_lesson = explode(",", $skip_modules);

       if(in_array($exercise['lesson']['id'], $skip_lesson) || $exercise['course']['course_type'] == 2){

               $exercise['lesson']['skip'] = 1;
           }
         $exercise['attempts'] = count($attempts);
      
         $this->set("json", json_encode($exercise));

    }else{
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
        
            $exercise['status'] = 0;
            $exercise['last_visited'] = 1;
        $exercise['lesson'] = $this->Element->module($id, $type);
         $exercise['course'] = $this->Lesson->getcourse($exercise['lesson']['id']);
            $modules = $this->CourseLessonMap->find('all', array('conditions' => array(
          'CourseLessonMap.course_id =' => $exercise['course']['id'],
          'CourseLessonMap.deleted !=' => 1,
            )));
                 $exercise['lesson']['skip'] = 1;
              
         $this->set("json", json_encode($exercise));
    
    }

     }
   
     public function attempt() {
         $data = $this->request->data;
    $user = $this->Auth->user();
    $this->layout = "default";
     $data['student_id'] = $user['Student']['id'];
         	$str = "select * from student_exercise_attempt where student_id=".$data['student_id']." and deleted = 0 and element_id = ".$data['element_id'];
    	     $attempts = $this->StudentExerciseAttempt->query($str) ;
       
    if($attempts == null) {
      $data['attempt'] = 1;
    }
    else if($attempts[count($attempts) - 1]['student_exercise_attempt']['attempt'] == 1 && 
      $attempts[count($attempts) - 1]['student_exercise_attempt']['status'] == 2 &&
      $attempts[count($attempts) - 1]['student_exercise_attempt']['slide_modified'] == 0) {

      $data['attempt'] = 2;
    }
    else {
      $data['id'] = $attempts[count($attempts) - 1]['student_exercise_attempt']['id'];
      $data['attempt'] = $attempts[count($attempts) - 1]['student_exercise_attempt']['attempt'];
    }

    if(!array_key_exists("stat", $data)) {
      $data['id'] = $attempts[count($attempts) - 1]['student_exercise_attempt']['id'];
      $data['status'] = 2;
    }
    else {
      $data['status'] = $data['stat'];
              }
    $this->set("json",json_encode($attempts));

    
    if($data['attempt'] != 2 || $attempts[count($attempts) - 1]['student_exercise_attempt']['slide_modified'] != 0){
    //$data['answers']=$attempts[0]['student_exercise_attempt']['answers'].$data['answers'];
      $this->StudentExerciseAttempt->save($data);                         
        $marker['element_id'] = $data['element_id'];
          $marker['student_id'] = $data['student_id'];
          $marker['slide_id'] = $data['slide_id'];
          $lesson_id = $this->LessonElementMap->find("first",array("conditions" => 
            array('LessonElementMap.element_id' => $data['element_id'],
                     'LessonElementMap.element_type'=>3,
                     'LessonElementMap.deleted' =>0
            )));
          $marker['lesson_id']=$lesson_id['LessonElementMap']['lesson_id'];
          $course_ids = $this->CourseLessonMap->find("first",array("conditions" => 
            array('CourseLessonMap.lesson_id' => $lesson_id['LessonElementMap']['lesson_id'],
                     'CourseLessonMap.deleted' =>0
            )));
           $marker['course_id']=$course_id['CourseLessonMap']['course_id'];
             $marker['position'] = $course_id['CourseLessonMap']['srno'];
           $mapping = $this->StudentLessonMap->find("first",array("conditions"=> 
            array('StudentLessonMap.course_id' =>$course_id['CourseLessonMap']['course_id'],
                    'StudentLessonMap.deleted' =>0
            )));

           if(empty($mapping))
          $this->StudentLessonMap->save($marker);
           else
            $this->StudentLessonMap->updatemarker($marker);
          }
	if($data['status'] == 1) {
         $this->StudentActivity->addOrUpdate(
          $this->StudentActivity->ACTIVITY_TYPES['EXERCISE'], 
        $data['element_id'],
        $this->StudentActivity->ACTIVITY_STATUS['IN PROGRESS'],
        "0"); 
       } 
      else {
    $this->StudentActivity->addOrUpdate(
          $this->StudentActivity->ACTIVITY_TYPES['EXERCISE'], 
        $data['element_id'],
        $this->StudentActivity->ACTIVITY_STATUS['FINISHED'],
        "0"); 
          }
       return $que;
  }
  

 public function adata_order($id){
    $data = $this->request->data;
        if(isset($data['slides'])){
       $this->Exercise->query("update exercise set slides = '".$data['slides']."' where id = $id;");
                   $this->set("json",json_encode(array("message" => "success")));
          $this->StudentExerciseAttempt->updateAll(array('slide_modified'=>1,'last_visited'=>1),
            array('StudentExerciseAttempt.element_id'=>$id));
        }
  }    
 
  public function getelements($exeid){
        $this->layout = "default";
        $user = $this->Auth->user();
              $student_id = $user['Student']['id'];
       $condition = array(
       'LessonElementMap.element_id' => $exeid,
        'LessonElementMap.element_type' => 3,
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
                 
               $lessons['elements']['test'][$t]['Test']['status'] = $student_test_attempt[0]['StudentTestAttempt']['status'];
                 $t++;
             }}
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
         $c++;}}
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
         $e++;}}
     
         }
         $this->set("json",json_encode($lessons));
  }


}
?>
