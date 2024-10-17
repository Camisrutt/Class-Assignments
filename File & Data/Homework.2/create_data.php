<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Data - Dark Theme</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #1e1e1e; /* Dark background */
            color: #f8f8f8; /* Light text */
        }
        .array-table {
            width: 100%;
            display: table;
            margin-bottom: 20px;
        }
        .array-column {
            display: table-cell;
            vertical-align: top;
            padding: 10px;
        }
        .array-column h3 {
            text-align: center;
            color: #ADD8E6; /* Bold orange for headings */
            font-weight: bold;
            margin-bottom: 10px;
            border-bottom: 2px solid #ADD8E6; /* Accent underlines */
            padding-bottom: 5px;
        }
        pre {
            background-color: #333333; /* Darker gray for arrays */
            border: 1px solid #ADD8E6; /* Accent border */
            padding: 10px;
            white-space: pre-wrap;
            word-wrap: break-word;
            color: #fff; /* White text */
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table, th, td {
            border: 3px solid #ADD8E6; /* Bold blue */
        }
        th, td {
            padding: 12px;
            text-align: left;
        }
        th {
            background-color: #333333; /* Darker gray for table header */
            color: #f8f8f8;
            font-weight: bold;
        }
        td {
            background-color: #444444; /* Dark gray for table cells */
        }
    </style>
</head>
<body>

<?php
// Combined function to read a file into an array, split based on delimiters, handle newlines, and filter out empty elements
function read_file_to_array($filename, $delimiter = "\n") {
    if (!file_exists($filename)) {
        die("File not found: $filename");
    }

    $content = file_get_contents($filename);
    if ($content === false) {
        die("Error reading file: $filename");
    }

    // Split content based on Unix and Windows newlines
    $lines = preg_split('/\r\n|\r|\n/', $content);

    // If a custom delimiter is provided, further split based on it
    if ($delimiter !== "\n") {
        $lines = array_map(function($line) use ($delimiter) {
            return explode($delimiter, $line);
        }, $lines);

        // Flatten the resulting array if delimiter-based splitting creates nested arrays
        $lines = array_merge(...$lines);
    }

    // Trim each line and filter out empty elements
    $lines = array_map('trim', $lines);

    return array_filter($lines, function($value) {
        return !empty($value);
    });
}

// Function to process domain data
function process_domains($filename) {
    $content = file_get_contents($filename);
    if ($content === false) {
        die("Error reading file: $filename");
    }

    // Use regex to split based on domains, keeping domain parts together
    $domains = preg_split('/(?<=\.com|\.edu|\.net|\.org|\.gov|\.io|\.us)(?=\.)/', $content);

    // Clean up and format the domains
    $domains = array_map(function($domain) {
        // Remove leading dot if present
        $domain = ltrim($domain, '.');
        return implode('.', array_map('trim', explode('.', $domain)));
    }, $domains);

    // Remove empty elements if any
    return array_filter($domains);
}

// Read data from files into arrays
$domains = process_domains('domains.txt'); // Process domains based on the given format
$first_names = read_file_to_array('first_names.csv', ','); // First names are comma-separated
$last_names = read_file_to_array('last_names.txt'); // Each last name on a new line
$street_names = read_file_to_array('street_names.txt', ':'); // Street names are colon-separated
$street_types = read_file_to_array('street_types.txt', '..;'); // Street types are separated by '..;'

// Display arrays side by side in a table layout
echo "<div class='array-table'>";
echo "<div class='array-column'><strong>First Names</strong><pre>" . print_r($first_names, true) . "</pre></div>";
echo "<div class='array-column'><strong>Last Names</strong><pre>" . print_r($last_names, true) . "</pre></div>";
echo "<div class='array-column'><strong>Domain</strong><pre>" . print_r($domains, true) . "</pre></div>";
echo "<div class='array-column'><strong>Street Names</strong><pre>" . print_r($street_names, true) . "</pre></div>";
echo "<div class='array-column'><strong>Street Types</strong><pre>" . print_r($street_types, true) . "</pre></div>";
echo "</div>";

// Generate 25 unique customers
$customers = [];
while (count($customers) < 25) {
    $first_name = $first_names[array_rand($first_names)];
    $last_name = $last_names[array_rand($last_names)];
    $email = strtolower($first_name . '.' . $last_name . '@' . $domains[array_rand($domains)]);
    
    $street_name = $street_names[array_rand($street_names)];
    $street_type = $street_types[array_rand($street_types)];
    $address = $street_name . ' ' . $street_type;

    // Ensure uniqueness of emails and addresses
    if (!isset($customers[$email]) && !in_array($address, array_column($customers, 'address'))) {
        $customers[$email] = [
            'first_name' => $first_name,
            'last_name' => $last_name,
            'email' => $email,
            'address' => $address
        ];
    }
}

// Display customer data in an HTML table
echo "<table>";
echo "<tr><th>First Name</th><th>Last Name</th><th>Email</th><th>Address</th></tr>";
foreach ($customers as $customer) {
    echo "<tr><td>{$customer['first_name']}</td><td>{$customer['last_name']}</td><td>{$customer['email']}</td><td>{$customer['address']}</td></tr>";
}
echo "</table>";

// Write customer data to customers.txt
$file = fopen('customers.txt', 'w');
foreach ($customers as $customer) {
    $address = str_replace(["\n", "\r"], " ", $customer['address']);
    $line = implode(':', [$customer['first_name'] . ':' . $customer['last_name'], $address, $customer['email']]) . "\n";
    fwrite($file, $line);
}
fclose($file);
?>

</body>
</html>
