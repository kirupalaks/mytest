<?php
     $headings = array('Name','Email','School','City','Standard','Mobile Number','Course','Comments');
    $this->Excel->generate($registered_students, 'FaceBookPaid_Students_list.xlsx',$headings , 'FaceBook Paid Report');
