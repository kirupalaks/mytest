<?php
      $headings = array('Id','Email','Source');
    $this->Excel->generate($visited_students, 'quiz_visited_list.xlsx',$headings ,'Visited Students');
