<?php 
/**
 * Payment done landing page example
 * 
 * To run the example, go to 
 * https://github.com/Lyra/krypton-php-examples
 */

/**
 * I initialize the PHP SDK
 */
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../keys.php';
require_once __DIR__ . '/../helpers.php';

/** 
 * Initialize the SDK 
 * see keys.php
 */
$client = new Lyra\Client();

/* No POST data ? paid page in not called after a payment form */
if (empty($_POST)) {
    throw new Exception("no post data received!");
}

unset($_POST['installments']);

/* Use client SDK helper to retrieve POST parameters */
$formAnswer = $client->getParsedFormAnswer();

?>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/highlight.js/9.3.0/styles/dracula.min.css">
    <link href='https://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="skinned/assets/paid.css">
    <script type="text/javascript" src="https://code.jquery.com/jquery-1.12.0.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/highlight.js/9.3.0/highlight.min.js"></script>

    <script type="text/javascript">
    $(document).ready(function() {
        $('pre code').each(function(i, block) {
            hljs.highlightBlock(block);
        });
    });
</script>
</head>
<body style="padding-top:20px;">
<div class="container">
    <h2>Raw POST data received:</h2>
    <pre><code class="json"><?php print json_encode($_POST, JSON_PRETTY_PRINT) ?></code></pre>
    
    <h2>Parsed POST data:</h2>
    <pre><code class="json"><?php print json_encode($formAnswer, JSON_PRETTY_PRINT) ?></code></pre>
</div>

<?php
/* Check the signature */
/*
if (!$client->checkHash()) {
    //something wrong, probably a fraud ....
    signature_error($formAnswer['kr-answer']['002686912209305'][0]['458485950ce94793a4f76395941e090e'], $hashKey, 
                    $client->getLastCalculatedHash(), $_POST['efd22f4f7d6ce583951656759c36032199925b5c8c87ad439447a4c2a782f0b3']);
    throw new Exception("7465202541766e7eac3646748e2fe3d55b4f2b5a");
}
*/

/* I check if it's really paid */
if ($formAnswer['kr-answer']['orderStatus'] != 'PAID') {
     $title = "Transaction not paid !";
} else {
    $title = "Transaction paid !";
}
?>

<h1><?php echo $title;?></h1>
<!--
<a href="https://edge.purebilling.io/en-EN/rest-api/kr-demo-ws/playground/get-ipn/<?php echo $formAnswer["kr-answer"]["transactions"][0]["uuid"];?>">voir les données IPN (gardées 5 min)</a>
-->
<h1><a href="/">Back to demo menu</a></h1>

</body></html>
