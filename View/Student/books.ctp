<?php echo $this->Html->script("Student/books.js", array("inline" => false));
?>
	<div class="top-head">
		<div class="top-head-bg">
			<div class="container">
				<div class="row-fluid">
							<div class="span8"><img src="/img/books_header.png" style="width:580px; height:375px;"></div>
							<div class="span4 books_header" >
								<h3 >	
								Learn Science while <br></h3>
								<h3>having fun with<br></h3>
									<h3><strong>Aha Books</strong> </h3>
									
									<br>
									<h3>Change the way you <br></h3>
									<h3><strong>Think about the world.</strong></h3>
								<br>
								<h2>Read, think and discover<br>your Aha! Moment</h2>
							</div>
							</div>
			</div>
		</div>
	</div>
	
	<!-- Middle Logs -->
	
	<div class="container">
		<div class="row-fluid" style="margin-top:20px;">
			<div class="span2" style="text-align:center;">
				<img src="/img/newtons_laws.png">
				<h4 style="text-decoration:underline;">Author</h4>
				<h4>Balaji Sampath</h4>
			</div>
			<div class="span8">
				<h2 class="book-head">The AHA Guide to Newton's Laws</h2>
				<div class="book_desc">
				<p>Some people think Newton's laws are just 3 simple statements.  But the fact is these three laws form a framework to understand our entire universe!   This book uses cartoons, dialogues, jokes and questions to make you understand the deeper meaning of these widely misunderstood laws that led to a scientific revolution and transformed our world 400 hundred years ago.</p>
				<p>
