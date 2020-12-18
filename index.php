<?php   
    require_once('./pdo/connect.php'); // подключаем бд
    require_once("./pdo/webhook.php");


    $message = "";
    $hash = "";
    if($_POST['send']){
    
        $name = trim(htmlentities(ucfirst($_POST['NewName'])));
        $family = trim(htmlentities(ucfirst($_POST['NewFamily'])));
        $imageinfo = $_FILES["img"];
        if($name != "" || $family != ""){

                $userInfo['name'] = $name;
                $userInfo['family'] = $family;

            if($imageinfo["name"] !== ""){
                echo $imageinfo["name"]."----";
                $imageinfo = getimagesize($_FILES['img']['tmp_name']);
            }


            if($imageinfo["mime"] == "image/jpg" || $imageinfo["mime"] == "image/png" || $imageinfo["mime"] == "image/jpeg"){
                
        

                $f_name = $_FILES['img']['name'];
                $f_size = $_FILES['img']['size'];
                $f_type = $_FILES['img']['type'];
                $f_tmp = $_FILES['img']['tmp_name'];
                $f_ext =  strtolower(end(explode(".", $f_name)));
    
                $f_new_name = uniqid().".".$f_ext; 
           
                $userInfo['data']['img_name'] = $f_new_name;

                move_uploaded_file($f_tmp, "./fhotos/$f_new_name");
               
            }
            else{

            }

            file_put_contents("./webhook.json", json_encode($userInfo));
            header("Location: http://workshop");
        }
        else{
            header("Location: http://workshop");
        }     
        
       
       header("Location: http://workshop");
    }
    else{

    }

    if($userInfo){ // если данные получены, то возвращаем OK
        echo "<h1 id = 'success' >OK</h1>";

         $stmt = $pdo->prepare("SELECT * FROM `users` WHERE `hash` = :hash"); // Ищем этого пользователя по hash
         $stmt->execute([":hash" => $userInfo['hash']]);
         $result = $stmt->fetch(PDO::FETCH_ASSOC);
         $hash = $result["hash"];

         if(!$result){ // Если пользователя по webhook не найдено
             $message = "мы создаём нового пользователя";
             $stmt = $pdo->prepare("INSERT INTO `users` (hash, name, family, update_date, data) VALUES (:hash, :name, :family, :update_date, :data)");
             $stmt->execute([":hash" => $userInfo['hash'], ":name" => $userInfo['name'], ":family" => $userInfo['family'], ":update_date" => $userInfo['update'], ":data" => json_encode($userInfo['data'])]);
            
        }
         else{
            $stmt = $pdo->prepare("UPDATE  users SET  name = :name, family = :family, update_date = :update_date, data = :data WHERE hash = :hash");
            $stmt->execute([":hash" => $userInfo['hash'], ":name" => $userInfo['name'], ":family" => $userInfo['family'], ":update_date" => $userInfo['update'], ":data" => json_encode($userInfo['data'])]);
         }

    }
    else{
        echo "<h1 id = 'error' >Возникла ошибка передачи данных</h1>";
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Тестовое задание от get-8</title>
    <link rel="stylesheet" href="./style/MainStyle.css">
</head>
<body>
    <h1 id = 'message'><?=$message?></h1>
    <table border = "2" >
        <thead>
            <caption>Информация о пользователе</caption>
            <tr>
                <td>
                   <b>Имя</b>
                </td>
                <td>
                   <b>Фамилия</b>
                </td>
                <td>
                    <b>Фото</b>
                </td>

            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    <?=$userInfo['name']?>
                </td>
                <td>
                    <?=$userInfo['family']?>
                </td>
                <td>
                    <img id = "avatar" src="./fhotos/<?=$userInfo['data']["img_name"]?>">
                </td>
            </tr>
        </tbody>        
    </table>

    <form id = "update_user_info" action="" method="post" enctype = "multipart/form-data">
        Обновление данных: 

        <p>
            <label for="NewName">Новое имя: </label><input type="text" name = "NewName" id = "NewName">
        </p>
        <p>
            <label for="NewFamily">Новая фамилия: </label><input type="text" name = "NewFamily" id = "NewFamily">
        </p>
        <p>
            Аватар: <input type="file" name="img" id="img">
        </p>

        <input type="submit" name = "send" value="Обновить">
    </form>

    <div id = "users-list">
      <ul id = "list">
        <?php
            $stmt = $pdo->query("SELECT * FROM users");             

            while($result = $stmt->fetch(PDO::FETCH_ASSOC)){
               
               $img = json_decode($result['data'],true);
               echo "
               <li>
                <a href = './users/thisUser.php?hash=".$result['hash']."'>
                    <img src = './fhotos/".$img['img_name']."'>
                    <span>
                      ".$result["name"]." ".$result["family"]."  
                    </span>
                  </a>
               </li>
           ";
            }

        ?>
      </ul>
    </div>


    <script src="./script/script.js"></script>
</body>
</html>