
<h2 class="text-xl font-bold mb-6">Users</h2>
<div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm overflow-hidden">
    <table class="w-full text-left">
        <thead class="bg-gray-100 dark:bg-gray-700">
            <tr><th class="px-4 py-3">ID</th><th class="px-4 py-3">Username</th><th class="px-4 py-3">Email</th><th class="px-4 py-3">Role</th><th class="px-4 py-3">Status</th><th class="px-4 py-3">Actions</th></tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user): ?>
                <tr class="border-t border-gray-200 dark:border-gray-700 hover:bg-gray-50 transition">
                    <td class="px-4 py-3"><?= $user['id'] ?></td>
                    <td class="px-4 py-3 font-medium"><?= e($user['username']) ?></td>
                    <td class="px-4 py-3 text-gray-500"><?= e($user['email']) ?></td>
                    <td class="px-4 py-3"><?= $user['role_id'] == 1 ? 'Admin' : 'User' ?></td>
                    <td class="px-4 py-3"><?= ucfirst($user['status']) ?></td>
                    <td class="px-4 py-3">
                        <select onchange="updateUserRole(<?= $user['id'] ?>, this.value)" class="text-sm border rounded px-2 py-1">
                            <option value="">Set Role</option>
                            <option value="1">Admin</option>
                            <option value="2">User</option>
                        </select>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<script>
function updateUserRole(id, role) { if (!role) return; fetch('/admin/users/' + id, { method: 'PUT', headers: {'Content-Type': 'application/json', 'X-CSRF-TOKEN': '<?= e($_SESSION['_csrf_token'] ?? '') ?>'}, body: JSON.stringify({role: role === '1' ? 'admin' : 'user'}) }).then(() => location.reload()); }
</script>
