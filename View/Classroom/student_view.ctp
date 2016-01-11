<?php
echo $this->Html->script("Classroom/student_view.js", array("inline" => false));
?>
<div class="top-ribbon" style="margin-top:65px;">
<div class="container">
			<div class="row-fluid">	
          <div class="top-ribbon-head text-center">
          <h3>Registration Form</h3>
	</div>
  </div>
  </div>
	</div>	
	<div class="container">
    <div class="row-fluid">
      <div class="inner-body">    
      <p><b>Please fill in the following details to proceed:</b></p>
    <form action="&lt;?php echo Router::url('/classroom_register'); ?&gt;" method="post" accept-charset="utf-8" id="register-form">
          <fieldset id="studentinformation">
        <legend>Student Information<small style="color:red;margin-left:10px;"></small></legend>
              <div class="row" style="margin-left:10px;">               
                <div class="control-group span6">
            <label class="control-label span3" for="name" style="display:inline">Name *</label>
            <div class="controls" style="display:inline">
              <input type="text" id="required" name="data[Student][name]" placeholder="Firstname Lastname" value="<?php echo $user['Student']['name'];?>"/><br>
          <span class="error_msg" style="color:red;">Enter your Name</span>
            </div>
          </div>
          <div class="control-group span6">
            <label class="control-label span3" style="display:inline" >Class *</label>
            <div class="controls" style="display:inline">
               <select name="data[Student][standard]">
                <option value="0" selected="selected">Select your class </option>
               <?php foreach($standard as $stnd) {?>
           <option value="<?php echo $stnd['Standard']['id']; ?>"
                <?php if($user['Student']['standard'] == $stnd['Standard']['id']){?>
                    selected <?php }?>>
                              <?php echo "Class ".$stnd['Standard']['name']; ?>
                              </option>                 
                            <?php }?>
              
            </select><br>
             <span id="class" style="color:red"></span>
             </div>
          </div>         
          </div>
          <div class="row" style="margin-left:10px;">               
        <div class="control-group span6">
            <label class="control-label span3" for="email" style="display:inline">Email ID *</label>
            <div class="controls" style="display:inline">
              <input type="text" id="required email" name="data[Student][email]" placeholder="example@mail.com" value="<?php echo $user['Student']['email'];?>" <?php if($user['Student']['email'] !="") echo "disabled";?>/><br>
              <span class="error_msg" style="color:red;display:none;">Enter your Email ID</span>
              <span id="emailwar" style='color:red;text-align:center;display:none'>Enter valid Email Id</span>
              <!--<p class="help-block">Supporting help text</p>-->
            </div>
          </div>
          <!-- </div> -->
                                                  
            <!-- <div class="row" style="margin-left:10px;"> -->
            <?php if($user['Student']['email'] ==""){?>
             <div class="control-group span6">              
            <label class="control-label span3" style="display:inline" >Retype your Email id * </label>
            <div class="controls" style="display:inline">
               <input type="password" id="required email" name="data[Student][retypeemail]"><br/>           
           <div class="error_msg" style="color:red;">Retype your Email id</div>               
           <div class="mismatch_msg" style="color:red;"></div> 
             </div>
             </div>
             <?php }?>
             </div>
             <div class="row" style="margin-left:10px;">             
          <div class="control-group span6">
            <label class="control-label span3" style="display:inline">School Name *</label>
            <div class="controls" style="display:inline">
              <!-- <input type="text"  id="required" name="data[Student][school_name]"  value="<?php echo $user['Student']['school_name'];?>"/> -->                            
               <select id="school" name="data[Student][school_name]">
               <option value="0" selected="selected">Select your School </option>
 				<?php foreach($school as $sch) {?> 				                     
				   <option value="<?php echo $sch['School']['SCHOOL_ID']; ?>"
				   <?php if(trim($user['Student']['school_name']) == trim($sch['School']['SCHOOL_NAME'])){?>
                       selected <?php }?>>
				        <?php echo $sch['School']['SCHOOL_NAME']; ?>
				    </option>                 
				<?php }?>
                                <option value="others">Others</option>
                    </select>   
                    <div class="span9 pull-right" id="otherschool" style="margin-right:10px;display:none">

                    <input type="text" maxlenght="90" name="data[Student][school_name]"  /></div><br/>
                    <span class="sch_war" style="color:red;display:none;">Enter School Name</span>
                    <span class="sch_err" style="color:red;display:none;">Select your school</span>
             </div>
          </div>
          <div class="control-group span6">
            <label class="control-label span3" style="display:inline" >Address *</label>
            <div class="controls" style="display:inline">
            <textarea  id="required" name="data[Student][address]" ><?php echo $user['Student']['address'];?></textarea><br/>
            <span class="error_msg" style="color:red;display:none;">Enter your address</span>
             </div>
          </div>
          </div>
           <div class="row" style="margin-left:10px;">             
          <div class="control-group span6">
            <label class="control-label span3" style="display:inline">City/Village *</label>
            <div class="controls" style="display:inline">
              <input type="text"  id="required" name="data[Student][place]" value="<?php echo $user['Student']['place'];?>" /><br/>
              <span class="error_msg" style="color:red;display:none;">Enter your City</span>
             </div>
          </div>
          <div class="control-group span6">
            <label class="control-label span3" style="display:inline">State *</label>
            <div class="controls" style="display:inline">
             
                <select  id="state" name="data[Student][state]" size ="1">
                <option value="Andhra Pradesh" 
                <?php if($user['Student']['state'] == "Andhra Pradesh"){?>
                      selected <?php }?>>Andhra Pradesh</option>
                <option value="Arunachal Pradesh"
                <?php if($user['Student']['state'] == "Arunachal Pradesh"){?>
                      selected <?php }?>>Arunachal Pradesh</option>
                <option value="Assam"
                <?php if($user['Student']['state'] == "Assam"){?>
                      selected <?php }?>>Assam</option>
                <option value="Bihar"
                <?php if($user['Student']['state'] == "Bihar"){?>
                      selected <?php }?>>Bihar</option>
                <option value="ChattisGarh"
                 <?php if($user['Student']['state'] == "ChattisGarh"){?>
                      selected <?php }?>>ChattisGarh</option>
                <option value="Goa" <?php if($user['Student']['state'] == "Goa"){?>
                      selected <?php }?>>Goa</option>
                <option value="Gujrat" <?php if($user['Student']['state'] == "Gujrat"){?>
                      selected <?php }?>>Gujrat</option>
                <option value="Haryana" <?php if($user['Student']['state'] == "Haryana"){?>
                      selected <?php }?>>Haryana</option>
                <option value="Himachal Pradesh" <?php if($user['Student']['state'] == "Himachal Pradesh"){?>
                      selected <?php }?>>Himachal Pradesh</option>
                <option value="Jammu and Kashmir" <?php if($user['Student']['state'] == "Jammu and Kashmir"){?>
                      selected <?php }?>>Jammu and Kashmir</option>
                <option value="Jharkhand" <?php if($user['Student']['state'] == "Jharkhand"){?>
                      selected <?php }?>>Jharkhand</option>
                <option value="Karnataka" <?php if($user['Student']['state'] == "Karnataka"){?>
                      selected <?php }?>>Karnataka</option>
                <option value="Kerala" <?php if($user['Student']['state'] == "Kerala"){?>
                      selected <?php }?>>Kerala</option>
                <option value="MadhyaPradesh" <?php if($user['Student']['state'] == "MadhyaPradesh"){?>
                      selected <?php }?>>MadhyaPradesh</option>
                <option value="Mahrashtra" <?php if($user['Student']['state'] == "Mahrashtra"){?>
                      selected <?php }?>>Maharashtra</option>
                <option value="Manipur" <?php if($user['Student']['state'] == "Manipur"){?>
                      selected <?php }?>>Manipur</option>
                <option value="Mizoram" <?php if($user['Student']['state'] == "Mizoram"){?>
                      selected <?php }?>>Mizoram</option>
                <option value="Meghalaya" <?php if($user['Student']['state'] == "Meghalaya"){?>
                      selected <?php }?>>Meghalaya</option>
                <option value="Nagaland" <?php if($user['Student']['state'] == "Nagaland"){?>
                      selected <?php }?>>Nagaland</option>
                <option value="Orissa" <?php if($user['Student']['state'] == "Orissa"){?>
                      selected <?php }?>>Orissa</option>
                <option value="Punjab" <?php if($user['Student']['state'] == "Punjab"){?>
                      selected <?php }?>>Punjab</option>
                <option value="Rajasthan" <?php if($user['Student']['state'] == "Rajasthan"){?>
                      selected <?php }?>>Rajasthan</option>
                <option value="Sikkim" <?php if($user['Student']['state'] == "Sikkim"){?>
                      selected <?php }?>>Sikkim</option>
                <option value="TamilNadu"<?php if($user['Student']['state'] == "TamilNadu"){?>
                      selected <?php } else echo "selected";?>>TamilNadu</option>
                <option value="Tripura" <?php if($user['Student']['state'] == "Tripura"){?>
                      selected <?php }?>>Tripura</option>
                <option value="Uttarakhand" <?php if($user['Student']['state'] == "Uttarakhand"){?>
                      selected <?php }?>>Uttarakhand</option>
                <option value="Uttarpradesh" <?php if($user['Student']['state'] == "Uttarpradesh"){?>
                      selected <?php }?>>UttarPradesh</option>
                <option value="WestBengal" <?php if($user['Student']['state'] == "WestBengal"){?>
                      selected <?php }?>>WestBengal</option>
                <option value="Andaman & Nicobar" <?php if($user['Student']['state'] == "Andaman & Nicobar"){?>
                      selected <?php }?>>Andaman & Nicobar</option>
                <option value="ChandiGarh" <?php if($user['Student']['state'] == "ChandiGarh"){?>
                      selected <?php }?>>ChandiGarh</option>
                <option value="Dadra & Nagar Haveli" <?php if($user['Student']['state'] == "Dadra & Nagar Haveli"){?>
                      selected <?php }?>>Dadra & Nagar Haveli</option>
                <option value="Daman & Diu" <?php if($user['Student']['state'] == "Daman & Diu"){?>
                      selected <?php }?>> Daman & Diu</option>
                <option value="Delhi" <?php if($user['Student']['state'] == "Delhi"){?>
                      selected <?php }?>>Delhi</option>
                <option value="Lakshwadeep" <?php if($user['Student']['state'] == "Lakshwadeep"){?>
                      selected <?php }?>> Lakswadeep</option>
                <option value="Pondicherry" <?php if($user['Student']['state'] == "Pondicherry"){?>
                      selected <?php }?>>Pondicherry</option>
                </select>
                
              <!--<p class="help-block">Supporting help text</p>-->
             </div>
          </div>
          </div>
          <div class="row" style="margin-left:10px;">             
          <div class="control-group span6">
            <label class="control-label span3" style="display:inline">Country *</label>
            <div class="controls" style="display:inline">
              
             <select  id="country" name="data[Student][country]" size ="1">
                <option value="India" selected>India</option>
                <!-- <option value="USA">USA</option>
                <option value="UK">UK</option> -->
                </select>
             </div>
          </div>
          <div class="control-group span6">
             <label class="control-label span3" style="display:inline">Postal Pin </label>
             <div class="controls" style="display:inline">
              <input type="text" id="numeric" name="data[Student][postal_pin]" value="<?php echo $user['Student']['postal_pin'];?>" />
             </div>
           </div> 
          </div>

          <div class="row" style="margin-left:10px;">  
           
           <div class="control-group span6">
            <label class="control-label span3" for="name" style="display:inline">Mobile No *</label>
            <div class="controls" style="display:inline">
              +91 <input type="text" id="required mobile" maxlength="10" name="data[Student][mobile_number]"  value="<?php echo $user['Student']['mobile_number'];?>"/><br/>
              <span class="error_msg" style="color:red;">Enter valid Mobile Number</span>             
             </div>
            </div>
          </div>
          </fieldset>
              <fieldset id="studentinformation">
        <legend>Parent Information<small style="color:red;margin-left:10px;"></small></legend>
          <div class="row" style="margin-left:10px;">  
          <div class="control-group span6">
            <label class="control-label span3" style="display:inline">Parent Name *</label>
            <div class="controls" style="display:inline">
              <input type="text" id="required" name="data[Student][parent_name]" value="<?php echo $user['Student']['parent_name'];?>" /><br/>
              <span class="error_msg" style="color:red;display:none;">Enter your Parent Name</span>
             </div>
          </div>
      
             <div class="control-group span6">
            <label class="control-label span3" style="display:inline">Parent Email *</label>
            <div class="controls" style="display:inline">
              <input type="text" id="required email" name="data[Student][parent_email]" value="<?php echo $user['Student']['parent_email'];?>"/><br>
              <!-- <span id="parent_email" style="color:red"></span> -->
              <span class="error_msg" style="color:red;">Enter valid Parent Email Id</span>
              <!-- <span id="emailwar" style='color:red;text-align:center;display:none'>Enter valid Parent Email Id</span> -->
             </div>
          </div>
          </div>  
           <div class="row" style="margin-left:10px;">  
           <div class="control-group span6">
             <label class="control-label span3" style="display:inline">Relationship *</label>
            <div class="controls" style="display:inline">
              <select id="relation" name="data[Student][parent_relationship]">
 				<?php foreach($relationship as $rel) {?>
				   <option value="<?php echo $rel['ParentRelationship']['id']; ?>"
				   <?php if($user['Student']['parent_relationship'] == $rel['ParentRelationship']['id']){?>
                      selected <?php }?>>
				        <?php echo $rel['ParentRelationship']['name']; ?>
				    </option>                 
				<?php }?>
              </select>
            </div>
            </div>
           
          <div class="control-group span6">
            <label class="control-label span3" name="data[Student][parent_mobile]" style="display:inline">Parent Mobile No *</label>
            <div class="controls" style="display:inline">
				+91 <input type="text" id="required mobile" maxlength="10" name="data[Student][parent_mobile]" value="<?php echo $user['Student']['parent_mobile'];?>" /><br/>
              <span class="error_msg" style="color:red;">Enter valid parent mobile</span>		
             </div>
            </div>
          </div>

          </fieldset>
<input type="text" id="required" name="data[Student][id]" value="<?php echo $user['Student']['id'];?>" style="visibility:hidden"/>          
            
           <div class="form-action span12">
              <a class="btn btn-primary" id="submit">Select your course &rarr;</a>
               <input class="btn btn-primary" type="reset" id="cancel" value="Cancel &larr;"/>               
              </div>

           </form> 
			</div>
		</div>
</div>
