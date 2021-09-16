CREATE TABLE web_topup (
	id int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
    playername varchar(100) NOT NULL,
    paymentch varchar(100) NOT NULL,
    time varchar(100) NOT NULL,
    amount varchar(100) NOT NULL,
    image varchar(250) NOT NULL,
    status varchar(250) NOT NULL,
    postingdate timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE web_shop_rank (
	id int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
    logo_image varchar(250) NOT NULL,
    product_name varchar(100) NOT NULL,
    product_code varchar(100) NOT NULL,
    price varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE web_shop_item (
	id int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
    item_image varchar(250) NOT NULL,
    item_name varchar(100) NOT NULL,
    item_code varchar(100) NOT NULL,
    price varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE web_purchase_history (
	id int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
    playername varchar(100) NOT NULL,
    product_name varchar(100) NOT NULL,
    product_code varchar(100) NOT NULL,
    point_price varchar(100) NOT NULL,
    product_price varchar(100) NOT NULL,
    postingdate timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE rank_price (
	id int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
    rank_name varchar(100) NOT NULL,
    rank_code varchar(100) NOT NULL,
    rank_price varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE product_list (
	id int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
    playername varchar(100) NOT NULL,
    item_name varchar(100) NOT NULL,
    item_code varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE alert_order (
	id int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
    playername varchar(100) NOT NULL,
    order_name varchar(100) NOT NULL,
    order_code varchar(100) NOT NULL,
    postingdate timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE alert_topup (
	id int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
    playername varchar(100) NOT NULL,
    payment_ch varchar(100) NOT NULL,
    amount varchar(100) NOT NULL,
    postingdate timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE announcement (
	id int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
    announcement varchar(100) NOT NULL,
    type varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE ban_list (
    id int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
    date varchar(100) NOT NULL,
    playername varchar(100) NOT NULL,
    reason varchar(100) NOT NULL,
    punisher varchar(100) NOT NULL,
    ip varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE shop (
    id int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
    ItemID varchar(100) NOT NULL,
    buy double(100,2) NOT NULL,
    sell double(100,2) NOT NULL,
    shop varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE shopcategory (
    id int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
    shopname varchar(100) NOT NULL,
    buyicon varchar(100) NOT NULL,
    sellicon varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE crate (
    id int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
    ItemID text NOT NULL,
    Amount int NOT NULL,
    droprate double(100,2) NOT NULL,
    crateid text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE cratecategory (
    id int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
    crateid text NOT NULL,
    keyid text NOT NULL,
    displayname text NOT NULL,
    totalopen int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;