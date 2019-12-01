<nav class="breadcrumb">
    <a class="breadcrumb-item" href="<?php echo $baseUrl; ?>">首页</a>
    <span class="breadcrumb-item active">数据库查询示例</span>
</nav>

<div class="container">
    <h3>Mysql</h3>
    <p>ORM目前使用 <a target="_blank" href="https://medoo.lvtao.net/index.php">Medoo</a></p>
    <div class="card">
        <div class="card-body">
        <div>查询余票</div>
        <?php
        foreach ($tickets as $value) {
            echo $value . '<br/>';
        } ?>
        </div>
    </div>
    <h3>Redis</h3>
    <div class="card">
        <div class="card-body">
        redisK：<?php echo $redisK; ?>
        </div>
    </div>
</div>