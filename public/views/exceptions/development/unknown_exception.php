<?php
/** @var \Exception|\Error|\ErrorException $exception */
?>

<div class="container">
    <h1 class="h2 text-center">
        Exception <?=$exception->getCode()?>
    </h1>

    <div class="list-group mt-4">
        <div class="list-group-item" aria-current="true">
            <div class="d-flex w-100 justify-content-between">
                <h5 class="mb-1">Message</h5>
            </div>
            <p class="mb-1"><?=$exception->getMessage()?></p>
        </div>
        <div class="list-group-item">
            <div class="d-flex w-100 justify-content-between">
                <h5 class="mb-1">Code</h5>
            </div>
            <p class="mb-1"><?=$exception->getCode()?></p>
        </div>
        <div class="list-group-item">
            <div class="d-flex w-100 justify-content-between">
                <h5 class="mb-1">File</h5>
            </div>
            <p class="mb-1"><?=$exception->getFile()?></p>
        </div>
        <div class="list-group-item">
            <div class="d-flex w-100 justify-content-between">
                <h5 class="mb-1">Line</h5>
            </div>
            <p class="mb-1"><?=$exception->getLine()?></p>
        </div>
        <div class="list-group-item">
            <div class="d-flex w-100 justify-content-between">
                <h5 class="mb-1">Trace</h5>
            </div>
            <div class="mt-1">
                <pre><?=$exception->getTraceAsString()?></pre>
            </div>
        </div>
        <div class="list-group-item">
            <div class="d-flex w-100 justify-content-between">
                <h5 class="mb-1">Dump</h5>
            </div>
            <p class="mb-1"><?php debug($exception)?></p>
        </div>
    </div>
</div>