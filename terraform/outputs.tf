output "vpc_id" {
  value = module.networking.vpc_id
}

output "public_subnet_id" {
  value = module.networking.public_subnet_id
}

output "security_group_id" {
  value = module.security.ec2_security_group_id
}

output "lambda_arn" {
  value = module.lambda.lambda_arn
}

output "ec2_public_ip" {
  value = module.ec2.public_ip
}

output "ec2_public_dns" {
  value = module.ec2.public_dns
}
