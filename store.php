<!DOCTYPE html>
<html lang="en" style="overflow-x: hidden;">

<head>
    <title>Collections</title>
    <meta charset="utf-8">
    <style>
        body{
         background-color: red; /* For browsers that do not support gradients */
  background-image: linear-gradient(90deg, #ffd89b 10%, #19547b 55%, #19547b 5000%);
} </style>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
<nav class="navbar navbar-expand-sm bg-dark navbar-dark pl-5 mb-0" style="border-radius: 0%;">
        <a class="navbar-brand" href="home.php" style="font-size: 25px;">BookHub</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="collapsibleNavbar">
            <ul class="navbar-nav">
                <li class="nav-item pr-4" style="font-size: 28px;">
                    <a class="nav-link" href="home.php">Home</a>
                </li>
                <li class="nav-item pl-4" style="font-size: 28px;">
                    <a class="nav-link" href="store.php">Collection</a>
                </li>
            </ul>
        </div>
    </nav>
    <?php
    require("mysqli_connect.php");

    $selectQuery = "SELECT * FROM books";
    $result = mysqli_query($dbc, $selectQuery);

    if (mysqli_num_rows($result) > 0) {
        echo "<div class='container-fluid'>
                <div class='container-fluid mt-5 row'>";
        while ($rows = mysqli_fetch_assoc($result)) {
            echo "<div class='col-3'>
                            <div class='card mb-5' style='width:300px'>
                                <a href='detail.php?id={$rows['bookid']}'>
                                    <img class='card-img-top' src='Image/{$rows['coverimage']}' alt='Card image' style='width:100%;height:450px;'>
                                </a>
                                <div class='card-body' style=' background-image: linear-gradient(90deg, #bdc3c7 0%, #2c3e50 95%,  #bdc3c7 100%);}'>
                                    <h4 class='card-title'>{$rows['booktitle']}</h4>
                                    <p class='card-text'>{$rows['author']}</p>
                                    <h4 class='card-title'>$ {$rows['price']}</h4>
                                    <a href='detail.php?id={$rows['bookid']}' class='btn btn-primary' style='background-color: #343a40;'>Check Me</a>
                                </div>
                            </div>
                        </div>";
        }
        echo "</div></div>";
    } else {
        echo "<h1 class='text-center text-danger'>Can't find any books.</h1>";
    }
    ?>

<div class="text-center"  style="background-color: #343a40; padding: 1em 0px;">
    <h1 class="credit" style="color: white;"> <span> OnlineBookHub | Shreya Soni |Copyright &copy; 2022 | all rights reserved! </span> </h1>
    </div>
</body>

</html>