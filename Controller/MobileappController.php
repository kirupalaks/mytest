<?php

class MobileappController extends AppController {

    public $name = "Mobileapp";
    public $uses = array("Slide",'Question','MobileAppQuestion','MobileAppTopic','MobileAppAhaforday');
    
    
    public function admin_index(){
		$this->layout = "ahaguru_mobile_math";
	}          
	public function admin_questions(){
		//$this->layout = "ahaguru_mobile_math";
		 $this->layout = "ahaguru";
		}
	public function adata_index(){
		$i=0;
       $questions['questions'] = $this->MobileAppQuestion->find("all");
	   
       $this->set("json", json_encode($questions)); 	 
	}  
	public function adata_questions(){
		$i=0;
       $questions['questions'] = $this->MobileAppQuestion->find("all");
	   $this->set("json", json_encode($questions));
	}
		
	
	public function adata_add_slide() {
	    $result;
	    $data = $this->request->data;
		if($data['question_type'] == 1) {
			$mcqtext = $data['question']['text'];				
			$coreqtxt = array('text' => $mcqtext,'image'=>$data['File']['question']['name'],'mark'=>$data['question']['mark'],'correct_answer'=>$data['question']['correct_answer']);
			$this->uploadFiles("mobileapp_content",$data['File']);				
		
		 $options = array( '0' =>
		array('text'=>trim($data['question']['option1']['text']),'image'=> str_replace(' ', '_', $data['File']['option1']['name'])),
		'1' => array('text'=>trim($data['question']['option2']['text']),'image'=> str_replace(' ', '_', $data['File']['option2']['name'])),
		'2' => array('text'=>trim($data['question']['option3']['text']),'image'=> str_replace(' ', '_', $data['File']['option3']['name'])),
		'3' => array('text'=>trim($data['question']['option4']['text']),'image'=> str_replace(' ', '_', $data['File']['option4']['name'])),
		'4' => array('text'=>trim($data['question']['option5']['text']),'image'=> str_replace(' ', '_', $data['File']['option5']['name']))
		);  
		$question_info = array('name'=>$data['name'],'questiontext'=>$coreqtxt,
		'option' => $options,
		'solution' => array('text'=>$data['question']['solution_text'],'video'=>$data['question']['solution_video'])			
		);
		$data['complexity']=$data['question']['diff_level'];	
		$data['question'] = json_encode($question_info);
		$this->MobileAppQuestion->save($data);
	     }
        $this->redirect("/admin/mobileapp/questions/");	     
    }
	public function adata_edit_slide() {
	    $result;
	    $data = $this->request->data;
		
		if($data['question_type'] == 1) {
			$questionimage ='';$option1image='';$option2image ='';$option3image='';$option5image='';$option4image =''; 
			if (!empty($data['File']['question']['name'])) 
			{
				move_uploaded_file($data['File']['question']['tmp_name'], "mobileapp_content/" .$data['File']['question']['name']); 
				$questionimage = $data['File']['question']['name'];	
			} else if (!empty($data['oldFile']['question']['name'])) { $questionimage = $data['oldFile']['question']; }
			if (!empty($data['File']['option1']['name'])) 
			{
				move_uploaded_file($data['File']['option1']['tmp_name'], "mobileapp_content/" .$data['File']['option1']['name']); 
				$option1image = $data['File']['option1']['name'];	
			} else if (!empty($data['oldFile']['option1']) )  { $option1image = $data['oldFile']['option1']; }
			if (!empty($data['File']['option2']['name'])) 
			{
				move_uploaded_file($data['File']['option2']['tmp_name'], "mobileapp_content/" .$data['File']['option2']['name']); 
				$option2image = $data['File']['option2']['name'];	
			} else if (!empty($data['oldFile']['option2']) )  { $option2image = $data['oldFile']['option2']; }
			if (!empty($data['File']['option3']['name'])) 
			{
				move_uploaded_file($data['File']['option3']['tmp_name'], "mobileapp_content/" .$data['File']['option3']['name']); 
				$option3image = $data['File']['option3']['name'];	
			} else if (!empty($data['oldFile']['option3']) )  { $option3image = $data['oldFile']['option3']; }
			if (!empty($data['File']['option4']['name']) ) 
			{
				move_uploaded_file($data['File']['option4']['tmp_name'], "mobileapp_content/" .$data['File']['option4']['name']); 
				$option4image = $data['File']['option4']['name'];	
			} else if (!empty($data['oldFile']['option4']) )  { $option4image = $data['oldFile']['option4']; }
			if (!empty($data['File']['option5']['name'])) 
			{
				move_uploaded_file($data['File']['option5']['tmp_name'], "mobileapp_content/" .$data['File']['option5']['name']); 
				$option5image = $data['File']['option5']['name'];	
			} else if (!empty($data['oldFile']['option5']) )  { $option5image = $data['oldFile']['option5']; }
			
			
			
			$mcqtext = $data['question']['text'];				
			$coreqtxt = array('text' => $mcqtext,'image'=>$questionimage,'mark'=>$data['question']['mark'],'correct_answer'=>$data['question']['correct_answer']);
				
		
		 $options = array( '0' =>
		array('text'=>trim($data['question']['option1']['text']),'image'=> str_replace(' ', '_', $option1image)),
		'1' => array('text'=>trim($data['question']['option2']['text']),'image'=> str_replace(' ', '_', $option2image)),
		'2' => array('text'=>trim($data['question']['option3']['text']),'image'=> str_replace(' ', '_', $option3image)),
		'3' => array('text'=>trim($data['question']['option4']['text']),'image'=> str_replace(' ', '_', $option4image)),
		'4' => array('text'=>trim($data['question']['option5']['text']),'image'=> str_replace(' ', '_', $option5image))
		);  
		$question_info = array('name'=>$data['name'],'questiontext'=>$coreqtxt,
		'option' => $options,
		'solution' => array('text'=>$data['question']['solution_text'],'video'=>$data['question']['solution_video'])
		
		);
		$data['complexity'] = $data['question']['diff_level'];
		$data['question'] = json_encode($question_info);// print_r($data); die;	
	    $this->MobileAppQuestion->query("update ag_ma_questions  set question= '".$data['question']."',complexity='".$data['complexity']."',tags='".$data['tags']."' where id='".$data['question_id']."' ;");
	    //$this->MobileAppQuestion->save($data);
	    }
	    $this->redirect("/admin/mobileapp/questions");
	
    }

