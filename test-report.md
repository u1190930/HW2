# Gift Card Application Test Report

**Test date:** 2026-11-16  
**Environment:** PHP built-in server at `http://127.0.0.1:8000`; SQLite database initialized from the supplied schema and seed files.

| Test ID | Test steps and input | Expected result | Actual result | Status |
|---|---|---|---|---|
| T01 | Open `/tests/validation-tests.php`. | Each validation case displays PASS or FAIL; no database records are modified. | All 8 harness cases displayed PASS. The Gift Card record count was unchanged. | PASS |
| T02 | Open `/card-list.php`. | The page displays the Gift Card records and a link to add a card. | HTTP 200; 20 cards rendered with the Add Gift Card link. | PASS |
| T03 | Open `/card-details.php?card_id=2`. | The selected card’s attributes and Edit, Delete, and Return links are displayed. | HTTP 200; Target Gift Card details and all three links rendered. | PASS |
| T04 | POST a new card: name `Validation Report Test 2026-11-16`, type `Retail`, value `25.50`, points `2550`. | The valid record is inserted and the response redirects to the list. | HTTP 302 redirect; the record was inserted. It was removed during T06. | PASS |
| T05 | Open the new card’s edit form, then POST name `Validation Report Edited 2026-11-16`, type `Travel`, value `75.25`, points `7525`. | The form is prepopulated; valid changes are saved and the updated details are displayed. | The form showed the original values; HTTP 302 redirect followed the update, and the details page showed the updated values. | PASS |
| T06 | Open the delete page with GET, then confirm with POST `confirm=delete` and the test card ID. | GET only shows the confirmation; confirmed POST deletes the card and redirects to the list. | GET left the record intact. Confirmed POST returned HTTP 302 and removed only the test record; the original count was restored. | PASS |
| T07 | POST card name `<script>alert(1)</script>`, type `Altered`, value `0`, points `1.5`. | Validation errors are shown, echoed form text is safely escaped, and no record is inserted. | Errors appeared for type, value, and points; the name was HTML-escaped; the record count did not change. | PASS |
| T08 | Open details with `card_id=not-an-integer` and with `card_id=2 OR 1=1`. | Invalid identifiers are rejected safely without changing records. | Both requests returned HTTP 404; the record count did not change. | PASS |

## Defect found and retested

The SQLite database initially had no tables, causing the Gift Card list query to return HTTP 500. The database was initialized using `database/schema.sql` and `database/seed.sql` (20 Gift Cards and 6 Accounts). The list and details pages were retested successfully in T02 and T03.
