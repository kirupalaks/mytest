<?php
App::uses('CakeEmail', 'Network/Email');
class AgpuzzlerapiController extends AppController {

	public $name = "Agpuzzlerapi";

	public $uses = array('Student','Agpuzzlertoken','AgPuzzlerSubscription','Course','CourseLessonMap','Concept','StudentActivity',
    'LessonElementMap','Lesson','Exercise','StudentExerciseAttempt','Slide','Question','Element','StudentConceptAttempt');

  public function beforeFilter() {
    parent::beforeFilter();
   $this->Auth->allow('authorize_authenticate','authorize','authenticate','forgotpwd','getpuzzler','submit_answer','getpuzzlerById'
    ,'getallpuzzler');
 }

public function authorize_authenticate(){
   $this->autoRender = false;   
    if($this->request->is("post")) {
      $this->layout ="default";      
      if(isset($_POST['user_id']) && $_POST['user_id'] != ""){
        $user_id = $_POST['user_id'];
        $password = $_POST['password'];
        $token = $this->authorize($user_id,$password);        
        if($token == Configure::read('msg.Token_Created') || $token == Configure::read('msg.Token_Exist')){
          $student = $this->Student->findByUserId($user_id);      
           $tokenexist = $this->Agpuzzlertoken->find("first",array('conditions'=>array('Agpuzzlertoken.STUDENT_ID' => $student['Student']['id'])));
                 $auth = $this->authenticate($tokenexist['Agpuzzlertoken']['STUDENT_ID']);
                 if($auth == Configure::read('msg.Subscribed')){
                     $subscription = $this->AgPuzzlerSubscription->find("first",array(
                    'conditions' => array('AgPuzzlerSubscription.student_id' => $tokenexist['Agpuzzlertoken']['STUDENT_ID'])));        
              if(!empty($subscription))
               {
                $result = $this->getallpuzzler($tokenexist['Agpuzzlertoken']['TOKEN']);
                  echo json_encode($result);             
                }
              }
                elseif($auth == Configure::read('msg.Subscription_Expired'))
                  echo json_encode(array("status" => Configure::read('status.success'),
                    "msg"=> Configure::read('msg.Subscription_Expired'),"token" => $tokenexist['Agpuzzlertoken']['TOKEN'])); 
                elseif($auth == Configure::read('msg.Not_Subscribed'))
                  echo json_encode(array("status" => Configure::read('status.success'),
                    "msg"=> Configure::read('msg.Not_Subscribed'),"token" => $tokenexist['Agpuzzlertoken']['TOKEN']));       
        }
        else if($token == Configure::read('msg.Invalid_Password'))
          echo json_encode(array("status" => Configure::read('status.error'),"msg" => Configure::read('msg.Invalid_Password')));
        else if($token == Configure::read('msg.No_User'))
            echo json_encode(array("status" => Configure::read('status.error'),"msg" => Configure::read('msg.No_User')));                           
      }       
      else if(isset($_POST['token']) && $_POST['token'] != ""){   
        $token = urlencode($_POST['token']);        
           $tokenexist = $this->Agpuzzlertoken->find("first",array('conditions'=>array('Agpuzzlertoken.TOKEN' => $token)));
           if(!empty($tokenexist)){
                 $auth = $this->authenticate($tokenexist['Agpuzzlertoken']['STUDENT_ID']);
            if($auth == Configure::read('msg.Subscribed')){
                $subscription = $this->AgPuzzlerSubscription->find("first",array(
                    'conditions' => array('AgPuzzlerSubscription.student_id' => $tokenexist['Agpuzzlertoken']['STUDENT_ID'])));        
              if(!empty($subscription))
               {
                $result = $this->getallpuzzler($tokenexist['Agpuzzlertoken']['TOKEN']);
                  echo json_encode($result);
              }                                      
                }
                elseif($auth == Configure::read('msg.Subscription_Expired'))
                  echo json_encode(array("status" => Configure::read('status.success'),
                    "msg"=> Configure::read('msg.Subscription_Expired'),"token" => $tokenexist['Agpuzzlertoken']['TOKEN'])); 
                elseif($auth == Configure::read('msg.Not_Subscribed'))
                  echo json_encode(array("status" => Configure::read('status.success'),
                    "msg"=> Configure::read('msg.Not_Subscribed'),"token" => $tokenexist['Agpuzzlertoken']['TOKEN'])); 
          }
      else{
           echo json_encode(array("status" => Configure::read('status.error'),              
              "msg" => Configure::read('msg.Invalid_Token'),"token" => $token)); 
      }
    }
  }
}

public function authorize($user_id,$password){      
      $student = $this->Student->findByUserId($user_id);      
      $keys=$student['Student']['name'];
      if($student['Student'] != null){
        if(strtolower($student['Student']['password']) == strtolower($password) && $student['Student']['deleted'] == 0) {                    
       $encrypted = base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5($keys), $user_id, MCRYPT_MODE_CBC, md5(md5($keys))));
          $token = urlencode($encrypted);          
         $token_data = array(
          'STUDENT_ID' => $student['Student']['id'],
          'TOKEN' => $token
          );        
         $token_table = $this->Agpuzzlertoken->find("first",array('conditions'=>array('Agpuzzlertoken.STUDENT_ID' => $student['Student']['id'])));         
          if(empty($token_table)){
            $tokensaved = $this->Agpuzzlertoken->save($token_data);               
          return Configure::read('msg.Token_Created');
        }
        else
          return Configure::read('msg.Token_Exist');
        }
        else
          return Configure::read('msg.Invalid_Password');
      }
      else
          return Configure::read('msg.No_User');
}

