<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Autocomplete</title>
        <script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
        <script src="autocomplete.js"></script>
    </head>
    <body>
    <body>
        <?php
        session_start();
        session_regenerate_id();
        if(!isset($_SESSION['username'])){
            header('location: loginPage.php');
            exit;
        }
        ?>
        <h1 id="title">Auto Completion - Index <?php echo " : Welcome ".$_SESSION['username'];?></h1>
        <div id="formWrapper">
            <form id="searchForm" action="" method="get">
                <p>Search: <input type="text" name="search"> </p>
                <input type="submit" name="add" value="Submit"/>
                <input type="submit" name="logout" value="logout"/>
            </form>
        </div>
        <?php
        
        
        //Logout
        if(isset($_GET['logout']))
        {
            unset($_SESSION['username']);
            header('location: index.php');
            exit;
        }
        
        ?>
    </body>
</body>
</html>
