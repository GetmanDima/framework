<?php

require_once 'constants.php';
require_once 'functions.php';


if (DEBUG_MODE) {
    runDebugMode();
} else {
    runProductionMode();
}