public function authenticate($id){
   $student = $this->Student->findById($id);      
          $puzzsub = $this->AgPuzzlerSubscription->find("first",array('conditions'=>
            array("AgPuzzlerSubscription.STUDENT_ID" => $student['Student']['id'])));       
          if(!empty($puzzsub)){
            $substartdate = date($puzzsub['AgPuzzlerSubscription']['SUBSCRIPTION_DATE']);
            $subperiod = $puzzsub['AgPuzzlerSubscription']['SUBSCRIPTION_PERIOD']-1;
            $subenddate = date("Y-m-d",strtotime('+'.$subperiod.' weeks', strtotime($substartdate)));                       
            if($subenddate >= date("Y-m-d", strtotime(date("Y-m-d")." +1 day"))){                  
              return Configure::read('msg.Subscribed');
          }
          else if($subenddate < date("Y-m-d", strtotime(date("Y-m-d")." +1 day")))
             return Configure::read('msg.Subscription_Expired');
        }
          else
            return Configure::read('msg.Not_Subscribed');
}

public function forgotpwd(){
   $this->autoRender = false;   
   if($this->request->is("post")) {
    $this->layout ="default";
    // $token = urlencode($_POST['token']); 
    // $tokenexist = $this->Agpuzzlertoken->find("first",array('conditions'=>array('Agpuzzlertoken.TOKEN' => $token)));
    if(isset($_POST['user_id']) && $_POST['user_id'] != ''){
      $user_id = trim($_POST['user_id']);
       $student = $this->Student->find("first",array('conditions'=>array('Student.user_id'=>
        $user_id,'Student.deleted'=>0)));      
       if(!empty($student)){
       if($student['Student']['email'] != ""){
        $rawstr = "Dear names,<br>
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
     $string=array($student['Student']['name'],$student['Student']['email'],$student['Student']['password']);
     $rawstr = str_replace($placeholders, $string, $rawstr);     
      $this->sendEmail($student['Student']['email'],null, 'Ahaguru: Password',$rawstr,null);      
      echo json_encode(array("status" => Configure::read('status.success'),"msg" =>  Configure::read('msg.Email_Sent')));
    }
    else
    echo json_encode(array("status" => Configure::read('status.error'),"msg" =>  Configure::read('msg.No_Email')));                           
    }
    else
    echo json_encode(array("status" => Configure::read('status.error'),"msg" =>  Configure::read('msg.UserId_NotReg')));                           
     }
     else
        echo json_encode(array("status" => Configure::read('status.error'),"msg" => Configure::read('msg.UserId_Missing')));   
   }
 }    
      
      
 public function getpuzzlerById(){
   $this->autoRender = false;     
 error_log("post".print_r($_POST,true));
   if(isset($_POST['token']) && $_POST['token'] != ""){   
      if(isset($_POST['lesson_id']) && $_POST['lesson_id'] !=""){
     $puzzler= array();
        $token = urlencode($_POST['token']);        
        $puzz_id = $_POST['lesson_id'];
        $tokenexist = $this->Agpuzzlertoken->find("first",array('conditions'=>
          array('Agpuzzlertoken.TOKEN' => $token)));
        if(!empty($tokenexist)){
          $user = $this->Student->findById($tokenexist['Agpuzzlertoken']['STUDENT_ID']);
          $studentid = $user['Student']['id'];
          $auth = $this->authenticate($tokenexist['Agpuzzlertoken']['STUDENT_ID']);
            if($auth == Configure::read('msg.Subscribed')){
                   $subscription = $this->AgPuzzlerSubscription->find("first",array(
                    'conditions' => array('AgPuzzlerSubscription.student_id' => $tokenexist['Agpuzzlertoken']['STUDENT_ID'])));        
              if(!empty($subscription))
               {
                $substartdate = date($subscription['AgPuzzlerSubscription']['SUBSCRIPTION_DATE']);
                 $subperiod = $subscription['AgPuzzlerSubscription']['SUBSCRIPTION_PERIOD']-1;
                $subenddate = date("Y-m-d",strtotime('+'.$subperiod.' weeks', strtotime($substartdate)));
                $weekStartDate = date('Y-m-d',strtotime("last Monday", strtotime($substartdate)));        
                $weekEndDate = date('Y-m-d',strtotime("next Sunday", strtotime($subenddate)));        
                // $cours = $this->Course->findById($subscription['AgPuzzlerSubscription']['COURSE_ID']);
                $subscription['AgPuzzlerSubscription']['end_date'] = $weekEndDate;        
                $lesson =  $this->Lesson->findById($puzz_id);                
                $course_id = $subscription['AgPuzzlerSubscription']['COURSE_ID'];            
                $course_lesson = $this->CourseLessonMap->query("select * from course_lesson_map where course_id=$course_id and lesson_id = $puzz_id and published = 1 and deleted = 0");
                 if(!empty($course_lesson))
                 {
                    $j=0;$i=0;                    
                        $isthisweek = $this->Lesson->find("first",array('conditions' => 
                array('Lesson.id' => $lesson['Lesson']['id'],
                       'Lesson.start_date <=' => date("Y-m-d", strtotime(date("Y-m-d")." +1 day")),
                      'Lesson.end_date >='=> date("Y-m-d", strtotime(date("Y-m-d"))),
                      // 'Lesson.start_date >=' => $weekStartDate,
                      // 'Lesson.end_date <='=> $weekEndDate,
                'Lesson.deleted' => 0))); 
                   if(!empty($lesson)){
                    $lesson_element = $this->LessonElementMap->find("all",array('conditions' => 
                          array('LessonElementMap.lesson_id' => $lesson['Lesson']['id'],
                            'LessonElementMap.deleted' => 0)));   
                    if(!empty($lesson_element)){                                                     
                        $lesson['Lesson']['skip'] = 1;                               
                           if(!empty($isthisweek))
                            $lesson['Lesson']['thisweek'] = 1;        
                          else
                            $lesson['Lesson']['thisweek'] = 0; 

                                $ele=0;
                                foreach ($lesson_element as $value) { 
                                $images = array();                                                       
                                      if($value['LessonElementMap']['element_type'] == 3){
                                        $exe = $this->Exercise->findById($value['LessonElementMap']['element_id']);
                                        if($exe['Exercise']['slides'] != ""){                                        
                                          $id = $value['LessonElementMap']['element_id'];                                        
                                        /*content fetch*/
                                         $attempts=$this->StudentExerciseAttempt->query("select * from student_exercise_attempt where 
                                          element_id = $id and student_id = $studentid and deleted=0");                                               
                                        $img = 0;
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
                                              if(preg_match_all('/<img[^>]+>/i',$exercise['slide'][$key]['Slide']['content']['Question']['question'], $result)){                                    
                                              $images[$img] = $result[0];                
                                              $img++;
                                            }
                                            if(preg_match_all('/<img[^>]+>/i',$exercise['slide'][$key]['Slide']['content']['Question']['solution_text'], $result)){                                    
                                              $images[$img] = $result[0];                
                                              $img++;
                                            }
                            // $exercise['slide'][$key]['Slide']['content']['Question']['question'] = htmlspecialchars($exercise['slide'][$key]['Slide']['content']['Question']['question'],ENT_QUOTES);
                                          $exercise['slide'][$key]['Slide']['content']['Question']['question'] = str_replace("'","&#39;",$exercise['slide'][$key]['Slide']['content']['Question']['question']);
                                          $exercise['slide'][$key]['Slide']['content']['Question']['question'] = str_replace("-","&#45;",$exercise['slide'][$key]['Slide']['content']['Question']['question']);
                                          $exercise['slide'][$key]['Slide']['content']['Question']['solution_text'] = str_replace("'","&#39;",$exercise['slide'][$key]['Slide']['content']['Question']['solution_text']);
                                          $exercise['slide'][$key]['Slide']['content']['Question']['solution_text'] = str_replace("-","&#45;",$exercise['slide'][$key]['Slide']['content']['Question']['solution_text']);
                                          }
                                       }
                                       
                                        $exercise['status'] = 0;
                                        $exercise['last_visited'] = 1;            
                                     }
                                       else if(count($attempts) == 1 && $attempts[0]['student_exercise_attempt']['status'] == 1 )
                                        // && $attempts[0]['student_exercise_attempt']['isMobileAttempt'] == 1) 
                                     {
                                        $exercise = $this->Exercise->findById($id);
                                        $elements= $this->LessonElementMap->query("select * from lesson_element_map where element_id = $id and element_type = 3;");
                                        $slideids = explode(",",$exercise['Exercise']['slides']);
                                        
                                        $exercise['slide'] = array();
                                        $type = 3;
                                        foreach($slideids as $key => $slide)
                                       {
                                         $result = array();
                                          $exercise['slide'][$key] = $this->Slide->findById($slide);
                                          if($exercise['slide'][$key]['Slide']['slide_type'] == 5) 
                                         {
                                            $exercise['slide'][$key]['Slide']['content'] =
                                            $this->Question->findById($exercise['slide'][$key]['Slide']['content']);                
                                          if(preg_match_all('/<img[^>]+>/i',$exercise['slide'][$key]['Slide']['content']['Question']['question'], $result)){                    
                                            $images[$img] = $result[0];                
                                            $img++;
                                          }
                                          if(preg_match_all('/<img[^>]+>/i',$exercise['slide'][$key]['Slide']['content']['Question']['solution_text'], $result)){                                    
                                              $images[$img] = $result[0];                
                                              $img++;
                                            }
                                          // $exercise['slide'][$key]['Slide']['content']['Question']['question'] = htmlspecialchars($exercise['slide'][$key]['Slide']['content']['Question']['question'],ENT_QUOTES);
                                           $exercise['slide'][$key]['Slide']['content']['Question']['question'] = str_replace("'","&#39;",$exercise['slide'][$key]['Slide']['content']['Question']['question']);
                                           $exercise['slide'][$key]['Slide']['content']['Question']['question'] = str_replace("-","&#45;",$exercise['slide'][$key]['Slide']['content']['Question']['question']);
                                           $exercise['slide'][$key]['Slide']['content']['Question']['solution_text'] = str_replace("'","&#39;",$exercise['slide'][$key]['Slide']['content']['Question']['solution_text']);
                                          $exercise['slide'][$key]['Slide']['content']['Question']['solution_text'] = str_replace("-","&#45;",$exercise['slide'][$key]['Slide']['content']['Question']['solution_text']);
                                         }
                                       }
                                        $exercise['status'] = $attempts[0]['student_exercise_attempt']['status'];
                                        $exercise['time'] = $attempts[0]['student_exercise_attempt']['duration'];
                                        $exercise['isMobileAttempt'] = $attempts[0]['student_exercise_attempt']['isMobileAttempt'];
                                        $exercise['answers'] = $attempts[0]['student_exercise_attempt']['answers']; 
                                        $exercise['score'] = $attempts[0]['student_exercise_attempt']['score']; 
                                        $exercise['last_visited'] = $attempts[0]['student_exercise_attempt']['last_visited']; 
                                        $exercise['slide_modified'] = $attempts[0]['student_exercise_attempt']['slide_modified']; 
                                      }
                                      else if(count($attempts) == 1 && $attempts[0]['student_exercise_attempt']['status'] == 2)
                                       // && $attempts[0]['student_exercise_attempt']['isMobileAttempt'] == 1) 
                                     { 
                                              $exercise = $this->Exercise->findById($id);
                                              $exercise['score'] = $attempts[0]['student_exercise_attempt']['score'];
                                              $exercise['isMobileAttempt'] = $attempts[0]['student_exercise_attempt']['isMobileAttempt'];
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
                                            if(preg_match_all('/<img[^>]+>/i',$exercise['slide'][$key]['Slide']['content']['Question']['question'], $result)){                                    
                                            $images[$img] = $result[0];                
                                            $img++;
                                          }         
                                          if(preg_match_all('/<img[^>]+>/i',$exercise['slide'][$key]['Slide']['content']['Question']['solution_text'], $result)){                                    
                                              $images[$img] = $result[0];                
                                              $img++;
                                            }       
                                          // $exercise['slide'][$key]['Slide']['content']['Question']['question'] = htmlspecialchars($exercise['slide'][$key]['Slide']['content']['Question']['question'],ENT_QUOTES);
                                            $exercise['slide'][$key]['Slide']['content']['Question']['question'] = str_replace("'","&#39;",$exercise['slide'][$key]['Slide']['content']['Question']['question']);
                                            $exercise['slide'][$key]['Slide']['content']['Question']['question'] = str_replace("-","&#45;",$exercise['slide'][$key]['Slide']['content']['Question']['question']);
                                            $exercise['slide'][$key]['Slide']['content']['Question']['solution_text'] = str_replace("'","&#39;",$exercise['slide'][$key]['Slide']['content']['Question']['solution_text']);
                                          $exercise['slide'][$key]['Slide']['content']['Question']['solution_text'] = str_replace("-","&#45;",$exercise['slide'][$key]['Slide']['content']['Question']['solution_text']);
                                          }
                                        }
                                    }                                    
                                                           
                                      $exercise['attempts'] = count($attempts);
                                      $lesson['element'][$ele] = $exercise;
                                      $lesson['element'][$ele]['image']=$images;
                                                      /*content fetch*/
                                                      $ele++;        
                               }                                                  
                      }                        
                      }
                       $puzzler['Ahapuzzler'][$i] = $lesson;                       
                      // $i++;

                    echo json_encode(array("status" => Configure::read('status.success'),"Puzzler" => $puzzler,
                    "msg"=> Configure::read('msg.Subscribed'),"token" => $tokenexist['Agpuzzlertoken']['TOKEN']));    
                      }                      
                      else
                          echo json_encode(array("status" => Configure::read('status.success'),"Puzzler" => $puzzler,
                          "msg"=> Configure::read('msg.No_Exercise'),"token" => $tokenexist['Agpuzzlertoken']['TOKEN']));    
                      }
                      else
                        echo json_encode(array("status" => Configure::read('status.success'),
                          "msg"=> Configure::read('msg.No_Puzzler'),"token" => $tokenexist['Agpuzzlertoken']['TOKEN']));                            
                  }
                }                              
            }
            elseif($auth == Configure::read('msg.Subscription_Expired'))
              echo json_encode(array("status" => Configure::read('status.success'),
                "msg"=> Configure::read('msg.Subscription_Expired'),"token" => $tokenexist['Agpuzzlertoken']['TOKEN'])); 
            elseif($auth == Configure::read('msg.Not_Subscribed'))
              echo json_encode(array("status" => Configure::read('status.success'),
               "msg"=> Configure::read('msg.Not_Subscribed'),"token" => $tokenexist['Agpuzzlertoken']['TOKEN'])); 
        }
        else{
           echo json_encode(array("status" => Configure::read('status.error'),              
              "msg" => Configure::read('msg.Invalid_Token'),"token" => $token)); 
        }
  } 
  else
      echo json_encode(array("status" => Configure::read('status.error'),              
              "msg" => Configure::read('msg.PuzzId_Missing'))); 
  }
  else{
           echo json_encode(array("status" => Configure::read('status.error'),              
              "msg" => Configure::read('msg.No_Token_Received'))); 
        }
}

