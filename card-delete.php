<?php
require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/gift-card-helpers.php';
require_once __DIR__ . '/includes/validation.php';

$isPost = ($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST';
$cardId = parseGiftCardId(
    $isPost ? ($_POST['card_id'] ?? null) : ($_GET['card_id'] ?? null),
);
$card = $cardId === null ? null : findGiftCard($pdo, $cardId);
$error = null;

if ($card === null) {
    http_response_code(404);
} elseif ($isPost) {
    if (($_POST['confirm'] ?? null) !== 'delete') {
        $error = 'Confirm deletion using the Delete Gift Card button.';
    } else {
        $statement = $pdo->prepare('DELETE FROM GIFTCARD WHERE cardId = :cardId');
        $statement->bindValue(':cardId', $cardId, PDO::PARAM_INT);
        $statement->execute();

        if ($statement->rowCount() === 1) {
            header('Location: card-list.php');
            exit;
        }

        $card = null;
        http_response_code(404);
    }
}

$pageTitle = 'Delete Gift Card | AirAsia Rewards Redemption';
require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/nav.php';
?>
  <main class="container narrow">
    <?php if ($card === null): ?>
      <h1>Gift Card Not Found</h1>
      <p>The requested gift card could not be found.</p>
      <p><a href="card-list.php">Return to Gift Card List</a></p>
    <?php else: ?>
      <h1>Delete Gift Card</h1>
      <p>Are you sure you want to delete <strong><?= htmlspecialchars($card['cardName'], ENT_QUOTES, 'UTF-8') ?></strong>?</p>
      <p>Card type: <?= htmlspecialchars($card['cardType'], ENT_QUOTES, 'UTF-8') ?></p>
      <p>Card value: $<?= number_format((float) $card['cardValue'], 2) ?></p>
      <p>Points required: <?= number_format((int) $card['points']) ?></p>

      <?php if ($error !== null): ?>
        <p role="alert"><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></p>
      <?php endif; ?>

      <form action="card-delete.php" method="post">
        <input type="hidden" name="card_id" value="<?= $cardId ?>">
        <div class="actions">
          <button type="submit" name="confirm" value="delete" class="btn">Delete Gift Card</button>
          <a href="card-details.php?card_id=<?= $cardId ?>" class="btn btn-secondary">Cancel</a>
        </div>
      </form>
    <?php endif; ?>
  </main>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
