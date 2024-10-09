<?php
include 'functions.php';
$pdo = pdo_connect_mysql();
$msg = '';

// Check if the record id exists
if (isset($_GET['id'])) {
    if (!empty($_POST)) {
        // Update the record
        $id = $_GET['id'];
        $user_id = isset($_POST['user_id']) ? $_POST['user_id'] : '';
        $book_id = isset($_POST['book_id']) ? $_POST['book_id'] : '';
        $date_borrowed = isset($_POST['date_borrowed']) ? $_POST['date_borrowed'] : '';
        $date_returned = isset($_POST['date_returned']) ? $_POST['date_returned'] : '';

        $stmt = $pdo->prepare('UPDATE records SET user_id = ?, book_id = ?, date_borrowed = ?, date_returned = ? WHERE id = ?');
        $stmt->execute([$user_id, $book_id, $date_borrowed, $date_returned, $id]);
        $msg = 'Updated Successfully!';
    }
    // Get the record from the database
    $stmt = $pdo->prepare('SELECT * FROM records WHERE id = ?');
    $stmt->execute([$_GET['id']]);
    $contact = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$contact) {
        exit('Record doesn\'t exist with that ID!');
    }
} else {
    exit('No ID specified!');
}
?>
<?=template_header('Update')?>

<div class="content update">
	<h2>Update Record #<?=$contact['id']?></h2>
    <form action="update.php?id=<?=$contact['id']?>" method="post">
        <label for="user_id">User ID</label>
        <label for="book_id">Book ID</label>
        <input type="text" name="user_id" placeholder="User ID" value="<?=$contact['user_id']?>" id="user_id">
        <input type="text" name="book_id" placeholder="Book ID" value="<?=$contact['book_id']?>" id="book_id">
        <label for="date_borrowed">Date Borrowed</label>
        <label for="date_returned">Date Returned</label>
        <input type="datetime-local" name="date_borrowed" value="<?=date('Y-m-d\TH:i', strtotime($contact['date_borrowed']))?>" id="date_borrowed">
        <input type="datetime-local" name="date_returned" value="<?=date('Y-m-d\TH:i', strtotime($contact['date_returned']))?>" id="date_returned">
        <input type="submit" value="Update">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>
