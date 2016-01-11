<?php echo $this->Html->script("Home/hindu.js?random=3", array("inline" => false));
?>
<div class="top-ribbon" style="margin-top:65px;height:0px"></div>
<div class="row-fluid">
    <img class="web-ban" src="/img/HAG banner- for HINDU page.png" style="margin-top:15px;" >
    <img class="mob-ban" src="/img/HAG-Mobile banner.png" />
	</div>
	<div class="content" style="background-color:#ffffff;">
	<div class="container" style="font-family:sans-serif;padding:10px;">
<!-- 	<?php if($discount !=0){?>
	<div class="row-fluid" align="center">
	<div class="span8" style="float:none;background-color:#fffa9c;padding:5px;font-weight:bold"><p>Special Pre-Registration Discount  <img src="/img/rs_symbol.png" style="height:13px"> 799/-</p><p>Offer Valid Upto 18th May, 2015 Only</p>
	</div>	
	</div>	
	<?php }?> -->
	<div class="row-fluid hinduregbox" style="margin-top:20px" align="center">
	<div id="junbox" class="span5 junbox " >
	<a href="/hindu_registration" class="regbtn" id="1" style="text-decoration:none;"><img src="/img/<?php echo $juniorbox;?>" data-placement='top' title="Click here to register" />
	<?php
	$lessons=0;$videos=0;$questions=0;
		foreach($coursecontent as $content){			
		if($content['Course']['id'] == 2 || $content['Course']['id'] == 14){	
			$lessons += sizeof($content['Course']['Lessons']['Lessons']);
			$videos += $content['Course']['videos'];
			$questions +=$content['Course']['questions'];
			}}?>
	<!-- <div class="contentcount" style="background-color:#ffd200;padding-bottom:10px;padding-top:10px">
		<?php echo "<font color='#606064' size='4px'><b>".$lessons." lessons | ".$videos." videos | ".$questions." questions</b></font>";?>
	</div> -->	</a>
		<!-- <div class="crscontent span5 web-crs" id ="1" style="background-color:#ffd200;padding:5px;cursor:pointer;margin:0;">
		<font color='#606064' size='4px'><b>Course Content</b>
		<span class="crscaret" style="vertical-align:middle;"></span></font>		
	</div>
	<div class="freelesson span5" id ="1" style="background-color:#ffd200;padding:5px;cursor:pointer;margin:0;">
		<a style="text-decoration:none;cursor:pointer;" target="_blank" 
		<?php if($loggedin != "admin" && $loggedin != "classroomstudent"){ echo "href='/course/getlesson/2'";}?>><font color='#606064' size='4px'><b>Free Lesson</b>
		<span class="crscaret" style="vertical-align:middle;"></span></font></a>
	</div>

        <div class="crscontent span5 mob-crs" id ="1" style="background-color:#ffd200;padding:5px;cursor:pointer;margin:0;">
            <font color='#606064' size='4px'><b>Course Content</b>
                <span class="crscaret" style="vertical-align:middle;"></span></font>            
        </div>	
	 -->
	<div class="coursecontent_1" style="display:none;font-size:18px;text-align:left;margin-top:40px">
	<?php 	
	$i =1;
	foreach($coursecontent as $content){
		if($content['Course']['id'] == 2 || $content['Course']['id'] == 14){
			echo "<div class='span5' style='float:none;background-color:#605f64;width:98%;padding:5px;margin:10px;color:#ffffff;'>".$content['Course']['name']."</div>";
			$j=1;
            echo "<ol class=\"list-group\" style='list-style-type:none'>";
            foreach ($content['Course']['Lessons']['Lessons'] as $value) {
                if($i<10){
                    if($i == 1 || $j == 1){
                        echo "<li class='list-group-item'><span class='web-ban-list' style='color:#605f64'><b>".$i."</b></span><span  style='background-color:#f1a400;padding:5px ; margin-left:5px;margin-right:0px;display:inline-block; width:93.25%'>".$value['Lesson']['name']."</span></li>";
                    }
                    else if($i%2 != 0){
                        echo "<li class='list-group-item'><span class='web-ban-list' style='color:#605f64'><b>".$i."</b></span><span  style='background-color:#f1a400;padding:5px ; margin-left:5px;margin-right:0px;display:inline-block; width:93.25%'>".$value['Lesson']['name']."</span></li>";
                    }
                    else{
                        echo "<li class='list-group-item'><span class='web-ban-list' style='color:#605f64'><b>".$i."</b></span><span  style='background-color:#f8c301;padding:5px ; margin-left:5px;margin-right:0px;display:inline-block; width:93.25%'>".$value['Lesson']['name']."</span></li>";
                    }
                    $i++;$j++;
                }
                else{
                    if($j == 1){
                        echo "<li class='list-group-item'><span class='web-ban-list' style='color:#605f64;margin-left:-10px;'><b>".$i."</b></span><span  style='background-color:#f1a400;padding:5px ; margin-left:5px;margin-right:0px;display:inline-block; width:92.56%'>".$value['Lesson']['name']."</span></li>";
                    }
                    else if($j%2 != 0){
                        echo "<li class='list-group-item'><span class='web-ban-list' style='color:#605f64;margin-left:-10px;'><b>".$i."</b></span><span  style='background-color:#f1a400;padding:5px ; margin-left:5px;margin-right:0px;display:inline-block; width:92.56%'>".$value['Lesson']['name']."</span></li>";
                    }
                    else{
                        echo "<li class='list-group-item'><span class='web-ban-list' style='color:#605f64;margin-left:-10px;'><b>".$i."</b></span><span  style='background-color:#f8c301;padding:5px ; margin-left:5px;margin-right:0px;display:inline-block; width:92.56%'>".$value['Lesson']['name']."</span></li>";
                    }
		    $i++;
		    $j++;
			}
			}
		    echo "</ol>";
		    }}?>
	  </div>
	</div>
	<div id="senbox" class="span5 junbox" >
	<a href="/hindu_registration" class="regbtn" data-placement='top' title="Click here to register" id="2" style="text-decoration:none"><img src="/img/<?php echo $seniorbox;?>" />	
	<?php
	$lessons=0;$videos=0;$questions=0;
		foreach($coursecontent as $content){			
		if($content['Course']['id'] == 5 || $content['Course']['id'] == 35){	
			$lessons += sizeof($content['Course']['Lessons']['Lessons']);
			$videos += $content['Course']['videos'];
			$questions +=$content['Course']['questions'];
			}}?>
