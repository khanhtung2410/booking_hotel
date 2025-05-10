<?php
$conn = mysqli_connect("localhost", "root", "", "hotel_booking") or die("Connection failed: " . mysqli_connect_error());
$db = mysqli_select_db($conn, "hotel_booking") or die("Database selection failed: " . mysqli_error($con));
