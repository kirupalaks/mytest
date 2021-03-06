<?php
echo $this->Html->script("Student/hallticketform.js?random=6",array("inline"=>false)); ?>
<div class="top-ribbon" style="margin-top:100px;background-color:#00AAE8">
    <div class="container">
      <div class="row-fluid">
        <div class="top-ribbon-head text-center">
        <h3 style="line-height:1">Hall Ticket - 25th October, 2015 Registration Form</h3></div>       
      </div>
    </div>
  </div>
<div class="container">
    <div class="row-fluid">

      <div class="inner-body">         
    <form action="/student/hallticket" method="post" accept-charset="utf-8" id="register-form" enctype="multipart/form-data"> 
          <h4>You are now progressing towards getting Hall Ticket for Physics Challenge Test - 2.</h4>
          <p>Please fill the following details to get your Hall Ticket.</p>
    <div id="resetable">
            <div class="row" style="margin-left:10px;">
              <div class="control-group">
                <label class="control-label" for="name"><b>Name * <font size="2">(As you wanted on the certificate)</font></b></label>
                <div class="controls">
                  <input type="text" id="required" maxlength="90" name="data[HT_STUDENT_NAME]"/><br>
                  <span class="error_msgname" style="color:red;display:none;">Enter your Name</span>
                </div>
              </div>
              </div>
            <div class="row" style="margin-left:10px;">
               <div class="control-group">
                  <label class="control-label" ><b>School Name *</b></label>
                  <div class="controls">
                  <select id="school" name="data[HT_SCHOOL_ID]">
                        <option value="0" selected="selected">Select your school </option>
                        <?php foreach($school as $sch) {?>
                <option value="<?php echo $sch['School']['SCHOOL_ID']; ?>">
                     <?php echo $sch['School']['SCHOOL_NAME']; ?></option>        
    
              <?php
                }
              ?>
                  <option value="others">Others</option>
                    </select>                
                    <input type="text" style="display:none" maxlenght="90" name="data[HT_SCHOOL_NAME]"  /><br/>
                    <span class="sch_war" style="color:red;display:none;">Enter School Name</span>
                    <span class="sch_err" style="color:red;display:none;">Select your school</span>
                </div>
              </div>
            </div>
            <div class="row" style="margin-left:10px;">
               <div class="control-group">
                  <label class="control-label" ><b>Enter Class in School *</b></label>
                  <div class="controls">
                    <select id="stard" name="data[HT_STANDARD]">
                        <option value="0" selected="selected">Select your class </option>
                        <?php foreach($standard as $stnd) {?>
                <option value="<?php echo $stnd['Standard']['id']; ?>">
                     <?php echo "Class ".$stnd['Standard']['name']; ?></option>        
    
              <?php
                }
              ?>
                      
                    </select><br>
                   <span id="stdwar" style="color:red"></span>
                </div>
              </div>         
            </div>
            <div class="row" style="margin-left:10px;">
              <div class="control-group">
            <label class="control-label" ><b>Enter Section in School<font size="2">(If Applicable)</font></b></label>
            <div class="controls">
           <input type="text" maxlength="2" name="data[HT_SECTION]"/><br>            
             </div>
          </div>        
          </div>        
           <div class="row" style="margin-left:10px;">  
           <div class="control-group">
            <label class="control-label" ><b>Mode of Test *</b></label>
            <div class="controls">
            <input type="radio" name="data[HT_TEST_MODE]" id="offline" value="Offline" checked="true" /> I would like to take up the test physically at the test center           
             
            <select style="width:auto" id="testloc" name="data[HT_TEST_LOCATION_CODE]" >         
            <?php if($promocoupon == 1){?>
               <?php foreach($centers['venue'] as $testcen) {?>               
               <?php if($testcen['code'] == 'CH_SANK'){?>
            <option value="<?php echo $testcen['code']; ?>">
                     <?php echo $testcen['name']; ?></option>                
                     <?php }}} elseif($promocoupon == 3){?>
               <?php foreach($centers['venue'] as $testcen) {?>
               <?php if($testcen['code'] == 'CH_KBV'){?>
            <option value="<?php echo $testcen['code']; ?>">
                     <?php echo $testcen['name']; ?></option>

              <?php }}} else{?>             
              <option value="0" selected="selected">Select your Test Center </option>    
              <?php foreach($centers['venue'] as $testcen) {?>               
               <?php if($testcen['code'] != 'CH_SANK' && $testcen['code'] != 'CH_KBV'){?>
            <option value="<?php echo $testcen['code']; ?>">
                     <?php echo $testcen['name']; ?></option>        
              <?php }}}?>
            </select>         <br/>        
            <p id="locwar" style="color:red;display:none">Select your Test Center</p>
            <b style='color:#37A10E'>Once Choosen your Test Center cannot be changed</b>
            </div>            
            <input type="radio" name="data[HT_TEST_MODE]" id="online" value="Online"/> Online Test <b style='color:#37A10E'>(Choose this option only if you will not be able to take test at any of our test Centers,Students appearing Online Test will get Certificates but will not be eligible for prizes)</b>
            </div>  
            </div>
            <b>Communication about the test results to be sent to</b>
            <div class="row" style="margin-left:10px;">

               <div class="control-group span4">
            <label class="control-label" for="name"><b>Email *</b></label>
            <div class="controls">
              <input type="text" id="required" maxlength="40" name="data[HT_STUDENT_EMAIL]"  /><br/>
              <!-- <span class="error_msg" style="color:red;display:none;">Enter valid number</span> -->               
                <span id="emailwar" style="color:red;display:none;">Enter valid email address</span>
             </div>
          </div>
          </div>          
         
            <div class="row" style="margin-left:10px;">

               <div class="control-group span4">
            <label class="control-label" for="name"><b>Phone No</b></label>
            <div class="controls">
              <input type="text" id="numeric" maxlength="10" name="data[HT_MOBILE_NUMBER]"  /><br/>
              <!-- <span class="error_msg" style="color:red;display:none;">Enter valid number</span> -->
               <span class="error_msgmbl" style="color:red;display:none;">Enter valid number</span>
             </div>
          </div>
          </div>          
         
           <div class="row" style="margin-left:10px;">  
           <div class="control-group">
            <label class="control-label" ><b>Postal Address *</b></label>
            <div class="controls">
            <textarea  id="required" maxlength="180" name="data[HT_ADDRESS]" ></textarea><br/>
            <span class="error_msgaddr" style="color:red;display:none;">Enter your address</span>
             </div>
          </div>        
        <!--   <div class="control-group span4">
            <label class="control-label" >Postal Pin </label>
            <div class="controls">
              <input type="text" id="numeric" name="data[postal_pin]"  />
             </div>
          </div>  -->
         
          </div>             
          </div>        
            <?php if($promocoupon == 1){?>
            <input type="text" style="visibility:hidden" value="<?php echo $centers['venue'][0]['name'];?>" name="data[HT_TEST_LOCATION]">
            <?php } elseif($promocoupon == 3){?>
            <input type="text" style="visibility:hidden" value="<?php echo $centers['venue'][3]['name'];?>" name="data[HT_TEST_LOCATION]">      <?php } else{?>
            <input type="text" style="visibility:hidden" name="data[HT_TEST_LOCATION]">
            <?php }?>
          
           </form>                  
          
            <div class="row" style="margin-left:10px;margin-top:-50px">  
          <div class="control-group">
           <form method="post" id="image" action="/student/hallticketphoto" enctype="multipart/form-data">
          <label><b>Photo :</b></label>
            <input type="file" id="image"  name="data[File][Content]" accept="image/*" />
            </form>
            </div>
            </div>
            <div class="form-action span12">
              <a class="btn btn-primary" id="submit" type="submit">Submit &rarr;</a>
               <a class="btn btn-primary" id="resetable" type="reset"> Reset &larr;</a>
              </div>       
 </div>
           </div></div>
