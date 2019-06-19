<?php
 
//Had to change this path to point to IOFactory.php.
  //Do not change the contents of the PHPExcel-1.8 folder at all.
  include('src/PHPExcel-1.8/Classes/PHPExcel/IOFactory.php');

  //Use whatever path to an Excel file you need.
  $inputFileName = 'sample.xlsx';

  try {
    $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
    $objReader = PHPExcel_IOFactory::createReader($inputFileType);
    $objPHPExcel = $objReader->load($inputFileName);
  } catch (Exception $e) {
    die('Error loading file "' . pathinfo($inputFileName, PATHINFO_BASENAME) . '": ' . 
        $e->getMessage());
  }

  $sheet = $objPHPExcel->getSheet(0);
  $highestRow = $sheet->getHighestRow();
  $highestColumn = $sheet->getHighestColumn();

  $time = array();
  $index = 0;
   for($col = 1; $col <=7; $col++){
	$val = $sheet->getCellByColumnAndRow($col, 1)->getFormattedValue();
	
	$time[$index] = $val;
	$index++;
   }
   
   $siteArray = array();
   for($row = 2; $row <= $highestRow; $row++){
	   
	   $siteName =  $sheet->getCellByColumnAndRow(0, $row)->getFormattedValue();
	   
	   $vIndex = 0;
	   $valArray = array();
	   for($col = 1; $col <= 7; $col++){
		   $value = $sheet->getCellByColumnAndRow($col, $row)->getFormattedValue();
		   $valArray[$vIndex] = $value;
		   $vIndex++;
	   }
	   
	   $siteArray[$siteName] = $valArray;
   }
   
   $content = array();
   
   $contents[] = array('Site','Date','Value');
   foreach($siteArray as $k => $val){
	   
	   for($i = 0; $i < 7; $i++){
		   $row = array($k, $time[$i], $val[$i]);
		   $contents[] = $row;
	   }
   }
  
	echo '<pre>';
      print_r($contents);
    echo '</pre>';
  
 
	$file = fopen("content.csv","w");

	foreach ($contents as $content)
	{
	 fputcsv($file,$content);
	}

	fclose($file);
  

?>