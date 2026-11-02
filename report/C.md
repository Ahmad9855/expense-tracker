# Report — Role C (Database & JavaScript)

**Name:** Hadeel Nasser
**Role:** C — Database & JavaScript

## 1. Role and Files

As Role C, I was responsible for the database structure, client-side validation, and the summary page. Files I worked on:

- `database/schema.sql` — builds the `expense_tracker` database with two tables, `categories` and `expenses`, and seeds the initial categories (Food, Transport, Bills, Entertainment, Other).
- `public/assets/js/main.js` — validates the add-expense form before submission: blocks the submit and shows a message next to the field if the amount is empty, zero, or negative.
- `public/summary.php` — the summary page: the total and percentage share of each category, each shown with a Bootstrap progress bar. I started this file only after B pushed `db.php`, since it depends on the database connection.

I worked with GitHub Desktop: fetching and pulling before starting, reviewing changes in the Changes tab, writing a commit summary, and pushing to origin.

## 2. Conflict

In Stage 2, all three of us deliberately edited `includes/header.php` at the same time to add our own page's navigation link to the same line of the navbar. After pulling in GitHub Desktop and pausing, each of us committed locally without pushing yet, then agreed on a push order.

When I pushed after a teammate, GitHub Desktop marked `includes/header.php` as conflicted and let me open it in the external editor to resolve it manually. I kept all three navigation links together in the navbar instead of keeping only mine, removed the conflict markers, marked the conflict as resolved, committed the merge, and pushed. We then confirmed all three links worked for everyone.

## 3. Revert

We practiced three ways to undo a change, depending on how far it had traveled, all through GitHub Desktop:

- Discarding an uncommitted change in the Changes tab — for an edit not yet committed, it restores the file to its last committed state.
- Resetting to a previous commit (right-click a commit in History → "Reset to Commit") — for a commit that only exists locally and hasn't been pushed; it removes the commit entirely.
- Reverting a commit (right-click a commit in History → "Revert This Commit") — for a commit already pushed and seen by the team; it creates a new commit that undoes it without erasing history.

For the real case, B pushed a commit to `public/index.php` that broke the home page without explaining the change. After pulling and noticing the home page was broken, A and I went through the History panel together to identify the responsible commit. Once A reverted and pushed the fix, I pulled the update and confirmed the home page worked again.