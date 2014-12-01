siesc-app
=========

Core Base of the SIESC system.

## Keeping the fork up to date.

In order to keep your fork sync with main repo's master, you need to do the following:

- Add this repository as `upstream` in your local copy.

```
git remote add upstream git@github.com:pmartelletti/siesc-app.git
```

- Rebase your master with  with the main repo's master.

```
git checkout master
git pull --rebase upstream master
```
- Resolve all existing problems that the rebase could have.
- Update composer, database and assetics.
