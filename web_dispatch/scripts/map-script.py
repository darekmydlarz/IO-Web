#!/usr/bin/env python

# scripts generate file map.js in directory: ./ready/lastdir(sys.argv[1])

import sys, string, os, json, fileinput

class ComplexEncoder(json.JSONEncoder):
	def default(self, obj):
		if isinstance(obj, complex):
			return [obj.real, obj.imag]
		return json.JSONEncoder.default(self, obj)

# an argument should be path to file `commisions.properties`
if __name__ == "__main__":
	if(len(sys.argv) < 2):
		print "Usage: %s <dir with commisions.properties file>" % sys.argv[0]
		exit(1)
	
	dirpath = sys.argv[1]
	path = 'uploads' + os.sep + dirpath + os.sep + "commisions.properties"
	
	dirname = dirpath.split(os.sep)
	dirname = dirname[-2] if dirname[-1] == "" else dirname[-1]
	
	f = open(path, 'r');
	fileLines = f.readlines();	
	# first line contains info about base localization (before first line is zero line!)
	firstline = fileLines[1:2]
	# skip 2 first lines	(configuration lines, base info)
	lines = fileLines[2:]
	f.close()
	
	firstline = firstline[0].split()	
	mymap = {}
	mymap[0] = {
		"x" : firstline[1],
		"y" : firstline[2],
		"from" : "0",
		"to" : "0"
	}
	
	for line in lines:
		tmp = line.split()
		deliverFrom = tmp[7]
		deliverTo = tmp[8]
		mymap[int(tmp[0])] = {
			"x" : tmp[1],
			"y" : tmp[2],
			"from" : deliverFrom,
			"to" : tmp[8]
		}
	
	# generate in the same dir a map for a tusk
	saveDirPath = '.' + os.sep + 'ready' + os.sep + dirname;

	if not os.path.exists(saveDirPath):
		os.makedirs(saveDirPath)
	mapFile = open(saveDirPath + os.sep + 'map.js', 'w');
	mapFile.write(ComplexEncoder().encode(mymap))
	mapFile.close()
