<!DOCTYPE HTML>
<html>
	<head>
		<title>Form</title>
    	<style>
    		body{color:gray;}
    		h1{font-size:18pt; font-weight:bold;}
            　　th{color:white; background:#999;}
            　　td{color:black; background:#eee; padding:5px 10px;}
    	</style>
    </head>
    <body>
    	<h1>Laravelとデータベースの連携</h1>
        <p>{{ $message; }}</p>
        <table>
            <tr>
                <th>ID</th>
                <th>user_id</th>
                <th>name</th>
                <th>password</th>
            </tr>
            @foreach($data as $value)
            <tr>
                <td>{{ $value -> id }}</td>
                <td>{{ $value -> user_id }}</td>
                <td>{{ $value -> name }}</td>
                <td>{{ $value -> password }}</td>
            </tr>
            @endforeach
    </table>
    </body>
</html>
