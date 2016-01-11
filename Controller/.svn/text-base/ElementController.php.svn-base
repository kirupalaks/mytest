<?php

class ElementController extends AppController {

  public $name = "Element";

  public $uses = array("LessonElementMap","Test","Lesson","Concept", "Element","Exercise","Course");

  public function beforeFilter() {
    parent::beforeFilter();
  }

  public function admin_index() {
    $this->layout = "ahaguru";
  }

  public function admin_view($moduleid,$id) {
    $this->layout = "ahaguru";
  }

  public function adata_index() {
    $this->set("json", json_encode( $this->LessonElementMap->find("all") ));
  }

  public function adata_view($courseid,$id) {
    $elements = $this->LessonElementMap->query("select * from lesson_element_map where lesson_id=$id and deleted = 0");

    foreach($elements as $i=>$element) {
      if($elements[$i]['lesson_element_map']['element_type'] == 1) {
        $elements[$i]['lesson_element_map']['details'] = $this->Test->findById($elements[$i]['lesson_element_map']['element_id']);
        $pdf = split("/", $elements[$i]['lesson_element_map']['details']['Test']['pdffile']);
        $elements[$i]['lesson_element_map']['details']['Test']['pdffile'] = $pdf[1];
      } else if($elements[$i]['lesson_element_map']['element_type'] == 2) {
        $elements[$i]['lesson_element_map']['details'] = $this->Concept->findById($elements[$i]['lesson_element_map']['element_id']);
        $pdf = split("/", $elements[$i]['lesson_element_map']['details']['Concept']['pdffile']);
        $elements[$i]['lesson_element_map']['details']['Concept']['pdffile'] = $pdf[1];
      } else if($elements[$i]['lesson_element_map']['element_type'] == 3) {
        $elements[$i]['lesson_element_map']['details'] = $this->Exercise->findById($elements[$i]['lesson_element_map']['element_id']);
        $pdf = split("/", $elements[$i]['lesson_element_map']['details']['Exercise']['pdffile']);
        $elements[$i]['lesson_element_map']['details']['Exercise']['pdffile'] = $pdf[1];
      } else {
        unset($elements[$i]);
      }
    }

    $data['elements'] = $elements;
      if(isset($elements[0]) && isset($elements[0]['lesson_element_map']) && isset($elements[0]['lesson_element_map']['details']))
    $data['lesson'] = $this->Element->module($elements[0]['lesson_element_map']['element_id'], $elements[0]['lesson_element_map']['element_type']);
    $data['course'] = $this->Course->findById($courseid);
    $this->set("json", json_encode($data));
  }

  public function adata_delete() {
    $data = $this->request->data;
   if($data['elementtype'] == 1)
      $this->Test->setDelete($data['testid'],$data['lessonid']);
   else  if($data['elementtype'] == 2)
      $this->Concept->setDelete($data['testid'],$data['lessonid']);
     else  if($data['elementtype'] == 3) 
           $this->Exercise->setDelete($data['testid'],$data['lessonid']);

    $this->set("json",json_encode(array("message"=>"success")));
  }

  public function adata_edit() {
    $data = $this->request->data;

    if($data['element_type'] == 1) {
      $this->Test->id = $data['testid'];
      $data['test']['edit'] = 1;
      $this->Test->save($data['test']);
    } else if($data['element_type'] == 2) {
      $this->Concept->id = $data['conceptid'];
      $this->Concept->save($data['concept']);
    } else if($data['element_type'] == 3) {
      $this->Exercise->id = $data['exerciseid'];
    $this->Exercise->save($data['exercise']);
        }

    $this->set("json", json_encode(array("message" => "success")));
    $this->redirect("/admin/element/".$data['courseid']."/".$data['lessonid']);
  }

  public function adata_add() {
    $data = $this->request->data;

    if($data['element_type'] == 1) {
      $test = $data['test'];

      $this->Test->save($test);

      $mapdata['module_id'] = $data['moduleid'];
      $mapdata['lesson_id'] = $data['lessonid'];
      $mapdata['element_id'] = $this->Test->id;
      $mapdata['element_type'] = $data['element_type'];
      $mapdata['position'] = 0;

      $this->LessonElementMap->save($mapdata);
    } else if($data['element_type'] == 2) {
      $concept = $data['concept'];

      $this->Concept->save($concept);

      $mapdata['module_id'] = $data['moduleid'];
        $mapdata['lesson_id'] = $data['lessonid'];
      $mapdata['element_id'] = $this->Concept->id;
      $mapdata['element_type'] = $data['element_type'];
      $mapdata['position'] = 0;

      $this->LessonElementMap->save($mapdata);
    } else if($data['element_type'] == 3) {
      $exercise = $data['exercise'];
      $this->Exercise->save($exercise);

      $mapdata['module_id'] = $data['moduleid'];
       $mapdata['lesson_id'] = $data['lessonid'];
      $mapdata['element_id'] = $this->Exercise->id;
      $mapdata['element_type'] = $data['element_type'];
      $mapdata['position'] = 0;

      $this->LessonElementMap->save($mapdata);
    }

    $this->redirect("/admin/element/".$data['courseid']."/".$data['lessonid']);
  }

public function admin_uploadpdf() {    
  $result;
  $data = $this->request->data;
  $pdffile = str_replace(' ', '_', $this->data['File']['Content']['name']);
  $data['File']['Content']['name'] = $pdfile;
  $result = $this->uploadFiles("content", $this->data['File']);  
  if(empty($result) 
     || (!empty($result) 
         && !array_key_exists("errors", $result))
     || (!empty($result) 
         && !array_key_exists("nofiles", $result))) {      
      if($data['type'] == 1) {
          $test = $this->Test->findById($data['id']);
            $test['Test']['pdffile'] = $result['urls'][0];
            $this->Test->save($test);
        }
        else if($data['type'] == 2) { 
         $cnpt = $this->Concept->findById($data['id']);
            $cnpt['Concept']['pdffile'] = $result['urls'][0];
            $this->Concept->save($cnpt);   
        }
          else if($data['type'] == 3) { 
          $exer = $this->Exercise->findById($data['id']);
            $exer['Exercise']['pdffile'] = $result['urls'][0];            
            $this->Exercise->save($exer);          
        }
      }
  $this->redirect("/admin/element/".$data['course_id']."/".$data['lesson_id']);
    }

}
