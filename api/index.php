
<?php
header("Content-Type: application/json");

// Define the endpoint to communicate with search.php
$searchURL = "http://localhost/projectTest/website/api/search1.php"; // Replace with your actual domain and path

// Check if it's a GET request to /search endpoint
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['q'])) {
    // Get the query parameter from the GET request
    $query = $_GET['q'];

    // Create cURL request to communicate with search.php
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $searchURL . "?q=" . urlencode($query));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    curl_close($ch);

    // Return the response from search.php as the API response
    echo $response;
} else {
    // Handle other HTTP methods or invalid requests
    http_response_code(405); // Method Not Allowed
    echo json_encode(array("message" => "Method Not Allowed"));
}
?>