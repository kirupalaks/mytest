<?php
App::import('Vendor', 'MyExcelHelper');
class ApiController extends AppController {

	public $name = "Api";

	public $uses = array('Teacher','TeacherBatchMap','Batch','Token','Subject',
    'ClassroomCourse','ClassroomStudent','Standard','StudentBatchMap',
    'Location','Test');

  public function beforeFilter() {
    parent::beforeFilter();
   $this->Auth->allow('login','teacherlogin','email','confirm_student','confirm_payment','syncdb',
    'edit_student','edit_contact','update_status','delete_student','syncdatabase','update_batches','gettestid');
 }

	   //For Tutor App
  
public function login(){
    if($this->request->is("post")) {
      $this->layout ="default";
      $name = $_POST['email'];
      $location = array();
      $standard = array();
      $classroomstudents = array();
      $course = array();
      $password = $_POST['password'];
      $keys = "tutor";$j=0;$i=0;$x=0;
      $y=0;$z=0;$s=0;$sub = 0;
      $teacher = $this->Teacher->findByEmail($_POST['email']);
      if($teacher['Teacher'] != null){
        if($teacher['Teacher']['password'] == $_POST['password'] && $teacher['Teacher']['deleted'] == 0) {
          //get batch id mapped to the teacher
       $encrypted = base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5($keys), $teacher['Teacher']['email'], MCRYPT_MODE_CBC, md5(md5($keys))));
          $token = urlencode($encrypted);
         $token_data = array(
          'teacher_id' => $teacher['Teacher']['id'],
          'token' => $encrypted
          );
         $token_table = $this->Token->find("first",array('conditions'=>array('teacher_id'=>$teacher['Teacher']['id'])));
          if(empty($token_table))
       $this->Token->save($token_data);
//          else
  //         $this->Token->query("update token_table set token =". $encrypted." where teacher_id =". $teacher['Teacher']['id']);
    
         $TeacherBatchMap = $this->TeacherBatchMap->find("all",array('conditions' => array(
          'TeacherBatchMap.teachers_id' => $teacher['Teacher']['id'],
          'TeacherBatchMap.deleted' => 0)));
         foreach ($TeacherBatchMap as $arr => $value) {
          
         $teachers_batch[$arr] = $value['TeacherBatchMap'];
       }
         //get batch details mapped to the teacher
         foreach ($TeacherBatchMap as $key => $teacherbatchmap) {
           $Batch = $this->Batch->find("first",array('conditions' => array(
          'Batch.id' => $teacherbatchmap['TeacherBatchMap']['batch_id'],
          'Batch.deleted' => 0)));
           $batch[$key] = $Batch['Batch'];
         }
       
         foreach ($batch as $key => $batches) {
          //get course  mapped to the batch
          $Course = $this->ClassroomCourse->find("first",array('conditions' => array(
          'ClassroomCourse.id' => $batches['course_id'],
          'ClassroomCourse.deleted' => 0)));

            $Subject = $this->Subject->find("first",array('conditions' => array(
          'Subject.id' => $Course['ClassroomCourse']['subject'],
          )));
                 //$course[$key] = $Course['ClassroomCourse']; 
           if(empty($course)){
            $course[$y] = $Course['ClassroomCourse']; 
            $y++;
             }
             else{
            $id = $this->searchForId($Course['ClassroomCourse']['id'], $course);
            if($id != 1){
            $course[$y] = $Course['ClassroomCourse']; 
             $y++;
             }
            }
             if(empty($subject)){
            $subject[$sub] = $Subject['Subject']; 
            $sub++;
             }
             else{
            $id = $this->searchForId($Subject['Subject']['id'], $subject);
            if($id != 1){
            $subject[$sub] = $Subject['Subject']; 
             $sub++;
             }
            }
            //get class  mapped to the batch
            $Standard = $this->Standard->find("all");
            foreach ($Standard as $key => $value) {
              $standard[$key] = $value['Standard'];
            }
            /*$Standard = $this->Standard->find("first",array('conditions' => array(
          'Standard.id' => $batches['class'])));
                if(empty($standard)){
            $standard[$z] = $Standard['Standard']; 
            $z++;
             }
             else{
            $id = $this->searchForId($Standard['Standard']['id'], $standard);
            if($id != 1){
            $standard[$z] = $Standard['Standard']; 
             $z++;
             }
            }*/

                   //get location  mapped to the batch
            $Location = $this->Location->find("first",array('conditions' => array(
          'Location.id' => $batches['location'])));
            if(empty($location)){
            $location[$x] = $Location['Location']; 
            $x++;
             }
             else{
            $id = $this->searchForId($Location['Location']['id'], $location);
            if($id != 1){
            $location[$x] = $Location['Location']; 
             $x++;
             }
            }

                //get students mapped to that batch
          $StudentBatchMap = $this->StudentBatchMap->find("all",array('conditions' => array(
            'StudentBatchMap.batch_id' => $batches['id'],
            'StudentBatchMap.deleted' => 0)));
        
          //$student_batch = $StudentBatchMap;
          foreach ($StudentBatchMap as $value) {
          $student_batch[$j] = $value['StudentBatchMap'];
          $j++;
          }
                  
          foreach ($StudentBatchMap as $arr => $studentsbatchmap) {
            $Student = $this->ClassroomStudent->find("first",array('conditions' => array(
              'ClassroomStudent.id' => $studentsbatchmap['StudentBatchMap']['student_id'])));
            $students[$i] = $Student['ClassroomStudent'];
           $i++;
          }
               
              foreach ($students as $std) { 
                 if(empty($classroomstudents)){
              $classroomstudents[$s] = $std;
            $s++;
             }
             else{
            $id = $this->searchForId($std['id'], $classroomstudents);
            if($id != 1){
              $classroomstudents[$s] = $std;
             $s++;
             }
           }
            }              
                
                }

             /*  print_r($teacher);
                echo "<br/><br/>";
                print_r($teachers_batch);
                echo "<br/><br/>";
                print_r($batch);
                echo "<br/><br/>";
                print_r($course);
                echo "<br/><br/>";
                print_r($standard);
                echo "<br/><br/>";
                print_r($location);
                echo "<br/><br/>";
                print_r($student_batch);
                echo "<br/><br/>";
                print_r($classroomstudents);
                echo "<br/><br/>";
                 print_r($subject);
                echo "<br/><br/>";*/
            
            echo json_encode(array("status" => "success","teacher"=>$teacher['Teacher'],"teacherbatchmap" => $teachers_batch,
            "batch"=>$batch,"course"=>$course,"standard" =>$standard,"location"=>$location,
            "studentsbatchmap"=>$student_batch,"students"=>$students,"subject" => $subject,"token" => $token));
      }//}
        else
          echo json_encode(array("status" => "error","msg" => "Enter correct password"));
             }
      else
        echo json_encode(array("status" => "error","msg" => "Emailid does not exist"));
}
}

