<?php

class StandardController extends AppController {

  public $name = "Standard";

  public $uses = array('Standard');

  public function beforeFilter() {
    parent::beforeFilter();
    $this->Auth->allow('getall');
  }

  public function index() {
    $this->set("json", json_encode($this->Standard->find('all')));
  }

  public function add() {
    $this->layout = "default";
    if($this->Auth->isAuthorized()) {
      $this->Standard->save(array("Standard"=>array("name" => $this->request->data['name'])));
      $this->set("stat", json_encode(array( "id"=> $this->Standard->id , "message" => "saved" )));
    }
    else
    $this->set("stat", json_encode(array( "message" => "error" )));
  }

  public function edit($id) {
    $this->layout = "default";
    if($this->Auth->isAuthorized()) {
      $this->Standard->id = $id;
      $this->Standard->save(array("Standard"=>array("name" => $this->request->data['name'])));
      $this->set("stat", json_encode(array( "message" => "saved" )));
    }
    else
    $this->set("stat", json_encode(array( "message" => "error" )));
  }

  public function delete($id) {
    $this->layout = "default";
    if($this->Auth->isAuthorized()) {
      $this->Standard->delete($id);
      $this->set("stat", json_encode(array( "message" => "deleted" )));
    }
    else
    $this->set("stat", json_encode(array( "message" => "error" )));
  }


  public function getall() {
    $this->layout = "default";
     //$this->set("stat", json_encode($this->Standard->find('all')));
     $this->set("stat", json_encode($this->Standard->find('all',array( 'order' => array('Standard.name' => 'DESC')))));
    }
    
  }