<!-- 	<div class="contentcount" style="background-color:#a9cb24;padding-bottom:10px;padding-top:10px">
		<?php echo "<font color='#606064' size='4px'><b>".$lessons." lessons | ".$videos." videos | ".$questions." questions</b></font>";?>
	</div> -->
	  </a>
	<!-- <img src="/img/SENIORS-COURSE CONTENT.png" style="float:none;margin-top:10px"  /> -->
	<!-- <div class="crscontent span5 web-crs" id ="2" style="background-color:#a9cb24;padding:5px;cursor:pointer;margin:0">
		<font color='#606064' size='4px'><b>Course Content</b></font>
		<span class="crscaret" style="vertical-align:middle;"></span>

    </div>
	<div class="freelesson span5" id ="2" style="background-color:#a9cb24;padding:5px;cursor:pointer;margin:0">
		<a style="text-decoration:none;cursor:pointer;" target="_blank" 
		<?php if($loggedin != "admin" && $loggedin != "classroomstudent"){ echo "href='/course/getlesson/35'";}?>><font color='#606064' size='4px'><b>Free Lesson</b></font></a>
		<span class="crscaret" style="vertical-align:middle;"></span>
	</div>
    <div class="crscontent span5 mob-crs" id ="2" style="background-color:#a9cb24;padding:5px;cursor:pointer;margin:0">
        <font color='#606064' size='4px'><b>Course Content</b></font>
        <span class="crscaret" style="vertical-align:middle;"></span>
    </div> -->

	<div class="coursecontent_2" style="display:none;font-size:18px;text-align:left;margin-top:40px">
	<?php 	
	$i =1;
	foreach($coursecontent as $content){
		if($content['Course']['id'] == 5 || $content['Course']['id'] == 35){
			echo "<div class='span5' style='float:none;background-color:#605f64;width:98%;padding:5px;margin:10px;color:#ffffff;'>".$content['Course']['name']."</div>";
			$j=1;
			echo "<ol style='list-style-type:none;margin-left:10px'>";			
			foreach ($content['Course']['Lessons']['Lessons'] as $value) {
                if($i<10){
                    if($i == 1 || $j == 1){
                        echo "<li class='list-group-item'><span class='web-ban-list' style='color:#605f64'><b>".$i."</b></span><span  style='background-color:#8aab16;padding:5px ; margin-left:5px;margin-right:0px;display:inline-block; width:93.25%'>".$value['Lesson']['name']."</span></li>";
                    }
                    else if($j%2 != 0){
                        echo "<li class='list-group-item'><span class='web-ban-list' style='color:#605f64'><b>".$i."</b></span><span  style='background-color:#8aab16;padding:5px ; margin-left:5px;margin-right:0px;display:inline-block; width:93.25%'>".$value['Lesson']['name']."</span></li>";
                    }
                    else{
                        echo "<li class='list-group-item'><span class='web-ban-list' style='color:#605f64'><b>".$i."</b></span><span  style='background-color:#a8cb26;padding:5px ; margin-left:5px;margin-right:0px;display:inline-block; width:93.25%'>".$value['Lesson']['name']."</span></li>";
                    }
                    $i++;$j++;
                }
                else{
                    if($j == 1){
                        echo "<li class='list-group-item'><span class='mar-cbar-two web-ban-list' style='color:#605f64;'><b>".$i."</b></span><span class='width-cbar-two'  style='background-color:#8aab16;padding:5px ; margin-left:5px;margin-right:0px;display:inline-block;'>".$value['Lesson']['name']."</span></li>";
                    }
                    else if($j%2 != 0){
                        echo "<li class='list-group-item'><span class='mar-cbar-two web-ban-list' style='color:#605f64;'><b>".$i."</b></span><span class='width-cbar-two'  style='background-color:#8aab16;padding:5px ; margin-left:5px;margin-right:0px;display:inline-block;'>".$value['Lesson']['name']."</span></li>";
                    }
                    else{
                        echo "<li class='list-group-item'><span class='mar-cbar-two web-ban-list' style='color:#605f64;'><b>".$i."</b></span><span class='width-cbar-two'  style='background-color:#a8cb26;padding:5px ; margin-left:5px;margin-right:0px;display:inline-block;'>".$value['Lesson']['name']."</span></li>";
                    }
		    $i++;
		    $j++;
			}
			}
		    echo "</ol>";
		    }}?>
	  </div>
	</div>
	</div>

	<!--<div class="row-fluid" style="margin-left:20px;">	
	<h3 class="mob-size" style="color:#00AEEF">Gain a strong Physics Foundation and achieve SUCCESS!</h3>
	<p class="p-fstyl" ><b>Newton's Laws of Motion and Projectile Motion</b> form the basis of High School Physics. These form the essential foundation on which the rest of the Physics concepts are built. Learning these topics in depth is critical to understanding Physics and achieving success in school.</p>
	<center><p><strong class="p-fstyl">Join The Hindu AhaGuru Physics Challenge NOW</strong><span class="p-fstyl"> and gain strong foundation in <br/><b>Newton's Laws of Motion and Projectile Motion</b> in an easy and fun way.</span></p></center>
	</div>	-->
	<div class="row-fluid" style="margin-top:20px;margin-left:20px;">
	<h3 class="mob-size" style="color:#00AEEF">Details of the Hindu AhaGuru Physics Challenge 2</h3>
	<ul class='list-group p-fstyl' >
	<li class='list-group-item'><strong>Step 1: Register for the Hindu AhaGuru Challenge 2.
	<?php if($discount == 0){?>
	<font color="#00AEEF">Registration Fee <img src="/img/RUPEE SYMBOL- blue.png">  999/-</font>
	<?php }else{?>
	<font color="#00AEEF">Registration Fee <span class="strikethrough"><img src="/img/RUPEE SYMBOL- blue.png">  999/-</span>&nbsp;&nbsp;<img src="/img/RUPEE SYMBOL- blue.png">  899/-</font>
	<?php }?>
	</strong></li>
	<li class='list-group-item'><strong>Step 2: <span>Learn and complete all the lessons in your online course</span></strong></li>
	<li class='list-group-item step3'><strong><table style="margin-top:-20px"><tr><td class="step">Step 3:</td><td class="stepcon">Take the test on <font color="#00AEEF">25th October 2015</font></td></tr></table></strong></li>		
		<li>The test will be for 90 minutes, for a total of 100 marks. The questions will include problems that involve reasoning and calculations.</li>
	<li class='list-group-item'>Participants will receive performance grades, certificates and winners will get attractive prizes!</li>
	</ul>
	
	</div>
	</div>
	</div>
	<div style="background: -webkit-linear-gradient(white, rgb(215,241,255));
  background: -o-linear-gradient(white, rgb(215,241,255));
  background: -moz-linear-gradient(white, rgb(215,241,255));
  background: linear-gradient(white, rgb(215,241,255));">	
  <div class="container text-center">
					<h3>Choose JUNIORS or SENIORS Category above to Register</h3>
					</div>
				</div>
			</div>
		</div>
	</div>


