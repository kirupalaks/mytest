<?php
App::uses('CakeEmail', 'Network/Email');
App::import('Vendor', 'PaymentRequest');
App::import('Vendor', 'dompdf', array('file' => 'dompdf' . DS . 'dompdf_config.inc.php'));
 

class StudentController extends AppController {

  public $name = "Student";
  public $components = array('RequestHandler');
  public $uses = array('Student','Standard','Lesson','ParentRelationship','StudentLessonSkip','StudentTestAttempt','StdCourseMap','StudentCourseMap','Course','CourseModuleMap','CourseLessonMap','Concept','School',
    'Module','Test','Dashboard','SmsStudentGroup','StudentSkipLessons','Admin','LessonElementMap','Exercise','StudentCourseMap','ClassroomStudent','PromotionalCoupon','HinduChallengeStudent','HallticketReg','Standard');

  public function beforeFilter() {
    parent::beforeFilter();
    $this->Auth->allow("verify_email","verify","authorized","register","mapped","getall","check_session");
  }


  public function unique_id($l = 3) {
  return substr((uniqid(mt_rand(), true)), 0, $l);
    }

  public function index() {
    $this->redirect("/student/course");
  } 

  public function hallticketform() {    
    $this->layout = "ahaguru";    
    $user = $this->Auth->user();
    $this->set("standard",$this->Standard->find("all",array( 'order' => array('Standard.name' => 'DESC'))));
    $this->set("school",$this->School->find("all"));
    $couponmap = $this->StudentCourseMap->find('first',array('conditions'=>
      array('StudentCourseMap.student_id' => $user['Student']['id'],         
         'StudentCourseMap.comments LIKE' => '%P1201516%',          
         'StudentCourseMap.payment' => 2,
         'StudentCourseMap.deleted' => 0)));
    if(!isset($couponmap['StudentCourseMap'])){
    $couponmap = $this->StudentCourseMap->find('first',array('conditions'=>
      array('StudentCourseMap.student_id' => $user['Student']['id'],         
         'StudentCourseMap.comments LIKE' => '%P2201516%',          
         'StudentCourseMap.payment' => 2,
         'StudentCourseMap.deleted' => 0)));
  }
  if(!isset($couponmap['StudentCourseMap'])){
    $couponmap = $this->StudentCourseMap->find('first',array('conditions'=>
      array('StudentCourseMap.student_id' => $user['Student']['id'],         
         'StudentCourseMap.comments LIKE' => '%P6201516%',          
         'StudentCourseMap.payment' => 2,
         'StudentCourseMap.deleted' => 0)));
  }           
      if(isset($couponmap['StudentCourseMap']))
        $this->set("promocoupon",1);
      // else if($user['Student']['school_name'] == "Chettinad Hari Shree Vidyalayam")
      //   $this->set("promocoupon",2);
      else if(stripos($user['Student']['school_name'],"KAVI") !== FALSE  )
        $this->set("promocoupon",3);
      else
        $this->set("promocoupon",0);

     $testcenters['venue'] =array(
      array( 'code' => 'CH_SANK','name' => 'Chennai, Vasantha Press Road, Adyar, Sri Sankara Senior Sec School'),          
      // array( 'code' => 'CH_SARA','name' => 'Chennai, T.Nagar, Saradha Vidyalaya School'),      
      array( 'code' => 'CH_KESA','name' => 'Chennai, Mylapore, Kesari Mat Hr Sec School'),
      array( 'code' => 'CH_KARN','name' => 'Chennai, T.Nagar, Karnataka Sanga School'),
      array( 'code' => 'CH_KBV','name' => 'Chennai, Tiruvottiyur, Kavi Bharathi Vidyalaya'),
      array( 'code' => 'MD_KLNP','name' => 'Madurai, Kozhimedu,Viraganoor P.O, K.L.NAGASWAMY Memorial Polytechnic College'),
      array( 'code' => 'BA_MOBI','name' => 'Bangalore, JP nagar 2nd phase, MobiSir Technologies private Ltd., Near by bank of Baroda'),    
      array( 'code' => 'CO_TARG','name' =>'Coimbatore, Target Academy of Mathematics(target tutions), Olampus Ramanathapuram'),
      array( 'code' => 'TRI_BHAR','name' => 'Trichy, Make Trust,Bharathidasan Salai Cantonment'),      
      array( 'code' => 'COH_STAL','name' => 'Cochin, Ernakulam, St Alberts Higher Secondary School'),      
      array('code' => 'TENK_SPEC','name' =>'Tenkasi, Spectrum Matriculation Higher Secondary School, NH-208, Tenkasi-Madurai Road, Kathirkantham' ));
     $this->set("centers",$testcenters);    
  } 

public function hallticketphoto(){
   $this->autoRender = false;   
  if($this->request->is("POST")) {
    // $data = $this->request->data;
    error_log("data".print_r($data,true));
    $user = $this->Auth->user();
      $folder = "img/user".$user['Student']['id'];
        $folder_url = WWW_ROOT.$folder;
        $rel_url = $folder;
        $image = str_replace(' ', '_', $this->data['File']['Content']['name']);
        if(!file_exists($folder_url.'/'.$image)) {
           $data['File']['Content']['name'] = $image;
           $this->HallticketReg->query("update ag_ma_hallticket set image = '".$image."' where HT_STUDENT_ID =".$user['Student']['id']);
        } 
        else {
           ini_set('date.timezone', 'Asia/Kolkata');
           $now = date('Y-m-d-His');
           $filename = $now.$image;
           $data['File']['Content']['name'] = $filename;
$this->HallticketReg->query("update ag_ma_hallticket set image = '".$filename."' where HT_STUDENT_ID =".$user['Student']['id']);
        }
        $this->uploadFiles("img/user".$user['Student']['id'], $this->data['File']);
        $this->redirect("/student/course");
      }
}
  
  public function hallticketform_reg(){
    if($this->request->is("POST")) {
      $mapdata = array();
      $this->layout = ""; 
      $user = $this->Auth->user();
      $data = $this->request->data;          
          error_log("data".print_r($data,true));
          $data['HT_STUDENT_ID'] = $user['Student']['id'];          
          $halltickentry = $this->HallticketReg->findByHtStudentId($user['Student']['id']);          
          if(empty($halltickentry)){
          if(is_numeric($data['HT_SCHOOL_ID'])){
            $this->HallticketReg->save($data);
            $id = $this->HallticketReg->id;
          }
          else{
            $school = $this->School->find("first",array('conditions' => array(
              'School.SCHOOL_NAME LIKE' => "%".$data['HT_SCHOOL_NAME']."%")));            
            if(empty($school)){
              $sch['SCHOOL_NAME'] = $data['HT_SCHOOL_NAME'];
              $this->School->save($sch);
              $sch_id = $this->School->id;
              $data['HT_SCHOOL_ID'] = $sch_id;
              $this->HallticketReg->save($data);
              $id = $this->HallticketReg->id;
            }
            else{
              $data['HT_SCHOOL_ID'] = $school['School']['SCHOOL_ID'];              
              $this->HallticketReg->save($data);
              $id = $this->HallticketReg->id; 
            }
          }
          $regdata = $this->HallticketReg->findById($id);          
          if($regdata['HallticketReg']['HT_TEST_MODE'] == 'Online' && $regdata['HallticketReg']['HT_CHALLENGE_LEVEL'] == "Senior"){              
            $crsmap = $this->StudentCourseMap->find("first",array('conditions'=>array(
              'StudentCourseMap.course_id'=>49,
              'StudentCourseMap.student_id' =>$user['Student']['id'])));            
            if(isset($crsmap['StudentCourseMap']))
            $mapdata['id'] = $crsmap['StudentCourseMap']['id'];
            $mapdata['student_id'] = $user['Student']['id'];
            $mapdata['course_id'] = 49;
            $mapdata['status'] = 1;
            $mapdata['payment'] = 2;
            $mapdata['deleted'] = 0;
            $mapdata['comments']="Online Senior Test Course added";
            error_log("assa".print_r($mapdata,true));
            $this->StudentCourseMap->save($mapdata);
          }        
          if($regdata['HallticketReg']['HT_TEST_MODE'] == 'Online' && $regdata['HallticketReg']['HT_CHALLENGE_LEVEL'] == "Junior"){              
            $crsmap = $this->StudentCourseMap->find("first",array('conditions'=>array(
              'StudentCourseMap.course_id'=>48,
              'StudentCourseMap.student_id' =>$user['Student']['id'])));
            error_log("crs".print_r($crsmap,true));
            if(isset($crsmap['StudentCourseMap']))
            $mapdata['id'] = $crsmap['StudentCourseMap']['id'];
            $mapdata['student_id'] = $user['Student']['id'];
            $mapdata['course_id'] = 48;
            $mapdata['status'] = 1;
            $mapdata['payment'] = 2;
            $mapdata['deleted'] = 0;
            $mapdata['comments']="Online Junior Test Course added";
             $this->StudentCourseMap->save($mapdata);
          }        
           $this->set("json",json_encode(array("msg" => "success")));
    }
    else
         $this->set("json",json_encode(array("msg" => "already_reg")));
    }
  }

