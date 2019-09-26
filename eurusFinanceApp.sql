



    CREATE TABLE `users` (
      `rowid` int(255) NOT NULL AUTO_INCREMENT,
      `user_id` varchar(225) NOT NULL,
      `first_name` varchar(255) NOT NULL,
      `last_name` varchar(255) NOT NULL,
      `middle_name` varchar(255) NOT NULL,
      `password` varchar(255) NOT NULL,
      `user_email` varchar(255) NOT NULL,
      `registration_date` varchar(255) NOT NULL,

    
      PRIMARY KEY (`rowid`),
      KEY `login_index` (`user_email`,`password`,`user_id`),
      KEY `user_info_index` (`first_name`,`last_name`,`middle_name`)
    ) 
    