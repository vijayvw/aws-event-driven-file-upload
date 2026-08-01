module "networking" {
  source = "./modules/networking"

  project_name       = var.project_name
  vpc_cidr           = var.vpc_cidr
  public_subnet_cidr = var.public_subnet_cidr
  availability_zone  = var.availability_zone
}

module "security" {

  source = "./modules/security"

  project_name      = var.project_name

  vpc_id            = module.networking.vpc_id

  allowed_ssh_cidr  = local.my_ip

}


module "iam" {
  source = "./modules/iam"

  project_name = var.project_name
  bucket_name  = module.s3.bucket_name

  # Temporary until the SNS module is created
  sns_topic_arn = module.sns.topic_arn
}

module "s3" {

  source = "./modules/s3"

  bucket_name  = var.bucket_name
  project_name = var.project_name

}

module "sns" {

  source = "./modules/sns"

  project_name       = var.project_name
  notification_email = var.notification_email

}

module "lambda" {

  source = "./modules/lambda"

  project_name = var.project_name

  lambda_role_arn = module.iam.lambda_role_arn

  bucket_name = module.s3.bucket_name

  sns_topic_arn = module.sns.topic_arn

}

module "ec2" {

  source = "./modules/ec2"

  project_name = var.project_name

  public_subnet_id = module.networking.public_subnet_id

  security_group_id = module.security.ec2_security_group_id

  instance_profile = module.iam.ec2_instance_profile

  bucket_name = module.s3.bucket_name

  instance_type = var.instance_type

  key_name = var.key_name

  github_repo = var.github_repo
}
