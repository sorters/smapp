/* Replace this file with actual dump of your database */

BEGIN TRANSACTION;
  CREATE TABLE "categories" ("id" integer not null primary key autoincrement, "name" varchar not null, "description" varchar not null, "created_at" datetime null, "updated_at" datetime null);
  CREATE TABLE "products" ("id" integer not null primary key autoincrement, "name" varchar not null, "category_id" integer null, "description" varchar not null, "buy_price" float not null, "sell_price" float not null, "created_at" datetime null, "updated_at" datetime null, foreign key("category_id") references "categories"("id"));
  CREATE TABLE "stocks" ("id" integer not null primary key autoincrement, "product_id" integer not null, "quantity" float not null, "created_at" datetime null, "updated_at" datetime null, foreign key("product_id") references "products"("id"));
COMMIT;
