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
  ami           = "ami-0bb84b8ffd87024d8"
  instance_type = "t2.micro"
  subnet_id     = "subnet-0d6cb1239b0ea36db"
  key_name      = "servidor-web"

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
  depends_on = [aws_eip_association.correo_eip_assoc]
  filename = "/home/admin/ip_publica_web.txt"
  content    = aws_eip.nginx_php_eip.public_ip
}

# Creación del servidor de correo
resource "aws_instance" "correo_server" {
  ami           = "ami-058bd2d568351da34"
  instance_type = "t2.micro"
  subnet_id     = "subnet-0d6cb1239b0ea36db"
  key_name      = "correo"

  tags = {
    Name = "correo"
  }
}
# Creación de una Elastic IP (EIP)
resource "aws_eip" "correo_eip" {
  instance = aws_instance.correo_server.id
}

# Asociar la Elastic IP (EIP) a la instancia EC2
resource "aws_eip_association" "correo_eip_assoc" {
  instance_id   = aws_instance.correo_server.id
  allocation_id = aws_eip.correo_eip.id
}

resource "local_file" "public_ip_correo_file" {
  depends_on = [aws_eip_association.correo_eip_assoc]
  filename = "/home/admin/ip_publica_correo.txt"
  content    = aws_eip.correo_eip.public_ip
}