  public function viewpdf($id) {    
    $this->layout = 'pdf'; //this will use the pdf.ctp layout    
    $data = $this->HallticketReg->findByHtStudentId($id);    
    $school = $this->School->findBySchoolId($data['HallticketReg']['HT_SCHOOL_ID']);
    $std = $this->Standard->findById($data['HallticketReg']['HT_STANDARD']);
    // <img src='/var/ahaguru3/app/webroot/img/userstid/image' width='100px' height='100px'/>
    if($data['HallticketReg']['HT_TEST_MODE'] == "Offline"){
    $html = "<div><img src='/var/ahaguru3/app/webroot/img/hallticketlogo.png' height='80px' width='650px'></div>
    <center><h2 class='text-center'>Hall Ticket - 25th October 2015</h2></center>";    
    // if($data['HallticketReg']['image'] != NULL && $data['HallticketReg']['image'] !='')
    //  $html = $html."<img src='/var/ahaguru3/app/webroot/img/userstid/image' width='100px' height='100px'/>";
    $html = $html."<table  border='1' style='width:100%;font-size:20px'><tr><td><b>Hall Ticket Number </b> </td><td>hallticketnumber";
        if($data['HallticketReg']['image'] != NULL && $data['HallticketReg']['image'] !='')
    $html = $html."<img style='margin-left:20px' src='/var/ahaguru3/app/webroot/img/userstid/image' width='100px' height='100px'/>";
    $html.="</td></tr>
    <tr><td><b>Student Name </b> </td><td>std_name</td></tr>   
    <tr><td><b>Level</b> </td><td>level</td></tr>
    <tr><td><b>Test Center </b> </td><td>tst_center</td></tr>
    <tr><td><b>Venue Address </b> </td><td>ven_address</td></tr>
    <tr><td><b>Test Time </b> </td><td>10.30 AM to 12.00 PM</td></tr>
    <tr><td><b>School </b> </td><td>school_name</td></tr>    
    <tr><td><b>Standard </b> </td><td>stand schsec</td></tr>
    </table><br/><br/>
    <center><h3><i>Students should be present at the venue at least 15 minutes before the exam time.</i><br/>
    <i>Hall ticket should be presented at the venue before the exam.</i><br/>
    <i>Ahaguru Contact Number: +91 96001 00090 www.ahaguru.com</i></h3></center>
    <div style='page-break-before:always;'><h4>Instructions for The Hindu Ahaguru Physics Challenge Test</h4>
      <p>Please carry the following items with you to your exam venue.</p>
        <ol><li>AhaGuru Hall ticket </li>
          <li>School photo id</li>
          <li>Water bottle, Stationary (pen)</li></ol>
          <p>Exam will start at 10.30 a.m on Sunday, the 25th of October.</p>
        <p>You are expected to be present atleast 15 minutes before the exam.</p>
        <p>Duration of the exam is 90 minutes.</p>
        <h4>Venue - Contact details</h4>
        <ul><li>Chennai, Adyar, Sri Sankara Senior Sec School - 9790920752</li>        
        <li>Chennai, Mylapore, Kesari Mat Hr Sec School - 9962640174</li>
        <li>Chennai, T.Nagar, Karnataka Sanga School - 9710833545</li>            
        <li>Chennai, Tiruvottiyur, Kavi Bharathi Vidyalaya, 792, Thiruvottiyur High Rd, Tiruvottiyur</li>
        <li>Trichy, Make Trust,Bharathidasan Salai Cantonment - 8939820480</li>
        <li>Tenkasi, Spectrum Matriculation Higher Secondary School NH-208, Tenkasi-Madurai Road, Kathirkantham, E-vilakku - 9043611223 / 9994594914</li>        
        <li>Madurai, Kozhimedu ,Viraganoor P.O, K.L.NAGASWAMY Memorial Polytechnic College - 8939820413</li>
        <li>Cochin, Ernakulam, St Alberts Higher Secondary School - 9597507152</li>        
        <li>Coimbatore, Olampus Ramanathapuram, Target Academy of Mathematics(target tutions) - 8903906564</li>
        <li>Bangalore, MobiSir Technologies private Ltd, 933A, 21st Main, JP nagar 2nd phase, Bangalore, Pin 560078. Near by bank of Baroda - 9632546165</li>
        </ul></div>";                
    if($data['HallticketReg']['HT_TEST_LOCATION_CODE'] == "CH_SANK"){
     $venue = "Chennai, Adyar, Sri Sankara Senior Sec School,Vasantha Press Road, Adyar, Opp to Forties (Malar) Hospital";  
      }
      else if($data['HallticketReg']['HT_TEST_LOCATION_CODE'] == "CH_KBV"){
        $venue="Chennai, Kavi Bharathi Vidyalaya, 792, Thiruvottiyur High Rd, Tiruvottiyur, Chennai, Tamil Nadu 600019";  
      }
      else if($data['HallticketReg']['HT_TEST_LOCATION_CODE'] == "CH_KESA"){
      $venue ="Kesari Higher Secondary School, Thiru Vi Ka 3rd St, Mylapore, Chennai, Tamil Nadu 600014";  
      }
      else if($data['HallticketReg']['HT_TEST_LOCATION_CODE'] == "CH_KARN"){
      $venue="Karnataka Sangha Higher Secondary School, 111, Habibullah Road,  T.Nagar, Panagal Park, Chennai, Tamil Nadu 600017";  
      }    
      else if($data['HallticketReg']['HT_TEST_LOCATION_CODE'] == "CO_TARG"){
      $venue="Target Academy of Mathematics(target tutions), No;6 Devar Street, Olampus Ramanathapuram,Olampus bus stop back side, Coimbatore - (pin)641045</li>";  
      }
      else if($data['HallticketReg']['HT_TEST_LOCATION_CODE'] == "MD_KLNP"){
      $venue="K.L.NAGASWAMY Memorial Polytechnic College, Kozhimedu, Viraganoor P.O, Madurai - 625 009 ";  
      }      
      else if($data['HallticketReg']['HT_TEST_LOCATION_CODE'] == "TRI_BHAR"){
      $venue="Make Trust, # 103 Pavalam Block, St Pauls Complex, Opp to Head Post office,Bharathidasan Salai Contonment, Trichy 1";  
      }
      else if($data['HallticketReg']['HT_TEST_LOCATION_CODE'] == "TENK_SPEC"){
      $venue="Spectrum Matriculation Higher Secondary School NH-208, Tenkasi-Madurai Road, Kathirkantham, E-vilakku, Elathur(PO) - 627803";  
      }
      else if($data['HallticketReg']['HT_TEST_LOCATION_CODE'] == "COH_STAL"){
      $venue="St.Alberts higher secondary school Ernakulam, Banerji Rd, Kacheripady, Ernakulam, Cochin, Kerala 682035";  
      }
      else if($data['HallticketReg']['HT_TEST_LOCATION_CODE'] == "BA_MOBI"){
      $venue="MobiSir Technologies private Ltd, 933A, 21st Main, JP nagar 2nd phase, Bangalore, Pin 560078. Near by bank of Baroda";  
      }           

     $placeholders=array('hallticketnumber','std_name','tst_center','ven_address','school_name','stand','level','schsec','image','stid');
     $string=array($data['HallticketReg']['HT_HALLTICKET_NO'],$data['HallticketReg']['HT_STUDENT_NAME'],
      $data['HallticketReg']['HT_TEST_LOCATION'],$venue,$school['School']['SCHOOL_NAME'],$std['Standard']['name'],
      $data['HallticketReg']['HT_CHALLENGE_LEVEL'],$data['HallticketReg']['HT_SECTION'],$data['HallticketReg']['image'],$data['HallticketReg']['HT_STUDENT_ID']);
           $html = str_replace($placeholders, $string, $html);
        $html= stripslashes($html);
  }
  else{
        $html = "<div><img src='/var/ahaguru3/app/webroot/img/hallticketlogo.png' height='80px' width='650px'></div>
    <center><h2 class='text-center'>Hall Ticket - 25th October 2015</h2></center>";    
    $html = $html."<table  border='1' style='width:100%;font-size:20px'><tr><td><b>Hall Ticket Number </b> </td><td>hallticketnumber";
        if($data['HallticketReg']['image'] != NULL && $data['HallticketReg']['image'] !='')
    $html = $html." <img style='margin-left:20px' src='/var/ahaguru3/app/webroot/img/userstid/image' width='100px' height='100px'/>";
    $html.="</td></tr>     
    <tr><td><b>Student Name </b> </td><td>std_name</td></tr>
    <tr><td><b>Level</b> </td><td>level</td> </tr>
    <tr><td><b>Test Mode </b> </td><td>Online</td></tr>
    <tr><td><b>Test Duration </b> </td><td>90 mins</td></tr>
    <tr><td><b>Test Time </b> </td><td>Test can be taken any time between 11.00 am to 10.00 pm</td></tr>
    <tr><td><b>School </b> </td><td>school_name</td></tr>    
    <tr><td><b>Standard </b> </td><td>stand schsec</td></tr>
    </table><br/><br/>
    <center><h3><i>Online tests can be taken on 25th October starting between 11.00 am to 10.00 pm for 90 minutes.</i><br/>
    <i>Please ensure that you have a stable Internet connection. Usage of Chrome browser is highly recommended.</i><br/>
    <i>Online Test Contact Number: +91 97318 44708 www.ahaguru.com</i></h3></center>";    
     $placeholders=array('hallticketnumber','std_name','school_name','stand','level','schsec','image','stid');
     $string=array($data['HallticketReg']['HT_HALLTICKET_NO'],$data['HallticketReg']['HT_STUDENT_NAME'],
      $school['School']['SCHOOL_NAME'],$std['Standard']['name'],$data['HallticketReg']['HT_CHALLENGE_LEVEL'],$data['HallticketReg']['HT_SECTION'],$data['HallticketReg']['image'],$data['HallticketReg']['HT_STUDENT_ID']);
           $html = str_replace($placeholders, $string, $html);

    //        $html = "<div><img src='/var/ahaguru3/app/webroot/img/hallticketlogo.png' height='80px' width='650px'></div>
    // <center><h2 class='text-center'>Hall Ticket - 25th October 2015</h2></center>";        
    // $html = $html."<table  border='1' style='width:100%;font-size:20px'><tr><td><b>Hall Ticket Number </b> </td><td>";        
    // $html.="</td></tr>
    // <tr><td><b>Student Name </b> </td><td height='30'></td></tr>   
    // <tr><td><b>Level</b> </td><td></td></tr>
    // <tr><td><b>Test Center </b> </td><td height='50'></td></tr>
    // <tr><td><b>Venue Address </b> </td><td height='50'></td></tr>
    // <tr><td><b>Test Time </b> </td><td >10.30 AM to 12.00 PM</td></tr>
    // <tr><td><b>School </b> </td><td height='30'></td></tr>    
    // <tr><td><b>Standard </b> </td><td></td></tr>
    // <tr><td><b>Mobile Number </b> </td><td></td></tr>
    // <tr><td><b>Email </b> </td><td height='20'></td></tr>
    // <tr><td><b>Address </b> </td><td height='60'></td></tr>
    // </table><br/><br/>";
        $html= stripslashes($html);

  }
  $dompdf = new DOMPDF();
  $dompdf->load_html($html);    
  $dompdf->render();  
   $dompdf->stream("HinduAhaguruPhysicsChallenge2_Hallticket.pdf");
}

