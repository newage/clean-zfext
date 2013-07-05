#CHANGELOG

##2.0.0 (2013-07-05):
- 5fce7d0 Update (user); Enable database queries caching
- 018ade1 [#2] Feature (core); Added command-tool for create new models structure
- 3f27aae Fix (core); Fixed paths in zf
- 7f1da08 Fix (user); Removed old code, changed bug in save name in profile, changed profile comtroller to index controller
- 718b114 [#1] Fix (user); Fixed show notification
- 463042c Fix (user, core); Updated core, changed job in database layer, changed all models to work with Zend_Db_Table
- d5cb852 Fix (core); Removed old code
- 852dff5 Fix (users); Added relationships to users and images db_tables. Changed models to db_row object
- b9978df [#23] Fix (acl); Fixed redirect to previous url after login

##1.2.1 (2013-06-21):
- 3e85e98 Fixed show default image
- bcdc5c6 Created avatar decorator for file field, created errorModal function
- 5c80b38 Fixed load font-awesome style
- f239abe Added new fields to registration form for more example
- 29f15a3 Added decorator for radio with use twitter bootstrap
- 2902106 Added multi-checkbox element decorator with twitter bootstrap
- 4169e39 Update Manifest for load zf_tool
- 242219d Update install.sh script
- ee420be Enable database persistent connection
- 433b4c1 Set metadata cache
- 9074b32 Update composer and create skeleton for email core
- 95c4e45 [#21] Change method name for load layout for default module
- 6dfe189 [#20] Create zf bash file for load local zf config
- bfa651c Update header for new font-awesome library
- 101e06d Change components folder name to view
- 1ceff85 Add Zend_Currency to Zend_Registry, and will can use view helper $this->currency()
- b9b831e Update footer view
- 529ddf6 Added to composer extend dropdown menu for bootstrap
- 8031e54 Move all js scripts from header to footer
- 84c9646 Update new user registration, update file upload field

##1.2.0 (2013-04-30):
- dc01677 [#14] Remove dead code, and redirect to access page after login
- b910f91 [#19] Move jquery script from layout to plugin. Maybe in future not loaded jquery scripts from all view
- f32c4c8 [#5] Fix login problem in authenticate controller
- 8e5f9af Add library for jquery script
- fd5b979 [#17] Collect all jquery string and show at one string
- 1bb15d2 Merge branch 'feature/autoload-layouts' into develop
- 69efc87 [#18] Load plugin after dispatch loot shutdown
- 42b5c68 Create layout plugin with autoloading existing layout for modules
- 962f220 Create controller plugin for autoload layout
- ce435e8 Add jquery i18n plugin
- f64023b Add jquery view helper
- 80e342e Update composer
- 164a82c Resolve conflicts
- 83f7ca4 Add development.ini file to gitignore
- a46e78b Add development.ini file to gitignore
- 075150a Update composer config
- 563e5ee Add twitter checkbox
- b841c52 Fix bug in translate plugin
- c1864ed Fix composer json
- 16f2ba7 Update translate in messenger
- 979012b Update twitter input file field
- c8de906 Add i18n jquery plugin
- e1b6982 Add plural to gettext translate file
- d70df09 Add plural forms to translate
- 00fa19f Add confirm modal and json error modal
- 3f1878a Resolve conflicts
- be6b6dd Add and on awesome font
- c4494b4 Update libraries version
- fa8633d Merge branch 'release/1.1.7' into develop
- 5b7fdc6 Update docs in administrator and user modules
- 3ccde9d Update documentation in default module

##1.1.7 (2013-02-26):
- c58fe34 Create image model
- 5bfa4b5 Create upload helper
- 2971790 Fix error pages
- ddfb8ef Fix button type in decorator
- e1de74f Fix title in forms
- 17d84d9 Merge branch 'feature/add-wysiwyg' into develop
- 6311a4a Fix twitter buttons in decorators
- a773860 Add wysiwyg
- e81f34f Add textarea, file, buttons decorators and update button decorator
- 8ca0ab1 [#7] Update install script
- 71cf9fd Remove application.development.ini
- f51ecd6 [#13] Add prettify library and create helper
- 0296c86 [#10] Add notification js library and update messenger helper
- d3b4a6e [#6] Update css for form in .hero-unit part
- 7421b25 Update install and create uninstall

##1.1.6 (2013-01-23):
- fc327e2 (HEAD, origin/develop, release/1.1.6, develop) Fix error in changelog file
- 1194068 Create changelog file
- e0d411d Add select2 decorator and update other decorators
- 2b6ee38 Clean old files from library
- 45dfb6f Install zf tool
- e656507 Merge branch 'hotfix/1.1.5' into develop

##1.1.5 (2012-11-27):
- 2197727 (tag: 1.1.5, origin/master, origin/HEAD, master) Merge branch 'hotfix/1.1.5'
- d462249 Remove bower from install.sh file

##1.1.4 (2012-11-27):
- ef53c5d (tag: 1.1.4) Merge branch 'release/1.1.4'
- 6b0dff2 Update zf-debug plugin and add js libraries to composer
- 58e99dc Create install bash script
- 74a41c0 Move jquery & bootstrap to bower create bower json config
- c18d5e2 Merge branch 'hotfix/1.1.3' into develop
- 337fcb1 Merge branch 'hotfix/1.1.2' into develop

##1.1.3 (2012-11-26):
- 2402e7e (tag: 1.1.3) Merge branch 'hotfix/1.1.3'
- 98607af Remove old tools from manifest

##1.1.2 (2012-11-22):
- 58043af (tag: 1.1.2) Merge branch 'hotfix/1.1.2'
- 6a560b2 Disable debug plugin if start process in command line
- e854f65 Crash manifest
- 8f74710 Ignore composer files
- 45b6f09 Change paginator to bootstrap
- 88ca09e Fix composer autoload

##1.1.1 (2012-11-14):
- 42f9459 (tag: 1.1.1) Add composer to project
- 26ccb76 Update bootstrap to 2.2.1
- 923bd47 Update composer jobs
- 4ebebcb Fix footer in css
- ce2b4c7 Update build.xml for ant

##1.1.0 (2012-11-09):
- 0f5cdb6 (tag: 1.1.0) Fix footer css
- b717a0b Update Twitter Bootstrap to 2.2
- e42535c Update bootstrap to 2.1.1 version
- 3c5cfe5 clean repository and add description
- a0c75f5 Create default row and rowset, update row to return model object
- 1ab6879 Fix row in table abstract
- 867018b Fix get db from user mapper
- 276af66 Fix model mapper extends
- 7a67dc4 Fix model abstract class
- 6ab1a21 Merge branch 'release' into develop
- ba6368a Merge branch 'develop' of bitbucket.org:newage/clean-zfext into develop
- 2d90e71 Remove old images
- c61ee4d Update redirect from session in acl plugin
- ecde88d Update bootstrap css to 2.1.0
- 9c0401f Fix dbModel code generate

##1.0.4 (2012-08-28):
- 0e7482c (tag: 1.0.4) Fix translator to breadcrumbs
- 21643ca Add translator to breadcrumbs template
- 2a21bcd Create breadcrumb
- d4a090a Enable tooltip in "a" elements
- d9d2402 Use popover in form elements
- 07dbe39 Update acl

##1.0.3 (2012-08-24):
- 3bb921b (tag: 1.0.3) Add default users in fixture
- 7cfdf2b Update navigations menu and create default menu
- a042112 Update form errors message


##1.0.2 (2012-08-24):
- 6df2ad1 Write session to db

##1.0.1 (2012-08-23):
- b2399f1 (tag: 1.0.1) Add email tool
- 21108d4 Enable logout action


