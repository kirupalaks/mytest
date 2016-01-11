<?php
App::uses('CakeEmail', 'Network/Email');
class AhaQuestionController extends AppController {

    public $name = "AhaQuestion";
    public $uses = array("Slide",'Question','Ag_Ma_Question','Ag_Ma_Topic','Ag_Tr_Aftd');
    
    
    public function admin_index(){
		$this->layout = "ahaguru";
	}          
	public function admin_questions(){
		//$this->layout = "ahaguru_mobile_math";
		 $this->layout = "ahaguru";
		}
	public function adata_index(){
	
	$i=0;

       $this->set("json", json_encode($questions)); 	 
	}  
	public function adata_questions(){
		$i=0;
       $questions['questions'] = $this->Ag_Ma_Question->find("all", array('order'=>array('Ag_Ma_Question.id'=>"DESC")));
		$ques =array();
	  /* foreach($questions['questions'] as $val){
		 $ques['question'] = $val['Ag_Ma_Question']['question'];  
		 $ques = array_merge($ques,$questions);  
	   } */
	   $this->set("json", json_encode($questions));
	}	
	public function adata_add_question() {
	    $result;
	    $data = $this->request->data; print_r($data);die;
		if($data['question_type'] == 1) {
			$mcqtext = $data['question']['text'];				
			$coreqtxt = array('text' => $mcqtext,'image'=>$data['File']['question']['name'],'mark'=>$data['question']['mark'],'correct_answer'=>$data['question']['correct_answer']);
			$this->uploadFiles("mobileapp_content",$data['File']);				
		
		 $options = array( '0' =>
		array('text'=>trim($data['question']['option1']['text']),'image'=> str_replace(' ', '_', $data['File']['option1']['name'])),
		'1' => array('text'=>trim($data['question']['option2']['text']),'image'=> str_replace(' ', '_', $data['File']['option2']['name'])),
		'2' => array('text'=>trim($data['question']['option3']['text']),'image'=> str_replace(' ', '_', $data['File']['option3']['name'])),
		'3' => array('text'=>trim($data['question']['option4']['text']),'image'=> str_replace(' ', '_', $data['File']['option4']['name']))	
		);  
		$question_info = array('name'=>$data['name'],'questiontext'=>$coreqtxt,'answer'=>array('image'=>$data['File']['answer']['name']),
		'option' => $options,
		'solution' => array('text'=>$data['question']['solution_text'],'image'=>$data['File']['solution']['name'],'video'=>$data['question']['solution_video'])			
		);
		$data['complexity']=$data['question']['diff_level'];	
		$data['question'] = json_encode($question_info);
		$this->Ag_Ma_Question->save($data);
	     }
        //$this->redirect("/admin/AhaQuestion/questions/");	     
    }
	public function adata_edit_slide() {
	    $result;
	    $data = $this->request->data;
		
		if($data['question_type'] == 1) {
			$questionimage ='';$solutionimage ='';$option1image='';$option2image ='';$option3image='';$answerimage='';$option4image =''; 
			if (!empty($data['File']['question']['name'])) 
			{
				move_uploaded_file($data['File']['question']['tmp_name'], "mobileapp_content/" .$data['File']['question']['name']); 
				$questionimage = $data['File']['question']['name'];	
			} else if (!empty($data['oldFile']['question'])) { $questionimage = $data['oldFile']['question']; }
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
			if (!empty($data['File']['answer']['name'])) 
			{
				move_uploaded_file($data['File']['answer']['tmp_name'], "mobileapp_content/" .$data['File']['answer']['name']); 
				$answerimage = $data['File']['answer']['name'];	
			} else if (!empty($data['oldFile']['answer']) )  { $answerimage = $data['oldFile']['answer']; }
			if (!empty($data['File']['solution']['name'])) 
			{
				move_uploaded_file($data['File']['solution']['tmp_name'], "mobileapp_content/" .$data['File']['solution']['name']); 
				$solutionimage = $data['File']['solution']['name'];	
			} else if (!empty($data['oldFile']['solution']	)) { $solutionimage = $data['oldFile']['solution']; }
			
			
			$mcqtext = $data['question']['text'];				
			$coreqtxt = array('text' => $mcqtext,'image'=>$questionimage,'mark'=>$data['question']['mark'],'correct_answer'=>$data['question']['correct_answer']);
				
		
		 $options = array( '0' =>
		array('text'=>$data['question']['option1']['text'],'image'=> str_replace(' ', '_', $option1image)),
		'1' => array('text'=>$data['question']['option2']['text'],'image'=> str_replace(' ', '_', $option2image)),
		'2' => array('text'=>$data['question']['option3']['text'],'image'=> str_replace(' ', '_', $option3image)),
		'3' => array('text'=>$data['question']['option4']['text'],'image'=> str_replace(' ', '_', $option4image))		
		);  
		$question_info = array('name'=>$data['name'],'questiontext'=>$coreqtxt,'answer'=>array('image'=>$answerimage),
		'option' => $options,
		'solution' => array('text'=>$data['question']['solution_text'],'image'=>$solutionimage,'video'=>$data['question']['solution_video'])
		
		);
		$data['complexity'] = $data['question']['diff_level'];
		$data['question'] = json_encode($question_info);
		
	   $this->Ag_Ma_Question->query("update ag_ma_questions  set question= '".$data['question']."',complexity='".$data['complexity']."',tags='".$data['tags']."' where id='".$data['question_id']."' ;");
	   //$this->MobileAppQuestion->save($data);
	    }
	    $this->redirect("/admin/AhaQuestion/questions");
	
    }

