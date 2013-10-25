<?
include 'simple_html_dom.php';

function create_all_required_table( $batch )
{
  echo "Create table " .  $batch;
    $query = "CREATE TABLE IF NOT EXISTS `tbl_student_detail" . $batch . "` (  `student_id` int NOT NULL AUTO_INCREMENT,  `student_usn` varchar(16) NOT NULL,  `student_name` varchar(64),  PRIMARY KEY (`student_id`)) ;";
    $results = mysql_query( $query ) or die( '<br/>Error, failed to create table  ' . error() );
    
    $query = "CREATE TABLE IF NOT EXISTS `tbl_student_results" . $batch . "` (  `student_details_id` int NOT NULL,  `semester` varchar(2) NOT NULL,  `subject_name` varchar(64),
  `external` varchar(5),  `internal` varchar(5),`total` varchar(5),`result` varchar(2)) ;";
    $results = mysql_query( $query ) or die( '<br/>Error, failed to create table  ' . error() );
    
    $query = "CREATE TABLE IF NOT EXISTS `tbl_student_revaluation" . $batch . "` (  `student_details_id` int NOT NULL,  `semester` varchar(2) NOT NULL,  `subject_name` varchar(64),  `old` varchar(5),  `final` varchar(5), `internal` varchar(5),`total` varchar(5), `outcome` varchar(5), `result` varchar(32)) ;";
    $results = mysql_query( $query ) or die( '<br/>Error, failed to create table  ' . error() );
    
    $query = "CREATE TABLE IF NOT EXISTS `tbl_student_report" . $batch . "` (  `student_details_id` int NOT NULL,  `semester` varchar(2) NOT NULL, `semester_result` varchar(32)) ;";
    $results = mysql_query( $query ) or die( '<br/>Error, failed to create table  ' . error() );
    
    $query = "CREATE TABLE IF NOT EXISTS `tbl_student_total" . $batch . "` (  `student_details_id` int NOT NULL,  `semester` varchar(2) NOT NULL, `semester_total` varchar(32)) ;";
    $results = mysql_query( $query ) or die( '<br/>Error, failed to create table  ' . error() );
    
}


