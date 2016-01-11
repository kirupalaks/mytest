<?php
      $headings = array('Id','Email','Source');
    $this->Excel->generate($visited_students, 'facebook_visited_list.xlsx',$headings ,'Visited Students');
