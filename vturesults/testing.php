<?php
require 'simple_html_dom.php';
$string="http://themeforest.net/category/site-templates";
//$html = file_get_html($string);
$doc=@file_get_contents($string);    
//echo $html;
$header_text = substr($doc,9000,800000);

$doc1 = new DOMDocument();
		@$doc1->loadHTML($header_text);
		
		$xpath = new DOMXPath($doc1);
echo $header_text;

$tables = $doc1->getElementsByTagName('div');
print_r($tables);
exit;
$nodes  = $xpath->query('.', $tables->item(1));
		print_r($nodes);

		
?>