public function searchForId($id, $array) {
  
   foreach ($array as $ky => $val) {
       if ($val['id'] === $id) {
  
           return 1;
       }
   }
   return null;
}
public function syncdb(){
   if($this->request->is("post")) {
     $location = array();
      $standard = array();
      $classroomstudents = array();
      $course = array();
    $key = "tutor";
    $j=0;$i=0;$x=0;
      $y=0;$z=0;$s=0;$sub=0;
    $token = urldecode($_POST['token']);
      $tutor = $this->Token->findByTeacherId($_POST['id']);
      $teacher =$this->Teacher->findById($_POST['id']);
      if(strcmp($token,$tutor['Token']['token']) == 0){
        $TeacherBatchMap = $this->TeacherBatchMap->find("all",array('conditions' => array(
          'TeacherBatchMap.teachers_id' => $teacher['Teacher']['id'],
          'TeacherBatchMap.deleted' => 0)));
         foreach ($TeacherBatchMap as $arr => $value) {
          
         $teachers_batch[$arr] = $value['TeacherBatchMap'];
       }
         //get batch details mapped to the teacher
         foreach ($TeacherBatchMap as $key => $teacherbatchmap) {
           $Batch = $this->Batch->find("first",array('conditions' => array(
          'Batch.id' => $teacherbatchmap['TeacherBatchMap']['batch_id'],
          'Batch.deleted' => 0)));
           $batch[$key] = $Batch['Batch'];
         }
       
         foreach ($batch as $key => $batches) {
          //get course  mapped to the batch
          $Course = $this->ClassroomCourse->find("first",array('conditions' => array(
          'ClassroomCourse.id' => $batches['course_id'],
          'ClassroomCourse.deleted' => 0)));
          
          $Subject = $this->Subject->find("first",array('conditions' => array(
          'Subject.id' => $Course['ClassroomCourse']['subject'],
          )));

                 //$course[$key] = $Course['ClassroomCourse']; 
           if(empty($course)){
            $course[$y] = $Course['ClassroomCourse']; 
            $y++;
             }
             else{
            $id = $this->searchForId($Course['ClassroomCourse']['id'], $course);
            if($id != 1){
            $course[$y] = $Course['ClassroomCourse']; 
             $y++;
             }
            }
             if(empty($subject)){
            $subject[$sub] = $Subject['Subject']; 
            $sub++;
             }
             else{
            $id = $this->searchForId($Subject['Subject']['id'], $subject);
            if($id != 1){
            $subject[$sub] = $Subject['Subject']; 
             $sub++;
             }
            }
            //get class  mapped to the batch
           /* $Standard = $this->Standard->find("first",array('conditions' => array(
          'Standard.id' => $batches['class'])));
                if(empty($standard)){
            $standard[$z] = $Standard['Standard']; 
            $z++;
             }
             else{
            $id = $this->searchForId($Standard['Standard']['id'], $standard);
            if($id != 1){
            $standard[$z] = $Standard['Standard']; 
             $z++;
             }
            }*/
            $Standard = $this->Standard->find("all");
            foreach ($Standard as $key => $value) {
              $standard[$key] = $value['Standard'];
            }

                   //get location  mapped to the batch
            $Location = $this->Location->find("first",array('conditions' => array(
          'Location.id' => $batches['location'])));
            if(empty($location)){
            $location[$x] = $Location['Location']; 
            $x++;
             }
             else{
            $id = $this->searchForId($Location['Location']['id'], $location);
            if($id != 1){
            $location[$x] = $Location['Location']; 
             $x++;
             }
            }

                //get students mapped to that batch
          $StudentBatchMap = $this->StudentBatchMap->find("all",array('conditions' => array(
            'StudentBatchMap.batch_id' => $batches['id'],
            'StudentBatchMap.deleted' => 0)));
        
          //$student_batch = $StudentBatchMap;
          foreach ($StudentBatchMap as $value) {
          $student_batch[$j] = $value['StudentBatchMap'];
          $j++;
          }
                  
          foreach ($StudentBatchMap as $arr => $studentsbatchmap) {
            $Student = $this->ClassroomStudent->find("first",array('conditions' => array(
              'ClassroomStudent.id' => $studentsbatchmap['StudentBatchMap']['student_id'])));
            $students[$i] = $Student['ClassroomStudent'];
           $i++;
          }
               
              foreach ($students as $std) { 
                 if(empty($classroomstudents)){
              $classroomstudents[$s] = $std;
            $s++;
             }
             else{
            $id = $this->searchForId($std['id'], $classroomstudents);
            if($id != 1){
              $classroomstudents[$s] = $std;
             $s++;
             }
           }
            }              
                
                }

            /*  print_r($teacher);
                echo "<br/><br/>";
                print_r($teachers_batch);
                echo "<br/><br/>";
                print_r($batch);
                echo "<br/><br/>";
                print_r($course);
                echo "<br/><br/>";
                print_r($standard);
                echo "<br/><br/>";
                print_r($location);
                echo "<br/><br/>";
                print_r($student_batch);
                echo "<br/><br/>";
                print_r($classroomstudents);
                echo "<br/><br/>";
                print_r($subject);
                echo "<br/><br/>";*/
            echo json_encode(array("status" => "success","teacher"=>$teacher['Teacher'],"teacherbatchmap" => $teachers_batch,
            "batch"=>$batch,"course"=>$course,"standard" =>$standard,"location"=>$location,
            "studentsbatchmap"=>$student_batch,"students"=>$students,"subject" => $subject,"token" => $_POST['token']));
    }
    else
    echo json_encode(array("status" => "error","msg" => "token not found","teacher_id" => $_POST['id']));
  }
}


