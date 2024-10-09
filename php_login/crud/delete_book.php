<?php
include 'functions.php';
$pdo = pdo_connect_mysql();
$msg = '';

// Check if the book_id exists
if (isset($_GET['book_id'])) {
    // Select the record that is going to be deleted
    $stmt = $pdo->prepare('SELECT * FROM books WHERE book_id = ?');
    $stmt->execute([$_GET['book_id']]);
    $book = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$book) {
        exit('Book doesn\'t exist with that ID!');
    }

    // Check if the confirmation form has been submitted
    if (isset($_GET['confirm'])) {
        if ($_GET['confirm'] == 'yes') {
            // Delete the record
            $stmt = $pdo->prepare('DELETE FROM books WHERE book_id = ?');
            $stmt->execute([$_GET['book_id']]);
            $msg = 'You have deleted the book!';
        } else {
            // User clicked the "No" button, redirect them back to the read page
            header('Location: read_books.php');
            exit;
        }
    }
} else {
    exit('No ID specified!');
}
?>
<?=template_header('Delete Book')?>

<div class="content delete">
    <h2>Delete Book #<?=$book['book_id']?></h2>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php else: ?>
    <p>Are you sure you want to delete book #<?=$book['book_id']?>?</p>
    <div class="yesno">
        <a href="delete_book.php?book_id=<?=$book['book_id']?>&confirm=yes">Yes</a>
        <a href="delete_book.php?book_id=<?=$book['book_id']?>&confirm=no">No</a>
    </div>
    <?php endif; ?>
</div>

<?=template_footer()?>
