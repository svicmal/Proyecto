terraform {
  required_providers {
    aws = {
      source  = "hashicorp/aws"
      version = "~> 4.16"
    }
  }
  required_version = ">= 1.2.0"
}

provider "aws" {
  region  = "us-east-1"
}

# Creación del servidor nginx para otra página web
resource "aws_instance" "nginx_php_server" {
  ami           = "ami-058bd2d568351da34"
  instance_type = "t2.micro"
  subnet_id     = "subnet-0377d780b21a5fb20"
  key_name      = "web"
  vpc_security_group_ids = ["sg-090f64eadc528c59e"]
  tags = {
    Name = "servidorweb"
  }
}
# Creación de una Elastic IP (EIP)
resource "aws_eip" "nginx_php_eip" {
  instance = aws_instance.nginx_php_server.id
}

# Asociar la Elastic IP (EIP) a la instancia EC2
resource "aws_eip_association" "nginx_php_eip_assoc" {
  instance_id   = aws_instance.nginx_php_server.id
  allocation_id = aws_eip.nginx_php_eip.id
}


resource "local_file" "public_ip_file" {
  depends_on = [aws_eip_association.nginx_php_eip_assoc]
  filename = "/home/admin/ip_publica_web.txt"
  content    = aws_eip.nginx_php_eip.public_ip
}
