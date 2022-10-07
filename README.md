# TYPO3 Extension `slub_web_profile`

[![TYPO3](https://img.shields.io/badge/TYPO3-9-orange.svg)](https://typo3.org/)

profile service extension for the SLUB website.

## 1 Usage

### 1.1 Installation using Composer

The recommended way to install the extension is using [Composer][1].

Run the following command within your Composer based TYPO3 project:

```
composer require slub/slub-web-profile
```

## 2 Administration corner

### 2.1 Release Management

News uses [semantic versioning][2], which means, that
* **bugfix updates** (e.g. 1.0.0 => 1.0.1) just includes small bugfixes or security relevant stuff without breaking changes,
* **minor updates** (e.g. 1.0.0 => 1.1.0) includes new features and smaller tasks without breaking changes,
* **major updates** (e.g. 1.0.0 => 2.0.0) breaking changes which can be refactorings, features or bugfixes.

### 2.2 Api

#### Configuration

The general domain to call the "profile service" can be set in the field "Domain" in "Settings Module" -> "Extension Configuration". Just take care that the domain begins with a protocol like "https://" and has no trailing slash. The profile service works with different paths to provide a multilingual experience you can configure via typoscript.

#### Typoscript

| Setup / Constant                                                 | Comment                                                                                                                                |
|------------------------------------------------------------------|----------------------------------------------------------------------------------------------------------------------------------------|
| plugin.tx_slubwebprofile.settings.api.path.bookedList            | Path to get the booked list.                                                                                                           |
| plugin.tx_slubwebprofile.settings.api.path.bookmarkList          | Path to get the bookmark list.                                                                                                         |
| plugin.tx_slubwebprofile.settings.api.path.reserveCurrent        | Path for currently reserved media                                                                                                      |
| plugin.tx_slubwebprofile.settings.api.path.reserveHistory        | Path for reserved, past media                                                                                                          |
| plugin.tx_slubwebprofile.settings.api.path.loanCurrent           | Path for currently loan media                                                                                                          |
| plugin.tx_slubwebprofile.settings.api.path.loanHistory           | Path for loaned, past media                                                                                                            |
| plugin.tx_slubwebprofile.settings.api.path.eventList             | "language array" to collect paths to call the event list. The numbers (sys_language_uid) have to fit with your configured languages.   |
| plugin.tx_slubwebprofile.settings.api.path.eventList.0           | Path for the sys_language_uid "0" (as example german), begins and ends with a slash, will be extended with user id                     |
| plugin.tx_slubwebprofile.settings.api.path.eventList.1           | Path for the sys_language_uid "1" (as example english), begins and ends with a slash, will be extended with user id                    |
| plugin.tx_slubwebprofile.settings.api.path.messageList           | "language array" to collect paths to call the message list. The numbers (sys_language_uid) have to fit with your configured languages. |
| plugin.tx_slubwebprofile.settings.api.path.messageList.0         | Path for the sys_language_uid "0" (as example german), begins and ends with a slash, will be extended with user category               |
| plugin.tx_slubwebprofile.settings.api.path.messageList.1         | Path for the sys_language_uid "1" (as example english), begins and ends with a slash, will be extended with user category              |
| plugin.tx_slubwebprofile.settings.api.path.userAccountDetail     | Path to get a single user (contains: account) data                                                                                     |
| plugin.tx_slubwebprofile.settings.api.path.userAccountUpdate     | Path to update a single user (contains: account) data                                                                                  |
| plugin.tx_slubwebprofile.settings.api.path.userDashboardDetail   | Path to get a single user (contains: dashboard) data                                                                                   |
| plugin.tx_slubwebprofile.settings.api.path.userDashboardUpdate   | Path to update a single user (contains: dashboard) data                                                                                |
| plugin.tx_slubwebprofile.settings.api.path.userSearchQueryDetail | Path to get a single user (contains: search query) data                                                                                |
| plugin.tx_slubwebprofile.settings.api.path.userSearchQueryUpdate | Path to update a single user (contains: search query) data                                                                             |

[1]: https://getcomposer.org/
[2]: https://semver.org/

