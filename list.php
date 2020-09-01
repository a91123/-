<?php
$page_title = '資料列表';
// 這邊會用來判定點到哪個表單 使該表單出現active樣式 (在navbar上顯示)
$page_name = 'list';
require __DIR__ . '/parts/connect.php';

$perPage = 5; // 每頁有幾筆資料
// 如果用戶有輸入就跳到用戶輸入的頁數 沒有輸入 就跳到第一頁
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
// 到shoplist撈資料
$t_sql = "SELECT COUNT(1) FROM `shop_list`";
// 總共有幾筆
$totalRows = $pdo->query($t_sql)->fetch(PDO::FETCH_NUM)[0];
// 總頁數= 總比數 除以一頁有幾筆
$totalPages = ceil($totalRows / $perPage);

$rows = [];
// 如果撈到的總筆數大於0 
if ($totalRows > 0) {
    // 如果用戶輸入小於1 跳轉到第一頁
    if ($page < 1) {
        header('Location: list.php');
        exit;
    }
    // 如果用戶輸入的頁數 大於 總頁數 跳轉到最後一頁 用.去串接 $totalPages 相當於js +號的字串相接
    if ($page > $totalPages) {
        header('Location: list.php?page=' . $totalPages);
        exit;
    };                                         //從0開始 拿五筆
    // sqp = 篩選到 全部的資料    第一頁 LIMIT = 1-1*5 拿五筆 =0~5 以此類推
    $sql = sprintf("SELECT * FROM `shop_list` LIMIT %s, %s", ($page - 1) * $perPage, $perPage);
    //stmt = 拿sql 的 筆數  (ex limit 0,5 從第0筆開始 撈五筆)  
    $stmt = $pdo->query($sql);
    // 把他塞到 rows 裡面 然後 下面利用foreach呈現在表格上
    $rows = $stmt->fetchAll();
}
?>
<?php require __DIR__ . '/parts/header.php'; ?>
<?php include __DIR__ . '/parts/navbar.php'; ?>

<div class="container">
    <div class="row">
        <div class="col d-flex justify-content-center">
            <nav aria-label="Page navigation example">
                <ul class="pagination">
                    <li class="page-item <?= $page == 1 ? 'disabled' : '' ?>">

                        <a class="page-link" href="?page=1">
                            第一頁
                        </a>
                    </li>

                    <li class="page-item <?= $page == 1 ? 'disabled' : '' ?>">
                        <!-- 點< 箭頭 連結到 上一頁 -->
                        <a class="page-link" href="?page=<?= $page - 1 ?>">
                            <i class="fas fa-arrow-circle-left"></i>
                        </a>
                    </li>
                    <!-- 用for 迴圈設定要出現幾個按鈕 出現 前三 i 後三 = 7個  -->
                    <?php for ($i = $page - 2; $i <= $page + 2; $i++) :
                        // 如果小於一就跳過
                        if ($i < 1) continue;
                        // 大於 總頁數也跳過
                        if ($i > $totalPages) break;
                    ?>
                        <!-- 這行表示 如果 你點到的頁數　= i就反白 -->
                        <li class="page-item <?= $i == $page ? 'active' : '' ?>">
                            <!-- 點第幾個按鈕就跳到第幾頁 -->
                            <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                        </li>
                    <?php endfor; ?>
                    <!-- 如果已經到最後一頁 換頁按鈕就會變暗 不給使用者繼續按 -->
                    <li class="page-item <?= $page == $totalPages ? 'disabled' : '' ?>">
                        <!-- 點> 箭頭 就跳到下一頁 -->
                        <a class="page-link" href="?page=<?= $page + 1 ?>">
                            <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </li>
                    <li class="page-item <?= $page == $totalPages  ? 'disabled' : '' ?>">

                        <a class="page-link" href="?page=<?= $totalPages ?>">
                            最後一頁
                        </a>
                    </li>

                </ul>
            </nav>

        </div>
    </div>
    <div class="row">
        <table class="table table-striped">

            <thead>
                <tr>
                    <th scope="col"><i class="fas fa-trash-alt "></i></th>
                    <th scope="col">#</th>
                    <th scope="col">商品名稱</th>
                    <th scope="col">價格</th>
                    <th scope="col">製造日期</th>
                    <th scope="col">使用期限</th>
                    <th scope="col">上架廠商</th>
                    <th scope="col"><i class="fas fa-edit"></i></th>

                </tr>
            </thead>
            <tbody>
                <!-- 用r去接收 撈到的資料  把他呈現在表格中-->
                <?php foreach ($rows as $r) : ?>
                    <tr>
                        <!-- `sid`, `name`, `price`, `MD`, `expried`, `firm` -->
                        <!-- htmlentities 跳脫 標籤 免得 被用戶惡意寫入js 破壞資料庫 -->
                        <td><a href="del.php?sid=<?= $r['sid'] ?>" onclick="ifDel(event)" data-sid="<?= $r['sid'] ?>">
                                <i class="fas fa-trash-alt"></i>
                            </a></td>
                        <td><?= htmlentities($r['sid']) ?></td>
                        <td><?= htmlentities($r['name']) ?></td>
                        <td><?= htmlentities($r['price']) ?></td>
                        <td><?= htmlentities($r['MD']) ?></td>
                        <td><?= htmlentities($r['expried']) ?></td>
                        <td><?= htmlentities($r['firm']) ?></td>
                        <td><a href="edit.php?sid=<?= $r['sid'] ?>"><i class="fas fa-edit"></i></a></td>

                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>


    <?php include __DIR__ . '/parts/js.php'; ?>
    <script>
        function ifDel(event) {
            const a = event.currentTarget;
            console.log(event.target, event.currentTarget);
            const sid = a.getAttribute('data-sid');
            // confirm 跟 alert一樣 等用戶按了之後 才會繼續往下
            // 案否取消連結 案是 就會執行 del檔案
            if (!confirm(`是否要刪除編號為 ${sid} 的資料?`)) {
                event.preventDefault(); // 取消連往 href 的設定
            }
        }
    </script>
    <?php include __DIR__ . '/parts/foot.php'; ?>