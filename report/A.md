# Report — Role A (Frontend)

**Name:** Ahmad Barakat
**Role:** A — Frontend

## 1. Role and Files

As Role A, I was responsible for the shared visual structure of the site: the Bootstrap setup, the navigation bar, the page styling, and the project documentation. Files I worked on:

- `.gitignore` — excludes `config.php` from version control so the real database credentials are never pushed.
- `includes/header.php` — the opening of every page: links Bootstrap and renders the top navbar.
- `includes/footer.php` — the closing of every page: closes the HTML tags and loads Bootstrap's and `main.js` scripts.
- `public/assets/css/style.css` — small custom styling on top of Bootstrap (background color, form width, spacing).
- `README.md` — the project name, team member names, and, in the final stage, the full setup and run instructions.

## 2. Conflict

In Stage 2, all three of us deliberately edited `includes/header.php` at the same time to add our own page's navigation link (Expenses, Add Expense, Summary) to the same line of the navbar. After pulling and stopping, each of us committed our change locally without pushing, then agreed on a push order.

The first push went through cleanly. When the second and third pushes were attempted, Git reported a merge conflict in `includes/header.php`, marked with `<<<<<<<`, `=======`, and `>>>>>>>` around the conflicting lines. The fix was to open the file, keep all three navigation links together in the navbar instead of choosing one over the others, remove the conflict markers, then stage, commit, and push the resolved file. Afterward we confirmed that all three links worked correctly for everyone.

## 3. Revert

We practiced three different ways to undo a change, depending on how far that change had traveled:

- `git restore <file>` — for an edit that was never committed; it simply restores the file to its last committed state.
- `git reset --hard HEAD~1` — for a commit that exists only on the local machine and was never pushed; it removes the commit entirely.
- `git revert <commit>` — for a commit that was already pushed to GitHub and seen by the team; it creates a new commit that undoes the change without rewriting history.

For the real case, B intentionally pushed a broken commit to `public/index.php` without explaining the change in the commit message. After pulling, I noticed the home page was broken, used `git log --oneline` to scan recent commit messages and identify the likely cause, then ran `git revert` on that commit and pushed the fix. B and C then pulled the update and confirmed the home page worked again.