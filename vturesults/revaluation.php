<?php

function revalutaion_result($USN ,$student_detail_id ) {

    //loading the results it 
    $string="http://results.vtu.ac.in/vitavireval.php?rid=" . $USN . "&submit=SUBMIT";

    $doc=@file_get_contents($string);     
    if($doc==false)
    {
       echo "Hello, <br/> VTU is currently uploading the revaluation results so please have some patience and try again after sometime<br/>";
       return;
    }

    //Seperate header and content
    $header_text = substr($doc,9000,800000);

    $ss = preg_match("/Results are not yet available/",$header_text, $tt);
    if ($ss != 0) {
        echo "Revaluation results not came for USN : " . $USN . "<br/>Cross check ones wheather the USN is correct<br>";
        return;
    }

    $doc1 = new DOMDocument();
    @$doc1->loadHTML($header_text);
    $xpath = new DOMXPath($doc1);
    $tables = $doc1->getElementsByTagName('table');
    
    $nodes  = $xpath->query('.//tbody/tr/td/b', $tables->item(2));
    $Name_USN = $nodes->item(0)->nodeValue;
    
    $nodes1  = $xpath->query('.//tbody/tr/td/table/tr/td/b', $tables->item(2));
    $semester_of_student = $nodes1->item(1)->nodeValue ;
    
    $remove=strrchr($Name_USN,'(');
    //remove is now "( usn )" and gets the student name.
    $current_student_name=str_replace(" $remove","",$Name_USN);
    
    $html = str_get_html($header_text);
    
    $cells = $html->find('td');
    $i; 
    $j = 0;
    $semester_report;  //FCD ,FC etc.
    $current_semester;
    $current_semester_set = 0;
    
    echo "Name: " . $current_student_name . "<br>";


           //UPDATE NAME : START
           //This block is for updating the name in table.
          /* Just to find whether the any of other friend has requested for the results so that that value will be present,
              in the student_details table. Just get the name so that we can know that the name is already updated.
              i.e if student_name is NULL going to update the table with student name */
          $querya = "SELECT * FROM tbl_student_detail "; 
          $queryb = "WHERE student_usn='"   . $USN . "'"; 
          $resultsa = mysql_query($querya . $queryb) or die('Error, failed to select student usn'.mysql_error() . $query); 
           if ($row = mysql_fetch_row($resultsa)) { //If the executed command has got any output
                    $student_detail_id = $row[0];
                    $student_name = $row[2];
            }
            else {
                    /* Insert into student details */
                    $query1 = "INSERT INTO tbl_student_detail(student_id ,student_usn ,student_name ) VALUES ";
                    $query2 = "('NULL' , '" . $USN . "' ,'" . $current_student_name  . "')";
                    $query = $query1 . $query2;
                     mysql_query($query) or die('Error, insert query failed to insert in student details'.mysql_error() . $query);
                    /* Inserted the result get the student_detail_id */
                    $querya = "SELECT student_id FROM tbl_student_detail "; 
                    $queryb = "WHERE student_usn='"   . $USN . "'"; 
                    $query = $querya . $queryb;
                    $resultsa = mysql_query($query) or die('Error, failed to select student usn'.mysql_error() . $query);
                    $row = mysql_fetch_row($resultsa);
                    $student_detail_id = $row[0];  //Just to update the name in next condition if name is not set in table.
           }
           if (preg_match("/NULL/i", $student_name)) { //If the student name has not been added to table then add it to table.
               $query = "UPDATE tbl_student_detail SET student_name='" . $current_student_name . "' WHERE student_id='" . $student_detail_id . "'";
               mysql_query($query) or die('Error, Update of student name failed in tbl_student_details'.mysql_error() . $query);
           }
           //UPDATE NAME : END

    
    foreach($cells as $cell) {
        $i++;
        if ( $i > 9) {
            if ($current_semester_set == 1) {
                     $current_semester = $cell->plaintext;             
                     $current_semester_set = 0; //Reset
            }
            if (preg_match("/Semester:/i", $cell->plaintext)) {
                     $current_semester_set = 1;
            }   
           /* This gives the result or the passing class outcome of semester. Ex : FCD, Second Class etc */
            if (preg_match("/result:/i", $cell->plaintext)) {
                    $semester_report = substr($cell->plaintext, 54);
                     echo "Sem: " . $current_semester . ", Result: " . $semester_report . "<br/><br/>";
            }
    
    
            $numberOfNumbersFound = preg_match_all("/[0-9]+/", $cell->plaintext, $out);
            //   echo $cell->plaintext . " I: " . $i . "NO: " .  $numberOfNumbersFound  . "<br/><br/>"; 
       
            if( ($j == 0 && $numberOfNumbersFound >= 2) || preg_match("/MATDIP/i", $cell->plaintext) ) {
                          /**
                            numberOfNumbersFound =2 for subjects formats like : Software Architectures (06IS72)
                            numberOfNumbersFound =3 for subjects formats like : Java and J2EE (06CS753)
                            numberOfNumbersFound =1 for subjects formats like : Advanced Mathematics - II (MATDIP401) so using to grep the MATDIP
                          **/
                      $subject = $cell->plaintext;
                      $j++;
             } elseif($numberOfNumbersFound == 1 && $j == 1) {
                      $old =  $cell->plaintext;
                      $j++;
             } elseif ($numberOfNumbersFound == 1 && $j == 2) {
                      $final =  $cell->plaintext;           
                      $j++;
             } elseif ($numberOfNumbersFound == 1 && $j == 3) {
                          $internal =  $cell->plaintext;           
                              $j++;
             } elseif ($numberOfNumbersFound == 1 && $j == 4) {
                      $total =  $cell->plaintext;   
                      $j++;       
             } elseif ($j == 5) {
                      $outcome =  $cell->plaintext;   
                      $j++;       
             }

            if ($j == 6) {
                echo $subject . "<br>Old : " . $old . ", final : " . $final . ",  I : " . $internal . " Total: " .  $total . "<br>Result : " . $outcome . "<br><br>";

//START : Insert into table
                /* To check the result has already been inserted */
                $querya = "SELECT * FROM tbl_student_revaluation "; 
                $queryb = "WHERE student_details_id='" . $student_detail_id . "' AND semester='" . $current_semester . "' AND subject_name='" . $subject . "' AND old='" . $old . "' AND  final='" . $final . "'  AND internal='" . $internal  . "' AND total='" . $total  . "' AND outcome='" . $outcome . "' AND result='" . $semester_report . "'"; 
                $query = $querya . $queryb;
                $resultsa = mysql_query($query) or die('Error, failed to select the from table tbl_student_results' . mysql_error() . $query); 
 
                if ($row = mysql_fetch_row($resultsa)) { 
                    //Already inserted no need to add again
                 } else
                 {
                      /* Insert the result into tbl_student_results  */
                      $query1 = "INSERT INTO tbl_student_revaluation(student_details_id ,semester ,subject_name ,old ,final ,internal ,total ,outcome ,result) VALUES ";
                      $query2 = "('" . $student_detail_id . "' , '" . $current_semester . "' ,'" . $subject  . "' ,'" . $old . "' ,'" . $final . "' ,'" . $internal . "' ,'" . $total . "' ,'" . $outcome . "' ,'" . $semester_report . "')";
                      $query = $query1 . $query2;
                       mysql_query($query) or die('Error, insert query failed to insert in tbl_student_results'.mysql_error() . $query);
                 }
//END
                $j=0;
            }
        }
    }
    
    //echo "<br>Semeter " . $semester_of_student . ", Total Marks " . $semester_total ;
}
?> 
