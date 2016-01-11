<?php
     $headings = array('Name','Email','School','City','Standard','Mobile Number','Course','Comments');
    $this->Excel->generate($registered_students, 'ThinkVidyaPaid_Students_list.xlsx',$headings , 'ThinkVidya Paid Report');
