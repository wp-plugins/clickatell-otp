#!/usr/bin/env bash
# Deploy the plugin to the remote wordpress repository
set -x
set -e
git svn rebase
git svn dcommit