public function syncdatabase($id){
     $location = array();
      $standard = array();
      $classroomstudents = array();
      $course = array();
    $key = "tutor";
    $j=0;$i=0;$x=0;
      $y=0;$z=0;$s=0;$sub=0;
        $teacher =$this->Teacher->findById($id);
        $TeacherBatchMap = $this->TeacherBatchMap->find("all",array('conditions' => array(
          'TeacherBatchMap.teachers_id' => $teacher['Teacher']['id'],
          'TeacherBatchMap.deleted' => 0)));
         foreach ($TeacherBatchMap as $arr => $value) {
          
         $teachers_batch[$arr] = $value['TeacherBatchMap'];
       }
         //get batch details mapped to the teacher
         foreach ($TeacherBatchMap as $key => $teacherbatchmap) {
           $Batch = $this->Batch->find("first",array('conditions' => array(
          'Batch.id' => $teacherbatchmap['TeacherBatchMap']['batch_id'],
          'Batch.deleted' => 0)));
           $batch[$key] = $Batch['Batch'];
         }
       
         foreach ($batch as $key => $batches) {
          //get course  mapped to the batch
          $Course = $this->ClassroomCourse->find("first",array('conditions' => array(
          'ClassroomCourse.id' => $batches['course_id'],
          'ClassroomCourse.deleted' => 0)));
          
          $Subject = $this->Subject->find("first",array('conditions' => array(
          'Subject.id' => $Course['ClassroomCourse']['subject'],
          )));

                 //$course[$key] = $Course['ClassroomCourse']; 
           if(empty($course)){
            $course[$y] = $Course['ClassroomCourse']; 
            $y++;
             }
             else{
            $id = $this->searchForId($Course['ClassroomCourse']['id'], $course);
            if($id != 1){
            $course[$y] = $Course['ClassroomCourse']; 
             $y++;
             }
            }
             if(empty($subject)){
            $subject[$sub] = $Subject['Subject']; 
            $sub++;
             }
             else{
            $id = $this->searchForId($Subject['Subject']['id'], $subject);
            if($id != 1){
            $subject[$sub] = $Subject['Subject']; 
             $sub++;
             }
            }
            //get class  mapped to the batch
            /*$Standard = $this->Standard->find("first",array('conditions' => array(
          'Standard.id' => $batches['class'])));
                if(empty($standard)){
            $standard[$z] = $Standard['Standard']; 
            $z++;
             }
             else{
            $id = $this->searchForId($Standard['Standard']['id'], $standard);
            if($id != 1){
            $standard[$z] = $Standard['Standard']; 
             $z++;
             }
            }*/
            $Standard = $this->Standard->find("all");
            foreach ($Standard as $key => $value) {
              $standard[$key] = $value['Standard'];
            }

                   //get location  mapped to the batch
            $Location = $this->Location->find("first",array('conditions' => array(
          'Location.id' => $batches['location'])));
            if(empty($location)){
            $location[$x] = $Location['Location']; 
            $x++;
             }
             else{
            $id = $this->searchForId($Location['Location']['id'], $location);
            if($id != 1){
            $location[$x] = $Location['Location']; 
             $x++;
             }
            }

                //get students mapped to that batch
          $StudentBatchMap = $this->StudentBatchMap->find("all",array('conditions' => array(
            'StudentBatchMap.batch_id' => $batches['id'],
            'StudentBatchMap.deleted' => 0)));
        
          //$student_batch = $StudentBatchMap;
          foreach ($StudentBatchMap as $value) {
          $student_batch[$j] = $value['StudentBatchMap'];
          $j++;
          }
                  
          foreach ($StudentBatchMap as $arr => $studentsbatchmap) {
            $Student = $this->ClassroomStudent->find("first",array('conditions' => array(
              'ClassroomStudent.id' => $studentsbatchmap['StudentBatchMap']['student_id'])));
            $students[$i] = $Student['ClassroomStudent'];
           $i++;
          }
               
              foreach ($students as $std) { 
                 if(empty($classroomstudents)){
              $classroomstudents[$s] = $std;
            $s++;
             }
             else{
            $id = $this->searchForId($std['id'], $classroomstudents);
            if($id != 1){
              $classroomstudents[$s] = $std;
             $s++;
             }
           }
            }              
                
                }

            /*  print_r($teacher);
                echo "<br/><br/>";
                print_r($teachers_batch);
                echo "<br/><br/>";
                print_r($batch);
                echo "<br/><br/>";
                print_r($course);
                echo "<br/><br/>";
                print_r($standard);
                echo "<br/><br/>";
                print_r($location);
                echo "<br/><br/>";
                print_r($student_batch);
                echo "<br/><br/>";
                print_r($classroomstudents);
                echo "<br/><br/>";
                print_r($subject);
                echo "<br/><br/>";*/
            echo json_encode(array("status" => "success","teacher"=>$teacher['Teacher'],"teacherbatchmap" => $teachers_batch,
            "batch"=>$batch,"course"=>$course,"standard" =>$standard,"location"=>$location,
            "studentsbatchmap"=>$student_batch,"students"=>$students,"subject" => $subject,"token" => $_POST['token']));
    }
  
