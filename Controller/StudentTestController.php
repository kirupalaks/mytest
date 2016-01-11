<?php

class StudentTestController extends AppController{

  public $name = "StudentTest";
  public $uses = array('Student', 'Test');

  public function beforeFilter() {
    parent::beforeFilter();
    $this->Auth->allow('student_tests');
  }

  public function student_tests(){
    $this->layout = "ahaguru";
    $this->render('student_tests');
  }

  public function student_attempts(){
    $this->layout = "ahaguru";
  }

}
