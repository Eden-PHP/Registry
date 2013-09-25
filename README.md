# Registry

One annoyance when dealing with configuration classes is that there can be many which holds a small part of all the actual data you need to build a web page. Gathering that data can be a real pain and if not stored in a public variable, impossible to access. *Eden's* registry out weighs the benefits of a normal configuration class because of its ability to organize data and access data by their unique key or access datasets by their common key. When we think about *Eden's* registry we can imagine a file system, where if you choose a folder you will get a list of files and when you choose a file given its folder path and name you will get the exact value. `Figure 1` below shows how we set data in the registry.

**Figure 1. Setting Paths**

	$registry = eden('registry') //instantiate
		->set('path', 'to', 'value1', 123)   //set path 'path','to', 'value' to 123
		->set('path', 'to', 'value2', 456);  //set path 'path','to', 'value' to 456

Now that we have a populated registry, `Figure 2` shows us how we can access data and datasets.

**Figure 2. Get Data and Datasets**

	echo $registry->get('path', 'to', 'value1'); //--> 123
	echo $registry->get('path', 'to', 'value2'); //--> 456
	echo $registry->get('path', 'to');   //--> {value1:123,value2:456}

The complete list of methods for a registry can be found in `Figure 3`.

> **Note:** The Registry class extends *Eden's* array object. This means you can also call common array methods.

**Figure 3. Registry Methods**

	$registry->set('path', 'to', 'value');   //set path 'path','to' to 'value'
	$registry->get('path', 'to');            //get data where path is 'path','to'
	$registry->remove('path', 'tp');     //unset data where path is 'path','to'
	$registry->isKey();                      //returns true if path 'path','to' exists
	 
	$registry['name'] = 'value';            //set 'name' to 'value'
	echo $registry['path']['to'];           //get data where path is 'path','to'
	 
	foreach($registry as $key => $value) {}  //loop through registry
	 
	echo $registry; // outputs a json version of the registry

*Eden's* registry is designed to be short and sweet and at the same time robust and an ideal solution for data management.

====

#Contributing to Eden

##Setting up your machine with the Eden repository and your fork

1. Fork the main Eden repository (https://github.com/Eden-PHP/Registry)
2. Fire up your local terminal and clone the *MAIN EDEN REPOSITORY* (git clone git://github.com/Eden-PHP/Registry.git)
3. Add your *FORKED EDEN REPOSITORY* as a remote (git remote add fork git@github.com:*github_username*/Registry.git)

##Making pull requests

1. Before anything, make sure to update the *MAIN EDEN REPOSITORY*. (git checkout master; git pull origin master)
2. If PHP Unit testing is included in this package please make sure to update it and run the test to ensure everything still works (phpunit)
3. Once updated with the latest code, create a new branch with a branch name describing what your changes are (git checkout -b bugfix/fix-twitter-auth)
    Possible types:
    - bugfix
    - feature
    - improvement
4. Make your code changes. Always make sure to sign-off (-s) on all commits made (git commit -s -m "Commit message")
5. Once you've committed all the code to this branch, push the branch to your *FORKED EDEN REPOSITORY* (git push fork bugfix/fix-twitter-auth)
6. Go back to your *FORKED EDEN REPOSITORY* on GitHub and submit a pull request.
7. An Eden developer will review your code and merge it in when it has been classified as suitable.