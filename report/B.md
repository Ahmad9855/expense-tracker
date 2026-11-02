# Report — Role B (Backend)

**Name:** Humama Abu Bakr
**Role:** B — Backend

## 1. Role and Files

As Role B, I was responsible for connecting the site to the database and building the two pages that read and write expense data. Files I worked on:

- `config.example.php` — a template holding the database connection settings with placeholder values, safe to push to GitHub.
- `config.php` — my own local copy of the template with the real connection values; created on each team member's machine and never pushed.
- `includes/db.php` — connects to the database through PDO and exposes the `$pdo` variable to the rest of the site. I pushed this early since C's work depended on it.
- `public/index.php` — the home page: a table of all expenses from newest to oldest, with the grand total shown underneath.
- `public/add_expense.php` — the add-expense form (description, amount, category, date); validates in PHP that the description isn't empty and the amount is greater than zero before saving.

I worked with GitHub Desktop: fetching and pulling the latest changes before starting, reviewing the changed files in the Changes tab, writing a commit summary, and pushing to origin.

## 2. Conflict

In Stage 2, all three of us deliberately edited `includes/header.php` at the same time to add our own page's navigation link to the same line of the navbar. After pulling in GitHub Desktop and pausing, each of us committed locally without pushing yet, then agreed on a push order.

When I pushed after a teammate, GitHub Desktop flagged `includes/header.php` as conflicted and offered to open it in the external editor to resolve the conflict manually. I opened the file, kept all three navigation links together in the navbar instead of keeping only mine, removed the conflict markers, then marked the conflict as resolved, committed the merge, and pushed. We then checked that all three links worked for everyone.

## 3. Revert

We practiced three ways to undo a change, depending on how far it had traveled, all through GitHub Desktop:

- Discarding an uncommitted change in the Changes tab — for an edit not yet committed, it restores the file to its last committed state.
- Resetting to a previous commit (right-click a commit in History → "Reset to Commit") — for a commit that only exists locally and hasn't been pushed; it removes the commit entirely.
- Reverting a commit (right-click a commit in History → "Revert This Commit") — for a commit already pushed and seen by the team; it creates a new commit that undoes it without erasing history.

For the real case, I intentionally pushed a commit to `public/index.php` that broke the home page, with a commit summary that didn't describe what had changed, so that A and C would have to find the cause from the History. After A located the problematic commit in GitHub Desktop's History panel and reverted it, I pulled the fix and confirmed the home page was working again.