 public function getall(){
  $this->layout = "default";
  $this->set('students',json_encode($this->Student->find("all",array('conditions' => array('Student.deleted'=> 0)))));
 }
  
  public function adata_index() {
    $conditions = array(
      'Student.deleted' => 0
    );
   $students = $this->Student->find("all", array('conditions'=>$conditions));
                $this->set("json", json_encode($students));
  }

  public function authorized(){
    if($this->Auth->user()){
       $user = $this->Auth->user();
       if($user['role'] == "admin")
        $this->set("json",json_encode(array("role"=>"admin","loggedin" =>"yes")));
      else if(isset($user['ClassroomStudent']) || (isset($user['Student']) && isset($_SESSION['classroomstudent'])))
        $this->set("json",json_encode(array("role"=>"classroomstudent","loggedin" =>"yes")));
      else if(isset($user['Student']) && !isset($_SESSION['classroomstudent']))
        $this->set("json",json_encode(array("role"=>"student","loggedin" =>"yes")));      
      else
      $this->set("json",json_encode("yes"));
    }
    else
      $this->set("json",json_encode("no"));
  }

  public function sdata_index() {
    $user = $this->Auth->user();
    $user = $this->Student->findById($user['Student']['id']);
    $user = $user['Student'];
    if(isset($user['standard'])) {
        $standard = $this->Standard->findById($user['standard']);
        $user['standard'] = $standard['Standard']['name'];  
    }
    
    if(isset($user['parent_relationship'])) {
        $parent_relationship = $this->ParentRelationship->findById($user['parent_relationship']);
        $user['parent_relationship'] = $parent_relationship['ParentRelationship']['name'];  
    }
    
    if ( file_exists(WWW_ROOT."/img/usr".$user['id']."/profile_200.jpg") ) {
      $user['photo'] = "/img/usr".$user['id']."/profile_200.jpg";
    } else {
      $user['photo'] = "Photo Not Available";
    }
    
    unset($user['id']);
    $this->set("user", json_encode($user));
  } 

  public function adata_delete($studentid) {
    if($this->Student->setDelete($studentid))
      $this->set("json", json_encode(array("message" => "deleted")));
    else 
      $this->set("json", json_encode(array("message" => "error")));
  }

    public function adata_course_save($id) 
    {
        $course_map = $this->StudentCourseMap->findAllByStudentId($id);
        $data = $this->request->data;
        $this->set("json", json_encode(array("message" => "Unable to Save")));
          for($i = 0; $i < count($course_map); $i++)
          {
            if($course_map[$i]['StudentCourseMap']['course_id'] == $data['course_id']) 
            {
              $this->StudentCourseMap->id = $course_map[$i]['StudentCourseMap']['id'];
              $data['id'] = $this->StudentCourseMap->id;
              $this->StudentCourseMap->save($data);
              $this->set("json", json_encode(array("message" => "Saved Successfully")));
            }
          }
          $cond= array(
            'StudentCourseMap.student_id' => $id,
            'StudentCourseMap.status' => 1,
            'StudentCourseMap.deleted' => 0
          );
          $student = $this->StudentCourseMap->find("all",array('conditions' => $cond));
          if(empty($student))
            $this->Student->query("update students set student_status = '2' where id = $id");
          else
            $this->Student->query("update students set student_status = '3' where id = $id");
          if(isset($data['deleted']) && $data['deleted'] == 1) 
          {
            $this->StudentTestAttempt->deleteAttemptOfCourse($data['student_id'], $data['course_id']);
            $this->StudentLessonSkip->deleteskipLessons($data['student_id'], $data['course_id']);
            $this->StudentSkipLessons->deleteskipLessons($data['student_id'], $data['course_id']);
          }
          else
          {
            $this->StudentLessonSkip->skipLessons($data['student_id'], $data['course_id'],$data['lessons']);
            $save = $this->StudentSkipLessons->skip($data['student_id'],$data['course_id'],$data['lessons']);
            if($save == 0)
              $this->set("json", json_encode(array("message" => "not saved")));
          }
    }

