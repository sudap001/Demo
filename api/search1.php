<?php
// Retrieve the query parameter from the API request
$query = $_GET['q'] ?? '';
// $range=$_GET['range']?? '';

// Perform some search operations based on the received query (replace this with your actual search logic)
// This is just a placeholder example:
$searchResults = "Search results for: " . $query;

require 'vendor/autoload.php';

use Elasticsearch\ClientBuilder;



$hosts = ['localhost:9200'];
$client = ClientBuilder::create()->setHosts($hosts)->build();

   

        //$index = 'bookdetails';

// Search for documents
// Specify the index
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
                    // ['match' => ['text' => $search]],
                    
                    // Add more fields as needed
                ],
            ],
        ],
    ],
// ];
    // 'size' => $range,
];

    $response = $client->search($params);

     


// Return the search results as a JSON response
echo json_encode(array("results" => $response));
?>