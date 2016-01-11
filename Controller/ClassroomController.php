<?php
App::import('Vendor', 'dompdf', array('file' => 'dompdf' . DS . 'dompdf_config.inc.php'));
class ClassroomController extends AppController {

    public $name = "Classroom";

    public $uses = array('ClassroomCourse','Batch','ClassroomBatch','Teacher','Subjects','Location','StudentBatchMap','School','StudentClassroomRequest',
      'Student','ClassroomStudent','Standard','ParentRelationship','TeacherBatchMap','StudentClassroomBatchMap','StudentCourseMap','Register','CrBatchMap');


    public function beforeFilter() {
   	parent::beforeFilter();
	$this->layout = "default";
  $this->Auth->allow("verify_email","student_registration","student_login","student_reg");
    }

    public function admin_index() {
	$this->layout = "ahaguru";
    }

      public function admin_courses() {
  $this->layout = "ahaguru";
    }

     public function student_index(){  
      $this->layout = "ahaguru";
        $user = $this->Auth->user();
            $this->set('user', $user);   
  }
        

  public function adata_courses() {
  $conditions = array(
        "ClassroomCourse.deleted =" => 0,
        //"ClassroomCourse.types =" => 2
        );
      $this->set("json",json_encode($this->ClassroomCourse->find("all", array('conditions' => $conditions))));
  }

public function verify_email() {
    if($this->request->is("post")){
      $email = $this->request->data['email'];
      $student = $this->ClassroomStudent->findByEmail($email);
      if($student == null) {
        $this->set("json", json_encode(array("isvalid"=>"yes")));
      }
      else {
        $this->set("json", json_encode(array("isvalid"=>"no")));
      }
    }
  }

public function subjects() {
  
      $this->set("json",json_encode($this->Subjects->find("all")));
  }

  public function location() {
  
      $this->set("json",json_encode($this->Location->find("all")));
  }

   public function schedule($id){
    $subjects = $this->Subjects->find("all");
    $teachers = $this->Teacher->find("all");
    $i=0;$j=0;
    $teacher = array();    
    $location = array();
    foreach ($subjects as $key =>$sub) {
      $batche = array();
    $teacer = array();       
    $teachers_id=array();
         $conditions = array(
        "ClassroomCourse.deleted =" => 0,
       // "ClassroomCourse.types =" => 2,
        "ClassroomCourse.subject =" => $sub['Subjects']['id']
        );
      $course = $this->ClassroomCourse->find("all", array('conditions' => $conditions));
     foreach ($course as $crs) {    
    $conditio = array(
        "Batch.deleted =" => 0,
        "Batch.class =" => $id,
        "Batch.acadamic_year" =>"2016-2017",
        "Batch.course_id =" => $crs['ClassroomCourse']['id']
        );    
      $batc=$this->Batch->find("all", array('conditions' => $conditio));
      $batche = array_merge($batche,$batc);
     }
     foreach ($batche as $key => $value) {  
        $teachers_id = explode(",", $value['Batch']['teachers_id']);
       $teacher = array_merge($teacher,$teachers_id);  
       $location[$j] = $value['Batch']['location'];
       $j++;
     }       $teacer =array_merge($teacer,$teacher);
            $batch[$i]['batches'] = $batche;       
        $batch[$i]['subject'] = $sub['Subjects']['name'];
       $i++;
    }    
   $batch[$i]['teachers']=array_unique($teacer);
   $i++;
   $batch[$i]['location']=array_unique($location);
   $this->set("json",json_encode($batch));

   }

   public function batches(){
    $subjects = $this->Subjects->find("all");
    $teachers = $this->Teacher->find("all");
    $i=0;$j=0;
    $teacher = array();    
    $location = array();
    foreach ($subjects as $key =>$sub) {
      $batche = array();
    $teacer = array();       
    $teachers_id=array();
         $conditions = array(
        "ClassroomCourse.deleted =" => 0,
      //  "ClassroomCourse.types =" => 2,
        "ClassroomCourse.subject =" => $sub['Subjects']['id']
        );
      $course = $this->ClassroomCourse->find("all", array('conditions' => $conditions));
     foreach ($course as $crs) {
    
    $conditio = array(
        "Batch.deleted =" => 0,
        "Batch.course_id =" => $crs['ClassroomCourse']['id']
        );
    
      $batc=$this->Batch->find("all", array('conditions' => $conditio));
      $batche = array_merge($batche,$batc);
     }
     foreach ($batche as $key => $value) {  
        $teachers_id = explode(",", $value['Batch']['teachers_id']);
       $teacher = array_merge($teacher,$teachers_id);  
       $location[$j] = $value['Batch']['location'];
       $j++;
     }
      
            $teacer =array_merge($teacer,$teacher);
            $batch[$i]['batches'] = $batche;       
        $batch[$i]['subject'] = $sub['Subjects']['name'];
       $i++;
    }
    
   $batch[$i]['teachers']=array_unique($teacer);
   $i++;
   $batch[$i]['location']=array_unique($location);
   $this->set("json",json_encode($batch));

   }

 public function courses() {
  $conditions = array(
        "ClassroomCourse.deleted =" => 0,
        //"ClassroomCourse.types =" => 2
        );
      $this->set("json",json_encode($this->ClassroomCourse->find("all", array('conditions' => $conditions))));
  }


    public function adata_addcourse() {
      $this->autoRender = false;
  if($this->request->is("post")) {
      $data = $this->request->data;
      $data['types'] = 2;
         $add = $this->ClassroomCourse->save($data);    
        
      $this->redirect("/admin/classroom/courses");
  }
    }


       /* Edit Course */
    public function adata_edit($id) {
  if($this->request->is("POST")) {
      $data = $this->request->data;
          $this->ClassroomCourse->id = $id;
      $add = $this->ClassroomCourse->save($data);
    
      $this->redirect("/admin/classroom");
  }
    }

