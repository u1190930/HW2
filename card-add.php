<?php
require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/validation.php';

$values = [
    'card_name' => '',
    'card_type' => '',
    'card_value' => '',
    'points_required' => '',
];
$errors = [];

if (($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST') {
    [$values, $errors] = validateGiftCardInput($_POST);

    if (!$errors) {
        $statement = $pdo->prepare(
            'INSERT INTO GIFTCARD (cardName, cardType, cardValue, points) '
            . 'VALUES (:cardName, :cardType, :cardValue, :points)'
        );
        $statement->execute([
            'cardName' => $values['card_name'],
            'cardType' => $values['card_type'],
            'cardValue' => (float) $values['card_value'],
            'points' => (int) $values['points_required'],
        ]);

        header('Location: card-list.php');
        exit;
    }
}

$pageTitle = 'Add Gift Card | AirAsia Rewards Redemption';
require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/nav.php';
?>
  <main class="container narrow">
    <h1>Add Gift Card</h1>

    <?php if ($errors): ?>
      <ul class="form-errors" role="alert">
        <?php foreach ($errors as $error): ?>
          <li><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></li>
        <?php endforeach; ?>
      </ul>
    <?php endif; ?>

    <form action="card-add.php" method="post">
      <div class="field">
        <label for="card-name">Card Name</label>
        <input type="text" id="card-name" name="card_name" maxlength="100" required
               value="<?= htmlspecialchars($values['card_name'], ENT_QUOTES, 'UTF-8') ?>"
               placeholder="Enter card name">
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
               value="<?= htmlspecialchars($values['card_value'], ENT_QUOTES, 'UTF-8') ?>"
               placeholder="0.00">
      </div>

      <div class="field">
        <label for="points-required">Points Required</label>
        <input type="number" id="points-required" name="points_required" step="1" min="1" required
               value="<?= htmlspecialchars($values['points_required'], ENT_QUOTES, 'UTF-8') ?>"
               placeholder="0">
      </div>

      <div class="actions">
        <button type="submit" class="btn">Add Gift Card</button>
        <a href="card-list.php" class="btn btn-secondary">Cancel</a>
      </div>
    </form>
  </main>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
