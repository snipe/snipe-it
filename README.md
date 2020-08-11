[![Build Status](https://travis-ci.org/snipe/snipe-it.svg?branch=master)](https://travis-ci.org/snipe/snipe-it) [![Crowdin](https://d322cqt584bo4o.cloudfront.net/snipe-it/localized.svg)](https://crowdin.com/project/snipe-it) [![Gitter](https://badges.gitter.im/Join%20Chat.svg)](https://gitter.im/snipe/snipe-it?utm_source=badge&utm_medium=badge&utm_campaign=pr-badge&utm_content=badge) [![Docker Pulls](https://img.shields.io/docker/pulls/snipe/snipe-it.svg)](https://hub.docker.com/r/snipe/snipe-it/) [![Twitter Follow](https://img.shields.io/twitter/follow/snipeitapp.svg?style=social)](https://twitter.com/snipeitapp)  [![Codacy Badge](https://api.codacy.com/project/badge/Grade/553ce52037fc43ea99149785afcfe641)](https://www.codacy.com/app/snipe/snipe-it?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=snipe/snipe-it&amp;utm_campaign=Badge_Grade)
[![All Contributors](https://img.shields.io/badge/all_contributors-189-orange.svg?style=flat-square)](#contributors) [![Open Source Helpers](https://www.codetriage.com/snipe/snipe-it/badges/users.svg)](https://www.codetriage.com/snipe/snipe-it)


## Snipe-IT - Open Source Asset Management System

This is a FOSS project for asset management in IT Operations. Knowing who has which laptop, when it was purchased in order to depreciate it correctly, handling software licenses, etc.

It is built on [Laravel 5.5](http://laravel.com).

Snipe-IT is actively developed and we [release quite frequently](https://github.com/snipe/snipe-it/releases). ([Check out the live demo here](https://snipeitapp.com/demo/).)

__This is web-based software__. This means there is no executable file (aka no .exe files), and it must be run on a web server and accessed through a web browser. It runs on any Mac OSX, flavor of Linux, as well as Windows, and we have a [Docker image](https://snipe-it.readme.io/docs/docker) available if that's what you're into.

-----

### Installation

For instructions on installing and configuring Snipe-IT on your server, check out the [installation manual](https://snipe-it.readme.io/docs). (Please see the [requirements documentation](https://snipe-it.readme.io/docs/requirements) for full requirements.)

If you're having trouble with the installation, please check the [Common Issues](https://snipe-it.readme.io/docs/common-issues) and [Getting Help](https://snipe-it.readme.io/docs/getting-help) documentation, and search this repository's open *and* closed issues for help.

-----
### User's Manual
For help using Snipe-IT, check out the [user's manual](https://snipe-it.readme.io/docs/overview).

-----
### Bug Reports & Feature Requests

Feel free to check out the [GitHub Issues for this project](https://github.com/snipe/snipe-it/issues) to open a bug report or see what open issues you can help with. Please search through existing issues (open *and* closed) to see if your question has already been answered before opening a new issue.

**PLEASE see the [Getting Help Guidelines](https://snipe-it.readme.io/docs/getting-help) and [Common Issues](https://snipe-it.readme.io/docs/common-issues) before opening a ticket, and be sure to complete all of the questions in the Github Issue template to help us to help you as quickly as possible.**

-----

### Upgrading

Please see the [upgrading documentation](https://snipe-it.readme.io/docs/upgrading) for instructions on upgrading Snipe-IT.

------
### Announcement List

To be notified of important news (such as new releases, security advisories, etc), [sign up for our list](http://eepurl.com/XyZKz). We'll never sell or give away your info, and we'll only email you when it's important.

------

### Translations!

Please see the [translations documentation](https://snipe-it.readme.io/docs/translations) for information about available languages and how to add translations to Snipe-IT.

-----

### Libraries, Modules & Related Projects

Since the release of the JSON REST API, several third-party developers have been developing modules and libraries to work with Snipe-IT.  

- [Python Module](https://github.com/jbloomer/SnipeIT-PythonAPI) by [@jbloomer](https://github.com/jbloomer)
- [SnipeSharp - .NET module in C#](https://github.com/barrycarey/SnipeSharp) by [@barrycarey](https://github.com/barrycarey)
- [InQRy](https://github.com/Microsoft/InQRy) by [@Microsoft](https://github.com/Microsoft)
- [SnipeitPS](https://github.com/snazy2000/SnipeitPS) by [@snazy2000](https://github.com/snazy2000) - Powershell API Wrapper for Snipe-it
- [jamf2snipe](https://github.com/ParadoxGuitarist/jamf2snipe) by [@ParadoxGuitarist](https://github.com/ParadoxGuitarist) - Python script to sync assets between a JAMFPro instance and a Snipe-IT instance
- [Marksman](https://github.com/Scope-IT/marksman) - A Windows agent for Snipe-IT
- [Snipe-IT plugin for Jira Service Desk (beta)](https://marketplace.atlassian.com/apps/1220379/snipe-it-for-jira-service-desk-beta?hosting=cloud&tab=overview) - for the upcoming Snipe-IT v5 only
- [Python 3 CSV importer](https://github.com/gastamper/snipeit-csvimporter) - allows importing assets into Snipe-IT based on Item Name rather than Asset Tag.
- [Snipe-IT Kubernetes Helm Chart](https://github.com/t3n/helm-charts/tree/master/snipeit) - For more information, [click here](https://hub.helm.sh/charts/t3n/snipeit).

As these were created by third-parties, Snipe-IT cannot provide support for these project, and you should contact the developers directly if you need assistance. Additionally, Snipe-IT makes no guarantees as to the reliability, accuracy or maintainability of these libraries. Use at your own risk. :) 

-----

### Security

To report a security vulnerability, please email security@snipeitapp.com instead of using the issue tracker. 

-----

### Contributors

Thanks goes to all of these wonderful people ([emoji key](https://github.com/kentcdodds/all-contributors#emoji-key)) who have helped Snipe-IT get this far:

<!-- ALL-CONTRIBUTORS-LIST:START - Do not remove or modify this section -->
<!-- prettier-ignore-start -->
<!-- markdownlint-disable -->
<table>
  <tr>
    <td align="center"><a href="http://www.snipe.net"><img src="https://avatars3.githubusercontent.com/u/197404?v=3?s=110" width="110px;" alt=""/><br /><sub><b>snipe</b></sub></a><br /><a href="https://github.com/snipe/snipe-it/commits?author=snipe" title="Code">💻</a> <a href="#infra-snipe" title="Infrastructure (Hosting, Build-Tools, etc)">🚇</a> <a href="https://github.com/snipe/snipe-it/commits?author=snipe" title="Documentation">📖</a> <a href="https://github.com/snipe/snipe-it/commits?author=snipe" title="Tests">⚠️</a> <a href="https://github.com/snipe/snipe-it/issues?q=author%3Asnipe" title="Bug reports">🐛</a> <a href="#design-snipe" title="Design">🎨</a> <a href="https://github.com/snipe/snipe-it/pulls?q=is%3Apr+reviewed-by%3Asnipe" title="Reviewed Pull Requests">👀</a></td>
    <td align="center"><a href="http://www.uberbrady.com"><img src="https://avatars0.githubusercontent.com/u/36335?v=3?s=110" width="110px;" alt=""/><br /><sub><b>Brady Wetherington</b></sub></a><br /><a href="https://github.com/snipe/snipe-it/commits?author=uberbrady" title="Code">💻</a> <a href="https://github.com/snipe/snipe-it/commits?author=uberbrady" title="Documentation">📖</a> <a href="#infra-uberbrady" title="Infrastructure (Hosting, Build-Tools, etc)">🚇</a> <a href="https://github.com/snipe/snipe-it/pulls?q=is%3Apr+reviewed-by%3Auberbrady" title="Reviewed Pull Requests">👀</a></td>
    <td align="center"><a href="https://github.com/dmeltzer"><img src="https://avatars0.githubusercontent.com/u/3803132?v=3?s=110" width="110px;" alt=""/><br /><sub><b>Daniel Meltzer</b></sub></a><br /><a href="https://github.com/snipe/snipe-it/commits?author=dmeltzer" title="Code">💻</a> <a href="https://github.com/snipe/snipe-it/commits?author=dmeltzer" title="Tests">⚠️</a> <a href="https://github.com/snipe/snipe-it/commits?author=dmeltzer" title="Documentation">📖</a></td>
    <td align="center"><a href="http://www.tuckertechonline.com"><img src="https://avatars0.githubusercontent.com/u/1609106?v=3?s=110" width="110px;" alt=""/><br /><sub><b>Michael T</b></sub></a><br /><a href="https://github.com/snipe/snipe-it/commits?author=mtucker6784" title="Code">💻</a></td>
    <td align="center"><a href="https://github.com/madd15"><img src="https://avatars2.githubusercontent.com/u/3274937?v=3?s=110" width="110px;" alt=""/><br /><sub><b>madd15</b></sub></a><br /><a href="https://github.com/snipe/snipe-it/commits?author=madd15" title="Documentation">📖</a> <a href="#question-madd15" title="Answering Questions">💬</a></td>
    <td align="center"><a href="https://github.com/vsposato"><img src="https://avatars2.githubusercontent.com/u/894126?v=3?s=110" width="110px;" alt=""/><br /><sub><b>Vincent Sposato</b></sub></a><br /><a href="https://github.com/snipe/snipe-it/commits?author=vsposato" title="Code">💻</a></td>
    <td align="center"><a href="https://github.com/vjandrea"><img src="https://avatars0.githubusercontent.com/u/1639757?v=3?s=110" width="110px;" alt=""/><br /><sub><b>Andrea Bergamasco</b></sub></a><br /><a href="https://github.com/snipe/snipe-it/commits?author=vjandrea" title="Code">💻</a></td>
  </tr>
  <tr>
    <td align="center"><a href="https://github.com/kpawelski"><img src="https://avatars0.githubusercontent.com/u/10640152?v=3?s=110" width="110px;" alt=""/><br /><sub><b>Karol</b></sub></a><br /><a href="#translation-kpawelski" title="Translation">🌍</a> <a href="https://github.com/snipe/snipe-it/commits?author=kpawelski" title="Code">💻</a></td>
    <td align="center"><a href="http://blog.morph027.de/"><img src="https://avatars3.githubusercontent.com/u/600106?v=3?s=110" width="110px;" alt=""/><br /><sub><b>morph027</b></sub></a><br /><a href="https://github.com/snipe/snipe-it/commits?author=morph027" title="Code">💻</a></td>
    <td align="center"><a href="https://github.com/fvleminckx"><img src="https://avatars3.githubusercontent.com/u/22935755?v=3?s=110" width="110px;" alt=""/><br /><sub><b>fvleminckx</b></sub></a><br /><a href="#infra-fvleminckx" title="Infrastructure (Hosting, Build-Tools, etc)">🚇</a></td>
    <td align="center"><a href="https://github.com/itsupportcmsukorg"><img src="https://avatars2.githubusercontent.com/u/15633547?v=3?s=110" width="110px;" alt=""/><br /><sub><b>itsupportcmsukorg</b></sub></a><br /><a href="https://github.com/snipe/snipe-it/commits?author=itsupportcmsukorg" title="Code">💻</a> <a href="https://github.com/snipe/snipe-it/issues?q=author%3Aitsupportcmsukorg" title="Bug reports">🐛</a></td>
    <td align="center"><a href="https://override.io"><img src="https://avatars3.githubusercontent.com/u/12373799?v=3?s=110" width="110px;" alt=""/><br /><sub><b>Frank</b></sub></a><br /><a href="https://github.com/snipe/snipe-it/commits?author=base-zero" title="Code">💻</a></td>
    <td align="center"><a href="https://github.com/ghost"><img src="https://avatars0.githubusercontent.com/u/10137?v=3?s=110" width="110px;" alt=""/><br /><sub><b>Deleted user</b></sub></a><br /><a href="#translation-ghost" title="Translation">🌍</a></td>
    <td align="center"><a href="https://github.com/tiagom62"><img src="https://avatars1.githubusercontent.com/u/10802313?v=3?s=110" width="110px;" alt=""/><br /><sub><b>tiagom62</b></sub></a><br /><a href="https://github.com/snipe/snipe-it/commits?author=tiagom62" title="Code">💻</a> <a href="#infra-tiagom62" title="Infrastructure (Hosting, Build-Tools, etc)">🚇</a></td>
  </tr>
  <tr>
    <td align="center"><a href="https://github.com/rystaf"><img src="https://avatars3.githubusercontent.com/u/2389047?v=3?s=110" width="110px;" alt=""/><br /><sub><b>Ryan Stafford</b></sub></a><br /><a href="https://github.com/snipe/snipe-it/commits?author=rystaf" title="Code">💻</a></td>
    <td align="center"><a href="https://github.com/ehanlon"><img src="https://avatars2.githubusercontent.com/u/10345935?v=3?s=110" width="110px;" alt=""/><br /><sub><b>Eammon Hanlon</b></sub></a><br /><a href="https://github.com/snipe/snipe-it/commits?author=ehanlon" title="Code">💻</a></td>
    <td align="center"><a href="https://github.com/zjean"><img src="https://avatars0.githubusercontent.com/u/441924?v=3?s=110" width="110px;" alt=""/><br /><sub><b>zjean</b></sub></a><br /><a href="https://github.com/snipe/snipe-it/commits?author=zjean" title="Code">💻</a></td>
    <td align="center"><a href="http://www.frei.media"><img src="https://avatars0.githubusercontent.com/u/12660103?v=3?s=110" width="110px;" alt=""/><br /><sub><b>Matthias Frei</b></sub></a><br /><a href="https://github.com/snipe/snipe-it/commits?author=FREImedia" title="Code">💻</a></td>
    <td align="center"><a href="https://github.com/opsydev"><img src="https://avatars0.githubusercontent.com/u/3767518?v=3?s=110" width="110px;" alt=""/><br /><sub><b>opsydev</b></sub></a><br /><a href="https://github.com/snipe/snipe-it/commits?author=opsydev" title="Code">💻</a></td>
    <td align="center"><a href="http://www.ddreier.com"><img src="https://avatars1.githubusercontent.com/u/82290?v=3?s=110" width="110px;" alt=""/><br /><sub><b>Daniel Dreier</b></sub></a><br /><a href="https://github.com/snipe/snipe-it/commits?author=ddreier" title="Code">💻</a></td>
    <td align="center"><a href="http://rassie.org"><img src="https://avatars0.githubusercontent.com/u/23448?v=3?s=110" width="110px;" alt=""/><br /><sub><b>Nikolai Prokoschenko</b></sub></a><br /><a href="https://github.com/snipe/snipe-it/commits?author=rassie" title="Code">💻</a></td>
  </tr>
  <tr>
    <td align="center"><a href="https://github.com/YetAnotherCodeMonkey"><img src="https://avatars0.githubusercontent.com/u/13452757?v=3?s=110" width="110px;" alt=""/><br /><sub><b>Drew</b></sub></a><br /><a href="https://github.com/snipe/snipe-it/commits?author=YetAnotherCodeMonkey" title="Code">💻</a></td>
    <td align="center"><a href="https://github.com/merid14"><img src="https://avatars0.githubusercontent.com/u/1342320?v=3?s=110" width="110px;" alt=""/><br /><sub><b>Walter</b></sub></a><br /><a href="https://github.com/snipe/snipe-it/commits?author=merid14" title="Code">💻</a></td>
    <td align="center"><a href="https://github.com/balous"><img src="https://avatars3.githubusercontent.com/u/11254614?v=3?s=110" width="110px;" alt=""/><br /><sub><b>Petr Baloun</b></sub></a><br /><a href="https://github.com/snipe/snipe-it/commits?author=balous" title="Code">💻</a></td>
    <td align="center"><a href="https://github.com/reidblomquist"><img src="https://avatars0.githubusercontent.com/u/6117660?v=3?s=110" width="110px;" alt=""/><br /><sub><b>reidblomquist</b></sub></a><br /><a href="https://github.com/snipe/snipe-it/commits?author=reidblomquist" title="Documentation">📖</a></td>
    <td align="center"><a href="https://github.com/mathieuk"><img src="https://avatars0.githubusercontent.com/u/539914?v=3?s=110" width="110px;" alt=""/><br /><sub><b>Mathieu Kooiman</b></sub></a><br /><a href="https://github.com/snipe/snipe-it/commits?author=mathieuk" title="Code">💻</a></td>
    <td align="center"><a href="https://github.com/csayre"><img src="https://avatars3.githubusercontent.com/u/6606421?v=3?s=110" width="110px;" alt=""/><br /><sub><b>csayre</b></sub></a><br /><a href="https://github.com/snipe/snipe-it/commits?author=csayre" title="Documentation">📖</a></td>
    <td align="center"><a href="https://github.com/adamdunson"><img src="https://avatars1.githubusercontent.com/u/768488?v=3?s=110" width="110px;" alt=""/><br /><sub><b>Adam Dunson</b></sub></a><br /><a href="https://github.com/snipe/snipe-it/commits?author=adamdunson" title="Code">💻</a></td>
  </tr>
  <tr>
    <td align="center"><a href="https://github.com/thehereward"><img src="https://avatars0.githubusercontent.com/u/5547470?v=3?s=110" width="110px;" alt=""/><br /><sub><b>Hereward</b></sub></a><br /><a href="https://github.com/snipe/snipe-it/commits?author=thehereward" title="Code">💻</a></td>
    <td align="center"><a href="https://github.com/swoopdk"><img src="https://avatars0.githubusercontent.com/u/5802977?v=3?s=110" width="110px;" alt=""/><br /><sub><b>swoopdk</b></sub></a><br /><a href="https://github.com/snipe/snipe-it/commits?author=swoopdk" title="Code">💻</a></td>
    <td align="center"><a href="https://linkedin.com/in/ahimta"><img src="https://avatars1.githubusercontent.com/u/3470403?v=3?s=110" width="110px;" alt=""/><br /><sub><b>Abdullah Alansari</b></sub></a><br /><a href="https://github.com/snipe/snipe-it/commits?author=Ahimta" title="Code">💻</a></td>
    <td align="center"><a href="https://github.com/MicaelRodrigues"><img src="https://avatars0.githubusercontent.com/u/796443?v=3?s=110" width="110px;" alt=""/><br /><sub><b>Micael Rodrigues</b></sub></a><br /><a href="https://github.com/snipe/snipe-it/commits?author=MicaelRodrigues" title="Code">💻</a></td>
    <td align="center"><a href="http://macadmincorner.com"><img src="https://avatars0.githubusercontent.com/u/614564?v=3?s=110" width="110px;" alt=""/><br /><sub><b>Patrick Gallagher</b></sub></a><br /><a href="https://github.com/snipe/snipe-it/commits?author=patgmac" title="Documentation">📖</a></td>
    <td align="center"><a href="https://github.com/Miliamber"><img src="https://avatars3.githubusercontent.com/u/7165922?v=3?s=110" width="110px;" alt=""/><br /><sub><b>Miliamber</b></sub></a><br /><a href="https://github.com/snipe/snipe-it/commits?author=Miliamber" title="Code">💻</a></td>
    <td align="center"><a href="https://github.com/hawk554"><img src="https://avatars3.githubusercontent.com/u/861766?v=3?s=110" width="110px;" alt=""/><br /><sub><b>hawk554</b></sub></a><br /><a href="https://github.com/snipe/snipe-it/commits?author=hawk554" title="Code">💻</a></td>
  </tr>
  <tr>
    <td align="center"><a href="http://jbirdkerr.net"><img src="https://avatars1.githubusercontent.com/u/1695622?v=3?s=110" width="110px;" alt=""/><br /><sub><b>Justin Kerr</b></sub></a><br /><a href="https://github.com/snipe/snipe-it/commits?author=jbirdkerr" title="Code">💻</a></td>
    <td align="center"><a href="http://www.irasnyder.com/devel/"><img src="https://avatars3.githubusercontent.com/u/11426176?v=3?s=110" width="110px;" alt=""/><br /><sub><b>Ira W. Snyder</b></sub></a><br /><a href="https://github.com/snipe/snipe-it/commits?author=irasnyd" title="Documentation">📖</a></td>
    <td align="center"><a href="https://github.com/aalaily"><img src="https://avatars2.githubusercontent.com/u/2475759?v=3?s=110" width="110px;" alt=""/><br /><sub><b>Aladin Alaily</b></sub></a><br /><a href="https://github.com/snipe/snipe-it/commits?author=aalaily" title="Code">💻</a></td>
    <td align="center"><a href="https://github.com/kobie-chasehansen"><img src="https://avatars0.githubusercontent.com/u/10247644?v=3?s=110" width="110px;" alt=""/><br /><sub><b>Chase Hansen</b></sub></a><br /><a href="https://github.com/snipe/snipe-it/commits?author=kobie-chasehansen" title="Code">💻</a> <a href="#question-kobie-chasehansen" title="Answering Questions">💬</a> <a href="https://github.com/snipe/snipe-it/issues?q=author%3Akobie-chasehansen" title="Bug reports">🐛</a></td>
    <td align="center"><a href="https://github.com/IDM-Helpdesk"><img src="https://avatars2.githubusercontent.com/u/13545400?v=3?s=110" width="110px;" alt=""/><br /><sub><b>IDM Helpdesk</b></sub></a><br /><a href="https://github.com/snipe/snipe-it/commits?author=IDM-Helpdesk" title="Code">💻</a></td>
    <td align="center"><a href="http://balticer.de"><img src="https://avatars2.githubusercontent.com/u/614439?v=3?s=110" width="110px;" alt=""/><br /><sub><b>Kai</b></sub></a><br /><a href="https://github.com/snipe/snipe-it/commits?author=balticer" title="Code">💻</a></td>
    <td align="center"><a href="http://www.michaeldaniels.me"><img src="https://avatars1.githubusercontent.com/u/8762511?v=3?s=110" width="110px;" alt=""/><br /><sub><b>Michael Daniels</b></sub></a><br /><a href="https://github.com/snipe/snipe-it/commits?author=mdaniels5757" title="Code">💻</a></td>
  </tr>
  <tr>
    <td align="center"><a href="http://tomcastleman.me"><img src="https://avatars3.githubusercontent.com/u/1532660?v=3?s=110" width="110px;" alt=""/><br /><sub><b>Tom Castleman</b></sub></a><br /><a href="https://github.com/snipe/snipe-it/commits?author=tomcastleman" title="Code">💻</a></td>
    <td align="center"><a href="https://github.com/DanielNemanic"><img src="https://avatars3.githubusercontent.com/u/10723243?v=3?s=110" width="110px;" alt=""/><br /><sub><b>Daniel Nemanic</b></sub></a><br /><a href="https://github.com/snipe/snipe-it/commits?author=DanielNemanic" title="Code">💻</a></td>
    <td align="center"><a href="https://github.com/southwolf"><img src="https://avatars0.githubusercontent.com/u/150648?v=3?s=110" width="110px;" alt=""/><br /><sub><b>SouthWolf</b></sub></a><br /><a href="https://github.com/snipe/snipe-it/commits?author=southwolf" title="Code">💻</a></td>
    <td align="center"><a href="https://github.com/ivarne"><img src="https://avatars2.githubusercontent.com/u/131616?v=3?s=110" width="110px;" alt=""/><br /><sub><b>Ivar Nesje</b></sub></a><br /><a href="https://github.com/snipe/snipe-it/commits?author=ivarne" title="Code">💻</a></td>
    <td align="center"><a href="http://www.j0k3r.net"><img src="https://avatars1.githubusercontent.com/u/62333?v=3?s=110" width="110px;" alt=""/><br /><sub><b>Jérémy Benoist</b></sub></a><br /><a href="https://github.com/snipe/snipe-it/commits?author=j0k3r" title="Documentation">📖</a></td>
    <td align="center"><a href="https://github.com/cleathley"><img src="https://avatars2.githubusercontent.com/u/724344?v=3?s=110" width="110px;" alt=""/><br /><sub><b>Chris Leathley</b></sub></a><br /><a href="#infra-cleathley" title="Infrastructure (Hosting, Build-Tools, etc)">🚇</a></td>
    <td align="center"><a href="https://github.com/splaer"><img src="https://avatars0.githubusercontent.com/u/972498?v=3?s=110" width="110px;" alt=""/><br /><sub><b>splaer</b></sub></a><br /><a href="https://github.com/snipe/snipe-it/issues?q=author%3Asplaer" title="Bug reports">🐛</a> <a href="https://github.com/snipe/snipe-it/commits?author=splaer" title="Code">💻</a></td>
  </tr>
  <tr>
    <td align="center"><a href="http://www.joeferguson.me"><img src="https://avatars1.githubusercontent.com/u/967362?v=3?s=110" width="110px;" alt=""/><br /><sub><b>Joe Ferguson</b></sub></a><br /><a href="https://github.com/snipe/snipe-it/commits?author=svpernova09" title="Code">💻</a></td>
    <td align="center"><a href="https://github.com/diwanicki"><img src="https://avatars3.githubusercontent.com/u/6108682?v=3?s=110" width="110px;" alt=""/><br /><sub><b>diwanicki</b></sub></a><br /><a href="https://github.com/snipe/snipe-it/commits?author=diwanicki" title="Code">💻</a> <a href="https://github.com/snipe/snipe-it/commits?author=diwanicki" title="Documentation">📖</a></td>
    <td align="center"><a href="https://github.com/pakkua80"><img src="https://avatars3.githubusercontent.com/u/2527115?v=3?s=110" width="110px;" alt=""/><br /><sub><b>Lee Thoong Ching</b></sub></a><br /><a href="https://github.com/snipe/snipe-it/commits?author=pakkua80" title="Documentation">📖</a> <a href="https://github.com/snipe/snipe-it/commits?author=pakkua80" title="Code">💻</a></td>
    <td align="center"><a href="http://shu.io"><img src="https://avatars1.githubusercontent.com/u/461491?v=3?s=110" width="110px;" alt=""/><br /><sub><b>Marek Šuppa</b></sub></a><br /><a href="https://github.com/snipe/snipe-it/commits?author=mrshu" title="Code">💻</a></td>
    <td align="center"><a href="https://github.com/mizar1616"><img src="https://avatars1.githubusercontent.com/u/8693762?v=3?s=110" width="110px;" alt=""/><br /><sub><b>Juan J. Martinez</b></sub></a><br /><a href="#translation-mizar1616" title="Translation">🌍</a></td>
    <td align="center"><a href="https://github.com/rrdial"><img src="https://avatars1.githubusercontent.com/u/1458388?v=3?s=110" width="110px;" alt=""/><br /><sub><b>R Ryan Dial</b></sub></a><br /><a href="#translation-rrdial" title="Translation">🌍</a></td>
    <td align="center"><a href="https://github.com/burlito"><img src="https://avatars2.githubusercontent.com/u/2871745?v=3?s=110" width="110px;" alt=""/><br /><sub><b>Andrej Manduch</b></sub></a><br /><a href="https://github.com/snipe/snipe-it/commits?author=burlito" title="Documentation">📖</a></td>
  </tr>
  <tr>
    <td align="center"><a href="http://www.cordeos.com"><img src="https://avatars0.githubusercontent.com/u/8341172?v=3?s=110" width="110px;" alt=""/><br /><sub><b>Jay Richards</b></sub></a><br /><a href="https://github.com/snipe/snipe-it/commits?author=technogenus" title="Code">💻</a></td>
    <td align="center"><a href="https://necurity.co.uk"><img src="https://avatars2.githubusercontent.com/u/7295127?v=3?s=110" width="110px;" alt=""/><br /><sub><b>Alexander Innes</b></sub></a><br /><a href="https://github.com/snipe/snipe-it/commits?author=leostat" title="Code">💻</a></td>
    <td align="center"><a href="https://buzzedword.codes"><img src="https://avatars2.githubusercontent.com/u/334485?v=3?s=110" width="110px;" alt=""/><br /><sub><b>Danny Garcia</b></sub></a><br /><a href="https://github.com/snipe/snipe-it/commits?author=buzzedword" title="Code">💻</a></td>
    <td align="center"><a href="https://github.com/archpoint"><img src="https://avatars2.githubusercontent.com/u/366855?v=3?s=110" width="110px;" alt=""/><br /><sub><b>archpoint</b></sub></a><br /><a href="https://github.com/snipe/snipe-it/commits?author=archpoint" title="Code">💻</a></td>
    <td align="center"><a href="http://www.jakemcgraw.com"><img src="https://avatars1.githubusercontent.com/u/67991?v=3?s=110" width="110px;" alt=""/><br /><sub><b>Jake McGraw</b></sub></a><br /><a href="https://github.com/snipe/snipe-it/commits?author=jakemcgraw" title="Code">💻</a></td>
    <td align="center"><a href="https://github.com/FleischKarussel"><img src="https://avatars1.githubusercontent.com/u/1714374?v=3?s=110" width="110px;" alt=""/><br /><sub><b>FleischKarussel</b></sub></a><br /><a href="https://github.com/snipe/snipe-it/commits?author=FleischKarussel" title="Documentation">📖</a></td>
    <td align="center"><a href="https://github.com/feeva"><img src="https://avatars3.githubusercontent.com/u/319644?v=3?s=110" width="110px;" alt=""/><br /><sub><b>Dylan Yi</b></sub></a><br /><a href="https://github.com/snipe/snipe-it/commits?author=feeva" title="Code">💻</a></td>
  </tr>
  <tr>
    <td align="center"><a href="http://FlashingCursor.com"><img src="https://avatars2.githubusercontent.com/u/857740?v=3?s=110" width="110px;" alt=""/><br /><sub><b>Gil Rutkowski</b></sub></a><br /><a href="https://github.com/snipe/snipe-it/commits?author=flashingcursor" title="Code">💻</a></td>
    <td align="center"><a href="http://www.desmondmorris.com"><img src="https://avatars3.githubusercontent.com/u/129360?v=3?s=110" width="110px;" alt=""/><br /><sub><b>Desmond Morris</b></sub></a><br /><a href="https://github.com/snipe/snipe-it/commits?author=desmondmorris" title="Code">💻</a></td>
    <td align="center"><a href="http://peelman.us"><img src="https://avatars2.githubusercontent.com/u/52936?v=3?s=110" width="110px;" alt=""/><br /><sub><b>Nick Peelman</b></sub></a><br /><a href="https://github.com/snipe/snipe-it/commits?author=peelman" title="Code">💻</a></td>
    <td align="center"><a href="https://abrahamvegh.com"><img src="https://avatars0.githubusercontent.com/u/53161?v=3?s=110" width="110px;" alt=""/><br /><sub><b>Abraham Vegh</b></sub></a><br /><a href="https://github.com/snipe/snipe-it/commits?author=abrahamvegh" title="Code">💻</a></td>
    <td align="center"><a href="https://github.com/rashivkp"><img src="https://avatars0.githubusercontent.com/u/2818680?v=3?s=110" width="110px;" alt=""/><br /><sub><b>Mohamed Rashid</b></sub></a><br /><a href="https://github.com/snipe/snipe-it/commits?author=rashivkp" title="Documentation">📖</a></td>
    <td align="center"><a href="http://hinchk.github.io"><img src="https://avatars3.githubusercontent.com/u/1509456?v=3?s=110" width="110px;" alt=""/><br /><sub><b>Kasey</b></sub></a><br /><a href="https://github.com/snipe/snipe-it/commits?author=HinchK" title="Code">💻</a></td>
    <td align="center"><a href="https://github.com/BrettFagerlund"><img src="https://avatars2.githubusercontent.com/u/10522541?v=3?s=110" width="110px;" alt=""/><br /><sub><b>Brett</b></sub></a><br /><a href="https://github.com/snipe/snipe-it/commits?author=BrettFagerlund" title="Tests">⚠️</a></td>
  </tr>
  <tr>
    <td align="center"><a href="http://jasonspriggs.com"><img src="https://avatars2.githubusercontent.com/u/16108587?v=3?s=110" width="110px;" alt=""/><br /><sub><b>Jason Spriggs</b></sub></a><br /><a href="https://github.com/snipe/snipe-it/commits?author=jasonspriggs" title="Code">💻</a></td>
    <td align="center"><a href="http://n8felton.wordpress.com"><img src="https://avatars2.githubusercontent.com/u/1134568?v=3?s=110" width="110px;" alt=""/><br /><sub><b>Nate Felton</b></sub></a><br /><a href="https://github.com/snipe/snipe-it/commits?author=n8felton" title="Code">💻</a></td>
    <td align="center"><a href="http://homepages.dcc.ufmg.br/~manassesferreira"><img src="https://avatars2.githubusercontent.com/u/14036694?v=3?s=110" width="110px;" alt=""/><br /><sub><b>Manasses Ferreira</b></sub></a><br /><a href="https://github.com/snipe/snipe-it/commits?author=manassesferreira" title="Code">💻</a></td>
    <td align="center"><a href="https://github.com/steveelwood"><img src="https://avatars0.githubusercontent.com/u/15913949?v=3?s=110" width="110px;" alt=""/><br /><sub><b>Steve</b></sub></a><br /><a href="https://github.com/snipe/snipe-it/commits?author=steveelwood" title="Tests">⚠️</a></td>
    <td align="center"><a href="http://twitter.com/matc"><img src="https://avatars1.githubusercontent.com/u/3361683?v=3?s=110" width="110px;" alt=""/><br /><sub><b>matc</b></sub></a><br /><a href="https://github.com/snipe/snipe-it/commits?author=matc" title="Tests">⚠️</a></td>
    <td align="center"><a href="http://www.davisracingteam.com"><img src="https://avatars3.githubusercontent.com/u/7405702?v=3?s=110" width="110px;" alt=""/><br /><sub><b>Cole R. Davis</b></sub></a><br /><a href="https://github.com/snipe/snipe-it/commits?author=VanillaNinjaD" title="Tests">⚠️</a></td>
    <td align="center"><a href="https://github.com/gibsonjoshua55"><img src="https://avatars2.githubusercontent.com/u/10167681?v=3?s=110" width="110px;" alt=""/><br /><sub><b>gibsonjoshua55</b></sub></a><br /><a href="https://github.com/snipe/snipe-it/commits?author=gibsonjoshua55" title="Code">💻</a></td>
  </tr>
  <tr>
    <td align="center"><a href="https://github.com/zwerch"><img src="https://avatars2.githubusercontent.com/u/2809241?v=4?s=110" width="110px;" alt=""/><br /><sub><b>Robin Temme</b></sub></a><br /><a href="https://github.com/snipe/snipe-it/commits?author=zwerch" title="Code">💻</a></td>
    <td align="center"><a href="https://github.com/imanghafoori1"><img src="https://avatars0.githubusercontent.com/u/6961695?v=4?s=110" width="110px;" alt=""/><br /><sub><b>Iman</b></sub></a><br /><a href="https://github.com/snipe/snipe-it/commits?author=imanghafoori1" title="Code">💻</a></td>
    <td align="center"><a href="https://github.com/richardhofman6"><img src="https://avatars1.githubusercontent.com/u/6551003?v=4?s=110" width="110px;" alt=""/><br /><sub><b>Richard Hofman</b></sub></a><br /><a href="https://github.com/snipe/snipe-it/commits?author=richardhofman6" title="Code">💻</a></td>
    <td align="center"><a href="https://github.com/gizzmojr"><img src="https://avatars0.githubusercontent.com/u/3697569?v=4?s=110" width="110px;" alt=""/><br /><sub><b>gizzmojr</b></sub></a><br /><a href="https://github.com/snipe/snipe-it/commits?author=gizzmojr" title="Code">💻</a></td>
    <td align="center"><a href="https://github.com/imjennyli"><img src="https://avatars3.githubusercontent.com/u/404729?v=4?s=110" width="110px;" alt=""/><br /><sub><b>Jenny Li</b></sub></a><br /><a href="https://github.com/snipe/snipe-it/commits?author=imjennyli" title="Documentation">📖</a></td>
    <td align="center"><a href="https://github.com/GeoffYoung"><img src="https://avatars0.githubusercontent.com/u/869227?v=4?s=110" width="110px;" alt=""/><br /><sub><b>Geoff Young</b></sub></a><br /><a href="https://github.com/snipe/snipe-it/commits?author=GeoffYoung" title="Code">💻</a></td>
    <td align="center"><a href="http://www.elliotblackburn.com"><img src="https://avatars3.githubusercontent.com/u/1068477?v=4?s=110" width="110px;" alt=""/><br /><sub><b>Elliot Blackburn</b></sub></a><br /><a href="https://github.com/snipe/snipe-it/commits?author=BlueHatbRit" title="Documentation">📖</a></td>
  </tr>
  <tr>
    <td align="center"><a href="http://andmemasin.eu"><img src="https://avatars1.githubusercontent.com/u/6357451?v=4?s=110" width="110px;" alt=""/><br /><sub><b>Tõnis Ormisson</b></sub></a><br /><a href="https://github.com/snipe/snipe-it/commits?author=TonisOrmisson" title="Code">💻</a></td>
    <td align="center"><a href="http://www.nicolai-essig.de"><img src="https://avatars0.githubusercontent.com/u/449411?v=4?s=110" width="110px;" alt=""/><br /><sub><b>Nicolai Essig</b></sub></a><br /><a href="https://github.com/snipe/snipe-it/commits?author=thakilla" title="Code">💻</a></td>
    <td align="center"><a href="https://github.com/techincolor"><img src="https://avatars1.githubusercontent.com/u/14809698?v=4?s=110" width="110px;" alt=""/><br /><sub><b>Danielle</b></sub></a><br /><a href="https://github.com/snipe/snipe-it/commits?author=techincolor" title="Documentation">📖</a></td>
    <td align="center"><a href="https://github.com/TheVakman"><img src="https://avatars1.githubusercontent.com/u/18545156?v=4?s=110" width="110px;" alt=""/><br /><sub><b>Lawrence</b></sub></a><br /><a href="https://github.com/snipe/snipe-it/commits?author=TheVakman" title="Tests">⚠️</a> <a href="https://github.com/snipe/snipe-it/issues?q=author%3ATheVakman" title="Bug reports">🐛</a></td>
    <td align="center"><a href="https://github.com/uknzaeinozpas"><img src="https://avatars1.githubusercontent.com/u/22473767?v=4?s=110" width="110px;" alt=""/><br /><sub><b>uknzaeinozpas</b></sub></a><br /><a href="https://github.com/snipe/snipe-it/commits?author=uknzaeinozpas" title="Tests">⚠️</a> <a href="https://github.com/snipe/snipe-it/commits?author=uknzaeinozpas" title="Code">💻</a></td>
    <td align="center"><a href="https://github.com/Gelob"><img src="https://avatars3.githubusercontent.com/u/422752?v=4?s=110" width="110px;" alt=""/><br /><sub><b>Ryan</b></sub></a><br /><a href="https://github.com/snipe/snipe-it/commits?author=Gelob" title="Documentation">📖</a></td>
    <td align="center"><a href="https://github.com/vcordes79"><img src="https://avatars1.githubusercontent.com/u/10672546?v=4?s=110" width="110px;" alt=""/><br /><sub><b>vcordes79</b></sub></a><br /><a href="https://github.com/snipe/snipe-it/commits?author=vcordes79" title="Code">💻</a></td>
  </tr>
  <tr>
    <td align="center"><a href="https://github.com/fordster78"><img src="https://avatars3.githubusercontent.com/u/27958330?v=4?s=110" width="110px;" alt=""/><br /><sub><b>fordster78</b></sub></a><br /><a href="https://github.com/snipe/snipe-it/commits?author=fordster78" title="Code">💻</a></td>
    <td align="center"><a href="https://github.com/CronKz"><img src="https://avatars0.githubusercontent.com/u/34064225?v=4?s=110" width="110px;" alt=""/><br /><sub><b>CronKz</b></sub></a><br /><a href="https://github.com/snipe/snipe-it/commits?author=CronKz" title="Code">💻</a> <a href="#translation-CronKz" title="Translation">🌍</a></td>
    <td align="center"><a href="https://github.com/tdb"><img src="https://avatars1.githubusercontent.com/u/585486?v=4?s=110" width="110px;" alt=""/><br /><sub><b>Tim Bishop</b></sub></a><br /><a href="https://github.com/snipe/snipe-it/commits?author=tdb" title="Code">💻</a></td>
    <td align="center"><a href="https://www.seanmcilvenna.com"><img src="https://avatars2.githubusercontent.com/u/5384694?v=4?s=110" width="110px;" alt=""/><br /><sub><b>Sean McIlvenna</b></sub></a><br /><a href="https://github.com/snipe/snipe-it/commits?author=seanmcilvenna" title="Code">💻</a></td>
    <td align="center"><a href="https://github.com/cepacs"><img src="https://avatars3.githubusercontent.com/u/36515590?v=4?s=110" width="110px;" alt=""/><br /><sub><b>cepacs</b></sub></a><br /><a href="https://github.com/snipe/snipe-it/issues?q=author%3Acepacs" title="Bug reports">🐛</a> <a href="https://github.com/snipe/snipe-it/commits?author=cepacs" title="Documentation">📖</a></td>
    <td align="center"><a href="https://github.com/lea-mink"><img src="https://avatars2.githubusercontent.com/u/37537300?v=4?s=110" width="110px;" alt=""/><br /><sub><b>lea-mink</b></sub></a><br /><a href="https://github.com/snipe/snipe-it/commits?author=lea-mink" title="Code">💻</a></td>
    <td align="center"><a href="https://github.com/hannahtinkler"><img src="https://avatars0.githubusercontent.com/u/7140719?v=4?s=110" width="110px;" alt=""/><br /><sub><b>Hannah Tinkler</b></sub></a><br /><a href="https://github.com/snipe/snipe-it/commits?author=hannahtinkler" title="Code">💻</a></td>
  </tr>
  <tr>
    <td align="center"><a href="https://github.com/doekman"><img src="https://avatars1.githubusercontent.com/u/1086388?v=4?s=110" width="110px;" alt=""/><br /><sub><b>Doeke Zanstra</b></sub></a><br /><a href="https://github.com/snipe/snipe-it/commits?author=doekman" title="Code">💻</a></td>
    <td align="center"><a href="https://www.sdhd.nl/"><img src="https://avatars1.githubusercontent.com/u/4325936?v=4?s=110" width="110px;" alt=""/><br /><sub><b>Djamon Staal</b></sub></a><br /><a href="https://github.com/snipe/snipe-it/commits?author=SjamonDaal" title="Code">💻</a></td>
    <td align="center"><a href="https://github.com/EarlRamirez"><img src="https://avatars3.githubusercontent.com/u/12306859?v=4?s=110" width="110px;" alt=""/><br /><sub><b>Earl Ramirez</b></sub></a><br /><a href="https://github.com/snipe/snipe-it/commits?author=EarlRamirez" title="Code">💻</a></td>
    <td align="center"><a href="https://github.com/RichardRay"><img src="https://avatars2.githubusercontent.com/u/8671456?v=4?s=110" width="110px;" alt=""/><br /><sub><b>Richard Ray Thomas</b></sub></a><br /><a href="https://github.com/snipe/snipe-it/commits?author=RichardRay" title="Code">💻</a></td>
    <td align="center"><a href="https://www.taisun.io/"><img src="https://avatars3.githubusercontent.com/u/1852688?v=4?s=110" width="110px;" alt=""/><br /><sub><b>Ryan Kuba</b></sub></a><br /><a href="https://github.com/snipe/snipe-it/commits?author=thelamer" title="Code">💻</a></td>
    <td align="center"><a href="https://github.com/ParadoxGuitarist"><img src="https://avatars1.githubusercontent.com/u/6751928?v=4?s=110" width="110px;" alt=""/><br /><sub><b>Brian Monroe</b></sub></a><br /><a href="https://github.com/snipe/snipe-it/commits?author=ParadoxGuitarist" title="Code">💻</a></td>
    <td align="center"><a href="https://github.com/plexorama"><img src="https://avatars1.githubusercontent.com/u/605167?v=4?s=110" width="110px;" alt=""/><br /><sub><b>plexorama</b></sub></a><br /><a href="https://github.com/snipe/snipe-it/commits?author=plexorama" title="Code">💻</a></td>
  </tr>
  <tr>
    <td align="center"><a href="https://tilldeeke.de"><img src="https://avatars2.githubusercontent.com/u/1795149?v=4?s=110" width="110px;" alt=""/><br /><sub><b>Till Deeke</b></sub></a><br /><a href="https://github.com/snipe/snipe-it/commits?author=tilldeeke" title="Code">💻</a></td>
    <td align="center"><a href="https://github.com/5quirrel"><img src="https://avatars0.githubusercontent.com/u/12634129?v=4?s=110" width="110px;" alt=""/><br /><sub><b>5quirrel</b></sub></a><br /><a href="https://github.com/snipe/snipe-it/commits?author=5quirrel" title="Code">💻</a></td>
    <td align="center"><a href="https://github.com/jasonlshelton"><img src="https://avatars1.githubusercontent.com/u/13071957?v=4?s=110" width="110px;" alt=""/><br /><sub><b>Jason</b></sub></a><br /><a href="https://github.com/snipe/snipe-it/commits?author=jasonlshelton" title="Code">💻</a></td>
    <td align="center"><a href="https://github.com/chemfy"><img src="https://avatars3.githubusercontent.com/u/7128321?v=4?s=110" width="110px;" alt=""/><br /><sub><b>Antti</b></sub></a><br /><a href="https://github.com/snipe/snipe-it/commits?author=chemfy" title="Code">💻</a></td>
    <td align="center"><a href="https://github.com/DeusMaximus"><img src="https://avatars3.githubusercontent.com/u/10080364?v=4?s=110" width="110px;" alt=""/><br /><sub><b>DeusMaximus</b></sub></a><br /><a href="https://github.com/snipe/snipe-it/commits?author=DeusMaximus" title="Code">💻</a></td>
    <td align="center"><a href="https://github.com/A-ROYAL"><img src="https://avatars2.githubusercontent.com/u/16384611?v=4?s=110" width="110px;" alt=""/><br /><sub><b>a-royal</b></sub></a><br /><a href="#translation-A-ROYAL" title="Translation">🌍</a></td>
    <td align="center"><a href="https://github.com/albertoaldrigo"><img src="https://avatars0.githubusercontent.com/u/5358208?v=4?s=110" width="110px;" alt=""/><br /><sub><b>Alberto Aldrigo</b></sub></a><br /><a href="#translation-albertoaldrigo" title="Translation">🌍</a></td>
  </tr>
  <tr>
    <td align="center"><a href="http://alex.stanev.org/blog"><img src="https://avatars0.githubusercontent.com/u/1412342?v=4?s=110" width="110px;" alt=""/><br /><sub><b>Alex Stanev</b></sub></a><br /><a href="#translation-RealEnder" title="Translation">🌍</a></td>
    <td align="center"><a href="http://devel.itsolution2.de"><img src="https://avatars0.githubusercontent.com/u/177295?v=4?s=110" width="110px;" alt=""/><br /><sub><b>Andreas Rehm</b></sub></a><br /><a href="#translation-sirrus" title="Translation">🌍</a></td>
    <td align="center"><a href="https://github.com/xelan"><img src="https://avatars0.githubusercontent.com/u/5080535?v=4?s=110" width="110px;" alt=""/><br /><sub><b>Andreas Erhard</b></sub></a><br /><a href="#translation-xelan" title="Translation">🌍</a></td>
    <td align="center"><a href="https://github.com/angeldeejay"><img src="https://avatars2.githubusercontent.com/u/142350?v=4?s=110" width="110px;" alt=""/><br /><sub><b>Andrés Vanegas Jiménez</b></sub></a><br /><a href="#translation-angeldeejay" title="Translation">🌍</a></td>
    <td align="center"><a href="https://github.com/aschiavon91"><img src="https://avatars0.githubusercontent.com/u/3910403?v=4?s=110" width="110px;" alt=""/><br /><sub><b>Antonio Schiavon</b></sub></a><br /><a href="#translation-aschiavon91" title="Translation">🌍</a></td>
    <td align="center"><a href="https://github.com/benunter"><img src="https://avatars0.githubusercontent.com/u/10464547?v=4?s=110" width="110px;" alt=""/><br /><sub><b>benunter</b></sub></a><br /><a href="#translation-benunter" title="Translation">🌍</a></td>
    <td align="center"><a href="http://catweb24.pl"><img src="https://avatars1.githubusercontent.com/u/5038647?v=4?s=110" width="110px;" alt=""/><br /><sub><b>Borys Żmuda</b></sub></a><br /><a href="#translation-rudashi" title="Translation">🌍</a></td>
  </tr>
  <tr>
    <td align="center"><a href="https://github.com/chibacityblues"><img src="https://avatars0.githubusercontent.com/u/5539359?v=4?s=110" width="110px;" alt=""/><br /><sub><b>chibacityblues</b></sub></a><br /><a href="#translation-chibacityblues" title="Translation">🌍</a></td>
    <td align="center"><a href="https://github.com/cwlin0416"><img src="https://avatars1.githubusercontent.com/u/1954830?v=4?s=110" width="110px;" alt=""/><br /><sub><b>Chien Wei Lin</b></sub></a><br /><a href="#translation-cwlin0416" title="Translation">🌍</a></td>
    <td align="center"><a href="https://github.com/Againstreality"><img src="https://avatars3.githubusercontent.com/u/11700533?v=4?s=110" width="110px;" alt=""/><br /><sub><b>Christian Schuster</b></sub></a><br /><a href="#translation-Againstreality" title="Translation">🌍</a></td>
    <td align="center"><a href="http://chriss.webhostid.com"><img src="https://avatars1.githubusercontent.com/u/4308704?v=4?s=110" width="110px;" alt=""/><br /><sub><b>Christian Stefanus</b></sub></a><br /><a href="#translation-kopi-item" title="Translation">🌍</a></td>
    <td align="center"><a href="http://wxcafe.net"><img src="https://avatars3.githubusercontent.com/u/3009327?v=4?s=110" width="110px;" alt=""/><br /><sub><b>wxcafé</b></sub></a><br /><a href="#translation-wxcafe" title="Translation">🌍</a></td>
    <td align="center"><a href="https://github.com/dpyroc"><img src="https://avatars3.githubusercontent.com/u/35761525?v=4?s=110" width="110px;" alt=""/><br /><sub><b>dpyroc</b></sub></a><br /><a href="#translation-dpyroc" title="Translation">🌍</a></td>
    <td align="center"><a href="http://www.friedlmaier.net"><img src="https://avatars1.githubusercontent.com/u/2153639?v=4?s=110" width="110px;" alt=""/><br /><sub><b>Daniel Friedlmaier</b></sub></a><br /><a href="#translation-da-friedl" title="Translation">🌍</a></td>
  </tr>
  <tr>
    <td align="center"><a href="https://github.com/danielheene"><img src="https://avatars1.githubusercontent.com/u/2947640?v=4?s=110" width="110px;" alt=""/><br /><sub><b>Daniel Heene</b></sub></a><br /><a href="#translation-danielheene" title="Translation">🌍</a></td>
    <td align="center"><a href="https://github.com/danielcb"><img src="https://avatars3.githubusercontent.com/u/319022?v=4?s=110" width="110px;" alt=""/><br /><sub><b>danielcb</b></sub></a><br /><a href="#translation-danielcb" title="Translation">🌍</a></td>
    <td align="center"><a href="https://github.com/dominiksenti"><img src="https://avatars3.githubusercontent.com/u/15846537?v=4?s=110" width="110px;" alt=""/><br /><sub><b>Dominik Senti</b></sub></a><br /><a href="#translation-dominiksenti" title="Translation">🌍</a></td>
    <td align="center"><a href="http://www.konectik.com"><img src="https://avatars0.githubusercontent.com/u/25570954?v=4?s=110" width="110px;" alt=""/><br /><sub><b>Eric Gautheron</b></sub></a><br /><a href="#translation-EpixFr" title="Translation">🌍</a></td>
    <td align="center"><a href="https://erlpil.com"><img src="https://avatars1.githubusercontent.com/u/5732623?v=4?s=110" width="110px;" alt=""/><br /><sub><b>Erlend Pilø</b></sub></a><br /><a href="#translation-Erlpil" title="Translation">🌍</a></td>
    <td align="center"><a href="http://fabio.technology"><img src="https://avatars0.githubusercontent.com/u/541832?v=4?s=110" width="110px;" alt=""/><br /><sub><b>Fabio Rapposelli</b></sub></a><br /><a href="#translation-frapposelli" title="Translation">🌍</a></td>
    <td align="center"><a href="https://github.com/fgbs"><img src="https://avatars2.githubusercontent.com/u/3605240?v=4?s=110" width="110px;" alt=""/><br /><sub><b>Felipe Barros</b></sub></a><br /><a href="#translation-fgbs" title="Translation">🌍</a></td>
  </tr>
  <tr>
    <td align="center"><a href="https://github.com/possebon"><img src="https://avatars0.githubusercontent.com/u/257745?v=4?s=110" width="110px;" alt=""/><br /><sub><b>Fernando Possebon</b></sub></a><br /><a href="#translation-possebon" title="Translation">🌍</a></td>
    <td align="center"><a href="https://github.com/gdraque"><img src="https://avatars3.githubusercontent.com/u/2540832?v=4?s=110" width="110px;" alt=""/><br /><sub><b>gdraque</b></sub></a><br /><a href="#translation-gdraque" title="Translation">🌍</a></td>
    <td align="center"><a href="https://github.com/georgwallisch"><img src="https://avatars0.githubusercontent.com/u/23440381?v=4?s=110" width="110px;" alt=""/><br /><sub><b>Georg Wallisch</b></sub></a><br /><a href="#translation-georgwallisch" title="Translation">🌍</a></td>
    <td align="center"><a href="https://github.com/jgroblesr85"><img src="https://avatars1.githubusercontent.com/u/9852832?v=4?s=110" width="110px;" alt=""/><br /><sub><b>Gerardo Robles</b></sub></a><br /><a href="#translation-jgroblesr85" title="Translation">🌍</a></td>
    <td align="center"><a href="https://t.me/Gluek"><img src="https://avatars2.githubusercontent.com/u/11082640?v=4?s=110" width="110px;" alt=""/><br /><sub><b>Gluek</b></sub></a><br /><a href="#translation-mrgluek" title="Translation">🌍</a></td>
    <td align="center"><a href="https://github.com/AdnanAbuShahad"><img src="https://avatars0.githubusercontent.com/u/6847946?v=4?s=110" width="110px;" alt=""/><br /><sub><b>AdnanAbuShahad</b></sub></a><br /><a href="#translation-AdnanAbuShahad" title="Translation">🌍</a></td>
    <td align="center"><a href="https://hafidzi.my"><img src="https://avatars1.githubusercontent.com/u/3580608?v=4?s=110" width="110px;" alt=""/><br /><sub><b>Hafidzi My</b></sub></a><br /><a href="#translation-hafidzi" title="Translation">🌍</a></td>
  </tr>
  <tr>
    <td align="center"><a href="https://github.com/fofwisdom"><img src="https://avatars2.githubusercontent.com/u/205521?v=4?s=110" width="110px;" alt=""/><br /><sub><b>Harim Park</b></sub></a><br /><a href="#translation-fofwisdom" title="Translation">🌍</a></td>
    <td align="center"><a href="http://www.kentsson.se"><img src="https://avatars2.githubusercontent.com/u/3333841?v=4?s=110" width="110px;" alt=""/><br /><sub><b>Henrik Kentsson</b></sub></a><br /><a href="#translation-Kentsson" title="Translation">🌍</a></td>
    <td align="center"><a href="https://github.com/husnulyaqien"><img src="https://avatars0.githubusercontent.com/u/36551034?v=4?s=110" width="110px;" alt=""/><br /><sub><b>Husnul Yaqien</b></sub></a><br /><a href="#translation-husnulyaqien" title="Translation">🌍</a></td>
    <td align="center"><a href="http://abaalkhail.org"><img src="https://avatars1.githubusercontent.com/u/2372747?v=4?s=110" width="110px;" alt=""/><br /><sub><b>Ibrahim</b></sub></a><br /><a href="#translation-abaalkh" title="Translation">🌍</a></td>
    <td align="center"><a href="https://github.com/igolman"><img src="https://avatars0.githubusercontent.com/u/1389334?v=4?s=110" width="110px;" alt=""/><br /><sub><b>igolman</b></sub></a><br /><a href="#translation-igolman" title="Translation">🌍</a></td>
    <td align="center"><a href="https://github.com/itangiang"><img src="https://avatars1.githubusercontent.com/u/3257070?v=4?s=110" width="110px;" alt=""/><br /><sub><b>itangiang</b></sub></a><br /><a href="#translation-itangiang" title="Translation">🌍</a></td>
    <td align="center"><a href="https://github.com/jarby1211"><img src="https://avatars2.githubusercontent.com/u/14814254?v=4?s=110" width="110px;" alt=""/><br /><sub><b>jarby1211</b></sub></a><br /><a href="#translation-jarby1211" title="Translation">🌍</a></td>
  </tr>
  <tr>
    <td align="center"><a href="http://jwillker.com"><img src="https://avatars3.githubusercontent.com/u/6719357?v=4?s=110" width="110px;" alt=""/><br /><sub><b>Jhonn Willker</b></sub></a><br /><a href="#translation-JohnWillker" title="Translation">🌍</a></td>
    <td align="center"><a href="https://github.com/joxelito94"><img src="https://avatars2.githubusercontent.com/u/10983635?v=4?s=110" width="110px;" alt=""/><br /><sub><b>Jose</b></sub></a><br /><a href="#translation-joxelito94" title="Translation">🌍</a></td>
    <td align="center"><a href="https://github.com/laopangzi"><img src="https://avatars0.githubusercontent.com/u/5206122?v=4?s=110" width="110px;" alt=""/><br /><sub><b>laopangzi</b></sub></a><br /><a href="#translation-laopangzi" title="Translation">🌍</a></td>
    <td align="center"><a href="http://usrportage.de"><img src="https://avatars2.githubusercontent.com/u/79707?v=4?s=110" width="110px;" alt=""/><br /><sub><b>Lars Strojny</b></sub></a><br /><a href="#translation-lstrojny" title="Translation">🌍</a></td>
    <td align="center"><a href="http://twitter.com/marcosbl"><img src="https://avatars0.githubusercontent.com/u/389801?v=4?s=110" width="110px;" alt=""/><br /><sub><b>MarcosBL</b></sub></a><br /><a href="#translation-MarcosBL" title="Translation">🌍</a></td>
    <td align="center"><a href="https://github.com/mariejoyacajes"><img src="https://avatars3.githubusercontent.com/u/35664606?v=4?s=110" width="110px;" alt=""/><br /><sub><b>marie joy cajes</b></sub></a><br /><a href="#translation-mariejoyacajes" title="Translation">🌍</a></td>
    <td align="center"><a href="http://www.markjohansen.dk"><img src="https://avatars2.githubusercontent.com/u/3052816?v=4?s=110" width="110px;" alt=""/><br /><sub><b>Mark S. Johansen</b></sub></a><br /><a href="#translation-msjohansen" title="Translation">🌍</a></td>
  </tr>
  <tr>
    <td align="center"><a href="http://martinstub.dk"><img src="https://avatars2.githubusercontent.com/u/982885?v=4?s=110" width="110px;" alt=""/><br /><sub><b>Martin Stub</b></sub></a><br /><a href="#translation-stubben" title="Translation">🌍</a></td>
    <td align="center"><a href="https://github.com/meyerf99"><img src="https://avatars2.githubusercontent.com/u/28959963?v=4?s=110" width="110px;" alt=""/><br /><sub><b>Meyer Flavio</b></sub></a><br /><a href="#translation-meyerf99" title="Translation">🌍</a></td>
    <td align="center"><a href="https://github.com/MicaelRodrigues"><img src="https://avatars3.githubusercontent.com/u/796443?v=4?s=110" width="110px;" alt=""/><br /><sub><b>Micael Rodrigues</b></sub></a><br /><a href="#translation-MicaelRodrigues" title="Translation">🌍</a></td>
    <td align="center"><a href="http://rubixy.com/"><img src="https://avatars0.githubusercontent.com/u/10481331?v=4?s=110" width="110px;" alt=""/><br /><sub><b>Mikael Rasmussen</b></sub></a><br /><a href="#translation-mikaelssen" title="Translation">🌍</a></td>
    <td align="center"><a href="https://github.com/IxFail"><img src="https://avatars1.githubusercontent.com/u/1544552?v=4?s=110" width="110px;" alt=""/><br /><sub><b>IxFail</b></sub></a><br /><a href="#translation-IxFail" title="Translation">🌍</a></td>
    <td align="center"><a href="http://www.mohammedfota.com"><img src="https://avatars3.githubusercontent.com/u/18483118?v=4?s=110" width="110px;" alt=""/><br /><sub><b>Mohammed Fota</b></sub></a><br /><a href="#translation-MohammedFota" title="Translation">🌍</a></td>
    <td align="center"><a href="https://github.com/omego"><img src="https://avatars0.githubusercontent.com/u/227080?v=4?s=110" width="110px;" alt=""/><br /><sub><b>Moayad Alserihi</b></sub></a><br /><a href="#translation-omego" title="Translation">🌍</a></td>
  </tr>
  <tr>
    <td align="center"><a href="https://github.com/saymd"><img src="https://avatars0.githubusercontent.com/u/1680266?v=4?s=110" width="110px;" alt=""/><br /><sub><b>saymd</b></sub></a><br /><a href="#translation-saymd" title="Translation">🌍</a></td>
    <td align="center"><a href="https://nordsken.se"><img src="https://avatars0.githubusercontent.com/u/1826808?v=4?s=110" width="110px;" alt=""/><br /><sub><b>Patrik Larsson</b></sub></a><br /><a href="#translation-pooot" title="Translation">🌍</a></td>
    <td align="center"><a href="https://github.com/drcryo"><img src="https://avatars1.githubusercontent.com/u/20584746?v=4?s=110" width="110px;" alt=""/><br /><sub><b>drcryo</b></sub></a><br /><a href="#translation-drcryo" title="Translation">🌍</a></td>
    <td align="center"><a href="https://github.com/pawel1615"><img src="https://avatars1.githubusercontent.com/u/19408004?v=4?s=110" width="110px;" alt=""/><br /><sub><b>pawel1615</b></sub></a><br /><a href="#translation-pawel1615" title="Translation">🌍</a></td>
    <td align="center"><a href="https://github.com/bodrovics"><img src="https://avatars2.githubusercontent.com/u/23340468?v=4?s=110" width="110px;" alt=""/><br /><sub><b>bodrovics</b></sub></a><br /><a href="#translation-bodrovics" title="Translation">🌍</a></td>
    <td align="center"><a href="https://github.com/priatna"><img src="https://avatars0.githubusercontent.com/u/3257654?v=4?s=110" width="110px;" alt=""/><br /><sub><b>priatna</b></sub></a><br /><a href="#translation-priatna" title="Translation">🌍</a></td>
    <td align="center"><a href="https://amayume.net"><img src="https://avatars1.githubusercontent.com/u/5358374?v=4?s=110" width="110px;" alt=""/><br /><sub><b>Fan Jiang</b></sub></a><br /><a href="#translation-ProfFan" title="Translation">🌍</a></td>
  </tr>
  <tr>
    <td align="center"><a href="https://github.com/ragnarcx"><img src="https://avatars1.githubusercontent.com/u/22555451?v=4?s=110" width="110px;" alt=""/><br /><sub><b>ragnarcx</b></sub></a><br /><a href="#translation-ragnarcx" title="Translation">🌍</a></td>
    <td align="center"><a href="http://www.reinvanhaaren.nl/"><img src="https://avatars2.githubusercontent.com/u/18654582?v=4?s=110" width="110px;" alt=""/><br /><sub><b>Rein van Haaren</b></sub></a><br /><a href="#translation-reinvanhaaren" title="Translation">🌍</a></td>
    <td align="center"><a href="http://dheche.songolimo.net"><img src="https://avatars1.githubusercontent.com/u/386672?v=4?s=110" width="110px;" alt=""/><br /><sub><b>Teguh Dwicaksana</b></sub></a><br /><a href="#translation-dheche" title="Translation">🌍</a></td>
    <td align="center"><a href="https://github.com/FRaccie"><img src="https://avatars2.githubusercontent.com/u/2572552?v=4?s=110" width="110px;" alt=""/><br /><sub><b>fraccie</b></sub></a><br /><a href="#translation-FRaccie" title="Translation">🌍</a></td>
    <td align="center"><a href="https://github.com/vinzruzell"><img src="https://avatars0.githubusercontent.com/u/35182720?v=4?s=110" width="110px;" alt=""/><br /><sub><b>vinzruzell</b></sub></a><br /><a href="#translation-vinzruzell" title="Translation">🌍</a></td>
    <td align="center"><a href="http://kevinaustin.com"><img src="https://avatars1.githubusercontent.com/u/7883603?v=4?s=110" width="110px;" alt=""/><br /><sub><b>Kevin Austin</b></sub></a><br /><a href="#translation-vipsystem" title="Translation">🌍</a></td>
    <td align="center"><a href="http://azuraweb.xyz"><img src="https://avatars3.githubusercontent.com/u/3861828?v=4?s=110" width="110px;" alt=""/><br /><sub><b>Wira Sandy</b></sub></a><br /><a href="#translation-wira-sandy" title="Translation">🌍</a></td>
  </tr>
  <tr>
    <td align="center"><a href="https://github.com/GrayHoax"><img src="https://avatars2.githubusercontent.com/u/8663789?v=4?s=110" width="110px;" alt=""/><br /><sub><b>Илья</b></sub></a><br /><a href="#translation-GrayHoax" title="Translation">🌍</a></td>
    <td align="center"><a href="https://github.com/godusevpn"><img src="https://avatars3.githubusercontent.com/u/30119111?v=4?s=110" width="110px;" alt=""/><br /><sub><b>GodUseVPN</b></sub></a><br /><a href="#translation-godusevpn" title="Translation">🌍</a></td>
    <td align="center"><a href="https://github.com/EngrZhou"><img src="https://avatars1.githubusercontent.com/u/745576?v=4?s=110" width="110px;" alt=""/><br /><sub><b>周周</b></sub></a><br /><a href="#translation-EngrZhou" title="Translation">🌍</a></td>
    <td align="center"><a href="https://github.com/takuy"><img src="https://avatars3.githubusercontent.com/u/1631095?v=4?s=110" width="110px;" alt=""/><br /><sub><b>Sam</b></sub></a><br /><a href="https://github.com/snipe/snipe-it/commits?author=takuy" title="Code">💻</a></td>
    <td align="center"><a href="https://www.illisian.com.au"><img src="https://avatars1.githubusercontent.com/u/264022?v=4?s=110" width="110px;" alt=""/><br /><sub><b>Azerothian</b></sub></a><br /><a href="https://github.com/snipe/snipe-it/commits?author=Azerothian" title="Code">💻</a></td>
    <td align="center"><a href="https://github.com/timothyfarmer"><img src="https://avatars1.githubusercontent.com/u/7632599?v=4?s=110" width="110px;" alt=""/><br /><sub><b>Tim Farmer</b></sub></a><br /><a href="https://github.com/snipe/snipe-it/commits?author=timothyfarmer" title="Code">💻</a></td>
    <td align="center"><a href="https://github.com/mskrip"><img src="https://avatars0.githubusercontent.com/u/17459600?v=4?s=110" width="110px;" alt=""/><br /><sub><b>Marián Skrip</b></sub></a><br /><a href="https://github.com/snipe/snipe-it/commits?author=mskrip" title="Code">💻</a></td>
  </tr>
  <tr>
    <td align="center"><a href="https://github.com/Godmartinz"><img src="https://avatars2.githubusercontent.com/u/47435081?v=4?s=110" width="110px;" alt=""/><br /><sub><b>Godfrey Martinez</b></sub></a><br /><a href="https://github.com/snipe/snipe-it/commits?author=Godmartinz" title="Code">💻</a></td>
    <td align="center"><a href="https://github.com/bigtreeEdo"><img src="https://avatars1.githubusercontent.com/u/2075128?v=4?s=110" width="110px;" alt=""/><br /><sub><b>bigtreeEdo</b></sub></a><br /><a href="https://github.com/snipe/snipe-it/commits?author=bigtreeEdo" title="Code">💻</a></td>
    <td align="center"><a href="https://colinmcneil.me/"><img src="https://avatars0.githubusercontent.com/u/5000430?v=4?s=110" width="110px;" alt=""/><br /><sub><b>Colin  McNeil</b></sub></a><br /><a href="https://github.com/snipe/snipe-it/commits?author=ColinMcNeil" title="Code">💻</a></td>
    <td align="center"><a href="https://github.com/JoKneeMo"><img src="https://avatars0.githubusercontent.com/u/421625?v=4?s=110" width="110px;" alt=""/><br /><sub><b>JoKneeMo</b></sub></a><br /><a href="https://github.com/snipe/snipe-it/commits?author=JoKneeMo" title="Code">💻</a></td>
    <td align="center"><a href="http://www.redbridge.se"><img src="https://avatars0.githubusercontent.com/u/54849013?v=4?s=110" width="110px;" alt=""/><br /><sub><b>Joshi</b></sub></a><br /><a href="https://github.com/snipe/snipe-it/commits?author=joshi-redbridge" title="Code">💻</a></td>
    <td align="center"><a href="https://github.com/anthonypburns"><img src="https://avatars2.githubusercontent.com/u/15731458?v=4?s=110" width="110px;" alt=""/><br /><sub><b>Anthony Burns</b></sub></a><br /><a href="https://github.com/snipe/snipe-it/commits?author=anthonypburns" title="Code">💻</a></td>
    <td align="center"><a href="http://phpprofi.ru/"><img src="https://avatars2.githubusercontent.com/u/1972329?v=4?s=110" width="110px;" alt=""/><br /><sub><b>Alexander Chibrikin</b></sub></a><br /><a href="https://github.com/snipe/snipe-it/commits?author=alek13" title="Code">💻</a></td>
  </tr>
  <tr>
    <td align="center"><a href="https://peter.upfold.org.uk/"><img src="https://avatars0.githubusercontent.com/u/1255375?v=4?s=110" width="110px;" alt=""/><br /><sub><b>Peter Upfold</b></sub></a><br /><a href="https://github.com/snipe/snipe-it/commits?author=PeterUpfold" title="Code">💻</a></td>
  </tr>
</table>

<!-- markdownlint-enable -->
<!-- prettier-ignore-end -->
<!-- ALL-CONTRIBUTORS-LIST:END -->

This project follows the [all-contributors](https://github.com/kentcdodds/all-contributors) specification. Contributions of any kind welcome!

-----

### Contributing

Please see the documentation on [contributing and developing for Snipe-IT](https://snipe-it.readme.io/docs/contributing-overview).


Please note that this project is released with a [Contributor Code of Conduct](CODE_OF_CONDUCT.md). By participating in this project you agree to abide by its terms.
