<?php
$page_title = '資料列表';
// 這邊會用來判定點到哪個表單 使該表單出現active樣式 (在navbar上顯示)
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
            return `<li class="page-item ${obj.active}">
                    <a class="page-link" href="#${obj.page}">${obj.page}</a>
                    </li>`
        }
        let pageData;
        const tableRowTpl = (obj) => {
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
                        str += tableRowTpl(i);
                    }
                    tbody.innerHTML = str;

                    str = '';
                    for (let i = obj.page - 3; i <= obj.page + 3; i++) {
                        if (i < 1) continue;
                        if (i > obj.totalPages) continue;
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


                }

            );
    </script>
    <?php include __DIR__ . '/parts/foot.php'; ?>