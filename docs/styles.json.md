## FILE : styles.json
This file customisation settings for SimplyShorts.
If this file is invalid or absent, or if some values are invalid or absent, `config.default.json`'s values will be used.

**font** - *object*	Font files must be in the dir `fonts`.

>**interline** *decimal* Space between line in line (ie.: `1.3`).

>**color** - *[int,int,int]* 	Text color, RGB - 0 to 255.

>**linkColor** - *[int,int,int]* 	Links color, RGB - 0 to 255.

>**defaultSans** - *string* 	The default Serif font, without the extension.

>**defaultSerif** - *string* The default font type, must be `sans` or `serif`.

>**defaultSize** - *int* The default size for texts in px.

**backgroundColor** - *[int,int,int]* Background color, fallback too, RGB - 0 to 255.

**backgrounds** - *array of objects*	Backgrounds, can be empty.

>**type** - *string* Must be `gradient`, `radialGradient` once, and/or `image` as many times as desired.

>**from** - *[int,int,int]* For `gradient` and `radialGradient`, the start color, RGB - 0 to 255.

>**to** - *[int,int,int]* For `gradient` and `radialGradient`, the end color, RGB - 0 to 255.

>**image** - *string* For `image`, filename of desired image, background files must be in `img/background`.

>**repeat** - *string* For `image`, like `background-repeat` CSS property, default `repeat`.

>**position** - *string* For `image`, like `background-position` CSS property, default `center`.

>**attachment** - *string* For `image`, like `background-attachment` CSS property : `scroll` or `fixed`, default `fixed`.

**blocks** - *object* Style for blocks

>**backgroundColor** - *[int,int,int,int]* Background color, RGB - 0 to 255 + alpha.

>**borderRadius** - *int* Corner radius in px.

>**shadow** - *[int,int,int,[int,int,int,int]]* Shadow : x, y, radius, then RGB - 0 to 255 + alpha.

>**alignment** - *string* Text alignment, must be `left`, `center` or `right`, default `right`.

>**width** - *int* Width of one unit block, in px.

>**margin** - *int* Space in px between blocks.

>**padding** - *int* Intern margin in blocks.

**title** - *object* Style for title on the home page.

>**font** - *string* Must be the font name or `default`.

>**size** - *int* Must be the size in px or `default`.

>**alignment** - *string* Text alignment, must be `left`, `center` or `right`, default `right`.

**navigation** - *object* Style fot the navigation menu.

>**font** - *string* Must be the font name or `default`.

>**size** - *int* Must be the size in px or `default`.

>**alignment** - *string* Text alignment, must be `left`, `center` or `right`, default `right`.

**Footer** - *object* Footer blocks.

>**opacity** - *decimal* Opacity of this blocks.

**error** - *object* Style fot the error block (3 units).

>**font** - *string* Must be the font name or `default`.

>**size** - *int* Must be the size in px or `default`.

>**alignment** - *string* Text alignment, must be `left`, `center` or `right`, default `center`.