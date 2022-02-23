<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <style>
        body {
            padding: 20px;
        }
    </style>
</head>
<body>

<script>
    function showForm() {
        var x = document.getElementById("form-wrapper");
        if (x.style.display == "none") {
            x.style.display = "block";
        } else {
            x.style.display = "none";
        }
    }
</script>

<div id="form-wrapper" style="display: none;">

<!--Skapa kontroll av inlog och visa isf nedanstående form-->
<?php
    // unset($_SESSION["logged_in"]);
    if(isset($_SESSION["logged_in"]) && $_SESSION["logged_in"] == true) {
        $user = $_SESSION['user'];
        echo "Inloggad som $user";

        echo '<script type="text/javascript">',
            'showForm();',
            '</script>';
    }
    else {
        echo "Not logged in<br>";
        echo "<a href='login.php'>
            <button>Back to log in</button>
            </a>";
    }
?>
    <form action="addtopicconfirmation.php" method="post">
        Rubrik
        <br>
        <input type="text" name="header">
        <br>
        Inlägg
        <br>
        <textarea name="content" cols="50" rows="10"></textarea>
        <br>
        Meddela mig via email vid nya inlägg:
        <input type="checkbox" name="subscribe" value="ok" checked>
        <br>
        <input type="submit" name="submit" value="Publicera">
    </form>
</div>

</body>
</html>