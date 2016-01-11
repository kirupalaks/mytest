<?php
class TeacherController extends AppController {

	public $name = "Teacher";

	public $uses = array('Teacher','TeacherBatchMap','Batch','Token','Subject',
    'ClassroomCourse','ClassroomStudent','Standard','StudentBatchMap',
    'Location');

  public function beforeFilter() {
    parent::beforeFilter();
   $this->Auth->allow('login','teacherlogin','email','confirm_student','confirm_payment','syncdb');
 }

	public function admin_index(){
		$this->layout = "ahaguru";
	}

	  public function unique_id($l = 3) {
	return substr((uniqid(mt_rand(), true)), 0, $l);
    }

	public function adata_index(){
       $this->layout = "default";
       $teacher = $this->Teacher->find("all",array('conditions' => array('Teacher.deleted' => 0)));
       $this->set("json",json_encode($teacher));
	}


	public function adata_add() {
  if($this->request->is("post")) {
      $data = $this->request->data;
      $pwd = substr($data['name'],0,4);
       $data['password'] = $pwd.$this->unique_id();
       $add = $this->Teacher->save($data);   
       $rawstring = "<p>Dear names,</p>
                  <p>Thank you for Registering !!!</p>
                  <p>Please use the below email id and password to login</p><br/>
                  <p>User Name : mailid</p>
                  <p>Password : passwd</p><br/>
                  <p>Have a great Day !!!</p>";
     $placeholders=array('names','mailid','passwd');
     $string=array($data['name'],$data['email'],$data['password']);
    $rawstr = str_replace($placeholders, $string, $rawstring);
    $this->sendEmail($this->request->data['email'],null, "Registration",$rawstr); 
      $this->redirect("/admin/teacher");
  }
    }

     public function adata_edit($id) {
  if($this->request->is("POST")) {
      $data = $this->request->data;
          $this->Teacher->id = $id;
     //$pwd = substr($data['name'],0,4);
       //$data['password'] = $pwd.$this->unique_id();
       $add = $this->Teacher->save($data);   
    $this->redirect("/admin/teacher");
  }
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
            $Standard = $this->Standard->find("first",array('conditions' => array(
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
            $Standard = $this->Standard->find("first",array('conditions' => array(
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

public function email(){
   if($this->request->is("post")) {
    $key = "tutor";
    $tokenreceived = $_POST['token'];
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
             $rawstr = "<p>Welcome ,</p><br/>
                  <table class='table table-bordered' style='border:1px solid #000000'>
                  <tr style='background-color:#c00000;'>
                   <th style='text-align:center; color:#FFFFFF;padding:5px;'>Student Name</th>
        <th style='text-align:center; color:#FFFFFF;padding:5px;'>Email</th>
        <th style='text-align:center; color:#FFFFFF;padding:5px;'>Standard</th>
        <th style='text-align:center; color:#FFFFFF;padding:5px;'>School</th>
        <th style='text-align:center; color:#FFFFFF;padding:5px;'>Mobile</th>
        <th style='text-align:center; color:#FFFFFF;padding:5px;'>Place</th>
         <th style='text-align:center; color:#FFFFFF;padding:5px;border-right:1px solid #000000'>Batch</th>
        <th style='text-align:center; color:#FFFFFF;padding:5px;border-right:1px solid #000000'>Class</th>
        <th style='text-align:center; color:#FFFFFF;padding:5px;border-right:1px solid #000000'>Location</th>
        <th style='text-align:center; color:#FFFFFF;padding:5px;border-right:1px solid #000000'>Course Name</th>
        <th colspan='2' style='text-align:center; color:#FFFFFF;padding:5px;border-right:1px solid #000000'>Weekly Schedule</th>
        <th style='text-align:center; color:#FFFFFF;padding:5px;'>Teachers</th>
        <th style='text-align:center; color:#FFFFFF;padding:5px;'>confirmation</th>
        <th style='text-align:center; color:#FFFFFF;padding:5px;'>Payment</th>
        </tr>tablecontent</table><br/>
        <p>Thank you and Have a Good day !!!.</p>";
         $tablecontent="";
        foreach($teachers_batch['ClassroomStudent'] as $key => $sch) {
    
          $tablecontent .="<tr style='border-bottom:1pt solid black'><td style='text-align:center;border-bottom:1px solid #000000;border-right:1px solid #000000;padding:5px'> ".$sch['name']."</td>";
          $tablecontent .="<td style='text-align:center;border-right:1px solid #000000;border-bottom:1px solid #000000;padding:5px'> ".$sch['email']."</td>";
          $tablecontent .="<td style='text-align:center;border-right:1px solid #000000;border-bottom:1px solid #000000;padding:5px'> ".$sch['standard']."</td>";
          $tablecontent .="<td style='text-align:center;border-right:1px solid #000000;border-bottom:1px solid #000000;padding:5px'> ".$sch['school_name']."</td>";
          $tablecontent .="<td style='text-align:center;border-right:1px solid #000000;border-bottom:1px solid #000000;padding:5px'> ".$sch['mobile_number']."</td>";
          $tablecontent .="<td style='text-align:center;border-right:1px solid #000000;border-bottom:1px solid #000000;padding:5px'> ".$sch['place']."</td>";
        $tablecontent .= "<td style='text-align:center;border-right:1px solid #000000;border-bottom:1px solid #000000;padding:5px;'> ".$sch['batch']['name']."</td>";
        $tablecontent .="<td style='text-align:center;border-right:1px solid #000000;border-bottom:1px solid #000000;padding:5px'> Std ".$sch['batch']['class']."</td>";
        $tablecontent .="<td style='text-align:center;border-right:1px solid #000000;border-bottom:1px solid #000000;padding:5px'> ".$sch['batch']['location']."</td>";
        $tablecontent .="<td style='text-align:center;border-right:1px solid #000000;border-bottom:1px solid #000000;padding:5px'> ".$sch['batch']['course']."</td>";
        $tablecontent .="<td style='text-align:center;border-right:1px solid #000000;border-bottom:1px solid #000000;padding:5px'> ".$sch['batch']['schedule_day']."</td>";
        $tablecontent .="<td style='text-align:center;border-right:1px solid #000000;border-bottom:1px solid #000000;padding:5px'> ".$sch['batch']['schedule_time']."</td>";
        $tablecontent .="<td style='text-align:center;border-right:1px solid #000000;border-bottom:1px solid #000000;padding:5px'> ".$teacher['Teacher']['name']."</td>";
        $tablecontent .="<td style='text-align:center;border-right:1px solid #000000;border-bottom:1px solid #000000;padding:5px'> ".$sch['confirmation']."</td>";
        $tablecontent .="<td style='text-align:center;border-bottom:1px solid #000000;padding:5px'> ".$sch['payment']."</td>";
            $tablecontent .= "</tr>";
     
         }
          $placeholders=array('tablecontent');
          $string=array($tablecontent);
          $emailstring = str_replace($placeholders, $string, $rawstr);
             $sendmail = $this->sendEmail($teacher['Teacher']['email'] , null , "Student : details",$emailstring);
         if ($sendmail){ 
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
    echo json_encode(array("status" => "error","msg" => "token not found","teacher_id" => $_POST['id']));
   }
}

public function confirm_payment(){
   if($this->request->is("post")) {
    $key = "tutor";
    $token = urldecode($_POST['token']);
    $tutor = $this->Token->findByTeacherId($_POST['id']);
     if(strcmp($token,$tutor['Token']['token']) == 0){
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
    echo json_encode(array("status" => "error","msg" => "token not found","teacher_id" => $_POST['id']));
   }
}

}
