-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 26, 2024 at 08:06 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `nutrialert`
--

-- --------------------------------------------------------

--
-- Table structure for table `allergies`
--

CREATE TABLE `allergies` (
  `allergy_id` int(11) NOT NULL,
  `allergy_recipe_id` int(11) NOT NULL,
  `allergy_name` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `allergies`
--

INSERT INTO `allergies` (`allergy_id`, `allergy_recipe_id`, `allergy_name`) VALUES
(3, 3, 'Egg-Free'),
(4, 3, 'Seafood'),
(5, 4, 'Seafood');

-- --------------------------------------------------------

--
-- Table structure for table `announcements`
--

CREATE TABLE `announcements` (
  `announcement_id` int(11) NOT NULL,
  `announcement_title` varchar(200) NOT NULL,
  `announcement_date` date NOT NULL,
  `announcement_posted_by_id` int(11) NOT NULL,
  `announcement_description` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `announcements`
--

INSERT INTO `announcements` (`announcement_id`, `announcement_title`, `announcement_date`, `announcement_posted_by_id`, `announcement_description`) VALUES
(1, 'Reminder: Update Your Weekly Nutrition Log!', '2024-07-26', 1, 'Dear NutriAlert Users,\r\n\r\nThis is a friendly reminder to update your weekly nutrition log to ensure you stay on track with your health goals.\r\n\r\nWhy Update Your Log?\r\nTrack Your Progress: Keep an eye on your calorie intake and nutrient consumption to meet your goals.\r\nPersonalized Feedback: Receive tailored advice based on your logged data to improve your diet.\r\nStay Motivated: Regularly updating your log can help maintain motivation and accountability.\r\nHow to Update Your Log?\r\nOpen the App: Navigate to the \"Nutrition Log\" section.\r\nEnter Your Meals: Log all your meals and snacks for the week.\r\nReview and Save: Make sure all entries are accurate and save your log.\r\nBy keeping your log up-to-date, you help us provide you with the best personalized nutrition advice possible.\r\n\r\nThank you for being proactive about your health!\r\n\r\nStay healthy,\r\nThe NutriAlert Team'),
(2, ' New Recipe from Our Chef - Quinoa and Avocado Salad!', '2024-07-26', 1, 'Hello NutriAlert Users,\r\n\r\nWe are thrilled to introduce a new healthy and delicious recipe from our chef: Quinoa and Avocado Salad!\r\n\r\nRecipe Details:\r\nIngredients:\r\n\r\n1 cup quinoa\r\n2 cups water\r\n1 ripe avocado, diced\r\n1 cup cherry tomatoes, halved\r\n1/4 cup red onion, finely chopped\r\n1/4 cup fresh cilantro, chopped\r\n1/4 cup lime juice\r\n2 tablespoons olive oil\r\nSalt and pepper to taste\r\nInstructions:\r\n\r\nCook Quinoa: Rinse the quinoa under cold water. In a medium saucepan, bring the quinoa and water to a boil. Reduce heat to low, cover, and simmer for about 15 minutes or until the water is absorbed and the quinoa is tender.\r\nPrepare Dressing: In a small bowl, whisk together lime juice, olive oil, salt, and pepper.\r\nCombine Ingredients: In a large bowl, combine the cooked quinoa, diced avocado, cherry tomatoes, red onion, and cilantro.\r\nAdd Dressing: Pour the dressing over the quinoa mixture and toss gently to combine.\r\nServe: Serve immediately or refrigerate for an hour to let the flavor'),
(3, 'New Recipe', '2024-07-26', 2, 'See'),
(5, 'New Recipe', '2024-07-26', 2, 'Garlic Butter Shrimp');

-- --------------------------------------------------------

--
-- Table structure for table `conditions`
--

CREATE TABLE `conditions` (
  `condition_id` int(11) NOT NULL,
  `condition_recipe_id` int(11) NOT NULL,
  `condition_name` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `conditions`
--

INSERT INTO `conditions` (`condition_id`, `condition_recipe_id`, `condition_name`) VALUES
(2, 3, 'Diabetes Friendly'),
(3, 4, 'Diabetes Friendly');

-- --------------------------------------------------------

--
-- Table structure for table `considerations`
--

CREATE TABLE `considerations` (
  `consideration_id` int(11) NOT NULL,
  `consideration_recipe_id` int(11) NOT NULL,
  `consideration_name` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `considerations`
--

INSERT INTO `considerations` (`consideration_id`, `consideration_recipe_id`, `consideration_name`) VALUES
(1, 1, 'Salads'),
(3, 4, 'A little bit spicy');

-- --------------------------------------------------------

--
-- Table structure for table `ingredients`
--

CREATE TABLE `ingredients` (
  `ingredient_id` int(11) NOT NULL,
  `ingredient_recipe_id` int(11) NOT NULL,
  `ingredient_name` varchar(200) NOT NULL,
  `ingredient_quantity` varchar(200) NOT NULL,
  `ingredient_unit` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ingredients`
--

INSERT INTO `ingredients` (`ingredient_id`, `ingredient_recipe_id`, `ingredient_name`, `ingredient_quantity`, `ingredient_unit`) VALUES
(1, 1, 'Chopped Shallot', '1', 'tablespoon'),
(2, 1, 'Apple Cider Vinegar', '2', 'tablespoon'),
(3, 1, 'Olive Oil', '3 - 4', 'tablespoons'),
(4, 1, 'Lemon', '1', ' '),
(5, 1, 'Butter Leaf', '2', 'heads'),
(6, 1, 'Baby Spinach', '3', 'cups'),
(7, 3, 'Garlic', '1', 'clove '),
(8, 3, 'Pepper', '1', 'teaspoon'),
(9, 4, 'Shrimp', '2', 'lbs'),
(10, 4, 'parsley chopped', '2', 'tablespoons'),
(11, 4, 'butter', '1/4', 'cup'),
(12, 3, 'Egg', '2', 'pcs'),
(13, 3, 'Egg', '2', 'pc');

-- --------------------------------------------------------

--
-- Table structure for table `recipes`
--

CREATE TABLE `recipes` (
  `recipe_id` int(11) NOT NULL,
  `recipe_name` varchar(200) NOT NULL,
  `recipe_time` int(11) NOT NULL,
  `recipe_description` varchar(200) NOT NULL,
  `recipe_procedures` varchar(3000) NOT NULL,
  `recipe_image` varchar(200) NOT NULL,
  `recipe_posted_by_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `recipes`
--

INSERT INTO `recipes` (`recipe_id`, `recipe_name`, `recipe_time`, `recipe_description`, `recipe_procedures`, `recipe_image`, `recipe_posted_by_id`) VALUES
(1, 'CRISP BUTTER LEAF SALAD WITH APPLE VINAIGRETTE AND TANGY BLUE CHEESE', 30, 'Simple, delicious and full of flavour. Nothing beats a bit of green for your holiday meal!', '1. Prepare vinaigrette - in a bowl whisk together chopped shallot, apple cider vinegar, and olive oil until incorporated. Season with salt, pepper, and juice of half a lemon. Set aside. \r\n2. Prepare greens and layer into a shallot bowl. Grate apple on a box grater, discarding the core and sprinkle over chilled greens. Garnish with chopped walnuts, pickled shallot and drizzle with vinaigrette. Crumble cold blue cheese over the top and serve immediately. ', 'CroppedFocusedImage108081050-50-DSCF1156.jpg', 3),
(3, 'Smoky Mountain Cheesy Crawfish Omelette from Ramsay Around The World', 45, 'If you can’t get your hands on these local delicacies at home, you could use lobster, crab or shrimp meat, and any sort of tomato basil cheddar or any local cheese from your area that tickles your fan', 'Heat two nonstick skillets over medium-high heat. Once hot, add a couple of teaspoons of oil to one pan, followed by the shallot, garlic and mushrooms, then season with a pinch of red pepper flakes. Add a couple of small pinches of butter to the pan and swirl, then let sit so everything can begin to caramelize. \r\nCrack the eggs into a bowl and lightly whisk.\r\nAdd the crawfish meat to the pan with the vegetables. \r\nAdd 2 tablespoons butter to the other skillet and let it melt and foam. Toss the crawfish mixture while the butter melts.\r\nSeason the eggs with salt and pepper then pour into the skillet. Rapidly swirl and shake the pan while using a spatula to stir and break up the eggs, then flatten them out once they start to cook.\r\nGenerously grate the cheese directly onto the eggs, then spoon the crawfish mixture in a line down the center of the eggs. Scatter the scallions all over.\r\nTo serve, tilt the pan up and begin to fold the sides of the eggs up and over the crawfish mixture. Once folded, lift a plate up toward the pan and let the omelette flip itself out onto the plate so that the mix is completely covered by the eggs and everything is tucked in nicely. Grate more cheese on top of the omelette, followed by a few slices of scallions and serve.', '../images/CroppedFocusedImage108081050-50-Screen-Shot-2021-09-24-at-4.09.44-PM.png', 3),
(4, 'Garlic Butter Shrimp', 40, 'Garlic Butter Shrimp is a super easy dish to make. This recipe shows how to cook this beloved dish the Filipino way. I like how it turned out. The dish is rich and flavorful. I enjoyed eating it with ', 'Marinate the shrimp in lemon soda for about 10 minutes\r\nMelt the butter in a pan.\r\nAdd the garlic. Cook in low heat until the color turns light brown\r\nPut-in the shrimp. Adjust heat to high. Stir-fry until shrimp turns orange.\r\nSeason with ground black pepper, salt, and lemon juice. Stir.\r\nAdd parsley. Cook for 30 seconds.\r\nServe hot. Share and Enjoy!', '../images/garlic-butter-shrimp-1.png', 2);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(100) NOT NULL,
  `user_type` enum('admin','chef','user') NOT NULL,
  `user_email` varchar(200) NOT NULL,
  `user_password` varchar(200) NOT NULL,
  `user_first_name` varchar(200) NOT NULL,
  `user_last_name` varchar(200) NOT NULL,
  `user_username` varchar(200) NOT NULL,
  `user_birthday` date NOT NULL,
  `user_age` int(3) NOT NULL,
  `user_gender` enum('Male','Female') NOT NULL,
  `user_weight` int(4) NOT NULL,
  `user_height` int(4) NOT NULL,
  `user_phone` varchar(20) NOT NULL,
  `user_bio` text NOT NULL,
  `user_image` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `user_type`, `user_email`, `user_password`, `user_first_name`, `user_last_name`, `user_username`, `user_birthday`, `user_age`, `user_gender`, `user_weight`, `user_height`, `user_phone`, `user_bio`, `user_image`) VALUES
(1, 'admin', 'admin@gmail.com', 'admin123', '', '', '', '0000-00-00', 0, '', 0, 0, '', '', ''),
(2, 'chef', 'judyannsantos@gmail.com', 'judy', 'Judy Ann', 'Santos', 'judyann', '1978-05-11', 46, 'Female', 60, 166, '09123456789', 'Judy Ann Santos-Agoncillo (; born Judy Anne Lumagui Santos; 11 May 1978) is a Filipino film and television actress, reality television host, recording artist, film producer and lately an effective Social Media Influencer/Vlogger thru her Youtube Channel Judy Ann\'s Kitchen.', '../images/JUDY-ANN-SANTOS.jpg'),
(3, 'chef', 'gordonramsay@gmail.com', 'gordon', 'Gordon', 'Ramsay', 'gordon', '1966-11-08', 58, 'Male', 55, 178, '09987654321', 'Gordon Ramsay (born November 8, 1966, Johnstone, Scotland) is a Scottish chef and restaurateur known for his highly acclaimed restaurants and cookbooks but perhaps best known in the early 21st century for the profanity and fiery temper that he freely displayed on television cooking programs.', '../images/gordon-ramsay.jpg'),
(4, 'user', 'nikkiher@gmail.com', 'nikki', 'Nikki', 'Her', 'nikki', '2005-06-10', 19, 'Female', 48, 152, '0978653421', 'I am nikki', '../images/template_3.jpg'),
(5, 'chef', 'kalinicole@gmail.com', 'kali', 'Nicole', 'Kali', 'kalikali', '2004-06-14', 20, 'Female', 35, 170, '0912345798', 'Hello! Good day!!!!!!', '../images/dffd.jpg'),
(6, 'chef', 'floraguardian@gmail.com', 'flora', 'Flora', 'Guardian', 'flora', '2001-01-11', 22, 'Female', 35, 170, '0978653421', 'flora flora flora', '../images/template_3 - Copy.jpg'),
(7, 'admin', 'nini@gmail.com', 'nini', 'Nini', 'Herhernan', 'nini', '2020-12-09', 4, 'Female', 35, 34, '09123654789', 'nininininininiininniherehehrehreheehre', '../images/58_Cute-Girl-Pic-WWW.FUNYLIFE.IN_-1.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `allergies`
--
ALTER TABLE `allergies`
  ADD PRIMARY KEY (`allergy_id`),
  ADD KEY `allergy_recipe_id` (`allergy_recipe_id`) USING BTREE;

--
-- Indexes for table `announcements`
--
ALTER TABLE `announcements`
  ADD PRIMARY KEY (`announcement_id`),
  ADD KEY `announcement_posted_by_id` (`announcement_posted_by_id`) USING BTREE;

--
-- Indexes for table `conditions`
--
ALTER TABLE `conditions`
  ADD PRIMARY KEY (`condition_id`),
  ADD KEY `condition_recipe_id` (`condition_recipe_id`) USING BTREE;

--
-- Indexes for table `considerations`
--
ALTER TABLE `considerations`
  ADD PRIMARY KEY (`consideration_id`),
  ADD KEY `consideration_recipe_id` (`consideration_recipe_id`) USING BTREE;

--
-- Indexes for table `ingredients`
--
ALTER TABLE `ingredients`
  ADD PRIMARY KEY (`ingredient_id`),
  ADD KEY `ingredient_recipe_id` (`ingredient_recipe_id`);

--
-- Indexes for table `recipes`
--
ALTER TABLE `recipes`
  ADD PRIMARY KEY (`recipe_id`),
  ADD KEY `recipe_posted_by_id` (`recipe_posted_by_id`) USING BTREE;

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `allergies`
--
ALTER TABLE `allergies`
  MODIFY `allergy_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `announcements`
--
ALTER TABLE `announcements`
  MODIFY `announcement_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `conditions`
--
ALTER TABLE `conditions`
  MODIFY `condition_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `considerations`
--
ALTER TABLE `considerations`
  MODIFY `consideration_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `ingredients`
--
ALTER TABLE `ingredients`
  MODIFY `ingredient_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `recipes`
--
ALTER TABLE `recipes`
  MODIFY `recipe_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `allergies`
--
ALTER TABLE `allergies`
  ADD CONSTRAINT `allergy_recipe_id` FOREIGN KEY (`allergy_recipe_id`) REFERENCES `recipes` (`recipe_id`);

--
-- Constraints for table `announcements`
--
ALTER TABLE `announcements`
  ADD CONSTRAINT `announcement_posted_by_id` FOREIGN KEY (`announcement_posted_by_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `conditions`
--
ALTER TABLE `conditions`
  ADD CONSTRAINT `condition_recipe_id` FOREIGN KEY (`condition_recipe_id`) REFERENCES `recipes` (`recipe_id`);

--
-- Constraints for table `considerations`
--
ALTER TABLE `considerations`
  ADD CONSTRAINT `consideration_recipe_id` FOREIGN KEY (`consideration_recipe_id`) REFERENCES `recipes` (`recipe_id`);

--
-- Constraints for table `ingredients`
--
ALTER TABLE `ingredients`
  ADD CONSTRAINT `ingredient_recipe_id` FOREIGN KEY (`ingredient_recipe_id`) REFERENCES `recipes` (`recipe_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
