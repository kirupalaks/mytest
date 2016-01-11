<?php echo $this->Html->script("Home/hsignup.js?random=2", array("inline" => false));
?>
<div class="top-ribbon" style="margin-top:100px;background-color:#a4a4a4">
    <div class="container">
      <div class="row-fluid">
        <div class="top-ribbon-head text-center">
        <h3 style="line-height:1">Step 1</h3></div>       
      </div>
    </div>
  </div>
  
  <div style="background-color:#bebebe;">
    <div class="row-fluid text-center" style="padding-top:20px;">
      <div class="span12">              
        <div class="row" style="margin:20px;">  
          <div class="control-group sec">                             
          <div class="controls">
            <font color="#595959">Email ID </font>
                  <input style="margin-left:10px" type="text" id="required email" name="data[Student][email]" value="<?php echo $email; ?>" readonly/>        
                    </div>
                </div>                                             
      </div>
    </div>
  </div>
</div>
 <div class="top-ribbon" style="margin-top:-10px;">
    <div class="container">
      <div class="row-fluid">
        <div class="top-ribbon-head text-center" >
        <h3 style="line-height:1">Step 2</h3></div>       
      </div>
    </div>
  </div>
  <div  style="background-color:#c6d9f1;">
  <div class="container">
	<div class="row-fluid text-center" style="padding-top:20px;">
      <div class="span12">                  

			<form action="/hsignup"  method="post" accept-charset="utf-8" id="signup">       
        <input type="text" id="student_level" name="data[Student][level]"  
      value="<?php echo $level ?>" style="display:none" />          
              <input type="text" id="required email" name="data[Student][email]" value="<?php echo $email ?>" style="display:none" readonly/>               
              <div class="row" style="margin-left:10px;">                     
              <div class="control-group sec span5">
              <span class="span4 frm-txt-styl">Student Name </span>
              <input type="text" id="required" name="data[Student][name]" />
              <br/>
                <span class="error_msg" style="color:red;">Enter your Name</span>              
              </div>          
              <div class="control-group sec span5">
           <span class="span4 frm-txt-styl" >Class </span>
            <select name="data[Student][standard]" id="required">
              <option value="0">Select your class</option>
              <?php
                 foreach($standard as $stnd) {               
                  ?>
                <option value="<?php echo $stnd['Standard']['id']; ?>">
                     <?php echo "Class ".$stnd['Standard']['name']; ?>
                     </option>            
              <?php } ?>
            </select><br>
            <span class="error_msgstd" style="color:red;display:none;">Select your class in school</span>             
          </div>
              </div>
              <div class="row" style="margin-left:10px;">  
          
          <div class="control-group sec span5">
            <span class="span4 frm-txt-styl">School </span>
            <input type="text" id="required" name="data[Student][school_name]"  
            /><br/>
            <span class="error_msg" style="color:red;">Enter your School Name</span>             
          </div>          
          <div class="control-group sec span5">
            <span class="span4 frm-txt-styl">City </span>
            <input type="text" id="required" name="data[Student][place]"/><br/>
            <span class="error_msg" style="color:red;">Enter your City</span>            
          </div>                   
          </div>
          <div class="row" style="margin-left:10px;">  
           
            <div class="control-group sec span5">
            <span class="span4 frm-txt-styl" >Mobile No</span>
             +91 <input type="text" id="required numeric" name="data[Student][mobile_number]"  maxlength="10" style="width:auto"/><br/>
            <span class="error_msg" style="color:red;display:none;">Enter your Mobile Number</span>
            <span class="error_msgmbl" style="color:red;display:none;">Enter valid Mobile Number</span>            <br/>            
            <span class="span4" style="display:inline-block;margin-right:10px;text-align:right;font-weight:bold;visibility:hidden">Mobile No </span>            
      <span style="font-style:italic;font-size:14px">All SMS messages regarding the Physics Challenge will be sent to this number </span>      
          </div>                   
                      <div class="control-group sec span5">
          <a class="btn btn-primary pull-right"  style="margin-right:14px" id="submit">Proceed to Pay</a>
          </div>
        </div>

           </form> 
			</div>
		</div>    
</div>
  <form id="trans" method="post" style="display:none" name="redirect" action="https://secure.ccavenue.com/transaction/transaction.do?command=initiateTransaction"> 
<input type=hidden name=encRequest >
<input type=hidden name=access_code >
</form>
</div>
  <div id="loading" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="width:450px;">
    
    <div class="modal-body">
      <img src="/img/loading.gif"></img> <h3>  Please Wait....</h3>
    </div>
    <div class="modal-footer"></div>
  </div>  