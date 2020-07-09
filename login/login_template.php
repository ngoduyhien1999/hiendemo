<<li>
    <div id="user_login" class="box-content">
        <h1>Đăng nhập tài khoản</h1>
            <form action="./login.php" method="Post" autocomplete="off">
            <label>Username</label></br>
            <input type="text" name="username" value="" /><br/>
            <label>Password</label></br>
            <input type="password" name="password" value="" /></br>
            <input type="checkbox" name="remember-me" value="">
            <label for="remember-me">Ghi nhớ tài khoản</label>
            <br>
            <input type="submit" value="Đăng nhập" /><br/>
            <a href="./register.php">Click vào đây để đăng ký</a>
            </form>
            <h2>Hoặc đăng nhập với mạng xã hội</h2>
            <div id="login-with-social">
                <?php if(isset($authUrl)){ ?>
                <a href="<?= $loginUrl ?>"><img src="../asset/images/facebook.png" alt='facebook login' title="Facebook Login" height="50" width="280" /></a>
                <?php } ?>
                <?php if(isset($authUrl)){ ?>
                <a href="<?= $authUrl ?>"><img src="../asset/images/google.png" alt='google login' title="Google Login" height="50" width="280" /></a>
                <?php } ?>
        </div>
    </div>
</li>
