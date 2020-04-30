# Load-Balancer
## A naive implementation of how a load balancer works using LAMP stack.
### 1 - Connecting PHP with the database

First connected php with the required database which in this case is db_with_2_tables using the function:
```mysqli_connect()``` which will return an object representing the connection to the database.
       
### 2 - Creating the Requests table
The query is first assigned as a string to a variable and then sent to mysqli using:
```mysqli_query()``` which takes in 2 parametres which includes the object representing the connection to the database and the variable 
containing the query as a string.
       
### 3 - Sending request from the request.py script

To send requests randomnly to different nodes, an array with the node names is first created and then a random node name is set to a 
variable using : ```rname = name[random.randint(0,3)]``` where 'name' is the array with node names.
    
### 4 - For random parametres
    
CPU required, memory required and time required for time completion: 3 variables rcreq, rmreq, rtreq are created
and are assigned random values. For CPU required the random values range from 0 to 20, for memory required the values may range from 0 to 100 
and for time the values range from 0 to 60.

These values are sent as a POST request using 2 commands:
```
param = {'name': rname, 'creq': rcreq, 'mreq':rmreq, 'treq': rtreq}
stuff = requests.post("http://localhost/hello/dbh.php", param)
```
       
### 5 - Processing the sent request:    
When the python file is executed the php script is also executed and then the parametres sent are recieved using:
```
$rname = htmlspecialchars($_POST['name']);
$rcreq = htmlspecialchars($_POST['creq']);
$rmreq = htmlspecialchars($_POST['mreq']);
$rtreq = htmlspecialchars($_POST['treq']);
```       
Now it is checked whether there is enough cpu and memory required. If even any one of it is too large than available quantities, the message
"cant be processed is printed".
If there is enough CPU and memory available the table Requests is updated using:
```
$query = "INSERT INTO requests(allocated_node_name, starttime, CPU_required, memory_required, time_req_for_comp) values('$rname', '$time', '$rcreq', '$rmreq', '$rtreq')";
mysqli_query($connect, $query);
```
The available memory and cpu is also updated in the nodes table using:
```
$query2 = "UPDATE nodes SET Available_CPUs = '$rmcrep', Available_memory = '$rmmreq' WHERE Name='$rname'";
mysqli_query($connect, $query2);
```
