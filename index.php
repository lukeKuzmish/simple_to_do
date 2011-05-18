<!DOCTYPE html>
<?php

    function generateError($error) {
        die("SQL error -- " . $error);
    }
    
    require_once("dbconnect.php");
    $newItem = $_POST["newItem"];
    
    
    if (isset($_POST['submit'])) {
        // add new entry to DB
        $myConnection = mysqli_connect($dbHostname, $dbUser, $dbPwd, $dbName) or generateError(mysqli_error($myConnection));
        
        $sql = "INSERT INTO `$dbTable` (item, time) VALUES ('{$newItem}', NOW())";
        
        if (!(mysqli_query($myConnection, $sql))) {
            generateError(mysqli_error($myConnection));
        }
        
    }
    
    mysqli_close($myConnection);
?>


    <head>
        <title>Simple To Do (STD)</title>
    
    <style>
        body {
            background:     #f0f0a1;
            font:           Arial, sans serif;    
       }
       
       #wrapper {
            width:          600px;
            margin:         0 auto;
        }
       
       #wrapper h1 {
            text-align:     center;
        }
        
        #list-of-items {
            margin:         0 auto;
            width:          500px;
        }
        
        #toDoItem {
            width:          350px;
        }
        
        #toDoTime {
            width:          100px;
        }
        
        #toDoCompleted {
            width:          50px;
        }
        
        td, th {
            padding:        10px;
        }
    </style>
    </head>
    
    <body>
        <div id="wrapper">
            <div id="header">
                <h1>Simple To Do (STD)</h1>
            </div>
            <hr />
            <div id="list-of-items">
            
                <table>
                    <colgroup>
                        <col id="toDoItem" />
                        <col id="toDoTime" />
                        <col id="toDoCompleted" />
                    </colgroup>
                    <thead>
                        <tr>
                            <th scope="col">To-Do</th>
                            <th scope="col">time entered</th>
                            <th scope="col">completed?</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                        require_once('dbconnect.php');
                        $myConnection = mysqli_connect($dbHostname, $dbUser, $dbPwd, $dbName) or generateError(mysqli_error($myConnection));
                        
                        $select = "SELECT * FROM `$dbTable` WHERE completed='0' ORDER BY id ASC";
                        
                        $dbResult = mysqli_query($myConnection, $select) or generateError(mysqli_error($myConnection));
                        
                        while ($row=mysqli_fetch_assoc($dbResult)) {
                            echo "<tr><td>{$row['item']}</td><td>{$row['time']}</td><td>{$row['completed']}</td></tr>";
                        }
                         
                        mysqli_close($myConnection);                   
                    ?>
                    </tbody>
                </table>
                    
            </div>
            <hr />
            <div id="add">
                <form method="post" action="<?php echo $PHP_SELF;?>">
                
                <textarea rows="10" cols="65" name="newItem"></textarea>
                
                <input type="submit" value="Submit" name="submit" /> 
                </form>
                
            </div>
            
            <div id="footer">
                <!-- put footer/credits here -->
                
            </div>
            
        </div>
        
    </body>
    
</html>
