<?php

$page_name = 'list';
require __DIR__ . '/parts/connect.php';
?>
<?php require __DIR__ . '/parts/header.php'; ?>
<?php include __DIR__ . '/parts/navbar.php'; ?>

<div class="container">
    <div class="row">
        <div class="col d-flex justify-content-center">
            <nav aria-label="Page navigation example">
                <ul class="pagination">


                </ul>
            </nav>

        </div>
    </div>
    <div class="row">
        <table class="table table-striped">

            <thead>
                <tr>

                    <th scope="col">#</th>
                    <th scope="col">商品名稱</th>
                    <th scope="col">價格</th>
                    <th scope="col">製造日期</th>
                    <th scope="col">使用期限</th>
                    <th scope="col">上架廠商</th>


                </tr>
            </thead>
            <tbody>


            </tbody>
        </table>
    </div>


    <?php include __DIR__ . '/parts/js.php'; ?>
    <script>
        const tbody = document.querySelector('tbody')
        const pageItemTpl = (obj) => {
            // 設置一個 pageItemTpl 函數 顯示按鈕 
            return `<li class="page-item ${obj.active}">
                    <a class="page-link" href="#${obj.page}">${obj.page}</a>
                    </li>`
        }
        let pageData;
        const tableRowTpl = (obj) => {
            // 設置一個tableRowTpl 顯示 表格的內容
            return `
             
                    <tr>
                    
                    <td>${obj.sid}</td>
                    <td>${obj.name}</td>
                    <td>${obj.price}</td>
                    <td>${obj.MD}</td>
                    <td>${obj.expried}</td>
                    <td>${obj.firm}</td>
                    </tr>
                
                `;
        };
        fetch('list_api.php')
            .then(r => r.json())
            .then(obj => {
                    console.log(obj);
                    pageData = obj;

                    let str = '';
                    for (let i of obj.rows) {
                        // 用for迴圈 把fetch 接收到的rows 資料 遍歷出來 放入tableRowTpl中
                        str += tableRowTpl(i);
                    }
                    tbody.innerHTML = str;
                    // 把str 塞到 tbody裡
                    str = '';
                    for (let i = obj.page - 3; i <= obj.page + 3; i++) {
                        // 用for迴圈 把 fetch接收到的page資料 資料 遍歷出來 放入pageItemTpl中
                        if (i < 1) continue;
                        if (i > obj.totalPages) continue;
                        // 設置一個o 物件 把 page 塞進去  這邊的功能是用來判斷是否 進入active狀態
                        const o = {
                            page: i,
                            active: ''
                        }
                        if (obj.page === i) {
                            o.active = 'active';
                        }
                        str += pageItemTpl(o);
                    }
                    document.querySelector('.pagination').innerHTML = str;
                    // 把 str 塞到 class pagination裡

                }

            );
    </script>
    <?php include __DIR__ . '/parts/foot.php'; ?>