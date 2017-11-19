<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>gastenboek</title>
    <link rel="stylesheet" href="style.css">
  </head>
  <body>
<form action="index.php" method="post">

    <label for="voornaam">Voornaam:</label><br>
        <input type="text" name="firstname" id="voornaam"><br>
  <br>
    <label for="tekst">Text gastenboek</label><br>
        <input type="text" name="input" id="tekst"><br><br>
      <div class="note">
        <p>NOTE: Er wordt niet toegestaan te schelden: worden die verboden zijn: <b>asshole</b> <b>bitch</b> <b>fuck</b></p>
      </div>
        <input type="submit" name="submit" value="submit"/>
</form>



<?php
$dbc = mysqli_connect('localhost', '23976', '23976', '23976_database') or die ('Error!');

if(isset($_POST['submit'])){

        $firstname = strip_tags($_POST['firstname']);
        $input = strip_tags($_POST['input']);

        function badWordFilter($data){
            $originals = array("asshole","bitch","fuck");
            $replacements = array("****","****","****");
            $data = str_ireplace($originals,$replacements,$data);

            return $data;
        }

        $myData = $input;
        $cleaned = badWordFilter($myData);


        $query = "INSERT INTO gastenboek VALUES (0,'$firstname','$cleaned')";
        $result = mysqli_query($dbc, $query) or die ('Error querying.');
        $message = 'Er is een nieuwe post';
        $to = '23976@ma-web.nl';
        $subject = 'Activeren';
        $from = '23976@ma-web.nl';
        mail($to, $subject, $message, 'From:' . $from);
    }else{
        echo "Geen geldige naam";


}
?>
<?php
$query = "SELECT * FROM gastenboek ORDER BY id DESC" or die ("Error");
$result = mysqli_query($dbc, $query);
while ($row = mysqli_fetch_array($result)){
    $username = $row['firstname'];
    $description = $row['input'];
    echo '<div class="output">';
    echo 'Voornaam: ' . $username . '<br>';
    echo 'Bericht: ' . $description;
    echo '</div><br>';
}
?>

  </body>
</html>
