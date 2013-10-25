<?php

require 'simple_html_dom.php';
require 'revaluation.php';
require 'dbdetails.php';

//Header

/* *****************VTU RESULTS************************
A simple txtWeb application where you ask txtWeb users to  enter the USN as an input to your app , for eg  
@quickvturesults USN  
This will return the result sms if the results of the particular USN is out*/    
   
 //Include your txtWeb app key in the head section of your app response 
  echo "<html> 
		<head>           
			<meta name=\"txtweb-appkey\" content=\"cd7b1a06-7013-4b96-8303-6489616ea8b4\">
		</head>        
	<body>";
     
//Registration
if(isset($_GET['txtweb-message']))     $message = $_GET['txtweb-message'];  

	/* To check if the mobile number is registered */
	$queryHash = "SELECT * FROM tbl_student_registration WHERE mobile_hash='". $mobilehash."'"; 
	$resultsa = mysql_query($queryHash) or die('Error, failed to select the mobile hash' . mysql_error() . $query); 

	if($row = mysql_fetch_row($resultsa)) { 
	
		//The mobile number is already registered. Needed format currently Empty message or USN of other person.
		$student_detail_id = $row[4];  //Get the student_detail_id that can be used to fetch the USN in later point.

		/* If the user has sent only @quickvturesults then find his registered usn and then get him his result */
		if ($message == NULL) {
			$query = "SELECT * FROM tbl_student_detail WHERE student_id ='" . $student_detail_id . "'";
			$student_details =  mysql_query($query) or die("Failed to select student_detail_id");
			$row = mysql_fetch_row($student_details);
			$student_usn = $row[1];
		}
		else { //Here the user need the result of some other usn, validate the usn and get him the result
			$registration_array = explode(" ", $message);
			$request= $registration_array[0] ;
			//Wheather he is requesting for amount      
			if (preg_match("/balance/i", $request)) {
				/* get him the earned balance amount */
			        $query = "SELECT amount_earned FROM tbl_amount_earned WHERE registration_id='" . $row[0] . "'";
			        $results=  mysql_query($query) or die("Failed to select student_detail_id");
			        
				$rows = mysql_fetch_row($results);
			        $amount_earned= $rows[0];
				
			        echo "Hi, your balance is : " . $amount_earned . "<br>Your registration id is : " . $row[0] . "<br>";
			        echo "Ask your friend to SMS<br>@quickvturesults[space]mobile_no[space]email_address[space]USN[space]" . $row[0] . "<br>(" . $row[0] . " is your registration id)<br>And send to 9243342000. You get 10 rupees for every friend who register through your registration id.";
			        echo "<br>Now SMS<br>@quickvturesults<br>to get your results.<br>or SMS<br>@quickvturesults[space]USN<br>to get results of any other USN.<br>And send to 9243342000 to get the results.<br>";
			        echo "Get revalutaion results also just sms @quickvturesults reval to get your results or sms @quickvturesults reval USN, to get results of other USN<br>";
			        mysql_close($con);
			        return;
			}

			//START: Revaluation results
			if (preg_match("/reval/i", $request)) {
			      /* get the user revaluation results */
			      if($registration_array[1] == NULL) { //if mgs Sent as "@quickvturesults reval" the extract USN from database.
				     $query = "SELECT * FROM tbl_student_detail WHERE student_id ='" . $student_detail_id . "'";
				     $student_details =  mysql_query($query) or die("Failed to select student_detail_id");
				     $row = mysql_fetch_row($student_details);
				     $student_usn = $row[1];
			      } else { //USN is send as "@quickvturesults reval 2ka07cs019"
				      if ( !isValid( 'usn', $registration_array[1]) && !isValid( 'usnmca', $registration_array[1])  ) {
					      echo "USN : " . $student_usn . " is invaild.<br>Just SMS<br>@quickvturesults<br>to get your revaluation results.<br>or SMS<br>@quickvturesults[space]USN<br>to get results of any other USN.<br>And send to 9243342000 to get the results.<br>";
					      echo "Get revalutaion results also just sms @quickvturesults reval to get your results or sms @quickvturesults reval USN, to get results of other USN<br>";
					      mysql_close($con);
					      return;
				      }
				      $student_usn = $registration_array[1];
			       }
				revalutaion_result($student_usn, $student_detail_id);
				mysql_close($con);
				return;
			}
			//END: Revaluation results
			$student_usn = $registration_array[0] ; 
			if ( !isValid( 'usn', $student_usn )  && !isValid( 'usnmca', $student_usn) ) {
				echo "USN : " . $student_usn . " is invaild.<br>Just SMS<br>@quickvturesults<br>to get your results.<br>or SMS<br>@quickvturesults[space]USN<br>to get results of any other USN.<br>And send to 9243342000 to get the results.<br>";
				echo "Get revalutaion results also just sms @quickvturesults reval to get your results or sms @quickvturesults reval USN, to get results of other USN<br>";
				mysql_close($con);
				return;
			}
		}          
          //Student as already been registered with USN student_usn goes and fetch the result after else part. Result of himself or any other usn
	}else{

			/* message has format : mobile_number email_id USN */
			$registration_array = explode(" ", $message);  
			/* For old user who just used to send @quickvturesults USN */ //80 line number
			
			if (count($registration_array) == 1) {
			    echo "Sorry, Please do registration first with us to get your results.<br>Just SMS<br>@quickvturesults[space]mobile_no[space]email_address[space]USN<br>And send to 9243342000.<br> Get 20Rs free mobile recharge on registration.";
			    mysql_close($con);
			    return;
			} elseif (count($registration_array) < 3 ) {
			    echo "Sorry, Invalid format for registration, note the correct format.<br>SMS<br>@quickvturesults[space]mobile_no[space]email_address[space]USN<br>And send to 9243342000.";
			    echo "Get revalutaion results also just sms @quickvturesults reval to get your results or sms @quickvturesults reval USN, to get results of other USN<br>";
			    mysql_close($con);
			    return;
			}
		
			//Validating the input

			$mobile_number = $registration_array[0] ;
			$email_id = $registration_array[1] ;
			$student_usn = $registration_array[2] ; 
			$invited_registration_id = $registration_array[3];

			if ( !isValid( 'mobile', $mobile_number ) ) {
				echo "Invalid mobile number cannot register please resend the registration request with correct details. Just SMS<br>@quickvturesults[space]mobile_no[space]email_address[space]USN<br>And send to 9243342000.";
				echo "Get revalutaion results also just sms @quickvturesults reval to get your results or sms @quickvturesults reval USN, to get results of other USN<br>";
				mysql_close($con);
				return;
			} elseif ( !isValid( 'email', $email_id ) ) {
				echo "Invalid email address cannot register please resend the registration request with correct details. Just SMS<br>@quickvturesults[space]mobile_no[space]email_address[space]USN<br>And send to 9243342000.";
				echo "Get revalutaion results also just sms @quickvturesults reval to get your results or sms @quickvturesults reval USN, to get results of other USN<br>";
				mysql_close($con);
				return;
			} elseif ( !isValid( 'usn', $student_usn ) && !isValid( 'usnmca', $student_usn ) ) {
				echo "Invalid USN number cannot register please resend the registration request with correct details. Just SMS<br>@quickvturesults[space]mobile_no[space]email_address[space]USN<br>And send to 9243342000.";
				echo "Get revalutaion results also just sms @quickvturesults reval to get your results or sms @quickvturesults reval USN, to get results of other USN<br>";
				mysql_close($con);
				return;
			}
			
			$queryStudent_detail = "SELECT * FROM tbl_student_detail WHERE student_usn='"   . $student_usn . "'"; 
			$resultsa = mysql_query($queryStudent_detail) or die('Error, failed to select student usn'.mysql_error() . $query); 

			if ($row = mysql_fetch_assoc($resultsa)) { //If the executed command has got any output
			   //No need to echo this as anyways we going to select the student id after this if else condition.
			}else {
			   /* Insert into student details */
			   $queryStudent_detailInsert = "INSERT INTO tbl_student_detail(student_id ,student_usn ,student_name ) VALUES('NULL' , '" . $student_usn . "' ,'NULL')";
			   mysql_query($queryStudent_detailInsert) or die('Error, insert query failed to insert in student details'.mysql_error() . $query);
			}
			
			/* registration of the student */
			/* Get the student_detail_id to link it to registration table */
			
			$querytbl_student = "SELECT student_id FROM tbl_student_detail WHERE student_usn='" . $student_usn . "'";
			$student_details =  mysql_query($querytbl_student) or die("Failed to select student_detail_id");
			
			$row = mysql_fetch_row($student_details);
			$student_detail_id = $row[0];
			
			$queryStudentRegistration = "INSERT INTO tbl_student_registration(registration_id ,mobile_hash ,mobile_number ,email_id ,student_detail_id , registration_time) VALUES('NULL' , '" . $mobilehash . "' , '" . $mobile_number . "' , '" . $email_id . "' , '" . $student_detail_id . "' ,'" .  date("F j, Y, g:i a") . "')";
			
			mysql_query($queryStudentRegistration) or die('Error, insert query failed for student registration'.mysql_error() . $query);
			
		}
		//loading the results it 
		$string="http://results.vtu.ac.in/vitavi.php?rid=" . $student_usn . "&submit=SUBMIT";
		
		$doc=@file_get_contents($string);     
		if($doc==false)
		{
		   echo "Hello, <br/> VTU is currently uploading the results so please have some patience and try again after sometime<br/>";
		   mysql_close($con);
		   return;
		}
		
		//Seperate header and content
		$header_text = substr($doc,9000,800000);

		$ss = preg_match("/Results are not yet available/",$header_text, $tt);
		if ($ss != 0) {
		    echo "Results not yet came for USN : " . $student_usn . "<br/>Cross check ones wheather the USN is correct<br>";
		    echo "Get revalutaion results also just sms @quickvturesults reval to get your results or sms @quickvturesults reval USN, to get results of other USN<br>";
		    mysql_close($con);
		    return;
		}
		
		//DOM Start here
		
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
		
		/**
			UPDATE NAME : START
			This block is for updating the name in table.
			Just to find whether the any of other friend has requested for the results so that that value will be present,in the student_details table. Just get the name so that we can know that the name is already updated.i.e if student_name is NULL going to update the table with student name 
		*/
		
		$querya = "SELECT * FROM tbl_student_detail WHERE student_usn='$student_usn'"; 
		$resultsa = mysql_query($querya) or die('Error, failed to select student usn'.mysql_error().$query); 
		   
		if($row = mysql_fetch_row($resultsa)) { 
			//If the executed command has got any output
			$student_detail_id = $row[0];
			$student_name = $row[2];
		}
		else {
			/* Insert into student details */
			$queryS = "INSERT INTO tbl_student_detail(student_id ,student_usn ,student_name ) VALUES('NULL' , '" . $student_usn . "' ,'" . $current_student_name  . "')";
			mysql_query($queryS) or die('Error, insert query failed to insert in student details'.mysql_error() . $query);
		       
			/* Inserted the result get the student_detail_id */
			
			$queryA = "SELECT student_id FROM tbl_student_detail WHERE student_usn='"   . $student_usn . "'"; 
			$resultsa = mysql_query($queryA) or die('Error, failed to select student usn'.mysql_error() . $query);
			
			
			$row = mysql_fetch_row($resultsa);
			
			//Just to update the name in next condition if name is not set in table.
			$student_detail_id = $row[0];  
		   }
		   if (preg_match("/NULL/i", $student_name)) { //If the student name has not been added to table then add it to table.
		       $query = "UPDATE tbl_student_detail SET student_name='" . $current_student_name . "' WHERE student_id='" . $student_detail_id . "'";
		       mysql_query($query) or die('Error, Update of student name failed in tbl_student_details'.mysql_error() . $query);
		   }
		   //UPDATE NAME : END
		   
		   
			$html = str_get_html($header_text);

			$cells = $html->find('td');
			$i=0;
			$j=0;
			$total_marks = 0;
			$semester_total = 0;
			$insert_sem_results = 0; //To allow inserting semester_report
			$semester_report;  //FCD ,FC etc.
			$current_semester;
			$current_semester_set = 0;
			
			echo "Name: " . $current_student_name . "<br>";
			
			foreach($cells as $cell) 
			{
				$i++;
				    if ( $i > 8) {

					if ($current_semester_set == 1) {
						 $current_semester = $cell->plaintext;             
						 $current_semester_set = 0; //Reset
					}
					if (preg_match("/Semester:/i", $cell->plaintext)) {
						 $current_semester_set = 1;
					}   
				       /* This gives the result or the passing class outcome of semester. Ex : FCD, Second Class etc */
					if (preg_match("/result:/i", $cell->plaintext)) {
						$semester_report = substr($cell->plaintext, 45);
						 echo "Sem: " . $current_semester . ", Result: " . $semester_report . "<br><br>";
						 if ($insert_sem_results == 0)
							 $insert_sem_results = 1;
						 if ($insert_sem_results == 11) //No need to skip subjects for next results(for back loggers).
							 $insert_sem_results = 3;
					}   
					if ($total_marks == 1 && $semester_total == 0)
						 $semester_total = $cell->plaintext;             
					if (preg_match("/Marks:/i", $cell->plaintext)) {
						 $total_marks = 1;
					}   
					$numberOfNumbersFound = preg_match_all("/[0-9]+/", $cell->plaintext, $out);
	 
					if( ($j == 0 && $numberOfNumbersFound >= 2) || preg_match("/MATDIP/i", $cell->plaintext) ) {
					/**
						numberOfNumbersFound =2 for subjects formats like : Software Architectures (06IS72)
						numberOfNumbersFound =3 for subjects formats like : Java and J2EE (06CS753)
						numberOfNumbersFound =1 for subjects formats like : Advanced Mathematics - II (MATDIP401) so using to grep the MATDIP
					**/
						$subject = $cell->plaintext;
						$j++;
					} elseif($numberOfNumbersFound == 1 && $j == 1) {
						$external =  $cell->plaintext;
						$j++;
					} elseif ($numberOfNumbersFound == 1 && $j == 2) {
						$internal =  $cell->plaintext;           
						$j++;
					} elseif ($numberOfNumbersFound == 1 && $j == 3) {
						$total =  $cell->plaintext;           
						$j++;
					} elseif ($j == 4) {
						$outcome =  $cell->plaintext;   
						$j++;       

					}

					if ($j == 5) {
					    echo $subject . "<br>E : " . $external . ", I : " . $internal . ",  T : " . $total . "<br>Result : " . $outcome . "<br><br>";
				 
					    /* To check the result has already been inserted */
					    $queryResults = "SELECT * FROM tbl_student_results WHERE student_details_id='" . $student_detail_id . "' AND semester='" . $current_semester . "' AND subject_name='" . $subject  . "' AND  external='" . $external  . "'  AND internal='" . $internal  . "' AND total='" . $total  . "' AND result='" . $outcome  . "'"; 
					    $resultsa = mysql_query($queryResults) or die('Error, failed to select the from table tbl_student_results' . mysql_error() . $query); 
				 
					    if ($row = mysql_fetch_row($resultsa)) { 
						  //Already inserted no need to add again
					    } else{
						/* Insert the result into tbl_student_results  */
						$queryRs = "INSERT INTO tbl_student_results(student_details_id ,semester ,subject_name ,external ,internal ,total ,result) VALUES('" . $student_detail_id . "' , '" . $current_semester . "' ,'" . $subject  . "' ,'" . $external . "' ,'" . $internal . "' ,'" . $total . "' ,'" . $outcome . "')";
						
						mysql_query($queryRs) or die('Error, insert query failed to insert in tbl_student_results'.mysql_error() . $query);
					    }

						//START : INSERTING results in tbl_student_report i.e FCD, FC, SC etc.
					    if ( $insert_sem_results == 3 ) {
						
						/* To check the result has already been inserted */
			   
						$queryReport = "SELECT * FROM tbl_student_report WHERE student_details_id='" . $student_detail_id . "' AND semester='" . $current_semester . "' AND semester_result='" . $semester_report . "'"; 
						$resultsa = mysql_query($queryReport) or die('Error, failed to select the from table tbl_student_total' . mysql_error() . $query); 
	 
						if ($row = mysql_fetch_row($resultsa)) { 
							//Already inserted no need to add again
						}else{
							/* Insert the result into tbl_student_total*/
							
							$query1 = "INSERT INTO tbl_student_report (student_details_id ,semester ,semester_result) VALUES ";
							$query2 = "('" . $student_detail_id . "' , '" . $current_semester . "' ,'" . $semester_report . "')";
							$query = $query1 . $query2;
							mysql_query($query) or die('Error, insert query failed to insert in tbl_student_total'.mysql_error() . $query);
						}
						
						$insert_sem_results = 11;  //simply took 11 to wait till next report normally helpful when multiple results will come. for  back loggers in subject
					    } else if ( $insert_sem_results < 3 ) {
					    
						    $insert_sem_results++;
						    //Insert only after skipping of 2 subjects as the format of subject is may be different.
						    /* 
							   one format : Software Engineering (10IS51) --- here its simple sem is 5.
							   other format : C# Programming and .Net (06CS761)-- here sem become 6 but actually its 7.
							   so for first result skip 2 subjects. (second results will be for  back loggers, regular have only one result.
						    */
					    }
				//END : INSERTING THE TOTAL marks of semester

					    $j=0;
				       }
				}
			}

			echo "<br>Semeter " . $semester_of_student . ", Total Marks " . $semester_total ;
			echo "<br><br>Get revalutaion results also just sms @quickvturesults reval to get your results or sms @quickvturesults reval USN, to get results of other USN<br>";

			//START : INSERTING total marks in tbl_student_total		
			
				$total_marks = preg_replace("/[^0-9]/", '', $semester_total); //Removing the space character from the semester_total.
			   
				/* To check the total result has already been inserted */
				$queryT = "SELECT * FROM tbl_student_total WHERE student_details_id='" . $student_detail_id . "' AND semester='" . $semester_of_student . "' AND semester_total='" . $total_marks . "'"; 
				$resultsa = mysql_query($queryT) or die('Error, failed to select the from table tbl_student_total' . mysql_error() . $query); 
		 
				if($row = mysql_fetch_row($resultsa)) { 
				  //Already inserted no need to add again
				}else{
				    /* Insert the result into tbl_student_total*/
				    $queryTS = "INSERT INTO tbl_student_total(student_details_id ,semester ,semester_total ) VALUES('" . $student_detail_id . "' , '" . $semester_of_student . "' ,'" . $total_marks . "')";
				   
				    mysql_query($queryTS) or die('Error, insert query failed to insert in tbl_student_total'.mysql_error() . $query);
				}
				
			//END : INSERTING THE TOTAL marks of semester
	  

		mysql_close($con);
		echo "</body>
		</html>";      

	
?> 
