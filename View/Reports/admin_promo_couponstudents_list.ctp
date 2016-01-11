<?php
      $headings = array('Registration No.','id','Name','Email','School','Mobile Number','Standard','Course','Comments','Address','City','State','Pin No','Parents Mobile Number',"Parent's Email",'Status','Registration Date');
    $this->Excel->generate($registered_students, 'Promotional_Students_list.xlsx',$headings , 'Promotional Students Report');
