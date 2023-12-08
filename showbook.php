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


        body {
    margin: 0;
    font-family: Arial, sans-serif;
}

.chatbox {
    position: fixed;
    bottom: 0;
    right: 0;
    width: 300px;
    background-color: #fff;
    border: 1px solid #ccc;
    border-radius: 10px 10px 0 0;
    overflow: hidden;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    z-index: 1000;
}

.header {
    background-color: #007bff;
    color: #fff;
    padding: 10px;
    text-align: center;
    cursor: pointer;
    user-select: none;
}

.chat-body {
    display: none;
}

.messages {
    max-height: 300px;
    overflow-y: auto;
    padding: 10px;
}

.user-message {
    background-color: #e6e6e6;
    border-radius: 5px;
    padding: 5px;
    margin-bottom: 5px;
}

.bot-message {
    background-color: #007bff;
    color: #fff;
    border-radius: 5px;
    padding: 5px;
    margin-bottom: 5px;
}

.input-container {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 10px;
    border-top: 1px solid #ccc;
}

#userInput {
    width: calc(70% - 5px);
    padding: 5px;
    margin: 5px;
    border: 1px solid #ccc;
    border-radius: 5px;
}

#submitBtn {
    width: 28%;
    padding: 7px;
    border: none;
    border-radius: 5px;
    background-color: #007bff;
    color: #fff;
    cursor: pointer;
}

#submitBtn:hover {
    background-color: #0056b3;
}

.open .chat-body {
    display: block;
}

.highlight {
        background-color: yellow; /* You can change the background color */
        font-weight: bold; /* Optionally, you can make the text bold */
    }
    </style>
    <title>Book Information</title>
</head>
<body>

<div class="thesis-container">
    <h2>Book Information</h2>
    <!-- <h3>Searched key: 
    // $key = preg_replace('/\b(' . preg_quote($key, '/') . ')\b/i', '<mark>$1</mark>', $key);
    // echo $key?></h3> -->
    

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
function highlightSearchTerm($text, $searchTerm) {
    if ($searchTerm !== '' && stripos($text, $searchTerm) !== false) {
        // Highlight the search term using HTML and CSS
        $highlightedText = preg_replace("/\b($searchTerm)\b/i", '<span class="highlight">$1</span>', $text);
        return $highlightedText;
    }
    return $text;
}

if (!empty($response['hits']['hits'])) {
    foreach ($response['hits']['hits'] as $hit) {
        $source = $hit['_source'];
        $advisor=highlightSearchTerm($source['advisor'], $key);
        $author=highlightSearchTerm($source['author'], $key);
        $degree=highlightSearchTerm($source['degree'], $key);
        $program=highlightSearchTerm($source['program'], $key);
        $university=highlightSearchTerm($source['university'], $key);
        $title=highlightSearchTerm($source['title'], $key);
        $year=highlightSearchTerm($source['year'], $key);
        $text=highlightSearchTerm($source['text'], $key);



            echo '<div class="Book-info">';
            // echo $key;
            echo '<strong>Advisor Name:</strong> ' . $advisor . '<br>';
            echo '<strong>Author:</strong> ' . $author . '<br>';
            echo '<strong>Degree:</strong> ' . $degree . '<br>';
            echo '<strong>Program:</strong> ' . $program . '<br>';
            echo '<strong id ="head1">Title:</strong> ' . $title . '<br>';
            echo '<strong>University:</strong> ' . $university. '<br>';
            echo '<strong>Year:</strong> ' . $year. '<br>';
            $abstract = preg_replace('/[\[\]]/', '', $text);
            $abstract = str_replace("'", "", $abstract);
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
<div class="chatbox" id="chatbox">
    <div class="header" id="toggleChat">
        Chatbot
    </div>
    <div class="chat-body" id="chatBody">
        <div class="messages" id="chatMessages">
            <!-- Chat messages will be displayed here -->
            <div class="bot-message">Hello, How may I help you?</div>
        </div>
        <div class="input-container">
            <input type="text" id="userInput" placeholder="Type here..." onkeypress="sendMsg(event)">
            <!-- <button id="submitBtn">Submit</button> -->
        </div>
    </div>
</div>

    <script>
        let chatOpen = false;

    const chatbox = document.getElementById('chatbox');
    const toggleChat = document.getElementById('toggleChat');
    const chatBody = document.getElementById('chatBody');
    const userInput = document.getElementById('userInput');
    const submitBtn = document.getElementById('submitBtn');
    const chatMessages = document.getElementById('chatMessages');

    toggleChat.addEventListener('click', function () {
        chatbox.classList.toggle('open');
    });



function sendMsg(e) {

if (e.key === 'Enter') {

    var chatInput = document.getElementById('userInput');

    var question = chatInput.value;

    var chatBody = document.getElementById('chat-body');

    var userMessage = document.createElement('div');
    const messageDiv = document.createElement('div');
        messageDiv.className = 'user-message';
        messageDiv.textContent = question;

    messageDiv.id = 'user-message';

    userMessage.textContent = question;

    chatMessages.appendChild(userMessage);

    var lineBreak = document.createElement("br");



    getAnswer(question);

    chatInput.value = '';

}

}


async function getAnswer(question) {

const apiKey = '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'; // Replace 'YOUR_API_KEY' with your actual API key


const apiUrl = 'https://api.openai.com/v1/engines/davinci/completions';
// var title =  document.getElementById("head1");

// var title1 = title.textContent;

var paragraph =  document.getElementById("paragraph");

var abstract = paragraph.textContent;


const requestBody = {

    prompt: abstract + question + "\nAnswer:",

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

const messageDiv = document.createElement('div');

messageDiv.id = 'bot-message';



        messageDiv.className =  'bot-message';
        messageDiv.textContent = answer;
        chatMessages.appendChild(messageDiv);


var lineBreak = document.createElement("br");


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