   /* Delete course */
    public function adata_delete($courseid) {
      /*if($this->Course->isSubscribed($courseid)) {
        $this->set("json", json_encode(array( "message" => "Course is under active subscription, Please delete all 
                          student subscription and try deleting again."))); 
      } else {
        if($this->Course->setDelete($courseid)){
          $this->StdCourseMap->setUpdate($courseid);
          $this->set("json", json_encode( array( "message" => "deleted") ));}
        else 
          $this->set("json", json_encode( array("message" => "error") ));
      }*/
      $this->set("json", json_encode( array( "message" => "deleted") ));
    }

    public function admin_batches() {
  $this->layout = "ahaguru";
    }
  
   public function teachers(){
   
   $this->set("json",json_encode($this->Teacher->find("all",array('conditions' => array('Teacher.deleted' => 0)))));
   }

  public function adata_batches() {
  $conditions = array(
        "Batch.deleted =" => 0,
        "Batch.acadamic_year =" =>"2016-2017"
          );
      $this->set("json",json_encode($this->Batch->find("all", array('conditions' => $conditions))));
  }

    public function adata_add_batches() {
  if($this->request->is("post")) {
      $data = $this->request->data;
      $teachers_id = $data['teachers_id'];
       $data['teachers_id']= implode(',', $data['teachers_id']);
       $data['acadamic_year'] = "2016-2017";       
        $this->Batch->save($data);
        $batchid = $this->Batch->id;
        foreach ($teachers_id as $id) {
         $mapped = array (
          'teachers_id' => $id,
          'batch_id' => $batchid
          );
         $this->TeacherBatchMap->saveAll($mapped);
         }
        $this->redirect("/admin/classroom/batches");
  }
    }

    /* Edit Course */
    public function adata_edit_batches($id) {
  if($this->request->is("POST")) {
      $data = $this->request->data;
      $teachers_id = $data['teachers_id'];

      $data['teachers_id']= implode(',', $data['teachers_id']);
          $this->Batch->id = $id;
     $add = $this->Batch->save($data);
       $batchid = $this->Batch->id;
     $this->TeacherBatchMap->setDelete($batchid);
     foreach ($teachers_id as $id) {
      $conditions = array(
        'batch_id' => $batchid,
        'teachers_id '=> $id
        );
       $batchmap = $this->TeacherBatchMap->find("first",array('conditions' => $conditions));
       
       if(empty($batchmap))
      {
          $mapped = array (
          'teachers_id' => $id,
          'batch_id' => $batchid
          );
          
         $this->TeacherBatchMap->saveAll($mapped);
       }
       else{
        $datamapped = array (
          'id' => $batchmap['TeacherBatchMap']['id'],
          'teachers_id' => $id,
          'batch_id' => $batchid,
          'deleted' => 0
          );
        
         $this->TeacherBatchMap->save($datamapped);
       }
     }
      $this->redirect("/admin/classroom/batches");
  }
    }

    public function sdata_selected_batches(){
      $data = $this->request->data;
      $subjects = $this->Subjects->find("all");
    $teachers = $this->Teacher->find("all");
    $i=0;$j=0;
    $teacher = array();    
    $location = array();
    foreach ($subjects as $key =>$sub) {
      $batche = array();
    $teacer = array();       
    $teachers_id=array();
         $conditions = array(
        "ClassroomCourse.deleted =" => 0,
        //"ClassroomCourse.types =" => 2,
        "ClassroomCourse.subject =" => $sub['Subjects']['id']
        );
      $course = $this->ClassroomCourse->find("all", array('conditions' => $conditions));
     foreach ($course as $crs) {
    foreach ($data['batche'] as $schedule) {
    $conditio = array(
        "Batch.deleted =" => 0,
         "Batch.id =" => $schedule,
        "Batch.course_id =" => $crs['ClassroomCourse']['id']
        );
       
      $batc=$this->Batch->find("all", array('conditions' => $conditio));
      $batche = array_merge($batche,$batc);
     }}
     foreach ($batche as $key => $value) {  
        $teachers_id = explode(",", $value['Batch']['teachers_id']);
       $teacher = array_merge($teacher,$teachers_id);  
       $location[$j] = $value['Batch']['location'];
       $j++;
     }
      
            $teacer =array_merge($teacer,$teacher);
            $batch[$i]['batches'] = $batche;       
        $batch[$i]['subject'] = $sub['Subjects']['name'];
       $i++;
    }
    
   $batch[$i]['teachers']=array_unique($teacer);
   $i++;
   $batch[$i]['location']=array_unique($location);
   $this->set("json",json_encode($batch));

   }

  public function logout() {    
    // $user = $this->Auth->user();
    // if(isset($user['Student'])){
    //   unset($_SESSION['classroomstudent']);      
    //  $this->redirect("/student/classroom");
    // }
    //   else{
   $this->Auth->logout();
    // session_destroy();
  $this->redirect("/classroom");}
    // }

  public function online_logout() {
   $this->Auth->logout();
   $this->redirect("/online");
    }

