<?php echo $this->Html->script("Home/classroom.js?random=2", array("inline" => false));
?>
	<div class="top-head">
		<div class="top-head-bg">
			<div class="container">
				<div class="row-fluid">
					<div class="span7"><img src="/img/classroom_header.png" style="width:489px; height:375px;"></div>
							<div class="span5 classroom_header" >
								<h2 style="margin-top:2px;">							
									<strong>Classroom Program in Chennai<br>
									<small>for</small> <span>IIT JEE + CBSE </span></strong>
								</h2>
								<h3>	
									Deepen your<br>
									<strong>Concept Understanding</strong>
								</h3>
								<h3>
									Make ideas come alive with<br>
									<strong>Exciting Experiments</strong>
								</h3>
								<h3>
									Conquer problem solving with<br>
									<strong>Innovative Techniques</strong></h3>
								</h3>	
								
								<h3>
									Build your skills with<br>
									<strong>Worksheets and Online Courses</strong></h3>
								</h3>
							</div>
					</div>
			</div>
		</div>
	</div>
	
	<!-- Middle Logs -->
	
	<div class="container">
			
		
					
		<div class="rowfluid" style="background-color:#ffffff;padding-top:10px;">
		<div class="tabs">
				<ul class="nav nav-tabs" id="mainLiginTab" style="margin-bottom:0px;border-bottom:0px solid #ddd;">
					<li style="border-bottom:1px solid #ddd;width:25%;background-color:#ffffff;font-size:18px;" class="active text-center"><a href="#IITTab" style="cursor:pointer" data-toggle="tab"><b>IIT JEE + CBSE Classes</b></a></li>
					<li id="sch" style="border-bottom:1px solid #ddd;width:20%;background-color:#ffffff;font-size:20px;" class="text-center"><a href="#scheduleTab" data-toggle="tab" style="cursor:pointer"><b>Class Schedule</b></a></li>
