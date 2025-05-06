<?php
$conn = mysqli_connect("localhost", "root", "", "booking_hotel") or die("Connection failed: " . mysqli_connect_error());
$db = mysqli_select_db($conn, "booking_hotel") or die("Database selection failed: " . mysqli_error($con));