<!-- Email Modal -->
	<div id="emailModal" class="modal hide fade span5" tabindex="-1" role="dialog" aria-hidden="true" style="margin-left: -300px;">
	<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				Email id
	</div>
	<div class="modal-body">
	<form action="/hindu_signup"  method="post" accept-charset="utf-8" 
	id="hinsignup">
        <div class="row" style="margin-left:10px;">  
       		<div class="control-group sec">
       			<label class="control-label" for="email">Email ID *</label>
          			<div class="controls">
           				<input type="text" id="required email" name="data[Student][email]" placeholder="example@mail.com"/><br>
           				<span class="error_msg" style="color:red;display:none;">Enter your Email ID</span>
           				<span class="emailwar" style="color:red;"></span>
              			</div>
          			</div>
          			<input type="text" id="student_level" 
          			name="data[Student][level]" style="display:none"/><br>
          		</div>
       	<div class="form-action span4">
              <button class="btn btn-primary" id="submit">Submit &rarr;</button>
            </div>
           </form> 
	</div>
	<div class="modal-footer">
	</div>
	</div>
<!--End of Email Modal -->

<!-- Sign up Modal & Login Modal -->
	<div id="signupModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="width:800px; margin-left: -400px;">
		<div class="modal-headerr">
			<div class="modal-headerr">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				<ul class="nav nav-tabs" id="mainLiginTab" style="margin-bottom:0px;border-bottom:0px solid #ddd;">
					<li class="active" style="border-bottom:1px solid #ddd;"><a href="#loginTab" data-toggle="tab"><b>Log In</b></a></li>
					<li style="border-bottom:1px solid #ddd;"><a href="#signupTab" data-toggle="tab"><b>Sign Up</b></a></li>
				</ul>

			</div>
		</div>
		
		<div class="modal-body text-center">
			<div class="tab-content">
				<div class="tab-pane active" id="loginTab">
					<div class="modal-body text-center">
					<h3>Please Enter your Email Id and Ahaguru Password</h3>
					<form class="frmstyle" id="login" method="post" action="<?php echo Router::url('/login'); ?>">
		<input id="required" class="inputLarge" name="data[Student][email]" type="text" placeholder="Enter your email id"><br>
                 <span class="error_msg" style="color:red;display:none;">Enter valid Email ID</span><br>
		<input id="required" class="inputLarge" name="data[Student][password]" type="password" placeholder="Enter your password"><br>
        <span class="error_msg" style="color:red;display:none;">Password Field cannot be empty</span>
		 <span id="warning" style='color:red;text-align:center;'></span><br>
		<button id="login" type="submit" class="btn btn-large btn-primary">Log In</button>
		<br><br>
		<a href="/forgotpwd"><strong>Forgot Password?</strong></a>
						</form>
					</div>
				     
				</div>
				
				<div class="tab-pane" id="signupTab">
					<div class="modal-body text-center" style="overflow:hidden;">
					
						<div class="row-fluid">
							<div class="span6">
								<!--<h2 style="text-decoration:underline; line-height:20px;">Start Learning Now!</h2>-->
								<h3 style="line-height:35px;">
								 <div>Signing up gives you free access to the 1st lesson of every course!</div></h3>
								 <h3>Please Enter your Name and Email Id</h3>
								<!--<h4 style="line-height:25px;">
									<div style="text-align:left; padding-left:70px;">
										<i class="icon-ok"></i> First Lesson of Every Course<br>
										<i class="icon-ok"></i> Fun Experiments and Videos<br>
										<i class="icon-ok"></i> Puzzles and Logic Games<br>
										<i class="icon-ok"></i> Quizzes and Practice Tests
									</div>
								</h4>-->
								
							</div>
							<div class="span6">
					<form class="frmstyle" id="signup" action="<?php echo Router::url("/register"); ?>"  method="post">
							<!--<span style="font-size:18px;">I am a &nbsp;&nbsp;&nbsp; 
							<input type="radio" name="userType" value="student" checked="checked" style="margin-bottom:5px;"> Student &nbsp;&nbsp;&nbsp;
							<input type="radio" name="userType" value="parent" style="margin-bottom:5px;" disabled> Parent &nbsp;&nbsp;&nbsp;
						<input type="radio" name="userType" value="teacher" style="margin-bottom:5px;" disabled> Teacher</span>-->
					<input id="required" class="inputLarge"  name="data[Student][name]" type="text" placeholder="Enter your full name">
                                              <span class="error_msg" style="color:red;display:none;">Enter your Name</span>
					<input id="required" class="inputLarge"  name="data[Student][email]" type="text" placeholder="Enter your email id"><br>
						<span class="error_msg" style="color:red;display:none;">Enter your Email ID</span>	
						<span id="emailwar" style='color:red;text-align:center;'></span>
						<select id="classinschool" class="inputLarge" style="height:45px; padding-top:10px; width:372px;" name="data[Student][standard]">
						<option value="0" selected="selected">Select your class in school</option>
						<?php
                			foreach($standard as $stnd) {?>
							<option value="<?php echo $stnd['Standard']['id']; ?>">
                     		<?php echo "Class ".$stnd['Standard']['name']; ?></option>        
   						<?php }?>
							</select>
				<span id="stdwar" style='color:red;text-align:center;'></span>
							<label style="font-size:18px">

			<input type="checkbox" name="agree" value="1" checked="checked" style="margin-bottom:5px;" disabled>&nbsp;&nbsp;&nbsp; Yes, I agree to the Ahaguru Terms of Use
							</label>
    
		<button id="signup" type="submit" class="btn btn-large btn-primary">Free Sign Up</button>
		<div style="font-size:18px;margin-top:10px;">After you sign up, we will email your password for you to log in.
		</div>
	
		</form>
							</div>
						</div>
					
						
				</div>
					
					
				</div>
			</div>
		</div>
	</div>
	<!-- Sign up Modal End -->
   

	<!-- Coupon Modal1 -->
	<div id="couponModal" class="modal hide fade span8" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"  data-backdrop="static"  style="margin-left: -400px;">
				<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			<center><h3>Pre-Paid Course Coupon </h3></center>
				</div>
		
		<div class="modal-body" style="margin:20px;">
		<form id="coupon" action="/" method="post">
		<h4 ><input type="radio" id="havecode" name="coupcode" value="yes" checked >&nbsp;&nbsp;I have a pre-paid course coupon.  <br><br>Coupon Code : <input type="text" id="required" name="couponcode"/>
      <button id="sub" style="margin-bottom:10px" type="submit" class="btn btn-primary">Enter</button></h4>
     
	<span class="error_msg" style="display:none;"><b>Enter valid coupon code.</b></span>
	
	<h4><input type="radio" id="nocode" name="coupcode" value="no" >&nbsp;&nbsp;I don't have a pre-paid coupon :</h4></form>
	<ol><li> <h4 style="font-weight:normal"> To directly purchase course coupon online using credit/ debit card click here  <a id="signup"  class="btn btn-primary"  href="/online">Proceed...</a></h4></li>
      	<li><h4 style="font-weight:normal">To purchase pre-paid course coupon please call +91 96001 00090.</h4></li></ol>
     	 
	 
   </div>
   </div>



   <!--Popup for already loggedin user-->
		<div id="alreadylogged" class="modal hide fade span8" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"  data-backdrop="static"  style="margin-left: -400px;" data-backdrop="static">
			<div class="modal-header">
				<center><h3>Already Enrolled</h3></center>
			</div>
		
		<div class="modal-body" style="margin:20px;">			
     	 	<p> <font size="4px">You have already enrolled in <b>The Hindu AhaGuru Physics Challenge 2 .</b> Please go to MyCourses page to start learning</font></p>
     	 	 <a class="btn btn-primary" href="/student/course">My Courses</a>
   			</div>
   		</div>


   <!--End Popup for already registered user-->

