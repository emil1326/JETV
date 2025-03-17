<?php

require 'src/functions.php';

require 'src/session.php';

require "src/configuration.php";

routeToController(uriPath());
