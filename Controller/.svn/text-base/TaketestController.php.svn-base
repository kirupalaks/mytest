<?php

class TaketestController extends AppController {

  public $name = "TakeTest";
  
  public $uses = array("Question");

  public function beforeFilter() {
    parent::beforeFilter();
    $this->Auth->allow("student_index","student_gethint");
  }

  public function student_index() {
    $this->layout = "ahaguru_math_nonav";  
    $user = $this->Auth->user();
    CakeLog::write('debug', "Entered in to test ".$user['Student']['id']); 
}
  
  public function student_gethint(){
    $this->layout = "default";
    $question = $this->Question->findById($this->request->data['question_id']);  
    $hint = $this->request->data['hint'];
    $data = array("hint" => $question['Question']['hint'.$hint]);
    $this->set("json",json_encode($data));
  }

  public function admin_gethint(){
    $this->layout = "default";
    $question = $this->Question->findById($this->request->data['question_id']);  
    $hint = $this->request->data['hint'];
    $data = array("hint" => $question['Question']['hint'.$hint]);
    $this->set("json",json_encode($data));
  }
}
