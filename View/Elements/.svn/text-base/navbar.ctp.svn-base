<div id="nvbar" class="navbar topnavbar navbar-fixed-top">
		<div class="navbar-inner">
			<div class="container">
	<?php 
          $user = $this->Session->read("Auth.User"); 
            $uri = $_SERVER["REQUEST_URI"];
         $url = split("/", $uri);
          $admin = false;
               if($user != null) {
            if(array_key_exists('Student',$user)) {
              $user = $user['Student'];
            }
            else if(array_key_exists('ClassroomStudent',$user)) {
              $user = "classroom";
            }
            else if(array_key_exists('Admin',$user)) {
              $user = $user['Admin'];
              $admin = true;
            }           
          }          
         if($uri =="/hindu_registration" || $uri =="/hsignup" || $uri =="/hlogin" || 
          	$url[count($url)-2]=="hlogin_success"){
          	// echo "<h3 class=\"pull-left\" style=\"margin-top:15px\">The Hindu AhaGuru Physics 
          	// Challenge Registration </h3>";
          	 echo "<span class=\"brand pull-left span10\" id='web-nav-reg' rel='tooltip' data-placement='right' title=\"Math and Science made Easy!\" style=\"outline:none; padding-bottom:5px;\" id=\"logoMenu\"><img src=\"".Router::url("/img/Hindu_logo.png")."\"></span>";
             
             echo "<span rel='tooltip' data-placement='right' id='mob-nav-reg' title='Math and Science made Easy!' style='outline:none; padding-bottom:5px;' id='logoMenu'><span><img src='/img/HinAha_logo.png' style='padding-top:12px;' class='reglogo-styl'></span><span style='color:#d20023;font-size:11px;'><b>The Hindu Ahaguru Physics Challenge Registration</b></span></span>";
          }

        else if(!isset($user['email']) && (strtolower($uri) == "/thehindu" || strtolower($uri) == "/hindu" || strtolower($uri) == "/thehindu?utm_source=thinkvidya" 
        	|| strtolower($uri) == "/thehindu?utm_source=quiz" || 
        	strtolower($uri) == "/thehindu?utm_source=facebook" || 
        	strtolower($uri) == "/thehindu?utm_source=free_signup" 
        	|| strtolower($uri) == "/hindu?utm_source=thinkvidya" 
        	|| strtolower($uri) == "/hindu?utm_source=quiz" || 
        	strtolower($uri) == "/hindu?utm_source=facebook" || 
        	strtolower($uri) == "/hindu?utm_source=free_signup")){
          	  	 echo "<a href=\"https://pay.hindu.com/esubspay/\" target=\"_blank\"><span class=\"brand pull-left\"  rel='tooltip' data-placement='right' title=\"Math and Science made Easy!\" style=\"outline:none; padding-bottom:5px;\" id=\"hinduweblogoMenu\"><img src=\"".Router::url("/img/Hindu_Ahaguru_white.jpg")."\"></span></a>";
          	  	 echo "<a href=\"https://pay.hindu.com/esubspay/\" target=\"_blank\"><span class=\"brand pull-left\"  rel='tooltip' data-placement='right' title=\"Math and Science made Easy!\" style=\"outline:none; padding-bottom:5px;\" id=\"hindumoblogoMenu\"><img src=\"".Router::url("/img/Hin_logo.png")."\"></span></a>";        			
          }
          elseif ($uri=="/hinduresults") {
            echo "<a href=\"/\"><span class=\"brand pull-left span8\" id='web-nav-reg' rel='tooltip' data-placement='right' title=\"Math and Science made Easy!\" style=\"outline:none; padding-bottom:5px;\" id=\"logoMenu\"><img src=\"".Router::url("/img/resultlogo.png")."\"></span></a>";
          }
          else if(isset($user['email']) && $uri =="/student/hallticket"){
            // echo "<h3 class=\"pull-left\" style=\"margin-top:15px\">The Hindu AhaGuru Physics 
            // Challenge Registration </h3>";
             echo "<span class=\"brand pull-left span8\" id='web-nav-reg' rel='tooltip' data-placement='right' title=\"Math and Science made Easy!\" style=\"outline:none; padding-bottom:5px;\" id=\"logoMenu\"><img src=\"".Router::url("/img/hallticketlogo.png")."\"></span>";
             
             echo "<span rel='tooltip' data-placement='right' id='mob-nav-reg' title='Math and Science made Easy!' style='outline:none; padding-bottom:5px;' id='logoMenu'><span><img src='/img/HinAha_logo.png' style='padding-top:12px;' class='reglogo-styl'></span><span style='color:#d20023;font-size:11px;'><b>The Hindu Ahaguru Physics Challenge Registration</b></span></span>";
          }
          else{
		    echo "<a class=\"brand pull-left\" onClick=\"window.location.href\" href='/' rel='tooltip' data-placement='right' title=\"Math and Science made Easy!\" style=\"outline:none; padding-bottom:7px;\" id=\"logoMenu\"><img src=\"".Router::url("/img/logo.png")."\" class='head-logo'></a>";
		    echo "<a class=\"brand pull-left\" onClick=\"window.location.href\" href='/' rel='tooltip' data-placement='right' title=\"Math and Science made Easy!\" style=\"outline:none; padding-bottom:5px;\" id=\"logoMenu\"><img src=\"".Router::url("/img/moblogo.png")."\" class='head-logo-mob'></a>";
		}?>
		

   
   <div class="resp-nav pull-right" >
            <?php 
          $user = $this->Session->read("Auth.User"); 
            $uri = $_SERVER["REQUEST_URI"];
         $url = split("/", $uri);
          $admin = false;
               if($user != null) {
            if(array_key_exists('Student',$user)) {
              $user = $user['Student'];
            }
            else if(array_key_exists('ClassroomStudent',$user)) {
              $user = "classroom";
            }
            else if(array_key_exists('Admin',$user)) {
              $user = $user['Admin'];
              $admin = true;
            }
          }
           if($user == "classroom" && ($uri == "/books" || $uri == "/student/books")){
          	echo  "<!--<span class=\"topmenu pull-right\" style=\"color:#009EE3\"><strong>Contact us: +91 96001 00090</strong>
		</span>-->
				<br>
					<ul class=\"pull-right nav\" style=\"margin:10px 0 0\">
			<li><a href=\"".Router::url("/online")."\">Online Courses</a></li>
		 <li><a href=\"".Router::url("/student/student/classroom")."\">Classroom</a></li>
		<li class=\"active\"><a href=\"".Router::url("/books")."\">Books</a></li>		
		
					</ul>";
          }
          else if($user == "classroom" && $uri == "/student/student/classroom"){
          	echo  "<!--<span class=\"topmenu pull-right\" style=\"color:#009EE3\"><strong>Contact us: +91 96001 00090</strong>
		</span>-->
				<br>
					<ul class=\"pull-right nav\" style=\"margin:10px 0 0\">
			<li id=\"online\"><a style=\"cursor:pointer\">Online Courses</a></li>
		 <li class=\"active\"><a href=\"".Router::url("/student/student/classroom")."\">Classroom</a></li>
		<li><a href=\"".Router::url("/books")."\">Books</a></li>		
		
					</ul>";
          }
          else if($user == "classroom"){
          	echo  "<!--<span class=\"topmenu pull-right\" style=\"color:#009EE3\"><strong>Contact us: +91 96001 00090</strong>
		</span>-->
				<br>
					<ul class=\"pull-right nav\" style=\"margin:10px 0 0\">
			<li id=\"online\"><a style=\"cursor:pointer\">Online Courses</a></li>
		 <li><a href=\"".Router::url("/student/student/classroom")."\">Classroom</a></li>
		<li><a href=\"".Router::url("/books")."\">Books</a></li>		
		
					</ul>";
          }
        else if(!isset($user['email']) && (strtolower($uri) == "/thehindu" || strtolower($uri) == "/hindu" || strtolower($uri) == "/thehindu?utm_source=thinkvidya" 
        	|| strtolower($uri) == "/thehindu?utm_source=quiz" || 
        	strtolower($uri) == "/thehindu?utm_source=facebook" || 
        	strtolower($uri) == "/thehindu?utm_source=free_signup" 
        	|| strtolower($uri) == "/hindu?utm_source=thinkvidya" 
        	|| strtolower($uri) == "/hindu?utm_source=quiz" || 
        	strtolower($uri) == "/hindu?utm_source=facebook" || 
        	strtolower($uri) == "/hindu?utm_source=free_signup")){
          	  echo  "<ul class=\"pull-right nav\" style=\"margin:0 0 0\">
            <li><span class=\"nav mob-cont\" style=\"color:#009EE3;padding-bottom:25px\">
             <strong>Contact +91 96001 00090</strong></span></li>";
          echo "<li><span class=\"btn btn-success\" data-backdrop=\"static\" data-toggle=\"modal\" data-target=\"#enquiryModal\" style=\"margin: 15px 0px 0px 6px;\">Enquiry</span></li>
          </ul>"; 
				}
          // else if($user['email'] == "" && $uri == "/" ) {          
          else if(!isset($user['email']) && ($uri == "/" || $uri == "/online" || $uri == "/books" || $uri == "/classroom")) {
		echo  "<!--<span class=\"topmenu pull-right\" style=\"color:#009EE3\"><strong>Contact us: +91 96001 00090</strong>
		</span>-->
				<br>
					<ul class=\"pull-right nav\" style=\"margin:0 0 0\">
			<!-- <li><a href=\"".Router::url("/hindu")."\">Hindu</a></li>-->
			<!--<li><a href=\"".Router::url("/online")."\">Online Courses</a></li>
						<li><a href=\"".Router::url("/classroom")."\">Classroom</a></li>
						<li><a href=\"".Router::url("/books")."\">Books</a></li>-->
						 <!--<li  style=\"margin-top:-2px;\">
						<a href=\"".Router::url("/quiz")."\" rel=\"tooltip\" data-placement=\"right\" style=\"text-decoration:none\" title=\" Science & Math Quiz 2015\">
						<button class=\"btn\" style=\"background-image:url('/img/yellowbtn.png')\"><b>Quiz 2015</b>
						</button></a>
						</li>	-->

						<li style=\"margin-left:10px;margin-top:8px;\"><button class=\"btn btn-success\" data-toggle=\"modal\" data-target=\"#couponModal\" data-backdrop=\"static\" id=\"couponLink\" style=\"margin-right:10px;\">Coupon</button></li>
            <li style=\"margin-top:8px;\"><button class=\"btn btn-success\" data-toggle=\"modal\" data-target=\"#signinModal\" data-backdrop=\"static\" id=\"loginLink\" style=\"margin-right:10px;\">Sign in</button></li>
						<!--<li style=\"margin-top:8px;\"><button class=\"btn btn-signup\" data-toggle=\"modal\" data-backdrop=\"static\" data-target=\"#signupModal\" id=\"signupLink\">Sign up</button></li>-->
					</ul>";
					
       }
       else if(isset($user['email']) && $uri =="/student/hallticket"){            
          }
