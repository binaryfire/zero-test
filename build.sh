#!/bin/bash

echo "Building phar..."
./zero app:build
mv ./builds/zero ./builds/zero.phar
echo .

echo "Building PHPacker executables..."
./vendor/bin/phpacker build --config=./.phpacker/config.json
rm -rf ./builds
echo .

echo "Build complete! Executables are in the ./dist directory."
