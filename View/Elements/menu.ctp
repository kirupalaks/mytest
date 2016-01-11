<div class="menu" style="float:left;margin-top:45px;">
 <div>
<div class="span1" style="padding-left:6px;">

<?php 
          $user = $this->Session->read("Auth.User"); 
          $uri = $_SERVER["REQUEST_URI"];
          $admin = false;
          if($user != null) {
            if(array_key_exists('Student',$user)) {
              $user = $user['Student'];
            }
            else if(array_key_exists('Admin',$user)) {
              $user = $user['Admin'];
              $admin = true;
            }
          }
if($user['email'] != ""){
             if(!$admin)    {
$menu = <<<begin
<ul style="list-style-type:none;">
<li class=\"active1\" id="\less\" style=\"list-style-type:none;text-align:right;border-bottom-left-radius:2px;border-top-left-radius:15px;float:left;background-color:#BCDE59;width:125px;padding:5px 5px 5px 5px;margin-top:27px;\"><b><a href=\"#\" style=\"text-decoration:none;list-style-type:none;color:black;\">Lesson</a></b></li><li id=\"forum\" style=\"list-style-type:none;text-align:right;border-bottom-left-radius:2px;border-top-left-radius:15px;float:left;background-color:#E8F3C5;width:125px;padding:5px 5px 5px 5px;\"><b><a href=\"#\" style=\"text-decoration:none;color:black;\">Forum</a></b></li><li id=\"cale\" style=\"border-bottom-left-radius:2px;list-style-type:none;text-align:right;border-top-left-radius:15px;float:left;background-color:#E8F3C5;width:125px;padding:5px 5px 5px 5px;margin-top:20px;\"><b>Calender</b></li><li id=\"inbox\" style=\"list-style-type:none;text-align:right;border-bottom-left-radius:2px;border-top-left-radius:15px;float:left;background-color:#E8F3C5;width:125px;padding:5px 5px 5px 5px;margin-top:20px;\"><b>Inbox</b></li><li id=\"emailtea\" style=\"list-style-type:none;text-align:right;border-bottom-left-radius:2px;border-top-left-radius:15px;float:left;background-color:#E8F3C5;width:125px;padding:5px 5px 5px 5px;margin-top:20px;\"><b>Email Teacher</b></li><li id=\"adminreq\" style=\"list-style-type:none;text-align:right;border-bottom-left-radius:2px;border-top-left-radius:15px;float:left;background-color:#E8F3C5;width:125px;padding:5px 5px 5px 5px;margin-top:20px;\"><b>Admin Request</b></li><li id=\"shr\" style=\"list-style-type:none;text-align:right;border-bottom-left-radius:2px;border-top-left-radius:15px;float:left;background-color:#E8F3C5;width:125px;padding:5px 5px 5px 5px;margin-top:20px;\"><b>Share</b></li><li id=\"cmt\" style=\"list-style-type:none;text-align:right;border-bottom-left-radius:2px;border-top-left-radius:15px;float:left;background-color:#E8F3C5;width:125px;padding:5px 5px 5px 5px;margin-top:20px;\"><b>Comment</b></li></ul>
begin;
echo $menu;
}
}?>
</div>
</div>
</div>
