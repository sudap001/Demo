<?php 
require 'vendor/autoload.php';

use Elasticsearch\ClientBuilder;


if(isset($_POST["add"])){
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
     $adviname=$_POST['advisorName'];
     $author=$_POST['author'];
     $degree=$_POST['degree'];
     $program=$_POST['program'];
     $title=$_POST['title'];
     $uni=$_POST['university'];
     $year=$_POST['year'];
     $abstract=$_POST['abstract'];



     
     
     // Create Elasticsearch client
     $hosts = ['localhost:9200'];
     $client = ClientBuilder::create()->setHosts($hosts)->build();

            indexToElasticsearch($author, $title, $year,$adviname,$program,$uni,$abstract,$degree);

    
            echo "PDF successfully uploaded and indexed.";
        } else {
            echo "Error uploading the file.";
        }

    }
    


function indexToElasticsearch($author, $title, $year, $adviname,$program,$uni,$abstract,$degree) {

    $hosts=['localhost:9200'];
    $client = ClientBuilder::create()->setHosts($hosts)->build();
    // Indexing settings
    $index = 'bookdetails'; 
    // Replace with your desired index name
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
    $total+=1;
    $params = [
        'index' => $index,
        // 'type' => $type,
        'body' => [
            'etd_file_id'=>$total,
            'author' => $author,
            'title' => $title,
            'year' => $year,
            'degree'=>$degree,
            'advisor'=>$adviname,
            'text'=>$abstract,
            'program'=>$program,
            'university'=>$uni,
        ],
    ];
    $response = $client->index($params);
    // session_start();
    // $_SESSION['id'] = $total;
    header("Location:selectpdf.php");
     
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
    <title>Advisor Details</title>
</head>
<body>
    <div class="container">
        <h2>Add New Book</h2>
        <form action="addbook.php" method="post" enctype="multipart/form-data">
            <label for="advisorName">Advisor Name:</label>
            <input type="text" id="advisorName" name="advisorName" required>

            <label for="author">Author:</label>
            <input type="text" id="author" name="author" required>

            <label for="degree">Degree:</label>
            <input type="text" id="degree" name="degree" required>

            <label for="program">Program:</label>
            <input type="text" id="program" name="program" required>

            <label for="title">Title:</label>
            <input type="text" id="title" name="title" required>

            <label for="university">University:</label>
            <input type="text" id="university" name="university" required>

            <label for="year">Year:</label>
            <input type="text" id="year" name="year" required>

            <label for="abstractText">abstract</label>
            <textarea id="abstract" name="abstract" rows="5" required></textarea>
        <br>

            <button type="submit" name="add">Submit</button>
        </form>
    </div>
</body>
</html>