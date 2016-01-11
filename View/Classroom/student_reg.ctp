<?php echo $this->Html->script("Classroom/student_reg.js", array("inline" => false));
?>
<div class="top-ribbon" style="margin-top:65px;">
		<div class="container">
			<div class="row-fluid">	
          <div class="top-ribbon-head text-center">
          <h3>Classroom Registration </h3>
	</div>
  </div>
  </div>

</div>	
	<div class="content" style="min-height:518px;">
		<div class="row-fluid text-center" style="padding-top:20px;">
			<div class="span12">						
	<form action="/"  method="post" accept-charset="utf-8" 
	id="signup">
        <div class="row" style="margin:20px;">  
       		<div class="control-group sec">       					       			
          <div class="controls">
       			<b>Enter your User ID </b>
           				<input type="text" id="required" name="data[Student][user_id]" style="margin-left:10px;" /><br/>           				
                  <input type="text" id="required classroom" name="data[Student][classroom]" style="margin-left:10px;visibility:hidden" value="1" /><br/                  
                  <div class="form-action span" style="margin-left:10px;">
              <span class="emailwar" style="color:red;"></span>                   
            </div>
           				
              			</div>
          			</div>          			
       	<div class="form-action" style="margin-left:10px;">
              <button class="btn btn-primary" id="submit">NEXT</button>
            </div>
            </div>
           </form> 
			</div>
		</div>
	</div>
