# GitHub Code Maintenance Guidelines

This document will cover some basic guidelines for contributing to this repository. These guidelines will help us maintain our code and keep out github repository organized.

This document contains the following chapters:
* [Code Styling](#code-styling)
* [Testing Your Code](#testing-your-code)
* [GitHub Commit Messages](#github-commit-messages)
* [GitHub Branches](#github-branches)
* [Pull Requests](#pull-requests)


## Code Styling

In order to keep our code readable, please make sure that you format your code in a readable way. Also make sure that you write code that is easy for others to understand. Some guidelines to follow include but are not limited to:

* Indenting nested statements
* **Commenting your code to help others understand it**
* Use appropriate variable and function names that make it easy to understand what your intention is
* Not hardcoding values (magic numbers) in your code as this makes it confusing for others to understand the code

Please make sure that you comment your code. This helps with keeping our code understandable, and can help if you get stuck and need another set of eyes on your code.

## Testing Your Code

Before making a commit, make sure that you test your code to ensure that it does what you want it to do. Test your code on the Chrome and Firefox browsers. If you are able to, try to test on Safari as well.

## GitHub Commit Messages

GitHub commit messages should be written in the imperative mood.

GitHub commit messages should follow this format:

```
Brief description of your changes (50 characters max)

Expand more on your changes (70 characters max)
```

Please make sure that your commit messages are detailed so that others can understand what changes you made.

## GitHub Branches
When making changes to this project, please commit all your changes in your own branch. **Never directly push any changes to the main branch.** If your branch contains multiple words, separate them with a hyphen. Please append the following categories to your branch based on what you are committing:

* **feature/** should be used if you are committing a new feature
* **bugfix/** should be used if you are fixing errors in the project
* **docs/** should be used if you are creating or updating documentation

For example, if you want to create a branch where you will be committing code to handle user authentication, the following branch name would be appropriate:

```feature/user-authentication```

Once you are finished making a change, open a pull request so your code can be reviewed and merged to main if accepted.

## Pull Requests
Pull requests will allow others to review your code before it gets merged to the main branch. This will allow others to look at your code and double check for any errors and integration issues that may come up. After multiple people review your commits and approve, then your branch will be merged with the main branch.