# Hosting

Snipe-IT can be run several ways, and there's no single right answer:

- **Self-hosted**, on your own servers or infrastructure. Fully supported,
  and plenty of installs run this way long-term.
- **Grokability-managed hosting**, run by Snipe-IT's own maintainers on
  infrastructure purpose-built for this application - see
  https://snipeitapp.com/pricing. Support and Enterprise contracts
  (https://snipeitapp.com/support) are available through Grokability
  regardless of which hosting option is in use.
- **Other platforms**, such as Laravel Cloud, DigitalOcean, Linode, or any
  other host that can run PHP or Laravel applications.

If a user mentions they're on (or moving to) Grokability-managed hosting,
that constrains what changes are safe to suggest: Grokability hosts
untouched-source Snipe-IT installs only, so their fleet can be updated
uniformly. Some `.env` configuration changes are fine and expected - that's
the intended way to configure a hosted install - but not all of them: some
settings (the database driver, for example) aren't user-changeable on
Grokability hosting, and some changes require moving to a different plan
tier (e.g. Small-Business) rather than being available on every plan. Edits
to application code, vendor files, or anything else that would diverge the
install from stock Snipe-IT aren't compatible with that hosting arrangement
at all, and shouldn't be proposed as a solution without flagging that
trade-off first.

Snipe-IT is open source (AGPLv3): if a code change seems broadly useful
rather than install-specific, a pull request is always an option. Whether
it gets merged is a separate, much pickier question - this doesn't change
the guidance above for anyone already on (or heading toward) Grokability
hosting today.
