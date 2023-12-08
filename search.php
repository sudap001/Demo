<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body{
            background-image:url("photo.png"); 
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
        .container {
            max-width: 800px;
            margin: 20px auto;
            /* margin-bottom: 20px; */
            padding: 10px;
            /* border: 1px solid #ccc; */
            /* border-radius: 4px; */
            background-color: #f1fffe;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .pagging{
           
            text-align:center;
        }
        .author-row {
            margin-bottom: 20px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            text-transform: uppercase;
        }
       
        .search-bar {
           
            width: 70%;
            height: 40px;
            font-size: 18px;
            padding-top:5px;
            display: flex;
            align-items: center;
        }
       
        input[type="text"] {
            padding: 5px;
            border: none;
            border-radius: 4px;
            margin-right: 10px;
        }

        button {
            padding: 5px 10px;
            background-color: #4CAF50;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
    </style>
    <title>Thesis Information</title>
</head>
<body>
<div class="navbar">
    <a href="index.php">Home</a>
    <a href="signup.php">SignUp</a>
    <a href="login.html">SignIn</a>
    <a href="#contact">Contact</a>
    <div class="search-bar">
    <form method="post" action="search.php">
                <input type="text" name="search" spellcheck="true" autocorrect="on" placeholder="Search...">
                <button type="submit" name="submit">Search</button>
            </form>
           
        </div>
</div>


    <?php
    require 'vendor/autoload.php';

use Elasticsearch\ClientBuilder;



$hosts = ['localhost:9200'];
$client = ClientBuilder::create()->setHosts($hosts)->build();

   

        $index = 'bookdetails';

// Search for documents
function searchWithPagination($search, $pageSize, $page)
{
    global $client;

// Specify the index
$index = 'bookdetails';

$from = ($page - 1) * $pageSize;

// Search for documents
$params = [
    'index' => $index,
    'body' => [
        'query' => [
            'bool' => [
                'should' => [
                    ['match' => ['title' => $search]],
                    ['match' => ['author' => $search]],
                    ['match' => ['year' => $search]],
                    ['match' => ['degree' => $search]],
                    ['match' => ['advisor' => $search]],
                    ['match' => ['program' => $search]],
                    ['match' => ['university' => $search]],
                    ['match' => ['text' => $search]],
                   
                    // Add more fields as needed
                ],
            ],
        ],
    ],
// ];
    'from' => $from,
    'size' => $pageSize,
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
                $bookid =$source['etd_file_id'];?>
            <div class="container">
                <div class="author-row">
                <strong><?php echo $source['author']; ?></strong><br>
                <?php echo $source['title']; ?>
                <form action="showbook.php" method="post">
        <?php
             // Example user ID
        echo '<input type="hidden" name="bookid" value="' . $bookid . '">';
        echo '<input type="hidden" name="key" value="' . $search . '">';
        ?>
        <input type="submit" name="showbook" value="ReadMore">
    </form>
            </div>
            </div>
      <?php  }
         
    // }


        // Enable/disable Previous and Next buttons based on pagination
        $totalHits = $response['hits']['total']['value'];
        $totalPages = ceil($totalHits / $pageSize);
        $firstpage=1;
        ?>
        <br>
        <div class="pagging">
        <?php
        echo '<a class="container " href="search.php?page='. $firstpage .'&search='.$search.' " ><< </a>';
       
        if ($page > 1) {
            echo '<a class="container" href="search.php?page='. ($page - 1) .'&search='.$search.' " >< </a>';
        } else {
            if($page==1){
                echo '<';
            }
           
        }

        echo "[$page]";

        if ($page < $totalPages) {
            echo '<a class="container" href="search.php?page='. ($page + 1) .'&search='.$search.'"> ></a>';
        } else {
            if($page==1){
                echo ' >';
            }
           
        }
        echo '<a class="container" href="search.php?page='. $totalPages.'&search='.$search.' " >  >></a>';
    } else {
        echo "No documents found for the search term: " . htmlspecialchars($search);
    }
    ?>
    </div>
    <?php
}


$pageSize = 4; // Number of results per page
$page = isset($_GET['page']) ?  max(1, intval($_GET['page'])) : 1;
$search=isset($_GET['search']) ? $_GET['search'] : '';
$search=sanitizeInput($search);
if (isset($_POST['submit'])) {
    $search = $_POST['search'];
    $search=sanitizeInput($search);
    $apiKey = '2UQCEnxzZeMQsUe0';



// Usage example:
$inputText = $search;
$search = correctSpelling($inputText, $apiKey);

}

searchWithPagination($search, $pageSize, $page);

function sanitizeInput($input) {
    return strip_tags($input); // Remove HTML tags
}
function correctSpelling($text, $apiKey) {
    $apiUrl = "https://api.textgears.com/spelling?key=$apiKey&text=" . urlencode($text);

    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => $apiUrl,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => array(
            "Content-Type: application/json"
        ),
    ));

    $response = curl_exec($curl);
    $err = curl_error($curl);
    curl_close($curl);

    if ($err) {
        return "cURL Error #:" . $err;
    } else {
        $decodedResponse = json_decode($response, true);

        // Check if there are suggestions for corrections
        if (isset($decodedResponse['response']['errors'])) {
            $errors = $decodedResponse['response']['errors'];

            foreach ($errors as $error) {
                $incorrectWord = $error['bad'];
                $correctedWord = $error['better'][0]; // Take the first suggestion

                // Replace the incorrect word with the corrected word
                $text = str_replace($incorrectWord, $correctedWord, $text);

                echo '<div style="text-align: center; background-color: lightblue; padding: 20px; margin-top:20px; width:">';
                echo "Incorrect word: $incorrectWord<br>";
                echo "Corrected word: $correctedWord<br><br>";
                echo '</div>';
            }
        }

        // Return the corrected text
        return $text;
    }
}
        ?>
       
       
       
 

</div>

</body>
</html>

