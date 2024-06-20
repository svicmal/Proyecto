#!/bin/bash

cd $1

ansible-playbook -i ip_server.txt --ssh-extra-args="-o StrictHostKeyChecking=no -o UserKnownHostsFile=/dev/null" --private-key=/home/admin/web.pem ansible/update.yaml
