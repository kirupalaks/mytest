<?php
      $headings = array('srno','coupon_code');
      
    $this->Excel->generate($coupons, 'Coupons.xlsx',$headings ,$course);
