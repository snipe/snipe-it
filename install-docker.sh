
#https://snipe-it.readme.io/docs/docker
#https://github.com/petr-toman/snipe-it
#docker-compose up --build -d
# watch: SELINUX and volumes usage - mapped volumes at hosting system should be like:
#sudo chcon -Rt svirt_sandbox_file_t /path/to/html/snipe-it
#or better:
#sudo semanage fcontext -a -t svirt_sandbox_file_t "/path/to/html/snipe-it(/.*)?"
#sudo restorecon -R /path/to/html/snipe-it & ll -Z
#https://www.projectatomic.io/blog/2015/06/using-volumes-with-docker-can-cause-problems-with-selinux/


#DON'T FORGOT TO EDIT . snipe-it.env file by your prefferences

docker build -t toman/snipe-it ./Dockerfile
docker-compose up --build -d
