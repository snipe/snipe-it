# Some Notes on Security

Although this is web-based software and must run on a web server, you may want to consider whether you actually need it accessible to the outside world. Running it on an internal network with ports closed to the outside world, or on AWS using a security group that prevents access from outside a selected static IP range, may be something to consider.

While most use cases won't be storing Personally Identifiable Information (PII), someone with the right motivation could gain useful knowledge about the number of employees, types of assets, etc you maintain. While this information in and of itself isn't harmful, it could be helpful to Bad Guys in a targeted attack, so you should consider whether you want to limit access to it via IP or network rules.

Also, running this over SSL is not required, but a good idea. (Running everything ever over SSL is a good idea at this point.)