//      else if($user['email'] == "" && $uri =="/books" ){
//         		echo  "<!--<span class=\"topmenu pull-right\" style=\"color:#009EE3\"><strong>Contact us: +91 96001 00090</strong>
// 		</span>-->
// 				<br>
// 					<ul class=\"pull-right nav\" style=\"margin:0 0 0\">
// 					<li><a href=\"".Router::url("/hindu")."\">Hindu</a></li>
// 			<li><a href=\"".Router::url("/online")."\">Online Courses</a></li>
// 						<li><a href=\"".Router::url("/classroom")."\">Classroom</a></li>
// 						<li class=\"active\"><a href=\"".Router::url("/books")."\">Books</a></li>
//                         <!--<li  style=\"margin-top:-2px;\">
// 						<a href=\"".Router::url("/quiz")."\" rel=\"tooltip\" data-placement=\"right\" style=\"text-decoration:none\" title=\" Science & Math Quiz 2015\">
// 						<button class=\"btn\" style=\"background-image:url('/img/yellowbtn.png')\"><b>Quiz 2015</b>
// 						</button></a>
// 						</li>	-->
// 						<li style=\"margin-left:10px;margin-top:8px;\"><button class=\"btn btn-success\" data-toggle=\"modal\" data-target=\"#couponModal\" data-backdrop=\"static\" id=\"couponLink\" style=\"margin-right:10px;\">Coupon</button></li>
// <li style=\" margin-top:8px;\"><button class=\"btn btn-success\" data-toggle=\"modal\" data-target=\"#signupModal\" data-backdrop=\"static\" id=\"loginLink\" style=\"margin-right:10px;\">Log in</button></li>
// 						<li style=\"margin-top:8px;\"><button class=\"btn btn-signup\" data-toggle=\"modal\" data-backdrop=\"static\" data-target=\"#signupModal\" id=\"signupLink\">Sign up</button></li>
// 					</ul>";
//        }
//             else if($user['email'] == "" && $uri =="/hindu" ){
//         		echo  "<!--<span class=\"topmenu pull-right\" style=\"color:#009EE3\"><strong>Contact us: +91 96001 00090</strong>
// 		</span>-->
// 				<br>
// 			<ul class=\"pull-right nav\" style=\"margin:0 0 0\">
// 			<li class=\"active\"><a href=\"".Router::url("/hindu")."\">Hindu</a></li>
// 			<li><a href=\"".Router::url("/online")."\">Online Courses</a></li>

