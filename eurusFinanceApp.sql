



    CREATE TABLE `users` (
      `rowid` int(255) NOT NULL AUTO_INCREMENT,
      `user_id` varchar(225) NOT NULL,
      `first_name` varchar(255) NOT NULL,
      `last_name` varchar(255) NOT NULL,
      `password` varchar(255) NOT NULL,
      `user_email` varchar(255) NOT NULL,
      `registration_date` varchar(255) NOT NULL,

    
      PRIMARY KEY (`rowid`),
      KEY `login_index` (`user_email`,`password`,`user_id`),
      KEY `user_info_index` (`first_name`,`last_name`)
    ) 
    


      CREATE TABLE `expenses` (
      `rowid` int(255) NOT NULL AUTO_INCREMENT,
      `user_id` varchar(225) NOT NULL,
      `item` varchar(255) NOT NULL,
      `description` varchar(255) NOT NULL,
      `amount` varchar(255) NOT NULL,
      `date` varchar(255) NOT NULL,
      `day` varchar(255) NOT NULL,
      `month` varchar(255) NOT NULL,
      `year` varchar(255) NOT NULL,

    
      PRIMARY KEY (`rowid`),
      KEY `compute_index` (`month`,`day`,`user_id`),
      KEY `compute_index_one` (`year`,`date`)
    ) 
