FROM alpine

RUN sed -i 's/dl-cdn.alpinelinux.org/mirrors.aliyun.com/' /etc/apk/repositories
RUN apk add --no-cache build-base python3 py3-pip py3-gevent py3-gunicorn
COPY requirements.txt /opt/requirements.txt
RUN pip3 install -r /opt/requirements.txt -i https://mirrors.aliyun.com/pypi/simple/ --no-cache-dir
RUN apk del py3-pip build-base

COPY playground /opt/playground
COPY docker-entrypoint /etc/docker-entrypoint
RUN chmod +x /etc/docker-entrypoint

EXPOSE 8000
WORKDIR /opt
ENTRYPOINT ["/etc/docker-entrypoint"]
