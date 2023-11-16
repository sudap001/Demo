<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body{
            background-image:url("photo.png");
            /* background-image:url("images.jpg"); */
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
                    // ['match' => ['text' => $search]],
                    
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
if (isset($_POST['submit'])) {
    $search = $_POST['search'];
}

searchWithPagination($search, $pageSize, $page);
        ?>
        
        
       
 

</div>

</body>
</html>