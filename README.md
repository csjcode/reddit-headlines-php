# Displaying Reddit Headlines for pre-configured subreddits with PHP JSON retrieval and JSON parser

## About
This an old piece of code I did a long time ago... but may be useful for somebody needing Reddit headlines. It was part of larger project I was working on to quickly retrieve various types of XML, RSS and JSON feeds and parse and display them for prepping for later curating on Twitter and other social media. I'm just posting it for posterity and if somebody needs a quick solution to do the same.

It's a simple but useful procedural PHP code snippet that does one thing well. It's not OOP or anything to fancy, intentionally, so that it an be efficiently cut-and-paste into existing projects, and easily customized without a lot of overhead/files.

Enjoy...

## Configuration

I run this locally in LAMP configuration but since it doesn't use anything to fancy, it should work on modern PHP and Apache/Nginx/webserver installs.

The file consists of:
* initial html setup
* html form and dropdown with subreddit categories
* display tags to display the headlines,
* a list of user-defined Reddit subreddits (an array in the code)
* url to retrieve PHP code to retrieve the JSON file
* PHP code to parse the JSON data

**note:** This does not display self-posts on Reddit, those are filtered out. You can change that easily if you want though in the code.

**note 2:** It is setup initally in the code to get display the most recent headlines first.

Just place it in the directory of a web server and go to the file location in a web browser.

You should see a dropdown with subreddit (category) names.

Select one subreddit name and it will retrieve it with recent top headlines (except for self-posts).