   public function adata_course_batch($course,$id){
    if($id == 0)
    {
          $conditions = array (
            'StudentCourseMap.course_id' => $course,
            'StudentCourseMap.deleted' => 0
          );
      $i = 0;
      $stud = $this->StudentCourseMap->find("all", array('conditions'=>$conditions));      
      foreach($stud as $stude)
      {              
         $conditions = array(
           'Student.id' => $stude['StudentCourseMap']['student_id'],
           'Student.deleted' => 0
          );
         $students= $this->Student->find("all", array('conditions'=>$conditions));
         if(!empty($students))
         {
           $student[$i] = $students[0]; 
           $i++;
         }
       }
    }
    else if($id <= 3)
    {
        $conditions = array (
          'StudentCourseMap.course_id' => $course,
          'StudentCourseMap.payment' => $id,
          'StudentCourseMap.status' => 1,
          'StudentCourseMap.deleted' => 0
        );
        $i = 0;
        $stud = $this->StudentCourseMap->find("all", array('conditions'=>$conditions));      
        foreach($stud as $stude)
        {
            $conditions = array(
              'Student.id' => $stude['StudentCourseMap']['student_id'],
              'Student.deleted' => 0
            );
            $students= $this->Student->find("all", array('conditions'=>$conditions));
            if(!empty($students))
            {
              $student[$i] = $students[0]; 
              $i++;
            }
          }
    }
    else if($id == 4)
    {
          $conditions = array (
            'StudentCourseMap.course_id' => $course,
            'StudentCourseMap.status' => 2,
            'StudentCourseMap.deleted' => 0
          );
      $i = 0;
      $stud = $this->StudentCourseMap->find("all", array('conditions'=>$conditions));      
      foreach($stud as $stude)
      {              
         $conditions = array(
           'Student.id' => $stude['StudentCourseMap']['student_id'],
           'Student.deleted' => 0
          );
         $students= $this->Student->find("all", array('conditions'=>$conditions));
         if(!empty($students))
         {
           $student[$i] = $students[0]; 
           $i++;
         }
       }
    }
    else if($id == 5)
    {
          $conditions = array (
            'StudentCourseMap.course_id' => $course,
            'StudentCourseMap.comments LIKE' => "%Promotional Code%",
            'StudentCourseMap.deleted' => 0
          );
      $i = 0;
      $stud = $this->StudentCourseMap->find("all", array('conditions'=>$conditions));      
      foreach($stud as $stude)
      {              
         $conditions = array(
           'Student.id' => $stude['StudentCourseMap']['student_id'],
           'Student.deleted' => 0
          );
         $students= $this->Student->find("all", array('conditions'=>$conditions));
         if(!empty($students))
         {
           $student[$i] = $students[0]; 
           $i++;
         }
       }
    }
    else
    {
        $conditions = array (
          'StudentCourseMap.course_id' => $course,
          'StudentCourseMap.status' => 2,
          'StudentCourseMap.deleted' => 0
        );
        $std = $this->StudentCourseMap->find("all",array('group'=>'StudentCourseMap.student_id','conditions'=>$conditions));
        $conditions = array (
          'StudentCourseMap.course_id' => $course,
          'StudentCourseMap.status' => 3,
          'StudentCourseMap.deleted' => 0
        );
        $std += $this->StudentCourseMap->find("all",array('group'=>'StudentCourseMap.student_id','conditions'=>$conditions));
        $i = 0;
        foreach($std as $stds)
        {
          $condition = array( 
            'StudentCourseMap.student_id' => $stds['StudentCourseMap']['student_id'],
            'StudentCourseMap.status' => 1,
            'StudentCourseMap.deleted' =>0
          );
          $std = $this->StudentCourseMap->find("all",array('conditions'=>$condition));        
          if(empty($std))
          {
            $conditions = array(
              'Student.id' => $stds['StudentCourseMap']['student_id'],
              'Student.deleted' => 0
            );
            $students= $this->Student->find("all", array('conditions'=>$conditions));
            if(!empty($students))
            {
              $student[$i] = $students[0]; 
              $i++;
            }
          }
        }
     }
          $this->set("json", json_encode($student));
      }
                                
   /* search students*/
   public function adata_search($data){
     if(isset($data)){
              $condi = array( 
     'OR' => array(array(
       'Student.email LIKE' => "$data%",
      'Student.deleted' => 0),
      array('Student.parent_email LIKE' => "$data%",
       'Student.deleted' => 0 ),
      array('Student.mobile_number LIKE' => "$data%",
       'Student.deleted' => 0 ),
      array('Student.user_id LIKE' => "$data%",
       'Student.deleted' => 0 ),
      array('Student.name LIKE' => "$data%",
      'Student.deleted' => 0)));
       $i = 0;
       $student = $this->Student->find("all", array('conditions'=>$condi));
            $this->set("json", json_encode($student));
          }}

   /* get students detail from database based on their batch/status  */
    public function adata_batch_view($id)
     {
      if($id == 0)
      {
        $i =0 ;
        $conditions = array(
         'Student.deleted' => 0,
         'Student.student_status' => 3
        );
        $students= $this->Student->find("all", array('conditions'=>$conditions));
        $this->set("json", json_encode($students));
      }
      else if($id<=3)
      {
        $conditions = array(
         'StudentCourseMap.Payment' => $id,
         'StudentCourseMap.status' => 1,
         'StudentCourseMap.deleted' => 0
        );
        $stud = $this->StudentCourseMap->find("all",array('group' => 'StudentCourseMap.student_id','conditions'=>$conditions));
        $i = 0;
        foreach($stud as $stude)
        {
          $conditions = array(
           'Student.id' => $stude['StudentCourseMap']['student_id'],
           'Student.deleted' => 0
          );
          $students= $this->Student->find("all", array('conditions'=>$conditions));
          if(!empty($students))
          {
            $student[$i] = $students[0]; 
            $i++;
          }
        }
        $this->set("json", json_encode($student));
      }
      else if($id == 4)
      {
        // $conditions = array(
        //  'StudentCourseMap.Payment' => $id,
        //  'StudentCourseMap.status' => 1,
        //  'StudentCourseMap.deleted' => 0
        // );
        // $stud = $this->StudentCourseMap->find("all",array('group' => 'StudentCourseMap.student_id','conditions'=>$conditions));
        // $i = 0;
        // foreach($stud as $stude)
        // {
        //   $conditions = array(
        //    'Student.id' => $stude['StudentCourseMap']['student_id'],
        //    'Student.deleted' => 0
        //   );
        //   $students= $this->Student->find("all", array('conditions'=>$conditions));
        //   if(!empty($students))
        //   {
        //     $student[$i] = $students[0]; 
        //     $i++;
        //   }
        // }
        // $this->set("json", json_encode($student));
        $i =0 ;
        $conditions = array(
         'Student.deleted' => 0,
         'Student.student_status' => 2
        );
        $students= $this->Student->find("all", array('conditions'=>$conditions));
        $this->set("json", json_encode($students));
      }
      else if($id == 5)
      {
          $conditions = array(
            'StudentCourseMap.comments LIKE' => "%Promotional Code%",
            'StudentCourseMap.deleted' => 0
          );
          $stud = $this->StudentCourseMap->find("all",array('group' => 'StudentCourseMap.student_id','conditions'=>$conditions));
          $i = 0;
          foreach($stud as $stude)
          {        
             $conditions = array(
              'Student.id' => $stude['StudentCourseMap']['student_id'],
              'Student.deleted' => 0
             );
             $students= $this->Student->find("all", array('conditions'=>$conditions));
             if(!empty($students))
             {
                $student[$i] = $students[0]; 
                $i++;
              }
           }
           $this->set("json", json_encode($student));
         }
      else{
        $std = $this->StudentCourseMap->query("select * from student_course_map where deleted = 1 group by student_id;");
        $i = 0;
        if(!empty($std))
        {
          foreach($std as $stds)
          {
            $condition = array( 
             'StudentCourseMap.student_id' => $stds['student_course_map']['student_id'],
             'StudentCourseMap.status' => 1,
             'StudentCourseMap.deleted' =>0
            );
            $std = $this->StudentCourseMap->find("all",array('conditions'=>$condition));
            if(empty($std))
            {
              $conditions = array(
                'Student.id' => $stds['student_course_map']['student_id'],
                'Student.deleted' => 0
              );
              $students= $this->Student->find("all", array('conditions'=>$conditions));
              if(!empty($students))
              {
                $student[$i] = $students[0]; 
                $i++;
              }
            }
          }
          $this->set("json", json_encode($student));
        }
        else{
          $conditions = array(
            'Student.student_status' => 2,
            'Student.deleted' => 0
          );
          $students= $this->Student->find("all", array('conditions'=>$conditions));
          $this->set("json", json_encode($students));
        }
      }
    }

    /*get students registered with promotional coupon*/
     public function adata_promo_view()
     {            
        $conditions = array(
          'StudentCourseMap.comments LIKE' => "%Promotional Code%",
          'StudentCourseMap.deleted' => 0
          );
     $stud = $this->StudentCourseMap->find("all",array('group' => 'StudentCourseMap.student_id','conditions'=>$conditions));
     $i = 0;
     foreach($stud as $stude){
       
      $conditions = array(
      'Student.id' => $stude['StudentCourseMap']['student_id'],
           'Student.deleted' => 0
          );
   $students= $this->Student->find("all", array('conditions'=>$conditions));
      if(!empty($students)){
               $student[$i] = $students[0]; 
                     $i++;}}
  
                      $this->set("json", json_encode($student));
    }


