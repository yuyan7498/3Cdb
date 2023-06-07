<?php
$server = "140.127.74.226";         # MySQL/MariaDB 伺服器
$dbuser = "411077022";       # 使用者帳號
$dbpassword = "411077022"; # 使用者密碼
$dbname = "411077022";    # 資料庫名稱

# 連接 MySQL/MariaDB 資料庫
$connection = new mysqli($server, $dbuser, $dbpassword, $dbname);

# 檢查連線是否成功
if ($connection->connect_error) {
  die("連線失敗：" . $connection->connect_error);
}else{
    printf("連線成功");
}

$sql = "SHOW DATABASES";
$result = $conn->query($sql);

$row = $result -> fetch_assoc();
var_dump($row);