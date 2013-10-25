
function isEmpty( str ) { 
	if ( null == str || "" == str ) { 
		return true; 
	} 
	return false; 
}

function validateEmail(elementValue){ 
	if (isEmpty(elementValue)) return false;
	 
    var emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;  
    return emailPattern.test(elementValue);  
} 