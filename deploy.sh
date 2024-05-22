#!/bin/bash

echo "Creando recursos con Terraform..."
terraform init
terraform apply -auto-approve

# Ejecutar los playbooks 
echo "Ejecutando playbooks de Ansible"
ansible-playbook -i /opt/inventario/ip_publica_web.txt ansible/nginx_conf.yaml
ansible-playbook -i /opt/inventario/ip_publica_correo.txt ansible/correo_conf.yaml
ip_correo = $(cat /opt/inventario/ip_publica_correo.txt)
ip_web = $(cat /opt/inventario/ip_publica_web.txt)
web = "${1}web"
correo = "${1}correo"
echo "$web    IN  A   $ip_correo" >> /var/cache/bind/db.origen
echo "$correo    IN  A   $ip_web" >> /var/cache/bind/db.origen
service bind restart