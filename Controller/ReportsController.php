<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class ReportsController extends AppController{
  public $name = "Reports";
  var $helpers = array('Excel');
  public $uses = array('RegisteredStudent','StudentTestScore','TestStudentDetail','StudentPaymentDetail','Test','StudentCourseMap','PromotionalCoupon','StandardCouponStudents','Student','DirectHinduPaid','QuizPaid','ThinkVidyaPaid','HinduRegisteredStudent','Concept','StudentConceptAttempt','StudentExerciseAttempt','StudentLessonSkip',
    'StudentTestAttempt','Exercise','Test','FaceBookPaid','CourseLessonMap','Lesson','LessonElementMap','StudentConceptAttempt','StudentExerciseAttempt','StudentTestAttempt','ClassroomRegisteredStudent','Standard','PromoCouponStudents','Course','CourseCouponMap','HinduStudent','HinduChallengeStudent','OnlinePaymentReport','ClassroomStudent2016');
     
  public function admin_index()
  {
    $this->layout = "ahaguru";
  } 
  
  public function admin_registeredstudents()
  {      
    $this->layout = "ahaguru";
  }
  
  public function admin_classroom_registeredstudents()
  {
    $this->layout = "ahaguru";
  }

  public function admin_promo_couponstudents()
  {
    $this->layout = "ahaguru";
  }

  public function admin_standard_couponstudents()
  {
    $this->layout = "ahaguru";
  }
      
  public function adata_registeredstudents()
  { 
    $student = $this->RegisteredStudent->find("all");             
    $this->set("json",json_encode($student));
  }
      
  public function admin_registeredstudents_list()
  {
    $this->layout = '';
    $registered_students=$this->RegisteredStudent->find("all");
    $this->set('registered_students', $registered_students); 
  }
       
  public function adata_classroom_registeredstudents()
  { 
    $student = $this->ClassroomRegisteredStudent->find("all");                
    $this->set("json",json_encode($student));
  }

  public function adata_promocoupon_students($crid,$coupid)
  { 
    $student = array();
    if($crid == 0 && $coupid == 0)
    {
     $student = $this->PromoCouponStudents->find("all");                
    }
    else if($crid == 0 && $coupid != 0){
      $couponcode = $this->PromotionalCoupon->find("first", 
        array('conditions' => array('PromotionalCoupon.id' => $coupid,'PromotionalCoupon.deleted' => 0)));
      $con = array(
        'PromoCouponStudents.comments LIKE' =>"%Promotional Code ".$couponcode['PromotionalCoupon']['coupon_code']."%",
      );
      $student = $this->PromoCouponStudents->find("all",array('conditions' => $con));                
    }
    else if($crid != 0 && $coupid == 0){
      $i=0;
      $couponcode = $this->PromotionalCoupon->find("all", 
        array('conditions' => array('PromotionalCoupon.course_id' => $crid,'PromotionalCoupon.deleted' => 0)));       
      $course = $this->Course->findById($crid);
      foreach ($couponcode as $code) {          
      $con = array(
        'PromoCouponStudents.comments LIKE' =>"%Promotional Code ".$code['PromotionalCoupon']['coupon_code']."%",
        'PromoCouponStudents.course =' => $course['Course']['name']
      );
         $students = $this->PromoCouponStudents->find("all",array('conditions' => $con));                    
       foreach ($students as $key => $value) {
        $student[$i] = $value;
        $i++;
       }       
      }
    }
    else if($crid != 0 && $coupid != 0){
      $i=0;
      $couponcode = $this->PromotionalCoupon->find("first", 
        array('conditions' => array('PromotionalCoupon.course_id' => $crid,'PromotionalCoupon.id' => $coupid,'PromotionalCoupon.deleted' => 0)));       
      $course = $this->Course->findById($crid);
      $con = array(
        'PromoCouponStudents.comments LIKE' =>"%Promotional Code ".$couponcode['PromotionalCoupon']['coupon_code']."%",
        'PromoCouponStudents.course =' => $course['Course']['name']
      );
       $students = $this->PromoCouponStudents->find("all",array('conditions' => $con));                  
       foreach ($students as $key => $value) {
        $student[$i] = $value;
        $i++;       
      }
    }
    $this->set("json",json_encode($student));
  }
   
  public function admin_promo_couponstudents_list()
  {
    $this->layout = '';
    $registered_students=$this->PromoCouponStudents->find("all");
    $this->set('registered_students', $registered_students); 
  }   

  public function adata_standardcoupon_students($crid)
  { 
    $student = array();
    if($crid == 0)
     $student = $this->StandardCouponStudents->find("all");                    
    else if($crid != 0){
      $i=0;
      $couponcode = $this->CourseCouponMap->find("all", 
       array('conditions' => array('CourseCouponMap.course_id' => $crid,'CourseCouponMap.deleted' => 0)));       
      $course = $this->Course->findById($crid);
      foreach ($couponcode as $code) {          
      $con = array(
        'StandardCouponStudents.comments =' =>"Added by couponcode ".$code['CourseCouponMap']['coupon_code'],
        'StandardCouponStudents.course =' => $course['Course']['name']
      );
         $students = $this->StandardCouponStudents->find("all",array('conditions' => $con));                    
       foreach ($students as $key => $value) {
        $student[$i] = $value;
        $i++;
       }       
      }
    }

    $this->set("json",json_encode($student));
  }
   
  public function admin_standard_couponstudents_list()
  {
    $this->layout = '';
    $registered_students=$this->StandardCouponStudents->find("all");
    $this->set('registered_students', $registered_students); 
  }   

  public function admin_classroom_registeredstudents_list()
  {
    $this->layout = '';
    $registered_students=$this->ClassroomRegisteredStudent->find("all");
    $standard = $this->Standard->find("all",array( 'order' => array('Standard.name' => 'DESC')));
    foreach ($registered_students as $key => $value) 
    {
      foreach ($standard as $std) 
      {
        if($std['Standard']['id'] == $value['ClassroomRegisteredStudent']['class'])
        {                
          $value['ClassroomRegisteredStudent']['class'] = $std['Standard']['name'];
          break;     
        }
      }
      $registered_student[$key] = $value;
    }
    // print_r($registered_student);
    $this->set('classroom_registered_students', $registered_student); 
  }

  public function admin_comprehensive_report()
  {
    $this->layout = "ahaguru";
  }

  public function admin_comprehensive_report_list()
  {
    $this->layout = "";
    $course =array();
    $courses = $this->Course->find("all",array('conditions'=>array('Course.deleted =' => 0,'Course.types =' =>1)));        
    foreach ($courses as $key => $value) {
      $course[$key]['Course']['name'] = $value['Course']['name'];
      /* Approved count */
      $appcount = $this->StudentCourseMap->find("all",array('conditions'=>
      array('StudentCourseMap.course_id =' => $value['Course']['id'],
          'StudentCourseMap.payment =' => 2,
        'StudentCourseMap.deleted =' => 0)));  
      $course[$key]['Course']['appcount'] = sizeof($appcount);
      /* UnApproved count */
      $unappcount = $this->StudentCourseMap->find("all",array('conditions'=>
      array('StudentCourseMap.course_id =' => $value['Course']['id'],
        'StudentCourseMap.payment =' => 1,
        'StudentCourseMap.deleted =' => 0)));  
      $course[$key]['Course']['unappcount'] = sizeof($unappcount);
      /* Online Payment count */
      $onlinepaycount = $this->StudentCourseMap->find("all",array('conditions'=>
      array('StudentCourseMap.course_id =' => $value['Course']['id'],        
        'StudentCourseMap.comments =' => "Online_Payment",
        'StudentCourseMap.deleted =' => 0)));  
      $course[$key]['Course']['onlinepaycount'] = sizeof($onlinepaycount);
      /* Coupon code count */
      $couponcount = $this->StudentCourseMap->find("all",array('conditions'=>
      array('StudentCourseMap.course_id =' => $value['Course']['id'],        
        'StudentCourseMap.comments LIKE' => "%Added by couponcode%",
        'StudentCourseMap.deleted =' => 0)));  
      $course[$key]['Course']['couponcount'] = sizeof($couponcount);
      /* Promotional Coupon code count */
      $promocouponcount = $this->StudentCourseMap->find("all",array('conditions'=>
      array('StudentCourseMap.course_id =' => $value['Course']['id'],        
        'StudentCourseMap.comments LIKE' => "%Promotional%",
        'StudentCourseMap.deleted =' => 0)));  
      $course[$key]['Course']['promocouponcount'] = sizeof($promocouponcount);
      /* Hindu Direct Online Payment */
      $hindudirectexistingpaid = $this->StudentCourseMap->find("all",array('conditions'=>
      array('StudentCourseMap.course_id =' => $value['Course']['id'],        
        'StudentCourseMap.comments LIKE' => "%hindu_direct%%Hindu Existing Student Online_Payment%",
        'StudentCourseMap.deleted =' => 0)));  
        $hindudirectnewpaid = $this->StudentCourseMap->find("all",array('conditions'=>
      array('StudentCourseMap.course_id =' => $value['Course']['id'],        
        'StudentCourseMap.comments LIKE' => "%hindu_direct%%Hindu New Student Online_Payment%",
        'StudentCourseMap.deleted =' => 0)));  
      $course[$key]['Course']['hindudirectpaid'] = sizeof($hindudirectexistingpaid) + sizeof($hindudirectnewpaid);
      /* thinkVidya Online Payment */
      $thinkvidyaexistingpaid = $this->StudentCourseMap->find("all",array('conditions'=>
      array('StudentCourseMap.course_id =' => $value['Course']['id'],        
        'StudentCourseMap.comments LIKE' => "%thinkvidya%%Hindu Existing Student Online_Payment%",
        'StudentCourseMap.deleted =' => 0)));  
      $thinkvidyanewpaid = $this->StudentCourseMap->find("all",array('conditions'=>
      array('StudentCourseMap.course_id =' => $value['Course']['id'],        
        'StudentCourseMap.comments LIKE' => "%thinkvidya%%Hindu New Student Online_Payment%",
        'StudentCourseMap.deleted =' => 0)));  
     $course[$key]['Course']['thinkvidyapaid'] = sizeof($thinkvidyaexistingpaid) + sizeof($thinkvidyanewpaid);
     /* Quiz Online Payment */
      $quizaexistingpaid = $this->StudentCourseMap->find("all",array('conditions'=>
      array('StudentCourseMap.course_id =' => $value['Course']['id'],        
        'StudentCourseMap.comments LIKE' => "%quiz%%Hindu Existing Student Online_Payment%",
        'StudentCourseMap.deleted =' => 0)));  
      $quiznewpaid = $this->StudentCourseMap->find("all",array('conditions'=>
      array('StudentCourseMap.course_id =' => $value['Course']['id'],        
        'StudentCourseMap.comments LIKE' => "%quiz%%Hindu New Student Online_Payment%",
        'StudentCourseMap.deleted =' => 0)));  
     $course[$key]['Course']['quizpaid'] = sizeof($quizaexistingpaid) + sizeof($quiznewpaid);
     /* Free Signup Online Payment */
      $freesignupexistingpaid = $this->StudentCourseMap->find("all",array('conditions'=>
      array('StudentCourseMap.course_id =' => $value['Course']['id'],        
        'StudentCourseMap.comments LIKE' => "%free_signup%%Hindu Existing Student Online_Payment%",
        'StudentCourseMap.deleted =' => 0)));  
      $freesignupnewpaid = $this->StudentCourseMap->find("all",array('conditions'=>
      array('StudentCourseMap.course_id =' => $value['Course']['id'],        
        'StudentCourseMap.comments LIKE' => "%free_signup%%Hindu New Student Online_Payment%",
        'StudentCourseMap.deleted =' => 0)));  
     $course[$key]['Course']['free_signuppaid'] = sizeof($freesignupexistingpaid) + sizeof($freesignupnewpaid);
    }

    $this->set("count",$course);
  }
      
// public function admin_comprehensive_report_list()
//   {
//     $this->layout = "";
//      $course =array();
//     $courses = $this->Course->find("all",array('conditions'=>array('Course.deleted =' => 0,'Course.types =' =>1)));        
//     $totalappcount=0;$totalunappcount=0;$totalonlinepaycount=0;$totalquizcount=0;$totalfreecount=0;
//     $totalcouponcount=0;$totalpromocount=0;$totalhindudirectcount=0;$totalthinkvidyacount=0;
//     foreach ($courses as $key => $value) {
//       $course[$key]['Course']['name'] = $value['Course']['name'];
//       /* Approved count */
//       $appcount = $this->StudentCourseMap->find("all",array('conditions'=>
//       array('StudentCourseMap.course_id =' => $value['Course']['id'],
//           'StudentCourseMap.payment =' => 2,
//         'StudentCourseMap.deleted =' => 0)));  
//       $course[$key]['Course']['appcount'] = sizeof($appcount);
//       $totalappcount +=sizeof($appcount);
//       /* UnApproved count */
//       $unappcount = $this->StudentCourseMap->find("all",array('conditions'=>
//       array('StudentCourseMap.course_id =' => $value['Course']['id'],
//         'StudentCourseMap.payment =' => 1,
//         'StudentCourseMap.deleted =' => 0)));  
//       $course[$key]['Course']['unappcount'] = sizeof($unappcount);
//       $totalunappcount +=sizeof($unappcount);
//       /* Online Payment count */
//       $onlinepaycount = $this->StudentCourseMap->find("all",array('conditions'=>
//       array('StudentCourseMap.course_id =' => $value['Course']['id'],        
//         'StudentCourseMap.comments =' => "Online_Payment",
//         'StudentCourseMap.deleted =' => 0)));  
//       $course[$key]['Course']['onlinepaycount'] = sizeof($onlinepaycount);
//       $totalonlinepaycount +=sizeof($onlinepaycount);
//       /* Coupon code count */
//       $couponcount = $this->StudentCourseMap->find("all",array('conditions'=>
//       array('StudentCourseMap.course_id =' => $value['Course']['id'],        
//         'StudentCourseMap.comments LIKE' => "%Added by couponcode%",
//         'StudentCourseMap.deleted =' => 0)));  
//       $course[$key]['Course']['couponcount'] = sizeof($couponcount);
//       $totalcouponcount +=sizeof($couponcount);
//       /* Promotional Coupon code count */
//       $promocouponcount = $this->StudentCourseMap->find("all",array('conditions'=>
//       array('StudentCourseMap.course_id =' => $value['Course']['id'],        
//         'StudentCourseMap.comments LIKE' => "%Promotional%",
//         'StudentCourseMap.deleted =' => 0)));  
//       $course[$key]['Course']['promocouponcount'] = sizeof($promocouponcount);
//       $totalpromocount +=sizeof($promocouponcount);
//       /* Hindu Direct Online Payment */
//       $hindudirectexistingpaid = $this->StudentCourseMap->find("all",array('conditions'=>
//       array('StudentCourseMap.course_id =' => $value['Course']['id'],        
//         'StudentCourseMap.comments LIKE' => "%hindu_direct%%Hindu Existing Student Online_Payment%",
//         'StudentCourseMap.deleted =' => 0)));  
//         $hindudirectnewpaid = $this->StudentCourseMap->find("all",array('conditions'=>
//       array('StudentCourseMap.course_id =' => $value['Course']['id'],        
//         'StudentCourseMap.comments LIKE' => "%hindu_direct%%Hindu New Student Online_Payment%",
//         'StudentCourseMap.deleted =' => 0)));  
//       $course[$key]['Course']['hindudirectpaid'] = sizeof($hindudirectexistingpaid) + sizeof($hindudirectnewpaid);
//       $totalhindudirectcount += sizeof($hindudirectexistingpaid) + sizeof($hindudirectnewpaid);
//       /* thinkVidya Online Payment */
//       $thinkvidyaexistingpaid = $this->StudentCourseMap->find("all",array('conditions'=>
//       array('StudentCourseMap.course_id =' => $value['Course']['id'],        
//         'StudentCourseMap.comments LIKE' => "%thinkvidya%%Hindu Existing Student Online_Payment%",
//         'StudentCourseMap.deleted =' => 0)));  
//       $thinkvidyanewpaid = $this->StudentCourseMap->find("all",array('conditions'=>
//       array('StudentCourseMap.course_id =' => $value['Course']['id'],        
//         'StudentCourseMap.comments LIKE' => "%thinkvidya%%Hindu New Student Online_Payment%",
//         'StudentCourseMap.deleted =' => 0)));  
//      $course[$key]['Course']['thinkvidyapaid'] = sizeof($thinkvidyaexistingpaid) + sizeof($thinkvidyanewpaid);
//        $totalthinkvidyacount += sizeof($thinkvidyaexistingpaid) + sizeof($thinkvidyanewpaid);
//      /* Quiz Online Payment */
//       $quizaexistingpaid = $this->StudentCourseMap->find("all",array('conditions'=>
//       array('StudentCourseMap.course_id =' => $value['Course']['id'],        
//         'StudentCourseMap.comments LIKE' => "%quiz%%Hindu Existing Student Online_Payment%",
//         'StudentCourseMap.deleted =' => 0)));  
//       $quiznewpaid = $this->StudentCourseMap->find("all",array('conditions'=>
//       array('StudentCourseMap.course_id =' => $value['Course']['id'],        
//         'StudentCourseMap.comments LIKE' => "%quiz%%Hindu New Student Online_Payment%",
//         'StudentCourseMap.deleted =' => 0)));  
//      $course[$key]['Course']['quizpaid'] = sizeof($quizaexistingpaid) + sizeof($quiznewpaid);
//      $totalquizcount += sizeof($quizaexistingpaid) + sizeof($quiznewpaid);
//      /* Free Signup Online Payment */
//       $freesignupexistingpaid = $this->StudentCourseMap->find("all",array('conditions'=>
//       array('StudentCourseMap.course_id =' => $value['Course']['id'],        
//         'StudentCourseMap.comments LIKE' => "%free_signup%%Hindu Existing Student Online_Payment%",
//         'StudentCourseMap.deleted =' => 0)));  
//       $freesignupnewpaid = $this->StudentCourseMap->find("all",array('conditions'=>
//       array('StudentCourseMap.course_id =' => $value['Course']['id'],        
//         'StudentCourseMap.comments LIKE' => "%free_signup%%Hindu New Student Online_Payment%",
//         'StudentCourseMap.deleted =' => 0)));  
//      $course[$key]['Course']['free_signuppaid'] = sizeof($freesignupexistingpaid) + sizeof($freesignupnewpaid);
//      $totalfreecount +=sizeof($freesignupexistingpaid) + sizeof($freesignupnewpaid);
//     }     
//     $studentcoursecount['Course']=$course;
//     $studentcoursecount['totalappcount'] = $totalappcount;
//     $studentcoursecount['totalunappcount'] = $totalunappcount;
//     $studentcoursecount['totalcouponcount'] = $totalcouponcount;
//     $studentcoursecount['totalpromocount'] = $totalpromocount;
//     $studentcoursecount['totalonlinepaycount'] = $totalonlinepaycount;
//     $studentcoursecount['totalhindudirectcount'] = $totalhindudirectcount;
//     $studentcoursecount['totalthinkvidyacount'] = $totalthinkvidyacount;
//     $studentcoursecount['totalquizcount'] = $totalquizcount;
//     $studentcoursecount['totalfreecount'] = $totalfreecount;
//     $totalnocourse = $this->Student->getunmappedstudent();
//     $studentcoursecount['totalnocourse'] = sizeof($totalnocourse);
//     $totalstudcount = $this->Student->find("all",array('conditions' => array('Student.deleted =' => 0)));
//     $studentcoursecount['totalstudcount'] = sizeof($totalstudcount);
//     $studentcoursecount['totalhindudirectvisited'] = $this->HinduChallengeStudent->gethindudirectvisited();
//     $studentcoursecount['totalquizvisited'] = $this->HinduChallengeStudent->getquizvisited();
//     $studentcoursecount['totalthinkvidyavisited'] = $this->HinduChallengeStudent->getthinkvidyavisited();    
//     $this->set("count",$studentcoursecount);
//   }
  
  public function adata_comprehensive_report()
  {
    $course =array();
    $courses = $this->Course->find("all",array('conditions'=>array('Course.deleted =' => 0,'Course.types =' =>1)));        
    $totalappcount=0;$totalunappcount=0;$totalonlinepaycount=0;$totalquizcount=0;$totalfreecount=0;
    $totalcouponcount=0;$totalpromocount=0;$totalhindudirectcount=0;$totalthinkvidyacount=0;
    foreach ($courses as $key => $value) {
      $course[$key]['Course']['name'] = $value['Course']['name'];
      /* Approved count */
      $appcount = $this->StudentCourseMap->find("all",array('conditions'=>
      array('StudentCourseMap.course_id =' => $value['Course']['id'],
          'StudentCourseMap.payment =' => 2,
        'StudentCourseMap.deleted =' => 0)));  
      $course[$key]['Course']['appcount'] = sizeof($appcount);
      $totalappcount +=sizeof($appcount);
      /* UnApproved count */
      $unappcount = $this->StudentCourseMap->find("all",array('conditions'=>
      array('StudentCourseMap.course_id =' => $value['Course']['id'],
        'StudentCourseMap.payment =' => 1,
        'StudentCourseMap.deleted =' => 0)));  
      $course[$key]['Course']['unappcount'] = sizeof($unappcount);
      $totalunappcount +=sizeof($unappcount);
      /* Online Payment count */
      $onlinepaycount = $this->StudentCourseMap->find("all",array('conditions'=>
      array('StudentCourseMap.course_id =' => $value['Course']['id'],        
          'OR' => array('StudentCourseMap.comments LIKE' => "Online_Payment,%",
            'StudentCourseMap.comments =' => "Online_Payment"),
        'StudentCourseMap.deleted =' => 0)));  
      $course[$key]['Course']['onlinepaycount'] = sizeof($onlinepaycount);
      $totalonlinepaycount +=sizeof($onlinepaycount);
      /* Coupon code count */
      $couponcount = $this->StudentCourseMap->find("all",array('conditions'=>
      array('StudentCourseMap.course_id =' => $value['Course']['id'],        
        'StudentCourseMap.comments LIKE' => "%Added by couponcode%",
        'StudentCourseMap.deleted =' => 0)));  
      $course[$key]['Course']['couponcount'] = sizeof($couponcount);
      $totalcouponcount +=sizeof($couponcount);
      /* Promotional Coupon code count */
      $promocouponcount = $this->StudentCourseMap->find("all",array('conditions'=>
      array('StudentCourseMap.course_id =' => $value['Course']['id'],        
        'StudentCourseMap.comments LIKE' => "%Promotional%",
        'StudentCourseMap.deleted =' => 0)));  
      $course[$key]['Course']['promocouponcount'] = sizeof($promocouponcount);
      $totalpromocount +=sizeof($promocouponcount);
      /* Hindu Direct Online Payment */
      $hindudirectexistingpaid = $this->StudentCourseMap->find("all",array('conditions'=>
      array('StudentCourseMap.course_id =' => $value['Course']['id'],        
        'StudentCourseMap.comments LIKE' => "%hindu_direct%%Hindu Existing Student Online_Payment%",
        'StudentCourseMap.deleted =' => 0)));  
        $hindudirectnewpaid = $this->StudentCourseMap->find("all",array('conditions'=>
      array('StudentCourseMap.course_id =' => $value['Course']['id'],        
        'StudentCourseMap.comments LIKE' => "%hindu_direct%%Hindu New Student Online_Payment%",
        'StudentCourseMap.deleted =' => 0)));  
      $course[$key]['Course']['hindudirectpaid'] = sizeof($hindudirectexistingpaid) + sizeof($hindudirectnewpaid);
      $totalhindudirectcount += sizeof($hindudirectexistingpaid) + sizeof($hindudirectnewpaid);
      /* thinkVidya Online Payment */
      $thinkvidyaexistingpaid = $this->StudentCourseMap->find("all",array('conditions'=>
      array('StudentCourseMap.course_id =' => $value['Course']['id'],        
        'StudentCourseMap.comments LIKE' => "%thinkvidya%%Hindu Existing Student Online_Payment%",
        'StudentCourseMap.deleted =' => 0)));  
      $thinkvidyanewpaid = $this->StudentCourseMap->find("all",array('conditions'=>
      array('StudentCourseMap.course_id =' => $value['Course']['id'],        
        'StudentCourseMap.comments LIKE' => "%thinkvidya%%Hindu New Student Online_Payment%",
        'StudentCourseMap.deleted =' => 0)));  
     $course[$key]['Course']['thinkvidyapaid'] = sizeof($thinkvidyaexistingpaid) + sizeof($thinkvidyanewpaid);
       $totalthinkvidyacount += sizeof($thinkvidyaexistingpaid) + sizeof($thinkvidyanewpaid);
     /* Quiz Online Payment */
      $quizaexistingpaid = $this->StudentCourseMap->find("all",array('conditions'=>
      array('StudentCourseMap.course_id =' => $value['Course']['id'],        
        'StudentCourseMap.comments LIKE' => "%quiz%%Hindu Existing Student Online_Payment%",
        'StudentCourseMap.deleted =' => 0)));  
      $quiznewpaid = $this->StudentCourseMap->find("all",array('conditions'=>
      array('StudentCourseMap.course_id =' => $value['Course']['id'],        
        'StudentCourseMap.comments LIKE' => "%quiz%%Hindu New Student Online_Payment%",
        'StudentCourseMap.deleted =' => 0)));  
     $course[$key]['Course']['quizpaid'] = sizeof($quizaexistingpaid) + sizeof($quiznewpaid);
     $totalquizcount += sizeof($quizaexistingpaid) + sizeof($quiznewpaid);
     /* Free Signup Online Payment */
      $freesignupexistingpaid = $this->StudentCourseMap->find("all",array('conditions'=>
      array('StudentCourseMap.course_id =' => $value['Course']['id'],        
        'StudentCourseMap.comments LIKE' => "%free_signup%%Hindu Existing Student Online_Payment%",
        'StudentCourseMap.deleted =' => 0)));  
      $freesignupnewpaid = $this->StudentCourseMap->find("all",array('conditions'=>
      array('StudentCourseMap.course_id =' => $value['Course']['id'],        
        'StudentCourseMap.comments LIKE' => "%free_signup%%Hindu New Student Online_Payment%",
        'StudentCourseMap.deleted =' => 0)));  
     $course[$key]['Course']['free_signuppaid'] = sizeof($freesignupexistingpaid) + sizeof($freesignupnewpaid);
     $totalfreecount +=sizeof($freesignupexistingpaid) + sizeof($freesignupnewpaid);
    }     
    $studentcoursecount['Course']=$course;
    $studentcoursecount['totalappcount'] = $totalappcount;
    $studentcoursecount['totalunappcount'] = $totalunappcount;
    $studentcoursecount['totalcouponcount'] = $totalcouponcount;
    $studentcoursecount['totalpromocount'] = $totalpromocount;
    $studentcoursecount['totalonlinepaycount'] = $totalonlinepaycount;
    $studentcoursecount['totalhindudirectcount'] = $totalhindudirectcount;
    $studentcoursecount['totalthinkvidyacount'] = $totalthinkvidyacount;
    $studentcoursecount['totalquizcount'] = $totalquizcount;
    $studentcoursecount['totalfreecount'] = $totalfreecount;
    $totalnocourse = $this->Student->getunmappedstudent();
    $studentcoursecount['totalnocourse'] = sizeof($totalnocourse);
    $totalstudcount = $this->Student->find("all",array('conditions' => array('Student.deleted =' => 0)));
    $studentcoursecount['totalstudcount'] = sizeof($totalstudcount);
    $studentcoursecount['totalhindudirectvisited'] = $this->HinduChallengeStudent->gethindudirectvisitedcount();
    $studentcoursecount['totalquizvisited'] = $this->HinduChallengeStudent->getquizvisitedcount();
    $studentcoursecount['totalthinkvidyavisited'] = $this->HinduChallengeStudent->getthinkvidyavisitedcount();
    $this->set("json",json_encode($studentcoursecount));
  }

  public function admin_hindu_reports()
  {
    $this->layout = "ahaguru";
  } 

  public function admin_directhindu(){
    $this->layout = "ahaguru";
  }

  public function adata_directhindu(){
    $student = $this->DirectHinduPaid->find("all");             
    $this->set("json",json_encode($student));
  }

  public function admin_directhindu_list(){
    $this->layout = '';
    $registered_students=$this->DirectHinduPaid->find("all");
    $this->set('registered_students', $registered_students); 
  }

  public function admin_directhindu_visited(){
    $this->layout = "ahaguru";
  }

  public function adata_directhindu_visited(){
    $students = $this->HinduChallengeStudent->gethindudirectvisited();    
    $this->set("json",json_encode($students));
  }

  public function admin_directhindu_visited_list(){
   $this->layout = '';
    $students = $this->HinduChallengeStudent->gethindudirectvisited();        
    $this->set('visited_students', $students); 
  }

  public function admin_quiz(){
   $this->layout = "ahaguru"; 
  }

  public function adata_quiz(){
    $student = $this->QuizPaid->find("all");             
    $this->set("json",json_encode($student));
  }

  public function admin_quiz_list(){
     $this->layout = '';
    $registered_students=$this->QuizPaid->find("all");
    $this->set('registered_students', $registered_students); 
  }

  public function admin_quiz_visited(){
   $this->layout = "ahaguru"; 
  }

  public function adata_quiz_visited(){
    $students = $this->HinduChallengeStudent->getquizvisited();
    $this->set("json",json_encode($students));
  }


  public function admin_quiz_visited_list(){   
   $this->layout = '';
    $students = $this->HinduChallengeStudent->getquizvisited();    
    $this->set('visited_students', $students); 
  }
  

  public function admin_thinkvidya_visited(){
   $this->layout = "ahaguru"; 
  }

  public function adata_thinkvidya_visited(){
    $students = $this->HinduChallengeStudent->getthinkvidyavisited();
    $this->set("json",json_encode($students));
  }

  public function admin_thinkvidya_visited_list(){
   
   $this->layout = '';
    $students = $this->HinduChallengeStudent->getthinkvidyavisited();    
    $this->set('visited_students', $students); 
  }

  public function admin_thinkvidya(){
   $this->layout = "ahaguru"; 
  }

  public function adata_thinkvidya(){
    $student = $this->ThinkVidyaPaid->find("all");             
    $this->set("json",json_encode($student));
  }

  public function admin_thinkvidya_list(){
     $this->layout = '';
    $registered_students=$this->ThinkVidyaPaid->find("all");
    $this->set('registered_students', $registered_students); 
  }

    public function admin_facebook_visited(){
   $this->layout = "ahaguru"; 
  }

  public function adata_facebook_visited(){
    $students = $this->HinduChallengeStudent->getfacebookvisited();
    $this->set("json",json_encode($students));
  }

  public function admin_facebook_visited_list(){
   
   $this->layout = '';
    $students = $this->HinduChallengeStudent->getfacebookvisited();    
    $this->set('visited_students', $students); 
  }

  public function admin_facebook(){
   $this->layout = "ahaguru"; 
  }

  public function adata_facebook(){
    $student = $this->FaceBookPaid->find("all");             
    $this->set("json",json_encode($student));
  }

  public function admin_facebook_list(){
     $this->layout = '';
    $registered_students=$this->FaceBookPaid->find("all");
    $this->set('registered_students', $registered_students); 
  }

  public function admin_online_report(){
    $this->layout = "ahaguru"; 
  }

  public function adata_online_report(){
   $student = $this->OnlinePaymentReport->find("all");             
   // foreach ($student as $key => $value) {
   //  $cour = "";
   //   $courses = split(',',$value['OnlinePaymentReport']['course']);
   //   foreach ($courses as $crs) {
   //     $crses = $this->Course->findById($crs);
   //     if($cour != "")
   //     $cour .=",".$crses['Course']['name'];
   //    else
   //    $cour .=$crses['Course']['name'];
   //   }     
   //   $value['OnlinePaymentReport']['course'] = $cour;
   //   $student[$key] = $value;
   // }         
    $this->set("json",json_encode($student)); 
  }

  public function admin_online_report_list(){
       $this->layout = '';
   $student = $this->OnlinePaymentReport->find("all");             
   // foreach ($student as $key => $value) {
   //  $cour = "";
   //   $courses = split(',',$value['OnlinePaymentReport']['course']);
   //   foreach ($courses as $crs) {
   //     $crses = $this->Course->findById($crs);
   //     if($cour != "")
   //     $cour .=",".$crses['Course']['name'];
   //    else
   //    $cour .=$crses['Course']['name'];
   //   }     
   //   $value['OnlinePaymentReport']['course'] = $cour;
   //   $student[$key] = $value;
   // }         
    $this->set("students",$student); 
  }
  public function admin_course_completion(){
    $this->layout = 'ahaguru';
  }

  public function adata_course_completion(){    
    $course =array();
    $courses = $this->Course->find("all",array('conditions'=>array('Course.deleted =' => 0,'Course.types =' =>1,
        'Course.course_visibility =' => 1 )));          
    foreach ($courses as $key => $value) {
      $studcoursemap = $this->StudentCourseMap->find("all",array('conditions' =>
        array('StudentCourseMap.course_id =' => $value['Course']['id'],
          'StudentCourseMap.payment =' => 2,'StudentCourseMap.deleted =' =>0)));

      $course[$key]['Course']['name'] = $value['Course']['name'];
      $course[$key]['Course']['approvedcount'] = sizeof($studcoursemap);
      $con = array(
        'CourseLessonMap.course_id =' => $value['Course']['id'],
        'CourseLessonMap.deleted =' => 0,
        'CourseLessonMap.srno !=' => 0,        
         );      
       $lessons = $this->CourseLessonMap->find("all",array('conditions'=>$con,'order' => array('CourseLessonMap.srno' => 'ASC')));      
      if(empty($lessons)){
        $con = array(
        'CourseLessonMap.course_id =' => $value['Course']['id'],
        'CourseLessonMap.deleted =' => 0,              
        );      
      $lessons = $this->CourseLessonMap->find("all",array('conditions'=>$con,'order' => array('CourseLessonMap.published_date' => 'ASC')));
      }    
      foreach ($lessons as $keys => $less) {
        $lesson = $this->Lesson->findById($less['CourseLessonMap']['lesson_id']);
        $course[$key]['Course']['Lessons'][$keys]['Lesson']['name'] = $lesson['Lesson']['name'];
        $elements = $this->LessonElementMap->find("all",array('conditions'=> array(
          'LessonElementMap.lesson_id ='=> $less['CourseLessonMap']['lesson_id'],
          'LessonElementMap.deleted =' => 0)));
        foreach ($elements as $elem){          
           if($elem['LessonElementMap']['element_type'] == 2){
             $conditions = array(           
                'StudentConceptAttempt.element_id =' => $elem['LessonElementMap']['element_id'],
                'StudentConceptAttempt.status =' => 2,
                'StudentConceptAttempt.deleted =' => 0
               );
            $studentcnptattempt = $this->StudentConceptAttempt->find("all", array('conditions' => $conditions,'fields' =>array('student_id')));            
           }
           else if($elem['LessonElementMap']['element_type'] == 3){          
                 $conditions = array(              
                'StudentExerciseAttempt.element_id =' => $elem['LessonElementMap']['element_id'],
                'StudentExerciseAttempt.status =' => 2,
                'StudentExerciseAttempt.deleted =' => 0
               );
               $studentexeattempt = $this->StudentExerciseAttempt->find("all", array('conditions' => $conditions,'fields' => array('student_id')));   
           }
            else if($elem['LessonElementMap']['element_type'] == 1){
              $conditions = array(        
                'StudentTestAttempt.test_id =' => $elem['LessonElementMap']['element_id'],
                'StudentTestAttempt.status =' => 2,
                'StudentTestAttempt.deleted =' => 0
               );
               $studenttestattempt = $this->StudentTestAttempt->find("all", array('conditions' => $conditions,'fields' => array('student_id')));               
           }
        }
        
        // $flat = call_user_func_array('array_merge', $studentcnptattempt);
        $studentcnptattempt = iterator_to_array(new RecursiveIteratorIterator(new RecursiveArrayIterator($studentcnptattempt)), 0);        
        $studentexeattempt = iterator_to_array(new RecursiveIteratorIterator(new RecursiveArrayIterator($studentexeattempt)), 0);        
        $totalcompletioncount = array_intersect($studentcnptattempt,$studentexeattempt);                
        $course[$key]['Course']['Lessons'][$keys]['Lesson']['completed'] = sizeof($totalcompletioncount);
      }
    }
    $this->set("json",json_encode($course));
  }


  public function admin_course_completion_list(){
    $this->layout = '';
  }

  public function admin_lesson_completion_list($lesscount){
    $this->layout = '';
$lesson_completed = $this->StudentLessonSkip->query("select group_concat(student_id separator ',') as student_id from student_lessons_skip where skip_lessons >=". $lesscount." and course_id in (2,14,5,35)");
  $ids = $lesson_completed[0][0]['student_id'];
  $hindu_reg_students = $this->HinduRegisteredStudent->query("select * from hindu_registered_students where student_id in(".$ids.")");
    $count = 0;        
     foreach ($hindu_reg_students as $key => $stud) {
      $stud_less_completion = 0;
      $student_id = $stud['hindu_registered_students']['student_id'];
       $courses = $this->StudentCourseMap->gethinducourse($stud['hindu_registered_students']['student_id']);
        foreach ($courses as $course) {                 
          $completed = 0;$les=0;$z=0;
            $course_id = $course['StudentCourseMap']['course_id'];
         $lessons_mapped = $this->CourseLessonMap->find("all",array('conditions' =>
          array('CourseLessonMap.course_id =' => $course_id,
              'CourseLessonMap.deleted =' => 0)));                                          
         if(!empty($lessons_mapped))
         {                     
            foreach($lessons_mapped as $lesson_mapped)
             {              
               $lesson = $this->Lesson->findById($lesson_mapped['CourseLessonMap']['lesson_id']);               
                     $testcount = 0;
               $cnptcount = 0;     $exercount = 0;              
                   $conditions = array(
              'LessonElementMap.lesson_id =' => $lesson['Lesson']['id'],
              'LessonElementMap.deleted =' => 0
            );
             $elements = $this->LessonElementMap->find("all", array('conditions' => $conditions));                
                foreach ($elements as $elem){
              if($elem['LessonElementMap']['element_type'] == 1){
                $tests = $this->Test->findById($elem['LessonElementMap']['element_id']);
                if($tests['Test']['questions'] != ""){
                 $conditions = array(
                'StudentTestAttempt.student_id =' => $student_id,
                'StudentTestAttempt.test_id =' => $tests['Test']['id'],
                'StudentTestAttempt.status =' => 2,
                'StudentTestAttempt.deleted =' => 0
               );
               $studenttestattempt = $this->StudentTestAttempt->find("first", array('conditions' => $conditions));
              if(!empty($studenttestattempt)){
                $testattempts[$testcount] = $studenttestattempt;
                 $testcount ++;
                 }}
               else{
                   $testcount ++;
                   }
              }else  if($elem['LessonElementMap']['element_type'] == 2){
                $concept = $this->Concept->findById($elem['LessonElementMap']['element_id']);
                if($concept['Concept']['slides'] != ""){
                 $conditions = array(
                'StudentConceptAttempt.student_id =' => $student_id,
                'StudentConceptAttempt.element_id =' => $concept['Concept']['id'],
                'StudentConceptAttempt.status =' => 2,
                'StudentConceptAttempt.deleted =' => 0
               );
               $studentcnptattempt = $this->StudentConceptAttempt->find("first", array('conditions' => $conditions));
              if(!empty($studentcnptattempt)){
                $cnptattempts[$cnptcount] = $studentcnptattempt;
                 $cnptcount ++;
                 }}
               else{
                   $cnptcount ++;
                   }
                 
             }else  if($elem['LessonElementMap']['element_type'] == 3){
                     $exe = $this->Exercise->findById($elem['LessonElementMap']['element_id']);
                if($exe['Exercise']['slides'] != ""){
                 $conditions = array(
                'StudentExerciseAttempt.student_id =' => $student_id,
                'StudentExerciseAttempt.element_id =' => $exe['Exercise']['id'],
                'StudentExerciseAttempt.status =' => 2,
                'StudentExerciseAttempt.deleted =' => 0
               );
               $studentexeattempt = $this->StudentExerciseAttempt->find("first", array('conditions' => $conditions));
              if(!empty($studentexeattempt)){
                $exerattempts[$exercount] = $studentexeattempt;
                 $exercount ++;
                 }}
               else{
                   $exercount ++;
                   }}
                 }                                 
           if(($testcount + $exercount + $cnptcount) == count($elements))
              $completed ++;               
                }
       }         
      $stud_less_completion += $completed;
    }
      if($stud_less_completion  >= $lesscount){    
        unset($stud['hindu_registered_students']['student_id']);
       $student[$count] = $stud;
    $count++;
  }
   }      
    $this->set("students",$student); 
  }

  public function admin_lesson_completion(){
    $this->layout = 'ahaguru';
  }

  public function adata_lesson_completion($lesscount){
  $lesson_completed = $this->StudentLessonSkip->query("select group_concat(student_id separator ',') as student_id from student_lessons_skip where skip_lessons >=". $lesscount." and course_id in (2,14,5,35)");
  $ids = $lesson_completed[0][0]['student_id'];
  $hindu_reg_students = $this->HinduRegisteredStudent->query("select * from hindu_registered_students where student_id in(".$ids.")");
    $count = 0;        
     foreach ($hindu_reg_students as $key => $stud) {
      $stud_less_completion = 0;
      $student_id = $stud['hindu_registered_students']['student_id'];
       $courses = $this->StudentCourseMap->gethinducourse($stud['hindu_registered_students']['student_id']);
        foreach ($courses as $course) {                 
          $completed = 0;$les=0;$z=0;
            $course_id = $course['StudentCourseMap']['course_id'];
         $lessons_mapped = $this->CourseLessonMap->find("all",array('conditions' =>
          array('CourseLessonMap.course_id =' => $course_id,
              'CourseLessonMap.deleted =' => 0)));                                          
         if(!empty($lessons_mapped))
         {                     
            foreach($lessons_mapped as $lesson_mapped)
             {              
               $lesson = $this->Lesson->findById($lesson_mapped['CourseLessonMap']['lesson_id']);               
                     $testcount = 0;
               $cnptcount = 0;     $exercount = 0;              
                   $conditions = array(
              'LessonElementMap.lesson_id =' => $lesson['Lesson']['id'],
              'LessonElementMap.deleted =' => 0
            );
             $elements = $this->LessonElementMap->find("all", array('conditions' => $conditions));                
                foreach ($elements as $elem){
              if($elem['LessonElementMap']['element_type'] == 1){
                $tests = $this->Test->findById($elem['LessonElementMap']['element_id']);
                if($tests['Test']['questions'] != ""){
                 $conditions = array(
                'StudentTestAttempt.student_id =' => $student_id,
                'StudentTestAttempt.test_id =' => $tests['Test']['id'],
                'StudentTestAttempt.status =' => 2,
                'StudentTestAttempt.deleted =' => 0
               );
               $studenttestattempt = $this->StudentTestAttempt->find("first", array('conditions' => $conditions));
              if(!empty($studenttestattempt)){
                $testattempts[$testcount] = $studenttestattempt;
                 $testcount ++;
                 }}
               else{
                   $testcount ++;
                   }
              }else  if($elem['LessonElementMap']['element_type'] == 2){
                $concept = $this->Concept->findById($elem['LessonElementMap']['element_id']);
                if($concept['Concept']['slides'] != ""){
                 $conditions = array(
                'StudentConceptAttempt.student_id =' => $student_id,
                'StudentConceptAttempt.element_id =' => $concept['Concept']['id'],
                'StudentConceptAttempt.status =' => 2,
                'StudentConceptAttempt.deleted =' => 0
               );
               $studentcnptattempt = $this->StudentConceptAttempt->find("first", array('conditions' => $conditions));
              if(!empty($studentcnptattempt)){
                $cnptattempts[$cnptcount] = $studentcnptattempt;
                 $cnptcount ++;
                 }}
               else{
                   $cnptcount ++;
                   }
                 
             }else  if($elem['LessonElementMap']['element_type'] == 3){
                     $exe = $this->Exercise->findById($elem['LessonElementMap']['element_id']);
                if($exe['Exercise']['slides'] != ""){
                 $conditions = array(
                'StudentExerciseAttempt.student_id =' => $student_id,
                'StudentExerciseAttempt.element_id =' => $exe['Exercise']['id'],
                'StudentExerciseAttempt.status =' => 2,
                'StudentExerciseAttempt.deleted =' => 0
               );
               $studentexeattempt = $this->StudentExerciseAttempt->find("first", array('conditions' => $conditions));
              if(!empty($studentexeattempt)){
                $exerattempts[$exercount] = $studentexeattempt;
                 $exercount ++;
                 }}
               else{
                   $exercount ++;
                   }}
                 }                                 
           if(($testcount + $exercount + $cnptcount) == count($elements))
              $completed ++;               
                }
       }         
      $stud_less_completion += $completed;
    }
      if($stud_less_completion  >= $lesscount){    
       $student[$count] = $stud;
    $count++;
  }
   }   
       $this->set("json",json_encode($student));
}


public function admin_student_course_completion(){
    $this->layout = 'ahaguru';
  }

  public function adata_student_course_completion($id){    
    $this->layout = 'default';
    $course_completion =array();
    $lesscomp = 0;
    
    $students = $this->StudentCourseMap->find("all",array('conditions' => 
      array('StudentCourseMap.challenge_type' => 'PC1',
         'StudentCourseMap.comments LIKE' => '%hindu%,%Payment%',
         'StudentCourseMap.comments NOT LIKE' => "%Aug%",
         'StudentCourseMap.course_id' => $id,
         'StudentCourseMap.deleted' =>0 ),'group' => 'StudentCourseMap.student_id'));    
            // print_r($students);
         foreach ($students as $key => $value) {         
            $lesscomp = 0;
           $stud = $this->Student->find("first",array('conditions' => 
            array(
              'Student.id' =>$value['StudentCourseMap']['student_id'],
              'Student.deleted' =>0)));
           if(!empty($stud)){
           $course_completion[$key] = $stud;      
              $course = $this->Course->find("first",array('conditions'=>
                array('Course.id'=>$value['StudentCourseMap']['course_id'],
                  'Course.deleted =' => 0 )));                             
            $course_completion[$key]['Course']['name'] = $course['Course']['name'];
               $con = array(
                'CourseLessonMap.course_id =' => $course['Course']['id'],
                'CourseLessonMap.deleted =' => 0,
                'CourseLessonMap.srno !=' => 0,        
                 );      
               $lessons = $this->CourseLessonMap->find("all",array('conditions'=>$con,'order' => array('CourseLessonMap.srno' => 'ASC')));              
               if(empty($lessons)){
                $con = array(
              'CourseLessonMap.course_id =' => $course['Course']['id'],
              'CourseLessonMap.deleted =' => 0,              
              );      
              $lessons = $this->CourseLessonMap->find("all",array('conditions'=>$con,'order' => array('CourseLessonMap.published_date' => 'ASC')));
            }                         
             $course_completion[$key]['Course']['total_lesson'] = count($lessons);
            foreach ($lessons as $keys => $less) {
              $cnptcount=0;$exercount=0;$testcount=0;      
        $elements = $this->LessonElementMap->find("all",array('conditions'=> array(
          'LessonElementMap.lesson_id ='=> $less['CourseLessonMap']['lesson_id'],
          'LessonElementMap.deleted =' => 0)));          
        ini_set('max_execution_time', 300);
        foreach ($elements as $elem){          
        //   // print_r($elem);
           if($elem['LessonElementMap']['element_type'] == 2){
             $conditions = array(           
                'StudentConceptAttempt.element_id =' => $elem['LessonElementMap']['element_id'],
                'StudentConceptAttempt.status =' => 2,
                'StudentConceptAttempt.deleted =' => 0,
                'StudentConceptAttempt.student_id =' =>$value['StudentCourseMap']['student_id']
               );
            $studentcnptattempt = $this->StudentConceptAttempt->find("first", array('conditions' => $conditions));                   
            if(!empty($studentcnptattempt))
              $cnptcount++;
            else
              break;
           }
           else if($elem['LessonElementMap']['element_type'] == 3){          
                 $conditions = array(              
                'StudentExerciseAttempt.element_id =' => $elem['LessonElementMap']['element_id'],
                'StudentExerciseAttempt.status =' => 2,
                'StudentExerciseAttempt.deleted =' => 0,
                'StudentExerciseAttempt.student_id =' =>$value['StudentCourseMap']['student_id']
               );
               $studentexeattempt = $this->StudentExerciseAttempt->find("first", array('conditions' => $conditions));               
               if(!empty($studentexeattempt))
                  $exercount++;
              else
                break;
           }
            else if($elem['LessonElementMap']['element_type'] == 1){
              $conditions = array(        
                'StudentTestAttempt.test_id =' => $elem['LessonElementMap']['element_id'],
                'StudentTestAttempt.status =' => 2,
                'StudentTestAttempt.student_id =' =>$value['StudentCourseMap']['student_id'],
                'StudentTestAttempt.deleted =' => 0
               );
               $studenttestattempt = $this->StudentTestAttempt->find("first", array('conditions' => $conditions));               
               if(!empty($studenttestattempt))
                  $testcount++;
              else
                break;
           }

        }
          if($cnptcount+$exercount+$testcount == count($elements))
            $lesscomp++;
        // $flat = call_user_func_array('array_merge', $studentcnptattempt);
        // $studentcnptattempt = iterator_to_array(new RecursiveIteratorIterator(new RecursiveArrayIterator($studentcnptattempt)), 0);        
        // $studentexeattempt = iterator_to_array(new RecursiveIteratorIterator(new RecursiveArrayIterator($studentexeattempt)), 0);        
        // $totalcompletioncount = array_intersect($studentcnptattempt,$studentexeattempt);                
        $course_completion[$key]['Course']['lesson_completed'] = $lesscomp;       
      }    
          }
             }      
    
       $this->set("json",json_encode($course_completion));
  }


  public function admin_student_course_completion_list($id){
    $this->layout = '';
    $course_completion =array();
    $lesscomp = 0;
     error_log("ssd".$id);
    $students = $this->StudentCourseMap->find("all",array('conditions' => 
      array('StudentCourseMap.challenge_type' => 'PC1',
         'StudentCourseMap.comments LIKE' => '%hindu%,%Payment%',
         'StudentCourseMap.comments NOT LIKE' => "%Aug%",
         'StudentCourseMap.course_id' => $id,
         'StudentCourseMap.deleted' =>0 ),'group' => 'StudentCourseMap.student_id'));    
            // print_r($students);
         foreach ($students as $key => $value) {         
            $lesscomp = 0;
           $stud = $this->Student->find("first",array('conditions' => 
            array(
              'Student.id' =>$value['StudentCourseMap']['student_id'],
              'Student.deleted' =>0)));
           if(!empty($stud)){
           $course_completion[$key] = $stud;      
              $course = $this->Course->find("first",array('conditions'=>
                array('Course.id'=>$value['StudentCourseMap']['course_id'],
                  'Course.deleted =' => 0 )));                             
            $course_completion[$key]['Course']['name'] = $course['Course']['name'];
               $con = array(
                'CourseLessonMap.course_id =' => $course['Course']['id'],
                'CourseLessonMap.deleted =' => 0,
                'CourseLessonMap.srno !=' => 0,        
                 );      
               $lessons = $this->CourseLessonMap->find("all",array('conditions'=>$con,'order' => array('CourseLessonMap.srno' => 'ASC')));              
               if(empty($lessons)){
                $con = array(
              'CourseLessonMap.course_id =' => $course['Course']['id'],
              'CourseLessonMap.deleted =' => 0,              
              );      
              $lessons = $this->CourseLessonMap->find("all",array('conditions'=>$con,'order' => array('CourseLessonMap.published_date' => 'ASC')));
            }                         
            foreach ($lessons as $keys => $less) {
              $cnptcount=0;$exercount=0;$testcount=0;      
        $elements = $this->LessonElementMap->find("all",array('conditions'=> array(
          'LessonElementMap.lesson_id ='=> $less['CourseLessonMap']['lesson_id'],
          'LessonElementMap.deleted =' => 0)));          
        ini_set('max_execution_time', 300);
        foreach ($elements as $elem){          
        //   // print_r($elem);
           if($elem['LessonElementMap']['element_type'] == 2){
             $conditions = array(           
                'StudentConceptAttempt.element_id =' => $elem['LessonElementMap']['element_id'],
                'StudentConceptAttempt.status =' => 2,
                'StudentConceptAttempt.deleted =' => 0,
                'StudentConceptAttempt.student_id =' =>$value['StudentCourseMap']['student_id']
               );
            $studentcnptattempt = $this->StudentConceptAttempt->find("first", array('conditions' => $conditions));                   
            if(!empty($studentcnptattempt))
              $cnptcount++;
            else
              break;
           }
           else if($elem['LessonElementMap']['element_type'] == 3){          
                 $conditions = array(              
                'StudentExerciseAttempt.element_id =' => $elem['LessonElementMap']['element_id'],
                'StudentExerciseAttempt.status =' => 2,
                'StudentExerciseAttempt.deleted =' => 0,
                'StudentExerciseAttempt.student_id =' =>$value['StudentCourseMap']['student_id']
               );
               $studentexeattempt = $this->StudentExerciseAttempt->find("first", array('conditions' => $conditions));               
               if(!empty($studentexeattempt))
                  $exercount++;
              else
                break;
           }
            else if($elem['LessonElementMap']['element_type'] == 1){
              $conditions = array(        
                'StudentTestAttempt.test_id =' => $elem['LessonElementMap']['element_id'],
                'StudentTestAttempt.status =' => 2,
                'StudentTestAttempt.student_id =' =>$value['StudentCourseMap']['student_id'],
                'StudentTestAttempt.deleted =' => 0
               );
               $studenttestattempt = $this->StudentTestAttempt->find("first", array('conditions' => $conditions));               
               if(!empty($studenttestattempt))
                  $testcount++;
              else
                break;
           }

        }
          if($cnptcount+$exercount+$testcount == count($elements))
            $lesscomp++;
        // $flat = call_user_func_array('array_merge', $studentcnptattempt);
        // $studentcnptattempt = iterator_to_array(new RecursiveIteratorIterator(new RecursiveArrayIterator($studentcnptattempt)), 0);        
        // $studentexeattempt = iterator_to_array(new RecursiveIteratorIterator(new RecursiveArrayIterator($studentexeattempt)), 0);        
        // $totalcompletioncount = array_intersect($studentcnptattempt,$studentexeattempt);                
        $course_completion[$key]['Course']['lesson_completed'] = $lesscomp;
      }    
          }
             }      
        $this->set("course_completion",$course_completion);
  }

  public function admin_classroom_students()
  {
    $this->layout = "ahaguru";
  }
    public function adata_classroom_students()
  {
     $student = $this->ClassroomStudent2016->find("all");                
    $this->set("json",json_encode($student));
  }

  public function admin_classroom_students_list()
  {
    $this->layout = '';
    $registered_students=$this->ClassroomStudent2016->find("all");
    $this->set('registered_students', $registered_students); 
  }
       
}
?>

