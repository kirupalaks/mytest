<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

App::uses('Controller', 'Controller');
App::uses('CakeEmail', 'Network/Email');
App::import('vendor', 'ImageResize');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package       app.Controller
 * @link http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {

     public $components = array(
      'Session',
      'Auth' => array(
      'loginAction' => '/login',
      'logoutRedirect' => 'http://106.186.125.162',      
      'Form' => array(
        'fields' => array(
          'username' => 'email'
         )
      ),
      'authorize' => 'Controller'
      )
    );

    // public $components = array(
    //   'Session',
    //   'Authlogout' => array(
    //   'loginAction' => '/login',
    //   'logoutRedirect' => '/login',
    //   'Form' => array(
    //     'fields' => array(
    //       'username' => 'email'
    //      )
    //   ),
    //   'authorize' => 'Controller'
    //   )
    // );
    
    public function isAuthorized($user = null) {
         if (empty($this->request->params['admin']) && empty($this->request->params['student']) &&
              empty($this->request->params['adata']) && empty($this->request->params['sdata'])) {
             return true;
         }
         if (isset($this->request->params['admin'])) {
             return (bool)($user['role'] === 'admin');
         }
         if (isset($this->request->params['adata'])) {
            return (bool)($user['data'] === 'adata');
         }
         if (isset($this->request->params['student'])) {
            return (bool)($user['role'] === 'student');
         }
         if (isset($this->request->params['sdata'])) {
            return (bool)($user['data'] === 'sdata');
         }
         return false;
    }

    public function error_log_array($array,$key=null) {
       if(is_array($array)) {
         if($key != null) error_log("__".$key."__");
         foreach($array as $key=>$value) {
           $this->error_log_array($value, $key);
         }
       }
       else {
          error_log( $key."=>".$array );
       }
    }

    public function uploadFiles($folder, $formdata, $itemId = null, $user_defined_filename = null, $thumbnails = array(), $force = false) {
        // setup dir names absolute and relative
        $folder_url = WWW_ROOT.$folder;
        $rel_url = $folder;
        // create the folder if it does not exist
        if(!is_dir($folder_url)) {

             mkdir($folder_url);
        }
        // if itemId is set create an item folder
        if($itemId) {
           // set new absolute folder
           $folder_url = WWW_ROOT.$folder.'/'.$itemId; 
           // set new relative folder
           $rel_url = $folder.'/'.$itemId;
           // create directory
           
           if(!is_dir($folder_url)) {
              mkdir($folder_url);
           }
        }
       // list of permitted file types, this is only images but documents can be added
        $permitted = array('image/gif','image/jpeg','image/jpg','image/pjpeg','image/png','text/csv','application/vnd.ms-excel','text/html',
                      'text/x-comma-separated-values','text/comma-separated-values', 'application/octet-stream', 'application/x-csv', 
                       'text/x-csv','application/csv', 'application/excel', 'application/vnd.msexcel','text/plain','application/pdf');
       // loop through and deal with the files
       // error_log("file".print_r($formdata,true));
       foreach($formdata as $file) {
         // replace spaces with underscores
         $filename = str_replace(' ', '_', $file['name']);
         //error_log("file".print_r($file,true));
         if(!empty($user_defined_filename))
         $filename = $user_defined_filename;
         // assume filetype is false
         $typeOK = false;
         // check filetype is ok
         foreach($permitted as $type) {
            if($type == $file['type']) {
               $typeOK = true;
               break;
            }
         }
         // if file type ok upload the file
        // error_log("tyrp".$typeOK);
                if($typeOK) {
           // switch based on error code
           switch($file['error']) {
           case 0:
            // check filename already exists
             if(!file_exists($folder_url.'/'.$filename) || $force) {
              // create full filename
              $full_url = $folder_url.'/'.$filename;
              $url = $rel_url.'/'.$filename;
              
              // upload the file
              $success = move_uploaded_file($file['tmp_name'], $url);
             
             } 
             else {
              // create unique filename and upload file
              ini_set('date.timezone', 'Asia/Kolkata');
              $now = date('Y-m-d-His');
              $filename = $now.$filename;
              $full_url = $folder_url.'/'.$filename;
              $url = $rel_url.'/'.$filename;
              $success = move_uploaded_file($file['tmp_name'], $url);
             
             }
             
                 // if upload was successful
             if($success) {
                 // save the url of the file
                 foreach( $thumbnails as $thumbnail ) {
                   $file = explode(".",$filename);
                   $file = $folder_url."/".$file[0]."_".$thumbnail.".".$file[1];
                   $ThumbnailGenerator = new ImageResize();
                   $ThumbnailGenerator->GenerateThumbnail($full_url, $file, $thumbnail,0,0.80);
                 }
                 $result['urls'][] = $url;
               
             }
             else {
               $result['errors'][] = "Error uploaded $filename. Please try again.";
             }
           break;
           case 3:
             // an error occured
             $result['errors'][] = "Error uploading $filename. Please try again.";
           break;
           default:
             // an error occured
             $result['errors'][] = "System error uploading $filename. Contact webmaster.";
           break;
           }
         } 
         elseif($file['error'] == 4) {
            // no file was selected for upload
            $result['nofiles'][] = "No file Selected";
         }
         else {
              // unacceptable file type
              $result['errors'][] = "$filename cannot be uploaded. Acceptable file types: gif, jpg, png,csv.";
         }
      }
      return $result;
    }
  
    public function sendEmail($receipient,$cc, $subject, $msg,$replyto){
	$email = new CakeEmail('smtp');
       	$email->sendAs = 'text';
   	//FIXME(Balaji Kutty, 2012-05-25)
	//Unable to get the template working with email. Fix it.

	//$email->template = 'passwd_reset';  
	//$email->set('password', $str);
	$email->delivery = 'smtp';  
  if($replyto != null)
  $email->replyTo($replyto);
	$email->subject($subject);
	$email->to($receipient);
	if($cc != null)
    $email->cc($cc);
   $email->helpers(array("Html"));
    $email->template("default");
    $email->emailFormat("html");
	if($email->send($msg))
      return true;
     
    }

public function sendMailWithAttachment($to, $file,$subject,$contents,$msg) {
       
    $email = new CakeEmail('smtp');
    $email->sendAs = 'text';
    $email->delivery = 'smtp';
    $email->subject($subject);
    $email->to($to);
    $email->helpers(array("Html"));
    $email->template("default");
    $email->emailFormat("html");
    $email->attachments($file);
    $email->viewVars($contents);
    if ($email->send($msg)) {
        return true;
      }
        return false;
    }
}
