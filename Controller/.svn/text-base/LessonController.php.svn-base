<?php

class LessonController extends AppController {

    public $name = "Lesson";

    public $uses = array("Lesson","CourseModuleMap",'Course','StudentCourseMap','Module',
	'LessonElementMap','Test','LessonType','ModuleLessonMap','CourseLessonMap','Exercise',
	'Concept');

    public function beforeFilter() {
	parent::beforeFilter();
    }

      public function adata_types(){
  
   $types = $this->LessonType->find("all");   
     $this->set("json",json_encode($types));
   }
 
    public function admin_view($id) {
			$this->layout = "ahaguru";
    }

    public function adata_add() {
			$data = $this->request->data;
 			$date = date_create_from_format("m\/d\/Y", $this->data['start_date']);
			$data['start_date'] = date_format($date, 'Y-m-d H:i:s');
			$date = date_create_from_format("m\/d\/Y", $this->data['end_date']);
			$data['end_date'] = date_format($date, 'Y-m-d H:i:s');
			$moduleid = $this->Lesson->save($data);
       $lessonmap = $this->CourseLessonMap->query('select max(srno) from course_lesson_map where course_id = '.$data['courseid']. '  and deleted = 0 ;');
                             if($lessonmap[0][0]['max(srno)'] != 0){
                        $mapdata['srno'] = $lessonmap[0][0]['max(srno)'] + 1;
  }
                      	$mapdata['course_id'] = $data['courseid'];
			$mapdata['lesson_id'] = $this->Lesson->id;
			$mapdata['position'] = 0;
        $mapdata['lesson_type'] = $moduleid['Lesson']['type'];
			$this->CourseLessonMap->save($mapdata);
			$this->redirect("/admin/lesson/".$data['courseid']);
    }

   public function adata_order($id){
    $data = $this->request->data;
        if(isset($data['lesson_id'])){
          $lesson_id=explode(",",$data['lesson_id']);
          $srno=explode(",",$data['srno']);
                 for($i = 0; $i< count($lesson_id) ; $i++){
       $this->CourseLessonMap->query("update course_lesson_map set srno = ".$srno[$i]." where lesson_id = ".$lesson_id[$i]." and course_id = $id;");
                        }
                  $this->set("json",json_encode(array("message" => "success")));
    }}        

    public function adata_edit($id) {
	$data = $this->request->data;
        $date = date_create_from_format("m\/d\/Y", $this->data['start_date']);
	$data['start_date'] = date_format($date, 'Y-m-d H:i:s');
	$date = date_create_from_format("m\/d\/Y", $this->data['end_date']);
	$data['end_date'] = date_format($date, 'Y-m-d H:i:s');
	$coursemodulemap = $this->CourseLessonMap->find("first", array('conditions'=>array(
	  'CourseLessonMap.lesson_id =' => $id,
          'CourseLessonMap.course_id =' =>$data['courseid']
	)));
	$old_data = $this->Lesson->findById($id);
	if($old_data['Lesson']['published'] == 0 && $data['published'] == 1) {
	  $data['published_date'] = date('Y-m-d H:i:s');
 	  $coursemodulemap['CourseLessonMap']['published_date'] = $data['published_date'];
	} else if($old_data['Lesson']['published'] == 1 && $data['published'] == 0) {
	  $data['published_date'] = "0000-00-00 00:00:00";
	  $coursemodulemap['CourseLessonMap']['published_date'] = $data['published_date'];
	}

	$coursemodulemap['CourseLessonMap']['published'] = $data['published'];
     $coursemodulemap['CourseLessonMap']['lesson_type'] = $old_data['Lesson']['type'];
	$this->CourseLessonMap->save($coursemodulemap);

	$this->Lesson->id = $id;
	$courseid = $this->Lesson->save($data);

	$this->redirect("/admin/lesson/".$data['courseid']);
    }

