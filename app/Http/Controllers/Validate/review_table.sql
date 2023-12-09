CREATE TABLE bas_prototype_review(
    id INT NOT NULL AUTO_INCREMENT,
    firstname VARCHAR(255) NOT NULL,
    lastname VARCHAR(255) NOT NULL,
    sku VARCHAR(255) NOT NULL,
    design INT NOT NULL,
    valueForMoney INT NOT NULL,
    strap INT NOT NULL,
    buckle INT NOT NULL,
    durability INT NOT NULL,
    functionality INT NOT NULL,
    support INT NOT NULL,
    comfort INT NOT NULL,
    reviewDate DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY(id)
);