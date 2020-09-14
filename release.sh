#!/usr/bin/env bash

if [ -z "$1" ]
  then
  echo "- No version is given. Use as ./release.sh 1.0.0";
  exit 1
fi

echo "- Clean up SVN";
rm -rf svn

echo "- Checkout from SVN remote";
svn co http://plugins.svn.wordpress.org/wp-acf-nullify-gatsby/ svn

echo "- Clean up SVN trunk";
rm -rf svn/trunk/*

echo "- Copy latest code and assets to SVN trunk";
cp -r src/* svn/trunk/
cp -r assets/* svn/assets/

echo "- Add to SNV";
svn add svn/trunk/*
svn add svn/assets/*

echo "- Create new SVN tag";
svn cp svn/trunk "svn/tags/$1"

echo "- Release to SVN remote";
cd svn/
svn ci -m "Release version $1" --username jabranr
