create table users
(
    user_id         serial                not null,
    title           varchar(10)           not null,
    fname           varchar(32)           not null,
    lname           varchar(32)           not null,
    email           varchar(64)           not null,
    passwd          varchar(64)           not null,
    CONSTRAINT pk_user PRIMARY KEY(user_id),
    CONSTRAINT unique_email UNIQUE (email)
);

create table products
(
    product_id      serial                not null,
    name            varchar(128)          not null,
    imgurl          text                  not null,
    category        varchar(64)           not null,
    brand           varchar(64)                   ,
    price           decimal(10,2)         not null,
    description     text                          ,
    CONSTRAINT pk_product PRIMARY KEY (product_id)
);

create table cart_items
(
    cart_item_id    serial          not null,
    user_id         serial          not null,
    product_id      serial          not null,
    quantity        smallint        not null,
    CONSTRAINT pk_cart_item PRIMARY KEY (cart_item_id),
    CONSTRAINT fk1_cart_item FOREIGN KEY (user_id) REFERENCES users(user_id),
    CONSTRAINT fk2_cart_item FOREIGN KEY (product_id) REFERENCES products(product_id)
);

create table orders
(
    order_id        serial          not null,
    user_id         serial          not null,
    user_name       varchar(64)     not null,
    flight_no       varchar(10)     not null,
    flight_date     date            not null,
    flight_seat     varchar(10)             ,
    booking_date    date                    ,
    status          varchar(20)             ,
    requirement     text                    ,
    CONSTRAINT pk_order PRIMARY KEY (order_id),
    CONSTRAINT fk_order FOREIGN KEY (user_id) REFERENCES users(user_id)
);

create table order_items
(
    order_item_id   serial          not null,
    order_id        serial          not null,
    product_id      serial          not null,
    quantity        smallint        not null,
    CONSTRAINT pk_order_item  PRIMARY KEY (order_item_id),
    CONSTRAINT fk1_order_item FOREIGN KEY (order_id) REFERENCES orders(order_id),
    CONSTRAINT fk2_order_item FOREIGN KEY (product_id) REFERENCES products(product_id)
);

create table notifications
(
    notification_id     serial              not null,
    user_id             serial              not null,
    title               varchar(128)        not null,
    message             text                not null,
    is_read             boolean             not null,
    add_date            date                not null,
    CONSTRAINT pk PRIMARY KEY (notification_id),
    CONSTRAINT fk FOREIGN KEY (user_id) REFERENCES users(user_id)
);
