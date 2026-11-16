
## Use Case Traceability

| Use case | PHP page or pages | Database table | Test evidence |
| --- | --- | --- | --- |
| View a List of Gift Cards (requirements document: "View a list of gift cards") | card-list.php | GIFTCARD | Opened card-list.php and confirmed all 20 seeded gift cards appeared with an image, card name, and points required, and that each card linked to card-details.php. |
| View Details of One Gift Card (requirements document: "View details of one gift card") | card-details.php | GIFTCARD | Opened card-details.php?card_id=1 and confirmed the image, name, type, value, and points were shown as plain text with links to update, delete, and the list. |
| Add a Gift Card (requirements document: "Add data for a new gift card") | card-add.php | GIFTCARD | Submitted valid gift card data, confirmed the redirect to card-list.php, and confirmed the new record appeared in the list and in the database. |
| Update a Gift Card (requirements document: "Update data for one gift card") | card-update.php | GIFTCARD | Opened the prepopulated form, submitted changed values, and confirmed card-details.php showed the updated information. |
| Delete a Gift Card (requirements document: "Delete a card") | card-delete.php | GIFTCARD | Opened the confirmation page, confirmed that opening it did not delete the card, then submitted the confirmation form and confirmed the card was removed. |

Full test steps and results are in `test-report.md`.