<!--Confirm Modal-->
           <div id="confirmmodal" class="modal hide fade span5" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" style="margin-left:-250px;">
    <div class="modal-header text-center">
        
      <h3 id="myModalLabel">Confirmation</h3>
      </div>
    <div class="modal-body">
      <font size="3px">The Information entered on the Hall Ticket Registration form cannot be altered.Are you sure you want to continue?</font>
    </div>
    <div class="modal-footer">
      <button class="btn btn-primary" id="confirm" data-dismiss="modal" onclick="submitform()">Confirm</button>
      <button class="btn btn-primary" class="close" data-dismiss="modal" aria-hidden="true">Cancel</button>
    </div>
  </div>

<!--warning Modal-->
    <div id="warningmodal" class="modal hide fade span5" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" style="margin-left:-250px;">
    <div class="modal-header text-center">
        
      <h3 id="myModalLabel">Confirmation</h3>
      </div>
    <div class="modal-body">
      <font size="3px">The Information entered on the Hall Ticket Registration form cannot be altered.Are you sure you want to continue?</font>
    </div>
    <div class="modal-footer">
      <button class="btn btn-primary" id="confirm" data-dismiss="modal" onclick="submitform()">Confirm</button>
      <button class="btn btn-primary" class="close" data-dismiss="modal" aria-hidden="true">Cancel</button>
    </div>
  </div>


  <!--loading-->
  <div id="loading" class="modal hide fade span5" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static" aria-hidden="true" style="margin-left:-250px;" >
             <div class="modal-header">
              <h3><center>Loading....</center></h3>
             </div>
             <div class="modal-body">
                <img src="/img/loading.gif"></img> <h3>  Please Wait....</h3>
             </div>
             <div class="modal-footer"></div>
          </div>