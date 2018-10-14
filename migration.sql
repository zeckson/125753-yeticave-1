# Migration #1
# Add TEXTINDEX on lots table

ALTER TABLE lots
  ADD FULLTEXT (description, name)