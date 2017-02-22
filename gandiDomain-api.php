<?php
  
require_once 'XML/RPC2/Client.php'; 
$domain_api = XML_RPC2_Client::create("https://rpc.ote.gandi.net/xmlrpc/", array('prefix' => 'domain.tld.','sslverify' => true));
$apikey = '***********';
$dom = $domain_api->region($apikey);
?>
<html>
<head>
 <title>Gandi domain name api</title>
</head>
<body>
<form method="post" id="formulaire"> 
<label>Domain name : <input name="domain" id="domain" value="" type="text"></label>
 
<select name="pty_select" > 
<?php foreach($dom as $key => $value){ ?> 
	<optgroup label="<?php echo $key; ?>">
		<?php foreach($value as $dot){ ?>
				 <option value="<?php echo $dot; ?>">.<?php echo $dot; ?></option> 
		<?php } ?>
	</optgroup>
<?php } ?>    
</select>
<input value="Envoyer" type="submit">
</form>
<?php
if (isset($_POST['domain'])) {
 
	$domain = $_POST['domain'].'.'.$_POST['pty_select'];
	$domain_api = XML_RPC2_Client::create('https://rpc.ote.gandi.net/xmlrpc/', array( 'prefix' => 'domain.' ));
	$result = $domain_api->available($apikey, array($domain));
	// print_r($result);
	 
	while ($result[$domain] === 'pending') {
		usleep(700000);
		$result = $domain_api->available($apikey, array($domain));
	}
	if ($result[$domain] === 'available')
		echo '<font color="green">This domain name is available</font>'; //print_r($result); 
	else 
		echo '<font color="red">This domain name is not available.</font> Try another';
}
?> 
</body>
</html>
