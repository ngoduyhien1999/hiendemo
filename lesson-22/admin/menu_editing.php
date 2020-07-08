<?php
include 'header.php';
if (!empty($_SESSION['current_user'])) {
    ?>
    <div class="main-content">
        <h1><?= !empty($_GET['id']) ? ((!empty($_GET['task']) && $_GET['task'] == "copy") ? "Copy danh mục" : "Sửa danh mục") : "Thêm danh mục" ?></h1>
        <div id="content-box">
            <?php
            if (isset($_GET['action']) && ($_GET['action'] == 'add' || $_GET['action'] == 'edit')) {
                if (isset($_POST['name']) && !empty($_POST['name']) && isset($_POST['link']) && !empty($_POST['link'])) {
                    if (empty($_POST['name'])) {
                        $error = "Bạn phải nhập tên danh mục";
                    } elseif (empty($_POST['link'])) {
                        $error = "Bạn phải nhập link danh mục";
                    } elseif (empty($_POST['position'])) {
                        $error = "Bạn phải nhập thứ tự danh mục";
                    } 
                    if (!isset($error)) {
                        if ($_GET['action'] == 'edit' && !empty($_GET['id'])) { //Cập nhật lại danh mục                            
                            $result = mysqli_query($con, "UPDATE `menu` SET `name` = '".$_POST['name']."', `link` = '".$_POST['link']."', `parent_id` = '".$_POST['parent_id']."', `position` = '".$_POST['position']."', `last_updated` = '".time()."' WHERE `menu`.`id` = ".$_GET['id'].";");
                        } else { //Thêm danh mục
                            $result = mysqli_query($con, "INSERT INTO `menu` (`id`, `parent_id`, `name`, `link`, `position`, `created_time`, `last_updated`) VALUES (NULL, '".$_POST['parent_id']."', '".$_POST['name']."', '".$_POST['link']."', '".$_POST['position']."', ".time().", ".time().");");
                        }
                        if (!$result) { //Nếu có lỗi xảy ra
                            $error = "Có lỗi xảy ra trong quá trình thực hiện.";
                        } 
                    }
                } else {
                    $error = "Bạn chưa nhập thông tin danh mục.";
                }
                ?>
                <div class = "container">
                    <div class = "error"><?= isset($error) ? $error : "Cập nhật thành công" ?></div>
                    <a href = "menu_listing.php">Quay lại danh sách danh mục</a>
                </div>
                <?php
            } else {
                $result = mysqli_query($con, "SELECT * FROM `menu` ORDER BY `menu`.`position` ASC");
                $menuList = mysqli_fetch_all($result, MYSQLI_ASSOC);
                $menuTree = createMenuTree($menuList, 0);
                //Sửa danh mục
                if (!empty($_GET['id'])) {
                    $result = mysqli_query($con, "SELECT * FROM `menu` WHERE `id` = " . $_GET['id']);
                    $currentMenu = $result->fetch_assoc();
                }
                ?>
                <form id="editing-form" method="POST" action="<?= (!empty($currentMenu) && !isset($_GET['task'])) ? "?action=edit&id=" . $_GET['id'] : "?action=add" ?>"  enctype="multipart/form-data">
                    <input type="submit" title="Lưu danh mục" value="" />
                    <div class="clear-both"></div>
                    <div class="wrap-field">
                        <label>Tên danh mục: </label>
                        <input type="text" name="name" value="<?= (!empty($currentMenu) ? $currentMenu['name'] : "") ?>" />
                        <div class="clear-both"></div>
                    </div>
                    <div class="wrap-field">
                        <label>Danh mục cha: </label>
                        <select name="parent_id">
                            <option value="">Lựa chọn</option>
                            <?php
                            if (!empty($menuTree)) {
                                showMenuSelectBox($menuTree, 0, $currentMenu['parent_id']);
                            }
                            ?>
                        </select>
                        <div class="clear-both"></div>
                    </div>
                    <div class="wrap-field">
                        <label>Link: </label>
                        <input type="text" name="link" value="<?= (!empty($currentMenu) ? $currentMenu['link'] : "") ?>" />
                        <div class="clear-both"></div>
                    </div>
                    <div class="wrap-field">
                        <label>Thứ tự: </label>
                        <input type="text" name="position" value="<?= (!empty($currentMenu) ? $currentMenu['position'] : "") ?>" />
                        <div class="clear-both"></div>
                    </div>
                </form>
                <div class="clear-both"></div>
            <?php } ?>
        </div>
    </div>

    <?php
}
include './footer.php';
?>