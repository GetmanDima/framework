<?php
/** @var \Exception|\Error|\ErrorException $error */
?>

<div class="container">
    <h1 class="h2 text-center">
        Error
    </h1>

    <div class="list-group mt-4">
        <div class="list-group-item" aria-current="true">
            <div class="d-flex w-100 justify-content-between">
                <h5 class="mb-1">Message</h5>
            </div>
            <p class="mb-1"><?=$error['errstr']?></p>
        </div>
        <div class="list-group-item">
            <div class="d-flex w-100 justify-content-between">
                <h5 class="mb-1">Code</h5>
            </div>
            <p class="mb-1"><?=$error['errno']?></p>
        </div>
        <div class="list-group-item">
            <div class="d-flex w-100 justify-content-between">
                <h5 class="mb-1">File</h5>
            </div>
            <p class="mb-1"><?=$error['errfile']?></p>
        </div>
        <div class="list-group-item">
            <div class="d-flex w-100 justify-content-between">
                <h5 class="mb-1">Line</h5>
            </div>
            <p class="mb-1"><?=$error['errline']?></p>
        </div>
        <div class="list-group-item">
            <div class="d-flex w-100 justify-content-between">
                <h5 class="mb-1">Dump</h5>
            </div>
            <p class="mb-1"><?php debug($error)?></p>
        </div>
    </div>
</div>