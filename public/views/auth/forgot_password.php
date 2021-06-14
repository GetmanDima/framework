<?php
if (isset($formErrors)) {
    $emailErrors = $formErrors['email'] ?? [];
} else {
    $emailErrors = [];
}
?>

<?php
if (isset($alertMessage)):
    ?>
    <div class="alert alert-<?=$alertMessage['type']?>" role="alert">
        <?=$alertMessage['text']?>
    </div>
<?php
endif
?>

<h2 class="h3 text-center mb-4">
    Forgot password
</h2>

<form action="/password/email" method="POST" class="col-md-8 col-lg-7 col-xl-6 mx-auto">
    <div class="form-group row mb-3">
        <label for="email" class="col-sm-2 col-form-label">Email</label>
        <div class="col-sm-10">
            <input name="email" type="email" class="form-control" id="email" placeholder="Email">
            <?php
            foreach ($emailErrors as $errorText):
                ?>
                <div class="form-text text-danger">
                    <?= $errorText ?>
                </div>
            <?php
            endforeach;
            ?>
        </div>
    </div>

    <div class="d-flex justify-content-end">
        <button type="submit" class="btn btn-primary">Send reset link</button>
    </div>
</form>