  public function sdata_confirm_batches(){
      $data = $this->request->data;
      $user = $this->Auth->user();
      $teachers = $this->Teacher->find("all");
      $standards = $this->Standard->find("all");
      $locations = $this->Location->find("all");
      // $Parent_relationship = $this->ParentRelationship->find("all");
      $courses = $this->ClassroomCourse->find("all",array('conditions' => 
        array(//'ClassroomCourse.types' => 2,
          'ClassroomCourse.deleted' => 0)));
      if(isset($user['Student'])){
      // $student_id = $this->Session->read('classroomstudent');
        $student_id = $user['Student']['id'];
      // $user = $this->ClassroomStudent->find("first",array('conditions'=>
      //   array('ClassroomStudent.id' => $student_id)));
      $email = $user['Student']['email']; 
      $parent_email = $user['Student']['parent_email'];
      //   foreach ($Parent_relationship as $rel) {
      //   if($rel['ParentRelationship']['id'] == $user['Student']['parent_relationship'])
      //     $parent_relationship = $rel['ParentRelationship']['name'] ;
      // }
      foreach ($standards as $std) {
        if($std['Standard']['id'] == $user['Student']['standard'])
          $stand = $std['Standard']['name'] ;
      }
      foreach ($data['batche'] as $sch) {    
      $data['student_id'] = $student_id;
      $data['cl_batch_id'] = $sch;
      $this->CrBatchMap->saveAll($data);
       $str = "update ag_tmp_students set deleted = 1 where student_userid = '".$user['Student']['user_id']."'";       
       $this->Register->query($str);
     }
    } 
    else{
      //$name = $user['ClassroomStudent']['name'];
      $email = $user['Student']['email']; 
      $parent_email = $user['Student']['parent_email'];
      //$school = $user['ClassroomStudent']['school_name'];
      // foreach ($Parent_relationship as $rel) {
      //   if($rel['ParentRelationship']['id'] == $user['Student']['parent_relationship'])
      //     $parent_relationship = $rel['ParentRelationship']['name'] ;
      // }
      foreach ($standards as $std) {
      if($std['Standard']['id'] == $user['Student']['standard'])
          $stand = $std['Standard']['name'] ;
      }
        foreach ($data['batche'] as $sch) {
          $data['student_id'] = $user['Student']['id'];
      $data['cl_batch_id'] = $sch;
      $this->CrBatchMap->saveAll($data);
      $str = "update ag_tmp_students set deleted = 1 where student_userid = '".$user['Student']['user_id']."'";
       $this->Register->query($str);
     }
    }
    $rawstring = "<p>Welcome names,</p><br/>
                  <p>Thank you for Registering with Direct Classroom Program.</p><br/>
                  <p>Please Confirm your profile and selection details.</p>
                  <p><b>Name </b>: names</p>
                  <p><b>Email </b>: emails</p>
                  <p><b>Class in School </b>: std</p>
                  <p><b>School Name </b>: school</p>                  
                  <p><b>Mobile </b>: mobiles</p>
                  <p><b>Parent Name </b>: parentname</p>
                  <p><b>Parent Email </b>: parentemail</p>
                  <p><b>Parent Mobile </b>: parent_mobile</p>
                  <br><br>
                  <p><b>Batch detail</b></p>
                  <table class='table table-bordered' style='border:1px solid #000000'>
                  <tr style='background-color:#c00000;'>
         <th style='text-align:center; color:#FFFFFF;padding:10px;border-right:1px solid #000000'>Batch</th>
        <th style='text-align:center; color:#FFFFFF;padding:10px;border-right:1px solid #000000'>Class</th>
        <th style='text-align:center; color:#FFFFFF;padding:10px;border-right:1px solid #000000'>Location</th>
        <th style='text-align:center; color:#FFFFFF;padding:10px;border-right:1px solid #000000'>Course Name</th>
        <th colspan='2' style='text-align:center; color:#FFFFFF;padding:10px;border-right:1px solid #000000'>Weekly Schedule</th>
        <th style='text-align:center; color:#FFFFFF;padding:10px;'>Teachers</th>
        </tr>tablecontent</table><br/>
        <!--<p>Program fees can be paid anytime by the end of January. Your respective course teachers will contact you shortly regarding <br/>
         the Parent-Teachers meeting.</p>-->
         <p>Respective teachers will directly contact you to meet them and you can pay the fees at that time directly. </p>
         <p>If Any corrections need to be done to the above details , Please email to <a href='learn@ahaguru.com'>learn@ahaguru.com</a>
         <p>Thank you and Have a Good day !!!.</p>";
         $tablecontent="";
        foreach($data['batche'] as $key => $sch) {
        if(($key+1)%2 ==0){
            $color="#c9dba9";
            }else{
              $color="#acc87a";
              }
        $batch = $this->Batch->findById($sch);
        $tablecontent .= "<tr style='background-color:$color;'><td style='text-align:center;border-right:1px solid #000000;padding:10px;'> ".$batch['Batch']['name']."</td>
        <td style='text-align:center;background-color:$color;border-right:1px solid #000000;padding:10px'> Std ";
        foreach($standards as $Standard){
          if($Standard['Standard']['id'] == $batch['Batch']['class']){
            $tablecontent .= $Standard['Standard']['name'];
          }}
          $tablecontent .="</td> <td style='text-align:center;border-right:1px solid #000000;padding:10px'>";
        foreach($locations as $loc){
          if($batch['Batch']['location'] == $loc['Location']['id']){
         $tablecontent .=$loc['Location']['name'] ;
         }}
         $tablecontent .="</td>
        <td style='text-align:center;border-right:1px solid #000000;padding:10px'>";
          foreach($courses as $course){
          if($batch['Batch']['course_id'] == $course['ClassroomCourse']['id']){
        $tablecontent .=$course['ClassroomCourse']['name'];
      }}
     $tablecontent .="</td>
       <td style='text-align:center;border-right:1px solid #000000;padding:10px'>".$batch['Batch']['schedule_day']."</td>
        <td style='text-align:center;border-right:1px solid #000000;padding:10px'>".$batch['Batch']['schedule_time']."</td>
        <td style='text-align:center;padding:10px'>";
         $teach = explode(',',$batch['Batch']['teachers_id']);
                foreach($teach as $tea){
                foreach($teachers as $teacher) { 
                if($teacher['Teacher']['id'] == $tea){
         $tablecontent .= $teacher['Teacher']['name'];
         if(sizeof($teach) > 1){
                      $tablecontent .= " , ";
                    }
                      
                     }}}
                     $tablecontent .= "</tr>";
         }

$placeholders=array('names','emails','std','school','mobiles','parentname',
  'parentemail','parent_mobile','tablecontent');
// error_log("user".print_r($user,true));
$string=array($user['Student']['name'],$user['Student']['email'],$stand,$user['Student']['school_name'],
              $user['Student']['mobile_number'],$user['Student']['parent_name'],
              $user['Student']['parent_email'],$user['Student']['parent_mobile'],$tablecontent);
$rawstr = str_replace($placeholders, $string, $rawstring);
 $this->sendEmail("kiruthiga.sekar10@gmail.com",$parent_email, "Classroom: Registration",$rawstr,null);
$emailstring = "<p>Dear Admin,</p>
                <p>names has registered with direct classroom program,</p>
                 <p><b>Student detail </b></p>
                 <p><b>Name </b>: names</p>
                  <p><b>Email </b>: emails</p>
                  <p><b>Class in School </b>: std</p>
                  <p><b>School Name </b>: school</p>
                  <p><b>Mobile </b>: mobiles</p>
                  <p><b>Parent Name </b> : parentname</p>
                  <p><b>Parent Email </b> : parentemail</p>                  
                  <p><b>Parent Mobile </b> : parentmobile</p>
                  <br><br>
                  <p><b>Batch detail</b></p>
                  <table class='table table-bordered' style='border:1px solid #000000'>
                  <tr style='background-color:#c00000;'>
         <th style='text-align:center; color:#FFFFFF;padding:10px;border-right:1px solid #000000'>Batch</th>
        <th style='text-align:center; color:#FFFFFF;padding:10px;border-right:1px solid #000000'>Class</th>
        <th style='text-align:center; color:#FFFFFF;padding:10px;border-right:1px solid #000000'>Location</th>
        <th style='text-align:center; color:#FFFFFF;padding:10px;border-right:1px solid #000000'>Course Name</th>
        <th colspan='2' style='text-align:center; color:#FFFFFF;padding:10px;border-right:1px solid #000000'>Weekly Schedule</th>
        <th style='text-align:center; color:#FFFFFF;padding:10px;'>Teachers</th>
        </tr>tablecontent</table>";
        $tablecontent="";
        foreach($data['batche'] as $key => $sch) {
        if(($key+1)%2 ==0){
            $color="#c9dba9";
            }else{
              $color="#acc87a";
              }
        $batch = $this->Batch->findById($sch);
        $tablecontent .= "<tr style='background-color:$color;'><td style='padding:10px;text-align:center;border-right:1px solid #000000'> ".$batch['Batch']['name']."</td>
        <td style='text-align:center;background-color:$color;padding:10px;border-right:1px solid #000000'> Std ";
        foreach($standards as $Standard){
          if($Standard['Standard']['id'] == $batch['Batch']['class']){
            $tablecontent .= $Standard['Standard']['name'];
          }}
          $tablecontent .="</td> <td style='text-align:center;padding:10px;border-right:1px solid #000000'>";
        foreach($locations as $loc){
          if($batch['Batch']['location'] == $loc['Location']['id']){
         $tablecontent .=$loc['Location']['name'] ;
         }}
         $tablecontent .="</td>
        <td style='text-align:center;border-right:1px solid #000000;padding:10px'>";
          foreach($courses as $course){
          if($batch['Batch']['course_id'] == $course['ClassroomCourse']['id']){
        $tablecontent .=$course['ClassroomCourse']['name'];
      }}
     $tablecontent .="</td>
       <td style='text-align:center;border-right:1px solid #000000;padding:10px'>".$batch['Batch']['schedule_day']."</td>
        <td style='text-align:center;border-right:1px solid #000000;padding:10px'>".$batch['Batch']['schedule_time']."</td>
        <td style='text-align:center;'>";
         $teach = explode(',',$batch['Batch']['teachers_id']);
                foreach($teach as $tea){
                foreach($teachers as $teacher) { 
                if($teacher['Teacher']['id'] == $tea){
         $tablecontent .= $teacher['Teacher']['name'];
         if(sizeof($teach) > 1){
                      $tablecontent .= " , ";
                    }
                      
                     }}}
                     $tablecontent .= "</tr>";
         }
                            
   $placeholders=array('names','emails','std','school','mobiles','parentname',
  'parentemail','parentmobile','tablecontent');
 // error_log("sdsdsd".print_r($user,true));
$string=array($user['Student']['name'],$user['Student']['email'],$stand,$user['Student']['school_name'],
              $user['Student']['mobile_number'],$user['Student']['parent_name'],
              $user['Student']['parent_email'],$user['Student']['parent_mobile'],$tablecontent);
$emailstring = str_replace($placeholders, $string, $emailstring);
// error_log("em".$emailstring);
 $this->sendEmail("kiruthiga.sekar10@gmail.com",null, "Classroom: Registration",$emailstring,null);
   $this->set("json",json_encode(array("result" => "mapped")));

   }

public function adata_delete_batches($batchid) {
         if($this->Batch->isSubscribed($batchid)) {
        $this->set("json", json_encode(array( "message" => "Batch is under active subscription, Please delete all 
                          student subscription and try deleting again."))); 
      } else {
        if($this->Batch->setDelete($batchid)){
          $this->TeacherBatchMap->setDelete($batchid);
               $this->set("json", json_encode( array( "message" => "deleted") ));
             }
        else {
            $this->set("json", json_encode( array("message" => "error") ));
        }
      }
      
    }

 public function admin_assign_course() {
  $this->layout = "ahaguru";        
      if($this->request->is("post")){
          $data = $this->request->data;
        $studentsid = $this->StudentClassroomBatchMap->findAllByBatchId($data['batch_id']);
        foreach ($studentsid as $student) {          
            $mapdata = array();          
            $con = array(
            'StudentCourseMap.student_id' => $student['StudentClassroomBatchMap']['student_id'],
            'StudentCourseMap.course_id' => $data['course_id'],
            // 'StudentCourseMap.deleted' => 0
            );
          $crsmap = $this->StudentCourseMap->find("first",array('conditions' => $con));          
          if(!empty($crsmap))
           $mapdata['id'] = $crsmap['StudentCourseMap']['id'];          
            $mapdata['student_id'] = $student['StudentClassroomBatchMap']['student_id'];
            $mapdata['course_id'] = $data['course_id'];            
            $mapdata['status'] = 1;
            $mapdata['comments'] = "Bulk Assigned";            
            $mapdata['payment'] = 2;            
            $mapdata['deleted'] = 0;
            $this->StudentCourseMap->saveAll($mapdata);
        }
        $this->redirect("/admin/classroom");
    }
  }

     public function classroombatches() {    
      $this->set("json",json_encode($this->ClassroomBatch->find("all")));
  }


  public function student_reg() {
     $this->layout = "ahaguru";
     $this->Session->delete('clemail');
        }

      public function student_login() {
      $this->layout = "ahaguru";
      $email = $this->Session->read('clemail');      
      if($email == undefined || $email == "")
        $this->redirect('/student/classroom/reg');
      $this->set('email',$this->Session->read('clemail'));
    }
    
    public function student_view($id) {
      $this->layout = "ahaguru";      
      $this->set('email',$this->Session->read('clemail'));
    $this->set("standard", $this->Standard->find('all',array( 'order' => array('Standard.name' => 'DESC'))));  
    $this->set("relationship", $this->ParentRelationship->find('all'));  
    $this->set("school", $this->School->find('all'));  
    $this->set("user",$this->Student->findById($id));    
    }

    public function student_registration(){
      $this->layout = "ahaguru";
      $email = $this->Session->read('clemail');      
      if($email == undefined || $email == "")
        $this->redirect('/student/classroom/reg');
      $this->set('email',$this->Session->read('clemail'));
      $this->set("standard", $this->Standard->find('all',array( 'order' => array('Standard.name' => 'DESC'))));  
    $this->set("relationship", $this->ParentRelationship->find('all'));  
    $this->set("school", $this->School->find('all'));  
    }

    public function sdata_edit($id){
      $this->autoRender = false;         
      if($this->request->is("post")){
        $data = $this->request->data;                        
        $school = $this->School->findBySchoolId($data['school_name']);        
        $tmpdata = array();
        $user = $this->Student->findById($id);
        if(!empty($user)){
        $tmpdata['registration_for'] = "CR_EXISTING";        
        $tmpdata['student_name'] = $user['Student']['name'];
        $tmpdata['student_userid'] = $user['Student']['user_id'];
        $tmpdata['mobile_number'] = $user['Student']['mobile_number'];
        }
        $data['school_name'] = $school['School']['SCHOOL_NAME'];
        $student = $this->Student->save($data);
        $batchmap = $this->CrBatchMap->findByStudentId($id);        
          if($student && empty($batchmap)){
            $this->Register->save($tmpdata);
          echo json_encode(array("result" => "saved","reg" => "valid"));        
          }
          else if($student && !empty($batchmap))
          echo json_encode(array("result" => "saved","reg" => "invalid"));        
      }    
    }    

    public function student_batch(){
      $this->layout = "ahaguru";
      // $user = $this->Auth->user();
      // $student_batches = $this->StudentBatchMap->findByStudentId($user['Student']['id']);
    }

    public function sdata_batch(){
      $subjects = $this->Subjects->find("all");
    $teachers = $this->Teacher->find("all");
    $i=0;$j=0;
    $teacher = array();    
    $location = array();
    $user = $this->Auth->user();    
    $con = array(
      'CrBatchMap.student_id' => $user['Student']['id'],
      'CrBatchMap.deleted' => 0
      );
    $student_batches = $this->CrBatchMap->find("all",array('conditions'=>$con));
    // error_log("ssaa".print_r($student_batches,true));
    foreach ($subjects as $key =>$sub) {
      $batche = array();
    $teacer = array();       
    $teachers_id=array();
         $conditions = array(
        "ClassroomCourse.deleted =" => 0,
        //"ClassroomCourse.types =" => 2,
        "ClassroomCourse.subject =" => $sub['Subjects']['id']
        );
      $course = $this->ClassroomCourse->find("all", array('conditions' => $conditions));
     foreach ($course as $crs) {
    foreach ($student_batches as $schedule) {
      // error_log("dsd".print_r($schedule,true));
    $conditio = array(
        "Batch.deleted =" => 0,
        "Batch.acadamic_year" =>"2016-2017",
         "Batch.id =" => $schedule['CrBatchMap']['cl_batch_id'],
        "Batch.course_id =" => $crs['ClassroomCourse']['id']
        );
      // error_log("con".print_r($conditio,true)); 
      $batc=$this->Batch->find("all", array('conditions' => $conditio));
      // error_log("batchid".print_r($batc,true));
      $batche = array_merge($batche,$batc);
     }}
     // error_log("batchid".print_r($batche,true));
     foreach ($batche as $key => $value) {  
        $teachers_id = explode(",", $value['Batch']['teachers_id']);
       $teacher = array_merge($teacher,$teachers_id);  
       $location[$j] = $value['Batch']['location'];
       $j++;
     }
      

            $teacer =array_merge($teacer,$teacher);
            $batch[$i]['batches'] = $batche;       
        $batch[$i]['subject'] = $sub['Subjects']['name'];
       $i++;
    }
    
   $batch[$i]['teachers']=array_unique($teacer);
   $i++;
   $batch[$i]['location']=array_unique($location);
   $this->set("json",json_encode($batch));      
    }

    public function sdata_request(){
      $this->autoRender = false;         
      if($this->request->is("post")){
        $user = $this->Auth->user();
        $data = $this->request->data;                        
        $data['student_id'] = $user['Student']['id'];
        $save = $this->StudentClassroomRequest->save($data);
        $rawstr = "<p>Student Name: sname</p>
                  <p>Student Email: semail</p>
                  <p>Student Mobile: smobile</p>
                  <p>Requested changes: rechanges<p>";
        $placeholders=array('sname','semail','smobile','rechanges');      
        $string=array($user['Student']['name'],$user['Student']['email'],$user['Student']['mobile_number'],$data['requested_change']);
        $rawstr = str_replace($placeholders, $string, $rawstr);
        $this->sendEmail("balajisampath@gmail.com","ramya16june@gmail.com", "Classroom: Request",$rawstr,null);
        if($save)
          echo json_encode(array('result' => 'success'));
            }
  }


  public function sdata_isregistered(){
      $this->autoRender = false;         
      if($this->request->is("post")){
        $user = $this->Auth->user();                                                        
        $batchmap = $this->CrBatchMap->findByStudentId($user['Student']['id']);        
          if(empty($batchmap)){          
          echo json_encode(array("is_reg" => 0,"student_id" => $user['Student']['id']));        
          }
          else if(!empty($batchmap))
          echo json_encode(array("is_reg" => 1,"student_id" => $user['Student']['id']));        
      }    
    }    


  public function admin_modify_batch(){
     $this->layout = "ahaguru"; 
  }
  public function adata_searchstudents($data) {      
  if(isset($data)){
              $condi = array( 
     'OR' => array(array(
       'Student.email LIKE' => "$data%",
      'Student.deleted =' => 0,
    'Student.student_status <>' => 2),
    array(
       'Student.mobile_number =' => "$data",
      'Student.deleted =' => 0,
    'Student.student_status <>' => 2),
    array(
       'Student.name =' => "$data",
      'Student.deleted =' => 0,
    'Student.student_status <>' => 2),
      ));
       $i = 0;    
    $studentid = $this->Student->find("all", array('conditions'=>$condi));  
    $this->set("json", json_encode($studentid));  
    }     
  }
  
  
  
  public function adata_studbatch($student_id){
    if(isset($student_id)){
    $subjects = $this->Subjects->find("all");
    $teachers = $this->Teacher->find("all");
    $i=0;$j=0;
    $teacher = array();    
    $location = array();
    $batche = array();
    $teachers_id=array();
     foreach ($subjects as $key =>$sub) {
     
    $teacer = array();       
    
       $conditions = array(
        "ClassroomCourse.deleted =" => 0,
       // "ClassroomCourse.types =" => 2,
        "ClassroomCourse.subject =" => $sub['Subjects']['id']
        );
     }
    $con = array (
        'CrBatchMap.student_id =' => $student_id,
        'CrBatchMap.deleted =' => 0
        //'CrBatchMap.status =' => 'NOT ',		
    );
        $batchdet = $this->CrBatchMap->find("all",array('conditions' =>$con));
    foreach ($batchdet as $cl_batch) {
      $conditio = array(
      "Batch.deleted =" => 0, 
      "Batch.id =" => $cl_batch['CrBatchMap']['cl_batch_id'],
      "Batch.acadamic_year" =>"2016-2017",       
      );    
      $batc=$this->Batch->find("all", array('conditions' => $conditio));      
	  $batc[$i]['Batch']['status']= $cl_batch['CrBatchMap']['status'];
	  $batche= array_merge($batche,$batc);
    } 
	//print_r($batche);	
      foreach ($batche as $key => $value) {  
      $teachers_id = explode(",", $value['Batch']['teachers_id']);
       $teacher = array_merge($teacher,$teachers_id);  
       //$teacher = array_merge($teacher,$teachers_id);  
       $location[$j] = $value['Batch']['location'];
       $j++;
    }       
           // $teacer =array_merge($teacer,$teacher);
            $batch[$i]['batches'] = $batche;       
       // $batch[$i]['subject'] = $sub['Subjects']['name'];
    //$batch[$i]['student_id'] =$cl_batch['CrBatchMap']['student_id'];
       $i++;    
  // $batch[$i]['teachers']=array_unique($teacer);
   //$i++;
   //$batch[$i]['location']=array_unique($location);  
    $this->set("json",json_encode($batch));
    } 
   }
   public function delete_batches(){
  //if(isset($data)){   
   $data = $this->request->data;         
    $conditio = array(      
      "CrBatchMap.cl_batch_id =" => $data['cl_batch_id'],
      "CrBatchMap.student_id =" =>$data['student_id'],
      "CrBatchMap.deleted" => 0
      );    
	$getbatch = $this->CrBatchMap->find('first',array('conditions'=>$conditio));             
	$deleted =  $this->CrBatchMap->delete($getbatch['CrBatchMap']['id']);		
      if(isset($deleted))
       $this->set("json", json_encode( array("message" => "deleted") ));       
     else
      $this->set("json", json_encode( array("message" => "try again") ));  
 } 
 
   public function adata_currentyearbatches($studentid){
	   //$data = $this->request->data;
    $subjects = $this->Subjects->find("all");
    $teachers = $this->Teacher->find("all");
    $i=0;$j=0;
    $teacher = array();    
    $location = array();
  $studbat = array();
  $condit = array(      
      "CrBatchMap.deleted =" => 0,     
      "CrBatchMap.student_id =" =>$studentid		
      );    
     $getbatch = $this->CrBatchMap->find('all',array('conditions'=>$condit));
   foreach($getbatch as $curbat){   
        $studbat[] = $curbat['CrBatchMap']['cl_batch_id'];      
    $i++;
  }    
    $batche = array();$batche1 = array();
    $teacer = array();       
    $teachers_id=array();
    
   if(count($studbat)>1){
    $conditio = array(
        "Batch.deleted =" => 0,
        "Batch.id NOT " => $studbat,
        "Batch.acadamic_year =" => "2016-2017"    
           );        
    } else {
    $studbat = $studbat[0];
    $conditio = array(
        "Batch.deleted =" => 0,
        "Batch.id <>" => $studbat,
        "Batch.acadamic_year =" => "2016-2017"    
           );
	}		
    $batc=$this->Batch->find("all", array('conditions' => $conditio));
	$batche = array_merge($batche,$batc);   
	$batch[$i]['batches'] = $batche;       
    $i++;       
    $this->set("json",json_encode($batch));
   }
 
   public function adminconfirm(){
      $data = $this->request->data;  
		$studentid = $data['studid']; 
    
    $condit = array(      
      "CrBatchMap.deleted =" => 1,
      "CrBatchMap.student_id =" =>$studentid ,    
      "CrBatchMap.cl_batch_id =" =>$data['batche']      
      );
      
     $getbatch = $this->CrBatchMap->find('all',array('conditions'=>$condit));
     if(empty($getbatch)){
         
      $data['student_id'] = $data['studid'];
      $data['cl_batch_id'] = $data['batche'];
      $this->CrBatchMap->saveAll($data);
      
      $this->set("json",json_encode(array("result" => "mapped")));
   
     }
    else {
      $data['student_id'] = $data['studid'];
      $data['cl_batch_id'] = $data['batche'];
      $qry = "update ag_tr_CL_student_batch set deleted = '0' where student_id = '".$data['student_id']."' and cl_batch_id = '".$data['cl_batch_id']."' "; 
      $this->CrBatchMap->query($qry);
       $this->set("json",json_encode(array("result" => "mapped")));
     }      
   }
   
   public function adata_updatebatch(){
      if($this->request->is("post")){
        $data = $this->request->data;  
		$studentid = $data['studid'];   	
		$editbatch = $data['editbatch'];   	
		$newbatch = $data['batche'];   	
		$condit = array(      
      "CrBatchMap.deleted =" => 0,
      "CrBatchMap.student_id =" =>$studentid ,    
      "CrBatchMap.cl_batch_id =" =>$editbatch     
      );      
     $getbatch = $this->CrBatchMap->find('all',array('conditions'=>$condit));
	 if(!empty($getbatch)){		
	$clbatch = $this->Batch->findById($editbatch);		
			$batch_name = $clbatch['Batch']['name'];			
	$con 	= array(  
				'ClassroomBatch.batch_name ='=> $batch_name,
				"ClassroomBatch.acadamic_year =" => "2016-2017" );					
	$ClassroomBatchdet = $this->ClassroomBatch->find('first',array('conditions'=>$con));
	$batch_id =$ClassroomBatchdet['ClassroomBatch']['batch_id'];
	$conditio = array(           
				  "StudentClassroomBatchMap.student_id =" =>$studentid,    
				  "StudentClassroomBatchMap.batch_id =" =>$batch_id   
				  );
	$StudentClass = $this->StudentClassroomBatchMap->find('first',array('conditions'=> $conditio));
	 }
			if(!empty($StudentClass)) {
				$cl_studentremarks = array();
				$remarks = "FROM".$editbatch."TO".$newbatch;
				foreach($getbatch as $curbat){   
					$cl_studentremarks = $curbat['CrBatchMap']['remarks']; 
					$cl_studentbatchid = $curbat['CrBatchMap']['id'];					
				}
				if(empty($cl_studentremarks)) {					
					$cl_studentremarks = $remarks;					
				} else if(count($cl_studentremarks)> 1){
				$cl_studentremarks = explode(',',$cl_studentremarks);
				} else if(!empty($cl_studentremarks)) {					
					$cl_studentremarks = $cl_studentremarks;
					$cl_studentremarks .=  ','.$remarks;				
				}
				$sg_id = $StudentClass['StudentClassroomBatchMap']['sg_id'];
				$crdata = array();
				
				$qry = "update ag_tr_CL_student_batch set remarks='$cl_studentremarks', cl_batch_id='".$newbatch."' where student_id = '$studentid' and cl_batch_id = '$editbatch' "; 
				$updated = $this->CrBatchMap->query($qry);
				//if($updated && $newbatchid){
				$clnewbatch = $this->Batch->findById($newbatch);		
				$newbatch_name = $clnewbatch['Batch']['name'];			
				$cond1 	= array(  
							'ClassroomBatch.batch_name ='=> $newbatch_name,
							"ClassroomBatch.acadamic_year =" => "2016-2017" );					
				$newbatchdet = $this->ClassroomBatch->find('first',array('conditions'=>$cond1));
				$newbatch_id =$newbatchdet['ClassroomBatch']['batch_id'];	
					
				$qry1 = "update ag_tr_student_batch set batch_id='".$newbatch_id."' where sg_id = '".$sg_id."' "; 
				$mapped = $this->StudentClassroomBatchMap->query($qry1);
				//if(isset($mapped['StudentClassroomBatchMap'])){
					$this->set("json",json_encode(array('result'=>'mapped')));
					//$this->set("json",json_encode($cl_studentremarks));
				//}				
				}	
	 }	
	}


   public function admin_regstudents(){
    $this->layout = "ahaguru";
   }


   public function adata_regstudents($id){
    $this->layout = "default";
    $students = array();
    $i=0;
    $cons = array(
      'OR' =>array('Batch.teachers_id LIKE' => "$id,%",
         'Batch.teachers_id' => "$id"),       
      'Batch.acadamic_year' => "2016-2017",
        'Batch.deleted' => 0
      );    
    $batches1 = $this->Batch->find("all",array('conditions' => $cons));
      $cond = array(
      // 'OR' =>array('Batch.teachers_id' => "$id",
       'Batch.teachers_id LIKE' => "%,$id",                   
      'Batch.acadamic_year' => "2016-2017",
        'Batch.deleted' => 0
      );
      $batches2 = $this->Batch->find("all",array('conditions' => $cond));
      $batches = array_merge($batches1,$batches2);
      // $batches = array_unique($batches);
     foreach ($batches as $key => $value) {      
        $regstudents = $this->CrBatchMap->find("all",array('conditions'=>
                array( 'CrBatchMap.cl_batch_id' => $value['Batch']['id'],
                'CrBatchMap.deleted' => 0
          )));        
        foreach ($regstudents as $stud) {
          $student = $this->Student->findById($stud['CrBatchMap']['student_id']);
          $student['Student']['regdate'] = $stud['CrBatchMap']['created'];
          $students[$i] = $student;          
          $i++;
        }
     }
     // $students = array_unique($students);
     $this->set("json",json_encode($students));
   }

   public function admin_stud_batch($id){
    // $this->layout = 'default'; //this will use the pdf.ctp layout        
    $this->layout = 'pdf';
    $subjects = $this->Subjects->find("all");
    $teachers = $this->Teacher->find("all");
    $standards = $this->Standard->find("all");
    $teachers = $this->Teacher->find("all");      
      $locations = $this->Location->find("all");
      // $Parent_relationship = $this->ParentRelationship->find("all");
      $courses = $this->ClassroomCourse->find("all",array('conditions' => 
        array(//'ClassroomCourse.types' => 2,
          'ClassroomCourse.deleted' => 0)));
      
    $i=0;$j=0;
    $teacher = array();    
    $location = array();
    $user = $this->Student->findById($id);
    $con = array(
      'CrBatchMap.student_id' => $user['Student']['id'],
      'CrBatchMap.deleted' => 0
      );
    $student_batches = $this->CrBatchMap->find("all",array('conditions'=>$con));    
    foreach ($subjects as $key =>$sub) {
      $batche = array();
    $teacer = array();       
    $teachers_id=array();
         $conditions = array(
        "ClassroomCourse.deleted =" => 0,        
        "ClassroomCourse.subject =" => $sub['Subjects']['id']
        );
      $course = $this->ClassroomCourse->find("all", array('conditions' => $conditions));
     foreach ($course as $crs) {
    foreach ($student_batches as $schedule) {      
    $conditio = array(
        "Batch.deleted =" => 0,
        "Batch.acadamic_year" =>"2016-2017",
         "Batch.id =" => $schedule['CrBatchMap']['cl_batch_id'],
        "Batch.course_id =" => $crs['ClassroomCourse']['id']
        );      
      $batc=$this->Batch->find("all", array('conditions' => $conditio));      
      $batche = array_merge($batche,$batc);
     }}
     // error_log("batchid".print_r($batche,true));
     foreach ($batche as $key => $value) {  
        $teachers_id = explode(",", $value['Batch']['teachers_id']);
       $teacher = array_merge($teacher,$teachers_id);  
       $location[$j] = $value['Batch']['location'];
       $j++;
     }      
            $teacer =array_merge($teacer,$teacher);
            $batch[$i]['batches'] = $batche;       
        $batch[$i]['subject'] = $sub['Subjects']['name'];
       $i++;
    }
    
   $batch[$i]['teachers']=array_unique($teacer);
   $i++;
   $batch[$i]['location']=array_unique($location);        
    $email = $user['Student']['email']; 
    $parent_email = $user['Student']['parent_email']; 
      foreach ($standards as $std) {
      if($std['Standard']['id'] == $user['Student']['standard'])
          $stand = $std['Standard']['name'] ;
      }        
    $rawstring = "<div><img src='/var/ahaguru3/app/webroot/img/logo.png' height='80px' width='350px'></div>        
            <p>Please Confirm your profile and selection details.</p>
                  <p><b>Name </b>: names</p>
                  <p><b>Email </b>: emails</p>
                  <p><b>Class in School </b>: std</p>
                  <p><b>School Name </b>: school</p>                  
                  <p><b>Mobile </b>: mobiles</p>
                  <p><b>Parent Name </b>: parentname</p>
                  <p><b>Parent Email </b>: parentemail</p>
                  <p><b>Parent Mobile </b>: parent_mobile</p>
                  <br>
                  <p><b>Batch detail</b></p>
                  <table class='table table-bordered' style='border:1px solid #000000'>
                  <tr style='background-color:#c00000;'>
         <th style='text-align:center; color:#FFFFFF;padding:10px;border-right:1px solid #000000'>Batch</th>
        <th style='text-align:center; color:#FFFFFF;padding:10px;border-right:1px solid #000000'>Class</th>
        <th style='text-align:center; color:#FFFFFF;padding:10px;border-right:1px solid #000000'>Location</th>
        <th style='text-align:center; color:#FFFFFF;padding:10px;border-right:1px solid #000000'>Course Name</th>
        <th colspan='2' style='text-align:center; color:#FFFFFF;padding:10px;border-right:1px solid #000000'>Weekly Schedule</th>
        <th style='text-align:center; color:#FFFFFF;padding:10px;'>Teachers</th>
        </tr>tablecontent</table><br/>";
         $tablecontent="";                         
        foreach($batch as $key => $sch) {
        if(($key+1)%2 ==0){
            $color="#c9dba9";
            }else{
              $color="#acc87a";
              }
            foreach($sch['batches'] as $schedulebatch) {
        $batch = $this->Batch->findById($schedulebatch['Batch']['id']);
        $tablecontent .= "<tr style='background-color:$color;'><td style='text-align:center;border-right:1px solid #000000;padding:10px;'> ".$batch['Batch']['name']."</td>
        <td style='text-align:center;background-color:$color;border-right:1px solid #000000;padding:10px'> Std ";
        foreach($standards as $Standard){
          if($Standard['Standard']['id'] == $batch['Batch']['class']){
            $tablecontent .= $Standard['Standard']['name'];
          }}
          $tablecontent .="</td> <td style='text-align:center;border-right:1px solid #000000;padding:10px'>";
        foreach($locations as $loc){
          if($batch['Batch']['location'] == $loc['Location']['id']){
         $tablecontent .=$loc['Location']['name'] ;
         }}
         $tablecontent .="</td>
        <td style='text-align:center;border-right:1px solid #000000;padding:10px'>";
          foreach($courses as $course){
          if($batch['Batch']['course_id'] == $course['ClassroomCourse']['id']){
        $tablecontent .=$course['ClassroomCourse']['name'];
      }}
     $tablecontent .="</td>
       <td style='text-align:center;border-right:1px solid #000000;padding:10px'>".$batch['Batch']['schedule_day']."</td>
        <td style='text-align:center;border-right:1px solid #000000;padding:10px'>".$batch['Batch']['schedule_time']."</td>
        <td style='text-align:center;padding:10px'>";
         $teach = explode(',',$batch['Batch']['teachers_id']);
                foreach($teach as $tea){
                foreach($teachers as $teacher) { 
                if($teacher['Teacher']['id'] == $tea){
         $tablecontent .= $teacher['Teacher']['name'];
         if(sizeof($teach) > 1){
                      $tablecontent .= " , ";
                    }
                      
                     }}}
                     $tablecontent .= "</tr>";
         }}

$placeholders=array('names','emails','std','school','mobiles','parentname',
  'parentemail','parent_mobile','tablecontent');
$string=array($user['Student']['name'],$user['Student']['email'],$stand,$user['Student']['school_name'],
              $user['Student']['mobile_number'],$user['Student']['parent_name'],
              $user['Student']['parent_email'],$user['Student']['parent_mobile'],$tablecontent);
$rawstr = str_replace($placeholders, $string, $rawstring);
$html= stripslashes($rawstr);
 // echo $html; 
  $dompdf = new DOMPDF();
  $dompdf->load_html($html);    
  $dompdf->render();  
  $dompdf->stream($user['Student']['name'].".pdf");

}
}
