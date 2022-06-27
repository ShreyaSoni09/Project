<!DOCTYPE html>
<html lang="en" style="overflow-x: hidden;">

<head>
<style>
     body{
         background-color: red; /* For browsers that do not support gradients */
  background-image: linear-gradient(90deg, #ffd89b 0%, #19547b 85%, #19547b 5000%);
}
  </style>
    <title>Detail Page</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
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
    session_start();
    require("mysqli_connect.php");
    $_SESSION['id'] = $_REQUEST['id'];

    $joinQuery = "SELECT books.bookid, booktitle, publishdate, price, description, coverimage, author, publisher, edition, category, stock FROM books INNER JOIN bookinventory ON  books.bookid = bookinventory.bookid WHERE books.bookid = " . $_SESSION["id"];
    $result = mysqli_query($dbc, $joinQuery);
    $rows = mysqli_fetch_assoc($result);
    $_SESSION['price'] = $rows['price'];

    if ($rows['stock'] <= 0) {
        $stock = "<h4 class='text-danger'><i class='fa-solid fa-circle-exclamation'></i> Out of stock </h5>";
        $stockcounter = "";
        $button = "<button type='submit' class='btn btn-lg btn-primary mt-5' disabled='disabled'>Buy Now</button>";
    } else if ($rows['stock'] <= 10) {
        $stock = "<h4 class='text-warning'><i class='fa-solid fa-circle-exclamation'></i> Low on stock </h4>";
        $stockcounter = "<h4 class='text-danger'> Only {$rows['stock']} in stock. </h4>";
        $button = "<button type='submit' class='btn btn-lg btn-primary mt-5' style='background-color: #343a40;'>Buy Now</button>";
    } else {
        $stock = "<h4 class='text-success'><i class='fa-solid fa-circle-check fa-sm'></i> Available </h4>";
        $stockcounter = "<h4 class='text-danger'>  {$rows['stock']} in stock. </h4>";
        $button = "<button type='submit' class='btn btn-lg btn-primary mt-5'>Buy Now</button>";
    }
    echo "<div class='breadcrumbs'>
                <ol class='items' style='list-style: none; margin-top:10px;'>
                    <li class='breadcrumb-item' style='font-size: 20px;'>
                        <a href='store.php'>Store</a>
                        <strong class='breadcrumb-item'> / {$rows['booktitle']}</strong>
                    </li>
                </ol>
            </div>";

    echo "<form action='checkout.php' method='POST'>
            <div class='row'>
                <div class='col-4 mt-5 ml-5 mb-5'>
                    <div class='profile-img'>
                        <img src='image/{$rows['coverimage']}' alt='Book image' style='width:90%; height:500px; background: linear-gradient(90deg, rgba(222,192,169,0.7878501742493873) 0%, rgba(117,117,186,1) 35%, rgba(96,169,183,1) 100%);'/>
                    </div>
                </div>
                <div class='col-6 mt-5 ml-5'>
                    <span>
                        <ul class='pl-0' style='list-style-type: none;'>
                            <li>
                                <h1>{$rows['booktitle']}</h1>
                            </li>
                            <li>
                                <h4><span style='color:black;'>Written by:</span> {$rows['author']}</h4>
                            </li>
                            <li>
                                <h4><span style='color:black;'>Publisher:</span> {$rows['publisher']}</h4>
                            </li>
                            <li>
                                <h4><span style='color:black;'>Edition:</span> {$rows['edition']}</h4>
                            </li>
                            <li>
                                <h4><span style='color:black;'>Published on:</span> {$rows['publishdate']}</h4>
                            </li>
                            <li>
                                <h4><span style='color:black;'>Category:</span> {$rows['category']}</h4>
                            </li>
                            <li>
                                <h4><span style='color:black;'>Description:</span> {$rows['description']}</h4>
                            </li>
                            <li>
                                <h2 class='text-primary'>$ {$rows['price']}</h2>
                            </li>
                            <li>
                                $stock
                            </li>
                            <li>
                                $stockcounter
                            </li>
                            <li>
                                <h4>Quantity</h4>
                                <select class='dropdown' name='qty'>
                                    <option value='1'>1</option>
                                    <option value='2'>2</option>
                                    <option value='3'>3</option>
                                    <option value='4'>4</option>
                                    <option value='5'>5</option>
                                </select>
                            </li>
                            <li>
                                $button
                            </li>
                        </ul>
                    <span>
                </div>
            </div>
        </form>";
    ?>

<div class="text-center"  style="background-color: #343a40; padding: 1em 0px;">
    <h1 class="credit" style="color: white;"> <span> OnlineBookHub | Shreya Soni |Copyright &copy; 2022 | all rights reserved! </span> </h1>
    </div>
</body>

</html>