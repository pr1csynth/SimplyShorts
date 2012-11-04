## FILE : config.json
This file contain default parameters for SimplyShorts.
If this file is invalid or absent, or if some values are invalid or absent, `config.default.json`'s values will be used.

**name** - *string*	Name of your Site

**offlineMessage** - *string*	Displayed in case of unknow error or in offline mode.

**online** - *boolean*	If false, display the `offlineMessage`.

**header** - *boolean*	Put the header on the main page, or not.

**navigation** - *boolean*	Put a navigation menu on the main page, require `header` to `true`.

**maxBlocks** - *int*	Number of blocks displayed on the main page.

**displayName** - *string*	Your name.

**generalAccount** - *string*	Login for general account.

**generalPass** - *string*	General pass for general account, hashed at the next parsing (protect this file anyaway from public access).

**db** - *object* Database settings, only support MySQL at the moment

>**host** - *string* DB host.

>**base** - *string* Name of the base.

>**user** - *string* User of the base.

>**pass** - *string* Password for `user`.

>**prefix** - *string* Table prefix.

**url** - *object* URL settings

>**basedir** - *string* Base directory of SimplyShort, at the root put nothing or `/`.

>**urlRewriting** - *boolean* Set it to true if you run Apache and you put this in `.htaccess` :

>>```ht
	RewriteEngine on
	RewriteCond %{REQUEST_FILENAME} !-f
	RewriteCond %{REQUEST_FILENAME} !-d 
	RewriteRule ^(.*) index.php?page=$1
```

>**separator** - *string* Separator in url (ie. : `!` → `http://shorts.multoo.eu/coding!add`).

**style** - *object*	Contain customisation settings

>**font** - *object*	Font files must be in the dir `fonts`.

>>**color** - *[int,int,int]* 	Text color, RGB - 0 to 255.

>>**defaultSans** - *string* 	The default Serif font, without the extension.

>>**defaultSerif** - *string* The default font type, must be `sans` or `serif`.

>>**defaultSize** - *int* The default size for texts in px.

>**backgroundColor** - *[int,int,int]* Background color, fallback too, RGB - 0 to 255.

>**backgrounds** - *array of objects*	Backgrounds, can be empty.

>>**type** - *string* Must be `gradient`, `radialGradient` once, and/or `image` as many times as desired.

>>**from** - *[int,int,int]* For `gradient` and `radialGradient`, the start color, RGB - 0 to 255.

>>**to** - *[int,int,int]* For `gradient` and `radialGradient`, the end color, RGB - 0 to 255.

>>**image** - *string* For `image`, filename of desired image, background files must be in `img/background`.

>>**repeat** - *string* For `image`, like `background-repeat` CSS property, default `repeat`.

>>**position** - *string* For `image`, like `background-position` CSS property, default `center`.

>>**attachment** - *string* For `image`, like `background-position` CSS property : `scroll` or `fixed`, default `fixed`.

>**blocks** - *object* Style for blocks

>>**backgroundColor** - *[int,int,int,int]* Background color, RGB - 0 to 255 + alpha.

>>**borderRadius** - *int* Corner radius in px.

>>**shadow** - *[int,int,int,[int,int,int,int]]* Shadow : x, y, radius, then RGB - 0 to 255 + alpha.

>>**alignment** - *string* Text alignment, must be `left`, `center` or `right`, default `right`.

>**title** - *object* Style for title on the home page.

>>**font** - *string* Must be the font name or `default`.

>>**size** - *int* Must be the size in px or `default`.

>>**alignment** - *string* Text alignment, must be `left`, `center` or `right`, default `right`.

>**navigation** - *object* Style fot the navigation menu.

>>**font** - *string* Must be the font name or `default`.

>>**size** - *int* Must be the size in px or `default`.

>>**alignment** - *string* Text alignment, must be `left`, `center` or `right`, default `right`.

>**error** - *object* Style fot the error block (3 units).

>>**font** - *string* Must be the font name or `default`.

>>**size** - *int* Must be the size in px or `default`.

>>**alignment** - *string* Text alignment, must be `left`, `center` or `right`, default `center`.