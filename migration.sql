# Migration #1
# Add TEXTINDEX on lots table
# 14 Oct 2018

ALTER TABLE lots
  ADD FULLTEXT (description, name);

# Migration #2
# Add alias to categories
# 29 Nov 2018

ALTER TABLE categories ADD alias VARCHAR(80) NOT NULL;

UPDATE categories SET alias = 'gear' WHERE id = 0;
UPDATE categories SET alias = 'bindings' WHERE id = 1;
UPDATE categories SET alias = 'boots' WHERE id = 2;
UPDATE categories SET alias = 'dress' WHERE id = 3;
UPDATE categories SET alias = 'tools' WHERE id = 4;
UPDATE categories SET alias = 'other' WHERE id = 5;

CREATE UNIQUE INDEX categories_alias_uindex ON categories (alias);