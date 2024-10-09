
<?php
include 'functions.php';
$pdo = pdo_connect_mysql();
$msg = '';

// Check if POST data is not empty
if (!empty($_POST)) {
    // Set-up the variables that are going to be inserted
    $id = isset($_POST['id']) && !empty($_POST['id']) && $_POST['id'] != 'auto' ? $_POST['id'] : NULL;
    $username = isset($_POST['username']) ? $_POST['username'] : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    
    // Insert new record into the accounts table
    $stmt = $pdo->prepare('INSERT INTO accounts (id, username, password, email) VALUES (?, ?, ?, ?)');
    $stmt->execute([$id, $username, $password, $email]);

    // Output message
    $msg = 'Created Successfully!';
}
?>

<?=template_header('Create')?>

<div class="content update">
    <h2>Create Account</h2>
    <form action="create-acc.php" method="post">
        <label for="id">ID</label>
        <label for="username">Username</label>
        <input type="text" name="id" value="auto" id="id">
        <input type="text" name="username" id="username">
        
        <label for="password">Password</label>
        <label for="email">Email</label>
        <input type="text" name="password" id="password">
        <input type="text" name="email" id="email">

        <input type="submit" value="Create">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>
