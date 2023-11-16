<?php

require 'vendor/autoload.php';

use Elasticsearch\ClientBuilder;

// Create Elasticsearch client
$hosts = ['localhost:9200'];
$client = ClientBuilder::create()->setHosts($hosts)->build();
$bookid=$_POST['bookid'];

// Function to retrieve PDF content from Elasticsearch
function getPDFContent($documentId)
{
    global $client;

    // Specify the index
    $index = 'bookdetails'; // Replace with the actual index name

    // Get PDF content from Elasticsearch
    $params = [
        'index' => $index,
        'id' => $documentId,
    ];

    $response = $client->get($params);

    if (isset($response['_source']['pdf_content'])) {
        return base64_decode($response['_source']['pdf_content']);
    } else {
        return null;
    }
}

// Example usage
$documentId = $bookid; // Replace with the actual document ID
$pdfContent = getPDFContent($documentId);

// If PDF content is retrieved, send it to the browser
if ($pdfContent !== null) {
    // Set headers for PDF download
    header('Content-Type: application/pdf');
    header('Content-Disposition: attachment; filename="downloaded_file.pdf"');

    // Output the PDF content
    echo $pdfContent;
} else {
    echo 'PDF document not found.';
}