// 						<li><a href=\"".Router::url("/classroom")."\">Classroom</a></li>
// 						<li><a href=\"".Router::url("/books")."\">Books</a></li>
//                         <!--<li  style=\"margin-top:-2px;\">
// 						<a href=\"".Router::url("/quiz")."\" rel=\"tooltip\" data-placement=\"right\" style=\"text-decoration:none\" title=\" Science & Math Quiz 2015\">
// 						<button class=\"btn\" style=\"background-image:url('/img/yellowbtn.png')\"><b>Quiz 2015</b>
// 						</button></a>
// 						</li>	-->
// 						<li style=\"margin-left:10px;margin-top:8px;\"><button class=\"btn btn-success\" data-toggle=\"modal\" data-target=\"#couponModal\" data-backdrop=\"static\" id=\"couponLink\" style=\"margin-right:10px;\">Coupon</button></li>
// <li style=\" margin-top:8px;\"><button class=\"btn btn-success\" data-toggle=\"modal\" data-target=\"#signupModal\" data-backdrop=\"static\" id=\"loginLink\" style=\"margin-right:10px;\">Log in</button></li>
// 						<li style=\"margin-top:8px;\"><button class=\"btn btn-signup\" data-toggle=\"modal\" data-backdrop=\"static\" data-target=\"#signupModal\" id=\"signupLink\">Sign up</button></li>
// 					</ul>";
//        }
//       else if($user['email'] == "" && $uri =="/online"){
//          		echo  "<!--<span class=\"topmenu pull-right\" style=\"color:#009EE3\"><strong>Contact us: +91 96001 00090</strong>
// 		</span>-->
// 				<br>
// 					<ul class=\"pull-right nav\" style=\"margin:0 0 0\">
// 			<li class=\"active\"><a href=\"".Router::url("/online")."\">Online Courses</a></li>
// 			<li><a href=\"".Router::url("/classroom")."\">Classroom</a></li>
// 			<li><a href=\"".Router::url("/books")."\">Books</a></li>
// 				 <!--<li  style=\"margin-top:-2px;\">
// 						<a href=\"".Router::url("/quiz")."\" rel=\"tooltip\" data-placement=\"right\" style=\"text-decoration:none\" title=\" Science & Math Quiz 2015\">
// 						<button class=\"btn\" style=\"background-image:url('/img/yellowbtn.png')\"><b>Quiz 2015</b>
// 						</button></a>
// 						</li>	-->
// 			<li style=\" margin-left:10px;margin-top:8px;\"><button class=\"btn btn-success\" data-toggle=\"modal\" data-target=\"#couponModal\" id=\"couponLink\" data-backdrop=\"static\" style=\"margin-right:10px;\">Coupon</button></li>
// <li style=\" margin-top:8px;\"><button class=\"btn btn-success\" data-toggle=\"modal\" data-target=\"#signupModal\" data-backdrop=\"static\" id=\"loginLink\" style=\"margin-right:10px;\">Log in</button></li>
// 						<li style=\"margin-top:8px;\"><button class=\"btn btn-signup\" data-backdrop=\"static\" data-toggle=\"modal\" data-target=\"#signupModal\" id=\"signupLink\">Sign up</button></li>
// 					</ul>";
//        }
//       else if($user['email'] == "" && $uri == "/classroom"){
//           		echo  "<!--<span class=\"topmenu pull-right\" style=\"color:#009EE3\"><strong>Contact us: +91 96001 00090</strong>
// 		</span>-->
// 				<br>
// 					<ul class=\"pull-right nav\" style=\"margin:0 0 0\">
// 			<li><a href=\"".Router::url("/online")."\">Online Courses</a></li>
// 		 <li class=\"active\"><a href=\"".Router::url("/classroom")."\">Classroom</a></li>
// 		<li><a href=\"".Router::url("/books")."\">Books</a></li>
// 		 <!--<li  style=\"margin-top:-2px;\">
// 						<a href=\"".Router::url("/quiz")."\" rel=\"tooltip\" data-placement=\"right\" style=\"text-decoration:none\" title=\" Science & Math Quiz 2015\">
// 						<button class=\"btn\" style=\"background-image:url('/img/yellowbtn.png')\"><b>Quiz 2015</b>
// 						</button></a>
// 						</li>		-->
// 		<li style=\" margin-left:10px;margin-top:8px;\"><button class=\"btn btn-success\" data-toggle=\"modal\" data-backdrop=\"static\" data-target=\"#couponModal\" id=\"couponLink\" style=\" margin-right:10px;\">Coupon</button></li>
//     <li style=\" margin-top:8px;\"><button class=\"btn btn-success\" data-toggle=\"modal\" data-backdrop=\"static\" data-target=\"#signupModal\" id=\"loginLink\"  style=\"margin-right:10px;\">Log in</button></li>
// 						<li style=\"margin-top:8px;\"><button class=\"btn btn-signup\" data-backdrop=\"static\" data-toggle=\"modal\" data-target=\"#signupModal\" id=\"signupLink\">Sign up</button></li>
// 					</ul>";
//       }
//       else if($user['email'] == "" && $uri == "/quiz"){
//           		echo  "<!--<span class=\"topmenu pull-right\" style=\"color:#009EE3\"><strong>Contact us: +91 96001 00090</strong>
// 		</span>-->
// 				<br>
// 					<ul class=\"pull-right nav\" style=\"margin:0 0 0\">
// 			<li><a href=\"".Router::url("/online")."\">Online Courses</a></li>
// 		 <li><a href=\"".Router::url("/classroom")."\">Classroom</a></li>
// 		<li><a href=\"".Router::url("/books")."\">Books</a></li>
// 		         <!--<li class=\"active\" style=\"margin-top:-2px;\">
// 						<a href=\"".Router::url("/quiz")."\" rel=\"tooltip\" data-placement=\"right\" style=\"text-decoration:none\" title=\" Science & Math Quiz 2015\">
// 						<button class=\"btn\" style=\"background-image:url('/img/yellowbtn.png')\"><b>Quiz 2015</b>
// 						</button></a>
// 						</li>	-->
// 		<li style=\" margin-left:10px;margin-top:8px;\"><button class=\"btn btn-success\" data-toggle=\"modal\" data-backdrop=\"static\" data-target=\"#couponModal\" id=\"couponLink\" style=\" margin-right:10px;\">Coupon</button></li>
// <li style=\" margin-top:8px;\"><button class=\"btn btn-success\" data-toggle=\"modal\" data-target=\"#signupModal\" data-backdrop=\"static\" id=\"loginLink\"  style=\"margin-right:10px;\">Log in</button></li>
// 						<li style=\"margin-top:8px;\"><button class=\"btn btn-signup\" data-backdrop=\"static\" data-toggle=\"modal\" data-target=\"#signupModal\" id=\"signupLink\">Sign up</button></li>
// 					</ul>";
//       }      
else if(isset($user['email']) && $url[count($url)-2] == "save" ){
echo "<div class=\"topmenu btn-group\">
		<a href=\"#\" class=\"dropdown-toggle\" data-toggle=\"dropdown\">".$user['name']." <span class=\"caret\" style=\"vertical-align:middle;\"></span></a>
		</div>";
}

