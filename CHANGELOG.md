# Changelog

If there are no installation instructions provided, assume a ```composer update``` will suffice.

## v4.0.0
+ Adds Laravel 5 support
+ Removes Exceptions
+ Adds new ```Auth::verify()``` method
+ Adds new artisan commands

## v3.1.0
+ Adds config options for model classnames.
+ Adds namespace for Eloquent.

### Credits
[bgallagh3r](https://github.com/bgallagh3r) for #66.  

## v3.0.1
+ Fixes Laravel 4.2 support

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
+ Adds != level check
+ Adds remember token methods
+ Adds facade support

### Credits
A huge thanks to the following people!  
[YOzaz](https://github.com/YOzaz) for #39, #38 and a great pull request.  
[quocvu](https://github.com/quocvu) for #42.  
[Raywin88](https://github.com/Raywin88) for #36.  
[Bogardo](https://github.com/Bogardo) for #35 and a pull request.

## v2.3.1
+ Caches permissions in Role.

### Credits
[xLink](https://github.com/xLink) for #33.

## v2.3.0
+ Adds `has` method to Role class.

### Credits
[NoelDavies](https://github.com/NoelDavies) for #30.

## v2.2.2
+ Adds cascade clause for migration's foreign keys.

### Credits
[Asilbalaban](https://github.com/asilbalaban) for #29.

## v2.2.1
+ Removes reliance on hard-coded primary key.

### Credits
[DyeH](https://github.com/DyeH) for #27.

## v2.2.0
+ Moves seeding to Seeder class.
+ Removes illuminate/support dependency.

### Credits
[GlobeView](https://github.com/GlobeView) for #25.  
[mpemberton5](https://github.com/mpemberton5) for #24.

## v2.1.1
+ Refactores to use LSB.

### Credits
[ronaldcastillo](https://github.com/ronaldcastillo) for #23.

## v2.1.0
+ Updates session key to reflect Laravel core changes.

### Credits
[xLink](https://github.com/xLink) for #22.  
[pidgpowell](https://github.com/pidgpowell) for #21.

## v2.0.2
+ Updates Readme to include a reference to the license.
+ Removes unecessary variable.

### Credits
[claar](https://github.com/claar) for #18.

## v2.0.1
+ Updates Readme with new version.

## v2.0.0
+ Removes delete column and adds soft delete.
+ Removes deleted scope methods - use ->trashed() instead.

### Credits
[senei](https://github.com/senei) for #8.  
[driesvints](https://github.com/driesvints) for #6.  
[tlgreg](https://github.com/tlgreg) for #11.

## v1.1.1
+ Fixes prefix not working in the Base Model.
+ Changes insert to insertGetId.

### Credits
[underparnv](https://github.com/underparnv) for #5.

## v1.1.0
+ Adds model scopes to the User model.