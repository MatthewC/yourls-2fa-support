# 2FA Support 
:rocket: Title says it all! This plugin adds 2FA support to YOURLS!

Requires [YOURLS](https://yourls.org) `>=1.7.3` and above.

## Usage

:bulb: This is a great place for showing a few usage examples!

:camera: If applicable, a screenshot of the admin interface or anything relevant is super helpful

![Screenshot 1](https://ghostcdn-s3.s3.us-east-1.amazonaws.com/screenshot02.png?response-content-disposition=inline&X-Amz-Security-Token=IQoJb3JpZ2luX2VjEDsaCXVzLWVhc3QtMSJHMEUCIHsgyS8HGcs0bRV9dsyzXyXYFzrgHgCoFRFzo8X23xROAiEAx8G7kiKbzysI4gnD3T4%2FCpi8p%2BrYkDe%2BB7fy%2Bq7tQlcq8QIIhP%2F%2F%2F%2F%2F%2F%2F%2F%2F%2FARAAGgw1ODE4MjI1MjQwODQiDLgde%2BS39SH9pNB%2BsyrFAgo1yevEo1kMfoAmP0J3qbOgg%2B3KhQgBTHyagBsOhRdURw8LwRsjOzrOABO3%2BfoyivlshVtbxdDVhlHbWMeo8f%2FTfSoq7RLaivCavVUab%2BrbPP%2B8mWzqhgqP1u5Y2LfWQZNqd9aEQrmP8oGutw70yyBqzC2Br4gy6NC3bkhO2sesDKem2lGIG%2BEhDcrMrTvdyckJugJL3pko%2BSyACNIrQ18rmWYuxm4uSX1%2FMjB7v2vowc80HTAO3MnqtNP0l%2Bg4kzJOi5iZ6nMm%2Fvdc8tm4h%2FlhfUXRMYtZ4raArlY85%2F3qJ0t8Cn82uCWy5QmsC3ofrOhp8flqNHO5SEKUa017BXgtLzP%2BCYZNb4PN4skkbYVtnW03QDEjIoZQKE2ZcxQ%2FN1VF2%2F%2BWBeHWCyrPzBRxLYWqLKgeUg1GB2FOPNmCLvDfs7YoNRkwn%2FLwlgY6swJFWxvOIsBrE1y4XxuThBHjn9HEU1Th4S83EhA2ukC7DmdgJHywPNPQdbdlYnr9ixEBIgBaBQMLDVNs5Nprj6PsraRW6UraS%2BnUn4UGIIvUhQWaZSjoNPpJLntvcQ%2BoPegmryIXblouPEsrJ4lUHdQLBWloBQ1G2C7vqRShYemtV4OyzUngPx03KHHiS3y74Skw1lY9Y8QxOSrGahuRi3vMFEXydzjpzKbVPyHDdlB5RF24k2Nii0jj%2F2ZNCM9Q2ZT1ukxz31uKnjEpR8Pz%2BCEuo5hKnf8gxMchEo8%2F4mrURowAMdD8KUfTA2SviCdQcC%2B5BQMvuaYvkolXsUQGBhXE6jMBDIlRrwXYMyJAfYC7MshAEZ408r%2F5V5I03shIQhPVWBNkaUqLtM99MsWlGSnNpJw8&X-Amz-Algorithm=AWS4-HMAC-SHA256&X-Amz-Date=20220724T023230Z&X-Amz-SignedHeaders=host&X-Amz-Expires=43200&X-Amz-Credential=ASIAYO52TFK2M4YK2AIQ%2F20220724%2Fus-east-1%2Fs3%2Faws4_request&X-Amz-Signature=0c8d7fa5041174ed2f9ce5fe7156913b27040ba142600c73a2cfda5bd9a141b8)
![Screenshot 2](https://ghostcdn-s3.s3.us-east-1.amazonaws.com/screenshot01.png?response-content-disposition=inline&X-Amz-Security-Token=IQoJb3JpZ2luX2VjEDsaCXVzLWVhc3QtMSJHMEUCIHsgyS8HGcs0bRV9dsyzXyXYFzrgHgCoFRFzo8X23xROAiEAx8G7kiKbzysI4gnD3T4%2FCpi8p%2BrYkDe%2BB7fy%2Bq7tQlcq8QIIhP%2F%2F%2F%2F%2F%2F%2F%2F%2F%2FARAAGgw1ODE4MjI1MjQwODQiDLgde%2BS39SH9pNB%2BsyrFAgo1yevEo1kMfoAmP0J3qbOgg%2B3KhQgBTHyagBsOhRdURw8LwRsjOzrOABO3%2BfoyivlshVtbxdDVhlHbWMeo8f%2FTfSoq7RLaivCavVUab%2BrbPP%2B8mWzqhgqP1u5Y2LfWQZNqd9aEQrmP8oGutw70yyBqzC2Br4gy6NC3bkhO2sesDKem2lGIG%2BEhDcrMrTvdyckJugJL3pko%2BSyACNIrQ18rmWYuxm4uSX1%2FMjB7v2vowc80HTAO3MnqtNP0l%2Bg4kzJOi5iZ6nMm%2Fvdc8tm4h%2FlhfUXRMYtZ4raArlY85%2F3qJ0t8Cn82uCWy5QmsC3ofrOhp8flqNHO5SEKUa017BXgtLzP%2BCYZNb4PN4skkbYVtnW03QDEjIoZQKE2ZcxQ%2FN1VF2%2F%2BWBeHWCyrPzBRxLYWqLKgeUg1GB2FOPNmCLvDfs7YoNRkwn%2FLwlgY6swJFWxvOIsBrE1y4XxuThBHjn9HEU1Th4S83EhA2ukC7DmdgJHywPNPQdbdlYnr9ixEBIgBaBQMLDVNs5Nprj6PsraRW6UraS%2BnUn4UGIIvUhQWaZSjoNPpJLntvcQ%2BoPegmryIXblouPEsrJ4lUHdQLBWloBQ1G2C7vqRShYemtV4OyzUngPx03KHHiS3y74Skw1lY9Y8QxOSrGahuRi3vMFEXydzjpzKbVPyHDdlB5RF24k2Nii0jj%2F2ZNCM9Q2ZT1ukxz31uKnjEpR8Pz%2BCEuo5hKnf8gxMchEo8%2F4mrURowAMdD8KUfTA2SviCdQcC%2B5BQMvuaYvkolXsUQGBhXE6jMBDIlRrwXYMyJAfYC7MshAEZ408r%2F5V5I03shIQhPVWBNkaUqLtM99MsWlGSnNpJw8&X-Amz-Algorithm=AWS4-HMAC-SHA256&X-Amz-Date=20220724T023120Z&X-Amz-SignedHeaders=host&X-Amz-Expires=43200&X-Amz-Credential=ASIAYO52TFK2M4YK2AIQ%2F20220724%2Fus-east-1%2Fs3%2Faws4_request&X-Amz-Signature=cc63bdfda78415d2da1a5cd0664820795c43fa71ced677007366edbf65c7f429)
## Installation

1. In `/user/plugins`, create a new folder named `matthew_2fa_support`.
2. Drop all files into that folder.
3. Create another folder named "PHPGangsta", and drop `GoogleAuthenticator.php` into that folder.
4. Go to the Plugins administration page (eg. `http://sho.rt/admin/plugins.php`) and activate the plugin.
5. Once active, head over to the "2FA Setup" section (eg. `http://sho.rt/admin/plugins.php?page=matthew_2fa_support`)
6. Hit `Activate?` and follow the instructions.

[]()

## License

This plugin is licensed under the [MIT License](LICENSE).
