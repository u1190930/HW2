<?php
const GIFT_CARD_TYPES = ['Retail', 'Dining', 'Entertainment', 'Travel'];

function parseGiftCardId(mixed $value): ?int
{
    if (!is_int($value) && !is_string($value)) {
        return null;
    }

    $cardId = filter_var(
        $value,
        FILTER_VALIDATE_INT,
        ['options' => ['min_range' => 1]],
    );

    return is_int($cardId) ? $cardId : null;
}

function validateGiftCardInput(array $input): array
{
    $values = [];
    foreach (['card_name', 'card_type', 'card_value', 'points_required'] as $field) {
        $value = $input[$field] ?? '';
        $values[$field] = is_string($value) ? trim($value) : '';
    }

    $errors = [];
    $nameLength = preg_match_all('/./us', $values['card_name']);
    if ($values['card_name'] === '') {
        $errors[] = 'Card name is required.';
    } elseif ($nameLength === false) {
        $errors[] = 'Card name must use valid text.';
    } elseif ($nameLength > 100) {
        $errors[] = 'Card name must be 100 characters or fewer.';
    }

    if (!in_array($values['card_type'], GIFT_CARD_TYPES, true)) {
        $errors[] = 'Select a valid card type.';
    }

    if (
        !is_numeric($values['card_value'])
        || !is_finite((float) $values['card_value'])
        || (float) $values['card_value'] <= 0
    ) {
        $errors[] = 'Card value must be a positive number.';
    }

    if (filter_var(
        $values['points_required'],
        FILTER_VALIDATE_INT,
        ['options' => ['min_range' => 1]],
    ) === false) {
        $errors[] = 'Points required must be a positive whole number.';
    }

    return [$values, $errors];
}
