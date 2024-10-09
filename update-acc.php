<?php
include 'functions.php';
$pdo = pdo_connect_mysql();
$msg = '';

// Provera da li postoji ID kontakta, npr. update.php?id=1
if (isset($_GET['id'])) {
    if (!empty($_POST)) {
        // Ova sekcija je slična kreiranju zapisa, ali ovde ažuriramo postojeći zapis
        $id = isset($_POST['id']) ? $_POST['id'] : NULL;
        $username = isset($_POST['username']) ? $_POST['username'] : '';
        $password = isset($_POST['password']) ? $_POST['password'] : '';
        $email = isset($_POST['email']) ? $_POST['email'] : '';
        
        // Hesuj lozinku pre nego što je uneseš u bazu (ako je korisnik menja)
        if (!empty($password)) {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        } else {
            // Ako lozinka nije promenjena, zadrži postojeću
            $stmt = $pdo->prepare('SELECT password FROM accounts WHERE id = ?');
            $stmt->execute([$_GET['id']]);
            $account = $stmt->fetch(PDO::FETCH_ASSOC);
            $hashed_password = $account['password'];
        }

        // Ažuriraj zapis u bazi
        $stmt = $pdo->prepare('UPDATE accounts SET id = ?, username = ?, password = ?, email = ? WHERE id = ?');
        $stmt->execute([$id, $username, $hashed_password, $email, $_GET['id']]);

        $msg = 'Updated Successfully!';
    }

    // Uzimanje podatka iz baze
    $stmt = $pdo->prepare('SELECT * FROM accounts WHERE id = ?');
    $stmt->execute([$_GET['id']]);
    $account = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$account) {
        exit('Account doesn\'t exist with that ID!');
    }
} else {
    exit('No ID specified!');
}
?>

<?=template_header('Update')?>

<div class="content update">
    <h2>Update Account #<?=$account['id']?></h2>
    <form action="update-acc.php?id=<?=$account['id']?>" method="post">
        <label for="id">ID</label>
        <label for="username">Username</label>
        <input type="text" name="id" placeholder="1" value="<?=$account['id']?>" id="id">
        <input type="text" name="username" placeholder="JohnDoe" value="<?=$account['username']?>" id="username">
        <label for="password">Password (leave blank to keep current)</label>
        <label for="email">Email</label>
        <input type="password" name="password" placeholder="Leave blank to keep current" id="password">
        <input type="text" name="email" placeholder="johndoe@example.com" value="<?=$account['email']?>" id="email">
        <input type="submit" value="Update">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>
