FROM wordpress:5.8

COPY ./entrypoint.sh /usr/local/bin/apache2-custom.sh
RUN chmod 755 /usr/local/bin/apache2-custom.sh
RUN chmod +x /usr/local/bin/apache2-custom.sh

CMD [ "apache2-custom.sh" ]
