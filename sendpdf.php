<?php

require 'vendor/autoload.php';

use Elasticsearch\ClientBuilder;

// Create Elasticsearch client
$hosts = ['localhost:9200'];
$client = ClientBuilder::create()->setHosts($hosts)->build();

// Function to index a PDF file in Elasticsearch
function indexPdf($filePath)
{
    global $client;

    // Get the filename without extension
    $fileName = pathinfo($filePath, PATHINFO_FILENAME);

    // Read the content of the PDF file
    $content = base64_encode(file_get_contents($filePath));

    // Index data in Elasticsearch
    $indexParams = [
        'index' => 'bookdetails', 
        'id' => $fileName, 
        'body' => [
            'pdf_content' => $content,
        ],
    ];

    $client->index($indexParams);
}

// Specify the directory path containing PDF files
$pdfDirectory = '/var/www/html/projectTest/website/pdf'; // Replace with the actual directory path

// Iterate through PDF files in the directory
$pdfFiles = glob($pdfDirectory . '/*.pdf');
foreach ($pdfFiles as $pdfFile) {
    // Index each PDF file
    indexPdf($pdfFile);
}

echo "PDF files indexed in Elasticsearch.";

?>
