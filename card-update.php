<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Update Gift Card | AirAsia Rewards Redemption</title>
  <link rel="stylesheet" href="css/styles.css">
</head>
<body>
  <main class="container narrow">
    <h1>Update Gift Card</h1>

    <form action="card-list.php" method="post">
      <div class="field">
        <label for="card-name">Card Name</label>
        <input type="text" id="card-name" name="card_name" value="Amazon Gift Card">
      </div>

      <div class="field">
        <label for="card-type">Card Type</label>
        <select id="card-type" name="card_type">
          <option value="">Select a card type</option>
          <option value="Retail" selected>Retail</option>
          <option value="Dining">Dining</option>
          <option value="Entertainment">Entertainment</option>
          <option value="Travel">Travel</option>
        </select>
      </div>

      <div class="field">
        <label for="card-value">Card Value ($)</label>
        <input type="number" id="card-value" name="card_value" step="0.01" min="0" value="25.00">
      </div>

      <div class="field">
        <label for="points-required">Points Required</label>
        <input type="number" id="points-required" name="points_required" step="1" min="0" value="2500">
      </div>

      <div class="actions">
        <button type="submit" class="btn">Submit</button>
        <a href="card-details.php" class="btn btn-secondary">Cancel</a>
      </div>
    </form>
  </main>
</body>
</html>