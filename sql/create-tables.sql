create table client
(
    client_id       serial                        ,
    title           varchar(10)                   ,
    fname           varchar(32)           not null,
    lname           varchar(32)           not null,
    email           varchar(32)                   ,
    passwd          varchar(32)                   ,
    CONSTRAINT pk_client PRIMARY KEY(client_id)
);

create table product
(
    product_id      serial                        ,
    name            varchar(40)           not null,
    image           bytea                         ,
    category        varchar(20)                   ,
    brand           varchar(20)                   ,
    price           decimal(10,2)                 ,
    description     varchar(1024)                 ,
    CONSTRAINT pk_product PRIMARY KEY (product_id)
);

create table cart_item
(
    item_id         serial                  ,
    client_id       serial                  ,
    product_id      serial                  ,
    quantity        smallint                ,
    CONSTRAINT pk_item PRIMARY KEY (item_id),
    CONSTRAINT fk_item1 FOREIGN KEY (client_id) REFERENCES client(client_id),
    CONSTRAINT fk_item2 FOREIGN KEY (product_id) REFERENCES product(product_id)
);