<!--					<li id="startdate" style="border-bottom:1px solid #ddd;width:20%;background-color:#ffffff" class="text-center"><a href="#classstart" data-toggle="tab" style="cursor:pointer"><b>Class Start Date</b></a></li>
					<?php if($register == "disable"){?>
					<a class='btn btn-large btn-success pull-right' id='register' href='/classroom_register' disabled><b>Register for Classroom Program</b></a>
					<?php } else{?>-->
					<a class='btn btn-large btn-success pull-right' id='register' href='/student/classroom/reg'><b>Register for Classroom Program</b></a>
				<!--<?php }?>-->
					</ul>
					   
				
			</div>
	
		
		<div class="text-center">
			<div class="tab-content">
				<div class="tab-pane active" style="font-size:16px;margin-bottom:20px;margin-left:10%" id="IITTab">
					<div class="text-center" style="margin-top:30px;">
						<h2 style="color:#823636">Direct Classroom Program for IIT JEE + CBSE</h2>
								<h3 style="line-height:10px">April 2016 to March 2017</h3>
								<h3>Std 8, 9, 10, 11, 12</h3>
								<h3 style="margin-top:20px;color:#0018d0">Physics, Chemistry and Maths Direct Classes
								</h3>
								<h3 style="line-height:10px;color:#0018d0">Registrations are open now for the academic year 2016-17</h3>
								<p>Registration is compulsory both for old students who are continuing and students joining new.</p>
								<p style="font-size:22px;margin-top:25px;line-height:10px">All classes for the new academic year will begin in the first week of April.</p>
								<p>Month of May will be summer vaccation and classes will resume again in June and go on till March.<br/>
								You can see the <!-- <a href="#scheduleTab" data-toggle="tab" style="cursor:pointer"><b> -->Class Schedule<!-- </b></a> --> by clicking on <a id="sch" href="#scheduleTab" data-toggle="tab" style="cursor:pointer"><b>schedule tab</b></a> above.</p>

								<h2>Class Registration and Enrolment Process</h2>
					</div>
					<div style="text-align:left">
					<ul style="list-style:none">Step 1:  <b>Click on <a class='btn btn-large btn-success' id='register' href='/student/classroom/reg'><b>Register for Classroom Program</b></a> and enter your email id.
								</b>
              					<li style="margin-left: 10%;">If you have an AhaGuru account already you will asked to enter the password.</li>
              					<li style="margin-left: 10%;">If you have an account but have forgotten the password, click on <a href="/forgotpwd"><strong>forgot Password.</strong></a></li></ul>
              					<ul style="list-style:none">Step 2:  <b>Fill in the registration form with your details              
								</b>
              					<li style="margin-left: 10%;">If you do not have an Ahaguru account, filling this form will create your account and you
              					will be sent an email with your password.</li></ul>
              					<ul style="list-style:none">Step 3:  <b>Select the classsroom courses you want to join.</b>
              					<!-- <li style="margin-left: 10%;">Only select the classroom courses you are sure to join.</li>
              					<li style="margin-left: 10%;">If later you want to add more courses you can login again and add them.</li> --></ul>
              					<ul style="list-style:none">Step 4:  <b>You will be sent an email with the classroom courses you have selected.</b>
              					</ul>
              					<ul style="list-style:none">Step 5:  <b>Once your registration has been done, we will be contacting you regarding the fees payment.<br/><span style="margin-left:6%">
								Registration is a preliminary step and you will need to confirm your seat by paying the fees.</span>
              					</b></ul>
              					</div>
              		<!-- <p style="margin-top:50px">Once your registration has been done, we will be contacting you regarding the fees payment.<br/>
					Registration is a preliminary step and you will need to confirm your seat by paying the fees.</p> -->
					<a class='btn btn-large btn-success' id='register' href='/student/classroom/reg'><b>Register Now <br/>Classroom Program 2016-17</b></a>				
					<h4>As there are limited seats, once all the seats for a particular batch are filled,<br/>we will be closing the registration for that batch.</h4>
					
							
					
				</div>
				
				<div class="tab-pane" id="scheduleTab" style="margin-top:30px;margin-bottom:20px">					
						<div class="text-center" style="margin-top:-5px;">
							<!-- <table class="table table-border" id="cltable" style="font-weight:bold;border:15px solid #00a8e7"> -->

						    <table class="table table-bordered" id="cltable" style="font-weight:bold;border:15px solid #00a8e7">
							<tr><td colspan="6" 
							style="background:#303192;color:#ffffff;font-size:20px;text-align:center;border: 5px solid #ffffff">Science + Physics Classes for IIT + CBSE by Balaji Sampath</td></tr>
							
							<tr style="background-color:#303192;">								
								<th style="text-align:center;color:#FFFFFF; padding:10px;border-left: 5px solid #ffffff;">Class</th>								
								<th style="text-align:center;color:#FFFFFF; padding:10px;">Course Name</th>
								<th style="text-align:center; color:#FFFFFF; padding:10px">Batch</th>
								<th style="text-align:center;color:#FFFFFF; padding:10px;">Location</th>
								<th style="text-align:center;color:#FFFFFF; padding:10px;">Weekly Schedule</th>
								<th style="text-align:center;color:#FFFFFF; padding:10px;border-right: 5px solid #ffffff;">Teachers</th>

							</tr>
							<tr style="background-color:#c5f0ff;">							
							<td rowspan="3"  style="text-align:center;border-left: 5px solid #ffffff;">Std 9<br/>
							+ <br/><span style="color:red">Advanced Std 8</span> </td>
							
							<td rowspan="3" style="text-align:center;">Physics + Chemistry Foundation <br/>for CBSE + IIT</td>				
							<td style="text-align:center;">P1</td>
							<td style="text-align:center;">Mylapore</td>
							<td style="text-align:center;">Friday 6.45 pm to 8.45 pm</td>
							<td rowspan="3" style="text-align:center;border-right: 5px solid #ffffff;">Balaji Sampath <br/> +<br/> Gomathi</td>
							</tr>
							<tr style="background-color:#c5f0ff;">						<td style="text-align:center;">P2</td>
							<td style="text-align:center;">T.Nagar</td>
							<td style="text-align:center;">Monday 5.00 pm to 7.00 pm</td></tr>
							<tr style="background-color:#c5f0ff;">						<td style="text-align:center;">P3</td>
							<td style="text-align:center;">Adyar</td>
							<td style="text-align:center;">Sunday 8.30 am to 10.30 am</td></tr>
							<tr style="background-color:#81deff;">
								<td style="text-align:center;border-left: 5px solid #ffffff;">Std 10</td>
							
							<td style="text-align:center;">Physics + Chemistry Bridge <br/> for CBSE + IIT <br/><span style="color:red">Std 10 + Selected Std 11 topics</span></td>				
							<td style="text-align:center;">P4</td>
							<td style="text-align:center;">Mandaveli</td>
							<td style="text-align:center;">Monday 5.30 pm to 7.30 pm</td>
							<td style="text-align:center;border-right:5px solid #ffffff">Balaji Sampath<br/> +<br/> Sudha Sridhar</td>
							</tr>

						   <tr style="background-color:#c5f0ff;">
								<td rowspan="2" style="text-align:center;border-left: 5px solid #ffffff;">Std 10</td>
							
							<td rowspan="2" style="text-align:center;">Physics + Chemistry Bridge <br/> for CBSE + IIT <br/><span style="color:red">Std 10 + Std 11 topics</span></td>				
							<td style="text-align:center;">P5</td>
							<td style="text-align:center;">Mylapore</td>
							<td style="text-align:center;">Friday 5.00 pm to 7.00 pm</td>
							<td rowspan="2" style="text-align:center;border-right:5px solid #ffffff">Balaji Sampath<br/> +<br/> D.P.Sankaran</td>
								</tr>
							<tr style="background-color:#c5f0ff">
							<td style="text-align:center;">P6</td>
							<td style="text-align:center;">T.Nagar</td>
							<td style="text-align:center;">Monday 7.00 pm to 9.00 pm</td>
							</tr>
								<tr style="background-color:#81deff;">
								<td rowspan="3"  style="text-align:center;border-left:5px solid #ffffff">Std 11</td>
							
							<td rowspan="3" style="text-align:center;">Physics Excellence <br/>for CBSE + IIT</td>				
							<td style="text-align:center;">P7</td>
							<td style="text-align:center;">Mylapore</td>
							<td style="text-align:center;">Tuesday 5.30 pm to 8.30 pm</td>
							<td rowspan="3" style="text-align:center;border-right:5px solid #ffffff">Balaji Sampath </td>
								</tr>
								<tr style="background-color:#81deff;">						<td style="text-align:center;">P8</td>
							<td style="text-align:center;">T.Nagar</td>
							<td style="text-align:center;">Wednesday 5.30 pm to 8.30 pm</td></tr>
							<tr style="background-color:#81deff;">						<td style="text-align:center;">P9</td>
							<td style="text-align:center;">Adyar</td>
							<td style="text-align:center;">Saturday 5.30 pm to 8.30 pm</td></tr>

							<tr style="background-color:#c5f0ff;">
								<td style="text-align:center;border-left:5px solid #ffffff;border-bottom:5px solid #ffffff">Std 12</td>
							
							<td style="text-align:center;border-bottom:5px solid #ffffff">Physics Excellence <br/> for CBSE + IIT </td>				
							<td style="text-align:center;border-bottom:5px solid #ffffff">P10</td>
							<td style="text-align:center;border-bottom:5px solid #ffffff">T.Nagar</td>
							<td style="text-align:center;border-bottom:5px solid #ffffff">Thursday 5.30 pm to 7.30 pm</td>
							<td style="text-align:center;border-right:5px solid #ffffff;border-bottom:5px solid #ffffff">Balaji Sampath<br/> +<br/> K.S. Balaji</td>
							</tr>
							</table>
							</div>
								
							<div class="text-center" style="margin-top:10px;">
										
								<table class="table table-bordered" id="cltable" style="font-weight:bold;border:15px solid #00a8e7">								
										<tr><td colspan="6" 
							style="background:#303192;color:#ffffff;font-size:20px;text-align:center;border: 5px solid #ffffff">Physics Classes for IIT JEE + CBSE by K.S. Balaji</td></tr>				
						   <tr style="background-color:#c5f0ff;">
								<td style="text-align:center;border-left:5px solid #ffffff;">Std 10</td>
							
							<td style="text-align:center;">Physics Bridge for CBSE + IIT <br/><span style="color:red">Std 10 + Selected Std 11 topics</span></td>				
							<td style="text-align:center;">P11</td>
							<td style="text-align:center;">Adyar</td>
							<td style="text-align:center;">Friday 5.30 pm to 7.30 pm</td>
							<td style="text-align:center;border-right:5px solid #ffffff">K.S. Balaji <br/> +<br/> SuryaKumar</td>
								</tr>
							
								<tr style="background-color:#81deff;">
								<td rowspan="2" style="text-align:center;border-left:5px solid #ffffff;border-bottom:5px solid #ffffff">Std 12</td>
							
							<td rowspan="2" style="text-align:center;border-bottom:5px solid #ffffff">Physics Excellence <br/>for CBSE + IIT</td>				
							<td style="text-align:center;">P12</td>
							<td style="text-align:center;">Adyar</td>
							<td style="text-align:center;">Wednesday 5.30 pm to 8.30 pm</td>
							<td rowspan="2" style="text-align:center;border-right:5px solid #ffffff;border-bottom:5px solid #ffffff">K.S. Balaji</td>
								</tr>
								<tr style="background-color:#81deff;"><td style="text-align:center;border-bottom:5px solid #ffffff">P13</td>
							<td style="text-align:center;border-bottom:5px solid #ffffff">Mylapore</td>
							<td style="text-align:center;border-bottom:5px solid #ffffff">Tuesday 5.30 pm to 8.30 pm</td></tr>							 
							</table>
							</div>														

								<div style="margin-top:15px;float:left;margin-bottom:15px;"><button class="btn btn-primary others" id="chemclasses"><i class='icon-plus icon-white'></i></button><h4 style="display:inline"> Chemistry Classes by (D.P. Sankaran, R. Lakshminarayanan and U. Kameswari)</h4></div>				
								<div id="chemclasses" style="display:none;margin-top:10px" class="text-center">										
								<table class="table table-bordered" id="cltable" style="font-weight:bold;border:15px solid #a7ce39">
								<tr><td colspan="6" style="background:#46812b;color:#ffffff;text-align:center;border:5px solid #ffffff;font-size:20px">Chemistry Classes at Mylapore, T.Nagar and Adyar</td></tr>
								<tr style="background-color:#779727;">
									<th style="text-align:center;color:#FFFFFF; padding:10px;border-left:5px solid #ffffff">Class</th>
								<th style="text-align:center;color:#FFFFFF; padding:10px;">Course Name</th>

									<th style="text-align:center; color:#FFFFFF; padding:10px">Batch</th>
									
									<th style="text-align:center;color:#FFFFFF; padding:10px;">Location</th>
									
									<th style="text-align:center;color:#FFFFFF; padding:10px;">Weekly Schedule</th>
								<th style="text-align:center;color:#FFFFFF; padding:10px;border-right:5px solid #ffffff">Teachers</th>	
								</tr>
								<tr style="background-color:#e6f0c1;">
								<td style="text-align:center;border-left:5px solid #ffffff">Std 11</td>				
								<td style="text-align:center;">Chemistry for CBSE</td>
								<td style="text-align:center;">C1</td>
									<td style="text-align:center;">Mylapore</td>
									<td style="text-align:center;">Friday 5.30 pm - 8.30 pm </td> 
									<td rowspan="4"style="text-align:center;border-right:5px solid #ffffff">
										D.P.Sankaran<br/>+<br/>
										R.Lakshminarayanan<br/>S.Santhanam
									</td>
								</tr>
								<tr style="background-color:#e6f0c1;">
								<td style="text-align:center;border-left:5px solid #ffffff">Std 11</td>				
								<td style="text-align:center;">Chemistry for IIT + CBSE </td>
								<td style="text-align:center;">C2
								</td>
									<td style="text-align:center;">Mylapore</td>
									<td style="text-align:center;">Sunday 3.30 pm - 7.30 pm </td> 
								</tr>
								<tr style="background-color:#e6f0c1;">
								<td style="text-align:center;border-left:5px solid #ffffff">Std 12</td>				
								<td style="text-align:center;">Chemistry for CBSE</td>
								<td style="text-align:center;">C3</td>
									<td style="text-align:center;">Mylapore</td>
									<td style="text-align:center;">Sunday 5.30 pm - 8.30 pm</td> 
								</tr>
								<tr style="background-color:#e6f0c1;">
								<td style="text-align:center;border-left:5px solid #ffffff">Std 12</td>		
								<td style="text-align:center;">Chemistry for IIT + CBSE</td>
								<td style="text-align:center;">C4</td>
									<td style="text-align:center;">Mylapore</td>
									<td style="text-align:center;">Wednesday 5.00 pm - 9.00 pm
									</td> 
								</tr>
									<tr style="background-color:#d1e288;">
								<td style="text-align:center;border-left:5px solid #ffffff">Std 11</td>		
								<td style="text-align:center;">Chemistry for IIT + CBSE </td>
								<td style="text-align:center;">C5</td>
									<td style="text-align:center;">T.Nagar</td>
									<td style="text-align:center;">Monday 5.00 pm - 9.00 pm
									</td> 
									<td rowspan="2" style="text-align:center;border-right:5px solid #ffffff">
									D.P.Sankaran<br/>+<br/>R.Lakshminarayanan
									</td>
								</tr>
								<tr style="background-color:#d1e288;">
								<td style="text-align:center;border-left:5px solid #ffffff">Std 12</td>		
								<td style="text-align:center;">Chemistry for IIT + CBSE </td>
								<td style="text-align:center;">C6</td>
									<td style="text-align:center;">T.Nagar</td>
									<td style="text-align:center;">Saturday 5.00 pm - 9.00 pm
									</td> 
									</tr>								
									<tr style="background-color:#e6f0c1;">
								<td style="text-align:center;border-left:5px solid #ffffff">Std 10</td>				
								<td style="text-align:center;">Chemistry Foundation</td>
								<td style="text-align:center;">C7</td>
									<td style="text-align:center;">Adyar</td>
									<td style="text-align:center;">Wednesday 5.30 pm - 7.30 pm </td> 
									<td rowspan="3"style="text-align:center;border-right:5px solid #ffffff;border-bottom:5px solid #ffffff">
										U.Kameswari
									</td>
								</tr>
								<tr style="background-color:#e6f0c1;">
								<td style="text-align:center;border-left:5px solid #ffffff">Std 11</td>				
								<td style="text-align:center;">Chemistry for IIT + CBSE </td>
								<td style="text-align:center;">C8
								</td>
									<td style="text-align:center;">Adyar</td>
									<td style="text-align:center;">Thursday 5.30 pm - 8.30 pm </td> 
								</tr>
								<tr style="background-color:#e6f0c1;">
								<td style="text-align:center;border-left:5px solid #ffffff;border-bottom:5px solid #ffffff">Std 12</td>				
								<td style="text-align:center;border-bottom:5px solid #ffffff">Chemistry for IIT + CBSE</td>
								<td style="text-align:center;border-bottom:5px solid #ffffff">C9</td>
									<td style="text-align:center;border-bottom:5px solid #ffffff">Adyar</td>
									<td style="text-align:center;border-bottom:5px solid #ffffff">Tuesday 5.30 pm - 8.30 pm</td> 
								</tr>								
								  </table>			 
								</div>			


								<div style="float:left;margin-bottom:15px;"><button class="btn btn-primary others" id="mathclasses" ><i class='icon-plus icon-white'></i></button><h4 style="display:inline"> Math Classes by (Rajesh Sadagopan, L.Venkataraman, Ravishankar)</h4></div>		
							<div  id="mathclasses" style="display:none;margin-top:10px" class="text-center">
										
								<table class="table table-bordered" id="cltable" style="font-weight:bold;border:15px solid #f58221">
								<tr><td colspan="6" 
							style="background:#9f390d;color:#ffffff;font-size:20px;text-align:center;border: 5px solid #ffffff">Maths Classes at Mylapore, T.Nagar and Adyar</td></tr>				
								<tr style="background-color:#da511f;">
									<th style="text-align:center;color:#FFFFFF; padding:10px;border-left:5px solid #ffffff">Class</th>
								<th style="text-align:center;color:#FFFFFF; padding:10px;">Course Name</th>

									<th style="text-align:center; color:#FFFFFF; padding:10px">Batch</th>
									
									<th style="text-align:center;color:#FFFFFF; padding:10px;">Location</th>
									
									<th style="text-align:center;color:#FFFFFF; padding:10px;">Weekly Schedule</th>
								<th style="text-align:center;color:#FFFFFF; padding:10px;border-right:5px solid #ffffff">Teachers</th>	
								</tr>
								<tr style="background-color:#fed09e;">
								<td style="text-align:center;border-left:5px solid #ffffff">Std 5-8</td>	
								<td style="text-align:center;">Math Olympiad Level 1 </td>
								<td style="text-align:center;">M1</td>
									<td style="text-align:center;">Mylapore</td>
									<td style="text-align:center;">Sat 6.45 pm - 8.00 pm <br/> Sun 7.30 am - 8.45 am</td> 
									<td rowspan="10"style="text-align:center;border-right:5px solid #ffffff">Rajesh Sadagopan</td>
								</tr>
								<tr style="background-color:#fed09e;">
								<td style="text-align:center;border-left:5px solid #ffffff">Std 5-8</td>				<td style="text-align:center;">Math Olympiad Level 1 </td>
								<td style="text-align:center;">M2</td>
									<td style="text-align:center;">Mylapore</td>
									<td style="text-align:center;">Sat 4.15 pm - 5.30 pm <br/> Sun 8.45 am - 10.00 am</td> 
								</tr>
								<tr style="background-color:#fed09e;">
								<td style="text-align:center;border-left:5px solid #ffffff">Std 5-8</td>				<td style="text-align:center;">Math Olympiad Level 1 </td>
								<td style="text-align:center;">M3</td>
									<td style="text-align:center;">Mylapore</td>
									<td style="text-align:center;">Sat 5.30 pm - 6.45 pm <br/> Sun 10.00 pm - 11.15 pm</td> 
								</tr>
								<tr style="background-color:#fed09e;">
								<td style="text-align:center;border-left:5px solid #ffffff">Std 9-12</td>		
								<td style="text-align:center;">Math Olympiad Level 2 </td>
								<td style="text-align:center;">M4</td>
									<td style="text-align:center;">Mylapore</td>
									<td style="text-align:center;">Sunday 5.00 pm - 8.00 pm
									</td> 
								</tr>
									<tr style="background-color:#fed09e;">
								<td style="text-align:center;border-left:5px solid #ffffff">Std 7-8</td>		
								<td style="text-align:center;">Math Foundation for IIT + CBSE </td>
								<td style="text-align:center;">M5</td>
									<td style="text-align:center;">Mylapore</td>
									<td style="text-align:center;">Tuesday 5.00 pm - 6.30 pm
									</td> 
								</tr>

								<tr style="background-color:#fed09e;">
								<td style="text-align:center;border-left:5px solid #ffffff">Std 7-8</td>		
								<td style="text-align:center;">Math Foundation for IIT + CBSE </td>
								<td style="text-align:center;">M6</td>
									<td style="text-align:center;">Mylapore</td>
									<td style="text-align:center;">Wednesday 5.00 pm - 6.30 pm
									</td> 
								</tr>

								<tr style="background-color:#fed09e;">
								<td style="text-align:center;border-left:5px solid #ffffff">Std 9-10</td>		
								<td style="text-align:center;">Math Foundation for IIT + CBSE </td>
								<td style="text-align:center;">M7</td>
									<td style="text-align:center;">Mylapore</td>
									<td style="text-align:center;">Tuesday 6.30 pm - 8.30 pm
									</td> 
								</tr>
								<tr style="background-color:#fed09e;">
								<td style="text-align:center;border-left:5px solid #ffffff">Std 9-10</td>		
								<td style="text-align:center;">Math Foundation for IIT + CBSE </td>
								<td style="text-align:center;">M8</td>
									<td style="text-align:center;">Mylapore</td>
									<td style="text-align:center;">Wednesday 6.30 pm - 8.30 pm
									</td> 
								</tr>
								<tr style="background-color:#fed09e;">
								<td style="text-align:center;border-left:5px solid #ffffff">Std 11</td>		
								<td style="text-align:center;">Advanced Mathematics for IIT </td>
								<td style="text-align:center;">M9</td>
									<td style="text-align:center;">Mylapore</td>
									<td style="text-align:center;">Monday 5.30 pm - 8.30 pm
									</td> 
								</tr>
								<tr style="background-color:#fed09e;">
								<td style="text-align:center;border-left:5px solid #ffffff">Std 12</td>		
								<td style="text-align:center;">Advanced Mathematics for IIT </td>
								<td style="text-align:center;">M10</td>
									<td style="text-align:center;">Mylapore</td>
									<td style="text-align:center;">Thursday 5.30 pm - 8.30 pm
									</td> 
								</tr>
								<tr style="background-color:#f9a870;">
								<td style="text-align:center;border-left:5px solid #ffffff">Std 7-8</td>		
								<td style="text-align:center;">Math Foundation for IIT + CBSE</td>
								<td style="text-align:center;">M11</td>
									<td style="text-align:center;">T.Nagar</td>
									<td style="text-align:center;">Friday 5.00 pm - 6.30 pm
									</td> 
									<td rowspan="2" style="text-align:center;border-right:5px solid #ffffff">Rajesh Sadagopan</td>
								</tr>
								<tr style="background-color:#f9a870;">
								<td style="text-align:center;border-left:5px solid #ffffff">Std 9-10</td>		
								<td style="text-align:center;">Math Foundation for IIT + CBSE</td>
								<td style="text-align:center;">M12</td>
									<td style="text-align:center;">T.Nagar</td>
									<td style="text-align:center;">Friday 6.30 pm - 8.30 pm
									</td> </tr>
									<tr style="background-color:#f9a870;">
								<td style="text-align:center;border-left:5px solid #ffffff">Std 11</td>		
								<td style="text-align:center;">Mathematics for IIT + CBSE</td>
								<td style="text-align:center;">M13</td>
									<td style="text-align:center;">T.Nagar</td>
									<td style="text-align:center;">Tuesday 5.30 pm - 8.30 pm
									</td> 
									<td rowspan="2" style="text-align:center;border-right:5px solid #ffffff">L.Venkataraman <br/>+<br/>R.Lakshminarayanan</td>
								</tr>
								<tr style="background-color:#f9a870;">
								<td style="text-align:center;border-left:5px solid #ffffff">Std 12</td>		
								<td style="text-align:center;">Mathematics for IIT + CBSE</td>
								<td style="text-align:center;">M14</td>
									<td style="text-align:center;">T.Nagar</td>
									<td style="text-align:center;">Wednesday 5.30 pm - 8.30 pm
									</td> </tr>
									<tr style="background-color:#fed09e;">
								<td style="text-align:center;border-left:5px solid #ffffff">Std 9</td>		
								<td style="text-align:center;">Math Foundation for IIT + CBSE</td>
								<td style="text-align:center;">M15</td>
									<td style="text-align:center;">Adyar</td>
									<td style="text-align:center;">Saturday 5.00 pm - 7.00 pm
									</td> 
									<td rowspan="3" style="text-align:center;border-right:5px solid #ffffff">Ravishankar <br/>+<br/>Jayaram</td>
								</tr>
								<tr style="background-color:#fed09e;">
								<td style="text-align:center;border-left:5px solid #ffffff">Std 10</td>		
								<td style="text-align:center;">Math Foundation for IIT + CBSE</td>
								<td style="text-align:center;">M16</td>
									<td style="text-align:center;">Adyar</td>
									<td style="text-align:center;">Sunday 8.30 am - 10.30 am
									</td> </tr>
									<tr style="background-color:#fed09e;">
								<td style="text-align:center;border-left:5px solid #ffffff">Std 11</td>		
								<td style="text-align:center;">Mathematics for IIT + CBSE</td>
								<td style="text-align:center;">M17</td>
									<td style="text-align:center;">Adyar</td>
									<td style="text-align:center;">Friday 5.30 pm - 8.30 pm
									</td> </tr>
									<tr style="background-color:#fed09e;">
								<td style="text-align:center;border-left:5px solid #ffffff;border-bottom:5px solid #ffffff">Std 12</td>		
								<td style="text-align:center;border-bottom:5px solid #ffffff">Mathematics for IIT + CBSE</td>
								<td style="text-align:center;border-bottom:5px solid #ffffff">M18</td>
									<td style="text-align:center;border-bottom:5px solid #ffffff">Adyar</td>
									<td style="text-align:center;border-bottom:5px solid #ffffff">Monday 5.30 pm - 8.30 pm
									</td> 
									<td style="text-align:center;border-right:5px solid #ffffff;border-bottom:5px solid #ffffff">RaviShankar<br/>+<br/>L. Venkataraman</td>
									</tr>
								  </table>			 
								</div>					
						</div>
			
				</div>
			</div>
		</div>		
		
	</div>
	
	
	<div class="bottom-band">
		<div class="container">
			<div class="row-fluid">
				<div class="span6 bottom-btn-link">
					<!--<button class="btn">FAQ</button>
					<button class="btn">Help</button>-->
					<button class="btn" id="enquiry" data-toggle="modal" data-target="#enquiryModal">Enquiry</button>
					 		<span class="pull-right">
					 	<a href="/classroom">Classroom Programs</a>
		 				<a href="/online">Online Courses</a>
						<a href="/books">Books</a>	
						<a style="cursor:pointer" id="about"  data-backdrop="static" data-toggle="modal" data-target="#aboutmodal">About</a>					
						</span>
				</div>
				<div class="span6">
					<div class="contactTxt">CONTACT</div>
					<div class="contactLink">
					<p>+91 96001 00090</p>
					<p class="emailLink"><a href="mailto:learn@ahaguru.com">learn@ahaguru.com</a></p>
					</div>
					
					
				</div>
			</div>
		</div>
	</div>
		   
	
	<!-- Sign up Modal & Login Modal -->

