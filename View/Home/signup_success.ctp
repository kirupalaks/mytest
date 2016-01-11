<?php
echo $this->Html->script("Home/signup_success.js", array("inline" => false));
?>
<div class="top-ribbon" style="margin-top:65px;">
</div>
<div class="container">
		<div class="row-fluid">
			<div class="inner-body">		
			<p><b>Please fill in and confirm details to proceed</b></p>
		<form action="&lt;?php echo Router::url('/signup/<%=user.Student.id%>'); ?&gt;" method="post" accept-charset="utf-8" id="register-form">
    <input type="hidden"   name="data[Student][id]" value="<%= user.Student.id%>"/>

          <div class="row" style="margin-left:10px;">  
             <div class="control-group span4">
               <label class="control-label" for="name">Course Coupon Code</label>
               <div class="controls">
                  <input type="text" id="required" name="data[Student][coupon_code]" /><br>
                  <!--<span class="error_msg" style="color:red;display:none;">Enter your Code</span>-->
                  <span id="warning" style="color:red;"></span>
                </div>
          </div></div>
      <div class="row" style="margin-left:10px;">  
            <div class="control-group span4">
            <label class="control-label" for="name">Name *</label>
            <div class="controls">
              <input type="text" id="required" name="data[Student][name]" placeholder="Firstname Lastname" value="<%= user.Student.name%>"/>
          <span class="error_msg" style="color:red;display:none;">Enter your Name</span>
            </div>
          </div>
          
        <div class="control-group span4">
            <label class="control-label" for="email">Email ID *</label>
            <div class="controls">
              <input type="text" id="required email" name="data[Student][email]" placeholder="example@mail.com" value="<%=user.Student.email%>" disabled/><br>
            <span class="error_msg" style="color:red;display:none;">Enter your Email ID</span>
              </div>
          </div>
          </div>
          <div class="row" style="margin-left:10px;">  
             <div class="control-group span4">
            <label class="control-label" for="name">Class *</label>
            <div class="controls">
            <select name="data[Student][standard]" id="required">
              <option value="0" selected="selected">Select your class</option>
              <%_.each(standards, function(stnd, index) {%>
                          <option value="<%=stnd.Standard.id %>"
             <% if(user.Student.standard == stnd.Standard.id) { %>
                                  selected <%}%>>
                     Class <%= stnd.Standard.name %></option>        
    
              <%});%>
              
            </select><br>
            <span id="class" style="color:red"></span>
             </div>
          </div>         
          <div class="control-group span4">
            <label class="control-label" for="name">School Name *</label>
            <div class="controls">
              <input type="text" id="required" name="data[Student][school_name]" value="<%= user.Student.school_name%>" />
             </div>
          </div>          
          </div>
          <div class="row" style="margin-left:10px;">  
           <div class="control-group span4">
            <label class="control-label" for="name">Address *</label>
            <div class="controls">
            <textarea  id="required" name="data[Student][address]" ><%=user.Student.address %></textarea>
             </div>
          </div>
          <div class="control-group span4">
            <label class="control-label" for="name">City/Village *</label>
            <div class="controls">
              <input type="text"  id="required" name="data[Student][place]" value="<%=user.Student.place%>"/>
             </div>
          </div>
          </div>
          <div class="row" style="margin-left:10px;">  
           <div class="control-group span4">
            <label class="control-label" for="name">State *</label>
            <div class="controls">
             
                <select  id="state" name="data[Student][state]" size ="1">
             <!--   <option value="Andhra Pradesh">Andhra Pradesh</option>
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
                <option value="Pondicherry">Pondicherry</option>-->
                </select>
                
              <!--<p class="help-block">Supporting help text</p>-->
             </div>
          </div>
          <div class="control-group span4">
            <label class="control-label" for="name">Country *</label>
            <div class="controls">
              <!--<input type="text" id="required" name="data[Student][parent_email]"  value="<%=user.Student.parent_email%>"/>-->
             <select  id="country" name="data[Student][country]" size ="1">
                <option value="India" selected>India</option>
                <option value="USA">USA</option>
                <option value="UK">UK</option>
                </select>
             </div>
          </div>
          </div>
          <div class="row" style="margin-left:10px;">  
          <div class="control-group span4">
            <label class="control-label" for="name">Postal Pin *</label>
            <div class="controls">
              <input type="text" id="required numeric" maxlength="7" name="data[Student][postal_pin]" value="<%= user.Student.postal_pin%>" />
             </div>
          </div> 
          <div class="control-group span4">
            <label class="control-label" for="name">Parent Name *</label>
            <div class="controls">
              <input type="text" id="required" name="data[Student][parent_name]" value="<%= user.Student.parent_name%>" />
             </div>
          </div>
          
          </div>
          <div class="row" style="margin-left:10px;">  
          <div class="control-group span4">
            <label class="control-label" for="name">Parent Email *</label>
            <div class="controls">
              <input type="text" id="required" name="data[Student][parent_email]"  value="<%=user.Student.parent_email%>"/>
             </div>
          </div>
           <div class="control-group span4">
             <label class="control-label" for="email">Relationship *</label>
            <div class="controls">
              <select id="relation" name="data[Student][parent_relationship]">
              <%_.each(relationship ,function(pre,index) {%>
              <option value="<%= pre.ParentRelationship.id%>"
         <%if( user.Student.parent_relationship == pre.ParentRelationship.id){%>
                   selected <%}%> >
                  <%=pre.ParentRelationship.name %></option>        
    
              <%});%>
              </select>
            </div>
            </div>
          </div>
          <div class="row" style="margin-left:10px;">  
          <div class="control-group span4">
            <label class="control-label" for="name">Mobile No *</label>
            <div class="controls">
              <input type="text" id="required numeric" maxlength="10" name="data[Student][mobile_number]" value="<%= user.Student.mobile_number%>" />
             </div>
          </div></div>

          <!--<div class="row" style="margin-left:10px;">  
             <div class="control-group span4">
               <label class="control-label" for="name">Course Coupon Code</label>
               <div class="controls">
                  <input type="text" id="required" name="data[Student][coupon_code]" /><br>
                  <span class="error_msg" style="color:red;display:none;">Enter your Code</span>
                  <span id="warning" style="color:red;"></span>
                </div>
          </div></div>-->
           <div class="form-action span4">
              <button class="btn btn-primary" id="submit">Confirm &rarr;</button>
              <a href="/student/student/allcourse" class="btn btn-primary" id="cancel">Cancel &rarr;</a>
              </div>

           </form> 
			</div>
		</div>
</div>