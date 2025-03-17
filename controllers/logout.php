<?php
require 'src/session.php';
sessionStart();
$_SESSION = [];
sessionDestroy();
redirect('/');