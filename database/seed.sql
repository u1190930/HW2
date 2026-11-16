-- AirAsia Rewards Redemption: HW3 sample data
-- Run after schema.sql. Contains 6 ACCOUNT rows and 20 GIFTCARD rows.
-- Gift cards are priced at 100 points per dollar of card value.

INSERT INTO ACCOUNT (userId, accountType, points) VALUES
    (1, 'Platinum', 25000),
    (2, 'Gold',     12000),
    (3, 'Gold',      8500),
    (4, 'Silver',    4200),
    (5, 'Standard',  1500),
    (6, 'Standard',   300);

INSERT INTO GIFTCARD (cardName, cardType, cardValue, points) VALUES
    ('Amazon Gift Card',      'Retail',        25.00,  2500),
    ('Target Gift Card',      'Retail',        25.00,  2500),
    ('Walmart Gift Card',     'Retail',        20.00,  2000),
    ('Best Buy Gift Card',    'Retail',        50.00,  5000),
    ('Apple Gift Card',       'Retail',        50.00,  5000),
    ('Starbucks Gift Card',   'Dining',        10.00,  1000),
    ('Uber Eats Gift Card',   'Dining',        30.00,  3000),
    ('DoorDash Gift Card',    'Dining',        25.00,  2500),
    ('Chipotle Gift Card',    'Dining',        15.00,  1500),
    ('Subway Gift Card',      'Dining',        10.00,  1000),
    ('Netflix Gift Card',     'Entertainment', 15.00,  1500),
    ('Spotify Gift Card',     'Entertainment', 10.00,  1000),
    ('Steam Gift Card',       'Entertainment', 20.00,  2000),
    ('Google Play Gift Card', 'Entertainment', 25.00,  2500),
    ('Xbox Gift Card',        'Entertainment', 25.00,  2500),
    ('Grab Gift Card',        'Travel',        20.00,  2000),
    ('Uber Gift Card',        'Travel',        25.00,  2500),
    ('Airbnb Gift Card',      'Travel',       100.00, 10000),
    ('Expedia Gift Card',     'Travel',        50.00,  5000),
    ('Lyft Gift Card',        'Travel',        15.00,  1500);
