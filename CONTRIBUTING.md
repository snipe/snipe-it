### Contributing

Please see the documentation on [contributing and developing for Snipe-IT](https://snipe-it.readme.io/docs/contributing-overview).


Please note that this project is released with a [Contributor Code of Conduct](CODE_OF_CONDUCT.md). By participating in this project you agree to abide by its terms.

### Useful tools

Add codespell as a linter:
`pip install codespell`

Add a precommit hook:
`cp contrib/hooks/pre-commit .git/hooks/`

Add phpcs:
`curl -OL https://phars.phpcodesniffer.com/phpcs.phar`

Check against PSR12:
`php phpcs.phar -n --standard=PSR12 app/`