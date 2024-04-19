module "eks" {
  source                           = "terraform-aws-modules/eks/aws"
  cluster_name                     = "Servidor web"
  cluster_version                  = "1.21"

  vpc_id                           = "vpc-12345678" # Variable de la VPC
  subnet_ids = module.vpc.private_subnet
  cluster_endpoint_public_access   = true
  cluster_endpoint_private_access  = true
  eks_managed_node_groups = {

    node_groups = {
      my_workers = {
        desired_capacity = 2
        max_capacity     = 3
        min_capacity     = 1
        instance_type    = "t2.micro" # Tipo de instancia para los nodos

      }
    }

  }
  
}


output "endpoint" {
  value = aws_eks_cluster.example.endpoint
}

output "kubeconfig-certificate-authority-data" {
  value = aws_eks_cluster.example.certificate_authority[0].data
}