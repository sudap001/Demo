
<?php
// Retrieve the query parameter from the API request
$query = $_GET['query'] ?? '';
$key=$_GET['key']?? '';
$range=$_GET['range'];

$servername = "localhost";
$username = "sudap001";
$password = "WebProjectUser";
$database = "librarymanagment";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$searchResults = "Search results for: " . $query;

require 'vendor/autoload.php';

use Elasticsearch\ClientBuilder;

$hosts = ['localhost:9200'];
$client = ClientBuilder::create()->setHosts($hosts)->build();



$sql = "SELECT * FROM signupuser WHERE apikey='$key'";
$result = $conn->query($sql);
if ($result->num_rows > 0){


        $index = 'bookdetails';


$index = 'bookdetails';


// Search for documents
$params = [
    'index' => $index,
    'body' => [
        'query' => [
            'bool' => [
                'should' => [
                    ['match' => ['title' => $query]],
                    ['match' => ['author' => $query]],
                    ['match' => ['year' => $query]],
                    ['match' => ['degree' => $query]],
                    ['match' => ['advisor' => $query]],
                    ['match' => ['program' =>$query]],
                    ['match' => ['university' =>$query]],

                ],
               
                   
            ],
        ],
    ],
    // 'from' => $from,
    'size' => $range,
];

    $response = $client->search($params);

     


echo json_encode(array("results" => $response));
}
else{
    echo "wrong API key";
}
?>

