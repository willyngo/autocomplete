<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Autocomplete</title>
        <script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
        <script src="autocomplete.js"></script>
        <link rel="stylesheet" type="text/css" href="styles.css">
    </head>
    <body>
        <?php
        session_start();
        session_regenerate_id();
        include('dbUtility.php');
        
        if(!isset($_SESSION['username'])) {
            header('location: loginPage.php');
            exit;
        }
        
        ?>
        <h1 id="title">Auto Completion - Index <?php echo " : Welcome ".$_SESSION['username']; ?></h1>            
        <form id="searchForm" action="" method="post">
            <input list="history" name="searchBar" placeholder="Search" id="searchBar"/>
            <datalist id="history">
            </datalist>
            <input type="submit" name="add" value="Submit"/>
            <input type="submit" name="logout" value="Logout"/>
        </form>
        
        <?php
        //When user submits his entry
        if(isset($_POST['add'])){
            //Check if it's a valid city
            if(isValidCity($_POST['searchBar'])){
                addToHistory($_SESSION['username'], $_POST['searchBar']);
            }
            else{
                echo "Not a valid city!";
            }
        }
        //Logout
        if (isset($_POST['logout'])) {
            unset($_SESSION['username']);
            header('location: index.php');
            exit;
        }
        ?>
    </body>
</html>
