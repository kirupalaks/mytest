<?php

class CouponController extends AppController {

    public $name = "Coupon";
     public $uses = array('Course','CourseCouponMap','PromotionalCoupon','CouponStatus','Student');


      public function beforeFilter() {
        parent::beforeFilter();
          $this->Auth->allow('verify_coupon');
    }

    public function admin_view($crsid){
        $this->layout = "ahaguru";
    }

      public function adata_count($crsid){
        $this->layout = "default";
                     $con = array(
      'CourseCouponMap.deleted =' => 0,
      'CourseCouponMap.course_id =' =>$crsid
      );
      $coupons = $this->CourseCouponMap->find("all",array('conditions' => $con));        
      $this->set("json", json_encode(sizeof($coupons)));
        }

              public function adata_view($crsid){
        $this->layout = "default";
                     $con = array(
      'CourseCouponMap.deleted =' => 0,
      'CourseCouponMap.course_id =' =>$crsid
      );
         $coupons = $this->Course->findById($crsid); 
     $coupons['Coupons'] = $this->CourseCouponMap->find("all",array('conditions' => $con));        
     foreach ($coupons['Coupons'] as $key => $value) {
     $conditions = array(
       'Student.email' => $value['CourseCouponMap']['student_info'],
       'Student.deleted' => 0
             );
     $students = $this->Student->find("first",array('conditions' => $conditions));
           $coupons['Coupons'][$key]['CourseCouponMap']['name'] = $students['Student']['name'];
      $coupons['Coupons'][$key]['CourseCouponMap']['school'] = $students['Student']['school_name'];
      $coupons['Coupons'][$key]['CourseCouponMap']['city'] = $students['Student']['place'];
      $coupons['Coupons'][$key]['CourseCouponMap']['mobile'] = $students['Student']['mobile_number'];
     }
      $this->set("json", json_encode($coupons));
        }
    
     
    public function adata_status(){
      $status = $this->CouponStatus->find("all");   
     $this->set("json",json_encode($status));
    }


      public function admin_coupon_list($crsid){
          $this->layout = '';
           $con = array(
      'CourseCouponMap.deleted =' => 0,
      'CourseCouponMap.course_id =' =>$crsid
      );
         $course = $this->Course->findById($crsid); 
     $coupon = $this->CourseCouponMap->find("all",array('conditions' => $con)); 

     foreach ($coupon as $key => $value) {

       unset ($value['CourseCouponMap']['course_id']);
       unset ($value['CourseCouponMap']['created']);
       unset ($value['CourseCouponMap']['modified']);
       unset ($value['CourseCouponMap']['deletd']);
       $status = $this->CouponStatus->find("all");   
       $coupons[$key]['CourseCouponMap']['srno'] = $value['CourseCouponMap']['srno'];
       $coupons[$key]['CourseCouponMap']['coupon_code'] = $value['CourseCouponMap']['coupon_code'];
       //$coupons[$key]['CourseCouponMap']['course'] = $course['Course']['name'];
    //   $coupons[$key]['CourseCouponMap']['created_by'] = $value['CourseCouponMap']['created_by'];
      // $coupons[$key]['CourseCouponMap']['purpose'] = $value['CourseCouponMap']['purpose'];
       
       /*foreach ($status as $stat) {
         if($stat['CouponStatus']['id'] == $value['CourseCouponMap']['status'])
          $coupons[$key]['CourseCouponMap']['status'] = $stat['CouponStatus']['name'];
       }*/
//$coupons[$key]['CourseCouponMap']['student_info'] = $value['CourseCouponMap']['student_info'];
     }
        $this->set("course",$course['Course']['name']);
           $this->set("coupons", $coupons);
        }

      public function adata_delete($id) {
        $data=$this->request->data;
        if($this->CourseCouponMap->setDelete($id,$data['courseid']))
      $this->set("json", json_encode( array( "message" => "deleted") ));
    else 
      $this->set("json", json_encode( array("message" => "error") ));
  }

