<?php
App::uses('CakeEmail', 'Network/Email');
App::import('Vendor', 'sms');
class AdminController extends AppController {

    public $name = "Admin";
    public $components = array('RequestHandler');
    public $uses = array  ('CourseModuleMap','Course','Lesson','LessonElementMap','Test','Admin','Student','AdminSlides',
                           'Standard','ParentRelationship','StudentCourseMap','AhaguruStandard','AgPuzzlerSubscription',
                   'Question','Element','ModuleLessonMap','Module','SmsGroup','StdCourseMap','SmsStudentGroup','StudentCoursePayment');

    public function beforeFilter() {
        parent::beforeFilter();
        $this->layout = "ahaguru";
    }

    public function admin_edit_test() {
        $this->layout = "ahaguru_math";
    }

    public function admin_addstud_group($id) {
        $this->layout = "ahaguru";
    }  

    public function admin_email_index(){
        $this->layout = "ahaguru";
    }
  
    public function admin_sms(){
        $this->layout = "ahaguru";
    }

    public function admin_group(){
        $this->layout = "ahaguru";
    }
 
    public function admin_sms_group(){
        $this->layout = "ahaguru";
    }
 
    public function admin_email(){
        $this->layout = "ahaguru";
    }

    public function admin_changepassword() {
        $this->layout = "ahaguru";
    }

    public function adata_changepassword() {
        $this->layout = "default";
        $data = $this->request->data;
        $admin = $this->Auth->user("Admin");
        $user = $this->Admin->findById($admin['id']);
        if($data['oldpassword'] == $user['Admin']['password']) {
            $newdata = array();
            $newdata['id'] = $admin['id'];
            $newdata['password'] = $data['password'];
            $this->Admin->save($newdata);
            $this->set("json", json_encode(array("message"=>"success")));
        } 
        else {
            $this->set("json", json_encode(array("message"=>"failure")));
        }
    }

    public function adata_checkpassword() {
        $this->layout = "default";
        $data = $this->request->data;
        $admin = $this->Auth->user("Admin");
        $admin = $this->Admin->findById($admin['id']);
        if($data['password'] == $admin['Admin']['password']) 
            $this->set("json", json_encode(array("success"=>"true")));
        else
            $this->set("json", json_encode(array("failure"=>"true")));
    }

    public function admin_coursedetails($id){
        $this->layout = "ahaguru";
    }  

    public function adata_coursedetails($id){
        $this->layout = "default";
        $conditions = array(
        "Course.deleted =" => 0,
        "Course.start_date <=" => date("Y-m-d", strtotime(date("Y-m-d")." +1 day")),
        "Course.end_date >=" => date("Y-m-d")
         );
        $this->set("json",json_encode(array($this->Course->find("all", array('conditions' => $conditions)),'batch'=>$id)));
    }  

    public function adata_slides() {
        $folder = "img";
        $folder_url = WWW_ROOT.$folder;
        $rel_url = $folder;
        $slide = str_replace(' ', '_', $this->data['File']['Content']['name']);
        if(!file_exists($folder_url.'/'.$slide)) {
           $data['File']['Content']['name'] = $slide;
           $this->AdminSlides->query("insert into admin_slides values(null,'$slide');");
        } 
        else {
           ini_set('date.timezone', 'Asia/Kolkata');
           $now = date('Y-m-d-His');
           $filename = $now.$slide;
           $data['File']['Content']['name'] = $filename;
           $this->AdminSlides->query("insert into admin_slides values(null,'$filename');");
        }
        $this->uploadFiles("img", $this->data['File']);
        $this->redirect("/admin/dashboard");
    }


    public function adata_getslides(){
        $this->layout = "default";
        $slides =$this->AdminSlides->getslides();
        $this->set("json",json_encode($slides));
    }

    public function adata_deleteslides($id){
        $this->layout = "default";
        $name=$this->AdminSlides->findById($id);
        $slide=$name['AdminSlides']['slides'];
        unlink(WWW_ROOT."/img/".$slide); 
        $this->AdminSlides->query("delete from admin_slides where id=$id;");
        $this->set("json", json_encode( array( "message" => "deleted") ));
    }

    public function admin_get_stud($id){
        $this->layout = "ahaguru";
    }

    public function adata_get_stud($id){
         $this->layout = "default";
         $condition = array(
          'SmsStudentGroup.deleted' => 0,
          'SmsStudentGroup.groupid' =>$id
         );
         $this->set("json",json_encode($this->SmsStudentGroup->find('all',array('conditions' =>$condition))));
    }
   
