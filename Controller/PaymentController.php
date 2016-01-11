<?php
App::uses('CakeEmail', 'Network/Email');
App::import('Vendor', 'PaymentRequest');
App::import('Vendor', 'PaymentResponse');
class PaymentController extends AppController {

    public $name = "Payment";
    public $uses = array ('Payment','StudentCourseMap','Student','HinduStudent','AgPuzzlerSubscription','StdCourseMap');

    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('pay');
        $this->layout = "ahaguru";
    }

      public function pay(){
    	 $this->layout ="default";
      if($this->Auth->user()){
        $user = $this->Auth->user();
        $PaymentRequest = new PaymentRequest();
     if($this->request->is("post")) {
          $data = $this->request->data;
          $this->Session->write("courses",$data['course_id']);
          $data['regno'] = $user['Student']['reg_no'];
          $result = $PaymentRequest->sendRequest($data);
          $this->set("json",json_encode($result));
         }
  	  }
  	  else{
  	  	 $this->set("json",json_encode("login"));
     }
  }


public function response(){
     if($this->request->is("post")) {
      $this->layout = "default";
       $PaymentResponse = new PaymentResponse();
       $user = $this->Auth->user();
        $data = $this->request->data;
        $result = $PaymentResponse->getResponse($data);
        $dataSize=sizeof($result);
        $course_id = $this->Session->read("courses");        
        $cmt = $this->Session->read("purchasemode");              
        $commet = $this->Session->read("sourcefrom");
         $levelid = $this->Session->read("studentlevel");                
         $usr = $this->Session->read("user_type");                
         $student = $this->Student->findById($user['Student']['id']);         
        if($commet == "thinkvidya" || $commet == "quiz" ||$commet =="free_signup" || $commet == "hindu_direct"){
         if($levelid == 1){
          $levels ="Junior";        
        }
        else if($levelid == 2){
          $levels ="Seniors";          
        }
       $data = array();
       $coupon_code = $this->Session->read('coupon_code');
         $sesscoupon = substr($this->Session->read('coupon_code'),0,4);
       if(stripos($coupon_code,"APC2") !== FALSE){
        $commet.=",by PromoCoupon ".$coupon_code;        
        $code = $coupon_code;
        }
       $rawstring = "<p>Dear studentname,</p>
                  <p>Welcome to AhaGuru!</p>
                  <p>You have successfully registered for The Hindu AhaGuru Physics Challenge 2 - levels !</p>
                  <p><b>Step 1:</b> Please go to www.ahaguru.com and login to your AhaGuru account:</p>
                  <p>Your AhaGuru UserName is uname</p>
                  <p>Your AhaGuru Password is upwd</p>
                  <p><b>Step 2:</b> You will find 'The Hindu AhaGuru Physics Challenge 2 - levels' Course added to your 'My Courses' page. Click on it to start learning
                  <p><b>Step 3:</b> Complete all the online lessons and take the written test on October 25th, 2015.</p>
                  <p>Please write to us at <a href=learn@ahaguru.com>learn@ahaguru.com </a> in case of any difficulties!
                  <p>All the best!</p>
                  <p>AhaGuru Team</p>
                  <p>www.ahaguru.com</p>";
        $placeholders=array('studentname','uname','upwd','levels');
        $string=array($user['Student']['name'],$user['Student']['email'],$student['Student']['password'],$levels);
        $rawstr = str_replace($placeholders, $string, $rawstring);        
        for($i = 0; $i < $dataSize; $i++) 
        { 
        $information=explode('=',$result[$i]);
        //if($i==3) $order_status=$information[1];
        $data[$information[0]] = $information[1];
      }
        $courses = implode(',',$course_id);
        if(empty($courses))
          $data['course_ids'] = $course_id;
        else
        $data['course_ids'] = $courses;
        $data['student_id'] = $user['Student']['id'];
        CakeLog::write('debug', "data from ccavenue".print_r($data,true));
        if($data['order_status'] == 'Success'){
         $this->Payment->save($data);          
         if(stripos($coupon_code,"APC2") !== FALSE){          
         $subscription = array();
         if($student['Student']['standard'] > 4)
          $std = 1;
        else
          $std = $student['Student']['standard'];
         $con = array('StdCourseMap.course_id' => array(44,45,46,47),
          'StdCourseMap.standard_id' => $std);
         $course_subscribed = $this->StdCourseMap->find("first",array('conditions' => $con));
         $studsubscrption = $this->AgPuzzlerSubscription->find("all",array('conditions' => 
            array('AgPuzzlerSubscription.STUDENT_ID' =>$student['Student']['id'],
              'AgPuzzlerSubscription.COURSE_ID' => $course_subscribed['StdCourseMap']['course_id'])));
          CakeLog::write('debug', "subscribe? ".print_r($studsubscrption,true));
           $datediff = date_diff(date_create("31-12-2015"),date_create(date("Y-m-d H:i:s")));              
          $datediff = ($datediff->days)+1;
          $week  = round($datediff / 7);
          $week = $week + 1;
          if(empty($studsubscrption)){
         $subscription['COURSE_ID'] = $course_subscribed['StdCourseMap']['course_id'];
         $subscription['STUDENT_ID'] = $user['Student']['id'];
         $subscription['SUBSCRIPTION_PERIOD'] = $week;
         $subscription['SUBSCRIPTION_DATE'] = date('Y-m-d H:i:s');
         $this->AgPuzzlerSubscription->save($subscription);
        }
        }
         foreach ($course_id as $ids) {
         $mapdata = array();
          $con = array(
            'StudentCourseMap.student_id' => $user['Student']['id'],
            'StudentCourseMap.course_id' => $ids,
            'StudentCourseMap.deleted' => 0
            );
          $crsmap = $this->StudentCourseMap->find("first",array('conditions' => $con));
		 CakeLog::write('debug', "crs exists? ".print_r($crsmap,true));
          if(!empty($crsmap))
            $mapdata['id'] = $crsmap['StudentCourseMap']['id'];          
            $mapdata['student_id'] = $user['Student']['id'];
            $mapdata['course_id'] = $ids;            
            $mapdata['status'] = 1;
            $mapdata['coupon_code']=$code;
            $mapdata['payment'] = 2;            
            $mapdata['deleted'] = 0;
            if($cmt == "hindu signup"){
               $mapdata['challenge_type'] = "PC2";
              // $mapdata['comments'] = $commet.",Hindu New Student Online_Payment";                   
                $mapdata['comments'] = $commet.",Hindu New Student Online_Payment";          
            }
            else if($cmt == "hindu login purchase"){
              if(!empty($crsmap)){
              // $comments = $crsmap['StudentCourseMap']['comments'];                                    
              //     $comments .= ",Hindu Existing Student Online_Payment";          
              // $mapdata['comments'] = $commet.",".$comments;
                $comments = $crsmap['StudentCourseMap']['comments'];                                                  
                $comments .= ",Hindu Existing Student Online_Payment";                        
                $mapdata['challenge_type'] = "PC2";              
              $mapdata['comments'] = $commet.",".$comments;
            }
            else{
               $mapdata['challenge_type'] = "PC2";               
              $mapdata['comments'] = $commet.",Hindu Existing Student Online_Payment";             
            }
          }
            else
              $mapdata['comments'] = $commet.",Online_Payment";
		       CakeLog::write('debug', "saved mapping".print_r($mapdata,true));
           $this->StudentCourseMap->saveAll($mapdata);
         }
         $this->sendEmail($user['Student']['email'], null,"Ahaguru: Registration",$rawstr,null);
          session_destroy();
         $this->redirect("/payment_success");
         // $this->redirect("/student/course");
       }
        else{
          $this->Payment->save($data);
          if($usr == "newuser"){
            $failurestud = $student['Student'];          
            $this->HinduStudent->save($failurestud);
            $this->Student->delete($student['Student']['id']);
          }
          else{
            $failurestud = $student['Student'];         
		$failurestud['challenge_type']="PC2"; 
            $this->HinduStudent->save($failurestud);
          }
          session_destroy();
          $this->redirect("/hindu");
        }
      }
      else{        
       $data = array();       
        for($i = 0; $i < $dataSize; $i++) 
        { 
        $information=explode('=',$result[$i]);
        //if($i==3) $order_status=$information[1];
        $data[$information[0]] = $information[1];
      }
        $courses = implode(',',$course_id);
        if(empty($courses))
          $data['course_ids'] = $course_id;
        else
        $data['course_ids'] = $courses;
        $data['student_id'] = $user['Student']['id'];
        CakeLog::write('debug', "data from ccavenue".print_r($data,true));
        if($data['order_status'] == 'Success'){          
         $this->Payment->save($data);
         foreach ($course_id as $ids) {
         $mapdata = array();
          $con = array(
            'StudentCourseMap.student_id' => $user['Student']['id'],
            'StudentCourseMap.course_id' => $ids,
            'StudentCourseMap.deleted' => 0
            );
          $crsmap = $this->StudentCourseMap->find("first",array('conditions' => $con));
          CakeLog::write('debug', "crs exists? ".print_r($crsmap,true));
          if(!empty($crsmap))
            $mapdata['id'] = $crsmap['StudentCourseMap']['id'];
            $mapdata['student_id'] = $user['Student']['id'];
            $mapdata['course_id'] = $ids;            
            $mapdata['status'] = 1;
            $mapdata['payment'] = 2;
            // $mapdata['challenge_type'] = "PC2";
            $mapdata['deleted'] = 0;
            if($cmt == "hindu signup"){
              $mapdata['challenge_type'] = "PC2";              
                $mapdata['comments'] = $commet.",Hindu New Student Online_Payment";                                                      
            }
            else if($cmt == "hindu login purchase"){              
              if(!empty($crsmap)){
              $comments = $crsmap['StudentCourseMap']['comments'];                                                  
                $comments .= ",Hindu Existing Student Online_Payment";                        
                $mapdata['challenge_type'] = "PC2";              
              $mapdata['comments'] = $commet.",".$comments;
            }
            else{
              $mapdata['challenge_type'] = "PC2";              
              $mapdata['comments'] = $commet.",Hindu Existing Student Online_Payment";             
            }
          }
            else
              $mapdata['comments'] = $commet.",Online_Payment";
            CakeLog::write('debug', "saved mapping".print_r($mapdata,true));
           $this->StudentCourseMap->saveAll($mapdata);
         }         
         $this->redirect("/student/course");
       }
        else{
          $this->Payment->save($data);         
          $this->redirect("/student/course");
        } 
        }      
      }
  }
  public function hresponse(){     
      $this->layout = "default";       
       $user = $this->Auth->user();        
        $course_id = $this->Session->read("courses");        
        $cmt = $this->Session->read("purchasemode");                      
        $commet = $this->Session->read("sourcefrom");                
         $levelid = $this->Session->read("studentlevel"); 
         $usr = $this->Session->read("user_type");                
         $student = $this->Student->findById($user['Student']['id']);
         if($levelid == 1){
          $levels ="Junior";        
        }
        else if($levelid == 2){
          $levels ="Seniors";          
        }
       $data = array();      
        $coupon_code = $this->Session->read('coupon_code');
         $sesscoupon = substr($this->Session->read('coupon_code'),0,4);
      if(stripos($coupon_code,"APC2") !== FALSE){        
        $commet.=",by PromoCoupon ".$coupon_code;
        $code = $coupon_code;
        }
        $courses = implode(',',$course_id);
        $rawstring = "<p>Dear studentname,</p>
                  <p>Welcome to AhaGuru!</p>
                  <p>You have successfully registered for The Hindu AhaGuru Physics Challenge 2 - levels !</p>
                  <p><b>Step 1:</b> Please go to www.ahaguru.com and login to your AhaGuru account:</p>
                  <p>Your AhaGuru UserName is uname</p>
                  <p>Your AhaGuru Password is upwd</p>
                  <p><b>Step 2:</b> You will find 'The Hindu AhaGuru Physics Challenge 2 - levels' Course added to your 'My Courses' page. Click on it to start learning
                  <p><b>Step 3:</b> Complete all the online lessons and take the written test at our centers in Chennai, Coimbatore, Madurai, Salem, Trichy, Cochin, Trivandrum and Bangalore on October 25th, 2015.</p>
                  <p>Please write to us at <a href=learn@ahaguru.com>learn@ahaguru.com </a> in case of any difficulties!
                  <p>All the best!</p>
                  <p>AhaGuru Team</p>
                  <p>www.ahaguru.com</p>";
        $placeholders=array('studentname','uname','upwd','levels');
        $string=array($user['Student']['name'],$user['Student']['email'],$student['Student']['password'],$levels);
        $rawstr = str_replace($placeholders, $string, $rawstring);
        // $this->sendEmail($this->request->data['Student']['email'], null,"Ahaguru: Registration",$rawstr);
        if(empty($courses))
          $data['course_ids'] = $course_id;
        else
        $data['course_ids'] = $courses;
        $data['student_id'] = $user['Student']['id'];   
          if(stripos($coupon_code,"APC2") !== FALSE){          
         $subscription = array();
         if($student['Student']['standard'] > 4)
          $std = 1;
        else
          $std = $student['Student']['standard'];
         $con = array('StdCourseMap.course_id' => array(44,45,46,47),
          'StdCourseMap.standard_id' => $std);
         $course_subscribed = $this->StdCourseMap->find("first",array('conditions' => $con));
         $studsubscrption = $this->AgPuzzlerSubscription->find("all",array('conditions' => 
            array('AgPuzzlerSubscription.STUDENT_ID' =>$student['Student']['id'],
              'AgPuzzlerSubscription.COURSE_ID' => $course_subscribed['StdCourseMap']['course_id'])));
          CakeLog::write('debug', "subscribe? ".print_r($studsubscrption,true));
           $datediff = date_diff(date_create("31-12-2015"),date_create(date("Y-m-d H:i:s")));              
          $datediff = ($datediff->days)+1;
          $week  = round($datediff / 7);                  
          $week = $week + 1;
          if(empty($studsubscrption)){
         $subscription['COURSE_ID'] = $course_subscribed['StdCourseMap']['course_id'];
         $subscription['STUDENT_ID'] = $user['Student']['id'];
         $subscription['SUBSCRIPTION_PERIOD'] = $week ;
         $subscription['SUBSCRIPTION_DATE'] = date('Y-m-d H:i:s');
         $this->AgPuzzlerSubscription->save($subscription);
        }
        }             
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
          // else
          //   $mapdata['challenge_type'] = "PC2";
            $mapdata['student_id'] = $user['Student']['id'];
            $mapdata['course_id'] = $ids;
            $mapdata['status'] = 1;         
            $mapdata['coupon_code']=$code;   
            $mapdata['payment'] = 2;
            $mapdata['deleted'] = 0;                  
            if($cmt == "hindu signup"){
              $mapdata['challenge_type'] = "PC2";                 
                $mapdata['comments'] = $commet.",Hindu New Student Online_Payment";                                                      
            }
            else if($cmt == "hindu login purchase"){
              if(!empty($crsmap)){
              $comments = $crsmap['StudentCourseMap']['comments'];                                                      
                $comments .= ",Hindu Existing Student Online_Payment";                        
                $mapdata['challenge_type'] = "PC2";              
              $mapdata['comments'] = $commet.",".$comments;
            }
            else{
               $mapdata['challenge_type'] = "PC2";              
              $mapdata['comments'] = $commet.",Hindu Existing Student Online_Payment";             
            }
          }
            else
              $mapdata['comments'] = $commet.",Online_Payment";
            error_log("dsds".print_r($mapdata,true));
           $this->StudentCourseMap->saveAll($mapdata);
         }         
      // $this->sendEmail($user['Student']['email'], null,"Ahaguru: Registration",$rawstr,null);        
            session_destroy();
          $this->redirect("/payment_success");
       }
        
}