     /* get deleted students detail from database based on their batch/status  */
     public function adata_deletedstudents($id) {
      if($id == 0)
      {        
          $conditions = array(
           'Student.deleted' => 1,
           'Student.student_status' => 3
          );
          $students= $this->Student->find("all", array('conditions'=>$conditions));
          if(!empty($students))
          {
            $this->set("json", json_encode($students));

          }
      }
      else if($id <= 3)
      {
        $conditions = array(
          'StudentCourseMap.Payment' => $id,
          'StudentCourseMap.status' => 1,
          'StudentCourseMap.deleted' => 0
        );
        $stud = $this->StudentCourseMap->find("all",array('group' => 'StudentCourseMap.student_id','conditions'=>$conditions));
        $i = 0;
        foreach($stud as $stude)
        {
          $conditions = array(
           'Student.id' => $stude['StudentCourseMap']['student_id'],
           'Student.deleted' => 1
          );
          $students= $this->Student->find("all", array('conditions'=>$conditions));
          if(!empty($students))
          {
            $student[$i] = $students[0]; 
            $i++;
          }
        }
        $this->set("json", json_encode($student));
      }
      else if($id == 4)
      {        
          $conditions = array(
           'Student.deleted' => 1,
           'Student.student_status' => 2
          );
          $students= $this->Student->find("all", array('conditions'=>$conditions));
          if(!empty($students))
          {
            $this->set("json", json_encode($students));

          }
      }
      else if($id == 5)
      {
           $conditions = array(
          'StudentCourseMap.comments LIKE' => "%Promotional Code%",
          'StudentCourseMap.deleted' => 1
          );
         $stud = $this->StudentCourseMap->find("all",array('group' => 'StudentCourseMap.student_id','conditions'=>$conditions));
         $i = 0;
         foreach($stud as $stude)
         {        
            $conditions = array(
              'Student.id' => $stude['StudentCourseMap']['student_id'],
              'Student.deleted' => 0
            );
            $students= $this->Student->find("all", array('conditions'=>$conditions));
            if(!empty($students))
            {
              $student[$i] = $students[0]; 
              $i++;
            }
         }
         $this->set("json", json_encode($student));
      }
      else
      {
        $std = $this->StudentCourseMap->query("select * from student_course_map where deleted = 0 and (status = '2' or status = '3') group by student_id;");
        $i = 0;
        foreach($std as $stds)
        {
          $condition = array( 
           'StudentCourseMap.student_id' => $stds['student_course_map']['student_id'],
           'StudentCourseMap.status' => 1,
           'StudentCourseMap.deleted' =>0
          );
          $std = $this->StudentCourseMap->find("all",array('conditions'=>$condition));        
          if(empty($std))
          {
            $conditions = array(
             'Student.id' => $stds['student_course_map']['student_id'],
             'Student.deleted' => 1
            );
            $students= $this->Student->find("all", array('conditions'=>$conditions));
            if(!empty($students))
            {
              $student[$i] = $students[0]; 
              $i++;
            }
          }
        }
        $this->set("json", json_encode($student));
      }
    }


/*list coupon students based on coupo code*/
public function adata_coupon_students($course_id,$coupid) 
 {  
    if($course_id == 0)
      $couponcode = $this->PromotionalCoupon->find("first", 
        array('conditions' => array('PromotionalCoupon.id' => $coupid,'PromotionalCoupon.deleted' => 0)));
    else
      $couponcode = $this->PromotionalCoupon->find("first", 
        array('conditions' => array('PromotionalCoupon.id' => $coupid,'PromotionalCoupon.course_id' => $course_id,'PromotionalCoupon.deleted' => 0)));
    if($course_id != 0){
    $con = array(
        'StudentCourseMap.comments LIKE' =>"%Promotional Code ".$couponcode['PromotionalCoupon']['coupon_code']."%",
        'StudentCourseMap.deleted' => 0,
        'StudentCourseMap.course_id' => $course_id
      );
  }
  else{
   $con = array(
        'StudentCourseMap.comments LIKE' =>"%Promotional Code ".$couponcode['PromotionalCoupon']['coupon_code']."%",
        'StudentCourseMap.deleted' => 0
              ); 
  }
    $i = 0;
    $stud = $this->StudentCourseMap->find("all", array('conditions'=>$con));      
    foreach($stud as $stude)
      {
        $conditions = array(
         'Student.id' => $stude['StudentCourseMap']['student_id'],
         'Student.deleted' => 0
        );
        $students= $this->Student->find("all", array('conditions'=>$conditions));
        if(!empty($students))
          {
            $student[$i] = $students[0]; 
            $i++;
          }
      }
      $this->set("json", json_encode($student));
  }


 public function adata_coursefilter($courseid,$id) 
 {
    if($id == 0)
    {
      $conditions = array (
       'StudentCourseMap.course_id' => $courseid,
        'StudentCourseMap.deleted' => 0
      );
      $i = 0;
      $stud = $this->StudentCourseMap->find("all", array('conditions'=>$conditions));      
      foreach($stud as $stude)
      {
         $conditions = array(
           'Student.id' => $stude['StudentCourseMap']['student_id'],
           'Student.deleted' => 1
         );
         $students= $this->Student->find("all", array('conditions'=>$conditions));
         if(!empty($students))
         {
            $student[$i] = $students[0]; 
            $i++;
         }
      }
    }
    else if($id <=3)
    {
        $conditions = array (
          'StudentCourseMap.course_id' => $courseid,
          'StudentCourseMap.payment' => $id,
          'StudentCourseMap.deleted' => 0
        );
        $i = 0;
        $stud = $this->StudentCourseMap->find("all", array('conditions'=>$conditions));      
        foreach($stud as $stude)
        {
          $conditions = array(
            'Student.id' => $stude['StudentCourseMap']['student_id'],
            'Student.deleted' => 1
          );
          $students= $this->Student->find("all", array('conditions'=>$conditions));
          if(!empty($students))
          {
            $student[$i] = $students[0]; 
            $i++;
          }
        }
    }
    else if($id == 4)
    {
      $conditions = array (
        'StudentCourseMap.course_id' => $courseid,
        'StudentCourseMap.deleted' => 0,
        'StudentCourseMap.comments LIKE' => "%Promotional Code%"
      );
      $i = 0;
      $stud = $this->StudentCourseMap->find("all", array('conditions'=>$conditions));      
      foreach($stud as $stude)
      {
         $conditions = array(
           'Student.id' => $stude['StudentCourseMap']['student_id'],
           'Student.deleted' => 1
         );
         $students= $this->Student->find("all", array('conditions'=>$conditions));
         if(!empty($students))
         {
            $student[$i] = $students[0]; 
            $i++;
         }
      }
    }
    else{
        $condition = array( 
        'StudentCourseMap.course_id' => $courseid,
          'StudentCourseMap.status' => 2,
          'StudentCourseMap.deleted' =>0
                         );
        $std = $this->StudentCourseMap->find("all",array('group'=>'StudentCourseMap.student_id','conditions'=>$condition));
     $condition = array( 
        'StudentCourseMap.course_id' => $courseid,
          'StudentCourseMap.status' => 3,
          'StudentCourseMap.deleted' =>0
                         );
        $std += $this->StudentCourseMap->find("all",array('group'=>'StudentCourseMap.student_id','conditions'=>$condition));
         $i = 0;
    foreach($std as $stds){
        
               $condition = array( 
           'StudentCourseMap.student_id' => $stds['StudentCourseMap']['student_id'],
          'StudentCourseMap.status' => 1,
          'StudentCourseMap.deleted' =>0
                         );
       $std = $this->StudentCourseMap->find("all",array('conditions'=>$condition));
        
       if(empty($std)){
         $conditions = array(
      'Student.id' => $stds['StudentCourseMap']['student_id'],
           'Student.deleted' => 1
          );
   $students= $this->Student->find("all", array('conditions'=>$conditions));
    if(!empty($students)){
              $student[$i] = $students[0]; 
                     $i++;}}}}
                  $this->set("json", json_encode($student));
          }  
      
    public function adata_lessonview($modid,$studid) {
      $lesson = array();
     $course = $this->CourseModuleMap->findByModuleId($modid);
        $lesson['lessons'] = $this->Module->getAllLessons($modid,$studid,$course['CourseModuleMap']['id']);
        $lesson['Course'] = $course;
      $conds = array(
       'StudentLessonSkip.student_id =' => $studid,
        'StudentLessonSkip.module_id =' => $modid,
        'StudentLessonSkip.deleted =' => 0
    );
     $lessonskip =$this->StudentLessonSkip->find('first', array("conditions" => $conds));
              if(empty($lessonskip))
      $lesson['lessonstoskip'] = 0;
    else
     $lesson['lessonstoskip'] = $lessonskip['StudentLessonSkip']['skip_lessons']; 
    
    $this->set("json",json_encode($lesson));
   }
 
