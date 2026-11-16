<?php
require_once __DIR__ . '/../includes/validation.php';

$validCard = [
    'card_name' => 'Test Gift Card',
    'card_type' => 'Retail',
    'card_value' => '25.00',
    'points_required' => '2500',
];

$hasError = static function (array $input, string $expectedError): bool {
    [, $errors] = validateGiftCardInput($input);
    return in_array($expectedError, $errors, true);
};

$tests = [
    [
        'name' => 'Valid Gift Card data',
        'expected' => 'Passes validation',
        'check' => static fn (): bool => validateGiftCardInput($validCard)[1] === [],
    ],
    [
        'name' => 'Blank Card Name',
        'expected' => 'Fails validation',
        'check' => static fn (): bool => $hasError(
            array_merge($validCard, ['card_name' => '']),
            'Card name is required.',
        ),
    ],
    [
        'name' => 'Altered or invalid Card Type',
        'expected' => 'Fails validation',
        'check' => static fn (): bool => $hasError(
            array_merge($validCard, ['card_type' => 'Invalid Type']),
            'Select a valid card type.',
        ),
    ],
    [
        'name' => 'Zero Card Value',
        'expected' => 'Fails validation',
        'check' => static fn (): bool => $hasError(
            array_merge($validCard, ['card_value' => '0']),
            'Card value must be a positive number.',
        ),
    ],
    [
        'name' => 'Negative Card Value',
        'expected' => 'Fails validation',
        'check' => static fn (): bool => $hasError(
            array_merge($validCard, ['card_value' => '-1']),
            'Card value must be a positive number.',
        ),
    ],
    [
        'name' => 'Invalid Points Required',
        'expected' => 'Fails validation',
        'check' => static fn (): bool => $hasError(
            array_merge($validCard, ['points_required' => '2500.5']),
            'Points required must be a positive whole number.',
        ),
    ],
    [
        'name' => 'Valid Gift Card identifier',
        'expected' => 'Passes validation',
        'check' => static fn (): bool => parseGiftCardId('12') === 12,
    ],
    [
        'name' => 'Invalid Gift Card identifier',
        'expected' => 'Fails validation',
        'check' => static fn (): bool => parseGiftCardId('12 OR 1=1') === null,
    ],
];

$results = [];
foreach ($tests as $test) {
    try {
        $passed = ($test['check'])();
        $exceptionMessage = null;
    } catch (Throwable $error) {
        $passed = false;
        $exceptionMessage = $error->getMessage();
    }

    $results[] = [
        'name' => $test['name'],
        'expected' => $test['expected'],
        'passed' => $passed,
        'exception' => $exceptionMessage,
    ];
}

$passedCount = count(array_filter($results, static fn (array $result): bool => $result['passed']));
$allPassed = $passedCount === count($results);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Validation Tests | AirAsia Rewards Redemption</title>
  <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
  <main class="container">
    <h1>Validation Test Harness</h1>
    <p>These tests call the shared validation functions and do not modify database records.</p>

    <table class="validation-results">
      <thead>
        <tr>
          <th scope="col">Test</th>
          <th scope="col">Expected behavior</th>
          <th scope="col">Result</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($results as $result): ?>
          <tr>
            <th scope="row"><?= htmlspecialchars($result['name'], ENT_QUOTES, 'UTF-8') ?></th>
            <td><?= htmlspecialchars($result['expected'], ENT_QUOTES, 'UTF-8') ?></td>
            <td class="<?= $result['passed'] ? 'test-pass' : 'test-fail' ?>">
              <?= $result['passed'] ? 'PASS' : 'FAIL' ?>
              <?php if ($result['exception'] !== null): ?>
                — <?= htmlspecialchars($result['exception'], ENT_QUOTES, 'UTF-8') ?>
              <?php endif; ?>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>

    <p class="<?= $allPassed ? 'test-pass' : 'test-fail' ?>">
      <?= $passedCount ?> of <?= count($results) ?> tests passed.
    </p>
    <p><a class="btn btn-secondary" href="../card-list.php">Return to Gift Card List</a></p>
  </main>
</body>
</html>
