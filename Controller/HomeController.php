<?php
App::uses('CakeEmail', 'Network/Email');
App::import('Vendor', 'PaymentRequest');

class HomeController extends AppController {

    public $name = "Home";

    public $uses = array('Student','Admin','Course','CourseCouponMap','StudentCourseMap','StdCourseMap','ParentRelationship','PromotionalCoupon','AgPuzzlerSubscription',
      'StudentLessonSkip','StudentSkipLessons','StudentLessonMap','Exercise','Test','Concept','LessonElementMap','Slide','Question','School','Register',
    	'AdminSlides','SessionAnalytic','Dashboard','Ahaguru','Standard','direct_login','CourseLessonMap','Lesson','Batch','ClassroomStudent','CrBatchMap');


   public function beforeFilter() {
	parent::beforeFilter();
	$this->Auth->allow('index','enquiry','register','registerSuccess','forgotpwd','getall_school','disclaimer','trmsandcon','privacy','coupon_login','thehindu','hlogin','hindu_registration','hloginsubmit','hinduresults','wppregister',
               'classroom','books','online','embed','login1','register1','photos','relationship','stud_register','checkcoupon','quiz','hsignup','hregister','sessionvariable','payment_success','cancel','classroom_register');
	$this->layout = "ahaguru";
    }

  public function unique_id($l = 3) {
	 return substr((uniqid(mt_rand(), true)), 0, $l);
    }

    public function index() {
      unset($_SESSION['wpp']);      
   $this->set('slides',$this->AdminSlides->getslides()); 
    $this->set('new', $this->Dashboard->getnews());   
    $this->set('students',$this->Student->find("all",array('conditions' => array('Student.deleted'=> 0))));
    $student=$this->Student->find("all",array('conditions' => array('Student.deleted'=> 0),'order'=>array('Student.id'=>'DESC limit 18')));
   
    for($i = 0;$i<18;$i++){
     if ( file_exists(WWW_ROOT."/img/usr".$student[$i]['Student']['id']."/profile_200.jpg") ) {
      $user[$i]['photo'] = "/img/usr".$student[$i]['Student']['id']."/profile_200.jpg";
    } else 
      $user[$i]['photo'] = "Photo Not Available";
      $user[$i]['name'] = $student[$i]['Student']['name'];
    }
    if($this->Auth->user()){      
    $user = $this->Auth->user();        
    if($user['role'] == "admin"){
      $this->set("loggedin","admin");      
    }
    else if(isset($user['ClassroomStudent']) || (isset($user['Student']) && isset($_SESSION['classroomstudent'])))
      $this->set("loggedin","classroomstudent");          
    else if(isset($user['Student']) && !isset($_SESSION['classroomstudent']))
      $this->set("loggedin","student");          
    }
    else{
      $this->set("loggedin","no");  
    }
    $this->set("users",$user);
    $this->set("standard", $this->Standard->find('all',array( 'order' => array('Standard.name' => 'DESC'))));
    $this->set("school", $this->School->find('all'));
         }

  public function signup(){
    $user = $this->Student->findById($this->params['id']);
  		unset($user['Student']['password']);
		$user['role'] = "student";
		$user['data'] = 'sdata';
		if($this->Auth->login($user)) { 
		    $session_data = array();
		    $session_data['user_id'] = $user['Student']['id'];
		    $session_data['user_agent'] = serialize($_SERVER['HTTP_USER_AGENT']);
		    $this->SessionAnalytic->save($session_data);
		    //$this->redirect("/student/student/allcourse"); 
        $wpp = $this->Session->read('wpp');        
        if($wpp == 1)
          $this->redirect("/student/agpuzzler"); 
        else
        $this->redirect("/student/course"); 
		}

  }
   
   public function hinduresults(){
    $this->layout="ahaguru";
   }
    public function logout() {      
      session_destroy();
	  $this->redirect($this->Auth->logout());           
    }

    public function purchase_success() {      
      session_destroy();
     $this->redirect($this->Auth->payment_succ());           
    }

   public function register1() {
        if($this->request->is("post")) {
          $this->layout = "default";
          $data = $this->request->data;
          error_log("dsds".print_r($data,true));
          $PaymentRequest = new PaymentRequest();
          if($data['Student']['pay_flag']){       
         $course_id = explode(",",$data['Student']['courses']) ;
        $this->Session->write("courses",$course_id);
      //$payment['regno'] = $user['Student']['reg_no'];    
         $payment['fee']= $data['Student']['fees'];
         $payment['pay_flag'] = $data['Student']['pay_flag'];
         $payment['courses'] = $data['Student']['courses'];
           $this->Session->write("paymentdata",$payment);

           $this->redirect("/student/register");
                    
       }
       else{
         $pwd = substr($data['Student']['name'],0,4);
            $data['Student']['password'] = $pwd.$this->unique_id();
            $data['Student']['user_id'] = $data['Student']['email'];
            error_log("savedsds".print_r($data,true));
       if($data['Student']['standard'] == 0) unset($data['Student']['standard']);

            $reg = $this->Student->save($data);

           if($reg){
                        $data['student_id'] = $this->Student->id;
                 $regno=$this->Student->query("select reg_no from students where id = $data[student_id]");                        
                $user = $this->Student->findByEmail($this->request->data['Student']['email']);
                $user1 = $this->Student->findByEmail($this->request->data['Student']['email']);
          //unset($user1['Student']['password']);
    $user1['role'] = "student";
    $user1['data'] = 'sdata';
          if($this->Auth->login($user1)) { 
        $session_data = array();
        $session_data['user_id'] = $user1['Student']['id'];
        $session_data['user_agent'] = serialize($_SERVER['HTTP_USER_AGENT']);
        $this->SessionAnalytic->save($session_data);}

    $standard=$this->Standard->query("select name from standards where id = ".$data['Student']['standard']);
    if(isset($data['Student']['parent_relationship']))
    $rel=$this->ParentRelationship->query("select name from parent_relationships where id =". $data['Student']['parent_relationship']);    
    $rawstring = "<p>Dear names,</p>
                  <p>Welcome to Ahaguru Classes!</p>
                  <p>Ahaguru classes offer concept based learning environment with carefully designed courses based on intensive learning research done by Dr.Balaji Sampath.  Both Direct Classes as well as Online courses are available from Class 5 onwards up to class 12.</p>
                   <p>Thank you for your interest in our classes. </p>
                   <p>Your registration has been successful. </p>
                  <p>Please check your profile information and email:<a href=learn@ahaguru.com>learn@ahaguru.com </a> for any questions and clarifications.</p>
                 <p> Student name: names</p>
                 <p>Student Email ID :emails</p>
                 <p>School Name: school</p>
                 <p>Class in School: standard</p>
                 <p>Parent Name: parents</p>
                 <p>Relationship : parentrel</p>
                 <p>Parent Email ID : parentemail</p>
                 <p>Mobile Number: mobile</p>
                 <p>Address: addr </p>
                  <p> State: state</p>
                  <p>City/Village: city</p>
                  <p>PinCode : pin</p>
                   <p>Country: country</p>
                   <p>Your online account will use your email as your login username and your password that is given below:</p>
                  <p>Your User Name: emails</p>
                  <p>Your Password: pwd</p>
                  <p>Please use the above email id and password to log into the website:www.ahaguru.com</p>
                  <p>All the best and Have a great Day!</p>
              <p>Thanks & Regards</p>
              <p>AHAGURU</p>
              <p>www.ahaguru.com</p>
              <p>+91-96001 00090</p>";
                   

    $placeholders=array('names','emails','pwd','school','standard','parents','parentrel','parentemail','mobile',
                                       'addr','state','city','pin','country');
     $string=array($user['Student']['name'],$user['Student']['email'],$user['Student']['password'],$user['Student']['school_name'],$standard[0]['standards']['name'],$user['Student']['parent_name'],
        $rel[0]['parent_relationships']['name'],$user['Student']['parent_email'],$user['Student']['mobile_number'],$user['Student']['address'],$user['Student']['state'],$user['Student']['place'],
        $user['Student']['postal_pin'],$user['Student']['country']);
           $rawstr = str_replace($placeholders, $string, $rawstring);
         $this->sendEmail($this->request->data['Student']['email'], null,"Ahaguru: Registration",$rawstr,null);
     
        $message = array("result" =>"success","msg"=>$data['student_id']); 
     }
     $this->set("json",json_encode($message));
     }}
       }

    public function checkcoupon(){
      if($this->request->is("post")) {
          $this->layout = "default";
              $data = $this->request->data;
      $crs= $this->CourseCouponMap->find("first",array('conditions'=>
          array('CourseCouponMap.coupon_code'=>$data['coupon_code'],
            'CourseCouponMap.status'=>1,
             'CourseCouponMap.deleted'=>0)));
      if(empty($crs))
      $message = array('result' => 'no','message'=>'Enter Correct Coupon Code');
      else
    $message = array('result' => 'valid');
       $this->set("json",json_encode($message));
   }
    }

