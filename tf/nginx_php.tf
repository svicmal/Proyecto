resource "aws_instance" "nginx_php_server" {
  ami           = "ami-0c55b159cbfafe1f0"  
  instance_type = "t2.micro"              
  subnet_id     = "subnet-0d6cb1239b0ea36db"
  key_name      = "nombre_de_tu_clave"      

  tags = {
    Name = var.name  
  }
}
resource "local_file" "public_ip_file" {
  depends_on = [aws_instance.example]
  filename = "/opt/inventario/ip_publica_web.txt"  # Cambia esto a la ruta de tu archivo
  content  = aws_instance.nginx_php_serve.public_ip  # `aws_instance.example.public_ip` es la dirección IP pública de tu instancia EC2
}