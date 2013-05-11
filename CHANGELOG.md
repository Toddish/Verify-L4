# Changelog

If there are no installation instructions provided, assume a ```composer update``` will suffice.

## v2.0.1
+ Updated Readme with new version.

## v2.0.0
+ Removed delete column and adds soft delete.
+ Removed deleted scope methods - use ->trashed() instead.

### Credits
[senei](https://github.com/senei) for #8.
[driesvints](https://github.com/driesvints) for #6.
[tlgreg](https://github.com/tlgreg) for #11.

## v1.1.1
+ Fixed prefix not working in the Base Model.
+ Changed insert to insertGetId.

### Credits
[underparnv](https://github.com/underparnv) for #5.

## v1.1.0
+ Added model scopes to the User model.