<?php

class HinduController extends AppController {
    
    public $name = "Hindu";
          
    public $uses = array("Student","StudentCourseMap","Standard","Payment","HinduStudent");
    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow("delete_entry");
    }

    public function admin_index() {
        $this->layout = "ahaguru";
    }

    public function unique_id($l = 3) {
   return substr((uniqid(mt_rand(), true)), 0, $l);
    }

    public function register_offline() {
        $this->layout = "default";
        $data = $this->request->data();                
        $level = $data['level'];
        if($level == 1){ 
            $course_id[0] = 41;
            $course_id[1] = 42;
            $courses = implode(',',$course_id);                     
          }
          else if($level == 2){ 
            $course_id[0] = 39;
            $course_id[1] = 40;
            $courses = implode(',',$course_id);                         
          }                             
        $user = $this->Student->findByEmail($data['email']);        
        if(empty($user)){
            $pwd = substr($data['name'],0,4);
          	$data['password'] = $pwd.$this->unique_id();
            $data['user_id'] = $data['email'] ;
          	$reg = $this->Student->save($data);      
          	if($reg){        
            	$data['id'] = $this->Student->id;
            	$regno=$this->Student->query("select reg_no from students where id =".$data['id']);        	
          	  $standard=$this->Standard->query("select name from standards where id =".$data['standard']);                   
              $user = $this->Student->findByEmail($data['email']);
              foreach ($course_id as $ids) {
                $mapdata = array();                
                $mapdata['id'] = $crsmap['StudentCourseMap']['id'];
                $mapdata['student_id'] = $user['Student']['id'];
                $mapdata['course_id'] = $ids;
                $mapdata['status'] = 1;
                $mapdata['payment'] = 2;
                $mapdata['deleted'] = 0;    
                $mapdata['challenge_type'] = "PC2";            
                $mapdata['comments'] = $data['source_from'].",Hindu New student offline payment";                                                                          
               $this->StudentCourseMap->saveAll($mapdata);
              }
              $paymentdata = array();
              $paymentdata['order_id'] = $user['Student']['reg_no'];
              $paymentdata['tracking_id'] = $data['leaf_no'];
              $paymentdata['student_id'] = $user['Student']['id'];
              $paymentdata['order_status'] = "Success";
              $paymentdata['payment_mode'] = $data['payment_mode'];
              $paymentdata['amount'] = $data['amount'];
              $paymentdata['course_ids'] = $courses;
              $this->Payment->save($paymentdata);
              if($level == 1)
                $levels ="Junior";
              else if($level == 2)
                $levels ="Seniors";          
              $rawstring = "<p>Dear studentname,</p>
                  <p>Welcome to AhaGuru!</p>
                  <p>You have successfully registered for The Hindu AhaGuru Physics Challenge 2 - levels !</p>
                  <p><b>Step 1:</b> Please go to www.ahaguru.com and login to your AhaGuru account:</p>
                  <p>Your AhaGuru UserName is uname</p>
                  <p>Your AhaGuru Password is upwd</p>
                  <p><b>Step 2:</b> You will find 'The Hindu AhaGuru Physics Challenge 2 - levels' Course added to your 'My Courses' page. Click on it to start learning
                  <p><b>Step 3:</b> Complete all the online lessons and take the written test on October 25, 2015.</p>
                  <p>Please write to us at <a href=learn@ahaguru.com>learn@ahaguru.com </a> in case of any difficulties!
                  <p>All the best!</p>
                  <p>AhaGuru Team</p>
                  <p>www.ahaguru.com</p>";
                  $placeholders=array('studentname','uname','upwd','levels');
                  $string=array($user['Student']['name'],$user['Student']['email'],$user['Student']['password'],$levels);
                  $rawstr = str_replace($placeholders, $string, $rawstring);        
                   $this->sendEmail($user['Student']['email'], null,"Ahaguru: Registration",$rawstr);
                  $msg = array("result"=>"valid","msg"=>"mapped");
            }
        }
        else{ 
          $cond = array(
        'StudentCourseMap.student_id'=>$user['Student']['id'],
        'StudentCourseMap.comments LIKE'=> "%Hindu%",
        'StudentCourseMap.challenge_type'=> "PC2",
        'StudentCourseMap.deleted'=>0,
        );

      $hinducoursemap = $this->StudentCourseMap->find("first",array('conditions'=>$cond));      
      if(empty($hinducoursemap)){        
          foreach ($course_id as $ids) {
         $mapdata = array();
          $con = array(
            'StudentCourseMap.student_id' => $user['Student']['id'],
            'StudentCourseMap.course_id' => $ids,
            'StudentCourseMap.deleted' => 0
            );
          $crsmap = $this->StudentCourseMap->find("first",array('conditions' => $con));          
          if(!empty($crsmap))
            $mapdata['id'] = $crsmap['StudentCourseMap']['id'];
            $mapdata['student_id'] = $user['Student']['id'];
            $mapdata['course_id'] = $ids;
            $mapdata['status'] = 1;
            $mapdata['payment'] = 2;
            $mapdata['deleted'] = 0;        
            $mapdata['challenge_type'] = "PC2";                
            $mapdata['comments'] = $data['source_from']."Hindu Existing student offline payment";                                                          
            if(!empty($crsmap)){
              $comments = $crsmap['StudentCourseMap']['comments'];                                    
              $comments .= $data['source_from'].",Hindu Existing student offline payment";     
              $mapdata['comments'] = $comments;
            }
           $this->StudentCourseMap->saveAll($mapdata);
           $msg = array("result"=>"valid","msg"=>"mapped");
          }
              $paymentdata = array();
              $paymentdata['order_id'] = $user['Student']['reg_no'];
              $paymentdata['tracking_id'] = $data['leaf_no'];
              $paymentdata['student_id'] = $user['Student']['id'];
              $paymentdata['order_status'] = "Success";
              $paymentdata['payment_mode'] = $data['payment_mode'];
              $paymentdata['amount'] = $data['amount'];
              $paymentdata['course_ids'] = $courses;
              $this->Payment->save($paymentdata);
          }
          else $msg = array("result"=>"invalid","msg"=>"already enrolled");                  
        }
          $this->set("json",json_encode($msg));
 }

 public function verify_user() {
    if($this->request->is("post")){
      $email = $this->request->data['email'];      
      $student = $this->Student->findByEmail($email);           
      if($student == null) {
        $this->set("json", json_encode(array("isvalid"=>"yes","email"=>$email)));
      }
      else {
        $this->set("json", json_encode(array("isvalid"=>"no","data"=>$student)));
      }
    }
  }

  public function delete_entry(){
    if($this->Auth->user()){
    $user = $this->Auth->user();
    $failurestud = $user['Student'];          
    $this->HinduStudent->save($failurestud);    
    $this->Student->delete($user['Student']['id']);
      unset( $_SESSION['User']);
    $this->set("json", json_encode("deleted"));
  }}
}
