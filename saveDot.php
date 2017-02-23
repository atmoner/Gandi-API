<?php

$path = dirname(__FILE__); 
require_once $path.'/libs/startup.php';
    
require_once 'XML/RPC2/Client.php'; 
$domain_api = XML_RPC2_Client::create("https://rpc.ote.gandi.net/xmlrpc/", array('prefix' => 'domain.tld.','sslverify' => true));
$apikey = '***********';
$dom = $domain_api->list($apikey);
var_dump($dom);
 
foreach ($dom as $key => $value) {
    //echo "Clé : $key; Valeur : $value<br />\n";
	switch ($value["region"]) {
		case 'generic':
		    $idRegion = 1;
		    break;
		    
		case 'europe':
		    $idRegion = 2;        
		    break; 
		    
		case 'america':
		    $idRegion = 3;        
		    break;
		    
		case 'africa':
		    $idRegion = 4;        
		    break;
		    
		case 'asia':
		    $idRegion = 5;
		    break;
	}
	$query = "INSERT INTO dot (id_r,name,phases,visibility) 
	         VALUES (
		  '".$db->escape($idRegion)."',
		  '".$db->escape($value['name'])."',
		  '".$db->escape(serialize($value['phases']))."',
		  '".$db->escape($value['visibility'])."'  
		  )";
    $db->query($query);
} 
