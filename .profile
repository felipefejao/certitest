# Heroku dyno boot script — gera uma APP_KEY temporária se não estiver definida.
# Para uma chave persistente, defina a config var:
#   heroku config:set APP_KEY="$(php artisan key:generate --show)"
if [ -z "$APP_KEY" ]; then
    export APP_KEY="base64:$(php -r 'echo base64_encode(random_bytes(32));')"
fi
