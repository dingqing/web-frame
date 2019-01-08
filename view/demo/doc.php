<h3>数据库查询示例</h3>
<ul>
    <li>
        <p>Mysql。ORM目前使用 <a target="_blank" href="https://medoo.lvtao.net/index.php">Medoo</a></p>
        <div>查询余票</div>
        <?php
        foreach ($tickets as $value) {
            echo $value . '<br/>';
        } ?>
    </li>
    <li>
        <p>Redis。</p>
        <div>redisK：<?php echo $redisK; ?></div>
    </li>
</ul>

