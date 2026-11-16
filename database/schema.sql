-- AirAsia Rewards Redemption: HW3 database schema (SQLite)
-- Table and column names follow the AirAsia Requirements Document.
-- Running this script drops and recreates both tables, so it also resets the data.

DROP TABLE IF EXISTS ACCOUNT;
DROP TABLE IF EXISTS GIFTCARD;

-- Account table: used by the redemption work in HW4.
-- userId will point to the USER table, which is added in HW4.
CREATE TABLE ACCOUNT (
    accountId   INTEGER PRIMARY KEY AUTOINCREMENT,  -- int(11), auto-generated
    userId      INT NOT NULL,                       -- int(11)
    accountType VARCHAR(100) NOT NULL,              -- varchar(100)
    points      INT NOT NULL CHECK (points >= 0)    -- int(50)
);

-- Gift card table: managed by the HW3 pages (list, details, add, update, delete).
CREATE TABLE GIFTCARD (
    cardId    INTEGER PRIMARY KEY AUTOINCREMENT,    -- int(11), auto-generated
    cardName  VARCHAR(100) NOT NULL,                -- varchar(100)
    cardType  VARCHAR(100) NOT NULL,                -- varchar(100)
    cardValue FLOAT NOT NULL CHECK (cardValue > 0), -- float(10)
    points    INT NOT NULL CHECK (points > 0)       -- int(50)
);
