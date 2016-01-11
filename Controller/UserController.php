<?php

class UserController extends AppController {

    public $name = "User";

    public $uses = array('Student','StudentCourseMap','StudentConceptAttempt','Dashboard','StudentExerciseAttempt','StudentActivity','StudentTestAttempt','StudentLessonSkip');

    public function beforeFilter() {
        parent::beforeFilter();
    }

    public function admin_index() {
        $this->layout = "ahaguru";
    }

    public function adata_usertags($studentid) {
      $this->layout = "default";
      $data = $this->request->data;
      if (isset($data['tags'])) {
        if ($this->Student->setTags($studentid, $data['tags'])) {
            $tags = $this->Student->getTags($studentid);
            if  (!empty($tags)) 
                $this->set("json", json_encode(array("message" => "success", "tags" => $tags)));
            else 
                $this->set("json", json_encode(array("message" => "success")));
        }
        else {
            $this->set("json", json_encode(array("message" => "failure")));
        }
      } else {
        $tags = $this->Student->getTags($studentid);
        if  (!empty($tags)) 
            $this->set("json", json_encode(array("message" => "success", "tags" => $tags)));
        else 
            $this->set("json", json_encode(array("message" => "failure")));
      }
        
    }

    public function adata_delete($studentid) {
           if($this->Student->setDelete($studentid))
        $this->set("json", json_encode(array("message" => "deleted")));
      else
        $this->set("json", json_encode(array("message" => "error")));
       }


      public function adata_permanent_delete($studentid) {
         
           if($this->StudentCourseMap->deleteAll(array('StudentCourseMap.student_id' => $studentid))){
              if($this->StudentTestAttempt->deleteAll(array('StudentTestAttempt.student_id' => $studentid))){
                  if($this->StudentConceptAttempt->deleteAll(array('StudentConceptAttempt.student_id' => $studentid))){
                   if($this->StudentExerciseAttempt->deleteAll(array('StudentExerciseAttempt.student_id' => $studentid))){
                    if($this->StudentActivity->deleteAll(array('StudentActivity.student' => $studentid))){
                  if($this->Dashboard->deleteAll(array('Dashboard.student_id' => $studentid))){
                 if($this->StudentLessonSkip->deleteAll(array('StudentLessonSkip.student_id' => $studentid))){
                if($this->Student->delete($studentid))
        $this->set("json", json_encode(array("message" => "deleted")));
      }}}}}}}else
        $this->set("json", json_encode(array("message" => "error")));
       }
   
    public function adata_addstudent($studentid) {
      $student = $this->Student->find("first",array('conditions' => 
        array('Student.id' => $studentid)));
      $user_id = split("/", $student['Student']['user_id']);
      $user = $this->Student->find("first",array('conditions' => 
        array('Student.user_id' => $user_id[0],
          'Student.deleted' => 0)));      
       if($user == null){
      if($this->Student->setAdd($studentid,$user_id[0]))
        $this->set("json", json_encode(array("message" => "added")));
      else
        $this->set("json", json_encode(array("message" => "error")));
      }
      else
        $this->set("json", json_encode(array("message" => "exist")));
    }
   
   
}
