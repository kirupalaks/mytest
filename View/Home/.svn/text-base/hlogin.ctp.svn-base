<?php
 echo $this->Html->script("Home/hlogin.js?random=2", array("inline" => false));
?>	
<div class="top-ribbon" style="margin-top:95px;">
		<div class="container">
			<div class="row-fluid">
				<div class="top-ribbon-head text-center"><h3> You already have an 
				AhaGuru account! Enter your password ... </h3></div>			
			</div>
		</div>
	</div>
	
	<div class="content" style="background-color:#c6d9f1; min-height:450px;">
		<div class="row-fluid" style="padding-top:20px;">
			<div class="span12">						
							
					<form id="login" class="form-horizontal text-center" method="post" action="/hlogin">
			<input type="text"  class="student_level" id="student_level"
				name="data[level]" value="<?php echo $level;?>" style="display:none"><br>	<div class="row" style="margin-top:20px;margin-left:5%">  			
			<div class="control-group sec">		
			<b >Email </b>
			<input type="text"  class="email" id="required email" placeholder="Enter your Email Id" 
				name="data[email]" value="<?php echo $email;?>" style="margin-left:10px;" readonly>				
						</div>
						</div>
				<h4>You already have an AhaGuru account. Enter your password to continue:</h4>
			<div class="row" style="margin-top:10px;">
				<div class="control-group sec">							
		<b >AhaGuru Password </b>
        <input type="password" id="required" class="password" placeholder="Enter your Password" name="data[password]" style="margin-left:10px;"><br/>
           <div class="span" >
           		<span class="error_msgpwd" style="color:red;display:none;margin-left:10px;">Enter valid Password</span>	                
           </div>
                
        	</div>
		        			<div class="span8">			              			
				<a class="pull-right" style="cursor:pointer;text-decoration:none;color:#000000;font-style:italic;margin-right:6%" data-toggle='modal' data-backdrop="static" data-target='#frgt'>Forgot Password?</a>			
							</div>
							<div class="span8">			
							<a id="submit" class="btn btn-primary pull-right" style="margin-right:6%">Log in</a>
								
								
							</div>
						</div>
					</form>		
				</div>
				</div>
			
</div>
</div>
	<div id="loading" class="modal hide fade span5" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="margin-left:-250px;">
		<div class="modal-header">
		<h3><center>Loading....</center></h3>
		</div>
		<div class="modal-body">
			<img src="/img/loading.gif"></img> <h3>  Please Wait....</h3>
		</div>
		<div class="modal-footer"></div>
	</div>

<div id="frgt" class="modal hide fade span6" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="margin-left: -400px;">
       <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true" >×</button>
        <h3><center>Forgot Password</center></h3>
      </div>
 
    
    <div class="modal-body text-center">
    <div class="span5" id="warning" style="margin-left:11%;margin-top:20px;"></div><br>       
    <form id="reset_password" class="form-horizontal" method="post" 
                action="&lt;?php echo Router::url('/'); ?&gt;" 
                style="padding-top:40px;">

            <div class="control-group">
              <label class="control-label" for="input01">Email ID</label>
                <div class="controls">
                  <input type="text" class="email" id="required email" name="data[User][email]"><br>
                  <span class="error_msg" style="color:red;display:none;">
                    Enter valid Email ID
                  </span>
                </div>
            </div>
            
            <div class="control-group">
              <div class="controls">
                  <button id="frgt" class="btn btn-primary">Submit</button>
                &nbsp;&nbsp;&nbsp;&nbsp;
              </div>
            </div>
          </form>  
        </div>
        </div>

        <!--Popup for already loggedin user-->
		<div id="alreadylogged" class="modal hide fade span8" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="margin-left: -400px;" data-backdrop="static">
			<div class="modal-header">
				<center><h3>Already Enrolled</h3></center>
			</div>
		
		<div class="modal-body" style="margin:20px;">			
     	 	<p> <font size="4px">You have already enrolled in <b>The Hindu AhaGuru Physics Challenege 2015.</b> Please go to MyCourses page to start learning</font></p>
     	 	 <a class="btn btn-primary" href="/student/course">My Courses</a>
   			</div>
   		</div>


   <!--End Popup for already registered user-->