<!-- Sign in Modal -->
	<div id="signinModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
				<div class="modal-headerr text-center">
			
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				<!-- <h3>Sign in</h3> -->
				<!-- <ul class="nav nav-tabs" id="mainLiginTab" style="margin-bottom:0px;border-bottom:0px solid #ddd;">
					<li class="active" style="border-bottom:1px solid #ddd;"><a href="#loginTab" data-toggle="tab"><b>Log In</b></a></li>
					<li style="border-bottom:1px solid #ddd;"><a href="#signupTab" data-toggle="tab"><b>Sign Up</b></a></li>
				</ul> -->

			</div>
			
		<div class="modal-body" style="margin:30px;border:1px solid #000000;overflow:hidden">
			<font color="#00A0E3"><h4>Sign in:</h4></font>
				<form id="signin" method="post" action="<?php echo Router::url('/login'); ?>">
					<div class="text-center span2"><font size="3px">Your email or user id:</font></div> 
					<input type="text" id="required" name="data[Student][email]" style="margin-left:10px;"><br/>
					 <div class="error_msg" style="color:red;text-align:center;display:none">Enter valid Email ID</div>
					<font color="#00A0E3"><h4>Do you have AhaGuru password:</h4>
					</font>
					<div class="text-center span2"><input type="radio" id="havepassword" name="checkpwd" checked="checked" /><font size="3px"> Yes, I have a password:</font>
					</div>
					<input type="password" id="required" name="data[Student][password]" style="margin-left:10px;">	<a href="/forgotpwd"><strong>Forgot Password?</strong></a>
					<div class="error_msg" style="color:red;text-align:center;display:none">Password Field cannot be empty</div>
					<div id="warning" style="color:red;text-align:center;"></div>
					<div class="text-center span2">
					<input type="radio" id="nopassword" name="checkpwd"/><font size="3px"> No, I am a new student</font>					
					</div>
					<div class="span6" style="margin-top:10px;margin-left:10%">
					<button id="newsignin" type="submit" class="btn btn-large btn-primary">Sign In</button>
					</div>
				</form>
			<!-- <div class="tab-content">
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
								<h3 style="line-height:35px;">
								 <div>Signing up gives you free access to the 1st lesson of every course!</div></h3>
								 <h3>Please Enter your Name and Email Id</h3>								
							</div>
							<div class="span6">
								<form class="frmstyle" id="signup" action="<?php echo Router::url("/register"); ?>"  method="post">							
									<input id="required" class="inputLarge"  name="data[Student][name]" type="text" placeholder="Enter your full name" />
					                <span class="error_msg" style="color:red;display:none;">Enter your Name</span>
									<input id="required" class="inputLarge"  name="data[Student][email]" type="text" placeholder="Enter your email id" /><br>
									<span class="error_msg" style="color:red;display:none;">Enter your Email ID
									</span>	
									<span id="emailwar" style='color:red;text-align:center;'></span>
									<select id="classinschool" class="inputLarge" style="height:45px; padding-top:10px; width:372px;" name="data[Student][standard]">
										<option value="0" selected="selected">Select your class in school</option>
								        <?php foreach($standard as $stnd) {?>
						                  <option value="<?php echo $stnd['Standard']['id']; ?>">
						                	<?php echo "Class ".$stnd['Standard']['name']; ?>
						                  </option>                 
						                <?php }?>
									</select>
									<span id="stdwar" style='color:red;text-align:center;'></span>
									<label style="font-size:18px">
										<input type="checkbox" name="agree" value="1" checked="checked" style="margin-bottom:5px;" disabled>&nbsp;&nbsp;&nbsp; Yes, I agree to the Ahaguru Terms of Use
									</label>
					  				<button id="signup" type="submit" class="btn btn-large btn-primary">Free Sign Up</button>
									<div style="font-size:18px;margin-top:10px;">		After you sign up, 	we will email your 		password for you to log in.
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div> -->
		</div>
	</div>
	<!-- Sign in Modal End -->

	<!--Sign up Modal -->
	<div id="signupModal" class="modal hide fade" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
				<div class="modal-headerr text-center">			
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>	
				<!-- <h3>Sign Up</h3>							 -->
			</div>
			
		<div class="modal-body" style="margin:30px;border:1px solid #000000;overflow:hidden">
				<form id="signup" method="post" action="<?php echo Router::url('/register'); ?>">
					<div class="span2" style="text-align: right;"><font size="3px">My Name is:</font></div> 
					<input type="text" id="required" name="data[Student][name]" style="margin-left:10px;"><br/>
					<div class="error_msg" style="color:red;text-align:center">Enter your name</div>
					<div class="span2" style="text-align: right;"><font size="3px">My Email id is:</font></div> 
					<input type="text" id="required" name="data[Student][email]" style="margin-left:10px;"><br/>					 
					 <div class="error_msg" style="color:red;text-align:center">Enter valid Email ID</div>	
					 <div id="emailwar" style='color:red;text-align:center;'></div>
					 <div class="span2" style="text-align: right;"><font size="3px">Retype your Email id:</font></div> 
					<input type="password" id="required" name="data[Student][retypeemail]" style="margin-left:10px;"><br/>					 
					 <div class="error_msg" style="color:red;text-align:center">Retype your Email id</div>	
					  <div class="mismatch_msg" style="color:red;text-align:center;"></div>	
					  <div class="span2" style="text-align: right;"><font size="3px">Standard:</font></div> 
					 <select id="classinschool" style="height:35px;padding-top:10px;margin-left:10px; width:auto;" name="data[Student][standard]">
					<option value="0" selected="selected">Select your class in school</option>
					    <?php foreach($standard as $stnd) {?>
					        <option value="<?php echo $stnd['Standard']['id']; ?>">
					           <?php echo "Class ".$stnd['Standard']['name']; ?>
						        </option>                 
						       <?php }?>
							</select>
							<div id="stdwar" style='color:red;text-align:center;'></div>										 
					<div class="span5 text-center" style="margin-top:10px;">
					<p><input type="checkbox" name="agree" value="1" style="vertical-align:middle; margin-bottom:7px;" required = "required"> &nbsp; Yes, I agree to the <a href="<?php echo Router::url("/trmsandcon"); ?>" target="new">Ahaguru Terms of Use</a></p>
					<button id="newsignup" type="submit" class="btn btn-large btn-primary">Sign Up</a>
					</div>
				</form>	
		</div>
	</div>
	<!-- Sign up Modal End -->
	<!-- Sign up Modal End -->
	
	<!-- Enquiry Modal 
	<div id="enquiryModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="width:450px;">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			<h3 id="myModalLabel">Enquiry</h3>
		</div>
		<div class="modal-body">
			<div>+91 96001 00090</div>
			<div></i> learn@ahaguru.com</div>
		</div>
		<div class="modal-footer"></div>
	</div>-->
	<!-- Login Modal End -->

	<div id="enquiryModal" class="modal hide fade span5" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="margin-left:-250px;">
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
		<span class="error_msg" style="color:red;display:none;">Please Enter your query</span><br>
	   <input id="required" name="data[toemail]" type="hidden" value="learn@ahaguru.com">
		<b>Contact : </b> <span>+91 96001 00090
					<p><a href="mailto:learn@ahaguru.com">learn@ahaguru.com</a></p></span>
			<button id="query"  class="btn btn-primary">Submit</button> </form>
						</center>		  
		</div>
		<div class="modal-footer"></div>
	</div>
	
	<div id="loading" class="modal hide fade span5" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="margin-left:-250px">
		<div class="modal-header">
			<h3 id="myModalLabel">Loading</h3></center>
				</div>

		<div class="modal-body">
			<img src="/img/loading.gif"></img> <h3>  Please Wait....</h3>
		</div>
		<div class="modal-footer"></div>
	</div>
	
	<!-- Coupon Modal1 -->
	<div id="couponModal" class="modal hide fade span8" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"  data-backdrop="static"  style="margin-left: -400px;">
		
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			<center><h3>Pre-Paid Course Coupon </h3></center>
		
		</div>
		<div class="modal-body " style="margin:20px;">
		<form id="coupon" action="/" method="post">
		<h4 ><input type="radio" id="havecode" name="coupcode" value="yes" checked >&nbsp;&nbsp;I have a pre-paid course coupon.  <br><br>Coupon Code : <input type="text" id="required" name="couponcode"/>
	  <button id="sub" style="margin-bottom:10px" type="submit" class="btn btn-primary">Enter</button></h4>
	 
	<span class="error_msg" style="display:none;"><b>Enter valid coupon code.</b></span>
	
	<h4><input type="radio" id="nocode" name="coupcode" value="no" >&nbsp;&nbsp;I don't have a pre-paid coupon :</h4></form>
	<ol><li> <h4 style="font-weight:normal"> To directly purchase course coupon online using credit/ debit card click here  <a id="signup"  class="btn btn-primary"  href="/online">Proceed...</a></h4></li>
		<li><h4 style="font-weight:normal">To purchase pre-paid course coupon please call +91 96001 00090.</h4></li></ol>
		 
	 
   </div>
   </div>
						
	<!--- Coupon Modal1 ends -->


	<!-- Coupon Modal2 -->
	<div id="couponMod" class="modal hide fade span8" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"   data-backdrop="static"  style="margin-left: -400px;">
		
			<div class="modal-header">			
			<center><h3>Thank you for purchasing  an AhaGuru Course Coupon! </h3></center>
		
		</div>
		<div class="modal-body text-center" style="margin-top:20px;">
				
			<a id="login" class="btn btn-large btn-success pull-left" href="/coupon_login">Yes. I already have an AhaGuru account.<br> Please activate my course</a>
 
			<a id="signup"  class="btn btn-large btn-success pull-right"  href="/register">No. I don’t have an AhaGuru account yet.<br>Please create my account and activate my course</a>

			<a class="pull-left span3"  href="/forgotpwd">Forgot Password?</a>
	 
		</div>
   </div>
						
	<!--- Coupon Modal2 ends -->

<div id="courModal" class="modal hide fade span7" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="margin-left: -315px;">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			<h3><center>Proceed To Register</center></h3>
		</div>
		<div class="modal-body" style="margin-top:20px;">
			<button class="btn btn-success pull-left span3" data-toggle="modal" data-target="#signupModal" id="logLink">Yes, I have already registered for direct classroom.<br>Click here to Log in</button>
			<a href="/classroom_register" class="btn btn-success pull-right span3" id="signLink" style="margin-left:20px;">No, I have not yet regidtered for direct classroom <br>Click here to create account</a>
			</form>

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