public function getallpuzzler($tokenreceived){
  $this->autoRender = false;   
  error_log("tokenreceived ".$tokenreceived);
   if($tokenreceived != ""){   
     $prevpuzzler= array();
        $token = $tokenreceived;        
        $tokenexist = $this->Agpuzzlertoken->find("first",array('conditions'=>
          array('Agpuzzlertoken.TOKEN' => $token)));
        if(!empty($tokenexist)){
          $user = $this->Student->findById($tokenexist['Agpuzzlertoken']['STUDENT_ID']);
          $studentid = $user['Student']['id'];
          $auth = $this->authenticate($tokenexist['Agpuzzlertoken']['STUDENT_ID']);
            if($auth == Configure::read('msg.Subscribed')){
                   $subscription = $this->AgPuzzlerSubscription->find("first",array(
                    'conditions' => array('AgPuzzlerSubscription.student_id' => $tokenexist['Agpuzzlertoken']['STUDENT_ID'])));        
              if(!empty($subscription))
               {
                $substartdate = date($subscription['AgPuzzlerSubscription']['SUBSCRIPTION_DATE']);
                $subperiod = $subscription['AgPuzzlerSubscription']['SUBSCRIPTION_PERIOD']-1;
                $subenddate = date("Y-m-d",strtotime('+'.$subperiod.' weeks', strtotime($substartdate)));
                $weekStartDate = date('Y-m-d',strtotime("last Monday", strtotime($substartdate)));        
                $weekEndDate = date('Y-m-d',strtotime("next Sunday", strtotime($subenddate)));        
                $cours = $this->Course->findById($subscription['AgPuzzlerSubscription']['COURSE_ID']);
                $subscription['AgPuzzlerSubscription']['end_date'] = $weekEndDate;        
                $cours = $this->Course->findById($subscription['AgPuzzlerSubscription']['COURSE_ID']);                
                               
              $con = array(
               'CourseLessonMap.course_id' => $cours['Course']['id'],
               'CourseLessonMap.deleted' => 0
              );
              $course_id = $cours['Course']['id'];            
              $course_lesson = $this->CourseLessonMap->query("select * from course_lesson_map where course_id=$course_id and published = 1 and deleted = 0 and srno!=0 order by srno;");
             if(empty($course_lesson)){
                $course_lesson = $this->CourseLessonMap->query("select * from course_lesson_map where course_id=$course_id and published = 1 and deleted = 0 order by published_date;");}      
                 if(!empty($course_lesson))
                 {
                    $j=0;$i=0;
                    foreach($course_lesson as $lessons)
                     {
                        
            $lesson = $this->Lesson->find("first",array('conditions' => 
                        array('Lesson.id' => $lessons['course_lesson_map']['lesson_id'],
                               'Lesson.start_date <=' => date("Y-m-d", strtotime(date("Y-m-d")." +1 day")),
                              'Lesson.end_date >='=> date("Y-m-d", strtotime(date("Y-m-d"))),
                              'Lesson.start_date >=' => $weekStartDate,
                              'Lesson.end_date <='=> $weekEndDate,
                        'Lesson.deleted' => 0))); 
            // $lesson = $this->Lesson->find("first",array('conditions' => 
            //             array('Lesson.id' => $lessons['course_lesson_map']['lesson_id'],
            //                    'Lesson.start_date <=' => date("Y-m-d", strtotime(date("Y-m-d")." +1 day")),
            //                   'Lesson.end_date >='=> date("Y-m-d", strtotime(date("Y-m-d"))),
            //                   'Lesson.start_date >=' => $weekStartDate,                
            //     'Lesson.deleted' => 0)));                         
                         $lesson_element = $this->LessonElementMap->find("all",array('conditions' => 
                array('LessonElementMap.lesson_id' =>$lesson['Lesson']['id'],
                'LessonElementMap.deleted' => 0)));  
          if(!empty($lesson) && !empty($lesson_element)){                        
              $now = new DateTime();
              $now->format('Y-m-d H:i:s');              
              $start_date  =date_create(date("Y-m-d H:i:s"));                            
              $end_date = date_create($lesson['Lesson']['end_date']);              
              $diff= date_diff($end_date, $start_date);

              //accesing days
              $days = $diff->d;             
              $lesson['Lesson']['day_count'] = $days + 1;

              $puzzler['thisweek'][$i] = $lesson;
              $i++;
              }
              else if(empty($lesson)){
            $lesson = $this->Lesson->find("first",array('conditions' => 
              array('Lesson.id' => $lessons['course_lesson_map']['lesson_id'],
              'Lesson.deleted' => 0))); 
            $lesson_element = $this->LessonElementMap->find("all",array('conditions' => 
                array('LessonElementMap.lesson_id' =>$lesson['Lesson']['id'],
                'LessonElementMap.deleted' => 0)));   
                if(!empty($lesson_element)){            
                      $now = new DateTime();
                      $now->format('Y-m-d H:i:s');              
                      $start_date  =date_create(date("Y-m-d H:i:s"));                            
                      $end_date = date_create($lesson['Lesson']['end_date']);              
                      $diff= date_diff($end_date, $start_date);
            // get previouslesson
          $previouslesson = $this->Lesson->find("first",array('conditions' => 
                array('Lesson.id' => $lessons['course_lesson_map']['lesson_id'],
                       'Lesson.start_date <=' => date("Y-m-d", strtotime(date("Y-m-d")." +1 day")),                      
                'Lesson.deleted' => 0)));       
        if(!empty($previouslesson)){                  
                 $puzzler['pastweek'][$j] = $previouslesson;
                 $exe = $this->LessonElementMap->find("all",array('conditions' =>
                 array('LessonElementMap.lesson_id' => $previouslesson['Lesson']['id'],
                  'LessonElementMap.element_type' => 3,
                  'LessonElementMap.deleted' => 0 )));
                  if(!empty($exe)){                 
                 foreach ($exe as $exes) {
                   $stuattmt =  $this->StudentExerciseAttempt->find("first",array('conditions' =>
                    array('StudentExerciseAttempt.student_id' => $user['Student']['id'],
                      'StudentExerciseAttempt.element_id' => $exes['LessonElementMap']['element_id'],                      
                      'StudentExerciseAttempt.deleted' => 0,)));
                   if(!empty($stuattmt))
                    $puzzler['pastweek'][$j]['Lesson']['attempt'] = $stuattmt['StudentExerciseAttempt']['attempt'];
                  else
                    $puzzler['pastweek'][$j]['Lesson']['attempt'] = 0;
                 }}
                 else{
                    $test = $this->LessonElementMap->find("all",array('conditions' =>
                 array('LessonElementMap.lesson_id' => $previouslesson['Lesson']['id'],
                  'LessonElementMap.element_type' => 1,
                  'LessonElementMap.deleted' => 0 )));                  
                 foreach ($test as $tests) {
                   $stuattmt =  $this->StudentTestAttempt->find("first",array('conditions' =>
                    array('StudentTestAttempt.student_id' => $user['Student']['id'],
                      'StudentTestAttempt.test_id' => $tests['LessonElementMap']['element_id'],                    
                      'StudentTestAttempt.deleted' => 0,)));
                   if(!empty($stuattmt))
                    $puzzler['pastweek'][$j]['Lesson']['attempt'] = $stuattmt['StudentTestAttempt']['attempt'];
                  else
                    $puzzler['pastweek'][$j]['Lesson']['attempt'] = 0;
                 }
                 }
          $j++;
        }                                                        
        } // not empty  lesson_element ends                      
        }}
        } 
        }                  
                        if($i == 0 && $j==0)
                  // echo json_encode(array("status" => Configure::read('status.success'),
                  //         "msg"=> Configure::read('msg.No_Puzzler'),"token" => $tokenexist['Agpuzzlertoken']['TOKEN']));                   
                            $result = array("status" => Configure::read('status.success'),
                          "msg"=> Configure::read('msg.No_Puzzler'),"token" => $tokenexist['Agpuzzlertoken']['TOKEN']);                   
                else if($i == 0 && $j !=0)
                      $result = array("status" => Configure::read('status.success'),
                          "msg"=> Configure::read('msg.No_Currentweek_Puzzler'),"puzzler"=> $puzzler,"token" => $tokenexist['Agpuzzlertoken']['TOKEN']);                   
                else if($i != 0 && $j ==0)                  
                    $result = array("status" => Configure::read('status.success'),
                          "msg"=> Configure::read('msg.No_Pastweek_Puzzler'),"puzzler"=> $puzzler,"token" => $tokenexist['Agpuzzlertoken']['TOKEN']);                   
               else                                  
                $result  =array("status" => Configure::read('status.success'),
                    "msg"=> Configure::read('msg.Subscribed'),"puzzler"=> $puzzler,"token" => $tokenexist['Agpuzzlertoken']['TOKEN']);    

            }
            elseif($auth == Configure::read('msg.Subscription_Expired'))              
                  $result = array("status" => Configure::read('status.success'),
                "msg"=> Configure::read('msg.Subscription_Expired'),"token" => $tokenexist['Agpuzzlertoken']['TOKEN']); 

            elseif($auth == Configure::read('msg.Not_Subscribed'))              
               $result =  array("status" => Configure::read('status.success'),
               "msg"=> Configure::read('msg.Not_Subscribed'),"token" => $tokenexist['Agpuzzlertoken']['TOKEN']); 

        }
        else{           
          $result = array("status" => Configure::read('status.error'),              
              "msg" => Configure::read('msg.Invalid_Token'),"token" => $token); 
        }
  }
  else{           
          $result = array("status" => Configure::read('status.error'),              
              "msg" => Configure::read('msg.No_Token_Received')); 
        }

        return $result;
}

