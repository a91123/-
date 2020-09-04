<?php
$page_title = '修改資料';
$page_name = 'edit';
// 與資料庫連線
require __DIR__ . '/parts/connect.php';
require __DIR__ . '/admin.php';
?>
<?php
// 如果有get到sid 就get到的sid 沒有get到就變0
$sid = isset($_GET['sid']) ? intval($_GET['sid']) : 0;
// 如果sid是空的就轉回list頁面
if (empty($sid)) {
    header('Location: list.php');
    exit;
}
// 
// MYSQL語法 (這邊的作用是 看你點到哪一個edit
$sql = " SELECT * FROM shop_list WHERE sid=$sid";
$row = $pdo->query($sql)->fetch();
// 如果沒有內容 轉回list頁面
if (empty($row)) {
    header('Location: list.php');
    exit;
}
?>

<?php require __DIR__ . '/parts/header.php'; ?>

<?php include __DIR__ . '/parts/navbar.php'; ?>
<div class="container">
    <div class="row">
        <div class="col-lg-6">
            <div id="infobar" class="alert alert-success" role="alert" style="display: none">
                A simple success alert—check it out!
            </div>
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">修改資料</h5>

                    <form name="form1" onsubmit="checkForm(); return false; novalidate">
                        <input type="hidden" name="sid" value="<?= $row['sid'] ?>">
                        <div class="form-group">
                            <label for="name"><span class="red-stars">**</span>產品名稱</label>
                            <input type="text" class="form-control" id="name" name="name" required value="<?= $row['name'] ?>">
                            <small class="form-text error-msg"></small>
                        </div>
                        <div class="form-group">
                            <label for="price"><span class="red-stars">**</span>價格</label>
                            <input type="int" class="form-control" id="price" name="price" value="<?= $row['price'] ?>">
                            <small class="form-text error-msg"></small>
                        </div>
                        <div class="form-group">
                            <label for="MD"><span class="red-stars">**</span>製造日期</label>
                            <input type="date" class="form-control" id="MD" name="MD" value="<?= $row['MD'] ?>">
                            <small class="form-text error-msg"></small>
                        </div>
                        <div class="form-group">
                            <label for="expried"><span class="red-stars">**</span>使用期限</label>
                            <input type="date" class="form-control" id="expried" name="expried" value="<?= $row['expried'] ?>">
                            <small class="form-text error-msg"></small>
                        </div>
                        <div class="form-group">
                            <label for="firm"><span class="red-stars">**</span>上架廠商</label>
                            <input type="text" class="form-control" name="firm" id="firm" value="<?= $row['firm'] ?>"></input>
                            <small class="form-text error-msg"></small>
                        </div>

                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>

        </div>
    </div>






</div>
<?php include __DIR__ . '/parts/js.php'; ?>
<script>
    // 列出正規表達式的格式
    // 檢視日期是否正確
    const date_pattern = /^[1-9]\d{3}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/;
    const $name = document.querySelector('#name');
    const $price = document.querySelector('#price');
    const $MD = document.querySelector('#MD');
    const $expried = document.querySelector('#expried');
    const $firm = document.querySelector('#firm');
    const r_fields = [$name, $MD, $expried, $price, firm];
    const infobar = document.querySelector('#infobar');
    const submitBtn = document.querySelector('button[type=submit]');

    function checkForm() {
        // 預設值為true
        let isPass = true;

        r_fields.forEach(el => {
            el.style.borderColor = '#CCCCCC';
            el.nextElementSibling.innerHTML = '';
        });
        // 成功送出 按鈕消失
        submitBtn.style.display = 'none';
        // TODO: 檢查資料格式
        // 檢查名字格式 小於二 提醒用戶
        if ($name.value.length < 2) {
            isPass = false;
            $name.style.borderColor = 'red';
            $name.nextElementSibling.innerHTML = '請填寫正確的產品名稱';
        }

        //   如日期不符合正規表達式 提醒用戶
        if (!date_pattern.test($MD.value)) {
            isPass = false;
            $MD.style.borderColor = 'red';
            $MD.nextElementSibling.innerHTML = '請填寫正確的製造日期';
        }
        //   如日期不符合正規表達式 提醒用戶
        if (!date_pattern.test($expried.value)) {
            isPass = false;
            $expried.style.borderColor = 'red';
            $expried.nextElementSibling.innerHTML = '請填寫正確的使用期限';
        }

        //   如果通過檢查 利用fetch傳到後端
        if (isPass) {
            // 使用formdata把 form做成表單 
            const fd = new FormData(document.form1);
            //把表格送給 inserapi 使用post 方法  body就是要送出的資料 這邊是form1 
            fetch('edit_api.php', {
                    method: 'POST',
                    body: fd
                })
                .then(r => r.json())
                .then(obj => {
                    if (obj.success) {
                        infobar.innerHTML = '修改成功';
                        infobar.className = "alert alert-success";
                        //if(infobar.classList.contains('alert-danger')){
                        //infobar.classList.replace('alert-danger', 'alert-success')
                        // }
                        setTimeout(() => {
                            location.href = 'list.php';
                        }, 3000)
                    } else {
                        infobar.innerHTML = obj.error || '資料沒有修改';
                        infobar.className = "alert alert-danger";
                        // if(infobar.classList.contains('alert-success')){
                        //     infobar.classList.replace('alert-success', 'alert-danger')
                        // }
                        submitBtn.style.display = 'block';
                    }
                    infobar.style.display = 'block';
                });

        } else {
            // 如果新增失敗submitBtn 會繼續留著
            submitBtn.style.display = 'block';
        }
    }
</script>
<?php include __DIR__ . '/parts/foot.php'; ?>