---
currentMenu: windows
---

# <i class="fa fa-windows"></i> Install Snipe-IT on Windows 2008 R2 with IIS

### Setting Up an IIS Website

- Extract [Snipe-IT](../downloading.html) to `C:\inetpub\wwwroot\snipe-it` (folder name can be changed but we will reference it as is shown here)
- Run IIS Manager
- Right Click `Sites` and `Add Website`

```
Site name: Snipe IT
Physical path: C:\inetpub\wwwroot\snipe-it\public
Binding
Type: http
IP address: All Unassigned or a specific IP if you have one you will be using
Port: 80 or any you wish to use
Host name: assets.portal.local (this can be changed to suit your needs)
```

- Click `OK`

Your site will now appear in the list.

- Double click on your site
- Double Click `URL Rewrite`
	- In the action pane click `Import Rules...`
	- Click the `...` button
	- Go to `C:\inetpub\wwwroot\snipe-it\public`
	- Select `.htaccess` file
	- Click `Open` then `Import`
	- In the action pane click `Apply`


## Fix Permissions

Add permissions for the IIS user for the `uploads` folder:

- Go to `C:\inetpub\wwwroot\snipe-it\public`
- Right Click uploads -> Properties
- Go to Security Tab -> Edit
- Click Add and change location to local machine
- Type IUSR in object name box
- Click OK
- Give IUSR full control
- Click OK twice

Add permissions for the IIS user for the `private_uploads` folder:

- Go to `C:\inetpub\wwwroot\snipe-it\app`
- Right Click private_uploads -> Properties
- Goto Security Tab -> Edit
- Click Add and change location to local machine
- Type IUSR in object name box
- Click OK
- Give IUSR full control
- Click OK twice

Add permissions for the IIS user for the `c:\windows\temp\` folder:

- Goto `C:\windows\`
- Right Click temp -> Properties
- Goto Security Tab -> Edit
- Click Add and change location to local machine
- Type IUSR in object name box
- Click OK
- Give IUSR modify permissions
- Click OK twice

Add permissions for the IIS user for the `storage` folder:

- Go to `C:\inetpub\wwwroot\snipe-it\app`
- Right Click storage -> Properties
- Goto Security Tab -> Edit
- Click Add and change location to local machine
- Type IUSR in object name box
- Click OK
- Give IUSR full control
- Click OK twice

Much <i class="fa fa-heart heart" style="color:red"></i> to [@madd15](http://github.com/madd15) for writing up the Windows installation guide!