public function teacherlogin(){
}

public function email(){
   if($this->request->is("post")) {
    $key = "tutor";
    $tokenreceived = $_POST['token'];
    $Excel = new MyExcelHelper();
    $token = urldecode($_POST['token']);
    $tutor = $this->Token->findByTeacherId($_POST['id']);
      if(strcmp($token,$tutor['Token']['token']) == 0){
    $teacher = $this->Teacher->findById($_POST['id']);
     $TeacherBatchMap = $this->TeacherBatchMap->find("all",array('conditions' => array(
          'TeacherBatchMap.teachers_id' => $teacher['Teacher']['id'],
          'TeacherBatchMap.deleted' => 0)));
       
         //get batch details mapped to the teacher
         foreach ($TeacherBatchMap as $key => $teacherbatchmap) {
           $Batch = $this->Batch->find("first",array('conditions' => array(
          'Batch.id' => $teacherbatchmap['TeacherBatchMap']['batch_id'],
          'Batch.deleted' => 0)));
           $teacher_batch['batch'][$key] = $Batch;
         }
       $i=0;
         foreach ($teacher_batch['batch'] as $key => $batches) {
          //get students mapped to that batch
          $StudentBatchMap = $this->StudentBatchMap->find("all",array('conditions' => array(
            'StudentBatchMap.batch_id' => $batches['Batch']['id'],
            'StudentBatchMap.deleted' => 0)));
          foreach ($StudentBatchMap as $arr => $studentsbatchmap) {
            $Student = $this->ClassroomStudent->find("first",array('conditions' => array(
              'ClassroomStudent.id' => $studentsbatchmap['StudentBatchMap']['student_id'])));
            $teachers_batch['ClassroomStudent'][$i] = $Student['ClassroomStudent']; 
            $standard = $this->Standard->find("first",array('conditions' => array(
          'Standard.id' => $Student['ClassroomStudent']['standard'])));
    
          $teachers_batch['ClassroomStudent'][$i]['standard'] = $standard['Standard']['name']; 
            if($studentsbatchmap['StudentBatchMap']['payment'] == 1)
            $teachers_batch['ClassroomStudent'][$i]['payment'] = "Not Paid";
            else
            $teachers_batch['ClassroomStudent'][$i]['payment'] = "Paid";
            if($studentsbatchmap['StudentBatchMap']['confirmation'] == 0)
            $teachers_batch['ClassroomStudent'][$i]['confirmation'] = "Not Confirmed";
            else
           $teachers_batch['ClassroomStudent'][$i]['confirmation'] = "Confirmed";
         $teachers_batch['ClassroomStudent'][$i]['batch']['name'] = $batches['Batch']['name'];
         $teachers_batch['ClassroomStudent'][$i]['batch']['schedule_day'] = $batches['Batch']['schedule_day'];
         $teachers_batch['ClassroomStudent'][$i]['batch']['schedule_time'] = $batches['Batch']['schedule_time'];
         //get course  mapped to the batch
          $Course = $this->ClassroomCourse->find("first",array('conditions' => array(
          'ClassroomCourse.id' => $batches['Batch']['course_id'],
          'ClassroomCourse.deleted' => 0)));
                $teachers_batch['ClassroomStudent'][$i]['batch']['course'] = $Course['ClassroomCourse']['name']; 
            //get class  mapped to the batch
            $Standard = $this->Standard->find("first",array('conditions' => array(
          'Standard.id' => $batches['Batch']['class'])));
    
          $teachers_batch['ClassroomStudent'][$i]['batch']['class'] = $Standard['Standard']['name']; 
                   //get location  mapped to the batch
            $Location = $this->Location->find("first",array('conditions' => array(
          'Location.id' => $batches['Batch']['location'])));
          $teachers_batch['ClassroomStudent'][$i]['batch']['location'] = $Location['Location']['name']; 
          $i++;
          }
                }
            foreach($teachers_batch['ClassroomStudent'] as $key => $sch) {
            $tablecontent[$key]['Student']['name'] = $sch['name'];
            $tablecontent[$key]['Student']['email'] = $sch['email'];
            $tablecontent[$key]['Student']['standard'] = $sch['standard'];
            $tablecontent[$key]['Student']['school_name'] = $sch['school_name'];
            $tablecontent[$key]['Student']['mobile_number'] = $sch['mobile_number'];
            $tablecontent[$key]['Student']['place'] = $sch['place'];
            $tablecontent[$key]['Student']['batch'] = $sch['batch']['name'];
        $tablecontent[$key]['Student']['batch_class'] = $sch['batch']['class'];
        $tablecontent[$key]['Student']['location'] = $sch['batch']['location'];
        $tablecontent[$key]['Student']['course'] = $sch['batch']['course'];
         $tablecontent[$key]['Student']['weekly schedule_day'] = $sch['batch']['schedule_day'];
        $tablecontent[$key]['Student']['weekly schedule_time'] = $sch['batch']['schedule_time'];
        $tablecontent[$key]['Student']['teacher'] = $teacher['Teacher']['name'];
        $tablecontent[$key]['Student']['confirmation'] = $sch['confirmation'];
        $tablecontent[$key]['Student']['payment'] = $sch['payment'];
     
         }
          $teacher['Teacher']['name']=str_ireplace(" ","_", $teacher['Teacher']['name']);
           $tmpfname = tempnam("/tmp", $teacher['Teacher']['name']);
             $filename = split("/", $tmpfname);
          $headings = array('Name','Email','Standard','School','Mobile','City','Batch',
        'Batch_Class','Location','Course','Schedule_day','Schedule_time','Teacher','Confirmation','Payment');
       $Excel->generate($tablecontent, $filename[2].'.xlsx',$headings , 'Classroom Students Report');
         if(file_exists($tmpfname.'.xlsx'))
            $sendmail = $this->sendMailWithAttachment($teacher['Teacher']['email'] ,$tmpfname.'.xlsx',"Student : details",file_get_contents($tmpfname.".xlsx"),"");               
         if ($sendmail){ 
            unlink($tmpfname.".xlsx");         
            unlink($tmpfname);         
          echo json_encode(array("status" => "success","token" => $tokenreceived,"teacher_id" => $_POST['id']));
        }
        else
       echo json_encode(array("status" => "error","token" => $_POST['token'],"teacher_id" => $_POST['id']));
   }
   else
    echo json_encode(array("status" => "error","msg" => "token not found","teacher_id" => $_POST['id']));
}
}

