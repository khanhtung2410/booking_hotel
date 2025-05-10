<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<?php
include "db_connect.php";

$room_id = isset($_POST['room_id']) ? intval($_POST['room_id']) : 0;
$hotel_id = isset($_POST['hotel_id']) ? intval($_POST['hotel_id']) : 0;
$checkin = isset($_POST['checkin']) ? $_POST['checkin'] : null;
$checkout = isset($_POST['checkout']) ? $_POST['checkout'] : null;
$people = isset($_POST['people']) ? intval($_POST['people']) : 1;


$sql = "SELECT rooms.*, rooms.name AS roomName, hotels.name AS hotelName, hotels.address 
FROM rooms 
LEFT JOIN hotels ON rooms.hotel_id = hotels.id 
WHERE rooms.id = ? AND rooms.hotel_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $room_id,  $hotel_id);
$stmt->execute();
$result = $stmt->get_result();

?>

<body>
    <div style="font-family: Arial, sans-serif; max-width: 600px; margin: auto; border: 1px solid #ccc; padding: 20px;">
        <h2 style="text-align: center;">Booking Receipt</h2>
        <?php if ($result && mysqli_num_rows($result) > 0): ?>
            <?php $row = mysqli_fetch_assoc($result); ?>
            <table style="width: 100%; border-collapse: collapse;">
                <tr>
                    <td style="padding: 8px; border: 1px solid #ddd; font-weight: bold;">Room Name:</td>
                    <td style="padding: 8px; border: 1px solid #ddd;"><?php echo htmlspecialchars($row['roomName']); ?></td>
                </tr>
                <tr>
                    <td style="padding: 8px; border: 1px solid #ddd; font-weight: bold;">Hotel Name:</td>
                    <td style="padding: 8px; border: 1px solid #ddd;"><?php echo htmlspecialchars($row['hotelName']); ?></td>
                </tr>
                <tr>
                    <td style="padding: 8px; border: 1px solid #ddd; font-weight: bold;">Hotel Address:</td>
                    <td style="padding: 8px; border: 1px solid #ddd;"><?php echo htmlspecialchars($row['address']); ?></td>
                </tr>
                <tr>
                    <td style="padding: 8px; border: 1px solid #ddd; font-weight: bold;">Check-in:</td>
                    <td style="padding: 8px; border: 1px solid #ddd;"><?php echo htmlspecialchars($checkin); ?></td>
                </tr>
                <tr>
                    <td style="padding: 8px; border: 1px solid #ddd; font-weight: bold;">Check-out:</td>
                    <td style="padding: 8px; border: 1px solid #ddd;"><?php echo htmlspecialchars($checkout); ?></td>
                </tr>
                <tr>
                    <td style="padding: 8px; border: 1px solid #ddd; font-weight: bold;">Price:</td>
                    <td style="padding: 8px; border: 1px solid #ddd;"><?php echo htmlspecialchars($row['price']); ?>Vnđ</td>
                </tr>
                <tr>
                    <td style="padding: 8px; border: 1px solid #ddd; font-weight: bold;">People:</td>
                    <td style="padding: 8px; border: 1px solid #ddd;"><?php echo htmlspecialchars($people); ?></td>
                </tr>
            </table>
        <?php else: ?>
            <p style="text-align: center; color: red;">No room details found.</p>
        <?php endif; ?>
    </div>
</body>

</html>