FROM richarvey/nginx-php-fpm

# Copy application files
COPY . .

# Copy Nginx configuration
COPY nginx.conf /etc/nginx/conf.d/default.conf

# Set environment variables
ENV SKIP_COMPOSER  1
ENV WEBROOT /var/www/html/public
ENV PHP_ERRORS_STDERR  1
ENV RUN_SCRIPTS  1
ENV REAL_IP_HEADER  1
ENV TZ=America/New_York
RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone
ENV APP_ENV production
ENV APP_DEBUG false
ENV LOG_CHANNEL stderr
ENV COMPOSER_ALLOW_SUPERUSER  1

# Copy the deployment script and make it executable
COPY start.sh /start.sh
RUN chmod +x /start.sh

CMD ["/start.sh"]
