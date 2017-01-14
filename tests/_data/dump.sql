/* Replace this file with actual dump of your database */

BEGIN TRANSACTION;

CREATE TABLE "users" ("id" integer not null primary key autoincrement, "name" varchar not null, "email" varchar not null, "api_token" varchar not null, "password" varchar not null, "remember_token" varchar null, "created_at" datetime null, "updated_at" datetime null);
INSERT INTO "users" (id,name,email,api_token,password,remember_token,created_at,updated_at) VALUES (1,'Admin','admin@sorters.io','IsZs01MiurjFPmCHuXG9b2dO7oSOgn14ZbsYtpDANfrYuVvglgX61cq2b6sY','$2y$10$zi7VUnFmoFRINXQdNLEgzuEr6hiQuVb6TcyU80POAgNV1W24jTEcK',NULL,'2016-08-01 19:26:22','2016-08-01 19:26:22');

CREATE TABLE "tags" ("id" integer not null primary key autoincrement, "name" varchar not null, "created_at" datetime null, "updated_at" datetime null);
CREATE TABLE "stocks" ("id" integer not null primary key autoincrement, "product_id" integer not null, "provider_id" integer null, "purchase_line_id" integer null, "quantity" float not null default '0', "unit_price" float null, "created_at" datetime null, "updated_at" datetime null, foreign key("product_id") references "products"("id"), foreign key("provider_id") references "providers"("id"), foreign key("purchase_line_id") references "purchaselines"("id"));
CREATE TABLE "purchaseorders" ("id" integer not null primary key autoincrement, "state" tinyint(1) not null default '1', "comments" varchar not null, "created_at" datetime null, "updated_at" datetime null);
CREATE TABLE "purchaselines" ("id" integer not null primary key autoincrement, "state" tinyint(1) not null default '1', "unit_price" float not null, "units" integer not null, "purchase_order_id" integer null, "provider_id" integer null, "product_id" integer not null, "created_at" datetime null, "updated_at" datetime null, foreign key("purchase_order_id") references "purchaseorders"("id"), foreign key("provider_id") references "providers"("id"), foreign key("product_id") references "products"("id"));
CREATE TABLE "providers" ("id" integer not null primary key autoincrement, "name" varchar not null, "description" varchar not null, "created_at" datetime null, "updated_at" datetime null);
CREATE TABLE "products" ("id" integer not null primary key autoincrement, "name" varchar not null, "category_id" integer null, "description" varchar not null, "unit_price" float null, "created_at" datetime null, "updated_at" datetime null, foreign key("category_id") references "categories"("id"));
CREATE TABLE "product_tag" ("id" integer not null primary key autoincrement, "product_id" integer not null, "tag_id" integer not null, "created_at" datetime null, "updated_at" datetime null, foreign key("product_id") references "products"("id"), foreign key("tag_id") references "tags"("id"));
CREATE TABLE "categories" ("id" integer not null primary key autoincrement, "name" varchar not null, "description" varchar not null, "created_at" datetime null, "updated_at" datetime null);
CREATE TABLE "productoffers" ("id" integer not null primary key autoincrement, "product_id" integer not null, "provider_id" integer null, "unit_price" float null, "delivery" date null, "created_at" datetime null, "updated_at" datetime null, foreign key("product_id") references "products"("id"), foreign key("provider_id") references "providers"("id"));
CREATE TABLE "customers" ("id" integer not null primary key autoincrement, "name" varchar not null, "description" varchar not null, "created_at" datetime null, "updated_at" datetime null);
CREATE TABLE "saleorders" ("id" integer not null primary key autoincrement, "customer_id" integer null, "state" tinyint(1) not null default '1', "comments" varchar not null, "created_at" datetime null, "updated_at" datetime null, foreign key("customer_id") references "customers"("id"));
CREATE TABLE "salelines" ("id" integer not null primary key autoincrement, "state" tinyint(1) not null default '1', "unit_price" float not null, "units" integer not null, "sale_order_id" integer null, "product_id" integer not null, "created_at" datetime null, "updated_at" datetime null, foreign key("sale_order_id") references "saleorders"("id"), foreign key("product_id") references "products"("id"));

CREATE UNIQUE INDEX "users_email_unique" on "users" ("email");
CREATE UNIQUE INDEX "tags_name_unique" on "tags" ("name");
CREATE UNIQUE INDEX "providers_name_unique" on "providers" ("name");
CREATE UNIQUE INDEX "products_name_unique" on "products" ("name");
CREATE UNIQUE INDEX "categories_name_unique" on "categories" ("name");
CREATE UNIQUE INDEX "customers_name_unique" on "customers" ("name");

COMMIT;