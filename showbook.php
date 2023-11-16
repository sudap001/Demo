<?php

if(isset($_POST['showbook'])){
    $bookid=$_POST['bookid'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 20px;
            background-image:url("photo.png");
        }

        .thesis-container {
            max-width: 800px;
            margin: auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            color: #333;
        }

        .thesis-info {
            margin-bottom: 20px;
        }

        .abstract {
            margin-top: 20px;
        }
    </style>
    <title>Book Information</title>
</head>
<body>

<div class="thesis-container">
    <h2>Book Information</h2>

    <?php
require 'vendor/autoload.php';

use Elasticsearch\ClientBuilder;

// $client=ClientBuilder::create()->build();
// echo "ES client has been created.<br>";

$hosts = ['localhost:9200'];
$client = ClientBuilder::create()->setHosts($hosts)->build();

// Index data
$index = 'bookdetails';

// Search for documents
$params = [
    'index' => $index,
    'body' => [
        'query' => [
            'match' => [
                'etd_file_id' =>$bookid,
            ],
        ],
    ],
];

$response = $client->search($params);

if (!empty($response['hits']['hits'])) {
    foreach ($response['hits']['hits'] as $hit) {
        $source = $hit['_source'];
            echo '<div class="thesis-info">';
            echo '<strong>Advisor Name:</strong> ' . $source['advisor'] . '<br>';
            echo '<strong>Author:</strong> ' . $source['author'] . '<br>';
            echo '<strong>Degree:</strong> ' . $source['degree'] . '<br>';
            echo '<strong>Program:</strong> ' . $source['program'] . '<br>';
            echo '<strong>Title:</strong> ' . $source['title'] . '<br>';
            echo '<strong>University:</strong> ' . $source['university'] . '<br>';
            echo '<strong>Year:</strong> ' . $source['year'] . '<br>';
            echo '<div class="abstract"><strong>Abstract:</strong> ' . $source['text'] . '</div>';
            echo '</div>';?>
            <form action="download.php" method="post">
        <?php
             // Example user ID
        echo '<input type="hidden" name="bookid" value="' . $bookid . '">';
        ?>
        <input type="submit" name="download" value="Download">
    </form>
   <?php     }
    } 

    // $conn->close();
    ?>

</div>

</body>
</html>

