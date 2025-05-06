<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<?php
include "db_connect.php";

// Fetch hotels from the database
$sql = "SELECT id, name, address, description, rating FROM hotels";
$result = mysqli_query($conn, $sql)
?>

<body>
    <h1>Hotels List</h1>
    <table border="1">
        <thead>
            <tr>
                <th>Name</th>
                <th>Address</th>
                <th>Description</th>
                <th>Rating</th>
                <th>Details</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['name']); ?></td>
                    <td><?php echo htmlspecialchars($row['address']); ?></td>
                    <td><?php echo htmlspecialchars($row['description']); ?></td>
                    <td><?php echo htmlspecialchars($row['rating']); ?></td>
                    <td><a href="hotel_details.php?hotel_id=<?php echo $row['id']; ?>">View Details</a></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</body>

</html>