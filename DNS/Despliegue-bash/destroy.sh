#!/bin/bash

cd $1
terraform destroy -auto-approve &>/dev/null
# Insert record into MongoDB
mongo_command=$(echo "db.paginas.deleteOne({ nombre : '$1', IP : '$ip_web' , usuario : 'root' , password : 'tu_contraseña'})")
if ! echo "$mongo_command" | mongosh --host 10.0.137.230 --port 27017 -u usuario -p PassWord --authenticationDatabase origen; then
  echo "MongoDB insertion failed"
  exit 1
fi
cd ..
rm -rf $1
cat /etc/bind/db.sergio | grep -v $1web > /etc/bind/db.sergio

sudo systemctl restart bind9
