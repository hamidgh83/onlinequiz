# Online Quiz
This is an small program to take an online Quiz. Users can pick a test and answer to the questions and finally get their result.

### Requirements
This project requires **PHP >=7.0**, **Composer** and  **NPM** to be installed. 

### Installation
Download the source code from:
```sh
git clone https://github.com/hamidgh83/onlinequiz.git
```
After cloning the source code go to the project folder and run:

```sh
composer update
```

Then to setup the project you need to create a database named "onlinequiz" and import sql file from the directory ***[project_path]/data***. Then go to ***Assest*** folder and update dependency packages using the following command:

```sh
$ npm update
```

This command simply download jquery and bootstrap packages and install them inside **Assets** folder.

**Note:** If you setup a virtual host please make sure that you set your root directory to ***src*** folder where the *index.php* file is located.

### Project Architecture
This project has been implemented based on MVC architecture and it doesn't use any PHP Frameworks.  


