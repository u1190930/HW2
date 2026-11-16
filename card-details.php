<?php
require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/gift-card-helpers.php';
require_once __DIR__ . '/includes/validation.php';

$cardId = parseGiftCardId($_GET['card_id'] ?? null);
$card = $cardId === null ? null : findGiftCard($pdo, $cardId);
if (!$card) {
    http_response_code(404);
}

$pageTitle = 'Gift Card Details | AirAsia Rewards Redemption';
require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/nav.php';
?>
  <main class="container">
    <?php if ($card): ?>
      <?php $cardName = htmlspecialchars($card['cardName'], ENT_QUOTES, 'UTF-8'); ?>
      <header class="page-header">
        <h1>Gift Card Details</h1>
      </header>

      <div class="details">
        <img src="images/giftcard.jpg" alt="<?= $cardName ?>">

        <dl>
          <dt>Card ID</dt>
          <dd><?= (int) $card['cardId'] ?></dd>

          <dt>Card Name</dt>
          <dd><?= $cardName ?></dd>

          <dt>Card Type</dt>
          <dd><?= htmlspecialchars($card['cardType'], ENT_QUOTES, 'UTF-8') ?></dd>

          <dt>Card Value</dt>
          <dd>$<?= number_format((float) $card['cardValue'], 2) ?></dd>

          <dt>Points Required</dt>
          <dd><?= number_format((int) $card['points']) ?></dd>
        </dl>
      </div>

      <div class="actions details-actions">
        <a href="card-update.php?card_id=<?= $cardId ?>" class="btn">Edit Gift Card</a>
        <a href="card-delete.php?card_id=<?= $cardId ?>" class="btn btn-danger">Delete Gift Card</a>
        <a href="card-list.php" class="btn btn-secondary">Return to Gift Card List</a>
      </div>
    <?php else: ?>
      <header class="page-header">
        <h1>Gift Card Not Found</h1>
      </header>
      <p>The requested gift card could not be found.</p>
      <p><a href="card-list.php">Back to Gift Card List</a></p>
    <?php endif; ?>
  </main>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