  public function adata_course($id) {
      $courses = array();
                     $conditions = array(
        'StudentCourseMap.student_id =' => $id,
        'StudentCourseMap.deleted =' => 0
    );
     
    $student_course_map = $this->StudentCourseMap->find('all', array("conditions" => $conditions));
        if(isset($student_course_map['StudentCourseMap'])) {
        $course = $this->Course->findById($student_course_map['StudentCourseMap']['course_id']);
          $cond = array(
        'CourseLessonMap.course_id =' => $course['Course']['id'],
        'CourseLessonMap.deleted =' => 0
    );
         $lesson_map = $this->CourseLessonMap->find('first', array("conditions" => $cond));
        $courses[0]['id'] = $course['Course']['id'];
        $courses[0]['name'] = $course['Course']['name'];
        $courses[0]['payment'] = $student_course_map['StudentCourseMap']['payment'];
        $courses[0]['status'] = $student_course_map['StudentCourseMap']['status'];
        $courses[0]['lessons'] = $this->Course->getAllLessons($course['Course']['id'], $id);       
     $conds = array(
       'StudentLessonSkip.student_id =' => $id,
        'StudentLessonSkip.course_id =' => $course['Course']['id'],
        'StudentLessonSkip.deleted =' => 0
    );
     $lessonskip =$this->StudentLessonSkip->find('all', array("conditions" => $conds));
              if(empty($lessonskip))
      $courses[0]['lessonstoskip'] = 0;
    else
     $courses[0]['lessonstoskip'] = $lessonskip[0]['StudentLessonSkip']['skip_lessons']; 
    }
            else {
      for($j = 0; $j< count($student_course_map); $j++) {
        $course = $this->Course->findById($student_course_map[$j]['StudentCourseMap']['course_id']);
             $cond = array(
        'CourseLessonMap.course_id =' => $course['Course']['id'],
        'CourseLessonMap.deleted =' => 0,
        'CourseLessonMap.published =' => 1
    );
          $lesson_map = $this->CourseLessonMap->find('first', array("conditions" => $cond));
         $courses[$j]['id'] = $course['Course']['id'];
        $courses[$j]['name'] = $course['Course']['name'];
        $courses[$j]['payment'] = $student_course_map[$j]['StudentCourseMap']['payment'];
        $courses[$j]['status'] = $student_course_map[$j]['StudentCourseMap']['status'];
        $courses[$j]['lessons'] = $this->Course->getAllLessons($course['Course']['id'], $id);
        $conds = array(
       'StudentLessonSkip.student_id =' => $id,
        'StudentLessonSkip.course_id =' => $course['Course']['id'],
        'StudentLessonSkip.deleted =' => 0
    );
     $lessonskip =$this->StudentLessonSkip->find('all', array("conditions" => $conds));
                 if(empty($lessonskip))
      $courses[$j]['lessonstoskip'] = 0;
    else
     $courses[$j]['lessonstoskip'] = $lessonskip[0]['StudentLessonSkip']['skip_lessons']; 
    
       }
    }            $this->set("json", json_encode($courses));
              }
  
  
    public function adata_edit($id){
       $student =$this->Student->findById($id);
    if($this->request->is("POST")) {
          $data = $this->request->data;
                  $data['id'] = $id; 
        $this->Student->save($data);
        $this->redirect("/admin/user");
               
                                             
      }}
    
    
 public function adata_getstandards(){
   $this->layout = "default";
   $this->set("json",json_encode($this->Standard->find("all",array( 'order' => array('Standard.name' => 'DESC')))));
      }

   

  public function view($id) {
    $this->layout = "ahaguru";
  }

  public function verify_email() {
    if($this->request->is("post")){
      $email = $this->request->data['email'];
      $level = $this->request->data['student_level'];
      $student = $this->Student->find("first",array('conditions' => 
        array('Student.email' => $email,
            'Student.deleted' => 0)));
      $parent = $this->Student->find("first",array('conditions' => 
        array('Student.parent_email' => $email,
            'Student.deleted' => 0)));
      $this->Session->write("studentemail",$email);
      $source = $this->Session->read("sourcefrom"); 
      if($source !=""){
        $this->HinduChallengeStudent->save(array('email' => $email,'source' => $this->Session->read("sourcefrom"),'challenge_type' =>"PC2"));
      }
      if($student == null && $parent == null) {
        $this->set("json", json_encode(array("isvalid"=>"yes")));
      }
      else if($student == null && $parent != null )
        $this->set("json", json_encode(array("isvalid"=>"parentemail")));
      else {
        $this->set("json", json_encode(array("isvalid"=>"no")));
      }
    }
  }
 
 public function verify(){
if($this->request->is("post")){
  $data = $this->request->data;         
  if(isset($data['classroom_reg']) && $data['classroom_reg']==1 ){
    $user_id = $data['user_id'];
     $user = $this->Student->findByUserId($this->request->data['user_id']);
      $parent = $this->Student->find("first",array('conditions' => 
        array('Student.parent_email' => $this->request->data['user_id'],
            'Student.deleted' => 0)));            
          if($user == null && $parent == null) {            
            $this->Session->write("clemail",$user_id);
        $this->set("json", json_encode(array("isvalid"=>"yes")));
      }
      else if($user == null && $parent != null )
        $this->set("json", json_encode(array("isvalid"=>"parentemail")));
      else {
        $this->Session->write("clemail",$user_id);
        $this->set("json", json_encode(array("isvalid"=>"no")));
      }
  }
  else{
      $user = $this->Student->findByUserId(trim($this->request->data['email']));
      
      // $user = $this->Student->findByEmail($this->request->data['email']);      
    // if(!isset($user['Student'])){
    //   $user = $this->Student->findByMobileNumber($this->request->data['email']);    
    //   error_log("pry".print_r($user,true));
    // }
     $admin = $this->Admin->findByEmail($this->request->data['email']);     
    if($user['Student'] != null && (strtolower(trim($user['Student']['password'])) == strtolower(trim($this->request->data['password']))) && $user['Student']['deleted'] == 0) {
    unset($user['Student']['password']);
    $user['role'] = "student";
    $user['data'] = 'sdata';
    if(isset($this->request->data['wpp']))      
        $this->Session->write('wpp',$this->request->data['wpp']);
      $this->set("json", json_encode(array("message"=>"valid","result"=>"student"))); 
      }
      else if($admin['Admin'] != null && ($admin['Admin']['password'] == $this->request->data['password'])) 
      {
    unset($admin['Admin']['password']);
    $admin['role'] = "admin";
    $admin['data'] = 'adata';
     $this->set("json", json_encode(array("message"=>"valid","result"=>"admin"))); 
      }

      else  $this->set("json", json_encode(array("message"=>"Please Enter valid details")));   
  }}

 }

  public function sdata_profile_photo() {
    //$this->layout = "default";
      $this->uploadFiles("img", $this->data['File'], "usr".$this->data['student_id'],"profile.jpg", array(200), true);
      $photo['photo'] = "/img/usr".$this->data['student_id']."/profile_200.jpg";
      $news = $this->Dashboard->query("select * from news where news_status = 2 and student_id = ".$this->data['student_id']);
      
      if(!empty($news)){
        foreach($news as $new){
          $str = explode(" ",$new['news']['news']);
          $str[1] = "src=".$photo['photo'];
          $data['id'] = $new['news']['id'];
          $data['news'] = implode(" ",$str);
          $this->Dashboard->save($data);
        }
      }
      $this->redirect("/student/".$this->data['student_id']);
  }

  public function sdata_edit() {
    $this->layout = "default";
    $this->Student->id = $this->request->params['id'];
         if ($this->Student->save($this->request->data)) {
      $message = array("message"=>"saved");
    } else {
      $message = array("message"=>"error");
    }
    $user = $this->Auth->user();
    if($user['Student']['id'] == $this->Student->id) {
      $user = $this->Student->findById($this->Student->id);
      $user['role'] = 'student';
      $user['data'] = 'sdata';
      unset($user['Student']['password']);
      $this->Auth->login($user);
    }
    $this->set("edit_user", json_encode($message));
  }
 
 public function adata_relation(){
$this->set("json",json_encode($this->ParentRelationship->find('all')));
}

    public function adata_get_stud_group($id){
          $this->layout = "default";
    $condition = array(
      'SmsStudentGroup.deleted' => 0,
      'SmsStudentGroup.groupid' =>$id
            );
      $this->set("json",json_encode($this->SmsStudentGroup->find('all',array('conditions' =>$condition))));
    }
    public function adata_student_edit($id){
       $this->layout = "default";
   if($this->request->is("post")) {
    $data = $this->request->data;
       $this->SmsStudentGroup->edit($id,$data);
    $this->redirect("/admin/addstud_group/".$data['groupid']);
   
   }   }


