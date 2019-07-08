<?

  include 'db_connect.php';

  date_default_timezone_set('UTC');

  $channelsApi = 'https://api.twitch.tv/helix/users?login=';
  $streamApi = 'https://api.twitch.tv/helix/streams?';

  $stmt = $pdo->query("SELECT * FROM characters ORDER BY name");
  $dbChars = $stmt->fetchAll(PDO::FETCH_ASSOC);

  $streamers = array();
  $userIds = array();
  $characterArray = array();

  $timeStarted = microtime(true);

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

    $streamer["character_name"] = $char['name'];
    $streamer["character_occupation"] = $char['occupation'];
    $streamer["twitch_name"] = $char['streamer'];
    $streamer["twitch_id"] = $userId;

    array_push($streamers, $streamer);
    array_push($userIds, "user_id=" . $userId . "&");
  }

  $firstRequest = microtime(true);
  echo "The first request took " . ($firstRequest - $timeStarted) . " seconds! <br>";

  $userStr = rtrim(implode("", $userIds), "&");

  $st = curl_init();

  curl_setopt_array($st, array(
    CURLOPT_HTTPHEADER=> array(
    'Client-ID: ' . $clientId
    ),
    CURLOPT_RETURNTRANSFER=> true,
    CURLOPT_URL => $streamApi . $userStr
  ));

  $secondRequest = microtime(true);
  echo "The second request took " . ($secondRequest - $firstRequest) . " seconds! <br>";

  $streamResponse = curl_exec($st);
  curl_close($st);

  $streamData = json_decode($streamResponse, true);

  echo json_encode(createCharacterEntries($streamers, $streamData));

  function createCharacterEntries($arr1, $arr2){
    $entries = array();

    foreach($arr1 as $x) {
      $entry["characterName"] = $x["character_name"];
      $entry["characterOccupation"] = $x["character_occupation"];
      $entry["twitchName"] = $x["twitch_name"];
      $entry["twitchId"] = $x["twitch_id"];
      $entry["twitchLive"] =  false;
      $entry["streamViewers"] =  0;
      $entry["streamDuration"] =  "";
      $entry["streamTitle"] =  "";

      foreach($arr2["data"] as $y) {
        if($x["twitch_id"] == $y["user_id"]){
          $entry["twitchLive"] =  true;
          $entry["streamViewers"] =  $y["viewer_count"];
          $minutes = floor((time() - strtotime($y["started_at"])) / 60);
          $hours = floor((time() - strtotime($y["started_at"])) / 60 / 60);
          $remMin = floor((time() - strtotime($y["started_at"])) / 60) - floor((time() - strtotime($y["started_at"])) / 60 / 60 ) * 60;
          if($remMin < 10){
            $remMin = 0 . $remMin;
          }
          $entry["streamDuration"] = ($hours . ":" . $remMin);
          $entry["streamTitle"] =  $y["title"];
          $entry["streamTitle"] =  $y["id"];

        }
      }

      array_push($entries, $entry);
    }

    return $entries;
  }

?>
