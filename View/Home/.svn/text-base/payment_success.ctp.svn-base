<?php
echo $this->Html->script("Home/payment_success.js?random=2", array("inline" => false));
?>
<div class="top-ribbon" style="margin-top:65px;">
		<div class="container">
			<div class="row-fluid">
				<div class="span4 top-ribbon-head" style="margin-top:15px">Login </div>
				<div class="span8"></div>
			</div>
		</div>
	</div>
	
	<div class="container" style="background-color:#FFFFFF; min-height:450px;">
<div class="row-fluid" style="padding-top:20px;">
			<div class="span12 text-center">
						
			<h4><p>Congratulations! You have successfully enrolled in The Hindu AhaGuru Physics Challenge 2015!</p>
			<p>Your AhaGuru User Name and Password has been sent from <a href="mailto:info@ahaguru.com">info@ahaguru.com</a> to your registered email ID</p>
			<p>Please check the email message and login with the AhaGuru User Name and Password sent to you to access your course.</p></h4>
<form id="login" class="form-horizontal" method="post" action="/login" style="padding-top:40px;">
						
			<div class="control-group">
				
			<div class="control">
			<input type="text"  class="email" id="required" placeholder="Enter your Email Id" 
				name="data[Student][email]"><br>
        	<span class="error_msg" style="color:red;display:none;">Enter valid Email ID
        	</span>
							</div>
						</div>

						<div class="control-group">
											<div class="control">
        <input type="password" id="required" class="password" placeholder="Enter your Password" name="data[Student][password]"><br>
        <span class="error_msg" style="color:red;display:none;">Password Field cannot be empty</span>
        <span id="warning" style='color:red;text-align:center;'></span><br>
    
							</div>
						</div>
                        
						<div class="control-group">
							<div class="control">
								<button id="submit" class="btn btn-primary ">Log in</button>
								<br><br>
								<a href="/forgotpwd">Forgot Password?</a>
							</div>
						</div>
					</form>		
				
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
		</div>
	</div>

<div class="modal hide" id="video_modal">
    <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
          <hr>
     </div>
        <div class="modal-body" style="height:auto;">
         <center><h3><%=result.result%></h3></center>
      </div>  

  </div>