   public function adata_import($id){
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
                 if($data['name'] != null && $data['mobile_number'] != null){
                  if(strlen($data['mobile_number']) == 10 && is_numeric($data['mobile_number'])) {
                            $data['groupid'] = $id;
                                         
                      $data['created']=date("Y-m-d H:i:s");
               $this->SmsStudentGroup->create();
              $this->SmsStudentGroup->save($data);
                  }
                else
                   $message[$z] = "row $z not saved enter valid phone number" ;}
                  else
                     $message[$z] = "row $z not saved column cannot be empty" ;
                 }}
                  if(!empty($message))
           $this->set("json",json_encode($message));
             else
           $this->redirect("/admin/addstud_group/".$id);
                  
                  }

  public function adata_add_stud_group(){
       $this->layout = "default";
   if($this->request->is("post")) {
    $data = $this->request->data;
      $this->SmsStudentGroup->save($data);
      $this->redirect("/admin/addstud_group/".$data['groupid']);
   }}

    public function adata_delete_stud_group($id){
       $this->layout = "default";
       if( $this->SmsStudentGroup->delete($id))
        $this->set("json", json_encode( array( "message" => "deleted") ));
        else 
          $this->set("json", json_encode( array("message" => "error") ));
   }

   
   public function student_allcourse(){  
       $this->layout = "ahaguru";
    $this->Session->write("sourcefrom","online");

                    }

   public function progress(){  
       $this->layout = "ahaguru";
                    }
 public function sdata_subscribe(){  
       $this->layout = "default";
    $user = $this->Auth->user();
      
   if($this->request->is("post")) {
    $ids = $this->request->data;}
    for($i = 0;$i<count($ids['course_id']);$i++){
  $data['student_id']= $user['Student']['id'];
$data['course_id'] =$ids['course_id'][$i];
if($this->StudentCourseMap->insertrecord($data))
   $this->set("json",json_encode(array("message"=>"saved")));
else
  $this->set("json",json_encode(array("message"=>"error")));
  }
}
 
  public function student_classroom(){  
    $this->layout = "ahaguru";
  }
                    
  public function classroom(){  
  $this->layout = "ahaguru";
  }
                    
public function sdata_classroom($id){  
      $this->layout = "default";
      $this->set("json",json_encode("sssssss"));
}

   public function sdata_allcourse(){  
       $this->layout = "default";
      $user = $this->Auth->user();
  $student_id= $user['Student']['id'];
  $courses =$this->Course->find("all",array('conditions'=>array('Course.deleted'=>0,'Course.course_visibility'=>1)));
   $count = 0;
      foreach($courses as $cour){
        $course1 =$this->StudentCourseMap->getcourse($cour['Course']['id'],$student_id);
        if(empty($course1)){

        $conditions = array(
          'Course.id' => $cours['course']['id'],
          'Course.course_visibility'=>1,
          'Course.deleted' => 0
          );
      $standard_id = $this->StdCourseMap->query("select standard_id from std_course_map where course_id = ".$cour['Course']['id']." and deleted = 0");
      $cour['Course']['standard'] = $standard_id[0]['std_course_map']['standard_id'];
      $lesson_map = $this->CourseLessonMap->query("select * from course_lesson_map where course_id=".$cour['Course']['id']." and deleted =0 and published = 1 and srno!=0 order by srno ;");
     if(empty($lesson_map)){
      $lesson_map = $this->CourseLessonMap->query("select * from course_lesson_map where course_id=".$cour['Course']['id']." and deleted = 0 and published = 1 order by published_date;");
      }
      $j=0;
       $slides = "";
      $questions = "";
      $modules =  array();
      foreach($lesson_map as $les) {
            $mod = $this->Lesson->findById($les['course_lesson_map']['lesson_id']);            
       if(!empty($mod)){
    $elemap = $this->LessonElementMap->find("all", array('conditions' =>
       array('LessonElementMap.lesson_id'=>$mod['Lesson']['id'],
        'LessonElementMap.deleted'=>0)));
        if(!empty($elemap)){
         foreach ($elemap as $key => $map) {
            if($map['LessonElementMap']['element_type'] ==3){
        $elements[$key]= $this->Exercise->find("first",array('conditions'=> array(
        "Exercise.deleted =" => 0,
        "Exercise.id =" => $map['LessonElementMap']['element_id']
      )));
    
  if($questions !="")
  $questions.=",".$elements[$key]['Exercise']['slides'];
  else
    $questions.=$elements[$key]['Exercise']['slides'];
        
          }
            else if($map['LessonElementMap']['element_type'] ==2){
 $elements[$key] = $this->Concept->find("first",array('conditions'=> array(
        "Concept.deleted =" => 0,
        "Concept.id =" => $map['LessonElementMap']['element_id']
      )));
 if($slides !="")
  $slides.= ",".$elements[$key]['Concept']['slides'];
else
  $slides.= $elements[$key]['Concept']['slides'];
            }
            else{
 $elements[$key] = $this->Test->find("first",array('conditions'=> array(
        "Test.deleted =" => 0,
        "Test.id =" => $map['LessonElementMap']['element_id']
      )));
  if($questions !="")
  $questions.=",".$elements[$key]['Test']['questions'];
  else
    $questions.=$elements[$key]['Test']['questions'];
            }}     
      $modules['Lessons'][$j] = $mod;
       $j++;
      }}}

      $cour['Course']['Lessons'] = $modules;
      $cour['Course']['slides'] = count(split(",",$slides));
      $cour['Course']['questions'] = count(split(",",$questions));

      $course[$count++] = $cour;   
      }}

      $this->set("json",json_encode($course));
     }
   
  public function sdata_promo_courses(){
     $this->layout = "default";
      $user = $this->Auth->user();
  $student_id= $user['Student']['id'];
  $course =$this->StudentCourseMap->getmypromocourse($student_id);
      $count = 0;
      foreach($course as $cours){
        $conditions = array(
          'Course.id' => $cours['StudentCourseMap']['course_id'],
              'Course.deleted' => 0        
          );
      $cour = $this->Course->find("first",array('conditions'=>$conditions));
        $standard_id = $this->StdCourseMap->query("select standard_id from std_course_map where course_id = ".$cour['Course']['id']." and deleted = 0");
      $cour['Course']['standard'] = $standard_id[0]['std_course_map']['standard_id'];
      $lesson_map = $this->CourseLessonMap->query("select * from course_lesson_map where course_id=".$cour['Course']['id']." and deleted =0 and published = 1 and srno!=0 order by srno ;");
     if(empty($lesson_map)){
      $lesson_map = $this->CourseLessonMap->query("select * from course_lesson_map where course_id=".$cour['Course']['id']." and deleted = 0 and published = 1 order by published_date;");
      }
      $j=0;
       $slides = "";
      $questions = "";
      $modules =  array();
      foreach($lesson_map as $les) {
            $mod = $this->Lesson->findById($les['course_lesson_map']['lesson_id']);            
       if(!empty($mod)){
        $elemap = $this->LessonElementMap->find("all", array('conditions' =>
       array('LessonElementMap.lesson_id'=>$mod['Lesson']['id'],
        'LessonElementMap.deleted'=>0)));
        if(!empty($elemap)){
              foreach ($elemap as $key => $map) {
            if($map['LessonElementMap']['element_type'] ==3){
        $elements[$key]= $this->Exercise->find("first",array('conditions'=> array(
        "Exercise.deleted =" => 0,
        "Exercise.id =" => $map['LessonElementMap']['element_id']
      )));
    
  if($questions !="")
  $questions.=",".$elements[$key]['Exercise']['slides'];
  else
    $questions.=$elements[$key]['Exercise']['slides'];
        
          }
            else if($map['LessonElementMap']['element_type'] ==2){
 $elements[$key] = $this->Concept->find("first",array('conditions'=> array(
        "Concept.deleted =" => 0,
        "Concept.id =" => $map['LessonElementMap']['element_id']
      )));
 if($slides !="")
  $slides.= ",".$elements[$key]['Concept']['slides'];
else
  $slides.= $elements[$key]['Concept']['slides'];
            }
            else{
 $elements[$key] = $this->Test->find("first",array('conditions'=> array(
        "Test.deleted =" => 0,
        "Test.id =" => $map['LessonElementMap']['element_id']
      )));
  if($questions !="")
  $questions.=",".$elements[$key]['Test']['questions'];
  else
    $questions.=$elements[$key]['Test']['questions'];
            }}
      $modules['Lessons'][$j] = $mod;
       $j++;
      }}}

      $cour['Course']['Lessons'] = $modules;
$cour['Course']['slides'] = count(split(",",$slides));
      $cour['Course']['questions'] = count(split(",",$questions));
      $course[$count++] = $cour;   
      }
      $this->set("json",json_encode($course));
     }


 public function sdata_course_map(){  
       $this->layout = "default";
      $user = $this->Auth->user();
  $student_id= $user['Student']['id'];
  $course =$this->StudentCourseMap->getmypurchasedcourse($student_id);
      $count = 0;
      foreach($course as $cours){
        $conditions = array(
          'Course.id' => $cours['StudentCourseMap']['course_id'],
              'Course.deleted' => 0        
          );
      $cour = $this->Course->find("first",array('conditions'=>$conditions));
        $standard_id = $this->StdCourseMap->query("select standard_id from std_course_map where course_id = ".$cour['Course']['id']." and deleted = 0");
      $cour['Course']['standard'] = $standard_id[0]['std_course_map']['standard_id'];
      $lesson_map = $this->CourseLessonMap->query("select * from course_lesson_map where course_id=".$cour['Course']['id']." and deleted =0 and published = 1 and srno!=0 order by srno ;");
     if(empty($lesson_map)){
      $lesson_map = $this->CourseLessonMap->query("select * from course_lesson_map where course_id=".$cour['Course']['id']." and deleted = 0 and published = 1 order by published_date;");
      }
      $j=0;
       $slides = "";
      $questions = "";
      $modules =  array();
      foreach($lesson_map as $les) {
            $mod = $this->Lesson->findById($les['course_lesson_map']['lesson_id']);            
       if(!empty($mod)){
        $elemap = $this->LessonElementMap->find("all", array('conditions' =>
       array('LessonElementMap.lesson_id'=>$mod['Lesson']['id'],
        'LessonElementMap.deleted'=>0)));
        if(!empty($elemap)){
              foreach ($elemap as $key => $map) {
            if($map['LessonElementMap']['element_type'] ==3){
        $elements[$key]= $this->Exercise->find("first",array('conditions'=> array(
        "Exercise.deleted =" => 0,
        "Exercise.id =" => $map['LessonElementMap']['element_id']
      )));
    
  if($questions !="")
  $questions.=",".$elements[$key]['Exercise']['slides'];
  else
    $questions.=$elements[$key]['Exercise']['slides'];
        
          }
            else if($map['LessonElementMap']['element_type'] ==2){
 $elements[$key] = $this->Concept->find("first",array('conditions'=> array(
        "Concept.deleted =" => 0,
        "Concept.id =" => $map['LessonElementMap']['element_id']
      )));
 if($slides !="")
  $slides.= ",".$elements[$key]['Concept']['slides'];
else
  $slides.= $elements[$key]['Concept']['slides'];
            }
            else{
 $elements[$key] = $this->Test->find("first",array('conditions'=> array(
        "Test.deleted =" => 0,
        "Test.id =" => $map['LessonElementMap']['element_id']
      )));
  if($questions !="")
  $questions.=",".$elements[$key]['Test']['questions'];
  else
    $questions.=$elements[$key]['Test']['questions'];
            }}
      $modules['Lessons'][$j] = $mod;
       $j++;
      }}}

      $cour['Course']['Lessons'] = $modules;
$cour['Course']['slides'] = count(split(",",$slides));
      $cour['Course']['questions'] = count(split(",",$questions));
      $course[$count++] = $cour;   
      }
      $this->set("json",json_encode($course));
     }