public function confirm_student(){
   if($this->request->is("post")) {
    $key = "tutor";
    $token = urldecode($_POST['token']);
    $tutor = $this->Token->findByTeacherId($_POST['id']);
    if(strcmp($token,$tutor['Token']['token']) == 0){
      if($_POST['batch_id'] != null && $_POST['student_id'] != null){
    $batch_id = $_POST['batch_id'];
    $student_id = $_POST['student_id'];
      $this->StudentBatchMap->id = $this->StudentBatchMap->field('id', array('student_id' => $student_id,
      'batch_id' => $batch_id));
  if ($this->StudentBatchMap->id) {
    if($this->StudentBatchMap->saveField('confirmation', 1))
      echo json_encode(array("status" => "success","token" => $_POST['token'],"teacher_id" => $_POST['id']));

      else
       echo json_encode(array("status" => "error","token" => $_POST['token'],"teacher_id" => $_POST['id']));
   }
   else
    echo json_encode(array("status" => "error","token" => $_POST['token'],"teacher_id" => $_POST['id']));
 }
  else
    echo json_encode(array("status" => "error","token" => $_POST['token'],"teacher_id" => $_POST['id']));
}
 else
    echo json_encode(array("status" => "error","msg" => "token not found","teacher_id" => $_POST['id']));
   }
}

