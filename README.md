# 2FA Support 
:rocket: Title says it all! This plugin adds 2FA support to YOURLS!

Requires [YOURLS](https://yourls.org) `>=1.7.3` and above.

## Usage

![Screenshot 1](https://camo.githubusercontent.com/1a4446f7c09f7bd8c2a3ed8e6cefe808f33869f154968380c4a92a173ad3e1b8/68747470733a2f2f67686f737463646e2d73332e73332e75732d656173742d312e616d617a6f6e6177732e636f6d2f73637265656e73686f7430322e706e673f726573706f6e73652d636f6e74656e742d646973706f736974696f6e3d696e6c696e6526582d416d7a2d53656375726974792d546f6b656e3d49516f4a62334a705a326c755832566a454473614358567a4c575668633351744d534a484d455543494873677953384847637330625256396473797a58795859467a72674867436f4652467a6f3858323378524f41694541783847376b694b627a79734934676e44335434253246437069387025324272596b446525324242376679253242713774516c637138514949685025324625324625324625324625324625324625324625324625324625324641524141476777314f4445344d6a49314d6a51774f445169444c676465253242533339534839704e422532427379724641676f31796576456f316b4d666f416d50304a3371624f6767253242334b68516742544879616742734f685264555277384c7752736a4f7a724f41424f33253242666f7969766c736856746278644456686c4862574d656f38662532465466536f7137524c6169764361765655616225324272625050253242386d577a716867715031753559324c6657515a4e716439614551726d50386f477574773730797942717a43324272346779364e4333626b684f32736573444b656d326c47494725324245684463724d7254766479636b4a75674a4c33706b6f253242537941434e4972513138726d575975786d34755358312532464d6a42377632766f776338304854414f334d6e71744e50306c25324267346b7a4a4f6935695a366e4d6d25324676646338746d34682532466c68665558524d59745a34726141726c59383525324633714a307438436e38327543577935516d7343336f66724f687038666c714e484f3553454b5561303137425867744c7a5025324243595a4e6234504e34736b6b625956746e5730335144456a496f5a514b45325a6378512532464e315646322532462532425742654857437972507a4252784c5957714c4b6765556731474232464f504e6d434c7644667337596f4e526b776e2532464c776c67593673774a465778764f4973427245317934587875546842486a6e394845553154683453383345684132756b4337446d64674a487977504e50516462646c596e7239697845424967426142514d4c44564e73354e70726a3650737261525736557261532532426e556e34554749497655685157615a536a6f4e50704a4c6e747663512532426f5065676d72794958626c6f75504573724a346c554864514c42576c6f42513147324337767152536859656d7456344f797a556e67507830334b4848695333793734536b77316c5939593851784f537247616875526933764d46455879647a6a707a4b625650794844646c4235524632346b324e6969306a6a253246325a4e434d3951325a5431756b787a3331754b6e6a45705238507a2532424345756f35684b6e663867784d6368456f38253246346d7255526f77414d6444384b556654413253766943645163432532423542514d76756159766b6f6c587355514742685845366a4d4244496c52727758594d794a41665943374d736841455a343038722532463556354930337368495168505657424e6b6155714c744d39394d73576c47536e4e704a773826582d416d7a2d416c676f726974686d3d415753342d484d41432d53484132353626582d416d7a2d446174653d3230323230373234543032333233305a26582d416d7a2d5369676e6564486561646572733d686f737426582d416d7a2d457870697265733d343332303026582d416d7a2d43726564656e7469616c3d41534941594f353254464b324d34594b32414951253246323032323037323425324675732d656173742d312532467333253246617773345f7265717565737426582d416d7a2d5369676e61747572653d30633864376661353034313137346564326639636535666537313536393133623237303430626131343236303063373361326366646135626439613134316238)
![Screenshot 2](https://camo.githubusercontent.com/2439a2d60ef6e23f74fc96cbc5441f3db6652bb1b904d923cbefd847f4199690/68747470733a2f2f67686f737463646e2d73332e73332e75732d656173742d312e616d617a6f6e6177732e636f6d2f73637265656e73686f7430312e706e673f726573706f6e73652d636f6e74656e742d646973706f736974696f6e3d696e6c696e6526582d416d7a2d53656375726974792d546f6b656e3d49516f4a62334a705a326c755832566a454473614358567a4c575668633351744d534a484d455543494873677953384847637330625256396473797a58795859467a72674867436f4652467a6f3858323378524f41694541783847376b694b627a79734934676e44335434253246437069387025324272596b446525324242376679253242713774516c637138514949685025324625324625324625324625324625324625324625324625324625324641524141476777314f4445344d6a49314d6a51774f445169444c676465253242533339534839704e422532427379724641676f31796576456f316b4d666f416d50304a3371624f6767253242334b68516742544879616742734f685264555277384c7752736a4f7a724f41424f33253242666f7969766c736856746278644456686c4862574d656f38662532465466536f7137524c6169764361765655616225324272625050253242386d577a716867715031753559324c6657515a4e716439614551726d50386f477574773730797942717a43324272346779364e4333626b684f32736573444b656d326c47494725324245684463724d7254766479636b4a75674a4c33706b6f253242537941434e4972513138726d575975786d34755358312532464d6a42377632766f776338304854414f334d6e71744e50306c25324267346b7a4a4f6935695a366e4d6d25324676646338746d34682532466c68665558524d59745a34726141726c59383525324633714a307438436e38327543577935516d7343336f66724f687038666c714e484f3553454b5561303137425867744c7a5025324243595a4e6234504e34736b6b625956746e5730335144456a496f5a514b45325a6378512532464e315646322532462532425742654857437972507a4252784c5957714c4b6765556731474232464f504e6d434c7644667337596f4e526b776e2532464c776c67593673774a465778764f4973427245317934587875546842486a6e394845553154683453383345684132756b4337446d64674a487977504e50516462646c596e7239697845424967426142514d4c44564e73354e70726a3650737261525736557261532532426e556e34554749497655685157615a536a6f4e50704a4c6e747663512532426f5065676d72794958626c6f75504573724a346c554864514c42576c6f42513147324337767152536859656d7456344f797a556e67507830334b4848695333793734536b77316c5939593851784f537247616875526933764d46455879647a6a707a4b625650794844646c4235524632346b324e6969306a6a253246325a4e434d3951325a5431756b787a3331754b6e6a45705238507a2532424345756f35684b6e663867784d6368456f38253246346d7255526f77414d6444384b556654413253766943645163432532423542514d76756159766b6f6c587355514742685845366a4d4244496c52727758594d794a41665943374d736841455a343038722532463556354930337368495168505657424e6b6155714c744d39394d73576c47536e4e704a773826582d416d7a2d416c676f726974686d3d415753342d484d41432d53484132353626582d416d7a2d446174653d3230323230373234543032333132305a26582d416d7a2d5369676e6564486561646572733d686f737426582d416d7a2d457870697265733d343332303026582d416d7a2d43726564656e7469616c3d41534941594f353254464b324d34594b32414951253246323032323037323425324675732d656173742d312532467333253246617773345f7265717565737426582d416d7a2d5369676e61747572653d63633633626466646137383431356432646131613563643036363438323037393563343366613731636564363737303037333636656462663635633766343239)
## Installation

1. In `/user/plugins`, create a new folder named `matthew_2fa_support`.
    1. Alternatively clone this repostiory in `/user/plugins` and skip steps 1-3
2. Drop all files into that folder.
3. Create another folder named `PHPGangsta` inside `matthew_2fa_support`, and drop `GoogleAuthenticator.php` into that folder.
4. Go to the Plugins administration page (eg. `http://sho.rt/admin/plugins.php`) and activate the plugin.
5. Once active, head over to the "2FA Setup" section (eg. `http://sho.rt/admin/plugins.php?page=matthew_2fa_support`)
6. Hit `Activate?` and follow the instructions.

![Demo GIF](https://ghostcdn-s3.s3.us-east-1.amazonaws.com/2fa_demo2.gif?response-content-disposition=inline&X-Amz-Security-Token=IQoJb3JpZ2luX2VjEDsaCXVzLWVhc3QtMSJHMEUCIHsgyS8HGcs0bRV9dsyzXyXYFzrgHgCoFRFzo8X23xROAiEAx8G7kiKbzysI4gnD3T4%2FCpi8p%2BrYkDe%2BB7fy%2Bq7tQlcq8QIIhP%2F%2F%2F%2F%2F%2F%2F%2F%2F%2FARAAGgw1ODE4MjI1MjQwODQiDLgde%2BS39SH9pNB%2BsyrFAgo1yevEo1kMfoAmP0J3qbOgg%2B3KhQgBTHyagBsOhRdURw8LwRsjOzrOABO3%2BfoyivlshVtbxdDVhlHbWMeo8f%2FTfSoq7RLaivCavVUab%2BrbPP%2B8mWzqhgqP1u5Y2LfWQZNqd9aEQrmP8oGutw70yyBqzC2Br4gy6NC3bkhO2sesDKem2lGIG%2BEhDcrMrTvdyckJugJL3pko%2BSyACNIrQ18rmWYuxm4uSX1%2FMjB7v2vowc80HTAO3MnqtNP0l%2Bg4kzJOi5iZ6nMm%2Fvdc8tm4h%2FlhfUXRMYtZ4raArlY85%2F3qJ0t8Cn82uCWy5QmsC3ofrOhp8flqNHO5SEKUa017BXgtLzP%2BCYZNb4PN4skkbYVtnW03QDEjIoZQKE2ZcxQ%2FN1VF2%2F%2BWBeHWCyrPzBRxLYWqLKgeUg1GB2FOPNmCLvDfs7YoNRkwn%2FLwlgY6swJFWxvOIsBrE1y4XxuThBHjn9HEU1Th4S83EhA2ukC7DmdgJHywPNPQdbdlYnr9ixEBIgBaBQMLDVNs5Nprj6PsraRW6UraS%2BnUn4UGIIvUhQWaZSjoNPpJLntvcQ%2BoPegmryIXblouPEsrJ4lUHdQLBWloBQ1G2C7vqRShYemtV4OyzUngPx03KHHiS3y74Skw1lY9Y8QxOSrGahuRi3vMFEXydzjpzKbVPyHDdlB5RF24k2Nii0jj%2F2ZNCM9Q2ZT1ukxz31uKnjEpR8Pz%2BCEuo5hKnf8gxMchEo8%2F4mrURowAMdD8KUfTA2SviCdQcC%2B5BQMvuaYvkolXsUQGBhXE6jMBDIlRrwXYMyJAfYC7MshAEZ408r%2F5V5I03shIQhPVWBNkaUqLtM99MsWlGSnNpJw8&X-Amz-Algorithm=AWS4-HMAC-SHA256&X-Amz-Date=20220724T040611Z&X-Amz-SignedHeaders=host&X-Amz-Expires=43200&X-Amz-Credential=ASIAYO52TFK2M4YK2AIQ%2F20220724%2Fus-east-1%2Fs3%2Faws4_request&X-Amz-Signature=32fd0f0077b46c483d77cbd128fdf22143e5d609c0db270ccbc60f4b30af3819)

## License

This plugin is licensed under the [MIT License](LICENSE).
