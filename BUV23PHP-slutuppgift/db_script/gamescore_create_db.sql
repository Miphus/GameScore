CREATE TABLE `news` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `author` varchar(255) NOT NULL,
  `publishDate` datetime NOT NULL,
  `content` TEXT NOT NULL,
  `image` MEDIUMBLOB NOT NULL,
  `url` varchar(255) NULL,
  `source` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
);

CREATE TABLE `user` (
  `id` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `profilepic` mediumblob DEFAULT NULL,
  `role` enum('admin','user') NOT NULL DEFAULT 'user',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `message` (
  `message_id` int(11) NOT NULL AUTO_INCREMENT,
  `sender_id` varchar(255) NOT NULL,
  `receiver_id` varchar(255) NOT NULL,
  `message_text` text NOT NULL,
  `sent_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`message_id`),
  KEY `fk_messages_sender_id` (`sender_id`),
  KEY `fk_messages_receiver_id` (`receiver_id`),
  CONSTRAINT `fk_messages_sender` FOREIGN KEY (`sender_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_messages_receiver` FOREIGN KEY (`receiver_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `game` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `release_date` date NOT NULL,
  `rating` float NOT NULL,
  `metacritic` int(11) DEFAULT NULL,
  `updated` datetime NOT NULL,
  `image_background` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `friend` (
  `user_id_a` varchar(255) NOT NULL,
  `user_id_b` varchar(255) NOT NULL,
  `status` enum('pending','accepted') NOT NULL DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`user_id_a`,`user_id_b`),
  KEY `fk_friends_user_b` (`user_id_b`),
  CONSTRAINT `fk_friends_user_a` FOREIGN KEY (`user_id_a`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_friends_user_b` FOREIGN KEY (`user_id_b`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `CONSTRAINT_1` CHECK (`user_id_a` <> `user_id_b`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE post (
    post_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id VARCHAR(255) NOT NULL,
    content TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    review_link TEXT DEFAULT NULL,
    FOREIGN KEY (user_id) REFERENCES user(id) ON DELETE CASCADE
);


CREATE TABLE comment (
    comment_id INT AUTO_INCREMENT PRIMARY KEY,
    post_id INT,
    content TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    user_id varchar (255),
    FOREIGN KEY (user_id) REFERENCES user(id) ON DELETE CASCADE,
    FOREIGN KEY (post_id) REFERENCES post(post_id) ON DELETE CASCADE
);



INSERT INTO `news` (`title`, `author`, `publishDate`, `content`, `image`, `url`, `source`, `address`) VALUES 
('Epic Fantasy Adventure Released', 'John Doe', '2024-02-25 10:00:00', 'An epic fantasy adventure game has been released, offering immersive worlds and challenging quests.','https://media.rawg.io/media/games/737/737ea5662211d2e0bbd6f5989189e4f1.jpg' ,'https://www.youtube.com/watch?v=xvFZjo5PgG0', 'GameSource', 'Virtual World'),
('Space Exploration Game Update', 'Jane Smith', '2024-02-24 09:30:00', 'The latest update for the popular space exploration game adds new planets and missions.', 'https://media.rawg.io/media/games/559/559bc0768f656ad0c63c54b80a82d680.jpg','https://www.youtube.com/watch?v=xvFZjo5PgG0', 'SpaceNews', 'Outer Space'),
('New Racing Game Hits the Market', 'Alex Johnson', '2024-02-23 14:00:00', 'A new high-speed racing game is now available, featuring advanced physics and real-world tracks.','https://media.rawg.io/media/games/253/2534a46f3da7fa7c315f1387515ca393.jpg' ,'https://www.youtube.com/watch?v=xvFZjo5PgG0', 'Speedster', 'Race Tracks Worldwide'),
('Survival Game Gets Major Expansion', 'Chris Lee', '2024-02-22 16:45:00', 'The latest expansion for the survival game adds new environments and challenges.','https://media.rawg.io/media/games/4be/4be6a6ad0364751a96229c56bf69be59.jpg' ,'https://www.youtube.com/watch?v=xvFZjo5PgG0', 'Survivalist', 'Unknown Lands'),
('Virtual Reality Adventure Unveiled', 'Morgan Wright', '2024-02-21 12:00:00', 'A new virtual reality adventure game offers unparalleled immersion into fantastical realms.', 'https://media.rawg.io/media/games/9aa/9aa42d16d425fa6f179fc9dc2f763647.jpg','https://www.youtube.com/watch?v=xvFZjo5PgG0', 'VRArcade', 'Virtual Realms'),
('Strategy Game Tournament Announced', 'Olivia King', '2024-02-20 18:30:00', 'A global tournament for the popular strategy game has been announced, with significant prizes.', 'https://media.rawg.io/media/games/2ad/2ad87a4a69b1104f02435c14c5196095.jpg','https://www.youtube.com/watch?v=xvFZjo5PgG0', 'Strategist', 'Global'),
('Indie Puzzle Game Surprise Hit', 'Ethan Hunt', '2024-02-19 11:15:00', 'An indie puzzle game has become a surprise hit, praised for its innovative gameplay.','https://media.rawg.io/media/games/26d/26d4437715bee60138dab4a7c8c59c92.jpg' ,'https://www.youtube.com/watch?v=xvFZjo5PgG0', 'IndiePlay', 'Puzzle World'),
('Action RPG Receives Critical Acclaim', 'Sophia Turner', '2024-02-18 13:45:00', 'The latest action RPG has received critical acclaim for its story and gameplay mechanics.','https://media.rawg.io/media/games/951/951572a3dd1e42544bd39a5d5b42d234.jpg' ,'https://www.youtube.com/watch?v=xvFZjo5PgG0', 'RPGFan', 'Fantasy Land'),
('Multiplayer Shooter Update Adds New Maps', 'Liam Ford', '2024-02-17 15:30:00', 'The latest update for the multiplayer shooter game adds new maps and weapons.', 'https://media.rawg.io/media/games/120/1201a40e4364557b124392ee50317b99.jpg','https://www.youtube.com/watch?v=xvFZjo5PgG0', 'ShooterPro', 'Battlefields'),
('Classic Game Remastered for Modern Consoles', 'Zoe Kim', '2024-02-16 17:00:00', 'A classic game has been remastered for modern consoles, featuring updated graphics and controls.','https://media.rawg.io/media/games/8d6/8d69eb6c32ed6acfd75f82d532144993.jpg' ,'https://www.youtube.com/watch?v=xvFZjo5PgG0', 'RetroGamer', 'Digital Store');
