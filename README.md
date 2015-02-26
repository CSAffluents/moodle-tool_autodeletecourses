# moodle-tool_autodeletecourses
Auto courses deletion tool for Moodle

Moodle admin tool plugin - Auto courses deletion
===================

Information
-----------

This admin tool allow to automatically delete the old courses based on many criterias like the course visibility, the creation date or if the course has been modified. This is particularly useful for the organizations who automatically create all the courses from an external system.

It was created by Gilles-Philippe Leblanc, developer at Université de Montréal.

To install it using git, type this command in the admin/tool folder of your Moodle install:
```
git clone https://github.com/leblangi/moodle-tool_autodeletecourses.git autodeletecourses
```
Then add /admin/tool/autodeletecourses to your git ignore.

Alternatively, download the zip from
<https://github.com/leblangi/moodle-tool_autodeletecourses/archive/master.zip>,
unzip it into the local folder, and then rename the new folder to "autodeletecourses".

After you have installed this admin tool plugin, you
should see a new option in the settings block:

> Site administration -> Courses -> Auto old courses deletion > Settings

You may check which courses will be deleted based on these settings here:

> Site administration -> Courses -> Auto old courses deletion > Show eligible courses

Once these settings are configured correctly, simply lauch the Moodle cron.

You may also configure a new cron to specifically proceed with the deletion of the old courses.

Sample cron entry:
```
# 5 minutes past 4am
5 4 * * * $sudo -u www-data /usr/bin/php /var/www/moodle/admin/tool/autodeletecourses/cli/delete.php
```

Notes:
- it is required to use the web server account when executing PHP CLI scripts
- you need to change the "www-data" to match the apache user account
- use "su" if "sudo" not available

I hope you find this tool useful. Please feel free to enhance it.
Report any idea or bug @
<https://github.com/leblangi/moodle-tool_autodeletecourses/issues>, thanks!
