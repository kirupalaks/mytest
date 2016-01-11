<?php
echo $this->Html->script("Classroom/student_registration.js", array("inline" => false));
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
        <form action="/classroom_register" method="post" accept-charset="utf-8" id="register-form">
          <fieldset id="studentinformation">
        <legend>Student Information<small style="color:red;margin-left:10px;"></small></legend>
              <div class="row" style="margin-left:10px;">               
                <div class="control-group span6">
            <label class="control-label span3" for="name" style="display:inline">Name *</label>
            <div class="controls" style="display:inline">
              <input type="text" id="required" name="data[Student][name]" placeholder="Firstname Lastname"/><br>
          <span class="error_msg" style="color:red;">Enter your Name</span>
            </div>
          </div>
          <div class="control-group span6">
            <label class="control-label span3" style="display:inline" >Class *</label>
            <div class="controls" style="display:inline">
               <select name="data[Student][standard]">
                <option value="0" selected="selected">Select your class </option>
               <?php foreach($standard as $stnd) {?>
           <option value="<?php echo $stnd['Standard']['id']; ?>">
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
              <input type="text" id="required email" name="data[Student][email]" placeholder="example@mail.com" value="<?php echo $email;?>"/><br>
              <span class="error_msg" style="color:red;display:none;">Enter valid Email ID</span>
              <!-- <span id="emailwar" style='color:red;text-align:center;display:none'>Enter valid Email Id</span>
               --><!--<p class="help-block">Supporting help text</p>-->
            </div>
          </div>          
                                                              
             <div class="control-group span6">              
            <label class="control-label span3" style="display:inline" >Retype your Email id * </label>
            <div class="controls" style="display:inline">
               <input type="password" id="required email" name="data[Student][retypeemail]"><br/>           
           <div class="error_msg" style="color:red;">Retype your Email id</div>      
           <div class="mismatch_msg" style="color:red;"></div> 
             </div>
             </div>             
             </div>
             <div class="row" style="margin-left:10px;">             
          <div class="control-group span6">
            <label class="control-label span3" style="display:inline">School Name *</label>
            <div class="controls" style="display:inline">
                          
               <select id="school" name="data[Student][school_name]">
                 <option value="0" selected="selected">Select your School </option>    
                 <?php foreach($school as $sch) {?>         
                 <option value="<?php echo $sch['School']['SCHOOL_ID']; ?>">
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
            <textarea  id="required" name="data[Student][address]" ></textarea><br/>
            <span class="error_msg" style="color:red;display:none;">Enter your address</span>
             </div>
          </div>
          </div>
           <div class="row" style="margin-left:10px;">             
          <div class="control-group span6">
            <label class="control-label span3" style="display:inline">City/Village *</label>
            <div class="controls" style="display:inline">
              <input type="text"  id="required" name="data[Student][place]" /><br/>
              <span class="error_msg" style="color:red;display:none;">Enter your City</span>
             </div>
          </div>
          <div class="control-group span6">
            <label class="control-label span3" style="display:inline">State *</label>
            <div class="controls" style="display:inline">
             
                <select  id="state" name="data[Student][state]" size ="1">
                <option value="Andhra Pradesh">Andhra Pradesh</option>
                <option value="Arunachal Pradesh">Arunachal Pradesh</option>
                <option value="Assam">Assam</option>
                <option value="Bihar">Bihar</option>
                <option value="ChattisGarh">ChattisGarh</option>
                <option value="Goa">Goa</option>
                <option value="Gujrat">Gujrat</option>
                <option value="Haryana">Haryana</option>
                <option value="Himachal Pradesh">Himachal Pradesh</option>
                <option value="Jammu and Kashmir">Jammu and Kashmir</option>
                <option value="Jharkhand">Jharkhand</option>
                <option value="Karnataka">Karnataka</option>
                <option value="Kerala">Kerala</option>
                <option value="MadhyaPradesh">MadhyaPradesh</option>
                <option value="Mahrashtra">Maharashtra</option>
                <option value="Manipur">Manipur</option>
                <option value="Mizoram">Mizoram</option>
                <option value="Meghalaya">Meghalaya</option>
                <option value="Nagaland">Nagaland</option>
                <option value="Orissa">Orissa</option>
                <option value="Punjab">Punjab</option>
                <option value="Rajasthan">Rajasthan</option>
                <option value="Sikkim">Sikkim</option>
                <option value="TamilNadu" selected>TamilNadu</option>
                <option value="Tripura">Tripura</option>
                <option value="Uttarakhand">Uttarakhand</option>
                <option value="Uttarpradesh">UttarPradesh</option>
                <option value="WestBengal">WestBengal</option>
                <option value="Andaman & Nicobar">Andaman & Nicobar</option>
                <option value="ChandiGarh">ChandiGarh</option>
                <option value="Dadra & Nagar Haveli">Dadra & Nagar Haveli</option>
                <option value="Daman & Diu"> Daman & Diu</option>
                <option value="Delhi">Delhi</option>
                <option value="Lakshwadeep"> Lakswadeep</option>
                <option value="Pondicherry">Pondicherry</option>
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
              <input type="text" id="numeric" name="data[Student][postal_pin]" />
             </div>
           </div> 
          </div>

          <div class="row" style="margin-left:10px;">  
           
           <div class="control-group span6">
            <label class="control-label span3" for="name" style="display:inline">Mobile No *</label>
            <div class="controls" style="display:inline">
              +91 <input type="text" id="required mobile" maxlength="10" name="data[Student][mobile_number]"/><br/>
              <span class="error_msg" style="color:red;">Enter valid Mobile Number</span>             
                </fieldset>
              <fieldset id="studentinformation">
        <legend>Parent Information<small style="color:red;margin-left:10px;"></small></legend>
          <div class="row" style="margin-left:10px;">  
          <div class="control-group span6">
            <label class="control-label span3" style="display:inline">Parent Name *</label>
            <div class="controls" style="display:inline">
              <input type="text" id="required" name="data[Student][parent_name]"/><br/>
              <span class="error_msg" style="color:red;display:none;">Enter your Parent Name</span>
             </div>
          </div>
      
             <div class="control-group span6">
            <label class="control-label span3" style="display:inline">Parent Email *</label>
            <div class="controls" style="display:inline">
              <input type="text" id="required email" name="data[Student][parent_email]" /><br>              
              <span class="error_msg" style="color:red;">Enter valid Parent Email Id</span>              
             </div>
          </div>
          </div>  
           <div class="row" style="margin-left:10px;">  
           <div class="control-group span6">
             <label class="control-label span3" style="display:inline">Relationship *</label>
            <div class="controls" style="display:inline">
              <select id="relation" name="data[Student][parent_relationship]">
        <?php foreach($relationship as $rel) {?>
           <option value="<?php echo $rel['ParentRelationship']['id']; ?>">
                <?php echo $rel['ParentRelationship']['name']; ?>
            </option>                 
        <?php }?>
              </select>
            </div>
            </div>
           
          <div class="control-group span6">
            <label class="control-label span3" name="data[Student][parent_mobile]" style="display:inline">Parent Mobile No *</label>
            <div class="controls" style="display:inline">
        +91 <input type="text" id="required mobile" maxlength="10" name="data[Student][parent_mobile]"/><br/>
              <span class="error_msg" style="color:red;">Enter valid parent mobile</span>   
             </div>
            </div>
          </div>

          </fieldset>
            
           <div class="form-action span12">
              <input class="btn btn-primary" type="submit" id="submit" value="Select your course &rarr;"/>
               <input class="btn btn-primary" id="cancel" type="reset" value="Cancel &larr;"/>               
              </div>

           </form> 
			</div>
		</div>
</div>
