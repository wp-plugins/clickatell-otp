#! /usr/bin/env bash
set -x
set -e

git svn init -s --prefix=svn/ --no-minimize-url http://plugins.svn.wordpress.org/clickatell-otp/
git svn fetch --log-window-size 100000
git svn rebase