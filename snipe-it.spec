%global php_min_ver 7.3.0

# Disable automatic requires/provides processing
AutoReqProv: no

Summary:		A free open source IT asset/license management system
Name:			snipe-it

%define   		ghowner   		Snipe

Version:		5.3.0
Release:		8%{?dist}
License:		AGPL-3.0
URL:    		https://snipeitapp.com/
Requires:		httpd
# IUS, EPEL, MariaDB repos
Requires:		mod_php > 7.1
Requires:		php-simplexml(x86-64)
Requires:		php-mysqlnd(x86-64)
Requires:		php-bcmath(x86-64)
Requires:		php-cli(x86-64)
Requires:		php-common(x86-64)
Requires:		php-embedded(x86-64)
Requires:		php-gd(x86-64)
Requires:		php-mbstring(x86-64)
#Requires:		php-mcrypt(x86-64)
Requires:		php-ldap(x86-64)
Requires:		php-json(x86-64)
Requires:		php-xml(x86-64)
Requires:		php-process(x86-64)

BuildArch:		noarch
BuildRequires: /usr/bin/composer
BuildRequires: php-bcmath
BuildRequires: php-ldap



%define			mungedurl		v%{version}
Source0: 		https://github.com/%{ghowner}/%{?URLbit}%{?!URLbit:%{name}}/archive/%{?mungedurl}.tar.gz
Source1:        site.conf

%description
Snipe-IT - Open Source Asset Management System
This is a FOSS project for asset management in IT Operations. Knowing who has which laptop, when it was purchased in order to depreciate it correctly, handling software licenses, etc.

It is built on Laravel 6.

Snipe-IT is actively developed and we release quite frequently. (Check out the live demo here.)

This is web-based software. This means there is no executable file (aka no .exe files), and it must be run on a web server and accessed through a web browser. It runs on any Mac OSX, flavor of Linux, as well as Windows, and we have a Docker image available if that's what you're into.


%prep
%autosetup 
#  composer maybe can't see what's on the OS right now, and so maybe can't use it,
#  and so will need some fixing before we can start to prune this absolute horrow
#  show of a vendor tree.
composer install --no-dev --working-dir .


%build
# nothing to build


%install
# Main
%{__mkdir_p} \
    %{buildroot}%{_datadir} \
    %{buildroot}%{_sysconfdir}/httpd/conf.d \

%{__cp} -a . %{buildroot}%{_datadir}/%{name}

%{__sed} '
s:_WEBROOT:%{_datadir}/%{name}:g
' \
  %{S:1} > \
  %{buildroot}%{_sysconfdir}/httpd/conf.d/site.conf

%{__chmod} -R go-w %{buildroot}%{_datadir}/%{name}
%{__chmod} -R 775 storage public/uploads

find %{buildroot} -type f |\
  sed \
    -e 's:%{buildroot}:.:' \
    -e 's:^\.:\%attr(-,-,-) :' \
    -e '\: %{_datadir}/%{name}/storage:s/-,-,-/664,snipeitapp,apache/' \
    -e '\: %{_datadir}/%{name}/public/uploads:s/-,-,-/664,snipeitapp,apache/' \
> %{_sourcedir}/list

find %{buildroot} -type d |\
  sed \
    -e 's:%{buildroot}:.:' \
    -e 's:^\.:\%attr(-,-,-) %dir :' \
    -e '\: %{_datadir}/%{name}/storage:s/-,-,-/2775,apache,snipeitapp/' \
    -e '\: %{_datadir}/%{name}/public/uploads:s/-,-,-/2775,apache,snipeitapp/' \
    -e '\: %{_datadir}/%{name}/bootstrap/cache:s/-,-,-/775,apache,snipeitapp/' \
>> %{_sourcedir}/list


%pre
egrep -q ^snipeitapp: /etc/passwd >/dev/null || \
  /usr/sbin/luseradd -u 65533 snipeitapp && \
  /usr/sbin/lgroupmod -M apache snipeitapp
: # protect the db


%postun
if [ $1 = 0 ]; then
  egrep -q ^snipeitapp: /etc/passwd > /dev/null && \
    luserdel -r snipeitapp
  egrep -q ^snipeitapp: /etc/group > /dev/null && \
    lgroupdel snipeitapp
fi
: # protect the db


%clean
%{__chmod} -R 777 $RPM_BUILD_ROOT
%{__rm} -rf $RPM_BUILD_ROOT


%files -f %{_sourcedir}/list
%defattr(-,root,root,-)
%license LICENSE
%doc *.md composer.json
%{_datadir}/%{name}/vendor/bin


%changelog
* Mon Nov 1 2021 Bishop <bishopolis@gmail.com> - 5.3.0-8
- ensure php-fpm is lit
- fix perms in bootstrap subdir for #reasons
- disable Options-Indexes in site.conf to recover system

* Fri Oct 29 2021 Bishop <bishopolis@gmail.com> - 5.3.0-7
- fix lusermod bits

* Thu Oct 28 2021 Bishop <bishopolis@gmail.com> - 5.3.0-5.2
- try a compromise for the file perms

* Wed Oct 27 2021 Bishop <bishopolis@gmail.com> - 5.3.0-5
- fix up ACLs for DocRoot in Site.conf

* Wed Oct 20 2021 Bishop <bishopolis@gmail.com> - 5.3.0-2
- new site.conf stanza for mod_ssl 

* Tue Oct 19 2021 Bishop <bishopolis@gmail.com> - 5.3.0-1
- patch XSS on all-file-types export - CVE-2021-3879

* Thu Oct 7 2021 Bishop <bishopolis@gmail.com> - 5.2.0-0.2
- remove mcrypt dep - https://github.com/snipe/snipe-it/issues/2694

* Mon Oct 4 2021 Bishop <bishopolis@gmail.com> - 5.2.0-0.1
- initial release