     public function student_view($lessonid) {
	     $this->layout = "ahaguru";
       $lesson = $this->Lesson->findById($lessonid);
       $data = array();
       $user = $this->Auth->user("Student");
       $studentid = $user['id'];
       $courses = explode(",", $this->Course->getStudentCourse($studentid));
       $isMapped = $this->Lesson->isMapped($lessonid);
       $courseid = $this->Lesson->moduleCourse($lessonid);
       if($lesson['Lesson']['type'] == 1)
       {
          $isEligible = $this->Lesson->isLocked($user['id'],$courseid, $lessonid);
          
          if($isEligible == 0)
            $isEligible = true;
          else
            $isEligible = false;
          if($isMapped && $isEligible) 
          {
            $lesson = array();
            $lesson = $this->Course->findById($courseid);
            $mod= $this->Course->getAllLessons($courseid,$studentid);
            $lesson['lesson'] = $this->Lesson->findById($lessonid);
            for($i = 0; $i < count($mod);$i++)
            {
              if($mod[$i]['Lesson']['id'] == $lessonid)
               { 
                  $lesson['lesson']['moduleno']= $i;
                }
            }
            $lesson['elements'] = $this->Lesson->getAllElements($lessonid);

            $concept_completed = 0;$exercise_completed =0;$test_completed = 0;
            for($i=0;$i<count($courses);$i++)
            {
              $lesson['courses'][$i]=$this->Course->findById($courses[$i]);
            }
            $lesson['courseid'] = $courseid;

             if(!empty($lesson['elements']['concept'])){
             
               foreach ($lesson['elements']['concept'] as $concept) {
                     if($concept['status'] == 2 ){
                          $concept_completed++;
                 }
                 else{
                                     
                   $this->redirect("/student/concept/".$concept['details']['Concept']['id']);  
                 }
               }
             }
             if(!empty($lesson['elements']['exercise']) && $concept_completed == count($lesson['elements']['concept'])){
                       
               foreach ($lesson['elements']['exercise'] as $exercise) {

                     if($exercise['status'] == 2){
                                  $exercise_completed++;  
                 }
                 else{
                                     
                   $this->redirect("/student/exercise/".$exercise['details']['Exercise']['id']);  
                 }
               }
             }
              if(!empty($lesson['elements']['test']) && ($concept_completed + $exercise_completed) == (count($lesson['elements']['concept']) + count($lesson['elements']['exercise'])))
             {
             
               foreach ($lesson['elements']['test'] as $test) {
                     if($test['status'] == 2){
                          $test_completed ++;
                 }
                 else{
                                     
                   $this->redirect("/student/taketest/".$test['details']['Test']['id']);  
                 }
            
               }
             }

             if(($concept_completed + $exercise_completed + $test_completed) == (count($lesson['elements']['concept']) + count($lesson['elements']['exercise'])+count($lesson['elements']['test']))){
             if(!empty($lesson['elements']['concept'])) 
             $this->redirect("/student/concept/".$lesson['elements']['concept'][0]['details']['Concept']['id']);  
             else if(!empty($lesson['elements']['exercise']))
              $this->redirect("/student/exercise/".$lesson['elements']['exercise'][0]['details']['Exercise']['id']);  
              else if(!empty($lesson['elements']['test']))
              $this->redirect("/student/taketest/".$lesson['elements']['test'][0]['details']['Test']['id']);    
             }
          
          } 
          else if(!$isMapped) 
          { 
             $this->set("json", json_encode(array("message" => "notpaid")));
          } 
          else if(!$isEligible) 
          {
            $this->set("json", json_encode(array("message" => "noteligible")));
          }
        }
        else
        {
          if($isMapped)
          {
              $lesson = array();
              $lesson = $this->Course->findById($courseid);
              $mod= $this->Course->getAllLessons($courseid,$studentid);
              $lesson['lesson'] = $this->Lesson->findById($lessonid);
              for($i = 0; $i < count($mod);$i++) 
              {
                if($mod[$i]['Lesson']['id'] == $lessonid)
                {
                  $lesson['lesson']['moduleno']= $i;
                }
              }
              $lesson['elements'] = $this->Lesson->getAllElements($lessonid);
              $concept_completed = 0;$exercise_completed =0;$test_completed = 0;
            for($i=0;$i<count($courses);$i++)
            {
              $lesson['courses'][$i]=$this->Course->findById($courses[$i]);
            }
            $lesson['courseid'] = $courseid;

             if(!empty($lesson['elements']['concept'])){
             
               foreach ($lesson['elements']['concept'] as $concept) {
                     if($concept['status'] == 2){
                          $concept_completed++;
                 }
                 else{
                                     
                   $this->redirect("/student/concept/".$concept['details']['Concept']['id']);  
                 }
               }
             }
             if(!empty($lesson['elements']['exercise']) && $concept_completed == count($lesson['elements']['concept'])){
                       
               foreach ($lesson['elements']['exercise'] as $exercise) {

                     if($exercise['status'] == 2){
                                  $exercise_completed++;  
                 }
                 else{
                                     
                   $this->redirect("/student/exercise/".$exercise['details']['Exercise']['id']);  
                 }
               }
             }
              if(!empty($lesson['elements']['test']) && ($concept_completed + $exercise_completed) == (count($lesson['elements']['concept']) + count($lesson['elements']['exercise'])))
             {
             
               foreach ($lesson['elements']['test'] as $test) {
                     if($test['status'] == 2){
                          $test_completed ++;
                 }
                 else{
                                     
                   $this->redirect("/student/taketest/".$test['details']['Test']['id']);  
                 }
            
               }
             }

             if(($concept_completed + $exercise_completed + $test_completed) == (count($lesson['elements']['concept']) + count($lesson['elements']['exercise'])+count($lesson['elements']['test']))){
             $this->redirect("/student/concept/".$lesson['elements']['concept']['0']['details']['Concept']['id']);  

             }
          
             /* for($i=0;$i<count($courses);$i++){
                $lesson['courses'][$i]=$this->Course->findById($courses[$i]);
              }
              $lesson['courseid'] = $courseid;
              if(!empty($lesson['elements']['concept']))
              $this->redirect("/student/concept/".$lesson['elements']['concept'][0]['details']['Concept']['id']);
            else if(!empty($lesson['elements']['exercise']))
              $this->redirect("/student/exercise/".$lesson['elements']['exercise'][0]['details']['Exercise']['id']);
            else  if(!empty($lesson['elements']['test']))
              $this->redirect("/student/taketest/".$lesson['elements']['test'][0]['details']['Test']['id']);*/
          }
        }
    }

