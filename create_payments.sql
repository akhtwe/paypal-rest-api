CREATE TABLE IF NOT EXISTS `payments` (
 `id` int(6) NOT NULL AUTO_INCREMENT,
 `transaction_id` varchar(20) NOT NULL,
 `payment_amount` decimal(7,2) NOT NULL,
 `payment_status` varchar(25) NOT NULL,
 `invoice_id` varchar(25) NOT NULL,
 `detail` TEXT NULL,
 `createdtime` datetime NOT NULL,
 PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