public function delete_student(){
   if($this->request->is("post")) {
    $key = "tutor";
    $token = urldecode($_POST['token']);
    $tutor = $this->Token->findByTeacherId($_POST['id']);
        if(strcmp($token,$tutor['Token']['token']) == 0){
      if($_POST['batch_id'] != null && $_POST['student_id'] != null){
    $batch_id = $_POST['batch_id'];
    $student_id = $_POST['student_id'];
      $this->StudentBatchMap->id = $this->StudentBatchMap->field('id', array('student_id' => $student_id,
      'batch_id' => $batch_id));
  if ($this->StudentBatchMap->id) {
    if($this->StudentBatchMap->saveField('deleted', 1) && $this->StudentBatchMap->saveField('confirmation', 0)
        && $this->StudentBatchMap->saveField('payment', 1))
     $this->syncdatabase($_POST['id']);
     else
    echo json_encode(array("status" => "error","token" => $_POST['token'],"teacher_id" => $_POST['id']));
   }
   else
    echo json_encode(array("status" => "error","token" => $_POST['token'],"teacher_id" => $_POST['id']));
 }
 else
    echo json_encode(array("status" => "error","token" => $_POST['token'],"teacher_id" => $_POST['id']));
}
 else
    echo json_encode(array("status" => "error","msg" => "token not found","teacher_id" => $_POST['id']));
   }
}

