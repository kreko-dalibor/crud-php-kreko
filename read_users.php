<?php
include 'functions.php';
// Connect to MySQL database
$pdo = pdo_connect_mysql();
// Get the page via GET request (URL param: page), if non exists default the page to 1
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
// Number of records to show on each page
$records_per_page = 5;

$stmt = $pdo->prepare('SELECT * FROM users ORDER BY user_id LIMIT :current_page, :record_per_page');
$stmt->bindValue(':current_page', ($page-1)*$records_per_page, PDO::PARAM_INT);
$stmt->bindValue(':record_per_page', $records_per_page, PDO::PARAM_INT);
$stmt->execute();
// Fetch the records so we can display them in our template.
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

$num_users = $pdo->query('SELECT COUNT(*) FROM users')->fetchColumn();
?>

<?=template_header('Read Users')?>

<div class="content read">
	<h2>Read Users</h2>
	<a href="create_user.php" class="create-contact">Create User</a>
	<table>
        <thead>
            <tr>
                <td>User ID</td>
                <td>First Name</td>
                <td>Last Name</td>
                <td>Address</td>
                <td>Phone Number</td>
                <td>Date of Enrollment</td>
                <td></td>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user): ?>
            <tr>
                <td><?=$user['user_id']?></td>
                <td><?=$user['first_name']?></td>
                <td><?=$user['last_name']?></td>
                <td><?=$user['address']?></td>
                <td><?=$user['phone_number']?></td>
                <td><?=$user['date_of_enrollment']?></td>
                <td class="actions">
                    <a href="update_user.php?user_id=<?=$user['user_id']?>" class="edit"><i class="fas fa-pen fa-xs"></i></a>
                    <a href="delete_user.php?user_id=<?=$user['user_id']?>" class="trash"><i class="fas fa-trash fa-xs"></i></a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
	<div class="pagination">
		<?php if ($page > 1): ?>
		<a href="read_users.php?page=<?=$page-1?>"><i class="fas fa-angle-double-left fa-sm"></i></a>
		<?php endif; ?>
		<?php if ($page*$records_per_page < $num_users): ?>
		<a href="read_users.php?page=<?=$page+1?>"><i class="fas fa-angle-double-right fa-sm"></i></a>
		<?php endif; ?>
	</div>
</div>

<?=template_footer()?>