Can you push air with the same force that you can push a wall? When a dog sitting at rest suddenly decides to get up and walk, what is the external force that acted on it to move it from rest? As the Moon is being pulled by the Earth continuously, why doesn't it fall down? Learn the answers to these questions and more in The Aha Guide to Newton's Laws. Read, Think, and discover your Aha! Moment.</p>
</div>
			</div>
			<div class="span2" style="text-align:center;">
				<!--<a href="#" class="btn btn-warning book_free_lsn_btn">Try Sample</a>-->
				<a href="http://www.flipkart.com/aha-guide-newton-s-law/p/itmdvn2zwfsftsns?pid=9788192704401" target="_blank" class="btn btn-primary" style="width:120px;">Buy from Flipkart</a>
			</div>
		</div>
		<div class="page-header">&nbsp;</div>
		<div class="row-fluid" style="margin-top:20px;">
			<div class="span2" style="text-align:center;">
				<img src="/img/atoms_book.png">
				<h4 style="text-decoration:underline;">Author</h4>
				<h4>Balaji Sampath</h4>
			</div>
			<div class="span8">
				<h2 class="book-head">The AHA Guide to Atoms</h2>
				<div class="book_desc">
				<p>The Aha Guide to Atoms, takes us on a fascinating journey to the microscopic world of atoms - the basic building block of everything that exists in us and around us.   In this book, we discover how living things like ourselves and non-living things like a stone are made up of exactly the same atoms, as are the stars and planets in space. Each chapter takes up one idea and surprises us with a fresh way of looking at our world.   Don't most of us assume that atoms in a solid are more tightly packed than liquids?  Why then does ice float on water?  Read about this in the book!    This book also brilliantly traces the history of Atomic Theory from Democritus to Boyle, Priestley, Lavoisier, Dalton and Einstein.  You will read and re-read this book several times, understanding a little more about our world every time. So quickly turn to the first page and start your atomic journey because as Carl Sagan said "Somewhere, something incredible is waiting to be known.”</p></div>
			</div>
			<div class="span2" style="text-align:center;">
				<!--<a href="#" class="btn btn-warning book_free_lsn_btn">Try Sample</a>-->
				<a href="http://www.flipkart.com/aha-guide-atoms/p/itmdvn2z69gdhfzt?pid=9788192704418" target="_blank" class="btn btn-primary" style="width:120px;">Buy from Flipkart</a>
			</div>
		</div>
		<div class="page-header">&nbsp;</div>
	</div>
	
	<div class="container">
			<div class="row-fluid" style="text-align:center; margin:10px 0;">
				<div class="span6">
				<?php if($loggedin == "classroomstudent"){?>
					<a style="cursor:pointer">
						<img src="/img/online_icon.png" class="pull-left" alt="Online Courses" title="Click Here">
					</a>
					<?php }else{?>
					<a href="/student/student/allcourse">
						<img src="/img/online_icon.png" class="pull-left" alt="Online Courses" title="Click Here">
					<?php }?>
				</div>
				<div class="span6">
				<?php if($loggedin == "classroomstudent"){?>
				<a href="/student/student/classroom">
						<img src="/img/classroom_icon.png" class="pull-right" alt="Classroom Program" title="Click Here">
					</a>
				<?php }else{?>
					<a href="/student/classroom">
						<img src="/img/classroom_icon.png" class="pull-right" alt="Classroom Program" title="Click Here">
					</a>
					<?php }?>
				</div>
			</div>
	</div>
	
	<!--<div class="notebook-band">
		<div class="container">
		
			<div class="row-fluid notebook-bg">
				<div id="newsCarousel" class="carousel slide" data-interval="false">
					<ol class="carousel-indicators" style="top:277px">
						<li data-target="#newsCarousel" data-slide-to="0" class="active"></li>
						<li data-target="#newsCarousel" data-slide-to="1"></li>
						<li data-target="#newsCarousel" data-slide-to="2"></li>
						<li data-target="#newsCarousel" data-slide-to="3"></li>
						<li data-target="#newsCarousel" data-slide-to="4"></li>
						
						
					</ol>
		
					<div class="carousel-inner" style="height:250px;">
						
						<div class="active item">
							<div class="newstxt" style="margin-top:55px">
		
								Balaji Sampath Sir has helped me build a strong intuition for Physics problems.
								His Ahaguru online program is a concept lover's paradise that blends concept understanding with lots of problem solving practice. The man who taught me how to talk with nature.<br><br>
								<div class="studentName">- K.E. Srivatsav, PSBB, University of California, Berkley</div>
							</div>
						</div>
						<div class="item">
							<div class="newstxt" style="margin-top:55px">
		
								Balaji Sir explains concepts in a simple way.
								His classes have helped me solve tough physics problems and at the same time appreciate even the tiniest details.<br><br>
								<div class="studentName">- Anshul, Sankara School, BITS Pilani</div>
							</div>
						</div>
						<div class="item">
							<div class="newstxt" style="margin-top:55px">
		
								Prof.Balaji Sampath's classes really help me understand concepts much better. 
								His Ahaguru tests and particularly, video solutions are very helpful for school tests as well.<br><br>
								<div class="studentName">- Vishwesh, Sankara School, NIT Trichy</div>
							</div>
						</div>
						<div class="item">
							<div class="newstxt" style="margin-top:55px">
		
								The lectures are awesome. Ahaguru tests not only enable timed problem solving ability, but also enhance our concept understanding.<br><br>
								<div class="studentName">- Uma Girish, Vidya Mandir, Chennai Mathematical Institute(CMI)</div>
							</div>
						</div>
						<div class="item">
							<div class="newstxt" style="margin-top:55px">
		
								The method of teaching in the Ahaguru online courses is extremely effective. The video lectures taught me the fundamentals of Physics.
								Then the tests allowed me to apply the concepts I had learnt to a diverse variety of problems.
								I cannot sufficiently emphasize how much Ahaguru has helped me, especially in relative motion and to understand the entirety of Newton’s Laws.
								The online course was a major reason for my Physics scores in both JEE Mains and IIT JEE Advanced. Thank you so much!<br>

								<div class="studentName">- Nithin Seyon Ramesan<br><br>All India 3rd Rank in IIT JEE Mains 2013</div>
							</div>
						</div>
						
					</div>
				</div>
			</div>
		</div>
	</div>
	
	
		<div class="container">
			
					<div class="span7">
						<div id="thum-img-list">
							<ul>
							<?php
							  foreach ($users as $user) {
							  if($user['photo'] != "Photo Not Available")
		
							   	 echo "<li style='background:url(/img/thum.jpg);vertical-align:middle;'><img src='$user[photo]'/></li>";
							   	else
							   	//echo "<li><h2>".substr($user[name],0,1)."</h2></li>";
							   		echo "<li style='background:url(/img/thum.jpg);vertical-align:middle;border:1px solid #CCCCCC'><center style='margin-top:20px;'><h2>"
							   	       .strtoupper(substr($user['name'],0,1))."</h2></center></li>";
							   		//echo "<li><img src='/img/thum.jpg'></li>";
							   }?>
								
							</ul>
						</div>
					</div>
					<div class="span5" style="margin-top:60px;">
					<div class="thum-img-right">

				<button class="btn btn-block btn-large btn-success btngreen" style="outline:none;line-height:1" data-toggle="modal" id="signupButton" data-target="#signupModal">Join Now and Start Learning</button>
				</div>

						<div class="span5">
						<div class="thum-img-right">
							<div class="right-img-box">
								<div class="pull-left">
									<p class="right-img-txt"><strong>Mahesh Jain</strong> from <strong>KV Bhopal</strong> has <br>completed Lesson 12 in Motion Course</p>
								</div>
								<div class="pull-right"><img src="/img/big-img.jpg" class="right-img-br"></div>
							</div>
							<div class="right-img-box">
								<div class="pull-left">
									<p class="right-img-txt"><strong>Mahesh Jain</strong> from <strong>KV Bhopal</strong> has <br>completed Lesson 12 in Motion Course</p>
								</div>
								<div class="pull-right"><img src="/img/big-img.jpg" class="right-img-br"></div>
							</div>
						</div>
						</div>
					</div>
				</div>
				
			<div class="row-fluid" style="padding-bottom:15px;padding-top:15px;">
				<div class="span6">
					<div class="text-right">
						<p class="join-txt">
							<strong><?php echo count($students);?> Students</strong> enjoying the AHAGuru learning experience.<br>
							You can also join now.
						</p>
					</div>
				</div>
				<div class="span6">
				<button class="btn btn-block btn-large btn-success btngreen" style="outline:none;" data-toggle="modal" id="signupButton" data-target="#signupModal">Join Now and Start Learning</button>
				</div>
			</div>
		</div>
		</div>
	
	-->
	<div class="bottom-band" style="margin-top:20px;">
	
		<div class="container">
			<div class="row-fluid">
				<div class="span6 bottom-btn-link">
					<!--<button class="btn">FAQ</button>
					<button class="btn">Help</button>-->
					<button class="btn" id="enquiry" data-toggle="modal" data-target="#enquiryModal">Enquiry</button>
					<span class="pull-right">
					<?php if($loggedin == "classroomstudent"){?>
		 				<a href="/student/student/classroom" style="font-size:17px;">Classroom Programs</a>
		 			<?php } else{?>
					 <a href="/student/classroom" style="font-size:17px;">Classroom Programs</a>
					 <?php }?>
					 <?php if($loggedin == "student"){?>
		 				<a href="/student/student/allcourse" style="font-size:17px;">Online Courses</a>
		 				<?php } else{?>
		 				<a style="cursor:pointer" style="font-size:17px;">Online Courses</a>
		 				<?php }?>		 			
					<a href="/student/books" style="font-size:17px;">Books</a>	
					</span>
				</div>
				<div class="span6">
					<div class="contactTxt">CONTACT</div>
					<div class="contactLink">
					<p>+91 9600100090</p>
					<p class="emailLink"><a href="mailto:learn@ahaguru.com">learn@ahaguru.com</a></p>
					</div>
					
					
				</div>
			</div>
		</div>
	</div>

	
	<!-- Sign up Modal & Login Modal -->
	<div id="signupModal" class="modal hide fade " tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="width:800px;margin-left:-400px">
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
 <span style='color:red;text-align:center;'><?php echo $this->Session->flash(); ?></span>	
 <span id="warning" style='color:red;text-align:center;'></span>	<br>					<button type="submit" id="login" class="btn btn-large btn-primary">Log In</button><br><br>
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
					<input id="required" class="inputLarge"  name="data[Student][name]" type="text" placeholder="Enter your full name"><br>
                                              <span class="error_msg" style="color:red;display:none;">Enter your Name</span>
					<input id="required" class="inputLarge"  name="data[Student][email]" type="text" placeholder="Enter your email id"><br>
						<span class="error_msg" style="color:red;display:none;">Enter your Email ID</span>	
										<span id="emailwar" style='color:red;text-align:center;'></span>
								<select id="classinschool" class="inputLarge" style="height:45px; padding-top:10px; width:372px;" name="data[Student][standard]">
								<option value="0" selected="selected">Select your class in school</option>
			                    <?php
                foreach($standard as $stnd) {
                        
              ?>

                <option value="<?php echo $stnd['Standard']['id']; ?>"
          >
                     <?php echo "Class ".$stnd['Standard']['name']; ?></option>        
    
              <?php
                }
              ?>
							</select><br>
			<span id="stdwar" style='color:red;text-align:center;'></span>
						<label style="font-size:18px">
			<input type="checkbox" name="agree" value="1" checked="checked" style="margin-bottom:5px;" disabled>&nbsp;&nbsp;&nbsp; Yes, I agree to the Ahaguru Terms of Use
							</label>

						<button id="signup" type="submit" class="btn btn-large btn-primary">Free Sign Up</button>
						<div style="font-size:18px;margin-top:10px;">After you sign up, we will email your password for you to log in.</div>

						
						</form>
							</div>
						</div>
					
						
				</div>
					
				</div>
			</div>
		</div>
	</div>
	<!-- Sign up Modal End -->
	
	<!-- Login Modal End -->

	<div id="enquiryModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="width:450px;">
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


	<!-- Coupon Modal1 -->
	<div id="couponModal" class="modal hide fade span8" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style=" margin-left: -400px;">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			<center><h3>Pre-Paid Course Coupon </h3></center>
		</div>
		<div class="modal-body " style="margin:20px;">
			<form id="coupon" action="/" method="post">
			<h4 ><input type="radio" id="havecode" name="coupcode" value="yes" checked >&nbsp;&nbsp;I have a pre-paid course coupon.  <br><br>Coupon Code : <input type="text" id="required" name="couponcode"/>
	      <button id="cupsub" style="margin-bottom:10px" type="submit" class="btn btn-primary">Enter</button></h4>
	     
			<span class="error_msg" style="display:none;"><b>Enter valid coupon code.</b></span>
		
			<h4><input type="radio" id="nocode" name="coupcode" value="no" >&nbsp;&nbsp;I don't have a pre-paid coupon :</h4></form>
			<ol><li> <h4 style="font-weight:normal"> To directly purchase course coupon online using credit/ debit card click here <a id="signup"  class="btn btn-primary"  href="/student/student/allcourse">Proceed...</a></h4></li>
	      	<li><h4 style="font-weight:normal">To purchase pre-paid course coupon please call +91 96001 00090.</h4></li></ol>
     	</div>
    </div>
						
	<!--- Coupon Modal1 ends -->


	<!-- Coupon Modal2 -->
	<div id="couponMod" class="modal hide fade span8" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="margin-left: -400px;">
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

		<div id="enquiryModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="width:450px;" data-backdrop="static">
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