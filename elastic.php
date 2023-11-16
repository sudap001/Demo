<?php

require 'vendor/autoload.php';

use Elasticsearch\ClientBuilder;
use League\Csv\Reader;

// Elasticsearch connection settings
$hosts = [
    'localhost:9200', // Change this to your Elasticsearch server address
];

$client = ClientBuilder::create()->setHosts($hosts)->build();

// Indexing settings
$index = 'bookdetails'; // Replace with your desired index name
$type = '_doc';

// CSV file path
$csvFilePath = '/home/sudap001/Downloads/metadata_abstract.csv'; // Replace with the actual path to your CSV file

// Read CSV file
$csv = Reader::createFromPath($csvFilePath, 'r');
$csv->setHeaderOffset(0); // Assuming the first row contains headers

// Get headers
$headers = $csv->getHeader();

// Index data into Elasticsearch
foreach ($csv as $record) {
    $document = [];
    foreach ($headers as $header) {
        $document[$header] = $record[$header];
    }

    // Index document
    $params = [
        'index' => $index,
        'type' => $type,
        'body' => $document,
    ];

    $client->index($params);
}

echo 'CSV data sent to Elasticsearch successfully.';

?>
