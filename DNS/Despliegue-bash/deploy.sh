#!/bin/bash


# Create directory and copy deployment files
mkdir "$1"
cp -r despliegue/* "$1/"
cd "$1" || exit

# Initialize and apply Terraform
if ! terraform init &>/dev/null; then
  echo "Terraform initialization failed"
  exit 1
fi

if ! terraform apply -auto-approve &>/dev/null; then
  echo "Terraform apply failed"
  exit 1
fi

# Sleep to allow services to start
sleep 180

# Retrieve the public IP address of the web server
ip_web=$(cat /home/admin/ip_publica_web.txt)
if [ -z "$ip_web" ]; then
  echo "Failed to retrieve web server IP"
  exit 1
fi

# Run Ansible playbook to configure Nginx
ansible-playbook -i /home/admin/ip_publica_web.txt --ssh-extra-args="-o StrictHostKeyChecking=no -o UserKnownHostsFile=/dev/null" --private-key=/home/admin/web.pem ansible/nginx_conf.yaml

# Insert record into MongoDB
mongo_command=$(echo "db.paginas.insert({ id : '$2',nombre : '$1', IP : '$ip_web' , usuario : 'root' , password : 'tu_contraseña'})")
if ! echo "$mongo_command" | mongosh --host 10.0.137.230 --port 27017 -u usuario -p PassWord --authenticationDatabase origen; then
  echo "MongoDB insertion failed"
  exit 1
fi

#Update DNS records
web="${1}web"
echo "$web    IN  A   $ip_web" >> /etc/bind/db.sergio

# Restart BIND service
if ! sudo service bind9 restart; then
  echo "Failed to restart BIND service"
  exit 1
fi
rm -rf /home/admin/despliegue/ansible/pag/*

cp /home/admin/index.html /home/admin/despliegue/ansible/pag