<!-- Coupon Modal2 -->
	<div id="couponMod" class="modal hide fade span8" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style=" margin-left: -400px;">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			<center><h3>Thank you for purchasing  an AhaGuru Course Coupon! </h3></center>
		
		</div>
		<div class="modal-body text-center" style="margin-top:20px;">
				
            <a id="login" class="btn btn-large btn-success pull-left" href="/coupon_login">Yes. I already have an AhaGuru account.<br> Please activate my course</a>
 
 	        <a id="signup"  class="btn btn-large btn-success pull-right"  href="/register">No. I don’t have an AhaGuru account yet.<br>Please create my account and activate my course</a>

	        <a class="pull-left span3"  href="/forgotpwd">Forgot Password?</a>
	 
        </div>
   </div>
						
	<!--- Coupon Modal2 ends -->
   <div id="enquiryModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"  data-backdrop="static">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true" >×</button>
			<center>
			<h3 id="myModalLabel">Enquiry Form</h3></center>
		</div>
		<div class="modal-body">
		<center>
		<span id="msg" style="color:red;"></span><br>
		  <form id="enquiry" method="post" action="<?php echo Router::url('/'); ?>">

		  <lable><strong>Name *: </strong></lable><input id="required" name="data[name]" type="text"><br>
		   <span class="error_msg" style="color:red;display:none;">Enter your name</span><br>
		  <lable><strong>Email *: </strong></lable><input id="required" name="data[email]" type="text"><br>
          <span class="error_msg" style="color:red;display:none;">Enter valid Email ID</span><br>
          <lable><strong>Queries *: </strong></lable>
		<textarea id="required" name="data[query]"></textarea><br>
        <span class="error_msg" style="color:red;display:none;">Please Enter your quries</span><br>
       <input id="required" name="data[toemail]" type="hidden" value="learn@ahaguru.com">
        <b>Contact : </b> <span>+91 96001 00090
					<p><a href="mailto:learn@ahaguru.com">learn@ahaguru.com</a></p></span>
			<button id="query"  class="btn btn-primary">Submit</button> </form>
						</center>		  
		</div>
		<div class="modal-footer"></div>
	</div>
	
	<div id="loading" class="modal hide fade span5" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="margin-left:-250px;">
		
		<div class="modal-body">
			<img src="/img/loading.gif"></img> <h3>  Please Wait....</h3>
		</div>
		<div class="modal-footer"></div>
	</div>