else if(isset($user['email'])){
  if(!$admin && $uri == "/student/puzzler"){
	echo	"<span class=\"topmenu\"><a href=\"".Router::url("/student/student/allcourse")."\" rel='tooltip' data-placement='bottom' title=\"Your Cart. Purchase Now!\">Purchase <img src=\"" .Router::url("/img/cart.png")."\"></a></span>
					<!--<div class=\"topmenu btn-group\">
						<a href=\"#\" class=\"dropdown-toggle\" data-toggle=\"dropdown\">".$user['name']." <span class=\"caret\" style=\"vertical-align:middle;\"></span></a>
		<ul class=\"dropdown-menu\" role=\"menu\" aria-labelledby=\"dLabel\">
							<li><a href=\"".Router::url("/student/".$user['id'])."\"><i class=\"icon-edit\"></i> Update Profile</a></li>
							<li><a href=\"".Router::url("/resetpwd")."\"><i class=\"icon-lock\"></i> Change Password</a></li>
							<li class=\"divider\"></li>
							<li><a href=\"".Router::url("/logout")."\"><i class=\"icon-off\"></i> Logout</a></li>
						</ul>
					</div>-->
				</div>
					<ul class=\"pull-right nav\" style=\"margin:0 0 0\">
					
						<li class=\"active\"><a id=\"dfree\" href=\"#\" data-href=\"".Router::url("/student/puzzler")."\">Free Zone</a></li>
						<li><a  href=\"".Router::url("/student/course")."\">My Courses</a></li>
						<li><a id=\"dall\" href=\"#\" data-href=\"".Router::url("/student/student/allcourse")."\">Online Courses</a></li>
       	
						<li><a id=\"dmyprog\" href=\"#\" data-href=\"".Router::url("/student/progress")."\">My Progress</a></li>
						<li><a id=\"dmyclass\" href=\"#\" data-href=\"".Router::url("/student/classroom")."\">My Classroom</a></li>
                <li>  <a href=\"#\" class=\"dropdown-toggle\" data-toggle=\"dropdown\">".$user['name']." <span class=\"caret\" style=\"vertical-align:middle;\"></span></a>
                    <ul class=\"dropdown-menu\" role=\"menu\" aria-labelledby=\"dLabel\">
              <li><a href=\"".Router::url("/student/".$user['id'])."\"><i class=\"icon-edit\"></i> Update Profile</a></li>
              <li><a href=\"".Router::url("/resetpwd")."\"><i class=\"icon-lock\"></i> Change Password</a></li>
              <li class=\"divider\"></li>
              <li><a href=\"".Router::url("/logout")."\"><i class=\"icon-off\"></i> Logout</a></li>
              <li>
            </ul></li>
					</ul>
			</div>
		</div>
	</div>"	;

}

else if(!$admin && $uri == "/student/student/allcourse" || $uri == "/student/student/allcourse#"|| !$admin && $uri =="/hindu" || !$admin && $uri == "/online" ){
	echo	"<!--<span class=\"topmenu\"><a href=\"".Router::url("/student/student/allcourse")."\" rel='tooltip' data-placement='bottom' title=\"Your Cart. Purchase Now!\">Purchase <img src=\"" .Router::url("/img/cart.png")."\"></a></span>-->
					<!--<div class=\"topmenu btn-group pull-right\">
						<a href=\"#\" class=\"dropdown-toggle\" data-toggle=\"dropdown\">".$user['name']." <span class=\"caret\" style=\"vertical-align:middle;\"></span></a>
		                <ul class=\"dropdown-menu\" role=\"menu\" aria-labelledby=\"dLabel\">
							<li><a href=\"".Router::url("/student/".$user['id'])."\"><i class=\"icon-edit\"></i> Update Profile</a></li>
							<li><a href=\"".Router::url("/resetpwd")."\"><i class=\"icon-lock\"></i> Change Password</a></li>
							<li class=\"divider\"></li>
							<li><a href=\"".Router::url("/logout")."\"><i class=\"icon-off\"></i> Logout</a></li>
						</ul>
					</div>-->
				<br>
					<ul class=\"pull-right nav\" style=\"margin:0 0 0\">
					
						<!--<li ><a id=\"dfree\" href=\"#\" data-href=\"".Router::url("/student/puzzler")."\">Free Zone</a></li>-->
						<li><a  href=\"".Router::url("/student/course")."\">My Courses</a></li>
						<!--<li class=\"active\"><a id=\"all\" href=\"".Router::url("/student/student/allcourse")."\">Online Courses</a></li>
       	                 <li><a id=\"all\" href=\"".Router::url("/student/classroom")."\">Classroom</a></li>
						<li><a id=\"all\" href=\"".Router::url("/student/books")."\">Books</a></li>-->
						
       	               <li><a id=\"all\" class=\"couponLink\"  data-toggle=\"modal\" data-backdrop=\"static\" data-target=\"#couponModal\" href=\"#\">Coupon</a></li>
						<!--<li><a id=\"dmyprog\" href=\"#\" data-href=\"".Router::url("/student/progress")."\">My Progress</a></li>
						<li><a id=\"dmyclass\" href=\"#\" data-href=\"".Router::url("/student/classroom")."\">My Classroom</a></li>-->
                <li>  <a href=\"#\" class=\"dropdown-toggle\" data-toggle=\"dropdown\">".$user['name']." <span class=\"caret\" style=\"vertical-align:middle;\"></span></a>
                    <ul class=\"dropdown-menu\" role=\"menu\" aria-labelledby=\"dLabel\">
              <li><a href=\"".Router::url("/student/".$user['id'])."\"><i class=\"icon-edit\"></i> Update Profile</a></li>
              <li><a href=\"".Router::url("/resetpwd")."\"><i class=\"icon-lock\"></i> Change Password</a></li>
              <li class=\"divider\"></li>
              <li><a href=\"".Router::url("/logout")."\"><i class=\"icon-off\"></i> Logout</a></li>
              <li>
            </ul></li>
					</ul>
			</div>
			</div>
		</div>
	</div>"	;

}
else if(!$admin && $uri == "/student/books" || $uri == "/student/books#"){
	echo	"<!--<span class=\"topmenu\"><a href=\"".Router::url("/student/student/allcourse")."\" rel='tooltip' data-placement='bottom' title=\"Your Cart. Purchase Now!\">Purchase <img src=\"" .Router::url("/img/cart.png")."\"></a></span>-->
					<!--<div class=\"topmenu btn-group pull-right\">
						<a href=\"#\" class=\"dropdown-toggle\" data-toggle=\"dropdown\">".$user['name']." <span class=\"caret\" style=\"vertical-align:middle;\"></span></a>
		                <ul class=\"dropdown-menu\" role=\"menu\" aria-labelledby=\"dLabel\">
							<li><a href=\"".Router::url("/student/".$user['id'])."\"><i class=\"icon-edit\"></i> Update Profile</a></li>
							<li><a href=\"".Router::url("/resetpwd")."\"><i class=\"icon-lock\"></i> Change Password</a></li>
							<li class=\"divider\"></li>
							<li><a href=\"".Router::url("/logout")."\"><i class=\"icon-off\"></i> Logout</a></li>
						</ul>
					</div>-->
				<br>
					<ul class=\"pull-right nav\" style=\"margin:0 0 0\">
					
						<!--<li ><a id=\"dfree\" href=\"#\" data-href=\"".Router::url("/student/puzzler")."\">Free Zone</a></li>-->
						<li><a  href=\"".Router::url("/student/course")."\">My Courses</a></li>
						<!--<li><a id=\"all\" href=\"".Router::url("/student/student/allcourse")."\">Online Courses</a></li>
       	                 <li><a id=\"all\" href=\"".Router::url("/student/classroom")."\">Classroom</a></li>
						<li class=\"active\"><a id=\"all\" href=\"".Router::url("/student/books")."\">Books</a></li>
						-->
       	               <li><a id=\"all\" class=\"couponLink\"  data-toggle=\"modal\" data-backdrop=\"static\" data-target=\"#couponModal\" href=\"#\">Coupon</a></li>
						<!--<li><a id=\"dmyprog\" href=\"#\" data-href=\"".Router::url("/student/progress")."\">My Progress</a></li>
						<li><a id=\"dmyclass\" href=\"#\" data-href=\"".Router::url("/student/classroom")."\">My Classroom</a></li>-->
                <li>  <a href=\"#\" class=\"dropdown-toggle\" data-toggle=\"dropdown\">".$user['name']." <span class=\"caret\" style=\"vertical-align:middle;\"></span></a>
                    <ul class=\"dropdown-menu\" role=\"menu\" aria-labelledby=\"dLabel\">
              <li><a href=\"".Router::url("/student/".$user['id'])."\"><i class=\"icon-edit\"></i> Update Profile</a></li>
              <li><a href=\"".Router::url("/resetpwd")."\"><i class=\"icon-lock\"></i> Change Password</a></li>
              <li class=\"divider\"></li>
              <li><a href=\"".Router::url("/logout")."\"><i class=\"icon-off\"></i> Logout</a></li>
              <li>
            </ul></li>
					</ul>
			</div>
			</div>
		</div>
	</div>"	;
}
else if(!$admin && ($uri == "/student/course/1" || $uri == "/student/agpuzzler" || 
  $url[count($url)-2] == "agpuzzler")){
  echo  "<!--<span class=\"topmenu\"><a href=\"".Router::url("/student/student/allcourse")."\" rel='tooltip' data-placement='bottom' title=\"Your Cart. Purchase Now!\">Purchase <img src=\"" .Router::url("/img/cart.png")."\"></a></span>-->
          <!--<div class=\"topmenu btn-group pull-right\">
            <a href=\"#\" class=\"dropdown-toggle\" data-toggle=\"dropdown\">".$user['name']." <span class=\"caret\" style=\"vertical-align:middle;\"></span></a>
                    <ul class=\"dropdown-menu\" role=\"menu\" aria-labelledby=\"dLabel\">
              <li><a href=\"".Router::url("/student/".$user['id'])."\"><i class=\"icon-edit\"></i> Update Profile</a></li>
              <li><a href=\"".Router::url("/resetpwd")."\"><i class=\"icon-lock\"></i> Change Password</a></li>
              <li class=\"divider\"></li>
              <li><a href=\"".Router::url("/logout")."\"><i class=\"icon-off\"></i> Logout</a></li>
            </ul>
          </div>-->
        <br>
          <ul class=\"pull-right nav\" style=\"margin:0 0 0\">
                                          
                       <li><a id=\"all\" class=\"couponLink\"  data-toggle=\"modal\" data-backdrop=\"static\" data-target=\"#couponModal\" href=\"#\">Coupon</a></li>
            <!--<li><a id=\"dmyprog\" href=\"#\" data-href=\"".Router::url("/student/progress")."\">My Progress</a></li>
            <li><a id=\"dmyclass\" href=\"#\" data-href=\"".Router::url("/student/classroom")."\">My Classroom</a></li>-->
                <li>  <a href=\"#\" class=\"dropdown-toggle\" data-toggle=\"dropdown\">".$user['name']." <span class=\"caret\" style=\"vertical-align:middle;\"></span></a>
                    <ul class=\"dropdown-menu\" role=\"menu\" aria-labelledby=\"dLabel\">
              <li><a href=\"".Router::url("/student/".$user['id'])."\"><i class=\"icon-edit\"></i> Update Profile</a></li>
              <li><a href=\"".Router::url("/resetpwd")."\"><i class=\"icon-lock\"></i> Change Password</a></li>
              <li class=\"divider\"></li>
              <li><a href=\"".Router::url("/logout")."\"><i class=\"icon-off\"></i> Logout</a></li>
              <li>
            </ul></li>
          </ul>
      </div>
      </div>
    </div>
  </div>" ;

}
else if(!$admin && $uri == "/student/student/classroom" || !$admin && $uri == "/student/classroom" || !$admin && $uri == "/classroom_register" || !$admin && $uri == "/classroom"){
	echo	"<!--<span class=\"topmenu\"><a href=\"".Router::url("/student/student/allcourse")."\" rel='tooltip' data-placement='bottom' title=\"Your Cart. Purchase Now!\">Purchase <img src=\"" .Router::url("/img/cart.png")."\"></a></span>-->
					<!--<div class=\"topmenu btn-group pull-right\">
						<a href=\"#\" class=\"dropdown-toggle\" data-toggle=\"dropdown\">".$user['name']." <span class=\"caret\" style=\"vertical-align:middle;\"></span></a>
		                <ul class=\"dropdown-menu\" role=\"menu\" aria-labelledby=\"dLabel\">
							<li><a href=\"".Router::url("/student/".$user['id'])."\"><i class=\"icon-edit\"></i> Update Profile</a></li>
							<li><a href=\"".Router::url("/resetpwd")."\"><i class=\"icon-lock\"></i> Change Password</a></li>
							<li class=\"divider\"></li>
							<li><a href=\"".Router::url("/logout")."\"><i class=\"icon-off\"></i> Logout</a></li>
              <li>
						</ul>
					</div>-->
				<br>
					<ul class=\"pull-right nav\" style=\"margin:0 0 0\">
					
						<!--<li ><a id=\"dfree\" href=\"#\" data-href=\"".Router::url("/student/puzzler")."\">Free Zone</a></li>-->
						<li><a  href=\"".Router::url("/student/course")."\">My Courses</a></li>
						<!--<li><a id=\"all\" href=\"".Router::url("/student/student/allcourse")."\">Online Courses</a></li>
       	                 <li class=\"active\"><a id=\"all\" href=\"".Router::url("/student/classroom")."\">Classroom</a></li>
						<li><a id=\"all\" href=\"".Router::url("/student/books")."\">Books</a></li>-->
       	               <li><a id=\"all\" class=\"couponLink\"  data-toggle=\"modal\" data-backdrop=\"static\" data-target=\"#couponModal\" href=\"#\">Coupon</a></li>
						<!--<li><a id=\"dmyprog\" href=\"#\" data-href=\"".Router::url("/student/progress")."\">My Progress</a></li>
						<li><a id=\"dmyclass\" href=\"#\" data-href=\"".Router::url("/student/classroom")."\">My Classroom</a></li>-->
            <li>  <a href=\"#\" class=\"dropdown-toggle\" data-toggle=\"dropdown\">".$user['name']." <span class=\"caret\" style=\"vertical-align:middle;\"></span></a>
                    <ul class=\"dropdown-menu\" role=\"menu\" aria-labelledby=\"dLabel\">
              <li><a href=\"".Router::url("/student/".$user['id'])."\"><i class=\"icon-edit\"></i> Update Profile</a></li>
              <li><a href=\"".Router::url("/resetpwd")."\"><i class=\"icon-lock\"></i> Change Password</a></li>
              <li class=\"divider\"></li>
              <li><a href=\"".Router::url("/logout")."\"><i class=\"icon-off\"></i> Logout</a></li>
              <li>
            </ul></li>
					</ul>
			</div>
			</div>
		</div>
	</div>"	;

}
else if(!$admin && $uri == "/books"){
	echo	"<!--<span class=\"topmenu\"><a href=\"".Router::url("/student/student/allcourse")."\" rel='tooltip' data-placement='bottom' title=\"Your Cart. Purchase Now!\">Purchase <img src=\"" .Router::url("/img/cart.png")."\"></a></span>-->
					<!--<div class=\"topmenu btn-group pull-right\">
						<a href=\"#\" class=\"dropdown-toggle\" data-toggle=\"dropdown\">".$user['name']." <span class=\"caret\" style=\"vertical-align:middle;\"></span></a>
		                <ul class=\"dropdown-menu\" role=\"menu\" aria-labelledby=\"dLabel\">
							<li><a href=\"".Router::url("/student/".$user['id'])."\"><i class=\"icon-edit\"></i> Update Profile</a></li>
							<li><a href=\"".Router::url("/resetpwd")."\"><i class=\"icon-lock\"></i> Change Password</a></li>
							<li class=\"divider\"></li>
							<li><a href=\"".Router::url("/logout")."\"><i class=\"icon-off\"></i> Logout</a></li>
						</ul>
					</div>-->
				<br>
					<ul class=\"pull-right nav\" style=\"margin:0 0 0\">
					
						<!--<li ><a id=\"dfree\" href=\"#\" data-href=\"".Router::url("/student/puzzler")."\">Free Zone</a></li>-->
						<li><a  href=\"".Router::url("/student/course")."\">My Courses</a></li>
						<!--<li><a id=\"all\" href=\"".Router::url("/student/student/allcourse")."\">Online Courses</a></li>
       	                 <li><a id=\"all\" href=\"".Router::url("/student/classroom")."\">Classroom</a></li>
						<li class=\"active\"><a id=\"all\" href=\"".Router::url("/student/books")."\">Books</a></li>-->
       	             <li><a id=\"all\" class=\"couponLink\" data-toggle=\"modal\" data-backdrop=\"static\" data-target=\"#couponModal\" href=\"#\">Coupon</a></li>
						<!--<li><a id=\"dmyprog\" href=\"#\" data-href=\"".Router::url("/student/progress")."\">My Progress</a></li>
						<li><a id=\"dmyclass\" href=\"#\" data-href=\"".Router::url("/student/classroom")."\">My Classroom</a></li>-->
                <li>  <a href=\"#\" class=\"dropdown-toggle\" data-toggle=\"dropdown\">".$user['name']." <span class=\"caret\" style=\"vertical-align:middle;\"></span></a>
                    <ul class=\"dropdown-menu\" role=\"menu\" aria-labelledby=\"dLabel\">
              <li><a href=\"".Router::url("/student/".$user['id'])."\"><i class=\"icon-edit\"></i> Update Profile</a></li>
              <li><a href=\"".Router::url("/resetpwd")."\"><i class=\"icon-lock\"></i> Change Password</a></li>
              <li class=\"divider\"></li>
              <li><a href=\"".Router::url("/logout")."\"><i class=\"icon-off\"></i> Logout</a></li>
              <li>
            </ul></li>
					</ul>
			</div>
			</div>
		</div>
	</div>"	;

}
else if(!$admin && $uri == "/student/progress"){
	echo	"<!--<span class=\"topmenu\"><a href=\"".Router::url("/student/student/allcourse")."\" rel='tooltip' data-placement='bottom' title=\"Your Cart. Purchase Now!\">Purchase <img src=\"" .Router::url("/img/cart.png")."\"></a></span>-->
				<!--	<div class=\"topmenu btn-group\">
						<a href=\"#\" class=\"dropdown-toggle\" data-toggle=\"dropdown\">".$user['name']." <span class=\"caret\" style=\"vertical-align:middle;\"></span></a>
		<ul class=\"dropdown-menu\" role=\"menu\" aria-labelledby=\"dLabel\">
							<li><a href=\"".Router::url("/student/".$user['id'])."\"><i class=\"icon-edit\"></i> Update Profile</a></li>
							<li><a href=\"".Router::url("/resetpwd")."\"><i class=\"icon-lock\"></i> Change Password</a></li>
							<li class=\"divider\"></li>
							<li><a href=\"".Router::url("/logout")."\"><i class=\"icon-off\"></i> Logout</a></li>
						</ul>
					</div>-->
				</div>
					<ul class=\"pull-right nav\" style=\"margin:0 0 0\">
					
						<li ><a id=\"dfree\" href=\"#\" data-href=\"".Router::url("/student/puzzler")."\">Free Zone</a></li>
						<li><a  href=\"".Router::url("/student/course")."\">My Courses</a></li>
						<li ><a id=\"dall\" href=\"#\" data-href=\"".Router::url("/student/student/allcourse")."\">Online Courses</a></li>
       	                 <li><a id=\"all\" href=\"".Router::url("/student/classroom")."\">Classroom</a></li>
						<li><a id=\"all\" href=\"".Router::url("/student/books")."\">Books</a></li>
       	               <li><a id=\"all\" class=\"couponLink\"  data-toggle=\"modal\" data-backdrop=\"static\" data-target=\"#couponModal\" href=\"#\">Coupon</a></li>
						<li class=\"active\"><a id=\"dmyprog\" href=\"#\" data-href=\"".Router::url("/student/progress")."\">My Progress</a></li>
						<li><a id=\"dmyclass\" href=\"#\" data-href=\"".Router::url("/student/classroom")."\">My Classroom</a></li>
                <li>  <a href=\"#\" class=\"dropdown-toggle\" data-toggle=\"dropdown\">".$user['name']." <span class=\"caret\" style=\"vertical-align:middle;\"></span></a>
                    <ul class=\"dropdown-menu\" role=\"menu\" aria-labelledby=\"dLabel\">
              <li><a href=\"".Router::url("/student/".$user['id'])."\"><i class=\"icon-edit\"></i> Update Profile</a></li>
              <li><a href=\"".Router::url("/resetpwd")."\"><i class=\"icon-lock\"></i> Change Password</a></li>
              <li class=\"divider\"></li>
              <li><a href=\"".Router::url("/logout")."\"><i class=\"icon-off\"></i> Logout</a></li>
              <li>
            </ul></li>
					</ul>
			</div>
		</div>
	</div>"	;

}
else if(!$admin && ($url[count($url)-2]=="hlogin_success" || $uri =="/hindu_registration" || $uri =="/hsignup" || $uri =="/hlogin")){
	// echo	"<div class=\"topmenu btn-group\">
	// 					<a class=\"dropdown-toggle\" data-toggle=\"dropdown\">".$user['name']." <span class=\"caret\" style=\"vertical-align:middle;\"></span></a>		
	// 				</div>
	// 			</div>
				
	// 		</div>
	// 	</div>
	// </div>"	;
	}
else if(!$admin && ($url[count($url)-2]=="login_success")){
echo	"<div class=\"topmenu btn-group\">
						<a href=\"#\" class=\"dropdown-toggle\" data-toggle=\"dropdown\">".$user['name']." <span class=\"caret\" style=\"vertical-align:middle;\"></span></a>
		<ul class=\"dropdown-menu\" role=\"menu\" aria-labelledby=\"dLabel\">
		<!--					<li><a href=\"".Router::url("/student/".$user['id'])."\"><i class=\"icon-edit\"></i> Update Profile</a></li>
							<li><a href=\"".Router::url("/resetpwd")."\"><i class=\"icon-lock\"></i> Change Password</a></li>
							<li class=\"divider\"></li>-->
							<li><a href=\"".Router::url("/logout")."\"><i class=\"icon-off\"></i> Logout</a></li>
						</ul>
					</div>
				</div>
				
			</div>
		</div>
	</div>"	;
}
else if(!$admin && $uri =="/")  {  
	echo	"<!--<span class=\"topmenu\"><a href=\"".Router::url("/student/student/allcourse")."\" rel='tooltip' data-placement='bottom' title=\"Your Cart. Purchase Now!\">Purchase <img src=\"" .Router::url("/img/cart.png")."\"></a></span>-->
				<!--	<div class=\"topmenu btn-group pull-right\">
						<a href=\"#\" class=\"dropdown-toggle\" data-toggle=\"dropdown\">".$user['name']." <span class=\"caret\" style=\"vertical-align:middle;\"></span></a>
		<ul class=\"dropdown-menu\" role=\"menu\" aria-labelledby=\"dLabel\">
							<li><a href=\"".Router::url("/student/".$user['id'])."\"><i class=\"icon-edit\"></i> Update Profile</a></li>
							<li><a href=\"".Router::url("/resetpwd")."\"><i class=\"icon-lock\"></i> Change Password</a></li>
							<li class=\"divider\"></li>
							<li><a href=\"".Router::url("/logout")."\"><i class=\"icon-off\"></i> Logout</a></li>
						</ul>
					</div>-->
				<br>
					<ul class=\"pull-right nav\" style=\"margin:0 0 0\">
					
						<!--<li><a id=\"dfree\" href=\"#\" data-href=\"".Router::url("/student/puzzler")."\">Free Zone</a></li>-->
						<li><a  href=\"".Router::url("/student/course")."\">My Courses</a></li>
						<!--<li><a id=\"all\" href=\"".Router::url("/student/student/allcourse")."\">Online Courses</a></li>
						<li><a id=\"all\" href=\"".Router::url("/student/classroom")."\">Classroom</a></li>
						<li><a id=\"all\" href=\"".Router::url("/student/books")."\">Books</a></li>-->
       	             <li><a id=\"all\" class=\"couponLink\"  data-toggle=\"modal\" data-backdrop=\"static\" data-target=\"#couponModal\" href=\"#\">Coupon</a></li>
						<!--<li><a id=\"dmyprog\" href=\"#\" data-href=\"".Router::url("/student/progress")."\">My Progress</a></li>
						<li><a id=\"dmyclass\" href=\"#\" data-href=\"".Router::url("/student/classroom")."\">My Classroom</a></li>-->
                <li>  <a href=\"#\" class=\"dropdown-toggle\" data-toggle=\"dropdown\">".$user['name']." <span class=\"caret\" style=\"vertical-align:middle;\"></span></a>
                    <ul class=\"dropdown-menu\" role=\"menu\" aria-labelledby=\"dLabel\">
              <li><a href=\"".Router::url("/student/".$user['id'])."\"><i class=\"icon-edit\"></i> Update Profile</a></li>
              <li><a href=\"".Router::url("/resetpwd")."\"><i class=\"icon-lock\"></i> Change Password</a></li>
              <li class=\"divider\"></li>
              <li><a href=\"".Router::url("/logout")."\"><i class=\"icon-off\"></i> Logout</a></li>
              <li>
            </ul></li>
                                            </ul>
                                            </div>
			</div>
		</div>
	</div>"	;
	}
else if(!$admin)  {  
         	echo	"<!--<span class=\"topmenu\"><a href=\"".Router::url("/student/student/allcourse")."\" rel='tooltip' data-placement='bottom' title=\"Your Cart. Purchase Now!\">Purchase <img src=\"" .Router::url("/img/cart.png")."\"></a></span>-->
					<!--<div class=\"topmenu btn-group pull-right\">
						<a href=\"#\" class=\"dropdown-toggle\" data-toggle=\"dropdown\">".$user['name']." <span class=\"caret\" style=\"vertical-align:middle;\"></span></a>
		<ul class=\"dropdown-menu\" role=\"menu\" aria-labelledby=\"dLabel\">
							<li><a href=\"".Router::url("/student/".$user['id'])."\"><i class=\"icon-edit\"></i> Update Profile</a></li>
							<li><a href=\"".Router::url("/resetpwd")."\"><i class=\"icon-lock\"></i> Change Password</a></li>
							<li class=\"divider\"></li>
							<li><a href=\"".Router::url("/logout")."\"><i class=\"icon-off\"></i> Logout</a></li>
						</ul>
					</div>-->
				<br>
					<ul class=\"pull-right nav\" style=\"margin:0 0 0\">
					
						<!--<li><a id=\"dfree\" href=\"#\" data-href=\"".Router::url("/student/puzzler")."\">Free Zone</a></li>-->
						<li class=\"active\"><a  href=\"".Router::url("/student/course")."\">My Courses</a></li>
						<!--<li><a id=\"all\" href=\"".Router::url("/student/student/allcourse")."\">Online Courses</a></li>
						<li><a id=\"all\" href=\"".Router::url("/student/classroom")."\">Classroom</a></li>
						<li><a id=\"all\" href=\"".Router::url("/student/books")."\">Books</a></li>-->
       	             <li><a id=\"all\" class=\"couponLink\"  data-toggle=\"modal\" data-backdrop=\"static\" data-target=\"#couponModal\" href=\"#\">Coupon</a></li>
						<!--<li><a id=\"dmyprog\" href=\"#\" data-href=\"".Router::url("/student/progress")."\">My Progress</a></li>
						<li><a id=\"dmyclass\" href=\"#\" data-href=\"".Router::url("/student/classroom")."\">My Classroom</a></li>-->
                <li>  <a href=\"#\" class=\"dropdown-toggle\" data-toggle=\"dropdown\">".$user['name']." <span class=\"caret\" style=\"vertical-align:middle;\"></span></a>
                    <ul class=\"dropdown-menu\" role=\"menu\" aria-labelledby=\"dLabel\">
              <li><a href=\"".Router::url("/student/".$user['id'])."\"><i class=\"icon-edit\"></i> Update Profile</a></li>
              <li><a href=\"".Router::url("/resetpwd")."\"><i class=\"icon-lock\"></i> Change Password</a></li>
              <li class=\"divider\"></li>
              <li><a href=\"".Router::url("/logout")."\"><i class=\"icon-off\"></i> Logout</a></li>
              <li>
            </ul></li>
                                            </ul>
                                            </div>
			</div>
		</div>
	</div>"	;}
 
            
 else{
  echo "<span class=\"topmenu\"><a  href=\"".Router::url("/admin/dashboard")."\" rel='tooltip' data-placement='left' >Home</a></span>
	<span class=\"topmenu\"><a href=\"".Router::url("/admin/changepassword")."\">Change Password</a></span>
	<span class=\"topmenu\"><a href=\"".Router::url("/logout")."\">Logout</a></span>
</div>

                    	
			</div>";}
}/*
else{
 echo "<span class=\"topmenu\"><a  href=\"".Router::url("/")."\" rel='tooltip' data-placement='left' >Home</a></span></li>
			<!--<span class=\"topmenu\"><a href=\"".Router::url("/login")."\">Login</a></span>
					<span class=\"topmenu\"><a href=\"#\" rel='tooltip' data-placement='bottom' title=\"Your Cart. Purchase Now!\"><img src=\"" .Router::url("/img/cart.png")."\"></a></span>-->
</div>
                        <!--	<ul class=\"pull-right nav\">
						<li><a href=\"".Router::url("/why")."\" rel='tooltip' title=\"Benefits\">Why</a></li>
						<li><a href=\"".Router::url("/what")."\" rel='tooltip' title=\"Programs\">What</a></li>
						<li><a href=\"".Router::url("/how")."\" rel='tooltip' title=\"Site Tour and FAQ\">How</a></li>
						<li><a href=\"".Router::url("/who")."\" rel='tooltip' title=\"Teachers\">Who</a></li>
						<li><a href=\"".Router::url("/")."\" rel='tooltip' title=\"Start Learning Now!\">You</a></li>
					</ul>-->
			</div>";
			
}*/
?>
</div></div>
	</div></div>
