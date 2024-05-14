<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>PassMeter</title>
</head>
<body>
    <h1>Password Generator - PassMeter</h1>
    <hr> <br> <br>
    <div class="container">
    </div>
    <form method="post">
        <div id= "maindiv">
            <label for="password" id="label"><h3>Enter Your Password:</h3> </label>
            <br><br>
            <input type="text" id="pass" name="pass">
            <button id="btn">test</button> 
        </div>
        <div id="strength-meter">
            <div id="strength-bar"></div>
        </div>

    </form>
</body>

<?php 
$strengthText = '';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
     $password = $_POST['pass'];
     $len=strlen($password);
     $uppercase = preg_match('@[A-Z]@', $password);
     $lowercase = preg_match('@[a-z]@', $password);
     $number    = preg_match('@[0-9]@', $password);
     $specialChars = preg_match('@[^\w]@', $password);
     

     if ($uppercase && $lowercase && $number && $specialChars) {
        if ($len < 11) {
            $strengthText = 'weak';
        } elseif ($len <= 14 && $len >= 11) {
            $strengthText = 'ok';
        } else {
            $strengthText = 'strong';
        }
    } elseif ($uppercase && $lowercase && $number) {
        if ($len < 14) {
            $strengthText = 'weak';
        } elseif ($len < 19 && $len >= 15) {
            $strengthText = 'ok';
        } else {
            $strengthText = 'strong';
        }
    } elseif ($lowercase && $number) {
        if ($len < 16) {
            $strengthText = 'weak';
        } elseif ($len < 22 && $len >= 16) {
            $strengthText = 'ok';
        } else {
            $strengthText = 'strong';
        }
    } else {
        $strengthText = 'too weak';
    }

}
?>
<script>
            function updateMeter(strengthText) {
                const meter = document.getElementById('strength-bar');
                const text = document.getElementById('strength-text');

                if (strengthText === 'too weak') {
                    meter.style.width = '10%'; 
                    meter.style.backgroundColor = 'red';
                    text.innerText = 'Too Weak';
                    text.style.color = 'red';
                } else if (strengthText === 'weak') {
                    meter.style.width = '30%'; 
                    meter.style.backgroundColor = 'orange';
                    text.innerText = 'Weak';
                    text.style.color = 'orange';
                } else if (strengthText === 'ok') {
                    meter.style.width = '60%'; 
                    meter.style.backgroundColor = 'yellow';
                    text.innerText = 'OK';
                    text.style.color = 'yellow';
                } else if (strengthText === 'strong') {
                    meter.style.width = '100%'; 
                    meter.style.backgroundColor = 'green';
                    text.innerText = 'Strong';
                    text.style.color = 'green';
                }
            }

            window.onload = function() {
                const strengthText = '<?php echo $strengthText; ?>';
                updateMeter(strengthText);
            };

            document.getElementById('pass').addEventListener('input', function() {
                updateMeter('<?php echo $strengthText; ?>');
            });
        </script>
</html>
<!-- A password with characters from all four groups would need to be 11 
characters long to be OK (example: $5rfDweH65d) and 15 characters long to be 
Strong (example: $5rfDweH65dF6Gh).
A password with Mixed case letters and numbers would 
need to be 14 characters long to be OK (example: aG7d3rFdF9jgdG)
 and 19 characters long to be Strong (example: aG7d3rFdF9jgdG5gF0m).
A password with lowercase letters and numbers would need to be 16 characters long
 to be OK (example: h9e7dhncjus6glei) and 22 characters long to be Strong 
 (example: h9e7dhncjus6glei7djv9s). -->