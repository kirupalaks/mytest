<?php

App::import('Vendor', 'gcm');
class ForumController extends AppController {

    public $name = "Forum";
    public $uses = array('Forum', 'Course', 'Admin','Classes');

    public function beforeFilter() {
        parent::beforeFilter();
    }
 
    public function admin_view($categoryid) {
            $this->layout = "ahaguru";
    }

    public function adata_view($courseId) {

            $conditions = array(
                    "Course.deleted =" => 0
            );

            $data['course'] = $this->Course->findById($courseId);
            $data['courses'] = $this->Course->find('all',array('conditions'=>$conditions));
            $data['posts'] = $this->Forum->getPosts($courseId);

            $this->set("json", json_encode($data));
    }

    public function adata_new_question() {
            $new_question = $this->Forum->newPost($this->request->data);
            if(!empty($new_question)) {
                    $this->sendNoti($new_question);
                    $this->set("json", json_encode(array("message" => "success")));
            } else {
                    $this->set("json", json_encode(array("message" => "fail")));
            }
            $this->redirect("/admin/forum/".$this->request->data['category_id']);
    }

    public function adata_post_details($postid) {
            $data = $this->Forum->getPost($postid);
            $data['details'] = $this->Forum->postDetails($postid);
            $this->set("json", json_encode($data));
    }

    public function adata_save_post($postid) {
            $this->error_log_array($this->request->data);
            $data = $this->request->data;
            $data['id'] = $postid;
            if($this->Forum->savePost($data)) {
                    $this->set("json", json_encode(array("message" => "success")));
            } else {
                    $this->set("json", json_encode(array("message" => "fail")));
            }
    }
        
    public function adata_answer_question($postid) {
            $user = $this->Auth->user("Admin");
            $data = $this->request->data;
            $data['created_by'] = "-".$user['id'];
            $reply = $this->Forum->replyForPost($data);
            $this->set("json", json_encode(array("message" => "success")));
    }

    public function adata_delete_post($postid) {
            $delete = $this->Forum->setDelete($postid);
            if($delete) {
                    $this->set("json", json_encode(array("message" => "success")));
            } else {
                    $this->set("json", json_encode(array("message" => "fail")));
            }
    }

    private function sendNoti($question){
      $title = "No title";
      $regIds = array();

      if(is_array($question))
      if(array_key_exists("title",$question['ForumPost'])){
        $title = $question['ForumPost']['title'];
      }

      $admin = $this->Admin->find('all');
      foreach($admin as $arr){
        $idstr = $arr['Admin']['gcm_regid']; 
        if(trim($idstr) != null)
          $regIds[] = $idstr;
      }

      $this->error_log_array($regIds);
      $msg = array("title"=>$title);

      if(count($regIds) > 0){
        $gcm = new gcm();
        $gcm->send_notification($regIds,$msg);
      }else{
        error_log("No reg ids found in admin. So GCM cannot be called");
      }

    }


}
