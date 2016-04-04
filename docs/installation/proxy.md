---
currentMenu: proxy
---

# Running Snipe-IT Through a Reverse Proxy

<div id="generated-toc" class="generate_from_h2"></div>

If you wish to use a Reverse Proxy in front of your web server, you'll need to take a few extra steps to make it work.

A typical Reverse Proxy scenario looks like this:

Internet <i class="fa fa-arrow-right"></i> Reverse Proxy Server (Public & Private IPs) <i class="fa fa-arrow-right"></i> Web Server (Private IPs)

The Reverse Proxy Server is functioning as a reverse proxy (Nginx, Squid, Apache's Mod_Proxy, or Varnish).

In most deployments the Reverse Proxy will perform HTTP to HTTPS redirection and only pass requests and responses via HTTPS to the remote client.

Scenario: <span style="color: red;">**BROKEN**</span>

Client  <i class="fa fa-arrow-left"></i> HTTPS <i class="fa fa-arrow-right"></i>  Reverse Proxy Server   <i class="fa fa-arrow-left"></i> HTTP <i class="fa fa-arrow-right"></i> Web Server

Scenario: <span style="color: green;">**WORKS**</span>

Client <i class="fa fa-arrow-left"></i> HTTP <i class="fa fa-arrow-right"></i>  Reverse Proxy Server   <i class="fa fa-arrow-left"></i> HTTP <i class="fa fa-arrow-right"></i> Web Server <br>
Client <i class="fa fa-arrow-left"></i> HTTPS <i class="fa fa-arrow-right"></i>  Reverse Proxy Server  <i class="fa fa-arrow-left"></i> HTTPS <i class="fa fa-arrow-right"></i> Web Server


## Explanation
In the above scenario the generated HTML will reference `http://` instead of `https://` for all assets. This causes most browsers to throw security warnings and refuse to display the content. (Typically, you'll see mixed content warnings because the browser won't load insecure elements on an SSL page.)

__This assumes that your Reverse Proxy Server and Web Server are correctly configured and working properly. Meaning you have other correctly functioning Applications behind the proxy and the Web Server for Snipe-IT works properly if accessed directly.__

Snipe-IT is unaware that requests to the proxy are being handled through HTTPS instead of HTTP. As such no effort is made to generate HTTPS links for Assets (javascript, CSS, images, etc.)

Snipe-IT needs to be made aware of the presence of the Reverse Proxy Server. The `X-Forwarded-Proto` header should be passed from the Reverse Proxy Server to the Web Server.

## Server Configuration
In Nginx, you would use:

```
proxy_set_header X-Forwarded-Proto $scheme;
```

With Apache's Mod_Proxy, you would add:

```
RequestHeader set X-Forwarded-Proto "https"
```

to your virtual host configuration.

## Snipe-IT Configurations

Copy the `app/config/packages/fideloper/proxy/config.example.php` to `app/config/packages/fideloper/proxy/config.php`, and change

```
'proxies' => '*'
```

to

```
'proxies' => array('YOUR.IP.GOES.HERE'),
```

replacing `YOUR.IP.GOES.HERE` with the IP address(es) of your Reverse Proxy. Note that IPs and CIDR Notation are accepted. **Do not leave this as the default asterisk as that is highly insecure.**

You may also want to see the [security notes](../security.html) for additional steps you can take for SSL configurations.
