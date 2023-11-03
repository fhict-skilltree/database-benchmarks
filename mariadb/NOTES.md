# MariaDB notes

## Get all skills from a skilltree using the skilltree_id

```sql
SELECT * FROM skills WHERE skills.skilltree_id = 1
```

## Get all skills from a skilltree using a recursive query

```sql
WITH RECURSIVE rectree AS (
    SELECT *
    FROM skills
    WHERE id = 1
    UNION ALL
    SELECT t.*
    FROM skills t
             JOIN rectree
                  ON t.parent_skill_id = rectree.id
) SELECT * FROM rectree;
```