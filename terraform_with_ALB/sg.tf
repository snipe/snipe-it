resource "aws_security_group" "ecs_sg-3306" {
  name        = "testapp-ecs-tasks-security-group-for-3306"
  description = "allow inbound access from the ALB only"
  vpc_id      = aws_default_vpc.default.id

  ingress {
    protocol        = "tcp"
    from_port       = 3306
    to_port         = 3306
    cidr_blocks = ["0.0.0.0/0"]
  }

  egress {
    protocol    = "-1"
    from_port   = 0
    to_port     = 0
    cidr_blocks = ["0.0.0.0/0"]
  }
}

resource "aws_security_group" "ecs_sg-80" {
  name        = "testapp-ecs-tasks-security-group-for-80"
  description = "allow inbound access from the ALB only"
  vpc_id      = aws_default_vpc.default.id

  ingress {
    protocol        = "tcp"
    from_port       = 80
    to_port         = 80
    cidr_blocks = ["0.0.0.0/0"]
  }

  egress {
    protocol    = "-1"
    from_port   = 0
    to_port     = 0
    cidr_blocks = ["0.0.0.0/0"]
  }
}