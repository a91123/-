<?php
if (!isset($page_name)) $page_name = '';
?>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
        <a class="navbar-brand" href="#">Navbar</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <!-- 用pagename判定點到哪個表單 然後更改他的css -->
                <li class="nav-item <?= $page_name == 'list' ? 'active' : '' ?>">

                    <a class="nav-link" href="list.php">列表</a>
                </li>
                <li class="nav-item <?= $page_name == 'inser' ? 'active' : '' ?>">
                    <a class="nav-link" href="inser.php">新增</a>
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