# Update guide

- change WordPress version in Dockerfile (Major version only)
- run `docker-compose up`
  -- installs and sets up the WordPress, database and plugins
  -- creates a dev login for WP dashboard
- enable API by changing permalink
- add a custom ACF field
- confirm the outcome from JSON endpoint http://localhost:8080/wp-json/acf/v3/posts
- update version and change log in `readme.txt` and `index.php`
- merge to master
- install SVN (brew install svn) (if required)
- run sh ./release.sh {new version}
  -- creates version in SVN
  -- pushes new tags into WordPress SVN
  -- creates new git tag
  -- pushes the change to GitHub