    public function adata_remove_question() {
		$this->autoRender = false;
       	$data = $this->request->data;	   	
		$this->Ag_Ma_Question->id = $data['questionid'];
	    $this->Ag_Ma_Question->save($data);
	    $this->set("json", json_encode(array("message" => "success")));
    }

public function admin_assignaftd(){
    $this->layout = "ahaguru";
   }
	
public function adata_assignaftd(){   
	if($this->request->is("post")) {
	  $this->layout = "default";
		$data = $this->request->data; 	
		//$today = date('Y-m-d');		
		$start_date = date_create_from_format("m\/d\/Y", $data['start_date']);
		$aftd_date = date_format($start_date, 'Y-m-d');
			/* if($aftd_date <= $today) {
					$message = array('result'=>'Can assign AFTD only for Future dates');			
				}
			else { */
					$con = array(
						'Ag_Tr_Aftd.topic_id =' => $data['topic_id'],           
						'Ag_Tr_Aftd.standard =' => $data['standard'],
						'Ag_Tr_Aftd.question_id IN' => $data['question_id'],
						'Ag_Tr_Aftd.aftd_date =' => $aftd_date
						);
					$aftdmap = $this->Ag_Tr_Aftd->find("first",array('conditions' => $con)); 
						 if(!empty($aftdmap)) {				
							$message = array('result'=>'Already Assigned for the Day');							
						}
						else if(empty($aftdmap)) {	
								foreach($data['question_id'] as $questionid){
											$aftd['topic_id'] = $data['topic_id'];
											$aftd['question_id'] = $questionid;
											$aftd['standard'] = $data['standard'];
											$aftd['aftd_date'] = $aftd_date;                                                            
											$this->Ag_Tr_Aftd->create();
											$this->Ag_Tr_Aftd->save($aftd);	
								}			
							$message = array('result'=>'Success');	
						}
			//} 
			$this->set("json",json_encode($message));			
	}
}

	public function admin_viewaftd(){
    $this->layout = "ahaguru";
   }

