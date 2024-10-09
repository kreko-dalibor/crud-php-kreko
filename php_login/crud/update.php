
<?php
include 'functions.php';
$pdo = pdo_connect_mysql();
$msg = '';

// Check if the car id exists, for example update.php?id=1 will get the car with the id of 1
if (isset($_GET['id'])) {
    if (!empty($_POST)) {
        // This part is similar to the create.php, but instead we update a record and not insert
        $id = isset($_POST['id']) ? $_POST['id'] : NULL;
        $marka = isset($_POST['marka']) ? $_POST['marka'] : '';
        $model = isset($_POST['model']) ? $_POST['model'] : '';
        $vin = isset($_POST['vin']) ? $_POST['vin'] : '';
        $regnum = isset($_POST['regnum']) ? $_POST['regnum'] : '';
        $created = isset($_POST['created']) ? $_POST['created'] : '';
        
        // Update the record
        $stmt = $pdo->prepare('UPDATE cars SET marka = ?, model = ?, VIN = ? WHERE id = ?');
        $stmt->execute([$marka, $model, $vin, $id, $created, $regnum]);
        $msg = 'Updated Successfully!';
    }

    // Get the car from the cars table
    $stmt = $pdo->prepare('SELECT * FROM cars WHERE id = ?');
    $stmt->execute([$_GET['id']]);
    $car = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$car) {
        exit('Car doesn\'t exist with that ID!');
    }
} else {
    exit('No ID specified!');
}
?>

<?=template_header('Update')?>

<div class="content update">
    <h2>Update Car #<?=$car['id']?></h2>
    <form action="update.php?id=<?=$car['id']?>" method="post">
        <label for="id">ID</label>
        <label for="marka">Marka</label>
        <input type="text" name="id" placeholder="1" value="<?=$car['id']?>" id="id" readonly>
        <input type="text" name="marka" placeholder="Opel" value="<?=$car['marka']?>" id="marka">
        
        <label for="model">Model</label>
        <label for="vin">VIN</label>
        <input type="text" name="model" placeholder="Astra" value="<?=$car['model']?>" id="model">
        <input type="text" name="vin" placeholder="JSDFJ84584T5H8" value="<?=$car['VIN']?>" id="vin">
        
        <label for="regnum">Reg-num</label>
        <label for="created">Created</label>
        <input type="text" name="regnum" placeholder="NS-855LF" value="<?=$car['regnum']?>" id="regnum">
        <input type="date" name="created" placeholder="2024-09-12 11:35:08" value="<?=$car['created']?>" id="created">
        <!-- Removed created field as it's not in the table -->
        
        <input type="submit" value="Update">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>
