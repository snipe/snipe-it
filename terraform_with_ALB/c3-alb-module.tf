resource "aws_ecs_cluster" "foo" {
  name = "snipe-cluster"
}
module "rohan-alb" {
  source = "./module/aws_alb_tg"
  alb_name = var.my_alb_name
  tg_name = var.my_tg_name
  
}
