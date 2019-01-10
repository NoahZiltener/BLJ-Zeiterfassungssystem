<?php include 'models/login.model.php'; ?>

<div class="wrapper">
    <form name="blog-form" action="index.php?page=login" method="post">
        <fieldset>
            <legend class="form-legend">Sign In</legend>
            <div class="form-group">
                <label class="form-label" for="username">Username</label>
                <input class="form-control" type="text" id="UserName" name="UserName">
            </div>
            <div class="form-group">
                <label class="form-label" for="passwd">Passwort</label>
                <input class="form-control" type="password" id="passwd" name="passwd">
            </div>
        </fieldset>
        <div class="form-actions">
            <input class="btn btn-primary" type="submit" value="Login">
        </div>
    </form>
    <?php if(sizeof($errors) !== 0):?>
            <ul class="error-box">
                <?php foreach($errors as $error): ?>
                    <li><?= $error ?></li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
</div>