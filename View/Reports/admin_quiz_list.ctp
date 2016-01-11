<?php
     $headings = array('Name','Email','School','City','Standard','Mobile Number','Course','Comments');
    $this->Excel->generate($registered_students, 'QuizPaid_Students_list.xlsx',$headings , 'Quiz Paid Report');
