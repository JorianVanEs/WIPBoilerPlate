<?

	// Connect to the database using host, username and password

try
{
	$pdo = new PDO('mysql:host=localhost;dbname=jorianvan_es_NoPixel', 'jorianvan_es_NoPixel',  'adLW78UnkJrc');

	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$pdo->setAttribute(PDO::ATTR_CASE, PDO::CASE_NATURAL);
}
catch (PDOException $e)
{
	pdo_exception($e);
}

	// ClientId Twitch

$clientId = 'oop2lsfdumqqxoxqkpzsdrcp7w3t9m';

?>
