# 2FA Support 
:rocket: Title says it all! This plugin adds 2FA support to YOURLS!

Requires [YOURLS](https://yourls.org) `>=1.7.3` and above.

## Usage

![Screenshot 1](https://user-images.githubusercontent.com/16270955/180672030-5d9fc39e-2927-4b31-bde3-b738530f69f5.png)
![Screenshot 2](https://user-images.githubusercontent.com/16270955/180672042-97aecb66-d5c7-46bc-b5c3-12e2620d0fdf.png)


## Installation

1. In `/user/plugins`, create a new folder named `matthew_2fa_support`.
    1. Alternatively clone this repostiory in `/user/plugins` and skip steps 1-3
2. Drop all files into that folder.
3. Create another folder named `PHPGangsta` inside `matthew_2fa_support`, and drop `GoogleAuthenticator.php` into that folder.
4. Go to the Plugins administration page (eg. `http://sho.rt/admin/plugins.php`) and activate the plugin.
5. Once active, head over to the "2FA Setup" section (eg. `http://sho.rt/admin/plugins.php?page=matthew_2fa_support`)
6. Hit `Activate?` and follow the instructions.


https://user-images.githubusercontent.com/16270955/180631967-bc8fd27f-4d33-4f81-9f25-85abb9f7ff93.mp4


## License

This plugin is licensed under the [MIT License](LICENSE).
