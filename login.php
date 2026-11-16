<?php
$pageTitle = 'Login | AirAsia Rewards Redemption';
require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/nav.php';
?>
  <main class="container narrow">
    <h1>AirAsia Rewards Redemption</h1>
    <h2>Login</h2>

    <form action="card-list.php" method="post">
      <div class="field">
        <label for="username">Username</label>
        <input type="text" id="username" name="username" placeholder="Enter username">
      </div>

      <div class="field">
        <label for="password">Password</label>
        <input type="password" id="password" name="password" placeholder="Enter password">
      </div>

      <button type="submit" class="btn">Login</button>
    </form>
  </main>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
