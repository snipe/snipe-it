# Contributing to Bootstrap Table

Looking to contribute something to Bootstrap Table? 

**Here's how you can help.**

Please take a moment to review this document in order to make the contribution
process easy and effective for everyone involved.

Following these guidelines helps to communicate that you respect the time of
the developers managing and developing this open source project. In return,
they should reciprocate that respect in addressing your issue or assessing
patches and features.


## Using the issue tracker

The [issue tracker](https://github.com/wenzhixin/bootstrap-table/issues) is
the preferred channel for [bug reports](#bug-reports), [features requests](#feature-requests)
and [submitting pull requests](#pull-requests), but please respect the following
restrictions:

* Please **do not** use the issue tracker for personal support requests.  Stack
  Overflow ([`bootstrap-table`](http://stackoverflow.com/questions/tagged/bootstrap-table) tag is better place to get help.

* Please **do not** derail or troll issues. Keep the discussion on topic and
  respect the opinions of others.

* Please **do not** open issues or pull requests regarding the code in [`bootstrap-table-examples`](https://github.com/wenzhixin/bootstrap-table-examples) and [`extensions plugin dependence`](https://github.com/wenzhixin/bootstrap-table/tree/develop/src/extensions) (open them in their respective repositories), the dependence list:
    * Table Editable: [x-editable](https://github.com/vitalets/x-editable)
    * Table Export: [tableExport.jquery.plugin](https://github.com/hhurz/tableExport.jquery.plugin)
    * Table Filter: [bootstrap-table-filter](https://github.com/lukaskral/bootstrap-table-filter)
    * Table flat-json: [bootstrap-table-flat-json](https://github.com/djhvscf/bootstrap-table-flatJSON)
    * Table Reorder: [jquery-ui](https://code.jquery.com/ui/) and [dragTable](https://github.com/akottr/dragtable/)
    * Table Resizable: [colResizable](https://github.com/alvaro-prieto/colResizable)

## Issues and labels

Our bug tracker utilizes several labels to help organize and identify issues. Here's what they represent and how we use them:

- `awaiting reply` - Issues that are awaiting reply, will be closed if there is no any response in 7 days.
- `browser bug` - Issues that are reported to us, but actually are the result of a browser-specific bug. These are diagnosed with reduced test cases and result in an issue opened on that browser's own bug tracker.
- `confirmed` - Issues that have been confirmed with a reduced test case and identify a bug in Bootstrap Table.
- `css` - Issues stemming from our compiled CSS or source CSS files.
- `docs` - Issues for improving or updating our documentation.
- `example` - Issues that contains an important example.
- `extension` - Issues for adding or updating our extension.
- `feature` - Issues asking for a new feature to be added, or an existing one to be extended or modified.
- `fixed` - Issues already fixed in a pull request.
- `grunt` - Issues with our included JavaScript-based Gruntfile, which is used to run all our tests, concatenate and compile source files, and more.
- `help wanted` - Issues we need or would love help from the community to resolve.
- `invalid` - Issues we can't resolve because it is not related to Bootstrap Table or the information provided is not completed.
- `js` - Issues stemming from our compiled or source JavaScript files.
- `locale` - Issues regarding errors in locale extensions.
- `needs example` - Issues don't have an example but we need an example in order to confirm the issue or test the pull request.
- `needs review` - Issues missing some important information about errors in the code, steps to reproduce the issue, etc.
- `resource` - Issues with helpful resources to improve Bootstrap Table.
- `update to latest version` - Issues need to update to latest version in order to be fixed.

For a complete look at our labels, see the [project labels page](https://github.com/wenzhixin/bootstrap-table/labels).


## Bug reports

A bug is a _demonstrable problem_ that is caused by the code in the repository.
Good bug reports are extremely helpful, so thanks!

Guidelines for bug reports:

0. **Validate and lint your code** &mdash; [validate your HTML](http://html5.validator.nu)
   and [lint your HTML](https://github.com/twbs/bootlint) to ensure your
   problem isn't caused by a simple error in your own code.

1. **Use the GitHub issue search** &mdash; check if the issue has already been
   reported.

2. **Check if the issue has been fixed** &mdash; try to reproduce it using the
   latest `master` or development branch in the repository.

3. **Isolate the problem** &mdash; ideally create a live example. 
    The web tool [jsfiddle](http://jsfiddle.net/) is a very helpful for this. Consider to use these templates:
    * [Table from html](http://jsfiddle.net/wenyi/e3nk137y/11/light/)
    * [Table from data](http://jsfiddle.net/wenyi/e3nk137y/13/light/)
    * [Table from url](http://jsfiddle.net/wenyi/e3nk137y/14/light/)
    * Other templates can also be found at [jsFiddle Bootstrap](http://bootstrap-table.wenzhixin.net.cn/examples/#basic)


A good bug report shouldn't leave others needing to chase you up for more
information. Please try to be as detailed as possible in your report. What is
your environment? What steps will reproduce the issue? What browser(s) and OS
experience the problem? Do other browsers show the bug differently? What
would you expect to be the outcome? All these details will help people to fix
any potential bugs.

Example:

> Short and descriptive example bug report title
>
> A summary of the issue and the browser/OS environment in which it occurs. If
> suitable, include the steps required to reproduce the bug.
>
> 1. This is the first step
> 2. This is the second step
> 3. Further steps, etc.
>
> `<url>` - a link to the reduced test case
>
> Any other information you want to share that is relevant to the issue being
> reported. This might include the lines of code that you have identified as
> causing the bug, and potential solutions (and your opinions on their
> merits).


## Feature requests

Feature requests are welcome. But take a moment to find out whether your idea
fits with the scope and aims of the project. It's up to *you* to make a strong
case to convince the project's developers of the merits of this feature. Please
provide as much detail and context as possible.


## Pull requests

Good pull requests—patches, improvements, new features—are a fantastic
help. They should remain focused in scope and avoid containing unrelated
commits.

**Please ask first** before embarking on any significant pull request (e.g.
implementing features, refactoring code, porting to a different language),
otherwise you risk spending a lot of time working on something that the
project's developers might not want to merge into the project.

Please adhere to the [coding guidelines](#code-guidelines) used throughout the
project (indentation, accurate comments, etc.) and any other requirements
(such as test coverage).

**Do not edit files of `dist` directly!** Those files are automatically generated. You should edit the
source files in [`/src/`](https://github.com/wenzhixin/bootstrap-table/tree/develop/src) instead.

Similarly, when contributing to Bootstrap's documentation, you should edit the
documentation source files in
[the `/docs/` directory of the `develop` branch](https://github.com/wenzhixin/bootstrap-table/tree/develop/docs).

Adhering to the following process is the best way to get your work
included in the project:

1. [Fork](https://help.github.com/articles/fork-a-repo/) the project, clone your fork,
   and configure the remotes:

   ```bash
   # Clone your fork of the repo into the current directory
   git clone https://github.com/<your-username>/bootstrap-table.git
   # Navigate to the newly cloned directory
   cd bootstrap-table
   # Assign the original repo to a remote called "upstream"
   git remote add upstream https://github.com/wenzhixin/bootstrap-table.git
   ```

2. If you cloned a while ago, get the latest changes from upstream:

   ```bash
   git checkout develop
   git pull upstream develop
   ```

3. Create a new topic branch (off the main project development branch) to
   contain your feature, change, or fix:

   ```bash
   git checkout -b <topic-branch-name>
   ```

4. Commit your changes in logical chunks. Please adhere to these [git commit
   message guidelines](http://tbaggery.com/2008/04/19/a-note-about-git-commit-messages.html)
   or your code is unlikely be merged into the main project. Use Git's
   [interactive rebase](https://help.github.com/articles/about-git-rebase/)
   feature to tidy up your commits before making them public.

5. Locally merge (or rebase) the upstream development branch into your topic branch:

   ```bash
   git pull [--rebase] upstream develop
   ```

6. Push your topic branch up to your fork:

   ```bash
   git push origin <topic-branch-name>
   ```

7. [Open a Pull Request](https://help.github.com/articles/using-pull-requests/)
    with a clear title and description against the `develop` branch.

**IMPORTANT**: By submitting a patch, you agree to allow the project owners to
license your work under the terms of the [MIT License](LICENSE) (if it
includes code changes) and under the terms of the
[Creative Commons Attribution 3.0 Unported License](docs/LICENSE)
(if it includes documentation changes).


## Code guidelines

- Readability
- Need semicolons
- 4 spaces (no tabs)
- strict mode
- "Attractive"


## License

By contributing your code, you agree to license your contribution under the [MIT License](LICENSE).
By contributing to the documentation, you agree to license your contribution under the [Creative Commons Attribution 3.0 Unported License](docs/LICENSE).
