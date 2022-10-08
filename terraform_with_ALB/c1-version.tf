provider "aws" {
  region  = var.aws_region
#   profile = default
  
}
terraform {
  required_providers {
    aws = {
      source = "hashicorp/aws"
      version = "4.33.0"
    }
  }
}

terraform {
  backend "s3" {
    bucket = "terraform-state-4543"
    key    = "path/tf.state"
    region =  "ap-south-1"
    encrypt = true
  }
}
