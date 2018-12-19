<?php include 'models/timereport.model.php';
$userid = $_SESSION['UserID'];
?>
 
<?php foreach($user as $user): ?>
            <h1>
                <?= htmlspecialchars($user['UserName'], ENT_QUOTES, "UTF-8"); ?>
            </h1>
<?php endforeach;?>
<form name="blog-form" action="index.php?page=logout" method="post">     
        <div class="form-actions">
            <input class="btn btn-primary" type="submit" value="Logout">
        </div>
</form>