public function confirm_payment(){
   if($this->request->is("post")) {
    $key = "tutor";
    $token = urldecode($_POST['token']);
    $tutor = $this->Token->findByTeacherId($_POST['id']);
     if(strcmp($token,$tutor['Token']['token']) == 0){
         if($_POST['batch_id'] != null && $_POST['student_id'] != null){
    $batch_id = $_POST['batch_id'];
    $student_id = $_POST['student_id'];
     $this->StudentBatchMap->id = $this->StudentBatchMap->field('id', array('student_id' => $student_id,
      'batch_id' => $batch_id));
  if ($this->StudentBatchMap->id) {
    if($this->StudentBatchMap->saveField('payment', 2))
      echo json_encode(array("status" => "success","token" => $_POST['token'],"teacher_id" => $_POST['id']));

      else
       echo json_encode(array("status" => "error","token" => $_POST['token'],"teacher_id" => $_POST['id']));
   }
   else
    echo json_encode(array("status" => "error","token" => $_POST['token'],"teacher_id" => $_POST['id']));
   }
    else
    echo json_encode(array("status" => "error","token" => $_POST['token'],"teacher_id" => $_POST['id']));
}
   else
    echo json_encode(array("status" => "error","msg" => "token not found","teacher_id" => $_POST['id']));
   }
}

public function update_status(){
   if($this->request->is("post")) {
    $key = "tutor";
    $token = urldecode($_POST['token']);
    $tutor = $this->Token->findByTeacherId($_POST['id']);
    if(strcmp($token,$tutor['Token']['token']) == 0){
          if($_POST['batch_id'] != null && $_POST['student_id'] != null && 
        $_POST['payment'] != null && $_POST['confirmation'] != null){
    $batch_id = $_POST['batch_id'];
    $student_id = $_POST['student_id'];
         $this->StudentBatchMap->id = $this->StudentBatchMap->field('id', array('student_id' => $student_id,
      'batch_id' => $batch_id));
  if ($this->StudentBatchMap->id) {
    if($this->StudentBatchMap->saveField('confirmation', $_POST['confirmation']) &&
      $this->StudentBatchMap->saveField('payment',$_POST['payment'])) {
      echo json_encode(array("status" => "success","token" => $_POST['token'],"teacher_id" => $_POST['id']));
       }
      else
       echo json_encode(array("status" => "error","token" => $_POST['token'],"teacher_id" => $_POST['id']));
   }
   else
    echo json_encode(array("status" => "error","token" => $_POST['token'],"teacher_id" => $_POST['id']));
   }
    else
    echo json_encode(array("status" => "error","token" => $_POST['token'],"teacher_id" => $_POST['id']));
}
   else
    echo json_encode(array("status" => "error","msg" => "token not found","teacher_id" => $_POST['id']));
   }
}

public function edit_student(){
  if($this->request->is("post")) {
    $token = urldecode($_POST['token']);
    $teacher_id = $_POST['id'];
    $tutor = $this->Token->findByTeacherId($teacher_id);
 
     if(strcmp($token,$tutor['Token']['token']) == 0){
      if($_POST['name'] != null && $_POST['student_id'] != null && 
        $_POST['school_name'] != null && $_POST['parent_name'] != null && $_POST['standard'] != null){
     $this->ClassroomStudent->id = $_POST['student_id'];
  if ($this->ClassroomStudent->id) {
    unset($_POST['id']);
    if($this->ClassroomStudent->save(array('ClassroomStudent'=>array('name'=>$_POST['name']
      ,'school_name'=>$_POST['school_name'],'parent_name' => $_POST['parent_name'],
      'standard' => $_POST['standard']))))
        echo json_encode(array("status" => "success","token" => $_POST['token'],"teacher_id" => $teacher_id));

      else
       echo json_encode(array("status" => "error","token" => $_POST['token'],"teacher_id" => $teacher_id));
   }
   else
    echo json_encode(array("status" => "error","token" => $_POST['token'],"teacher_id" => $teacher_id));    
  }
   else
    echo json_encode(array("status" => "error","token" => $_POST['token'],"teacher_id" => $teacher_id));    
  }
  else
    echo json_encode(array("status" => "error","msg" => "token not found","teacher_id" => $_POST['id']));
}
}

