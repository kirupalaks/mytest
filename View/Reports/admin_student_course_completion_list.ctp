<?php
      $headings = array('Name','Student_id','Email','Course Name','Lesson_completed');      
    $this->Excel->generate($course_completion, 'Student_Lesson_completion_Report.xlsx',$headings ,'Student Lesson completed');

