<?php 
require 'vendor/autoload.php';

use Elasticsearch\ClientBuilder;


if(isset($_POST["add"])){
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




        if ($_FILES["pdfFile"]["error"] == 0) {
            $pdfFilePath = $_FILES["pdfFile"]["tmp_name"];
            $pdfFileName = $_FILES["pdfFile"]["name"];

            // Index the data into Elasticsearch
        indexToElasticsearch($author, $title, $year, $pdfFilePath, $pdfFileName,$adviname,$program,$uni,$abstract,$degree);

            echo "Data and PDF successfully uploaded to Elasticsearch.";
        } else {
            echo "Error uploading the PDF file.";
        }
    }
    


function indexToElasticsearch($authorName, $title, $year, $pdfFilePath, $pdfFileName,$adviname,$program,$uni,$abstract,$degree) {


    $client = ClientBuilder::create()->setHosts($hosts)->build();
    // Indexing settings
    $index = 'bookdetails'; // Replace with your desired index name
    // $type = '_doc';

    // Read PDF content
    $pdfContent = base64_encode(file_get_contents($pdfFilePath));

    // Index document with author name, title, year, and PDF content

    $params = [
        'index' => $index,
        // 'type' => $type,
        'body' => [
            'etd_file_id'=>$pdfFileName,
            'author' => $author,
            'title' => $title,
            'year' => $year,
            'degree'=>$degree,
            'advisor'=>$adviname,
            'text'=>$abstract,
            'program'=>$program,
            'university'=>$uni,
            'file_name' => $pdfFileName,
            'content' => $pdfContent,
        ],
    ];

    $response = $client->index($params);

    // You can handle the response as needed
    // Note: In a production environment, you should add error handling and logging





     echo '<script>
     alerty("Book Added susscessfully");
     window.location="userdashboard.php";
     </script>';
     
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
            background-image:url("photo.png");
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
        .navbar {
            overflow: hidden;
            background-color: #333;
        }
        .navbar a {
            float: left;
            display: block;
            color: white;
            text-align: center;
            padding: 14px 16px;
            text-decoration: none;
        }
        .navbar a:hover {
            background-color: #ddd;
            color: black;
        }
        .search-bar {
            
            width: 70%;
            height: 40px;
            font-size: 18px;
            padding:1%;
            padding-top: 30px;
            display: flex;
            align-items: center;
        }
    </style>
    <title>Advisor Details</title>
</head>
<body>
<div class="navbar">
    <a href="userdashboard.php">Dashboard</a>
    <div class="search-bar">
    <form method="post" action="searchlogin.php">
                <input type="text" name="search" placeholder="Search...">
                <button type="submit" name="submit">Search</button>
            </form>
    </div>
    </div>

    <div class="container">
        <h2>Add New Book</h2>
        <form action="addbook.php" method="post">
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

            <label for="abstractText">Abstract</label>
            <textarea id="abstract" name="abstract" rows="5" required></textarea>
            <label for="pdfFile">Select PDF File:</label>
        <input type="file" name="pdfFile" id="pdfFile" accept=".pdf" required>
        <br>

            <button type="submit" name="add">Submit</button>
        </form>
    </div>
</body>
</html>
