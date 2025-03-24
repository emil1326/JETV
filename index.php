<?php

require 'src/functions.php';

require 'src/session.php';

require "src/configuration.php";

require "src/class/Database.php";

require "models/UserModel.php";

routeToController(uriPath());
