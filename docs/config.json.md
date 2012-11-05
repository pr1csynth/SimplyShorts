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

>**basedir** - *string* Base directory of SimplyShort, at the root put `/`.

>**separator** - *string* Separator in url (ie. : `!` → `http://shorts.multoo.eu/coding!add`).