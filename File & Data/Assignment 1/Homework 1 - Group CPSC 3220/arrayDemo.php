<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Array Demo Results</title>
</head>
<body>
    <h2>Array Demo Results</h2>

    <?php
    // Check if form data was posted
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Get form data
        $rows = intval($_POST['rows']);
        $columns = intval($_POST['columns']);
        $min = intval($_POST['min']);
        $max = intval($_POST['max']);


        // Check for valid inputs
        if ($min >= $max) {
            echo "<p style='color:red;'>Invalid range: Minimum value should be less than maximum value.</p>";
            echo "<a href='arrayDemo.html'>Go Back</a>";
            exit();
        }

        // Create the 2D array
        $array = array();
        for ($i = 0; $i < $rows; $i++) {
            $array[$i] = array();
            for ($j = 0; $j < $columns; $j++) {
                $array[$i][$j] = rand($min, $max);
            }
        }

        // Print the original array in a table
        echo "<h3>Original Array</h3>";
        echo "<table border='1' cellpadding='5' cellspacing='0'>";
        for ($i = 0; $i < $rows; $i++) {
            echo "<tr>";
            for ($j = 0; $j < $columns; $j++) {
                echo "<td>" . $array[$i][$j] . "</td>";
            }
            echo "</tr>";
        }
        echo "</table><br>";

        // Process the data to compute sum, average, and standard deviation
        echo "<h3>Row Summary (Sum, Average, Standard Deviation)</h3>";
        echo "<table border='1' cellpadding='5' cellspacing='0'>";
        echo "<tr><th>Row</th><th>Sum</th><th>Average</th><th>Standard Deviation</th></tr>";

        for ($i = 0; $i < $rows; $i++) {
            $sum = array_sum($array[$i]);
            $avg = $sum / $columns;
            $std_dev = standard_deviation($array[$i]);

            echo "<tr>";
            echo "<td>" . ($i + 1) . "</td>";
            echo "<td>" . $sum . "</td>";
            echo "<td>" . number_format($avg, 3) . "</td>";
            echo "<td>" . number_format($std_dev, 3) . "</td>";
            echo "</tr>";
        }
        echo "</table><br>";

        // Process data to display values and whether they are positive/negative/zero
        echo "<h3>Array Analysis (Positive/Negative/Zero)</h3>";
        echo "<table border='1' cellpadding='5' cellspacing='0'>";
        for ($i = 0; $i < $rows; $i++) {
            echo "<tr>";
            for ($j = 0; $j < $columns; $j++) {
                echo "<td>" . $array[$i][$j] . "</td>";
            }
            echo "</tr>";
            echo "<tr>";
            for ($j = 0; $j < $columns; $j++) {
                if ($array[$i][$j] > 0) {
                    echo "<td>positive</td>";
                } elseif ($array[$i][$j] < 0) {
                    echo "<td>negative</td>";
                } else {
                    echo "<td>zero</td>";
                }
            }
            echo "</tr>";
        }
        echo "</table><br>";

        // Link back to arrayDemo.html
        echo "<a href='arrayDemo.html'>Go Back</a>";
    } else {
        echo "<p>No form data submitted.</p>";
        echo "<a href='arrayDemo.html'>Go Back</a>";
    }

    // Function to calculate standard deviation
    function standard_deviation($array) {
        $mean = array_sum($array) / count($array);
        $sum_square_diff = 0;
        foreach ($array as $value) {
            $sum_square_diff += pow($value - $mean, 2);
        }
        return sqrt($sum_square_diff / count($array));
    }
    ?>

</body>
</html>