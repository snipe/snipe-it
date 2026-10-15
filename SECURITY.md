# Security Policy

We take security issues very seriously, and will always attempt to address any vulnerabilities as quickly as possible.

## Supported Versions

We try to make a reasonable effort to support older versions of Snipe-IT, however there are times when library
dependencies and/or PHP/MySQL dependencies make it impossible to backport security fixes on older versions.

| Version | Supported          |
|---------|--------------------|
| 8.x     | :white_check_mark: |
| 7.x     | :x:                |
| 6.x     | :x:                |
| 5.1.x   | :x:                |
| 5.0.x   | :x:                |
| 4.0.x   | :x:                |
| < 4.0   | :x:                |

## Reporting a Vulnerability

__Security vulnerabilities should be reported [via a new GHSA](https://github.com/grokability/snipe-it/security) or via
email security@snipeitapp.com.__

If we find that your security report is valid but has been reported in a previous GHSA that is currently still in draft
mode (therefore currently invisible to you), we will add your Github username to the original GHSA so that you can be
credited for your discovery.

When creating a GHSA, please leave the "package" field blank. Snipe-IT is not a package, so we will just have to blank
that field out when reviewing your GHSA.

You can typically expect a response within five business days, and we typically have fixes out in under a week from the
initial disclosure.

This obviously varies based on the severity of the security issue and the difficulty in remediation, but those have
historically been the timelines we work around.

__We do ask that you do not disclose the vulnerability publicly until we have had a chance to address it and tag a
release__ so that we can protect our users, and we will work with you to coordinate a public disclosure once we have a
fix out.

If you alert us to the security issue via security@snipeitapp.com, please provide a GitHub username or other
information if you would like to be credited, or please let us know if you would like to remain anonymous.

For responsible disclosure, we ask that you give us at least __90 days__ to address the issue before disclosing it
publicly, but we will work with you if you need to disclose it sooner than that.

For a full breakdown of our security policies, please see https://snipeitapp.com/security.