function insert_result_of_students( $region, $colg, $batch, $branch, $start, $end )
{
    
    for ( $count = $start; $count < $end ; $count++ ) {
        $student_usn = $region . $colg . $batch . $branch . str_pad($count, 3, '0', STR_PAD_LEFT);
       echo "Result of : " .  $student_usn . "<br>";
        //loading the results it 
         $string      = "http://results.vtu.ac.in/vitavi.php?rid=" . $student_usn . "&submit=SUBMIT";
        
        $doc = @file_get_contents( $string );
        if ( $doc == false ) {
            continue;
        }
        
        //Seperate header and content
        $header_text = substr( $doc, 9000, 800000 );
        
        $ss = preg_match( "/Results are not yet available/", $header_text, $tt );
        if ( $ss != 0 ) {
            continue;
        }
        
        $doc1 = new DOMDocument();
        @$doc1->loadHTML( $header_text );
        $xpath  = new DOMXPath( $doc1 );
        $tables = $doc1->getElementsByTagName( 'table' );
        
        $nodes    = $xpath->query( './/tbody/tr/td/b', $tables->item( 2 ) );
        $Name_USN = $nodes->item( 0 )->nodeValue;
        
        $nodes1              = $xpath->query( './/tbody/tr/td/table/tr/td/b', $tables->item( 2 ) );
        $semester_of_student = $nodes1->item( 1 )->nodeValue;
        
        $remove               = strrchr( $Name_USN, '(' );
        //remove is now "( usn )" and gets the student name.
        $current_student_name = str_replace( " $remove", "", $Name_USN );
        
        //UPDATE NAME : START
        //This block is for updating the name in table.
        /* Just to find whether the any of other friend has requested for the results so that that value will be present,
        in the student_details table. Just get the name so that we can know that the name is already updated.
        i.e if student_name is NULL going to update the table with student name */
        $querya = "SELECT * FROM tbl_student_detail" . $batch . " ";
        $queryb = "WHERE student_usn='" . $student_usn . "'";
        $resultsa = mysql_query( $querya . $queryb ) or die( 'Error, failed to select student usn' . mysql_error() . $query );
        if ( $row = mysql_fetch_row( $resultsa ) ) { //If the executed command has got any output
            $student_detail_id = $row[0];
            $student_name      = $row[2];
        } else {
            /* Insert into student details */
            $query1 = "INSERT INTO tbl_student_detail" . $batch . "(student_id ,student_usn ,student_name ) VALUES ";
            $query2 = "('NULL' , '" . $student_usn . "' ,'" . $current_student_name . "')";
            $query  = $query1 . $query2;
            mysql_query( $query ) or die( 'Error, insert query failed to insert in student details' . mysql_error() . $query );
            /* Inserted the result get the student_detail_id */
            $querya = "SELECT student_id FROM tbl_student_detail" . $batch . " ";
            $queryb = "WHERE student_usn='" . $student_usn . "'";
            $query  = $querya . $queryb;
            $resultsa = mysql_query( $query ) or die( 'Error, failed to select student usn' . mysql_error() . $query );
            $row               = mysql_fetch_row( $resultsa );
            $student_detail_id = $row[0]; //Just to update the name in next condition if name is not set in table.
        }
        if ( preg_match( "/NULL/i", $student_name ) ) { //If the student name has not been added to table then add it to table.
            $query = "UPDATE tbl_student_detail" . $batch . " SET student_name='" . $current_student_name . "' WHERE student_id='" . $student_detail_id . "'";
            mysql_query( $query ) or die( 'Error, Update of student name failed in tbl_student_details' . mysql_error() . $query );
        }
        //UPDATE NAME : END
        
        $html = str_get_html( $header_text );
        
        $cells = $html->find( 'td' );
        $i=0;
        $j                  = 0;
        $total_marks        = 0;
        $semester_total     = 0;
        $insert_sem_results = 0; //To allow inserting semester_report
        $semester_report; //FCD ,FC etc.
        $current_semester;
        $current_semester_set = 0;
        
     //   echo "Name: " . $current_student_name . "<br>";
        
        foreach ( $cells as $cell ) {
            $i++;
            if ( $i > 8 ) {
                
                if ( $current_semester_set == 1 ) {
                    $current_semester     = $cell->plaintext;
                    $current_semester_set = 0; //Reset
                }
                if ( preg_match( "/Semester:/i", $cell->plaintext ) ) {
                    $current_semester_set = 1;
                }
                /* This gives the result or the passing class outcome of semester. Ex : FCD, Second Class etc */
                if ( preg_match( "/result:/i", $cell->plaintext ) ) {
                    $semester_report = substr( $cell->plaintext, 45 );
         //           echo "Sem: " . $current_semester . ", Result: " . $semester_report . "<br><br>";
                    if ( $insert_sem_results == 0 )
                        $insert_sem_results = 1;
                    if ( $insert_sem_results == 11 ) //No need to skip subjects for next results(for back loggers).
                        $insert_sem_results = 3;
                }
                if ( $total_marks == 1 && $semester_total == 0 )
                    $semester_total = $cell->plaintext;
                if ( preg_match( "/Marks:/i", $cell->plaintext ) ) {
                    $total_marks = 1;
                }
                $numberOfNumbersFound = preg_match_all( "/[0-9]+/", $cell->plaintext, $out );
                
                if ( ( $j == 0 && $numberOfNumbersFound >= 2 ) || preg_match( "/MATDIP/i", $cell->plaintext ) ) {
                    /**
                    numberOfNumbersFound =2 for subjects formats like : Software Architectures (06IS72)
                    numberOfNumbersFound =3 for subjects formats like : Java and J2EE (06CS753)
                    numberOfNumbersFound =1 for subjects formats like : Advanced Mathematics - II (MATDIP401) so using to grep the MATDIP
                    **/
                    $subject = $cell->plaintext;
                    $j++;
                } elseif ( $numberOfNumbersFound == 1 && $j == 1 ) {
                    $external = $cell->plaintext;
                    $j++;
                } elseif ( $numberOfNumbersFound == 1 && $j == 2 ) {
                    $internal = $cell->plaintext;
                    $j++;
                } elseif ( $numberOfNumbersFound == 1 && $j == 3 ) {
                    $total = $cell->plaintext;
                    $j++;
                } elseif ( $j == 4 ) {
                    $outcome = $cell->plaintext;
                    $j++;
                    
                }
                
                if ( $j == 5 ) {
              //      echo $subject . "<br>E : " . $external . ", I : " . $internal . ",  T : " . $total . "<br>Result : " . $outcome . "<br><br>";
                    
                    /* To check the result has already been inserted */
                    $querya = "SELECT * FROM tbl_student_results" . $batch . " ";
                    $queryb = "WHERE student_details_id='" . $student_detail_id . "' AND semester='" . $current_semester . "' AND subject_name='" . $subject . "' AND  external='" . $external . "'  AND internal='" . $internal . "' AND total='" . $total . "' AND result='" . $outcome . "'";
                    $query  = $querya . $queryb;
                    $resultsa = mysql_query( $query ) or die( 'Error, failed to select the from table tbl_student_results' . mysql_error() . $query );
                    
                    if ( $row = mysql_fetch_row( $resultsa ) ) {
                        //Already inserted no need to add again
                    } else {
                        /* Insert the result into tbl_student_results  */
                        $query1 = "INSERT INTO tbl_student_results" . $batch . "(student_details_id ,semester ,subject_name ,external ,internal ,total ,result) VALUES ";
                        $query2 = "('" . $student_detail_id . "' , '" . $current_semester . "' ,'" . $subject . "' ,'" . $external . "' ,'" . $internal . "' ,'" . $total . "' ,'" . $outcome . "')";
                        $query  = $query1 . $query2;
                        mysql_query( $query ) or die( 'Error, insert query failed to insert in tbl_student_results' . mysql_error() . $query );
                    }
                    
                    //START : INSERTING results in tbl_student_report i.e FCD, FC, SC etc.
                    if ( $insert_sem_results == 3 ) {
                        /* To check the result has already been inserted */
                        $querya = "SELECT * FROM tbl_student_report" . $batch . " ";
                        $queryb = "WHERE student_details_id='" . $student_detail_id . "' AND semester='" . $current_semester . "' AND semester_result='" . $semester_report . "'";
                        $query  = $querya . $queryb;
                        $resultsa = mysql_query( $query ) or die( 'Error, failed to select the from table tbl_student_total' . mysql_error() . $query );
                        
                        if ( $row = mysql_fetch_row( $resultsa ) ) {
                            //Already inserted no need to add again
                        } else {
                            /* Insert the result into tbl_student_total*/
                            $query1 = "INSERT INTO tbl_student_report" . $batch . " (student_details_id ,semester ,semester_result) VALUES ";
                            $query2 = "('" . $student_detail_id . "' , '" . $current_semester . "' ,'" . $semester_report . "')";
                            $query  = $query1 . $query2;
                            mysql_query( $query ) or die( 'Error, insert query failed to insert in tbl_student_total' . mysql_error() . $query );
                        }
                        $insert_sem_results = 11; //simply took 11 to wait till next report normally helpful when multiple results will come. for  back loggers in subject
                    } else if ( $insert_sem_results < 3 ) {
                        $insert_sem_results++; //Insert only after skipping of 2 subjects as the format of subject is may be different.
                        /* 
                        one format : Software Engineering (10IS51) --- here its simple sem is 5.
                        other format : C# Programming and .Net (06CS761)-- here sem become 6 but actually its 7.
                        so for first result skip 2 subjects. (second results will be for  back loggers, regular have only one result.
                        */
                    }
                    // END : INSERTING THE TOTAL marks of semester
                    
                    $j = 0;
                }
            }
        }
        
      //  echo "<br>Semeter " . $semester_of_student . ", Total Marks " . $semester_total;
      //  echo "<br><br>Get revalutaion results also just sms @quickvturesults reval to get your results or sms @quickvturesults reval USN, to get results of other USN<br>";
        
        //START : INSERTING total marks in tbl_student_total
        $total_marks = preg_replace( "/[^0-9]/", '', $semester_total ); //Removing the space character from the semester_total.
        /* To check the total result has already been inserted */
        $querya      = "SELECT * FROM tbl_student_total" . $batch . " ";
        $queryb      = "WHERE student_details_id='" . $student_detail_id . "' AND semester='" . $semester_of_student . "' AND semester_total='" . $total_marks . "'";
        $query       = $querya . $queryb;
        $resultsa = mysql_query( $query ) or die( 'Error, failed to select the from table tbl_student_total' . mysql_error() . $query );
        
        if ( $row = mysql_fetch_row( $resultsa ) ) {
            //Already inserted no need to add again
        } else {
            /* Insert the result into tbl_student_total*/
            $query1 = "INSERT INTO tbl_student_total" . $batch . "(student_details_id ,semester ,semester_total ) VALUES ";
            $query2 = "('" . $student_detail_id . "' , '" . $semester_of_student . "' ,'" . $total_marks . "')";
            $query  = $query1 . $query2;
            mysql_query( $query ) or die( 'Error, insert query failed to insert in tbl_student_total' . mysql_error() . $query );
        }
        //END : INSERTING THE TOTAL marks of semester
        
    }
}

/* Get conneted to database */
$con = mysql_connect( "localhost", "nikhilkathare", "shobhagk" ) or die( "Error connecting database" . mysql_error() );
mysql_select_db( "quickvturesults_com_vtustudents" );

if ( isset( $_GET['region'] ) )
    $region = $_GET['region'];
if ( isset( $_GET['colg'] ) )
    $colg = $_GET['colg'];
if ( isset( $_GET['batch'] ) )
    $batch = $_GET['batch'];
if ( isset( $_GET['branch'] ) )
    $branch = $_GET['branch'];
if ( isset( $_GET['start'] ) )
    $start= $_GET['start'];
if ( isset( $_GET['end'] ) )
    $end= $_GET['end'];


create_all_required_table($batch);
insert_result_of_students( $region, $colg, $batch, $branch, $start,$end );

mysql_close( $con );
?>
