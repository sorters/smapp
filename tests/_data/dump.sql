/* Replace this file with actual dump of your database */

BEGIN TRANSACTION;
CREATE TABLE "users" ("id" integer not null primary key autoincrement, "name" varchar not null, "email" varchar not null, "api_token" varchar not null, "password" varchar not null, "remember_token" varchar null, "created_at" datetime null, "updated_at" datetime null);
INSERT INTO "users" (id,name,email,api_token,password,remember_token,created_at,updated_at) VALUES (1,'Admin','admin@sorters.io','IsZs01MiurjFPmCHuXG9b2dO7oSOgn14ZbsYtpDANfrYuVvglgX61cq2b6sY','$2y$10$zi7VUnFmoFRINXQdNLEgzuEr6hiQuVb6TcyU80POAgNV1W24jTEcK',NULL,'2016-08-01 19:26:22','2016-08-01 19:26:22');
CREATE TABLE "stocks" ("id" integer not null primary key autoincrement, "product_id" integer not null, "quantity" float not null default '0', "created_at" datetime null, "updated_at" datetime null, foreign key("product_id") references "products"("id"));
CREATE TABLE "products" ("id" integer not null primary key autoincrement, "name" varchar not null, "category_id" integer null, "description" varchar not null, "created_at" datetime null, "updated_at" datetime null, foreign key("category_id") references "categories"("id"));
CREATE TABLE "categories" ("id" integer not null primary key autoincrement, "name" varchar not null, "description" varchar not null, "created_at" datetime null, "updated_at" datetime null);
CREATE UNIQUE INDEX "users_email_unique" on "users" ("email");
CREATE UNIQUE INDEX "products_name_unique" on "products" ("name");
CREATE UNIQUE INDEX "categories_name_unique" on "categories" ("name");
COMMIT;