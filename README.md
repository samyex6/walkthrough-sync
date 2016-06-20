# walkthrough-sync

Dependencies: AngularJS 1.4.9

The aim of this tool is based on my needs of making walkthroughs for Pokemon Sun & Moon, synchronizing images automatically while I'm taking screenshots from the game.

This is a local experimental version, server uploading feature still needs to be implemented.

It uses dirty long polling to check if the file `progress` is empty, if so, run `sync.bash`, otherwise check if it's timestamp is greater than what `$_GET['timstamp']` had passed and then return the content.

`sync.bash` simply optimizes what's in the folder `screenshots/original`, place the output to `screenshots/optimized` and then move the original image to `screenshots/processed`.

Note that the current version is written under Linux environment, since my 3DS capture tool can only run on Windows so I'll need to convert it to Windows compatible.
