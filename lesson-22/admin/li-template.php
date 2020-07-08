<li>
    <div class="listing-prop listing-name" style="width: 301px;"><?= str_repeat("---", $num - 1).$row['name'] ?></div>
    <div class="listing-prop listing-button">
        <a href="./<?= $config_name ?>_delete.php?id=<?= $row['id'] ?>">Xóa</a>
    </div>
    <div class="listing-prop listing-button">
        <a href="./<?= $config_name ?>_editing.php?id=<?= $row['id'] ?>">Sửa</a>
    </div>
    <div class="listing-prop listing-button">
        <a href="./<?= $config_name ?>_editing.php?id=<?= $row['id'] ?>&task=copy">Copy</a>
    </div>
    <div class="listing-prop listing-time"><?= date('d/m/Y H:i', $row['created_time']) ?></div>
    <div class="listing-prop listing-time"><?= date('d/m/Y H:i', $row['last_updated']) ?></div>
    <div class="clear-both"></div>
</li>