public function sdata_detail(){

   $this->layout = "default";
   $user = $this->Auth->user();

   if ( file_exists(WWW_ROOT."/img/usr".$user['Student']['id']."/profile_200.jpg") ) {
      $user['Student']['photo'] = "/img/usr".$user['Student']['id']."/profile_200.jpg";
    } else {
      $user['Student']['photo'] = "Photo Not Available";
    }
             $this->set("json",json_encode($user['Student']));
}

public function register(){
    $this->layout="ahaguru";        
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
         $this->Session->write("courses",$course_id);
       $paymentdata['fee'] = $paymentinfo['fees'];
       $paymentdata['courses'] = $paymentinfo['courses'];
       $paymentdata['regno'] = $regno;
       //$this->Session->write($paymentdata);
       $PaymentRequest = new PaymentRequest();
  $results= $PaymentRequest->sendRequest($paymentdata);
    $message = array("result" =>"encrypt","msg"=>$results); 
  echo json_encode($message);

         }
    //$paymentin$this->layout ="default";fo = $this->Session->read('paymentdata');
    
    }
}

public function adata_deletemapping($id){
  $this->layout ="default";
  $deleted = $this->StudentCourseMap->setDeleted($id);
    if($deleted)
    $this->set("json",json_encode("deleted"));
  else
    $this->set("json",json_encode("notdeleted"));
}

public function save($id){
  $this->layout="ahaguru";        
    if($this->request->is("post")) {
      $data = $this->request->data;
      $user = $this->Student->findById($id);
       unset($data['email']);
       if(!$data['cancel'])
      $this->Student->save($data);
    $paymentinfo = $this->Session->read('paymentdata');
    $paymentinfo['regno'] = $user['Student']['reg_no'];    
   $this->layout="default";        
   $PaymentRequest = new PaymentRequest();
  $this->Session->write("purchasemode","online login");    
  $results= $PaymentRequest->sendRequest($paymentinfo);
  $message = array("result" =>"encrypt","msg"=>$results); 
      // $this->redirect("/payment/response");
  echo json_encode($message);
}   
}

public function mapped($id,$type){

  $this->layout="default";  
  $user = $this->Auth->user();
  $data = $this->request->data;
  $student_id= $user['Student']['id'];
  $lessons = $this->LessonElementMap->find('first',array('conditions' => 
  array(
    'LessonElementMap.element_id' => $id,
    'LessonElementMap.element_type' => $type,
    'LessonElementMap.deleted' => 0,
    )));
  $course = $this->CourseLessonMap->find('first',array('conditions' => 
  array(
    'CourseLessonMap.lesson_id' => $lessons['LessonElementMap']['lesson_id'],
    'CourseLessonMap.deleted' => 0,
    )));
  $coursemap = $this->StudentCourseMap->find('first',array('conditions' => 
  array(
    'StudentCourseMap.course_id' => $course['CourseLessonMap']['course_id'],
    'StudentCourseMap.student_id' => $student_id,
    )));
  $this->set("json",json_encode($coursemap));
  
}

public function books(){
  $this->layout = "ahaguru";
  $this->set('students',$this->Student->find("all",array('conditions' => array('Student.deleted'=> 0))));
    $student=$this->Student->find("all",array('conditions' => array('Student.deleted'=> 0),'order'=>array('Student.id'=>'DESC limit 18')));
    $user = $this->Auth->user();
    if(isset($user['ClassroomStudent']) || (isset($user['Student']) && isset($_SESSION['classroomstudent'])))
      $this->set("loggedin","classroomstudent");
    else if(isset($user['Student']) && !isset($_SESSION['classroomstudent']))
      $this->set("loggedin","student");
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

public function check_session(){
  $this->layout="default";  
   if($this->Auth->user()){
      $user = $this->Auth->user();
      if(isset($user['Student']) && !isset($_SESSION['classroomstudent'])){
      $cmt = $this->Session->read("sourcefrom");
      $data = $this->request->data;
      $this->Session->write("studentlevel",$data['level']);
      $conditions= array(
        'StudentCourseMap.student_id' => $user['Student']['id'],
        'StudentCourseMap.deleted' => 0,
        'StudentCourseMap.comments LIKE' => "%Hindu%",
        'StudentCourseMap.challenge_type' =>"PC2"
        );
      $crsmap = $this->StudentCourseMap->find("first",array('conditions'=>$conditions));
      if(empty($crsmap)){
        $message =array("result"=>"valid","msg"=>"purchase","id"=>$user['Student']['id']);
      //   $cond= array(
      //   'StudentCourseMap.student_id' => $user['Student']['id'],
      //   'StudentCourseMap.deleted' => 0,
      //   'StudentCourseMap.payment' => 2,
      //   );
      // $apprcrsmap = $this->StudentCourseMap->find("first",array('conditions'=>$cond));
      // if(empty($apprcrsmap))
      //     $message =array("result"=>"valid","msg"=>"purchase","id"=>$user['Student']['id']);
      // else{
      //       if($data['level'] == 1){
      //         $course_id[0] = 41;
      //         $course_id[1] = 42;
      //       }      
      //       else if($data['level'] == 2){
      //         $course_id[0] = 40;      
      //         $course_id[1] = 39;
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
      //        if(empty($mapping)){                      
      //           $this->StudentCourseMap->saveAll($mapdata);            
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
      //   $message =array("result"=>"mapped","msg"=>"coursemapped");
      // }
      }
      else
        $message =array("result"=>"invalid","msg"=>"already reg");
      }     
      else if($user['role'] == "admin")
        $message =array("result"=>"loggedin","msg"=>"admin");
      else if(isset($user['ClassroomStudent']) || (isset($user['Student']) && isset($_SESSION['classroomstudent'])))
        $message =array("result"=>"loggedin","msg"=>"classroomstudent");

    }
  else{
      $message =array("result"=>"valid","msg"=>"new reg");
  }
  $this->set("json",json_encode($message));
}
}