  public function adata_edit($id) {
     $array = $this->request->data;

     $data = array(
      'id' => $id,
      'created_by' => $array['created_by'],
      'purpose' => $array['purpose']
        );
          $this->CourseCouponMap->save($data);
     $this->redirect("/admin/coupon/".$array['courseid']); 
  } 

 public function adata_add() {
     $data = $this->request->data;  
     $maxsrno = $this->CourseCouponMap->query("select max(srno) from course_coupon_map where course_id = ".$data['course_id']);
       if(empty($maxsrno[0][0]['max(srno)']))
      $srno = 1;
    else
      $srno = $maxsrno[0][0]['max(srno)'] + 1;
    $keys = array_merge(range(0, 9), range('A', 'Z'));
          for ($i = 0; $i < $data['count']; $i++) {
         $key = md5($i.time());
    
    $mapdata[$i]['coupon_code'] = strtoupper(substr($key,0,10));  
    $mapdata[$i]['created_by'] = $data['created_by'];
    $mapdata[$i]['purpose'] = $data['purpose'];
    $mapdata[$i]['course_id'] = $data['course_id'];
    $mapdata[$i]['srno'] = $srno++;
    }
    $this->CourseCouponMap->saveAll($mapdata);  
    //$this->set("json",json_encode("mapped"));
      $this->redirect("/admin/coupon/".$data['course_id']);

   
   }

   public function  verify_coupon(){
    $this->layout ="default";
     $data= $this->request->data;     
     if(stripos($data['coupon_code'],"APC2S") === FALSE){
      $sesscoupon = substr($data['coupon_code'],0,4);      
      $coupnum = trim(substr($data['coupon_code'],4));      
      }
      else if(stripos($data['coupon_code'],"APC2S") !== FALSE){
      $sesscoupon = substr($data['coupon_code'],0,5);      
      $coupnum = trim(substr($data['coupon_code'],5));      
      }      
      if(strcasecmp($sesscoupon,"APC2") == 0){        
     if((strlen($coupnum) == 4 || strlen($coupnum) == 5) && is_numeric($coupnum) && intval($coupnum) > 0 && intval($coupnum) <= 20000){
        $crs= $this->PromotionalCoupon->find("first",array('conditions'=>
       array('PromotionalCoupon.coupon_code LIKE' => $sesscoupon."%",       
        'PromotionalCoupon.validity >=' => date("Y-m-d"),
       'PromotionalCoupon.deleted'=>0)));
     }}
     else if(strcasecmp($sesscoupon,"APC2S") == 0){        
      if(strlen($data['coupon_code']) == 5){
        $crs= $this->PromotionalCoupon->find("first",array('conditions'=>
       array('PromotionalCoupon.coupon_code LIKE' => $sesscoupon."%",       
        'PromotionalCoupon.validity >=' => date("Y-m-d"),
       'PromotionalCoupon.deleted'=>0)));
      }
    }
     else{
      $crs= $this->CourseCouponMap->find("first",array('conditions'=>
          array('CourseCouponMap.coupon_code'=>$data['coupon_code'],
              'CourseCouponMap.status'=>1,         
             'CourseCouponMap.deleted'=>0)));      
    if(empty($crs)){
      $crs= $this->PromotionalCoupon->find("first",array('conditions'=>
       array('PromotionalCoupon.coupon_code' =>$data['coupon_code'],       
        'PromotionalCoupon.validity >=' => date("Y-m-d"),
       'PromotionalCoupon.deleted'=>0)));
      }}     
     if(empty($crs))
      $message = array('result' => 'no','message'=>'Enter Correct Code');
     else{      
        $this->Session->write('coupon_code',$data['coupon_code']);
        if($this->Auth->user()){
          $user = $this->Auth->user();      
          if(strcasecmp($sesscoupon,"APC2") == 0 || strcasecmp($sesscoupon,"APC2S") == 0 )
            $message = array('result' => 'validhindu','message'=>'valid','id'=>$user['Student']['id']);
          else
            $message = array('result' => 'valid','message'=>'valid','id'=>$user['Student']['id']);
        }
        else
          $message = array('result' => 'valid','message'=>'login');
     }
      $this->set("json", json_encode($message));

   }

 

}