public function edit_contact(){
  if($this->request->is("post")) {
    $token = urldecode($_POST['token']);
     $teacher_id = $_POST['id'];
    $tutor = $this->Token->findByTeacherId($teacher_id);
       if(strcmp($token,$tutor['Token']['token']) == 0){
        if($_POST['mobile_number'] != null && $_POST['parent_email'] != null && 
        $_POST['email'] != null && $_POST['parent_mobile'] != null && $_POST['student_id'] != null){
     $this->ClassroomStudent->id = $_POST['student_id'];
  if ($this->ClassroomStudent->id) {
    unset($_POST['id']);
    if($this->ClassroomStudent->save($_POST))
      echo json_encode(array("status" => "success","token" => $_POST['token'],"teacher_id" => $teacher_id));

      else
       echo json_encode(array("status" => "error","token" => $_POST['token'],"teacher_id" => $teacher_id));
   }
   else
    echo json_encode(array("status" => "error","token" => $_POST['token'],"teacher_id" => $teacher_id));    
  }
   else
    echo json_encode(array("status" => "error","token" => $_POST['token'],"teacher_id" => $teacher_id));    
  }
  else
    echo json_encode(array("status" => "error","msg" => "token not found","teacher_id" => $_POST['id']));
}
}

public function update_batches(){
  if($this->request->is("post")) {
       $token = urldecode($_POST['token']);
     $teacher_id = $_POST['id'];
    $tutor = $this->Token->findByTeacherId($teacher_id);
       if(strcmp($token,$tutor['Token']['token']) == 0){
   if($_POST['old_batch_ids'] != null && $_POST['student_id'] != null || $_POST['new_batch_ids'] != null){
   $old_batches = split(",", $_POST['old_batch_ids']);
   if($_POST['new_batch_ids'] != null)
  $new_batches = split(",", $_POST['new_batch_ids']);
   else
    $new_batches = array();
   //$StudentBatchMap= $this->StudentBatchMap->find('all', array('student_id' => $_POST['student_id']));
         foreach ($old_batches as $key => $value) {
          if($new_batches != null){
        if(!(in_array($value,$new_batches))){
        $this->StudentBatchMap->id= $this->StudentBatchMap->field('id', array('student_id' => $_POST['student_id'],
          'batch_id' => $value));
        $savebatch = $this->StudentBatchMap->saveField('deleted', 1);
      }
      else
      $savebatch = 1;
    }
     else{
         $this->StudentBatchMap->id= $this->StudentBatchMap->field('id', array('student_id' => $_POST['student_id'],
          'batch_id' => $value));
        $savebatch = $this->StudentBatchMap->saveField('deleted', 1);
       }
       }
         if($new_batches != null){
      foreach ($new_batches as $key => $values) {
        if(!(in_array($values,$old_batches))){
          $this->StudentBatchMap->id= $this->StudentBatchMap->field('id', array('student_id' => $_POST['student_id'],
          'batch_id' => $values));
          if($this->StudentBatchMap->id)
            $mapping = $this->StudentBatchMap->saveField('deleted', 0);
            else
            $mapping =  $this->StudentBatchMap->saveAll(array('StudentBatchMap' => array(
          'student_id' => $_POST['student_id'],'batch_id' => $values)));        
      }
      else 
        $mapping = 1;
    }}
      else
          $mapping =1;

         if($mapping && $savebatch)
        $this->syncdatabase($_POST['id']);
      else
      echo json_encode(array("status" => "error","token" => $_POST['token'],"teacher_id" => $teacher_id));      
      }
      else
      echo json_encode(array("status" => "error","token" => $_POST['token'],"teacher_id" => $teacher_id));    
     }
     else
    echo json_encode(array("status" => "error","msg" => "token not found","teacher_id" => $_POST['id']));
  }
}

/* For Quiz App */

public function gettestid(){
    $test = $this->Test->find("all",array('conditions' => 
      array('Test.deleted' => 0)));
   $this->autoRender = false;
    // $this->set("json",json_encode($test));
   echo json_encode($test);
  }

}

