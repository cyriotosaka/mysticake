---
name: feedback-run-command
description: User prefers running tests with ./vendor/bin/pest, not php vendor/bin/pest
metadata:
  type: feedback
---

Always use `./vendor/bin/pest` (not `php vendor/bin/pest`) when running tests in this project.

**Why:** User preference — they use Git Bash where `./vendor/bin/pest` is the standard form.

**How to apply:** Any time you need to run Pest tests, use `./vendor/bin/pest` as the command.
