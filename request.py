import requests
import random
name = ["cpu1", "cpu2", "cpu3", "cpu4"]
rname = name[random.randint(0,3)]
rcreq = random.randint(0,20)
rmreq = random.randint(0,100)
rtreq = random.randint(0,60)
param = {'name': rname, 'creq': rcreq, 'mreq':rmreq, 'treq': rtreq}
stuff = requests.post("http://localhost/hello/dbh.php", param)
