<?php
function findGiftCard(PDO $pdo, int $cardId): ?array
{
    $statement = $pdo->prepare(
        'SELECT cardId, cardName, cardType, cardValue, points FROM GIFTCARD WHERE cardId = :cardId'
    );
    $statement->bindValue(':cardId', $cardId, PDO::PARAM_INT);
    $statement->execute();
    $card = $statement->fetch();

    return $card ?: null;
}
