<?php
session_start();
session_unset();
session_destroy();
session_write_close();
setcookie(session_name(),'',0,'/');
session_regenerate_id(true);

require_once 'src/utils/links.php';
$index = get_index_page_link();
header("Location: $index");
