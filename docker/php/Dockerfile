FROM php:7.4.0-fpm

# Install extensions
ADD https://raw.githubusercontent.com/mlocati/docker-php-extension-installer/572050a69b646d596b93b421abdff4426a4a679b/install-php-extensions /usr/local/bin/
RUN chmod uga+x /usr/local/bin/install-php-extensions
RUN install-php-extensions intl pdo_pgsql

# Install composer
# hadolint ignore=DL3008,DL3009
RUN apt-get update && apt-get install --yes --no-install-recommends git unzip
# hadolint ignore=DL3022
COPY --from=composer:1.9.1 /usr/bin/composer /usr/local/bin/composer

# Configure permissions
ARG UID=1000
RUN useradd --uid $UID --create-home user
USER user

WORKDIR /usr/src/project
