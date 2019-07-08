<?

  include 'db_connect.php';

  $msgs = array();

  if($_POST["first_name"] === ""){
    array_push($msgs, "Please fill in a firstname.");
  }

  if($_POST["last_name"] === ""){
    array_push($msgs, "Please fill in a lastname.");
  }

  if($_POST["occupation"] === ""){
    array_push($msgs, "Please fill in a occupation.");
  }

  if($_POST["streamer"] === ""){
    array_push($msgs, "Please fill in a streamer.");
  }

  $fileName = $_FILES["avatar"]["name"];
  $fileSize = $_FILES["avatar"]["size"];
  $fileTmp = $_FILES["avatar"]["tmp_name"];
  $fileError = $_FILES["avatar"]["error"];
  $fileTmpName = basename($_FILES["avatar"]["tmp_name"]);
  $fileExtention = strtolower(end(explode('.', $_FILES['avatar']['name'])));

  if(isset($_FILES["avatar"])){
    $validExtentions = array("jpeg", "jpg", "png");

    if($fileError === 0){
      if(in_array($fileExtention, $validExtentions) === false){
       array_push($msgs, "Please select a jpg or png image.");
      }

      if($fileSize > 2000000){
        array_push($msgs, "Please select an smaller image.");
      }
    }
  } else {
    array_push($msgs, "Please select an image.");
  }

  if(sizeof($msgs) <= 0){
    $sql = "INSERT INTO characters (firstname, lastname, occupation, streamer) VALUES (?,?,?,?)";
    $pdo->prepare($sql)->execute([$_POST["first_name"], $_POST["last_name"],  $_POST['occupation'],  $_POST['streamer']]);
    move_uploaded_file($fileTmp, '../img/avatars/' . $_POST["first_name"] . "_" . $_POST["last_name"] . "." . $fileExtention);
    array_push($msgs, "Image successfully uploaded!");
  }

  echo json_encode(implode(",", $msgs));

?>
