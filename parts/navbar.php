<?php
if (!isset($page_name)) $page_name = '';
?>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
        <a class="navbar-brand" href="#"></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">

                <li class="nav-item <?= $page_name == 'list' ? 'active' : '' ?>">

                    <a class="nav-link" href="list.php">列表</a>
                </li>
                <li class="nav-item <?= $page_name == 'inser' ? 'active' : '' ?>">
                    <a class="nav-link" href="inser.php">新增</a>
                </li>

            </ul>

            <ul class="navbar-nav ">
                <?php if (isset($_SESSION['admin'])) : ?>
                    <li class="nav-item">
                        <a class="nav-link"><?= $_SESSION['admin']['nickname'] ?></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">登出</a>
                    </li>

                <?php else : ?>
                    <li class="nav-item <?= $page_name == 'login' ? 'active' : '' ?>">
                        <a class="nav-link" href="login.php">登入</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="member.php">免費註冊</a>
                    </li>
                <?php endif; ?>
                </li>


            </ul>



        </div>
    </div>
</nav>
<style>
    .navbar .nav-item.active {
        background-color: #7abaff;

    }
</style>