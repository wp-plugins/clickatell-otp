#!/usr/bin/env bash
# Tag a new plugin release

if [ $# -ne 1 ];
    then echo "You must specify the <tag> argument"
fi

set -x
set -e
git tag -a $1 -m "tagging $1"
git svn tag "$1"