#!/bin/bash

set -e

composer install --no-dev

zip -r website.zip . \
    -x "*.git*" \
    -x "build.sh"
