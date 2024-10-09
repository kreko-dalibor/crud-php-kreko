<?php
include 'functions.php';
$pdo = pdo_connect_mysql();
$msg = '';

// Check if the book_id exists
if (isset($_GET['book_id'])) {
    if (!empty($_POST)) {
        // Update the record
        $book_id = $_GET['book_id'];
        $title = isset($_POST['title']) ? $_POST['title'] : '';
        $author = isset($_POST['author']) ? $_POST['author'] : '';
        $genre = isset($_POST['genre']) ? $_POST['genre'] : '';
        $available_copies = isset($_POST['available_copies']) ? $_POST['available_copies'] : 0;

        $stmt = $pdo->prepare('UPDATE books SET title = ?, author = ?, genre = ?, available_copies = ? WHERE book_id = ?');
        $stmt->execute([$title, $author, $genre, $available_copies, $book_id]);
        $msg = 'Updated Successfully!';
    }
    // Get the book from the books table
    $stmt = $pdo->prepare('SELECT * FROM books WHERE book_id = ?');
    $stmt->execute([$_GET['book_id']]);
    $book = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$book) {
        exit('Book doesn\'t exist with that ID!');
    }
} else {
    exit('No ID specified!');
}
?>
<?=template_header('Update Book')?>

<div class="content update">
	<h2>Update Book #<?=$book['book_id']?></h2>
    <form action="update_book.php?book_id=<?=$book['book_id']?>" method="post">
        <label for="title">Title</label>
        <label for="author">Author</label>
        <input type="text" name="title" placeholder="Title" value="<?=$book['title']?>" id="title">
        <input type="text" name="author" placeholder="Author" value="<?=$book['author']?>" id="author">
        <label for="genre">Genre</label>
        <label for="available_copies">Available Copies</label>
        <input type="text" name="genre" placeholder="Genre" value="<?=$book['genre']?>" id="genre">
        <input type="number" name="available_copies" placeholder="Available Copies" value="<?=$book['available_copies']?>" id="available_copies">
        <input type="submit" value="Update">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>
