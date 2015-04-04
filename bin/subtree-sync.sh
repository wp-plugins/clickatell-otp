#!/usr/bin/env bash
# This file is a helper script to keep the subtree folder in sync.
set -x
git fetch click_php master:click_php
git merge --squash -s subtree --no-commit click_php/master