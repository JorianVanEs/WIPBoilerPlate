 <?

   include 'db_connect.php';

   $stmt = $pdo->query("SELECT * FROM factions ORDER BY id");
   $dbFactions = $stmt->fetchAll(PDO::FETCH_ASSOC);

   echo json_encode($dbFactions);

?>
