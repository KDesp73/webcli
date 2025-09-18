#!/usr/bin/env bash
set -e

GREEN="\033[0;32m"
RED="\033[0;31m"
NC="\033[0m"

echo -e "${GREEN}[*] Setting up PHP project...${NC}"

if ! command -v php >/dev/null 2>&1; then
  echo -e "${RED}[!] PHP is not installed. Please install PHP 8.2+.${NC}"
  exit 1
fi

if ! command -v unzip >/dev/null 2>&1; then
  echo -e "${RED}[!] unzip is not installed. Please install unzip.${NC}"
  exit 1
fi

if ! command -v composer >/dev/null 2>&1; then
  echo -e "${GREEN}[*] Installing Composer...${NC}"
  EXPECTED_SIGNATURE="$(wget -q -O - https://composer.github.io/installer.sig)"
  php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
  ACTUAL_SIGNATURE="$(php -r "echo hash_file('sha384', 'composer-setup.php');")"

  if [ "$EXPECTED_SIGNATURE" != "$ACTUAL_SIGNATURE" ]; then
    >&2 echo -e "${RED}[!] ERROR: Invalid Composer installer signature${NC}"
    rm composer-setup.php
    exit 1
  fi

  php composer-setup.php --install-dir=/usr/local/bin --filename=composer
  rm composer-setup.php
fi

if command -v apt-get >/dev/null 2>&1; then
  echo -e "${GREEN}[*] Installing PHP extensions...${NC}"
  apt-get update -y
  apt-get install -y git libzip-dev
  docker-php-ext-install zip || true
fi

echo -e "${GREEN}[*] Installing composer dependencies...${NC}"
composer install --no-dev --optimize-autoloader

echo -e "${GREEN}✔ Setup complete.${NC}"