<!-- About -->
	<div id="aboutmodal" class="modal hide fade span8" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style=" margin-left: -400px;">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			<center><h3>About Dr.Balaji Sampath</h3></center>
		
		</div>
		<div class="modal-body" style="margin-top:20px;font-size:14px;">
						<div class="pull-left"><img src="/img/balaji_sampath.png" style="border-bottom-right-radius:40px;margin:0"></div>
						<div class="span6 pull-right" style="line-height:30px;margin:0">
				<p>Balaji Sampath did his B. Tech from IIT-Madras<b>(All India Rank 4 in IITJEE 1990)</b>.
				 He then got his PhD from the University of Maryland at College Park. He returned to India in 1997 to improve the quality of education in India. He started AID INDIA,Eureka Books and Eureka Child Foundation,non-profit initiatives that have educated over a million children in villages.</p>	
				 <p>Balaji's physics class foucses on conceptual clarity, practical experiments and innovative problem solving techniques. His classes have helped several hundred students get into IITs, NITs and BITs. More 
				 importantly, lots of students have reported 'falling in love with Physics because of Balaji's classes'. His popular Science Demos on Sun TV got lakhs of children excited about science. His Science Books, Experiments, Videos and Teaching Methods have inspired thousands of students and teachers. For innovation in Science Education, he was awarded the Ashoka Fellowship and the Lemelson Inventor Certificate. For his contribution to education, IIT Madras recognized Balaji Sampath with <b> IIT Distinguished Alumnus Award 2012.</b></p>																	
						</div>
					</div>
				</div>
<!--About ends -->