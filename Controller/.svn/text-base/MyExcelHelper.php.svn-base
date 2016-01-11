<?php
App::import('Vendor','PHPExcel',array('file' => 'excel/PHPExcel.php'));

class MyExcelHelper {
      
    function excelHelper() {
        
    }
                 
    function generate($tdata, $fileName, $headings, $title = 'Report') {
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);
            //Seeting the Column Title in Column Headers
        $rowNumber = 4;
        $objPHPExcel->getActiveSheet()->fromArray(array($headings),NULL,'A'.$rowNumber);
       
         //$objPHPExcel->getActiveSheet()->getStyle('A')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(16);
        
       
        $highestRow = $objPHPExcel->getActiveSheet()->getHighestRow();
        $highestColumn = $objPHPExcel->getActiveSheet()->getHighestColumn();
        
        //Setting the Auto Filter
        $objPHPExcel->getActiveSheet()->setAutoFilter('A4:' . $highestColumn . $highestRow );
        
        $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);
        
        //Setting the Title
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(floor($highestColumnIndex/2),2,$title);
        $objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex(floor($highestColumnIndex/2)).'2')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_RED);
        $objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex(floor($highestColumnIndex/2)).'2')->getFont()->setSize(11);
        
        
        //Setting the width of columns
        for($column = 1;$column < $highestColumnIndex; $column++){
        
            $objPHPExcel->getActiveSheet()->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex($column))->setWidth(18);
        }
    
        //Inserting the data
        $i=5;
        foreach ($tdata as $row){
            foreach($row as $record){
                $j=0;
                foreach($record as $field => $value){
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j++, $i, $value);

                            }
                $i++;
            }
        }
        $objPHPExcel->getActiveSheet()->getStyle('A4:'. $highestColumn . $highestRow)->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('A4:'. $highestColumn . $highestRow)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle('A4:'.$highestColumn .$highestRow )->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        
        
         //Setting the coloring scheme of rows
          for($row = 4;$row < $i + 1; $row++){
                  if($row == 4||$row == $i + 1 ) $color = 'FFCFDAE7';
                  else if($row % 2 == 0) $color = 'FFFFFFFF';
                  else $color = 'FFE7EDF5';
                  
        $objPHPExcel->getActiveSheet()->getStyle('A' . $row)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
        $objPHPExcel->getActiveSheet()->getStyle('A' . $row)->getFill()->getStartColor()->setARGB($color);
        $objPHPExcel->getActiveSheet()->duplicateStyle( $objPHPExcel->getActiveSheet()->getStyle('A' . $row), 'B' . $row . ':'.$highestColumn . $row);
        
        $objPHPExcel->getActiveSheet()->getStyle('A'.$row)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        
        $objPHPExcel->getActiveSheet()->getStyle($highestColumn.$row)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
      }
          
        $objPHPExcel->getActiveSheet()->getStyle('A'.($i ).":$highestColumn".($i))->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        
        $objPHPExcel->getActiveSheet()->setTitle($title);
        $objPHPExcel->getActiveSheet()->getPageSetup()->setHorizontalCentered(true);
        $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
         if(strcmp($fileName,"tmp.xlsx") == 0){
         $objWriter->save('/tmp/myExcelFile.xlsx');
        }
        else{
        header("Content-type: application/vnd.ms-excel");
        header('Content-Disposition: attachment;filename="'.$fileName.'"');
        header('Cache-Control: max-age=0');
        $objWriter->save('php://output');
       }
       
    }
}
?>
