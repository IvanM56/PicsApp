
DROP DATABASE IF EXISTS `picsapp`;
CREATE DATABASE IF NOT EXISTS `picsapp` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `picsapp`;

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
    `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
    `username` varchar(20) NOT NULL,
    `email` varchar(255) NOT NULL,
    `password` varchar(255) NOT NULL,
    `profile_img` varchar(255) NOT NULL, 
    `pic_count` int(10) NOT NULL,
    `token` varchar(255) NOT NULL,
    `token_expires` datetime NOT NULL,
    `created_at` datetime NOT NULL DEFAULT current_timestamp(),
    PRIMARY KEY (`id`),
    UNIQUE KEY (`email`)
)ENGINE = InnoDB;

DROP TABLE IF EXISTS `images`;
CREATE TABLE IF NOT EXISTS `images` (
    `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
    `user_id` int(10) UNSIGNED NOT NULL,
    `img_name` varchar(255) NOT NULL,
    `uploaded_at` datetime NOT NULL DEFAULT current_timestamp(),
    PRIMARY KEY (`id`)
    -- FOREIGN KEY (`user_id`) REFERENCES `users`(`id`)
)ENGINE = InnoDB;

DROP TABLE IF EXISTS `remember`;
CREATE TABLE IF NOT EXISTS `remember` (
    `token_hash` varchar(64) NOT NULL,
    `user_id` int(10) UNSIGNED NOT NULL,
    `expires_at` datetime NOT NULL,
    PRIMARY KEY (`token_hash`)
    -- FOREIGN KEY (`user_id`) REFERENCES `users`(`id`)
)ENGINE = InnoDB;


ALTER TABLE `images` ADD FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE `remember` ADD FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE ON UPDATE CASCADE;