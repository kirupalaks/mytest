<?php

class DashboardController extends AppController {
    
    public $name = "Dashboard";
        
    public $uses = array("Dashboard","NewsTypes");
    public function beforeFilter() {
        parent::beforeFilter();
    }

    public function admin_index() {
        $this->layout = "ahaguru";
    }

    public function student_index() {
        $this->layout = "ahaguru";
    }
    
    public function adata_delete($newid) {
        $this->layout = "default";
        $this->Dashboard->query("delete from news where id=$newid;");
        $this->set("json", json_encode( array( "message" => "deleted")));
    }                     
       
    public function adata_news()
    {
     $data=array();
     $this->layout = "default";
     $data = $this->request->data;
    	if(isset($data['newss'])){
       for($i=0;$i<count($data['newss']);$i++){
         $this->NewsTypes->savenews($data['newss'][$i],$this->NewsTypes->NEWS_TYPES['ADMIN NEWS'],$data['news_target'],null,null);
           }
              $data=$this->Dashboard->query("select * from news where news_status = 1;"); 
    
               $this->set("json", json_encode($data));
          
   }
    }

   public function adata_get() {
    $this->layout = "default";
    $data=$this->Dashboard->query("select * from news where news_status = 1;"); 
    $this->set("json",json_encode($data));
      }

    public function course_news() {
      $this->layout = "default";
      $data=$this->Dashboard->query("select * from news where news_status = 1 and news_target='C';"); 
      $this->set("json",json_encode($data));
      }

   public function puzzler_news() {
      $this->layout = "default";
      $data=$this->Dashboard->query("select * from news where news_status = 1 and news_target='P';"); 
      $this->set("json",json_encode($data));
      }
        
}