   public function sdata_view($lessonid) {
    $this->layout ="default";
    $lesson = $this->Lesson->findById($lessonid);
    $data = array();
		$user = $this->Auth->user("Student");
    $studentid = $user['id'];
    $courses = explode(",", $this->Course->getStudentCourse($studentid));
    $isMapped = $this->Lesson->isMapped($lessonid);
    $courseid = $this->Lesson->moduleCourse($lessonid);
    if($lesson['Lesson']['type'] == 1)
    {
		  $isEligible = $this->Lesson->isLocked($user['id'],$courseid, $lessonid);
      if($isEligible == 0)
        $isEligible = true;
      else
        $isEligible = false;
     	if($isMapped && $isEligible) 
      {
				$lesson = array();
        $lesson = $this->Course->findById($courseid);
        $mod= $this->Course->getAllLessons($courseid,$studentid);
     		$lesson['lesson'] = $this->Lesson->findById($lessonid);
        for($i = 0; $i < count($mod);$i++)
        {
          if($mod[$i]['Lesson']['id'] == $lessonid)
         { 
            $lesson['lesson']['moduleno']= $i;
          }
        }
       	$lesson['elements'] = $this->Lesson->getAllElements($lessonid);
        for($i=0;$i<count($courses);$i++)
        {
          $lesson['courses'][$i]=$this->Course->findById($courses[$i]);
        }
				$lesson['courseid'] = $courseid;
       	$this->set("json", json_encode($lesson));
     	}
      else if(!$isMapped) 
      {
				$this->set("json", json_encode(array("message" => "notpaid")));
			} 
      else if(!$isEligible) 
      {
				$this->set("json", json_encode(array("message" => "noteligible")));
		  }
    }
    else{
      if($isMapped)
      {
        $lesson = array();
                                        $lesson = $this->Course->findById($courseid);
                                   $mod= $this->Course->getAllLessons($courseid,$studentid);
                                   	$lesson['lesson'] = $this->Lesson->findById($lessonid);
                                  for($i = 0; $i < count($mod);$i++) 
                               {
                              if($mod[$i]['Lesson']['id'] == $lessonid)
                                {
                                      $lesson['lesson']['moduleno']= $i;
                                }
                               }
			       $lesson['elements'] = $this->Lesson->getAllElements($lessonid);
                      for($i=0;$i<count($courses);$i++){
                      $lesson['courses'][$i]=$this->Course->findById($courses[$i]);
                                    }
			         $lesson['courseid'] = $courseid;
                             	$this->set("json", json_encode($lesson));
                        }
          
                 }
          
                 
    }



    public function adata_view($id) {
      $this->layout = "default";
 	    $modules = $this->Lesson->findById($id);

       	$this->set("json", json_encode($modules));

    }

   public function adata_delete($lessonid) {
       $this->layout = "default";
    if($this->Lesson->setDelete($lessonid))
      $this->set("json", json_encode( array( "message" => "deleted") ));
    else 
      $this->set("json", json_encode( array("message" => "error") ));
  }

 public function adata_lesson($id) {
     $this->layout = "default";
    $conditions = array(
      'Lesson.deleted =' => 0
    );
     $course_modules = $this->CourseLessonMap->query("select * from course_lesson_map where course_id=$id and deleted =0 and srno!=0 order by srno ;");
     if(empty($course_modules)){
    $course_modules = $this->CourseLessonMap->query("select * from course_lesson_map where course_id=$id and deleted = 0 order by published_date;");}
    $modules = $this->Course->findById($id);
         $j = 0;
    for($i = 0; $i < count($course_modules); $i++) {
                $conditions['Lesson.id ='] = $course_modules[$i]['course_lesson_map']['lesson_id'];
      $mod = $this->Lesson->findById($course_modules[$i]['course_lesson_map']['lesson_id']);
       if(!empty($mod)){
	$modules['Lessons'][$j] = $mod;
	$j++;
      }
    }
       $this->set("json", json_encode($modules));
  }

