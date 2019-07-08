<?

  include 'db_connect.php';

  $channelsApi = 'https://api.twitch.tv/helix/users?login=';
  $streamApi = 'https://api.twitch.tv/helix/streams?user_id=';

  $stmt = $pdo->query("SELECT * FROM characters ORDER BY name");
  $dbChars = $stmt->fetchAll(PDO::FETCH_ASSOC);
  $characterArray = array();

  foreach ($dbChars as $char) {;

    $ch = curl_init();

    curl_setopt_array($ch, array(
      CURLOPT_HTTPHEADER=> array(
      'Client-ID: ' . $clientId
      ),
      CURLOPT_RETURNTRANSFER=> true,
      CURLOPT_URL => $channelsApi . $char['streamer']
    ));

    $channelResponse = curl_exec($ch);
    curl_close($ch);

    $obj = json_decode($channelResponse, true);

    foreach($obj["data"] as $result) {
        $userId = $result["id"];
    }

    $st = curl_init();

    curl_setopt_array($st, array(
      CURLOPT_HTTPHEADER=> array(
      'Client-ID: ' . $clientId
      ),
      CURLOPT_RETURNTRANSFER=> true,
      CURLOPT_URL => $streamApi . $userId
    ));

    $streamResponse = curl_exec($st);
    curl_close($st);

    $streamData = json_decode($streamResponse, true);

    $character = array();
    $character["name"] = $char["name"];
    $character["occupation"] = $char["occupation"];
    $character["streamer"] = $char["streamer"];
    $character["twitch"] = array();

    foreach($streamData["data"] as $stream) {
      if($stream["type"] == "live"){
        $character["twitch"]["live"] = "true";
        $character["twitch"]["user"] = $stream["user_name"];
        $character["twitch"]["title"] = $stream["title"];
        $character["twitch"]["viewerCount"] = $stream["viewer_count"];
        $character["twitch"]["startTime"] = $stream["started_at"];
      } else {
        $character["twitch"] = [];
      }
    }

    array_push($characterArray ,$character);
  }

  echo json_encode($characterArray);

?>
