<?php
    require_once("../pdo/connect.php");

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../style/MainStyle.css">
</head>
<body>

    <table border = "1" >
     <thead>
        <caption>Список всех пользователей</caption>

        <tr>
            <td>
                <b>Имя</b>
            </td>
            <td>
                <b>Фамилия</b>
            </td>
            <td>
                <b>Ававтар</b>
            </td>
        </tr>
     </thead>
     <tbody>
     
        <?php
            $stmt = $pdo->query("SELECT * FROM users");             

             while($result = $stmt->fetch(PDO::FETCH_ASSOC)){
                
                $img = json_decode($result['data'],true);

                echo "
                <tr>
                    <td>
                        ".$result["name"]."
                    </td>
                    <td>
                        ".$result["family"]."
                    </td>
                    <td>
                        <img src = '../fhotos/".$img['img_name']."' id = 'avatar'  >
                    </td>
                </tr>
            ";
             }

            // foreach ($result as $key) {

                
                
            


               
            // }
        
        ?>
     </tbody>
        
    </table>

</body>
</html>