    public function adata_remove_question() {
		$this->autoRender = false;
       	$data = $this->request->data;	   	
		$this->MobileAppQuestion->id = $data['questionid'];
	    $this->MobileAppQuestion->save($data);
	    $this->set("json", json_encode(array("message" => "success")));
    }

public function admin_assignaftd(){
    $this->layout = "ahaguru";
   }
	
public function adata_assignaftd(){   
  if($this->request->is("post")) {
  $this->layout = "default";
	$data = $this->request->data; 	
	 $con = array(
            'MobileAppAhaforday.topic_id =' => $data['topic_id'],           
            'MobileAppAhaforday.standard =' => $data['standard'],
            'MobileAppAhaforday.question_id IN' => $data['question_id']         
            );
	
 		$aftdmap = $this->MobileAppAhaforday->find("first",array('conditions' => $con));    	
		$start_date = date_create_from_format("m\/d\/Y", $data['start_date']);
		$aftd_date = date_format($start_date, 'Y-m-d H:i:s');
		$aftdmap_date = date("m/d/Y", strtotime($aftdmap['MobileAppAhaforday']['date'])); 
			
			if((!empty($aftdmap) && ($aftdmap_date != $data['start_date'] )) ) {
			//if((!empty($aftdmap) && ($aftdmap_date != $data['start_date'] )) || (empty($aftdmap)))  {
				foreach($data['question_id'] as $questionid){
					$aftd['topic_id'] = $data['topic_id'];
					$aftd['question_id'] = $questionid;
					$aftd['standard'] = $data['standard'];
					$aftd['date'] = $aftd_date;                                                            
					$this->MobileAppAhaforday->create();
					$this->MobileAppAhaforday->save($aftd);	
				}			
			$message = array('result'=>'Success');
			$this->set("json",json_encode($message));	
			}
		 else 	{		
				$message = array('result'=>'Already Assigned for the Day');
				$this->set("json",json_encode($message));	
			} 
			
			/* if(empty($aftdmap)) 	{
					foreach($data['question_id'] as $questionid){
						$aftd['topic_id'] = $data['topic_id'];
						$aftd['question_id'] = $questionid;
						$aftd['standard'] = $data['standard'];
						$aftd['date'] = $aftd_date;                                                            
						$this->MobileAppAhaforday->create();
						$this->MobileAppAhaforday->save($aftd);	
					}			
					$message = array('result'=>'Success');
					$this->set("json",json_encode($message));	
				
				
			} 
			*/
     }
}

public function admin_viewaftd(){
    $this->layout = "ahaguru";
   }


   public function adata_viewaftd(){
    //$this->layout = "default";0987654321
    $questions = array();
    $i=0;   
	   
   // $aftd = $this->MobileAppAhaforday->find("all");
     $aftd = $this->MobileAppAhaforday->query("SELECT GROUP_CONCAT( question_id
					SEPARATOR  ',' ) AS qid,GROUP_CONCAT( id
					SEPARATOR  ',' ) AS aftdid,  standard, topic_id, date
					FROM  ag_tr_aftd
					GROUP BY  standard ,topic_id , date  ORDER BY date DESC"); 
   
	  //foreach ($aftd as $key => $value) {      
      //  $question = $this->MobileAppQuestion->find("first",array('conditions'=>
             //   array( 'MobileAppQuestion.id' => $value['MobileAppAhaforday']['question_id']                
        //  ))); 
		//$question['MobileAppAhaforday'] =$value['MobileAppAhaforday']['id'];
       // $questions[$i] = $question;   
// $i++;		  
        /*  foreach ($assignaftd as $val) {
          $question = $this->MobileAppTopic->find("first",array('conditions'=>
                array( $val['MobileAppAhaforday']['topic_id'])));
          $question['MobileAppAhaforday']['topic'] = $val['MobileAppTopic']['topic_name'];
          $questions[$i] = $question;          
          $i++;
        } */
		//$questions = array_merge($questions,$aftd);
  //   } 
	 
	 $this->set("json",json_encode($aftd));
   }

 public function getall_topic() {
	  $this->layout = "default";   
		$this->set("json",json_encode($this->MobileAppTopic->find("all")));
  }
 public function adata_getaftd($aftd_id){
	$this->autoRender = "false";   
		$con = array (
        'MobileAppAhaforday.id =' => $aftd_id,
       	
    );
     $aftdmap = $this->MobileAppAhaforday->find("all",array('conditions'=> $con));	 
	 $this->set("json",json_encode($aftdmap));
 }	
}