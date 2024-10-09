
<?php
include 'functions.php';
$pdo = pdo_connect_mysql();
$msg = '';

// Check if POST data is not empty
if (!empty($_POST)) {
    // Set-up the variables that are going to be inserted
    $id = isset($_POST['id']) && !empty($_POST['id']) && $_POST['id'] != 'auto' ? $_POST['id'] : NULL;
    $marka = isset($_POST['marka']) ? $_POST['marka'] : '';
    $model = isset($_POST['model']) ? $_POST['model'] : '';
    $vin = isset($_POST['vin']) ? $_POST['vin'] : '';
    $regnum = isset($_POST['regnum']) ? $_POST['regnum'] : '';
    $created = isset($_POST['created']) ? $_POST['created'] : '';
    
    // Insert new record into the cars table
    $stmt = $pdo->prepare('INSERT INTO cars (id, marka, model, VIN, regnum, created) VALUES (?, ?, ?, ?, ?, ?)');
    $stmt->execute([$id, $marka, $model, $vin, $regnum, $created]);

    // Output message
    $msg = 'Created Successfully!';
}
?>

<?=template_header('Create')?>

<div class="content update">
    <h2>Create Car</h2>
    <form action="create.php" method="post">
        <label for="id">ID</label>
        <label for="marka">Marka</label>
        <input type="text" name="id" placeholder="26" value="auto" id="id">
        <input type="text" name="marka" placeholder="Opel" id="marka">
        
        <label for="model">Model</label>
        <label for="vin">VIN</label>
        <input type="text" name="model" placeholder="Astra" id="model">
        <input type="text" name="vin" placeholder="JSDFJ84584T5H8" id="vin">

        <label for="regnum">Reg-num</label>
        <label for="created">Created</label>
        <input type="text" name="regnum" placeholder="NS-855LF" id="regnum">
        <input type="date" name="created" placeholder="2024-09-12 11:35:08" id="created">
        
        <input type="submit" value="Create">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>