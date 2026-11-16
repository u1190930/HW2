<?php
require_once __DIR__ . '/includes/db.php';
$cards = $pdo->query(
    'SELECT cardId, cardName, points FROM GIFTCARD ORDER BY cardId'
)->fetchAll();

$pageTitle = 'Gift Cards | AirAsia Rewards Redemption';
require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/nav.php';
?>
  <main class="container">
    <header class="page-header">
      <h1>Gift Cards</h1>
    </header>

    <?php if ($cards): ?>
      <ul class="card-grid">
        <?php foreach ($cards as $card): ?>
          <?php
          $cardName = htmlspecialchars($card['cardName'], ENT_QUOTES, 'UTF-8');
          $detailsUrl = 'card-details.php?card_id=' . (int) $card['cardId'];
          ?>
          <li class="card">
            <a href="<?= $detailsUrl ?>"><img src="images/giftcard.jpg" alt="<?= $cardName ?>"></a>
            <h2><a href="<?= $detailsUrl ?>"><?= $cardName ?></a></h2>
            <p>Points required: <strong><?= number_format((int) $card['points']) ?></strong></p>
          </li>
        <?php endforeach; ?>
      </ul>
    <?php else: ?>
      <p>No gift cards are currently available.</p>
    <?php endif; ?>
  </main>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
