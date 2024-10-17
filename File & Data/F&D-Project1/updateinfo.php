<?php
// Validate form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Gather form data and trim to remove any unnecessary spaces
    $firstName = trim($_POST['firstName']);
    $lastName = trim($_POST['lastName']);
    $phone = trim($_POST['phone']);
    $email = trim($_POST['email']);

    // Initialize an empty array to store error messages
    $errors = [];

    // Validate: No field should be blank
    if (empty($firstName) || empty($lastName) || empty($phone) || empty($email)) {
        $errors[] = "All fields are required.";
    }

    // Validate: First and last name max length 20 characters
    if (strlen($firstName) > 20) {
        $errors[] = "First name must not exceed 20 characters.";
    }
    if (strlen($lastName) > 20) {
        $errors[] = "Last name must not exceed 20 characters.";
    }

    // Validate: Email max length 30 characters
    if (strlen($email) > 30) {
        $errors[] = "Email must not exceed 30 characters.";
    }

    // Validate: First and last name should only contain letters
    if (!preg_match("/^[a-zA-Z]+$/", $firstName)) {
        $errors[] = "First name should only contain alphabetical characters.";
    }
    if (!preg_match("/^[a-zA-Z]+$/", $lastName)) {
        $errors[] = "Last name should only contain alphabetical characters.";
    }

    // Validate: Phone number format xxx-xxx-xxxx
    if (!preg_match("/^\d{3}-\d{3}-\d{4}$/", $phone)) {
        $errors[] = "Phone number must be in the format xxx-xxx-xxxx.";
    }

    // Validate: Email format lettersAndNumbers@lettersOnly.com or .edu
    if (!preg_match("/^[a-zA-Z0-9]+@[a-zA-Z]+\.(com|edu)$/", $email)) {
        $errors[] = "Email must follow the format lettersAndNumbers@lettersOnly.com or .edu.";
    }

    // If errors are found, display them
    if (!empty($errors)) {
        // Display each error
        foreach ($errors as $error) {
            echo "<p>$error</p>";
        }
        // Provide link back to the form
        echo "<p><a href='userInfo.html'>Go back to the form</a></p>";
        exit; // Stop further execution if there are errors
    }

    // If no errors, process and save the data
    $filename = 'userInfo.txt';
    $fileData = [];
    
    // Check if the file exists before processing
    if (file_exists($filename)) {
        $file = fopen($filename, 'r');
        
        // Loop through each line in the file
        while (($line = fgets($file)) !== false) {
            $lineData = explode(':', trim($line));
    
            // Ensure the line has exactly 4 parts (LastName, FirstName, PhoneNumber, EmailAddress)
            if (count($lineData) === 4) {
                $fileData[$lineData[0]] = $lineData; // Use LastName as the key
            }
        }
        fclose($file);
    }

    // Add new user data
    $fileData[$lastName] = [$lastName, $firstName, $phone, $email];

    // Sort data by Last Name
    ksort($fileData);

    // Write sorted data back to the file
    $file = fopen($filename, 'w');
    foreach ($fileData as $entry) {
        fputcsv($file, $entry, ':'); // Use ':' as delimiter
    }
    fclose($file);

    // Display the sorted data in an HTML table
    echo "<h2>Submitted User Data</h2>";
    echo "<table border='1'>";
    echo "<tr><th>Last Name</th><th>First Name</th><th>Phone</th><th>Email</th></tr>";

    foreach ($fileData as $entry) {
        echo "<tr>";
        echo "<td>{$entry[0]}</td>";
        echo "<td>{$entry[1]}</td>";
        echo "<td>{$entry[2]}</td>";
        echo "<td>{$entry[3]}</td>";
        echo "</tr>";
    }

    echo "</table>";

    // Provide a link back to the form
    echo "<p><a href='userInfo.html'>Submit another entry</a></p>";
}
?>
