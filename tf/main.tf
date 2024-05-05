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
  region  = "us-west-2"
}

# Llamamos al archivo que creara el servidor nginx para crear otra pagina web
module "Servidor_web" {
  source = "./nginx_php.tf"
}

module "Servidor_correo" {
  source = "./correo.tf"
}