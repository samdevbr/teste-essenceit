CREATE DATABASE `essenceit`;

CREATE TABLE `essenceit`.`routes` (
  `id` int(10) UNSIGNED NOT NULL,
  `takeoff` varchar(10) NOT NULL,
  `land` varchar(10) NOT NULL,
  `price` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `essenceit`.`routes` (`id`, `takeoff`, `land`, `price`) VALUES
(1, 'GRU', 'BRC', 10),
(2, 'GRU', 'SCL', 18),
(3, 'GRU', 'ORL', 56),
(4, 'GRU', 'CDG', 75),
(5, 'SCL', 'ORL', 20),
(6, 'BRC', 'SCL', 5),
(7, 'ORL', 'CDG', 5),

ALTER TABLE `essenceit`.`routes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `route_unique` (`takeoff`,`land`);
ALTER TABLE `essenceit`.`routes`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
