# Changelog

If there are no installation instructions provided, assume a ```composer update``` will suffice.

## v3.0.1
+ Fixed Laravel 4.2 support

### Credits
[MartijnThomas](https://github.com/MartijnThomas).  

## v3.0.0
+ Adds support for Laravel 4.2 by using soft delete trait
+ Some small tweaks for php 5.4

### Credits
[YOzaz](https://github.com/YOzaz) for #47.  

## v2.4.1
+ Removes thrid parameter for PHP <= 5.3.8

### Credits
[ivannovak](https://github.com/ivannovak) for #44.  
[YOzaz](https://github.com/YOzaz) for #45/pull request.  

## v2.4.0
+ Added != level check
+ Added remember token methods
+ Added facade support

### Credits
A huge thanks to the following people!  
[YOzaz](https://github.com/YOzaz) for #39, #38 and a great pull request.  
[quocvu](https://github.com/quocvu) for #42.  
[Raywin88](https://github.com/Raywin88) for #36.  
[Bogardo](https://github.com/Bogardo) for #35 and a pull request.

## v2.3.1
+ Cached permissions in Role.

### Credits
[xLink](https://github.com/xLink) for #33.

## v2.3.0
+ Added `has` method to Role class.

### Credits
[NoelDavies](https://github.com/NoelDavies) for #30.

## v2.2.2
+ Added cascade clause for migration's foreign keys.

### Credits
[Asilbalaban](https://github.com/asilbalaban) for #29.

## v2.2.1
+ Removed reliance on hard-coded primary key.

### Credits
[DyeH](https://github.com/DyeH) for #27.

## v2.2.0
+ Moved seeding to Seeder class.
+ Removed illuminate/support dependency.

### Credits
[GlobeView](https://github.com/GlobeView) for #25.  
[mpemberton5](https://github.com/mpemberton5) for #24.

## v2.1.1
+ Refactored to use LSB.

### Credits
[ronaldcastillo](https://github.com/ronaldcastillo) for #23.

## v2.1.0
+ Updated session key to reflect Laravel core changes.

### Credits
[xLink](https://github.com/xLink) for #22.  
[pidgpowell](https://github.com/pidgpowell) for #21.

## v2.0.2
+ Updated Readme to include a reference to the license.
+ Removed unecessary variable.

### Credits
[claar](https://github.com/claar) for #18.

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