    public function adata_get_group(){
        $this->layout = "default";
        $conditions = array(
          "SmsGroup.deleted =" => 0,
        );
        $this->set("json",json_encode($this->SmsGroup->find("all", array('conditions' => $conditions))));
    }
  
    public function adata_add_group() {
       $this->layout = "default";
	      if($this->request->is("post")) {
	          $data = $this->request->data;
	          $this->SmsGroup->save($data);
	          $this->redirect("/admin/sms_group");
	      }
    }

    public function adata_delete_group($id) {
        $this->layout = "default";
        if($this->SmsGroup->delete($id))
           $this->set("json", json_encode( array( "message" => "deleted") ));
        else 
           $this->set("json", json_encode( array("message" => "error") ));
    }

    public function adata_group_edit($id){
       $this->layout = "default";
       $data = $this->request->data;
       $this->SmsGroup->edit($id,$data);
       $this->redirect("/admin/sms_group");
    } 
   
    public function unique_id($l = 3) {
	     return substr((uniqid(mt_rand(), true)), 0, $l);
    } 
  
    public function adata_import(){
        $this->layout= "default";
        $this->uploadFiles("csvfiles", $this->data['File'], "fileimport",$this->data['File']['Content']['name'], array(800), true);
        $filename = WWW_ROOT."csvfiles/fileimport/".$this->data['File']['Content']['name']; 
        $delimiter = ',';
        $length = 0;
        $z = 0;
        if (($handle = fopen($filename, "r")) !== FALSE) { 
              $header = fgetcsv($handle);
              while (($row = fgetcsv($handle,$length, $delimiter)) !== FALSE) { 
                 $z++;
                 foreach ($header as $k=>$head) {
                    $data[$head]=(isset($row[$k])) ? $row[$k] : '';
                 }
                 $data['created']=date("Y-m-d H:i:s");
                 $student = $this->Student->findByEmail($data['email']);                                                     
                 if($student == null && isset($data['email']) && isset($data['name'])) {
                   if(preg_match("/^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/",$data['email'])){
                     if(isset($data['standard']) && isset($data['course']) && isset($data['course_status'])){
                          $std = $this->Standard->findByName($data['standard']);
                          $data['standard'] = $std['Standard']['id'];           
                          $con = array(
                            'Course.name' => $data['course'],
                            'Course.deleted' => 0
                          );
                          $crsid = $this->Course->find("all",array('conditions'=>$con));
                          $crs_stat = $this->StudentCoursePayment->findByName($data['course_status']);
                          $stdcrsemap['payment'] = $crs_stat['StudentCoursePayment']['id'];
                          if(!empty($crsid)){
                             $cons = array(
                                'StdCourseMap.standard_id' => $std['Standard']['id'],
                                'StdCourseMap.course_id' => $crsid[0]['Course']['id']
                             );
                          $stdcourse = $this->StdCourseMap->find("all",array('conditions'=>$cons));
                          if(!empty($stdcourse)){
                             $pwd = substr($data['name'],0,4);
                             $data['password'] = $pwd.$this->unique_id();
                             $this->Student->create();
                             $this->Student->save($data);
                             $students = $this->Student->findByEmail($data['email']);
                             $stdcrsemap['student_id'] = $students['Student']['id'];
                             $stdcrsemap['standard'] = $std['Standard']['id'];
                             $stdcrsemap['creation_ts'] = date("Y-m-d H:i:s");
                             $stdcrsemap['course_id'] = $crsid[0]['Course']['id']; 
                             $this->StudentCourseMap->create();
                             $this->StudentCourseMap->save($stdcrsemap);
                             $rawstring = "<p>This email is being sent by Balaji Sampath to all his Std 9 and Std 10 direct 
                                          classroom students.If you are  not his student, please send a reply to balajisampath@ahaguru.com
                                           </p><br>
                                           Dear names<br><p>As I had informed you in class, we are starting the Online Course for Std 9 by 
                                           May 10.</p>  
                                           <p>You have now been added to the Online Course on 'Motion' for Std 9.</p>
                                           <p>Your online account will use your email as your login username and your password that is 
                                           given below:</p>
                                           <p>Your User Name: emails</p>
                                           <p>Your Password: password</p><p>Please use the above email id and password to log into
                                           the website:  www.ahaguru.com</p>
                                           <p>(Login using the login box for Std 9 and Std 10).</p>
                                           <p>Go to 'Motion' course and within that you will see a bunch of lessons and modules.</p>
                                           <p>Each lesson is divided into 2 sections: Concept & Exercises</p>
                                           <p>Concept section will have concept videos, quizzes and a few practice problems.After you go  
                                           through all the slides in the Concept section, you can move on to the Exercise Section. 
                                           (You cannot access Exercise without completing all the slides in Concept).</p>
                                           <p>Exercise Section will have around 15 questions which you must complete. You will get a score at
                                            the end. If you complete the Concept and the Exercise sections, then it means that you have
                                            completed that Lesson.</p>
                                            <p>The next lesson will NOT OPEN until you finish the Previous Lesson.  So you must finish the
                                            lessons in order.</p>
                                            <p>Right now, you will be able to see Lesson 1 and Lesson 2.</p>
                                            <p>More Lessons will be put up over the next few days. You are expected to complete at least 6
                                            lessons by May end. Remember your direct classes will restart in June!</p>
                                            <p>You can continue to do the rest of the lessons in June and are expected to complete the entire
                                            Motion Course by June end.</p>
                                            <p>If you have any doubts, or find some question wrong you can send me an email to:
                                            balajisampath@ahaguru.com</p><br>
                                            <p>All the best.<br>
                                            Balaji Sampath</p>";
                     		    $placeholders=array('names','emails','password','regno');
                            $string=array($students['Student']['name'],$students['Student']['email'],$students['Student']['password']);
                            $rawstr = str_replace($placeholders, $string, $rawstring);
                       	    $this->sendEmail($data['email'],null, "Ahaguru: Registration",$rawstr,null);
                          }
                          else
                              $message[$z] = "row $z not saved check course & standard details" ;
                          }
                          else
                              $message[$z] = "row $z not saved check course details" ;
                     }
                     else{
                        $pwd = substr($data['name'],0,4);
                        $data['password'] = $pwd.$this->unique_id();
                        $this->Student->create();
                        $this->Student->save($data);
                        $students = $this->Student->findByEmail($data['email']);
                        $rawstring = "<p>This email is being sent by Balaji Sampath to all his Std 9 and Std 10 direct classroom students.  
                                      If you are  not his student, please send a reply to balajisampath@ahaguru.com</p><br> 
                                      Dear names<br><p>As I had informed you in class, we are starting the Online Course for Std 9 by 
                                      May 10.</p>  
                                      <p>You have now been added to the Online Course on 'Motion' for Std 9.</p>
                                      <p>Your online account will use your email as your login username and your password that is 
                                      given below:</p>
                                      <p>Your User Name: emails</p>
                                      <p>Your Password: password</p><p>Please use the above email id and password to log into the 
                                      website:  www.ahaguru.com</p>
                                      <p>(Login using the login box for Std 9 and Std 10).</p>
                                      <p>Go to 'Motion' course and within that you will see a bunch of lessons and modules.</p>
                                      <p>Each lesson is divided into 2 sections: Concept & Exercises</p>
                                      <p>Concept section will have concept videos, quizzes and a few practice problems.After you go through
                                      all the slides in the Concept section, you can move on to the Exercise Section. (You cannot access
                                       Exercise without completing all the slides in Concept).</p>
                                      <p>Exercise Section will have around 15 questions which you must complete. You will get a score at the
                                      end. If you complete the Concept and the Exercise sections, then it means that you have completed that
                                      Lesson.</p>
                                      <p>The next lesson will NOT OPEN until you finish the Previous Lesson.  So you must finish the lessons
                                      in order.</p>
                                      <p>Right now, you will be able to see Lesson 1 and Lesson 2.</p>
                                      <p>More Lessons will be put up over the next few days. You are expected to complete at least 6 lessons
                                      by May end. Remember your direct classes will restart in June!</p>
                                      <p>You can continue to do the rest of the lessons in June and are expected to complete the entire Motion
                                      Course by June end.</p>
                                      <p>If you have any doubts, or find some question wrong you can send me an email to:
                                       balajisampath@ahaguru.com</p><br>
                                       <p>All the best.<br>
                                       Balaji Sampath</p>";
            		        $placeholders=array('names','emails','password');
                        $string=array($students['Student']['name'],$students['Student']['email'],$students['Student']['password']);
                        $rawstr = str_replace($placeholders, $string, $rawstring);
                        $this->sendEmail($data['email'],null, "Ahaguru: Registration",$rawstr,null);
                     }                        
                   }
                   else
                      $message[$z] = "row $z not saved Enter vaild Email address" ;
                 }  
                 else {
                     $message[$z] = "row $z not saved Duplicate email address / Email or name field can't be empty" ;
                 }
             }  
             fclose($handle);
        }
        if(!empty($message)) 
        $this->set("json",json_encode($message));
        else
        $this->redirect("/admin/user");
    }    

