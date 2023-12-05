<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload PDF to Elasticsearch</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 800px;
            margin: 20px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        label {
            display: block;
            margin-bottom: 8px;
        }
        input, textarea {
            width: 100%;
            padding: 8px;
            margin-bottom: 12px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
        button {
            background-color: #4caf50;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <form action="selectpdf.php" method="post" enctype="multipart/form-data">
        <label for="pdfFile">Select PDF File:</label>
        <input type="file" name="pdfFile" id="pdfFile" accept=".pdf" required>
        <br>
        <button type="submit">Upload PDF</button>
    </form>
</body>
</html>
<?php

require 'vendor/autoload.php'; // Include the Elasticsearch PHP client

use Elasticsearch\ClientBuilder;


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the file was uploaded without errors
    if (isset($_FILES["pdfFile"]) && $_FILES["pdfFile"]["error"] == 0) {
        $pdfFilePath = $_FILES["pdfFile"]["tmp_name"];
        $pdfFileName = $_FILES["pdfFile"]["name"];

        // Index the PDF into Elasticsearch
        indexToElasticsearch($pdfFilePath, $pdfFileName);

        echo "PDF successfully uploaded and indexed.";
    } else {
        echo "Error uploading the file.";
    }
}

function indexToElasticsearch($pdfFilePath, $pdfFileName) {
    // Elasticsearch connection settings
    $hosts = [
        'localhost:9200', // Change this to your Elasticsearch server address
    ];

    $client = ClientBuilder::create()->setHosts($hosts)->build();

    // Indexing settings
    $index = 'bookdetails'; // Replace with your desired index name
    $countParams = [
        'index' => $index,
        // 'type' => $type,
        'body' => [
            'query' => [
                'match_all' => (object) [],
            ],
        ],
    ];

    $countres=$client->count($countParams);
    $total=$countres['count'];
    $pdfContent = file_get_contents($pdfFilePath);

    // Index document with PDF content
    $params = [
        'index' => $index,
        'id'=>$total,
        'body' => [
            'file_name' => $pdfFileName,    
            'pdf_content' => base64_encode($pdfContent),
        ],
    ];

    $response = $client->index($params);
    header("Location:addbook.php");
}




?>