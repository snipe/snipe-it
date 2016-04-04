---
currentMenu: security
---

# Some Notes on Security

Snipe-IT was built with security in mind. We utilize bcrypt to handle passwords, which is an adaptive hash function based on the Blowfish symmetric block cipher cryptographic algorithm. Additionally, the software is designed in such a way to prevent brute forcing the password, with IP addresses and usernames locked out for 10 minutes after a specified number of login attempts.

## Additional Security

Although this is web-based software and must run on a web server, you may want to consider whether you actually need it accessible to the outside world. Running it on an internal network with ports closed to the outside world, or on AWS using a security group that prevents access from outside a selected static IP range (like your company network IP), may be something to consider.

While most use cases won't be storing Personally Identifiable Information (PII), someone with the right motivation could gain useful knowledge about the number of employees, types of assets, etc you maintain. While this information in and of itself isn't harmful, it could be helpful to Bad Guys in a targeted attack, so you should consider whether you want to limit access to it via IP or network rules.

Also, running Snipe-IT over SSL is not required, but a good idea. (Running everything ever over SSL is a good idea at this point.)

There are some optional configuration options that you can enable if you run Snipe-IT over HTTPS, such as <a href="http://docs.snipeitapp.com/installation/configuration.html#optional-set-cookies-to-https-only">enabling HTTPS-only cookies</a>, and setting your <a href="http://docs.snipeitapp.com/installation/configuration.html#optional-set-your-htaccess-to-redirect-to-ssl">`.htaccess` to redirect to the HTTPS version</a>.
