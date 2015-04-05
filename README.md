# Clickatell Wordpress Plugin

In order to deploy this plugin to the Wordpress Subversion Repository, you need to run `./bin/svn_sync.sh`.

When you have successfully completed this operation, you can commit the changes to svn using `git svn dcommit`

## Tagging Releases

Use SVN to tag new releases, tagging the releases in GIT will do nothing except flag a specific commit. Since we are working with two repositories it is preferable to rather use SVN for keeping track of tags.