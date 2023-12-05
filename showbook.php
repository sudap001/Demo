<?php

if(isset($_POST['showbook'])){
    $bookid=$_POST['bookid'];
    $key=$_POST['key'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="icon" type="image/png" sizes="16x16" href="vscomlogo.png">
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


        #chat-container {
            position: fixed;
            bottom: 0;
            right:5px;
            width:20%;
            border: 1px solid #ccc;
            border-radius: 5px;
            overflow: hidden;
        }

        #chat-header {
            background-color: #4CAF50;
            color: white;
            padding: 10px;
            cursor: pointer;
        }
        #chat-header {
            background-color: #4CAF50;
            color: white;
            padding: 10px;
            cursor: pointer;
        }

        #chat-body {
            height: 400px;
            overflow-y: auto;
            padding: 10px;
            background-color:#edf8fc;
        }

        #user-message {
            color: #333;
            background-color: #fce6d2;
            
        }

        #bot-message {
            color: #007BFF;
            background-color:#ffffff;
        }

        #chat-input {
            width: 100%;
            padding: 10px;
            border: none;
            outline: none;
        }

    </style>
    <title>Book Information</title>
</head>
<body>

<div class="thesis-container">
    <h2>Book Information</h2>
    <h3>Searched key: <?php 
    $key = preg_replace('/\b(' . preg_quote($key, '/') . ')\b/i', '<mark>$1</mark>', $key);
    echo $key?></h3>
    

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
            echo '<div class="Book-info">';
            // echo $key;
            echo '<strong>Advisor Name:</strong> ' . $source['advisor'] . '<br>';
            echo '<strong>Author:</strong> ' . $source['author'] . '<br>';
            echo '<strong>Degree:</strong> ' . $source['degree'] . '<br>';
            echo '<strong>Program:</strong> ' . $source['program'] . '<br>';
            echo '<strong>Title:</strong> ' . $source['title'] . '<br>';
            echo '<strong>University:</strong> ' . $source['university'] . '<br>';
            echo '<strong>Year:</strong> ' . $source['year'] . '<br>';
            $abstract = preg_replace('/[\[\]]/', '', $source['text']);
            // $abstract = str_replace("'", "", $abstract);
            $abstract=CallWikifier($abstract);
            echo '<div class="abstract" id ="paragraph"><strong>Abstract:</strong> ' . $abstract . '</div>';
            echo '</div>';?>
            <form action="download.php" method="post">
        <?php
             // Example user ID
        echo '<input type="hidden" name="bookid" value="' . $bookid . '">';
        ?>
        <div id='answer'></div>
        <input type="submit" name="download" value="Download">

    </form>
   <?php     }
    } 

    // $conn->close();
    ?>
    

</div>
<div id="chat-container">
        <!-- <div id="chat-header" onclick="tglChat()">Chatbot</div> -->
        <div id="chat-body"></div>
        <input type="text" id="chat-input" placeholder="Type your message..." onkeypress="sendMsg(event)">
    </div>

    <script>
        function sendMsg(e) {

if (e.key === 'Enter') {

    var chatInput = document.getElementById('chat-input');

    var question = chatInput.value;

    var chatBody = document.getElementById('chat-body');

    var userMessage = document.createElement('div');

    userMessage.id = 'user-message';

    userMessage.textContent = question;

    chatBody.appendChild(userMessage);

    var lineBreak = document.createElement("br");

    chatBody.appendChild(lineBreak);

    getAnswer(question);

    chatInput.value = '';

}

}


async function getAnswer(question) {

const apiKey = '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'; // Replace 'YOUR_API_KEY' with your actual API key


const apiUrl = 'https://api.openai.com/v1/engines/davinci/completions';

var abstract = paragraph.textContent;


const requestBody = {

    prompt: abstract + "\nQuestion: " + question + "\nAnswer:",

    max_tokens: 50,

    n: 1,

    stop: null,

    temperature: 0.5

};


const response = await fetch(apiUrl, {

    method: 'POST',

    headers: {

        'Content-Type': 'application/json',

        'Authorization': 'Bearer ' + apiKey

    },

    body: JSON.stringify(requestBody)

});


const responseJson = await response.json();

var answer = responseJson.choices[0].text;

var chatBody = document.getElementById('chat-body');

var botMessage = document.createElement('div');

botMessage.id = 'bot-message';

botMessage.textContent = answer;

chatBody.appendChild(botMessage);

var lineBreak = document.createElement("br");

chatBody.appendChild(lineBreak);

}


    </script>

</body>
</html>

<?php
function CallWikifier($text, $lang = "en", $threshold = 0.8) {
    // Prepare the URL and data
    $data = http_build_query([
        "text" => $text, "lang" => $lang,
        "userKey" => "yxxdutgeeufaaamjrufotmdqgfbujt",
        "pageRankSqThreshold" => $threshold, "applyPageRankSqThreshold" => "true",
        "nTopDfValuesToIgnore" => "200", "nWordsToIgnoreFromList" => "200",
        "wikiDataClasses" => "true", "wikiDataClassIds" => "false",
        "support" => "true", "ranges" => "false", "minLinkFrequency" => "2",
        "includeCosines" => "false", "maxMentionEntropy" => "3"
    ]);
    
    $url = "http://www.wikifier.org/annotate-article";
    
    // Initialize cURL session
    $ch = curl_init($url);
    
    // Set cURL options
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 60);
    
    // Execute the cURL request
    $response = curl_exec($ch);
    
    // Close cURL session
    curl_close($ch);
    
    // Process the response
    $annotations = json_decode($response, true);
    
    // Output the annotations
    foreach ($annotations["annotations"] as $annotation) {
        // echo $annotation["title"] . " (" . $annotation["url"] . ")<br>";
        $text = str_replace($annotation["title"], '<a href="'. $annotation['url'] . '" target="_blank">' . $annotation['title'] . '</a>', $text);
        // echo '<br>';
        // echo $text;
    }
    return $text;
}
?>