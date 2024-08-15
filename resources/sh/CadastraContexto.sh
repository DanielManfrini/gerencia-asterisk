#!/bin/bash

# Criado por Daniel Lopes 24/04/2024

senha=$(openssl enc -d -aes-256-cbc -pbkdf2 -iter 100000 -salt -in secret.secret)

sshpass -p "$senha" ssh amota@172.20.20.42<< EOF

arquivo="/etc/asterisk/extensions.conf"

echo "[$1]" >> "\$arquivo"
echo "switch => Realtime/\$1@extensions" >> "\$arquivo"

EOF