    public function register() {
  		//$this->set("standard", $this->Standard->find('all'));
    $uri = $_SERVER['HTTP_REFERER'];
      $uri = split("/", $uri);   
      $sesscoupon = substr($this->Session->read('coupon_code'),0,4);
      if(strcasecmp($sesscoupon,"APC2") == 0)
          $this->redirect("/TheHindu");
        if($this->request->is("post")) {
          $this->layout = "default";
          if($uri[count($uri)-1] =="register"){
              $data = $this->request->data;
                $pwd = substr($data['name'],0,4);
               $data['password'] = $pwd.$this->unique_id();
               $data['user_id'] = $data['email'];
 	           if($data['standard'] == 0) unset($data['standard']);
 	    $crs= $this->CourseCouponMap->find("first",array('conditions'=>
         	array('CourseCouponMap.coupon_code'=>$data['coupon_code'],
            'CourseCouponMap.status'=>1,
      	     'CourseCouponMap.deleted'=>0,)));
       if(empty($crs)){
      // $crs= $this->PromotionalCoupon->find("first",array('conditions'=>
      //  array('PromotionalCoupon.coupon_code'=>$data['coupon_code'],       
      //  'PromotionalCoupon.deleted'=>0)));
        $crs= $this->PromotionalCoupon->find("all",array('conditions'=>
       array('PromotionalCoupon.coupon_code'=>$data['coupon_code'],       
       'PromotionalCoupon.deleted'=>0)));
      }
     if(empty($crs))
     	$message = array('result' => 'no','message'=>'Enter Correct Code');
     else{
       $reg = $this->Student->save($data);
 	       if($reg){
          if(isset($crs['CourseCouponMap'])){
     	$mapdata['course_id'] = $crs['CourseCouponMap']['course_id'];
     	$mapdata['student_id'] = $this->Student->id;
     	$mapdata['payment'] = 2;
     	$mapdata['status'] = 1;
      $mapdata['course_mapped_type'] = 1;
     	$mapdata['comments'] = "Added by couponcode ".$data['coupon_code'];
     	$this->StudentCourseMap->save($mapdata);
        $course = $this->Course->findById($crs['CourseCouponMap']['course_id']);
      $this->CourseCouponMap->addinfo($data['coupon_code'],$crs['CourseCouponMap']['course_id'],$data['email']);
       $data['student_id'] = $this->Student->id;
        $regno=$this->Student->query("select reg_no from students where id = $data[student_id]");
		$user = $this->Student->findByEmail($this->request->data['email']);
    $standard=$this->Standard->query("select name from standards where id = $data[standard]");

    $rel=$this->ParentRelationship->query("select name from parent_relationships where id = $data[parent_relationship]");
    $rawstring = "<p>Dear names,</p>
                  <p>Welcome to Ahaguru Classes!</p>
                  <p>Ahaguru classes offer concept based learning environment with carefully designed courses based on intensive learning research done by Dr.Balaji Sampath.  Both Direct Classes as well as Online courses are available from Class 5 onwards up to class 12.</p>
                   <p>Thank you for your interest in our classes. </p>
                   <p>Your registration has been successful. </p>
                  <p>Please check your profile information and email:<a href=learn@ahaguru.com>learn@ahaguru.com </a> for any questions and clarifications.</p>
                 <p> Student name: names</p>
                 <p>Student Email ID :emails</p>
                 <p>School Name: school</p>
                 <p>Class in School: standard</p>
                 <p>Parent Name: parents</p>
                 <p>Relationship : parentrel</p>
                 <p>Parent Email ID : parentemail</p>
                 <p>Mobile Number: mobile</p>
                 <p>Address: addr </p>
                  <p> State: state</p>
                  <p>City/Village: city</p>
                  <p>PinCode : pin</p>
                   <p>Country: country</p>
                   <p>Your online account will use your email as your login username and your password that is given below:</p>
                  <p>Your User Name: emails</p>
                  <p>Your Password: pwd</p>
                  <p>Please use the above email id and password to log into the website:www.ahaguru.com</p>
                  <p>All the best and Have a great Day!</p>
              <p>Thanks & Regards</p>
              <p>AHAGURU</p>
              <p>www.ahaguru.com</p>
              <p>+91-96001 00090</p>";
                   

		$placeholders=array('names','emails','pwd','school','standard','parents','parentrel','parentemail','mobile',
                                       'addr','state','city','pin','country');
     $string=array($user['Student']['name'],$user['Student']['email'],$user['Student']['password'],$user['Student']['school_name'],$standard[0]['standards']['name'],$user['Student']['parent_name'],
        $rel[0]['parent_relationships']['name'],$user['Student']['parent_email'],$user['Student']['mobile_number'],$user['Student']['address'],$user['Student']['state'],$user['Student']['place'],
        $user['Student']['postal_pin'],$user['Student']['country']);
     $rawstr = str_replace($placeholders, $string, $rawstring);
       $this->sendEmail($this->request->data['email'],null, "Ahaguru: Registration",$rawstr,null);
           //$this->redirect('/register_success/'.$user['Student']['id']);
        $message = array('result' => 'success','message'=>'You are successfully enrolled in the course '.$course['Course']['name'].'! Your password has been sent to the email ID <email> from info@ahaguru.com
If you don’t find it in your primary folder, please check your Updates/Spam/Trash folders as well.
Use the password to Log In and start learning at Ahaguru!', 'student_id'=>$user['Student']['id']);
	    }
      else if(sizeof($crs) > 0){
        $msg ="";
        foreach ($crs as $crses) { 
          $mapdata = array();       
      $mapdata['course_id'] = $crses['PromotionalCoupon']['course_id'];
      $mapdata['student_id'] = $this->Student->id;
      $mapdata['payment'] = 1;
      $mapdata['status'] = 1;
      $mapdata['course_mapped_type'] = 1;
      $mapdata['comments'] = "Promotional Code ".$data['coupon_code'];
      $this->StudentCourseMap->saveAll($mapdata);
      $this->StudentLessonSkip->skipLessons($mapdata['student_id'], $crses['PromotionalCoupon']['course_id'],$crses['PromotionalCoupon']['lesson_count']);
     $save = $this->StudentSkipLessons->skip($mapdata['student_id'], $crses['PromotionalCoupon']['course_id'],$crses['PromotionalCoupon']['lesson_count']);
        $course = $this->Course->findById($crses['PromotionalCoupon']['course_id']);
        $msg .=$course['Course']['name'].",";
      }
        $data['student_id'] = $this->Student->id;
        $regno=$this->Student->query("select reg_no from students where id = $data[student_id]");
    $user = $this->Student->findByEmail($this->request->data['email']);
    $standard=$this->Standard->query("select name from standards where id = $data[standard]");

    $rel=$this->ParentRelationship->query("select name from parent_relationships where id = $data[parent_relationship]");
    $rawstring = "<p>Dear names,</p>
                  <p>Welcome to Ahaguru Classes!</p>
                  <p>Ahaguru classes offer concept based learning environment with carefully designed courses based on intensive learning research done by Dr.Balaji Sampath.  Both Direct Classes as well as Online courses are available from Class 5 onwards up to class 12.</p>
                   <p>Thank you for your interest in our classes. </p>
                   <p>Your registration has been successful. </p>
                  <p>Please check your profile information and email:<a href=learn@ahaguru.com> learn@ahaguru.com </a> for any questions and clarifications.</p>
                 <p> Student name: names</p>
                 <p>Student Email ID : emails</p>
                 <p>School Name : school</p>
                 <p>Class in School : standard</p>
                 <p>Parent Name : parents</p>
                 <p>Relationship : parentrel</p>
                 <p>Parent Email ID : parentemail</p>
                 <p>Mobile Number : mobile</p>
                 <p>Address : addr </p>
                  <p> State : state</p>
                  <p>City/Village : city</p>
                  <p>PinCode : pin</p>
                   <p>Country : country</p>
                   <p>Your online account will use your email as your login username and your password that is given below:</p>
                  <p>Your User Name : emails</p>
                  <p>Your Password : pwd</p>
                  <p>Please use the above email id and password to log into the website:www.ahaguru.com</p>
                  <p>All the best and Have a great Day!</p>
              <p>Thanks & Regards</p>
              <p>AHAGURU</p>
              <p>www.ahaguru.com</p>
              <p>+91-96001 00090</p>";
                   

    $placeholders=array('names','emails','pwd','school','standard','parents','parentrel','parentemail','mobile',
                                       'addr','state','city','pin','country');
     $string=array($user['Student']['name'],$user['Student']['email'],$user['Student']['password'],$user['Student']['school_name'],$standard[0]['standards']['name'],$user['Student']['parent_name'],
        $rel[0]['parent_relationships']['name'],$user['Student']['parent_email'],$user['Student']['mobile_number'],$user['Student']['address'],$user['Student']['state'],$user['Student']['place'],
        $user['Student']['postal_pin'],$user['Student']['country']);
     $rawstr = str_replace($placeholders, $string, $rawstring);
        $this->sendEmail($this->request->data['email'],null, "Ahaguru: Registration",$rawstr,null);
           //$this->redirect('/register_success/'.$user['Student']['id']);
//         $message = array('result' => 'success','message'=>'You are successfully enrolled in the course '.$course['Course']['name'].'! Your password has been sent to the email ID <email> from learn@ahaguru.com
// If you don’t find it in your primary folder, please check your Updates/Spam/Trash folders as well.
// Use the password to Log In and start learning at Ahaguru!');
  $message = array('result' => 'success','message'=>'You are successfully enrolled in the course '.$msg.'! Your password has been sent to the email ID <email> from info@ahaguru.com
If you don’t find it in your primary folder, please check your Updates/Spam/Trash folders as well.
Use the password to Log In and start learning at Ahaguru!','student_id'=>$user['Student']['id']);

      }
    }
	   }
           echo json_encode($message);
    }else{
              $data = $this->request->data;
              $pwd = substr($data['Student']['name'],0,4);
               $data['Student']['password'] = $pwd.$this->unique_id();
               $data['Student']['user_id'] = $data['Student']['email'];
               // if($data['Student']['standard'] == 0) unset($data['Student']['standard']);
            $reg = $this->Student->save($data);
           if($reg){
                        $data['student_id'] = $this->Student->id;
                        $regno=$this->Student->query("select reg_no from students where id = $data[student_id]");
                $user = $this->Student->findByEmail($this->request->data['Student']['email']);
       
    $standard=$this->Standard->query("select name from standards where id = ".$data['Student']['standard']);

//    $rel=$this->ParentRelationship->query("select name from parent_relationships where id = ".$data['Student']['parent_relationship']);
    $rawstring = "<p>Dear names,</p>
                  <p>Welcome to Ahaguru Classes!</p>
                  <p>Ahaguru classes offer concept based learning environment with carefully designed courses based on intensive learning research done by Dr.Balaji Sampath.  Both Direct Classes as well as Online courses are available from Class 5 onwards up to class 12.</p>
                   <p>Thank you for your interest in our classes. </p>
                   <p>Your registration has been successful. </p>
                  <p>Please check your profile information and email:<a href=learn@ahaguru.com>learn@ahaguru.com </a> for any questions and clarifications.</p>
                 <p> Student name: names</p>
                 <p>Student Email ID :emails</p>
                
                 <p>Class in School: standard</p>
                
                   <p>Your online account will use your email as your login username and your password that is given below:</p>
                  <p>Your User Name: emails</p>
                  <p>Your Password: pwd</p>
                  <p>Please use the above email id and password to log into the website:www.ahaguru.com</p>
                  <p>All the best and Have a great Day!</p>
              <p>Thanks & Regards</p>
              <p>AHAGURU</p>
              <p>www.ahaguru.com</p>
              <p>+91-96001 00090</p>";
                   

    $placeholders=array('names','emails','pwd','standard');
     $string=array($user['Student']['name'],$user['Student']['email'],$user['Student']['password'],$standard[0]['standards']['name']);
           $rawstr = str_replace($placeholders, $string, $rawstring);
        $this->sendEmail($this->request->data['Student']['email'],null, "Ahaguru: Registration",$rawstr,null);
           $this->redirect('/register_success/'.$user['Student']['id']);

    }

    }
  }
}

   public function forgotpwd() {
   		if($this->request->is('post')) {
	  $data = $this->request->data;    
       	    $this->layout = "default";
            if(isset($data['classroom_reg']) && $data['classroom_reg'] ==1 ){
              $user = $this->ClassroomStudent->findByEmail($data['email']);
              if($user != null){
               $this->Student->id = $user['ClassroomStudent']['id'];       
               $regno=$this->Student->query("select reg_no from classroom_students where id = ".$user['ClassroomStudent']['id']);
                $user = $this->ClassroomStudent->findByEmail($this->request->data['email']);
       $msg = "Dear names,<br>
              <p>Hello from AhaGuru,</p>
              <p>You account has been accessed without a valid password.  Please use the following login and password to access your account.</p>
              <p>Your user name: email</p>
              <p>Your password : pwd</p><br><br>
              <p>All the best and Have a great Day!</p>
              <p>Thanks & Regards</p>
              <p>AHAGURU</p>
              <p>www.ahaguru.com</p>
              <p>+91-96001 00090</p>";
      $placeholders=array('names','email','pwd');
     $string=array($user['ClassroomStudent']['name'],$user['ClassroomStudent']['email'],$user['ClassroomStudent']['password']);
     $rawstr = str_replace($placeholders, $string, $msg);
       $this->sendEmail($user['ClassroomStudent']['email'], null,'Ahaguru: Password',$rawstr,null);
    $message = array( "result"=>"success", "message"=>"An email with your password has been sent to your email address <a>".$user['ClassroomStudent']['email']."</a>. Please check and Login.");
                      
      } else {
    $message = array("result"=>"fail", "message"=>"That e-mail address doesn't have an associated user account. Are you sure you've registered?");
   }}
            else{              
	       $user = $this->Student->findByUserId($data['email']);
         error_log("dds".print_r($user,true));
      	    if($user != null){
              if($user['Student']['email'] != ""){
               $this->Student->id = $user['Student']['id'];       
               $regno=$this->Student->query("select reg_no from students where id = ".$user['Student']['id']);
		            $user = $this->Student->findByUserId($this->request->data['email']);
              $msg = "Dear names,<br>
              <p>Hello from AhaGuru,</p>
              <p>You account has been accessed without a valid password.  Please use the following login and password to access your account.</p>
              <p>Your user name: email</p>
              <p>Your password : pwd</p><br><br>
              <p>All the best and Have a great Day!</p>
              <p>Thanks & Regards</p>
              <p>AHAGURU</p>
              <p>www.ahaguru.com</p>
              <p>+91-96001 00090</p>";
      $placeholders=array('names','email','pwd');
     $string=array($user['Student']['name'],$user['Student']['email'],$user['Student']['password']);
     $rawstr = str_replace($placeholders, $string, $msg);
      $this->sendEmail($user['Student']['email'],null, 'Ahaguru: Password',$rawstr,null);      
		$message = array( "result"=>"success", "message"=>"An email with your password has been sent to your email address <a>".$user['Student']['email']."</a>. Please check and Login.");
      }
      else
        $message = array("result"=>"noemail", "message"=>"User Id does not have an associated Email id. Please contact School co-ordinator or AhaGuru helpline number");                      
	    } else {
		$message = array("result"=>"fail", "message"=>"That e-mail address doesn't have an associated user account. Are you sure you've registered?");
   }}
             	    echo json_encode($message);
	}
    }

    public function login() {
    $uri = $_SERVER['HTTP_REFERER'];
      $uri = split("/", $uri);         
    if($this->request->is("post")) {
      $this->layout = "default";
        $data = $this->request->data;
    $PaymentRequest = new PaymentRequest();
    if(isset($data['classroom_reg']) && $data['classroom_reg']==1 ){
    $user = $this->Student->findByUserId($data['email']);     
    if($user['Student'] != null){      
    if(strtolower(trim($user['Student']['password'])) == strtolower(trim($data['password'])) && $user['Student']['deleted'] == 0) {
    unset($user['Student']['password']);
    $user['role'] = "student";
    $user['data'] = 'sdata';
       if($this->Auth->login($user)) { 
        $session_data = array();
        $session_data['user_id'] = $user['Student']['id'];
        $session_data['direct_classroom'] = 1;
        $session_data['user_agent'] = serialize($_SERVER['HTTP_USER_AGENT']);
        $this->SessionAnalytic->save($session_data);
          // if($uri[count($uri)-1] =="classroom_register")
            $message = array("result"=>"logged","id" =>$user['Student']['id']);
        // else
        //   $this->redirect("/student/student/classroom"); 
      }
      }
      else
        $message = array("result"=>"wrongpwd");
    }
      else
            $message = array("result"=>"invalid");

        echo json_encode($message);
  }
    else{
     $user = $this->Student->findByUserId(trim($this->request->data['Student']['email']));
      // $user = $this->Student->findByEmail($this->request->data['Student']['email']);     
     $admin = $this->Admin->findByEmail(trim($this->request->data['Student']['email']));     
    if($user['Student'] != null){
    if(strtolower(trim($user['Student']['password'])) == strtolower(trim($this->request->data['Student']['password'])) && $user['Student']['deleted'] == 0) {
    unset($user['Student']['password']);
    $user['role'] = "student";
    $user['data'] = 'sdata';
       if($this->Auth->login($user)) {       
        $session_data = array();
        $session_data['user_id'] = $user['Student']['id'];
        $session_data['user_agent'] = serialize($_SERVER['HTTP_USER_AGENT']);
        $this->SessionAnalytic->save($session_data);
        if(isset($this->request->data['Student']['wpp']))      
          $this->redirect("/student/agpuzzler"); 
        else
          $this->redirect("/student/course");         
      
    }}
    else {
      
         $msg = "Dear names,<br>
              <p>Hello from AhaGuru,</p>
              <p>You account has been accessed without a valid password.  Please use the following login and password to access your account.</p>
              <p>Your user name: email</p>
              <p>Your password : pwd</p><br><br>
              <p>All the best and Have a great Day!</p>
              <p>Thanks & Regards</p>
              <p>AHAGURU</p>
              <p>www.ahaguru.com</p>
              <p>+91-96001 00090</p>";
      $placeholders=array('names','email','pwd');
     $string=array($user['Student']['name'],$user['Student']['email'],$user['Student']['password']);     // $rawstr = str_replace($placeholders, $string, $msg);
     $this->sendEmail($user['Student']['email'], null,'Ahaguru: Password',$rawstr,null);
  $message = array("result"=>"You password was wrong. Enter the correct password.<br>
(In case you have forgotten your Ahaguru password, we have sent it to your email ID. Please look for an email from info@ahaguru.com.<br>
 If you don’t find it, please also check your Spam/Trash folders. Thank you!)"); 

   
      }
      }

      else if($admin['Admin'] != null){
      if ($admin['Admin']['password'] == $this->request->data['Student']['password'])
            {
                  unset($admin['Admin']['password']);
    $admin['role'] = "admin";
    $admin['data'] = 'adata';
    if($this->Auth->login($admin)) { 
      $_SESSION['auth'] = 1;
        $session_data = array();
        $session_data['user_id'] = $admin['Admin']['id'];
        $session_data['user_agent'] = serialize($_SERVER['HTTP_USER_AGENT']);
        $this->SessionAnalytic->save($session_data);
           $this->redirect("/admin/dashboard"); 
        // $this->redirect("http://localhost:8080/php-reports-master/?sessid=XXYYZZ");
    }}
    else
    $message = array("result"=>"You password was wrong. Enter the correct password."); 
      }

      else {
        $message = array("result"=>"Enter valid details."); 
      }
      
      echo json_encode($message);
   }}}

     

    public function coupon_login() {
      $uri = $_SERVER['HTTP_REFERER'];
      $uri = split("/", $uri);     
      $sesscoupon = substr($this->Session->read('coupon_code'),0,4);
      if(strcasecmp($sesscoupon,"APC2") == 0)
          $this->redirect("/TheHindu");
      if($this->Auth->user()){
        $user = $this->Auth->user();
        $this->redirect("/login_success/".$user['Student']['id']);
      }
   		if($this->request->is("post")) {
     		$data = $this->request->data;
        $this->layout = "default";      
     	  $user = $this->Student->findByUserId($data['email']);        
        // $user = $this->Student->findByEmail($data['email']);
      $admin = $this->Admin->findByEmail($data['email']);
  	   if($user['Student'] != null ){
   if(strtolower(trim($user['Student']['password'])) == strtolower(trim($data['password'])) && $user['Student']['deleted'] == 0) {
		unset($user['Student']['password']);
		$user['role'] = "student";
		$user['data'] = 'sdata';
	if($this->Auth->login($user)) { 
	    $session_data = array();
	    $session_data['user_id'] = $user['Student']['id'];
	  $session_data['user_agent'] = serialize($_SERVER['HTTP_USER_AGENT']);
	 $this->SessionAnalytic->save($session_data);

		    	$message = array("result"=>"success","message"=>$user['Student']['id']); 

		}}
		else {
			   $msg = "Dear names,<br>
              <p>Hello from AhaGuru,</p>
              <p>You account has been accessed without a valid password.  Please use the following login and password to access your account.</p>
              <p>Your user name: email</p>
              <p>Your password : pwd</p><br><br>
              <p>All the best and Have a great Day!</p>
              <p>Thanks & Regards</p>
              <p>AHAGURU</p>
              <p>www.ahaguru.com</p>
              <p>+91-96001 00090</p>";
      $placeholders=array('names','email','pwd');
     $string=array($user['Student']['name'],$user['Student']['email'],$user['Student']['password']);
     $rawstr = str_replace($placeholders, $string, $msg);
      $this->sendEmail($user['Student']['email'], null,'Ahaguru: Password',$rawstr,null);
	$message = array("result"=>"You password was wrong. Enter the correct password.<br>
(In case you have forgotten your Ahaguru password, we have sent it to your email ID. Please look for an email from info@ahaguru.com.<br>
 If you don’t find it, please also check your Spam/Trash folders. Thank you!)"); 

   
	    }}
	    else if($admin['Admin'] != null ){
	    	if($admin['Admin']['password'] == $this->request->data['password']) 
	    {
		unset($admin['Admin']['password']);
		$admin['role'] = "admin";
		$admin['data'] = 'adata';
		if($this->Auth->login($admin)) { 
		    $session_data = array();
		    $session_data['user_id'] = $admin['Admin']['id'];
		    $session_data['user_agent'] = serialize($_SERVER['HTTP_USER_AGENT']);
		    $this->SessionAnalytic->save($session_data);
          $message = array("result"=>"admin");
		  
		}}
		else 
			$message = array("result"=>"You password was wrong. Enter the correct password."); 

	    }
	    else
     	$message = array("result"=>"&nbsp Your email does not match our records.<br>
     	 To get a new Ahaguru account with your course coupon <a href='/'>click here.</a>"); 

      echo json_encode($message);

}
    }

    public function enquiry(){
    if($this->request->is("POST")){
        $this->layout = "default";
        $data = $this->request->data;
        $rawstr = "<p>Name : name</p><p>Email : email</p><p>message</p>";
        $placeholders=array('name','email','message');
       $string=array($data['name'],$data['email'],$data['query']);
           $rawstr = str_replace($placeholders, $string, $rawstr);         
        $this->sendEmail($data['toemail'],null,"Queries",$rawstr,$data['email']);
        $this->set("json",json_encode("Thank You!!! we will reach you soon"));
        //else 
         //$this->set("json",json_encode("Sorry!! Try later")); 
    }

    } 
  
    public function login1(){
      if($this->request->is("POST")){
        $this->layout = "default";
        $data = $this->request->data;
        $paymentinfo = $this->Session->read('paymentdata');
        if(isset($data['Student']['already_exist'])){
         $data['Student']['pay_flag'] = $paymentinfo['pay_flag'];
         $data['Student']['course'] = $paymentinfo['courses'];
         $data['Student']['fee'] = $paymentinfo['fee'];
        }
        $PaymentRequest = new PaymentRequest();
        $this->layout = "default";
         $user = $this->Student->findByUserId($this->request->data['Student']['email']);
         // $user = $this->Student->findByEmail($this->request->data['Student']['email']);
        $admin = $this->Admin->findByEmail($this->request->data['Student']['email']);
        if($user['Student'] != null && (strtolower(trim($user['Student']['password'])) == strtolower(trim($this->request->data['Student']['password']) )) && $user['Student']['deleted'] == 0) {
          unset($user['Student']['password']);
          $user['role'] = "student";
          $user['data'] = 'sdata';
       if($this->Auth->login($user)) { 
        $session_data = array();
        $session_data['user_id'] = $user['Student']['id'];
        $session_data['user_agent'] = serialize($_SERVER['HTTP_USER_AGENT']);
        $this->SessionAnalytic->save($session_data);
        if($data['Student']['pay_flag']){
         $course_id = explode(",",$data['Student']['course']) ;
         $this->Session->write("courses",$course_id);
         
         $i = 0;
         foreach ($course_id as $coures) {
           $con = array(
            'StudentCourseMap.course_id' => $coures,
            'StudentCourseMap.student_id' => $user['Student']['id'],
            'StudentCourseMap.deleted' => 0
            );

           $course = $this->StudentCourseMap->find("first",array('conditions' => $con ));
           if(!empty($course))
          if(strpos($course['StudentCourseMap']['comments'],"Promotional") === FALSE){
            $courses[$i] = $course;
           $i++;
         }}
           if(empty($courses)){
         
             $payment['regno'] = $user['Student']['reg_no'];    
         $payment['fee']= $data['Student']['fees'];
         $payment['courses'] = $data['Student']['course'];
           $this->Session->write("paymentdata",$payment);
                
           $result['student_id'] = $user['Student']['id'];
          $message = array("result" =>"encrypt","msg"=>$result); 
        }
        else
         $message = array("result" =>"encrypt_fail");  
         }
        else{  
          $result['student_id'] = $user['Student']['id'];
          $message = array("result" =>"logged","msg"=>$result); 
        }
    }
    else $this->Session->setFlash("Please enter valid details."); 
      }

      else if($admin['Admin'] != null && ($admin['Admin']['password'] == $this->request->data['Student']['password'])) 
      {
    unset($admin['Admin']['password']);
    $admin['role'] = "admin";
    $admin['data'] = 'adata';
    if($this->Auth->login($admin)) { 
        $session_data = array();
        $session_data['user_id'] = $admin['Admin']['id'];
        $session_data['user_agent'] = serialize($_SERVER['HTTP_USER_AGENT']);
        $this->SessionAnalytic->save($session_data);
          $message = array("result" =>"admin","msg"=>$result); 
      //  $this->redirect("/admin/dashboard"); 
    }
    else $this->Session->setFlash("&nbsp Please enter valid details."); 
      }
      else{
          $message = array("result" =>"fail","msg"=>"Enter valid details"); 
     
   }
   $this->set("json",json_encode($message));
     }
    }

    public function registerSuccess(){
      $user = $this->Student->findById($this->params['id']);
	$this->set('user_name', $user['Student']['name']);
	$this->set('user_email', $user['Student']['email']);
	$this->set('reg_no', $user['Student']['reg_no']);
        $this->set('id',$user['Student']['id']);
	$this->render('register_success');
    $user1 = $this->Student->findByEmail($this->request->$user['Student']['email']);
      $admin1 = $this->Admin->findByEmail($this->request->$user['Student']['email']);
    		unset($user1['Student']['password']);
		$user1['role'] = "student";
		$user1['data'] = 'sdata';
		if($this->Auth->login($user1)) { 
    		    $session_data = array();
		    $session_data['user_id'] = $user['Student']['id'];
		    $session_data['user_agent'] = serialize($_SERVER['HTTP_USER_AGENT']);
		    $this->SessionAnalytic->save($session_data);
		
	}
	
    }
    
    public function loginSuccess(){
	  if($this->request->is("post")) {
      $data = $this->request->data;      
        $this->layout="default";        
      $user = $this->Student->findByEmail($data['email']);
      unset($data['email']);
      $this->Student->save($data);
      $crs= $this->CourseCouponMap->find("first",array('conditions'=>
         	array('CourseCouponMap.coupon_code'=>$data['coupon_code'],
               'CourseCouponMap.status'=>1,
      	       'CourseCouponMap.deleted'=>0)));
       if(empty($crs)){
      // $crs= $this->PromotionalCoupon->find("first",array('conditions'=>
      //  array('PromotionalCoupon.coupon_code'=>$data['coupon_code'],       
      //  'PromotionalCoupon.deleted'=>0)));
        $crs= $this->PromotionalCoupon->find("all",array('conditions'=>
       array('PromotionalCoupon.coupon_code'=>$data['coupon_code'],       
       'PromotionalCoupon.deleted'=>0)));
      }

       if(empty($crs))
     	$result = array("msg"=>"fail","message"=>"Enter Correct Coupon Code");
     else{       
      if(isset($crs['CourseCouponMap'])){
     	$mapdata['course_id'] = $crs['CourseCouponMap']['course_id'];
     	$mapdata['student_id'] = $data['id'];
     	$mapdata['payment'] = 2;
     	$mapdata['status'] = 1;
      $mapdata['course_mapped_type'] = 2;
     	$mapdata['comments'] = "Added by couponcode ".$data['coupon_code'];
     	$con = array(
     		'StudentCourseMap.course_id' => $crs['CourseCouponMap']['course_id'],
     		'StudentCourseMap.student_id' => $data['id'],
     		'StudentCourseMap.deleted' => 0
     		);
      $course = $this->Course->findById($crs['CourseCouponMap']['course_id']);
     	$mapping = $this->StudentCourseMap->find("first",array('conditions' => $con ));        
     	if(empty($mapping)){
     	$this->StudentCourseMap->save($mapdata);
      $this->CourseCouponMap->addinfo($data['coupon_code'],$crs['CourseCouponMap']['course_id'],$user['Student']['email']);
     	$result = array("msg"=>"success","message" => "You have been successfully enrolled in the course.
               ".$course['Course']['name']."<br> 
     		This course has been added to your ‘My Courses’ page. Thanks for learning at Ahaguru!");
     }
     else if(strpos($mapping['StudentCourseMap']['comments'],"Promotional") !== false){
      $mapdata['id'] = $mapping['StudentCourseMap']['id'];
        $this->StudentCourseMap->save($mapdata);
       $this->CourseCouponMap->addinfo($data['coupon_code'],$crs['CourseCouponMap']['course_id'],$user['Student']['email']);
      $result = array("msg"=>"success","message" => "You have been successfully enrolled in the course.
               ".$course['Course']['name']."<br> 
        This course has been added to your ‘My Courses’ page. Thanks for learning at Ahaguru!");
     }
      else
       $result = array("msg"=>"fail","message" => "<p><font size='4px'>You have already enrolled in <b>".$course['Course']['name']."</b> Please go to MyCourses page to start learning</font></p>
       ");     
     
     }
     else if(sizeof($crs) > 0){
      $msg="";
      $mapped=0;$tagging=0;
      foreach ($crs as $crse) {     
      $mapdata = array();
      $mapdata['course_id'] = $crse['PromotionalCoupon']['course_id'];
      $mapdata['student_id'] = $data['id'];
      $mapdata['payment'] = 1;
      $mapdata['status'] = 1;
      $mapdata['course_mapped_type'] = 2;
      $mapdata['comments'] = "Promotional Code ".$data['coupon_code'];
      $mapdata['coupon_code'] = $data['coupon_code'];
      $con = array(
        'StudentCourseMap.course_id' => $crse['PromotionalCoupon']['course_id'],
        'StudentCourseMap.student_id' => $data['id'],
        'StudentCourseMap.deleted' => 0
        );
      $course = $this->Course->findById($crse['PromotionalCoupon']['course_id']);
       
      $mapping = $this->StudentCourseMap->find("first",array('conditions' => $con ));      
      if(empty($mapping)){
      $this->StudentCourseMap->saveAll($mapdata);
      $this->StudentLessonSkip->skipLessons($data['id'], $crse['PromotionalCoupon']['course_id'],$crse['PromotionalCoupon']['lesson_count']);
     $save = $this->StudentSkipLessons->skip($data['id'], $crse['PromotionalCoupon']['course_id'],$crse['PromotionalCoupon']['lesson_count']);
     $msg .=$course['Course']['name']." ,";
     $mapped++;
       // $result = array("msg"=>"success","message" => "You have been successfully enrolled in the course.
               // ".$course['Course']['name']."<br> 
   }
   else{   
     if(strpos($mapping['StudentCourseMap']['comments'],$data['coupon_code']) === FALSE){      
      $mapping['StudentCourseMap']['comments'] = $mapping['StudentCourseMap']['comments'].",Promotional Code ".$data['coupon_code'];
      $mapping['StudentCourseMap']['coupon_code'] = $data['coupon_code'];      
       $this->StudentCourseMap->saveAll($mapping);
       $tagging++;
     }
     else{      
        $mapping['StudentCourseMap']['coupon_code'] = $data['coupon_code'];
       $this->StudentCourseMap->saveAll($mapping);
       $tagging++;
     }
        
   }

    }
     if($mapped > 0){
     $result = array("msg"=>"success","message" => "You have been successfully enrolled in the course
               ".$msg."<br> 
        This course has been added to your ‘My Courses’ page. Thanks for learning at Ahaguru!");
     }
     else if($tagging > 0){
     $result = array("msg"=>"success","message" => "Your Coupon is Accepted. Thanks for learning at Ahaguru!");
     }
    else               
     $result = array("msg"=>"fail","message" => "<p><font size='4px'>You have already enrolled in <b>".$course['Course']['name']."</b> Please go to MyCourses page to start learning</font></p>
       ");     
   }
     }
         echo json_encode($result);
    }
}

    public function resetpwd(){
     	if($this->request->is('post')) {
	    $this->layout = "default";

	    $user= $this->Auth->user();
	    $user = $this->Student->findByUserId($user['Student']['email']);
      // $user = $this->Student->findByEmail($user['Student']['email']);
	    $current_password = $this->request->data['password'];
	    if(strtolower(trim($current_password)) == strtolower(trim($user['Student']['password']))){
		$user['Student']['password'] = $this->request->data['new_password'];
		$this->Student->id = $user['Student']['id'];
		$this->Student->save($user);
		$msg = array("result"=>"success","message"=> "Password reset successfully.");
	    }
	    else {
		$msg = array("result"=>"fail","message"=>"Unable to reset password. Please type the correct existing password.");
    }
	    echo json_encode($msg);    
	}
    }


    public function curl_get($url) {
	$curl = curl_init($url);
 	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($curl, CURLOPT_TIMEOUT, 30);
	$return = curl_exec($curl);
	curl_close($curl);
  	return $return;
    }

    public function embed() {
	$this->layout = "default";
	$url = $this->request->query['url'];
	$json = "";
 	if(strstr($url,"youtube"))
	    $json = $this->curl_get("http://www.youtube.com/oembed?url=".rawurlencode($url)."&format=json&callback=foo");
	else if(strstr($url,"vimeo"))
	    $json = $this->curl_get("http://vimeo.com/api/oembed.json?url=".rawurlencode($url));
	if(is_object(json_decode($json)) == 1) {
             	    $this->set("json", $json);
	} else {
	    $this->set("json", json_encode(array("html" => "<h3>Video not available. Please try later.</h3>")));
	}
    }
 
public function getall_school() {
    $this->layout = "default";     
    $this->set("school", json_encode($this->School->find('all')));
    }  
 
public function classroom(){
	$this->layout = "ahaguru";
  unset($_SESSION['wpp']);      
  $this->set("standard", $this->Standard->find('all',array( 'order' => array('Standard.name' => 'DESC'))));
  if($this->Auth->user()){
    $user = $this->Auth->user();
    if($user['role'] != "admin")      
      $this->redirect("/student/classroom");
    else
      $this->set("register","disable");
  }
  
}

public function online(){
	$this->layout = "ahaguru";
  unset($_SESSION['wpp']);      
  $this->Session->write("sourcefrom","online");  
  if($this->Auth->user()){
    $user = $this->Auth->user();
    if($user['role'] != "admin")
      $this->redirect("/student/student/allcourse");     

    }
}    

public function books(){
	$this->layout = "ahaguru";
  if($this->Auth->user()){
    $user = $this->Auth->user();
    if($user['role'] != "admin")
      $this->redirect("/student/books");    
  }  
  $this->set('students',$this->Student->find("all",array('conditions' => array('Student.deleted'=> 0))));
    $student=$this->Student->find("all",array('conditions' => array('Student.deleted'=> 0),'order'=>array('Student.id'=>'DESC limit 18')));
    for($i = 0;$i<18;$i++){
     if ( file_exists(WWW_ROOT."/img/usr".$student[$i]['Student']['id']."/profile_200.jpg") ) {
      $user[$i]['photo'] = "/img/usr".$student[$i]['Student']['id']."/profile_200.jpg";
    } else 
      $user[$i]['photo'] = "Photo Not Available";
      $user[$i]['name'] = $student[$i]['Student']['name'];
    }
    $this->set("users",$user);
  $this->set("standard", $this->Standard->find('all',array( 'order' => array('Standard.name' => 'DESC'))));
}
 public function disclaimer(){
 	$this->layout = "ahaguru";
}

 public function trmsandcon(){
 	$this->layout = "ahaguru";
}

 public function privacy(){
 	$this->layout = "ahaguru";
}
public function getuser($id){
  $this->layout = 'default';
	$user = $this->Student->findById($id);
 $this->set('json',json_encode($user));
} 

public function getUserById($id){
 $this->layout = 'default';
  $user = $this->Student->findById($id);
 $this->set('json',json_encode($user));
}

public function photos(){
  $this->layout = 'default';
     $students=$this->Student->find("all",array('conditions' => array('Student.deleted'=> 0)));
  $student=$this->Student->find("all",array('conditions' => array('Student.deleted'=> 0),'order'=>array('Student.id'=>'DESC limit 18')));
  $user['student'] = count($students);
    for($i = 0;$i<18;$i++){
     if ( file_exists(WWW_ROOT."/img/usr".$student[$i]['Student']['id']."/profile_200.jpg") ) {
      $user['students'][$i]['photo'] = "/img/usr".$student[$i]['Student']['id']."/profile_200.jpg";
    } else 
      $user['students'][$i]['photo'] = "Photo Not Available";
      $user['students'][$i]['name'] = $student[$i]['Student']['name'];
    }

    $this->set("json",json_encode($user));

}

public function relationship(){
$this->layout = 'default';

  $this->set("json", json_encode($this->ParentRelationship->find('all')));
}

public function stud_register(){
      $paymentinfo = $this->Session->read('paymentdata');
    if($this->request->is("post")) {
      $data = $this->request->data;
      $this->layout="default";        
          $pwd = substr($data['Student']['name'],0,4);
          $data['Student']['password'] = $pwd.$this->unique_id();
          $data['Student']['user_id'] = $data['Student']['email'];
             $reg = $this->Student->save($data);
         if($reg){
             $data['Student']['id'] = $this->Student->id;

        $regno=$this->Student->query("select reg_no from students where id =".$data['Student']['id']);
    $user = $this->Student->findByEmail($this->request->data['Student']['email']);
    $standard=$this->Standard->query("select name from standards where id =".$data['Student']['standard']);

    $rel=$this->ParentRelationship->query("select name from parent_relationships where id =".$data['Student']['parent_relationship']);
    $rawstring = "<p>Dear names,</p>
                  <p>Welcome to Ahaguru Classes!</p>
                  <p>Ahaguru classes offer concept based learning environment with carefully designed courses based on intensive learning research done by Dr.Balaji Sampath.  Both Direct Classes as well as Online courses are available from Class 5 onwards up to class 12.</p>
                   <p>Thank you for your interest in our classes. </p>
                   <p>Your registration has been successful. </p>
                  <p>Please check your profile information and email:<a href=learn@ahaguru.com>learn@ahaguru.com </a> for any questions and clarifications.</p>
                 <p> Student name: names</p>
                 <p>Student Email ID :emails</p>
                 <p>School Name: school</p>
                 <p>Class in School: standard</p>
                 <p>Parent Name: parents</p>
                 <p>Relationship : parentrel</p>
                 <p>Parent Email ID : parentemail</p>
                 <p>Mobile Number: mobile</p>
                 <p>Address: addr </p>
                  <p> State: state</p>
                  <p>City/Village: city</p>
                  <p>PinCode : pin</p>
                   <p>Country: country</p>
                   <p>Your online account will use your email as your login username and your password that is given below:</p>
                  <p>Your User Name: emails</p>
                  <p>Your Password: pwd</p>
                  <p>Please use the above email id and password to log into the website:www.ahaguru.com</p>
                  <p>All the best and Have a great Day!</p>
              <p>Thanks & Regards</p>
              <p>AHAGURU</p>
              <p>www.ahaguru.com</p>
              <p>+91-96001 00090</p>";
                $placeholders=array('names','emails','pwd','school','standard','parents','parentrel','parentemail','mobile',
                                       'addr','state','city','pin','country');
     $string=array($user['Student']['name'],$user['Student']['email'],$user['Student']['password'],$user['Student']['school_name'],$standard[0]['standards']['name'],$user['Student']['parent_name'],
        $rel[0]['parent_relationships']['name'],$user['Student']['parent_email'],$user['Student']['mobile_number'],$user['Student']['address'],$user['Student']['state'],$user['Student']['place'],
        $user['Student']['postal_pin'],$user['Student']['country']);
     $rawstr = str_replace($placeholders, $string, $rawstring);
         $this->sendEmail($this->request->data['Student']['email'], null,"Ahaguru: Registration",$rawstr,null);
    
          unset($user['Student']['password']);
    $user['role'] = "student";
    $user['data'] = 'sdata';
   if($this->Auth->login($user)) { 
            $session_data = array();
        $session_data['user_id'] = $user['Student']['id'];
        $session_data['user_agent'] = serialize($_SERVER['HTTP_USER_AGENT']);
       $this->SessionAnalytic->save($session_data);
  }
             
       $course_id = explode(",",$paymentinfo['courses']) ;      
       $paymentdata['fee'] = $paymentinfo['fee'];
       $paymentdata['courses'] = $paymentinfo['courses'];
       $paymentdata['regno'] = $regno[0]['students']['reg_no'];
       $this->Session->write($paymentdata);
       $this->Session->write("courses",$course_id);
       $this->Session->write("purchasemode","online signup");    
       $PaymentRequest = new PaymentRequest();
       $results= $PaymentRequest->sendRequest($paymentdata);
       $message = array("result" =>"encrypt","msg"=>$results); 
        $this->set("json",json_encode($message));
        // $this->redirect("/payment/response");

         }
    //$paymentinfo = $this->Session->read('paymentdata');
    
    }
}

public function quiz(){
  $this->layout = "ahaguru";
}

public function sessionvariable(){
   if($this->request->is("post")){
    $data = $this->request->data;
    $this->layout="default";
    $this->Session->write("studentlevel",$data['level']); 
    $this->set("json",json_encode("done"));
  }
}

public function thehindu(){
  $this->layout = "ahaguru";
     $this->set('students',$this->Student->find("all",array('conditions' => array('Student.deleted'=> 0))));
     $this->set("standard", $this->Standard->find('all',array( 'order' => array('Standard.name' => 'DESC'))));      
     if($this->Auth->user()){
    $user = $this->Auth->user();
    if($user['role'] == "admin"){
      $this->set("loggedin","admin");      
    }
    else if(isset($user['ClassroomStudent']) || (isset($user['Student']) && isset($_SESSION['classroomstudent'])))
      $this->set("loggedin","classroomstudent");          
    else if(isset($user['Student']) && !isset($_SESSION['classroomstudent']))
      $this->set("loggedin","student");          

    }
    else{
      $this->set("loggedin","no");      
    }    

     $url = $_SERVER["REQUEST_URI"];    
     if(strtolower($url) == "/hindu" || strtolower($url) == "/thehindu"){
      $this->set("juniorbox","JUNIOR999.png");
      $this->set("seniorbox","SENIOR999.png");
      $this->set("discount","0");
      $this->Session->write("studentfees",999); 
      }            
      else if(strtolower($url) == "/hindu?utm_source=facebook" || strtolower($url) == "/thehindu?utm_source=facebook"){
      $this->set("juniorbox","JUNIOR999.png");
      $this->set("seniorbox","SENIOR999.png");
      $this->set("discount","0");
      $this->Session->write("studentfees",999); 
      }            
       else{
      $this->set("juniorbox","JUNIORS899.png");
      $this->set("seniorbox","SENIORS899.png");
      $this->set("discount","1");
      $this->Session->write("studentfees",899);
        }
        
        if(strtolower($url) == "/hindu?utm_source=thinkvidya" || strtolower($url) == "/thehindu?utm_source=thinkvidya"){
          $this->Session->write("sourcefrom","thinkvidya"); 
        }
        else if(strtolower($url) == "/hindu?utm_source=facebook" || strtolower($url) == "/thehindu?utm_source=facebook"){
          $this->Session->write("sourcefrom","facebook"); 
        }
        else if(strtolower($url) == "/hindu?utm_source=free_signup" || strtolower($url) == "/thehindu?utm_source=free_signup"){
          $this->Session->write("sourcefrom","free_signup"); 
        }
        else if(strtolower($url) == "/hindu?utm_source=quiz" || strtolower($url) == "/thehindu?utm_source=quiz"){
                  $this->Session->write("sourcefrom","quiz"); 
        }
        else
          $this->Session->write("sourcefrom","hindu_direct"); 
}

public function hindu_registration(){
  $this->layout = "ahaguru";  
  if($this->Auth->user()){
    $user = $this->Auth->user();
    if($user['role'] == "admin" || isset($user['ClassroomStudent']) || isset($_SESSION['classroom'])){
      $this->redirect("/thehindu");
    }}    
  $this->set("level",$this->Session->read("studentlevel"));
}

public function hsignup(){
  $this->layout="ahaguru";        
   if($this->Auth->user()){
    $user = $this->Auth->user();
    if($user['role'] == "admin" || isset($user['ClassroomStudent']) || isset($_SESSION['classroom'])){
      $this->redirect("/thehindu");
    }}    
  $this->set("standard", $this->Standard->find('all',array( 'order' => array('Standard.name' => 'DESC'))));
  $this->set("email",$this->Session->read("studentemail"));
  $this->set("level",$this->Session->read("studentlevel"));
}

public function hlogin(){  
  $this->set("email",$this->Session->read("studentemail"));  
  $this->set("level",$this->Session->read("studentlevel"));
  $this->layout="ahaguru";
  if($this->Auth->user()){
    $user = $this->Auth->user();
    if($user['role'] == "admin" || isset($user['ClassroomStudent']) || isset($_SESSION['classroom'])){
      $this->redirect("/thehindu");
    }}    
}

public function hloginsubmit(){
  if($this->request->is("post")){
    $data = $this->request->data;
    $this->layout="default";
    $cmt = $this->Session->read("sourcefrom");
    // $user = $this->Student->findByUserId($data['email']);
    $user = $this->Student->findByEmail($data['email']);
    $admin = $this->Admin->findByEmail($data['email']);
    $level = $data['level'];
    if($user['Student'] != null ){
    if(strtolower(trim($user['Student']['password'])) == strtolower(trim($data['password'])) && $user['Student']['deleted'] == 0) {
    unset($user['Student']['password']);
    $user['role'] = "student";
    $user['data'] = 'sdata';
    if($this->Auth->login($user)) { 
      $session_data = array();
      $session_data['user_id'] = $user['Student']['id'];
      $session_data['user_agent'] = serialize($_SERVER['HTTP_USER_AGENT']);
      $this->SessionAnalytic->save($session_data);
      $cond = array(
        'StudentCourseMap.student_id'=>$user['Student']['id'],
        'StudentCourseMap.comments LIKE'=> "%Hindu%",
        'StudentCourseMap.challenge_type' =>"PC2",
        'StudentCourseMap.deleted'=>0,
        );
      $hinducoursemap = $this->StudentCourseMap->find("first",array('conditions'=>$cond));
      if(empty($hinducoursemap)){
         $msg = array("result"=>"validlogin",'id'=>$user['Student']['id']);
      // $con = array(
      //   'StudentCourseMap.student_id'=>$user['Student']['id'],
      //   'StudentCourseMap.payment'=>2,
      //   'StudentCourseMap.deleted'=>0,
      //   );
      // $coursemap = $this->StudentCourseMap->find("all",array('conditions'=>$con));      
      // if(empty($coursemap)) //if not even single course approved
      //    $msg = array("result"=>"validlogin",'id'=>$user['Student']['id']);
      // else{ //if atleast single course approved
      //           if($level == 1){
      //         $course_id[0] = 42;
      //         $course_id[1] = 41;
      //       }      
      //       else if($level == 2){
      //         $course_id[0] = 39;      
      //         $course_id[1] = 40;
      //       }      
      //       foreach ($course_id as $value) {      
      //       $mapdata = array();
      //       $mapdata['course_id'] = $value;
      //       $mapdata['student_id'] = $user['Student']['id'];
      //       $mapdata['payment'] = 2;
      //       $mapdata['status'] = 1;
      //       $mapdata['challenge_type'] = "PC2";
      //       $mapdata['course_mapped_type'] = 2;
      //       $mapdata['deleted'] = 0;
      //       $mapdata['comments'] = $cmt.",Hindu Existing Student login";
      //       $con = array(
      //         'StudentCourseMap.course_id' => $value,
      //         'StudentCourseMap.student_id' => $user['Student']['id'],
      //          'StudentCourseMap.deleted' => 0
      //         );      
      //       $mapping = $this->StudentCourseMap->find("first",array('conditions' => $con ));          
      //            if(empty($mapping)){                          
      //               $this->StudentCourseMap->saveAll($mapdata);            
      //         }
      //         else{                          
      //           $mapdata['id'] = $mapping['StudentCourseMap']['id'];
      //           $comments = $mapping['StudentCourseMap']['comments'];                    
      //           if(strpos($comments,$mapdata['comments']) === FALSE){
      //             $comments .= ",".$mapdata['comments'];          
      //             $mapdata['comments'] = $comments;           
      //             $this->StudentCourseMap->saveAll($mapdata);        
      //           }
      //           else{
      //             unset($mapdata['comments']);                  
      //            $this->StudentCourseMap->saveAll($mapdata);        
      //           }
      //         }       
      //       }
      //       $msg = array("result"=>"valid","msg"=>"mapped","role"=>"student");
      //   }
      }
          else $msg = array("result"=>"invalid","msg"=>"already enrolled");
          }
        }
        else $msg = array("result"=>"wrongpwd","msg"=>"Enter Valid Password");
      }
      else if($admin['Admin'] != null ){
        if($admin['Admin']['password'] == $this->request->data['password']) 
        {
          unset($admin['Admin']['password']);
          $admin['role'] = "admin";
          $admin['data'] = 'adata';
          if($this->Auth->login($admin)) { 
              $session_data = array();
              $session_data['user_id'] = $admin['Admin']['id'];
              $session_data['user_agent'] = serialize($_SERVER['HTTP_USER_AGENT']);
              $this->SessionAnalytic->save($session_data);      
              $msg = array("result"=>"valid","role"=>"admin");
          }
  }       else $msg = array("result"=>"wrongpwd","msg"=>"Enter Valid Password");
        }
      else $msg = array("result"=>"wrongpwd","msg"=>"Enter Valid Password");
      
     $this->set("json",json_encode($msg));
    }
  }

public function hregister(){    
    if($this->request->is("post")) {
      $data = $this->request->data;
      $this->layout="default";        
      $level = $data['Student']['level'];
      if($this->Auth->user()){
               $user = $this->Auth->user();
               $regno=$this->Student->query("select reg_no from students where id =".$user['Student']['id']);
            // $data['Student']['id'] = $user['Student']['id'];
            // $reg = $this->Student->save($data);      
      }
      else{
      $pwd = substr($data['Student']['name'],0,4);
      $data['Student']['password'] = $pwd.$this->unique_id();
      $data['Student']['user_id'] = $data['Student']['email'];
      $reg = $this->Student->save($data);      
      if($reg){
        $this->Session->write("user_type","newuser");
        $data['Student']['id'] = $this->Student->id;        
        $regno=$this->Student->query("select reg_no from students where id =".$data['Student']['id']);
        $user = $this->Student->findByEmail($this->request->data['Student']['email']);
        $standard=$this->Standard->query("select name from standards where id =".$data['Student']['standard']);
        unset($user['Student']['password']);
        $user['role'] = "student";
        $user['data'] = 'sdata';
        if($this->Auth->login($user)) { 
          $session_data = array();
          $session_data['user_id'] = $user['Student']['id'];
          $session_data['user_agent'] = serialize($_SERVER['HTTP_USER_AGENT']);
          $this->SessionAnalytic->save($session_data);
        }}}
       if($level == 1){ 
        $course_id[0] = 41;
        $course_id[1] = 42;
        $courses = implode(',',$course_id);       
       $fees = $this->Session->read("studentfees");
       $ch1 = $this->StudentCourseMap->find("first", array('conditions' => 
        array('StudentCourseMap.student_id' => $user['Student']['id'],
          'StudentCourseMap.challenge_type' => "PC1",
          'StudentCourseMap.deleted' =>0)));
       $sesscoupon = $this->Session->read('coupon_code');      
        if(stripos($sesscoupon,"APC2S") === FALSE){
      $sesscoupon = substr($sesscoupon,0,4);              
      }
      else if(stripos($sesscoupon,"APC2S") !== FALSE){
      $sesscoupon = substr($sesscoupon,0,5);            
      }
      if(strcasecmp($sesscoupon,"APC2") == 0)
        $fees = 799;
      else if(strcasecmp($sesscoupon,"APC2S") == 0)
        $fees = 899;
      else if(!empty($ch1))
        $fees = 899;
       $paymentdata['fee'] = $fees;
       $paymentdata['courses'] = $courses ;
       $paymentdata['regno'] = $regno[0]['students']['reg_no'];
         error_log("fees".print_r($paymentdata,true));
       $this->Session->write($paymentdata);
       $this->Session->write("courses",$course_id);
      }
      else if($level == 2){ 
        $course_id[0] = 40;
        $course_id[1] = 39;
        $courses = implode(',',$course_id);              
       $fees = $this->Session->read("studentfees");
        $ch1 = $this->StudentCourseMap->find("first", array('conditions' => 
        array('StudentCourseMap.student_id' => $user['Student']['id'],
          'StudentCourseMap.challenge_type' => "PC1",
          'StudentCourseMap.deleted' =>0)));
      $sesscoupon = $this->Session->read('coupon_code');      
        if(stripos($sesscoupon,"APC2S") === FALSE){
      $sesscoupon = substr($sesscoupon,0,4);              
      }
      else if(stripos($sesscoupon,"APC2S") !== FALSE){
      $sesscoupon = substr($sesscoupon,0,5);            
      }
      if(strcasecmp($sesscoupon,"APC2") == 0)
        $fees = 799;
      else if(strcasecmp($sesscoupon,"APC2S") == 0)
        $fees = 899;
        else if(!empty($ch1))
        $fees = 899;
       $paymentdata['fee'] = $fees;
       $paymentdata['courses'] = $courses ;
       $paymentdata['regno'] = $regno[0]['students']['reg_no'];
       error_log("fees".print_r($paymentdata,true));
       $this->Session->write($paymentdata);
       $this->Session->write("courses",$course_id);
      }     
      $this->Session->write("purchasemode","hindu signup");    
      $this->Session->write('course_mapped_type',1);
      $PaymentRequest = new PaymentRequest();
      $results= $PaymentRequest->sendRequest($paymentdata);
      $message = array("result" =>"encrypt","msg"=>$results,"student_id"=>$user['Student']['id']);       
      $this->set("json",json_encode($message));
      // $this->redirect("/payment/hresponse");
         }
    //$paymentinfo = $this->Session->read('paymentdata');
  
}

public function hlogin_success($id){
      $this->layout="ahaguru";
      if($this->Auth->user()){
    $user = $this->Auth->user();
    if($user['role'] == "admin" || isset($user['ClassroomStudent'])){
      $this->redirect("/thehindu");
    }}    
      $this->set("standard", $this->Standard->find('all',array( 'order' => array('Standard.name' => 'DESC'))));
      $this->set("user",$this->Student->findById($id));             
      $this->set("level",$this->Session->read("studentlevel"));      
    }

  public function hloginsuccess($id){
    if($this->request->is("post")) {
      $data = $this->request->data;       
      error_log("aa".print_r($data,true));
      $this->layout="default";
      $level = $data['Student']['level'];
      $user = $this->Student->findByUserId($data['Student']['user_id']);
      unset($data['Student']['email']);
      $this->Student->save($data);             
      if($level == 1){ 
        $course_id[0] = 42;
        $course_id[1] = 41;
        $courses = implode(',',$course_id);       
       foreach ($course_id as $key => $value) {
        $cour = $this->Course->findById($value);
        if($cour['Course']['discount'] == 0)
          $fees += $cour['Course']['fee'];
        else
          $fees += $cour['Course']['discount'];
       }             
       $fees = $this->Session->read("studentfees");
        $ch1 = $this->StudentCourseMap->find("first", array('conditions' => 
        array('StudentCourseMap.student_id' => $user['Student']['id'],
          'StudentCourseMap.challenge_type' => "PC1",
          'StudentCourseMap.deleted' =>0)));
      $sesscoupon = $this->Session->read('coupon_code');      
        if(stripos($sesscoupon,"APC2S") === FALSE){
      $sesscoupon = substr($sesscoupon,0,4);              
      }
      else if(stripos($sesscoupon,"APC2S") !== FALSE){
      $sesscoupon = substr($sesscoupon,0,5);            
      }
      if(strcasecmp($sesscoupon,"APC2") == 0)
        $fees = 799;
      else if(strcasecmp($sesscoupon,"APC2S") == 0)
        $fees = 899;
       else if(!empty($ch1))
        $fees = 899;
       $paymentdata['fee'] = $fees;
       $paymentdata['courses'] = $courses ;
       $paymentdata['regno'] = $user['Student']['reg_no'];
       error_log("feeslogin".print_r($paymentdata,true));
       $this->Session->write($paymentdata);
       $this->Session->write("courses",$course_id);
      }
      else if($level == 2){ 
        $course_id[0] = 39;
        $course_id[1] = 40;
        $courses = implode(',',$course_id);       
       foreach ($course_id as $key => $value) {
        $cour = $this->Course->findById($value);
        if($cour['Course']['discount'] == 0)
          $fees += $cour['Course']['fee'];
        else
          $fees += $cour['Course']['discount'];
       }
             
       $fees = $this->Session->read("studentfees");
        $ch1 = $this->StudentCourseMap->find("first", array('conditions' => 
        array('StudentCourseMap.student_id' => $user['Student']['id'],
          'StudentCourseMap.challenge_type' => "PC1",
          'StudentCourseMap.deleted' =>0)));
      $sesscoupon = $this->Session->read('coupon_code');      
        if(stripos($sesscoupon,"APC2S") === FALSE){
      $sesscoupon = substr($sesscoupon,0,4);              
      }
      else if(stripos($sesscoupon,"APC2S") !== FALSE){
      $sesscoupon = substr($sesscoupon,0,5);            
      }
      if(strcasecmp($sesscoupon,"APC2") == 0)
        $fees = 799;
      else if(strcasecmp($sesscoupon,"APC2S") == 0)
        $fees = 899;
       else if(!empty($ch1))
        $fees = 899;
       $paymentdata['fee'] = $fees;
       $paymentdata['courses'] = $courses ;
       $paymentdata['regno'] = $user['Student']['reg_no'];         
       $this->Session->write($paymentdata);
       $this->Session->write("courses",$course_id);
      }           
      $this->Session->write("purchasemode","hindu login purchase");    
      $this->Session->write('course_mapped_type',2);
      $PaymentRequest = new PaymentRequest();
      $results= $PaymentRequest->sendRequest($paymentdata);      
      $message = array("result" =>"encrypt","msg"=>$results,"student_id"=>$user['Student']['id']);       
      $this->set("json",json_encode($message));       
  //     if($data['Student']['level'] == 1){
  //       $course_id[0] = 2;
  //       $course_id[1] = 14;
  //     }      
  //     else if($data['Student']['level'] == 2){
  //       $course_id[0] = 5;      
  //       $course_id[1] = 35;
  //     }      
  //     foreach ($course_id as $value) {      
  //     $mapdata['course_id'] = $value;
  //     $mapdata['student_id'] = $data['Student']['id'];
  //     $mapdata['payment'] = 2;
  //     $mapdata['status'] = 1;
  //     $mapdata['course_mapped_type'] = 2;
  //     $mapdata['deleted'] = 0;
  //     $mapdata['comments'] = "Hindu Existing Student login";
  //     $con = array(
  //       'StudentCourseMap.course_id' => $value,
  //       'StudentCourseMap.student_id' => $data['Student']['id'],
  //        'StudentCourseMap.deleted' => 0
  //       );      
  //     $mapping = $this->StudentCourseMap->find("first",array('conditions' => $con ));          
  //      if(empty($mapping)){        
  //         $this->StudentCourseMap->saveAll($mapdata);            
  //       }
  //       else{          
  //         $mapdata['id'] = $mapping['StudentCourseMap']['id'];
  //         $comments = $mapping['StudentCourseMap']['comments'];                    
  //         if(strpos($comments,$mapdata['comments']) === FALSE){
  //           $comments .= ",".$mapdata['comments'];          
  //           $mapdata['comments'] = $comments;
  //           $this->StudentCourseMap->saveAll($mapdata);        
  //         }
  //         else{
  //           unset($mapdata['comments']);
  //          $this->StudentCourseMap->saveAll($mapdata);        
  //         }
  //       }       
  //  }
  // // $this->Session->write("purchasemode","hindu login");    
  //  $this->redirect("/student/course/1");
   }     
  }

  public function payment_success(){
        $this->layout="ahaguru";
  }

  public function cancel() {
    $this->autoRender = false;               
      if($this->request->is("POST")) {
        $this->layout = "default";
        $data = $this->request->data;          
        if(isset($data['student_userid'])){
          $user = $this->Student->findByUserId($data['student_userid']);        
        if($user['Student'] != null){
          $data['registration_for'] = "CR_EXISTING";        
          $batchmap = $this->CrBatchMap->findByStudentId($user['Student']['id']);
          if($batchmap['CrBatchMap'] == null)
            $reg = $this->Register->save($data);
          else
            $reg =1;
          }
          else
            $reg = $this->Register->save($data);  
        }
        else{
          $user = $this->Auth->user();
          $data['student_userid'] = $user['Student']['user_id'];
          $reg = $this->Register->save($data);
        }
    if($reg){      
      $message = array("result"=>"success");
      echo json_encode($message);             
    }   
    }
   }


public function classroom_register() {
        $this->autoRender = false;      
      if($this->request->is("POST")) {
        error_log("ds".print_r($data,true));
          $this->layout = "default";
          $data = $this->request->data;
          error_log("ds".print_r($data,true));
           $tmpdata = array();
                 $pwd = substr($data['Student']['name'],0,4);
          $data['Student']['password'] = $pwd.$this->unique_id();
          $data['Student']['user_id'] = $data['Student']['email'];
             $reg = $this->Student->save($data);        
         if($reg){
           $data['Student']['id'] = $this->Student->id;

        $regno=$this->Student->query("select reg_no from students where id =".$data['Student']['id']);
        $user = $this->Student->findByEmail($this->request->data['Student']['email']);
        $tmpdata['registration_for'] = "CR_NEW";        
        $tmpdata['student_name'] = $user['Student']['name'];
        $tmpdata['student_userid'] = $user['Student']['user_id'];
        $tmpdata['mobile_number'] = $user['Student']['mobile_number'];
        $this->Register->save($tmpdata);
        $standard=$this->Standard->query("select name from standards where id =".$data['Student']['class_2016']);

        $rel=$this->ParentRelationship->query("select name from parent_relationships where id =".$data['Student']['parent_relationship']);
    $rawstring = "<p>Dear names,</p>
                  <p>Welcome to Ahaguru Classes!</p>
                  <p>Ahaguru classes offer concept based learning environment with carefully designed courses based on intensive learning research done by Dr.Balaji Sampath.  Both Direct Classes as well as Online courses are available from Class 5 onwards up to class 12.</p>
                   <p>Thank you for your interest in our classes. </p>
                   <p>Your registration has been successful. </p>
                  <p>Please check your profile information and email:<a href=learn@ahaguru.com>learn@ahaguru.com </a> for any questions and clarifications.</p>
                 <p> Student name: names</p>
                 <p>Student Email ID :emails</p>
                 <p>School Name: school</p>
                 <p>Class in School: standard</p>
                 <p>Parent Name: parents</p>
                 <p>Relationship : parentrel</p>
                 <p>Parent Email ID : parentemail</p>
                 <p>Mobile Number: mobile</p>
                 <p>Address: addr </p>
                  <p> State: state</p>
                  <p>City/Village: city</p>
                  <p>PinCode : pin</p>
                   <p>Country: country</p>
                   <p>Your online account will use your email as your login username and your password that is given below:</p>
                  <p>Your User Name: emails</p>
                  <p>Your Password: pwd</p>
                  <p>Please use the above email id and password to log into the website:www.ahaguru.com</p>
                  <p>All the best and Have a great Day!</p>
              <p>Thanks & Regards</p>
              <p>AHAGURU</p>
              <p>www.ahaguru.com</p>
              <p>+91-96001 00090</p>";
                $placeholders=array('names','emails','pwd','school','standard','parents','parentrel','parentemail','mobile',
                                       'addr','state','city','pin','country');
     $string=array($user['Student']['name'],$user['Student']['email'],$user['Student']['password'],$user['Student']['school_name'],$standard[0]['standards']['name'],$user['Student']['parent_name'],
        $rel[0]['parent_relationships']['name'],$user['Student']['parent_email'],$user['Student']['mobile_number'],$user['Student']['address'],$user['Student']['state'],$user['Student']['place'],
        $user['Student']['postal_pin'],$user['Student']['country']);
     $rawstr = str_replace($placeholders, $string, $rawstring);
         $this->sendEmail($this->request->data['Student']['email'], null,"Ahaguru: Registration",$rawstr,null);
    
          unset($user['Student']['password']);
    $user['role'] = "student";
    $user['data'] = 'sdata';
   if($this->Auth->login($user)) { 
            $session_data = array();
        $session_data['user_id'] = $user['Student']['id'];
        $session_data['user_agent'] = serialize($_SERVER['HTTP_USER_AGENT']);
       $this->SessionAnalytic->save($session_data);
  }  
    // $message = array("result"=>"success");
  $this->redirect("/student/student/classroom");
  }
                   // echo json_encode($message);
           
   }}


   public function wppregister() {
      //$this->set("standard", $this->Standard->find('all'));
    $uri = $_SERVER['HTTP_REFERER'];
      $uri = split("/", $uri);         
        if($this->request->is("post")) {
          $this->layout = "default";     
              $data = $this->request->data;
              $pwd = substr($data['Student']['name'],0,4);
               $data['Student']['password'] = $pwd.$this->unique_id();
               $data['Student']['user_id'] = $data['Student']['email'];
               if(is_numeric($data['Student']['school_id'])){
                $sch=$this->School->findBySchoolId($data['Student']['school_id']);
                $data['Student']['school_name'] = $sch['School']['SCHOOL_NAME'];
                }
            $reg = $this->Student->save($data);
           if($reg){
              $this->Session->write("wpp","1");
              $data['student_id'] = $this->Student->id;
              $regno=$this->Student->query("select reg_no from students where id = $data[student_id]");
              $user = $this->Student->findByEmail($this->request->data['Student']['email']);
              $standard=$this->Standard->query("select name from standards where id = ".$data['Student']['standard']);
              $con = array('StdCourseMap.course_id' => array(44,45,46,47),
          'StdCourseMap.standard_id' => $data['Student']['standard']);
         $course_subscribed = $this->StdCourseMap->find("first",array('conditions' => $con));
              $studsubscrption = $this->AgPuzzlerSubscription->find("all",array('conditions' => 
            array('AgPuzzlerSubscription.STUDENT_ID' =>$user['Student']['id'])));              
              $subenddate = date("Y-m-d", strtotime(date("Y-m-d")." +3 months"));
           $datediff = date_diff(date_create($subenddate),date_create(date("Y-m-d H:i:s")));              
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
              $rawstring = "<p>Dear names,</p>
                  <p>Welcome to Ahaguru Classes!</p>
                  <p>Ahaguru classes offer concept based learning environment with carefully designed courses based on intensive learning research done by Dr.Balaji Sampath.  Both Direct Classes as well as Online courses are available from Class 5 onwards up to class 12.</p>
                   <p>Thank you for your interest in our classes. </p>
                   <p>Your registration has been successful. </p>
                  <p>Please check your profile information and email:<a href=learn@ahaguru.com>learn@ahaguru.com </a> for any questions and clarifications.</p>
                 <p> Student name: names</p>
                 <p>Student Email ID :emails</p>
                
                 <p>Class in School: standard</p>
                
                   <p>Your online account will use your email as your login username and your password that is given below:</p>
                  <p>Your User Name: emails</p>
                  <p>Your Password: pwd</p>
                  <p>Please use the above email id and password to log into the website:www.ahaguru.com</p>
                  <p>All the best and Have a great Day!</p>
              <p>Thanks & Regards</p>
              <p>AHAGURU</p>
              <p>www.ahaguru.com</p>
              <p>+91-96001 00090</p>";
                   

    $placeholders=array('names','emails','pwd','standard');
     $string=array($user['Student']['name'],$user['Student']['email'],$user['Student']['password'],$standard[0]['standards']['name']);
           $rawstr = str_replace($placeholders, $string, $rawstring);
        $this->sendEmail($this->request->data['Student']['email'],null, "Ahaguru: Registration",$rawstr,null);
           $this->redirect('/register_success/'.$user['Student']['id']);

    }

    
  }
}
}


