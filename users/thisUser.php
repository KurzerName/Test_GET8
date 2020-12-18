<?php
    require_once("../pdo/connect.php");

    $user_hash = $_GET["hash"];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE hash = :hash");
    $stmt->execute([":hash" => $user_hash]);
    $user_info = $stmt->fetch(PDO::FETCH_ASSOC);
    
    $more_user_info = json_decode($user_info['data'], true);

?>

<!DOCTYPE html>
<html>
    <head>
        <title>*Имя пользователя*</title>
        <meta name = "width" content="width=device-width, initial-scale:1.0">
        <meta charset="UTF-8">
        <link rel="stylesheet" href = "../style/MainStyle.css">

    </head>

    <body>


         <div id = "aboutUser">
             <div id = "User">
                 <div id = "UserAvatar">
                    <img src = "../fhotos/<?=$more_user_info['img_name']?>." >
                 </div>


                 <div id = "UserInfo">
                     <span id = "UserName" >
                         <?=$user_info['name']?>
                     </span>

                     <span id = "UserFamily">
                         <?=$user_info['family']?>
                     </span>
                 </div>
             </div>

            <div id = "UserMoreInformation">
                
                <span id = "url">
                    Url : <?=$more_user_info['url']?>
                </span>
                
            <a href = "http://workshop">Обратно</a>
            </div>
        
         </div>

    </body>

</html>