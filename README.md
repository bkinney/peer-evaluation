# peer-evaluation
Just a clone of the 2016 working version without the external files that don't reside in the folder, such as the config, dbconnect, or anything from the Canvas API infrastructure. So, this doesn't work as is. Am going to fork it to create the 'RedHat' version.
Visit http://apps.ats.udel.edu/peer/readme.html for a list of functions and dependencies.

The plan for this is to get rid of everything specific to the University of Delaware. Partial list:

Dependency on LDAP - now you can only put in people from your Canvas course
Option for CAS login vs Canvas. This version is Canvas only
Link to the lti database for API tokens - just use a hard code a token, or replace with your own db info
Link to peer database- you will need to create your own db and link to it.
