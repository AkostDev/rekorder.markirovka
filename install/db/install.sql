CREATE TABLE IF NOT EXISTS `ro_account` (
    `ID` int(10) UNSIGNED AUTO_INCREMENT NOT NULL,
    `NAME` varchar(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci,
    `ACCESS_KEY` varchar(100) NOT NULL COLLATE utf8mb4_unicode_ci,
    `DATE_CREATE` datetime NOT NULL,
    `DATE_UPDATE` datetime NOT NULL,
    PRIMARY KEY (`ID`),
    UNIQUE INDEX `ux_ro_account_access_key` (`ACCESS_KEY`) USING BTREE
);