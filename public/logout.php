<?php
session_start();
session_unset(); // removes all session variables
session_destroy(); // ends the session

header("Location: /asset-forge-marketplace/public/");
exit;