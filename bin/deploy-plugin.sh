#!/usr/bin/env bash
# Deploy the plugin to the remote wordpress repository
set -x
git fetch click_php master:click_php
git merge --squash -s subtree --no-commit click_php/master