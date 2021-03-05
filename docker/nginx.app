FROM nginx:stable-alpine

RUN rm -f /etc/nginx/conf.d/default.conf

ADD ./nginx/nginx.conf /etc/nginx/nginx.conf
ADD ./nginx/default.conf /etc/nginx/conf.d/default.conf

RUN mkdir -p /var/www/html

RUN addgroup -g 1000 timebreaker && adduser -G timebreaker -g timebreaker -s /bin/sh -D timebreaker

RUN chown timebreaker:timebreaker /var/www/html