   public function adata_viewaftd(){
    $this->layout = "default";
    $questions = array();
    $i=0; 
     $aftd = $this->Ag_Tr_Aftd->query("SELECT GROUP_CONCAT( question_id
					SEPARATOR  ',' ) AS qid,GROUP_CONCAT( id
					SEPARATOR  ',' ) AS aftdid,  standard, topic_id, aftd_date
					FROM  ag_tr_aftd
					GROUP BY  standard ,topic_id , aftd_date  ORDER BY aftd_date DESC"); 
	$this->set("json",json_encode($aftd));
   }
public function admin_topics() {
  $this->layout = "ahaguru";
  }
 public function getall_topic() {
	  $this->layout = "default";   
		$this->set("json",json_encode($this->Ag_Ma_Topic->find("all",array('order'=>array('Ag_Ma_Topic.created'=>"DESC")))));
  }
 public function adata_getaftd(){
	$data = $this->request->data;    	
		$con = array('Ag_Tr_Aftd.id =' => $data['aftd_id']);
     $aftdmap = $this->Ag_Tr_Aftd->find("first",array('conditions'=> $con));	
	
	 $this->set("json",json_encode($aftdmap));
 }
 

 public function adata_assignquestions(){    
	  if($this->request->is("post")) {
		$this->layout = "default";
		$data = $this->request->data; 
		// $today = date('Y-m-d');	
		$start_date = date_create_from_format("m\/d\/Y", $data['start_date']);
		$aftd_date = date_format($start_date, 'Y-m-d');
		
					$question_id =$data['question_id'][0];
					$query = "select * from ag_tr_aftd WHERE topic_id='".$data['topic_id']."' AND standard='".$data['standard']."' AND aftd_date='".$aftd_date."' AND question_id = '".$question_id."'  ";
					
					$aftdmap = $this->Ag_Tr_Aftd->query($query); 
					 if(!empty($aftdmap)) {				
						$message = array('result'=>'Already Assigned for the Day');							
					}
					else if(empty($aftdmap)) {
						$query1 = "update ag_tr_aftd  set question_id= '".$question_id."',topic_id='".$data['topic_id']."',standard='".$data['standard']."',aftd_date='".$aftd_date."' where id='".$data['id']."' ";
						$this->Ag_Tr_Aftd->query($query1);			
						$message = array('result'=>'Success');
					}
				
			$this->set("json",json_encode($message));			
		 }
	}
	 public function adata_addtopic() {
       
	  if($this->request->is("post")) {
		$this->layout = "default"; 
		$data = $this->request->data;	 
		  $topic_name = $data['topic_name'];
		  $con = array(
		  'OR' =>array('Ag_Ma_Topic.topic_name LIKE' => "$topic_name%",
			 'Ag_Ma_Topic.topic_name' => $data['topic_name'])
		  );    
		 $topics = $this->Ag_Ma_Topic->find("first",array('conditions'=> $con));
		  if(empty($topics)){
			$add = $this->Ag_Ma_Topic->save($data);
			$this->redirect("/admin/AhaQuestion/topics");	
		  }
		  else {
			$message = array('result'=>'Topic Name Already Exists');			  
			$this->redirect("/admin/AhaQuestion/topics");	
			//$this->set("json",json_encode($message));
		  }	
	  }	  
    }
    public function adata_edit($id) {
	  if($this->request->is("POST")) {
				$data = $this->request->data;
			  $this->Ag_Ma_Topic->id = $id;
		  $add = $this->Ag_Ma_Topic->save($data);
		
		  $this->redirect("/admin/AhaQuestion/topics");
	  }
    }
	 public function adata_getallaftd() {
	  $this->layout = "default";  
	   $aftd = $this->Ag_Tr_Aftd->query("SELECT question_id AS qid, standard
					FROM  ag_tr_aftd ORDER BY qid ASC	
					 ");
		$this->set("json",json_encode($aftd));
  }
  
  public function admin_getallassignaftd() {
    $this->layout = "ahaguru";  
    }
	public function adata_getallassignaftd($id){
	$this->layout = "default";
    $questions = array();
    $i=0;
    $cond = array(
      'OR' =>array('Ag_Tr_Aftd.topic_id LIKE' => "$id,%",
         'Ag_Tr_Aftd.topic_id' => "$id")
      );    
    $aftd1 = $this->Ag_Tr_Aftd->query("SELECT GROUP_CONCAT( question_id
					SEPARATOR  ',' ) AS question_id,  standard, topic_id
					FROM  ag_tr_aftd WHERE topic_id='".$id."'
					GROUP BY  standard ");
/* 	foreach ($aftd1 as  $value) { 
		//$question_id = explode(',',$value[$key]['question_id']);
		$questions =$value[$j]['question_id'];
		 for($i = 0; $i< count($question_id) ; $i++){
			  $questions[$i] = $this->Ag_Ma_Question->findById($question_id[$i]);
		 }	 
		 $j++;

	}	
	 */
 
    
	   
	   $this->set("json", json_encode($aftd1));
	}
	 public function adata_question($questionid) {
      $this->set("json", json_encode($this->Ag_Ma_Question->findById($questionid)));
    }
	 public function adata_getaftdquestion($questionid) {
	  $val = $this->Ag_Tr_Aftd->query("SELECT GROUP_CONCAT(standard SEPARATOR  ',') AS std ,question_id  FROM ag_tr_aftd WHERE question_id = '".$questionid."' ");
	 //$val = $val['Ag_Tr_Aftd']['std'];
      $this->set("json", json_encode($val));
    }
	public function adata_delete_image() {
		//$this->autoRender = false;
       	$data = $this->request->data;	   	
		$image = $data['imageid'];
		$folder = $data['folderpath'];
		$foldern = $folder.'/'.$image;
		if(!empty($image)){ unlink($foldern);
		
		$questionid = $data['questionid'];
		$question = $this->Ag_Ma_Question->findById($questionid);		
		$questiontext = $question['Ag_Ma_Question']['question'];
			
		$qtext = json_decode($questiontext);
		if($data["key"]=='qimage'){
		$questionarray = $qtext->questiontext; 
		/* $data1['name'] = $qtext->name; 
		$data1['answer'] = $qtext->answer; 
		$data1['option'] = $qtext->option; 
		$data1['solution'] = $qtext->solution; */
		$imgdata = array('image' => "");
		$questionarray = array_merge((array)$questionarray, (array)$imgdata);
		$qtext->questiontext = $questionarray;
		}
		if($data["key"]=='ansimage'){
		$answerarray = $qtext->answer; 
		
		$img1data = array('image' => "");
		$answerarray = array_merge((array)$answerarray, (array)$img1data);
		$qtext->answer = $answerarray;
		}
		$qtext = json_encode($qtext);
		$this->Ag_Ma_Question->query("update ag_ma_questions  set question= '".$qtext."' where id='".$questionid."' ;");
	   // $this->Ag_Ma_Question->save($data);
	    
				
		$this->set("json", json_encode(array("message" => "Success")));
		}
	  // $this->set("json", json_encode($qtext));
    }	
	
	public function admin_reminder(){
		$standards = array("9","10","11","12");
		$today = date('Y-m-d');
		$conditions = array(
			'Ag_Tr_Aftd.aftd_date'=> $today,
			'Ag_Tr_Aftd.standard IN' => $standards			
		);
		$array_email = array("kirutry@gmail.com");
		$getdata = $this->Ag_Tr_Aftd->find('all', array('group'=>'Ag_Tr_Aftd.standard','conditions'=>$conditions));
		
		foreach($getdata  as $val){			
			$getdata_standards[] = $val['Ag_Tr_Aftd']['standard'];				
		}
		$not_avail_standard	= array();
		$not_avail_standard = array_diff_key($standards,$getdata_standards);
		$values = implode(",", array_values($not_avail_standard));
		
	 if($array_email != ""){
			$rawstr = "Dear All,<br>
              <p>At least Two questions are not available for tomorrow's AFTD for class(es) - $values</p>			  
			  ";
			$this->sendEmail($array_email,null, 'Aha for the Day - Reminder',$rawstr,null);
			
			echo json_encode(array("status" => array('Email_Sent')));
		}
		else {
			echo json_encode(array("status" => array('Not Sent'))); 
		}
		//$this->set("json",json_encode($array_email));
	}
 
}
