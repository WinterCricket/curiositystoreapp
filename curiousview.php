<!DOCTYPE html>
<html lang="en">
<head>
        <meta charset="UTF-8">
        <style>
                .tableColor {
                        background-color: black;
                        color: white;
                }
        </style>

        <title >View Records</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
</head>
<body>
        
        <h1>View Records</h1>
        
        <p><b>View All</b> | <a href="curiouspaginated.php">View Paginated</a></p>
        
        <?php
                        // connect to the database
        include('curiousconnect-db.php');
        
                        // get the records from the database
        if ($result = $mysqli->query("SELECT * FROM products ORDER BY id"))
        {
                                // display records if there are records to display
                if ($result->num_rows > 0)
                {
                                        // display records in a table
                        echo "<table border='1' cellpadding='10'>";
                        
                                        // set table headers
                        echo "<tr> <th>ID</th> <th>Name</th> <th>Description</th> <th>Price</th> <th></th> <th></th> </tr>";
                        
                        while ($row = $result->fetch_object())
                        {
                                                // set up a row for each record
                                echo "<tr>";
                                echo "<td >" . $row->id . "</td>";
                                echo "<td>" . $row->name . "</td>";
                                echo "<td >" . $row->description . "</td>";
                                echo "<td class='tableColor'>" . $row->price . "</td>";
                                echo "<td><a href='curiousrecords.php?id=" . $row->id . "'>Edit</a></td>";
                                echo "<td><a href='curiousdelete.php?id=" . $row->id . "'>Delete</a></td>";
                                echo "</tr>";
                        }
                        
                        echo "</table>";
                }
                                // if there are no records in the database, display an alert message
                else
                {
                        echo "No results to display!";
                }
        }
                        // show an error if there is an issue with the database query
        else
        {
                echo "Error: " . $mysqli->error;
        }
        
                        // close database connection
        $mysqli->close();
        
        ?>
        
        <a href="curiousrecords.php">Add New Record</a>
</body>
</html>