      public function adata_import_downloaded(){
        $this->layout= "default";
        $this->uploadFiles("csvfiles", $this->data['File'], "fileimport",$this->data['File']['Content']['name'], array(800), true);
        $filename = WWW_ROOT."csvfiles/fileimport/".$this->data['File']['Content']['name']; 
        $delimiter = ',';
        $length = 0;
        $z = 0;
        if (($handle = fopen($filename, "r")) !== FALSE) { 
              $header = fgetcsv($handle);
              while (($row = fgetcsv($handle,$length, $delimiter)) !== FALSE) { 
                 $z++;
                 foreach ($header as $k=>$head) {
                    $data[$head]=(isset($row[$k])) ? $row[$k] : '';
                 }

                 $data['created']=date("Y-m-d H:i:s");
                 error_log("ss".print_r($data,true));
                 if(!empty($data['course_ids']))
                 $course_ids = explode(',',$data['course_ids']);
                  else
                    $course_ids = array();
                  if(!empty($data['email']) && !empty($data['user_id'])){
                  $student = $this->Student->findByUserId($data['user_id']);                                                       
                  if(empty($student))
                    $student = $this->Student->findByEmail($data['email']);                                                       
                  if($student == null){
                  if(!empty($data['name']) && preg_match("/^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/",$data['email'])) {
                       $pwd = substr($data['name'],0,4);
                      $data['password'] = $pwd.$this->unique_id();
                      $data['student_status'] = 3;
                      $this->Student->create();
                        $standard_new = $this->Standard->find('first',array('conditions' => 
                          array('Standard.name' => $data['standard'])));
                      $data['standard'] = $standard_new['Standard']['id'];                                                
                      $this->Student->save($data);
                      $students = $this->Student->findByUserId($data['user_id']);
                      if(!empty($course_ids)){
                      foreach ($course_ids as $value) {                        
                      $studentcrsemap['student_id'] = $students['Student']['id'];
                      $studentcrsemap['course_id'] = $value;
                      $studentcrsemap['payment'] = 2;
                      $studentcrsemap['Challenge_type'] = "PC2";
                      $studentcrsemap['comments'] = "KBV,Hindu New Student Offline_Payment";
                                  $this->StudentCourseMap->create();
                      $this->StudentCourseMap->save($studentcrsemap);                      
                    }
                  }}
                  else
                    $message[$z] = "row $z Name cannot be empty / Enter Valid EmailId" ;
                  }
                 else
                    $message[$z] = "row $z Duplicate user id / email" ;
                 }
                 else if(empty($data['email']) && !empty($data['user_id'])){
                  $student = $this->Student->findByUserId($data['user_id']);                                                       
                 if($student == null){
                  if(!empty($data['name'])){
                      $pwd = substr($data['name'],0,4);
                      $data['password'] = $pwd.$this->unique_id();
                      //$this->Student->create();
                      $standard_new = $this->Standard->find('first',array('conditions' => 
                          array('Standard.name' => $data['standard'])));
                      $data['standard'] = $standard_new['Standard']['id'];                                                
                      $data['student_status'] = 3;                      
                      unset($data['email']);
                      $this->Student->create();                      
                      $this->Student->save($data);                  
                      $students = $this->Student->findByUserId($data['user_id']);                      
                             if(!empty($course_ids)){
                      foreach ($course_ids as $value) {                        
                      $studentcrsemap['student_id'] = $students['Student']['id'];
                      $studentcrsemap['course_id'] = $value;
                      $studentcrsemap['payment'] = 2;
                      $studentcrsemap['Challenge_type'] = "PC2";
                      $studentcrsemap['comments'] = "KBV,Hindu New Student Offline_Payment";                                                  
                             $this->StudentCourseMap->create();
                      $this->StudentCourseMap->save($studentcrsemap);                      
                    }
                  }}
                  else
                    $message[$z] = "row $z Name cannot be empty" ;
                  }
                 else
                    $message[$z] = "row $z Duplicate user id" ;
                 }                 
                 else if((!empty($data['email']) && empty($data['user_id'])) || (empty($data['email']) && empty($data['user_id']))){
                  $message[$z] = "row $z User Id cannot be empty<br/>" ;
                 // $student = $this->Student->findByEmail($data['email']);                                                       
                 // if($student == null && isset($data['email']) && isset($data['name'])) {
                 //  if(preg_match("/^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/",$data['email'])){
                 //        $pwd = substr($data['name'],0,4);
                 //        $data['password'] = $pwd.$this->unique_id();
                 //        $data['student_status'] = 3;
                 //        $data['user_id'] = $data['email'];
                 //        //$this->Student->create();
                 //          $standard_new = $this->Standard->find('first',array('conditions' => 
                 //          array('Standard.name' => $data['standard'])));
                 //      $data['standard'] = $standard_new['Standard']['id'];                                                
                 //           $this->Student->create();
                 //        $this->Student->save($data);
                 //       $students = $this->Student->findByEmail($data['email']);
                 //         // $studentcrsemap['student_id'] = $students['Student']['id'];
                 //         // $studentcrsemap['course_id'] = 14;
                 //         // $studentcrsemap['payment'] = 2;
                 //         // $studentcrsemap['comments'] = "imported from oldsite";
                 //         // $standard_old = $this->AhaguruStandard->getstandard();
                 //         // foreach ($standard_old as $std) {
                 //         //   if($std['standards']['id'] == $data['standard']){
                 //         //    $standard_new = $this->Standard->find('first',array('conditions' => 
                 //         //        array('Standard.name' => $std['standards']['name'])));
                 //         //    $data['standard'] = $standard_new['Standard']['id'];
                 //         //    break;
                 //         //   }
                 //         // }

                      
                 //             // $this->StudentCourseMap->saveAll($studentcrsemap);
                 //          if(!empty($course_ids)){
                 //      foreach ($course_ids as $value) {                        
                 //      $studentcrsemap['student_id'] = $students['Student']['id'];
                 //      $studentcrsemap['course_id'] = $value;
                 //      $studentcrsemap['payment'] = 2;
                 //      $studentcrsemap['comments'] = "Added for Aug Hindu Challenge";                                              
                 //      $this->StudentCourseMap->create();
                 //      $this->StudentCourseMap->save($studentcrsemap);                      
                 //    }
                 //  }
                 //        $rawstring = "<p>Dear names,</p>
                 //                      <p>Wish you and your family a merry Christmas vacation and a very Happy New Year.</p>
                 //                      <p>We have redesigned the AhaGuru website.  To celebrate this and the coming New Year, I am happy to gift you some vacation homework :-)</p>
                 //                      <p>I have enrolled you for the new AhaGuru course on Current Electricity.</p>
                 //                      <p>You can access this by logging into: <a href='http://www.ahaguru.com'>www.AhaGuru.com</a> using the following:</p>
                 //                      <p>Your User Name is: emails<br/>
                 //                         Your Password is:  pwd</p>
                 //                      <p>Once you log in you can see the Current Electricity course in the My Courses tab.
                 //                        Click on it and start viewing and solving!</p>
                 //                      <p>I have put up 6 lessons.  I will be adding more soon. Try and finish these 6 lessons during your vacations.  A special reward awaits
                 //                       everyone who completes all 6 lessons before 1st January!</p>
                 //                      <p>I am trying to migrate the older courses into the new site. This will take me some time.</p>
                 //                      <p>Until then your older courses will be available at the website:<a href='http://www.ahaguru.net'> www.ahaguru.net</a>. You can access your older courses with your email id and same password as you have been using.
                 //                        (The new password we have sent you here will only work for the new courses in <a href='http://www.ahaguru.com'>www.ahaguru.com</a>)
                 //                      <p>If you have any questions on the course or login account, please send your request to 
                 //                      <a href='mailto:learn@ahaguru.com'>learn@ahaguru.com</a> or call +91 96001 00090</p><br/>
                 //                      <p>All the best.</p>
                 //                      <p>Have a wonderful vacation and a very happy new year!</p>
                 //                      <p>Balaji Sampath</p>";
                 //        $placeholders=array('names','emails','pwd');
                 //        $string=array($students['Student']['name'],$students['Student']['email'],$students['Student']['password']);
                 //        $rawstr = str_replace($placeholders, $string, $rawstring);
                       // $this->sendEmail($data['email'],$students['Student']['parent_email'], "Ahaguru: Registration",$rawstr,null);                    
                 //   }
                 //   else
                 //      $message[$z] = "row $z not saved Enter vaild Email address<br/>" ;
                 // }  
                 // else {
                 //     $message[$z] = "row $z not saved Duplicate email address / Email or name field can't be empty<br/>" ;
                 // }
             }  }
             fclose($handle);
        }
        if(!empty($message)) 
        $this->set("json",json_encode($message));
        else
        $this->redirect("/admin/user");
    }    


