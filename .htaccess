<IfModule mod_rewrite.c>
    <IfModule mod_negotiation.c>
        Options -MultiViews
    </IfModule>

    # Make sure .env files not not browseable if in a sub-directory.
    <FilesMatch "\.env$">
    Deny from all
    </FilesMatch>
    
</IfModule>
