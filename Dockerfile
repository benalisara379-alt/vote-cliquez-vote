FROM php:8.3-cli

WORKDIR /app

COPY . .

CMD ["php", "-S", "0.0.0.0:8000"]