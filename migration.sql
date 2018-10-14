# Migration #1
# Add TEXTINDEX on lots table
# 14 Oct 2018

ALTER TABLE lots
  ADD FULLTEXT (description, name)