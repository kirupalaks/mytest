<?php
      $headings = array('Name','Email','Standard','School','Mobile Number',
      	'Parent Name','Parent Mobile','Parent Email','City','Batch_name','Batch_class','Batch_location','Course','Schedule_day','Schedule_time','
      	Teacher','Reg_date');      
    $this->Excel->generate($registered_students, 'Classroom_Students_list.xlsx',
    	$headings ,'Classroom Students 2016-2017');
