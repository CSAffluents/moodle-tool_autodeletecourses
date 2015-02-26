# moodle-tool_oldcoursesremoval
Old courses removal tool for Moodle

Moodle admin tool plugin - Old courses removal
===================

Information
-----------

This admin tool allow to remove the old courses based on many criterias like the course visibility, the creation date or if the course has been modified. This is particularly useful for the organizations who automatically create all the courses from an external system.

It was created by Gilles-Philippe Leblanc, developer at Université de Montréal.

To install it using git, type this command in the admin/tool folder of your Moodle install:
```
git clone https://github.com/leblangi/moodle-tool_oldcoursesremoval.git oldcoursesremoval
```
Then add /admin/tool/oldcoursesremoval to your git ignore.

Alternatively, download the zip from
<https://github.com/leblangi/moodle-tool_oldcoursesremoval/archive/master.zip>,
unzip it into the local folder, and then rename the new folder to "oldcoursesremoval".

After you have installed this admin tool plugin, you
should see a new option in the settings block:

> Site administration -> Courses -> Auto old courses removal

I hope you find this tool useful. Please feel free to enhance it.
Report any idea or bug @
<https://github.com/leblangi/moodle-tool_purgeautobackups/issues>, thanks!
