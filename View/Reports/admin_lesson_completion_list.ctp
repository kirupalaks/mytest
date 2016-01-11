<?php
      $headings = array('Name','Email','City','Mobile Number');
    $this->Excel->generate($students, 'Five_lesson_completion_Students_list.xlsx',$headings , 'Students Report');
