# Extension:EmulateGroup

The EmulateGroup extension allows users to temporarily become a different group.
This is useful to see how the wiki looks through regular user eyes (if an admin)

## Installation

* Download and place the file(s) in a directory called EmulateGroup in your extensions/ folder
* Add the following line to your LocalSettings.php
```
wfLoadExtension('EmulateGroup');
```
* Run the update script `php <mediawiki-instance>/maintenance/update.php` to create the DB tables

## Usage

Logged in users can start emulating by choosing the group from the dropdown in the left menu,
and then clicking "Emulate."  They can stop by then clicking "Stop" in the same place.

## Parameters

* `$wgEmulateGroupGroupList` - The list of groups that can be emulated to.  Defaults to all
  keys of `$wgGroupPermissions` sorted alphabetically.  If a function, will be called to
  get the list.

## Rights

* `'emulategroup'` - Accounts who have the rights to use EmulateGroup

To enable for admins, the following to lines should be added:

```
$wgGroupPermissions['sysop']['emulategroup'] = true;
```

## Internationalization

Currently only has support for English.
