<?php
require_once '../../classes/db_conn.php';
require_once '../../classes/crud.php';

$db = (new Database())->getConnection();
$crud = new GenericCrud($db);

// Only fetch users for initial page load
$users = $crud->read('users');
?>
<h1>Users</h1>
<form id="userForm" autocomplete="off">
    <input name="id" placeholder="ID" required>
    <input name="provider" placeholder="Provider" required>
    <input name="firebase_uid" placeholder="Firebase UID" required>
    <button type="submit">Create</button>
</form>
<div id="formResult" class="mt-2"></div>
<table class="table table-bordered mt-4">
    <tr><th>ID</th><th>Provider</th><th>Firebase UID</th></tr>
    <?php foreach ($users as $user): ?>
        <tr>
            <td><?=htmlspecialchars($user['id'])?></td>
            <td><?=htmlspecialchars($user['provider'])?></td>
            <td><?=htmlspecialchars($user['firebase_uid'])?></td>
        </tr>
    <?php endforeach; ?>
</table>
<script>
document.getElementById('userForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const form = e.target;
    const data = {
        table: 'users',
        action: 'create',
        payload: {
            id: form.id.value,
            provider: form.provider.value,
            firebase_uid: form.firebase_uid.value
        }
    };
    fetch('../router.php', {
        method: 'POST',
        headers: {'Content-Type': 'application/json'},
        body: JSON.stringify(data)
    })
    .then(res => res.json())
    .then(resp => {
        const resultDiv = document.getElementById('formResult');
        if (resp.success) {
            resultDiv.innerHTML = '<span class="text-success">User created! ID: ' + resp.id + '</span>';
            form.reset();
        } else {
            resultDiv.innerHTML = '<span class="text-danger">Error: ' + (resp.message || 'Unknown error') + '</span>';
        }
    });
});
</script>
<?php include '../footer.php'; ?>