# LMSAdescomPlugin
All notable changes to this project will be documented in this file.
This project adheres to [Semantic Versioning](http://semver.org/) and [Keep a CHANGELOG](http://keepachangelog.com/).

## [1.2.0] - 2015-08-14
### Added
- added CHANGELOG in polish language
- added supported LMS versions informations in README file
- added information about "adescom" section in "User Interface Configuration" > "User Interface"
- added plugin author informations
- added plugin name informations

### Changed
- adjusted templates to new plugin templates management engine
- adjusted EOLs
- droped support for HTML and PDF versions of README
- changed CHANGELOG format
- removed deprecated plugins screen shots
- removed deprecated informations about translation strings from README file, translation strings are now automatically merged in LMS
- removed deprecated informations about "default_" variables in lms.ini file
- improved plugin directory path determination

### Fixed
- fixed warnings for non defined fractions in lms-payments

## [1.1.12] - 2015-07-30
### Fixed
- fixed customer VoIP assignments edit methods

## [1.1.11] - 2015-07-21
### Fixed
- fixed customer's voip accounts get method for customers than are not present at Adescom VoIP central

## [1.1.10] - 2015-07-13
### Fixed
- fixed customer delete action for customers that are not present at Adescom VoIP central

## [1.1.9] - 2015-06-30
### Fixed
- fixed default value for UF2M checking
- fixed some encoding problems in lms-payments script

## [1.1.8] - 2015-06-15
### Added
- added lms-payments ability to use uiconfig adescom section variables

### Fixed
- changed "eq" to "==" and "neq" to "!=" Smarty comparison operators

## [1.1.7] - 2015-05-08
### Added
- some config variables from lms.ini have been moved to database with backward compatibility

## [1.1.6] - 2015-04-22
### Added
- added synchronization howto

### Fixed
- fixed prepaid account add procedure for older versions of PHP
- fixed path to invoice edit template
- removed right to select ctm local check

## [1.1.5] - 2015-04-10
### Fixed
- added return statement in lmsInit handler
- changed some class names to avoid conflicts

## [1.1.4] - 2015-04-02
### Fixed
- fixed free numbers from pool request parser for frontend webservice

## [1.1.3] - 2015-03-25
### Changed
- updated README files

## [1.1.2] - 2015-03-19
### Added
- README file

## [1.1.1] - 2015-03-17
### Changed
- removed customer add and customer edit handlers

## [1.1.0] - 2015-03-03
### Changed
- added more OOP
- added more documentation
- removes deprecated code

## [1.0.13] - 2015-02-23
### Added
- added some documentation

### Fixed
- fixed error displaying at VoIP account edit form

## [1.0.12] - 2015-02-17 
### Fixed
- optimised execution time of VoIP accounts information lists
- fixed problem with saving default absolute limit
- fixed problem with checking if client already exists at CTM while adding new VoIP account

## [1.0.11] - 2015-02-11
### Added
- added block levels to VoIP add form

### Fixed
- fixed prepaid charge/recharge problem with ',' separated decimal values
- fixed displaying of VoIP account info at prepaid recharge form
- fixed displaying of block levels at VoIP edit form

## [1.0.10] - 2015-02-10
### Fixed
- fixed add clients webservice request
- fixed VoIP assignments add and edit forms

## [1.0.9] - 2015-02-02
### Fixed
- fixed displaying errors at customer add form
- fixed billing filtering
- fixed add and edit invoice forms

## [1.0.8] - 2015-02-01
### Fixed
- fixed problems with displaying invoice add form

## [1.0.7] - 2015-01-22
### Fixed
- fixed CTM name at VoIP informations print page

## [1.0.6] - 2015-01-13
### Added
- added this changelog

### Fixed
- fixed VoIP account owner switching

## [1.0.5] - 2015-01-11
### Fixed
- fixed VoIP account status at VoIP info form

## [1.0.4] - 2014-12-07
### Changed
- changed templates path according to changes in LMS

## [1.0.3] - 2014-11-14
### Fixed
- fixed VoIP edit problems: sets account access to true by default, provides default phone and login

## [1.0.2] - 2014-11-06
### Changed
- removed Adescom connection where it is not required

## [1.0.1] - 2014-11-05
### Fixed
- fixed VoIP assignment management
- fixed phone profile problem at VoIP add form
- fixed pool problem at VoIP add form
- fixed VoIP status at VoIP info form
- fixed VoIP box at node info form
- fixed problems at customer add form

## [1.0.0] - 2014-10-16
### Added
- first version of a plugin
- VoIP and customer management
- VoIP assignments
- VoIP liabilities at invoice items list
- billing reports
