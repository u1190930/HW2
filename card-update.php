<?php
require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/gift-card-helpers.php';
require_once __DIR__ . '/includes/validation.php';

$isPost = ($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST';
$cardId = parseGiftCardId(
    $isPost ? ($_POST['card_id'] ?? null) : ($_GET['card_id'] ?? null),
);
$card = $cardId === null ? null : findGiftCard($pdo, $cardId);
$errors = [];

if ($card === null) {
    http_response_code(404);
} elseif ($isPost) {
    [$values, $errors] = validateGiftCardInput($_POST);

    if (!$errors) {
        $statement = $pdo->prepare(
            'UPDATE GIFTCARD SET cardName = :cardName, cardType = :cardType, '
            . 'cardValue = :cardValue, points = :points WHERE cardId = :cardId'
        );
        $statement->execute([
            'cardName' => $values['card_name'],
            'cardType' => $values['card_type'],
            'cardValue' => (float) $values['card_value'],
            'points' => (int) $values['points_required'],
            'cardId' => $cardId,
        ]);

        header('Location: card-details.php?card_id=' . $cardId);
        exit;
    }
}

if ($card !== null && !$isPost) {
    $values = [
        'card_name' => $card['cardName'],
        'card_type' => $card['cardType'],
        'card_value' => (string) $card['cardValue'],
        'points_required' => (string) $card['points'],
    ];
}

$pageTitle = 'Update Gift Card | AirAsia Rewards Redemption';
require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/nav.php';
?>
  <main class="container narrow">
    <?php if ($card === null): ?>
      <h1>Gift Card Not Found</h1>
      <p>The requested gift card could not be found.</p>
      <p><a href="card-list.php">Return to Gift Card List</a></p>
    <?php else: ?>
      <h1>Update Gift Card</h1>

      <?php if ($errors): ?>
        <ul class="form-errors" role="alert">
          <?php foreach ($errors as $error): ?>
            <li><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></li>
          <?php endforeach; ?>
        </ul>
      <?php endif; ?>

      <form action="card-update.php?card_id=<?= $cardId ?>" method="post">
        <input type="hidden" name="card_id" value="<?= $cardId ?>">

        <div class="field">
          <label for="card-name">Card Name</label>
          <input type="text" id="card-name" name="card_name" maxlength="100" required
                 value="<?= htmlspecialchars($values['card_name'], ENT_QUOTES, 'UTF-8') ?>">
        </div>

        <div class="field">
          <label for="card-type">Card Type</label>
          <select id="card-type" name="card_type" required>
            <option value="">Select a card type</option>
            <?php foreach (GIFT_CARD_TYPES as $type): ?>
              <option value="<?= htmlspecialchars($type, ENT_QUOTES, 'UTF-8') ?>"
                <?= $values['card_type'] === $type ? 'selected' : '' ?>>
                <?= htmlspecialchars($type, ENT_QUOTES, 'UTF-8') ?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>

        <div class="field">
          <label for="card-value">Card Value ($)</label>
          <input type="number" id="card-value" name="card_value" step="0.01" min="0.01" required
                 value="<?= htmlspecialchars($values['card_value'], ENT_QUOTES, 'UTF-8') ?>">
        </div>

        <div class="field">
          <label for="points-required">Points Required</label>
          <input type="number" id="points-required" name="points_required" step="1" min="1" required
                 value="<?= htmlspecialchars($values['points_required'], ENT_QUOTES, 'UTF-8') ?>">
        </div>

        <div class="actions">
          <button type="submit" class="btn">Save Changes</button>
          <a href="card-details.php?card_id=<?= $cardId ?>" class="btn btn-secondary">Cancel</a>
        </div>
      </form>
    <?php endif; ?>
  </main>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
