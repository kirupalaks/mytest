<?php
      $headings = array('Registration No.','id','Name','Tags','Email','School','Mobile Number','Standard','Course','Address','City','State','Pin No','Parents Mobile Number',"Parent's Email",'Status','Registration Date','Batch');
    $this->Excel->generate($registered_students, 'Registered_Students_list.xlsx',$headings , 'Registered Students Report');
