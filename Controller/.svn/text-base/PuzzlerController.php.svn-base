<?php

class PuzzlerController extends AppController {

    public $name = "Puzzler";

    public $uses = array('Course','Puzzler','StudentTestAttempt','Question','Classes','ClassPuzzlerMap','Slide','Student','Module','CourseModuleMap','LessonElementMap','StdCourseMap','StudentCoursePayment');

   public function beforeFilter() {
	parent::beforeFilter();
    $this->Auth->allow("guest_index");
	$this->layout = "default";
    }

   public function student_index(){
       $this->layout="ahaguru";

    }

 public function adata_add() {
	if($this->request->is("post")) {
	    $data = $this->request->data;
         $add = $this->Puzzler->save($data);
    if($add){
         	$data['puzzler_id'] = $this->Puzzler->id;
                  $data['class_id']= $data['cls'];
            		$this->ClassPuzzlerMap->save($data);}
	    $this->redirect("/admin/puzzler");
	}
    }

  public function adata_delete($id) {
        if($this->Puzzler->setDelete($id)){
          $this->set("json", json_encode( array( "message" => "deleted") ));}
        else 
          $this->set("json", json_encode( array("message" => "error") ));
      
    }


   public function allslides($id){
        $this->layout ="default";
        $slide = array();
        $slides = $this->Concept->findById($id);
        $slides = $slides['Concept']['slides'];
        $slides = explode(",",$slides);
        for($i=0; $i < count($slides); $i++){
            $slide[$i] = $this->Slide->findById($slides[$i]);
        }
        $this->set("json",json_encode($slide));
    }


  public function adata_edit($id) {
	if($this->request->is("POST")) {
	    $data = $this->request->data;

	    $this->Puzzler->id = $id;
	    $add = $this->Puzzler->save($data);
         if($add){
         	$data['puzzler_id'] = $this->Puzzler->id;
   	$this->ClassPuzzlerMap->query("update class_puzzler_map set class_id = ".$data['cls']." where puzzler_id = ".$data['puzzler_id']);}
	    $this->redirect("/admin/puzzler");
	}
    }

   public function admin_index() {
	$this->layout = "ahaguru";
    }

  public function admin_edit($id) {
      $this->layout = "ahaguru_math";
    }
      public function adata_index() {
      $conditions = array(
        "Puzzler.deleted =" => 0
      );
 $puzzler = $this->Puzzler->find("all", array('conditions' => $conditions));
              
              $count = 0;
      foreach($puzzler as $puzz){
         $class_id = $this->ClassPuzzlerMap->query("select class_id from class_puzzler_map where puzzler_id = ".$puzz['Puzzler']['id']." and deleted = 0");
   
              $puzz['Puzzler']['class'] = $class_id[0]['class_puzzler_map']['class_id'];
                $puzzler[$count++] = $puzz;  
    }
      $this->set("json",json_encode($puzzler));
               }

   
  public function guest_index(){
      $this->layout="ahaguru";
   }
   
    public function adata_slide($id) {

	$result;

	$data = $this->request->data;

	if($data['slide_type'] == 1) {
	    $result = $this->uploadFiles("content", $this->data['File']);
	}
	
	if($data['slide_type'] == 5) {
	    $this->Question->save($data['question']);
	    $data['content'] = $this->Question->id;
	}

	if(empty($result) 
	   || (!empty($result) 
	       && !array_key_exists("errors", $result))
	   || (!empty($result) 
	       && !array_key_exists("nofiles", $result))) {

	   if(!empty($result) && !array_key_exists("nofiles", $result) && $data['slide_type'] != 5) {
		$data['content'] = $data['File']['content']['name'];
	   }
	    $this->Slide->save($data);
	    $slideid = $this->Slide->id;

	    $puzzle = $this->Puzzler->findById($id);
	    $cdata = array();
	    $cdata['slides'] = $puzzle['Puzzler']['slides'];
	    $cdata['slides'] = empty($cdata['slides']) 
				 ? $slideid 
				 : $cdata['slides'].",".$slideid;

	    $this->Puzzler->id = $id;


	    $this->Puzzler->save($cdata);
}


	if(!isset($data['practice']))
	$this->redirect("/admin/puzzler/edit/$id");
    }

