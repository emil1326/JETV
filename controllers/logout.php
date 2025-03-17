<?php
sessionStart();
$_SESSION = [];
sessionDestroy();
redirect('/');