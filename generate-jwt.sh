#!/bin/bash

echo "Entrez une passphrase pour protéger la clé privée JWT :"
read -s PASSPHRASE
echo "Confirmer la passphrase :"
read -s CONFIRM

# Vérifier que les passphrases correspondent
if [ "$PASSPHRASE" != "$CONFIRM" ]; then
  echo "Les passphrases ne correspondent pas."
  exit 1
fi

# Créer les répertoires si nécessaire
mkdir -p config/jwt

# Générer les clés privée et publique
openssl genrsa -aes256 -passout pass:$PASSPHRASE -out config/jwt/private.pem 4096
openssl rsa -in config/jwt/private.pem -passin pass:$PASSPHRASE -pubout -out config/jwt/public.pem

# Mettre à jour .env.local avec la passphrase (si elle n'existe pas déjà)
if [ ! -f .env.local ]; then
  touch .env.local
fi

if grep -q "JWT_PASSPHRASE=" .env.local; then
  sed -i "s/^JWT_PASSPHRASE=.*/JWT_PASSPHRASE=$PASSPHRASE/" .env.local
else
  echo "JWT_PASSPHRASE=$PASSPHRASE" >> .env.local
fi

echo "Clés JWT générées et .env.local mis à jour."