FROM node:18-alpine AS builder
WORKDIR /usr/src/app

# Устанавливаем зависимости и собираем проект
COPY package*.json ./
RUN npm install --frozen-lockfile
COPY . .
RUN npm run build

# Запускаем сервер Next.js
CMD ["npm", "run", "dev"]  # <-- Запуск в dev-режиме

EXPOSE 3000