<div class="menu">
<div class="span1" style="float:left;padding-left:6px;">
<ul>
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
echo " <li class=\"active1\" id="\less\" style=\"list-style-type:none;text-align:right;border-bottom-left-radius:2px;border-top-left-radius:15px;float:left;background-color:#BCDE59;width:125px;padding:5px 5px 5px 5px;margin-top:27px;\"><b><a href=\"#\" style=\"text-decoration:none;list-style-type:none;color:black\">Lesson</a></b></li>
  <li id=\"forum\" style=\"text-align:right;list-style-type:none;border-bottom-left-radius:2px;border-top-left-radius:15px;float:left;background-color:#E8F3C5;width:125px;padding:5px 5px 5px 5px;margin-top:20px;\"><b><a href=\"#\" style=\"text-decoration:none;color:black;\">Forum</a></b></li>
<li id=\"cale\" style=\"text-align:right;border-bottom-left-radius:2px;list-style-type:none;border-top-left-radius:15px;float:left;background-color:#E8F3C5;width:125px;padding:5px 5px 5px 5px;margin-top:20px;\"><b>Calender</b></li>
<li id=\"inbox\" style=\"text-align:right;list-style-type:none;border-bottom-left-radius:2px;border-top-left-radius:15px;float:left;background-color:#E8F3C5;width:125px;padding:5px 5px 5px 5px;margin-top:20px;\"><b>Inbox</b></li>
<li id=\"emailtea\" style=\"text-align:right;list-style-type:none;border-bottom-left-radius:2px;border-top-left-radius:15px;float:left;background-color:#E8F3C5;width:125px;padding:5px 5px 5px 5px;margin-top:20px;\"><b>Email Teacher</b></li>
<li id=\"adminreq\" style=\"text-align:right;list-style-type:none;border-bottom-left-radius:2px;border-top-left-radius:15px;float:left;background-color:#E8F3C5;width:125px;padding:5px 5px 5px 5px;margin-top:20px;\"><b>Admin Request</b></li>
<li id=\"shr\" style=\"text-align:right;list-style-type:none;border-bottom-left-radius:2px;border-top-left-radius:15px;float:left;background-color:#E8F3C5;width:125px;padding:5px 5px 5px 5px;margin-top:20px;\"><b>Share</b></li>
<li id=\"cmt\" style=\"text-align:right;list-style-type:none;border-bottom-left-radius:2px;border-top-left-radius:15px;float:left;background-color:#E8F3C5;width:125px;padding:5px 5px 5px 5px;margin-top:20px;\"><b>Comment</b></li>";
?>
</ul>

}
}
</div>
</div>