      public function adata_import_puzz_subscription(){
        $this->layout= "default";
        $this->uploadFiles("csvfiles", $this->data['File'], "fileimport",$this->data['File']['Content']['name'], array(800), true);
        $filename = WWW_ROOT."csvfiles/fileimport/".$this->data['File']['Content']['name']; 
        $delimiter = ',';
        $length = 0;
        $z = 0;
        if (($handle = fopen($filename, "r")) !== FALSE) { 
              $header = fgetcsv($handle);
              while (($row = fgetcsv($handle,$length, $delimiter)) !== FALSE) { 
                 $z++;
                 foreach ($header as $k=>$head) {
                    $data[$head]=(isset($row[$k])) ? $row[$k] : '';
                 }

                 $data['created']=date("Y-m-d H:i:s");
                 error_log("ss".print_r($data,true));                 
                  if(!empty($data['email']) && !empty($data['user_id'])){
                  $student = $this->Student->findByUserId($data['user_id']);                                                       
                  if(empty($student))
                    $student = $this->Student->findByEmail($data['email']);                                                       
                  if($student == null){
                  if(!empty($data['name']) && preg_match("/^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/",$data['email'])) {
                       $pwd = substr($data['name'],0,4);
                      $data['password'] = $pwd.$this->unique_id();
                      $data['student_status'] = 3;
                      $this->Student->create();
                        $standard_new = $this->Standard->find('first',array('conditions' => 
                          array('Standard.name' => $data['standard'])));
                      $data['standard'] = $standard_new['Standard']['id'];                                                
                      $this->Student->save($data);
                      $students = $this->Student->findByUserId($data['user_id']);
                        $subscription = array();
                       if($students['Student']['standard'] > 4)
                        $std = 1;
                      else
                        $std = $students['Student']['standard'];
                       $con = array('StdCourseMap.course_id' => array(44,45,46,47),
                        'StdCourseMap.standard_id' => $std);
                       $course_subscribed = $this->StdCourseMap->find("first",array('conditions' => $con));
                       $studsubscrption = $this->AgPuzzlerSubscription->find("all",array('conditions' => 
                          array('AgPuzzlerSubscription.STUDENT_ID' =>$students['Student']['id'],
                            'AgPuzzlerSubscription.COURSE_ID' => $course_subscribed['StdCourseMap']['course_id'])));
                        CakeLog::write('debug', "subscribe? ".print_r($studsubscrption,true));
                         $datediff = date_diff(date_create("01-11-2015"),date_create(date("Y-m-d H:i:s")));              
                        $datediff = ($datediff->days)+1;
                        $week  = round($datediff / 7);
                        $week = $week;
                        if(empty($studsubscrption)){
                       $subscription['COURSE_ID'] = $course_subscribed['StdCourseMap']['course_id'];
                       $subscription['STUDENT_ID'] = $students['Student']['id'];
                       $subscription['SUBSCRIPTION_PERIOD'] = $week;
                       $subscription['SUBSCRIPTION_DATE'] = date('Y-m-d H:i:s');
                       $this->AgPuzzlerSubscription->create();
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
                 <p>School Name: school</p>
                 <p>Class in School: standard</p>        
                 <p>Mobile Number: mobile</p>                 
                   <p>Your online account will use your email as your login username and your password that is given below:</p>
                  <p>Your User Name: emails</p>
                  <p>Your Password: pwd</p>
                  <p>Please use the above email id and password to log into the website:www.ahaguru.com</p>
                  <p>All the best and Have a great Day!</p>
              <p>Thanks & Regards</p>
              <p>AHAGURU</p>
              <p>www.ahaguru.com</p>
              <p>+91-96001 00090</p>";
                   

    $placeholders=array('names','emails','pwd','school','standard','mobile');
     $string=array($students['Student']['name'],$students['Student']['email'],$students['Student']['password'],$students['Student']['school_name'],$standard[0]['standards']['name']
        ,$students['Student']['mobile_number']);
           $rawstr = str_replace($placeholders, $string, $rawstring);
           error_log("ww".$rawstr);
                }
                  else
                    $message[$z] = "row $z Name cannot be empty / Enter Valid EmailId" ;
                  }
                 else
                    $message[$z] = "row $z Duplicate user id / email" ;
                 }
                 else if(empty($data['email']) && !empty($data['user_id'])){
                  $student = $this->Student->findByUserId($data['user_id']);                                                       
                 if($student == null){
                  if(!empty($data['name'])){
                      $pwd = substr($data['name'],0,4);
                      $data['password'] = $pwd.$this->unique_id();
                      //$this->Student->create();
                      $standard_new = $this->Standard->find('first',array('conditions' => 
                          array('Standard.name' => $data['standard'])));
                      $data['standard'] = $standard_new['Standard']['id'];                                                
                      $data['student_status'] = 3;                      
                      unset($data['email']);
                      $this->Student->create();                      
                      $this->Student->save($data);                  
                      $students = $this->Student->findByUserId($data['user_id']);                      
                        $subscription = array();
                           if($students['Student']['standard'] > 4)
                            $std = 1;
                          else
                            $std = $students['Student']['standard'];
                           $con = array('StdCourseMap.course_id' => array(44,45,46,47),
                            'StdCourseMap.standard_id' => $std);
                           $course_subscribed = $this->StdCourseMap->find("first",array('conditions' => $con));
                           $studsubscrption = $this->AgPuzzlerSubscription->find("all",array('conditions' => 
                              array('AgPuzzlerSubscription.STUDENT_ID' =>$students['Student']['id'],
                                'AgPuzzlerSubscription.COURSE_ID' => $course_subscribed['StdCourseMap']['course_id'])));
                            CakeLog::write('debug', "subscribe? ".print_r($studsubscrption,true));
                             $datediff = date_diff(date_create("31-12-2015"),date_create(date("Y-m-d H:i:s")));              
                            $datediff = ($datediff->days)+1;
                            $week  = round($datediff / 7);
                            $week = $week;
                            if(empty($studsubscrption)){
                           $subscription['COURSE_ID'] = $course_subscribed['StdCourseMap']['course_id'];
                           $subscription['STUDENT_ID'] = $students['Student']['id'];
                           $subscription['SUBSCRIPTION_PERIOD'] = $week;
                           $subscription['SUBSCRIPTION_DATE'] = date('Y-m-d H:i:s');
                              $this->AgPuzzlerSubscription->create();
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
                 <p>School Name: school</p>
                 <p>Class in School: standard</p>                               
                 <p>Address: addr </p>                  
                   <p>Your online account will use your email as your login username and your password that is given below:</p>
                  <p>Your User Name: emails</p>
                  <p>Your Password: pwd</p>
                  <p>Please use the above email id and password to log into the website:www.ahaguru.com</p>
                  <p>All the best and Have a great Day!</p>
              <p>Thanks & Regards</p>
              <p>AHAGURU</p>
              <p>www.ahaguru.com</p>
              <p>+91-96001 00090</p>";
                   

    $placeholders=array('names','emails','pwd','school','standard','mobile');
     $string=array($students['Student']['name'],$students['Student']['email'],$students['Student']['password'],$students['Student']['school_name'],$standard[0]['standards']['name']
        ,$students['Student']['mobile_number']);
           $rawstr = str_replace($placeholders, $string, $rawstring);
           error_log("ww".$rawstr);
         // $this->sendEmail($students['Student']['email'], null,"Ahaguru: Registration",$rawstr,null);
                    }
                  else
                    $message[$z] = "row $z Name cannot be empty" ;
                  }
                 else{
                      $students = $this->Student->findByUserId($data['user_id']);                      
                        $subscription = array();
                           if($students['Student']['standard'] > 4)
                            $std = 1;
                          else
                            $std = $students['Student']['standard'];
                           $con = array('StdCourseMap.course_id' => array(44,45,46,47),
                            'StdCourseMap.standard_id' => $std);
                           $course_subscribed = $this->StdCourseMap->find("first",array('conditions' => $con));
                           $studsubscrption = $this->AgPuzzlerSubscription->find("all",array('conditions' => 
                              array('AgPuzzlerSubscription.STUDENT_ID' =>$students['Student']['id'],
                                'AgPuzzlerSubscription.COURSE_ID' => $course_subscribed['StdCourseMap']['course_id'])));
                            CakeLog::write('debug', "subscribe? ".print_r($studsubscrption,true));
                             $datediff = date_diff(date_create("31-12-2015"),date_create(date("Y-m-d H:i:s")));              
                            $datediff = ($datediff->days)+1;
                            $week  = round($datediff / 7);
                            $week = $week;
                            if(empty($studsubscrption)){
                           $subscription['COURSE_ID'] = $course_subscribed['StdCourseMap']['course_id'];
                           $subscription['STUDENT_ID'] = $students['Student']['id'];
                           $subscription['SUBSCRIPTION_PERIOD'] = $week;
                           $subscription['SUBSCRIPTION_DATE'] = date('Y-m-d H:i:s');
                              $this->AgPuzzlerSubscription->create();
                           $this->AgPuzzlerSubscription->save($subscription);
                           $message[$z] = "row $z Duplicate user id puzzler subscripbed" ;
                          }
                          else
                            $message[$z] = "row $z Duplicate user id" ;
                 }
                 }                 
                 else if((!empty($data['email']) && empty($data['user_id'])) || (empty($data['email']) && empty($data['user_id']))){
                  $message[$z] = "row $z User Id cannot be empty<br/>" ;
                 // $student = $this->Student->findByEmail($data['email']);                                                       
                 // if($student == null && isset($data['email']) && isset($data['name'])) {
                 //  if(preg_match("/^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/",$data['email'])){
                 //        $pwd = substr($data['name'],0,4);
                 //        $data['password'] = $pwd.$this->unique_id();
                 //        $data['student_status'] = 3;
                 //        $data['user_id'] = $data['email'];
                 //        //$this->Student->create();
                 //          $standard_new = $this->Standard->find('first',array('conditions' => 
                 //          array('Standard.name' => $data['standard'])));
                 //      $data['standard'] = $standard_new['Standard']['id'];                                                
                 //           $this->Student->create();
                 //        $this->Student->save($data);
                 //       $students = $this->Student->findByEmail($data['email']);
                 //         // $studentcrsemap['student_id'] = $students['Student']['id'];
                 //         // $studentcrsemap['course_id'] = 14;
                 //         // $studentcrsemap['payment'] = 2;
                 //         // $studentcrsemap['comments'] = "imported from oldsite";
                 //         // $standard_old = $this->AhaguruStandard->getstandard();
                 //         // foreach ($standard_old as $std) {
                 //         //   if($std['standards']['id'] == $data['standard']){
                 //         //    $standard_new = $this->Standard->find('first',array('conditions' => 
                 //         //        array('Standard.name' => $std['standards']['name'])));
                 //         //    $data['standard'] = $standard_new['Standard']['id'];
                 //         //    break;
                 //         //   }
                 //         // }

                      
                 //             // $this->StudentCourseMap->saveAll($studentcrsemap);
                 //          if(!empty($course_ids)){
                 //      foreach ($course_ids as $value) {                        
                 //      $studentcrsemap['student_id'] = $students['Student']['id'];
                 //      $studentcrsemap['course_id'] = $value;
                 //      $studentcrsemap['payment'] = 2;
                 //      $studentcrsemap['comments'] = "Added for Aug Hindu Challenge";                                              
                 //      $this->StudentCourseMap->create();
                 //      $this->StudentCourseMap->save($studentcrsemap);                      
                 //    }
                 //  }
                 //        $rawstring = "<p>Dear names,</p>
                 //                      <p>Wish you and your family a merry Christmas vacation and a very Happy New Year.</p>
                 //                      <p>We have redesigned the AhaGuru website.  To celebrate this and the coming New Year, I am happy to gift you some vacation homework :-)</p>
                 //                      <p>I have enrolled you for the new AhaGuru course on Current Electricity.</p>
                 //                      <p>You can access this by logging into: <a href='http://www.ahaguru.com'>www.AhaGuru.com</a> using the following:</p>
                 //                      <p>Your User Name is: emails<br/>
                 //                         Your Password is:  pwd</p>
                 //                      <p>Once you log in you can see the Current Electricity course in the My Courses tab.
                 //                        Click on it and start viewing and solving!</p>
                 //                      <p>I have put up 6 lessons.  I will be adding more soon. Try and finish these 6 lessons during your vacations.  A special reward awaits
                 //                       everyone who completes all 6 lessons before 1st January!</p>
                 //                      <p>I am trying to migrate the older courses into the new site. This will take me some time.</p>
                 //                      <p>Until then your older courses will be available at the website:<a href='http://www.ahaguru.net'> www.ahaguru.net</a>. You can access your older courses with your email id and same password as you have been using.
                 //                        (The new password we have sent you here will only work for the new courses in <a href='http://www.ahaguru.com'>www.ahaguru.com</a>)
                 //                      <p>If you have any questions on the course or login account, please send your request to 
                 //                      <a href='mailto:learn@ahaguru.com'>learn@ahaguru.com</a> or call +91 96001 00090</p><br/>
                 //                      <p>All the best.</p>
                 //                      <p>Have a wonderful vacation and a very happy new year!</p>
                 //                      <p>Balaji Sampath</p>";
                 //        $placeholders=array('names','emails','pwd');
                 //        $string=array($students['Student']['name'],$students['Student']['email'],$students['Student']['password']);
                 //        $rawstr = str_replace($placeholders, $string, $rawstring);
                       // $this->sendEmail($data['email'],$students['Student']['parent_email'], "Ahaguru: Registration",$rawstr,null);                    
                 //   }
                 //   else
                 //      $message[$z] = "row $z not saved Enter vaild Email address<br/>" ;
                 // }  
                 // else {
                 //     $message[$z] = "row $z not saved Duplicate email address / Email or name field can't be empty<br/>" ;
                 // }
             }  }
             fclose($handle);
        }
        if(!empty($message)) 
        $this->set("json",json_encode($message));
        else
        $this->redirect("/admin/user");
    }    
} 
