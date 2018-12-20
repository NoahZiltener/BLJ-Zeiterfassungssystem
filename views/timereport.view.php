<?php include 'models/timereport.model.php';
$userid = $_SESSION['UserID'];
?> 
        <?php foreach($alluserstamps as $stamp): ?>

            <p>
                <?= htmlspecialchars($stamp['StampDateandTime'], ENT_QUOTES, "UTF-8"); ?>
            </p>

        <?php endforeach;?>
        <?php foreach($users as $user): ?>
                    <p>
                        <?= htmlspecialchars($user['UserName'], ENT_QUOTES, "UTF-8"); ?>
                    </p>
        <?php endforeach;?>

    <form name="blog-form" action="index.php?page=logout" method="post">     
            <div class="form-actions">
                <input class="btn btn-primary" type="submit" value="Logout">
            </div>
    </form>

