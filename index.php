<?php
require '_connec.php';

$connection = createConnection();

$query = "SELECT * FROM friend";
$statement = $connection->query($query);
$friends = $statement->fetchAll();

$errors = [];

if($_SERVER["REQUEST_METHOD"] === 'POST') {

$friend = array_map("trim", $_POST); 
$friend = array_map("htmlentities", $friend);

    if(!isset($friend['firstname']) || empty($friend['firstname']))
    {
        $errors[] = "Le champ est obligatoire";
    }

    if(!isset($friend['lastname']) || empty($friend['lastname']))
    {
        $errors[] = "Le champ est obligatoire";
    }

    if(strlen($friend['firstname']) > 45)
    {
        $errors[] = "Le mot est trop long";
    }

    if(strlen($friend['lastname']) > 45)
    {
        $errors[] = "Le mot est trop long";
    }

    foreach ($errors as $error) {
        echo $error . "<hr>" ;
    }    


    if (empty($errors)) {

    $query = 'INSERT INTO friend (firstname, lastname) VALUES (:firstname, :lastname)';
    $statement = $connection->prepare($query);
    $statement->bindValue(':firstname', $friend['firstname']);
    $statement->bindValue(':lastname', $friend['lastname']);
    $statement->execute();
    header('Location: /'); 
    exit();

    }

}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@picocss/pico@1/css/pico.min.css">
    <title>Document</title>
</head>
<body>
    <div>
    <?php foreach($friends as $friend){ echo "<li>" . $friend['firstname'] . " " . $friend['lastname'] . "</li>"; } ?>
    </div>
    <div>
       
        <form action="" method="post" class='container'>

                <input type="text" id="firstname" name="firstname" placeholder="First name" required>

                <input type="text" id="lastname" name="lastname" placeholder="Last name" required>

                <button type="submit">Submit</button>

        </form>
    </div>    
</body>
</html>