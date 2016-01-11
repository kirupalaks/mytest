<?php

class PromotionalController extends AppController {

    public $name = "Promotional";
      public $uses = array('Course','PromotionalCoupon','CouponStatus','Student',
        'verify_coupon');
    
      public function beforeFilter() {
      parent::beforeFilter();
      $this->layout = "default";
    }

    public function admin_view($crsid){
        $this->layout = "ahaguru";
    }

    public function adata_view($crsid){
              $con = array(
      'PromotionalCoupon.deleted =' => 0,
      'PromotionalCoupon.course_id =' =>$crsid
      );
         $coupons = $this->Course->findById($crsid); 
     $coupons['Coupons'] = $this->PromotionalCoupon->find("all",array('conditions' => $con));        
     foreach ($coupons['Coupons'] as $key => $value) {
     $conditions = array(
       'Student.email' => $value['PromotionalCoupon']['student_info'],
       'Student.deleted' => 0
             );
     $students = $this->Student->find("first",array('conditions' => $conditions));
           $coupons['Coupons'][$key]['PromotionalCoupon']['name'] = $students['Student']['name'];
      $coupons['Coupons'][$key]['PromotionalCoupon']['school'] = $students['Student']['school_name'];
      $coupons['Coupons'][$key]['PromotionalCoupon']['city'] = $students['Student']['place'];
      $coupons['Coupons'][$key]['PromotionalCoupon']['mobile'] = $students['Student']['mobile_number'];
     }
      $this->set("json", json_encode($coupons));
        }
    
    public function adata_delete($id) {
        $data=$this->request->data;
        if($this->PromotionalCoupon->setDelete($id,$data['courseid']))
      $this->set("json", json_encode( array( "message" => "deleted") ));
    else 
      $this->set("json", json_encode( array("message" => "error") ));
  }

  public function adata_edit($id) {
     $data = $this->request->data;

     $data['id'] = $id;
      $date = date_create_from_format("m\/d\/Y", $this->data['validity']);
      $data['validity'] = date_format($date, 'Y-m-d H:i:s');    
          $this->PromotionalCoupon->save($data);
     $this->redirect("/admin/promotional/".$data['courseid']); 
  } 

   public function adata_status(){
      $status = $this->CouponStatus->find("all");   
     $this->set("json",json_encode($status));
    }


 public function adata_add() {
     $data = $this->request->data;  
    $date = date_create_from_format("m\/d\/Y", $this->data['validity']);
      $data['validity'] = date_format($date, 'Y-m-d H:i:s');    
    $this->PromotionalCoupon->save($data);  
    $this->redirect("/admin/promotional/".$data['course_id']);   
   }

   public function verify_coupon(){
     $data = $this->request->data;  
    $coupons= $this->PromotionalCoupon->find("first",array('conditions'=>
       array('PromotionalCoupon.coupon_code' =>$data['coupon_code'],       
             'PromotionalCoupon.deleted' => 0)));
        if(isset($data['couponid'])){
       if($data['couponid'] == $coupons['PromotionalCoupon']['id'] || empty($coupons)){
        $this->set("json", json_encode(array("isvalid"=>"yes")));
      }
      else {
        $this->set("json", json_encode(array("isvalid"=>"no","validity" =>$coupons['PromotionalCoupon']['validity'] )));
      }
    }
      else{
       if(empty($coupons)) {
        $this->set("json", json_encode(array("isvalid"=>"yes")));
      }
      else {
        // $this->set("json", json_encode(array("isvalid"=>"no")));
        $this->set("json", json_encode(array("isvalid"=>"no","validity" =>$coupons['PromotionalCoupon']['validity'] )));
      }
   }
 }


  public function adata_coupons($crsid){
    if($crsid == 0){
    $con = array(
       "PromotionalCoupon.deleted =" => 0
             );
     $promo_coupons = $this->PromotionalCoupon->find("all", array('conditions' => $con,'group'=>array('coupon_code')));
    }
    else{
    $con = array(
      "PromotionalCoupon.deleted =" => 0,
      "PromotionalCoupon.course_id =" => $crsid
             );
     $promo_coupons = $this->PromotionalCoupon->find("all", array('conditions' => $con));
    }
    $this->set("json", json_encode($promo_coupons));
    }

}