    public function admin_practicetest($id) {
	$this->layout = "ahaguru_math";
    }

    public function adata_remove_slide() {
	$data = $this->request->data;
	$puzzle = $this->Puzzler->findById($data['puzzlerid']);
	$slides = explode(",",$puzzle['Puzzler']['slides']);
	foreach($slides as $key => $value) {
	    if($value == $data['slideid']) {
		unset($slides[$key]);
	    }
	}
	$puzzle['Puzzler']['slides'] = implode(",",$slides);
	$this->Puzzler->id = $data['puzzleid'];
	$this->Puzzler->save($puzzle['Puzzler']);
	$this->set("json", json_encode(array("message" => "success")));
    }

    public function adata_edit_slide() {
	$result;
	$data = $this->request->data;

	if($data['slide_type'] == 1) {
	    $result = $this->uploadFiles("content", $this->data['File']);
	}

	if($data['slide_type'] == 5) {
	    $this->Question->id = $data['question_id'];
	    $this->Question->save($data['question']);
	    $data['content'] = $this->Question->id;
	}

	if(empty($result) 
	   || (!empty($result) 
	       && !array_key_exists("errors", $result))
	   || (!empty($result) 
	       && !array_key_exists("nofiles", $result))) {

	    if(!empty($result) && !array_key_exists("nofiles", $result) && $data['slide_type'] != 5)
	    $data['content'] = $data['File']['content']['name'];
	    $this->Slide->id = $data['slide_id'];
	    $this->Slide->save($data);
}

	if(!isset($data['practice']))
	$this->redirect("/admin/puzzler/edit/".$data['puzzler_id']);
	else 
	$this->redirect("/admin/practicetest/".$data['puzzler_id']);

    }

    public function adata_view($id) {
	$concept = $this->Puzzler->findById($id);
	$slideids = explode(",",$concept['Puzzler']['slides']);
	$concept['slide'] = array();
	foreach($slideids as $key => $slide) {
	    $concept['slide'][$key] = $this->Slide->findById($slide);

	    if($concept['slide'][$key]['Slide']['slide_type'] == 5) {
		$concept['slide'][$key]['Slide']['content'] =
		    $this->Question->findById($concept['slide'][$key]['Slide']['content']);
	    }

	}
	$this->set("json", json_encode($concept));
    }

   public function sdata_class(){
   $this->layout="default";
   
     $this->set("json", json_encode($this->Classes->find("all")));

   }

   public function adata_class(){
   $this->layout="default";
   
   $this->set("json", json_encode($this->Classes->find("all")));

   }

  public function sdata_view($id){
    $this->layout = "default";
    $conditions = array(
      "ClassPuzzlerMap.class_id =" => $id,
        "ClassPuzzlerMap.deleted =" => 0
      );
    $class_puzz= $this->ClassPuzzlerMap->find("all",array("conditions"=>$conditions)); 
   $count =0;
  foreach($class_puzz as $cls_puzz){
$conditions = array(
      "Puzzler.id =" => $cls_puzz['ClassPuzzlerMap']['puzzler_id'],
        "Puzzler.deleted =" => 0
      );
   $puzz=$this->Puzzler->find("all",array("conditions"=>$conditions)); 
  $puzzler[$count] = $puzz[0];
   $count++;


   }
 $this->set("json", json_encode($puzzler));
   }

  public function student_quiz_view($id){
     $this->layout = "ahaguru_nonav";
}

 public function sdata_quiz_view($id){
     $this->layout = "default";

   $puzz=$this->Puzzler->findById($id);
                 	$slideids = explode(",",$puzz['Puzzler']['slides']);
        $puzz['slide'] = array();
        $type = 3;
        foreach($slideids as $key => $slide) {
            $puzz['slide'][$key] = $this->Slide->findById($slide);
                       if($puzz['slide'][$key]['Slide']['slide_type'] == 5) {
            $puzz['slide'][$key]['Slide']['content'] =
                $this
                ->Question
                ->findById($puzz['slide'][$key]['Slide']['content']);}}
  
               $this->set("json", json_encode($puzz));

}
  public function student_game_view($id){
     $this->layout = "ahaguru_nonav";
}
   }
?>

