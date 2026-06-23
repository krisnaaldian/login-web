<?php
include '../users.php';
include '../database.php';

$db = new Database();
$conn = $db->connect();
$user = new users($conn);

$result = $user->getAllUsers();
$daftar_user = $result->fetch_all(MYSQLI_ASSOC);  


$logged_in_username = $_SESSION['username'] ?? '';
$login_count = 0;
if ($logged_in_username) {
    $sql_user = "SELECT login_count FROM users WHERE username = '" . $conn->real_escape_string($logged_in_username) . "'";
    $res_user = $conn->query($sql_user);
    if ($res_user && $res_user->num_rows > 0) {
        $row_user = $res_user->fetch_assoc();
        $login_count = $row_user['login_count'];
    }
}
?>
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
          <h1 class= "mt-4"> Daftar User </h1>
          <hr />
          <?php if ($logged_in_username): ?>
          <div class="alert alert-success" role="alert">
            Selamat Datang <?php echo htmlspecialchars($logged_in_username); ?> Anda telah login sebanyak <?php echo htmlspecialchars($login_count); ?> kali
          </div>
          <?php endif; ?>
          <a href="index.php?halaman=tambah_user_form.php" class="btn btn-primary mb-2">Tambah User</a>
          <div class="table-responsive small">
            <table class="table table-striped table-sm">
              <thead>
                <tr>
                  <th scope="col">ID</th>
                  <th scope="col">Username</th>
                  <th scope="col">Email</th>
                  <th scope="col">Asal</th>
                  <th scope="col">Aksi</th>
                </tr>
              </thead>
              <tbody>
                <?php
                foreach ($daftar_user as $row) {
                  ?>
                <tr>
                  <td><?php echo $row['id']; ?></td>
                  <td><?php echo $row['username']; ?></td>
                  <td><?php echo $row['email']; ?></td>
                  <td><?php echo $row['asal']; ?></td>
                  <td>
                    <a href="delete_user.php?id=<?= $row['id'] ?>">delete</a>
                    <a href="index.php?halaman=edit_user_form.php&id=<?php echo $row ['id'];?>">| edit</a>
                  </td>
                </tr>
                <?php
                }
                ?>
              </tbody>
            </table>
          </div>
        </main>