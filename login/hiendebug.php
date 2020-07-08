<?php
system('tail -20 /var/log/httpd/hiendemo.uns.vn-error_log /home/hiendemo/logs/error-tmp.log');
echo nl2br(file_get_contents('/home/hiendemo/error-tmp.log'));
?>
