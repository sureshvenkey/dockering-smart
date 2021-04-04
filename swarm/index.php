<html>
<head>
<title>Docker PHP App</title>

<?php
if($_SERVER['REQUEST_METHOD'] == "POST")
{
$servername = "mysql";
$username = "root";
$password = "mysql";
$dbname = "phonedb";
$name=$_POST["name"];
$phone=$_POST["phone"];

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "INSERT INTO emp (name, phone) VALUES ('".$name."', '".$phone."')";

if ($conn->query($sql) === TRUE) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

echo "<h1>Records in Database</h1>";
$result = mysqli_query($conn,"SELECT * FROM emp");
echo "<table border='1'> <tr> <th>Name</th> <th>Phone Number</th> </tr>";
while($row = mysqli_fetch_array($result))
{
echo "<tr>";
echo "<td>" . $row['name'] . "</td>";
echo "<td>" . $row['phone'] . "</td>";
echo "</tr>";
}
echo "</table>";


$conn->close();
}
?>
</head>
<body>
<H1> Welcome to Phone Number Database Page </H1>
        <form action="index.php" method="POST">
                <label for="name">Enter the Name:</label>
                <input type="text" name="name" id="name"><br><br>
                <label for="phone">Enter the Phone Number:</label>
                <input type="number" name="phone"><br><br>
                <label for="phone">Click Submit to view the records in database</label>
                <input type="submit" name="submit">
        </form>
</body>
</html>
