#!/bin/bash

echo "Creando recursos con Terraform..."
terraform init
terraform apply -auto-approve

# Generar el inventario de Ansible usando terraform-inventory
echo "Generando el inventario de Ansible"
terraform-inventory --output=inventario.ini

# Ejecutar los playbooks 
echo "Ejecutando playbooks de Ansible"
ansible-playbook -i /opt/inventario/ip_publica_web.txt ansible/cluste1/nginx_conf.yaml
ansible-playbook -i /opt/inventario/ip_publica_correo.txt ansible/correo_conf.yaml
