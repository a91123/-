<?php

if (!isset($_SESSION)) {
    session_start();
}
// 如果沒有設置 session 代表沒有登入 所以可以在 有設權限的地方 require 這隻檔案
if (!isset($_SESSION['admin'])) {
    header('Location: list.php');
    exit;
}
