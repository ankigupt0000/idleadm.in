<?php
$servername = "localhost";
$username = "username";
$password = "password";
$dbname='database';
$conn = new mysqli($servername, $username, $password, $dbname);


function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}
    $query=$_REQUEST['q'];
    $tiny=$_REQUEST['tiny'];
    $url=$_REQUEST['url'];
    if(($query == "index.php" || $query == "") && $tiny == "")
    {
        header('Location: wp/');
    }
    else
    {
        if ($conn->connect_error) 
        {
            die("Connection failed: " . $conn->connect_error);
        }
        $sql = "SELECT URL FROM MINURL where TINYURL='".$query."'";

        $result=$conn->query($sql);
        if ($result->num_rows > 0) 
        {
            if($row = $result->fetch_assoc()) 
            {
                header('Location: '.$row['URL']);
            }
        }
        if ($tiny != "" && $url != "")
        {
            $sql= "SELECT URL FROM MINURL where TINYURL='".$tiny."'";
            $result=$conn->query($sql);
            if($result->num_rows > 0)
            {
                if($row = $result->fetch_assoc()) 
                {
                    echo "This url is already registered with <a href='http://idleadm.in/".$row['URL']."'>idleadm.in/".$tiny."</a>";
                }
            }
            else
            {
                if(substr($url,0,4)!="http")
                    $url="http://".$url;
                $sql= "insert into MINURL(TINYURL,URL) values ('".$tiny."','".$url."')";
                if ($conn->query($sql) === TRUE) 
                {
                   echo "Access your site at <a href='http://idleadm.in/".$tiny."'>idleadm.in/".$tiny."</a>";
                }
            }
        }
?>

<html>
<head>
<title>
Simpilest Tiny URL service.
</title>
</head>
<body>
<form action="tinyurl.php" method="GET">
Tiny URL:<input type='text' name='tiny' value='
<?php  
while(1)
{
    $random=generateRandomString(10);
    $sql= "SELECT URL FROM MINURL where TINYURL='".$random."'";
    $result=$conn->query($sql);
    if($result->num_rows == 0)
    {
        break;
    }
}
echo $random;
?>
'/>
<br/>
URL:<input type='text' name='url' />
<br/>
<input type='submit' />
</form>
</body>
</html>

<?php        
    }
?>
