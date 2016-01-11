<?php

class AnimationController extends AppController {

    public $name = "Animation";

    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('animation');
}
   

   public function animation(){
     $this->layout = "default";
     
   }
}
