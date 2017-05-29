FROM alpine:3.4

MAINTAINER Eric Pfeiffer <computerfr33k@users.noreply.github.com>

ENV caddy_version=0.10.0

LABEL caddy_version="$caddy_version" architecture="amd64"

RUN apk update \
    && apk upgrade \
    && apk add tar curl git

RUN curl --silent --show-error --fail --location \
        --header "Accept: application/tar+gzip, application/x-gzip, application/octet-stream" -o - \
        "https://caddyserver.com/download/linux/amd64?plugins=http.cgi,http.cors,http.expires,http.filemanager,http.git,http.ipfilter,http.realip,tls.dns.cloudflare,tls.dns.digitalocean,tls.dns.dnspod,tls.dns.dyn,tls.dns.googlecloud,tls.dns.linode,tls.dns.namecheap,tls.dns.ovh,tls.dns.route53,tls.dns.vultr" \
        | tar --no-same-owner -C /usr/bin/ -xz caddy \
    && mv /usr/bin/caddy /usr/bin/caddy \
    && chmod 0755 /usr/bin/caddy

EXPOSE 80 443 2015

WORKDIR /var/www/public

CMD ["/usr/bin/caddy", "-conf", "/etc/Caddyfile"]