public function submit_answer(){
   $this->autoRender = false;    
   if(isset($_POST['token']) && $_POST['token'] != ""){   
    if((isset($_POST['element_id']) && $_POST['element_id'] != "") && 
      (isset($_POST['score']) && $_POST['score'] != "") &&
      (isset($_POST['answers']) && $_POST['answers'] != "") &&      
        (isset($_POST['status']) && $_POST['status'] != ""))
    {
    $data = array();    
    $token = urlencode($_POST['token']);        
     $tokenexist = $this->Agpuzzlertoken->find("first",array('conditions'=>
          array('Agpuzzlertoken.TOKEN' => $token)));
        if(!empty($tokenexist)){
          $user = $this->Student->findById($tokenexist['Agpuzzlertoken']['STUDENT_ID']);
          $student_id = $user['Student']['id'];
          $data['element_id'] = $_POST['element_id'];
          $data['student_id'] = $student_id;
          $data['score'] = $_POST['score'];          
          $data['last_visited'] = 1;          
          $data['isMobileAttempt'] = 1;          
          $data['answers'] = $_POST['answers'];
          $str = "select * from student_exercise_attempt where student_id=".$student_id." and deleted = 0 and element_id = ".$_POST['element_id'];
           $attempts = $this->StudentExerciseAttempt->query($str) ;        
    if(empty($attempts)) {
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
    $data['status'] = $_POST['status'];    
    $lesson_element = $this->LessonElementMap->find("first",array('conditions' => 
                          array('LessonElementMap.element_id' => $_POST['element_id'],
                            'LessonElementMap.element_type' => 3,
                            'LessonElementMap.deleted' => 0)));                                           
        $lessonvalid = $this->Lesson->find("first",array('conditions' => 
                        array('Lesson.id' => $lesson_element['LessonElementMap']['lesson_id'],
                               'Lesson.start_date <=' => date("Y-m-d", strtotime(date("Y-m-d")." +1 day")),
                              'Lesson.end_date >='=> date("Y-m-d", strtotime(date("Y-m-d"))),   
                        'Lesson.deleted' => 0)));       
      if(!empty($lessonvalid)){    
        if(empty($attempts)){ //if no attempts in db before
          $data['answers'] = str_replace("|","!",$data['answers']);     
          $this->StudentExerciseAttempt->save($data);
          if($data['status'] == 1){                                            
          $this->StudentActivity->addOrUpdatemob($student_id,
          $this->StudentActivity->ACTIVITY_TYPES['EXERCISE'], 
          $data['element_id'],
          $this->StudentActivity->ACTIVITY_STATUS['IN PROGRESS'],
            "0"); 
          }
          else if($data['status'] == 2){                                            
          $this->StudentActivity->addOrUpdatemob($student_id,
          $this->StudentActivity->ACTIVITY_TYPES['EXERCISE'], 
          $data['element_id'],
          $this->StudentActivity->ACTIVITY_STATUS['FINISHED'],
            "0"); 
          }
          echo json_encode(array("status" => Configure::read('status.success'),              
              "msg" => Configure::read('msg.Saved'),"token" => $token)); 
        }//if incompleted in web
        else if($data['attempt'] == 1 && $attempts[count($attempts)-1]['student_exercise_attempt']['status'] == 1){
          $data['answers'] = str_replace("|","!",$data['answers']);     
          $this->StudentExerciseAttempt->save($data);          
                    if($data['status'] == 1){                                            
          $this->StudentActivity->addOrUpdatemob($student_id,
          $this->StudentActivity->ACTIVITY_TYPES['EXERCISE'], 
          $data['element_id'],
          $this->StudentActivity->ACTIVITY_STATUS['IN PROGRESS'],
            "0"); 
          }
          else if($data['status'] == 2){                                            
          $this->StudentActivity->addOrUpdatemob($student_id,
          $this->StudentActivity->ACTIVITY_TYPES['EXERCISE'], 
          $data['element_id'],
          $this->StudentActivity->ACTIVITY_STATUS['FINISHED'],
            "0"); 
          }
          echo json_encode(array("status" => Configure::read('status.success'),              
              "msg" => Configure::read('msg.Saved'),"token" => $token)); 
          } //if completed in web
          else if($data['status'] == 1 && $attempts[count($attempts)-1]['student_exercise_attempt']['status'] == 2){
                      echo json_encode(array("status" => Configure::read('status.success'),              
              "msg" => Configure::read('msg.App_Answer_Discarded'),"webattempts" => $attempts)); 
          }
        else if($data['status'] == 2 && $attempts[count($attempts)-1]['student_exercise_attempt']['status'] == 2){
            if(round($_POST['score']) >= round($attempts[count($attempts)-1]['student_exercise_attempt']['score']))  { // app answers scenorio                   
          $data['answers'] = str_replace("|","!",$data['answers']); 
          $sqlqry = "update student_exercise_attempt SET answers='".$data['answers']."',score='".$data['score']."' where student_id='".$student_id."' and element_id='".$data['element_id']."' ";          
          $this->StudentExerciseAttempt->query($sqlqry);  
          echo json_encode(array("status" => Configure::read('status.success'),              
          "msg" => Configure::read('msg.Saved'),"token" => $token)); 
        }   else if(round($_POST['score']) < round($attempts[count($attempts) - 1]['student_exercise_attempt']['score']))  { // Web answers scenorio          
          echo json_encode(array("status" => Configure::read('status.success'),              
          "msg" => Configure::read('msg.App_Answer_Discarded'),"webattempts" => $attempts)); 
          
        }   
      }
        }
        else{ 
          echo json_encode(array("status" => Configure::read('status.error'),              
              "msg" => Configure::read('msg.Puzzler_id_not_valid'),"token" => $token));      
        }
       // Meesage       
      } //  empty token
      else{
           echo json_encode(array("status" => Configure::read('status.error'),              
              "msg" => Configure::read('msg.Invalid_Token'),"token" => $token)); 
        }     
   }
         else if(!isset($_POST['element_id']) || $_POST['element_id'] == "")
                 echo json_encode(array("status" => Configure::read('status.error'),              
                 "msg" => Configure::read('msg.ExerciseId_Missing'))); 
        else if(!isset($_POST['status']) || $_POST['status'] == "")
                 echo json_encode(array("status" => Configure::read('status.error'),              
                 "msg" => Configure::read('msg.Status_Missing'))); 
        else if(!isset($_POST['score']) || $_POST['score'] == "")
           echo json_encode(array("status" => Configure::read('status.error'),              
           "msg" => Configure::read('msg.Score_Missing')));          
         else if(!isset($_POST['answers']) || $_POST['answers'] == "")
           echo json_encode(array("status" => Configure::read('status.error'),              
           "msg" => Configure::read('msg.Answer_Missing'))); 
 }
  else {
           echo json_encode(array("status" => Configure::read('status.error'),              
           "msg" => Configure::read('msg.No_Token_Received'))); 
        }
 }
}


