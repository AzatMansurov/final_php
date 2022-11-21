<?php
    if ($_SERVER['REQUEST_METHOD'] == "POST") {

        if (isset($_POST['text'])) {

            $text = $_POST['text'];

            $db_host = 'localhost';
            $db_name = 'php';
            $db_user = 'root';
            $db_password = 'yes';
        
            $date_time = date('Y-m-d H:i:s', time());
            $query = "
                INSERT INTO log (date_time, text)
                VALUES ('$date_time', '$text')
            ";

            $link = mysqli_connect($db_host, $db_user, $db_password, $db_name) or die("DB connecting error: " . mysqli_error($link));
            mysqli_query($link, $query) or die("DB sending request error: " . mysqli_error($link));

            $array = array(
                'text' => $text
            );
            
            $ch = curl_init('http://localhost:8090');
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($array, '', '&'));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_HEADER, false);
            $html = curl_exec($ch);
            curl_close($ch);
            
            echo $html;

            header("location:" . 'index.php');
        }
    }
?>

<!doctype html>
<html lang="ru">
<head>
    <meta charset="utf-8" />
    <title></title>
    <link rel="stylesheet" href="style.css" />
</head>
<body>

    <form action="<?=$_SERVER['PHP_SELF']?>" method="POST">
        <textarea rows="10" cols="50" name="text" required></textarea>
        <br>
        <button>Отправить</button>
    </form>

</body>
</html>
