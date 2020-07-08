<?php
include 'header.php';
$config_name = "menu";
$config_title = "danh mục";
if (!empty($_SESSION['current_user'])) {
    if (!empty($_GET['action']) && $_GET['action'] == 'search' && !empty($_POST)) {
        $_SESSION[$config_name . '_filter'] = $_POST;
        header('Location: ' . $config_name . '_listing.php');
        exit;
    }
    if (!empty($_SESSION[$config_name . '_filter'])) {
        $where = "";
        foreach ($_SESSION[$config_name . '_filter'] as $field => $value) {
            if (!empty($value)) {
                switch ($field) {
                    case 'name':
                        $where .= (!empty($where)) ? " AND " . "`" . $field . "` = '" . $value . "'" : "`" . $field . "` = '" . $value . "'";
                        break;
                    default:
                        $where .= (!empty($where)) ? " AND " . "`" . $field . "` = " . $value . "" : "`" . $field . "` = " . $value . "";
                        break;
                }
            }
        }
        extract($_SESSION[$config_name . '_filter']);
    }
    if (!empty($where)) {
        $currentMenu = mysqli_query($con, "SELECT * FROM `menu`  where (" . $where . ")");
        $currentMenu = mysqli_fetch_assoc($currentMenu);
        if (!empty($currentMenu)) {
            $menuList = mysqli_query($con, "SELECT * FROM `menu` ORDER BY `menu`.`position` ASC"); //Lấy tất cả các menu
            $menuList = mysqli_fetch_all($menuList, MYSQLI_ASSOC);
            $childrenMenu = createMenuTree($menuList, $currentMenu['id']); //Lấy các Menu con của Current Menu ID
            if (!empty($childrenMenu)) {
                $currentMenu['children'] = $childrenMenu;
            }
            $menuTree = array(
                $currentMenu
            );
        }
    } else {
        $menu = mysqli_query($con, "SELECT * FROM `menu` ORDER BY `menu`.`position` ASC");
        $menuList = mysqli_fetch_all($menu, MYSQLI_ASSOC);
        $menuTree = createMenuTree($menuList, 0); //Lấy các Menu con của Parent ID = 0;
    }
    mysqli_close($con);
    ?>
    <div class="main-content">
        <h1>Danh sách <?= $config_title ?></h1>
        <div class="listing-items">
            <div class="buttons">
                <a href="./<?= $config_name ?>_editing.php">Thêm <?= $config_title ?></a>
            </div>
            <div class="listing-search">
                <form id="<?= $config_name ?>-search-form" action="<?= $config_name ?>_listing.php?action=search" method="POST">
                    <fieldset>
                        <legend>Tìm kiếm <?= $config_title ?>:</legend>
                        Tên <?= $config_title ?>: <input type="text" name="name" value="<?= !empty($name) ? $name : "" ?>" />
                        <input type="submit" value="Tìm" />
                    </fieldset>
                </form>
            </div>
            <ul id="<?= $config_name ?>-list">
                <li class="listing-item-heading">
                    <div class="listing-prop listing-name"  style="width:301px;">Tên <?= $config_title ?></div>
                    <div class="listing-prop listing-button">
                        Xóa
                    </div>
                    <div class="listing-prop listing-button">
                        Sửa
                    </div>
                    <div class="listing-prop listing-button">
                        Copy
                    </div>
                    <div class="listing-prop listing-time">Ngày tạo</div>
                    <div class="listing-prop listing-time">Ngày cập nhật</div>
                    <div class="clear-both"></div>
                </li>
                <?php
                if (!empty($menuTree)) {
                    showMenuTree($menuTree, 0, $config_name);
                }
                ?>
            </ul>
            <div class="clear-both"></div>
        </div>
    </div>
    <?php
}
include './footer.php';
?>