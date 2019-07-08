<?

  include 'db_connect.php';

  date_default_timezone_set('UTC');

  $channelsApi = 'https://api.twitch.tv/helix/users?';
  $streamApi = 'https://api.twitch.tv/helix/streams?';

  $dbCharsArray = array();
  $userIds = array();
  $characterArray = array();

  $timeStarted = microtime(true);

  $stmt = $pdo->query("SELECT * FROM characters ORDER BY id DESC");
  $dbChars = $stmt->fetchAll(PDO::FETCH_ASSOC);

  foreach ($dbChars as $char) {;
    array_push($dbCharsArray, "login=" . strtolower($char['streamer']) . "&");
  }

  $streamersString = rtrim(implode("", $dbCharsArray), "&");

  $channelRequest = curl_init();

  curl_setopt_array($channelRequest, array(
    CURLOPT_HTTPHEADER=> array(
    'Client-ID: ' . $clientId
    ),
    CURLOPT_RETURNTRANSFER=> true,
    CURLOPT_URL => $channelsApi . $streamersString
  ));

  $channelResponse = curl_exec($channelRequest);
  curl_close($channelRequest);

  $channelData = json_decode($channelResponse, true);

  $streamers = createStreamerArray($dbChars, $channelData);

  foreach($channelData["data"] as $channel){
    array_push($userIds, "user_id=" . $channel["id"] . "&");
  }

  $userStr = rtrim(implode("", $userIds), "&");

  $streamRequest = curl_init();

  curl_setopt_array($streamRequest, array(
    CURLOPT_HTTPHEADER=> array(
    'Client-ID: ' . $clientId
    ),
    CURLOPT_RETURNTRANSFER=> true,
    CURLOPT_URL => $streamApi . $userStr
  ));

  $streamResponse = curl_exec($streamRequest);
  curl_close($streamRequest);

  $streamData = json_decode($streamResponse, true);

  echo json_encode(createCharacterEntries($streamers, $streamData));

  function createStreamerArray($arr1, $arr2){
    $streamers = array();
    foreach($arr1 as $x){
      $streamer["character_firstname"] = $x['firstname'];
      $streamer["character_lastname"] = $x['lastname'];
      $streamer["character_occupation"] = $x['occupation'];
      $streamer["twitch_name"] = $x['streamer'];

      foreach ($arr2["data"] as $y) {
        if($x["streamer"] == $y["display_name"]){
          $streamer["twitch_id"] = $y["id"];
        }
      }
      array_push($streamers, $streamer);
    }
    return $streamers;
  }

  function createCharacterEntries($arr1, $arr2){
    $entries = array();

    foreach($arr1 as $x) {
      $entry["characterFirstname"] = $x["character_firstname"];
      $entry["characterLastname"] = $x["character_lastname"];
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
