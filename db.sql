SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

CREATE TABLE `eventlog` (
  `id` int(11) NOT NULL,
  `signature` text,
  `events` longtext,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

ALTER TABLE `eventlog`
ADD PRIMARY KEY (`id`);

ALTER TABLE `eventlog`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

CREATE TABLE `questions` (
  `id` int(11) NOT NULL,
  `number` int(3) NOT NULL,
  `text` text NOT NULL,
  `answer1` varchar(200) NOT NULL,
  `answer2` varchar(200) NOT NULL,
  `answer3` varchar(200) NOT NULL,
  `penjelasan` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

ALTER TABLE `questions`
ADD PRIMARY KEY (`id`);

ALTER TABLE `questions`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;


INSERT INTO `questions` (`id`, `number`, `text`, `answer1`, `answer2`, `answer3`,`penjelasan`) VALUES
(1, 1, 'Gajah apa yang belalainya pendek?', 'gajah pesek', 'pesek','','Gajah pesek. hehehe'),
(2, 2, 'Apa persamaannya gajah dan tiang listrik?', 'sama-sama ga bisa terbang','ga bisa terbang','tidak bisa terbang','sama-sama ga bisa terbang. hehehe'),
(3, 3, 'Monyet apa yang rambutnya panjang?', 'monyet gondrong','monyet gimbal','monyet reggae','Monyet gondrong/gimbal/reggae. hehehe'),
(4, 4, 'Hitam, putih, merah, apakah itu?', 'zebra abis dikerokin','zebra dikerokin','zebra kerokan','Zebra abis dikerokin. hehehe'),
(5, 5, 'Siapa yang selalu jadi korban pemerasan?', 'sapi perah','sapi','','Sapi perah. Soalnya kan diperas terus hehe'),
(6, 6, 'Ada bebek 10 di kali 2 jadi berapa?', '8','delapan','lapan','8. Soalnya yang 2 lagi di kali hehe'),
(7, 7, 'Hewan apa yg bersaudara?', 'Katak beradik','katak adik','','Katak beradik(Kakak beradik/Kakak adik) hehe'),
(8, 8, 'Kenapa anak kodok suka loncat-loncat?', 'anak-anak','karna anak-anak','masih anak-anak','Anak-anak. Biasalah, namanya juga anak-anak hehe'),
(9, 9, 'Hewan apa yg paling aneh?', 'belalang kupu-kupu','','','Belalang kupu-kupu. soalnya, kalo siang makan nasi kalo malam minum susu hehe'),
(10, 10, 'Hewan apa yang namanya 2 huruf?', 'u dan g','i kan','','u dan g(udang)/i kan(ikan).hehehe'),
(11, 11, 'Bebek apa yg jalannya selalu muter ke kiri terus?','bebek dikunci stang','bebek kunci stang','bebek dikonci stang','Bebek dikunci stang. hehehe'),
(12, 12, 'Ikan apa yang nggak bisa berenang?','ikan bodoh','ikan goblok','ikan tolol','ikan bod*h/go*lok/t*lol. hehehe'),
(13, 13, 'Bola apa yang mirip kucing?','bolaemon','bola emon','','Bolaemon. hehehe'),
(14, 14, 'Ayam apa yang besar?','ayam semesta','','','Ayam semesta. hehehe'),
(15, 15, 'Ada ayam jantan palanya ada di amerika ekornya di Afrika, sayapnya di Jakarta, matanya ada di Brazil, telurnya ada di mana?','ayam jantan gak bertelur','ayam jantan gapunya telur','ga ada','Ayam jantan ga bertelur. hehe'),
(16, 16, 'Apa beda unta dengan kangkung?','unta di arap kangkung di urap','unta arap kangkung urap','unta di arap, kangkung di urap','Unta di arap, Kangkung di urap. hehehe');

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `user_id` varchar(100) NOT NULL,
  `display_name` varchar(100) NOT NULL,
  `score` float NOT NULL DEFAULT '0',
  `line_id` varchar(50) DEFAULT NULL,
  `number` int(3) NOT NULL DEFAULT '0',
  `try` int(3) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

ALTER TABLE `users`
ADD PRIMARY KEY (`id`);

ALTER TABLE `users`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;