  public function adata_mergecourse(){
    $data = $this->request->data;
    error_log("courseid".print_r($data,true));
  }

  public function admin_replicate_lesson(){
      $this->autoRender = false; 
    $data = $this->request->data;
    error_log("courseid".print_r($data,true));
    foreach ($data['lesson_ids'] as $lesson_id) {
      $mapdata = array();
      $lesson = array();$elements_id = array();
      $lesson = $this->Lesson->findById($lesson_id);
      //Save as new Lesson
      unset($lesson['Lesson']['id']);unset($lesson['Lesson']['created']);
      unset($lesson['Lesson']['modified']);      
      $lesson['Lesson']['start_date'] =  date('Y-m-d H:i:s');
      $lesson['Lesson']['end_date'] =  date('Y-m-d H:i:s');
      $lesson['Lesson']['published'] = 0;
      $this->Lesson->saveAll($lesson);       
      $newlesson = $this->Lesson->findById($this->Lesson->id);
      error_log("newless".print_r($newlesson,true));
      //save new course lesson map
      $lessonmap = $this->CourseLessonMap->query('select max(srno) from course_lesson_map where course_id = '.$data['to_course_id']. '  and deleted = 0 ;');
      if($lessonmap[0][0]['max(srno)'] != 0){
        $mapdata['srno'] = $lessonmap[0][0]['max(srno)'] + 1;
      }
      $mapdata['course_id'] = $data['to_course_id'];
      $mapdata['lesson_id'] = $newlesson['Lesson']['id'];
      $mapdata['position'] = 0;
      $mapdata['lesson_type'] = $newlesson['Lesson']['type'];
       error_log("newcrsmap".print_r($mapdata,true));
      $mapping = $this->CourseLessonMap->saveAll($mapdata);
     
      // get elements from lesson      
      $elements_id = $this->LessonElementMap->find("all",array('conditions'=>
        array('LessonElementMap.lesson_id' => $lesson_id,
          'LessonElementMap.deleted'=>0)));
      error_log("elements".print_r($elements_id,true));
      foreach ($elements_id as $eleid) {
        $newelementid = 0;
        error_log("element1".print_r($eleid,true));
        $concept = array();$exercise = array();$test = array();$elemapdata = array();
        if($eleid['LessonElementMap']['element_type'] == 2){
          $concept = $this->Concept->findById($eleid['LessonElementMap']['element_id']);      
      //Save as new element 
      unset($concept['Concept']['id']);unset($concept['Concept']['created']);
      unset($concept['Concept']['created_ts']);
      unset($concept['Concept']['modified']);unset($concept['Concept']['modified_ts']);           
      error_log("cnpt1".print_r($concept,true));
       $this->Concept->saveAll($concept);       
       $newelementid = $this->Concept->id;
       error_log("cnpt".print_r($newelementid,true));
      }
      else if($eleid['LessonElementMap']['element_type'] == 3){
      $exercise = $this->Exercise->findById($eleid['LessonElementMap']['element_id']);      
      //Save as new element 
      unset($exercise['Exercise']['id']);unset($exercise['Exercise']['created']);
      unset($exercise['Exercise']['created_ts']);
      unset($exercise['Exercise']['modified']);unset($concept['Exercise']['modified_ts']);           
      $this->Exercise->saveAll($exercise);       
      $newelementid = $this->Exercise->id;
      error_log("exe".print_r($newelementid,true));
      }
      else if($eleid['LessonElementMap']['element_type'] == 1){
          $test = $this->Test->findById($eleid['LessonElementMap']['element_id']);      
      //Save as new element 
      unset($test['Test']['id']);unset($test['Test']['created']);      
      unset($test['Test']['modified']);      
      $this->Test->saveAll($test);       
      $newelementid = $this->Test->id;
            }      
      //save new element lesson map
      $elemapdata['element_id'] = $newelementid;
      $elemapdata['lesson_id'] = $newlesson['Lesson']['id'];
      $elemapdata['position'] = 0;
      $elemapdata['element_type'] = $eleid['LessonElementMap']['element_type'];      

      $this->LessonElementMap->saveAll($elemapdata);
     }
    }
      $this->redirect("/admin/lesson/"+$data['to_course_id']);
  }


}
