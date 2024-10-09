<?php
include 'functions.php';
$pdo = pdo_connect_mysql();
$msg = '';

// Check if POST data is not empty
if (!empty($_POST)) {
    // Set-up the variables that are going to be inserted, we must check if the POST variables exist if not we can default them to blank
    $book_id = isset($_POST['book_id']) && !empty($_POST['book_id']) && $_POST['book_id'] != 'auto' ? $_POST['book_id'] : NULL;
    $title = isset($_POST['title']) ? $_POST['title'] : '';
    $author = isset($_POST['author']) ? $_POST['author'] : '';
    $genre = isset($_POST['genre']) ? $_POST['genre'] : '';
    $available_copies = isset($_POST['available_copies']) ? $_POST['available_copies'] : 0;

    // Insert new record into the books table
    $stmt = $pdo->prepare('INSERT INTO books (book_id, title, author, genre, available_copies) VALUES (?, ?, ?, ?, ?)');
    $stmt->execute([$book_id, $title, $author, $genre, $available_copies]);
    // Output message
    $msg = 'Created Successfully!';
}
?>
<?=template_header('Create Book')?>

<div class="content update">
    <h2>Create Book</h2>
    <form action="create_book.php" method="post">
        <label for="book_id">Book ID</label>
        <label for="title">Title</label>
        <input type="text" name="book_id" placeholder="Book ID" value="auto" id="book_id">
        <input type="text" name="title" placeholder="Title" id="title">
        <label for="author">Author</label>
        <label for="genre">Genre</label>
        <input type="text" name="author" placeholder="Author" id="author">
        <input type="text" name="genre" placeholder="Genre" id="genre">
        <label for="available_copies">Available Copies</label>
        <input type="number" name="available_copies" placeholder="Available Copies" id="available_copies">
        <input type="submit" value="Create">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>
