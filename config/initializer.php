<?php

require_once 'constants.php';
require_once 'functions.php';


setCookieLifeTime();
setSessionLifeTime();

if (DEBUG_MODE) {
    runDebugMode();
} else {
    runProductionMode();
}
