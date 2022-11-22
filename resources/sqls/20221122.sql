alter table snipeit.assets add money varchar(3) after purchase_cost;
ALTER TABLE snipeit.assets MODIFY COLUMN money varchar(3) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'ARG' NULL;

alter table snipeit.components  add money varchar(3) DEFAULT 'ARG' after purchase_cost;
alter table snipeit.consumables  add money varchar(3) DEFAULT 'ARG' after purchase_cost;