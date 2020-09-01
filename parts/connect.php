<?php
$db_host = "localhost";
// 連線到哪個資料庫
$db_name = "topic";
// 帳號密碼
$db_user = "root";
$db_pass = "";
// 連結到 MYSQL類型的資料庫 dbhost 是連到哪個主機 dbname= 連到哪張表
$dsn = "mysql:host={$db_host};dbname={$db_name}";

$pdo_options = [
    // 屬性錯誤的模式(SQL語法錯誤時 提示的方式) (這代表錯誤的時候沒有提示)
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    //拿取資料的方式  這邊是 拿出來的資料 用關聯式陣列顯示
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    // 連線之後 自動使用SET NAMES 'utf8' 語法 意思就是 使用UTF8編碼
    PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"
];
//  dsn=主機 資料庫名稱 user padd = 帳號密碼  pdo_options =你的設定
$pdo = new PDO($dsn, $db_user, $db_pass, $pdo_options);
