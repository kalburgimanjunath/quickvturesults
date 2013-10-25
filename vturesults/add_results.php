<?
error_reporting(E_ALL); 
//quickvturesults.com/quickvturesults/add_the_result.php?region=2&colg=ka&batch=10&branch=cs
//http://quickvturesults.com/quickvturesults/add_the_result.php?region=2&colg=ka&batch=10&branch=cs&start=0&end=60
//shell_exec('php add_the_result.php?region=2&colg=ka&batch=10&branch=cs &');
$cmd = "php add_the_result.php?region=2&colg=ka&batch=10&branch=cs &";
//$cmd = "cat  add_the_result.php";
//exec('/bin/bash "'. $cmd.'"',$output,$return);
$return = system($cmd, $output);
if($return==0)
{
    echo 'Successful'. $return . $output;
} 
else
{
    echo 'Unsuccessful' . $return . $output;
}
?>
