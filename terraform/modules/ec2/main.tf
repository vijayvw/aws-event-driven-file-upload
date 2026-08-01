data "aws_ami" "amazon_linux" {

  most_recent = true

  owners = ["amazon"]

  filter {
    name   = "name"
    values = ["al2023-ami-2023*-x86_64"]
  }

  filter {
    name   = "architecture"
    values = ["x86_64"]
  }

}

resource "aws_instance" "this" {

  ami           = data.aws_ami.amazon_linux.id
  instance_type = var.instance_type

  subnet_id = var.public_subnet_id

  vpc_security_group_ids = [
    var.security_group_id
  ]

  iam_instance_profile = var.instance_profile

  associate_public_ip_address = true

  key_name = var.key_name

  user_data = templatefile(
    "${path.module}/userdata.sh.tpl",
    {
      bucket_name = var.bucket_name
      github_repo = var.github_repo
    }
  )

  tags = {
    Name = "${var.project_name}-server"
  }

}
