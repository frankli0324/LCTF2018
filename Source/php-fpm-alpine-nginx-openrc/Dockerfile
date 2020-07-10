FROM php:7.0-fpm-alpine

RUN sed -i 's/dl-cdn.alpinelinux.org/mirrors.aliyun.com/' /etc/apk/repositories
RUN apk add --no-cache openrc nginx

RUN sed -i 's/#rc_sys=""/rc_sys="lxc"/g' /etc/rc.conf &&\
    echo 'rc_provide="loopback net"' >> /etc/rc.conf &&\
    sed -i 's/^#\(rc_logger="YES"\)$/\1/' /etc/rc.conf &&\
    sed -i '/tty/d' /etc/inittab &&\
    sed -i 's/hostname $opts/# hostname $opts/g' /etc/init.d/hostname &&\
    sed -i 's/mount -t tmpfs/# mount -t tmpfs/g' /lib/rc/sh/init.sh &&\
    sed -i 's/cgroup_add_service /# cgroup_add_service /g' /lib/rc/sh/openrc-run.sh

RUN mkdir /run/nginx
RUN mkdir /run/openrc
RUN touch /run/openrc/softlevel
VOLUME [ "/sys/fs/cgroup" ]

COPY php-fpm /etc/init.d/php-fpm
RUN chmod +x /etc/init.d/php-fpm

RUN rc-update add nginx default
RUN rc-update add php-fpm default
